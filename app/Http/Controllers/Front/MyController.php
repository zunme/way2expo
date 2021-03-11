<?php

namespace App\Http\Controllers\Front;

use App\Models\Booth;
use App\Models\BoothFavorite;
use App\Models\Category;
use App\Models\Company;
use App\Models\Expo;
use App\Models\ExpoFavorite;
use App\Models\Live;
use App\Models\Meeting;
use App\Models\Notification;
use App\Models\ProductFavorite;
use App\Models\User;
use App\Models\UserCard;
use App\Models\UserCardExchage;
use App\Models\UserMeta;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController as ConfirmablePasswordController;
use Yajra\DataTables\Facades\DataTables;

class MyController extends ConfirmablePasswordController
{
    protected $isMobile;

    public function __construct(StatefulGuard $guard)
    {
        parent::__construct($guard);
        $agent = new \Jenssegers\Agent\Agent;
        $this->isMobile = $agent->isMobile();
    }

    /**
     * 즐겨찾기 화면
     *
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Http\JsonResponse
     */
    public function showFavorites(Request $request)
    {
        $expos = ExpoFavorite::with(['expo' => function ($q) {
            $q->active();
        }])->where('user_id', Auth::id())->latest()->get();
        $booths = BoothFavorite::with(['booth' => function ($q) {
            $q->active();
        }, 'booth.expoBooth'])->where('user_id', Auth::id())->latest()->get();
        $today = \Carbon\Carbon::now();
        $data = compact(['expos', 'booths', 'today']);
        if ($request->wantsJson()) return response()->json(['result' => 'OK', 'data' => $data], 200);
        return view('desktop.my.favorites', $data);
    }

    /**
     * 찜 화면, 목록
     *
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Http\JsonResponse
     */
    public function dibs(Request $request)
    {
        $products = ProductFavorite::with(['product' => function ($q) {
            $q->with('expo')->active();
            $q->with('booth')->active();
        }], 'expo')->where('user_id', Auth::id())->latest()->get();
        $today = \Carbon\Carbon::now();
        $data = compact(['products', 'today']);
        if ($request->wantsJson()) return response()->json(['result' => 'OK', 'data' => $data], 200);
        return view('desktop.my.dibs', $data);
    }

    /**
     * 카카오 로그인 연동
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function connectKakao(Request $request)
    {
        $inputs = $request->validate([
            'kakao_id' => 'required',
        ], ['kakao_id.*' => '카카오 아이디가 없습니다.']);

        $user = Auth::guard()->user();
        $user->update(['kakao_id' => $inputs['kakao_id']]);
        return response()->json(array('result' => "OK", "msg" => "연동 완료."), 200);
    }

    /**
     * 카카오 로그인 해제
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function disconnectKakao(Request $request)
    {
        if ($request->filled('user_id') && $request->filled('referrer_type')) {
            $admin_key = $request->header('Authorization');

            if ('KakaoAK ' . config('services.kakao.admin_key') == $admin_key) {
                $user = User::where('kakao_id', $request->query('user_id'))->first();
                $user->update(['kakao_id' => 0]);
                return response()->json(array('result' => "OK", "msg" => "연동 해지 완료."), 200);
            } else {
                return response()->json(array('result' => "OK", "msg" => "권한이 없습니다."), 200);
            }
        }

        $user = Auth::guard()->user();
        $user->update(['kakao_id' => 0]);
        return response()->json(array('result' => "OK", "msg" => "연동 해지 완료."), 200);
    }

    /**
     * 내가 본 화면
     *
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Http\JsonResponse
     */
    public function latest(Request $request)
    {
        $user = Auth::guard()->user();
        if (empty($user))
            return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.']]], 401);

        return view('desktop.my.latest');
    }

    /**
     * 비밀번호 확인
     *
     * ConfirmablePassword
     * @param Request $request
     * @return Application|Factory|View|\Laravel\Fortify\Contracts\ConfirmPasswordViewResponse
     */
    public function show(Request $request)
    {
        if ($this->isMobile) return view('mobile.my.confirm');
        else return view('desktop.my.confirm');
    }

