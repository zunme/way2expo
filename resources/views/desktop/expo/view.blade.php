@extends('desktop.layouts.none')
@section('css')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
    <style>
        .slick-prev {
            left: 10px;
            z-index: 1;
        }

        .slick-next {
            right: 30px;
            z-index: 1;
        }

        .slick-prev:before, .slick-next:before {
            font-size: 40px;
        }

        .slick-frame {
            visibility: hidden;
        }

        .slick-frame.slick-initialized {
            visibility: visible;
        }

        .slider-nav .slick-current {
            outline: -webkit-focus-ring-color auto 1px;
        }
    </style>
    <style>

        .sticky {
            position: fixed;
            top: 0;
            width: 100%;
        }

        .booth-sticky-top {
            display: none;
            position: fixed;
            width: 100%;
            text-align: center;
            vertical-align: top;
            z-index: 1;
        }

        .booth-sticky-top .booth-sticky-content {
            min-width: 550px;
            width: 900px;
            max-width: 1190px !important;
            text-align: center;
            vertical-align: top;
            margin: 0 auto 1.75rem auto;
            position: relative;
            left: -21px;
            background-color: #fff;
        }

        .booth-toolbar {
            display: none;
            position: fixed;
            width: 100%;
            text-align: center;
            vertical-align: top;
            z-index: 1;
        }

        .booth-toolbar .booth-toolbar-content {
            min-width: 550px;
            width: 900px;
            max-width: 1190px !important;
            text-align: center;
            vertical-align: top;
            margin: 0 auto 1.75rem auto;
            position: relative;
            left: -18px;
            background-color: #fff;
        }

        .bootstrap-datetimepicker-widget .today > div {
            background-color: #eeeeee;
        }

        .bootstrap-datetimepicker-widget table td.day > div {
            z-index: 1;
        }

        .bootstrap-datetimepicker-widget table td.active:hover > div, .bootstrap-datetimepicker-widget table td.active > div {
            background-color: #f44336;
        }

        .bootstrap-datetimepicker-widget .datepicker-days thead .picker-switch {
            cursor: default;
            pointer-events: none;
        }

        .booth-title-expo {
            font-size: 16px;
        }

        .btn-social img {
            vertical-align: top;
        }

        .pagination li a {
            text-decoration: none;
        }

        .paginationjs-page > a, .paginationjs-prev > a, .paginationjs-next > a {
            border: 0;
            border-radius: 30px !important;
            transition: all .3s;
            padding: 0 11px;
            margin: 0 3px;
            min-width: 30px;
            height: 30px;
            line-height: 30px;
            color: #999;
            font-weight: 400;
            font-size: 12px;
            text-transform: uppercase;
            background: 0 0;
            text-align: center;
        }

        .paginationjs-page > a:not(:disabled):not(.disabled), .paginationjs-prev > a, .paginationjs-next > a {
            cursor: pointer;
        }

        .paginationjs-page > a, .paginationjs-prev > a, .paginationjs-next > a {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: 0;
            line-height: 1.25;
            background-color: transparent;
            border: 0 solid #dee2e6;
        }

        .paginationjs-page.active > a, .paginationjs-page.active > a:focus, .paginationjs-page.active > a:hover, .paginationjs-page.active > span, .paginationjs-page.active > span:focus, .paginationjs-page.active > span:hover {
            background-color: #682679;
            border-color: #682679;
            color: #fff;
            box-shadow: 0 4px 5px 0 rgba(104, 38, 121, .14), 0 1px 10px 0 rgba(104, 38, 121, .12), 0 2px 4px -1px rgba(104, 38, 121, .2);
        }

        .loader,
        .loader:before,
        .loader:after {
            border-radius: 50%;
            width: 2.5em;
            height: 2.5em;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
            -webkit-animation: load7 1.8s infinite ease-in-out;
            animation: load7 1.8s infinite ease-in-out;
        }

        .loader {
            color: #3c4858;
            font-size: 10px;
            margin: 80px auto;
            position: relative;
            text-indent: -9999em;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
            -webkit-animation-delay: -0.16s;
            animation-delay: -0.16s;
        }

        .loader:before,
        .loader:after {
            content: '';
            position: absolute;
            top: 0;
        }

        .loader:before {
            left: -3.5em;
            -webkit-animation-delay: -0.32s;
            animation-delay: -0.32s;
        }

        .loader:after {
            left: 3.5em;
        }

        @-webkit-keyframes load7 {
            0%,
            80%,
            100% {
                box-shadow: 0 2.5em 0 -1.3em;
            }
            40% {
                box-shadow: 0 2.5em 0 0;
            }
        }

        @keyframes load7 {
            0%,
            80%,
            100% {
                box-shadow: 0 2.5em 0 -1.3em;
            }
            40% {
                box-shadow: 0 2.5em 0 0;
            }
        }

    </style>
@endsection
@section('body-class', 'expo-page raised')
@section('body')
@section('header-class','header-filter header-s')
@section('header-bg',$expo->getImageUrl())
@section('header-bg-attachment','fixed')
@section('header-bg-position','0 center')
@section('header-parallax','false')
@section('header-content')
    <div class="container" style="top:0px">
        <div class="row">
            <div class="col-12 ml-auto mr-auto text-center">
                <h2 class="title mb-5">
                    <button class="btn btn-sm btn-black btn-fab btn-round btn-favorite" data-id="{{$expo->id}}"
                            data-favorite="expo" data-toggle="tooltip" titie="즐겨찾기">
                        <i class="material-icons {{($expoFavorite)?'text-warning':''}}">star</i>
                    </button>
                    {{ $expo->expo_name }}
                    <button class="btn btn-sm btn-black btn-fab btn-round" data-toggle="modal" data-target="#snsModal">
                        <i class="material-icons">share</i>
                    </button>

                </h2>
            </div>
        </div>
    </div>
