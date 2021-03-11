<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\User;
use App\Modules\companyModule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends AdminbaseController
{
    /**
     * 기업 관리 화면
     */
    public function index(Request $request)
    {
        return view('admin.company.list');
    }

    /**
     * 기업 목록 - Datatables
     * @param Request $request
     * @return Datatables
     * @throws Exception
     */
    public function list(Request $request)
    {
        $data = Company::with("Responsibility")
            ->leftJoin('users', 'companies.company_master_user_id', "=", "users.id")
            ->select('companies.*', 'users.name', 'users.email')
            ->latest()->get();

        return Datatables::of($data)
            ->filter(function ($instance) use ($request) {
                if ($request->get('display_status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if (Str::contains($row['company_display_status'], $request->get('display_status'))) {
                            return true;
                        }
                    });
                }
                if ($request->get('company_level_status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if (Str::contains($row['company_level'], $request->get('company_level_status'))) {
                            return true;
                        }
                    });
                }
            }, true)
            ->editColumn('company_image_url', function ($request) {
                return (!empty($request->company_image_url))?Storage::disk('public')->url($request->company_image_url):null;
            })
//            ->editColumn('company_attachment_file_url1', function ($request) {
//                return (!empty($request->company_attachment_file_url1))?Storage::disk('public')->url($request->company_attachment_file_url1):null;
//            })
//            ->editColumn('company_attachment_file_url2', function ($request) {
//                return (!empty($request->company_attachment_file_url2))?Storage::disk('public')->url($request->company_attachment_file_url2):null;
//            })
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * 기업 정보 저장
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string[]
     */
    public function save(Request $request)
    {
        if (empty($request->id)) {
            $companyModule = new companyModule(null, null, auth('web'));
            return $companyModule->create();
        } else {
            $companyModule = new companyModule($request->id, null, auth('web'));
            return $companyModule->update();
        }
    }

    /**
     * 마스터 담당자 변경
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string[]
     */
    public function changemaster(Request $request)
    {
        $companyModule = new companyModule($request->company_id, null, auth('web'));
        return $companyModule->changemaster();
    }

    /**
     * 담당자 추가
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string[]
     */
    public function addpserson(Request $request)
    {
        $companyModule = new companyModule($request->company_id, null, auth('web'));
        return $companyModule->addpserson();
    }

    /**
     * 담당자 삭제
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string[]
     */
    public function delpserson(Request $request)
    {
        $companyModule = new companyModule($request->company_id, null, auth('web'));
        return $companyModule->delpserson();
    }

    /**
     * 담당자 검색
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function userlist(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('company_id', '0')->where('user_status', 'Y')->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * 첨부파일 삭제
     * @param Request $request
     * @return bool
     */
    public function delfile(Request $request)
    {
        $companyModule = new companyModule($request->company_id, null, auth('web'));
        return $companyModule->delfile();
    }

}
