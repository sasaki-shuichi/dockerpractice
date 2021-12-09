<?php

namespace App\Business\Screen\Login;

use App\Business\Screen\BaseViewModel;

/**
 * LoginViewModel
 */
class LoginViewModel extends BaseViewModel
{
	/**
	 * __construct()
	 */
	function __construct()
	{
		$this->var = ['f_email' => '', 'f_password' => ''];
	}
}
