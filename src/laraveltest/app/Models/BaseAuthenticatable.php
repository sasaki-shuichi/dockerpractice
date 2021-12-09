<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class BaseAuthenticatable extends Authenticatable
{
    /**
     * scopefindDelete
     */
    public function scopeFindDelete($query, $key)
    {
        $obj = $query->find($key);
        if (is_null($obj) === false) {
            $obj->delete();
        }
    }
}
