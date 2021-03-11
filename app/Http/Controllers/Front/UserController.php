<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;

/**
 * Class UserController
 * @package App\Http\Controllers\Front
 */
class UserController extends Controller
{
    /**
     * @var bool
     */
    protected $isMobile;

    public function __construct()
    {
        $agent = new \Jenssegers\Agent\Agent;
        $this->isMobile = $agent->isMobile();
    }

    public function showConfirmForm()
    {
        return view('desktop.my.confirm');
    }

    public function showMyInfoForm()
    {
        $user = Auth::guard()->user();
        return view('desktop.my.info', compact('user'));
    }

    public function showRegisterForm()
    {
        return view('desktop.register');
    }

    public function showFindForm()
    {
        return view('desktop.find');
    }
    /**
     * 회원가입
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $messages = [
            'name.*' => '이름(2~20자)을 입력해주세요.',
            'email.unique' => '이미 사용중인 이메일입니다.',
            'email.*' => '이메일을 확인해주세요.',
            'tel.required' => '전화번호를 입력해주세요',
            'tel.*' => '전화번호는 숫자, - 를 포함해 20자 이하로 적어주세요',
            'password.confirmed' => "패스워드가 동일하지 않습니다.",
            'password.*' => "영문, 숫자를 포함한 6~20자 만 허용합니다.",
            'agree_email.*' => "이메일 수신동의를 확인해주세요.",
            'agree_sms.*' => "SMS 수신동의를 확인해주세요.",
        ];

        $validatedData = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => ['required', 'string', new Password, 'confirmed'],
            'name' => 'required|min:2|max:20',
            'tel' => 'required|min:2|regex:/^[0-9-]+$/|max:20',
            'agree_email' => 'required|in:Y,N',
            'agree_sms' => 'required|in:Y,N',
        ], $messages);

        try {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'tel' => $validatedData['tel'],
                'password' => Hash::make($validatedData['password']),
                'agree_email' => $validatedData['agree_email'],
                'agree_sms' => $validatedData['agree_sms']
            ]);

        } catch (\Exception $e) {
            return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e, 'data' => $request]], 422);
        }

        $credentials = $request->only('email', 'password');
        $credentials['user_status'] = 'Y';

        if (Auth::attempt($credentials, true)) {
            $user = Auth::guard()->user();
        }
        if ($request->ajax()) {
            return response()->json(array('result' => "OK", "action" => 'redirect', "msg" => "회원가입 완료.", "url" => url('/')));
        } else return redirect()->intended('/');
    }


    /**
     * 내 정보 수정
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(Request $request)
    {
        $messages = [
            'tel.required' => '전화번호를 입력해주세요',
            'tel.*' => '전화번호는 숫자, - 를 포함해 20자 이하로 적어주세요',
        ];

        $validatedData = $request->validate([
            'tel' => 'required|min:2|regex:/^[0-9-]+$/|max:20',
        ], $messages);

        try {
            $user = Auth::guard('web')->user();
            $user->update($validatedData);
            return response()->json(array('result' => "OK", "msg" => "정보 수정 완료.", "data" => ""));
            //            $up = User::where('id', $user->id )->update( $validatedData );
            //            if( !$up){
            //                return response()->json( array('result'=>"error", "msg"=>"변경된 내용이 없습니다.") );
            //            }
            //            return response()->json( array('result'=>"OK", "data"=>"") );

        } catch (\Exception $e) {
            //            $error = Error::create([
            //                'title' => '저장중 에러가 발생했습니다.',
            //                'status' => '402',
            //            ]);
            //            throw new JsonApiException($error, 402, $ex);
        }
    }

    public function passwordConfirm(Request $request)
    {
        $input = $request->all();
        $messages = [
            'password.*' => "비밀번호를 입력해주세요.",
        ];
        $validatedData = $request->validate([
            'password' => 'required',
        ], $messages);

        if (Hash::check($validatedData['password'], Auth::user()->password)) {
            return redirect()->route('my.info');
        } else {
            return redirect()->back()->with('error', '비밀번호가 일치하지 않습니다.');
        }
    }
}
