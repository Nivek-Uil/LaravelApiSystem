<?php

namespace App\Models;


use App\Models\Traits\Serialize;
use DateTimeInterface;

class Permission extends \Spatie\Permission\Models\Permission
{
    use Serialize;

    protected $guarded = [
        'id',
        'guard_name',
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
        'pivot'
    ];

}
