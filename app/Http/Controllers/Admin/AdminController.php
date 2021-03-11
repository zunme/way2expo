<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Models\BannerCategory;
use App\Models\Banner;
use App\Models\Meeting;
use App\Models\vod;
use App\Models\SiteConfig;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AdminController extends BaseController
{

      public function home(Request $request) {
        return view('admin.index');
      }

/* banner */
      public function banner(Request $request) {
        $bannerCategory = BannerCategory::get();
        return view('admin.banner', compact(['bannerCategory']));
      }
      public function bannerlist(Request $request) {
        $data = Banner::select('banners.*','banner_categories.type','banner_categories.category_title')->join('banner_categories','banners.banner_category_id','=','banner_categories.id' )->where('banners.active','1');
        if ( $request->searchByCategory != ''){
          $data->where('banner_category_id',$request->searchByCategory );
        }
        if( $request->searchByAlt != ''){
          $data->where('banners.alt','LIKE','%'.$request->searchByAlt.'%' );
        }
        $data->get();
        return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
      }
      public function bannercreate(Request $request) {
        return Banner::make(
            $request->only(['alt', 'url','banner_category_id', 'active','banner_class']),
            $request->file('image')
        );
      }
      public function bannerupdate(Request $request) {
        return Banner::up(
            $request->id,
            $request->only(['alt', 'url','banner_category_id', 'active','banner_class']),
            $request->file('image')
        );
      }
      public function bannerdelete( Request $request ){
        $banner = Banner::where( 'id', $request->id)->first();
        if( empty($banner->id)){
          return response()->json(['errors' => ['system' => ['데이터를 찾을 수 없습니다.'] ]], 404);
        }else {
          $banner->remove();
          return response()->json(['result'=>'OK'], 200);;
        }
      }
/* /banner */
      public function meeting( Request $request ){
        return view('admin.meeting');
      }
      public function meetinglist( Request $request ){
        $data = Meeting::select('meetings.*','expos.expo_name','booths.booth_title')->with(['applicant','receptionist'])
                ->join( 'booths', 'meetings.booth_id','=','booths.id' )
                ->join( 'expos', 'booths.expo_id','=','expos.id' );
        if(!empty($request->meeting_status)){
          $data->where('meeting_status', $request->meeting_status);
        }
        return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
      }
	public function vod(){
		$vods = vod::orderBy('sortno')->get();
		return view('admin.vod',compact(['vods']));
	}
	public function vodform(Request $request){		
		$messages = [
            'title.*'=>"입력내용을 확인해주세요.",
        ];
        $data = $request->validate([
			'title' => 'bail|required|min:2|max:20|',
			'url'=>'required',
			'mov_url'=>'nullable|url',
			'img_url'=>'nullable|url',
			'use_yn'=>'nullable|in:Y,N'
         ],$messages);
		$data['use_yn'] = $data['use_yn'] ?? 'N';
		if( !$request->id){
			$data['sortno'] = (vod::max('sortno') ) + 1;
		}
		if( !empty($request->file('bgimg')) ) {
		  $data['img_url'] = $this->saveImage( 'vod', $request->file('bgimg') );
		}else if ( empty($data['img_url'] ) ) {
			return response()->json(['message'=>'', 'errors' => ['img_url' => ['이미지가 필요합니다.'] ]], 422);
		}

		vod::updateOrCreate(['id'=>$request->id], $data);
		return response()->json(['result'=>'OK'], 200);;
	}
	private function saveImage($dir, UploadedFile $file = null){
		//$this->deleteImage($col);
		$image = Image::make($file);

		$image_name = \Carbon\Carbon::now()->timestamp.'_'.( \Str::random(8) ).'.jpg' ;

		Storage::disk('public')->put($dir.'/'. $image_name, $image->stream()->__toString());
		return '/storage/'.$dir.'/'.$image_name;
    }
	private function uploadfile($table, $file){
		//$this->delfile($table->expo_attachment_file_url);
		$file_extension=$file->getClientOriginalExtension();
		$fileName = Carbon::now()->timestamp.'_'.( Str::random(8) ).'.'.$file_extension;
		Storage::disk('public')->put('expo/'.$fileName, \File::get($file));
		$filePath = $file->storeAs('expo', $fileName, 'public');
		$table->update([
			'expo_attachment_file_url' => $filePath,
		]);
	}
	public function vodinfo(Request $request){
		$info = vod::where('id',$request->id)->first();
		return response()->json(['result'=>'OK','data'=>$info], 200);
	}
	public function vodsort(Request $request){
		
		$vods = vod::orderBy('sortno')->get();
		if( $request->sort ){
			$sort = $request->sort;
			if( !empty( $sort) ){
				DB::beginTransaction();
				try{
					foreach ($sort as $idx =>$id){
						vod::where('id', $id)->update(['sortno'=>$idx]);
					}
					DB::commit();
					return response()->json(['result'=>'OK'], 200);;
				}catch( \Exception $e) {
					DB::rollback();
					return response()->json(['errors' => ['system' => ['DB ERROR.'] ]], 500);
				}
			}
		}else return response()->json(['errors' => ['system' => ['소트 데이터를 찾을 수 없습니다.'] ]], 404);
	}
	
	public function siteconfig() {
		$data = SiteConfig::orderBy('sortno')->orderBy('id')->get();
		return view('admin.config',compact(['data']));
	}
	public function siteconfigUpdate(Request $request) {
		$data = SiteConfig::where('id',$request->id)->update($request->except('id'));
		\Cache::forget('siteconfig');
		return response()->json(['result'=>'OK'], 200);
	}
}