<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use Validator;
use Storage;
use Carbon\Carbon;

use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

use App\Models\Expo;
use App\Models\Product;
use App\Models\ProductImage;

class ProductController extends BaseController
{
	function index() {
		$expos = Expo::orderBy('id','desc')->get();
		return view('admin.product', compact(['expos']));
	}
  public function prdlist(Request $request) {

	  $data = Product::select(
		  		'products.*'
		  		,'expos.expo_name','booths.booth_title'
	  		)
		  ->join('expos', 'products.expo_id','=','expos.id')
		   ->join('booths','products.booth_id','=','booths.id')
		;
	  if( $request->expo_id > 0 ){
		 $data->where('products.expo_id', $request->expo_id) ;
	  }
      return Datatables::of($data)
              ->addIndexColumn()
              ->with(['today'=>Carbon::now()->format('Y-m-d')])
              ->rawColumns(['action'])
              ->make(true);
  }
  public function prdinfo(Request $request) {
	  $prd = Product::find($request->id);
	  $imgs = ProductImage::where('prd_id',$request->id )->get();
	  return response()->json(['result' => 'OK', 'product' => $prd, 'imgs'=>$imgs ], 200);
		  
  }
	function prdupdate (Request $request) {
		$data = $request->except(['id','sort[]']);
		try {
			$prd = Product::findOrFail($request->id);
			$prd->update($data);	
		} catch (\Exception $e) {
			return response()->json(['errors' => ['system' => ['잠시 후에 이용해주세요.'], 'message'=>['잠시 후에 이용해주세요.'] ] ], 422);	
		}
		if( $request->sort ){
			$this->attachSrot( $request->sort );
		}
		
		 if($request->hasFile('attachment'))
         {
             $files = $request->file('attachment');
             foreach ($files as $file) {
               $this->uploadattach($prd->id, $file);
             }
         }
		
		return response()->json(['result' => 'OK' ], 200);
		
	}
	function changeblock( Request $request) { 
		Product::whereIn( 'id', $request->chk)->update(['prd_use_yn'=>$request->change_type]);

		return response()->json(['result' => 'OK' ], 200);
	}
	private function uploadattach($prd_id, $file){
		$sort = ProductImage::where( 'prd_id', $prd_id )->max('sort');
		if( !$sort) $sort = 1;
		else $sort = $sort +1;
		$dir ='prd/'. ($prd_id % 100) .'/'.$prd_id;
		
		$image = Image::make($file);
		$image_name = $dir."/".Carbon::now()->timestamp.'_'.( Str::random(8) ).'.'.$file->getClientOriginalExtension();
		Storage::disk('public')->put($image_name, $image->stream()->__toString());
		ProductImage::create(['prd_id'=>$prd_id, 'url'=> $image_name, 'sort'=>$sort]);
	}
	private function attachSrot( $sortdata ){
		
		if( !empty($sortdata) ){
			foreach( $sortdata as $key=>$val){
				 $sortno = $key +1 ; 
				 ProductImage::where( 'id', $val )->update(['sort'=>$sortno]);
			}	
		}
	}
}