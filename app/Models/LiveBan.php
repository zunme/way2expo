<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveBan extends Model
{
    use HasFactory;

    protected $table = 'live_bans';

    protected $fillable = [
        'banned_type', 'booth_id', 'user_id', 'created_by_id', 'memo'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
