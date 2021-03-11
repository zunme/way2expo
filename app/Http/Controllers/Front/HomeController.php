<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Expo;
use App\Models\Banner;
use App\Models\Notification;
use App\Models\vod;
use App\Models\SiteConfig;

use App\Models\Posts;
use App\Models\PostsFile;
use Illuminate\Support\Facades\DB;
use Storage;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{
    /**
     * @var bool
     */
    private $isMobile;

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $agent = new \Jenssegers\Agent\Agent;
        $this->isMobile = $agent->isMobile();
    }

    /**
     * @return Application|Factory|View
     */
    public function index(Request $request){
      $expoConfig = config('expo');
      $expo = Expo::with('expoMeta')->active()->get();
      if ($this->isMobile) {
        $user = Auth::guard()->user();

        $noti = new Notification();
        $notiCount = $noti->newCount( $user);

        $header_image = Banner::select('banners.*')->active()
            ->join('banner_categories', 'banners.banner_category_id', 'banner_categories.id')
            ->where('type', 'image_mobile_index' )->first();

        $mobile_banner_header_category = 'mobile_main_header';
        $mobile_banner_header = Banner::select('banners.*')->active()
            ->join('banner_categories', 'banners.banner_category_id', 'banner_categories.id')
            ->where('type', $mobile_banner_header_category )->get();
        $expos = Expo::active()->progress()->get();
        $recruting = Expo::active()->recruiting()->get();
		$vods = vod::where('use_yn','Y')->orderBy('sortno')->get();
		//$banner_area = SiteConfig::getconfig('m_banner_booth_area');
		  $site_config = SiteConfig::loaddata();

        if ( $request->page =='true') $page ='mobile.home';
        else $page = 'mobile.index';
        return view($page, compact(['expoConfig','user','notiCount','header_image','mobile_banner_header','expos', 'recruting','vods','site_config']) );
      }else{
          $uri = $request->path();
          if ($uri == 'notice') {
              return view('desktop.notice');
          }
          return view('desktop.home');
      }
    }

    public function getBanners(Request $request)
    {
        $inputs = $request->validate([
            'type' => 'required|array',
            'config' => 'nullable|array',
        ], ['type.*' => 'A category type is required']);

        $banners = Banner::select('banners.*','banner_categories.type')->active()
            ->join('banner_categories', 'banners.banner_category_id', 'banner_categories.id')
            ->whereIn('banner_categories.type',$inputs['type'])
            ->get()
            ->keyBy(function($item){
                return $item->type;
            });

        $bannerConfig = [
            'between'=> empty( $inputs['config']['between'] ) ? '0' : $inputs['config']['between'] ,
            'perView'=> empty( $inputs['config']['perView'] ) ? '1' : $inputs['config']['perView'] ,
            'arrow'=> empty( $inputs['config']['arrow'] ) || $inputs['config']['arrow'] != 'on' ? 'off' : 'on' ,
            'indicators'=> empty( $inputs['config']['indicators'] ) || $inputs['config']['indicators'] != 'on' ? 'off' : 'on' ,
            'class' => empty( $inputs['config']['class'] ) ? '' : $inputs['config']['class'] ,
            'auto' => empty( $inputs['config']['auto'] ) || $inputs['config']['auto']==true ? 'swiper-auto-play' : '' ,
            'loop' => empty( $inputs['config']['loop'] ) || $inputs['config']['auto']== true ? 'true' : 'false' ,
            'center' => empty( $inputs['config']['center'] ) || $inputs['config']['center']== true ? 'true' : 'false' ,
            'page' => empty( $inputs['config']['page'] ) || $inputs['config']['page']== true ? true : false ,
        ];

        return response()->json(['result' => "OK", "data" => $banners,'config'=>$bannerConfig]);
    }

	/* 모바일 공지사항 */
	public function notice(Request $request){

		return view('mobile.noticeboard');
	}
	public function postlist(Request $request){

        if ($this->isMobile) {
            if( $request->last_idx < 1){
                $noti = Posts::where('use_yn','Y')->where('noti','Y')
                    ->orderBy('id','desc')->get();
            }else $noti = [];

            $list = Posts::where('use_yn','Y')->where('noti','N');
            if( $request->last_idx > 0 ){
                $list->where('id','<', $request->last_idx);
            }
            $data = $list->orderBy('id','desc')->limit(20)->get();
            return response()->json(['result'=>'OK','noti'=>$noti,'data'=>$data ], 200);
        }else{
            DB::statement(DB::raw('set @rownum=0'));
            $data = Posts::select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'posts.*')
                ->where('use_yn', 'Y')
                ->where('noti', 'N')
                ->latest()
                ->get();

            return Datatables::of($data)
                ->with('noti', function () use ($data) {
                    return Posts::with('attachFiles')
                        ->where('noti', 'Y')
                        ->where('use_yn', 'Y')
                        ->limit(5)
                        ->latest()->get();
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
	}
  function filedn( Request $request ){
    $attach = PostsFile::where('id', $request->id)->first();
    if( !empty($attach->org_name) ) {
      return Storage::disk('public')
        ->download($attach->url, $attach->org_name );
    }
  }
	public function postview(Request $request, $noticeid){
		$post = Posts::with(['attachFiles'])->where('id', $noticeid)->where('use_yn','Y')->first();
    if ($this->isMobile) {
      return view('mobile.postview', compact(['post']));
    }
		else return response()->json(['result' => 'OK', 'data' => $post], 200);
          
	}
	/* / 모바일 공지사항 */
}
