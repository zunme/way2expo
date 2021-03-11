<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpoMeta extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'expo_metas';
    protected $primaryKey = 'expo_id';
    protected $fillable = ['expo_id','visitor_count','product_count','product_in_cart_count','booth_count','favorite_count'];
    function addViewCount( ){
      $this->visitor_count = $this->visitor_count + 1;
      $this->save();
    }
}
