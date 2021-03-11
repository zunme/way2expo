@extends('desktop.layouts.none')
@section('css')
@endsection
@section('body-class', '')
@section('header','')
@section('body')
    <div class="main">
        <div class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-2">
                        @include('desktop.my.inc.mylnb')
                    </div>
                    <div class="col-10">
                        <form name="edit" method="post" action="{{ route('my.info.edit') }}">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="form-title">기본정보</div>
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
                                               disabled>
                                        <button type="button" class="btn btn-sm btn-black">전화번호 변경</button>
                                    </div>
                                    <div class="form-group">
                                        <label>지역</label>
                                        <select class="form-control" data-style="btn" name="area">
                                            <option value="" data-hidden="true" selected>선택</option>
                                            @foreach($areas as $area)
                                                <option
                                                    value="{{$area}}" {{($user->meta->area == $area)?'selected':''}}>{{$area}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>연령대</label>
                                        <select class="form-control" data-style="btn" name="age">
                                            <option value="" data-hidden="true" selected>선택</option>
                                            @foreach($ages as $age)
                                                <option
                                                    value="{{$age}}" {{($user->meta->age == $age)?'selected':''}}>{{$age}}
                                                    대
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>비밀번호</label>
                                        <button type="button" class="btn btn-sm btn-black btn-pw">비밀번호 변경</button>
                                    </div>
                                    <div class="form-group">
                                        <label>카카오 연동</label>
                                        @if($user->kakao_id)
                                            <span>연동됨</span>
                                            <button type="button" class="btn btn-sm btn-black btn-kakao-disconnect">연동
                                                해지
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-black" id="kakao-login-btn">카카오 연동</button>
                                        @endif
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label>마케팅 수신동의</label>
                                        <label class="form-check-label">
                                            동의함
                                            <input class="form-check-input" type="checkbox" name="agree_marketing"
                                                   value="Y" {{ ($user->meta->agree_marketing === 'Y')?'checked':'' }}>
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                        <button type="button" class="btn btn-sm btn-black btn-agree">내용보기</button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-link" data-toggle="collapse" href="#usermeta"
                                            aria-expanded="true" aria-controls="usermeta">
                                        추가정보 <i class="material-icons">keyboard_arrow_down</i>
                                    </button>
                                    <div id="usermeta" class="collapse collapsed" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="form-group">
                                            <div>관심분야</div>
                                            <div id="category1" class="select-category">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label>분야1</label>
                                                        <select class="form-control select-category1" data-style="btn"
                                                                name="category_pid1">
                                                            <option value="" data-hidden="true" selected>선택</option>
                                                            @foreach($categories as $category)
                                                                <option
                                                                    value="{{ $category->id }}" {{($user->meta->category_pid1 == $category->id)?'selected':''}}>{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label>분야2</label>
                                                        <select class="form-control select-category2" data-style="btn"
                                                                name="category_id1"
                                                        {{($user->meta->category_pid1)?'':'disabled'}}>
                                                    <option value="" selected>선택</option>
                                                    @foreach($allCategories as $children)
                                                        <option value="{{ $children->id }}"
                                                                        data-id="{{ $children->parent_id }}" {{($user->meta->category_id1 == $children->id)?'selected':''}}>{{ $children->name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div id="category2" class="select-category">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label>분야1</label>
                                                        <select class="form-control select-category1" data-style="btn"
                                                                name="category_pid2">
                                                            <option value="" data-hidden="true" selected>선택</option>
                                                            @foreach($categories as $category)
                                                                <option
                                                                    value="{{ $category->id }}" {{($user->meta->category_pid2 == $category->id)?'selected':''}}>{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label>분야2</label>
                                                        <select class="form-control select-category2" data-style="btn"
                                                                name="category_id2"
                                                            {{($user->meta->category_pid2)?'':'disabled'}}>
                                                            <option value="" selected>선택</option>
                                                            @foreach($allCategories as $children)
                                                                <option value="{{ $children->id }}"
                                                                        data-id="{{ $children->parent_id }}" {{($user->meta->category_id2 == $children->id)?'selected':''}}>{{ $children->name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div id="category3" class="select-category">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label>분야1</label>
                                                        <select class="form-control select-category1" data-style="btn"
                                                                name="category_pid3">
                                                            <option value="" data-hidden="true" selected>선택</option>
                                                            @foreach($categories as $category)
                                                                <option
                                                                    value="{{ $category->id }}" {{($user->meta->category_pid3 == $category->id)?'selected':''}}>{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label>분야2</label>
                                                        <select class="form-control select-category2" data-style="btn"
                                                                name="category_id3"
                                                            {{($user->meta->category_pid3)?'':'disabled'}}>
                                                            <option value="" selected>선택</option>
                                                            @foreach($allCategories as $children)
                                                                <option value="{{ $children->id }}"
                                                                        data-id="{{ $children->parent_id }}" {{($user->meta->category_id3 == $children->id)?'selected':''}}>{{ $children->name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>관람목적</label>
                                            <select class="form-control" data-style="btn" name="purpose_viewing">
                                                <option value="" data-hidden="true" selected>선택</option>
                                                @foreach($purposes as $purpose)
                                                    <option
                                                        value="{{ $purpose }}" {{($user->meta->purpose_viewing == $purpose)?'selected':''}}>{{ $purpose }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <label>업종</label>
                                            <select class="form-control" data-style="btn" name="industry">
                                                <option value="" data-hidden="true" selected>선택</option>
                                                @foreach($industries as $industry)
                                                    <option
                                                        value="{{ $industry }}" {{($user->meta->industry == $industry)?'selected':''}}>{{ $industry }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>기업명</label>
                                            <input type="text" name="company_name" class="form-control"
                                                   value="{{$user->meta->company_name}}">
                                        </div>
                                        <div class="form-group">
                                            <label>부서</label>
                                            <input type="text" name="company_dept" class="form-control"
                                                   value="{{$user->meta->company_dept}}">
                                        </div>
                                        <div class="form-group">
                                            <label>직책</label>
                                            <select class="form-control" data-style="btn" name="company_position">
                                                <option value="" data-hidden="true" selected>선택</option>
                                                @foreach($positions as $position)
                                                    <option
                                                        value="{{ $position }}" {{($user->meta->company_position == $position)?'selected':''}}>{{ $position }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">기업 주소</label>
                                            <button type="button" class="btn btn-sm btn-black"
                                                    onclick="execDaumPostcode()">주소검색
                                            </button>
                                            <input type="hidden" class="form-control" id="company_zip" name="company_zip"
                                                   value="{{$user->meta->company_dept}}">
                                            <input type="text" class="form-control" id="company_address1"
                                                   name="company_address1" value="{{$user->meta->company_address1}}">
                                            <input type="text" class="form-control" id="company_address2"
                                                   name="company_address2" value="{{$user->meta->company_address2}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="">소개글</label>
                                            <textarea name="intro" rows="10"
                                                      class="form-control">{{$user->meta->intro}}</textarea>
                                        </div>
                                        <div class="form-row form-file-upload form-file-simple">
                                            <label for="">소개자료</label>
                                            <input type="file" name="company_attachment_file_url" class="form-control-file">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-rose btn-block btn-ajax">정보 수정</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-after')
    @verbatim
        <script id="template-agree" type="text/x-handlebars-template">
            <div class="modal-content">
                <div class="modal-header">
                    마케팅 수신동의
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                    <textarea name="" class="form-control" id="" cols="30" rows="10">회사는 서비스 혜택 제공을 위해 다양한 방법(알림톡/SMS, 이메일 등)을 통해 서비스 관련 정보를 회원에게 제공할 수 있습니다.
단, 회원이 서비스 혜택 정보 제공을 원치 않는다는 의사를 명확히 밝히는 경우 정보제공을 하지 않으며 이 경우 회원에게 정보 미 제공으로 인한 불이익이 발생하더라도 회사가 책임지지 않습니다. 또한, 이용 목적이 변경될 시에는 사전 동의를 구할 예정입니다.
- 이벤트 및 마케팅 기획, 서비스 개발을 위한 연구/조사, 서비스 관련 각종 이벤트 및 행사 관련 정보 안내를 위한 알림톡/SMS, 이메일 발송, 사은행사 안내, 이벤트/경품 당첨 결과 안내 및 상품배송
</textarea>
                    </div>
                </div>
            </div>
        </script>
        <script id="template-change-password" type="text/x-handlebars-template">
            <div class="modal-content">
                <form name="changeForm">
                    <div class="modal-header">
                        비밀번호 변경
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>이전 비밀번호</label>
                            <input type="password" class="form-control" name="password" placeholder="이전 비밀번호를 입력하세요.">
                        </div>
                        <div class="form-group">
                            <label>변경 비밀번호</label>
                            <input type="password" class="form-control" name="new_password"
                                   placeholder="영문+숫자+특수문자 포함 8~20자">
                            <input type="password" class="form-control" name="confirm_password"
                                   placeholder="변경할 비밀번호를 다시 입력해주세요">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-black">저장</button>
                    </div>
                </form>
            </div>
        </script>
    @endverbatim
@stop
@section('page-script')
    <div id="daumPost"
         style="display:none;position:fixed;overflow:hidden;z-index:2000;-webkit-overflow-scrolling:touch;">
        <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer"
             style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()"
             alt="닫기 버튼">
    </div>
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>
        $(function () {
            $('.btn-agree').on('click', function () {
                pop_tpl('default', 'template-agree', null);
            });
            $('.btn-kakao-disconnect').on('click',function(){
                Kakao.Auth.login({
                    success: function(authObj) {
                        Kakao.API.request({
                            url: '/v1/user/unlink',
                            success: function(response) {
                                console.log(response);
                                $.post('/my/info/disconnectKakao');
                            },
                            fail: function(error) {
                                console.log(error);
                            },
                        });

                        // Kakao.Auth.setAccessToken(authObj.access_token);
                        // Kakao.API.request({
                        //     url: '/v2/user/me',
                        //     success: function(res) {
                        //         $.post('/login',{kakao_id:res.id}).done(function(res){
                        //             if (res.result === 'OK') {
                        //                 window.location.href = res.url;
                        //             }
                        //         });
                        //     },
                        //     fail: function(error) {
                        //         alert(
                        //             'login success, but failed to request user information: ' +
                        //             JSON.stringify(error)
                        //         )
                        //     },
                        // })
                    },
                    fail: function(err) {
                        alert('failed to login: ' + JSON.stringify(err))
                    },
                });
            });
            $('#kakao-login-btn').on('click',function(){
                Kakao.Auth.login({
                    success: function(authObj) {
                        Kakao.API.request({
                            url: '/v2/user/me',
                            success: function(res) {
                                $.post('/my/info/connectKakao',{kakao_id:res.id}).done(function(res){
                                    if (res.result === 'OK') {
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
            })
            $('.btn-pw').on('click', function () {
                pop_tpl('default', 'template-change-password', null);
                let form = $('form[name=changeForm]');
                form.submit(function(e){
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: "/my/info/changePassword",
                        data: new FormData(this),
                        dataType: "JSON",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (res) {
                            if (res.result === 'OK') {
                                confirmPopup(res.msg,'success',function(v){
                                    $('#modal-default').modal('hide');
                                    $(this).unbind();
                                })
                            }
                        },
                    });
                })
            });
            /* Edit */
            var editForm = $('form[name=edit]');
            editForm.submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                console.log($(this).serializeObject())
                $.ajax({
                    type: 'POST',
                    url: "{{ route('my.info.edit') }}",
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
                            }).then(function () {
                                // window.location.reload();
                            });
                        } else {
                            toastr.warning(res.msg)
                        }

                    },
                });
            });
            let selectedCategories = {};

            $(".select-category1").on("change", function () {
                let div = $(this).closest('.select-category');
                let category2 = div.find(".select-category2");
                let sel = $(this).val();
                if (!sel || sel === '') {
                    category2.find("option").val('');
                    category2.find(">:first-child").show().prop('selected', true);
                    category2.prop('disabled', true);
                    selectedCategories[div.attr('id')] = null;
                } else {
                    category2.find("option").hide().prop('selected', false);
                    $.each(category2.find("option[data-id='" + sel + "']"), function (e) {
                        $(this).show();
                    });
                    category2.prop('disabled', false);
                    selectedCategories[div.attr('id')] = sel;
                }
            });
            $(".select-category2").on("change", function () {
                let div = $(this).closest('.select-category');
                let option = $(this).find("option")
                if (_.indexOf(_.values(selectedCategories), $(this).val()) > -1) {
                    confirmPopup('중복선택입니다 다시 선택해주세요.', 'warning', function () {
                        option.prop('selected', false);
                        selectedCategories[div.attr('id')] = null;
                        // $('.selectpicker').selectpicker('refresh');
                    });
                    return;
                }
                selectedCategories[div.attr('id')] = $(this).val();
                // $('.selectpicker').selectpicker('refresh');
            });
        });
        let element_layer = document.getElementById('daumPost');

        function execDaumPostcode() {
            daum.postcode.load(function () {
                new daum.Postcode({
                    oncomplete: function (data) {
                        // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                        // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                        // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                        var addr = ''; // 주소 변수
                        var extraAddr = ''; // 참고항목 변수

                        //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                        if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                            addr = data.roadAddress;
                        } else { // 사용자가 지번 주소를 선택했을 경우(J)
                            addr = data.jibunAddress;
                        }

                        // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                        if (data.userSelectedType === 'R') {
                            // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                            // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                            if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                                extraAddr += data.bname;
                            }
                            // 건물명이 있고, 공동주택일 경우 추가한다.
                            if (data.buildingName !== '' && data.apartment === 'Y') {
                                extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                            }
                            // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                            if (extraAddr !== '') {
                                extraAddr = ' (' + extraAddr + ')';
                            }
                            // 조합된 참고항목을 해당 필드에 넣는다.

                        } else {
                        }

                        // 우편번호와 주소 정보를 해당 필드에 넣는다.
                        // document.getElementById('sample2_postcode').value = data.zonecode;
                        document.getElementById("company_zip").value = data.zonecode;
                        document.getElementById("company_address1").value = addr + extraAddr;
                        // 커서를 상세주소 필드로 이동한다.
                        document.getElementById("company_address2").focus();

                        // iframe을 넣은 element를 안보이게 한다.
                        // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                        element_layer.style.display = 'none';
                    },
                    width: '100%',
                    height: '100%',
                    maxSuggestItems: 5
                }).embed(element_layer);

                // iframe을 넣은 element를 보이게 한다.
                element_layer.style.display = 'block';

                // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
                initLayerPosition();

            });
        }

        function initLayerPosition() {
            var width = 400; //우편번호서비스가 들어갈 element의 width
            var height = 480; //우편번호서비스가 들어갈 element의 height
            var borderWidth = 1; //샘플에서 사용하는 border의 두께

            // 위에서 선언한 값들을 실제 element에 넣는다.
            element_layer.style.width = width + 'px';
            element_layer.style.height = height + 'px';
            element_layer.style.border = borderWidth + 'px solid';
            // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
            element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width) / 2 - borderWidth) + 'px';
            element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height) / 2 - borderWidth) + 'px';
        }

        function closeDaumPostcode() {
            element_layer.style.display = 'none';
        }

    </script>
@stop

