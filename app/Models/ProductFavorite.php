<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFavorite extends Model
{
    use HasFactory;
    protected $table = 'product_favorites';
    protected $fillable = ['user_id','product_id'];

    public function product()
   {
       return $this->hasOne(Product::class, 'id','product_id');
   }	
}
