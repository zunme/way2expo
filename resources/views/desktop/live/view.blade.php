@extends('desktop.layouts.blank')
@section('navbar','')
@section('css')
    <style>
        .content-wrap.nav-fixed {
            padding-top: 0px !important;
        }

        .live-layout {
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ mix('/assets/css/live.css') }}">
@endsection
@section('body')
    <div id="root">
        <div class="live-layout">
            <div class="live-inner">
                <div class="live-header-wrap">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-6">
                            <div class="live-header-logo">
                                <img src="/assets/img/logo/logo-way2expo-white.png" alt="" width="90">
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            <div class="live-header-tool">
                                <button type="button" class="btn btn-link" data-toggle="tooltip"
                                        data-id="{{$booth->id}}" title="즐겨찾기" onclick="toggleBoothFavorite(this)"><i
                                        class="material-icons {{(empty($favorite))?'':'text-warning'}}">{{(empty($favorite))?'star_border':'grade'}}</i>
                                </button>
                                <button type="button" class="btn btn-link" onclick="window.close();"><i
                                        class="material-icons">close</i>
                                </button>
                            </div>

                        </div>
                    </div>
                    <div class="live-header-title">
                        <h2 class="title text-white">{{ $booth->booth_title }}</h2>
                    </div>
                    <div class="live-header-stat d-flex">
                        <i class="material-icons">live_tv</i><span id="totalViewCount"
                                                                   class="mr-2">0</span>
                        <i class="material-icons" style="padding-top:1px;">favorite_border</i><span id="likeCount"
                                                                                                    class="live-like-count">{{$live->like_count??0}}</span>

                    </div>
                    {{--                    <div class="live-controls d-flex">--}}
                    {{--                        <button id="muteBtn" class="btn btn-sm btn-just-icon btn-round btn-danger" data-container=".live-controls" data-toggle="popover" data-placement="right" data-content="소리 켜기">--}}
                    {{--                            <i class="material-icons">volume_off</i>--}}
                    {{--                        </button>--}}

                    {{--                    </div>--}}
                </div>
                <h5 id="waitingTv" class="title"
                    style="display:none;">
                    Loading</h5>
                <div class="live-player">
                    <video id="remoteVideo" class="remote-video" autoplay playsinline="" webkit-playsinline=""
                           controlslist="nodownload" disablepictureinpicture="true"
                           style="z-index:1;width: 100%;height:100%"></video>
                </div>
                <div class="live-footer">
                    <div class="live-comment">
                        <div id="live-comment-inner" class="live-comment-inner">
                            <div id="chatLogDiv" class="comment">
                            </div>
                        </div>
                        <div id="chatLogDownIcon" class="chatLogDownIcon">
                            <button type="button" class="btn btn-black btn-fab btn-fab-mini btn-round">
                                <i class="material-icons">vertical_align_bottom</i>
                            </button>
                        </div>
                        <div class="live-comment-tool">
                            <div class="live-comment-input">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group p-0 m-0">
                                            <div class="input-group">
                                                @if(!empty($user))
                                                    <input type="text" class="form-control " id="chatMsg"
                                                           placeholder="메시지 내용...">
                                                    <div class="input-group-append">
                                                        <button type="button" id="sendMessageBtn"
                                                                class="btn btn-link p-2"><i
                                                                class="material-icons">send</i>
                                                        </button>
                                                        <button type="button" id="autoScrollBtn"
                                                                class="btn btn-warning p-2"
                                                        ><i class="material-icons">low_priority</i>
                                                        </button>
                                                        <button type="button" id="clearChatBtn"
                                                                class="btn btn-danger p-2"
                                                        ><i class="material-icons">delete</i>
                                                        </button>
                                                    </div>
                                                @else()
                                                    <input type="text" class="form-control disabled" id="chatMsg"
                                                           placeholder="로그인 후 이용가능" disabled="true">
                                                    <div class="input-group-append">
                                                        <a href="/login" role="button" class="btn btn-sm">로그인</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="live-like">
                                <button id="like-btn" type="button" class="btn btn-link"><i
                                        class="material-icons">favorite_border</i></button>
                            </div>
                        </div>
                    </div>
                    <div class="live-banner">

                    </div>
                </div>
                <div class="live-play-tool">
                    <button id="playBtn" class="btn btn-black btn-fab btn-round">
                        <i class="material-icons">play_arrow</i>
                    </button>
                    <div id="loading" class="lds-ring">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('page-after')
    @verbatim
        <script id="template-live-agree" type="text/x-handlebars-template">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <form name="agreeForm">
                        <h5 class="title m-0 p-0">방송안내</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="content">
                                    본 부스의 라이브 방송은 방송의 클린함과 욕설, 비매너 행위 등을 방지하고자 하는 목적으로 실명을 사용하여 방송을 진행합니다.

                                    시청자 여러분의 실명은 방송을 진행하는 관리자는 확인할 수 있으며, 채팅을 입력하게 될 경우 실명이 노출될 수 있습니다.

                                    클린하고 건전한 채팅문화를 만들기위해 많은 협조를 부탁드립니다.

                                </div>
                            </div>
                        </div>
                        <h5 class="title m-0 p-0">방송규정</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="content">
                                    Where can I get some?
                                    There are many variations of passages of Lorem Ipsum available, but the majority
                                    have suffered alteration in some form, by injected humour, or randomised words which
                                    don't look even slightly believable. If you are going to use a passage of Lorem
                                    Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of
                                    text. All the Lorem Ipsum generators on the Internet tend to repeat predefined
                                    chunks as necessary, making this the first true generator on the Internet. It uses a
                                    dictionary of over 200 Latin words, combined with a handful of model sentence
                                    structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem
                                    Ipsum is therefore always free from repetition, injected humour, or
                                    non-characteristic words etc.
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-sm">돌아가기</button>
                            <button type="submit" class="btn btn-sm btn-black btn-block">모두 확인 및 입장</button>
                        </div>
                    </form>

                </div>
            </div>
        </script>
    @endverbatim
