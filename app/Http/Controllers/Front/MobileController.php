<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Notification;
use App\Events\NotiEvent;

use App\Models\User;
use App\Models\UserMeta;

use App\Models\Expo;
use App\Models\Booth;
use App\Models\Product;
use App\Models\SearchLog;

use Carbon\Carbon;
use Validator;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;

use App\Models\Company;
use App\Models\Category;
use App\Models\CheckPlus;
use Illuminate\Support\Facades\Storage;
use App\Modules\jsonrpctalk;
use Illuminate\Support\Facades\Cache;

class MobileController extends Controller
{
  public function register(Request $request){
	  $data = [ 
		  'step'=>'1',
		  'agree_service'=>'N',
		  'agree_marketing' =>'N',
		];
		return $this->registerStep3( $request, $data);
  }
  public function nice( Request $request ) {
    $agree = $request->only(['agree_service', 'agree_marketing']);
    if ( $agree['agree_service'] != 'Y' ){
      echo "false";return;
    }
    $request->session()->put('cpc_agree', $agree);
    $enc = $this->cpc($request);
    echo $enc['data'];
  }
  
  public function certPrc(Request $request){
    $data = $this->cpc( $request );
    if ( !$data['result'] ){
      $msg = "본인 인증에 실패하셨습니다.";
      return view('mobile.inc.msg', compact(['msg']));
    }
    
    $cnt = User::where('di',$data['data']->di)->count();
    if ( $cnt > 0 ){
      $msg = "이미 가입 기록이 있습니다.";
      return view('mobile.inc.msg', compact(['msg']));      
    }
    
    $request->session()->put('cpc_id', $data['data']->id );
    return redirect("/m/register/step3");
  }
  public function certErrprPrc(Request $request){
      $msg = "본인 인증에 실패하셨습니다.";
      return view('mobile.inc.msg', compact(['msg']));  
  }
  public function registerStep3(Request $request, $data = null){
      $enc='';
	    $user = Auth::guard()->user();
	    if (!empty( $user->id) ){
			return view("mobile.redirect");
		}
    if ( empty ($request->session()->get('cpc_id')) ){
      $data = [ 
        'step'=>'1',
        'agree_service'=>'N',
        'agree_marketing' =>'N',
        'cert'=> new CheckPlus()
      ];
    
    }else {
      $cert = CheckPlus::where('id', $request->session()->get('cpc_id'))->first();     
      $cpc_agree = $request->session()->get('cpc_agree');
		  $data = [ 
			  'step'=>'3',
			  'agree_service'=>$cpc_agree['agree_service'] =='Y' ? 'Y' : 'N',
			  'agree_marketing' => $cpc_agree['agree_marketing'] =='Y' ? 'Y' : 'N',
        'cert'=>$cert,
			];     
    }

		$areas =config('dataset.area');
		$ages=config('dataset.age');
		$purpose=config('dataset.purpose_viewing');
		$industry=config('dataset.industry');
		$company_position=config('dataset.company_position');

		$category = Category::where('display_yn','Y')->where('parent_id','0')
		  ->orderBy('id')->get();
		$sub = Category::where('display_yn','Y')->where('parent_id','>','0')
		  ->get();
		$subcategory = array();
		foreach ( $sub as $row){
		  $subcategory[ $row['code1'] ][] = $row;
		}
		return view('mobile.inc.register',
				  compact(['data','areas','ages','purpose','industry',
						   'company_position','category','subcategory','enc']) );
  }
  
  public function changehp( Request $request ){
    $user = Auth::user();
    if( empty($user->id) ){
      return;
    }
    $type='F';
    $enc = $this->cpc( $request, "/mobile/change/hpprc", $type);
    echo $enc['data'];
  }
  public function changehpprc( Request $request ){
    $user = Auth::user();
    if( empty($user->id) ){
        $msg = "로그인후 본인인증을 해주세요";
        return view('mobile.inc.msg', compact(['msg']));
    }
    $res = $this->cpc( $request,'','F' );
    if ( $res['result']){
      $data = $res['data'];
      $di = $data->di;
      $tel = $data->mobile_no;
      if( $user->di != $di ){
        $msg = "가입자 명의의 휴대폰으로 인증해주세요";
        return view('mobile.inc.msg', compact(['msg']));
      }
      $user->update(['tel'=>$tel]);
      return redirect('/m/myinfo');
    }
    $msg = "본인 인증 실패";
    return view('mobile.inc.msg', compact(['msg']));
    
  }
  public function changehperror( Request $request ){
    $msg = "인증 오류";
    return view('mobile.inc.msg', compact(['msg']));
  }
  
