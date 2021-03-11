<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Events\MeetingCreated;
use App\Events\MeetingUpdated;
use App\Models\Booth;
use DateTimeInterface;

class Meeting extends Model
{
    use HasFactory;
    protected $table = 'meetings';
    protected $fillable = [
      'booth_id','user_id','company_id','meeting_date','meeting_time','meeting_status','meeting_msg','room_id','room_pwd'
    ];

    public function scopeReady($query){
        return $query->where('meeting_status', 'R');
    }
    public function scopeAccepted($query){
        return $query->where('meeting_status', 'A');
    }
    public function scopeDenied($query){
        return $query->where('meeting_status', 'D');
    }
    public function scopeScheduled($query){
        return $query->where('meeting_status','!=', 'D');
    }
    public function applicant()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }
    public function receptionist()
    {
        return $this->hasOne(Company::class, 'id','company_id');
    }
    public function getlist($booth_id, $date) {
      $meeting = new Meeting();
      $booth = Booth::display()->where('booths.id', $booth_id )
        ->join("expos", "booths.expo_id",'=','expos.id')
        ->first();
      if (empty($booth->id)){
        return ['result'=>'Error','msg'=>'부스를 찾을 수 없습니다.','data'=>null];
      }
      $closetime  = Carbon::parse($booth->expo_close_date)->format('Y-m-d');
      $starttime  = Carbon::parse($booth->expo_open_date)->format('Y-m-d');
      $today = Carbon::now()->format('Y-m-d');
      $todayNow = Carbon::now()->format('YmdH');
      $cvdate = Carbon::parse($date)->format('Ymd');
      /*
      if( $closetime < $today ){
        return ['result'=>'Error','msg'=>'종료된 엑스포입니다.','data'=>null];
      }
      */
      if ( ($date >= $starttime && $date <= $closetime) ) {
          $list = Meeting::where('booth_id', $booth_id)->where('meeting_date', $date)->where('meeting_status','!=', 'D')->get();
          $times = [];
          for( $i = 9; $i < 18; $i ++){
            $times['time_'.$i] = [
              "date"=>$date,
              "avail_date"=> ( $cvdate.( sprintf('%02d', $i )) > $todayNow ) ? true: false,
              "startTime"=> $i,
              "startTimeDisplay"=>sprintf('%02d', $i),
              "endTime"=> $i+1,
              "endTimeDisplay"=>sprintf('%02d', $i+1),
              "reservation_available"=>true
            ];
          }
          foreach( $list as $row ){
            $times[ 'time_'.$row['meeting_time']]['reservation_available'] = false;
          }
          return ['result'=>'OK','data'=>$times,'checkLogin'=>false];
      }else return ['result'=>'Error','msg'=>'엑스포기간이 아닙니다.','data'=>compact('starttime','closetime', 'date') ];
    }

    protected $dispatchesEvents = [
       'created' => MeetingCreated::class,
       'updated' => MeetingUpdated::class,
     ];
}
