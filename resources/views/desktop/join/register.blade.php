@extends('desktop.layouts.none')
@section('body-class', '')
@section('header','')
@section('body')
    <div class="main">
        <div class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-5 ml-auto mr-auto">
                        <form name="join" method="POST" action="{{ route('join.post.register') }}">
                            @csrf
                            <input type="hidden" name="kakao_id" value="{{session()->get('kakao_id')}}">
                            <h5>기본정보</h5>
                            <div class="form-group">
                                <label>이름</label>
                                <input type="text" name="name" class="form-control" value="" required>
                            </div>
                            <div class="form-group">
                                <label>이메일</label>
                                <input type="email" name="email" class="form-control" value="" required>
                                <button id="check" type="button" class="btn btn-sm btn-black">중복확인</button>
                            </div>
                            <div class="form-group">
                                <label>휴대전화</label>
                                <input type="tel" name="tel" class="form-control" value="" required>
                            </div>
                            <div class="form-group">
                                <label>지역</label>
                                <select class="form-control" data-style="btn" name="area">
                                    <option value="" data-hidden="true" selected>선택</option>
                                    @foreach($areas as $area)
                                        <option value="{{$area}}">{{$area}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>연령대</label>
                                <select class="form-control" data-style="btn" name="age">
                                    <option value="" data-hidden="true" selected>선택</option>
                                    @foreach($ages as $age)
                                        <option value="{{$age}}">{{$age}}대</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>비밀번호</label>
                                <input type="password" name="password" class="form-control" value=""
                                       required>
                            </div>
                            <div class="form-group">
                                <label>비밀번호 확인</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                       value="" required>
                            </div>
                            <button type="button" class="btn btn-link" data-toggle="collapse" href="#usermeta"
                                    aria-expanded="true" aria-controls="usermeta">
                                추가정보 <i class="material-icons">keyboard_arrow_down</i>
                            </button>
                            <div id="usermeta" class="collapse show" role="tabpanel" aria-labelledby="headingTwo">
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
                                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label>분야2</label>
                                                <select class="form-control select-category2" data-style="btn"
                                                        name="category_id1"
                                                        disabled>
                                                    <option value="" selected>선택</option>
                                                    @foreach($allCategories as $children)
                                                        <option value="{{ $children->id }}"
                                                                data-id="{{ $children->parent_id }}">{{ $children->name }}</option>
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
                                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label>분야2</label>
                                                <select class="form-control select-category2" data-style="btn"
                                                        name="category_id2"
                                                        disabled>
                                                    <option value="" selected>선택</option>
                                                    @foreach($allCategories as $children)
                                                        <option value="{{ $children->id }}"
                                                                data-id="{{ $children->parent_id }}">{{ $children->name }}</option>
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
                                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label>분야2</label>
                                                <select class="form-control select-category2" data-style="btn"
                                                        name="category_id3"
                                                        disabled>
                                                    <option value="" selected>선택</option>
                                                    @foreach($allCategories as $children)
                                                        <option value="{{ $children->id }}"
                                                                data-id="{{ $children->parent_id }}">{{ $children->name }}</option>
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
                                                value="{{ $purpose }}">{{ $purpose }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label>업종</label>
                                    <select class="form-control" data-style="btn" name="industry">
                                        <option value="" data-hidden="true" selected>선택</option>
                                        @foreach($industries as $industry)
                                            <option
                                                value="{{ $industry }}">{{ $industry }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>기업명</label>
                                    <input type="text" name="company_name" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label>부서/직책</label>
                                    <input type="text" name="company_dept" class="form-control" value="">
                                    <select class="form-control" data-style="btn" name="company_position">
                                        <option value="" data-hidden="true" selected>선택</option>
                                        @foreach($positions as $position)
                                            <option
                                                value="{{ $position }}">{{ $position }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-row">
                                    <div class="col-12">
                                        <label>기업대표이미지</label>
                                        <input type="file" name="company_image_url" class="form-control form-control-file"
                                               accept="image/*">
                                        <p><small>* 5MB 이하의 파일만 등록가능 합니다. (jpg, png, gif, bmp)
                                            </small></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>기업 홈페이지</label>
                                    <input type="text" name="company_site" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label>기업 전화번호</label>
                                    <input type="text" name="company_tel" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label for="">기업 주소</label>
                                    <button type="button" class="btn btn-sm btn-black"
                                            onclick="execDaumPostcode()">주소검색
                                    </button>
                                    <input type="text" class="form-control" id="company_zip" name="company_zip">
                                    <input type="text" class="form-control" id="company_address1"
                                           name="company_address1">
                                    <input type="text" class="form-control" id="company_address2"
                                           name="company_address2">
                                </div>
                                <div class="form-group">
                                    <label for="">소개글</label>
                                    <textarea name="intro" rows="10" class="form-control"></textarea>
                                </div>
                                <div class="form-row form-file-upload form-file-simple">
                                    <label for="">소개자료</label>
                                    <input type="file" name="company_attachment_file_url" class="form-control-file">
                                </div>

                            </div>
                            <button type="submit" class="btn btn-outline-rose btn-block btn-ajax">회원
                                가입
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <div id="daumPost"
         style="display:none;position:fixed;overflow:hidden;z-index:2000;-webkit-overflow-scrolling:touch;">
        <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer"
             style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()"
             alt="닫기 버튼">
    </div>
    <script type="text/javascript"
            src="//dapi.kakao.com/v2/maps/sdk.js?appkey=e1e0c8cd1b6f4167551210b0d77056c6"></script>
    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js?autoload=false"></script>
    <script>
        const join = function ($$) {
            let selectedCategories;
            let joinForm = $$('form[name=join]');

            init();
            fake();

            function init() {
                selectedCategories = {};
                window.onbeforeunload = function (e) {
                    e.preventDefault();
                    e.returnValue = '';
                };
                $$.each($$('.select-category'), function (idx) {
                    selectedCategories[$$(this).attr('id')] = null
                });
                addListener();
                register();
            }

            function addListener() {
                $$(".select-category1").on("change", function () {
                    let div = $$(this).closest('.select-category');
                    let category2 = div.find(".select-category2");
                    let sel = $$(this).val();
                    if (!sel || sel === '') {
                        category2.find("option").val('');
                        category2.find(">:first-child").show().prop('selected', true);
                        category2.prop('disabled', true);
                        selectedCategories[div.attr('id')] = null;
                    } else {
                        category2.find("option").hide().prop('selected', false);
                        $$.each(category2.find("option[data-id='" + sel + "']"), function (e) {
                            $$(this).show();
                        });
                        category2.prop('disabled', false);
                        selectedCategories[div.attr('id')] = sel;
                    }
                    // $$('.selectpicker').selectpicker('refresh');
                });
                $$(".select-category2").on("change", function () {
                    let div = $$(this).closest('.select-category');
                    let option = $$(this).find("option")
                    if (_.indexOf(_.values(selectedCategories), $$(this).val()) > -1) {
                        confirmPopup('중복선택입니다 다시 선택해주세요.', 'warning', function () {
                            option.prop('selected', false);
                            selectedCategories[div.attr('id')] = null;
                            // $$('.selectpicker').selectpicker('refresh');
                        });
                        return;
                    }
                    selectedCategories[div.attr('id')] = $$(this).val();
                    // $$('.selectpicker').selectpicker('refresh');
                });
                $$('#check').on('click', function (e) {
                    e.preventDefault();
                    $$.post("{{ route('join.post.check') }}", joinForm.serialize())
                        .done(function (res) {
                            confirmPopup(res.msg, 'success');
                            // joinForm.find('input[name=email]').prop('readonly', true);
                            $$(e.target).prop('disabled', true);
                            $$('input[name=check]').remove();
                            $$('<input/>', {
                                type: 'hidden',
                                name: 'check',
                                value: 'Y',
                                appendTo: joinForm
                            });
                        })
                        .fail(function (xqr) {
                            $$('input[name=check]').remove();
                            if (xqr.responseJSON.errors === 'email') {
                                $$(e.target).prop('disabled', false);
                            }
                        });
                })
                joinForm.find('input[name=email]').on('keyup', function (e) {
                    $$('#check').prop('disabled', false);
                    $$('input[name=check]').remove();
                })
            }

            function register() {
                joinForm.submit(function (e) {
                    e.preventDefault();
                    $$.ajax({
                        type: 'POST',
                        url: "{{ route('join.post.register') }}",
                        data: new FormData(this),
                        dataType: "JSON",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (res) {
                            window.onbeforeunload = null;
                            window.location.href = res.url;
                        },
                    });
                });
            }

            function fake() {
                /* Fake */
                var values = joinForm.serializeArray();
                var pass = '12341234';

                for (index = 0; index < values.length; ++index) {
                    var target = joinForm.find('input[name=' + values[index].name + ']');
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

            }

        }(jQuery);

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
