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
                        <div id="latest-template">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        $(function () {
            show_tpl($.urlParam('m'));
        });
        $.urlParam = function(name){
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            if (results==null){
                return null;
            }
            else{
                return results[1] || 0;
            }
        }

        function show_tpl(value) {
            const modeArr = ['expo', 'booth'];
            if(value === null || modeArr.indexOf(value) < 0) value = 'expo';
            let db;
            if (value === 'expo') {
                db = myexpoDB;
            } else if(value === 'booth'){
                db = myBootmDB;
            }
            db.allDocs({include_docs: true, descending: true})
                .then(function (result) {
                    console.log(result)
                    let sorted = result.rows.sort(function (a, b) {
                        return (a.doc.date > b.doc.date) ? -1 : (a.doc.date < b.doc.date) ? 1 : 0;
                    });
                    let template = Handlebars.compile($("#latest"+value).html());
                    $("#latest-template").html(template({'rows': sorted}));
                    if(result.total_rows < 1){
                        $('.not-found').show();
                    }
                });
        }
    </script>
    @include('desktop.my.template')
@stop