    /**
     * ConfirmablePassword
     * @param Request $request
     * @return Application|\Illuminate\Contracts\Support\Responsable|Factory|View|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $messages = [
            'password.*' => "비밀번호를 입력해주세요.",
        ];
        $validatedData = $request->validate([
            'password' => 'required',
        ], $messages);
        $confirmed = Hash::check($validatedData['password'], Auth::user()->password);

        if ($confirmed) {
            $request->session()->put('auth.password_confirmed_at', time());
            $intended_url = redirect()->intended('/')->getTargetUrl();

            if ($this->isMobile) return view('mobile.confirm');
            else return response()->json(array('result' => "OK", "action" => 'redirect', "msg" => "", "url" => $intended_url));
        } else {
            return response()->json(['errors' => ['password' => ['비밀번호가 일치하지 않습니다.']]], 422);
        }

    }

    /**
     * 내 정보 화면
     *
     * @return Application|Factory|View
     */
    public function showMyInfoForm()
    {
        $user = User::with(['card', 'company', 'meta'])->find(Auth::id());
        $categories = Category::where('parent_id', '=', 0)->display()->get();
        $allCategories = Category::select(['id', 'name', 'parent_id'])->get();
        $areas = config('dataset.area');
        $ages = config('dataset.age');
        $purposes = config('dataset.purpose_viewing');
        $industries = config('dataset.industry');
        $positions = config('dataset.company_position');

        return view('desktop.my.info', compact(
            'user',
            'categories',
            'allCategories',
            'areas',
            'ages',
            'purposes',
            'industries',
            'positions'
        ));
    }

    /**
     * 명함 관리 화면
     *
     * @return Application|Factory|View
     */
    public function showMyCardForm()
    {
        $user = User::with(['card', 'company'])->find(Auth::id());
        return view('desktop.my.card', compact('user'));
    }

    /**
     * 비즈니스 문의 폼
     *
     * @param Request $request
     * @param null $company_id
     * @return Application|Factory|View|\Illuminate\Http\JsonResponse
     */
    public function showCardExchange(Request $request, $company_id = null)
    {
        /* company_id === booth_id  */
        $booth = Booth::display()
            ->with('companyBooth')
            ->select('booths.*', 'expo_open_date')
            ->join('expos', 'booths.expo_id', '=', 'expos.id')
            ->where('booths.id', $company_id)
            ->where('expos.expo_use_yn', 'Y')
            ->first();

        if (empty($booth->id)) {
            return response()->json(['result' => "error", "msg" => '잘못된 경로입니다.'], 422);
        }

        $company_id = $booth->company_id;
        $user = User::with(['card', 'company'])->find(Auth::id());
        return view('desktop.my.cardexchange', compact(['user', 'company_id', 'booth']));

    }

