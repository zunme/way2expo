<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use App\Models\ExpoMeta;
use App\Models\Booth;
use Shetabit\Visitor\Models\Visit;

class Expo extends Model
{
    use HasFactory;
    protected $table = 'expos';

    protected $fillable = [
            'request_user_id', 'expo_code', 'expo_name', 'expo_category1'
            ,'expo_open_date', 'expo_close_date', 'expo_recruit_start_date', 'expo_recruit_end_date'
            ,'expo_url', 'expo_location', 'expo_image_url', 'expo_attachment_file_url','expo_description'
            ,'expo_info_addr','expo_info_email','expo_info_phone'
            ,'expo_use_yn','expo_add_json','open'
            ,'privacy_terms_text', 'entry_terms_text', 'provided_terms_text'
          ];
    protected $casts = [
      'expo_add_json' => 'array',
      'expo_open_date' => 'datetime:Y-m-d',
      'expo_close_date' => 'datetime:Y-m-d',
      'expo_recruit_start_date' => 'datetime:Y-m-d',
      'expo_recruit_end_date' => 'datetime:Y-m-d',
    ];

    public function expoMeta() {
        return $this->hasOne(ExpoMeta::class,'expo_id' );
    }
    public function expoAttach() {
        return $this->hasMany(ExpoImage::class,'expo_id' );
    }
    public function booths()
   {
       return $this->hasMany(Booth::class, 'expo_id');
   }
    public function scopeActive($query){
        return $query->where('expo_use_yn', 'Y');
    }
    public function scopeUnactive($query){
        return $query->where('expo_use_yn', 'N');
    }

    public function scopeProgress($query){
        return $query->whereDate('expo_open_date', '<=', Carbon::now())
                    ->whereDate('expo_close_date', '>=', Carbon::now());
    }
    public function scopeUpcomming($query){
        return $query->whereDate('expo_open_date', '>', Carbon::now());
    }
    public function scopeEnded($query){
        return $query->whereDate('expo_close_date', '<', Carbon::now());
    }
    public function scopeRecruiting($query){
      return $query->whereDate('expo_recruit_start_date', '<=', Carbon::now())
                  ->whereDate('expo_recruit_end_date', '>=', Carbon::now());
    }
    public function getImageUrl(){
           return url(Storage::disk('public')
               ->url($this->expo_image_url));
       }
    public function getProgressStatus() {
      $today = Carbon::now()->format('Ymd');
      if( $today < $this->expo_open_date->format('Ymd')) return 'pre';
      else if ( $this->expo_open_date->format('Ymd') <= $today
          && $today <= $this->expo_close_date->format('Ymd') ) return "ing";
      else return "end";
    }

    public function getRecruitmentStatus() {
      $today = Carbon::now()->format('Ymd');
      if( $today < $this->expo_recruit_start_date->format('Ymd')) return 'pre';
      else if ( $this->expo_recruit_start_date->format('Ymd') <= $today
          && $today <= $this->expo_recruit_end_date->format('Ymd') ) return "ing";
      else return "end";
    }

    public function visitLogs( ){
        return $this->morphMany(Visit::class, 'visitable');
    }
    public function makemeta(){
      $meta = new ExpoMeta();
      $meta->expo_id = $this->id;
      $meta->save();
    }

}
