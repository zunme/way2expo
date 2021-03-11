@extends('desktop.layouts.none')
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
                        @if(!$has_live)
                            @if(!session()->has('guide'))
                                @include('desktop.my.booth.live_guide')
                            @else
                                @include('desktop.my.booth.live_cast')
                            @endif
                        @else
                            <h4>라이브 중입니다.</h4>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        $(function () {
            var agreeForm = $('form[name=agreeForm]');
            agreeForm.submit(function (e) {
                let isCheck = $('input[name=agree]').prop('checked');
                if(isCheck){
                    return;
                }
                Swal2.fire({
                    html: '서비스 이용을 위해서는<br>반드시 규정 확인 및 동의가 필요합니다.',
                    icon: 'warning',
                    showConfirmButton: true,
                });
                e.preventDefault();
            });
        });
    </script>
@stop
