<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1190, maximum-scale=1.0">
    <meta name="robots" content=index"">
    <meta property="og:site_name" content="@yield('meta_site_name', env('APP_NAME') )"/>
    <meta property="og:type" content="website"/>
    @if( empty($meta) )
        <meta property="og:title" content="Way2EXPO 온라인 박람회">
        <meta property="og:image" content="{{\URL::to('/image/bg-logo-poster.png')}}">
        <meta property="og:description" content="Way2EXPO 온라인 박람회">
        <meta name="description" content="Way2EXPO 온라인 박람회">
        <meta name="keywords" content="way2expo,온라인박람회,박람회, @yield('meta_keywords','')">
        <meta property="og:url" content="{{\URL::to( '/' )}}">
    @else
        <meta name="description" content="{{$meta->description}}"/>
        <meta property="og:title" content="{{$meta->title}}"/>
        <meta property="og:description" content="{{$meta->description}}"/>
        <meta property="og:image" content="{{$meta->image}}"/>
        <meta property="og:url" content="{{$meta->url}}"/>
        <meta name="keywords" content="way2expo,온라인박람회,박람회, @yield('meta_keywords','')">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }}</title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Noto+Sans+KR:100,300,400,500,600,700,900|Material+Icons">
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link rel="stylesheet" type="text/css" href="/assets/css/material-kit.min.css?v=2.2.0">
    {{--    <link rel="stylesheet" type="text/css" href="/assets/css/material-kit.css?v=2.2.0">--}}
    <link rel="stylesheet" type="text/css" href="/assets/css/swal-bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ mix('/assets/css/style.css') }}">
    @yield('css')
    <style>
        .media .icon {
            margin: 0 auto;
            width: 46px;
            height: 46px;
            overflow: hidden;
            text-align: right;
        }

        .navbar {
            min-width: 1024px;
        }

        .navbar .notification-list .list-group a:hover {
            box-shadow: none !important;
            background-color: #fff !important;
            color: inherit !important;
        }

        .navbar .navbar-nav .nav-item .nav-link a {
            color: inherit;
        }

        .navbar .nav-search .input-group {
            width: 300px;

        }

        .navbar .nav-search .input-group input {
            border-radius: 20px;
            padding-right: 15px;
            padding-left: 15px;
            z-index: 0;
        }

        .navbar .nav-search .input-group-append {
            margin-left: -15px;
        }

        .navbar .nav-search .input-group-append button {
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .navbar .navbar-nav .nav-item .nav-icon {
            padding: 15px 10px;
        }

        .navbar .navbar-nav .nav-item .nav-icon.dropdown-toggle::after {
        }

        .navbar .navbar-nav .nav-item .nav-icon .material-icons {
            font-size: 1.5rem;
            margin: 0;
        }

        .navbar .navbar-nav .nav-item .nav-icon.nav-notifications .noti-cnt {
            position: absolute;
            top: 5px;
            right: -9px;
            z-index: 2;
            padding: 5px 10px;
            border-radius: 20px !important;
        }

        .navbar .navbar-nav .nav-item .nav-icon.nav-logout .material-icons {
            top: 2px !important;
        }

        .navbar .navbar-nav .nav-item .nav-icon.nav-settings .material-icons {
            font-size: 1.4rem;
            top: 2px;
        }

        .navbar .navbar-nav .nav-item .nav-icon.nav-logout .material-icons {
            margin-top: -5px;
            top: 3px;
            position: relative;
            margin-right: 3px;
        }

        .content-wrap.nav-fixed {
            padding-top: 70px;
        }

        /*
         *  STYLE 1
         */
        .notification-list::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            background-color: #F5F5F5;
        }

        .notification-list::-webkit-scrollbar {
            background: transparent;
            width: 2px;
            background-color: transparent;
        }

        .notification-list::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: #555;
        }
    </style>
    <!--[if IE]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js"
            integrity="sha512-kp7YHLxuJDJcOzStgd6vtpxr4ZU9kjn77e6dBsivSz+pUuAuMlE2UTdKB7jjsWT84qbS8kdCWHPETnP/ctrFsA=="
            crossorigin="anonymous"></script>
    <script
        src="https://polyfill.io/v3/polyfill.min.js?features=URL%2fetch%2CArray.prototype.filter%2CDocument%2CSymbol.asyncIterator%2CObject.assign%2CArray.prototype.includes%2CArray.from"
        async defer></script>
    <![endif]-->
    @yield('head-script')
