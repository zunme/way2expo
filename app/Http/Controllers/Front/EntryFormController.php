<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\EntryForm;
use App\Models\Expo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EntryFormController extends Controller
{
    public function showForm(Request $request)
    {
        $user = Auth::guard('web')->user();
        $expo = null;
        $expo_list = [];
        if (empty($user))
            return redirect()->back()->withErrors(['msg' => '로그인이 필요합니다.']);
//            return redirect()->intended('/login');
        if($request->has('id')){
            $isOn = expo::where('id',$request->id)->active()->Recruiting()->exists();
            if(empty($isOn))return redirect()->back()->withErrors(['msg' => '출품신청 가능한 기간이 아닙니다.']);
        }

        if ($request->has('step') || $request->has('expo')) {
            $expo = expo::find($request->expo);
            $today = Carbon::now()->format('Y-m-d');
            if ($expo->expo_recruit_start_date->format('Y-m-d') > $today || $expo->expo_recruit_end_date < Carbon::now())
                return redirect()->back()->withErrors(['msg' => '출품 신청 기간이 아닙니다.']);

        }else{
            $expo_list = expo::active()->Recruiting()->get();
            if ($expo_list->count() < 1)
                return redirect()->back()->withErrors(['msg' => '출품신청 가능한 박람회가 없습니다.']);
        }
        $data = compact(['user','expo_list', 'expo']);
        return view('desktop.entry.index', $data);
    }

    public function create(Request $request)
    {
        $user = Auth::guard('web')->user();

        $messages = [
            'expo_id.*' => "출품신청하실 박람회를 선택해 주세요.",
            'agree_privacy.*' => '개인정보 수집 동의를 확인해주세요',
            'agree_entry.*' => '참가규정을 확인해 주세요',
            'company_name.*' => "기업명을 입력해주세요",
            'company_zip.*' => '기업주소를 입력해주세요',
            'company_address1.*' => '기업주소를 입력해주세요',
            'company_address2.*' => '기업주소를 입력해주세요',
            'biz_no.*' => '사업자등록번호를 입력해주세요',
            'attachment_file.mimes' => '올바른 파일을 올려주세요.',
            'attachment_file.size' => '파일은 10MB이하의 파일을 업로드 할 수 있습니다',
            'attachment_file.*' => '사업자등록증을 첨부해주세요.',
            'ceo_name.*' => '대표자 이름을 입력해주세요',
            'company_url.*' => '올바른 URL을 입력해주세요',
            'manager_name.*' => '출품담당자 이름을 입력해 주세요',
            'manager_email.*' => '출품담당자 이메일을 입력해 주세요',
            'manager_tel.numeric' => '번호만 입력해주세요.',
            'manager_tel.*' => '출품담당자 전화번호를 입력해 주세요',
            'manager_phone.numeric' => '번호만 입력해주세요.',
            'manager_fax.numeric' => '번호만 입력해주세요.',
            'tax_manager_name.*' => '세금계산서 이름을 입력해 주세요',
            'tax_manager_email.*' => '세금계산서 이메일을 입력해 주세요',
            'tax_manager_tel.numeric' => '번호만 입력해주세요.',
            'tax_manager_tel.*' => '세금계산서 전화번호를 입력해 주세요',
            'tax_manager_phone.numeric' => '번호만 입력해주세요.',
            'tax_manager_fax.numeric' => '번호만 입력해주세요.',
        ];
        $validatedData = $request->validate([
            'agree_privacy' => 'bail|required|in:Y',
            'agree_entry' => 'bail|required|in:Y',
            'agree_provided' => 'bail|nullable|in:Y,N',
            'expo_id' => 'bail|required',
            'category_text' => 'bail|required',
            'category_detail_text' => 'bail|nullable',
            'company_name' => 'bail|required',
            'company_name_eng' => 'bail|nullable',
            'company_url' => 'bail|nullable|url',
            'company_zip' => 'bail|required',
            'company_address1' => 'bail|required',
            'company_address2' => 'bail|required',
            'biz_no' => 'bail|required',
            'attachment_file' => 'bail|required|mimes:jpeg,jpg,gif,png,zip,pdf,doc,docx,hwp,csv,txt,xlx,xls,pptx|max:10240',
            'ceo_name' => 'bail|required',
            'ceo_email' => 'bail|nullable|email',
            'manager_name' => 'bail|required',
            'manager_email' => 'bail|required|email',
            'manager_position' => 'bail|nullable',
            'manager_tel' => 'bail|required|numeric',
            'manager_phone' => 'bail|nullable|numeric',
            'manager_fax' => 'bail|nullable|numeric',
            'tax_manager_name' => 'bail|required',
            'tax_manager_email' => 'bail|required|email',
            'tax_manager_position' => 'bail|nullable',
            'tax_manager_tel' => 'bail|required|numeric',
            'tax_manager_phone' => 'bail|nullable|numeric',
            'tax_manager_fax' => 'bail|nullable|numeric',
        ], $messages);
        $validatedData['user_id'] = $user->id;
        $entry = EntryForm::create($validatedData);
        $this->uploadfile($entry, $request->file('attachment_file'));
        return response()->json(array('result' => "OK", "data" => $validatedData, "msg" => "신청이 완료되었습니다."));

    }

    public function getEntryList(){
        $expo_list = expo::select(['id', 'expo_name'])->active()->Recruiting()->get();
        return response()->json(['result' => "OK", "data" => $expo_list],200);
    }

    private function uploadfile($table, $file)
    {

        $storage = Storage::disk('public');
        $path = 'entry/';

        if (!$storage->exists($path)) {
            $storage->makeDirectory($path, 0775, true);
        }

        $file_extension = $file->getClientOriginalExtension();
        $fileName = Carbon::now()->timestamp . '_' . (Str::random(8)) . '.' . $file_extension;
        $storage->put($path . $fileName, \File::get($file));

        $table->attachment_file = $path . $fileName;
        $table->save();
    }
}
