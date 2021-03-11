@extends('desktop.layouts.none')
@section('head-script')
    <script src="https://unpkg.com/splitting/dist/splitting.min.js"></script>
    <script src="https://unpkg.com/scroll-out/dist/scroll-out.min.js"></script>
@endsection
@section('body-class', 'raised')
@section('body')
    <div class="content-wrap">
        <div class="position-relative">
            <div class="page-header header-filter header-m" data-parallax="false" style="background-image: url('/assets/img/page-header/business-962359_1920.jpg'); transform: translate3d(0px, 0px, 0px);background-position: center bottom;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 ml-auto mr-auto text-center">
                            <h2 class="title">기업회원 전환안내</h2>
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
                <div class="section">
                    <h3 class="title text-center" data-scroll data-splitting>기업회원이 되면 다양한 서비스를 이용할 수 있습니다.</h3>
                    <div class="row">
                        <div class="col-4">
                            <div class="info text-center">
                                <div class="icon icon-primary">
                                    <i class="material-icons">chat</i>
                                </div>
                                <h4 class="info-title">기업회원 신청 방법을 알려드립니다.</h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="info text-center">
                                <div class="icon icon-primary">
                                    <i class="material-icons">chat</i>
                                </div>
                                <h4 class="info-title">기업회원 신청 방법을 알려드립니다.</h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="info text-center">
                                <div class="icon icon-primary">
                                    <i class="material-icons">chat</i>
                                </div>
                                <h4 class="info-title">기업회원 신청 방법을 알려드립니다.</h4>
                            </div>
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
@endsection
@section('page-script')
    <script>
        $(function(){
            const results = Splitting({
                target: '.section',
                by: 'grid',
                matching: '.col-4'
            });

            Splitting();
            ScrollOut({
                targets: '[data-splitting]',
            });
        })
    </script>
@endsection