</head>
<body class="@yield('body-class','') antialiased">
<div class="wrap" style="overflow:hidden;min-width: 1024px;">
    @section('navbar')
        <nav class="navbar navbar-expand fixed-top bg-white mb-0">
            <div class="container">
                <a href="/" role="button" class="navbar-brand">
                    <div class="logo-small ml-2">
                        <img src="/assets/img/logo/logo-way2expo.svg" class="img-fluid">
                    </div>
                </a>
                <form name="nav-searchForm" class="nav-search form-inline mr-auto" method="get" action="/search">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="search" name="q" class="form-control" placeholder="검색어를 입력해주세요."
                                   value="{{ urldecode(request('q')) }}">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-black btn-search" type="submit">
                                    <i class="material-icons">search</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="collapse navbar-collapse-none">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        </li>
                        <li class="nav-item">
                            <a role="button" class="nav-link" href="{{ route('expo') }}">
                                박람회
                            </a>
                        </li>
                        <!--
                        <li class="nav-item">
                            <a role="button" class="nav-link" href="">
                                참여기업
                            </a>
                        </li>
                        -->
                        <li class="nav-item">
                            <a role="button" class="nav-link" href="/service">
                                서비스 소개
                            </a>
                        </li>
                        @guest
                            <li class="nav-item">
                                <div class="nav-link">
                                    <a href="{{route('login')}}" title="로그인">로그인</a>
                                    /
                                    <a href="{{route('join.index')}}" role="button" title="회원가입">회원가입</a>
                                </div>
                            </li>
                        @endguest
                        @auth()
                            <li class="nav-item position-relative dropdown">
                                <a class="nav-link nav-icon nav-notifications" href="#" id="notifications"
                                   data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">notifications_none</i>
                                    <span
                                        class="badge badge-danger rounded noti-cnt">0</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-large"
                                     aria-labelledby="navbarDropdown">
                                    <div class="list-group">
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item position-relative">
                                <a href="#" role="button" class="dropdown-toggle nav-link nav-icon nav-mypage"
                                   data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">person_outline</i>

                                </a>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <h6 class="dropdown-header">{{Auth::user()->name}} 님</h6>
                                    <div class="dropdown-body">
                                        <div class="dropdown-divider"></div>
                                        @if (Auth::user()->company_id > 0)
                                            <a class="dropdown-item" href="/my/meeting/receive">신청받은 1:1화상회의</a>
                                            <a class="dropdown-item" href="/my/exchange/receive">신청받은 비즈니스문의</a>
                                            <div class="dropdown-divider"></div>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('my.info') }}">내 정보</a>
                                        <a class="dropdown-item" href="/my/card">내 명함 관리</a>
                                        {{--                                        <a class="dropdown-item" href="/my/notifications">알림 내역</a>--}}
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="/my/latest?m=expo">내가 본 박람회</a>
                                        <a class="dropdown-item" href="/my/latest?m=booth">내가 본 부스</a>
                                        <a class="dropdown-item" href="/my/favorites">즐겨찾기</a>
                                        <a class="dropdown-item" href="/my/dibs">찜</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="/my/meeting/send">1:1 화상회의</a>
                                        <a class="dropdown-item" href="/my/exchange/send">비즈니스 문의</a>
                                    </div>
                                </div>
                            </li>
                            @if (Auth::user()->company_id > 0)
                                @php($company = \App\Models\Company::find(Auth::User()->company_id))
                                <li class="nav-item position-relative">
                                    <a href="{{ route('my.booth') }}" role="button"
                                       class="nav-link nav-icon nav-settings" data-toggle="tooltip" title="부스 관리"
                                    >
                                        <i class="material-icons">settings</i>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    <a href="#" role="button" onclick="this.parentNode.submit();"
                                       class="nav-link nav-icon nav-logout">
                                        <i class="material-icons">exit_to_app</i>
                                    </a>
                                </form>
                            </li>
                        @endauth
                        <li class="nav-item position-relative">
                            <a href="#" class="nav-link nav-icon" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                SNS
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <div class="dropdown-header">
                                    <h6 class="mb-0">Way2EXPO 공식 SNS 채널</h6>
                                </div>
                                <div class="dropdown-body d-flex align-items-center"
                                     style="width: 200px;padding: 15px 15px;">
                                    <div class="container text-center">
                                        <a href="https://www.youtube.com/channel/UCE2NAEyZ4__hJmD-F_2zJPA"
                                           target="_blank" class="btn btn-social btn-just-icon  btn-youtube">
                                            <i class="fa fa-youtube"></i>
                                        </a>
                                        <a href="https://blog.naver.com/way2expo" target="_blank"
                                           class="btn btn-social btn-just-icon">
                                            <img src="/image/sns/naverblog.png" alt="" class="img img-fluid align-top">
                                        </a>
                                        {{--                                        <a href="https://instagram.com/way2expo" target="_blank" class="btn btn-social btn-just-icon bg-transparent">--}}
                                        {{--                                            <img src="/image/sns/instagram.png" alt="" class="img img-fluid align-top">--}}

                                        {{--                                        </a>--}}
                                        {{--                                        <a href="button" class="btn btn-social btn-just-icon  btn-facebook">--}}
                                        {{--                                            <i class="fa fa-facebook" style="font-size:28px;"> </i>--}}
                                        {{--                                        </a>--}}
                                        {{--                                        <button type="button" class="btn btn-social btn-just-icon">--}}
                                        {{--                                            <img src="/image/sns/kakaostory.png" alt="" class="img img-fluid align-top">--}}
                                        {{--                                        </button>--}}
                                        {{--                                        <button type="button" class="btn btn-social btn-just-icon">--}}
                                        {{--                                            <img src="/image/sns/kakaotalk.png" alt="" class="img img-fluid align-top">--}}
                                        {{--                                        </button>--}}
                                        {{--                                        <button type="button" class="btn btn-social btn-just-icon">--}}
                                        {{--                                            <img src="/image/sns/naverband.png" alt="" class="img img-fluid align-top">--}}
                                        {{--                                        </button>--}}
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
    @show
    <div class="content-wrap nav-fixed">
        @section('header')
            @include('desktop.layouts.header')
        @show
        @yield('body')
    </div>
    @section('footer')
        <footer class="footer footer-default pb-5">
            <div class="container">
                <nav class="text-left">
                    <ul>
                        <li>
                            <a href="/service">
                                서비스 소개
                            </a>
                        </li>
                        <li>
                            <a href="/notice">
                                공지사항
                            </a>
                        </li>
                        <li>
                            <a href="/terms-use">
                                이용약관
                            </a>
                        </li>
                        <li>
                            <a href="/terms-privacy">
                                개인정보처리방침
                            </a>
                        </li>
                        <li>
                            <a href="/terms-email">
                                이메일무단수집거부
                            </a>
                        </li>
                        <li>
                            <a href="/contact">
                                기업제휴문의
                            </a>
                        </li>
                    </ul>

                </nav>
                <hr>
                <div class="row text-left ">
                    <div class="col-md-6">
                        <h3 class="title mt-0 mb-5">(주)비욘텍</h3>
                        <p>인천 서구 마중 5로 17 | 대표 유원식</p>
                        <p>사업자등록번호 131-86-30990</p>
                        <p>Copyright 2020 way2expo co.ltd. All rights reserved</p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="title m-0">고객센터</h5>
                        <h3 class="title mt-0 mb-3">1577-8764</h3>
                        <p>support@way2expo.com</p>
                        <p>운영시간 : 평일 08:30 ~ 17:30 (12:00 ~ 13:00 점심시간)</p>
                    </div>
                </div>
            </div>
        </footer>
    @show
