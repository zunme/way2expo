<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Events\NotiEvent;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\Expo;
use App\Models\Booth;
use App\Models\Company;
use App\Models\UserCard;
use App\Models\UserCardExchage;
use App\Models\ExpoFavorite;
use App\Models\BoothFavorite;
use App\Models\Category;

use Carbon\Carbon;
use Validator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MobileMyController extends Controller
{
	
	function menu() {
		$user = Auth::user();
		return view("mobile.inc.menu", compact(['user']));
	}
  /**
    * 회사소개서 다운
  **/
  function companyfiledn( Request $request ){
    $booth = Company::where('id', $request->id)->first();
    if( $request->file == 1 && !empty($booth->company_attachment_file_url1) ) {
      return Storage::disk('public')
        ->download($booth->company_attachment_file_url1, $booth->company_attachment_file_name1 );
    }
    if( $request->file == 2 && !empty($booth->company_attachment_file_url2) ) {
      return Storage::disk('public')
        ->download($booth->company_attachment_file_url2, $booth->company_attachment_file_name2 );
    }
  }
  /**
    * 내정보
  **/
  function checkpwd(Request $request ){
	  $user = Auth::user();
	  $password = $request->input('password_check');
	  if (!\Hash::check($password, $user->password)) {
        return response()->json(['success'=>false, 'message' => 'Login Fail, pls check password']);
     }
        return response()->json(['success'=>true,'message'=>'success', 'data' => $user]);
	  
  }
  function disconnectKakao(Request $request ){
	 $user = Auth::user();
	 $user->kakao_id = '0';
	 $user->update();
	 return response()->json(['result'=>'OK'], 200);
  }
  function myinfo( Request $request ){
    $user = User::with(['card', 'company','meta'])->find(Auth::id());
	  
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
    return view('mobile.myinfo'
				, compact(['user','areas','category','subcategory'
					,'ages','purpose','industry','company_position'
		]));
  }
function mycardinfo( Request $request ){
    $user = User::with(['card', 'company'])->find(Auth::id());
    return view('mobile.mycard', compact(['user']));
  }
	
  function myCardSave( Request $request ){
    $messages = [
      'card_name.*' => '명함 이름을 확인해주세요',
      'card_tel.*' => '명함 전화번호를 확인해주세요',
      'card_email.*' => '명함 이메일을 확인해주세요',
      'card_company.*' => '명함 회사이름을 확인해주세요',
      'card_dept.*' => '명함 부서를 확인해주세요',
      'card_position.*' => '명함 직책(급)을 확인해주세요',
      'card_homepage.*' => '명함 홈페이지를 확인해주세요',
      'card_addr.*' => '명함 주소를 확인해주세요',
    ];

    $data = $request->validate([
      'card_name' => 'bail|required',
      'card_tel' => 'bail|required|min:2|max:20|regex:/^[0-9-]+$/',
      'card_email' => 'bail|required|email|max:20',
      'card_company' => 'bail|nullable|min:2|max:40|string',
      'card_dept' => 'bail|nullable|min:2|max:20|string',
      'card_position' => 'bail|nullable|min:2|max:20|string',
      'card_homepage' => 'bail|nullable|min:2|max:100|url',
      'card_addr' => 'bail|nullable|min:2|max:100|string',
     ],$messages);

     $card = UserCard::where('user_id',Auth::id())->first();
     if( empty($card->user_id)){
       $data['user_id'] = Auth::id();
       $card = UserCard::create($data);
     }else $card->update($data);
     return response()->json(['result'=>'OK','data'=>$data], 200);;
  }
  /**
    * 참가한 엑스포
  **/
  function myexpo( Request $request ){
    $user = Auth::user();
    if ($user->company_id < 1){
      $booths  = null;
    }else {
	  $sub = \DB::table('meetings')
		->select( 
			\DB::raw("count(1) as meeting_cnt"),
		  "booth_id as subid"
		)
		  ->where('company_id', $user->company_id)
		  ->groupBy('booth_id');
		
      $booths = Booth::active()->with(['expoBooth','boothMeta'])
		  ->select ( 'booths.*', 
					\DB::raw("ifnull( meeting_cnt, 0 ) as meeting_cnt")
				   )
		  	->leftJoinSub($sub, 'subq', function ($join) {
				$join->on('booths.id', '=', 'subq.subid');
			})
        ->where('company_id', $user->company_id )->latest()->get();
    }
    $today = Carbon::now()->format('Y-m-d');

    return view('mobile.myexpo', compact(['booths', 'today']));
  }
  /*
  명함 업로드
  */
  function cardsave( Request $request){
    $user = Auth::guard()->user();
    if (empty($user->id)) {
        return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.']]], 401);
    }
    $user = User::where('id', Auth::id())->firstOrFail();
    if( !empty($request->file('fnpreviefile')) && in_array($request->cardtype,['business_card_front','business_card_back']) ) {
      $user->saveImage( $request->cardtype , $request->file('fnpreviefile') );
      return response()->json(['result'=>'OK','data'=> url(Storage::disk('public')->url($user->{$request->cardtype})) ], 200);

    }
    else return response()->json(['errors' => ['parameter' => ['나중에 시도해주세요.'] ]], 422);
  }
  function cardExchange( Request $request, $company_id=null){
	 /* company_id => booth->id 로 변경 */
	$booth = Booth::display()
		->with('companyBooth')
		->select ( 'booths.*', 'expo_open_date')
		->join('expos','booths.expo_id','=','expos.id')
		->where('booths.id', $company_id)
		->where('expos.expo_use_yn', 'Y')
		->first();
	$opendate = new Carbon($booth->expo_open_date);

	if( empty($booth->id) ){
		return view('mobile.inc.msgtemplate', ["msg"=>"잘못된 경로입니다."] );
	}else if( Carbon::today() < $opendate->format('Y-m-d') ){
		$msg =  "비즈니스 문의는 ".$opendate->format('Y-m-d')." 부터 가능합니다.";
		return view('mobile.inc.msgtemplate', ["msg"=>$msg] );
	}
	$company_id = $booth->company_id;
	  
    $user = User::with(['card', 'company'])->find(Auth::id());
    return view('mobile.cardexchange', compact(['user','company_id','booth']));
  }
  function cardExchangeSave( Request $request){
    $user = Auth::guard()->user();
    if (empty($user->id)) {
        return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.']]], 401);
    }
    $messages = [
      'booth_id.*' => '부스 정보가 없습니다.',
	  'agree.*' => '개인정보제3자 제공동의를동의해주세요',
      'message.*' => '소개 및 인사말을 입력 해 주세요',
    ];

    $data = $request->validate([
      'booth_id' => 'bail|required|numeric',
	  'agree' => 'bail|required|in:Y',
      'message' => 'bail|required|min:2|string',
     ],$messages);
	$booth = Booth::where('id',$request->booth_id )->first();
	if( empty($booth->id) ){
		return response()->json(['errors' => ['parameter' => ['부스정보를 찾을 수 없습니다..'] ]], 422);
	}
	$data['company_id'] = $booth->company_id;
	  
    //$company = Company::where('id', $request->company_id)->firstOrFail();
	  
    $cnt = UserCardExchage::
            where(['user_id'=> Auth::id(),'booth_id'=>$request->booth_id])
            ->count();
    if( $cnt > 0 ){
      return response()->json(['errors' => ['parameter' => ['이미 비즈니스문의를전송하였습니다.'] ]], 422);
    }
	
    $data['user_id'] = Auth::id();
    $excnhange = UserCardExchage::create( $data );

    $msg = [
      "icon"=>"contact_page",
      "title"=>"비즈니스문의",
      "target"=>"card.receive",
      "content"=> "새로운 비즈니스 문의.",
    ];
    $company_users = User::where('company_id', $booth->company_id )->get();
    foreach( $company_users as $company_user ){
      $noti = [
        'reciever_id'=>$company_user->id,
        'sender_id'=>$user->id,
        'data'=>$msg
      ];
      Notification::create($noti);
    }

    return response()->json(['result'=>'OK','data'=>null], 200);
  }
  function cardRecieveList( Request $request){
	  
	  $user = Auth::guard()->user();
		if (empty($user->id)) {
			return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.']]], 401);
		}	  
	  $data = UserCardExchage::select('*')
		  ->where('user_id', $user->id)
	  	  ->paginate(10);
	  return response()->json([ 'result' => 'OK', 'data' => $data ], 200);
  }
  function cardReceiveList( Request $request){
	  $user = Auth::guard()->user();
		if (empty($user->id)) {
			return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.']]], 401);
		}
	  $qry = UserCardExchage::select(
		  		'user_card_exchages.id',
		  		'user_card_exchages.message', 'user_card_exchages.read_yn',
		  		'users.business_card_front','users.business_card_back',
		  		'user_cards.user_id',
		  		'user_cards.card_name', 'user_cards.card_tel',
		  		'user_cards.card_email',
		  		'user_card_exchages.created_at',
		  		'booths.booth_title'
	  			)
		  	->join( 'users', 'user_card_exchages.user_id','=','users.id')
		    ->join( 'booths', 'user_card_exchages.booth_id','=','booths.id')
		  	->leftJoin ( 'user_cards', 'user_card_exchages.user_id','=','user_cards.user_id' )
		  	->where('user_card_exchages.company_id', $user->company_id)
		  	->where('user_card_exchages.use_yn_company', 'Y')
	  		;
	  if( $request->item > 0 ){
		  $qry->where('user_card_exchages.id','<',$request->item);
	  }
	  $data = $qry->orderBy('id','desc')->limit(10)->get();
	  //$data = $qry->orderBy('id','desc')->paginate(10);
	  
	  return response()->json([ 'result' => 'OK', 'data' => ['data'=>$data] ], 200);	  
  }
  function cardSendList( Request $request){
	  $user = Auth::guard()->user();
		if (empty($user->id)) {
			return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.']]], 401);
		}
	  $data = UserCardExchage::select(
		  'user_card_exchages.id',
		  'user_card_exchages.created_at',
		  'expo_name','booth_title',
		  'user_card_exchages.message'
		  
	  		)
		  ->join('booths','user_card_exchages.booth_id','=','booths.id' )
		  ->join('expos','booths.expo_id','=','expos.id' )
		  ->where('user_card_exchages.user_id', $user->id)
		  ->orderBy('id','desc')
		  ->paginate(10);
	  return response()->json([ 'result' => 'OK', 'data' => $data ], 200);
  }
  function cardview( Request $request, $card_id){
	  $user = Auth::guard()->user();
		if (empty($user->id)) {
			return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.']]], 401);
		}
	  
	  $card = UserCardExchage::where('id', $card_id)
		 -> where('company_id', $user->company_id)->first();
		if (empty($card->id)) {
			return response()->json(['errors' => ['auth' => ['권한이 없습니다.']]], 403);
		}
	  $card->read_yn = 'Y';$card->save();
	  $user = User::with(['card', 'company'])->find($card->user_id);
	  return view("mobile.mycardexchangeview", compact(['card','user']));
  }
  function cardremove( Request $request){
	  $user = Auth::guard()->user();
		if (empty($user->id)) {
			return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.']]], 401);
		}
	  $res = UserCardExchage::
		  	whereIn('id',$request->business_card_del )
		  	->where('company_id', $user->company_id )
		  	->update(['use_yn_company'=>'N']);
	  return response()->json([ 'result' => 'OK', 'data'=>$res ], 200);
  }
  function historyBooth( Request $request){
    return view( 'mobile.historybooth');
  }
  function historyExpo( Request $request){
    return view( 'mobile.historyexpo');
  }
  function favoritelist( Request $request){
    $expos = ExpoFavorite::with(['expo'=>function($q){
      $q->active();
    }])->where('user_id', Auth::id() )->latest()->get();
    $booths = BoothFavorite::with(['booth'=>function($q){
      $q->active();
    },'booth.expoBooth'])->where('user_id', Auth::id() )->latest()->get();
	if($request->option=='json') return response()->json([ 'result' => 'OK', 'expos'=>$expos, 'booths'=>$booths], 200);
    return view( 'mobile.myfavorite', compact('expos','booths'));
  }
	function favoritelistExpo(  Request $request){
		$expos = 
			Expo::active()->select('expos.id','expos.expo_code','expos.expo_name' ,'expos.expo_image_url', 'expos.expo_open_date', 'expos.expo_close_date')
				->join('expo_favorites', 'expos.id','=','expo_favorites.expo_id')
				->where('expo_favorites.user_id', Auth::id() )->get();
				
		return response()->json([ 'result' => 'OK', 'data'=>$expos ], 200);
	}
	function favoritelistBooth(  Request $request){
		$booths = Booth::active()
			->select('booths.id', 'booths.booth_title',
					 'booths.booth_mobile_image_url', 'booths.booth_intro',
					 'expos.expo_code','expos.expo_name' ,'expos.expo_image_url' )
			->join('booth_favorites', 'booths.id','=','booth_favorites.booth_id')
			->join ('expos', 'booths.expo_id','=','expos.id')
			->where('booth_favorites.user_id', Auth::id() )->get();
			
		return response()->json([ 'result' => 'OK', 'data'=>$booths ], 200);
	}
  function mycompany( Request $request){
    $user = Auth::user();
    $company = Company::where('id', $user->company_id)->first();
    if( $user->company_id < 1 ){
      return view('mobile.inc.notfound');
    }
    return view('mobile.mycompany', compact(['company']));
  }
  function cardexchangelist( Request $request){
    /*
     $user = Auth::user();
    $zoom = new \MacsiDigital\Zoom\Support\Entry;
    $zoom_api_user = new \MacsiDigital\Zoom\User($zoom);
    $zoomuser = $zoom_api_user->find('develop@way2expo.com');
    if ( empty( $zoomuser) ){
      $zoomuser = $zoom_api_user->create([
          'first_name' => '',
          'last_name' => '',
          'email' => 'develop@way2expo.com',
          'password' => '12341234'
      ]); 
    }
    $meeting = $zoom->meeting()->make([
      'topic' => 'booth',
      'type' => 2,
      'start_time' => new Carbon('2020-11-12 14:10:00'), // best to use a Carbon instance here.
      'password'=>'12341234',
    ]);
    $meeting->settings()->make([
      'join_before_host' => true,
      'approval_type' => 2,
      'registration_type' => 1,
      'enforce_login' => false,
      'waiting_room' => false,
    ]);
    $res = $zoomuser->meetings()->save($meeting);
    dd($res);
    */
    $user = Auth::user();
    $card = UserCardExchage::with('cardSender','companyInfo')->where('user_id', $user->id)->get();
    //dd($card);
    return view('mobile.mycardexchange', compact(['user']));
  }
	function favoriteproductlist() {
		return view( 'mobile.myfavoriteproduct');
	}
	public function edituserinfo(Request $request)
    {
        $messages = [
            'tel.required' => '전화번호를 입력해주세요',
            'tel.*' => '전화번호는 숫자, - 를 포함해 20자 이하로 적어주세요',
        ];

        $validatedData = $request->validate([
			'age'=>'nullable|string',
			'area'=>'nullable|string',
        ], $messages);

        try {
            $user = Auth::guard('web')->user();
            
			$user->update($validatedData);
			UserMeta::where('user_id', $user->id)->update($request->except(['tel']));
			
            return response()->json(array('result' => "OK", "msg" => "정보 수정 완료.", "data" => ""));

        } catch (\Exception $e) {
            //            throw new JsonApiException($error, 402, $ex);
			return response()->json([ 'result' => 'ERROR' ], 500);
       }
    }
	public function additionaluserinfo( Request $request) {
		UserMeta::where('user_id', Auth::id() )->update( $request->all() );
			
            return response()->json(array('result' => "OK", "msg" => "정보 수정 완료.", "data" => ""));
	}
}