@stop
@section('page-script')
    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@remotemonster/sdk"></script>

    <script>

        /* remote-monster */
        const config = {
            credential: {
                serviceId: '{{ config('remotemonster.serviceId') }}',
                key: '{{ config('remotemonster.key') }}'
            },
            view: {
                remote: '#remoteVideo',
            },
            media: {
                recvonly: true,
                video: true,
                audio: true,
            },
            rtc: {
                simulcast: true
            },
            dev: {
                logLevel: '{{ config('remotemonster.dev.logLevel') }}'
            }
        };
        const payload = @json($payload);

        /* variables */
        const boothId = {{ $booth->id }};
        const boothUrl = '{{$booth->url()}}';
        const isLogged = {{(empty($user)?'false':'true')}};
        const myLiveId = '{{ (!empty($live))?$live->id:'' }}';
        const myChannelId = '{{(!empty($live))?$live->full_channel_id:''}}';
        // const myChannelId = 'testchannel';
        let likeCount = {{ (!empty($live))?$live->like_count:0 }};
        let totalViewCount = {{$live->visitor_count??0}};

        /* 즐겨찾기 */
        function toggleBoothFavorite(obj) {
            $.ajax({
                url: "/booth/favorite",
                method: "post",
                data: {'booth_id': $(obj).data('id')},
                dataType: 'JSON',
                success: function (res) {
                    if (res.result === 'OK') {
                        var icon = $(obj).find('.material-icons');
                        if (res.data === 'add') {
                            icon.text('grade');
                            icon.addClass('text-warning');
                        } else {
                            icon.text('star_border');
                            icon.removeClass('text-warning');
                        }
                        Swal2.fire({
                            toast: false,
                            text: res.msg,
                            position: 'center',
                            showConfirmButton: true,
                            timer: 3000,
                            icon: "success",
                            // timerProgressBar: true,
                            didOpen: function (toast) {
                                toast.addEventListener('mouseenter', Swal2.stopTimer)
                                toast.addEventListener('mouseleave', Swal2.resumeTimer)
                            }
                        }).then(function (value) {
                            if (value) {
                            }
                        });

                    } else {
                        toastr.error(res.msg);
                    }
                    refreshToken();
                },
            });
        }
    </script>
    <script src="/assets/js/wordfilter.js" type="text/javascript"></script>
    <script src="{{ mix('/assets/js/liveView.js') }}" type="text/javascript"></script>
@stop
