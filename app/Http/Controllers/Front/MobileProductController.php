<?php

namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Storage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Models\Expo;
use App\Models\Booth;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductFavorite;
use App\Models\Company;

class MobileProductController extends Controller{
	function prdlist ( Request $request, $expo_id,$booth_id=null ){	
		$booth = null;
		
		if( !empty($booth_id) ) {
			$booth = Booth::display()->where('id', $booth_id)->first();
			if( empty($booth->id) ){
				return response()->json([ 'result' => 'OK', 'data' => [] ], 200);
			}
			$expo_id = $booth->expo_id;
		}		
		$prd = $this->defaultqry();
		
		if ( !empty($booth_id) ) $prd->where( 'products.booth_id', $booth->id);
		else $prd->where( 'products.expo_id', $expo_id);
		
		$prd = $prd->orderBy('products.booth_id','asc')->paginate(6);

		return response()->json([ 'result' => 'OK', 'data' => $prd ], 200);
	}

	function prdinfo($id){
		$user = Auth::guard()->user();
		$userid = empty($user->id) ? '-1' : $user->id;
		$prd = $this->defaultqry();
		$prd = $prd->where('products.id',$id)->first();
		
		$images = ProductImage::where('prd_id', $id)->orderBy('sort', 'asc')->get();
		$prd->prd_url = "/mobile/link/".$prd->id;
		return view("mobile.product", compact(['prd','images']) );
	}
	function prdlink($id){
		$user = Auth::guard()->user();
		$user_id =  empty($user->id) ? 0 : $user->id;
		$prd = $this->defaultqry();
		$prd = $prd->where('products.id',$id)->first();
		if( empty($prd->prd_url) ) return redirect("/");
		
		\Log::channel('product')->info('ProductLink',['type'=>'M','id' => $id, "user"=>$user_id, "time"=>Carbon::now()]);
		return redirect( $prd->prd_url);
	}
	function defaultqry(){
		$user = Auth::guard()->user();
		$userid = empty($user->id) ? '-1' : $user->id;		
		return Product::
			select( 
				'products.*', 'booths.booth_title','expos.expo_code','expos.expo_name',
				\DB::raw("if ( product_favorites.id is NULL , 0,1) AS isfavorite")
			)
			->join( 'expos', function($q) {
				$q->on(  'products.expo_id','=','expos.id' );
				$q->on( "expo_use_yn",'=',\DB::raw("'Y'") );
				$q->on( "expos.open",'=',\DB::raw("'Y'") );
				$q->on( "expo_open_date",'<=',\DB::raw("'".carbon::now()."'") );
			})				
			->join( 'booths', function($q) {
				$q->on(  'products.booth_id','=','booths.id' );
				$q->on( "booth_use_yn",'=',\DB::raw("'Y'") );
				$q->on( "booth_display_yn",'=',\DB::raw("'Y'") );
			})
			->leftJoin( 'product_favorites', function($q) use($userid) {
				$q->on(  'products.id','=','product_favorites.product_id' );
				$q->on(  'product_favorites.user_id','=',\DB::raw("'$userid'") );
			})
			->where(['prd_use_yn'=>'Y','prd_display_yn'=>'Y'] )
			;	
	}
	function defaultMyqry() {
		$user = Auth::guard()->user();
		$userid = empty($user->id) ? '-1' : $user->id;		
		return Product::
			select( 
				'products.*', 'booths.booth_title','expos.expo_code','expos.expo_name',
				\DB::raw("if ( product_favorites.id is NULL , 0,1) AS isfavorite")
			)
			->join( 'expos', function($q) {
				$q->on(  'products.expo_id','=','expos.id' );
			})				
			->join( 'booths', function($q) {
				$q->on(  'products.booth_id','=','booths.id' );
				$q->on( "booth_use_yn",'=',\DB::raw("'Y'") );
			})
			->leftJoin( 'product_favorites', function($q) use($userid) {
				$q->on(  'products.id','=','product_favorites.product_id' );
				$q->on(  'product_favorites.user_id','=',\DB::raw("'$userid'") );
			})
			->where(['prd_use_yn'=>'Y'] )
			;	
	}
	function favoritetoggle(Request $request){
        $user = Auth::guard()->user();
        if (empty($user->id)) {
            return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.']]], 401);
        }
        $favorite = ProductFavorite::where('user_id', $user->id)->where('product_id', $request->prd_id)->first();
        if (empty($favorite)) {
            $favorite = ProductFavorite::create([
                'user_id' => $user->id,
                'product_id' => $request->prd_id,
            ]);
            return response()->json(['result' => 'OK', 'data' => 'add'], 200);
        } else {
            $favorite->delete();
            return response()->json(['result' => 'OK', 'data' => 'remove'], 200);
        }		
	}
	function favorite(Request $request){
	    $user = Auth::guard()->user();
        if (empty($user->id)) {
            return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.']]], 401);
        }	
		$list = ProductFavorite::
					select( 
						'products.*', 'booths.booth_title','expos.expo_code','expos.expo_name'
						,\DB::raw("1 AS isfavorite")
					)
					->join('products', 'products.id', '=','product_favorites.product_id' )
					->join( 'expos', function($q) {
						$q->on(  'products.expo_id','=','expos.id' );
						$q->on( "expo_use_yn",'=',\DB::raw("'Y'") );
						$q->on( "expos.open",'=',\DB::raw("'Y'") );
						$q->on( "expo_open_date",'<=',\DB::raw("'".carbon::now()."'") );
					})				
					->join( 'booths', function($q) {
						$q->on(  'products.booth_id','=','booths.id' );
						$q->on( "booth_use_yn",'=',\DB::raw("'Y'") );
						$q->on( "booth_display_yn",'=',\DB::raw("'Y'") );
					})
				->where('product_favorites.user_id', $user->id)
				->orderBy('product_favorites.id','desc')
				->paginate(10);
		//$list =$this->defaultqry();	$list = $list->paginate(8);
		
		return response()->json(['result' => 'OK', 'data' => $list], 200);
	}
	function favoriteItem(Request $request, $id){
	    $user = Auth::guard()->user();
        if (empty($user->id)) {
            return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.']]], 401);
        }	
		$list = ProductFavorite::
					select( 
						'products.*', 'booths.booth_title','expos.expo_code','expos.expo_name'
						,\DB::raw("1 AS isfavorite")
					)
					->join('products', 'products.id', '=','product_favorites.product_id' )
					->join( 'expos', function($q) {
						$q->on(  'products.expo_id','=','expos.id' );
						$q->on( "expo_use_yn",'=',\DB::raw("'Y'") );
						$q->on( "expos.open",'=',\DB::raw("'Y'") );
						$q->on( "expo_open_date",'<=',\DB::raw("'".carbon::now()."'") );
					})				
					->join( 'booths', function($q) {
						$q->on(  'products.booth_id','=','booths.id' );
						$q->on( "booth_use_yn",'=',\DB::raw("'Y'") );
						$q->on( "booth_display_yn",'=',\DB::raw("'Y'") );
					})
				->where('product_favorites.user_id', $user->id)
				->where('product_favorites.product_id', $id)->get()
				;
		//$list =$this->defaultqry();	$list = $list->paginate(8);
		
		return response()->json(['result' => 'OK', 'data' => $list], 200);		
	}

}