    /**
     * 명함 저장
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function myCardSave(Request $request)
    {
        $user = User::with(['card', 'company'])->find(Auth::id());

        if ($request->hasFile('business_card_front')) {
            $user->saveImage('business_card_front', $request->file('business_card_front'));
            return response()->json(['result' => 'OK', 'data' => $user->fresh(), 'msg' => '이미지 명함 앞면이 저장되었습니다.'], 200);
        }
        if ($request->hasFile('business_card_back')) {
            $user->saveImage('business_card_back', $request->file('business_card_back'));
            return response()->json(['result' => 'OK', 'data' => $user->fresh(), 'msg' => '이미지 명함 뒷면이 저장되었습니다.'], 200);
        }

        $messages = [
            'card_name.*' => '명함 이름을 확인해주세요',
            'card_tel.*' => '명함 전화번호를 확인해주세요',
            'card_email.*' => '명함 이메일을 확인해주세요',
            'card_company.*' => '명함 회사이름을 확인해주세요',
            'card_dept.*' => '명함 부서를 확인해주세요',
            'card_position.*' => '명함 직책(2~20자)을 확인해주세요',
            'card_homepage.*' => '명함 홈페이지를 확인해주세요',
            'card_addr.*' => '명함 주소를 확인해주세요',
        ];

        $data = $request->validate([
            'card_name' => 'bail|required',
            'card_tel' => 'bail|required|min:2|max:20|regex:/^[0-9-]+$/',
            'card_email' => 'bail|required|email|max:20',
            'card_company' => 'bail|nullable|min:2|max:40|string',
            'card_dept' => 'bail|nullable|min:2|max:20|string',
            'card_position' => 'bail|nullable|min:2|max:20|string',
            'card_homepage' => 'bail|nullable|min:2|max:100|url',
            'card_addr' => 'bail|nullable|min:2|max:100|string',
        ], $messages);

        $card = UserCard::where('user_id', Auth::id())->first();
        if (empty($card->user_id)) {
            $data['user_id'] = Auth::id();
            $card = UserCard::create($data);
        } else $card->update($data);
        return response()->json(['result' => 'OK', 'msg' => '텍스트 명함이 저장되었습니다.', 'data' => $data], 200);
    }

    /**
     * 내 정보 수정
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request)
    {
        $messages = [
            //            'tel.required' => '전화번호를 입력해주세요',
            //            'tel.*' => '전화번호는 숫자, - 를 포함해 20자 이하로 적어주세요',
            'category_pid1.*' => "분야 선택을 확인해주세요.",
            'category_pid2.*' => "분야 선택을 확인해주세요.",
            'category_pid3.*' => "분야 선택을 확인해주세요.",
            'category_id1.*' => "분야 선택을 확인해주세요.",
            'category_id2.*' => "분야 선택을 확인해주세요.",
            'category_id3.*' => "분야 선택을 확인해주세요.",
            'company_image_url.max' => "5MB 이하 파일만 업로드 가능합니다.",
            'company_attachment_file_url.max' => "10MB 이하 파일만 업로드 가능합니다.",
        ];

        $validatedData = $request->validate([
            //            'tel' => 'required|min:2|regex:/^[0-9-]+$/|max:20',
            'agree_marketing' => 'nullable|in:Y',
            'gender' => 'nullable|in:0,1',
            'area' => 'nullable|string',
            'age' => 'nullable|numeric',
            'birthdate' => 'nullable|date',
            'category_pid1' => 'nullable|numeric|required_with:category_id1',
            'category_id1' => 'nullable|numeric|required_with:category_pid1',
            'category_pid2' => 'nullable|numeric|required_with:category_id2',
            'category_id2' => 'nullable|numeric|required_with:category_pid2',
            'category_pid3' => 'nullable|numeric|required_with:category_id3',
            'category_id3' => 'nullable|numeric|required_with:category_pid3',
            'purpose_viewing' => 'nullable|string',
            'industry' => 'nullable|string',
            'company_name' => 'nullable',
            'company_dept' => 'nullable',
            'company_position' => 'nullable',
            'company_image_url' => 'nullable|mimes:jpeg,jpg,gif,png|max:5120',
            'company_site' => 'nullable|url',
            'company_tel' => 'nullable|min:2|regex:/^[0-9-]+$/|max:20',
            'company_zip' => 'nullable|min:2|max:6',
            'company_address1' => 'nullable|string|min:2|max:50|required_with:company_address2',
            'company_address2' => 'nullable|string|min:2|max:50|required_with:company_address1',
            'intro' => 'nullable',
            'company_attachment_file_url' => 'nullable|mimes:jpeg,png,jpg,gif,svg,doc,docx,pdf,zip,xlsx,xls,ppt,pptx|max:10240',
        ], $messages);

        try {
            $user = Auth::guard('web')->user();
            //            $user->update($validatedData);
            $meta = UserMeta::find($user->id)->update($validatedData);
            return response()->json(array('result' => "OK", "msg" => "정보 수정 완료.", "data" => ""));
        } catch (\Exception $e) {
            return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e, 'data' => $request->all()]], 422);
        }
    }

    /**
     * 비즈니스 문의 저장
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function myCardExchange(Request $request)
    {
        $user = Auth::guard()->user();
        if (empty($user->id)) {
            return response()->json(['errors' => ['login' => ['로그인 후 이용해주세요.']]], 401);
        }
        $messages = [
            'company_id.*' => '명함을 교환활 기업 정보가 없습니다.',
            'booth_id.*' => '명함을 교환활 부스 정보가 없습니다.',
            'agree.*' => '개인정보 제3자 제공동의를 동의해주세요',
            'message.*' => '소개 및 인사말 (2~1000자)을 입력해주세요.',
        ];

        $inputs = $request->validate([
            'company_id' => 'bail|required|numeric',
            'booth_id' => 'bail|required|numeric',
            'agree' => 'bail|required|in:Y',
            'message' => 'bail|required|min:2|max:1000|string',
        ], $messages);

        $booth = Booth::with(['companyBooth:id', 'expoBooth:id,expo_open_date'], function ($q) {
            $q->active();
        })->where('id', $inputs['booth_id'])->first();

        if (empty($booth)) return response()->json(['errors' => ['parameter' => ['부스 정보가 없습니다.']]], 422);

        if (Carbon::today() < $booth->expoBooth->expo_open_date->format('Y-m-d'))
            return response()->json(['result' => "error", "msg" => "비즈니스 문의는 " . $booth->expoBooth->expo_open_date->format('Y-m-d') . " 부터 가능합니다."], 422);

        $isExist = UserCardExchage::where(['user_id' => Auth::id(), 'company_id' => $inputs['booth_id']])
            ->exists();
        if ($isExist) {
            return response()->json(['errors' => ['parameter' => ['이미 비즈니스문의를 전송하였습니다.']]], 422);
        }

        $inputs['user_id'] = Auth::id();
        $inputs = removeHtmlTags($inputs, ['_method', '_token']);
        $exchange = UserCardExchage::create($inputs);

        $msg = [
            "icon" => "contact_page",
            "title" => "비즈니스문의",
            "target" => "card.receive",
            "content" => "새로운 비즈니스 문의.",
        ];
        $company_users = User::where('company_id', $inputs['company_id'])->get();
        foreach ($company_users as $company_user) {
            $noti = [
                'reciever_id' => $company_user->id,
                'sender_id' => $user->id,
                'data' => $msg
            ];
            Notification::create($noti);
        }
        return response()->json(['result' => 'OK', 'msg' => '비즈니스 문의가 정상적으로 전달되었습니다.'], 200);
    }

    /**
     * 알림 화면
     *
     * @return Application|Factory|View
     */
    public function showNotifications()
    {
        $user = Auth::guard()->user();
        $compact = compact(['user']);
        Notification::where('reciever_id', $user->id)->update(['noti_read' => 'Y']);

        return view('desktop.my.notifications', $compact);

    }

