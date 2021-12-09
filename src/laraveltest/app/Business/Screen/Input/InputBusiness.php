<?php

namespace App\Business\Screen\Input;

use App\Business\Screen\BaseBusiness;
use App\Business\Utils;
use App\Business\Common;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Acount;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InputFormRequest;

/**
 * InputBusiness
 */
class InputBusiness extends BaseBusiness
{
    /**
     * seek
     */
    public function seek(InputFormRequest $request): InputViewModel
    {
        $rtn = new InputViewModel();
        try {
            $tmp = $request->session()->get('user_id');
            $userId = Utils::toString($tmp, '');
            if (Utils::isEmptyString($userId) === true) {
                // Error
                $rtn->addErrorMessage('該当するユーザーが見つかりません。(USER_ID:無)');
            } else {
                $user = $this->getUser($userId);
                if (Utils::isEmptyArray($user) === true) {
                    // Error
                    $rtn->addErrorMessage('該当するユーザーが見つかりません。' . "(USER_ID:$userId)");
                } else {
                    $this->setModelFromDB($rtn, $user);
                }
            }
        } catch (\Exception $e) {
            // Error
            Log::error($e);
            $rtn->addException($e);
        }
        return $rtn;
    }

    /**
     * regist
     */
    public function regist(InputFormRequest $request): InputViewModel
    {
        $rtn = new InputViewModel();
        try {
            $this->setModelFromRequest($request, $rtn);

            $errors = $this->validation($request);
            if (is_null($errors) === false) {
                // Error
                $rtn->addMessageBag($errors);
            } else {
                $userId = Common::getRequestString($request, 'userId');
                if (Utils::isEmptyString($userId)) {
                    $userId = Utils::toString(Common::createSeqId("USER_ID"));
                }

                $rs = $this->registTable($request, $userId);
                if ($rs === false) {
                    // Error
                    $rtn->addErrorMessage('登録処理に失敗しました。' . "(USER_ID:$userId)");
                } else {
                    $rtn->user_id = $userId;
                }
            }
        } catch (\Exception $e) {
            // Error
            Log::error($e);
            $rtn->addException($e);
        }
        return $rtn;
    }

    /**
     * delete
     */
    public function delete(InputFormRequest $request): InputViewModel
    {
        $rtn = new InputViewModel();
        try {
            $this->setModelFromRequest($request, $rtn);
            $userId = Common::getRequestString($request, 'userId');
            if (Utils::isEmptyString($userId) === true) {
                // Error
                $rtn->addErrorMessage('該当するユーザーが見つかりません。(USER_ID:無)');
            } else {
                $rs = $this->deleteTable($userId);
                if ($rs === false) {
                    // Error
                    $rtn->addErrorMessage('削除処理に失敗しました。' . "(USER_ID:$userId)");
                }
            }
        } catch (\Exception $e) {
            // Error
            Log::error($e);
            $rtn->addException($e);
        }
        return $rtn;
    }

    /**
     * getUser
     */
    public function getUser(string $userId): array
    {
        $query = User::query()->join('acounts', 'users.user_id', '=', 'acounts.user_id');
        $user_id = Utils::toInt($userId, -1);
        $query->userIdEquals($user_id);
        $rs = $query->get()->first();
        return !is_null($rs) ? $rs->toArray() : [];
    }

    /**
     * setModelFromDB
     */
    private function setModelFromDB(InputViewModel $model, array $user)
    {
        $model->f_userId   = Utils::toString($user['user_id']);
        $model->f_name     = $user['name'];
        $model->f_email    = $user['email'];
        $model->f_address  = $user['address'];
        $model->f_tel      = $user['tel'];
        $model->f_userName = $user['user_name'];
        $model->f_country  = $this->getCountryCode($user['country'], $model->countries);
        $model->f_company  = $user['company'];
        $model->f_element  = $user['element'];
        $model->f_birth    = Utils::convYmdFormat($user['birth'], 'Y-m-d');
        $model->f_comment  = $user['comment'];
    }

    /**
     * setModelFromRequest
     */
    private function setModelFromRequest(InputFormRequest $request, InputViewModel $model)
    {
        $model->f_userId   =  Common::getRequestString($request, 'userId');
        $model->f_name     =  Common::getRequestString($request, 'name');
        $model->f_email    =  Common::getRequestString($request, 'email');
        $model->f_address  =  Common::getRequestString($request, 'address');
        $model->f_tel      =  Common::getRequestString($request, 'tel');
        $model->f_userName =  Common::getRequestString($request, 'userName');
        $model->f_country  =  Common::getRequestString($request, 'country');
        $model->f_company  =  Common::getRequestString($request, 'company');
        $model->f_element  =  Common::getRequestString($request, 'element');
        $model->f_birth    =  Common::getRequestString($request, 'birth');
        $model->f_comment  =  Common::getRequestString($request, 'comment');
    }