</div>
<!-- Modal -->
<div class="modal fade" id="bizFormModal" tabindex="-1" role="dialog" aria-labelledby="bizForm" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title modal-title m-0" id="bizForm">기업회원 전환 안내</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="info text-center">
                    <div class="icon">
                        <button class="btn btn-black btn-lg btn-fab btn-round btn-disabled">
                            <i class="material-icons">business</i>
                        </button>
                    </div>
                    <h5 class="info-title mb-0">온라인 부스는 기업회원 전용 메뉴입니다.</h5>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-sm" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" id="modal-sm-area">
    </div>
</div>
<div class="modal fade" id="modal-lg" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" id="modal-lg-area">
    </div>
</div>

<div class="modal fade" id="modal-xl" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" id="modal-xl-area">

    </div>
</div>

<div class="modal fade" id="modal-default" role="dialog" aria-hidden="true" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" id="modal-default-area">
    </div>
</div>

@yield('page-after')
<script>
    @auth
    let isLogined = true;
    @endauth
    @guest
    let isLogined = false;
    @endguest
</script>
<!--   Core JS Files   -->
<script src="/assets/js/core/jquery.min.js" type="text/javascript"></script>
<script src="/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="/assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
<script src="/assets/js/plugins/jquery.serializeObject.min.js" type="text/javascript"></script>
<script src="/assets/js/plugins/moment.min.js"></script>
<script src="/assets/js/plugins/sweetalert2.all.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/toastr.min.js"></script>
<script src="/assets/js/material-kit.js?v=2.2.0" type="text/javascript"></script>
<script src="/assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
<script src="//cdn.jsdelivr.net/npm/pouchdb@7.2.1/dist/pouchdb.min.js"></script>
<script src="{{ mix('/assets/js/web.js') }}" type="text/javascript"></script>
<script src="{{ mix('/assets/js/desktop_bootstrap.js') }}" type="text/javascript"></script>