    /**
     * 알림 리스트
     *
     * @return mixed
     * @throws \Exception
     */
    public function getNotificationList(Request $request)
    {
        $user = Auth::guard()->user();
        DB::statement(DB::raw('set @rownum=0'));
        $data = Notification::select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'notifications.*')
            ->where('reciever_id', $user->id)
            ->where(function ($q) use ($request) {
                if ($request->has('simple')) {
                    $q->where(['noti_read' => 'N']);
                }
            })
            ->orderBy('id', 'desc')->get();
        $this->notiupdate();
        return Datatables::of($data)
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('time', function ($row) {
                return $row->created_at->diffForHumans();
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);

    }

    /**
     * 신청한 미팅 화면
     *
     * @return Application|Factory|View
     */
    public function showSendMeetingList()
    {
        $user = Auth::guard()->user();
        $compact = compact(['user']);
        return view('desktop.my.meeting.send', $compact);
    }

    /**
     * 신청한 미팅 리스트
     *
     * @return mixed
     * @throws \Exception
     */
    public function getSendMeetingList(Request $request)
    {
        $user = Auth::guard()->user();
        DB::statement(DB::raw('set @rownum=0'));
        $data = Meeting::select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'expos.expo_name', 'booths.booth_title', 'company_name', 'meetings.*', 'users.name')
            ->join('booths', 'meetings.booth_id', '=', 'booths.id')
            ->join('expos', 'booths.expo_id', '=', 'expos.id')
            ->join('companies', 'booths.company_id', '=', 'companies.id')
            ->join('users', 'user_id', '=', 'users.id')
            ->where('meetings.user_id', $user->id)->orderBy('meetings.meeting_date', 'desc')->orderBy('meetings.meeting_time', 'desc')->get();
        $now = Carbon::now();
        //$now = $now->timestamp;
        foreach ($data as &$row) {
            $start = Carbon::create($row->meeting_date . " " . $row->meeting_time . ":00:00");
            $endtime = Carbon::create($row->meeting_date . " " . $row->meeting_time . ":00:00");
            $endtime->addHours();
            $row['meeting_start_time'] = $start;
            $row['meeting_end_time'] = $endtime;
            if ($now->timestamp > $start->timestamp && $row->meeting_status == 'R') $row['meeting_status'] = 'E';
            else if ($row->meeting_status == 'A') {
                $row['starttime'] = $start;
                if ($now < $endtime) {
                    $row['meeting_cid'] = \Crypt::encryptString($row->id);
                    $row['meeting_confirmed'] = true;
                    $row['meeting_ready'] = true;

                } else {
                    $row['meeting_cid'] = '';
                    $row['meeting_confirmed'] = false;
                    $row['meeting_status'] = 'E';
                }
            } else {
                $row['meeting_cid'] = '';
                $row['meeting_confirmed'] = false;
            }
        }

