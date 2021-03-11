<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteConfig extends Model
{
    use HasFactory;
	protected $table = 'site_configs';
    protected $fillable =
            ['code','config_type','title','val','sortno','use_yn'];
	 /*protected $dispatchesEvents = [
       'updated' =>$this->test(),
     ];*/	
	public static function loaddata() {
		return Cache::remember('siteconfig', 60*60*30, function () {
			$data = SiteConfig::where('use_yn','Y')->get();
			$res = array();
			foreach ($data as $row){
				$res[ $row['code'] ] = $row;
			}
			return $res;
		});

	}
	public static function getconfig($code){
		return SiteConfig::where(['use_yn'=>'Y', 'code'=>$code])->first();
	}

}
