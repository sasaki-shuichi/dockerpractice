<?php

namespace App\Validators;

use Illuminate\Validation\Validator;
use App\Business\Utils;

class CustomValidator extends Validator
{
    public function validateCustomMax($attribute, $value, $parameters, $message)
    {
        $len1 = mb_strlen($value);
        $len2 = Utils::toInt($parameters[0]);
        return $len2 >= $len1;
    }

    protected function replaceCustomMax($message, $attribute, $rule, $parameters)
    {
        return str_replace([':max'], [$parameters[0]], $message);
    }

    public function validateCustomTel($attribute, $value, $parameters, $message)
    {
        return Utils::isTel($value);
    }

    public function validateCustomYmd($attribute, $value, $parameters, $message)
    {
        return Utils::isYmd($value);
    }

    public function validateCustomPws($attribute, $value, $parameters, $message)
    {
        $rtn = false;

        $len1 = Utils::toInt($parameters[0]);
        $len2 = mb_strlen($value);

        $isAlnum = Utils::is_alnum($value);
        if ($len1 === $len2 && $isAlnum === true) {
            $rtn = true;
        }

        return $rtn;
    }

    protected function replaceCustomPws($message, $attribute, $rule, $parameters)
    {
        return str_replace([':len'], [$parameters[0]], $message);
    }
}
