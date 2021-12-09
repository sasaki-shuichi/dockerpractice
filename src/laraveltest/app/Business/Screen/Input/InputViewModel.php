<?php

namespace App\Business\Screen\Input;

use App\Business\Screen\BaseViewModel;

/**
 * InputViewModel
 */
class InputViewModel extends BaseViewModel
{
    /**
     * __construct()
     */
    public function __construct()
    {
        $this->var = [
            'f_name'     => '',
            'f_email'    => '',
            'f_password' => '',
            'f_address'  => '',
            'f_company'  => '',
            'f_tel'      => '',
            'f_userName' => '',
            'f_country'  => '',
            'f_element'  => '',
            'f_birth'    => '',
            'f_comment'  => '',
            'f_userId'   => '',
            'countries'  => config('values.countries'),
            'man'        => '男',
            'woman'      => '女'
        ];
    }
}
