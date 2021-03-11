<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveVisit extends Model
{
    use HasFactory;

    protected $table = 'live_visits';

    protected $fillable = [
        'url', 'referer', 'useragent', 'device', 'platform', 'browser',
        'ip', 'live_id', 'visitor_id',
    ];

    protected $casts = [
        'request' => 'array',
        'languages' => 'array',
        'headers' => 'array',
    ];


}
