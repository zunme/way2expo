<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContactController extends Controller
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

    public function index()
    {
        $user = Auth::guard()->user();
        if ($this->isMobile) {
            return view('mobile.contact');
        } else {
            return view('desktop.contact');
        }
    }

    public function save(Request $request)
    {
        $user = Auth::guard()->user();
        $messages = [
            'company_name.*' => '기업명/이름을 입력해주세요.',
            'company_tel.*' => '기업 전화번호를 입력해주세요.',
            'email.*' => '이메일을 입력해주세요.',
            'title.*' => '제목을 입력해주세요.',
            'message.*' => '문의 내용을 입력해주세요.',
            'agree.*' => '개인정보 수집 및 이용동의를 확인해주세요.',
            'select_file.max' => '10MB 이하의 파일만 등록가능 합니다.',
            'select_file.*' => '파일 형식을 확인해주세요.',
        ];

        $validatedData = $request->validate([
            'company_name' => 'bail|required',
            'company_tel' => 'bail|required|min:2|regex:/^[0-9-]+$/|max:20',
            'tel' => 'bail|nullable|min:2|regex:/^[0-9-]+$/|max:20',
            'email' => 'bail|required|email',
            'title' => 'bail|required|min:2|max:20',
            'message' => 'bail|required|min:2|max:1000',
            'agree' => 'bail|required|in:Y',
            'select_file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,doc,docx,pdf,zip,xlsx,xls,ppt,pptx|max:10240',
        ], $messages);

        $inputs = $this->removeHtmlTagsOfFields($validatedData, ['_method', '_token'], ['company_tel', 'tel', 'email']);
        $inputs['user_id'] = Auth::id();

        if ($request->hasFile('select_file')) {
            $inputs['attachment_file_url'] = $this->saveFile($request->file('select_file'));
        }
        Contact::create($inputs);
        return response()->json(['result' => 'OK'], 200);
    }

    private function saveFile($file)
    {
        $storage = Storage::disk('public');
        $path = 'contact/';

        if (!$storage->exists($path)) {
            $storage->makeDirectory($path, 0775, true); //creates directory
        }
        $filename = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $fileNameToStore = \Illuminate\Support\Carbon::now()->format('ymdhis') . '_' . Str::random(9) . "." . $ext;
        $storage->putFileAs($path, $file, $fileNameToStore);
        $url = $path . $fileNameToStore;

        return $url;
    }

    private function removeHtmlTagsOfFields(array $inputs, array $excepts = array(), array $htmlarr = array())
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

}
