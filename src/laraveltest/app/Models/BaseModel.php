<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
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
