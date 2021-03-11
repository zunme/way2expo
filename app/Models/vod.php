<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vod extends Model
{
    use HasFactory;
	protected $table = 'vods';
    protected $fillable =
            ['title','url','mov_url','img_url','sortno','use_yn'];
}
