<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Booth;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SampleController extends Controller
{
    public function index(Request $request){
        $user = Auth::guard()->user();
        $company = null;
        $booth = null;
        if (Auth::check()) {
            $company = Company::find( $user->company_id );
            $booth = Booth::with('tags')->where( ['expo_id'=>1,'company_id'=>$user->company_id, 'booth_use_yn'=>'Y'])->first();
        }
        return view('desktop.sample.form',compact(['user','company','booth']));
    }
}
