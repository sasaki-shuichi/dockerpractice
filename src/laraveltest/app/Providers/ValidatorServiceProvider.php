<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Validators\CustomValidator;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::resolver(function ($translator, $data, $rules, $messages, $attributes) {
            return new CustomValidator($translator, $data, $rules, $messages, $attributes);
        });
        // Validator::extend('mb_len', function ($attribute, $value, $parameters, $validator) {
        // 	return false;
        // });
        // Validator::replacer('mb_len', function ($message, $attribute, $rule, $parameters) {
        // 	return "aaaa";
        // });
    }
}
