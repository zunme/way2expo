<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;

use Illuminate\Contracts\Foundation\Application;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Banner;
use App\Models\Expo;
use App\Models\Booth;
use App\Models\vod;


class MobileController extends Controller {
  use ApiResponser;
  
  function bannerListType( $bannertype ){
    $banner = Banner::select('banners.*')->active()
            ->join('banner_categories', 'banners.banner_category_id', 'banner_categories.id')
            ->where('type', $bannertype )->get();
    return $this->success($banner);
  }
  function homedata(Request $request){
    $vods = vod::where('use_yn','Y')->orderBy('sortno')->get();
    $expos = Expo::active()->progress()->get();
    $recruting = Expo::active()->recruiting()->get();
    return $this->success( compact(['vods', 'expos', 'recruting']));
  }
  function boothSimpleInfo(Request $request){
    $data = Booth::find($request->id)->first();
    return $this->success( $data );
  }
  function expoInfo(Request $request, $expocode){
      $expo = Expo::with(['expoMeta', 'expoAttach' => function ($q) {
      $q->orderBy('sort', 'asc');
      }])->active()->where('expo_code', $expo_code)->first();
      return $this->success( $data );
  }
}