<?php
namespace App\Http\Controllers\Admin;


use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Storage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Models\Expo;
use App\Models\ExpoMeta;
use App\Models\ExpoImage;
use Yajra\DataTables\Facades\DataTables;

class ExpoController extends BaseController
{

/* EXPO */
      public function expo(Request $request) {
        return view('admin.expo');
      }
      public function expolist(Request $request) {
        $data = expo::select('*')->with(['expoAttach' =>function($q){
          $q->orderBy('sort', 'asc');
        }]);
        if( $request->progressStatus !='all'){
          if( $request->progressStatus =='progress'){
            $data->Progress();
          }else if( $request->progressStatus =='upcomming'){
            $data->Upcomming();
          }else if( $request->progressStatus =='ended'){
            $data->Ended();
          }else if( $request->progressStatus =='recruiting'){
            $data->Recruiting();
          }

        }
        if( $request->use_status =='Y'){
          $data->Active();
        }else if( $request->use_status =='N'){
          $data->Unactive();
        }
        $data->get();
        return Datatables::of($data)
                ->addIndexColumn()
                ->with(['today'=>Carbon::now()->format('Y-m-d')])
                ->rawColumns(['action'])
                ->make(true);
      }
      public function expocreate(Request $request) {
        $urlregex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $imagerequire ='required';

        if( !empty($request->id) ) {
          $expo = Expo::findOrFail($request->id);
          $isupdate = true;
          $imagerequire ='nullable';
        }else {
          $isupdate = false;
        }

        $messages = [
            'expo_name.*'=>"박람회 타이틀을 입력해주세요.",
            'expo_code.unique'    => '이미 사용하고 있는 박람회코드입니다.',
            'expo_code.alpha_dash'    => '영문,숫자,-,_ 만 가능합니다.',
            'expo_code.*'    => '박람회 코드(2~20자)을 입력해주세요.',
            'expo_open_date.*'=>'박람회 시작일을 입력해주세요.',
            'expo_close_date.after'=>'박람회 종료일은 시작일 이후이어야 합니다.',
            'expo_close_date.*'=>'박람회 종료일을 입력해주세요.',
            'expo_recruit_end_date.after_or_equal'=>'박람회 모집 종료일은 시작일 이후이어야 합니다.',
            'expo_recruit_end_date.*'=>'박람회 모집 종료일을 입력해주세요.',
            'expo_info_phone.*'    => '전화번호는 숫자, - 를 포함해 20자 이하로 적어주세요',
            'expo_info_email.*'=>'이메일을 확인해주세요.',
            'expo_description.*'=>"박람회 설명을 적어주세요",
            'select_img.required'=>"박람회 이미지 파일을 올려주세요",
            'select_img.*'=>"올바른 이미지 파일을 올려주세요",
			'open'=>'부스노출여부를 확인해주세요',
            'privacy_terms_text.*' => '개인정보 수집 및 이용약관 동의 내용을 적어주세요',
            'entry_terms_text.*' => '참가 규정 내용을 적어주세요',
            'provided_terms_text.*' => '제3자 정보 제공동의 내용을 적어주세요',
        ];
        $data = $request->validate([
          'expo_code' => 'required|min:2|max:20|alpha_dash|unique:expos,expo_code,'.$request->id,
          'expo_name' => 'bail|required',
          'expo_open_date' => 'required|date_format:"Y-m-d"',
          'expo_close_date' => 'required|date_format:"Y-m-d"|after_or_equal:'.$request->expo_open_date,
          'expo_recruit_start_date' => 'required|date_format:"Y-m-d"',
          'expo_recruit_end_date' => 'required|date_format:"Y-m-d"|after_or_equal:'.$request->expo_recruit_start_date,
          'expo_use_yn'=>'required|in:Y,N',
		  'open'=>'required|in:Y,N',
          'expo_description'=>'required|min:2|max:1000',
          'select_img' => $imagerequire.'|image|mimes:jpeg,jpg,gif,png|max:2048',
          'select_attach' => 'nullable|mimes:jpeg,jpg,gif,png,zip,pdf,doc,docx,hwp,csv,txt,xlx,xls,pptx|max:20480',
          'expo_url'=>'nullable|url',
          'expo_location'=>'nullable|max:20',
          'expo_info_addr'=>'nullable|max:50',
          'expo_info_phone' => 'nullable|min:2|max:20|regex:/^[0-9-]+$/',
          'expo_info_email' => 'nullable|email',
          'privacy_terms_text' => 'required',
          'entry_terms_text' => 'required',
          'provided_terms_text' => 'required',
         ],$messages);

         if( !$isupdate){
           $expo = Expo::create($data);$expo->makemeta();
         } else $expo->update($data);

         if( $request->file('select_img') ){
           $this->uploadimage( $expo, $request->file('select_img') );
         }
         if( $request->file('select_attach') ){
           $this->uploadfile( $expo, $request->file('select_attach') );
         }
         if($request->hasFile('attachment'))
         {
             $files = $request->file('attachment');
             foreach ($files as $file) {
               $this->uploadattach($expo->id, $file);
             }
         }
         return response()->json(['result'=>'OK','data'=>$expo], 200);;
         //$expo->delete();
      }
      public function expodelete(Request $request){
        $expo = Expo::findOrFail($request->delete_id);
        $this->delfile($expo->expo_image_url);
        $expo->delete();
        ExpoMeta::where('expo_id',$request->delete_id)->delete();
         return response()->json(['result'=>'OK'], 200);
      }
      public function deleteAttach(Request $request){
        $image = ExpoImage::where('id', $request->key)->first();
        if( !empty($image->id) ){
          $this->delfile( $image->url );
          ExpoImage::where('id', $request->key)->delete();
          return response()->json(['result'=>'OK','message'=> "Deleted file 1 successfully!"], 200);;
        }
      }
      public function attachsort (Request $request){
        $image = ExpoImage::where('id', $request->key)->first();

        if( !empty( $image->expo_id) ){
          try{
            foreach( $request->keys as $idx=>$sort){
              $idx= preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($idx, ENT_QUOTES));
              ExpoImage::where('id', $idx)->update(['sort'=>$sort]);
            }
          }catch ( \Exception $e) {
            return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e'=>$e,'data'=>$request->all() ]], 422);
          }
          return response()->json(['result'=>'OK','message'=>"변경완료"], 200);
        }
      }
      private function uploadimage($expo, $file){
        $this->delfile($expo->expo_image_url);
        $image = Image::make($file);
        $image_name = Carbon::now()->timestamp.'_'.( Str::random(8) ).'.'.(mimeToExt( $image->mime));
        Storage::disk('public')->put('expo/'. $image_name, $image->stream()->__toString());

        $expo->update([
            'expo_image_url' => 'expo/'.$image_name,
        ]);
      }
      private function uploadfile($table, $file){
        $this->delfile($table->expo_attachment_file_url);
        $file_extension=$file->getClientOriginalExtension();
        $fileName = Carbon::now()->timestamp.'_'.( Str::random(8) ).'.'.$file_extension;
        Storage::disk('public')->put('expo/'.$fileName, \File::get($file));
        $filePath = $file->storeAs('expo', $fileName, 'public');
        $table->update([
            'expo_attachment_file_url' => $filePath,
        ]);
      }
      private function uploadattach($expo_id, $file){
        $sort = ExpoImage::where( 'expo_id', $expo_id )->max('sort');
        if( !$sort) $sort = 1;
        else $sort = $sort +1;

        $image = Image::make($file);
        $image_name = $expo_id.'/'.Carbon::now()->timestamp.'_'.( Str::random(8) ).'.'.(mimeToExt( $image->mime));
        Storage::disk('public')->put('expo/'. $image_name, $image->stream()->__toString());
        ExpoImage::create(['expo_id'=>$expo_id, 'url'=> 'expo/'.$image_name, 'sort'=>$sort, 'attach_size'=>$file->getSize()]);
      }
      private function delfile($path){
        $storage = Storage::disk('public');

        if($storage->exists($path) && $path !== null){
            $storage->delete($path);
        }
      }
}
