<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use Validator;
use Storage;
use Carbon\Carbon;

use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

use App\Models\User;

class UserController extends BaseController
{
  public function index(Request $request) {
    return view('admin.user');
  }
  public function userlist(Request $request) {
      $data = User::select('*')->with('card');
      $data->get();
      return Datatables::of($data)
              ->addIndexColumn()
              ->with(['today'=>Carbon::now()->format('Y-m-d')])
              ->rawColumns(['action'])
              ->make(true);
  }
  public function usercreate( Request $request ){
      /* admin validate 생략 */
    if( $request->id ){
      $user = User::where('id', $request->id)->firstOrFail();
      $user->update( $request->all() );
    }else {
      $data = $request->all();
      if( $request->password ) $data['password'] = \Hash::make($data['password']);
        $user = User::create( $data );
    }
    if( !empty($request->file('card_front')) ) {
      $user->saveImage( 'business_card_front', $request->file('card_front') );
    }
    if( !empty($request->file('card_back')) ) {
      $user->saveImage( 'business_card_back', $request->file('card_back') );
    }
    return response()->json(['result'=>'OK','data'=>$user], 200);

  }
  protected function userguard() {
      return Auth::guard('web');
  }

  public function userlogin(Request $request){
    $input = $request->all();
    $this->userguard()->logout();
    $user = User::where('email', $input['email'])->first();
    Auth::login($user);
    return \Redirect::to('/');

  }

}
