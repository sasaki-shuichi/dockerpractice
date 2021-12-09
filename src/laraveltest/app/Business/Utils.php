<?php

namespace App\Business;

use DateTime;

class Utils
{
    /**
     * toInt
     */
    public static function toInt($val, $default = -1): int
    {
        $rtn = $default;
        if (is_numeric($val) === true) {
            $rtn = intval($val);
        }
        return $rtn;
    }

    /**
     * toString
     */
    public static function toString($val, $default = ''): string
    {
        $rtn = '';
        if (is_null($val) === true) {
            $rtn = $default;
        } elseif (is_string($val) === true) {
            $rtn = $val;
        } elseif (is_numeric($val) === true) {
            $rtn = strval($val);
        } elseif (is_bool($val) === true) {
            $rtn = ($val === true) ? 'true' : 'false';
        } else {
            // is_array or is_object
            $rtn = $default;
        }
        return $rtn;
    }

    /**
     * convYmdFormat
     */
    public static function convYmdFormat(?string $val, string $fmt): string
    {
        $rtn = '';
        if (self::isYmd($val) === true) {
            $tmp = strtotime($val);
            $rtn = date($fmt, $tmp);
        }
        return $rtn;
    }

    /**
     * isYmd
     */
    public static function isYmd(?string $date): bool
    {
        $formats = [
            ['/^[1-9]{1}[0-9]{0,3}\/[0-9]{1,2}\/[0-9]{1,2}$/', '/'], // YYYY/MM/DD
            ['/^[1-9]{1}[0-9]{0,3}\-[0-9]{1,2}\-[0-9]{1,2}$/', '-'], // YYYY-MM-DD
        ];

        if (self::isEmptyString($date) === true) {
            return false;
        }

        $delimiter = '';
        foreach ($formats as $fmt) {
            if (preg_match($fmt[0], $date)) {
                $delimiter = $fmt[1];
            }
        }

        if (self::isEmptyString($delimiter) === true) {
            return false;
        }

        list($y, $m, $d) = explode($delimiter, $date);

        if (checkdate($m, $d, $y) === false) {
            return false;
        }

        $year = self::toInt($y);
        if ($year < 1970 || $year > 2099) {
            return false;
        }

        return true;
    }

    /**
     * isTel
     */
    public static function isTel(?string $tel): bool
    {
        $formats = [
            '/^0[0-9]{1,4}-[0-9]{1,4}-[0-9]{3,4}\z/',
            '/^0[0-9]{9,10}\z/',
        ];

        if (self::isEmptyString($tel) === true) {
            return false;
        }

        foreach ($formats as $fmt) {
            if (preg_match($fmt, $tel)) {
                return true;
            }
        }

        return false;
    }

    /**
     * is_alnum
     */
    public static function is_alnum($val): bool
    {
        if (self::isEmptyString($val) === true) {
            return false;
        }

        if (preg_match("/^[a-zA-Z0-9]+$/", $val)) {
            return true;
        }

        return false;
    }

    /**
     * isEmptyString
     */
    public static function isEmptyString(?string $val): bool
    {
        return self::isEmpty($val);
    }

    /**
     * isEmptyArray
     */
    public static function isEmptyArray(?array $arr): bool
    {
        return self::isEmpty($arr);
    }

    /**
     * isEmpty
     */
    public static function isEmpty($arg): bool
    {
        $rtn = true;
        if (is_null($arg) === false) {
            if (empty($arg) === false) {
                $rtn = false;
            }
        }
        return $rtn;
    }
}