        return Datatables::of($data)
            ->filter(function ($instance) use ($request) {
                if ($request->get('meeting_status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if ($row['meeting_status'] == $request->get('meeting_status')) {
                            return true;
                        }
                        return false;
                    });
                }
            }, true)
            ->editColumn('meeting_msg', function ($row) {
                return $row->meeting_msg;
                //                return nl2br($row->meeting_msg);
            })
            ->editColumn('meeting_status', function ($row) {
                return $row->meeting_status;
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d H:i:s');
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * 신청 받은 미팅 리스트
     *
     * @return mixed
     * @throws \Exception
     */
    public function getReserveMeetingList(Request $request)
    {
        $user = Auth::guard()->user();
        if ($user->company_id < 1)
            return response()->json(['errors' => ['parameter' => ['권한이 없습니다.']]], 422);

        $data = Meeting::select([
            'expos.expo_name',
            'booths.booth_title',
            'company_name',
            'users.name',
            'users.email',
            'meetings.*'
        ])
            ->join('booths', 'meetings.booth_id', '=', 'booths.id')
            ->join('expos', 'booths.expo_id', '=', 'expos.id')
            ->join('users', 'user_id', '=', 'users.id')
            ->leftJoin('companies', 'users.company_id', '=', 'companies.id')
            ->where('meetings.company_id', $user->company_id)
            ->where(function ($q) use ($request) {
                if (!empty(($request->meeting_status)))
                    $q->where('meetings.meeting_status', $request->meeting_status);
            })
            ->latest()->get();
        $now = Carbon::now();

        //$now = $now->timestamp;
        foreach ($data as &$row) {
            $start = Carbon::create($row->meeting_date . " " . $row->meeting_time . ":00:00");
            $endtime = Carbon::create($row->meeting_date . " " . $row->meeting_time . ":00:00");
            $endtime->addHours();
            $row['meeting_start_time'] = $start;
            $row['meeting_end_time'] = $endtime;

            if ($now->timestamp > $start->timestamp && $row->meeting_status == 'R') $row['meeting_status'] = 'E';
            else if ($row->meeting_status == 'A') {
                $row['starttime'] = $start;
                if ($now < $endtime) {
                    $row['meeting_cid'] = \Crypt::encryptString($row->id);
                    $row['meeting_confirmed'] = true;
                    $row['meeting_ready'] = true;
                } else {
                    $row['meeting_cid'] = '';
                    $row['meeting_confirmed'] = false;
                    $row['meeting_status'] = 'E';
                }
            } else {
                $row['meeting_cid'] = '';
                $row['meeting_confirmed'] = false;
            }
        }

        return Datatables::of($data)
            ->filter(function ($instance) use ($request) {
                if ($request->get('meeting_status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if ($row['meeting_status'] == $request->get('meeting_status')) {
                            return true;
                        }
                        return false;
                    });
                }
            }, true)
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * 1:1 화상회의 관리(수신)
     *
     * @return Application|Factory|View
     */
    public function showManageMeeting()
    {
        $user = Auth::guard()->user();
        $compact = compact(['user']);

        if ($user->company_id < 1)
            return redirect()->back()->withErrors(['msg' => '권한이 없습니다.']);

        return view('desktop.my.company.meeting', $compact);
    }

    /**
     * 비즈니스 문의 관리(수신)
     *
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function showManageExchange()
    {
        $user = Auth::guard()->user();
        if ($user->company_id < 1)
            return redirect()->back()->withErrors(['msg' => '권한이 없습니다.']);

        $compact = compact(['user']);
        return view('desktop.my.contact.receive', $compact);
    }

    /**
     * 전시상품 관리
     *
     * @param $booth_id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function showManageProduct($booth_id)
    {
        if (empty($booth_id))
            return redirect()->intended();
        $user = Auth::guard()->user();
        $booth = Booth::where([
            'id' => $booth_id,
            'company_id' => $user->company_id,
        ])
            ->with('tags', 'boothMeta', 'boothAttach', 'expoBooth')->first();

        if (empty($booth))
            return redirect()->intended();

        $booths = Booth::where([
            'company_id' => $user->company_id,
        ])->latest()->get();

        $compact = compact(['user', 'booths', 'booth']);

        return view('desktop.my.product.list', $compact);
    }

    /**
     * 비즈니스 문의(발신) 화면
     *
     * @return Application|Factory|View
     */
    public function showContactList()
    {
        $user = Auth::guard()->user();
        $compact = compact(['user']);
        return view('desktop.my.contact.send', $compact);
    }

    /**
     * 미팅 상태 변경
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmMeeting(Request $request)
    {
        $messages = [
            'meeting_id.*' => 'PARAMETER ERROR',
            'status.*' => 'PARAMETER ERROR',
        ];

        $input = $request->validate([
            'meeting_id' => 'bail|required|integer',
            'status' => 'bail|required|in:A,D',
        ], $messages);

        $user = Auth::guard()->user();
        $meeting = Meeting::where('id', $input['meeting_id'])->first();
        if ($meeting->company_id != $user->company_id) {
            return response()->json(['errors' => ['auth' => ['권한이 없습니다.']]], 403);
        }

        if ($input['status'] == 'A') {
            if (empty($meeting->room_id)) {
                $meeting_cfg = [
                    'topic' => 'meeting',
                    'type' => 2,
                    'start_time' => new Carbon($meeting->meeting_date . ' ' . sprintf('%02d', $meeting->meeting_time) . ':00:00'), // best to use a Carbon instance here.
                    'duration' => (int)$meeting->duration,
                    'password' => Str::random(8),
                ];

                $useremail = "booth_" . $meeting->booth_id . "@way2expo.com";

                $zoom = new \MacsiDigital\Zoom\Support\Entry;
                $zoomuser = $zoom->user()->find($useremail);

                if (empty($zoomuser)) {
                    $booth = Booth::where(['id' => $meeting->booth_id])->first();
                    $booth_name = preg_replace("/\([^)]+\)/u", "", $booth->booth_title);
                    $booth_name = preg_replace("/[^a-zA-Z0-9가-힣ㄱ-ㅎㅏ-ㅣ]/u", "", $booth_name);

                    $zoomuser = $zoom->user()->create([
                        'action' => 'autoCreate',
                        'user_info' => [
                            'first_name' => $booth_name,
                            'last_name' => '',
                            'email' => $useremail,
                            'password' => 'secretWay2expo!',
                            'type' => '2',
                        ]
                    ]);
                }
                /*
              if ($zoomuser->status != 'active'){
                  return response()->json(['message'=>'ZOOM에서 메일('.$user->email.')을 보냈습니다. 승인해주세요','errors' => ['confirm' => ['ZOOM에서 메일('.$user->email.')을 보냈습니다. 승인해주세요'] ], 'data'=>[] ], 422);
                  return;
              }
              */
                //$zoomuser = $zoom->user()->find('develop@way2expo.com');
                $meetingapi = $zoom->meeting()->make($meeting_cfg);
                $meetingapi->settings()->make([
                    'join_before_host' => true,
                    'approval_type' => 2,
                    'registration_type' => 1,
                    'enforce_login' => false,
                    'waiting_room' => true,
                ]);
                $res = $zoomuser->meetings()->save($meetingapi);
                $meeting->room_pwd = $meeting_cfg['password'];
                $meeting->room_id = $res->id;
            }
            $meeting->meeting_status = 'A';
            $meeting->save();
            $msg = "승인되었습니다.";
        } else {
            $meeting->meeting_status = 'D';
            $meeting->save();
            $msg = "반려되었습니다.";
        }
        return response()->json(['result' => 'OK', 'data' => $meeting, 'msg' => $msg], 200);
    }

    /**
     * 부스 관리 - 상세 화면
     *
     * @param Request $request
     * @param $booth_id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function showDetailBooth(Request $request, $booth_id)
    {
        if (empty($booth_id))
            return redirect()->back()->withErrors(['msg' => '부스가 존재하지 않습니다.']);

        $user = Auth::guard()->user();
        if ($user->company_id < 1)
            return redirect()->back()->withErrors(['msg' => '권한이 없습니다.']);

        $booth = Booth::where([
            'id' => $booth_id,
            'company_id' => $user->company_id,
        ])
            ->with('tags', 'boothMeta', 'boothAttach', 'expoBooth')->first();
        if (empty($booth))
            return redirect()->back()->withErrors(['msg' => '부스가 존재하지 않습니다.']);

        $booths = Booth::where([
            'company_id' => $user->company_id,
        ])->latest()->get();
        $compact = compact(['user', 'booth', 'booths']);

        if ($this->isMobile) {
        } else {
            return view('desktop.my.booth.detail', $compact);
        }
    }

    /**
     * 부스 관리 - 라이브 화면
     *
     * @param Request $request
     * @param $booth_id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function showLiveBooth(Request $request, $booth_id)
    {
        if (empty($booth_id))
            return redirect()->intended();
        $user = Auth::guard()->user();
        $booth = Booth::where([
            'id' => $booth_id,
            'company_id' => $user->company_id,
        ])
            ->with('tags', 'boothMeta', 'boothAttach', 'expoBooth')->first();

        if ($booth->expoBooth->expo_open_date->format('Y-m-d') > Carbon::today())
            return redirect()->to('/my/booth/detail/' . $booth_id)->withErrors(['msg' => '박람회 기간이 아닙니다.']);

        if (empty($booth))
            return redirect()->intended();

        $booths = Booth::where([
            'company_id' => $user->company_id,
        ])->latest()->get();

        /* Live */
        $payload = [
            'command' => null,
            'body' => null,
            'sender' => [
                'type' => "manager",
                'key' => $this->encrypt64($user->id),
                'name' => $user->name,
                'banned_type' => null,
            ],
            'target' => [
                'key' => null,
                'memo' => null,
            ],

        ];
        $has_live = Live::where('booth_id', $booth_id)->active()->exists();
        if ($has_live) return redirect()->to('/my/booth/detail/' . $booth_id)->withErrors(['msg' => '현재 LIVE 방송이 진행 중입니다.']);
        $compact = compact(['user', 'booths', 'booth', 'payload', 'has_live']);
        return view('desktop.my.booth.live', $compact);
    }

    /**
     * 부스 관리 - 라이브 동의
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postShowLiveBooth()
    {
        $user = Auth::guard()->user();
        if (empty($user)) return redirect()->intended('/');
        $live_start = Carbon::createFromTimeString(config('expo.live_start_time'));
        $live_end = Carbon::createFromTimeString(config('expo.live_end_time'));
        if (!Carbon::now()->between($live_start, $live_end))
            return redirect()->back()->withErrors(['msg' => '방송 가능 시간 ' . $live_start->format('H:i') . '~' . $live_end->format('H:i')]);

        return redirect()->back()->with('guide', 'checked');
    }

    /**
     * 비즈니스 문의 내역(수신)
     *
     * @return mixed
     * @throws \Exception
     */
    public function getExchangeReceiveList(Request $request)
    {
        $user = Auth::guard()->user();
        DB::statement(DB::raw('set @rownum=0'));
        $data = UserCardExchage::select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'user_card_exchages.*')
            ->with([
                'boothInfo' => function ($q) {
                    $q->with('expoBooth:id,expo_name');
                    $q->active();
                },
                'cardSender' => function ($q) {
                    $q->with('card');
                },
            ])
            ->where('use_yn_company', 'Y')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * 비즈니스 문의 내역(발신)
     *
     * @return mixed
     * @throws \Exception
     */
    public function getExchangeSendList(Request $request)
    {
        $user = Auth::guard()->user();
        DB::statement(DB::raw('set @rownum=0'));
        $data = UserCardExchage::select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'user_card_exchages.*')
            ->with([
                'boothInfo' => function ($q) {
                    $q->with('expoBooth:id,expo_name');
                    $q->active();
                },
            ])
            ->where('use_yn_company', 'Y')
            ->where('user_id', $user->id)
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * 비즈니스 문의 - 삭제
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeExchange(Request $request)
    {
        $user = Auth::guard()->user();
        $inputs = $request->validate([
            'id' => 'required|array',
        ], ['id.*' => 'A id is required']);
        if ($user->company_id < 1) return response()->json(['result' => "error", "msg" => '권한이 없습니다.'], 422);

        $card = UserCardExchage::find($inputs['id'][0]);
        if ($user->company_id != $card->company_id)
            return response()->json(['errors' => ['parameter' => ['권한이 없습니다.']]], 422);

        UserCardExchage::whereIn('id', $inputs['id'])->update([
            'use_yn_company' => 'N'
        ]);
        return response()->json(['result' => 'OK', 'msg' => '삭제되었습니다.'], 200);
    }

    /**
     * 비즈니스 문의 - 상세
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExchangeDetail(Request $request)
    {
        $user = Auth::guard()->user();
        $inputs = $request->validate([
            'id' => 'required',
        ], ['id.*' => 'A id is required']);

        $card = UserCardExchage::find($inputs['id']);
        $card->update(['read_yn' => "Y"]);
        return response()->json(['result' => 'OK', 'data' => $card], 200);
    }

    /**
     * 알림 갯수
     *
     * @return int|string
     */
    public function noticount()
    {
        $user = Auth::guard()->user();

        $noti = new Notification();
        $notiCount = $noti->newCount($user);
        return $notiCount;
    }

    /**
     * 알림 갱신
     *
     * @return null
     */
    public function notiupdate()
    {
        $user = Auth::guard()->user();

        if (!empty($user->id)) {
            Notification::where('reciever_id', $user->id)->update(['noti_read' => 'Y']);
        }
        return null;
    }

    /**
     * 암호화
     *
     * @param $n
     * @return int
     */
    private function encrypt64($n)
    {
        return ((0x000000000000FFFF & $n) << 48) + (((0xFFFFFFFFFFFF0000 & $n) >> 16) & 0x0000FFFFFFFFFFFF);
    }

    /**
     * 복호화
     *
     * @param $n
     * @return int
     */
    private function decrypt64($n)
    {
        return ((0x0000FFFFFFFFFFFF & $n) << 16) + (((0xFFFF000000000000 & $n) >> 48) & 0x000000000000FFFF);
    }
}
