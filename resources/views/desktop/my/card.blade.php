@extends('desktop.layouts.none')
@section('css')
    <style>
        .krajee-default.file-preview-frame .kv-file-content {
            width: 100%;
            height: auto;
        }

        .krajee-default.file-preview-frame {
            margin: 0;
            padding: 0
        }

        .file-preview {
            width: 450px;
            height: auto;
        }

        .file-drop-zone {
            margin: 0;
            min-height: 259px;
        }

        .file-drop-zone.clickable:hover {
            border: 1px dashed #999;
        }

        .btn-file {
            z-index: 2;
            cursor: pointer;
        }

        .f-slash:not(:last-child):after {
            content: '\002F';
        }

        .f-slash.slash-hide:after {
            display: none;
        }
    </style>
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
                        <form name="myCardForm">
                            @csrf
                            <div class="col-12">
                                <h5>이미지 명함</h5>
                                <div class="form-row form-group">
                                    <div class="col-6 text-center">
                                        <label for="business_card_front">앞면</label>
                                        <div class="preview-upload">
                                            @if(empty($user->business_card_front))
                                                <div class="info">
                                                    <h5>등록된 명함 없음</h5>
                                                </div>
                                                <div class="preview"></div>
                                            @else
                                                <div class="preview">
                                                    <img src="/storage/{{$user->business_card_front}}"
                                                         class="img img-fluid" alt="">
                                                </div>
                                            @endif
                                            <input type="file" name="business_card_front"
                                                   class="control form-control-file"
                                                   id="business_card_front"
                                                   accept="image/x-png,image/gif,image/jpeg">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-black btn-browse">찾아보기
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 text-center">
                                        <label for="business_card_back">뒷면</label>
                                        <div class="preview-upload">
                                            @if(empty($user->business_card_back))
                                                <div class="info">
                                                    <h5>등록된 명함 없음</h5>
                                                </div>
                                                <div class="preview"></div>
                                            @else
                                                <div class="preview">
                                                    <img src="/storage/{{$user->business_card_back}}"
                                                         class="img img-fluid" alt="">
                                                </div>
                                            @endif
                                            <input type="file" name="business_card_back"
                                                   class="control form-control-file"
                                                   id="business_card_back"
                                                   accept="image/x-png,image/gif,image/jpeg">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-black btn-browse">찾아보기
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form name="cardTextForm">
                            <h5>텍스트 명함</h5>
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="d-flex justify-content-between">
                                        <div
                                            class="copy_card_name">{{(empty($user->card->card_name))?"이름":$user->card->card_name}}</div>
                                        <div class="d-flex">
                                            <div
                                                class="copy_card_dept f-slash {{(empty($user->card->card_dept))?'empty':''}}">{{(empty($user->card->card_dept))?"":$user->card->card_dept}}</div>
                                            <div
                                                class="copy_card_position f-slash {{(empty($user->card->card_position))?'empty':''}}">{{(empty($user->card->card_position))?"":$user->card->card_position}}</div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <div
                                            class="copy_card_company">{{(empty($user->card->card_company))?"":$user->card->card_company}}</div>
                                    </div>
                                    <div class="d-flex">
                                        <div
                                            class="copy_card_tel">{{(empty($user->card->card_tel))?"전화번호":$user->card->card_tel}}</div>
                                    </div>
                                    <div class="d-flex">
                                        <div
                                            class="copy_card_email">{{(empty($user->card->card_email))?"이메일":$user->card->card_email}}</div>
                                    </div>
                                    <div class="d-flex">
                                        <div
                                            class="copy_card_homepage">{{(empty($user->card->card_homepage))?"홈페이지":$user->card->card_homepage}}</div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <div class="form-group d-inline-block">
                                        <label>텍스트 명함</label>
                                        <div class="form-group">
                                            <label>이름</label>
                                            <input type="text" name="card_name" class="form-control"
                                                   value="{{(empty($user->card->card_name))?'':$user->card->card_name}}"
                                            >
                                        </div>
                                        <div class="form-group">
                                            <label>전화번호</label>
                                            <input type="text" name="card_tel" class="form-control"
                                                   value="{{(empty($user->card->card_tel))?'':$user->card->card_tel}}"
                                            >
                                        </div>
                                        <div class="form-group">
                                            <label>이메일</label>
                                            <input type="text" name="card_email" class="form-control"
                                                   value="{{(empty($user->card->card_email))?'':$user->card->card_email}}"
                                            >
                                        </div>
                                        <div class="form-group">
                                            <label>회사명</label>
                                            <input type="text" name="card_company" class="form-control"
                                                   value="{{(empty($user->card->card_company))?'':$user->card->card_company}}"
                                            >
                                        </div>
                                        <div class="form-group">
                                            <label>부서</label>
                                            <input type="text" name="card_dept" class="form-control"
                                                   value="{{(empty($user->card->card_dept))?'':$user->card->card_dept}}"
                                            >
                                        </div>
                                        <div class="form-group">
                                            <label>직책</label>
                                            <input type="text" name="card_position" class="form-control"
                                                   value="{{(empty($user->card->card_position))?'':$user->card->card_position}}"
                                            >
                                        </div>
                                        <div class="form-group">
                                            <label>홈페이지</label>
                                            <input type="text" name="card_homepage" class="form-control"
                                                   value="{{(empty($user->card->card_homepage))?'':$user->card->card_homepage}}"
                                            >
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <button class="btn btn-sm btn-black">저장</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-after')
@stop
@section('page-script')

    <script>
        $(function () {
            let initData = {
                business_card_front: '{{(empty ($user->business_card_front))?'null':'/storage/'.$user->business_card_front}}',
                business_card_back: '{{(empty ($user->business_card_back))?'null':'/storage/'.$user->business_card_back}}',
            }
            let img = {
                width: "100%",
            };

            /* Edit */
            var cardTextForm = $('form[name=cardTextForm]');
            cardTextForm.submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "/my/card/save",
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
            var cardForm = $('form[name=myCardForm]');

            cardForm.find('.btn-browse').on('click', function () {
                $(this).closest('.preview-upload').find('input[type=file]').click();
            })
            cardForm.find('input[type=file]').change(function (e) {
                var info = $(this).closest('.preview-upload').find('.info');
                var preview = $(this).closest('.preview-upload').find('.preview');
                var btnGroup = $(this).closest('.preview-upload').find('.btn-group');
                var input = $(this);
                var inputName = $(this).attr('name');
                var reader = new FileReader();
                var f = $(this)[0].files;
                if (f.length > 0) {
                    if (btnGroup.find('#preview-remove').length > 0) btnGroup.find('#preview-remove').remove();
                    if (btnGroup.find('#preview-upload').length > 0) btnGroup.find('#preview-upload').remove();
                    reader.onload = function (e) {
                        info.hide();
                        preview.html('<img class="img img-fluid" src="' + e.target.result + '">');
                        let clearBtn = $("<button/>", {
                            text: "삭제",
                            id: "preview-remove",
                            type: "button",
                            class: "btn btn-sm btn-warning",
                            on: {
                                click: function () {
                                    preview.empty();
                                    if (initData[inputName] !== null) {
                                        $("<img/>", {
                                            class: "img img-fluid",
                                            src: initData[inputName],
                                            appendTo: preview
                                        })
                                    } else {
                                        info.show();
                                    }
                                    input.val('')
                                    $(this).remove();
                                    btnGroup.find('#preview-upload').remove();
                                }
                            },
                            append: "",
                            appendTo: btnGroup
                        });
                        let uploadBtn = $("<button/>", {
                            text: "저장",
                            id: "preview-upload",
                            type: "button",
                            class: "btn btn-sm btn-info",
                            on: {
                                click: function () {
                                    var formData = new FormData();
                                    formData.append(inputName, $("#" + inputName)[0].files[0]);
                                    $.ajax({
                                        url: '/my/card/save',
                                        processData: false,
                                        contentType: false,
                                        data: formData,
                                        type: 'POST',
                                        success: function (res) {
                                            confirmPopup(res.msg, 'success');
                                            clearBtn.remove();
                                            uploadBtn.remove();
                                            initData[inputName] = '/storage/' + res.data[inputName];
                                        }
                                    });
                                    input.val('')
                                }
                            },
                            // append: "<i class='material-icons'>clear</i>",
                            appendTo: btnGroup
                        });
                    };
                    reader.readAsDataURL(f[0]);
                } else {
                }
            });
            if($('.f-slash.empty').length < 1) $('.f-slash').removeClass('slash-hide')
            else $('.f-slash').addClass('slash-hide');

            $('form[name=cardTextForm]').find('input[type=text]').on('keyup', function (e) {
                let inp = $(this);
                let className = '.copy_' + $(this).attr('name');
                let target = $('form[name=cardTextForm]').find(className);
                let dept = $('input[name=card_dept]');
                let position = $('input[name=card_position]');
                target.text(inp.val());
                if (dept.val() !== '') {
                    if(position.val() !== '') $('.copy_card_position').removeClass('slash-hide')
                    else $('.copy_card_position').addClass('slash-hide')
                }else{
                    $('.copy_card_position').addClass('slash-hide')

                }
                if (position.val() !== '') {
                    if(dept.val() !== '') $('.copy_card_dept').removeClass('slash-hide')
                    else $('.copy_card_dept').addClass('slash-hide')
                }else{
                    $('.copy_card_dept').addClass('slash-hide')
                }
            });


        });
    </script>
@stop
