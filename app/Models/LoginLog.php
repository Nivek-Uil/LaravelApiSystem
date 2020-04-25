<?php

namespace App\Models;


class LoginLog extends Model
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
