<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCard extends Model
{
    use HasFactory;
    protected $table = 'user_cards';
    protected $primaryKey = 'user_id';
    protected $fillable =
            ['user_id','card_name','card_tel','card_email','card_company','card_dept',
            'card_position','card_addr','card_homepage'];
}