@endsection
<div class="main main-raised raised-s">
    <div class="container">
        <div class="section p-0 pt-4">
            <div class="row justify-content-center">
                <ul class="nav nav-pills nav-pills-black p-0" id="tab-expo" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link nav-intro active" data-toggle="tab" href="#intro" role="tablist"
                           aria-expanded="true">
                            박람회 소개
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-booth" data-toggle="tab" href="#booth" role="tablist"
                           aria-expanded="true">
                            부스
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-product" data-toggle="tab" href="#product" role="tablist"
                           aria-expanded="true">
                            전시상품
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-guide" data-toggle="tab" href="#guide" role="tablist"
                           aria-expanded="true">
                            출품안내
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content tab-space pt-4">
                <div class="loader d-none">Loading...</div>
                <div class="tab-pane active" id="intro" aria-expanded="true">
                    <div class="tab-pane-body"></div>
                </div>
                <div class="tab-pane" id="booth" aria-expanded="true">
                    <div class="tab-pane-slider"></div>
                    <div id="booth-search" class="d-flex justify-content-end">
                        <label>
                            <input type="search"
                                   class="form-control form-control-sm"
                                   placeholder="검색어를 입력하세요.">
                        </label>
                    </div>
                    <button class="btn btn-sm btn-black d-none" id="btn-refresh">랜덤</button>
                    <div class="tab-pane-body"></div>
                </div>
                <div class="tab-pane" id="product" aria-expanded="true">
                    <div class="tab-pane-slider"></div>
                    <div id="product-search" class="d-flex justify-content-end">
                        <label>
                            <input type="search"
                                   class="form-control form-control-sm"
                                   placeholder="검색어를 입력하세요.">
                        </label>
                    </div>
                    <div class="tab-pane-body"></div>
                </div>
                <div class="tab-pane" id="guide" aria-expanded="true">
                    <div class="row">
                        <div class="col-12">
                            <a href="/entry?id={{$expo->id}}" class="btn btn-sm btn-black">출품 안내</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-after')
    @include('desktop.expo.template')
