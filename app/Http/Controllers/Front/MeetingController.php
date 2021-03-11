<?php

namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

use App\Models\Meeting;
use App\Models\Expo;
use App\Models\Booth;
use App\Models\BoothMeta;
use App\Models\Company;

use App\Models\Notification;
use App\Events\NotiEvent;

class MeetingController extends Controller
{
    protected $isMobile;
    public function __construct()
    {
        $agent = new \Jenssegers\Agent\Agent;
        $this->isMobile = $agent->isMobile();
    }

    function reserveform( Request $request, $expo_code, $booth_id, $date, $time ){
    $user = Auth::guard()->user();
    $msgcode = '';
    if( empty($user->id) ){
      if( $request->wantsJson() ){
          return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.'] ]], 401);
      }else {
        return view('mobile.inc.login');
      }
    }
	$expo = Expo::active()
		->where('expo_code', $expo_code)
		->first();
	if( empty($expo->id) || $expo->open != 'Y'){
		return view('mobile.inc.msgtemplate', ["msg"=>"잘못된 경로입니다."] );
	}
	else if ( $expo->expo_close_date->format('Y-m-d') < Carbon::today() ){
		return view('mobile.inc.msgtemplate', ["msg"=>"박람회가 종료되었습니다."] );
	}
	if( $date < $expo->expo_open_date->format('Y-m-d') || $date > $expo->expo_close_date->format('Y-m-d') ){
		$msg =  "박람회 기간은 <br>".$expo->expo_open_date->format('Y-m-d').'~'.$expo->expo_close_date->format('Y-m-d')."<br> 입니다.";
		return view('mobile.inc.msgtemplate', ["msg"=>$msg] );
	}
	$booth = Booth::display()->with('companyBooth')->where('id',$booth_id)->first();
	if( empty($booth->id) ) {
		return view('mobile.inc.msgtemplate', ["msg"=>"잘못된 경로입니다."] );
	}
    $dupl = Meeting::scheduled()->where(
      ['booth_id'=>$booth_id, 'user_id'=>$user->id, 'meeting_date'=>$date]
      )->where( 'meeting_time','>',  (Carbon::now()->format('G')) ) ->first();
    if( !empty($dupl) ){
      $msgcode = 'date';
    }else {
      $dupl = Meeting::scheduled()->where(
        ['booth_id'=>$booth_id, 'meeting_date'=>$date, 'meeting_time'=>$time]
        )->first();
        if( !empty($dupl)  ){
          $msgcode = 'time';
        }
    }
    $data = compact(['expo_code','booth_id','date','time', 'dupl', 'msgcode','booth' ]);
    /*mobile */
    if ($this->isMobile) {
        return view('mobile.meetingform' , $data );
    } else {
        return $data;
    }
  }
  public function reserve( Request $request ){
    $user = Auth::guard()->user();

    if( empty($user->id) ){
          return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.'] ]], 401);
    }

    $messages = [
        'meeting_msg.*' => '신청 내용(2~300자)을 입력해주시기 바랍니다.',
		'agree.*' =>'개인정보제공에 동의해주세요.',
        '*.*'=>'parameter error'
    ];
    $data = $request->validate([
      'booth_id' => 'bail|required',
      'meeting_date' => 'bail|required',
      'meeting_time' => 'bail|required',
	  'agree'=>'bail|required|in:Y',
      'meeting_msg' => 'bail|required|min:2|max:600',
     ],$messages);
     $data['user_id'] = $user->id;

     $dupl = Meeting::scheduled()->where(
       ['booth_id'=>$request->booth_id, 'user_id'=>$user->id, 'meeting_date'=>$request->meeting_date]
       )->where( 'meeting_time','>',  (Carbon::now()->format('G')) )->first();
     if( !empty($dupl) ){
       return response()->json(['message'=>'error','errors' => ['duplicate1' => ['이미 '.$dupl->meeting_time.'시에 미팅예약신청을 하셨습니다.'] ], 'data'=>$dupl], 422);
     }
	  
	 $dupl = Meeting::scheduled()->where(
       ['user_id'=>$user->id, 'meeting_date'=>$request->meeting_date,'meeting_time'=>$request->meeting_time ]
       )->first();
     if( !empty($dupl) ){
       return response()->json(['message'=>'error','errors' => ['duplicate1' => ['이미 같은 시간에 신청한다른 회의가 있습니다.'] ], 'data'=>$dupl], 422);
     }
	  
     $dupl = Meeting::scheduled()->where(
       ['booth_id'=>$request->booth_id, 'meeting_date'=>$request->meeting_date
       , 'meeting_time'=>$request->meeting_time]
       )->first();
     if( !empty($dupl)  ){
       return response()->json(['message'=>'refresh','errors' => ['duplicate2' => ['먼저 신청한 회원이있습니다'] ]], 422);
     }
     $booth = Booth::where('id',$request->booth_id )->first();
 
     $inputs = removeHtmlTags($data,['_method','_token'] );
     $inputs['company_id'] = $booth->company_id;
   
     Meeting::create($inputs);
     $meta = BoothMeta::where('booth_id', $request->booth_id)->first();
     $meta->addMeetingCount();
     /*
     TODO 미팅카운트 
     $meta = BoothMeta::where('booth_id', $request->booth_id)->first();
     $meta->addMeetingCount();
     */
    return response()->json( array('result'=>"OK" ,"msg"=>"신청 되었습니다.") );

  }

