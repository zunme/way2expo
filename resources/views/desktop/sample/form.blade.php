@extends('desktop.layouts.none')
@section('body-class', 'raised')
@section('body')
    <div class="content-wrap" style="min-height:100vh;">
        <div class="page-header-wrap">
            <div class="page-header header-filter header-xs" data-parallax="false"
                 style="background-image: url('/assets/img/page-header/the-office-of-the-3814956_1280.jpg');background-position: bottom center;">
                <div class="container">
                    <div class="row">
                        <div class="col-12 ml-auto mr-auto text-center">
                            <h2 class="title mb-0">타이틀</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                     xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <div class="main main-raised raised-xs">
            <div class="section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            @guest
                                <h4 class="title">로그인</h4>
                                <form name="login" method="post" action="{{ route('login') }}">
                                    @csrf
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="이메일"
                                               value="support@way2expo.com" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" value="qweqwe123"
                                               placeholder="비밀번호" required>
                                    </div>
                                    <div class="form-group form-check">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="remember_me"
                                                       checked> 자동로그인
                                                <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-outline-black btn-block btn-ajax">로그인</button>
                                </form>
                            @endguest
                            <h4 class="title">로그아웃</h4>
                            <form method="post" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-black btn-block">로그아웃</button>
                            </form>
                            @guest
                                <h4 class="title">회원가입</h4>
                                <form name="register" method="post" action="{{ route('member.register') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>이메일</label>
                                        <input type="email" name="email" class="form-control" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label>비밀번호</label>
                                        <input type="password" name="password" class="form-control" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label>비밀번호 확인</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                               value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label>이름</label>
                                        <input type="text" name="name" class="form-control" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label>휴대전화</label>
                                        <input type="tel" name="tel" class="form-control" value="" required>
                                    </div>
                                    <div class="form-group m-0">
                                        <div class="form-check form-check-radio form-check-inline">
                                            <label>Email 수신여부</label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="agree_email"
                                                       value="Y" checked> 수신함
                                                <span class="circle"><span class="check"></span></span>
                                            </label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="agree_email"
                                                       value="N"> 수신안함
                                                <span class="circle"><span class="check"></span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check form-check-radio form-check-inline">
                                            <label>SMS 수신여부</label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="agree_sms" value="Y"
                                                       checked> 수신함
                                                <span class="circle"><span class="check"></span></span>
                                            </label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="agree_sms" value="N">
                                                수신안함
                                                <span class="circle"><span class="check"></span></span>
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-outline-black btn-block btn-ajax">회원 가입</button>
                                </form>
                            @endguest
                            @auth
                                <h4 class="title">내 정보 수정</h4>
                                <form name="edit" method="post" action="{{ route('my.info.edit') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>이메일</label>
                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                               disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>이름</label>
                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                                               disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>휴대전화</label>
                                        <input type="tel" name="tel" class="form-control" value="{{ $user->tel }}"
                                               required>
                                    </div>
                                    <div class="form-group m-0">
                                        <div class="form-check form-check-radio form-check-inline">
                                            <label>Email 수신여부</label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="agree_email"
                                                       value="Y"{{($user->agree_email=='Y')?'checked':''}}> 수신함
                                                <span class="circle"><span class="check"></span></span>
                                            </label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="agree_email"
                                                       value="N"{{($user->agree_email=='N')?'checked':''}}> 수신안함
                                                <span class="circle"><span class="check"></span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check form-check-radio form-check-inline">
                                            <label>SMS 수신여부</label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="agree_sms"
                                                       value="Y" {{($user->agree_sms=='Y')?'checked':''}}> 수신함
                                                <span class="circle"><span class="check"></span></span>
                                            </label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="agree_sms"
                                                       value="N" {{($user->agree_sms=='N')?'checked':''}}> 수신안함
                                                <span class="circle"><span class="check"></span></span>
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-outline-black btn-block btn-ajax">정보 수정</button>
                                </form>
                                @if (!empty($company))
                                <h4 class="title">회사 정보 수정</h4>
                                <form name="companyEdit" method="post" action="{{ route('my.company.edit') }}">
                                    @csrf
                                    <input type="hidden" name="company_id" value="">
                                    <div class="form-group">
                                        <label>회사명</label>
                                        <input type="text" name="company_name" class="form-control" value="{{ $company->company_name }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>전화번호 1</label>
                                        <input type="text" name="company_tel1" class="form-control" value="{{ $company->company_tel1 }}">
                                    </div>
                                    <div class="form-group">
                                        <label>전화번호 2</label>
                                        <input type="text" name="company_tel2" class="form-control" value="{{ $company->company_tel2 }}">
                                    </div>
                                    <div class="form-group">
                                        <label>주소</label>
                                        <input type="text" name="company_address1" class="form-control" value="{{ $company->company_address1 }}">
                                        <input type="text" name="company_address2" class="form-control" value="{{ $company->company_address2 }}">
                                    </div>
                                    <div class="form-group">
                                        <label>홈페이지</label>
                                        <input type="text" name="company_url" class="form-control" value="{{ $company->company_url }}">
                                    </div>
                                    <div class="form-group">
                                        <label>카테고리</label>
                                        <input type="text" name="company_category1" class="form-control" value="{{ $company->company_category1 }}">
                                    </div>
                                    <div class="form-group">
                                        <label>태그</label>
                                        <div class="row">
                                            <div class="col-4">
                                                <input type="text" name="tags[]" class="form-control" placeholder="태그1">
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="tags[]" class="form-control" placeholder="태그2">
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="tags[]" class="form-control" placeholder="태그3">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-outline-black btn-block btn-ajax">회사 정보 수정</button>
                                </form>
                                @endif
                                <h4 class="title">즐겨찾기</h4>
                                <button class="btn btn-sm" data-id="1" onclick="change_favorite(this);">추가</button>
                                <h4 class="title">부스 개설하기</h4>
                                    <form name="save" method="post" action="{{ route('my.booth.save') }}">
                                        @csrf
                                        @if ( !empty($booth->id) )
                                            <input type="hidden" name="id" value={{ $booth->id }}>
                                        @endif
                                        <h4 class="form-title">부스 기본 정보</h4>
                                        <div class="form-group">
                                            <label>부스 타이틀</label>
                                            <input type="text" name="booth_title" class="form-control"
                                                   placeholder="제목을 입력해주세요(최대 50자)" value="">
                                        </div>
                                        <div class="form-group">
                                            <label>부스 소개</label>
                                            <textarea class="form-control" name="booth_intro" rows="3"
                                                      placeholder="부스소개를 작성해 주세요.&#13;&#10;(최대 1,000자)"></textarea>
                                        </div>
                                        <div class="form-group p-0">
                                            <div class="row">
                                                <div class="col-4">
                                                    <input type="text" name="tags[]" class="form-control" placeholder="태그1" value="">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" name="tags[]" class="form-control" placeholder="태그2" value="">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" name="tags[]" class="form-control" placeholder="태그3" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="form-title">동영상</h4>
                                        <input type="hidden" name="booth_movtype" value="">
                                        <div class="form-group">
                                            <ul class="nav nav-pills nav-pills-black p-0" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link nav-link-sm active" data-toggle="tab" data-type="false" href="#booth_movtype1"
                                                       role="tablist" aria-expanded="true">
                                                        Off
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link nav-link-sm" data-toggle="tab" data-type="mp4" href="#booth_movtype2"
                                                       role="tablist" aria-expanded="false">
                                                        동영상 업로드
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link nav-link-sm" data-toggle="tab" data-type="youtube" href="#booth_movtype3"
                                                       role="tablist" aria-expanded="false">
                                                        YouTube 동영상<i class="fa fa-youtube-play"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="booth_movtype1" aria-expanded="false">
                                            </div>
                                            <div class="tab-pane" id="booth_movtype2" aria-expanded="false">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group form-file-upload form-file-simple">
                                                            <label>사용자 동영상 업로드</label>
                                                            <input type="text" name="booth_mp4_url" class="form-control inputFileVisible"
                                                                   placeholder="동영상 업로드">
                                                            <input type="file" name="booth_youtube_url"
                                                                   class="inputFileHidden"
                                                                   accept="image/x-png,image/gif,image/jpeg"
                                                                   data-target="imgInp_target_pc">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="booth_movtype3" aria-expanded="false">
                                                <div class="row p-0">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>YouTube 동영상</label>
                                                            <input type="text" name="booth_youtube_url" class="form-control"
                                                                   placeholder="https://youtu.be/xxxxxxx">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="form-title">이미지 첨부</h4>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group form-file-upload form-file-simple">
                                                    <label>PC용 사진</label>
                                                    <input type="text" class="form-control inputFileVisible"
                                                           placeholder="PC 이미지 업로드">
                                                    <input type="file" name="selectimg_pc" class="inputFileHidden"
                                                           accept="image/x-png,image/gif,image/jpeg"
                                                           data-target="imgInp_target_pc"
                                                           onchange="updatePhotoPreview(this);">
                                                </div>
                                                <div id="imgInp_target_pc">
                                                    <img src="" class="imgInp-new-img inboximg d-none">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group form-file-upload form-file-simple">
                                                    <label>모바일용 사진</label>
                                                    <input type="text" class="form-control inputFileVisible"
                                                           placeholder="모바일 이미지 업로드">
                                                    <input type="file" name="selectimg_mobile" class="inputFileHidden">
                                                </div>
                                            </div>
                                        </div>
                                        <!--
                                         모집중인 박람회가 몇개 없으니 좀더 직관적으로 (Select 나 박스형태 - 검색폼은 아니다.)
                                         -->
                                        <h4 class="form-title">박람회 선택</h4>
                                        <input type="hidden" name="expo_id" value=1>
                                        <!--<div class="input-group">
                                            <input type="text" class="form-control" placeholder="검색어를 입력해주세요.">
                                            <div class="input-group-append">
                                                <button class="btn btn-sm btn-black btn-search" type="button" onclick="searchExpo();">
                                                    <i class="material-icons">search</i>
                                                </button>
                                            </div>
                                        </div>
                                        -->
                                        {{--<button type="button" class="btn btn-sm btn-black" data-toggle="modal" data-target="#searchModal">박람회 검색</button>--}}
                                        <button type="submit" class="btn btn-outline-black btn-block btn-ajax">부스 만들기</button>
                                    </form>
{{--
                                <h4 class="title">부스 수정하기</h4>
                                <form name="save" method="post" action="{{ route('my.booth.save') }}"c>
                                    @csrf
                                    @if ( !empty($booth->id) )
                                        <input type="hidden" name="id" value="{{ $booth->id }}">
                                    @endif
                                    <h4 class="form-title">부스 기본 정보</h4>
                                    <div class="form-group">
                                        <label>부스 타이틀</label>
                                        <input type="text" name="booth_title" class="form-control"
                                               placeholder="제목을 입력해주세요(최대 50자)" value="{{ $booth->booth_title }}">
                                    </div>
                                    <div class="form-group">
                                        <label>부스 소개</label>
                                        <textarea class="form-control" name="booth_intro" rows="3"
                                                  placeholder="부스소개를 작성해 주세요.&#13;&#10;(최대 1,000자)">{{ $booth->booth_intro }}</textarea>
                                    </div>
                                    <div class="form-group p-0">
                                        <div class="row">
                                            <div class="col-4">
                                                <input type="text" name="tags[]" class="form-control" placeholder="태그1" value="{{ ($booth->tags->count() > 0)?$booth->tags->get(0)->name:"" }}">
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="tags[]" class="form-control" placeholder="태그2" value="{{ ($booth->tags->count() > 1)?$booth->tags->get(1)->name:"" }}">
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="tags[]" class="form-control" placeholder="태그3" value="{{ ($booth->tags->count() > 2)?$booth->tags->get(2)->name:"" }}">
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="form-title">동영상</h4>
                                    <input type="hidden" name="booth_movtype" value="">
                                    <div class="form-group">
                                        <ul class="nav nav-pills nav-pills-black p-0" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link nav-link-sm active" data-toggle="tab" data-type="false" href="#booth_movtype1"
                                                   role="tablist" aria-expanded="true">
                                                    Off
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link nav-link-sm" data-toggle="tab" data-type="mp4" href="#booth_movtype2"
                                                   role="tablist" aria-expanded="false">
                                                    동영상 업로드
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link nav-link-sm" data-toggle="tab" data-type="youtube" href="#booth_movtype3"
                                                   role="tablist" aria-expanded="false">
                                                    YouTube 동영상<i class="fa fa-youtube-play"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="booth_movtype1" aria-expanded="false">
                                        </div>
                                        <div class="tab-pane" id="booth_movtype2" aria-expanded="false">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group form-file-upload form-file-simple">
                                                        <label>사용자 동영상 업로드</label>
                                                        <input type="text" name="booth_mp4_url" class="form-control inputFileVisible"
                                                               placeholder="동영상 업로드">
                                                        <input type="file" name="booth_youtube_url"
                                                               class="inputFileHidden"
                                                               accept="image/x-png,image/gif,image/jpeg"
                                                               data-target="imgInp_target_pc">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="booth_movtype3" aria-expanded="false">
                                            <div class="row p-0">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>YouTube 동영상</label>
                                                        <input type="text" name="booth_youtube_url" class="form-control"
                                                               placeholder="https://youtu.be/xxxxxxx">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="form-title">이미지 첨부</h4>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group form-file-upload form-file-simple">
                                                <label>PC용 사진</label>
                                                <input type="text" class="form-control inputFileVisible"
                                                       placeholder="PC 이미지 업로드">
                                                <input type="file" name="selectimg_pc" class="inputFileHidden"
                                                       accept="image/x-png,image/gif,image/jpeg"
                                                       data-target="imgInp_target_pc"
                                                       onchange="updatePhotoPreview(this);">
                                            </div>
                                            <div id="imgInp_target_pc">
                                                <img src="" class="imgInp-new-img inboximg d-none">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group form-file-upload form-file-simple">
                                                <label>모바일용 사진</label>
                                                <input type="text" class="form-control inputFileVisible"
                                                       placeholder="모바일 이미지 업로드">
                                                <input type="file" name="selectimg_mobile" class="inputFileHidden">
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="form-title">박람회 선택</h4>
                                    <input type="hidden" name="expo_id" value="1">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="검색어를 입력해주세요.">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-black btn-search" type="button" onclick="searchExpo();">
                                                <i class="material-icons">search</i>
                                            </button>
                                        </div>
                                    </div>
                                    --}}
{{--<button type="button" class="btn btn-sm btn-black" data-toggle="modal" data-target="#searchModal">박람회 검색</button>--}}{{--

                                    <button type="submit" class="btn btn-outline-black btn-block">부스 만들기</button>
                                </form>
--}}
                            @endauth
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchExpoModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="title modal-title m-0" id="searchExpoModal">박람회 검색</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-inline ml-auto">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="검색어를 입력해주세요.">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-black btn-search" type="button">
                                    <i class="material-icons">search</i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-black">전환신청하기</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">닫기</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('page-script')
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="/assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>
    <script>
        $(function () {
            /* Login */
            var loginForm = $('form[name=login]');
            loginForm.find("button[type=submit]").click(function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('login') }}",
                    dataType: "json",
                    cache: false,
                    data: loginForm.serialize(),
                    success: function (res) {
                        window.location.replace(res.url);
                    },
                    error: function (err) {
                        ajaxError(err)
                    },
                });
            });

            /* Register */
            var registerForm = $('form[name=register]');
            registerForm.find("button[type=submit]").click(function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('member.register') }}",
                    data: registerForm.serialize(),
                    success: function (res) {
                        window.location.replace(res.url);
                    },
                    error: function (err) {
                        ajaxError(err)
                    }
                });
            });

            /* Edit */
            var editForm = $('form[name=edit]');
            editForm.find("button[type=submit]").click(function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('my.info.edit') }}",
                    data: editForm.serialize(),
                    success: function (res) {
                        if (res.result == 'OK') {
                            Swal2.fire({
                                text: res.msg,
                                icon: 'success',
                                showConfirmButton: true,
                            });
                        } else {
                            toastr.warning(res.msg)
                        }

                    },
                    error: function (err) {
                        ajaxError(err)
                    }
                });
            });

            /* CompanyEdit */

            /* Booth */
            var saveForm = $('form[name=save]');
            saveForm.find("button[type=submit]").click(function (e) {
                e.preventDefault();
                var formData = new FormData(saveForm[0]);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('my.booth.save') }}",
                    dataType: "JSON",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (res) {
                        if (res.result === 'OK') {
                            Swal2.fire({
                                text: res.msg,
                                icon: 'success',
                                showConfirmButton: true,
                            });

                        } else {
                            Swal2.fire({
                                text: res.msg,
                                icon: 'error',
                                showConfirmButton: true,
                            });
                        }

                    },
                    error: function (err) {
                        ajaxError(err)
                    }
                });
            });

            /* create tabs event */
            $('form[name=save] a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                e.target // newly activated tab
                e.relatedTarget // previous active tab
                // Todo: Set booth_movtype value
                var input = $('input[name=booth_movtype]');
                var typeValue = $(e.target).data('type');
                input.val((typeValue === false)?'':typeValue);

            })
            $('form[name=save] a[data-toggle="tab"]').on('hide.bs.tab', function (e) {
                e.target // newly activated tab
                e.relatedTarget // previous active tab
                // Todo: Initialize
            })

            /* Fake */
            var values = registerForm.serializeArray();
            var pass = 'qweqwe123';

            for (index = 0; index < values.length; ++index) {
                var target = registerForm.find('input[name=' + values[index].name + ']');
                if (values[index].name === "password")
                    target.val(pass);
                if (values[index].name === "password_confirmation")
                    target.val(pass);
                if (values[index].name === "name")
                    target.val(fakeName());
                if (values[index].name === "email")
                    target.val(fakeEmail());
                if (values[index].name === "tel")
                    target.val(fakeTel());
            }

        })

        function fakeId(length) {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }

        function fakeName() {
            let text = "";
            let first = "김이박최정강조윤장임한오서신권황안송류전홍고문양손배조백허유남심노정하곽성차주우구신임나전민유진지엄채원천방공강현함변염양변여추노도소신석선설마주연방위표명기반왕모장남탁국여진구";
            let last = "가강건경고관광구규근기길나남노누다단달담대덕도동두라래로루리마만명무문미민바박백범별병보사산상새서석선설섭성세소솔수숙순숭슬승시신아안애엄여연영예오옥완요용우원월위유윤율으은의이익인일자잔장재전정제조종주준중지진찬창채천철초춘충치탐태택판하한해혁현형혜호홍화환회효훈휘희운모배부림봉혼황량린을비솜공면탁온디항후려균묵송욱휴언들견추걸삼열웅분변양출타흥겸곤번식란더손술반빈실직악람권복심헌엽학개평늘랑향울련";

            for (var i = 0; i < 1; i++)
                text += first.charAt(Math.floor(Math.random() * first.length));
            for (var i = 0; i < 2; i++)
                text += last.charAt(Math.floor(Math.random() * last.length));

            return text;
        }

        function fakeEmail() {
            var strValues = "abcdefg12345";
            var strEmail = "";
            var strTmp;
            for (var i = 0; i < 10; i++) {
                strTmp = strValues.charAt(Math.round(strValues.length * Math.random()));
                strEmail = strEmail + strTmp;
            }
            strTmp = "";
            strEmail = strEmail + "@";
            for (var j = 0; j < 8; j++) {
                strTmp = strValues.charAt(Math.round(strValues.length * Math.random()));
                strEmail = strEmail + strTmp;
            }
            strEmail = strEmail + ".com"
            return strEmail;
        }

        function fakeTel() {
            let phone = "010";
            while (phone.length < 11) phone += Math.floor(Math.random() * 10);
            phone = phone.replace(/(^02|^0505|^1[0-9]{3}|^0[0-9]{2})([0-9]+)?([0-9]{4})$/, "$1-$2-$3").replace("--", "-")

            return phone;
        }

        /* 즐겨찾기 */
        function change_favorite(obj) {
            var booth_id = $(obj).data('id');
            $.ajax({
                url: "{{ route('booth.favorite') }}",
                method: "post",
                data: {booth_id: booth_id},
                dataType: 'JSON',
                success: function (res) {
                    if (res.result === 'OK') {
                        toastr.success(res.msg);
                    } else {
                        toastr.error(res.msg);
                    }
                },
                error: function (err) {
                }
            });
        }

        /* Todo: javascript - 박람회 검색 */
        function searchExpo(){
            $.ajax({
                url: "{{ route('booth.favorite') }}",
                method: "post",
                data: {booth_id: booth_id},
                dataType: 'JSON',
                success: function (res) {
                    if (res.result === 'OK') {
                    } else {
                    }
                },
                error: function (err) {
                }
            });
        }


        /* updatePhotoPreview */
        function updatePhotoPreview(obj) {
            var reader = new FileReader();
            var target = $(obj).data('target');

            reader.onload = (e) => {
                var img = $("#" + target + " img");
                img.attr('src', e.target.result);
                img.show();
                // $("#" + target +" img.imgInp-origin-img" ).hide();
            };
            reader.readAsDataURL(obj.files[0]);
        }

    </script>
@endsection
