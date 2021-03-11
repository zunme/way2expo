@extends('desktop.layouts.none')
@section('css')
    <style>
        .form-check {
            margin-left: 3px;
        }
    </style>
@endsection
@section('body-class', '')
@section('header','')
@section('body')
    <div class="main">
        <div class="section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 text-center">
                        <div class="logo-img">
                            <img src="/assets/img/logo/bg-logo-transparency.png" width="300" alt="">
                        </div>
                        <h4 class="title mt-0">성공적인 비즈니스의 첫걸음 Way2EXPO</h4>
                        @if(session('kakao_id'))
                            <h4 class="text-info">카카오 처음 연동을 위해 로그인해주세요.</h4>
                        @endif
                    </div>
                    <div class="col-5 ml-auto mr-auto">
                        <form name="loginForm" method="post" action="{{ route('login') }}" class="needs-validation"
                              novalidate="">
                            @csrf
                            @if(session('kakao_id'))
                                <input type="hidden" name="kakao_id" value="{{session('kakao_id')}}">
                                <input type="hidden" name="kakao_connect" value="true">
                            @endif
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email" aria-required="true"
                                       placeholder="E-mail을 입력해주세요" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group pt-1">
                                <input type="password" class="form-control" name="password" id="password"
                                       aria-required="true" placeholder="비밀번호를 입력해주세요" required>
                            </div>
                            <div class="form-group form-check mt-1">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="remember_me"
                                               id="inlineCheckbox1" value="1"> 로그인 상태 유지
                                        <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group d-none">
                                <span class="text-danger">이메일과 비밀번호를 모두 입력해주세요.</span>
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-lg btn-black btn-fill btn-block btn-round">
                                    로그인
                                </button>
                            </div>
                        </form>
                        <div class="form-group m-0">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <a href="/find" class="btn btn-link">아이디, 비밀번호 찾기</a>
                                    |
                                    <form class="d-inline" method="post" action="/join">
                                        @csrf
                                        @if(session('kakao_id'))
                                            <input type="hidden" name="kakao_id" value="{{session('kakao_id')}}">
                                        @endif
                                        <button type="submit" class="btn btn-link text-center">회원가입</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(session('kakao_id'))
                @else
                    <div class="row">
                        <div class="col-5 ml-auto mr-auto text-center">
                            <hr class="hr-text" data-content="">
                            <a id="kakao-login-btn">카카오 로그인 팝업</a>
{{--                            <button id="kakao-login-btn-redirect" class="btn btn-link">카카오 로그인 리다이렉트</button>--}}
                            {{--                        <button class="btn btn-link btn-kakao-login" role="button">--}}
                            {{--                            <img src="/assets/img/buttons/kakao/kakao_login_medium_wide.png" class="img img-fluid"--}}
                            {{--                                 alt="">--}}
                            {{--                        </button>--}}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        $(function () {
            /* Login */
            var loginForm = $('form[name=loginForm]');
            loginForm.submit(function (e) {
                e.preventDefault();
                console.log(loginForm.serialize())
                $.ajax({
                    type: 'POST',
                    url: "{{ route('login') }}",
                    dataType: "json",
                    cache: false,
                    data: loginForm.serialize(),
                    success: function (res) {
                        window.location.href = res.url;
                    },
                });
            });

            {{--$('#kakao-login-btn').on('click', function () {--}}
            {{--    Kakao.Auth.login({--}}
            {{--        scope: 'account_email',--}}
            {{--        success: function (response) {--}}
            {{--            console.log(response);--}}
            {{--            Kakao.API.request({--}}
            {{--                url: '/v2/user/me',--}}
            {{--                success: function (res) {--}}
            {{--                    console.log(res)--}}
            {{--                },--}}
            {{--                fail: function (error) {--}}
            {{--                    alert(--}}
            {{--                        'login success, but failed to request user information: ' +--}}
            {{--                        JSON.stringify(error)--}}
            {{--                    )--}}
            {{--                },--}}
            {{--            })--}}
            {{--        },--}}
            {{--        fail: function (error) {--}}
            {{--            console.log(error);--}}
            {{--        }--}}
            {{--    });--}}
            {{--})--}}
            {{--$('#kakao-login-btn-redirect').on('click', function () {--}}
            {{--    Kakao.Auth.authorize({--}}
            {{--        redirectUri: '{{env('KAKAO_REDIRECT_URI')}}'--}}
            {{--    })--}}
            {{--});--}}

            if ($('input[name=kakao_id]').length < 1) {
                Kakao.Auth.createLoginButton({
                    container: '#kakao-login-btn',
                    success: function(authObj) {
                        Kakao.API.request({
                            url: '/v2/user/me',
                            success: function(res) {
                                $.post('/login',{kakao_id:res.id}).done(function(res){
                                    if (res.result === 'OK') {
                                        window.location.href = res.url;
                                    }
                                });
                            },
                            fail: function(error) {
                                alert(
                                    'login success, but failed to request user information: ' +
                                    JSON.stringify(error)
                                )
                            },
                        })
                    },
                    fail: function(err) {
                        alert('failed to login: ' + JSON.stringify(err))
                    },
                });
            }
        })
    </script>
@stop
