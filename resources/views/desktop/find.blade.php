@extends('desktop.layouts.none')
@section('css')
    <style>
        .form-check {
            margin-left: 3px;
        }
    </style>
@endsection
@section('body-class', '')
@section('header','')
@section('body')
    <div class="main">
        <div class="section">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 text-center">
                        <div class="logo-img">
                            <img src="/assets/img/logo/bg-logo-transparency.png" width="300" alt="">
                        </div>
                        <h4 class="title mt-0">성공적인 비즈니스의 첫걸음 Way2EXPO</h4>
                    </div>
                    <div class="col-5">
                        <ul class="nav nav-pills nav-pills-black p-0 justify-content-center"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#link1" role="tablist"
                                   aria-expanded="true" style="padding:5px 50px">
                                    아이디 찾기
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#link2" role="tablist"
                                   aria-expanded="false" style="padding:5px 50px">
                                    비밀번호 찾기
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content tab-space pt-4">
                            <div class="tab-pane active" id="link1" aria-expanded="true">
                                <div class="container text-center">
                                    <p class="text">아이디 찾기를 위해 본인인증을 진행해주세요.</p>
                                    <button type="button" class="btn btn-sm btn-black">본인인증</button>
                                    <p class="text">본인인증 시 제공되는 정보는 해당 인증기관에서 직접 수집하며, 인증 이외의 용도로 이용 또는 저장되지 않습니다.</p>
                                </div>
                            </div>
                            <div class="tab-pane" id="link2" aria-expanded="true">
                                <div class="container text-center">
                                    <p class="text">비밀번호 찾기를 위해 아이디 입력과 본인인증을 진행해주세요.</p>
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="E-mail을 입력해주세요.">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-black">본인인증</button>
                                    <p class="text">본인인증 시 제공되는 정보는 해당 인증기관에서 직접 수집하며, 인증 이외의 용도로 이용 또는 저장되지 않습니다.</p>
                                </div>
                            </div>
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
        });
    </script>
@stop
