<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use App\Business\Screen\Login\LoginBusiness;
use App\Business\Screen\Login\LoginViewModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Facades\TestSrv;

/**
 * LoginController
 */
class LoginController extends Controller
{
    private $business;

    /**
     * construct
     */
    public function __construct(LoginBusiness $b)
    {
        Log::debug('Facade test1():' . TestSrv::test1());
        Log::debug('Facade test2():' . TestSrv::test2());
        $this->business = $b;
    }

    /**
     * init
     */
    public function init(LoginFormRequest $request)
    {
        Log::debug('Facade getCounter():' . TestSrv::getCounter());
        return view('pages.login', ['model' => new LoginViewModel()]);
    }

    /**
     * init
     */
    public function lift(LoginFormRequest $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return view('pages.login', ['model' => new LoginViewModel()]);
    }

    /**
     * auth
     */
    public function auth(LoginFormRequest $request)
    {
        $rtn = null;
        $ts = app()->make('testsrv');
        Log::debug('TestSrv getCounter():' . $ts->getCounter());

        Log::debug('ログイン処理開始');
        $model = $this->business->auth($request);
        if ($model->isError() === true) {
            // Error
            $rtn = view('pages.login', ['model' => $model]);
        } else {
            $request->session()->regenerate();
            $rtn = redirect()->route('disp.init');
            Log::debug(Auth::user());
        }
        Log::debug('ログイン処理終了');

        return $rtn;
    }
}
