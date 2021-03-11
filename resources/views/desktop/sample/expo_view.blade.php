@extends('desktop.layouts.none')
@section('body-class', 'raised expo-page')
@section('body')
    <div class="content-wrap">
{{--        <div class="alert alert-danger m-0" role="alert">--}}
{{--            <span><strong>[박람회 공지사항]</strong> 이벤트 진행중</span>--}}
{{--            <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--                <span aria-hidden="true">&times;</span>--}}
{{--            </button>--}}
{{--        </div>--}}
        <div class="page-header-wrap">
            <div class="page-header header-filter header-m" data-parallax="false" style="background-image: url('/assets/img/samples/poster/poster_2.jpeg');">
                <div class="container">
                    <div class="expo-header d-flex align-content-flex-start justify-content-between">
                        <div>
                            <button class="btn btn-sm btn-black btn-fab btn-round" data-toggle="tooltip" titie="즐겨찾기">
                                <i class="material-icons">star</i>
                            </button>
                            <button class="btn btn-sm btn-black btn-fab btn-round" data-toggle="tooltip" titie="공유">
                                <i class="material-icons">share</i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 ml-auto mr-auto text-center">
                            <h2 class="title mb-0">박람회 이름</h2>
                            <div class="info p-2">
                                <p class="m-0">전시장명</p>
                                <p class="m-0">0000. 00. 00 ~ 0000. 00. 00</p>
                            </div>
                            <div class="info p-2">
                                <div class="row justify-content-between">
                                    <div class="col-6">참가업체 1</div>
                                    <div class="col-6">방문자 12,234</div>
                                </div>
                                <p class="mt-4 mb-0">
                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal">온라인 부스 만들기</button>
                                </p>
                            </div>
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
            <div class="section p-0 pt-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <ul class="nav nav-pills nav-pills-black p-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#link1" role="tablist" aria-expanded="true">
                                    소개
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#link2" role="tablist" aria-expanded="false">
                                    부스
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content tab-space">
                <div class="tab-pane" id="link1" aria-expanded="true">
                    <p>통이미지</p>
                    <img src="https://via.placeholder.com/1280x300.png" class="img-fluid">
                </div>
                <div class="tab-pane active" id="link2" aria-expanded="true">
                    <div class="container">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="min-height:300px;">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
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
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <div class="row">
                            @for ($i = 0; $i < 20; $i++)
                                <div class="col-3">
                                    <div class="card" style="min-width:250px;max-width:250px;">
                                        <a href="#" role="button" data-toggle="modal" data-target="#boothModal" data-booth-id="{{ $i }}">
                                            <img class="card-img-top" src="https://via.placeholder.com/250x362.png" style="width:250px;height:362px;">
                                        </a>
                                        <div style="position: absolute;top: 0;width: 100%;height: auto;">
                                            <div class="card-badge text-center">
                                                <span class="badge badge-real-black">#다섯글자자</span>
                                                <span class="badge badge-real-black">#다섯글자자</span>
                                                <span class="badge badge-real-black">#다섯글자자</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
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
    <div class="modal fade" id="boothModal" tabindex="-1" role="dialog" aria-labelledby="boothModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg booth-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <button class="btn btn-sm btn-black btn-fab btn-round" data-toggle="tooltip" titie="즐겨찾기">
                            <i class="material-icons">star</i>
                        </button>
                        <button class="btn btn-sm btn-black btn-fab btn-round" data-toggle="tooltip" titie="공유">
                            <i class="material-icons">share</i>
                        </button>
                    </div>
                    <button class="btn btn-sm btn-black btn-fab btn-round" data-dismiss="modal" aria-label="Close">
                        <i class="material-icons" aria-hidden="true">close</i>
                    </button>
                </div>
                <div class="page-header header-filter booth-header" data-parallax="false" style="background-image: url('/assets/img/samples/poster/poster_0.jpg');">
                    <div class="container">
                        <h2 class="title m-0">부스 이름</h2>
                    </div>
                    <div class="text-right" style="position:absolute;width: 100%;height:auto;right:0;bottom:10px;z-index:2;">
                        <p class="m-0 pr-3">
                            <a class="btn btn-sm btn-danger btn-live" href="/sample/booth/live" role="button">LIVE 보기</a>
                            <button class="btn btn-sm btn-black" data-toggle="modal" data-target="#exampleModal">명함교환</button>
                        </p>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row justify-content-center">
                        <ul class="nav nav-pills nav-pills-black booth-tabs p-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#booth-tab1" role="tab" aria-expanded="true">
                                    소개
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#booth-tab2" role="tab" aria-expanded="false">
                                    1:1 미팅신청
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content tab-space">
                        <div class="tab-pane show active" role="tabpanel" id="booth-tab1" aria-expanded="true">
                            <div class="info text-center">
                                <div class="icon">
                                    <button class="btn btn-black btn-lg btn-fab btn-round btn-disabled">
                                        <i class="material-icons">business</i>
                                    </button>
                                </div>
                                <h5 class="info-title mb-0">온라인 부스는 기업회원 전용 메뉴입니다.</h5>
                                <h5 class="info-title m-0">기업회원으로 신청하시겠습니까?</h5>
                            </div>
                            <div class="info text-center">
                                <div class="icon">
                                    <button class="btn btn-black btn-lg btn-fab btn-round btn-disabled">
                                        <i class="material-icons">business</i>
                                    </button>
                                </div>
                                <h5 class="info-title mb-0">온라인 부스는 기업회원 전용 메뉴입니다.</h5>
                                <h5 class="info-title m-0">기업회원으로 신청하시겠습니까?</h5>
                            </div>
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
                        <div class="tab-pane" role="tabpanel" id="booth-tab2" aria-expanded="true">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-black">전환신청하기</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">닫기</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="liveModal" tabindex="-1" role="dialog" aria-labelledby="boothModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                LIVE
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        $(function () {
            $('#boothModal').on('show.bs.modal', function(event) {
                $('.booth-tabs li:first-child a').tab('show');
                var modal = this;
                var button = $(event.relatedTarget);
                var hash = modal.id;
                if (typeof event.relatedTarget !== 'undefined'){
                    var id = button.data('booth-id');
                    hash = id;
                    localStorage.setItem('showBooth', hash);
                    window.location.hash = hash;
                }
                // ajax
                window.onhashchange = function() {
                    if (!window.location.hash) {
                        localStorage.removeItem('showBooth');
                        $(modal).modal('hide');
                    }
                }
            });

            $('#boothModal').on('hide.bs.modal', function(e) {
                if (window.location.hash) {
                    window.history.back();
                }
                history.pushState("", document.title, window.location.pathname);
                localStorage.removeItem('showBooth');

            });
            if(window.location.hash){
                var modal = $('#boothModal');
                localStorage.setItem('showBooth', window.location.hash);
                modal.modal('show');
            }
            if (localStorage.getItem("showBooth") !== null) {
                window.location.hash = localStorage.getItem("showBooth");
                var modal = $('#boothModal');
                modal.modal('show');
            }
        });
    </script>
    <script>
    </script>
@endsection