<script src="/packages/js/kakao.min.js"></script>
<script>
    var myexpoDB = new PouchDB('expolist');
    var myBootmDB = new PouchDB('boothlist');
    var snsDefaultImage = '{{ \URL::to( Config::get('expo.default_image') ) }}';
    var snsDefaultUrl = '{{ \URL::to('/')}}';
    let global_noti_cnt = 0;

    $(function () {
        @if(session('errors') && !empty(session('errors')->first('msg')))
        confirmPopup('{!! session('errors')->first('msg') !!}', 'error')
        @endif
        var navSearchForm = $('form[name=nav-searchForm]');
        navSearchForm.submit(function (e) {
            let query = $(this).find('input[name=q]').val();
            var reg = /[\{\}\[\]\/?.,;:|\)*~`!^\-_+<>@\#$%&\\\=\(\'\"]/gi
            if (!reg.test(query) && query.length > 1) {
                return;
            }
            Swal2.fire({
                text: '검색어는 특수문자를 제외한 2자이상 입니다.',
                icon: 'error',
                showConfirmButton: true,
                timer: 3000,
                didOpen: function (toast) {
                    toast.addEventListener('mouseenter', Swal2.stopTimer)
                    toast.addEventListener('mouseleave', Swal2.resumeTimer)
                },
                didClose: function () {
                    $(this).find('input[name=q]').focus();
                }
            })
            e.preventDefault();
        });

        if (isLogined) {
            $('.nav-notifications').closest('.dropdown').on('show.bs.dropdown', function () {
                let btn = $(this);
                let container = btn.closest('.dropdown').find('.dropdown-menu .list-group')
                let template = Handlebars.compile($("#template-notification").html());
                $.post('/my/notification-list', {start: 0, length: 5, simple: true}).done(function (res) {
                    container.html(template({data: res.data}));
                    global_noti_cnt = 0;
                    $(".noti-cnt").each(function () {
                        $(this).text(global_noti_cnt);
                    })

                })
            })
        }
    });
    Kakao.init('{{ Config::get('expo.kakaokey') }}');
</script>
@auth()
    @if(Auth::user()->company_id > 0)
        <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
        <script>
            $.get('/my/noticount').done(function(cnt){
                global_noti_cnt = cnt;
                $(".noti-cnt").each(function () {
                    $(this).text(global_noti_cnt);
                })
            })
            {{--Echo.private('noti.{{Auth::user()->id}}')--}}
                {{--    .listen('NotiEvent', (e) => {--}}
                {{--        notificationPopup(e)--}}
                {{--        ++global_noti_cnt;--}}
                {{--        $(".noti-cnt").each(function () {--}}
                {{--            $(this).text(global_noti_cnt);--}}
                {{--        })--}}
                {{--    });--}}
            if (Notification.permission === "granted") {
                {{--const beamsClient = new PusherPushNotifications.Client({--}}
                {{--    instanceId: '{{\Config::get('beam.id')}}',--}}
                {{--});--}}

                {{--beamsClient.start()--}}
                {{--    .then(beamsClient => beamsClient.getDeviceId())--}}
                {{--    .then(deviceId =>--}}
                {{--        console.log('Successfully registered with Beams. Device ID:', deviceId)--}}
                {{--    )--}}
                {{--    .then(() => beamsClient.addDeviceInterest('company_{{Auth::user()->company_id}}'))--}}
                {{--    .then(() => console.log('company:'+{{Auth::user()->company_id}}+' Successfully registered and subscribed!')).catch(console.error);--}}

            } else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(permission => {

                });
            }

        </script>
    @endif
@endauth

@yield('page-script')
@verbatim
    <script id="template-notification" type="text/x-handlebars-template">
    {{#if (gt data.length 0) }}
        {{#each data}}
        <a href="{{notificationLink data.target}}" class="list-group-item list-group-item-action">
            {{data.title}}
        {{data.content}}
        {{time}}
        </a>
        {{/each}}
    {{else}}
        <div class="info text-center not-found">
            <div class="icon">
                <button class="btn btn-danger btn-lg btn-fab btn-round btn-disabled">
                    <i class="material-icons">search_off</i>
                </button>
            </div>
            <h4 class="info-title">알림 내역이 없습니다.</h4>
        </div>
    {{/if}}
    </script>
@endverbatim

</body>
</html>
