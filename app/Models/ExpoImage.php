<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpoImage extends Model
{
    use HasFactory;
    protected $table = 'expo_images';
    protected $primaryKey = 'expo_id';
    protected $fillable = ['expo_id','url','sort','attach_size'];


}
