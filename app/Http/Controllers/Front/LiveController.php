<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Booth;
use App\Models\BoothFavorite;
use App\Models\Expo;
use App\Models\Live;
use App\Models\LiveBan;
use App\Models\LiveVisit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Str;

class LiveController extends Controller
{
    protected $isMobile;

    public function __construct()
    {
        $agent = new \Jenssegers\Agent\Agent;
        $this->isMobile = $agent->isMobile();
    }

    /**
     * 방송 시청
     * @param $booth_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function view($booth_id)
    {
        $channel_id = null;
        $favorite = null;
        $payload = [
            'command' => null,
            'body' => null,
            'sender' => [
                'type' => "guest",
                'key' => "guestUser",
                'name' => "guest",
                'banned_type' => null,
            ],
            'target' => [
                'key' => null,
                'memo' => null,
            ],

        ];

        $booth = Booth::find($booth_id);
        // if (empty($booth)) return response()->json(['errors' => ['parameter' => ['부스가 존재하지 않습니다.']]], 422);

        $user = Auth::guard('web')->user();

        if (!empty($user)) {
            $banned_type = LiveBan::where([
                'booth_id' => $booth_id,
                'user_id' => $user->id,
            ])->value('banned_type');
            if ($banned_type === 'B') {
                return '<script type="text/javascript">alert("차단된 사용자 입니다.");window.close();</script>';
            }

            $payload['sender']['key'] = $this->encrypt64($user->id);
            $payload['sender']['type'] = (!empty($user->company_id) && $booth->company_id == $user->company_id) ? 'manager' : 'member';
            $payload['sender']['name'] = $user->name;
            $payload['sender']['banned_type'] = $banned_type;

            $favorite = BoothFavorite::where([
                'user_id' => $user->id,
                'booth_id' => $booth_id,
            ])->first();
        }

        $live = Live::where('booth_id', $booth_id)->active()->first();

        if (!empty($live)) {
            $this->visit($live->id);
            if ($payload['sender']['type'] !== 'manager')
                $live->addVisitorCount();
        }

        $data = compact(['user', 'live', 'booth', 'payload', 'favorite']);

        if ($this->isMobile) {
        } else {
            return view('desktop.live.view', $data);
        }
    }

    /**
     * 방송 생성 (remoteMonsterChannelId: $live->full_channel_id)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $messages = [
            'booth_id.*' => '부스 정보가 없습니다.',
        ];

        $validatedData = $request->validate([
            'booth_id' => 'required',
        ], $messages);

        $user = Auth::guard('web')->user();
        if (empty($user)) return response()->json(['errors' => ['parameter' => ['권한이 없습니다.']]], 422);

        $booth = Booth::find($validatedData['booth_id']);
        if (empty($booth)) return response()->json(['errors' => ['parameter' => ['부스가 존재하지 않습니다.']]], 422);

        $expo = Expo::find($booth->expo_id);
        if (empty($expo)) return response()->json(['errors' => ['parameter' => ['박람회가 존재하지 않습니다.']]], 422);

        if (Carbon::now() < $expo->expo_open_date || Carbon::now() > $expo->expo_close_date)
            return response()->json(['errors' => ['parameter' => ['박람회 기간이 아닙니다.']]], 422);

        if ($user->company_id < 1 || $booth->company_id != $user->company_id)
            return response()->json(['errors' => ['parameter' => ['권한이 없습니다.']]], 422);

        $live_start = Carbon::createFromTimeString(config('expo.live_start_time'));
        $live_end = Carbon::createFromTimeString(config('expo.live_end_time'));
        if (!Carbon::now()->between($live_start, $live_end))
            return response()->json(['errors' => ['parameter' => ['방송 가능 시간이 아닙니다.']]], 422);

        // $companyModule = new companyModule($user->company_id, $user, false);
        // if ($companyModule->getGrant() !== 'M') return response()->json(['errors' => ['parameter' => ['마스터 담당자가 아닙니다.']]], 422);

        $has_live = Live::where('booth_id', $validatedData['booth_id'])->active()->exists();
        if (!empty($has_live)) return response()->json(['errors' => ['parameter' => ['LIVE 방송이 진행 중입니다.']]], 422);

        $live = new Live([
            'booth_id' => $booth->id,
            'channel_id' => Carbon::now()->timestamp,
            'live_status' => 'O',
        ]);
        $live->save();
        $live_ban = LiveBan::where([
            'booth_id' => $booth->id
        ])
            ->leftJoin('users', 'live_bans.user_id', "=", "users.id")
            ->select(['live_bans.banned_type', 'live_bans.user_id', 'live_bans.memo', 'users.name'])
            ->get();

        $banned_users = $live_ban->map(function ($data) {
            return collect([
                'memo' => $data->memo,
                'banned_type' => $data->banned_type,
                'name' => $data->name,
                'key' => $this->encrypt64($data->user_id),
            ]);
        })
            ->reject(function ($value) {
                return $value['banned_type'] === 'U';
            })->values()->all();

        if ($this->isMobile) {
        } else {
            return response()->json(['result' => 'OK', 'data' => ['live' => $live, 'bannedUsers' => $banned_users]], 200);
        }
    }


    /**
     * 방송 종료
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function close(Request $request)
    {
        $messages = [
            'live_id.*' => 'LIVE 방송 정보가 없습니다.',
        ];

        $validatedData = $request->validate([
            'live_id' => 'required',
        ], $messages);

        $user = Auth::guard('web')->user();
        if (empty($user)) return response()->json(['errors' => ['parameter' => ['권한이 없습니다.']]], 422);

        $live = Live::find($validatedData['live_id']);
        if (empty($live)) return response()->json(['errors' => ['parameter' => ['Live 방송 정보가 없습니다.']]], 422);

        $booth = Booth::find($live->booth_id)->active()->first();
        if (empty($booth)) return response()->json(['errors' => ['parameter' => ['부스가 존재하지 않습니다.']]], 422);

        if (empty($user->company_id) && $booth->company_id != $user->company_id)
            return response()->json(['errors' => ['parameter' => ['권한이 없습니다.']]], 422);

        $live->live_status = "C";
        $live->save();

        return response()->json(['result' => 'OK', 'data' => ['live' => $live]], 200);
    }

    /**
     * 방송중인 채널 목록 조회 API
     * @param null $channel_id
     * @return array|mixed
     */
    public function getChannelListOnAPI($channel_id = null)
    {
        $response = Http::withHeaders([
            'Content-type' => 'application/json'
        ])
            ->post(config('remotemonster.lambdaurl') . '/broadcast-channel-list', [
                'serviceId' => config('remotemonster.serviceId'),
                'secret' => config('remotemonster.key'),
            ])->json();

        if (!empty($channel_id)) {
            foreach ($response as $channel) {
                if ($channel['id'] === $channel_id) {
                    $response = $channel;
                    break;
                }
            }
        }
        return $response;
    }

