<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(array $array)
 * @method static create(array $array)
 */
class BoothFavorite extends Model
{
    use HasFactory;
    protected $table = 'booth_favorites';
    protected $fillable = [
        'user_id', 'booth_id'
    ];
    public function booth()
   {
       return $this->hasOne(Booth::class, 'id','booth_id');
   }
}
