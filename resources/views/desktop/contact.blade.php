@extends('desktop.layouts.none')
@section('body-class', '')
@section('header','')
@section('body')
    <div class="main">
        <div class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-8 ml-auto mr-auto">
                        <h3 class="title">제휴문의</h3>
                        <form name="contactForm" method="POST" action="/contact/save">
                            @csrf
                            <input type="hidden" name="user_id" value="{{Auth::id()}}">
                            <h5>정보입력</h5>
                            <div class="form-group">
                                <label>기업명/이름</label>
                                <input type="text" name="company_name" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label>기업전화번호</label>
                                <input type="tel" name="company_tel" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label>개인전화번호</label>
                                <input type="tel" name="tel" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label>이메일</label>
                                <input type="email" name="email" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label>제목</label>
                                <input type="text" name="title" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label>문의내용</label>
                                <textarea name="message" id="" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <label>파일첨부</label>
                                    <input type="file" name="select_file" class="form-control form-control-file"
                                           accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf,zip"
                                    >
                                    <div><small>* 10MB 이하의 파일 1개만 등록가능 합니다.</small></div>
                                    <div><small>* 사업과 무관한 내용이거나 불법적인 내용은 통보없이 삭제합니다.</small></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">개인정보 수집 및 이용동의</label>
                                <textarea rows="5" class="form-control" readonly>동의내용</textarea>
                            </div>
                            <div class="form-check text-right">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox"
                                           name="agree" value="Y"> 서비스 약관 동의
                                    <span class="form-check-sign"><em class="check"></em></span>
                                </label>
                            </div>

                            <button class="btn btn-sm btn-black">보내기</button>
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
        const contact = function ($$) {
            let form = $$('form[name=contactForm]');

            form.submit(function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "/contact/save",
                    dataType: "JSON",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (res) {
                        if (res.result === 'OK') {
                            window.location.href = '/contact/done';
                        }
                    }
                })
            });
        }(jQuery)
    </script>
@stop