    /**
     * 방송 강제 종료
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse|mixed
     */
    public function closeOnAPI(Request $request)
    {
        $lives = Live::where([
            'booth_id' => $request->booth_id,
            'live_status' => 'O',
        ])->get();

        foreach ($lives as $live) {
            $live->live_status = 'C';
            $live->save();
            Http::withHeaders([
                'Content-type' => 'application/json'
            ])
                ->post(config('remotemonster.lambdaurl') . '/channel-force-termination', [
                    'serviceId' => config('remotemonster.serviceId'),
                    'secret' => config('remotemonster.key'),
                    'channelId' => $live->full_channel_id,
                ])->json();
        }
        return true;
    }

    /**
     * WebHook Get (?action=(create|close)&chid=29prNYThNh)
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function webhook(Request $request)
    {
        if (empty($request->has('action')) || empty($request->has('chid')))
            return redirect(404);

        $query = $request->query();
        $action = $query['action'];
        $splitStr = Str::of($query['chid'])->explode('_');

        if (empty($splitStr))
            return redirect(404);

        $live = Live::where([
            'booth_id' => $splitStr['booth_id'],
            'channel_id' => $splitStr['channel_id'],
        ])->first();

        if (!empty($live)) {
            if ($action === 'close') { // 방송 종료
                $live->live_status = 'C';
                $live->update();
            }
        }
        return response()->json(null, 200);
    }

    public function recordDone(Request $request)
    {
        if (empty($request->has('id')) || empty($request->has('url')))
            return redirect(404);

        $query = $request->query();
        return null;
    }

    /**
     * 방송 기능 - 강퇴,차단,해제,좋아요
     * param : payload - command, sender, target, addlike
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function commands(Request $request)
    {
        $messages = [
            'command.*' => '올바른 요청이 아닙니다.',
        ];

        $validatedData = $request->validate([
            'command' => 'required',
        ], $messages);

        $command = $validatedData['command'];

        if (in_array($command, ['ban', 'block', 'unban', 'block', 'unblock'])) {
            $messages = [
                'booth_id.*' => '부스 정보가 없습니다.',
                'target.key' => '해당 사용자 정보가 없습니다.',
            ];

            $validatedData = $request->validate([
                'booth_id' => 'required',
                'target.key' => 'required',
                'target.memo' => 'nullable',
            ], $messages);
            if (empty($validatedData['target']['memo'])) $validatedData['target']['memo'] = null;

            $booth = Booth::find($validatedData['booth_id'])->first();
            if (empty($booth)) return response()->json(['errors' => ['parameter' => ['부스가 존재하지 않습니다.']]], 422);

            $user = Auth::guard('web')->user();
            if (empty($user))
                return response()->json(['errors' => ['parameter' => ['권한이 없습니다.']]], 422);

            if ($booth->company_id != $user->company_id)
                return response()->json(['errors' => ['parameter' => ['권한이 없습니다.']]], 422);

            $booth_id = $booth->id;
            $target_user_key = $this->decrypt64($validatedData['target']['key']);
            $matchThese = ['booth_id' => $booth_id, 'user_id' => $target_user_key];

            if ($command == 'ban') {
                $ban = LiveBan::updateOrCreate($matchThese, [
                    'banned_type' => 'B',
                    'booth_id' => $booth_id,
                    'user_id' => $target_user_key,
                    'created_by_id' => $user->id,
                    'memo' => $validatedData['target']['memo'],
                ]);
                return response()->json(['result' => "OK", "msg" => '강퇴 처리되었습니다.', "data" => $ban], 200);
            }
            if ($command == 'block') {
                $ban = LiveBan::updateOrCreate($matchThese, [
                    'banned_type' => 'C',
                    'booth_id' => $booth_id,
                    'user_id' => $target_user_key,
                    'created_by_id' => $user->id,
                    'memo' => $validatedData['target']['memo'],
                ]);
                return response()->json(['result' => "OK", "msg" => '채팅이 차단되었습니다.'], 200);
            }
            if (in_array($command, ['unban', 'unblock'])) {
                $ban = LiveBan::where([
                    'booth_id' => $booth_id,
                    'user_id' => $target_user_key,
                ])->update(['banned_type' => 'U']);
                return response()->json(['result' => "OK", "msg" => '해제되었습니다.'], 200);
            }
        }

        if ($command == 'addlike') {
            $messages = [
                'live_id.*' => 'LIVE 방송 중이 아닙니다.',
            ];

            $validatedData = $request->validate([
                'live_id' => 'required',
            ], $messages);

            $live = Live::find($validatedData['live_id']);
            if (empty($live) || $live->live_status !== 'O') return response()->json(['result' => "error", "msg" => 'Live 방송 중이 아닙니다.'], 422);
            $live->addLikeCount();
            $data = [
                'totalLikeCount' => $live->total_like_count,
                'likeCount' => $live->like_count
            ];
            return response()->json(['result' => "OK", "data" => $data], 200);
        }

        return redirect(401);
    }

    /**
     * 차단 사용자 목록
     * @param $booth_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBannedUsers(Request $request)
    {
        $messages = [
            'booth_id.*' => '부스 정보가 없습니다.',
        ];

        $validatedData = $request->validate([
            'booth_id' => 'required',
        ], $messages);

        $banned_users = LiveBan::where([
            'booth_id' => $validatedData['booth_id']
        ])
            ->leftJoin('users', 'live_bans.user_id', "=", "users.id")
            ->select(['live_bans.banned_type', 'live_bans.user_id', 'users.name'])
            ->get();
        $banned_users = $banned_users->map(function ($data) {
            return collect([
                'banned_type' => $data->banned_type,
                'name' => $data->name,
                'key' => $this->encrypt64($data->user_id),
            ]);
        })->reject(function ($value) {
            return $value['banned_type'] === 'U';
        })->values()->all();

        return response()->json(['result' => "OK", "data" => $banned_users], 200);
    }

    /**
     * 방문자 로그 생성
     * @param $liveKey
     * @return LiveVisit|\Illuminate\Database\Eloquent\Model
     */
    public function visit($liveKey)
    {
        $visitor = visitor();

        try {
            $prepareLog = [
                'url' => $visitor->url(),
                'referer' => $visitor->referer(),
                'useragent' => $visitor->userAgent(),
                'device' => $visitor->device(),
                'platform' => $visitor->platform(),
                'browser' => $visitor->browser(),
                'ip' => $visitor->ip(),
                'live_id' => $liveKey,
                'visitor_id' => $visitor->getVisitor() ? $visitor->getVisitor()->id : null,
            ];

            $visit = LiveVisit::create($prepareLog);
            return $visit;

        } catch (\Exception $e) {
        }
    }

