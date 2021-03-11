@extends('desktop.layouts.none')
@section('body-class', '')
@section('header','')
@section('body')
<div class="main">
    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <h3 class="title">비밀번호 확인</h3>
                </div>
                <div class="col-4 ml-auto mr-auto">
                    <form name="confirm" method="post">
                        <div class="form-group">
                            <label for="password">비밀번호</label>
                            <input type="password" class="form-control" name="password" id="password" aria-required="true" placeholder="비밀번호를 입력하세요." required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-black btn-fill btn-block btn-ajax">
                                확인
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-script')
    <script>
        $(function () {
            /* Confirm */
            var confirmForm = $('form[name=confirm]');
            confirmForm.submit(function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "/confirm-password",
                    dataType: "json",
                    cache: false,
                    data: confirmForm.serialize(),
                    success: function (res) {
                        window.location.replace(res.url);
                    },
                });
            });
        });
    </script>
@stop
