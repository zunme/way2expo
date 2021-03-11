<?php

namespace App\Modules;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Company;

class companyModule
{
    protected $user, $is_user;
    protected $admin, $is_admin;
    protected $company;

    /* $grantType
      A: 어드민,
      M: 마스터,
      c: 담당자,
      or false
    */
    protected $grantType;

    /*
    * @param int $companyid
    * @param Model::User  $user
    * @param Model::admin $admin
    */
    public function __construct($companyid, $user, $admin = null)
    {
        $this->company = Company::where('id', $companyid)->first();
        $this->user = $user;
        $this->admin = $admin;
        $this->is_admin = false;
        $this->is_user = false;

        if (empty($admin)) {
            if (empty($user)) {
                ;
            } else {
                $this->is_user = true;
            }
        } else {
            $this->is_admin = true;
        }
        $this->grantType = $this->checkType();
    }



    /* 기본정보 생성 */
    /* 회사 이미지는 name = select_file 로 받음 */
    public function create()
    {
        $request = Request::capture();
        if ($this->grantType === false || $this->grantType == 'C') {
            if (Request::ajax()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            } else {
                return ['error' => 'Unauthenticated.'];
            }
        }
        $data = $this->validator($request->all())->validate();
        $data = $this->removeHtmlTagsOfFields($data, []);

        if (empty($data['company_level']) || !$this->is_admin) {
            $data['company_level'] = 90;
        }

        $data['company_image_url'] = $this->uploadimage($request);

        if($request->hasFile('file1')){
            $file1 = $this->saveFile($request, 'file1', $type = 'file');
            $data['company_attachment_file_url1'] = $file1['url'];
            $data['company_attachment_file_name1'] = $file1['fileName'];
        }

        try {
            $create = Company::create($data);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e]], 422);
        }
        $company = $this->getInfo($create->id);

        return response()->json(['result' => "OK", "msg" => "기본 정보가 추가 되었습니다.", "data" => $company]);
    }
    /* END 기본정보 생성 */

    /* 기본정보 수정 */
    public function update()
    {
        $delfile = null;

        if (empty($this->company)) {
            return response()->json(['errors' => ['system' => ['회사정보를 찾을 수 없습니다.']]], 422);
        }
        $request = Request::capture();
        if ($this->grantType === false) {
            if (Request::ajax()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            } else {
                return ['error' => 'Unauthenticated.'];
            }
        }

        $data = $this->validator($request->all())->validate();
        $data = $this->removeHtmlTagsOfFields($data, []);

        if (!$this->is_admin && isset($data['company_level'])) {
            unset($data['company_level']);
        }

        $img = $this->uploadimage($request);
        if (!empty($img)) {
            $data['company_image_url'] = $img;
            $delfile = $this->company->company_image_url;
        }

        $file1 = $this->saveFile($request, 'file1', $type = 'file');
        if (!empty($file1)) {
            $data['company_attachment_file_url1'] = $file1['url'];
            $data['company_attachment_file_name1'] = $file1['fileName'];
            $delfile = $this->company->company_attachment_file_url1;
        }

        try {
            $create = Company::where('id', $this->company->id)->update($data);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e]], 422);
        }
        $company = $this->getInfo($this->company->id);
        if ($delfile != '' && $delfile != '') Storage::disk('public')->delete($delfile);
        return response()->json(['result' => "OK", "msg" => "기본 정보가 변경 되었습니다.", "data" => $company]);
    }
    /* END 기본정보 수정 */
    /* 기본정보 Validator */
    protected function validator(array $data)
    {
        $messages = [
            'company_name.*' => "회사이름을 입력해주세요.",
            'company_tel1.*' => "전화번호를 입력해주세요.",
            'company_tel2.*' => "전화번호를 입력해주세요.",
            'company_email.*' => "이메일을 입력해주세요.",
            'company_address1.*' => "주소를 입력해주세요.",
            'company_address2.*' => "주소를 입력해주세요.",
            'company_url.url' => "올바른 홈페이지 URL을 입력해주세요.",
            'company_url.min' => "올바른 홈페이지 URL을 입력해주세요.",
            'company_url.max' => "올바른 홈페이지 URL을 입력해주세요.",
            'company_url.*' => "홈페이지를 입력해주세요.",
            'company_display_status.*' => "화면표시 여부를 선택해주세요.",
            'company_level.*' => "인증여부를 선택해주세요.",
        ];
        return Validator::make($data, [
            'company_name' => 'required|string|min:2|max:50',
            'company_tel1' => 'required|min:2|regex:/^[0-9-]+$/|max:20',
            'company_tel2' => 'nullable|min:2|regex:/^[0-9-]+$/|max:20',
            'company_email' => 'required|email',
            'company_address1' => 'required|string|min:2|max:50',
            'company_address2' => 'nullable|string|min:2|max:50',
            'company_url' => 'nullable|url|min:4|max:255',
            'company_display_status' => 'required|in:Y,N',
            'company_level' => 'nullable|numeric|min:80|max:200',
            'company_info1' => 'nullable|string',
            'company_info2' => 'nullable|string',
        ], $messages);
    }
    /* END 기본정보 Validator */

    /* 마스터 변경 */
    public function changemaster()
    {
        $request = Request::capture();
        if (!$this->is_admin) {
            if (Request::ajax()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            } else {
                return ['error' => 'Unauthenticated.'];
            }
        }

        $messages = [
            'company_id.*' => "파라미터 오류입니다.",
            'user_id.*' => "파라미터 오류입니다.",
        ];
        $validatedData = $request->validate([
            'company_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ], $messages);
        $user = User::where('id', $validatedData['user_id'])->first();

        try {
            DB::beginTransaction();
            if ($this->company->company_master_user_id != $validatedData['user_id']) {
                User::where('id', $this->company->company_master_user_id)->update(['company_id' => 0]);
                $this->company['company_master_user_id'] = $validatedData['user_id'];
                $user['company_id'] = $this->company->id;
                $this->company->save();
                $user->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            return response()->json(['errors' => ['system' => ['저장 오류입니다.'], 'e' => $e]], 422);
        }

        return response()->json(
            [
                'result' => "OK",
                "msg" => $this->company->company_name . "의 마스터가 [" . $user->name . "](으)로 변경 되었습니다.",
                "data" => $user,
            ]);
    }
    /* END 마스터 변경 */
    /* 담당자 수*/
    public function countPerson()
    {
        return User::join('companies', 'users.company_id', '=', 'companies.id')
            ->where('company_id', $this->company->id)
            ->whereRaw('users.id != companies.company_master_user_id')
            ->count();
    }
    /* END 담당자 수*/

    /* 담당자 추가 */
    public function addpserson()
    {
        $request = Request::capture();
        if ($this->grantType === false || $this->grantType == 'C') {
            if (Request::ajax()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            } else {
                return ['error' => 'Unauthenticated.'];
            }
        }
        $user = User::where('id', $request->user_id)->first();
        if ($user->company_id == $this->company->id) {
            return response()->json(['errors' => ['system' => ['기존 담당자 입니다.']]], 422);
        } else if ($user->company_id != 0) {
            return response()->json(['errors' => ['system' => ['다른회사 담당자 입니다.']]], 422);
        } else {
            try {
                $user['company_id'] = $this->company->id;
                $user->save();
            } catch (\Exception $e) {
                return response()->json(['errors' => ['system' => ['저장 오류입니다.'], 'e' => $e]], 422);
            }
            return response()->json(
                [
                    'result' => "OK",
                    "msg" => $this->company->company_name . " 담당자가 추가되었습니다 .",
                    "data" => $user,
                ]);
        }
    }

    /* END 담당자 추가 */
    public function delpserson()
    {
        $request = Request::capture();
        if ($this->grantType === false || $this->grantType == 'C') {
            if (Request::ajax()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            } else {
                return ['error' => 'Unauthenticated.'];
            }
        }
        $user = User::where('id', $request->user_id)->first();
        if ($user->company_id != $this->company->id) {
            return response()->json(['errors' => ['system' => ['기존 담당자가 아닙니다.']]], 422);
        }
        try {
            $user['company_id'] = 0;
            $user->save();
        } catch (\Exception $e) {
            return response()->json(['errors' => ['system' => ['저장 오류입니다.'], 'e' => $e]], 422);
        }
        return response()->json(
            [
                'result' => "OK",
                "msg" => $this->company->company_name . " 담당자가 삭제 되었습니다 .",
                "data" => User::join('companies', 'users.company_id', '=', 'companies.id')
                    ->where('company_id', $this->company->id)
                    ->whereRaw('users.id != companies.company_master_user_id')
                    ->count(),
            ]);
    }
    /* 담당자 삭제 */
    /* END 담당자 삭제 */
    private function getInfo($id = null)
    {
        if (empty($id)) {
            return Company::with("Responsibility")
                ->leftJoin('users', 'companies.company_master_user_id', "=", "users.id")
                ->select('companies.*', 'users.name', 'users.email')->latest()->get();
        }
        return Company::with("Responsibility")
            ->leftJoin('users', 'companies.company_master_user_id', "=", "users.id")
            ->select('companies.*', 'users.name', 'users.email')
            ->where('companies.id', $id)->first();
    }

    protected function uploadimage($request)
    {
        $storage = Storage::disk('public');
        $path = 'company/';

        if ($request->hasFile('select_file')) {
            if (!$storage->exists($path)) {
                $storage->makeDirectory($path, 0775, true); //creates directory
            }
            $request->validate([
                'select_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $image_name = $request->file('select_file')->getClientOriginalName();
            $filename = pathinfo($image_name, PATHINFO_FILENAME);
            $image_ext = $request->file('select_file')->getClientOriginalExtension();
            $fileNameToStore = Carbon::now()->format('ymdhis') . '_' . Str::random(9) . "." . $image_ext;
//            $fileNameToStore = uniqid('', true) . '.' . $image_ext;
//            $path = $request->file('select_file')->storeAs('company', $fileNameToStore);
            $storage->putFileAs($path,$request->file('select_file'),$fileNameToStore);
            $url = $path . $fileNameToStore;

            return $url;
        }
        return null;
    }

    protected function saveFile($request, $input_name, $type = 'image', $path = '/company/')
    {
        $storage = Storage::disk('public');
        $path = 'company/';

        if ($request->hasFile($input_name)) {

            if (!$storage->exists($path)) {
                $storage->makeDirectory($path, 0775, true); //creates directory
            }

            if ($type == 'image') {
                $request->validate([
                    'select_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
            } else {
                $request->validate([
                    $input_name => 'required|mimes:jpeg,png,jpg,gif,svg,doc,pdf,zip,ppt,pptx|max:10240',
                ]);
            }
            $filename = $request->file($input_name)->getClientOriginalName();
            $ext = $request->file($input_name)->getClientOriginalExtension();
            $fileNameToStore = Carbon::now()->format('ymdhis') . '_' . Str::random(9) . "." . $ext;
            $storage->putFileAs($path,$request->file($input_name),$fileNameToStore);
            $url = $path . $fileNameToStore;

            return [
                'url'=>$url,
                'fileName'=>$filename,
            ];

        } else return null;
    }
    public function delfile()
    {
        $storage = Storage::disk('public');
        if ($storage->exists($this->company->company_attachment_file_url1)) {
            Company::where('id', $this->company->id)->update(['company_attachment_file_url1'=>null,'company_attachment_file_name1'=>null]);
            try {
                $storage->delete($this->company->company_attachment_file_url1);
            } catch (\Exception $e) {
                return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e]], 422);
            }
            return response()->json(['result' => "OK", "msg" => "파일이 삭제되었습니다.", "data" => $this->company]);
        }
        return null;
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

    public function getGrant()
    {
        return $this->grantType;
    }

    private function checkType()
    {
        //어드민

        if ($this->is_admin) return 'A';
        else if (empty($this->company)) return false;
        else if ($this->is_user) {
            //마스터
            if ($this->company->company_master_user_id == $this->user->id) {
                return 'M';
            } //담당자
            else if ($this->user->company_id == $this->company->id) {
                return 'C';
            } else return false;
        } else return false;
    }

    private function role($roletype)
    {
        //TODO
    }

}