  public function finduser(Request $request){
    $user = Auth::guard()->user();
    if( !empty($user->id)){
      $msg = "이미 로그인 중입니다.";
      return view('mobile.inc.msgtemplate', compact(['msg']));
    }
    $result = $request->session()->pull('finduser', array( 'res'=>false, 'find'=>'','msg'=>'','type'=>'') );
    return view('mobile.finduser', compact(['result']));
  }
  public function findid( Request $request ){
    $type='F';
    $enc = $this->cpc( $request, "/mobile/finduser/idprc", $type);
    echo $enc['data'];
  }

  public function findpwd( Request $request ){
    $request->session()->put('findpwd', $request->email);
    $type='F';
    $enc = $this->cpc( $request, "/mobile/finduser/pwdprc", $type);
    echo $enc['data'];
  }
  public function findidprc( Request $request ){
    $res = false;
    $find = '';
    $msg = '';
    $type="id";
    
    $data = $this->cpc( $request,'','F' );
    if ( !$data['result'] ){
      $msg = "본인 인증에 실패하셨습니다.";
    } else {
    
      $finduser = User::where('di',$data['data']->di)->first();
      if ( empty($finduser->id) ){
        $msg = "사용자 아이디를 찾을 수 없습니다.";
      }else {
        //$email = $this->masking( $finduser->email );
        $res = true;
        $find = $finduser->email ; 
      }
      
    }
    $data = compact (['msg', 'find','res','type']);
    $request->session()->put('finduser', $data);
    return redirect('/m/find');
  }
  public function findpwdprd( Request $request ){
    $res = false;
    $find = '';
    $msg = '';
    $type="pwd";
    
    $data = $this->cpc( $request,'','F' );

    if ( !$data['result'] ){
      $msg = "본인 인증에 실패하셨습니다.";
    }else {
      $finduser = User::where('di',$data['data']->di)
          ->where('email', $request->session()->get('findpwd')  )->first();
      if ( empty($finduser->id) ){
        $msg = "사용자 아이디를 찾을 수 없습니다.";
      }else {
        //$email = $this->masking( $finduser->email );
        $res = true;
        $find = $finduser->email ; 
         $request->session()->put('findPwdUserId', $finduser->id);
      }
    }
    $data = compact (['msg', 'find','res','type']);
    $request->session()->put('finduser', $data);
    return redirect('/m/find');
  }
  public function changepwdprc( Request $request ){
    $userid = $request->session()->get('findPwdUserId');
    if( empty($userid) ){
     		 return response()->json([
            'errors' => ["cert"=>["인증정보를 찾을 수 없습니다."],]
        ], 422); 
    }
    $user = User::find( $userid);
    if( empty($userid) ){
     		 return response()->json([
            'errors' => ["cert"=>["사용자 정보를 찾을 수 없습니다."],]
        ], 422); 
    }
    Validator::extend('without_spaces', function($attr, $value){
      return preg_match('/^\S*$/u', $value);
    });	  
    $messages = [
		'password.confirmed'    => '비밀번호가 일치하지 않습니다.',
		'password.without_spaces'    => '공백은 사용할 수 없습니다.',
    'password.*'    => '영문,숫자,특수문자를 조합하여 8~20자로 입력해주세요.',
		//'password.*'    => '변경할 비밀번호를 입력해주세요.',
    ];

    $data = $request->validate([
		'password'=>'bail|required|min:8|max:20|without_spaces|regex:/[a-zA-z]/|regex:/[0-9]/|regex:/[@!#$%^&*()-=_+{}\[\]<>~`]/|confirmed',
     ],$messages);
    try {
      $user->update( ['password' => \Hash::make( $data['password'] )] );
       $request->session()->forget('findPwdUserId');
      return response()->json(['result'=>'OK','data'=>$user->email], 200);
    } catch (\Exception $e) {
      return response()->json(['result'=>'FALSE'], 500);
    }
  }
  private function cpc($request,$url="/mobile/cert",$type='R'){
    $cfg = config('checkplus');
    
    $site_code = $cfg['site_code'];
    $site_pw = $cfg['site_pw'];
    $cb_encode_path = app_path().'/NICE/CPClient_64bit';
;
    if( !empty($request->EncodeData) ){
      $enc_data = $request->EncodeData;
      $data = array();
      if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {
        return array( 'result'=>false, 'msg'=>'입력 값 확인이 필요합니다','data'=>[]);
      } // 문자열 점검 추가. 
      if(base64_encode(base64_decode($enc_data))!=$enc_data) {
        return array( 'result'=>false, 'msg'=>'입력 값 확인이 필요합니다','data'=>[]);
      }
      $plaindata = `$cb_encode_path DEC $site_code $site_pw $enc_data`;	
      
      $user = Auth::guard()->user();
      $data['type'] = $type;
      if (!empty( $user->id) ){
        $data['user_id'] = $user->id;
      } else {
        $data['user_id'] = 0;
      }
      $data['req_seq'] = $this->getCpcValue($plaindata , "REQ_SEQ");
      $data['res_seq'] = $this->getCpcValue($plaindata , "RES_SEQ");
      $data['auth_type'] = $this->getCpcValue($plaindata , "AUTH_TYPE");
      $data['name'] = urldecode ($this->getCpcValue($plaindata , "UTF8_NAME"));
      $data['birthdate'] = $this->getCpcValue($plaindata , "BIRTHDATE");
      $data['gender'] = $this->getCpcValue($plaindata , "GENDER");
      $data['nationainfo'] = $this->getCpcValue($plaindata , "NATIONALINFO");
      $data['di'] = $this->getCpcValue($plaindata , "DI");
      $data['ci'] = $this->getCpcValue($plaindata , "CI");
      $data['mobile_co'] = $this->getCpcValue($plaindata , "MOBILE_CO");
      $data['mobile_no'] = $this->getCpcValue($plaindata , "MOBILE_NO");
      
      if( $data['req_seq'] != $request->session()->pull('cpc_reqseq','') ){
          //return array( 'result'=>false, 'msg'=>'제한된 접근입니다.','data'=>[]);
      }
      $checkplus = CheckPlus::create($data);
       return array( 'result'=>true, 'msg'=>'','data'=>$checkplus);
    }else {
      $returnurl = url($url);
      $errorurl = url( $url."/error");
      
      $reqseq = `$cb_encode_path SEQ $site_code`;

      $authtype = "M";$popgubun="N";$customize="Mobile";
      $gender="";

      $plaindata = "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
      "8:SITECODE" . strlen($site_code) . ":" . $site_code .
      "9:AUTH_TYPE" . strlen($authtype) . ":". $authtype .
      "7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
      "7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
      "11:POPUP_GUBUN" . strlen($popgubun) . ":" . $popgubun .
      "9:CUSTOMIZE" . strlen($customize) . ":" . $customize .
      "6:GENDER" . strlen($gender) . ":" . $gender ;
      //$enc= `$cb_encode_path ENC $cfg['site_code'] $cfg['site_pw'] $plaindata`;
      $enc = `$cb_encode_path ENC $site_code $site_pw $plaindata`;
      if ( $enc == -1 ){
        return array( 'result'=>false, 'msg'=>'시스템 에러','data'=>"암/복호화 시스템 오류입니다.");
      } else if ( $enc == -2 ){
        return array( 'result'=>false, 'msg'=>'시스템 에러','data'=>"암호화 처리 오류입니다.");
      } else if ( $enc == -3 ){
        return array( 'result'=>false, 'msg'=>'시스템 에러','data'=>"암호화 데이터 오류 입니다.");
      } else if ( $enc == -9 ){
        return array( 'result'=>false, 'msg'=>'시스템 에러','data'=>"입력값 오류 입니다.");
      }
      else {
        $request->session()->put('cpc_reqseq', $reqseq);
        return array( 'result'=>true, 'msg'=>'','data'=>$enc);
      }
    }
  }
  private function getCpcValue($str , $name) {
    $pos1 = 0;  //length의 시작 위치
    $pos2 = 0;  //:의 위치

    while( $pos1 <= strlen($str) ) {
      $pos2 = strpos( $str , ":" , $pos1);
      $len = (int)substr($str , $pos1 , $pos2 - $pos1);
      $key = substr($str , $pos2 + 1 , $len);
      $pos1 = $pos2 + $len + 1;
      if( $key == $name ) {
        $pos2 = strpos( $str , ":" , $pos1);
        $len = (int)substr($str , $pos1 , $pos2 - $pos1);
        $value = substr($str , $pos2 + 1 , $len);
        return $value;
      } else {
      // 다르면 스킵한다.
        $pos2 = strpos( $str , ":" , $pos1);
        $len = (int)substr($str , $pos1 , $pos2 - $pos1);
        $pos1 = $pos2 + $len + 1;
      }            
    }
  }
  private function masking( $str ){
	  $prefix = Str::before($str,'@');
	  $postfix = Str::after($str,'@');
	
	  if( $postfix != $prefix){
		  $header = Str::limit( $prefix, 3,'')
					.str_repeat('X', strlen($prefix)-3);

		  $domainname = Str::before($postfix,'.');
		  $domainname =  Str::limit( $domainname, 3,'')
					.str_repeat('X', strlen($domainname)-3);
		  $firstdomain = Str::after($postfix,'.');
		  $firstdomain  = str_repeat('X', strlen($firstdomain));
		  return $header.'@'.$domainname.'.'.$firstdomain;		  
	  }
	  else {
		  return Str::limit( $str, 4,'')
					.str_repeat('X', Str::length($str)-2);
	  }
  }
  public function  registerPrc( Request $request){
	  //TODO 인증여부 체크 필요
	Validator::extend('without_spaces', function($attr, $value){
		return preg_match('/^\S*$/u', $value);
	});	  
    $messages = [
		'agree_service.*' => '서비스 이용 동의를 하지 않으셨습니다.',
		'email.unique'    => '이미 사용중인 이메일입니다.',
		'email.without_spaces'    => '공백은 사용할 수 없습니다.',
		'email.*'    => '이메일을 입력해주세요.',
		'password.confirmed'    => '비밀번호가 일치하지 않습니다.',
		'password.regex'    => '영문,숫자,특수문자를 조합하여 8~20자로 입력해주세요.',
		'password.without_spaces'    => '공백은 사용할 수 없습니다.',
		'password.*'    => '비밀번호를 입력해주세요.',
    ];

    $data = $request->validate([
		'agree_service'=>'bail|required|in:Y',
		'agree_marketing'=>'bail|required|in:Y,N',
		'email'=>'bail|required|without_spaces|email|unique:users,email,'.$request->email,
		'password'=>'bail|required|min:8|max:20|without_spaces|regex:/[a-zA-z]/|regex:/[0-9]/|regex:/[@!#$%^&*()-=_+{}\[\]<>~`]/|confirmed',
		'area'=>'bail|nullable|string',
		'age'=>'bail|nullable|string',
		
		'category_pid1'=>'bail|nullable|integer',
		'category_id1'=>'bail|nullable|integer',
		'category_pid2'=>'bail|nullable|integer',
		'category_id2'=>'bail|nullable|integer',
		'category_pid3'=>'bail|nullable|integer',
		'category_id3'=>'bail|nullable|integer',
		
		'purpose_viewing'=>'bail|nullable|string',
		'industry'=>'bail|nullable|string',
		
		'company_name'=>'bail|nullable|string',
		'company_dept'=>'bail|nullable|string',
		'company_position'=>'bail|nullable|string',
		'company_site'=>'bail|nullable|url',
		'company_tel'=>'bail|nullable|string',
		'company_zip'=>'bail|nullable|string',
		'company_address1'=>'bail|nullable|string',
		'company_address2'=>'bail|nullable|string',
		'intro'=>'bail|nullable|string',
		
     ],$messages);
	  
	 if( $data['email']==$data['password']){
		 return response()->json([
            'errors' => ["password"=>["아이디와 동일한 비밀번호는 사용할 수 없습니다"],]
        ], 422);
	 }
	  
    if ( empty($request->session()->get('cpc_id')) ){
     		 return response()->json([
            'errors' => ["cert"=>["인증정보 오류입니다."],]
        ], 422); 
    }
    $data['password'] = \Hash::make( $data['password'] );
    $cert = CheckPlus::where('id', $request->session()->get('cpc_id'))->first();
    
	  $data['tel'] = $cert->mobile_no;
	  $data['di'] = $cert->di;
	  $data['name'] = $cert->name;
	  $data ['user_status'] = 'Y';
	  $data['birthdate'] = $cert->birthdate;
    
	  //return response()->json(['result'=>'OK','data'=>$userdata], 200);
		\DB::beginTransaction();
		try {
			$user = User::create($data);
			$data['user_id'] = $user->id;
			$userMeta = UserMeta::create($data);
      $cert->user_id = $user->id;
      $cert->type = 'C';
      $cert->save();
		\DB::commit();
			//$userdata = [ 'name'=>$data['name'],'email'=>$data['email'] ];
      $userdata = [ 'name'=>$this->masking( $data['name'] ),
				   'email'=>$this->masking( $data['email'] ) 
				  ];

      $request->session()->forget('cpc_agree');
      $request->session()->forget('cpc_id');
      
			return response()->json(['result'=>'OK','data'=>$userdata], 200);
		} catch (\Exception $e) {
		\DB::rollback();
			dump( $e);
			return response()->json(['result'=>'FALSE'], 500);
		}
		
  }
  public function snslogin(Request $request){
	  $kakaoid = $request->session()->get('kakaoid');
	  $kakaoConnect = $request->session()->get('kakaoConnect');
	  $request->session()->forget('kakaoid');
	 
	  if( !empty($kakaoConnect) ){
		  $request->session()->keep(['kakaoConnect']);
	  }
	  else if( !empty($kakaoid) ){
		  $request->session()->flash('kakaoConnect', $kakaoid);
	  }else {
		  redirect('/');
		  return;
	  }
	  return view("mobile.inc.loginsns");
  }

