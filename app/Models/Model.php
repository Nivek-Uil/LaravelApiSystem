<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Model extends BaseModel
{
    use SoftDeletes;

    protected $hidden = [
//        'updated_at',
        'deleted_at',
//        'pivot'
    ];

    // 解决Laravel 7.0+ 【在 Eloquent 模型上使用 toArray 或 toJson 方法时，Laravel 7 将使用新的日期序列化格式】的问题
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }

}
