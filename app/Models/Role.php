<?php

namespace App\Models;


use App\Models\Traits\Serialize;
use DateTimeInterface;

class Role extends \Spatie\Permission\Models\Role
{
    use Serialize;

    protected $hidden = [
        'updated_at',
        'deleted_at',
        'pivot'
    ];

}
