<?php

namespace App\Business\Screen\Disp;

use App\Business\Screen\BaseViewModel;

/**
 * DispViewModel
 */
class DispViewModel extends BaseViewModel
{
    /**
     * __construct()
     */
    public function __construct()
    {
        $this->var = [
            'f_name'        => '',
            'f_man'         => false,
            'f_woman'       => false,
            'f_prefectures' => [],
            'f_birthFrom'   => '',
            'f_birthTo'     => '',
            'f_userId'      => '',
            'f_page'        => '1',
            'man'           => '1',
            'woman'         => '1',
            'prefectures'   => config('values.prefectures'),
            'users'         => collect([])
        ];
    }
}
