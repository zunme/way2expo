<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Expo;
use App\Models\Booth;
use App\Models\Live;
use App\Models\LiveBan;
use App\Models\LiveVisit;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Carbon\Carbon;

class MobileLiveController extends Controller
{
 function startcheck(Request $request ){
    $user = Auth::guard()->user();
    $channel_id = $request->channel_id;
    $tmp = explode('_', $channel_id);

    $channel_id = $tmp[2];
    $booth_id = $request->booth_id;
    $booth = Booth::with(['companyBooth'])->where('id',$booth_id)->first();

    if( $booth->company_id != $user->company_id || $booth->company_id < 1){
      return response()->json(['errors' => ['msg' => ['권한이 없습니다.'] ]], 403);
    }else if ( $booth->companyBooth->company_level < 100){
      return response()->json(['errors' => ['msg' => ['권한이 없습니다.'] ]], 403);
    }
    $live = Live::where('booth_id',$booth_id )
                ->where('live_status','O')->count();

   
    if( $live > 0 ) {
        $apires = Http::post('https://signal.remotemonster.com/lambda/broadcast-channel-list', [
            'secret' => config('remotemonster.key'),
            'serviceId' => config('remotemonster.serviceId'),
            'keyword'=>'booth_'.$booth->id."_"
        ]);
        $channles = json_decode($apires->body());
        if( count($channles) > 0 ) return response()->json(['errors' => ['msg' => ['라이브 방송이 진행중입니다.'] ]], 422);
        else {
            Live::where('booth_id',$booth_id )
                ->where('live_status','O')->update(['live_status'=> 'C']);
        }
    }
    Live::create([
        'booth_id'=>$booth_id,
        'channel_id'=>$channel_id,
        'live_status'=>'O',
    ]);
    return response()->json(['result'=>'OK','data'=> [] ], 200);
 }
  function closecheck(Request $request ){

        $channel_id = $request->channel_id;
        $tmp = explode('_', $channel_id);

        $channel_id = $tmp[2];
        $booth_id = $request->booth_id;
        Live::where(['booth_id'=>$booth_id,'channel_id'=>$channel_id,])
            ->update(['live_status'=>'C']);
        return response()->json(['result'=>'OK','data'=> [] ], 200);
 }
 function startlive( Request $request, $id ){
    $user = Auth::guard()->user();
    $booth_id = \Crypt::decryptString($id);
    $cfg = \Config::get('remotemonster');
    $cfg['view'] = ['remote'=> '#remoteVideo','local'=> '#localVideo'];
    $booth = Booth::display()->with(['expoBooth'])->where('id',$booth_id)->first();
	 if( empty($booth->id) || $booth->expoBooth->expo_use_yn != 'Y'){
		return view('mobile.inc.msgtemplate', ["msg"=>"잘못된 경로입니다."] );	 
	 }else if ( $booth->expoBooth->expo_close_date->format('Y-m-d') < Carbon::today() ){
		return view('mobile.inc.msgtemplate', ["msg"=>"박람회가 종료되었습니다."] );
	}else if ( $booth->expoBooth->expo_open_date->format('Y-m-d') > Carbon::today() ){
		return view('mobile.inc.msgtemplate', ["msg"=>"박람회 기간이 아닙니다."] );
	}
	 
    if( $booth->company_id != $user->company_id){
      return view("mobile.inc.notfound",["msg"=>"권한이 없습니다."]);
    }
	
    $apires = Http::post('https://signal.remotemonster.com/lambda/broadcast-channel-list', [
            'secret' => config('remotemonster.key'),
            'serviceId' => config('remotemonster.serviceId'),
        'keyword'=>'booth_'.$booth->id."_"
    ]);
	 
    $channles = json_decode($apires->body());

    if( count( $channles) > 0 ){
		$cnt = Live::where(['booth_id'=> $booth->id, 'live_status'=>'O'])->count();
		if( $cnt  > 0 ){
			$msg = "현재 라이브 방송이 진행중입니다.";
			return view('mobile.inc.msgtemplate', compact(['msg']));
		}	 
    }
	else {
		Live::where(['booth_id'=> $booth->id, 'live_status'=>'O'])->update(['live_status'=>'C']);
	}

    $channel_id = "booth_".$booth->id."_".uniqid();
    $userkey = $this->encrypt64($user->id);
    
    $banlist = LiveBan::select('user_id')->where(['booth_id'=> $booth_id,'banned_type'=>'B'])->get();
    $mutelist = LiveBan::select('user_id')->where(['booth_id'=> $booth_id,'banned_type'=>'C'])->get();
    $tmp = array();
    foreach( $mutelist as $row ){
        $tmp[] =  $this->encrypt64($row->user_id);
    }
    $mutelist = $tmp;
    return view('mobile.livetrans', compact(['booth','user','userkey','channel_id','banlist','mutelist','cfg']));
 }
 function viewlive(  Request $request, $id ){
    $user = Auth::guard()->user();
    //$booth_id = \Crypt::decryptString($id);
    $booth_id = $id;
    $booth = Booth::where('id',$booth_id)->first();
    $cfg = \Config::get('remotemonster');
    if(!empty($user->id) ) {
		$userkey =  $this->encrypt64($user->id);
		$username = $user->name;
	}
    else {
		$userkey = "guestUser";
		$username = 'guest';
	}

    $channels = Live::where('booth_id',$booth_id )
                ->where('live_status','O')->first();
    if( empty($channels->id)){
        $msg = "현재 진행중인 라이브가 없습니다.";
        return view('mobile.inc.msgtemplate', compact(['msg']));  
    }else {
		$this->visit($channels->id);
		$channels->addVisitorCount();
	}
	 
	 
    $channel_id = "booth_".$channels->booth_id."_".$channels->channel_id;
    if( !empty($user->id ) ) {
        $isban = LiveBan::where(['booth_id'=> $booth_id, 'user_id'=>$user->id ,'banned_type'=>'B'])->count();
        if( $isban > 0 ){
            $msg = "강제 퇴장되셨습니다.";
            return view('mobile.inc.msgtemplate', compact(['msg']));
        }
        $chatable = LiveBan::where(['booth_id'=> $booth_id, 'user_id'=>$user->id ,'banned_type'=>'C'])->count();
        $mute = $chatable > 0 ? 'true' : 'false';
    }else {
        $mute = 'true';
    }
	 
    return view('mobile.liveview', compact(['userkey','username','channel_id','mute','booth','cfg','channels']) );
 }
 function livecheck(Request $request, $booth_id ) {
    $live = Live::where(['booth_id'=> $booth_id,'live_status'=>'O' ])->count();
    if( $live > 0 ) return response()->json(['result'=>'OK','data'=> "on" ], 200);
    else return response()->json(['result'=>'OK','data'=> "off" ], 200);
 }
 function usercheck(Request $request ) {
    $user = Auth::guard()->user();
    $messages = [
      'booth_id.*' => 'PARAMETER ERROR'
    ];
    $input = $request->validate([
      'booth_id' => 'bail|required|integer',
     ],$messages);
    $booth_id = $request->booth_id;
    $user_key =  $this->decrypt64($request->user_key);

    $booth = Booth::where('id', $booth_id)->first();
    if( empty($booth->id) || empty($booth->company_id) ){
        return response()->json(['errors' => ['auth' => ['권한이 없습니다.'] ]], 403);
    }
    $isban = LiveBan::where(['booth_id'=> $booth_id, 'user_id'=>$user_key ,'banned_type'=>'B'])->count();
    $ismute = LiveBan::where(['booth_id'=> $booth_id, 'user_id'=>$user_key ,'banned_type'=>'C'])->count();

    $data = [
		"uuid"=> $user_key,
        "ban" => ($isban>0) ? true:false,
        "mute" => ($ismute>0) ? true:false
    ];
    return response()->json(['result'=>'OK','data'=> $data ], 200);
 }
 function cmd( Request $request ) {
    $user = Auth::guard()->user();
    $messages = [
      'booth_id.*' => 'PARAMETER ERROR',
      'cmd.*' => 'PARAMETER ERROR',
    ];
    $input = $request->validate([
      'booth_id' => 'bail|required|integer',
      'cmd' => 'bail|required|in:ban,block,unban,unblock',
     ],$messages);
    $cmdlist =['ban'=>'b', 'block'=>'c' , 'unban'=>'b','unblock'=>'c' ];
    $booth_id = $request->booth_id;
    $user_key =  $this->decrypt64($request->user_key);
    $booth = Booth::where('id', $booth_id)->first();

    if( empty($booth->id) || empty($booth->company_id) ){
        return response()->json(['errors' => ['auth' => ['권한이 없습니다.'] ]], 403);
    }else if ( $booth->company_id != $user->company_id ){
        return response()->json(['errors' => ['auth' => ['권한이 없습니다.'] ]], 403);
    }
    $findcmd = $cmdlist[ $request->cmd ];

    $log = LiveBan::where(['booth_id'=> $booth_id, 'user_id'=>$user_key ,'banned_type'=>$findcmd])->first();
    if ( in_array( $request->cmd, ['ban', 'block'] ) ){
        if ( !empty( $log->id) ){
            return response()->json(['errors' => ['dup' => ['기존에 처리된 유저입니다.'] ]], 422);
        }
        try {
            LiveBan::create( [
                'banned_type'=> $cmdlist[ $request->cmd ],
                'booth_id'=>$booth->id, 
                'user_id'=>$user_key,
                'created_by_id'=>$user->id
            ]);
			$isban = LiveBan::where(['booth_id'=> $booth_id, 'user_id'=>$user_key ,'banned_type'=>'B'])->count();
			$ismute = LiveBan::where(['booth_id'=> $booth_id, 'user_id'=>$user_key ,'banned_type'=>'C'])->count();

			$data = [
				"uuid"=> $user_key,
				"ban" => ($isban>0) ? true:false,
				"mute" => ($ismute>0) ? true:false
			];
            return response()->json(['result'=>'OK','data'=> $data ], 200);
        }catch ( \Exception $e) {
            return response()->json(['errors' => ['system' => ['잠시후에 시도해주세요'] ]], 422);
        }

    }else {
        if( !empty($log->id) ){
            $log->banned_type = 'U';
            $log->save();
        }
		$isban = LiveBan::where(['booth_id'=> $booth_id, 'user_id'=>$user_key ,'banned_type'=>'B'])->count();
		$ismute = LiveBan::where(['booth_id'=> $booth_id, 'user_id'=>$user_key ,'banned_type'=>'C'])->count();

		$data = [
			"uuid"=> $user_key,
			"ban" => ($isban>0) ? true:false,
			"mute" => ($ismute>0) ? true:false
		];
        return response()->json(['result'=>'OK','data'=> $data ], 200);
    }
 }
	function addLike(Request $request){
		$tmp = explode('_',$request->channel_id);
		if( count($tmp)< 3) {
			return response()->json(['result' => "error", "msg" => '방송 중이 아닙니다.'], 422);
		}
		$channel_id = $tmp[2];
			
		$live = Live::where(['booth_id'=>$request->booth_id, 'channel_id'=>$channel_id ])->first();
		
		if (empty($live) || $live->live_status !== 'O') return response()->json(['result' => "error", "msg" => '방송 중이 아닙니다.'], 422);
		$live->addLikeCount();
		return response()->json(['result' => "OK",'data'=> $live->like_count ], 200);
	}
 function thumb ( Request $request  ){
	 $base64_image = $request->imgBase64;
	if (preg_match('/^data:image\/(\w+);base64,/', $base64_image )) {
		$data = substr($base64_image, strpos($base64_image, ',') + 1);
		$data = base64_decode($data);
	    $image = Image::make($data);
		
		$image->resize('200', null, function ($constraint) {
			 $constraint->aspectRatio();
		 });
		$stroageres = Storage::disk('public')->put('/thumb/'.$request->channel_id.'.jpg', $image->stream()->__toString());
		//dd ($stroageres);
		echo url('/storage/thumb/'.$request->channel_id.'.jpg?ver='.time() );
	}else dd( "error");
	 
 }
 function remon( Request $request  ){
	 \Log::debug('get remon');
	 \Log::debug( $request->all() );
	 
     if ( $request->action){
		$status = ( $request->action == 'create') ?'O':'C';
        $tmp = explode("_",  $request->chid );
        $booth = $tmp[1];
        $channel = $tmp[2];
		 
	 	\Log::debug('booth:'.$booth.', chid:'.$channel.' => '.$status);
        
		 $live = Live::where([
            'booth_id' =>$booth, 'channel_id'=>$channel
        ])->first();
        if( !empty($live->id) ){
            $live->live_status = $status;
            $live->save();
        }else {
            Live::create([
                'booth_id' =>$booth, 'channel_id'=>$channel, 'live_status'=>$status
            ]);
        }
        echo "200: OK";
     }
 }
	private function visit($liveKey)
    {
        $visitor = visitor();

        try {
            $prepareLog = [
                'url' => $visitor->url(),
                'referer' => $visitor->referer(),
                'useragent' => $visitor->userAgent(),
                'device' => $visitor->device(),
                'platform' => $visitor->platform(),
                'browser' => $visitor->browser(),
                'ip' => $visitor->ip(),
                'live_id' => $liveKey,
                'visitor_id' => $visitor->getVisitor() ? $visitor->getVisitor()->id : null,
            ];

            $visit = LiveVisit::create($prepareLog);
            return true;

        } catch (\Exception $e) {
			return false;
        }
    }
	
	function simpleBoothInfo(Request $request, $booth_id){
		$booth = Booth::with('expoBooth')->where('id', $booth_id)->display()->first();
		if( empty($booth)){
			return response()->json(['result' => "error",'data'=>[] ], 404);
		}
		return response()->json(['result' => "OK",'data'=> $booth ], 200);
	}
	    /**
     * 암호화
     * @param $n
     * @return int
     */
    private function encrypt64($n)
    {
        return ((0x000000000000FFFF & $n) << 48) + (((0xFFFFFFFFFFFF0000 & $n) >> 16) & 0x0000FFFFFFFFFFFF);
    }

    /**
     * 복호화
     * @param $n
     * @return int
     */
    private function decrypt64($n)
    {
        return ((0x0000FFFFFFFFFFFF & $n) << 16) + (((0xFFFF000000000000 & $n) >> 48) & 0x000000000000FFFF);
    }

}
