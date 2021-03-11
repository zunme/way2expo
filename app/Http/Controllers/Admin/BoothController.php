<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booth;
use App\Models\BoothImage;
use App\Models\Company;
use App\Models\Expo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BoothController extends AdminbaseController
{
    /**
     * 부스 관리 화면
     */
    public function index()
    {
        $booth = Booth::where('booth_use_yn', 'Y')->get();
        return view('admin.booth.list', compact(['booth']));
    }

    /**
     * 부스 리스트
     * @param Request $request
     * @return Datatables
     * @throws Exception
     */
    public function list(Request $request)
    {
        $data = Booth::with('companyBooth', 'expoBooth', 'tags', 'boothAttach')->latest()->get();
        $expo_list = Expo::latest()->get();
        $company_list = Company::latest()->get();
        return Datatables::of($data)
            ->filter(function ($instance) use ($request) {
                if ($request->get('display_status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if (Str::contains($row['booth_display_yn'], $request->get('display_status'))) {
                            return true;
                        }
                        return false;
                    });
                }
                if ($request->get('use_status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if (Str::contains($row['booth_use_yn'], $request->get('use_status'))) {
                            return true;
                        }
                        return false;
                    });
                }
                if ($request->get('selected_expo')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if (Str::contains($row['expo_id'], $request->get('selected_expo'))) {
                            return true;
                        }
                        return false;
                    });
                }
            }, true)
            ->with('expo_list', $expo_list)
            ->with('company_list', $company_list)
            ->rawColumns(['action'])
            ->editColumn('user', function ($request) {
                return [
                    'company' => $request->company_name
                ];
            })
            ->editColumn('booth_image_url', function ($request) {
                return Storage::disk('public')->url($request->booth_image_url);
            })
            ->editColumn('booth_mobile_image_url', function ($request) {
                return Storage::disk('public')->url($request->booth_mobile_image_url);
            })
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * 부스 생성/수정
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request)
    {
        $messages = [
            'expo_id.*' => '박람회 선택을 해주세요.',
            'company_id.*' => '기업 선택을 해주세요.',
            'booth_title.*' => '부스 제목을 입력해주세요',
            'booth_intro.*' => '부스 소개를 입력해주세요',
            'selectimg_pc.*' => 'PC용 이미지를 업로드 해 주세요.',
            'selectimg_mobile.*' => '모바일용 이미지를 업로드 해 주세요.',
            'select_attach.*' => '올바른 이미지를 업로드 해 주세요.',
            'booth_mp4_url' => '동영상 URL을 확인해주세요.',
            'booth_youtube_url.*' => '동영상 URL을 확인해주세요.',
            'tags.*.*' => '태그는 2자 이상 최대 20자까지 가능합니다.',
            'booth_use_yn.*' => '사용 유무를 선택해주세요.',
            'booth_display_yn.*' => '노출 유무를 선택해주세요.',
        ];

        $request->validate([
            'expo_id' => 'bail|required',
            'company_id' => 'bail|required',
            'booth_title' => 'bail|required|min:2|max:25|',
            'booth_intro' => 'bail|required|min:2|max:1000',
            'tags.*' => 'nullable|string|distinct|min:2|max:20|',
            'booth_movtype' => 'nullable|in:mp4,youtube',
            'booth_mp4_url' => 'nullable|url',
            'booth_youtube_url' => 'nullable|url',
            'booth_use_yn' => 'required|in:Y,N',
            'booth_display_yn' => 'required|in:Y,N',
            'select_attach.*' => 'nullable|mimes:jpeg,jpg,gif,png|max:20480',
        ], $messages);

        $inputs = $this->removeHtmlTagsOfFields($request->all(), ['_method', '_token'], ['booth_title', 'booth_intro']);
        if (empty($request->id)) {
            $request->validate([
                'selectimg_pc' => 'bail|required',
                'selectimg_mobile' => 'bail|required',
            ], $messages);
            $booth = new Booth();
        } else {
            $booth = Booth::find($request->id);
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
                (new \App\Http\Controllers\Front\BoothController)->saveTags($create->id, $inputs);

            } catch (Exception $e) {
                return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e, 'data' => $inputs]], 422);
            }
            return response()->json(array('result' => "OK", "action" => 'refresh', 'url' => $create->id, "msg" => "추가 되었습니다."));
        } // 수정
        else {
            try {
                if (empty($inputs['booth_movtype']))
                    $inputs['booth_youtube_url'] = $inputs['booth_mp4_url'] = null;
                Booth::find($request->id)->update($inputs);

                $attach_array = $request->select_attach;
                $sortable = json_decode($request->sortable, true);

                $attach_index = 0;
                BoothImage::where('booth_id', $booth->id)->update(['sort' => 0]);
                $boothImageIds = BoothImage::where('booth_id', $booth->id)->pluck('id');

                $sort = 1;
                foreach ($sortable as $item) {
                    // 새로운 파일이면 저장
                    if (array_key_exists('isNewFile', $item)) {
                        $booth->saveDetailImage($booth->id, $attach_array[$attach_index], true);
                        $attach_index++;
                        $sort++;
                    } else {
                        $update_id = $boothImageIds[$boothImageIds->search($item['id'], true)];
                        BoothImage::where('id', $update_id)->update(['sort' => $sort]);
                        $sort++;
                    }
                }
                // 태그
                (new \App\Http\Controllers\Front\BoothController)->saveTags($request->id, $inputs, true);
            } catch (Exception $e) {
                return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e, 'data' => $inputs]], 422);
            }
            return response()->json(array('result' => "OK", "action" => 'refresh', "msg" => "수정 되었습니다."));

        }
    }

    /**
     * 부스 삭제
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request)
    {
        try {
            $booth = Booth::find($request->id);
            if (!empty($booth->company_id))
                $booth->delete();

        } catch (Exception $e) {
            return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e]], 422);
        }
        return response()->json(['result' => "OK", "msg" => "삭제되었습니다."]);
    }

    public function deleteDetailImage(Request $request)
    {
        try {
            $boothImage = BoothImage::where('id',$request->id)->first();
            $this->deleteFile($boothImage->url);
            BoothImage::where('id',$request->id)->delete();

            $boothImages = BoothImage::where('booth_id', $request->id)->orderBy('sort');
            $boothImages->update(['sort' => 0]);

            $sort = 1;
            foreach ($boothImages as $item) {
                BoothImage::where('id', $item->id)->update(['sort' => $sort]);
                $sort++;
            }


        } catch (Exception $e) {
            return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e]], 422);
        }
        return response()->json(['result' => "OK", "msg" => "삭제되었습니다."]);

    }

    /**
     * 파일 제거
     * @param $path
     * @return bool
     */
    private function deleteFile($path)
    {
        $storage = Storage::disk('public');
        if ($storage->exists($path) && $path !== null) {
            return $storage->delete($path);
        }
        return false;
    }

}
