<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Booth;
use App\Models\BoothFavorite;
use App\Models\Expo;
use App\Models\ExpoFavorite;
use App\Models\Product;
use App\Models\ProductFavorite;
use App\Models\SearchLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index()
    {
        return view('desktop.search.index');
    }

    public function result(Request $request)
    {
        $user = Auth::guard('web')->user();
        $userid = (empty($user) ? null : $user->id);

        $request->merge(['keyword' => $request->route('keyword')]);
        $inputs = $request->validate(['keyword' => 'required'], ['keyword.*' => '검색어를 입력하세요.']);
        $searchstr = $inputs['keyword'];
        SearchLog::create(['user_id' => $userid, 'search' => $searchstr]);

        $expo = Expo::select([
            'expos.id',
            'expos.expo_code',
            'expos.expo_name',
            'expos.expo_open_date',
            'expos.expo_close_date',
            'expos.expo_image_url'
        ])
            ->where('expo_use_yn', 'Y')
            ->where(function ($q) use ($searchstr) {
                $q->orWhere('expo_name', 'LIKE', "%{$searchstr}%");
                $q->orWhere('expo_description', 'LIKE', "%{$searchstr}%");
            })
            ->orderByRaw('case
            when expo_open_date <= NOW() AND expo_close_date >= CURDATE() then 0
            when expo_open_date > NOW() then 1
            else 2 end ASC
            ')
            ->get();

        $booth = Booth::with('tags:booth_id,name')
            ->select([
                'sub.expo_name',
                'sub.expo_code',
                'sub.expo_open_date',
                'sub.expo_close_date',
                'booths.id',
                'booths.booth_title',
                'booths.booth_image_url',
            ])
            ->fromSub(function ($q) {
                $q->from('booths')
                    ->select([
                        'booths.id',
                        'expos.expo_name',
                        'expos.expo_code',
                        'expos.expo_open_date',
                        'expos.expo_close_date'
                    ])
                    ->join('expos', function ($join) {
                        $join->on('expos.id', '=', 'booths.expo_id');
                        $join->where('expos.expo_use_yn', 'Y');
                        $join->where(function ($q) {
                            $q->orWhere('expos.expo_open_date', '<=', Carbon::now());
                            $q->orWhere('expos.open', 'Y');
                        });
                    })
                    ->where(['booths.booth_use_yn' => 'Y', 'booths.booth_display_yn' => 'Y']);
            }, 'sub')
            ->join('booths', function ($join) {
                $join->on('booths.id', '=', 'sub.id');
            })
            ->where(function ($q) use ($searchstr) {
                $q->orWhere('booths.booth_title', 'LIKE', "%{$searchstr}%");
                $q->orWhere('booths.booth_intro', 'LIKE', "%{$searchstr}%");
                $q->orWhereHas('tags', function ($q) use ($searchstr) {
                    $q->where('name', 'like', "%{$searchstr}%");
                });
            })
            ->orderByRaw(DB::raw('
            case
            when sub.expo_open_date <= NOW() AND sub.expo_close_date >= CURDATE() then 0
            when sub.expo_open_date > NOW() then 1
            else 2 end ASC
            '))->get();

        $product = Product::select([
            'products.expo_id',
            'products.booth_id',
            'products.id',
            'products.prd_title',
            'products.prd_img1',
            'products.prd_org_price',
            'products.prd_price',
            'products.prd_price_percent',
            'products.prd_viewprice',
            'expos.expo_code',
        ])
            ->join('expos', function ($join) {
                $join->on('expos.id', '=', 'products.expo_id');
                $join->where('expos.expo_use_yn', 'Y');
                $join->where('expos.expo_open_date', '<=', Carbon::now());
            })
            ->join('booths', function ($join) {
                $join->on('booths.id', '=', 'products.booth_id');
                $join->where('booths.booth_use_yn', 'Y');
                $join->where('booths.booth_display_yn', 'Y');
            })
//            ->join('companies', function ($join) {
//                $join->on('booths.company_id', '=', 'companies.id');
//                $join->where('companies.company_display_status', 'Y');
//                $join->where('companies.company_level', '=', 100);
//            })
            ->where('products.prd_use_yn', 'Y')
            ->where('products.prd_display_yn', 'Y')
            ->where(function ($q) use ($searchstr) {
                $q->orWhere('products.prd_title', 'LIKE', "%{$searchstr}%");
                $q->orWhere('products.prd_description', 'LIKE', "%{$searchstr}%");
            })->get();
        //            ->orderBy('products.created_at', 'DESC')
        $searchData = [
            'expo' => $expo,
            'booth' => $booth->shuffle(),
            'product' => $product->shuffle(),
        ];

        $expos = ExpoFavorite::with(['expo' => function ($q) {
            $q->active();
        }])->where('user_id', Auth::id())->latest()->get();

        $booths = BoothFavorite::with(['booth' => function ($q) {
            $q->active();
        }, 'booth.expoBooth'])->where('user_id', Auth::id())->latest()->get();

        $products = ProductFavorite::with(['product' => function ($q) {
            $q->active();
        }])->where('user_id', Auth::id())->latest()->get();

        $today = Carbon::now();

        $topKeywords = $this->getTopSearchKeyword();

        $searchData['favorites'] = [
            'expo' => $expos,
            'booth' => $booths,
            'product' => $products,
        ];

        $data = compact([
            'searchData', 'today', 'topKeywords'
        ]);
        return response()->json(['result' => "OK", "data" => $data], 200);
    }

    public function getTopSearchKeyword()
    {
        $data = Cache::remember('topSearhed', 60 * 24, function () {
            $startOfWeek = Carbon::now()->startOfWeek()->startOfDay();
            $endOfWeek = Carbon::now()->endOfWeek()->endOfDay();
            return SearchLog::selectRaw('count(*) as cnt, search')
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->groupBy('search')
                //                ->having('cnt', '>', 5)
                ->orderBy('cnt', 'desc')
                ->limit(5)
                ->get();
        });
        return $data;
    }
}
