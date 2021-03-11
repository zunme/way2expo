@extends('desktop.layouts.none')
@section('body-class', '')
@section('header','')
@section('body')
<div class="main">
    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8 ml-auto mr-auto">
                    <h5>약관동의</h5>
                    <form name="agreeForm" action="{{ route('join.post.agree') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kakao_id" value="{{session('kakao_id')}}">
                        <div class="form-check text-right">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="select-all"> 전체 약관 동의
                                <span class="form-check-sign"><em class="check"></em></span>
                            </label>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="content">
                                    Where can I get some?
                                    There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                                </div>
                                <div class="form-check text-right">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               name="service_agree" value="Y"> 서비스 약관 동의
                                        <span class="form-check-sign"><em class="check"></em></span>
                                    </label>
                                </div>
                                <div class="content">
                                    Where can I get some?
                                    There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                                </div>
                                <div class="form-check text-right">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                               name="market_agree" value="Y"> 마케팅 이용 동의
                                        <span class="form-check-sign"><em class="check"></em></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-sm btn-black">다음</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-after')
@stop
@section('page-script')
    <script>
        $(function () {
            let form = $('form[name=agreeForm]')
            $('#select-all').on('click', function () {
                $('input[type="checkbox"]', form).prop('checked', this.checked);
            });

            form.on('change', 'input[type="checkbox"]', function () {
                if (!this.checked) {
                    var el = $('#select-all').get(0);
                    if (el && el.checked && ('indeterminate' in el)) {
                        el.indeterminate = true;
                        el.checked = false;
                    }
                }
            });
        });
    </script>
@stop
