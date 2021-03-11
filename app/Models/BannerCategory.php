<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerCategory extends Model
{
    use HasFactory;
    protected $fillable = ['category_title','type', 'width', 'height','resize'];
    public function banners(){
      return $this->hasMany(Banner::class);
    }
    public function delete(){
        foreach($this->banners as $banner){
            $banner->delete();
        }
    }
}
