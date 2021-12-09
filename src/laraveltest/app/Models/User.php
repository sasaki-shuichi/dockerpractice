<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Business\Utils;

class User extends BaseModel
{
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'name',
        'tel',
        'address',
        'company',
        'user_name',
        'country',
        'element',
        'birth',
        'comment',
    ];

    use HasFactory;

    public function acounts()
    {
        return $this->hasOne('App\Models\Acount', 'user_id');
    }

    /**
     * scopeManEquals
     */
    public function scopeUserIdEquals($query, int $userId)
    {
        return $query->where('users.user_id', $userId);
    }

    /**
     * scopeNameLike
     */
    public function scopeNameLike($query, string $val)
    {
        $query->when(
            Utils::isEmptyString($val) === false,
            function ($query) use ($val) {
                return $query->where('users.name', 'like', '%' . $val . '%');
            }
        );
        return $query;
    }

    /**
     * scopePrefecturesLike
     */
    public function scopePrefecturesLike($query, array $codes)
    {
        $query->when(
            Utils::isEmptyArray($codes) === false,
            function ($query) use ($codes) {
                $query->where(function ($query) use ($codes) {
                    $array = config('values.prefectures');
                    foreach ($codes as $code) {
                        $query->orWhere('users.address', 'like', '%' . $array[$code] . '%');
                    }
                    return $query;
                });
            }
        );
        return $query;
    }

    /**
     * scopeElementEquals
     */
    public function scopeElementEquals($query, bool $man, bool $woman)
    {
        $query
            ->when(
                $man === true && $woman === true,
                function ($query) {
                    $query->where(function ($query) {
                        $query->orWhere('users.element', '男')->orWhere('users.element', '女');
                    });
                }
            )
            ->when(
                $man === true && $woman === false,
                function ($query) {
                    $this->scopeManEquals($query);
                }
            )
            ->when(
                $man === false && $woman === true,
                function ($query) {
                    $this->scopeWomanEquals($query);
                }
            );

        return $query;
    }

    /**
     * scopeManEquals
     */
    public function scopeManEquals($query)
    {
        return $query->where('users.element', '男');
    }

    /**
     * scopeWomanEquals
     */
    public function scopeWomanEquals($query)
    {
        return $query->where('users.element', '女');
    }

    /**
     * scopeBirthFromTo
     */
    public function scopeBirthFromTo($query, string $from, string $to)
    {
        $query
            ->when(
                Utils::isEmptyString($from) === false && Utils::isEmptyString($to) === false,
                function ($query) use ($from, $to) {
                    $query->whereRaw('STR_TO_DATE(users.birth,\'%Y/%m/%d\') between ? and ?', [
                        $from,
                        $to
                    ]);
                }
            )
            ->when(
                Utils::isEmptyString($from) === false && Utils::isEmptyString($to) === true,
                function ($query) use ($from) {
                    $this->scopeBirthGraterEqual($query, $from);
                }
            )
            ->when(
                Utils::isEmptyString($from) === true && Utils::isEmptyString($to) === false,
                function ($query) use ($to) {
                    $this->scopeBirthLessEqual($query, $to);
                }
            );
        return $query;
    }

    /**
     * scopeBirthGraterEqual
     */
    public function scopeBirthGraterEqual($query, $birth)
    {
        return $query->whereRaw('STR_TO_DATE(users.birth,\'%Y/%m/%d\') >= ?', $birth);
    }

    /**
     * scopeBirthLessEqual
     */
    public function scopeBirthLessEqual($query, $birth)
    {
        return $query->whereRaw('STR_TO_DATE(users.birth,\'%Y/%m/%d\') <= ?', $birth);
    }
}
