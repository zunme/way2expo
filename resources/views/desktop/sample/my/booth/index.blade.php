@extends('desktop.layouts.none')
@section('body-class', 'raised')
@section('body')
    <div class="content-wrap" style="min-height:100vh;">
        <div class="page-header-wrap">
            <div class="page-header header-filter header-xs" data-parallax="false" style="background-image: url('/assets/img/page-header/the-office-of-the-3814956_1280.jpg');background-position: bottom center;">
                <div class="container">
                    <div class="row">
                        <div class="col-12 ml-auto mr-auto text-center">
                            <h2 class="title mb-0">내가 만든 부스</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <div class="main main-raised raised-xs">
            <div class="section p-0 pt-3">
                <div class="container">
                    <div class="row justify-content-end text-right">
                        <div class="col-4">
                            <a role="button" href="{{route('my.booth.create')}}" class="btn btn-sm btn-danger">박람회 참여하기</a>
                        </div>
                    </div>
                    <div class="row justify-content-center text-center">
                        <div class="col-8">
                            <div class="info">
                                <div class="icon">
                                    <button class="btn btn-danger btn-lg btn-fab btn-round btn-disabled">
                                        <i class="material-icons">search_off</i>
                                    </button>
                                </div>
                                <h4 class="info-title">조회된 결과가 없습니다.</h4>
                                <a href="{{route('my.booth.create')}}" role="button" class="btn btn-sm btn-black">박람회 참여하기</a>
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
    </script>
@stop

