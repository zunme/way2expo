<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ProductImage;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [	'expo_id','booth_id','prd_title','prd_url',
						   'prd_img1','prd_img2','prd_img3','prd_img4',
						   'prd_org_price','prd_price','prd_price_percent',
						   'prd_description','prd_viewprice',
						   'prd_use_yn','prd_display_yn' ];
	public function prdDescImg() {
        return $this->hasMany(ProductImage::class,'prd_id' );
    }
	public function scopeActive($query){
		/*
		  prd_use_yn : 어드민 변경
		  prd_display_yn : 사용자 변경
	    */
        return $query->where('prd_use_yn', 'Y')->where('prd_display_yn', 'Y');
    }
    public function expo()
    {
        return $this->hasOne(Expo::class, 'id','expo_id');
    }
    public function booth()
    {
        return $this->hasOne(Expo::class, 'id','booth_id');
    }

    public function company()
    {
        return $this->hasOneThrough(
            Company::class,
            Booth::class,
            'company_id',
            'id',
            'booth_id',
            'id'
        );
    }
}
