<?php

namespace App\Http\Controllers\Input;

use App\Http\Controllers\Controller;
use App\Http\Requests\InputFormRequest;
use App\Business\Screen\Input\InputViewModel;
use App\Business\Screen\Input\InputBusiness;

class InputController extends Controller
{
    private $business;

    /**
     * construct
     */
    public function __construct(InputBusiness $b)
    {
        $this->business = $b;
    }

    /**
     * new
     */
    public function new(InputFormRequest $request)
    {
        return view('pages.input', ['model' => new InputViewModel()]);
    }

    /**
     * edit
     */
    public function edit(InputFormRequest $request)
    {
        $model = $this->business->seek($request);
        return view('pages.input', ['model' => $model]);
    }

    /**
     * regist
     */
    public function regist(InputFormRequest $request)
    {
        $rtn = null;
        $model = $this->business->regist($request);
        if ($model->isError() === true) {
            // Error
            $rtn = view('pages.input', ['model' => $model]);
        } else {
            $rtn = redirect()->route('disp.complete')->with('complete', '登録しました。');
        }
        return $rtn;
    }

    /**
     * delete
     */
    public function delete(InputFormRequest $request)
    {
        $rtn = null;
        $model = $this->business->delete($request);
        if ($model->isError() === true) {
            // Error
            $rtn = view('pages.input', ['model' => $model]);
        } else {
            $rtn = redirect()->route('disp.complete')->with('complete', '削除しました。');
        }
        return $rtn;
    }
}
