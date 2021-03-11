@extends('desktop.layouts.none')
@section('css')
    <style>
        .card-meeting {
            list-style: none;
            padding: 0;
            margin: 10px auto;
            text-align: left;
        }

        .card-meeting .card-body {
            padding: 0;
        }

        .card-meeting ul {
            list-style: none;
            padding: 0;
            margin: 10px auto;
        }

        .card-meeting ul li {
            color: #343a40;
            text-align: left;
            padding: 12px 0;
            border-bottom: 1px solid rgba(153, 153, 153, .3);
        }

        .card-meeting ul li span.form-title {
            border: 0;
        }

        .card-meeting .form-check {
            margin: 0 5px 0 0;
        }

        .dataTables_empty {
            text-align: center;
            font-weight: 500;
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
                        <div class="row">
                            <div class="col-12">
                                <table class="table" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>박람회</th>
                                        <th>신청부스</th>
                                        <th>신청일시</th>
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
@section('page-script')
    <script src="/assets/js/plugins/jquery.dataTables.min.js"></script>
    <script src="/assets/js/plugins/dataTables.bootstrap4.min.js"></script>
    <script>
        let recordsTotal = 0;
        $(function () {
            dataTable = $('#dataTable').DataTable({
                "processing": false,
                "serverSide": true,
                "ajax": function (data, callback, settings) {
                    $.ajax({
                        'type': 'POST',
                        'url': "/my/exchange/send/list",
                        "data": $.extend({}, data, {}),
                        'success': function (json) {
                            recordsTotal = json.recordsTotal;
                            callback(json);
                        },

                    });
                },
                "dom": "<'row justify-content-between align-items-center'<'col-8'i><'col-4 text-right'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'P><'col-sm-12 col-md-7'p>>",
                "language": {
                    "info": "총 _TOTAL_개의 비즈니스 문의가 있습니다.",
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
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
                "columns": [
                    {
                        data: "booth_info.expo_booth.expo_name",
                        searchable: false,
                        sortable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data;
                        }
                    },
                    {
                        data: "booth_info.booth_title",
                        searchable: false,
                        sortable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data;
                        }
                    },
                    {
                        data: "created_at",
                        searchable: false,
                        sortable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return moment(data).format('Y.MM.D');
                        }
                    },

                    {
                        data: null,
                        searchable: false,
                        sortable: false,
                        render: function (data, type, row) {
                            let buttons = `
                            <div class="buttons">
                                <button type="button" class="btn btn-sm btn-black" onClick="view(this)">보기</button>
                            </div>
                            `;
                            return buttons;
                        }
                    },
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
                "drawCallback": function (settings) {
                },
            });

        });

        function view(btn) {
            selected_row = $(btn).closest('tr');
            var row_data = dataTable.row(selected_row).data();
            pop_tpl('default', 'viewpop', row_data);
        }
    </script>
    @include('desktop.my.contact.template')
@stop
