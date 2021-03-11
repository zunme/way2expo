<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CompanyController extends Controller
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

    public function showMyCompany()
    {
        $user = Auth::guard()->user();
        $company = Company::find($user->company_id);
        $company->company_download_url = Storage::disk('public')->url($company->company_attachment_file_url1);
        return view('desktop.my.company', compact('user', 'company'));
    }

    /**
     * 회사 정보
     * @param $company_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function detail($company_id)
    {
        $company = Company::with("Responsibility")
            ->leftJoin('users', 'companies.company_master_user_id', "=", "users.id")
            ->select('companies.*', 'users.name', 'users.email')
            ->where('companies.id', $company_id)->first();

        return $company;
    }

    /**
     * 회사 정보 수정
     */
    public function edit(Request $request)
    {
        $company = Company::find($request->id);
        if (empty($company)) return response()->json(['errors' => ['parameter' => ['기업 정보를 찾을 수 없습니다.']]], 422);
        //if ($company->company_level < 100) return response()->json(['result' => "error", "msg" => '권한이 없습니다.', "link" => "/"], 422);

        $messages = [
            'company_email.*' => "올바른 이메일을 입력해주세요.",
            'company_url.*' => "올바른 URL을 입력해주세요.",
            'company_tel1.*' => "올바른 번호를 입력해주세요.",
        ];
        /* TODO 전화번호 변경 여부 */
        $validatedData = $request->validate([
            //'company_tel1' => 'required|min:2|regex:/^[0-9-]+$/|max:20',
            'company_email' => 'nullable|email',
            'company_address1' => 'nullable|string|min:2|max:50',
            'company_address2' => 'nullable|string|min:2|max:50',
            'company_url' => 'nullable|url|min:4|max:255',
            'company_info1' => 'nullable|string',
            'company_info2' => 'nullable|string',
        ], $messages);

        $inputs = $this->removeHtmlTagsOfFields($validatedData, ['_method', '_token'], ['company_info1', 'company_info2', 'company_address1', 'company_address2']);

        if ($request->hasFile('select_file')) {
            $this->deleteFile($company->company_attachment_file_url1);
            $inputs['company_attachment_file_url1'] = $this->uploadFile($request, $request->file('select_file'));
            $inputs['company_attachment_file_name1'] = $request->file('select_file')->getClientOriginalName();
            unset($inputs['select_file']);
        }

        if ($request->hasFile('select_img')) {
            $this->deleteFile($company->company_image_url);
            $inputs['company_image_url'] = $this->uploadImage($request, $request->file('select_img'));
            unset($inputs['select_img']);
        }

        try {
            $update = Company::where('id', $request->id)->update($inputs);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e]], 422);
        }

        return response()->json(['result' => 'OK', "msg" => "기업 정보가 변경 되었습니다.", 'data' => $update], 200);
    }

    /**
     * 기업 이미지 업로드
     * @param Request $request
     * @param UploadedFile|null $file
     * @return null
     */
    public function uploadImage(Request $request, UploadedFile $file = null)
    {
        if ($file === null) return null;
        $messages = [
            'select_img.max' => '이미지를 2MB 이하로 올려주세요.',
            'select_img.*' => '올바른 이미지를 올려주세요.',
        ];

        $request->validate([
            'select_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $messages);

        $storage = Storage::disk('public');
        $path = 'company/';

        $image = Image::make($file);
        $image_name = $this->generateFileName($file);
        if (!$storage->exists($path)) {
            $storage->makeDirectory($path, 0775, true);
        }
        $storage->put($path . $image_name, $image->stream()->__toString());
        return $path . $image_name;
    }

    /**
     * 기업 파일 업로드
     * @param Request $request
     * @param UploadedFile|null $file
     * @return null
     */
    public function uploadFile(Request $request, UploadedFile $file = null)
    {
        if ($file === null) return null;
        $messages = [
            'select_file.max' => '파일을 10MB 이하로 올려주세요.',
            'select_file.*' => '올바른 파일을 올려주세요.',
        ];

        $request->validate([
            'select_file' => 'required|mimes:jpeg,png,jpg,gif,svg,doc,docx,pdf,zip,xlsx,xls,ppt,pptx|max:10240',
        ], $messages);

        $storage = Storage::disk('public');
        $path = 'company/';
        if (!$storage->exists($path)) {
            $storage->makeDirectory($path, 0775, true);
        }
        $file_name = $this->generateFileName($file);

        $storage->putFileAs(
            $path, $request->file('select_file'), $file_name
        );
        $url = $path . $file_name;

        return $url;
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

    private function generateFileName(UploadedFile $file)
    {
        $ext = $file->getClientOriginalExtension();
        return Carbon::now()->format('ymdhis') . '_' . Str::random(9) . "." . $ext;
    }

    /**
     * 파일 제거
     * @param $path
     * @return bool
     */
    public function deleteFile($path)
    {
        $storage = Storage::disk('public');
        if ($storage->exists($path) && $path !== null) {
            return $storage->delete($path);
        }
        return false;
    }
}
