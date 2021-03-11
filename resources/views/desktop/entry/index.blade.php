@extends('desktop.layouts.none')
@section('css')
    <style>
        .bootstrap-select > .dropdown-toggle.bs-placeholder.btn, .bootstrap-select > .dropdown-toggle.bs-placeholder.btn:hover {
            color: #aaa;
            font-weight: normal;
        }
    </style>
@stop
@section('body-class', '')
@section('header','')
@section('body')
    <div class="main">
        <div class="section">
            <div class="container">
                <h3 class="title text-center">출품신청</h3>
                <div class="row justify-content-center">
                    <ul class="nav nav-pills nav-pills-black p-0" id="formTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link nav-step1 active" data-toggle="tab" href="#step1" role="tablist"
                               aria-expanded="true">
                                01.박람회,출품분야선택
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-step2 disabled" data-toggle="tab" href="#step2" role="tablist"
                               aria-expanded="false">
                                02.약관동의 및 정보입력
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-step3 disabled" data-toggle="tab" href="#step3" role="tablist"
                               aria-expanded="false">
                                03.완료
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content tab-space pt-4">
                    <div class="tab-pane active" id="step1">
                        <div class="tab-pane-body"></div>
                    </div>
                    <div class="tab-pane" id="step2">
                        <div class="tab-pane-body"></div>
                    </div>
                    <div class="tab-pane" id="step3">
                        <div class="tab-pane-body"></div>
                    </div>
                    {{--                    @if(empty(request()->has('step')))--}}
                    {{--                        @include('desktop.entry.step1',['expo_list'=>$expo_list])--}}
                    {{--                    @else--}}
                    {{--                        @include('desktop.entry.step2',['expo'=>$expo])--}}
                    {{--                    @endif--}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-after')
    @include('desktop.entry.template')
@endsection
@section('page-script')
    <div id="daumPost"
         style="display:none;position:fixed;overflow:hidden;z-index:2000;-webkit-overflow-scrolling:touch;">
        <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer"
             style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()"
             alt="닫기 버튼">
    </div>
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>
        const entry = (function ($$) {
            const initData = {
                expos: @json($expo_list),
                user: @json($user),
                expo: null,
                category_text: null,
                category_detail_text: null,
                formData: null,

            }
            const template = {
                step1: Handlebars.compile($$("#template-entry-step1").html()),
                step2: Handlebars.compile($$("#template-entry-step2").html()),
                step3: Handlebars.compile($$("#template-entry-step3").html()),
            };

            let tab = $$('#formTab');
            let paneId = 'step1'
            let pane = $$('.tab-content').find('#' + paneId);
            let templateContainer = pane.find('.tab-pane-body');
            tab.on('show.bs.tab', function (e) {
                paneId = $$(e.target).attr('href').replace('#', '');
                pane = $$('.tab-content').find('#' + paneId);
                templateContainer = pane.find('.tab-pane-body');
                templateContainer.html(template[paneId](initData));
            });
            step1();

            function step1() {
                templateContainer.html(template[paneId](initData));
                let form = pane.find('form');
                form.submit(function (e) {
                    e.preventDefault();
                    let data = $$(this).serializeObject();
                    if (!data.expo_id) {
                        confirmPopup('박람회를 선택해주세요.', 'error');
                        return false;
                    }
                    if (!data.category_text) {
                        confirmPopup('분야를 1개 이상 선택해주세요.', 'error');
                        return false;
                    }
                    initData.expo = _.find(initData.expos, {id: parseInt(data.expo_id)})
                    initData.category_text = data.category_text;
                    initData.category_detail_text = data.category_detail_text;
                    tab.find('.nav-step1').addClass('disabled');
                    step2();
                });
            }

            function step2() {
                tab.find('.nav-step2').removeClass('disabled');
                tab.find('.nav-step2').tab('show');
                let form = pane.find('form');
                $('#sameInfoBtn').on('click', function () {
                    let data = form.serializeObject()
                    $('input[name=tax_manager_name]').val(data.manager_name)
                    $('input[name=tax_manager_email]').val(data.manager_email)
                    $('input[name=tax_manager_position]').val(data.manager_position)
                    $('input[name=tax_manager_tel]').val(data.manager_tel)
                    $('input[name=tax_manager_phone]').val(data.manager_phone)
                    $('input[name=tax_manager_fax]').val(data.manager_fax)

                });
                form.submit(function (e) {
                    e.preventDefault();
                    let formData = new FormData(this);
                    formData.append('expo_id', initData.expo.id)
                    formData.append('category_text', initData.category_text)
                    formData.append('category_detail_text', initData.category_detail_text)
                    $.ajax({
                        type: 'POST',
                        url: "/entry/save",
                        dataType: "JSON",
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (res) {
                            if (res.result === 'OK') {
                                initData.formData = res.data;
                                step3();
                            }
                        },
                    });
                });
                $('#prevBtn').on('click', function () {
                    Swal2.fire({
                        html: '이전화면으로 돌아가겠습니까?<br>입력하신 정보는 저장되지 않습니다.',
                        icon: 'warning',
                        showConfirmButton: true,
                        showCancelButton: true,
                    }).then(function (value) {
                        if (value.isConfirmed) {
                            window.location.href = '/entry';
                        }
                    });
                });
            }

            function step3(){
                tab.find('.nav-step3').removeClass('disabled');
                tab.find('.nav-step3').tab('show');
                templateContainer.html(template[paneId](initData));

            }
        })(jQuery)




        {{--$(function () {--}}
        {{--    $('.form-check-input').prop('checked',false);--}}
        {{--    $('#category_detail_text').val('');--}}
        {{--    @if (request()->has('id'))--}}
        {{--    $('#expoSelect').val({{request()->get('id')}});--}}
        {{--    $('.selectpicker').selectpicker('refresh')--}}
        {{--    @endif--}}
        {{--    const entryFormStep1 = $('form[name=entryFormStep1]')--}}
        {{--    entryFormStep1.submit(function (e) {--}}
        {{--        var formData = $(this).serializeObject();--}}
        {{--        if(!formData.expo){--}}
        {{--            confirmPopup('박람회를 선택해주세요.','error');--}}
        {{--            return false;--}}
        {{--        }--}}
        {{--        if(!formData.category_text){--}}
        {{--            confirmPopup('분야를 1개 이상 선택해주세요.','error');--}}
        {{--            return false;--}}
        {{--        }--}}
        {{--    });--}}

        {{--    const entryFormStep2 = $('form[name=entryFormStep2]')--}}
        {{--    entryFormStep2.submit(function (e) {--}}
        {{--        e.preventDefault();--}}
        {{--        var formData = new FormData(this);--}}
        {{--        $.ajax({--}}
        {{--            type: 'POST',--}}
        {{--            url: "/entry/form-save",--}}
        {{--            dataType: "JSON",--}}
        {{--            data: formData,--}}
        {{--            contentType: false,--}}
        {{--            cache: false,--}}
        {{--            processData: false,--}}
        {{--            success: function (res) {--}}
        {{--                if(res.result === 'OK'){--}}
        {{--                    $('#company_name_txt').text(res.data.company_name)--}}
        {{--                    $('#manager_name_txt').text(res.data.manager_name)--}}
        {{--                    $('#tax_manager_name_txt').text(res.data.tax_manager_name)--}}
        {{--                    $('#formTab li:nth-child(2) > a').addClass('disabled')--}}
        {{--                    $('#formTab li:nth-child(3) > a').removeClass('disabled')--}}
        {{--                    $('#formTab li:nth-child(3) > a').tab('show')--}}
        {{--                }--}}
        {{--            },--}}
        {{--        });--}}
        {{--    })--}}
        {{--    $('#sameInfoBtn').on('click',function () {--}}
        {{--        let data = entryFormStep2.serializeObject()--}}
        {{--        $('input[name=tax_manager_name]').val(data.manager_name)--}}
        {{--        $('input[name=tax_manager_email]').val(data.manager_email)--}}
        {{--        $('input[name=tax_manager_position]').val(data.manager_position)--}}
        {{--        $('input[name=tax_manager_tel]').val(data.manager_tel)--}}
        {{--        $('input[name=tax_manager_phone]').val(data.manager_phone)--}}
        {{--        $('input[name=tax_manager_fax]').val(data.manager_fax)--}}

        {{--    })--}}
        {{--    $('#prevBtn').on('click',function(){--}}
        {{--        Swal2.fire({--}}
        {{--            html: '이전화면으로 돌아가겠습니까?<br>입력하신 정보는 저장되지 않습니다.',--}}
        {{--            icon: 'warning',--}}
        {{--            showConfirmButton: true,--}}
        {{--            showCancelButton: true,--}}
        {{--        }).then(function (value) {--}}
        {{--            if (value.isConfirmed) {--}}
        {{--                window.location.href='/entry';--}}
        {{--            }--}}
        {{--        });--}}
        {{--    });--}}
        {{--});--}}

        // 우편번호 찾기 화면을 넣을 element
        var element_layer = document.getElementById('daumPost');

        function closeDaumPostcode() {
            // iframe을 넣은 element를 안보이게 한다.
            element_layer.style.display = 'none';
        }

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

        // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
        // resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
        // 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
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
    </script>
    @include('desktop.entry.template')
@stop
