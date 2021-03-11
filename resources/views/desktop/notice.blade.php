@extends('desktop.layouts.none')
@section('css')
    <style>
        #dataTable tbody tr[role*=row], .dt-noti{
            cursor:pointer;
        }
    </style>
@stop
@section('header-class','')
@section('body-class', '')
@section('header', '')
@section('body')
    <div class="main">
        <div class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <table class="table" id="dataTable">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>제목</th>
                                <th>날짜</th>
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
@section('page-after')
    @verbatim
    <script id="detail" type="text/x-handlebars-template">
        {{{body}}}
        {{#if (gt attach_files.length 0)}}
        첨부파일
            {{#each attach_files}}
            <div><a href="/notice/filedown?id={{id}}" class='file-download' data-id='{{id}}' download>{{org_name}} <small>({{size}})</small></a></div>
            {{/each}}
        {{/if}}
    </script>
    @endverbatim
@stop
@section('page-script')
    <script src="/assets/js/plugins/jquery.dataTables.min.js"></script>
    <script src="/assets/js/plugins/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function () {
            let recordsTotal = 0;
            dataTable = $('#dataTable').DataTable({
                "pageLength": 15,
                "lengthChange": false,
                "searching": false,
                "info": false,
                "processing": false,
                "serverSide": true,
                "ajax": function (data, callback, settings) {
                    $.ajax({
                        'type': 'get',
                        'url': "/notice/list",
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
                                            class: 'dt-noti',
                                            role: 'row',
                                            append: [
                                                $('<th>', {text: '[공지]'}),
                                                $('<th>', {
                                                    text: noti.title,
                                                }),
                                                $('<th>', {
                                                    text: moment(noti.created_at).format('Y.MM.DD'),
                                                }),
                                            ],
                                            on: {
                                                click: function () {
                                                    let bodyRow = $('<tr>', {
                                                        append:$('<td>',{
                                                            colSpan: headLength,
                                                        })
                                                    });
                                                    let parent = $(this);
                                                    if ($(this).hasClass('shown')) {
                                                        $(this).next().remove();
                                                        $(notiRow).removeClass('shown');
                                                    } else {
                                                        $.get('/notice/'+noti.id).done(function(res){
                                                            if (res.result === 'OK') {
                                                                let template = Handlebars.compile($("#detail").html());
                                                                let detail = $('<div>').html(template(res.data))
                                                                $(parent).after($(bodyRow).find('td').html(detail));
                                                                $(notiRow).addClass('shown');
                                                            }
                                                        });
                                                    }
                                                }
                                            }
                                        });
                                        $(settings.nTHead)
                                            .append(notiRow);
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
                        width: 100,
                        visible: true,
                        sortable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return recordsTotal - data + 1;
                        }
                    },
                    {
                        data: "title",
                        visible: true,
                        sortable: false,
                        searchable: true,
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
                ],
                "initComplete": function (settings, json) {
                },
            });

            // Add event listener for opening and closing details
            $('#dataTable').on('click', 'tbody > tr[role=row]', function () {
                var row = dataTable.row($(this));
                if (row.child.isShown()) {
                    row.child.hide();
                    $(this).removeClass('shown');
                } else {
                    $.get('/notice/'+row.data().id).done(function(res){
                        if (res.result === 'OK') {
                            let template = Handlebars.compile($("#detail").html());
                            let detail = $('<div>').html(template(res.data))
                            row.child(detail).show();
                            $(this).addClass('shown');
                        }
                    });
                }
            });

        });
    </script>
@stop
