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
        <h1>출품신청내역</h1>
    </div>
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>목록</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-md" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>박람회 명</th>
                                        <th>기업 명</th>
                                        <th>기업 주소</th>
                                        <th>담당자 명</th>
                                        <th>담당자 전화번호</th>
                                        <th>신청일시</th>
                                        <th>상세</th>
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
    <script>
        $(function () {
            let recordsTotal = 0;
            dataTable = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": function (data, callback, settings) {
                    data.meeting_id = $("#meeting_id").val();
                    data.meeting_status = $("#meeting_status").val();
                    $.ajax({
                        'type': 'get',
                        'url': "/admin/entrylist",
                        "data": $.extend({}, data, {}),
                        'success': function (json) {
                            recordsTotal = json.recordsTotal;
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
                "columnDefs": [
                ],
                "createdRow": function (row, data, dataIndex) {
                },
                "columns": [
                    {
                        data: "rownum",
                        visible: true,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return recordsTotal - data + 1;
                        }
                    },
                    {
                        data: "expo.expo_name",
                        visible: true,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data;
                        }
                    },
                    {
                        data: "company_name",
                        visible: true,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data;
                        }
                    },
                    {
                        data: "company_address1",
                        visible: true,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data + row.company_address2;
                        }
                    },
                    {
                        data: "manager_name",
                        visible: true,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data;
                        }
                    },
                    {
                        data: "manager_tel",
                        visible: true,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data.replace(/[^0-9]/g, "").replace(/(^02|^0505|^1[0-9]{3}|^0[0-9]{2})([0-9]+)?([0-9]{4})/,"$1-$2-$3").replace("--", "-") ;
                        }
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
                            <button type="button" class="btn btn-sm btn-icon btn-primary" onClick="view(this)">보기</button>
                            `;
                            buttons += `</div>`;
                            return buttons;
                        },
                    },

                ],
                "initComplete": function (settings, json) {
                    var textBox = $('#dataTable_filter label input');
                    textBox.unbind();
                    textBox.bind('keyup input', function (e) {
                        if (e.keyCode === 8 && !textBox.val() || e.keyCode === 46 && !textBox.val()) {
                            // do nothing ¯\_(ツ)_/¯
                        } else if (e.keyCode === 13 || !textBox.val()) {
                            dataTable.search(this.value).draw();
                        }
                    });
                },

            });
        });

        function view(btn) {
            selected_row = $(btn).closest('tr');
            var row_data = dataTable.row(selected_row).data();
            pop_tpl('lg', 'viewpop', row_data);
        }
    </script>
    @include('admin.entry.template')

@stop
