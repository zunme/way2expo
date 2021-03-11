<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'userid';
    }

    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */

    public function login(Request $request)
    {
        if (session()->has('url.intended')) {
            $redirect_url = session()->get('url.intended');
            session()->forget('url.intended');
        } else {
            $redirect_url = $this->redirectTo;
        }

        $kakaoConnect = $request->session()->get('kakaoConnect');
		if( !empty($kakaoConnect) ){
		  $request->session()->keep(['kakaoConnect']);
        }
          
        $messages = [
            'email.*' => "올바른 이메일을 입력해주세요.",
            'password.*' => "비밀번호를 입력해주세요.",
        ];

        $validator = $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ], $messages);

        $input = $request->all();

        $remember_me = $request->has('remember_me');

        $credentials = $request->only('email', 'password');
        $credentials['user_status'] = 'Y';

        if ( Auth::attempt($credentials, $remember_me)) {
            if( $kakaoConnect ){
				$user = Auth::user();
				$user->kakao_id = $kakaoConnect;
				$user->save();
            }
            
            if ($request->ajax()) {
                return response()->json(array('result' => "OK", "action" => 'redirect', "url" => url()->previous()));
            } else {
                return redirect()->to($redirect_url);
            }
        } else {
            $user = User::where('email', $input['email'])->first();
            if (empty($user)) {
                return response()->json(['errors' => ['email' => ['사용자를 찾을 수 없습니다.']]], 422);
            } else {
                return response()->json(['errors' => ['email' => ['이메일과 비밀번호를 확인해주세요.']]], 422);
            }
        }
    }

    public function showLoginForm(Request $request)
    {
        $agent = new \Jenssegers\Agent\Agent;
        $isMobile = $agent->isMobile();

        $url = $request->input('url');
        if ($url) {
            $data = ['intended' => $url];
            session(['url' => $data]);
        }
        if (!session()->has('url.intended')) {
            session()->put('url.intended', url()->previous());
        }
        if ($isMobile) {
            if ($request->ajax()) {
                return view('mobile.inc.login');
            }
            return redirect('/m/login');
            //return view('mobile.login');
        }
        return view('desktop.login');
    }
}
