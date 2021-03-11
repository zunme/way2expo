<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckPlus extends Model
{
    protected $table = 'checkpluses';
    protected $fillable = [
        'user_id',
        'type',
        'err_code',
        'req_seq',
        'auth_type',
        'res_seq',
        'name',
        'birthdate',
        'gender',
        'nationainfo',
        'di',
        'ci',
        'mobile_co',
        'mobile_no',
    ];
}
