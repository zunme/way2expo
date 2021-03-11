<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Booth;
use App\Models\BoothFavorite;
use App\Models\BoothImage;
use App\Models\BoothMeta;
use App\Models\BoothTag;
use App\Models\Company;
use App\Models\Expo;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * Class BoothController
 * @package App\Http\Controllers\Front
 */
class BoothController extends Controller
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

    public function index(Request $request)
    {
        $user = Auth::guard()->user();
        /*mobile */
        if ($this->isMobile) {
            return view('mobile.my.booth', compact(['user']));
            /* desktop */
        } else {
            return view('desktop.my.booth.index', compact(['user']));
        }
    }

    public function showMakeForm()
    {
        $user = Auth::guard()->user();
        //        $isPossibleToBooth = Booth::where(['company_id' => 1, 'expo_id' => 5])->doesntExist();
        //        $isPossibleToExpo = Expo::find(4)->Recruiting()->exists();
        //        $isPossible = ($isPossibleToBooth && $isPossibleToExpo);
        return view('desktop.my.booth.make', compact(['user']));
    }

    /**
     * 부스 목록
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function list(Request $request)
    {
        $data = Booth::with('companyBooth', 'expoBooth')->latest()->get();
        return Booth::display()->get();
    }

    /**
     * 부스 생성/수정
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request)
    {
        $user = Auth::guard('web')->user();
        $company = Company::find($user->company_id);
        if ($user->company_id < 1) return response()->json(['result' => "error", "msg" => '부스 생성 권한이 없습니다.', "link" => "/"], 422);
        if (empty($company->id) || $company->company_level < 100) {
            return response()->json(['result' => "error", "msg" => '부스 생성을 하실 수 없습니다.', 'company' => $company], 422);
        }

        // 수정
        if (!empty($request->id)) {
            $booth = Booth::where(['id' => $request->id, 'booth_use_yn' => 'Y'])->first();
            if (empty($booth->id)) {
                return response()->json(['errors' => ['parameter' => ['부스정보를 찾을 수 없습니다.']]], 422);
            } else if ($user->company_id != $booth->company_id) {
                return response()->json(['errors' => ['parameter' => ['부스 수정 권한이 없습니다.']]], 422);
            }
        }

        $messages = [
            'expo_id.*' => '박람회 선택을 해주세요.',
            'booth_title.*' => '부스 제목을 입력해주세요',
            'booth_intro.*' => '부스 소개를 입력해주세요',
            'selectimg_pc.max' => '5MB 이하 파일만 업로드 가능합니다.',
            'selectimg_mobile.max' => '5MB 이하 파일만 업로드 가능합니다.',
            'selectimg_pc.*' => 'PC용 이미지를 업로드 해 주세요.',
            'selectimg_mobile.*' => '모바일용 이미지를 업로드 해 주세요.',
            'select_attach.*' => '올바른 이미지를 업로드 해 주세요.',
            'booth_mp4_url' => '동영상 URL을 확인해주세요.',
            'booth_youtube_url.*' => '동영상 URL을 확인해주세요.',
            'tags.*.distinct' => '태그는 중복 입력할 수 없습니다.',
            'tags.*.*' => '태그는 2자 이상 최대 5자까지 가능합니다.',
            'booth_display_yn.*' => '노출 유무를 선택해주세요.',
        ];

        // 생성
        if (empty($request->id)) {
            $request->validate([
                'expo_id' => [
                    'bail', 'required',
                    function ($attribute, $value, $fail) {
                        $recruit = Expo::where(['id' => $value])->Recruiting()->exists();
                        if ($recruit === false) {
                            $fail('박람회 모집 기간이 아닙니다.');
                        }
                    },
                ],
            ], $messages);
        }

        $validatedData = $request->validate([
            'expo_id' => 'bail|required',
            'booth_title' => 'bail|required|min:2|max:25|',
            'booth_intro' => 'bail|required|min:2|max:1000',
            'tags.*' => 'nullable|string|distinct|min:2|max:20|',
            'booth_movtype' => 'nullable|in:mp4,youtube',
            'booth_mp4_url' => 'nullable|url',
            'booth_youtube_url' => 'nullable|url',
            'booth_display_yn' => 'sometimes|in:Y,N',
            'select_attach.*' => 'nullable|mimes:jpeg,jpg,gif,png|max:20480',
        ], $messages);
        $inputs = $this->removeHtmlTagsOfFields($request->all(), ['_method', '_token'], ['booth_title', 'booth_intro']);
        $inputs['company_id'] = $company->id;

        if (empty($request->id)) {
            $request->validate([
                'selectimg_pc' => 'required|mimes:jpeg,jpg,gif,png|max:5120',
                'selectimg_mobile' => 'required|mimes:jpeg,jpg,gif,png|max:5120',
            ], $messages);
            $booth = new Booth();
        }

        if ($request->hasFile('selectimg_pc')) {
            $inputs['booth_image_url'] = $booth->saveImage($inputs, $request->file('selectimg_pc'));
        }
        if ($request->hasFile('selectimg_mobile')) {
            $inputs['booth_mobile_image_url'] = $booth->saveImage($inputs, $request->file('selectimg_mobile'));
        }
        unset($inputs['selectimg_pc']);
        unset($inputs['selectimg_mobile']);
        unset($inputs['select_attach']);

        // 생성
        if (empty($request->id)) {
            try {
                $create = $booth->create($inputs);
                $create->makeMeta();

                if ($request->hasFile('select_attach')) {
                    $files = $request->file('select_attach');
                    foreach ($files as $file) {
                        $uploaded = $booth->saveDetailImage($create->id, $file);
                    }
                }

                // 태그
                $this->saveTags($create->id, $inputs);

            } catch (\Exception $e) {
                return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e, 'data' => $inputs]], 422);
            }
            return response()->json(array('result' => "OK", "action" => 'refresh', 'url' => $create->id, "msg" => "추가 되었습니다."));
        } // 수정
        else {
            try {
                if (empty($inputs['booth_movtype']))
                    $inputs['booth_youtube_url'] = $inputs['booth_mp4_url'] = null;
                $booth->find($request->id)->update($inputs);
                $attach_array = $request->select_attach;
                $sortable = json_decode($request->sortable, true);
                $attach_index = 0;
                BoothImage::where('booth_id', $booth->id)->update(['sort' => 0]);
                $boothImageIds = BoothImage::where('booth_id', $booth->id)->pluck('id');

                if ($request->hasFile('select_attach')) {
                    $files = $request->file('select_attach');
                    foreach ($files as $file) {
                        $uploaded = $booth->saveDetailImage($request->id, $file);
                    }
                }


                // 태그
                $this->saveTags($request->id, $inputs, true);
            } catch (\Exception $e) {
                return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e, 'data' => $inputs]], 422);
            }
            return response()->json(array('result' => "OK", "action" => 'refresh', "msg" => "수정 되었습니다."));

        }
    }

    public function deleteDetailBoothImage(Request $request)
    {
        $boothImage = BoothImage::where('id', $request->key)->first();
        $storage = Storage::disk('public');
        if ($storage->exists($boothImage->url) && $boothImage->url !== null) {
            $storage->delete($boothImage->url);
        }
        BoothImage::where('id', $request->key)->delete();

        $boothImages = BoothImage::where('booth_id', $request->key)->orderBy('sort');
        $boothImages->update(['sort' => 0]);

        $sort = 1;
        foreach ($boothImages as $item) {
            BoothImage::where('id', $item->id)->update(['sort' => $sort]);
            $sort++;
        }
        return response()->json(['result' => "OK", "msg" => "삭제되었습니다."]);

    }

    public function changeSortDetailBoothImage(Request $request)
    {
        $image = BoothImage::where('id', $request->key)->first();

        if( !empty( $image->booth_id) ){
            try{
                foreach( $request->keys as $idx=>$sort){
                    $idx= preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($idx, ENT_QUOTES));
                    BoothImage::where('id', $idx)->update(['sort'=>$sort]);
                }
            }catch ( \Exception $e) {
                return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e'=>$e,'data'=>$request->all() ]], 422);
            }
            return response()->json(['result'=>'OK','message'=>"변경완료"], 200);
        }
    }

    /**
     * 내 부스 화면 (참여박람회)
     * @param Request $request
     * @return Application|Factory|View
     */
    public function myBooths(Request $request)
    {
        $user = Auth::guard()->user();
        $company = Company::find($user->company_id);
        $booths = Booth::where(['company_id' => $user->company_id])->with('tags', 'expoBooth', 'boothMeta', 'boothAttach')->get();

        foreach ($booths as $booth) {
            $booth->booth_image_url = (!empty($booth->booth_image_url)) ? $booth->getDesktopImageUrl() : null;
            $booth->booth_mobile_image_url = (!empty($booth->booth_mobile_image_url)) ? $booth->getMobileImageUrl() : null;
        }

        $expo_list = Expo::latest()->get();
        $expo_recruiting_list = Expo::Recruiting()->latest()->get();
        foreach ($expo_list as $expo) {
            $expo->recruiting = false;
            if ($expo_recruiting_list->contains('id', $expo->id)) {
                $expo->recruiting = true;
            }
        }
        /*mobile */
        if ($this->isMobile) {
            return view('mobile.my.booth', compact(['user']));
            /* desktop */
        } else {
            return view('desktop.my.booth.index', compact(['user', 'booths', 'expo_list', 'expo_recruiting_list']));
        }
    }

    /**
     * 부스 즐겨찾기
     * @param Request $request
     * @return JsonResponse
     */
    public function favorite(Request $request)
    {
        $user = Auth::guard('web')->user();
        if (empty($user->id)) {
            return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.']]], 401);
        }
        $favorite = BoothFavorite::where([
            'user_id' => $user->id,
        ]);
        $cnt = $favorite->count('*');
        if ($cnt > 24) {
            return response()->json(['result' => "error", "action" => "count", "msg" => '즐겨찾기는 총 24개까지 등록 가능합니다.'], 422);
        }
        $favorite = $favorite->where([
            'booth_id' => $request->booth_id,
        ])->first();
        if (empty($favorite->id)) {
            try {
                BoothFavorite::create([
                    'user_id' => $user->id,
                    "booth_id" => $request->booth_id,
                ]);
                BoothMeta::where('booth_id', $request->booth_id)->increment('favorite_count');

            } catch (Exception $e) {
                return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e]], 422);
            }
            return response()->json(array('result' => "OK", "msg" => "즐겨찾기에 추가되었습니다", "data" => 'add'));
        } else {
            try {
                $favorite->delete();
                $meta = BoothMeta::where('booth_id', $request->booth_id)->first();
                if ($meta->favorite_count > 0) $meta->decrement('favorite_count');

            } catch (Exception $e) {
                return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e]], 422);
            }
            return response()->json(array('result' => "OK", "msg" => "즐겨찾기가 삭제되었습니다", "data" => 'remove'));

        }
    }


    /**
     * HTML
     * @param array $inputs
     * @param array $excepts
     * @param array $htmlarr
     * @return array
     */
    public function removeHtmlTagsOfFields(array $inputs, array $excepts = array(), array $htmlarr = array())
    {
        foreach ($inputs as $index => $in) {
            if (is_array($inputs[$index])) {
                $inputs[$index] = $this->removeHtmlTagsOfFields($in, $excepts, $htmlarr);
            } else if ((!in_array($index, $excepts) && !in_array($index, $htmlarr) && $in != '') || is_numeric($index)) {
                $inputs[$index] = htmlentities(strip_tags($in), ENT_QUOTES, 'UTF-8');
            } else if (in_array($index, $htmlarr) && $in != '') {
                $inputs[$index] = htmlentities($in, ENT_QUOTES, 'UTF-8');
            }
        }
        return $inputs;
    }

    /**
     * 부스 태그 저장
     * @param $booth_id
     * @param $inputs
     * @param bool $on_edit
     * @return JsonResponse
     */
    public function saveTags($booth_id, $inputs, $on_edit = false)
    {
        if (count(array_filter($inputs['tags'])) >= 0) {
            if ($on_edit){
                BoothTag::where('booth_id', $booth_id)->delete();
            }

            foreach ($inputs['tags'] as $name) {
                try {
                    if(!empty($name))
                        BoothTag::create(['booth_id' => $booth_id, 'name' => $name]);
                } catch (Exception $e) {
                    return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e]], 422);
                }
            }
        }
    }
}
