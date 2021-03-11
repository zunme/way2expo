<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PostsFile extends Model
{
    use HasFactory;
    protected $table = 'posts_files';
    protected $primaryKey = 'posts_id';
    protected $fillable = ['posts_id','url','org_name'];

    protected $appends = ['size'];

    public function getSizeAttribute() {
        if (Storage::disk('public')->exists($this->url)) {
            $bytes = Storage::disk('public')->size($this->url);
            $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
            for ($i = 0; $bytes > 1024; $i++) {
                $bytes /= 1024;
            }
            return round($bytes, 1) . ' ' . $units[$i];

        }else{
            return 0;
        }
    }
}
