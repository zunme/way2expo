@extends('admin.defaultlayout')
@section('css')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="/admin_assets/stisla/node_modules/chocolat/dist/css/chocolat.css">

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
        <h1>부스관리</h1>
    </div>
    <section class="section">
        <div class="section-body">
            <!--
            <h2 class="section-title">Table</h2>
            <p class="section-lead">Example of some Bootstrap table components.</p>
            -->


            {{--            <div class="row">--}}
            {{--                <div class="col-6">--}}
            {{--                    <div class="card">--}}
            {{--                        <div class="card-body">--}}
            {{--                            <div class="form-group">--}}
            {{--                                <label for="image-upload" class="btn btn-sm btn-icon btn-primary text-white" style="cursor:pointer">--}}
            {{--                                    <i class="fas fa-plus"></i>--}}
            {{--                                </label>--}}
            {{--                                <input type="file" class="d-none" id="image-upload" onchange="addDetailImage(this)">--}}
            {{--                                <form name="detail">--}}
            {{--                                <ul class="list-group sortable">--}}
            {{--                                </ul>--}}
            {{--                                    <button class="btn" type="submit">확인</button>--}}
            {{--                                </form>--}}
            {{--                            </div>--}}

            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}


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
                                <table class="table table-striped table-md" id="booth_table">
                                    <thead>
                                    <tr>
                                        <th>박람회 명</th>
                                        <th>기업 명</th>
                                        <th>제목</th>
                                        <th>동영상</th>
                                        <th>사용</th>
                                        <th>노출</th>
                                        <th>이미지</th>
                                        <th>등록일시</th>
                                        <th>관리</th>
                                    </tr>
                                    </thead>
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
    <script src="/admin_assets/stisla/node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
    <script src="/admin_assets/stisla/assets/js/page/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
    <script src="/admin_assets/stisla/assets/js/page/jquery.uploadPreview.min.js"></script>

    <script>
        $(function () {
            $('.sortable').sortable({
                swap: true,
                swapClass: 'highlight', // The class applied to the hovered swap item
                handle: '.handle', // handle's class
                animation: 150,
                fallbackOnBody: true,
                // swapThreshold: 0.65,
                onEnd: function (evt) {
                },
                stop: function (event, ui) {
                }
            });

            boothTable = $('#booth_table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    'url': "/admin/booth-list",
                    'data': function (data) {
                        data.display_status = $('#display_status').val();
                        data.use_status = $('#use_status').val();
                        data.selected_expo = $('#selected_expo').val();
                    }

                },
                "dom": "<'row justify-content-between'<'col-4'l><'col text-right'>><'row justify-content-between'<'col-4'i><'col'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'P><'col-sm-12 col-md-7'p>>",
                "order": [[6, 'desc']],
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
                "initComplete": function (settings, json) {
                    var textBox = $('#booth_table_filter label input');
                    textBox.unbind();
                    textBox.bind('keyup input', function (e) {
                        if (e.keyCode === 8 && !textBox.val() || e.keyCode === 46 && !textBox.val()) {
                            // do nothing ¯\_(ツ)_/¯
                        } else if (e.keyCode === 13 || !textBox.val()) {
                            boothTable.search(this.value).draw();
                        }
                    });
                    $("#booth_table_wrapper > div:nth-child(1) > div:nth-child(1)").removeClass('col-md-6').addClass('col-md-2');
                    $("#booth_table_wrapper > div:nth-child(1) > div:nth-child(2)").removeClass('col-md-6').addClass('col-md-10');
                    let addSearch = `
                            <div class="form-group m-0">
                            <label class="col-form-label mr-2">박람회</label>
                            <select name="selected_expo"
                                    class="form-control form-control-sm form-control-sm-important inline-select mr-2"
                                    onChange="boothTable.draw()" id="selected_expo"
                                    style="width:110px">
                                <option value="">전체</option>
                            </select>
                            <label class="col-form-label mr-2">사용상태</label>
                            <select name="use_status"
                                    class="form-control form-control-sm form-control-sm-important inline-select mr-2"
                                    onChange="boothTable.draw()" id="use_status"
                                    style="width:80px">
                                <option value="">전체</option>
                                <option value="Y">Y</option>
                                <option value="N">N</option>
                            </select>
                            <label class="col-form-label mr-2">노출상태</label>
                            <select name="display_status"
                                    class="form-control form-control-sm form-control-sm-important inline-select"
                                    onChange="boothTable.draw()" id="display_status"
                                    style="width:80px">
                                <option value="">전체</option>
                                <option value="Y">Y</option>
                                <option value="N">N</option>
                            </select>
                            </div>
                    `;
                    // $("#booth_table_filter").append(addSearch);
                    $("#booth_table_length").parent().next().append(addSearch);
                    let expo_list = boothTable.ajax.json().expo_list;
                    $(expo_list).each(function (index, data) {
                        $('#selected_expo').append($("<option>", {
                            value: data.id,
                            text: data.expo_name
                        }));
                    });
                },
                "columnDefs": [
                    {"targets": [2], "searchable": true, "sortable": false},
                    {"targets": [3], "searchable": false, "sortable": false},
                    {"targets": [4], "searchable": true, "sortable": false},
                    {"targets": [5], "searchable": true, "sortable": false},
                    {"targets": [6], "searchable": false, "sortable": true},
                    {"targets": [7], "searchable": false, "sortable": false},
                    {"targets": [8], "searchable": false, "sortable": false},
                    {"targets": [9], "visible": false, "searchable": false, "sortable": false},
                ],
                "createdRow": function (row, data, dataIndex) {
                    // $('td:eq(0)', row).css('min-width', '108px');
                    // $('td:eq(1)', row).css('min-width', '108px');
                    // $('td:eq(2)', row).css('min-width', '200px');
                    // $('td:eq(3)', row).css('min-width', '60px');
                    // $('td:eq(4)', row).css('min-width', '60px');
                    // $('td:eq(5)', row).css('min-width', '60px');
                    // $('td:eq(6)', row).css('min-width', '150px');
                    // $('td:eq(7)', row).css('min-width', '150px');
                    // $('td:eq(8)', row).css('min-width', '150px');
                },
                "columns": [
                    {
                        data: "expo_booth.expo_name",
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data;
                            // return data + '<a href="#" class="btn btn-sm btn-link"><i class="fa fa-cog"></i></a>';
                        }
                    },
                    {
                        data: "company_booth.company_name",
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data;
                        }
                    },
                    {data: "booth_title"},
                    {
                        data: "booth_movtype",
                        render: function (data, type, row) {
                            let alink = '';
                            let badge = '';
                            if (data === 'youtube') {
                                badge = '<a href="' + row.booth_youtube_url + '" target="_blank" role="button" class="btn btn-sm btn-icon btn-round p-0"><i class="fab fa-youtube" style="font-size:17px;color:red;vertical-align: middle;"></i></a>';
                            } else if (data === 'mp4') {
                                badge = '<a href="#" role="button" class="btn btn-sm btn-icon btn-round p-0"><i class="fa fa-file-video" style="font-size:17px;vertical-align: middle;"></i></a>';
                            } else {
                                badge = '<span class="">-</span>';
                            }
                            return badge;
                        },
                    },
                    {
                        data: "booth_use_yn",
                        render: function (data) {
                            return data;
                        },
                    },
                    {
                        data: "booth_display_yn",
                        render: function (data, type, row) {
                            return data;
                        },
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            let html = '<div class="gallery">';
                            if (row.booth_image_url !== null && typeof row.booth_image_url !== 'undefined') {
                                html += `<div class="gallery-item" data-image="${row.booth_image_url}" data-title="Image 1" data-toggle="tooltip" data-placement="top" title="" data-original-title="데스크탑용 이미지"></div>`;
                            } else {
                                html += '-';
                            }
                            if (row.booth_mobile_image_url !== null && typeof row.booth_mobile_image_url !== 'undefined') {
                                html += `<div class="gallery-item" data-image="${row.booth_mobile_image_url}" data-title="Image 1" data-toggle="tooltip" data-placement="top" title="" data-original-title="모바일용 이미지"></div>`;
                            } else {
                                html += '-';
                            }
                            html += '</div>';
                            return html;
                        },
                    },
                    {
                        data: "created_at",
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return ''
                            else return data;
                        }
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            let buttons = '<div class="buttons">';
                            buttons += `
                            <button type="button" class="btn btn-sm btn-icon btn-primary" onClick="edit(this)">수정</button>
                            `;
                            if (row.expo_booth !== null && typeof row.expo_booth !== 'undefined') {
                                buttons += `<a href="/expo/${row.expo_booth.expo_code}/${row.id}" target="_blank" role="button" class="btn btn-sm btn-icon btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="홈페이지에서 보기">미리보기</a>`;
                            }
                            buttons += `</div>`;
                            return buttons;
                        },
                    },
                    {data: "id"},
                ],
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
                    if (jQuery().Chocolat) {
                        chocolateapi = $(".gallery").Chocolat({
                            className: 'gallery',
                            imageSelector: '.gallery-item',
                        }).data('chocolat');
                    }
                },
                "preDrawCallback": function (settings) {
                    if (typeof chocolateapi != 'undefined') {
                        chocolateapi.api().destroy();
                    }
                },

            });

            $("#booth_table tbody").on('click', 'tr', function (event) {
                $("#booth_table tbody tr").removeClass('dt-highlight-row');
                $(this).addClass('dt-highlight-row');
            });


            $('#modal-lg').on('hidden.bs.modal', function (e) {
                $('.sortable').sortable('destroy');
                $('input[name=booth_youtube_url]').unbind();
                $('input[name=booth_movtype]').unbind();
                $('form[name=booth-save] button[type=submit]').unbind();
            })
        });

        function edit(btn) {
            selected_row = $(btn).closest('tr');
            var row_data = boothTable.row(selected_row).data();
            pop_tpl('lg', 'editpop', row_data);
        }

        function deleteBooth(btn) {
            selected_row = $(btn).closest('tr');
            var row_data = boothTable.row(selected_row).data();
            swal(`${row_data.booth_title} 부스를 삭제하시겠습니까?"`, {
                icon: "warning",
                title: `${row_data.expo_booth.expo_name} - ${row_data.company_booth.company_name}`,
                buttons: {
                    cancel: "취소",
                    confirm: {
                        text: '삭제',
                    },
                },
            })
                .then(function (isConfirm) {
                    if (isConfirm) {
                        const formData = new FormData();
                        formData.append('id', row_data.id);
                        $.ajax({
                            type: 'POST',
                            url: "/admin/booth-delete",
                            dataType: "JSON",
                            data: formData,
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
                                        if (result) {
                                            boothTable.ajax.reload(null, false);
                                        }
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
                    }
                });
        }

    </script>
    @include('admin.booth.template')
@stop