    /**
     * validation
     */
    private function validation(InputFormRequest $request): ?MessageBag
    {
        $rtn = null;
        $validator = Validator::make(
            $request->all(),
            [
                'name'      => 'required|custom_max:20',
                'email'     => 'required|email',
                'password'  => 'required|custom_pws:10',
                'address'   => 'required|custom_max:50',
                'tel'       => 'required|custom_tel',
                'userName'  => 'required|custom_max:20',
                'country'   => 'required',
                'company'   => 'required|custom_max:20',
                'element'   => 'required',
                'birth'     => 'required|custom_ymd',
                'comment'   => 'required|custom_max:100',
            ],
            [],
            [
                'name'      => '名前',
                'email'     => 'Eメール',
                'password'  => 'パスワード',
                'address'   => '住所',
                'tel'       => '電話番号',
                'userName'  => 'ユーザー名',
                'country'   => '国名',
                'company'   => '会社名',
                'element'   => '性別',
                'birth'     => '生年月日',
                'comment'   => 'コメント',
            ],
        );
        if ($validator->fails()) {
            $rtn = $validator->errors();
        }
        return $rtn;
    }

    /**
     * registTable
     */
    private function registTable(InputFormRequest $request, string $userId): bool
    {
        $rtn = false;
        try {
            DB::beginTransaction();

            $rtn = $this->registAcount($request, $userId);
            if ($rtn === false) {
                // Error
                DB::rollback();
                Log::error('Acounts Table Regist Error');
                return $rtn;
            }

            $rtn = $this->registUser($request, $userId);
            if ($rtn === false) {
                // Error
                DB::rollback();
                Log::error('Users Table Regist Error');
                return $rtn;
            }

            DB::commit();
        } catch (\Exception $e) {
            // Error
            DB::rollback();
            Log::error($e);
            $rtn = false;
        }
        return $rtn;
    }

    /**
     * registAcount
     */
    private function registAcount(InputFormRequest $request, string $userId): bool
    {
        $password = Common::getRequestString($request, 'password');
        $values = [
            'user_id'   => $userId,
            'email'     => Common::getRequestString($request, 'email'),
            'password'  => Hash::make($password),
        ];

        $acount = Acount::find($userId);
        if (is_null($acount) === true) {
            $acount = new Acount();
        }
        return $acount->fill($values)->save();
    }

    /**
     * registUser
     */
    private function registUser(InputFormRequest $request, string $userId): bool
    {
        $code  = Common::getRequestString($request, 'country');
        $birth = Common::getRequestString($request, 'birth');

        $values = [
            'user_id'   => $userId,
            'name'      => Common::getRequestString($request, 'name'),
            'tel'       => Common::getRequestString($request, 'tel'),
            'address'   => Common::getRequestString($request, 'address'),
            'company'   => Common::getRequestString($request, 'company'),
            'user_name' => Common::getRequestString($request, 'userName'),
            'country'   => $this->getCountryName($code),
            'element'   => Common::getRequestString($request, 'element'),
            'birth'     => Utils::convYmdFormat($birth, 'Y/m/d'),
            'comment'   => Common::getRequestString($request, 'comment'),
        ];

        $user = User::find($userId);
        if (is_null($user) === true) {
            $user = new User();
        }

        return $user->fill($values)->save();
    }

    /**
     * deleteTable
     */
    private function deleteTable(string $userId): bool
    {
        $rtn = true;
        try {
            DB::beginTransaction();

            Acount::findDelete($userId);
            User::findDelete($userId);

            DB::commit();
        } catch (\Exception $e) {
            // Error
            DB::rollback();
            Log::error($e);
            $rtn = false;
        }
        return $rtn;
    }

    /**
     * getCountryCode
     */
    private function getCountryCode(string $country, array $countries): string
    {
        $rtn = '';
        if (in_array($country, $countries)) {
            $rtn = array_search($country, $countries);
        }
        return $rtn;
    }

    /**
     * getCountryName
     */
    private function getCountryName(string $code): string
    {
        $countries = config('values.countries');
        return $countries[$code];
    }
}
