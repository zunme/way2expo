<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;
use Illuminate\Http\{RedirectResponse, Request, Response};
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialUser;
use Illuminate\Support\Facades\Http;

class MobileSocialController extends Controller
{

	//https://murflim.run.goorm.io/mobile/social/kakao
 	protected function guard()
    {
        return Auth::guard('web');
    }
	
    public function execute(Request $request)
    {
		config(['services.kakao.redirect'=>env('KAKAO_REDIRECT_MOBILE_URI')]);
		/*
		$kakao = config('services.kakao');
		$config = new \SocialiteProviders\Manager\Config(
			$kakao['client_id'], $kakao['client_secret'],"https://murflim.run.goorm.io/mobile/social/kakao", ["guzzle"=>[]]);	
		
		//dump( Socialite::driver('kakao') );
		//dd( Socialite::driver('kakao')->setConfig($config) );		
		*/
        if (! $request->has('code')) {
			return Socialite::driver('kakao')->redirect();
			//return Socialite::driver('kakao')->setConfig($config)->redirect();
        }
        return $this->handleProviderCallback($request);
    }
	public function disconnectKakao( Request $request ){
		//Socialite::driver('kakao')->removeAccessTokenAdmin($user->kakao_id);
		//$res = Socialite::driver('kakao')->removeAccessTokenResponse( $usertoken );	
		$user =  Auth::user();
		if( !empty($user->kakao_id) ) {
			$admin = env('KAKAO_ADMIN');
			$response = Http::withOptions([
				'debug' => false,
			])->withHeaders([
				'Accept' => 'application/json',
				'Authorization' => "KakaoAK {$admin}",
			])->asForm()->post('https://kapi.kakao.com/v1/user/unlink', [
				'target_id_type'=>'user_id',
				'target_id'=>$user->kakao_id
			]);
			if( $response->successful() ){
				$user->kakao_id = '0';
				$user->save();
				return response()->json(['result'=>'OK'], 200);
			}else {
				/*
				$user->kakao_id = '0';
				$user->save();
				Socialite::driver('kakao')->removeAccessTokenAdmin($user->kakao_id);
				*/
				return response()->json(['result'=>'ERROR'], 500);
			};
		}
		return response()->json(['result'=>'ERROR'], 404);
	}

    protected function handleProviderCallback(Request $request)
    {
		
        $socialUser = Socialite::driver('kakao')->user();
		
		$authuser = Auth::user();
		if( !empty($authuser->id) ){
			$authuser->kakao_id = $socialUser->getId();
			$authuser->save();
			return redirect('/m/myinfo');
		}
		if( $user = User::where('kakao_id', $socialUser->getId())->first() ) {
            $this->guard()->login($user, true);
			return redirect('/');
        }
		$request->session()->put('kakaoid', $socialUser->getId());
		return redirect('/m/snslogin');
		//else return view("mobile.sample");
    }

}