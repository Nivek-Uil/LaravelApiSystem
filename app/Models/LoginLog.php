<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends BaseModel
{
    //
    protected $fillable = [
        'user_id',
        'account',
        'ip',
        'method',
        'user_agent',
        'remark'
    ];

}
