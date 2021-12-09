<?php

namespace App\Business\Screen\Login;

use App\Business\Common;
use App\Business\Screen\BaseBusiness;
use App\Business\Screen\Login\LoginViewModel;

use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use App\Events\TestPublish;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;

class LoginBusiness extends BaseBusiness
{
	/**
	 * auth
	 */
	public function auth(LoginFormRequest $request): LoginViewModel
	{
		$rtn = new LoginViewModel();
		try {
			$errors = $this->validation($request);
			if (is_null($errors) === FALSE) {
				// Error
				$rtn->addMessageBag($errors);
			} else {
				$credentials = $request->only('email', 'password');
				if (Auth::attempt($credentials) === FALSE) {
					// Error
					$rtn->addErrorMessage('メールアドレスかパスワードが間違っています。');
				} else {
					// Login OK !!
					event(new TestPublish('LOGIN OK!!'));
					Artisan::call('command:testcom', [
						'name' => 'TEST'
					]);
				}
			}
			$rtn->f_email = Common::getRequestString($request, 'email', FALSE);
		} catch (\Exception $e) {
			// Error
			Log::error($e);
			$rtn->addException($e);
		}

		return $rtn;
	}

	/**
	 * validation
	 */
	private function validation(LoginFormRequest $request): ?MessageBag
	{
		$rtn = NULL;
		$validator = Validator::make(
			$request->all(),
			[
				'email'    => 'required|max:255',
				'password' => 'required',
			],
			[],
			[
				'email'    => 'メールアドレス',
				'password' => 'パスワード',
			],
		);
		if ($validator->fails()) {
			$rtn = $validator->errors();
		}
		return $rtn;
	}
}
