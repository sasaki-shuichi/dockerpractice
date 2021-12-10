<?php

namespace App\Business\Screen\Disp;

use App\Business\Common;
use App\Business\Utils;
use App\Models\User;
use App\Business\Screen\BaseBusiness;
use App\Business\Screen\Disp\DispViewModel;
use App\Http\Requests\DispFormRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\DB;

/**
 * DispBusiness
 */
class DispBusiness extends BaseBusiness
{

    /**
     * search
     */
    public function search(DispFormRequest $request): DispViewModel
    {
        Log::debug('検索処理開始');
        $rtn = new DispViewModel();
        try {
            $this->setFormValues($request, false, $rtn);
            $errors = $this->validation($request);
            if (is_null($errors) === false) {
                // Error
                $rtn->addMessageBag($errors);
            } else {
                Common::setSession('DISPBUSINESS_SEARCH_PARAM', $rtn->var);

                $users = $this->getUsers($rtn);
                $rtn->users = $users;
            }
        } catch (\Exception $e) {
            // Error
            Log::error($e);
            $rtn->addException($e);
        }
        Log::debug('検索処理終了');
        return $rtn;
    }

    /**
     * page
     */
    public function page(DispFormRequest $request): DispViewModel
    {
        Log::debug('Page処理開始');
        $rtn = new DispViewModel();
        try {
            $this->setFormValues($request, true, $rtn);
            $users = $this->getUsers($rtn);
            $rtn->users = $users;
        } catch (\Exception $e) {
            // Error
            Log::error($e);
            $rtn->addException($e);
        }
        Log::debug('Page処理終了');
        return $rtn;
    }

    /**
     * complete
     */
    public function complete(DispFormRequest $request): DispViewModel
    {
        $rtn = new DispViewModel();
        try {
            $tmp = $request->session()->get('complete');
            $msg = Utils::toString($tmp, '');
            $rtn->addInfoMessage($msg);
        } catch (\Exception $e) {
            // Error
            Log::error($e);
            $rtn->addException($e);
        }
        return $rtn;
    }

    /**
     * setFormValues
     */
    private function setFormValues(DispFormRequest $request, bool $isPagenate, DispViewModel $model)
    {
        $model->f_name        = Common::getRequestString($request, 'name');
        $model->f_man         = Common::getRequestString($request, 'man');
        $model->f_woman       = Common::getRequestString($request, 'woman');
        $model->f_prefectures = Common::getRequestArray($request, 'prefectures');
        $model->f_birthFrom   = Common::getRequestString($request, 'birthFrom');
        $model->f_birthTo     = Common::getRequestString($request, 'birthTo');

        if ($isPagenate === true) {
            $var = Common::getSession('DISPBUSINESS_SEARCH_PARAM');
            if (is_null($var) === false) {
                $model->var = $var;
            }
            $model->f_page = Common::getRequestString($request, 'page');
        }
    }

    /**
     * validation
     */
    private function validation(DispFormRequest $request): ?MessageBag
    {
        $rtn       = null;
        $validator = Validator::make(
            $request->all(),
            ['name' => 'max:20'],
            [],
            ['name' => '名前']
        );
        if ($validator->fails()) {
            $rtn = $validator->errors();
        }
        return $rtn;
    }

    /**
     * getUsers
     */
    private function getUsers(DispViewModel $model)
    {
        $page = Utils::toInt($model->f_page, 1);
        $query = User::with('acounts');
        $query
            ->nameLike($model->f_name)
            ->prefecturesLike($model->f_prefectures)
            ->elementEquals($model->f_man, $model->f_woman)
            ->birthFromTo($model->f_birthFrom, $model->f_birthTo);
        $rs = $query->paginate(10, '*', null, $page);
        return $rs;

        //$query = User::query()->join('acounts', 'users.user_id', '=', 'acounts.user_id');
        //$rtn = DB::select('select users.* , acounts.password from users left join acounts on acounts.user_id = users.user_id');
        //return $rtn;
    }
}