    /**
     * Live 방문자 리스트 가져오기
     * booth_id, live_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVisitors(Request $request)
    {
        $messages = [
            'booth_id.*' => '부스 정보가 없습니다.',
        ];

        $validatedData = $request->validate([
            'booth_id' => ['required',
                function ($attribute, $value, $fail) {
                    $booth = Booth::find($value)->active();
                    if (empty($booth)) {
                        $fail('부스가 존재하지 않습니다.');
                        return;
                    }
                }],
            'live_id' => 'sometimes',
        ], $messages);

        $count = 0;
        if ($request->has('live_id')) {
            $live = Live::find($request->live_id);
            $count = $live->visitor_count;

        } else {
        }
        $data = [
            'visitors' => [
                'totalCount' => $count,
            ],
        ];
        return response()->json(['result' => "OK", 'data' => $data['visitors']], 200);
    }

    /**
     * 썸네일
     * @param Request $request
     */
    public function thumb(Request $request)
    {
        $base64_image = $request->imgBase64;
        if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
            $data = substr($base64_image, strpos($base64_image, ',') + 1);
            $data = base64_decode($data);
            $image = Image::make($data);

            $image->resize('200', null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $stroageres = Storage::disk('public')->put('/thumb/' . $request->channel_id . '.jpg', $image->stream()->__toString());
            //dd ($stroageres);
            echo url('/storage/thumb/' . $request->channel_id . '.jpg?ver=' . time());
        } else dd("error");
    }

    /**
     * 암호화
     * @param $n
     * @return int
     */
    private function encrypt64($n)
    {
        return ((0x000000000000FFFF & $n) << 48) + (((0xFFFFFFFFFFFF0000 & $n) >> 16) & 0x0000FFFFFFFFFFFF);
    }

    /**
     * 복호화
     * @param $n
     * @return int
     */
    private function decrypt64($n)
    {
        return ((0x0000FFFFFFFFFFFF & $n) << 16) + (((0xFFFF000000000000 & $n) >> 48) & 0x000000000000FFFF);
    }

}
