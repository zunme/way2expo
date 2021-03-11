@extends('desktop.layouts.none')
@section('css')
    <style>
        .meeting-confirm .modal-footer {
            border: 0;
            padding-top: 0
        }

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
            color: #999;
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
                    @include('desktop.my.company.lnb')
                </div>
                <div class="col-10">
                    <h4 class="title">요청받은 화상회의</h4>
                    <table class="table" id="dataTable">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>박람회 명</th>
                            <th>기업 명</th>
                            <th>이름</th>
                            <th>상태</th>
                            <th>예약일시</th>
                            <th>신청일시</th>
                            <th>내용</th>
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
                        'url': "/my/meeting/receive-list",
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
                        data: "expo_name",
                        sortable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data;
                        }
                    },
                    {
                        data: "company_name",
                        sortable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data;
                        }
                    },
                    {
                        data: "name",
                        sortable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data;
                        }
                    },
                    {
                        data: "meeting_status",
                        sortable: true,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            if (data === 'R') return '<span class="text-info">대기중</span>'
                            if (data === 'E') return '<span class="">종료</span>'
                            if (data === 'D') return '<span class="text-warning">미팅거절</span>'
                            if (data === 'A') {
                                if (moment(new Date()).unix() >= moment(`${row.meeting_date} ${row.meeting_time}`).unix() && moment(new Date()).unix() <= moment(`${row.meeting_date} ${row.meeting_time + 1}`).unix()) {
                                    return `<a href='/meeting/${row.meeting_cid}' class="btn btn-sm btn-danger" target="_blank">미팅참가</a>`;
                                }
                                return '<span class="">미팅종료</span>';
                            }
                            if (data === 'C') return '<span class="text-warning">취소</span>'
                        }
                    },
                    {
                        data: "meeting_date",
                        sortable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return `${row.meeting_date} ${row.meeting_time}시 ~ ${parseInt(row.meeting_time) + 1}시`;
                        }
                    },
                    {
                        data: "created_at",
                        sortable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return moment(data).format('Y.MM.DD');
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
                "drawCallback": function (settings) {
                },
            });

        });

        function view(btn) {
            selected_row = $(btn).closest('tr');
            var row_data = dataTable.row(selected_row).data();
            pop_tpl('default', 'confirmpop', row_data);
        }
    </script>
    @include('desktop.my.meeting.template')
@stop
