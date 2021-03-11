@extends('desktop.layouts.none')
@section('body-class', 'raised')
@section('body')
    <div class="content-wrap">
        <div class="page-header-wrap">
            <div class="page-header header-filter header-m" data-parallax="false" style="background-image: url('/assets/img/page-header/blue-funnel-946886_1280.jpg'); transform: translate3d(0px, 0px, 0px);">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 ml-auto mr-auto text-center">
                            <h2 class="title">박람회</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <div class="main main-raised raised-m">
            <div class="container">
                <div class="section p-0 pb-3 pt-4">
                    <div id="expo-ad-banner" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#expo-ad-banner" data-slide-to="0" class="active"></li>
                            <li data-target="#expo-ad-banner" data-slide-to="1"></li>
                            <li data-target="#expo-ad-banner" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="https://via.placeholder.com/720x200.png?text=Promotion+Banner" alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="https://via.placeholder.com/720x200.png?text=Promotion+Banner" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="https://via.placeholder.com/720x200.png?text=Promotion+Banner" alt="Third slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#expo-ad-banner" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#expo-ad-banner" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-6 text-left">
                        <ul class="nav nav-pills nav-pills-black p-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#link1" role="tablist" aria-expanded="true">
                                    전체 00 건
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#link2" role="tablist" aria-expanded="false">
                                    진행중 00 건
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#link3" role="tablist" aria-expanded="false">
                                    예정 00 건
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#link4" role="tablist" aria-expanded="false">
                                    모집중 00 건
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#link5" role="tablist" aria-expanded="false">
                                    종료 00 건
                                </a>
                            </li>
                        </ul>

                    </div>
                    <div class="col-6 text-right">
                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal">온라인 부스 만들기</button>
                    </div>
                </div>
                <div class="tab-content tab-space pt-0">
                    <div class="tab-pane active" id="link1" aria-expanded="true">
                        <div class="row">
                            <div class="col-3">
                                <a href="/sample/expo/view" role=button>
                                    <div class="card" style="min-width:250px;max-width:250px;">
                                        <img class="card-img-top" src="/assets/img/samples/poster/poster_0.jpg" style="width:250px;height:362px;">
                                        <div class="card-badge text-center">
                                            <span class="badge badge-black">#다섯글자자</span>
                                            <span class="badge badge-black">#다섯글자자</span>
                                            <span class="badge badge-black">#다섯글자자</span>
                                        </div>
                                        <div class="card-body p-2">
                                            <h4 class="card-title m-0">한국국제기계박람회</h4>
                                            <p class="card-text m-0">0000. 00. 00 ~ 0000.00.00</p>
                                            <p class="card-text m-0">온라인</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-3">
                                <a href="/sample/expo/view" role=button>
                                    <div class="card" style="min-width:250px;max-width:250px;">
                                        <img class="card-img-top" src="/assets/img/samples/poster/poster_0.jpg" style="width:250px;height:362px;">
                                        <div class="card-badge text-center">
                                            <span class="badge badge-black">#다섯글자자</span>
                                            <span class="badge badge-black">#다섯글자자</span>
                                            <span class="badge badge-black">#다섯글자자</span>
                                        </div>
                                        <div class="card-body p-2">
                                            <h4 class="card-title m-0">한국국제기계박람회</h4>
                                            <p class="card-text m-0">0000. 00. 00 ~ 0000.00.00</p>
                                            <p class="card-text m-0">온라인</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="link2" aria-expanded="false">
                        <div class="row">
                            <div class="col m-auto text-center">
                                <div class="info">
                                    <div class="icon">
                                        <button class="btn btn-danger btn-lg btn-fab btn-round btn-disabled">
                                            <i class="material-icons">search_off</i>
                                        </button>
                                    </div>
                                    <h4 class="info-title">조회된 결과가 없습니다.</h4>
                                    <button class="btn btn-sm btn-black">전체 박람회 보기</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="link3" aria-expanded="false">
                        <div class="row">
                            <div class="col-3">
                                <a href="/sample/expo/view" role="button">
                                    <div class="card" style="min-width:250px;max-width:250px;">
                                        <img class="card-img-top" src="/assets/img/samples/poster/poster_0.jpg" style="width:250px;height:362px;">
                                        <div class="card-badge text-center">
                                            <span class="badge badge-black">#다섯글자자</span>
                                            <span class="badge badge-black">#다섯글자자</span>
                                            <span class="badge badge-black">#다섯글자자</span>
                                        </div>
                                        <div class="card-body p-2">
                                            <h4 class="card-title m-0">한국국제기계박람회</h4>
                                            <p class="card-text m-0">0000. 00. 00 ~ 0000.00.00</p>
                                            <p class="card-text m-0">온라인</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-3">
                                <div class="card" style="min-width:250px;max-width:250px;">
                                    <img class="card-img-top" src="/assets/img/samples/poster/poster_1.jpg" style="width:250px;height:362px;">
                                    <div class="card-badge text-center">
                                        <span class="badge badge-black">#다섯글자자</span>
                                        <span class="badge badge-black">#다섯글자자</span>
                                        <span class="badge badge-black">#다섯글자자</span>
                                    </div>
                                    <div class="card-body p-2">
                                        <h4 class="card-title m-0">한국국제기계박람회</h4>
                                        <p class="card-text m-0">0000. 00. 00 ~ 0000.00.00</p>
                                        <p class="card-text m-0">온라인</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="link4" aria-expanded="false">
                        <div class="row">
                            <div class="col-3">
                                <a href="/sample/expo/view" role="button">
                                    <div class="card" style="min-width:250px;max-width:250px;">
                                        <img class="card-img-top" src="/assets/img/samples/poster/poster_0.jpg" style="width:250px;height:362px;">
                                        <div class="card-badge text-center">
                                            <span class="badge badge-black">#다섯글자자</span>
                                            <span class="badge badge-black">#다섯글자자</span>
                                            <span class="badge badge-black">#다섯글자자</span>
                                        </div>
                                        <div class="card-body p-2">
                                            <h4 class="card-title m-0">한국국제기계박람회</h4>
                                            <p class="card-text m-0">0000. 00. 00 ~ 0000.00.00</p>
                                            <p class="card-text m-0">온라인</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-3">
                                <div class="card" style="min-width:250px;max-width:250px;">
                                    <img class="card-img-top" src="/assets/img/samples/poster/poster_1.jpg" style="width:250px;height:362px;">
                                    <div class="card-badge text-center">
                                        <span class="badge badge-black">#다섯글자자</span>
                                        <span class="badge badge-black">#다섯글자자</span>
                                        <span class="badge badge-black">#다섯글자자</span>
                                    </div>
                                    <div class="card-body p-2">
                                        <h4 class="card-title m-0">한국국제기계박람회</h4>
                                        <p class="card-text m-0">0000. 00. 00 ~ 0000.00.00</p>
                                        <p class="card-text m-0">온라인</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="link5" aria-expanded="false">
                        <div class="row">
                            <div class="col">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="section">

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="title modal-title m-0" id="exampleModalLabel">기업회원 전환 안내</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="info text-center">
                        <div class="icon">
                            <button class="btn btn-black btn-lg btn-fab btn-round btn-disabled">
                                <i class="material-icons">business</i>
                            </button>
                        </div>
                        <h5 class="info-title mb-0">온라인 부스는 기업회원 전용 메뉴입니다.</h5>
                        <h5 class="info-title m-0">기업회원으로 신청하시겠습니까?</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-black">전환신청하기</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">닫기</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        $(function(){
        })
    </script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="/assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
@endsection
