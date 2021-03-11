@extends('desktop.layouts.none')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/css/fileinput.min.css" media="all"
          rel="stylesheet" type="text/css"/>
    <style>
        .gallery .gallery-item {
            float: left;
            display: inline-block;
            width: 100px;
            height: 100px;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            border-radius: 3px;
            margin-right: 7px;
            margin-bottom: 7px;
            cursor: pointer;
            transition: all .5s;
            position: relative;
        }

        .image-preview {
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

        .image-preview label {
            position: absolute;
            z-index: 5;
            opacity: 0.8;
            cursor: pointer;
            width: 60px;
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

        .btn-file input[type=file] {
            z-index: 2;
            cursor: pointer;
        }

        .file-footer-caption {
            line-height: 1;
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
                                <h4>전시상품은 박람회 개최기간 이전에는 공개되지 않습니다.</h4>
                                <table class="table" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox"
                                                           id="select-all" value="1">
                                                    <span class="form-check-sign"><em class="check"></em></span>
                                                </label>
                                            </div>
                                        </th>
                                        <th>이미지</th>
                                        <th>전시상품 명</th>
                                        <th>공개여부</th>
                                        <th>등록일자</th>
                                        <th>상세</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('page-after')
    @include('desktop.my.product.template')
@stop
@section('page-script')
    <script src="/assets/js/plugins/jquery.dataTables.min.js"></script>
    <script src="/assets/js/plugins/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/js/plugins/piexif.min.js"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/js/plugins/sortable.min.js"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/js/fileinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/themes/fa/theme.js"></script>

    <script>
        let booths = @json($booths);
        let booth = @json($booth);
        let recordsTotal = 0;
        $(function () {
            dataTable = $('#dataTable').DataTable({
                "pageLength": 5,
                "processing": false,
                "serverSide": true,
                "ajax": function (data, callback, settings) {
                    $.ajax({
                        'type': 'POST',
                        'url': "/my/booth/product/list",
                        "data": $.extend({}, data, {booth_id:{{request()->booth_id}}}),
                        'success': function (json) {
                            recordsTotal = json.recordsTotal;
                            callback(json);
                        },

                    });
                },
                "dom": "<'row justify-content-between align-items-center'<'col-8'i><'col-4 text-right'f><'col-12'<'d-flex justify-content-between dt-toolbar'>>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-12'<'d-flex justify-content-between dt-toolbar'>>>" +
                    "<'row'<'col-sm-12 col-md-5'P><'col-sm-12 col-md-7'p>>",
                "language": {
                    "info": "총 _TOTAL_개의 전시상품이 등록되어있습니다.",
                    "infoFiltered": "",
                    "infoEmpty": "",
                    "emptyTable": "정보가 없습니다.",
                    "zeroRecords": "정보가 없습니다.",
                    "lengthMenu": "표시 _MENU_ 개",
                    "search": "",
                    "searchPlaceholder": "검색어를 입력하세요.",
                    "paginate": {
                        "first": "처음",
                        "last": "끝",
                        "next": "다음",
                        "previous": "이전"
                    },
                },
                "columnDefs": [],
                "columns": [
                    {
                        width: 80,
                        visible: true,
                        sortable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            let checkbox = '<div class="form-check">' +
                                '<label class="form-check-label">' +
                                '<input class="form-check-input" type="checkbox" name="id[]" value="' + row.id + '">' +
                                '<span class="form-check-sign"><em class="check"></em></span>' +
                                '</label>' +
                                '</div>';
                            return checkbox;
                        }
                    },
                    {
                        width: 150,
                        data: "prd_img1",
                        visible: true,
                        sortable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            let html = '<div class="gallery">';
                            html += `<div class="gallery-item" data-image="/storage/${data}" data-title="Image 1" data-toggle="tooltip" data-placement="top" title="" data-original-title="제품" onClick="edit(this)"></div>`;
                            html += '</div>';
                            return html;

                        }
                    },
                    {
                        data: "prd_title",
                        visible: true,
                        sortable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-';
                            let block = '';
                            if (row.prd_use_yn === 'N')
                                block = '<div class="text-danger">관리자에 의해 노출이 되지 않는 상품입니다. (문의요망)</div>'
                            return '<button type="button" class="btn btn-link m-0 p-0" onClick="edit(this)">' + data + '</button>' + block;
                        }
                    },
                    {
                        width: 100,
                        data: "prd_display_yn",
                        visible: true,
                        sortable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return (data === 'Y') ? '공개' : '비공개';
                        }
                    },
                    {
                        width: 100,
                        data: "created_at",
                        visible: true,
                        sortable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return moment(data).format('Y.MM.DD');
                        }
                    },
                    {
                        width: 100,
                        data: null,
                        searchable: false,
                        sortable: false,
                        render: function (data, type, row) {
                            return '<button type="button" class="btn btn-sm btn-black" onClick="edit(this)">보기</button>';
                        },
                    },

                ],
                "initComplete": function (settings, json) {
                    var textBox = $('#dataTable_filter label input');
                    textBox.unbind();
                    textBox.bind('keyup input', function (e) {
                        if (e.keyCode === 8 && !this.value || e.keyCode === 46 && !this.value) {
                            dataTable.search(this.value).draw();
                        } else if (e.keyCode === 13 && this.value) {
                            dataTable.search(this.value).draw();
                        } else {

                        }
                    });
                    let disableBtn = $('<button/>', {
                        type: 'button',
                        class: 'btn btn-sm btn-black',
                        text: '선택 비공개',
                        on: {
                            click: function () {
                                var data = dataTable.$('input[type="checkbox"]').serialize();
                                if (data.length > 0) {
                                    confirmPopup('선택한 상품을 비공개하시겠습니까?', 'warning', function (val) {
                                        data += '&display=N';
                                        if (val.isConfirmed) {
                                            $.ajax({
                                                type: 'POST',
                                                url: '/my/booth/product/display',
                                                data: data,
                                                dataType: "JSON",
                                                cache: false,
                                                success: function (res) {
                                                    dataTable.ajax.reload(null, true);
                                                    confirmPopup(res.msg, 'success')
                                                },
                                            });
                                        }
                                    }, {
                                        showCancelButton: true,
                                        customClass: {
                                            confirmButton: 'btn btn-sm btn-danger',
                                            cancelButton: 'btn btn-sm btn-black'
                                        },
                                    });
                                } else {
                                    confirmPopup('선택항목이 없습니다.', 'warning')
                                }
                            }
                        }
                    });
                    let enableBtn = $('<button/>', {
                        type: 'button',
                        class: 'btn btn-sm btn-black',
                        text: '선택 공개',
                        on: {
                            click: function () {
                                var data = dataTable.$('input[type="checkbox"]').serialize();
                                if (data.length > 0) {
                                    confirmPopup('선택한 상품을 공개하시겠습니까?', 'warning', function (val) {
                                        data += '&display=Y';
                                        if (val.isConfirmed) {
                                            $.ajax({
                                                type: 'POST',
                                                url: '/my/booth/product/display',
                                                data: data,
                                                dataType: "JSON",
                                                cache: false,
                                                success: function (res) {
                                                    dataTable.ajax.reload(null, false);
                                                    confirmPopup(res.msg, 'success')
                                                },
                                            });
                                        }
                                    }, {
                                        showCancelButton: true,
                                        customClass: {
                                            confirmButton: 'btn btn-sm btn-danger',
                                            cancelButton: 'btn btn-sm btn-black'
                                        },
                                    });
                                } else {
                                    confirmPopup('선택항목이 없습니다.', 'warning')
                                }
                            }
                        }
                    });

                    let selectGroup = $('<div>', {
                        append: [disableBtn, enableBtn]
                    });

                    let addBtn = '<button class="btn btn-sm btn-black" onClick="edit()">등록하기</button>';
                    let importBtn = '<button class="btn btn-sm btn-black" onClick="copy()">복사하기</button>';
                    let toolGroup = $('<div>', {
                        append: [importBtn, addBtn]
                    })
                    $('div.dt-toolbar').append(selectGroup).append(toolGroup);

                    $('#select-all').on('click', function () {
                        var rows = dataTable.rows({'search': 'applied'}).nodes();
                        $('input[type="checkbox"]', rows).prop('checked', this.checked);
                    });

                    $('#dataTable tbody').on('change', 'input[type="checkbox"]', function () {
                        if (!this.checked) {
                            var el = $('#select-all').get(0);
                            if (el && el.checked && ('indeterminate' in el)) {
                                el.indeterminate = true;
                                el.checked = false;
                            }
                        }
                    });
                },
                "drawCallback": function (settings) {
                    $(".gallery .gallery-item").each(function () {
                        var me = $(this);

                        me.attr('href', me.data('image'));
                        me.attr('title', me.data('title'));
                        if (me.parent().hasClass('gallery-fw')) {
                            me.css({
                                height: me.parent().data('item-height'),
                            });
                            me.find('div').css({
                                lineHeight: me.parent().data('item-height') + 'px'
                            });
                        }
                        me.css({
                            backgroundImage: 'url("' + me.data('image') + '")'
                        });
                    });
                    $('#select-all').prop('checked', false)
                },
                "preDrawCallback": function (settings) {
                },

            });
            $('#filter-tab a').on('click', function (e) {
                e.preventDefault()
                $('#meeting_status').val($(this).data('status'))
                dataTable.draw()
            })
        });

        function previewImg(obj) {
            var reader = new FileReader();
            var target = $(obj).parent().find('.preview-img');
            if (obj.files.length > 0) {
                reader.onload = (e) => {
                    var img = $('<img />');
                    img.attr('src', e.target.result).addClass('img img-fluid');
                    target.html(img)
                };
                reader.readAsDataURL(obj.files[0])
            } else {
                target.empty();
            }
        }

        function attachfiles(data) {
            let prdImages = ['prd_img1', 'prd_img2', 'prd_img3', 'prd_img4']
            for (const imgKey in prdImages) {
                if (data[prdImages[imgKey]] !== null && typeof data[prdImages[imgKey]] !== 'undefined') {
                    var img = $("<img />");
                    img.attr('src', '/storage/' + data[prdImages[imgKey]]).addClass('img img-fluid');
                    $('#preview-' + prdImages[imgKey]).html(img)
                }
            }
            let previewimages = []
            let urls = [];
            if (typeof data.prd_desc_img !== 'undefined') {
                for (idx in data.prd_desc_img) {
                    let img = {
                        caption: 'sort : ' + data.prd_desc_img[idx].sort,
                        downloadUrl: '/storage/' + data.prd_desc_img[idx].url,
                        width: "120px",
                        key: data.prd_desc_img[idx].id
                    };
                    urls.push('/storage/' + data.prd_desc_img[idx].url);
                    previewimages.push(img)
                }
            }

            $("#prd_imgs").fileinput({
                theme: "fa",
                initialPreview: urls,
                initialPreviewAsData: true,
                initialPreviewConfig: previewimages,
                initialPreviewShowDelete: true,
                previewFileType: 'image',
                deleteUrl: "/my/booth/product/delimage",
                allowedFileTypes: ['image'],
                allowedFileExtensions: ['jpg', 'png', 'gif'],
                allowedPreviewTypes: ['image'],
                dropZoneEnabled: false,
                showUpload: false,
                showClose: false,
                showRemove: false,
                showCaption: false,
                showDownload: false,
                overwriteInitial: false,
                maxTotalFileCount: 4,
                msgFilesTooMany: '최대 {m}개만 업로드 가능합니다.',
                msgTotalFilesTooMany: '최대 {m}개만 업로드 가능합니다.',
                maxFileSize: 1024000,
                initialCaption: 'Detail',
                browseLabel: '업로드',
                removeLabel: '삭제',
                btnDefault: '<button type="{type}" tabindex="500" title="{title}" class="{css}"{status}>{icon}{label}</button>',
                btnLink: '<a href="{href}" tabindex="500" title="{title}" class="{css}"{status}>{icon}{label}</a>',
                btnBrowse: '<div tabindex="500" class="{css}"{status}>{icon}{label}</div>',
                removeIcon: '<i class="material-icons"></i>&nbsp;',
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
            }).on('filesorted', function (event, params) {

                let data = {};
                for (idx in params.stack) {
                    data['keys["' + params.stack[idx].key + '"]'] = parseInt(idx) + 1;
                }
                data['key'] = params.stack[params.newIndex].key;
                data['old'] = params.oldIndex + 1;
                data['new'] = params.newIndex + 1;
                $.ajax({
                    url: '/my/booth/product/attachsort',
                    method: "POST",
                    data: data,
                    dataType: 'JSON',
                    success: function (res) {
                        toastPopup(res.message)
                    },
                });
            }).on('filedeleted', function (event, key, jqXHR, data) {
                toastPopup(jqXHR.responseJSON.msg);
            });
        }

        function pad(n, width) {
            n = n + '';
            return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
        }


        function edit(btn) {
            let selected_row = $(btn).closest('tr');
            let row_data = dataTable.row(selected_row).data();
            if (typeof row_data !== 'undefined') {
                $.post('/my/booth/product/detail', {product_id: row_data.id}).done(function (res) {
                    $("#modal-lg").on('shown.bs.modal', function () {
                        attachfiles(res.data);
                        disRate();

                        $('form[name=productForm]').submit(function (e) {
                            e.preventDefault();
                            var formData = new FormData(this);
                            $.ajax({
                                type: 'POST',
                                url: "/my/booth/product/save",
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
                                        }).then(function (result) {
                                            if (result.isConfirmed) {
                                                dataTable.ajax.reload(null, false);
                                                $('#modal-lg').modal('hide');
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
                        $('#prd_org_price,#prd_price').on('keyup', function () {
                            if ($(this).val())
                                $(this).val(parseInt($(this).val()));
                            disRate();
                        })

                    });
                    $('#modal-lg').on('hide.bs.modal', function (e) {
                        $('#prd_imgs').fileinput('destroy');
                        $('form[name=productForm]').unbind();
                        $('#prd_org_price,#prd_price').unbind();
                        $(this).unbind();
                    })
                    // if (typeof row_data === 'undefined')
                    //     row_data = $.extend(row_data, {booth_id: booth.id, expo_id: booth.expo_booth.id})
                    pop_tpl('lg', 'template-product-detail', res.data);

                });
            } else {
                row_data = $.extend(row_data, {booth_id: booth.id, expo_id: booth.expo_booth.id})
                pop_tpl('lg', 'template-product-detail', row_data);
            }
        }

        function copy() {
            $('#modal-lg').on('show.bs.modal', function () {
                dataTableSub = null;
                $('#boothSelectSub').change(function (e) {
                    let selected_booth_id = $(this).val();
                    let recordsTotal = 0;
                    if (selected_booth_id) {
                        $('.my-product-sub-list').removeClass('d-none')
                        if (dataTableSub != null) {
                            dataTableSub.destroy();
                            dataTableSub = null;
                        }
                        dataTableSub = $('#dataTableSub').DataTable({
                            "pageLength": 5,
                            "processing": false,
                            "serverSide": true,
                            "ajax": function (data, callback, settings) {
                                $.ajax({
                                    'type': 'POST',
                                    'url': "/my/booth/product/list",
                                    "data": $.extend({}, data, {copy: true, booth_id: selected_booth_id}),
                                    'success': function (json) {
                                        recordsTotal = json.recordsTotal;
                                        callback(json);
                                    },

                                });
                            },
                            "dom":
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'P><'col-sm-12 col-md-7'p>>",
                            "language": {
                                "info": "총 _TOTAL_개의 전시상품이 등록되어있습니다.",
                                "infoFiltered": "",
                                "infoEmpty": "",
                                "emptyTable": "정보가 없습니다.",
                                "zeroRecords": "정보가 없습니다.",
                                "lengthMenu": "표시 _MENU_ 개",
                                "search": "",
                                "searchPlaceholder": "검색어를 입력하세요.",
                                "paginate": {
                                    "first": "처음",
                                    "last": "끝",
                                    "next": "다음",
                                    "previous": "이전"
                                },
                            },
                            "scrollY": "300px",
                            "scrollCollapse": true,
                            "columnDefs": [],
                            "columns": [
                                {
                                    width: 80,
                                    visible: true,
                                    sortable: false,
                                    searchable: false,
                                    render: function (data, type, row) {
                                        let checkbox = '<div class="form-check">' +
                                            '<label class="form-check-label">' +
                                            '<input class="form-check-input" type="checkbox" name="id[]" value="' + row.id + '">' +
                                            '<span class="form-check-sign"><em class="check"></em></span>' +
                                            '</label>' +
                                            '</div>';
                                        return checkbox;
                                    }
                                },
                                {
                                    data: "prd_img1",
                                    width: 100,
                                    visible: true,
                                    sortable: false,
                                    searchable: false,
                                    render: function (data, type, row) {
                                        if (data == null || typeof data == 'undefined') return '-'
                                        let html = '<img src="/storage/' + data + '" width=100>';
                                        return html;

                                    }
                                },
                                {
                                    data: "prd_title",
                                    visible: true,
                                    sortable: false,
                                    searchable: false,
                                },
                            ],
                            "initComplete": function (settings, json) {
                                $('#sub-select-all').on('click', function () {
                                    var rows = dataTableSub.rows({'search': 'applied'}).nodes();
                                    $('input[type="checkbox"]', rows).prop('checked', this.checked);
                                });

                                $('#dataTableSub tbody').on('change', 'input[type="checkbox"]', function () {
                                    if (!this.checked) {
                                        var el = $('#sub-select-all').get(0);
                                        if (el && el.checked && ('indeterminate' in el)) {
                                            el.indeterminate = true;
                                            el.checked = false;
                                        }
                                    }
                                });
                            },
                            "drawCallback": function (settings) {
                                $('#sub-select-all').prop('checked', false)
                            },
                            "preDrawCallback": function (settings) {
                            },

                        });
                    } else {
                        $('.my-product-sub-list').addClass('d-none')
                    }
                })

                $('form[name=productCopyForm]').submit(function (e) {
                    e.preventDefault();
                    var formData = $(this).serializeObject();
                    if (typeof formData.id !== 'undefined') {
                        confirmPopup(formData.id.length + '개를 '+$('#boothSelect option:selected').text()+' 부스로 복사 하시겠습니까?','warning', function (val) {
                            if (val.isConfirmed) {
                                $.ajax({
                                    type: 'POST',
                                    url: "/my/booth/product/copy",
                                    dataType: "JSON",
                                    data: formData,
                                    success: function (res) {
                                        if (res.result === 'OK') {
                                            confirmPopup(res.msg,'success',function(val){
                                                if (val.isConfirmed) {
                                                    dataTable.ajax.reload(null, true);
                                                    $('#modal-lg').modal('hide');
                                                }
                                            });
                                        }
                                    },
                                });
                            }
                        },{showCancelButton:true});
                    }else{
                        confirmPopup('선택된 항목이 없습니다.','error');
                    }
                });

            });
            $('#modal-lg').on('hide.bs.modal', function () {
                $(this).unbind();
                $('#boothSelectSub').unbind();
            });
            pop_tpl('lg', 'template-product-copy', {booths: booths, booth: booth});
        }

        function disRate() {
            var dis_price = $("#prd_price").val().trim();
            var price = $("#prd_org_price").val().trim();
            if (price === "" || dis_price === "") {
                result = 0;
            } else {
                result = 100 - (dis_price / price * 100);
            }
            let rate = Math.floor(result);
            if (rate < 0) {
                $("#prd_price_percent").val('판매가격이 원가보다 높습니다.');
                return;
            }

            $("#prd_price_percent").val(rate);
        }

    </script>
@stop