  public function search(Request $request){
		$searchstr = $request->searchstr;
	  return view("mobile.inc/search" , compact(['searchstr']));
  }
  public function searchWordTop(Request $request) {
	$searchstr = $request->searchstr;
 	$user = Auth::guard()->user();
	$userid = empty($user->id) ? '-1' : $user->id;	  
	  
	$topSearhed = Cache::remember('topSearhed', 60*30, function () {
		return SearchLog::select('search')
					  ->where('created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 3 DAY)'))
					  ->where('search','!=','')
					  ->groupBy('search')
					  ->orderByRaw('count(1) desc')
					  ->limit(6)
					  ->get();
	});
	if (empty($topSearhed) || $topSearhed->count() < 5 ) {
	  Cache::forget('topSearhed');
	}

	if ( !empty($searchstr) ) {
		SearchLog::create(['user_id'=>$userid, 'search'=>$searchstr] ); 
	}
	  
	return response()->json(['result'=>'OK','data'=> $topSearhed ], 200);
  }
	public function searchBooth(Request $request) {
		$user = Auth::guard()->user();
		$userid = empty($user->id) ? '-1' : $user->id;

		$searchstr = $request->searchstr;
		if( $userid > 0 ) $logined = true;
		else $logined = false;	
		\DB::statement("SET SQL_MODE=''");
		  
		  
		$sub = DB::table('booths')
			->select(
				DB::raw("booths.id AS subid"),
				'expos.expo_code',
				'expos.expo_open_date','expos.expo_close_date'
			  )
			->join( 'expos', function($q) {
				$q->on(  'booths.expo_id','=','expos.id' );
				$q->on( "expos.expo_use_yn",'=',DB::raw("'Y'") );
				//$q->on( "expos.open",'=',DB::raw("'Y'") );
			  })
			->leftJoin('booth_tags','booths.id','=','booth_tags.booth_id')
			  ->where( function ($query) use ($searchstr){
				$query->where('booths.booth_title','like','%'.$searchstr.'%')
					->orWhere('booths.booth_intro','like','%'.$searchstr.'%')
					->orWhere('booth_tags.name','like','%'.$searchstr.'%')
					;
			})
			->where([
				'booth_use_yn'=>'Y',
				'booth_display_yn'=>'Y',
			])
			->where( function ($whereQuery){
				$whereQuery->where( 'expos.open','Y')
					->orWhere('expos.expo_open_date','<=', \DB::raw("'".carbon::now()."'") );
			})
			->groupBy('booths.id');

		$booth = Booth::with('tags')
			->select(
				DB::raw("
					case 
						when subq.expo_open_date > CURDATE() then '1'
						when subq.expo_close_date >= CURDATE() then '0'
						ELSE '2' 
					end AS expostatus	
				"),
				// DB::raw("booth_favorites.id AS isfavorite"),
				DB::raw("if ( booth_favorites.id is NULL , 0,1) AS isfavorite"),
				'booths.id','booths.expo_id','booths.company_id'
				,'booths.booth_mobile_image_url', 'booths.booth_title'
				,'subq.expo_code'
			)
			->joinSub($sub, 'subq', function ($join) {
				$join->on('booths.id', '=', 'subq.subid');
			})
			->leftJoin('booth_favorites', function($q) use($userid) {
				  $q->on('booths.id', '=','booth_favorites.booth_id' )
					  ->where('user_id', $userid);
			  })
			->orderByRaw(DB::raw('1 asc, rand()'))
			->get();
		return response()->json(['result'=>'OK','data'=> $booth ], 200);
	}
	public function searchExpo(Request $request) {
		$user = Auth::guard()->user();
		$userid = empty($user->id) ? '-1' : $user->id;

		$searchstr = $request->searchstr;
		if( $userid > 0 ) $logined = true;
		else $logined = false;
		$expo = Expo::active()
			->select ( 
				DB::raw("
					case 
						when expos.expo_open_date > CURDATE() then '1'
						when expos.expo_close_date >= CURDATE() then '0'
						ELSE '2' 
					end AS expostatus	
				"),
				DB::raw("if ( expo_favorites.id is NULL , 0,1) AS isfavorite"),
				//DB::raw("expo_favorites.id AS isfavorite"),
				'expos.id','expos.expo_code','expos.expo_name',
				'expos.expo_open_date','expos.expo_close_date','expos.expo_image_url'
			)
			->leftJoin('expo_favorites', function($q) use($userid) {
			  $q->on('expos.id', '=','expo_favorites.expo_id' )
				  ->where('user_id', $userid);
			})
			->where('expo_name','like','%'.$searchstr.'%')
			->orWhere('expo_description','like','%'.$searchstr.'%')
			->orderByRaw(DB::raw(' 1 asc, rand()'))
			//->inRandomOrder()
			->get();
		return response()->json(['result'=>'OK','data'=> $expo ], 200);
	}
	function searchPrd( Request $request) {
	  $user = Auth::guard()->user();
	  $userid = empty($user->id) ? '-1' : $user->id;
	
	  $searchstr = $request->searchstr;
	  if( $userid > 0 ) $logined = true;
	  else $logined = false;
	  $product = Product::
			select(
				DB::raw("
					case 
						when expos.expo_open_date > CURDATE() then '1'
						when expos.expo_close_date >= CURDATE() then '0'
						ELSE '2' 
					end AS expostatus	
				"),
				'products.id','products.booth_id','products.expo_id','products.prd_title',
				'products.prd_img1',
				'products.prd_org_price','products.prd_price','products.prd_price_percent',
				'products.prd_viewprice',
				'booths.booth_title','expos.expo_code','expos.expo_name',
				\DB::raw("if ( product_favorites.id is NULL , 0,1) AS isfavorite")
			)
			->join( 'expos', function($q) {
				$q->on(  'products.expo_id','=','expos.id' );
				$q->on( "expo_use_yn",'=',\DB::raw("'Y'") );
				//$q->on( "expos.open",'=',\DB::raw("'Y'") );
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
			->where( function ($query) use($searchstr) {
				$query->where('products.prd_title','like','%'.$searchstr.'%')
					->orwhere('products.prd_description','like','%'.$searchstr.'%');
			})
			->orderByRaw(DB::raw('1 asc, booth_id asc'))
			->get();
		return response()->json(['result'=>'OK','data'=> $product ], 200);
	}
	
  public function clearCacheAll(){
	  Cache::forget('topSearhed');
  }
  public function siteinfo() {
    return view('mobile.siteinfo');
  }
  public function notice() {
    return view('mobile.noticeboard');
  }
  public function notilist() {
    $user = Auth::guard()->user();
    $notilist = null;

    if( !empty($user->id) ){
      $notilist = Notification::where('reciever_id', $user->id)->orderBy('id', 'desc')->get();
      Notification::where('reciever_id', $user->id)->update(['noti_read'=>'Y']);
    }
    $routercfg = config('expo.mobile.notiroute');
    return view('mobile.noticelist', compact(['user', 'notilist','routercfg']));
  }
  public function noticount(){
    $user = Auth::guard()->user();

    $noti = new Notification();
    $notiCount = $noti->newCount( $user);
    return $notiCount;
  }
  private function urldn($prefix_dir, $booth_id, $dn_url) {
	  try{
	  $Jsonrpctalk = new Jsonrpctalk('http://13.125.72.95:6800/jsonrpc');
	  $dn = $Jsonrpctalk->addUri([$dn_url],['dir'=>$prefix_dir.'/booth_'.$booth_id]);
	  if( isset($dn['result'])) return $dn['result'];
	  } catch  ( \Exception $e) {
		  return false;
	  }
  }
  public function notitest(Request $request){
	$booth_id = '1';
	$prefix_dir = "/data/download";
	if( $request->dn == 'true'){
	  $gid = $this->urldn($prefix_dir,$booth_id, $request->url ) ;
	}
	try{
		$Jsonrpctalk = new Jsonrpctalk('http://13.125.72.95:6800/jsonrpc');
		$stopped = $Jsonrpctalk->tellStopped(0,1000);

		$res = $stopped['result'];

		foreach ( $res as $files){

			if( $files['errorCode'] =='0'){
				$tmp = array();
				$tmp['gid'] = $files['gid'];
				$tmp['file'] = str_replace($prefix_dir,'',$files['files'][0]['path']) ;
				//$Jsonrpctalk->removeDownloadResult($tmp['gid']);
				dump(  $tmp);
			}
		}
	} catch  ( \Exception $e) {
	  echo "error occured";
	  return false;
	}
  }
  public function boothCreate(Request $request, $expo_code=null,$booth_id=null){
    $user = Auth::guard()->user();
    $company = Company::where('id', $user->company_id)->first();
    if (empty($company->id) || $company->company_level < 100) {
      $msg = "부스를 생성 하실 수 없습니다.";
      return view('mobile.inc.msgtemplate', compact(['msg']));
    }
    if( !empty( $booth_id )){
      $booth = Booth::with('tags')->select('expos.expo_name','expo_code', 'booths.*')
              ->join('expos', 'booths.expo_id','=','expos.id')
              ->where('booths.id', $booth_id)
              ->where( 'booths.company_id', $user->company_id)
              ->first();
      if( empty($booth->id) ) {
        $msg = "부스를 찾을 수 없습니다.";
        return view('mobile.inc.msgtemplate', compact(['msg']));
      }
      $expo_code = $booth->expo_code;
      $expos = Expo::active()->where('id', $booth->expo_id)->get();
    }else {
      $booth = new Booth();
      $expos = Expo::active()->Recruiting()->get();
    }


    return view('mobile.booth_make', compact(['expo_code','expos', 'booth']));
  }
	/* 마케팅 수신동의 내용보기 */
	public function viewmarketing (){
		return view("mobile.agreemarketing");
	}
}
