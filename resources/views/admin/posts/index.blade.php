@extends('admin.defaultlayout')
@section('css')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="/admin_assets/stisla/node_modules/chocolat/dist/css/chocolat.css">
    <link rel="stylesheet" href="/admin_assets/stisla/node_modules/summernote/dist/summernote-bs4.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/css/fileinput.min.css" media="all"
          rel="stylesheet" type="text/css"/>


    <style>
        .list-group-item.highlight {
            outline: -webkit-focus-ring-color auto 1px;
        }

        .dt-highlight-row {
            background-color: #e3eaef !important;
        }

        .dataTables_filter label {
            font-weight: 600 !important;
            color: #34395e !important;
            font-size: 12px !important;
            letter-spacing: .5px !important;
        }

        .dataTables_info {
            font-weight: 600 !important;
            color: #34395e !important;
        }

        .table td .buttons button, .table td .buttons a {
            vertical-align: top;
            line-height: 1rem;
        }

        .image-preview {
            width: auto;
            height: 60px;
            overflow: auto;
        }

        .image-preview input, #callback-preview input {
            width: 100%;
        }

        .sortable li {
            line-height: 1;
        }
    </style>
@endsection
@section('main')
    <div class="section-header">
        <h1>공지사항</h1>
    </div>
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>목록</h4>
                            <div class="card-header-action">
                                <button class="btn btn-primary" onClick="edit(this)">
                                    등록하기
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-md" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>제목</th>
                                        <th>날짜</th>
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
    </section>
