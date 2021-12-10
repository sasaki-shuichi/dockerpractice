<?php

namespace App\Business;

use Illuminate\Http\Request;
use App\Models\Sequence;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class Common
{
    /**
     * getRequestString
     */
    public static function getRequestString(Request $request, string $key, string $default = '', bool $isTrim = true): string
    {
        $tmp = $request->input($key);
        $rtn = Utils::toString($tmp, $default);
        return $isTrim === true ? trim($rtn) : $rtn;
    }

    /**
     * getRequestArray
     */
    public static function getRequestArray(Request $request, string $key, array $default = []): array
    {
        $rtn = [];
        $val = $request->input($key);
        if (is_null($val === true)) {
            $rtn = $default;
        } elseif (is_array($val) === true) {
            $rtn = $val;
        } else {
            $rtn = $default;
        }
        return $rtn;
    }

    /**
     * getSession
     */
    public static function getSession(string $key)
    {
        $rtn = null;
        if (Session::has('business') === true) {
            $array = (array)Session::get('business');
            if (array_key_exists($key, $array) === true) {
                $rtn = $array[$key];
            }
            Log::debug('getSession()...' . print_r($array, true));
        }
        return $rtn;
    }

    /**
     * setSession
     */
    public static function setSession(string $key, $val)
    {
        $array = [];
        if (Session::has('business') === true) {
            $array = (array)Session::get('business');
        }
        $array[$key] = $val;
        Session::put('business', $array);
        Log::debug('setSession()...' . print_r($array, true));
    }

    /**
     * isExistRequestValue
     */
    public static function isExistRequestValue(Request $request, string $key): bool
    {
        $rtn = false;
        $val = $request->input($key);
        if (Utils::isEmpty($val) === false) {
            $rtn = true;
        }
        return $rtn;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function createSeqId(string $key)
    {
        $value = self::getNewValueAndCommit($key);
        return $value;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function getSeqId(string $key)
    {
        $sequence = Sequence::find($key);
        return $sequence->sequence;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private static function getNewValueAndCommit(string $key)
    {
        // config/sequence.php という設定ファイルを作って初期値を用意しておける。
        // なければ 1 からスタート
        $default = config("sequence.default.$key", 1);

        $sequence = Sequence::lockForUpdate()->find($key);
        if (!$sequence) {
            $sequence = new Sequence;
            $sequence->key = $key;
        }

        if (($sequence->sequence ?? 0) < $default) {
            $sequence->sequence = $default;
        } else {
            $sequence->sequence = ($sequence->sequence ?? 0) + 1;
        }
        $sequence->save();

        return $sequence->sequence;
    }
}
