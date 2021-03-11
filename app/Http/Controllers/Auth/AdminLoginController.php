<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class LoginController
 *
 * @package App\Http\Controllers\Auth
 */
class AdminLoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest:admin')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function login(Request $request)
    {

        $this->validator($request);
        
        $remember_me = $request->has('remember_me');
        $credentials = $request->only('email', 'password');

        if(Auth::guard('admin')
            ->attempt( $credentials, $remember_me)
            ) {
            return redirect()
                ->intended(route('admin.home'))
                ->with('status', 'You are Logged in as Admin!');
        }
        return $this->loginFailed();
    }
    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'email'    => 'required|email|exists:admins|min:5|max:191',
            'password' => 'required|string|min:4|max:255',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists' => '....',
        ];

        //validate the request.
        $request->validate($rules, $messages);
    }
    private function loginFailed()
    {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Login failed, please try again!');
    }
    public function showLoginForm(Request $request)
    {
        if(Admin::where('email', 'admin@way2expo.com')->count() < 1) {
            Admin::create(
                [
                'email' => 'admin@way2expo.com',
                'name' => 'admin@way2expo.com',
                'password' => bcrypt('12341234')
                ]
            );
        }
        return view('admin.login');
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()
            ->route('admin.login')
            ->with('status', 'Admin has been logged out!');
    }
}
