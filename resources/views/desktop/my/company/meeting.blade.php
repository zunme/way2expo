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
                                <div class="form-group">
                                    <input type="hidden" id="meeting_status">
                                    <input type="hidden" id="meeting_id">
                                    <ul class="nav nav-pills nav-pills-black p-0" id="filter-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active show" data-toggle="tab" data-status="" href="#" role="tablist"
                                               aria-expanded="true">
                                                전체
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" data-status="R" href="#"
                                               role="tablist"
                                               aria-expanded="false">
                                                대기
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" data-status="A" href="#"
                                               role="tablist"
                                               aria-expanded="false">
                                                승인
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" data-status="D" href="#"
                                               role="tablist"
                                               aria-expanded="false">
                                                반려
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" data-status="E" href="#"
                                               role="tablist"
                                               aria-expanded="false">
                                                종료
                                            </a>
                                        </li>
                                    </ul>

                                </div>

                                <table class="table" id="dataTable">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>부스 명</th>
                                        <th>요청시간</th>
                                        <th>요청인</th>
                                        <th>상태</th>
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
                    data.meeting_id = $("#meeting_id").val();
                    data.meeting_status = $("#meeting_status").val();
                    $.ajax({
                        'type': 'POST',
                        'url': "/my/meeting/receive/list",
                        "data": $.extend({}, data, {}),
                        'success': function (json) {
                            recordsTotal = json.recordsTotal;
                            callback(json);
                        },

                    });
                },
                "dom": "<'row justify-content-between align-items-center'<'col-8'i><'col-4 text-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'P><'col-sm-12 col-md-7'p>>",
                "language": {
                    "info": "총 _TOTAL_개의 화상회의 요청이 있습니다.",
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
                        data: "rownum",
                        visible: false,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return recordsTotal - data + 1;
                        }
                    },
                    {
                        data: "booth_title",
                        visible: true,
                        sortable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return data;
                        }
                    },
                    {
                        width: "200px",
                        data: "meeting_date",
                        sortable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return `${moment(row.meeting_date).format('Y.M.D')} ${pad(row.meeting_time, 2)}:00~${parseInt(row.meeting_time) + 1}:00`;
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
                        sortable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            if (data === 'R') return '<span class="text-info">승인대기</span>'
                            if (data === 'E') return '<span class="">종료</span>'
                            if (data === 'D') return '<span class="text-warning">반려</span>'
                            if (data === 'A') {
                                if (row.meeting_ready) {
                                    return `<a href='/meeting/${row.meeting_cid}' class="btn btn-sm btn-danger" target="_blank">미팅참가</a>`;
                                }
                                return '<span class="">종료</span>';
                            }
                            if (data === 'C') return '<span class="text-warning">취소</span>'
                        }
                    },
                    {
                        width: "200px",
                        data: "created_at",
                        sortable: true,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return moment(data).format('Y.MM.DD H:mm:ss');
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
            $('#filter-tab a').on('click', function (e) {
                e.preventDefault()
                $('#meeting_status').val($(this).data('status'))
                dataTable.draw()
            })
            @if(!empty(request()->id))
                $('#meeting_id').val({{request()->id}})
                dataTable.draw()

            @endif
        });

        function pad(n, width) {
            n = n + '';
            return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
        }


        function view(btn) {
            selected_row = $(btn).closest('tr');
            var row_data = dataTable.row(selected_row).data();
            pop_tpl('default', 'confirmpop', row_data);
        }

    </script>
    @include('desktop.my.meeting.template')
@stop