  /*
  날짜별 예약가능 타임테이블
  return json
  */
  public function timetable( Request $request ){
    $messages = ['boot.*'=>'parameter error','date.*'=>'parameter error'];
    $data = \Validator::make($request->all(),[
      'booth' => 'required|numeric|min:0|not_in:0',
      'date' => 'required|date_format:Y-m-d',
     ],$messages);
     if ($data->fails()) return response()->json(['errors' => ['validator' => [$data->messages()->first()] ]], 422);
    $data = $request->validate([
      'booth' => 'required|numeric|min:0|not_in:0',
      'date' => 'required|date_format:Y-m-d',
     ],$messages);
    $meeting = new Meeting();
    $res =$meeting->getlist($data['booth'],$data['date']) ;
    $user = Auth::guard()->user();
    if( !empty($user->id)) $res['checkLogin'] = true;
    return response()->json( $res);
  }


  /* 신청한 미팅 */
  function sendlist( Request $request ){
    $user = Auth::guard()->user();
    if( empty($user->id) ){
        return view('mobile.inc.login');
    }
    return view('mobile.meeting_send');
  }
  function receivelist( Request $request ){
    $user = Auth::guard()->user();
    if( empty($user->id) ){
        return view('mobile.inc.login');
    }
    return view('mobile.meeting_reserve');
  }
  function receivejson( Request $request ){
    $user = Auth::guard()->user();
    /*
    $data = Booth::select('expos.expo_name','booths.booth_title','users.name', 'meetings.*')
      ->join('expos', 'booths.expo_id', '=', 'expos.id')
      ->join('meetings', 'booths.id','=','meetings.booth_id')
      ->join('users', 'user_id' , '=','users.id')
      ->where('booths.company_id', $user->company_id)->orderBy('meetings.id')->get();
      */
      $data =Meeting::select('expos.expo_name','booths.booth_title','users.name', 'meetings.*')
              ->join('booths', 'meetings.booth_id','=','booths.id')
              ->join('expos', 'booths.expo_id', '=', 'expos.id')
              ->join('users', 'user_id' , '=','users.id')
              ->where('meetings.company_id', $user->company_id)->orderBy('meetings.meeting_date','desc')->orderBy('meetings.meeting_time','desc')->get();
    $now = Carbon::now();
    //$now = $now->timestamp;
    foreach( $data as &$row){
      $start = Carbon::create($row->meeting_date." ".$row->meeting_time.":00:00");
      $endtime =Carbon::create($row->meeting_date." ".$row->meeting_time.":00:00");
      $endtime->addHours();
      $row['meeting_start_time'] = $start;
      $row['meeting_end_time'] = $endtime;

      if( $now->timestamp >  $start->timestamp && $row->meeting_status =='R') $row['meeting_status'] = 'E';
      else if( $row->meeting_status == 'A'){
        $row['starttime'] = $start;
        if( $now <  $endtime){
          $row['meeting_cid'] =\Crypt::encryptString($row->id);
          $row['meeting_confirmed'] = true;
        }else {
          $row['meeting_cid'] ='';
          $row['meeting_confirmed'] = false;
        }
      }else {$row['meeting_cid'] ='';$row['meeting_confirmed'] = false;}
    }
    return response()->json( ["data"=>$data] );
  }
  function sendjson( Request $request ){
    $user = Auth::guard()->user();
    $data =Meeting::select('expos.expo_name','booths.booth_title','company_name', 'meetings.*')
            ->join('booths', 'meetings.booth_id','=','booths.id')
            ->join('expos', 'booths.expo_id', '=', 'expos.id')
            ->join('companies', 'booths.company_id','=','companies.id')
            ->where( 'meetings.user_id',$user->id )->orderBy('meetings.meeting_date','desc')->orderBy('meetings.meeting_time','desc')->get();
    $now = Carbon::now();
    //$now = $now->timestamp;
    foreach( $data as &$row){
      $start = Carbon::create($row->meeting_date." ".$row->meeting_time.":00:00");
      $endtime =Carbon::create($row->meeting_date." ".$row->meeting_time.":00:00");
      $endtime->addHours();
      $row['meeting_start_time'] = $start;
      $row['meeting_end_time'] = $endtime;
      if( $now >=  $endtime && $row->meeting_status =='R') $row->meeting_status = 'E';
      else if( $row->meeting_status == 'A'){
        $row['starttime'] = $start;
        if( $now <  $endtime){
          $row['meeting_cid'] =\Crypt::encryptString($row->id);
          $row['meeting_confirmed'] = true;
        }else {
          $row['meeting_cid'] ='';
          $row['meeting_confirmed'] = false;
        }
      }else {$row['meeting_cid'] ='';$row['meeting_confirmed'] = false;}
    }          
    return response()->json( ["data"=>$data] );
  }
  function meetingConfirmForm(Request $request ,$meeting_id){
    $user = Auth::guard()->user();
    
    $meeting = Meeting::select('expos.expo_name','booths.booth_title','users.name', 'meetings.*')
              ->join('booths', 'meetings.booth_id','=','booths.id')
              ->join('expos', 'booths.expo_id', '=', 'expos.id')
              ->join('users', 'user_id' , '=','users.id')->where('meetings.id', $meeting_id )->first();
    if( $meeting->company_id != $user->company_id){
      return view('mobile.inc.notfound');
    }

    $now = Carbon::now();
    $meetingtime =  new Carbon($meeting->meeting_date.' '.sprintf('%02d',$meeting->meeting_time).':00:00');
    return view('mobile.meetinginfo', compact(['meeting','now','meetingtime']));
  }
  function meetingConfirm(Request $request){
    $messages = [
      'meeting_id.*' => 'PARAMETER ERROR',
      'status.*' => 'PARAMETER ERROR',
    ];
    
    $input = $request->validate([
      'meeting_id' => 'bail|required|integer',
      'status' => 'bail|required|in:A,D',
     ],$messages);

    $user = Auth::guard()->user();
    $meeting = Meeting::where('id', $input['meeting_id'])->first();
    if( $meeting->company_id != $user->company_id){
      return response()->json(['errors' => ['auth' => ['권한이 없습니다.'] ]], 403);
    }
    
    if( $input['status']=='A'){
      if( empty($meeting->room_id) ){
        $meeting_cfg = [
          'topic' => 'meeting',
          'type' => 2,
          'start_time' => new Carbon($meeting->meeting_date.' '.sprintf('%02d',$meeting->meeting_time).':00:00'), // best to use a Carbon instance here.
          'duration' => (int)$meeting->duration,
          'password'=>Str::random(8),
        ];
		//$useremail = str_replace('@', '_', $user->email)."@way2expo.com";
		  $useremail = "booth_".$meeting->booth_id."@way2expo.com";
		 // $useremail = "develop@way2expo.com";
		  
        $zoom = new \MacsiDigital\Zoom\Support\Entry;
		$zoomuser = $zoom->user()->find($useremail);
		  
		 if ( empty($zoomuser)){
			 $booth = Booth::where(['id'=>$meeting->booth_id])->first();
			 $booth_name = preg_replace("/\([^)]+\)/u","",$booth->booth_title );
			 $booth_name = preg_replace("/[^a-zA-Z0-9가-힣ㄱ-ㅎㅏ-ㅣ]/u", "", $booth_name);
			 
			 $zoomuser =$zoom->user()->create([
				 'action'=>'autoCreate',
				 'user_info'=>[
					'first_name' => $booth_name ,
					'last_name' => '',
					'email' => $useremail,
					'password' => 'secretWay2expo!' ,
					'type'=>'2',
				 ]
			 ]);
		 }
		  /*
		if ($zoomuser->status != 'active'){
			return response()->json(['message'=>'ZOOM에서 메일('.$user->email.')을 보냈습니다. 승인해주세요','errors' => ['confirm' => ['ZOOM에서 메일('.$user->email.')을 보냈습니다. 승인해주세요'] ], 'data'=>[] ], 422);
			return;
		}
		*/
        //$zoomuser = $zoom->user()->find('develop@way2expo.com');
        $meetingapi = $zoom->meeting()->make($meeting_cfg);
        $meetingapi->settings()->make([
          'join_before_host' => true,
          'approval_type' => 2,
          'registration_type' => 1,
          'enforce_login' => false,
          'waiting_room' => true,
        ]);
        $res = $zoomuser->meetings()->save($meetingapi);
        $meeting->room_pwd = $meeting_cfg['password'];
        $meeting->room_id = $res->id;
      }
      $meeting->meeting_status = 'A';
      $meeting->save();
    }else {
      $meeting->meeting_status = 'D';
      $meeting->save();
    }
    return response()->json(['result'=>'OK','data'=> [] ], 200);
  }
  function meeting(Request $request, $meeting_id) {
     $user = Auth::guard()->user();
     if( empty($user->id) ){
       abort(403, 'Unauthorized action.');
     }
     $meeting_id = \Crypt::decryptString($meeting_id);
     $meeting = Meeting::where( 'id', (int)$meeting_id )->first();
     
	 if ( $meeting->company_id == $user->company_id ) $hosttuser = "1";
	 else $hosttuser = "0";
	  
	 if ( empty($meeting->id) ) abort(403, 'Unauthorized action.');
     else if ( $meeting->user_id != $user->id && $meeting->company_id != $user->company_id ) abort(403, 'Unauthorized action.');
     else {
       $start = Carbon::create($meeting->meeting_date." ".$meeting->meeting_time.":00:00");
		 
       //if( $hosttuser != "1" ) $now = Carbon::now();
	   //else $now = Carbon::now()->addMinutes(10) ;
		$now = Carbon::now();
	
       if( $now < $start ){
		   if( $hosttuser != "1" ) {
        	   $msg = $start->diffForHumans($now)."에 회의 참가가 가능합니다.";
		   }else {
			   $msg = $start->diffForHumans($now)."에 회의 개설이 가능합니다.";
		   }
        return view('meetingmsg',compact(['msg']));
       }
       $end = $start->addHours();
       if( $now >= $end ){
        $msg = $end->diffForHumans($now)." 에 종료된 희의입니다.";
        return view('meetingmsg',compact(['msg']));
       }
       $agent = new \Jenssegers\Agent\Agent;

       $company = Company::where( 'id', $meeting->company_id )->first();

       $signature = $this->generate_signature( $meeting->room_id ,$hosttuser);
       $arg = [
        'apiKey'=>\Config::get('zoom.api_key'),
        'mn'=> (int)$meeting->room_id,
        'email'=> $user->email,
        'name'=> $user->name,
        'pwd'=> $meeting->room_pwd,
        'role'=> $hosttuser,
        'signature'=>$signature,
       ];
       $data = compact('meeting', 'user', 'company','hosttuser','arg');

       if ($agent->isMobile()){;} 
       return view('mobile.meeting', $data );

     }
  }
  function generate_signature ( $meeting_number, $role){
    $api_key = \Config::get('zoom.api_key');
    $api_sercet = \Config::get('zoom.api_secret');
    $time = time() * 1000; //time in milliseconds (or close enough)
    $data = base64_encode($api_key . $meeting_number . $time . $role);
    $hash = hash_hmac('sha256', $data, $api_sercet, true);
    $_sig = $api_key . "." . $meeting_number . "." . $time . "." . $role . "." . base64_encode($hash);
    //return signature, url safe base64 encoded
    return rtrim(strtr(base64_encode($_sig), '+/', '-_'), '=');
  }
}