@endsection
@section('script')
    <script src="/admin_assets/stisla/node_modules/summernote/dist/summernote-bs4.js"></script>
    <script src="/admin_assets/stisla/node_modules/summernote/dist/lang/summernote-ko-KR.min.js"></script>
    <script>
        $(function () {
            let recordsTotal = 0;
            dataTable = $('#dataTable').DataTable({
                "pageLength": 10,
                "processing": true,
                "serverSide": true,
                "ajax": function (data, callback, settings) {
                    $.ajax({
                        'type': 'get',
                        'url': "/admin/posts/list",
                        "data": $.extend({}, data, {}),
                        'success': function (json) {
                            recordsTotal = json.recordsTotal;
                            if (typeof json.noti !== 'undefined') {
                                if ($(settings.nTHead).find('tr').length > 0) {
                                    $(settings.nTHead).find('tr:not(:first)').remove();
                                }
                                if (json.noti.length > 0) {
                                    let headLength = $(settings.nTHead).find('th').length;
                                    for (const notiKey in json.noti) {
                                        let noti = json.noti[notiKey];
                                        let notiRow = $('<tr>', {
                                            role: 'row',
                                            append: [
                                                $('<th>', {text: '[공지]'}),
                                                $('<th>', {
                                                    text: noti.title,
                                                    // colspan: headLength - 3,
                                                }),
                                                $('<th>', {
                                                    text: moment(noti.created_at).format('Y.MM.DD'),
                                                }),
                                                $('<th>', {
                                                    append: $('<button>', {
                                                        class: 'btn btn-sm btn-primary',
                                                        text: '보기',
                                                        on: {
                                                            click: function () {
                                                                edit(this, noti);
                                                            }
                                                        }
                                                    }),
                                                }),
                                            ]
                                        });
                                        $(settings.nTHead)
                                            .append(notiRow)
                                    }
                                }
                            }
                            callback(json);

                        },
                    });
                },
                "dom": "<'row justify-content-between'<'col-4'l><'col text-right'>><'row justify-content-between'<'col-4'i><'col'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'P><'col-sm-12 col-md-7'p>>",
                "language": {
                    "info": "_TOTAL_ 건",
                    "infoFiltered": "/ 전체 _MAX_ 건",
                    "infoEmpty": "검색된 결과가 없습니다.",
                    "emptyTable": "검색된 결과가 없습니다.",
                    "zeroRecords": "검색된 결과가 없습니다.",
                    "lengthMenu": "표시 _MENU_ 개",
                    "search": "검색:",
                    "paginate": {
                        "first": "처음",
                        "last": "끝",
                        "next": "다음",
                        "previous": "이전"
                    },
                },
                "columnDefs": [],
                "createdRow": function (row, data, dataIndex) {
                },
                "columns": [
                    {
                        data: "rownum",
                        width: 50,
                        visible: true,
                        searchable: false,
                        sortable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return recordsTotal - data + 1;
                        }
                    },
                    {
                        data: "title",
                        visible: true,
                        searchable: true,
                        sortable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data;
                        }
                    },
                    {
                        data: "created_at",
                        width: 100,
                        sortable: false,
                        render: function (data) {
                            return moment(data).format('Y.MM.DD');
                        }
                    },
                    {
                        data: null,
                        width: 80,
                        sortable: false,
                        render: function (data, type, row) {
                            let buttons = '<div class="buttons">';
                            buttons += `
                            <button type="button" class="btn btn-sm btn-icon btn-primary" onClick="edit(this)">보기</button>
                            `;
                            buttons += `</div>`;
                            return buttons;
                        },
                    },
                    {
                        data: "noti",
                        visible: false,
                        searchable: false
                    }

                ],
                "initComplete": function (settings, json) {
                    var textBox = $('#dataTable_filter label input');
                    textBox.unbind();
                    textBox.bind('keyup input', function (e) {
                        if (e.keyCode === 8 && !textBox.val() || e.keyCode === 46 && !textBox.val()) {
                        } else if (e.keyCode === 13 || !textBox.val()) {
                            dataTable.search(this.value).draw();
                        }
                    });

                },
            });
        });

        function addFiles(el) {
            let inp = $(el).parent()
            inp.parent().append(inp.clone());
        }

        function edit(btn, json) {
            selected_row = $(btn).closest('tr');
            var row_data = dataTable.row(selected_row).data();
            if (json) row_data = json;
            $('#modal-xl').on('show.bs.modal', function () {
                if (jQuery().summernote) {
                    $(".summernote-simple").summernote({
                        dialogsInBody: true,
                        lang: "ko-KR",
                        disableResizeEditor: true,
                        height: 400,
                        toolbar: [
                            ['font', ['bold', 'italic', 'underline', 'clear']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['height', ['height']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'hr']],
                            ['view', ['fullscreen', 'codeview']],
                        ],
                        callbacks: {}
                    });
                }
                $('form[name=postForm]').unbind('submit').submit(function (e) {
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: "/admin/posts/save",
                        dataType: "JSON",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (res) {
                            if (res.result === 'OK') {
                                swal({
                                    text: res.msg,
                                    icon: 'success',
                                    button: true,
                                }).then(function (result) {
                                    dataTable.ajax.reload(null, false);
                                    $('#modal-xl').modal('hide');
                                });

                            } else {
                                swal({
                                    text: res.msg,
                                    icon: 'error',
                                    button: true,
                                });
                            }

                        },
                        error: function (err) {
                            ajaxError(err)
                        }
                    });
                    return false;
                });
                $('#addFiles').unbind('click').on('click', function (e) {
                    let btnRemove = $('<button>', {
                        type: 'button',
                        class: 'btn btn-sm btn-icon btn-danger',
                        on: {
                            click: function (e) {
                                $(e.target).closest('div').remove();
                            }
                        },
                        append: $('<i>', {class: 'fas fa-times'}),
                    })
                    let inpFormGroup = $('<div>', {
                        append: [
                            $('<input>', {
                                type: 'file',
                                name: 'select_attach[]',
                            }),
                            btnRemove
                        ]
                    })
                    $(e.target).closest('div').append(inpFormGroup);
                });

            });
            $('#modal-xl').on('hide.bs.modal', function () {
                $('form[name=postForm]').unbind('submit');
            });
            pop_tpl('xl', 'viewpop', row_data);
        }

        function removePost() {
            let form = $('form[name=postForm]');
            let id = form.find('input[name=id]');

            swal({
                title: '',
                text: "글을 삭제하시겠습니까?",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    confirm: "삭제",
                    cancel: {
                        text: "취소",
                        value: null,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                },

            }).then((value) => {
                if (value) {
                    $.post('/admin/posts/removePost', {id:id.val()}).done(function (res) {
                        iziToast.success({
                            message: res.msg,
                            position: 'topRight'
                        });
                        $('#modal-xl').modal('hide');
                        dataTable.ajax.reload(null, false);
                    })
                }
            });
        }

        function removeFile(el) {
            let url = $(el).data('path');
            swal({
                title: '',
                text: "파일을 삭제하시겠습니까?",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    confirm: "삭제",
                    cancel: {
                        text: "취소",
                        value: null,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                },

            }).then((value) => {
                if (value) {
                    $.post('/admin/posts/removeAttach', {id: $(el).data('id'), url: url}).done(function (res) {
                        iziToast.success({
                            message: res.msg,
                            position: 'topRight'
                        });
                        $(el).closest('div').remove();
                        dataTable.ajax.reload(null, false);
                    })
                }
            });

        }

    </script>
    @include('admin.posts.template')
@stop
