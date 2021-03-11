<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoothImage extends Model
{
    use HasFactory;
    protected $table = 'booth_images';
    protected $primaryKey = 'booth_id';
    protected $fillable = ['booth_id','url','sort','attach_size'];
}
