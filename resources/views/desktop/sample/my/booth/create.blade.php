@extends('desktop.layouts.none')
@section('body-class', 'raised')
@section('css')
@endsection
@section('body')
    <div class="content-wrap" style="min-height:100vh;">
        <div class="page-header-wrap">
            <div class="page-header header-filter header-s" data-parallax="false" style="background-image: url('/assets/img/page-header/the-office-of-the-3814956_1280.jpg');background-position: bottom center;">
                <div class="container">
                    <div class="row">
                        <div class="col-12 ml-auto mr-auto text-center">
                            <h2 class="title mb-0">박람회 참여하기</h2>
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
        <div class="main main-raised raised-s pb-3">
            <div class="section p-0 pt-3">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-10">
                            <div class="row ">
                                <div class="col-3">
                                    <ul class="nav nav-pills nav-pills-black flex-column">
                                        <li class="nav-item"><a class="nav-link active" href="#tab1" data-toggle="tab">부스 개설하기</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#tab2" data-toggle="tab">박람회 검색</a></li>
                                        <li class="nav-item disabled"><a class="nav-link disabled" href="#tab3" data-toggle="tab">완료</a></li>
                                    </ul>
                                </div>
                                <div class="col-9">
                                    <div class="tab-content booth-create-tab">
                                        <div class="tab-pane active show" id="tab1">
                                            <form>
                                                @csrf
                                                <h5 class="form-title">
                                                    부스 기본정보
                                                    <button class="btn btn-sm float-right">adsf</button>
                                                </h5>
                                                <div class="form-group">
                                                    <label>부스명</label>
                                                    <input type="text" name="booth_name" class="form-control" placeholder="부스 이름을 입력하세요.(최대 10글자)" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>부스소개</label>
                                                    <textarea class="form-control" rows="5" placeholder="부스 소개를 작성하세요(최대 1,000자)"></textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group pt-0">
                                                            <input type="text" name="tags[]" class="form-control" placeholder="검색 키워드 1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group pt-0">
                                                            <input type="text" name="tags[]" class="form-control" placeholder="검색 키워드 2" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group pt-0">
                                                            <input type="text" name="tags[]" class="form-control" placeholder="검색 키워드 3" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <h5 class="form-title">부스 사진</h5>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group form-file-upload form-file-multiple">
                                                            <input type="file" name="booth_pc_image" class="inputFileHidden" accept="image/x-png,image/gif,image/jpeg" onChange="cardimgchange(this)">
                                                            <label for="bcard_front" class="bmd-label-static">PC용 사진</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control inputFileVisible front-text" placeholder="이미지 업로드" readonly value="">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text p-0">
                                                                        <button type="button" class="btn btn-sm btn-fab btn-black btn-block m-0">
                                                                            <i class="material-icons">image</i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="input-group-text p-0 delete_booth_pc_image">
                                                                        <button type="button" class="btn btn-sm btn-fab btn-danger btn-block m-0" onclick="">
                                                                            <i class="material-icons">cancel</i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="fileinput-new thumbnail text-center">
                                                            <div class="image-empty">
                                                                <div class="info">
                                                                    <div class="icon icon-primary">
                                                                        <i class="material-icons">cancel_presentation</i>
                                                                    </div>
                                                                    <h4 class="info-title">이미지가 없습니다.</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group form-file-upload form-file-multiple">
                                                            <input type="file" name="booth_pc_image" class="inputFileHidden" accept="image/x-png,image/gif,image/jpeg" onChange="cardimgchange(this)">
                                                            <label for="bcard_front" class="bmd-label-static">모바일용 사진</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control inputFileVisible front-text" placeholder="이미지 업로드" readonly value="">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text p-0">
                                                                        <button type="button" class="btn btn-sm btn-fab btn-black btn-block m-0">
                                                                            <i class="material-icons">image</i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="input-group-text p-0 delete_booth_pc_image">
                                                                        <button type="button" class="btn btn-sm btn-fab btn-danger btn-block m-0" onclick="">
                                                                            <i class="material-icons">cancel</i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="fileinput-new thumbnail text-center">
                                                            <img src="/assets/img/logo/bg-logo-transparency.png" class="img img-fluid rounded">
                                                        </div>

                                                    </div>
                                                </div>
                                                <h5 class="form-title">
                                                    부스 영상
                                                    <button class="btn btn-black btn-sm btn-link btn-round">
                                                        <i class="material-icons">help_outline</i>
                                                    </button>
                                                </h5>
                                                <div class="form-group">
                                                    <label>YouTube URL</label>
                                                    <input type="text" name="youtube_url" class="form-control" placeholder="URL">
                                                </div>
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-sm btn-info">다음 단계</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="tab2">
                                            Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas.
                                            <br><br>Dramatically maintain clicks-and-mortar solutions without functional solutions.
                                        </div>
                                        <div class="tab-pane" id="tab3">
                                            Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.
                                            <br><br>Dynamically innovate resource-leveling customer service for state of the art customer service.
                                        </div>
                                    </div>
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
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="/assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>
@endsection
