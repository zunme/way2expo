<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpoFavorite extends Model
{
    use HasFactory;
    protected $table = 'expo_favorites';
    protected $fillable = ['user_id','expo_id'];

    public function expo()
   {
       return $this->hasOne(Expo::class, 'id','expo_id');
   }
}
