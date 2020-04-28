<?php

namespace App\Models;

use App\Models\Traits\Serialize;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Model extends EloquentModel
{
    use SoftDeletes,Serialize;

    protected $hidden = [
        'deleted_at',
    ];

    public function delete()
    {

    }

}
