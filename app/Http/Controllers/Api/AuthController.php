<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponser;

    public function login(Request $request)
    {
        $messages = [
            'email.*' => "올바른 이메일을 입력해주세요.",
            'password.*' => "비밀번호를 입력해주세요.",
        ];

        $attr = $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ], $messages);
      
        if (!Auth::attempt($attr)) {
            return $this->error('로그인에 실패하였습니다.', 401);
        }

        return $this->success([
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->success([ ]);
    }
}