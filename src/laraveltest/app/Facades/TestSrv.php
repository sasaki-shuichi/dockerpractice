<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class TestSrv extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'testsrv';
    }
}
