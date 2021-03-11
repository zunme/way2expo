<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Shetabit\Visitor\Models\Visit;

class Booth extends Model
{
    protected $table = 'booths';
    protected $fillable = [
        'company_id',
        'expo_id',
        'booth_image_url',
        'booth_mobile_image_url',
        'booth_youtube_url',
        'booth_mp4_url',
        'booth_title',
        'booth_intro',
        'booth_use_yn',
        'booth_display_yn',
        'booth_movtype'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function scopeActive($query)
    {
        return $query->where('booth_use_yn', 'Y');
    }

    public function scopeDisplay($query)
    {
        return $query->where('booth_use_yn', 'Y')->where('booth_display_yn', 'Y');
    }

    /**
     * 태그
     */
    public function tags()
    {
        return $this->hasMany("App\Models\BoothTag", "booth_id");
    }

    /**
     * Desktop 이미지 URL
     */
    public function getDesktopImageUrl()
    {
        return url(Storage::disk('public')
            ->url($this->booth_image_url));
    }

    /**
     * Mobile 이미지 URL
     */
    public function getMobileImageUrl()
    {
        return url(Storage::disk('public')
            ->url($this->booth_mobile_image_url));
    }

    /**
     * 부스 회사 정보
     */
    public function companyBooth()
    {
        return $this->belongsTo("App\Models\Company", "company_id");
    }

    /**
     * 부스 박람회 정보
     */
    public function expoBooth()
    {
        return $this->belongsTo("App\Models\Expo", "expo_id");
    }

    public function liveBooth()
    {
        return $this->belongsTo("App\Models\Live", "booth_id");
    }

    /**
     * 부스 상세 이미지
     */
    public function boothAttach()
    {
        return $this->hasMany(BoothImage::class, 'booth_id')->orderBy('sort');
    }

    /**
     * 부스 이미지 업로드
     * @param array $inputs
     * @param UploadedFile|null $file
     * @return null
     */
    public function saveImage(array $inputs, UploadedFile $file = null)
    {
        if ($file === null) return null;
        $storage = Storage::disk('public');
        $path = 'booth/';

        $image = Image::make($file);
        $image_name = $this->generateFileName($file);
        if (!$storage->exists($path)) {
            $storage->makeDirectory($path, 0775, true);
        }
        $storage->put($path . $image_name, $image->stream()->__toString());
        $url = $path . $image_name;

        if (!empty($inputs['id'])) {
            $booth = Booth::find($inputs['id']);
            if (!empty($inputs['selectimg_pc'])) {
                $this->deleteImage($booth->booth_image_url);
            }
            if (!empty($inputs['selectimg_mobile'])) {
                $this->deleteImage($booth->booth_mobile_image_url);
            }
        }

        return $url;
    }

    /**
     * 부스 상세 이미지 업로드
     * @param null $booth_id
     * @param UploadedFile|null $file
     * @param bool $on_edit
     * @return BoothImage
     */
    public function saveDetailImage($booth_id = null, UploadedFile $file = null, $on_edit = false)
    {
        if ($file === null) return null;
        if ($on_edit) {

        }
        $storage = Storage::disk('public');
        $path = 'booth/detail/';

        $sort = BoothImage::where('booth_id', $booth_id)->max('sort');
        if (!$sort) $sort = 1;
        else $sort = $sort + 1;

        $image = Image::make($file);
        $image_name = $this->generateFileName($file);

        if (!$storage->exists($path)) {
            $storage->makeDirectory($path, 0775, true);
        }
        $storage->put($path . $image_name, $image->stream()->__toString());
        $url = $path . $image_name;

        return BoothImage::create(['booth_id' => $booth_id, 'url' => $url, 'sort' => $sort, 'attach_size' => $file->getSize()]);
    }

    /**
     * 파일 제거
     * @param $image_path
     * @return bool
     */
    public function deleteImage($image_path)
    {
        $storage = Storage::disk('public');
        if ($storage->exists($image_path) && $image_path !== null) {
            return $storage->delete($image_path);
        }
        return false;
    }

    public function boothMeta()
    {
        return $this->hasOne("App\Models\BoothMeta", 'booth_id', 'id');
    }

    public function makeMeta()
    {
        $meta = new BoothMeta();
        $meta->booth_id = $this->id;
        $meta->save();
    }

    private function generateFileName(UploadedFile $file)
    {
        $image_ext = $file->getClientOriginalExtension();
        return Carbon::now()->format('ymdhis') . '_' . Str::random(9) . "." . $image_ext;
    }

    public function visitLogs()
    {
        return $this->morphMany(Visit::class, 'visitable');
    }

    public function url()
    {
        return "/expo/".$this->expoBooth->expo_code."/".$this->id;
    }
}
