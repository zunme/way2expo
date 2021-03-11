@extends('desktop.layouts.none')
@section('body-class', 'raised')
@section('body')
    <div class="content-wrap">
        <div class="page-header-wrap">
            <div class="page-header header-filter header-s" data-parallax="false" style="background-image: url('/assets/img/page-header/key-2114046_1920.jpg');">
                <div class="container">
                    <div class="row">
                        <div class="col-12 ml-auto mr-auto text-center">
                            <h2 class="title mb-0">로그인</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <div class="main main-raised raised-s" style="max-width: 680px;">
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-10 ml-auto mr-auto">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">아이디</label>
                                    <input type="email" class="form-control" name="email" id="email" aria-required="true" placeholder="이메일을 입력하세요." value="{{ old('email') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">비밀번호</label>
                                    <input type="password" class="form-control" name="password" id="password" aria-required="true" placeholder="비밀번호를 입력하세요." required>
                                </div>
                                <div class="form-group form-check mt-4">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="remember_me" id="inlineCheckbox1" value="option1"> 자동로그인
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-info btn-fill btn-block btn-round">
                                    로그인
                                </button>
                            </div>
                            </form>
                            <div class="form-group m-0">
                                <div class="row">
                                    <div class="col-6 text-left">
                                        <a href="#" class="btn btn-link">아이디 찾기</a>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="#" class="btn btn-link text-center">비밀번호 찾기</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-text" data-content="아직 멤버가 아니신가요?">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-8 ml-auto mr-auto">
                            <a href="#" class="btn btn-lg btn-fill btn-block btn-outline-rose">회원가입</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
    </script>
@stop
