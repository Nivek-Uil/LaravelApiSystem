<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class BaseModel extends Model
{
    use SoftDeletes;

    protected $hidden = [
//        'updated_at',
        'deleted_at',
//        'pivot'
    ];


    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
        'last_login_time' => 'datetime:Y-m-d H:i:s',
    ];

}
