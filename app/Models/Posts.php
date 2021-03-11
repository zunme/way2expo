<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\PostsFile;
class Posts extends Model
{
    use HasFactory;
	protected $table = 'posts';
	protected $fillable = ['noti', 'use_yn', 'title','body'];
	public function attachFiles() {
        return $this->hasMany(PostsFile::class,'posts_id' );
    }
}
