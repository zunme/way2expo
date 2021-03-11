@section('css')
    <style>
        .chatLog {
            width: 100%;
        }

        .chatText {
            position: relative;
            margin: 0;
        }

        .chatText.join {
            margin: 0 auto;
            text-align: center;
        }

        /*width: calc(100vh * 0.5625);*/

        .live-comment-inner span {
            align-self: flex-end;
            vertical-align: text-bottom;
            word-break: break-all;
        }

        .live-comment-inner {
            height: 507px;
            border: 1px solid #ddd;
            border-radius: 3px;
            overflow-x: hidden;
            overflow-y: scroll;
            cursor: grab;
        }

        .viewers {
            border: 1px solid #ddd;
            border-radius: 3px;
            overflow-y: scroll;
            overflow-x: hidden;
            width: 100%;
            height: 507px;
        }

        .viewers .material-icons {
            position: absolute;
            left: 3px;
            font-size: 1rem;
            line-height: 1.2;
        }

        .viewers .dropdown-item, .chatText .dropdown-item {
            margin: 0 auto;
            width: 100%;
            cursor: pointer;
        }

        #image-preview-pc, #image-preview-mobile {
            width: 250px;
            height: 250px;
            border: 2px dashed #ddd;
            border-radius: 3px;
            position: relative;
            overflow: hidden;
            background-color: #ffffff;
            color: #ecf0f1;
        }

        .live-player {
        }

        .live-player video {
            /*width: 464px;*/
            /*height: 261px;*/
            width: 100%;
            height: 541px;
        }

        #live-manage-tab .nav-link {
            padding: 2px 15px;
        }

        /*
 *  STYLE 1
 */
        .live-comment-inner::-webkit-scrollbar-track, .viewers::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            background-color: #F5F5F5;
        }

        .live-comment-inner::-webkit-scrollbar, .viewers::-webkit-scrollbar {
            background: transparent;
            width: 2px;
            background-color: transparent;
        }

        .live-comment-inner::-webkit-scrollbar-thumb, .viewers::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: #555;
        }

        #chatLogDiv {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        #chatLogDiv .chatName {
            cursor: pointer;
        }

    </style>
