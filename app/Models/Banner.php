<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Models\BannerCategory;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = [
        'alt', 'url','image_url','image_path','banner_class','views','clicks','active','banner_category_id'
    ];
    protected $dates = ['viewed_at'];

    public static function make(array $data, UploadedFile $image = null){
        if(!$image){
            //throw new \Exception('UploadedFile required');
            return response()->json(['errors' => ['system' => ['UploadedFile required.'] ]], 422);
        }

        $validator = Validator::make(
            $data,
            [
                'url' => 'required',
                'active' => 'boolean',
                'banner_category_id' => 'required|exists:banner_categories,id',
                'banner_class'=>'nullable|string|max:20'
            ],
            [
                'url.*' =>"링크 URL을 입력해주세요",
                'banner_category_id.*' =>"배너 카테고리를 입력해주세요",
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['errors' => ['system' => [$validator->messages()->first()] ]], 422);
        }
        $data = array_merge( $data ,['image_url'=>'', 'image_path'=>'','views'=>0, 'clicks'=>0 ]);
        $banner = Banner::create($data);
        $banner->saveImage($image);

        return response()->json(['data'=>$banner], 201);;
    }
    public static function up( int $id , array $data, UploadedFile $image = null){
      $validator = Validator::make(
          $data,
          [
              'url' => 'required',
              'active' => 'boolean',
              'banner_category_id' => 'required|exists:banner_categories,id',
              'banner_class'=>'nullable|string|max:20'
          ],
          [
              'url.*' =>"링크 URL을 입력해주세요",
              'banner_category_id.*' =>"배너 카테고리를 입력해주세요",
          ]
      );

      if ($validator->fails())
      {
          return response()->json(['errors' => ['system' => [$validator->messages()->first()] ]], 422);
      }
      $banner =Banner::where('id', $id )->first();
      $banner->update( $data );
      if(!$image){
          return response()->json(['data'=>$banner], 200);;
      }
      $banner->saveImage($image);
      return response()->json(['data'=>$banner], 200);;
    }
    public function scopeActive($query){
        return $query->where('active', true);
    }
    public function banner_category(){
        return $this->belongsTo(BannerCategory::class);
    }
    public function activate(){
       return $this->update(['active' => true]);
   }
   public function deactivate(){
        return $this->update(['active' => false]);
    }

    public function plusViews(){
        return $this->update(['views' => $this->views+1]);
    }
    public function plusClicks(){
       return $this->update(['clicks' => $this->clicks+1]);
   }
   public static function generateImageName($extension = 'jpg'){
        return Carbon::now()->timestamp.'_'.( Str::random(8) ).'.'.$extension;
    }
    public function saveImage(UploadedFile $file){
        $this->deleteImage();
        $image = Image::make($file);

        $image_name = Banner::generateImageName( mimeToExt( $image->mime) );

        $banner_category = $this->banner_category;
        if( $banner_category->resize=='Y' ){

          $height = ( $banner_category->height < 1 ) ? null : $banner_category->height;
          $width = ( $banner_category->width < 1 ) ? null : $banner_category->width;

          if($width === null || $height === null){
              $image->resize($width, $height, function ($constraint) {
                 $constraint->aspectRatio();
             });
          }else $image->fit( $banner_category->width, $banner_category->height );
        }

        Storage::disk('public')->put('banner/'. $image_name, $image->stream()->__toString());

        $this->update([
            'image_url' => 'banner/'.$image_name,
            'image_path' => 'banner/'.$image_name
        ]);
    }
    public function remove(){
      $this->deleteImage();
      $this->delete();
    }
    private function deleteImage(){
        $storage = Storage::disk('public');

        if($storage->exists($this->image_path) && $this->image_path !== null){
            $storage->delete($this->image_path);
        }
    }
    public function getImageUrl(){
           return url(Storage::disk('public')
               ->url($this->image_path));
       }
}
