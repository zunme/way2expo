<?php

namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use App\Models\Live;
use App\Models\ProductFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Models\Banner;
use App\Models\Expo;
use App\Models\ExpoFavorite;
use App\Models\ExpoMeta;

use App\Models\Booth;
use App\Models\BoothMeta;
use App\Models\BoothFavorite;
use App\Models\Meeting;

class ExpoController extends Controller
{
    protected $isMobile;

    public function __construct()
    {
        $agent = new \Jenssegers\Agent\Agent;
        $this->isMobile = $agent->isMobile();
    }

    /**
     * 박람회 Index
     * @param Request $request
     * @param null $expo_code
     * @param null $booth_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request, $expo_code = null, $booth_id = null)
    {
        $meta = $this->makeMeta($expo_code, $booth_id);
        $expo = Expo::with('expoMeta')->active()
            ->orderByRaw('case
            when expo_open_date <= NOW() AND expo_close_date >= CURDATE() then 0
            when expo_open_date > NOW() then 1
            else 2 end ASC
            ')
            ->get();
        $expoConfig = config('expo');
        $user = Auth::guard()->user();

        /*mobile */
        if ($this->isMobile || $request->wantsJson()) {
            $mobile_banner_header_category = 'expo_main_header';
            $mobile_banner_footer_category = 'expo_main_header';

            $mobile_banner_header = Banner::select('banners.*')->active()
                ->join('banner_categories', 'banners.banner_category_id', 'banner_categories.id')
                ->where('type', $mobile_banner_header_category)->get();
            $mobile_banner_footer = Banner::select('banners.*')->active()
                ->join('banner_categories', 'banners.banner_category_id', 'banner_categories.id')
                ->where('type', $mobile_banner_footer_category)->get();
            $ispage = $request->route()->getName() == 'expopage' ? true : false;
            $active = 'all';

            if (Expo::active()->progress()->count() > 0) $active = "ing";
            else if (Expo::active()->upcomming()->count() > 0) $active = "ing";
            else 'all';
            if ($ispage) return view('mobile.expo', compact(['meta', 'user', 'ispage', 'expoConfig', 'mobile_banner_header', 'mobile_banner_footer', 'expo', 'active']));
            else if ($request->wantsJson()) return response()->json(['result' => 'OK', 'data' => compact(['ispage', 'expoConfig', 'mobile_banner_header', 'mobile_banner_footer', 'expo', 'active'])], 200);
            else return view('mobile.expoinit', compact(['meta', 'user', 'ispage', 'expoConfig', 'mobile_banner_header', 'mobile_banner_footer', 'expo', 'active']));
        } /* desktop */
        else {
            if (!empty($request->route('expo_code'))) {
                if (!Expo::where('expo_code', $expo_code)->exists()) {
                    return redirect()->intended('/expo');
                }
                return $this->expodetail($request, $expo_code);
            }
            $desktop_banner_header_category = 'pc_expo_main_header';
            $desktop_banner_footer_category = 'pc_expo_main_footer';

            $desktop_banner_header = Banner::select('banners.*')->active()
                ->join('banner_categories', 'banners.banner_category_id', 'banner_categories.id')
                ->where('type', $desktop_banner_header_category)->get();
            $desktop_banner_footer = Banner::select('banners.*')->active()
                ->join('banner_categories', 'banners.banner_category_id', 'banner_categories.id')
                ->where('type', $desktop_banner_footer_category)->get();
            $today = Carbon::now()->format('Y-m-d');

            $favorite = ExpoFavorite::with(['expo' => function ($q) {
                $q->active();
            }])->where('user_id', Auth::id())->latest()->get();

            if ($request->wantsJson()) return response()->json(['result' => 'OK', 'data' => compact(['expoConfig', 'desktop_banner_header', 'desktop_banner_footer', 'expo'])], 200);
            else return view('desktop.expo.index', compact(['meta', 'user', 'expoConfig', 'desktop_banner_header', 'desktop_banner_footer', 'expo', 'today', 'favorite']));
        }

    }

    /**
     * 박람회 상세 화면
     * @param Request $request
     * @param $expo_code
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function expodetail(Request $request, $expo_code)
    {
        $user = Auth::guard()->user();
        $userid = empty($user->id) ? '-1' : $user->id;
        $isLogined = false;
        $myCompanyId = 0;
        $myBooth = null;

        $expoConfig = config('expo');
        /*
        $expo = Expo::with(['booths' => function ($q) {
            $q->with('tags')->display();
        }, 'expoMeta', 'expoAttach' => function ($q) {
            $q->orderBy('sort', 'asc');
        }])->active()->where('expo_code', $expo_code)->first();
        */
        $expo = Expo::with(['expoMeta', 'expoAttach' => function ($q) {
            $q->orderBy('sort', 'asc');
        }])->active()->where('expo_code', $expo_code)->first();

		$expo['booths'] = Booth::select(
					 \DB::raw("if(booth_favorites.id is null, 'false' , 'true' ) AS isfavorite"),
					'booths.*'
				)
				->with(['tags','companyBooth'])->display()
            ->leftJoin('booth_favorites', function ($q) use ($userid) {
                $q->on('booths.id', '=', 'booth_favorites.booth_id')
                    ->where('user_id', $userid);
            })
            ->where('booths.expo_id', $expo->id)
            ->get();
        $meta = $this->makeMeta($expo_code, null);

        visitor()->setVisitor($user)->visit($expo);
        $expo->expoMeta->addViewCount();
        if (empty($user)) {
            $expoFavorite = 0;
        } else {
            $expoFavorite = ExpoFavorite::where('user_id', $user->id)->where('expo_id', $expo->id)->count();
            $isLogined = true;
            $myCompanyId = $user->company_id < 1 ? 0 : $user->company_id;
            if ($myCompanyId > 0) $myBooth = Booth::where([
                'company_id' => $user->company_id,
                'expo_id' => $expo->id,
            ])
                ->where('company_id', '>', '0')
                ->first();
        }
        /*mobile */
        if ($this->isMobile || $request->wantsJson()) {
            $banners = Banner::select('banners.*')->active()
                ->join('banner_categories', 'banners.banner_category_id', 'banner_categories.id')
                ->where('type', 'm_expo_booth_head')->get();
			$data = compact(['expoConfig', 'expo', 'expoFavorite', 'banners', 'isLogined', 'myCompanyId', 'myBooth']);
			if( $request->wantsJson() ) return response()->json(['result' => 'OK', 'data' => $data, 200]);
            return view('mobile.expo_detail', $data );
        } /* desktop */
        else {
            $booth_id = null;
            if (!empty($request->route('booth_id'))) {
                $booth_id = $request->route('booth_id');
                if (!Booth::where('id', $booth_id)->exists()) {
                    return redirect()->intended('/expo/' . $expo_code);
                }
            }
            $meta = $this->makeMeta($expo_code, $booth_id);

            $banners = Banner::select('banners.*', 'banner_categories.type')->active()
                ->join('banner_categories', 'banners.banner_category_id', 'banner_categories.id')
                ->get()
                ->groupBy('type');

            $expos = ExpoFavorite::with(['expo' => function ($q) {
                $q->active();
            }])->where('user_id', Auth::id())->latest()->get();
            $booths = BoothFavorite::with(['booth' => function ($q) {
                $q->active();
            }, 'booth.expoBooth'])->where('user_id', Auth::id())->get();
            $products = ProductFavorite::with(['product' => function ($q) {
                $q->active();
            }])->where('user_id', Auth::id())->latest()->get();
            $favorites = [
                'expo' => $expos,
                'booth' => $booths,
                'product' => $products,
            ];
            $data = compact(['meta', 'expoConfig', 'expo', 'favorites', 'expoFavorite', 'banners', 'isLogined', 'myCompanyId', 'myBooth', 'booth_id', 'user']);
            if ($request->ajax()) {
                return $data;
            }
            return view('desktop.expo.view', $data);
        }
    }

    /**
     * 박람회 즐겨찾기
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function favoritetoggle(Request $request)
    {
        $user = Auth::guard()->user();
        if (empty($user->id)) {
            return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.']]], 401);
        }
        $favorite = ExpoFavorite::where('user_id', $user->id)->where('expo_id', $request->expo_id)->first();
        if (empty($favorite)) {
            $favorite = ExpoFavorite::create([
                'user_id' => $user->id,
                'expo_id' => $request->expo_id,
            ]);
            ExpoMeta::where('expo_id', $request->expo_id)->increment('favorite_count');
            return response()->json(array('result' => "OK", "msg" => "즐겨찾기에 추가되었습니다", "data" => 'add'), 200);
        } else {
            $favorite->delete();
            $meta = ExpoMeta::where('expo_id', $request->expo_id)->first();
            if ($meta->favorite_count > 0) $meta->decrement('favorite_count');
            return response()->json(array('result' => "OK", "msg" => "즐겨찾기가 삭제되었습니다", "data" => 'remove'), 200);
        }
    }

    /**
     * 박람회 부스 화면
     * @param Request $request
     * @param $expo_code
     * @param $booth_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function booth(Request $request, $expo_code, $booth_id)
    {
        \Blade::setEchoFormat('nl2br(e(%s))');
        $user = Auth::guard()->user();
        //$request->visitor()->setVisitor($user)->visit();
        $booth = Booth::with(['companyBooth', 'boothAttach', 'expoBooth', 'tags'])
            ->where('id', $booth_id)->first();
		if(  $booth->expoBooth->expo_use_yn != 'Y'){
			return response()->json(['errors' => ['parameter' => ['부스를 찾을 수 없습니다.']]], 422);
		}
        if( $booth->expoBooth->open != 'Y' && $booth->expoBooth->expo_open_date->format('Ymd') >= Carbon::now()->format('Ymd') ) {
			return response()->json(['errors' => ['parameter' => ['준비중인 부스 입니다(1).']]], 422);
		}
        //if( $booth->expoBooth->expo_recruit_end_date->format('Ymd') >= Carbon::now()->format('Ymd')) return response()->json(['errors' => ['parameter' => ['준비중인 부스 입니다(2).']]], 422);
//        if( $booth->companyBooth->company_display_status != 'Y') return response()->json(['errors' => ['parameter' => ['준비중인 부스 입니다.']]], 422);
//        if( $booth->companyBooth->company_level < 100) return response()->json(['errors' => ['parameter' => ['준비중인 부스 입니다.']]], 422);

        visitor()->setVisitor($user)->visit($booth);
        if (empty($booth->id)) {
            $data = compact(['booth']);
        } else {
            $expo = Expo::where('id', $booth->expo_id)->first();
            $boothMeta = BoothMeta::where('booth_id', $booth->id)->first();
            if (!empty($boothMeta->booth_id)) {
                $boothMeta->visitor_count = $boothMeta->visitor_count + 1;
                $boothMeta->save();
            }
            $dates = $this->getDatesFromRange($expo->expo_open_date->format('Y-m-d'), $expo->expo_close_date->format('Y-m-d'));

            $today = Carbon::now()->format('Y-m-d');
            if ($expo->expo_open_date->format('Y-m-d') > $today) $startdate = $expo->expo_open_date->format('Y-m-d');
            else if ($expo->expo_close_date->format('Y-m-d') >= $today) $startdate = $today;
            else $startdate = $expo->expo_close_date->format('Y-m-d');

            $meeting = new Meeting();
            $timetables = $meeting->getlist($booth->id, $startdate);

            if (!empty($user->id)) {
                $favorite = BoothFavorite::where([
                    'user_id' => $user->id,
                    'booth_id' => $request->booth_id,
                ])->first();
            } else {
                $favorite = null;
            }

            $live = Live::where('booth_id', $booth->id)->active()->first();

            $data = compact(['user', 'expo', 'booth', 'favorite', 'dates', 'startdate', 'timetables', 'live']);

        }
        if ($this->isMobile) {
            return view('mobile.expobooth', $data);
        } else {
            if ($request->ajax())
                return $data;
        }
    }

    /**
     * 박람회 Meta
     * @param $expo_code
     * @param $booth_id
     * @return object
     */
    private function makeMeta($expo_code, $booth_id)
    {
        $meta = (object)[
            'title' => 'Way2EXPO',
            'description' => 'Way2EXPO 온라인 박람회',
            'image' => \URL::to('/way2expo.jpg'),
            'url' => \URL::current(),
        ];

        if ($booth_id) {
            $data = Booth::where('id', $booth_id)->first();
            if (!empty($data->id)) {
                $meta->title = $data->booth_title;
                $meta->description = empty($data->booth_intro) ? 'Way2EXPO 온라인 박람회 부스' : $data->booth_intro;
                $meta->image = \URL::to('/storage/' . $data->booth_image_url);
            }
        } else if ($expo_code) {
            $data = Expo::where('expo_code', $expo_code)->first();
            if (!empty($data->id)) {
                $meta->title = $data->expo_name;
                $meta->description = empty($data->booth_intro) ? $data->expo_name : $data->expo_description;
                $meta->image = \URL::to('/storage/' . $data->expo_image_url);
            }
        }
        return ($meta);
    }

    function boothlist(Request $request, $expo_id)
    {
        $user = Auth::guard()->user();
        $userid = empty($user->id) ? '-1' : $user->id;
        $booths = Booth::select(
            \DB::raw("if(booth_favorites.id is null, 'false' , 'true' ) AS isfavorite"),
            'booths.*'
        )
            ->with(['companyBooth'])->display()
            ->leftJoin('booth_favorites', function ($q) use ($userid) {
                $q->on('booths.id', '=', 'booth_favorites.booth_id')
                    ->where('user_id', $userid);
            })
            ->where('booths.expo_id', $expo_id)
            ->orderBy('booths.created_at', 'asc')
            ->paginate(4);
        $expo = Expo::select('expo_code')->where('id', $expo_id)->first();

        return response()->json(['result' => 'OK', 'data' => $booths, 'expo_code' => $expo->expo_code], 200);
    }

    /**
     * CSRF 갱신
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function refresh(Request $request)
    {
        session()->regenerate();
        return csrf_token();
        return response()->json(['result' => 'OK', 'data' => csrf_token()], 200);
    }

    /**
     * 날짜 Array
     * @param $start
     * @param $end
     * @param string $format
     * @return array
     */
    private function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {
        $arr = CarbonPeriod::create($start, $end)->toArray();
        $ret = [];
        foreach ($arr as $date) {
            $ret[] = $date->format($format);
        }
        return $ret;
    }
}