@endsection
<div class="row">
    <div class="col-12">
        <div class="row justify-content-center">
            <div class="col-12 text-left">
                <p id="live-stat-text" class="text">현재 방문자 수 (회원/총): <span
                        id="userViewCount">0</span>/<span id="totalViewCount">0</span>,
                    좋아요:
                    <span id="likeCount">0</span></p>
            </div>
            <div id="panel-player" class="col-6 pr-0">
                <div class="btn-toolbar text-right" role="toolbar">
                    <div class="btn-group m-0" role="group">
                        <button type="button" class="btn btn-sm btn-danger"
                                id="channelBtn"
                                disabled>
                            LIVE 시작
                        </button>
                        <button type="button" class="btn btn-sm btn-warning d-none"
                                id="forceCloseBtn"
                        >
                            강제 종료
                        </button>
                        <button type="button" class="btn btn-sm btn-info"
                                id="screenShareBtn" style="display:none;">
                            화면 공유 켜기
                        </button>
                        <a id="viewerModeBtn" role="button" href="#" target="_blank"
                           class="btn btn-sm btn-black text-white"
                           style="display:none;">시청자
                            모드 <i class="material-icons">open_in_new</i></a>
                        <button type="button" class="btn btn-sm btn-black"
                                id="pannelBtn">패널
                            감추기
                        </button>

                    </div>

                </div>
                <div class="live-player">
                    <video id="localVideo" class="remote-video center" autoplay
                           playsinline
                           muted
                           disablepictureinpicture="true" controlslist="nodownload"
                           x-webkit-airplay=""
                           webkit-playsinline=""
                           style="z-index:1;background-image: url('/assets/img/samples/coming-soon-2550190_1280.jpg'); background-size:cover;background-position: center center;"></video>

                </div>
            </div>
            <div id="panel-options" class="col-6 pl-0">
                <ul class="nav nav-pills nav-pills-black p-0" id="live-manage-tab"
                    role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#manage1"
                           role="tablist"
                           aria-expanded="true">
                            장치
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#manage2"
                           role="tablist"
                           aria-expanded="false">
                            채팅
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="manage1" aria-expanded="true">
                        <div class="container pt-3">
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="videoInputSelect">Video Input</label>
                                    <select id="videoInputSelect"
                                            class="form-control selectpicker"
                                            data-style="btn btn-link"></select>
                                </div>
                                <div class="form-group col-6">
                                    <label for="audioInputSelect">Audio Input</label>
                                    <select id="audioInputSelect"
                                            class="form-control selectpicker"
                                            data-style="btn btn-link"></select>
                                </div>
                                {{--                                                            <div class="form-group col-12">--}}
                                {{--                                                                <label for="liveTitle">LIVE 타이틀</label>--}}
                                {{--                                                                <input type="text" name="liveTitle" id="liveTitle"--}}
                                {{--                                                                       class="form-control"--}}
                                {{--                                                                       value="{{$booth->booth_title}}">--}}
                                {{--                                                            </div>--}}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane active" id="manage2" aria-expanded="true">
                        <div class="form-row">
                            <div class="col-9 pr-0">
                                <div class="form-group m-0">
                                    <div id="live-comment-inner"
                                         class="live-comment-inner">
                                        <div id="chatLogDiv" class="comment">
                                        </div>
                                        <div id="chatLogDownIcon"
                                             style="position: absolute;bottom: 0;right: 10px;display:none;">
                                            <button type="button"
                                                    class="btn btn-black btn-fab btn-fab-mini btn-round">
                                                <i class="material-icons">vertical_align_bottom</i>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <input id="chatMsg"
                                           class="form-control form-control-sm"
                                           type="text"
                                           placeholder="메시지"
                                           onkeyup="if(event.keyCode===13){sendMessage();}"
                                           disabled
                                    >
                                    <div class="input-group-append">
                                        <button type="button" id="sendMessageBtn"
                                                onclick="sendMessage()"
                                                class="btn btn-sm btn-black text-white pl-3 pr-3"
                                                style="" disabled>전송
                                        </button>
                                        <button id="autoScrollBtn"
                                                class="btn btn-sm btn-warning text-white pl-3 pr-3"
                                                style="" disabled>스크롤
                                        </button>
                                        <button id="clearChatBtn"
                                                class="btn btn-sm btn-danger text-white pl-3 pr-3"
                                                style="" disabled>삭제
                                        </button>
                                        {{--                                                                    <a onclick="autoScroll()"--}}
                                        {{--                                                                       class="btn btn-sm btn-danger text-white pl-3 pr-3"--}}
                                        {{--                                                                       style="">--}}
                                        {{--                                                                        <i class="material-icons">vertical_align_bottom</i></a>--}}
                                        {{--                                                                    <a onclick="clearChat()"--}}
                                        {{--                                                                       class="btn btn-sm btn-danger text-white pl-3 pr-3"--}}
                                        {{--                                                                       style="">--}}
                                        {{--                                                                        <i class="material-icons">delete</i></a>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 pl-0">
                                <div class="form-group m-0">
                                    <div id="viewersDiv" class="viewers">
                                    </div>
                                </div>
                                <div class="input-group">
                                    <input id="live-viewer-search" class="form-control"
                                           type="text"
                                           placeholder="시청자 검색">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="manage3">
                        <div class="form-row">
                            <div class="col-12">
                                <div class="input-group">
                                    <input id="live-banned-search" class="form-control"
                                           type="text"
                                           placeholder="차단 사용자 검색">
                                </div>
                                <div id="bannedDiv" class="viewers">
                                    <div class="list-group">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('page-script')
    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@remotemonster/sdk"></script>
    <script>
        /* remote-monster */
        let config = {
            credential: {
                serviceId: '{{ config('remotemonster.serviceId') }}',
                key: '{{ config('remotemonster.key') }}'
            },
            view: {
                remote: '#remoteVideo',
                local: '#localVideo',
            },
            media: {
                sendonly: true,
                audio: {
                    autoGainControl: false,
                    echoCancellation: false,
                    noiseSuppression: false,
                },
                video: {
                    width: {{ config('remotemonster.media.video.defaultWidth') }},
                    height: {{ config('remotemonster.media.video.defaultHeight') }},
                    codec: '{{ config('remotemonster.media.video.codec') }}',
                    maxBandwidth: {{ config('remotemonster.media.video.maxBandwidth') }},
// facingMode: 'user',             // 'user', 'environment'
                    frameRate: {
                        max: {{ config('remotemonster.media.video.frameRate.max') }},
                        min: {{ config('remotemonster.media.video.frameRate.min') }}
                    }
                },
            },
            dev: {
                logLevel: '{{ config('remotemonster.dev.logLevel') }}' //SILENT, ERROR, WARN, INFO, DEBUG, VERBOSE
            }
        };
        const payload = @json($payload);
        const booth_id = {{ $booth->id }};
        const expo_id = {{$booth->expo_id}};

        $(function () {
            $('#live-viewer-search').on('keyup', function () {
                var searchTerm = $(this).val().toLowerCase();
                $('#viewersDiv div').each(function () {
                    if ($(this).filter('[data-search-term *= ' + searchTerm + ']').length > 0 || searchTerm.length < 1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

            });

            $('#bannedDiv .list-group-item').each(function () {
                $(this).attr('data-search-term', $(this).children('button').text().toLowerCase());
            });

            $('#live-banned-search').on('keyup', function () {
                var searchTerm = $(this).val().toLowerCase();
                $('#bannedDiv .list-group-item').each(function () {
                    if ($(this).filter('[data-search-term *= ' + searchTerm + ']').length > 0 || searchTerm.length < 1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

            });

            $('#pannelBtn').on('click', function () {
                $(this).toggleClass('btn-black btn-secondary')
                $(this).text(($(this).hasClass('btn-black') ? '패널 감추기' : '패널 보이기'));
                var optionsPanel = $('#panel-options')
                var playerPanel = $('#panel-player')
                optionsPanel.toggle();
                playerPanel.toggleClass('col-6 col-12');
                playerPanel.toggleClass('pr-0');
            });
            $('#forceCloseBtn').on('click', function () {
                Swal2.fire({
                    text: '방송을 강제 종료 하시겠습니까?',
                    icon: 'warning',
                    showConfirmButton: true,
                    showCancelButton: true
                }).then(function (value) {
                    if (value.isConfirmed) {
                        $.post('/live/force-close', {'booth_id': booth_id})
                    }
                });
            })
        });
    </script>
    <script src="/assets/js/wordfilter.js"></script>
    <script src="{{ mix('/assets/js/liveCast.js') }}" type="text/javascript"></script>
@stop
