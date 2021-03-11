@extends('desktop.layouts.none')
@section('css')
    <style>
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
                        <table class="table" id="dataTable">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>제목</th>
                                <th>내용</th>
                                <th>일시</th>
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
                        'url': "/my/notification-list",
                        "data": $.extend({}, data, {}),
                        'success': function (json) {
                            recordsTotal = json.recordsTotal;
                            callback(json);
                        },

                    });
                },
                "dom": "<'row justify-content-between align-items-center'<'col-4'i><'col text-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'P><'col-sm-12 col-md-7'p>>",
                "language": {
                    "info": "전체 _TOTAL_",
                    "infoFiltered": "/ _MAX_",
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
                        data: "rownum",
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return recordsTotal - data + 1;
                        }
                    },

                    {
                        data: "data.title",
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data;
                        }
                    },
                    {
                        data: "data.content",
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            let btn = ``;
                            if(row.data.target === 'meeting.receive'){
                                btn = `<a href="/my/meeting/receive" class="btn btn-sm btn-link btn-just-icon"><i class="material-icons">open_in_new</i></a>`;
                            }
                            return data + btn;
                        }
                    },

                    {
                        data: "created_at",
                        sortable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data;
                        }
                    },
                ],
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
    @include('desktop.my.meeting.template')
@stop
