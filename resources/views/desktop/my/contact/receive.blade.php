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
                                <form name="tableForm">
                                    @csrf
                                </form>
                                    <table class="table" id="dataTable">
                                        <thead>
                                        <tr>
                                            <th>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox"
                                                               name="select_all"
                                                               id="select-all" value="1">
                                                        <span class="form-check-sign"><em class="check"></em></span>
                                                    </label>
                                                </div>
                                            </th>
                                            <th>??????</th>
                                            <th>??????</th>
                                            <th>?????????</th>
                                            <th>??????</th>
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
                "pageLength": 15,
                "processing": false,
                "serverSide": true,
                "ajax": function (data, callback, settings) {
                    data.user_name = $("#user_name").val();
                    $.ajax({
                        'type': 'POST',
                        'url': "/my/exchange/receive/list",
                        "data": $.extend({}, data, {}),
                        'success': function (json) {
                            recordsTotal = json.recordsTotal;
                            callback(json);
                        },

                    });
                },
                "dom": "<'row justify-content-between align-items-center'<'col-6'<'dt-toolbar'>><'col-6 text-right'i>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'P><'col-sm-12 col-md-7'p>>",
                "language": {
                    "info": "??? _TOTAL_?????? ???????????? ????????? ????????????.",
                    "infoFiltered": "",
                    "infoEmpty": "",
                    "emptyTable": "????????? ????????????.",
                    "zeroRecords": "????????? ????????????.",
                    "lengthMenu": "?????? _MENU_ ???",
                    "search": "",
                    "searchPlaceholder": "???????????? ???????????????.",
                    "paginate": {
                        "first": "??????",
                        "last": "???",
                        "next": "??????",
                        "previous": "??????"
                    },
                },
                "columnDefs": [],
                "columns": [
                    {
                        targets: 0,
                        searchable: false,
                        orderable: false,
                        className: 'dt-body-center',
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
                        data: null,
                        searchable: false,
                        sortable: false,
                        render: function (data, type, row) {
                            let cards = _.pick(row, ['card_sender.card', 'card_sender.business_card_front', 'card_sender.business_card_back'])
                            let view = '';
                            if (cards.card_sender.card !== null) {
                                let card = cards.card_sender.card;
                                return '??????:' + card.card_name + '??????:' + card.card_tel
                            } else if (cards.card_sender.business_card_front !== null) {
                                return '<img src="/storage/' + cards.card_sender.business_card_front + '" class="img img-fluid">';
                            } else if (cards.card_sender.business_card_back !== null) {
                                return '<img src="/storage/' + cards.card_sender.business_card_back + '" class="img img-fluid">';

                            }
                            return '-';
                        }
                    },
                    {
                        data: "read_yn",
                        searchable: false,
                        sortable: false,
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return '-'
                            return (data === 'N')?'?????????':'??????';
                        }
                    },
                    {
                        data: "created_at",
                        searchable: false,
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
                                <button type="button" class="btn btn-sm btn-black" onClick="view(this)">??????</button>
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
                    let removeBtn = $('<button/>', {
                        type: 'button',
                        class: 'btn btn-sm btn-black',
                        text: '????????????',
                        appendTo: 'div.dt-toolbar',
                        on: {
                            click: function () {
                                var data = dataTable.$('input[type="checkbox"]').serialize();
                                if (data.length > 0) {
                                    confirmPopup('?????? ????????? ?????????????????????????','warning',function(val){
                                        if (val.isConfirmed) {
                                            $.ajax({
                                                type: 'POST',
                                                url: '/my/exchange/remove',
                                                data: data,
                                                dataType: "JSON",
                                                cache: false,
                                                success: function (res) {
                                                    dataTable.ajax.reload(null, false);
                                                },
                                            });
                                        }
                                    },{showCancelButton:true});
                                }else{
                                    confirmPopup('??????????????? ????????????.', 'warning')
                                }
                            }
                        }
                    });
                },
                "drawCallback": function (settings) {
                    $('#select-all').prop('checked', false);
                },
            });

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
        });

        function view(btn) {
            selected_row = $(btn).closest('tr');
            var row_data = dataTable.row(selected_row).data();
            let cell = selected_row.find('td').eq(2);
            let cards = _.pick(row_data, ['card_sender.card', 'card_sender.business_card_front', 'card_sender.business_card_back'])
            row_data.cards = cards.card_sender;
            $.post('/my/exchange/view',{id: row_data.id}).done(function(res){
                let display = res.data.read_yn;
                let text = (display === 'Y') ? '??????' : '?????????';
                cell.text(text);
                pop_tpl('lg', 'viewcardpop', row_data);
            })
        }
    </script>
    @include('desktop.my.contact.template')
@stop
