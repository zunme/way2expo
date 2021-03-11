@extends('desktop.layouts.none')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/css/fileinput.min.css" media="all"
          rel="stylesheet" type="text/css"/>
    <style>
        #image-preview-pc, #image-preview-mobile {
            width: 200px;
            height: 200px;
            border: 2px dashed #ddd;
            border-radius: 3px;
            position: relative;
            overflow: hidden;
            background-color: #ffffff;
            background-repeat: no-repeat;
            color: #ecf0f1;
        }

        .image-preview label, #callback-preview label {
            position: absolute;
            z-index: 5;
            opacity: 0.8;
            cursor: pointer;
            width: 140px;
            height: 29px;
            text-transform: uppercase;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            text-align: center;
            color: #fff;
            background-color: #3c4858;
            border-color: #3c4858;
            box-shadow: 0 2px 2px 0 rgba(60, 72, 88, .14), 0 3px 1px -2px rgba(60, 72, 88, .2), 0 1px 5px 0 rgba(60, 72, 88, .12);
            padding: .40625rem 1.25rem;
            font-size: .6875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }

        .image-preview {
            width: auto;
            height: 60px;
            overflow: auto;
            border: 2px dashed #ddd;
            border-radius: 3px;
            position: relative;
        }

        .imagecheck {
            width: 100%;
        }

        .list-group-item.highlight {
            outline: #e5007e solid 2px;
        }

        .image-preview-pc input, .image-preview-mobile input, #callback-preview input {
            line-height: 200px;
            font-size: 200px;
            position: absolute;
            opacity: 0;
            z-index: 10;
        }

        .btn-file input[type=file] {
            z-index: 2;
            cursor: pointer;
        }

        .file-footer-caption {
            line-height: 1;
        }
        .h-scroll {
            height: 80vh; /* %-height of the viewport */
            position: fixed;
            overflow-y: scroll;
        }
        .h-scroll::-webkit-scrollbar-track, .viewers::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            background-color: #F5F5F5;
        }

        .h-scroll::-webkit-scrollbar, .viewers::-webkit-scrollbar {
            background: transparent;
            width: 0px;
            background-color: transparent;
        }

        .h-scroll::-webkit-scrollbar-thumb, .viewers::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: #555;
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
                        @include('desktop.my.company.lnb')
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-12">
                                <form name="booth-save" method="post" action="" class="m-0">
                                    <input type="hidden" name="id" value="{{$booth->id}}">
                                    <input type="hidden" name="expo_id" value="{{$booth->expo_id}}">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="form-group">
                                                <label>박람회명</label>
                                                <input type="text" class="form-control"
                                                       value="{{$booth->expoBooth->expo_name}}"
                                                       disabled>
                                            </div>
                                            <div class="form-group">
                                                <label>부스명*</label>
                                                <input type="text" name="booth_title" class="form-control"
                                                       placeholder="제목을 입력해주세요(최대 50자)"
                                                       value="{{$booth->booth_title}}">
                                            </div>
                                            <div class="form-group">
                                                <label>Youtube 영상 링크</label>
                                                <input type="hidden" name="booth_movtype"
                                                       value="{{$booth->booth_movtype}}">
                                                <input type="text" name="booth_youtube_url"
                                                       class="form-control"
                                                       placeholder="https://youtu.be/xxxxxxx"
                                                       value="{{$booth->booth_youtube_url}}"
                                                >
                                                <small>* 유튜브 영상을 링크하고 싶으실 경우 영상 주소를 복사하여 입력해주세요</small>
                                            </div>
                                            <div class="form-group">
                                                <label>대표 이미지*</label>
                                                <div class="row">
                                                    <div class="col-6 text-center">
                                                        <div class="form-group d-inline-block">
                                                            <label>PC용 사진</label>
                                                            @if (empty($booth->booth_image_url))
                                                                <div id="image-preview-pc" class="image-preview">
                                                                    <label for="image-upload-pc"
                                                                           id="image-label-pc">PC 이미지
                                                                        업로드</label>
                                                                    <input type="file" name="selectimg_pc"
                                                                           id="image-upload-pc"
                                                                           accept="image/x-png,image/gif,image/jpeg"
                                                                    />
                                                                </div>
                                                            @else
                                                                <div id="image-preview-pc" class="image-preview"
                                                                     @if (!empty($booth->booth_image_url))
                                                                     style="background-image: url('/storage/{{ $booth->booth_image_url }}');
                                                                         background-size: cover; background-position: center center;"
                                                                    @endif
                                                                >
                                                                    <label for="image-upload-pc"
                                                                           id="image-label-pc">
                                                                        {{ (empty($booth->booth_image_url))?'PC 이미지 업로드':'변경' }}
                                                                    </label>

                                                                    <input type="file" name="selectimg_pc"
                                                                           id="image-upload-pc"
                                                                           accept="image/x-png,image/gif,image/jpeg">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-6 text-center">
                                                        <div class="form-group d-inline-block">
                                                            <label>모바일 사진</label>
                                                            @if (empty($booth->booth_mobile_image_url))
                                                                <div id="image-preview-mobile"
                                                                     class="image-preview">
                                                                    <label for="image-upload-mobile"
                                                                           id="image-label-mobile">모바일
                                                                        이미지 업로드</label>
                                                                    <input type="file" name="selectimg_mobile"
                                                                           id="image-upload-mobile"
                                                                           accept="image/x-png,image/gif,image/jpeg"
                                                                    />
                                                                </div>
                                                            @else
                                                                <div id="image-preview-mobile" class="image-preview"
                                                                     @if (!empty($booth->booth_mobile_image_url))
                                                                     style="background-image: url('/storage/{{ $booth->booth_mobile_image_url }}');
                                                                         background-size: contain; background-position: center center;"
                                                                    @endif
                                                                >
                                                                    <label for="image-upload-mobile"
                                                                           id="image-label-mobile">
                                                                        {{ (empty($booth->booth_mobile_image_url))?'PC 이미지 업로드':'변경' }}
                                                                    </label>

                                                                    <input type="file" name="selectimg_mobile"
                                                                           id="image-upload-mobile"
                                                                           accept="image/x-png,image/gif,image/jpeg">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>소개 이미지*</label>
                                                <input type="file" id="booth-intro-image" name="select_attach[]"
                                                       accept="image/*" multiple/>

                                            </div>
                                            <div class="form-group">
                                                <label>부스 소개</label>
                                                <textarea class="form-control" name="booth_intro" rows="3"
                                                          placeholder="부스소개를 작성해 주세요.&#13;&#10;(최대 1,000자)">{{$booth->booth_intro}}</textarea>
                                            </div>
                                            <div class="form-group p-0">
                                                <p class="m-0">
                                                    <label>해시태그</label>
                                                </p>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <input type="text" name="tags[]" class="form-control"
                                                               placeholder="태그1"
                                                               value="{{(!empty($booth->tags[0]->name)?$booth->tags[0]->name:'')}}">
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" name="tags[]" class="form-control"
                                                               placeholder="태그2"
                                                               value="{{(!empty($booth->tags[1]->name)?$booth->tags[1]->name:'')}}">
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" name="tags[]" class="form-control"
                                                               placeholder="태그3"
                                                               value="{{(!empty($booth->tags[2]->name)?$booth->tags[2]->name:'')}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-warning btn-ajax">수정
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="/assets/js/plugins/jquery.uploadPreview.min.js" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/js/plugins/piexif.min.js"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/js/plugins/sortable.min.js"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/js/fileinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/themes/fa/theme.js"></script>

    <script>

        function addDetailImage(ele) {
            var files = $(ele)[0].files;
            var cloned = $(ele).clone()

            var i = 0,
                len = files.length;
            (function readFile(n) {
                var reader = new FileReader();
                var f = files[n];
                reader.onload = function (e) {
                    var item = `
                            <li class="list-group-item handle p-0" data-id="isNewFile">
                                <div class="card card-plain m-0">
                                    <div class="card-body m-0 p-0">
                                        <div class="row justify-content-between m-0">
                                            <div class="col-10 p-0 m-0 text-left">
                                                <button type="button" class="btn btn-sm btn-block btn-outline-danger">
                                                    <i class="material-icons">swap_vert</i>
                                                    드래그&드랍 하여 순서 변경
                                                </button>

                                            </div>
                                            <div class="col-2 p-0 m-0 text-right">
                                                <button type="button"
                                                        class="btn btn-sm btn-block btn-outline-danger"
                                                        onclick="removeDetailImageItem(this)">삭제</button>
                                            </div>

                                        </div>
                                        <label class="imagecheck">
                                            <div class="image-preview m-0">
                                                <img src="${e.target.result}" class="img img-fluid m-0" alt="">
                                            </div>
                                        </label>
                                    </div>
                                    <div class="card-footer m-0 p-0">
                                        <button type="button" class="btn btn-sm btn-block btn-light detail-more m-0" onclick="moreDetailImage(this)">펼치기</button>
                                    </div>
                                </div>
                            </li>

                    `;
                    item = $(item).prepend(cloned.attr('name', 'select_attach[]').removeAttr("id onchange"))
                    $('.sortable').append(item);

                    if (n < len - 1) {
                        readFile(++n)
                    } else {
                        $('#image-upload').val('');
                    }
                };
                reader.readAsDataURL(f);
            }(i));
        }

        function removeDetailImageItem(ele) {
            var key = $(ele).closest('li').data('id');
            Swal2.fire({
                text: '해당 이미지를 삭제하시겠습니까?',
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true,
            }).then(function (result) {
                if (result.isConfirmed) {
                    if (key !== 'isNewFile') {
                        $.ajax({
                            type: 'POST',
                            url: "/my/booth/delimage",
                            dataType: "JSON",
                            data: {id: $(ele).closest('li').data('id')},
                            success: function (res) {
                                $(ele).closest('li').remove();
                            }
                        });
                    } else {
                        $(ele).closest('li').remove();
                    }

                }
            });
        }

        function moreDetailImage(ele) {
            var preview = $(ele).closest('li').find('.image-preview');
            if (preview.css('height') === '60px') {
                preview.css('height', 'auto');
                $(ele).text('접기');
            } else {
                preview.css('height', '60px')
                $(ele).text('펼치기');
            }
        }

        function strToObject(str) {
            var array = $('.sortable').sortable('toArray');
            var result = [];
            $.each(array, function (i, value) {
                result.push((value !== 'isNewFile') ? {'id': value} : {'isNewFile': true});
            })
            return result;
        }

        function attachfiles(data) {
            let previewimages = []
            let urls = [];
            if (typeof data.booth_attach != 'undefined') {
                for (idx in data.booth_attach) {
                    let img = {
                        caption: 'sort : ' + data.booth_attach[idx].sort,
                        downloadUrl: '/storage/' + data.booth_attach[idx].url,
                        size: data.booth_attach[idx].attach_size,
                        width: "120px",
                        key: data.booth_attach[idx].id
                    };
                    urls.push('/storage/' + data.booth_attach[idx].url);
                    previewimages.push(img)
                }
            }
            $("#booth-intro-image").fileinput({
                theme: "fa",
                initialPreview: urls,
                initialPreviewAsData: true,
                initialPreviewConfig: previewimages,
                deleteUrl: "/my/booth/delimage",
                allowedFileTypes: ['image'],
                allowedFileExtensions: ['jpg', 'png', 'gif'],
                allowedPreviewTypes: ['image'],
                showUpload: false,
                overwriteInitial: false,
                showClose: false,
                showDownload: false,
                maxTotalFileCount: 3,
                msgFilesTooMany: '최대 {m}개만 업로드 가능합니다.',
                msgTotalFilesTooMany: '최대 {m}개만 업로드 가능합니다.',
                maxFileSize: 1024000,
                initialCaption: 'Detail',
                browseLabel: '사진 추가',
                removeLabel: '삭제',
                showCaption: false,
                btnDefault: '<button type="{type}" tabindex="500" title="{title}" class="{css}"{status}>{icon}{label}</button>',
                btnLink: '<a href="{href}" tabindex="500" title="{title}" class="{css}"{status}>{icon}{label}</a>',
                btnBrowse: '<div tabindex="500" class="{css}"{status}>{icon}{label}</div>',
                removeIcon: '<i class="material-icons">remove</i>&nbsp;',
                browseIcon: '<i class="material-icons">add</i>&nbsp;',
                // actionDownload: '<i class="material-icons">get_app</i>&nbsp;',
                browseClass: 'btn btn-sm btn-black',
                removeClass: 'btn btn-sm btn-warning',
                layoutTemplates: {
                    actions: '<div class="file-actions">\n' +
                        '    <div class="file-footer-buttons">\n' +
                        '        {delete} {zoom} {other}' +
                        '    </div>\n' +
                        '    {drag}\n' +
                        '    <div class="clearfix"></div>\n' +
                        '</div>',
                    caption: '<div class="file-caption form-control {class}" tabindex="500">\n' +
                        '  <span class="file-caption-icon"></span>\n' +
                        '  <input class="file-caption-name" onkeydown="return false;" onpaste="return false;">\n' +
                        '</div>',
                    actionDelete: '<button type="button" class="kv-file-remove {removeClass}" title="{removeTitle}"{dataUrl}{dataKey}>{removeIcon}</button>\n',
                    actionDrag: '<span class="file-drag-handle {dragClass}" title="{dragTitle}">{dragIcon}</span>',
                    actionZoom: '<button type="button" class="kv-file-zoom {zoomClass}" title="{zoomTitle}111">{zoomIcon}</button>',
                    actionDownload: '<button type="button" class="{downloadClass}" title="{downloadTitle}" data-url="{downloadUrl}" data-caption="{caption}">{downloadIcon}</button>\n',
                },
            });
            $('#booth-intro-image').on('filezoomhidden', function (event, params) {
                $("body").addClass("modal-open");
            });
            $('#booth-intro-image').on('filedeleted', function (event, id, index) {
            });
            $('#booth-intro-image').on('filesorted', function (event, params) {
                let data = {};
                for (idx in params.stack) {
                    data['keys["' + params.stack[idx].key + '"]'] = parseInt(idx) + 1;
                }
                data['key'] = params.stack[params.newIndex].key;
                data['old'] = params.oldIndex + 1;
                data['new'] = params.newIndex + 1;
                $.ajax({
                    url: '/my/booth/attachsort',
                    method: "POST",
                    data: data,
                    dataType: 'JSON',
                    success: function (res) {
                        toastPopup(res.message)
                    },
                });


            });
        }

        function ytVidId(url) {
            var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
            return (url.match(p)) ? RegExp.$1 : false;
        }

        $(function () {
            attachfiles(@json($booth));
            /* Booth */
            $.uploadPreview({
                input_field: "#image-upload-pc",   // Default: .image-upload
                preview_box: "#image-preview-pc",  // Default: .image-preview
                label_field: "#image-label-pc",    // Default: .image-label
                label_selected: "변경",  // Default: Change File
                success_callback: function () {

                },
            });

            $.uploadPreview({
                input_field: "#image-upload-mobile",   // Default: .image-upload
                preview_box: "#image-preview-mobile",  // Default: .image-preview
                label_field: "#image-label-mobile",    // Default: .image-label
                label_selected: "변경",  // Default: Change File
                success_callback: function () {

                },
            });
            var saveForm = $('form[name=booth-save]');
            saveForm.submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                if (formData.get('booth_youtube_url') && !ytVidId(formData.get('booth_youtube_url'))) {
                    confirmPopup('유효하지 않는 Youtube 주소입니다.', 'error');
                    return false;
                }


                // var sortableData = JSON.stringify(strToObject());
                // formData.append('sortable', sortableData)

                $.ajax({
                    type: 'POST',
                    url: "/my/booth/save",
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
                                showDenyButton: true,
                                denyButtonText: '부스 바로보기',
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success',
                                    denyButton: 'btn btn-sm btn-black',
                                },

                            }).then(function (value) {
                                if (value.isDenied) {
                                    window.location.href = '/expo/{{$booth->expobooth->expo_code}}/{{$booth->id}}';
                                }
                            });
                        } else {
                            Swal2.fire({
                                text: res.msg,
                                icon: 'error',
                                showConfirmButton: true,
                            });
                        }

                    },
                });
            });


            $('input[name=booth_youtube_url]').change('keyup', function () {
                $('input[name=booth_movtype]').val('youtube');
                if (!$(this).val())
                    $('input[name=booth_movtype]').val('')
            });
            // $('.sortable').sortable({
            //     swap: true,
            //     swapClass: 'highlight', // The class applied to the hovered swap item
            //     handle: '.handle', // handle's class
            //     animation: 150,
            //     fallbackOnBody: true,
            //     // swapThreshold: 0.65,
            //     onEnd: function (evt) {
            //     },
            //     stop: function (event, ui) {
            //     }
            // });
        });
    </script>
@stop