@endsection
@section('page-script')
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="/assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <script src="/assets/js/plugins/ko.js" type="text/javascript"></script>
    <!-- remon -->
    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@remotemonster/sdk"></script>
    <script src="/assets/js/plugins/pagination.min.js" type="text/javascript"></script>

    <script>
        const expoDetail = (function ($$) {
                const initData = {
                    user: @json($user),
                    expo: @json($expo),
                    booth: null,
                    product: null,
                    expoMeta: @json($meta),
                    banners: @json($banners),
                    favorites: @json($favorites),
                    historyState: {
                        popid: 0,
                        tabid: 'intro',
                        boothtabid: 'intro',
                        expo_code: null,
                        expoid: null,
                        booth: {{(empty($booth_id))?'null':$booth_id}},
                        productid: null,
                        expopbooth: ''
                    },
                    selectedTab: null,
                    search: {
                        type: null,
                        id: null,
                        str: null,
                    },
                    meta: {
                        kakaoMeta: {
                            objectType: 'feed',
                            content: {
                                title: '{{urlencode($meta->title)}}',
                                description: '{{urlencode($meta->description)}}',
                                imageUrl:
                                    '{{$meta->image}}',
                                link: {
                                    mobileWebUrl: window.location.href,
                                    webUrl: window.location.href,
                                },
                            },
                        },
                        fbMeta: {
                            method: 'share',
                            href: window.location.href,
                        }
                    },
                    rmConfig: {
                        onCheck: true,
                        credential: {
                            serviceId: '{{ config('remotemonster.serviceId') }}',
                            key: '{{ config('remotemonster.key') }}'
                        },
                        view: {
                            local: '#localVideo'
                        }
                    },
                }
                let defaultPageOptions = {
                    className: "page-item",
                    ulClassName: "pagination justify-content-center m-4",
                    showPrevious: true,
                    showNext: true,
                    showPageNumbers: true,
                    showNavigator: false,
                    prevText: '이전',
                    nextText: '다음',
                    hideWhenLessThanOnePage: true,
                };
                let searchLoop;
                let remon;
                let myexpoDB = new PouchDB('expolist');
                let myBootmDB = new PouchDB('boothlist');

                // elements
                const expoTab = $$('#tab-expo');
                let paneId = 'intro'
                let pane = $$('.tab-content').find('#' + paneId);

                let templateContainer = pane.find('.tab-pane-body');
                let templateId = $$("#template-expo-" + paneId);

                let selectedTab = expoTab.find('.nav-' + paneId);
                let previousPane,
                    previousPaneId,
                    paginationContainer;

                let boothModal = $$('#modal-booth');
                let productModal = $$('#modal-product');

                let isBoothOpened = false;
                let isDirectOpened = false;
                let isShowSlider = false;

                function showTab(id) {
                    selectedTab = expoTab.find('.nav-' + id);
                    selectedTab.tab('show');
                }

                function addListeners() {
                    tabListener(true);
                    stateListener(true);
                    snsModalListener(true);

                }

                function tabListener(isOn) {
                    if (isOn) {
                        expoTab.on('show.bs.tab', function (e) {
                            searchLiveLoop(false);
                            previousPaneId = $$(e.relatedTarget).attr('href').replace('#', '');
                            previousPane = $$('.tab-content').find('#' + previousPaneId);
                            paneId = $$(e.target).attr('href').replace('#', '');
                            pane = $$('.tab-content').find('#' + paneId);
                            templateContainer = pane.find('.tab-pane-body');
                            templateId = $$("#template-expo-" + paneId);
                            selectedTab = $$(this).find('.nav-' + paneId);
                            if (initData.historyState.tabid !== paneId) {
                                initData.historyState.tabid = paneId;
                                window.history.pushState(
                                    initData.historyState,
                                    null,
                                    null,
                                );
                            }

                            // intro
                            if (paneId === 'intro') {
                                introContainer();
                            }
                            // booth
                            if (paneId === 'booth') {
                                boothContainer();
                            }
                            // product
                            if (paneId === 'product') {
                                productContainer();
                            }

                            if (previousPaneId === 'booth') {
                                clearInterval(searchLoop);
                            }
                            if (previousPaneId === 'product') {
                            }

                            if (typeof previousPane !== 'undefined' && previousPane.find('.tab-pane-slider').hasClass('slick-initialized')) {
                                // previousPane.find('.tab-pane-slider').slick('unslick');
                                // previousPane.find('.tab-pane-slider').unbind('init destroy');
                            }
                        });
                    } else {
                        expoTab.unbind('show.bs.tab');
                    }
                }

                function stateListener(isOn) {
                    if (isOn) {
                        window.onpopstate = function (event) {
                            if (event.state) {
                                expoTab.find('.nav-' + event.state.tabid).tab('show');
                                initData.historyState = event.state;
                            }
                            initData.historyState.popid = 0;
                            //
                            window.history.replaceState(
                                initData.historyState,
                                null,
                                "/expo/" + initData.expo.expo_code)
                            if (isBoothOpened) boothModal.modal('hide');
                        };
                    } else {
                        window.onpopstate = null;
                    }
                }

                function snsModalListener(isOn) {
                    let fbScript = document.createElement("script");
                    let snsModal = $$("#snsModal");
                    let clipboard = $$('.clipboard');
                    let kakaoBtn = $$('#kakao-share-btn');
                    let fbBtn = $$('#fb-share-btn');
                    let naverBtn = $$('#blog-share-btn');

                    if (isOn) {
                        snsModal.on('show.bs.modal', function () {
                            fbScript.setAttribute("src", "https://connect.facebook.net/en_US/sdk.js");
                            document.body.appendChild(fbScript);
                            window.fbAsyncInit = function () {
                                FB.init({
                                    appId: '760394214816719',
                                    autoLogAppEvents: true,
                                    xfbml: true,
                                    version: 'v9.0'
                                });
                            };
                        });
                        snsModal.on('hide.bs.modal', function () {
                            window.fbAsyncInit = null;
                            document.body.removeChild(fbScript);
                            $$('#fb-root').remove();
                            clipboard.find('button').unbind('click');
                            kakaoBtn.unbind();
                            fbBtn.unbind();
                            naverBtn.unbind();
                        });
                        snsModal.on('shown.bs.modal', function () {
                            clipboard.find('input').val(window.location.href);
                            clipboard.find('input').select();
                            clipboard.find('button').on('click', function () {
                                clipboard.find('input').val();
                                document.execCommand("copy");
                                confirmPopup('복사되었습니다.', 'success')
                                clipboard.find('input').select();
                            });
                            kakaoBtn.on('click', function () {
                                Kakao.Link.sendDefault(initData.meta.kakaoMeta)
                            });
                            fbBtn.on('click', function () {
                                FB.ui(initData.meta.fbMeta, function (response) {
                                });
                            })
                            naverBtn.on('click', function () {
                                window.open('https://share.naver.com/web/shareView.nhn?url=' + window.location.href + '&title=' + initData.meta.kakaoMeta.content.title, '네이버팝업', 'width=750px,height=600px,scrollbars=no');
                            })

                        });
                    }
                }

                function adBannerSlider(type) {
                    const template = $$('#template-ad-banner');
                    const templateContainer = pane.find('.tab-pane-slider');
                    const options = {
                        autoplay: true,
                        autoplaySpeed: 3000,
                        dots: false,
                        touchMove: false,
                        infinite: true,
                        adaptiveHeight: false
                    };
                    if (type === null) return;
                    let bannerSlide = (typeof initData.banners[type] !== 'undefined') ? initData.banners[type] : [];
                    if (bannerSlide.length < 1) return;
                    compile(template, templateContainer, {data: bannerSlide});

                    pane.find('.tab-pane-slider').on('init', function (event, slick) {
                        isShowSlider = true;
                    });
                    pane.find('.tab-pane-slider').on('destroy', function (event, slick) {
                        isShowSlider = false;
                    });

                    templateContainer.slick(options);

                }

                function openBooth(boothId) {
                    let data;
                    let url = '/expo-meta/' + initData.expo.expo_code + '/' + boothId;
                    let templateDetail = Handlebars.compile($$("#template-expo-booth-detail").html());
                    // elements
                    let boothTab, paneId, pane, templateContainer, templateId, selectedTab, boothTabPreviousPane,
                        boothTabPreviousPaneId,
                        paginationContainer;

                    $$.getJSON(url).done(function (res) {
                        data = res;
                        initData.booth = data.booth;
                        setState();
                        setSNS();
                        setDB();
                        showModal();
                        isBoothOpened = true;
                    }).fail(function (xqr) {
                        if (initData.booth === null) {
                            initData.historyState.popid = 0;
                            window.history.replaceState(
                                initData.historyState,
                                null,
                                "/expo/" + initData.expo.expo_code);
                            isDirectOpened = false;
                            isBoothOpened = false;
                        }

                    });

                    function showModal() {
                        boothModal.find('.modal-lg').addClass('booth-dialog');
                        boothModal.html(templateDetail(data));
                        modalListener();
                        boothTabListener();
                        toggleFavoriteBtn();
                        boothModal.modal('handleUpdate')
                        boothModal.modal('show');
                        if (isLogined && (initData.user.company_id === data.booth.company_id)) {
                            boothTab.find('.nav-booth-meeting').addClass('d-none');
                            boothTab.find('.nav-booth-contact').addClass('d-none');
                            $$('<a>', {
                                href: '/my/booth/detail/' + initData.booth.id,
                                class: 'btn btn-sm btn-warning',
                                text: '내 부스 관리',
                                appendTo: boothTab.parent(),
                            })
                        }

                    }

                    function modalListener() {
                        boothModal.on('show.bs.modal', function () {
                            searchLiveLoop(true);
                            let modalBody = $$('#modal-booth').find('.page-header .container .title');
                            $$(this).scroll(function () {
                                if (modalBody.offset().top < 0) {
                                    $$('.booth-sticky-top').fadeIn(200);
                                } else {
                                    $$('.booth-sticky-top').fadeOut(100);

                                }
                            });
                            if (initData.search.type === 'product' || initData.product !== null) {
                                boothTab.find('.nav-booth-product').tab('show');
                            }
                            if (initData.selectedTab != null && initData.selectedTab === 'contact') {
                                boothTab.find('.nav-booth-contact').tab('show');
                            }
                        });
                        boothModal.on('hide.bs.modal', function (e) {
                            $(this).find('.modal-lg').removeClass('booth-dialog');
                            initData.historyState.popid = 0;
                            //
                            window.history.replaceState(
                                initData.historyState,
                                null,
                                "/expo/" + initData.expo.expo_code);
                            isDirectOpened = false;
                            isBoothOpened = false;
                        });
                        boothModal.on('hidden.bs.modal', function (e) {
                            initData.meta.kakaoMeta.content.title = initData.expoMeta.title;
                            initData.meta.kakaoMeta.content.description = initData.expoMeta.description;
                            initData.meta.kakaoMeta.content.imageUrl = initData.expoMeta.image;

                            initData.booth = null;
                            initData.product = null;
                            initData.search.type = null;
                            initData.search.id = null;
                            boothTab.unbind();
                            $(e.currentTarget).unbind();

                        });
                        boothModal.on('shown.bs.modal', function () {
                            if (initData.booth.booth_movtype === 'youtube' && initData.booth.booth_youtube_url !== null) {
                                setTimeout(function(){
                                    previewYoutube();
                                },300)
                            }
                        })
                    }

                    function boothTabListener() {
                        boothTab = $$('#tab-booth');
                        paneId = 'intro';
                        boothTab.on('show.bs.tab', function (e) {
                            boothTabPreviousPaneId = $$(e.relatedTarget).attr('href').replace('#booth-', '');
                            boothTabPreviousPane = $$('.booth-dialog').find('.tab-content').find('#booth-' + boothTabPreviousPaneId);
                            paneId = $$(e.target).attr('href').replace('#booth-', '');
                            pane = $$('.booth-dialog').find('.tab-content').find('#booth-' + paneId);
                            templateContainer = pane.find('.tab-pane-body');
                            templateId = $$("#template-expo-" + paneId);
                            selectedTab = $$(this).find('.nav-' + paneId);
                            // product
                            if (paneId === 'product') {
                                boothProductContainer();
                            }
                            // contact
                            if (paneId === 'contact') {
                                if (isLogined === false) {
                                    Swal2.fire({
                                        icon: 'error',
                                        position: 'center',
                                        text: '로그인 후 이용해주세요.',
                                        showConfirmButton: true,
                                        showCancelButton: true,
                                        confirmButtonText: "로그인",
                                        customClass: {
                                            confirmButton: 'btn btn-sm btn-black',
                                            cancelButton: 'btn btn-sm',
                                        },
                                    }).then(function (value) {
                                        if (value.isConfirmed) {
                                            window.location.href = '/login';
                                        }
                                        boothTab.find('.nav-booth-' + boothTabPreviousPaneId).tab('show');
                                    });
                                    e.preventDefault();
                                    return;
                                }
                                boothContactContainer();
                            }

                        });
                    }

                    function setSNS() {
                        initData.meta.kakaoMeta.content.title = initData.booth.booth_title;
                        initData.meta.kakaoMeta.content.description = initData.booth.booth_intro;
                        initData.meta.kakaoMeta.content.imageUrl = '/storage/' + initData.booth.booth_mobile_image_url;
                    }

                    function setDB() {
                        let boothdoc = {
                            "_id": '' + initData.booth.id,
                            "expo_code": initData.expo.expo_code,
                            "expo_name": initData.expo.expo_name,
                            "booth_title": initData.booth.booth_title,
                            "img": '/storage/' + initData.booth.booth_mobile_image_url,
                            "date": new Date()
                        }
                        myBootmDB.get('' + initData.booth.id).then(function (doc) {
                            myBootmDB.remove(doc)
                            myBootmDB.put(boothdoc);
                        }).catch(function (err) {
                            myBootmDB.put(boothdoc)
                        });
                        myBootmDB.allDocs({
                            include_docs: true,
                            attachments: true
                        }).then(function (result) {
                            if (result.total_rows > 30) {
                                sorted = rowSort(result.rows)
                                var popdata = sorted[sorted.length - 1];
                                myBootmDB.remove(popdata.id, popdata.value.rev, function (err) {
                                    console.log(err)
                                })
                            }
                        }).catch(function (err) {
                            console.log(err);
                        });
                    }

                    function setState() {
                        initData.historyState.booth = boothId
                        initData.historyState.popid = 1;
                        initData.historyState.tabid = 'booth';
                        window.history.pushState(
                            initData.historyState,
                            null,
                            (isDirectOpened) ? initData.historyState.booth : initData.expo.expo_code + "/" + initData.historyState.booth
                        );
                    }

                    function boothProductContainer() {
                        templateContainer = pane.find('.tab-pane-body');
                        templateId = $$("#template-expo-" + paneId);
                        let template = Handlebars.compile(templateId.html());
                        let templateCard = Handlebars.compile($$("#template-expo-product-item").html());

                        compile(templateId, templateContainer, null);
                        paginationContainer = pane.find('#pagination-grid-' + paneId);
                        let searchstr = $$('input[name=searchstr]');
                        let searchid = $$('input[name=searchid]');
                        let isSearchMode = false;
                        let options = {
                            pageSize: 4,
                            locator: 'data.data',
                            dataSource: '/products',
                            totalNumber: 0,
                            totalNumberLocator: function (response) {
                                return response.data.total;
                            },
                            ajax: {
                                type: 'POST',
                                data: {
                                    expo_id: initData.expo.id,
                                    booth_id: initData.booth.id,
                                    searchid: searchid.val(),
                                    searchstr: searchstr.val()
                                },
                            },
                            callback: function (data, pagination) {
                                if (data.length > 0) {
                                    if (initData.product !== null) {
                                        openProductDetail(initData.product)
                                    }

                                    pane.find('#data-container-product').html(templateCard({data: data}));
                                } else {
                                    pane.find('.not-found').removeClass('d-none');
                                }
                                onClickBoothProduct();
                                toggleFavoriteBtn();
                            },
                            afterInit: function () {
                                if (initData.search.id !== null) {
                                    $$.ajax({
                                        url: "/product/detail",
                                        method: "POST",
                                        data: {
                                            product_id: searchid.val(),
                                        },
                                        success: function (res) {
                                            openProductDetail(res.data)
                                        },
                                    });
                                }
                            }
                        }

                        if (initData.search.type === 'product' && initData.search.id) {
                            options.ajax.data.searchid = searchstr.val();
                            searchid.val(initData.search.id);
                            isSearchMode = true;
                        }

                        // searchstr.unbind().bind('keyup input', function (e) {
                        //     if (e.keyCode === 8 && !searchstr.val() || e.keyCode === 46 && !searchstr.val()) {
                        //         isSearchMode = false
                        //     } else if (e.keyCode === 13 || !searchstr.val()) {
                        //         options.ajax.data.searchstr = searchstr.val();
                        //         paginationContainer.pagination(_.assignIn(defaultPageOptions, options));
                        //     }
                        // });

                        paginationContainer.pagination(_.assignIn(defaultPageOptions, options));

                        function onClickBoothProduct() {
                            pane.find('.btn-product').unbind();
                            pane.find('.btn-product').on('click', function (e) {
                                e.preventDefault();
                                $$.ajax({
                                    url: "/product/detail",
                                    method: "POST",
                                    data: {
                                        product_id: $(this).data('id'),
                                    },
                                    success: function (res) {
                                        openProductDetail(res.data)
                                    },
                                });
                            });
                        }
                    }

                    function boothContactContainer() {
                        templateContainer = pane.find('.tab-pane-body');
                        templateId = $$("#template-expo-booth-contact");

                        $$.ajax({
                            url: "/my/card/exchange/" + initData.booth.id,
                            method: "GET",
                            success: function (res) {
                                templateContainer.html(res);
                            },
                            complete: function (xhr, status) {
                                if (status === 'error') {
                                    boothTab.find('.nav-booth-' + boothTabPreviousPaneId).tab('show');
                                } else {
                                    contactForm();
                                }
                            }
                        });

                        function contactForm() {
                            let contactForm = $$('form[name=boothContactForm]');
                            let goBtn = contactForm.find('.btn-mycard').click(function (e) {
                                e.preventDefault();
                                confirmPopup('해당 페이지를 벗어나<br>명함관리 페이지로 이동하시겠습니까?', 'warning', function (val) {
                                    if (val.isConfirmed) {
                                        window.location.href = '/my/card';
                                    }
                                }, {showCancelButton: true})

                            });
                            contactForm.submit(function (e) {
                                e.preventDefault();
                                let data = new FormData($$(this)[0]);
                                data.append('booth_id', initData.booth.id);
                                data.append('company_id', initData.booth.company_booth.id);
                                $$.ajax({
                                    url: "/my/card/exchange",
                                    method: "POST",
                                    data: data,
                                    dataType: 'JSON',
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function (res) {
                                        if (res.result === 'OK') {
                                            confirmPopup(res.msg, 'success', function () {
                                                boothContactContainer();
                                            });
                                        }
                                    },
                                })
                            })

                        }
                    }

                    function openProductDetail(data) {
                        templateContainer = boothModal.find('#data-container-product-detail');
                        templateId = $$("#template-expo-product-detail");
                        const list = boothModal.find('#data-container-product');
                        const pagination = boothModal.find('#pagination-grid-product');
                        const detail = boothModal.find('#data-container-product-detail');
                        let obj = _.pick(data, ['prd_img1', 'prd_img2', 'prd_img3', 'prd_img4']);
                        data.previews = _.compact(Object.keys(obj).map(function (key) {
                            if (key === 'prd_img1') obj[key] = obj[key].replace('thumb/', '');
                            return obj[key];
                        }));
                        compile(templateId, templateContainer, data);
                        detail.show();
                        list.hide();
                        pagination.hide();
                        $$('.btn-back-list').on('click', function () {
                            detail.hide();
                            pagination.show();
                            list.show();
                            $$(this).unbind();
                        });
                        $$('#product-slider .slider-for').on('init', function (slick) {
                        });
                        $$('#product-slider .slider-for').on('lazyLoadError', function (event, slick, image, imageSource) {
                        });
                        $$('#product-slider .slider-for').on('destroy', function (slick) {
                        });
                        setTimeout(function () {
                            $$('#product-slider .slider-for').slick({
                                lazyLoad: 'ondemand',
                                speed: 100,
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                arrows: false,
                                touchMove: false,
                                draggable: false,
                                adaptiveHeight: false,
                                asNavFor: '.slider-nav',

                            });
                            $$('#product-slider .slider-nav').slick({
                                lazyLoad: 'ondemand',
                                speed: 100,
                                slidesToShow: 4,
                                slidesToScroll: 1,
                                asNavFor: '.slider-for',
                                touchMove: false,
                                draggable: false,
                                adaptiveHeight: false,
                                centerMode: false,
                                focusOnSelect: true,
                            });
                        }, 100)

                        toggleFavoriteBtn();
                        initData.product = null;
                        initData.search.type = null;
                        initData.search.id = null;
                    }

                }

                function openDirect() {
                    isDirectOpened = true;
                    if (window.location.hash && window.location.hash.indexOf('_')) {
                        let hash = window.location.hash;
                        let tabName = (hash.indexOf('_')) ? hash.replace('#', '').split('_')[0] : hash.replace('#', '');
                        initData.selectedTab = tabName;
                        initData.search.type = tabName;
                        initData.search.id = window.location.hash.split('_')[1];
                        $$('input[name=searchid]').val(initData.search.id);
                    }
                    boothContainer();
                    showTab('booth')
                }

                function searchLiveLoop(isOn) {
                    if (isOn) {
                        clearInterval(searchLoop);
                        checkCasts();
                        searchLoop = setInterval(function () {
                            checkCasts();
                        }, 3000);
                    } else {
                        clearInterval(searchLoop);
                    }
                }

                function introContainer() {
                    paneId = 'intro';
                    pane = $$('.tab-content').find('#' + paneId);
                    templateContainer = $$('.tab-content').find('#' + paneId).find('.tab-pane-body');
                    templateId = $$("#template-expo-" + paneId);
                    compile(templateId, templateContainer, initData.expo);
                    adBannerSlider('pc_expo_main_header');
                }

                function productContainer() {
                    let isAjax = true;
                    paneId = 'product';
                    pane = $$('.tab-content').find('#' + paneId);
                    templateContainer = $$('.tab-content').find('#' + paneId).find('.tab-pane-body');
                    templateId = $$("#template-expo-" + paneId);
                    let searchstr = templateContainer.find('input[name=searchstr]')

                    compile(templateId, templateContainer, null);
                    let searchInput = $$('#product-search').find('input[type=search]');
                    searchInput.unbind();
                    searchInput.val('');
                    searchInput.bind('keyup input', function (e) {
                        if (e.keyCode === 8 && !searchInput.val() || e.keyCode === 46 && !searchInput.val()) {
                        } else if (e.keyCode === 13 || !searchInput.val()) {
                            options.ajax.data = {expo_id: initData.expo.id, searchstr: searchInput.val()};
                            templateContainer.empty();
                            paginationContainer.pagination('destroy')
                                .pagination(_.assignIn(defaultPageOptions, options));

                        }
                    });

                    let options = {
                        pageSize: 4 * 4,
                        callback: function (data, pagination) {
                            if (data.length > 0) {
                                drawProductDataContainer(data);
                            } else {
                                paginationContainer.empty();
                                pane.find('.not-found').removeClass('d-none');
                            }
                        },
                        afterEnable: function () {
                            searchstr.unbind().bind('keyup input', function (e) {
                                if (e.keyCode === 8 && !searchstr.val() || e.keyCode === 46 && !searchstr.val()) {
                                } else if (e.keyCode === 13 || !searchstr.val()) {
                                    let idx = _.findIndex(initData.expo.products, function (chr) {
                                        return chr.prd_title === searchstr.val();
                                    });
                                    let pageNo = Math.floor((idx / options.pageSize)) + 1;
                                    paginationContainer.pagination('go', pageNo);
                                }
                            });
                        },
                    }

                    if (isAjax) {
                        options.locator = 'data.data'
                        options.dataSource = '/products';
                        options.totalNumberLocator = function (response) {
                            return response.data.total;
                        };
                        options.ajax = {
                            type: 'POST',
                            data: {expo_id: initData.expo.id},
                            beforeSend: function () {
                            }
                        };
                        paginationContainer = $$('#pagination-grid-' + paneId);
                        paginationContainer.pagination(_.assignIn(defaultPageOptions, options));

                    } else {
                        if (typeof initData.expo.products === 'undefined') {
                            pane.find('.not-found').removeClass('d-none');

                        } else {
                            options.locator = 'products'
                            options.dataSource = initData.expo;
                            options.totalNumber = initData.expo.products.length;
                            options.afterPaging = function () {
                                // $$('html, body').animate({
                                //     scrollTop: templateContainer.offset().top - 60
                                // }, 1);
                            }

                            paginationContainer = $$('#pagination-grid-' + paneId);
                            paginationContainer.pagination(_.assignIn(defaultPageOptions, options));
                        }
                    }

                    adBannerSlider('pc_expo_product_head');

                    function drawProductDataContainer(data) {
                        if (!pane.find('.not-found').hasClass('.not-found')) pane.find('.not-found').addClass('d-none');
                        templateId = $$("#template-expo-product-item");
                        templateContainer = $$('#data-container-product');
                        compile(templateId, templateContainer, {data: data});
                        toggleFavoriteBtn();
                        onClickProduct();
                    }
                }

                function boothContainer() {
                    paneId = 'booth';
                    pane = $$('.tab-content').find('#' + paneId);
                    templateContainer = $$('.tab-content').find('#' + paneId).find('.tab-pane-body');
                    templateId = $$("#template-expo-" + paneId);
                    compile(templateId, templateContainer, null);
                    let searchInput = $$('#booth-search').find('input[type=search]');
                    searchInput.unbind();
                    searchInput.val('');
                    searchInput.bind('keyup input', function (e) {
                        if (e.keyCode === 8 && !searchInput.val() || e.keyCode === 46 && !searchInput.val()) {
                        } else if (e.keyCode === 13 || !searchInput.val()) {
                            options.dataSource = _.filter(initData.expo.booths, function (o) {
                                return (_.includes(o.booth_title, searchInput.val()));
                            })
                            templateContainer.empty();

                            paginationContainer.pagination('destroy')
                                .pagination(_.assignIn(defaultPageOptions, options));

                        }
                    });

                    let options = {
                        pageSize: 4 * 2,
                        callback: function (data, pagination) {
                            if (data.length > 0) {
                                drawBoothDataContainer(data);
                            } else {
                                pane.find('.not-found').removeClass('d-none');
                            }
                        }
                    }
                    options.dataSource = initData.expo.booths;
                    options.afterPaging = function () {
                        // $$('html, body').animate({
                        //     scrollTop: $$('.content-wrap').offset().top - 60
                        // }, 1);
                    }
                    paginationContainer = $$('#pagination-grid-' + paneId);
                    paginationContainer.pagination(_.assignIn(defaultPageOptions, options));
                    searchLiveLoop(true);
                    if (isDirectOpened) {
                        initData.historyState.popid = 1;
                        let idx = _.findIndex(initData.expo.booths, function (chr) {
                            return chr.id === parseInt(initData.historyState.booth);
                        });

                        let pageNo = Math.floor((idx / options.pageSize)) + 1;
                        paginationContainer.pagination('go', pageNo);
                        openBooth(initData.historyState.booth);
                    }

                    adBannerSlider('pc_expo_booth_head');

                    function drawBoothDataContainer(data) {
                        if (!pane.find('.not-found').hasClass('.not-found')) pane.find('.not-found').addClass('d-none');

                        $$('a.open-booth').unbind();
                        templateId = $$("#template-expo-booth-item");
                        templateContainer = $$('#data-container-booth');
                        templateContainer.empty();
                        compile(templateId, templateContainer, {data: data});
                        $$('a.open-booth').on('click', function () {
                            openBooth($$(this).data('booth-id'))
                        });
                        toggleFavoriteBtn();
                    }
                }

                function onClickProduct() {
                    $$('.btn-product').unbind();
                    $$('.btn-product').on('click', function () {
                        initData.search.type = 'product';
                        initData.search.id = $$(this).data('id');
                        openBooth($$(this).data('booth'));
                    });
                }

                function toggleFavoriteBtn() {
                    $$('.btn-favorite').unbind('click');
                    $$('.btn-favorite').on('click', function (e) {
                        let obj = $$(this);
                        let type = obj.data('favorite');
                        let id = obj.data('id');
                        let icon = obj.find('.material-icons');
                        let data = {};
                        data[type + '_id'] = id;

                        $$.ajax({
                            url: "/my/favorites/" + type,
                            method: "POST",
                            data: data,
                            dataType: 'JSON',
                            success: function (res) {
                                if (res.result === 'OK') {
                                    if (res.data === 'add') {
                                        initData.favorites[type + '_' + id] = true;
                                        icon.addClass('text-warning');
                                    } else {
                                        delete initData.favorites[type + '_' + id];
                                        icon.removeClass('text-warning');
                                    }
                                    Swal2.fire({
                                        toast: false,
                                        text: res.msg,
                                        position: 'center',
                                        showConfirmButton: true,
                                        showDenyButton: true,
                                        denyButtonText: (type === 'product') ? '찜 관리' : '즐겨찾기 관리',
                                        customClass: {
                                            confirmButton: 'btn btn-sm btn-success',
                                            denyButton: 'btn btn-sm btn-black',
                                        },
                                        icon: (res.data === 'add') ? "success" : "warning",
                                    }).then(function (value) {
                                        if (value.isDenied) {
                                            if (type === 'product') {
                                                window.location.href = '/my/dibs';
                                            } else {
                                                window.location.href = '/my/favorites#' + type;
                                            }
                                        }
                                    });
                                    if ($$('#pagination-grid-' + type).length > 0) {
                                        let pagejs = $$('#pagination-grid-' + type);
                                        let currentpage = pagejs.pagination('getSelectedPageNum');
                                        pagejs.pagination('go', currentpage)
                                    }


                                } else {
                                    toastr.error(res.msg);
                                }
                            },
                        });
                    });
                }

                async function checkCasts() {
                    if (!initData.rmConfig.onCheck) return;
                    remon = new Remon({config: initData.rmConfig});

                    var searchResult = await remon.fetchCasts();
                    if (searchResult.length > 0) {
                        let cards = $$('#data-container-booth .card a');
                        $$.each(cards, function () {
                            let boothId = $$(this).attr('id');
                            let badge = $$(this).closest('.card').find('.badge-live');
                            let onLives = _.findIndex(searchResult, function (chr) {
                                let id = chr.id.split('_', 2)[1];
                                return 'booth_' + id === boothId;
                            });
                            if (onLives > -1) {
                                badge.show();
                            } else {
                                badge.hide();
                            }

                        })
                        if (isBoothOpened) {
                            let boothDialogLiveBtn = $$('.booth-dialog').find('.btn-live');
                            let onLives = _.findIndex(searchResult, function (chr) {
                                let id = parseInt(chr.id.split('_', 2)[1]);
                                return id === initData.booth.id;
                            });
                            if (onLives > -1) {
                                boothDialogLiveBtn.show();
                            } else {
                                boothDialogLiveBtn.hide();
                            }
                        }

                    }
                }

                function compile(target, container, data) {
                    let template = Handlebars.compile(target.html());
                    container.html(template(data));
                }

                function previewYoutube() {
                    var player = $('.youtube-player');
                    var val = player.data('url');
                    if (val.length < 1) {
                        player.hide();
                        return;
                    }
                    if (!ytVidId(val)) {
                        swal({
                            text: '유효하지 않는 Youtube 주소입니다.',
                            icon: 'error',
                            button: true,
                        });
                        player.hide();
                        return;
                    }
                    var id = YouTubeGetID(val);
                    var embed = `<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"width="100%" height="500" type="text/html" src="https://www.youtube.com/embed/${id}?autoplay=1&fs=0&iv_load_policy=3&showinfo=0&rel=0&cc_load_policy=0&start=0&end=0" frameborder="0" allowfullscreen></iframe>`;
                    player.html(embed);
                    player.show();
                }

                function YouTubeGetID(url) {
                    var ID = '';
                    url = url.replace(/(>|<)/gi, '').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
                    if (url[2] !== undefined) {
                        ID = url[2].split(/[^0-9a-z_\-]/i);
                        ID = ID[0];
                    } else {
                        ID = url;
                    }
                    return ID;
                }

                function ytVidId(url) {
                    var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
                    return (url.match(p)) ? RegExp.$1 : false;
                }

                function setData() {
                    initData.expo_code = initData.expo.expo_code;
                    initData.expoid = initData.expo.id;
                    initData.expo.booths = (typeof initData.expo.booths === 'undefined') ? [] : initData.expo.booths;
                    let convertFavorites = {};

                    _.forOwn(initData.favorites, function (value, key) {
                        if (value.length > 0) {
                            _.each(value, function (val) {
                                let id = val[key + '_id'];
                                convertFavorites[key + '_' + id] = true;
                            })

                        }
                    });

                    initData.favorites = convertFavorites;

                    let expodoc = {
                        "_id": '' + initData.expo.expo_code,
                        "title": initData.expo.expo_name,
                        "img": '/storage/' + initData.expo.expo_image_url,
                        "start": initData.expo.expo_open_date,
                        "end": initData.expo.expo_close_date,
                        "date": new Date()
                    }
                    myexpoDB.get('' + initData.expo.expo_code).then(function (doc) {
                        myexpoDB.remove(doc)
                        myexpoDB.put(expodoc);
                    }).catch(function (err) {
                        myexpoDB.put(expodoc)
                    });
                    myexpoDB.allDocs({
                        include_docs: true,
                        attachments: true
                    }).then(function (result) {
                        if (result.total_rows > 30) {
                            sorted = rowSort(result.rows)
                            var popdata = sorted[sorted.length - 1];
                            myexpoDB.remove(popdata.id, popdata.value.rev, function (err) {
                                console.log(err)
                            })
                        }
                    }).catch(function (err) {
                        console.log(err);
                    });

                }

                return {
                    init: function () {
                        Handlebars.registerHelper('isFavorite', function (type, id) {
                            return typeof initData.favorites[type + '_' + id] !== 'undefined';
                        });
                        setData();
                        if (initData.historyState.booth !== null) openDirect();
                        else window.history.replaceState(initData.historyState, null, '');
                        addListeners();
                        toggleFavoriteBtn();
                        if (!isDirectOpened) introContainer();
                    },
                    reservePop: function (obj) {
                        var data = {
                            'expo_code': initData.expo.expo_code,
                            'booth_id': initData.booth.id,
                            'meeting_date': $(obj).data('meeting-date'),
                            'meeting_time': $(obj).data('meeting-time'),
                            'text': $(obj).data('meeting-time-text'),
                            'ordinal-suffix': $(obj).data('ordinal-suffix'),
                        };
                        var url = '/reserve/' + data.expo_code + '/' + data.booth_id + '/' + data.meeting_date + '/' + data.meeting_time;

                        $.getJSON(url).done(function (res) {
                            // console.log('reservePop', res);
                            if (res.dupl !== null) {
                                var options = {
                                    toast: false,
                                    title: '<h4 style="font-size:1.5rem;font-weight:500;">이미 ' + res.dupl.meeting_time + '시에 미팅을 신청하셨습니다.</h4>',
                                    text: '담당자가 신청내용 확인 후 승인이 되면 해당 시간에 미팅이 진행됩니다.',
                                    position: 'center',
                                    showConfirmButton: true,
                                    icon: 'warning',
                                }
                                Swal2.fire(options).then(function (value) {
                                });

                            } else {
                                pop_tpl('default', 'cardpop', $.extend(data, res));
                            }
                        });
                    }

                }
            }(jQuery)
        );

        $(function () {
                expoDetail.init();
            }
        );
    </script>
@endsection
