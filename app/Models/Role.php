<?php

namespace App\Models;


class Role extends \Spatie\Permission\Models\Role
{
    protected $hidden = [
        'updated_at',
        'deleted_at',
        'pivot'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];
}
