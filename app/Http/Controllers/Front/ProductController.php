<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BoothMeta;
use App\Models\Company;
use App\Models\Product;
use App\Models\ProductFavorite;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    protected $isMobile;

    public function __construct()
    {
        $agent = new \Jenssegers\Agent\Agent;
        $this->isMobile = $agent->isMobile();
    }

    /**
     * 전시 상품 리스트
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getProducts(Request $request)
    {
        $user = Auth::guard()->user();
        $userid = (empty($user)) ? -1 : $user->id;
        try {
            $products = Product::select(
                    'products.*'
                )
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
                //                ->join('companies', function ($join) {
                //                    $join->on('booths.company_id', '=', 'companies.id');
                //                    $join->where('companies.company_display_status', 'Y');
                //                    $join->where('companies.company_level', '=', 100);
                //                })
                ->where('products.expo_id', $request->expo_id)
                ->where(function ($q) use ($request) {
                    if (!empty($request->booth_id)) {
                        $q->where('products.booth_id', $request->booth_id);
                    }
                    if (!empty($request->searchstr)) {
                        $q->where('products.prd_title', 'LIKE', "%{$request->searchstr}%");
                    }
                    if (!empty($request->searchid)) {
                        $q->where('products.id', $request->searchid);
                    }
                })
                ->active()
                ->latest()
                ->paginate($request->pageSize, ['*'], 'pageNumber')->withQueryString();

        } catch (\Exception $e) {
            return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e, 'data' => $request->all()]], 422);
        }
        return response()->json(['result' => "OK", "data" => $products]);
    }

    public function detail(Request $request)
    {
        $user = Auth::guard()->user();
        $userid = (empty($user)) ? -1 : $user->id;
        $inputs = $request->validate([
            'product_id' => 'required',
        ], ['product_id.*' => 'A product_id is required']);

        $product = Product::with('prdDescImg')
            ->select(
                DB::raw("if(product_favorites.id is null, 'false' , 'true' ) AS isFavorite"),
                'products.*'
            )
            ->join('expos', function ($join) {
                $join->on('expos.id', '=', 'products.expo_id');
                $join->where('expos.expo_use_yn', 'Y');
                $join->where('expos.expo_open_date', '<=', now());
            })
            ->join('booths', function ($join) {
                $join->on('booths.id', '=', 'products.booth_id');
                $join->where('booths.booth_use_yn', 'Y');
                $join->where('booths.booth_display_yn', 'Y');
            })
            ->leftJoin('product_favorites', function ($q) use ($userid) {
                $q->on('products.id', '=', 'product_favorites.product_id')
                    ->where('user_id', $userid);
            })
            ->where('products.id', $inputs['product_id'])
            ->active()->first();

        if (empty($product)) return response()->json(['result' => "error", "msg" => '해당 상품은 준비중입니다.'], 422);
        return response()->json(['result' => "OK", "data" => $product]);
    }

    /**
     * 전시 상품 관리 리스트
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getMyBoothProducts(Request $request)
    {
        $user = Auth::guard()->user();
        $inputs = $request->validate([
            'booth_id' => 'required',
        ], ['booth_id.*' => 'A booth_id is required']);

        $data = Product::select('products.*')
            ->where('booth_id', $inputs['booth_id'])
            ->where(function ($q) use ($request) {
                $searchstr = (!empty($request->search['value'])) ? $request->search['value'] : '';
                if (!empty($searchstr))
                    $q->where('products.prd_title', 'LIKE', "%{$searchstr}%");
                if ($request->has('copy')) {
                    $q->where('products.prd_use_yn', 'Y');
                    $q->where('products.prd_display_yn', 'Y');
                }
            })
            ->latest();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * 전시 상품 관리 상세
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getMyBoothProductDetail(Request $request)
    {
        $user = Auth::guard()->user();
        if ($user->company_id < 1) return response()->json(['result' => "error", "msg" => '상품 관리 권한이 없습니다.', "link" => "/"], 422);

        $inputs = $request->validate([
            'product_id' => 'required',
        ], ['product_id.*' => 'A product_id is required']);

        $data = Product::with('prdDescImg')
            ->where('id', $inputs['product_id'])->firstOrFail();

        return response()->json(['result' => 'OK', 'data' => $data], 200);
    }

    public function copy(Request $request)
    {
        $user = Auth::guard()->user();
        if ($user->company_id < 1) return response()->json(['result' => "error", "msg" => '상품 관리 권한이 없습니다.', "link" => "/"], 422);

        $inputs = $request->validate([
            'booth_id' => 'bail|required',
            'selected_booth_id' => 'bail|required',
            'id' => 'bail|required|array',
        ], ['id.*' => '선택된 항목이 없습니다.', 'selected_booth_id.*' => '부스를 선택해주세요.', 'booth_id.*' => '저장될 부스 정보가 없습니다.']);

        $products = Product::with('prdDescImg')->whereIn('id', $inputs['id'])->get();

        foreach ($products as $product) {
            try {
                \DB::beginTransaction();
                $new_product = $product->replicate();
                $new_product->booth_id = $inputs['booth_id'];
                $new_product->prd_display_yn = 'N';
                $new_product->save();
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollback();
            }
            $this->copyProductImages($new_product);
        }

        return response()->json(['result' => 'OK', 'msg' => '비공개로 복사되었습니다.'], 200);
    }

    private function copyProductImages($product)
    {
        foreach (['prd_img1', 'prd_img2', 'prd_img3', 'prd_img4'] as $item) {
            if (empty($product[$item])) continue;
            $storage = Storage::disk('public');
            $path = 'prd/' . ($product->id % 100) . '/';
            if ($storage->exists($product[$item])) {
                if ($item == 'prd_img1') {
                    // origin file
                    $product[$item] = Str::of($product[$item])->replace('thumb/', '');
                }

                $origin_fullname = basename($product[$item]);
                $origin_filename = pathinfo($product[$item], PATHINFO_FILENAME);
                $change_filename = Carbon::now()->timestamp . '_' . (Str::random(8));
                $new_path = $path . Str::of($origin_fullname)->replace($origin_filename, $change_filename);
                $storage->copy($product[$item], $new_path);

                if ($item == 'prd_img1') {
                    // 썸네일
                    $thumb_file = 'thumb/' . $product[$item];
                    $origin_fullname = basename($thumb_file);
                    $origin_filename = pathinfo($thumb_file, PATHINFO_FILENAME);
                    $change_filename = Carbon::now()->timestamp . '_' . (Str::random(8));
                    $new_path = 'thumb/' . $path . Str::of($origin_fullname)->replace($origin_filename, $change_filename);
                    if ($storage->exists($thumb_file)) {
                        $storage->copy($product[$item], $new_path);
                    }
                }
                $product->update([$item => $new_path]);
            } else {
                $product->update([$item => null]);
            }
        }
    }

    public function setdisplay(Request $request)
    {
        $user = Auth::guard()->user();
        $inputs = $request->validate([
            'id' => 'required|array',
            'display' => 'required|in:Y,N'
        ], ['id.*' => '선택된 항목이 없습니다.', 'display.*' => 'A display is empty']);

        $products = Product::whereIn('id', $inputs['id'])->get();

        foreach ($products as $product) {
            try {
                \DB::beginTransaction();
                $product->update([
                    'prd_display_yn' => $inputs['display']
                ]);
                $meta = BoothMeta::where('booth_id', $product->booth_id)->first();
                if ($inputs['display'] == 'Y') {
                    $meta->increment('product_count');
                } else {
                    if ($meta->product_count > 0) $meta->decrement('product_count');
                }
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollback();
            }
        }
        return response()->json(['result' => 'OK', 'msg' => '처리되었습니다.'], 200);
    }

    public function removeProduct(Request $request)
    {
        $user = Auth::guard()->user();
        $inputs = $request->validate([
            'id' => 'required|array',
        ], ['id.*' => '선택된 항목이 없습니다.']);

        $products = Product::with('prdDescImg')->whereIn('id', $inputs['id'])->get();

        foreach ($products as $product) {
            if ($product->prdDescImg->count() > 0) {
                foreach ($product->prdDescImg as $desc) {
                    $tmp = $request->merge(['key' => $desc->id]);
                    $this->delProductImage($tmp);
                }
            }
            Storage::disk('public')->deleteDirectory('prd/' . ($product->id % 100) . '/');
            Storage::disk('public')->deleteDirectory('thumb/prd/' . ($product->id % 100) . '/');
            $product->delete();
            $meta = BoothMeta::where('booth_id', $product->booth_id)->first();
            if ($meta->product_count > 0) $meta->decrement('product_count');
        }
        return response()->json(['result' => 'OK', 'msg' => '삭제되었습니다.'], 200);
    }

    public function delProductImage(Request $request)
    {
        $productImage = ProductImage::where('id', $request->key)->first();
        $this->delfile($productImage->url);
        ProductImage::where('id', $request->key)->delete();

        $productImages = ProductImage::where('prd_id', $request->key)->orderBy('sort');
        $productImages->update(['sort' => 0]);

        $sort = 1;
        foreach ($productImages as $item) {
            ProductImage::where('id', $item->id)->update(['sort' => $sort]);
            $sort++;
        }
        return response()->json(['result' => "OK", "msg" => "삭제되었습니다."]);

    }

    public function save(Request $request)
    {
        $user = Auth::guard('web')->user();
        $company = Company::find($user->company_id);
        $isUpdate = ($request->id != null);
        $imagerequire = 'required';
        if ($user->company_id < 1) return response()->json(['result' => "error", "msg" => '상품 관리 권한이 없습니다.', "link" => "/"], 422);
        if (empty($company->id) || $company->company_level < 100) {
            return response()->json(['result' => "error", "msg" => '상품 관리 권한이 없습니다.', 'company' => $company], 422);
        }
        // 수정
        if ($isUpdate) {
            $imagerequire = 'nullable';
            $product = Product::find($request->id);
            if (empty($product)) return response()->json(['errors' => ['parameter' => ['상품 정보를 찾을 수 없습니다.']]], 422);
        }
        $messages = [
            'prd_display_yn.*' => '상품 공개 설정을 해주세요.',
            'prd_title.*' => '상품명을 입력해주세요.',
            'prd_img1.*' => '대표이미지를 등록해주세요.',
            'prd_imgs.max' => '5MB 이하의 파일만 등록가능 합니다.',
            'prd_imgs.*' => '',
            'prd_viewprice.*' => '가격 설정을 확인해주세요.',
            'prd_org_price.*' => '제품원가를 입력해주세요.',
            'prd_price.*' => '판매가격을 입력해주세요.',
            'prd_price_percent.numeric' => '할인율을 확인해주세요.',
            'prd_price_percent.*' => '할인율을 확인해주세요.',
        ];

        $inputs = $request->validate([
            'expo_id' => 'required',
            'booth_id' => 'required',
            'prd_display_yn' => 'required',
            'prd_title' => 'bail|required|min:2|max:25|',
            'prd_img1' => $imagerequire . '|mimes:jpeg,jpg,gif,png|max:5120',
            'prd_img2' => 'nullable|mimes:jpeg,jpg,gif,png|max:5120',
            'prd_img3' => 'nullable|mimes:jpeg,jpg,gif,png|max:5120',
            'prd_img4' => 'nullable|mimes:jpeg,jpg,gif,png|max:5120',
            'prd_viewprice' => 'required|in:Y,N',
            'prd_org_price' => 'required|integer',
            'prd_price' => 'required|integer',
            'prd_price_percent' => 'required|integer',
            'prd_url' => 'nullable',
            'prd_imgs' => 'nullable|array|min:1',
            'prd_imgs.*.*' => 'nullable|mimes:jpeg,jpg,gif,png|max:5120',
        ], $messages);

        unset($inputs['prd_img1'], $inputs['prd_img2'], $inputs['prd_img3'], $inputs['prd_img4'], $inputs['prd_imgs']);
        if ($isUpdate) {
            $product->update($inputs);
            $msg = "수정 되었습니다.";
        } else {
            $product = Product::create($inputs);
            $msg = "추가 되었습니다.";
            BoothMeta::where('booth_id', $inputs['booth_id'])->increment('product_count');
        }
        if ($request->hasFile('prd_img1')) {
            $this->uploadimage($product, $request->file('prd_img1'), 1);
        }
        if ($request->hasFile('prd_img2')) {
            $this->uploadimage($product, $request->file('prd_img2'), 2);
        }
        if ($request->hasFile('prd_img3')) {
            $this->uploadimage($product, $request->file('prd_img3'), 3);
        }
        if ($request->hasFile('prd_img4')) {
            $this->uploadimage($product, $request->file('prd_img4'), 4);
        }
        if ($request->hasFile('prd_imgs')) {
            $this->uploadimage($product, $request->file('prd_imgs'));
        }

        return response()->json(array('result' => "OK", "action" => 'refresh', "msg" => $msg));
    }

    public function changeSort(Request $request)
    {
        $image = ProductImage::where('id', $request->key)->first();

        if (!empty($image->prd_id)) {
            try {
                foreach ($request->keys as $idx => $sort) {
                    $idx = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($idx, ENT_QUOTES));
                    ProductImage::where('id', $idx)->update(['sort' => $sort]);
                }
            } catch (\Exception $e) {
                return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e, 'data' => $request->all()]], 422);
            }
            return response()->json(['result' => 'OK', 'message' => "변경완료"], 200);
        }

    }

    private function uploadimage($product, $file, $index = 0)
    {
        if ($file === null) return null;

        $storage = Storage::disk('public');
        $path = 'prd/' . ($product->id % 100) . '/';;

        if (!$storage->exists($path)) {
            $storage->makeDirectory($path, 0775, true);
        }
        if (is_array($file)) {
            foreach ($file as $item) {

                $image = Image::make($item);
                $image_name = Carbon::now()->timestamp . '_' . (Str::random(8)) . '.' . (mimeToExt($image->mime));
                $storage->put($path . $image_name, $image->stream()->__toString());
                $url = $path . $image_name;

                ProductImage::create([
                    'prd_id' => $product->id,
                    'url' => $url,
                ]);
            }
        } else {
            $col_name = "prd_img" . $index;
            $this->delfile($product->$col_name);

            $image = Image::make($file);
            $image_name = Carbon::now()->timestamp . '_' . (Str::random(8)) . '.' . (mimeToExt($image->mime));
            $storage->put($path . $image_name, $image->stream()->__toString());

            if ($index == 1) {
                $org_file = Str::of($product->prd_img1)->replace('thumb/', '');
                $this->delfile($org_file);

                $image->resize('200', null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $path = 'thumb/' . $path;
                if (!$storage->exists($path)) {
                    $storage->makeDirectory($path, 0775, true);
                }
                $image_name = Carbon::now()->timestamp . '_' . (Str::random(8)) . '.' . (mimeToExt($image->mime));
                $storage->put($path . $image_name, $image->stream()->__toString());
            }

            $url = $path . $image_name;
            $product->update([$col_name => $url]);
        }

    }

    /**
     * 상품 찜
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function favorite(Request $request)
    {
        $user = Auth::guard('web')->user();
        if (empty($user->id)) {
            return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.']]], 401);
        }
        $favorite = ProductFavorite::where([
            'user_id' => $user->id,
        ]);
        $cnt = $favorite->count('*');
        if ($cnt > 50) {
            return response()->json(['result' => "error", "action" => "count", "msg" => '찜은 총 50개까지 등록 가능합니다.'], 422);
        }
        $favorite = $favorite->where([
            'product_id' => $request->product_id,
        ])->first();
        if (empty($favorite->id)) {
            ProductFavorite::create([
                'user_id' => $user->id,
                "product_id" => $request->product_id,
            ]);
            return response()->json(array('result' => "OK", "msg" => "찜에 추가되었습니다", "data" => 'add'), 200);
        } else {
            $favorite->delete();
            return response()->json(array('result' => "OK", "msg" => "찜에 삭제되었습니다", "data" => 'remove'), 200);

        }
    }

    private function delfile($image_path)
    {
        $storage = Storage::disk('public');

        if ($storage->exists($image_path) && $image_path !== null) {
            return $storage->delete($image_path);
        }
        return false;
    }
}
