@extends('desktop.layouts.none')
@section('css')
    <style>
        .search-tab .nav .nav-item {
            width: 25%;
            margin: 0 !important;
        }

        .search-tab .nav .nav-item .nav-link {
            padding: 5px 0;
            margin: 0 5px;
        }

        .result-content .card {
            margin: 0 auto;
        }

        .card-search-booth {
            text-align: left;
        }

        .card-search-booth .card-header-image {
            width: 170px;
            height: 170px;
        }

        .result-content .card-img.end-filter {

        }

        .result-content .card-img.end-filter::before {
            background: rgba(0, 0, 0, .7);
        }

        .result-content .card-img.end-filter::before, .result-content .card-img.end-filter::after {
            position: absolute;
            z-index: 1;
            width: 250px;
            height: 250px;
            display: block;
            left: 0;
            top: 0;
            content: "";
        }

        mark {
            background: #e5007e;
            color: #fff;
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
@section('body-class', '')
@section('header','')
@section('body')
    <div class="main">
        <div class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div id="search-top-keyword" class="m-2">
                            <h6>이번주 고객님들의 가장 많이 검색한 단어 입니다.</h6>
                        </div>
                        <h4 class="title mt-0">
                            <span id="search-keyword" class="text-danger"></span>
                            <small>관련 총 <span id="totalCount" class="count-span"></span> 개의 검색 결과</small>
                        </h4>
                    </div>
                    <div class="col-12">
                        <div class="search-tab">
                            <ul class="nav nav-pills nav-pills-black p-0" id="tab-search" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#result-all" role="tablist"
                                       aria-expanded="true">
                                        전체 (<span class="count-text count-text-all"></span>)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#result-expo" role="tablist"
                                       aria-expanded="true">
                                        박람회 (<span class="count-text-expo"></span>)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#result-booth" role="tablist"
                                       aria-expanded="true">
                                        부스 (<span class="count-text-booth"></span>)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#result-product" role="tablist"
                                       aria-expanded="true">
                                        전시상품 (<span class="count-text-product"></span>)
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="result-content">
                            <div class="loader">Loading...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-after')
    @include('desktop.search.template')
@stop
@section('page-script')
    <script src="/assets/js/plugins/jquery.mark.min.js"></script>
    <script src="/assets/js/plugins/pagination.min.js" type="text/javascript"></script>

    <script>
        // 즐겨찾기 collection 수정
        const searchResult = (function ($$) {
            const resultContainer = $$('.result-content');
            const searchTab = $$('#tab-search')
            const searchTopKeywordContainer = $$('#search-top-keyword');
            const searchForm = $$('form[name=nav-searchForm]');
            const searchKeyword = searchForm.find('input[name=q]');
            const url = decodeURIComponent(window.location.href);
            const pageOptions = {
                pageSize: 4 * 4,
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
            let keyword = searchKeyword.val(), resultData, today, searchData, favorites, topKeywords;
            let template = Handlebars.compile($$("#search-template").html());
            let templateAll = Handlebars.compile($$('#template-result-all').html());
            let templateExpo = Handlebars.compile($$('#template-result-expo').html());
            let templateBooth = Handlebars.compile($$('#template-result-booth').html());
            let templateProduct = Handlebars.compile($$('#template-result-product').html());
            let resultTemplate = {
                'all': templateAll,
                'expo': templateExpo,
                'booth': templateBooth,
                'product': templateProduct,
            }

            function addListeners() {
                tabListener(true);
            }

            function tabListener(isOn) {
                if (isOn) {
                    searchTab.on('show.bs.tab', function (e) {
                        let previousPaneId = $$(e.relatedTarget).attr('href').replace('#', '');
                        let paneId = $$(e.target).attr('href').replace('#result-', '');
                        if (paneId !== 'all') drawPagination(paneId, searchData);
                        else drawDashboard(searchData);
                    });
                }
            }

            function render(res) {
                resultContainer.html(template(res));
                resultData = res.data;
                searchData = resultData.searchData;
                today = resultData.today;
                topKeywords = resultData.topKeywords;
                favorites = {};
                _.forIn(searchData.favorites, function (value, key) {
                    _.keyBy(value, function (o) {
                        favorites[key + '_' + o[key+'_id']] = null;
                    })
                });
                $$('#search-keyword').text(keyword);
                $$('#totalCount').text(searchData.expo.length + searchData.booth.length + searchData.product.length);

                drawDashboard(searchData);
                topKeywords.forEach(function (item) {
                    searchTopKeywordContainer.append('' +
                        '<button class="btn btn-sm btn-dark btn-topKeyword">' +
                        '#' + item.search +
                        '</button>');
                });
                onClickTopKeyword(true);
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
                                    favorites[type + '_' + id] = true;

                                    icon.addClass((type === 'product')?'text-danger':'text-warning');
                                } else {
                                    delete favorites[type + '_' + id];
                                    icon.removeClass((type === 'product')?'text-danger':'text-warning');
                                }
                                Swal2.fire({
                                    toast: false,
                                    text: res.msg,
                                    position: 'center',
                                    showConfirmButton: true,
                                    showDenyButton: true,
                                    denyButtonText: '즐겨찾기 관리',
                                    customClass: {
                                        confirmButton: 'btn btn-sm btn-success',
                                        denyButton: 'btn btn-sm btn-black',
                                    },
                                    icon: "success",
                                }).then(function (value) {
                                    if (value.isDenied) {
                                        if (type === 'product') {
                                            window.location.href = '/my/dibs';
                                        } else {
                                            window.location.href = '/my/favorites#' + type;
                                        }
                                    }
                                });

                            } else {
                                toastr.error(res.msg);
                            }
                        },
                    });
                });
            }

            function onClickTopKeyword(isOn) {
                const btn = $$('.btn-topKeyword');
                if (isOn) {
                    btn.on('click', function () {
                        keyword = $$(this).text().replace('#', '');
                        searchKeyword.val(keyword)
                        searchForm.submit();
                    })
                } else {
                    btn.unbind('click')
                }
            }

            function drawDashboard(data) {
                data = {
                    expo: (data.expo.length > 4) ? data.expo.slice(0, 4) : data.expo,
                    booth: (data.booth.length > 2) ? data.booth.slice(0, 2) : data.booth,
                    product: (data.product.length > 2) ? data.product.slice(0, 4) : data.product,
                    favorites: data.favorites,
                }

                $$('#data-container-all').html(templateAll(data));

                if (data.expo.length < 1) {
                    $$('.not-found-expo').removeClass('d-none');
                } else {
                    $$('#data-container-all-expo').html(templateExpo(data));
                }
                if (data.booth.length < 1) {
                    $$('.not-found-booth').removeClass('d-none')
                } else {
                    $$('#data-container-all-booth').html(templateBooth(data));

                }
                if (data.product.length < 1) {
                    $$('.not-found-product').removeClass('d-none')
                } else {
                    $$('#data-container-all-product').html(templateProduct(data));

                }

                $$('.count-text-all').text(searchData.expo.length + searchData.booth.length + searchData.product.length);
                $$('.count-text-expo').text(searchData.expo.length);
                $$('.count-text-booth').text(searchData.booth.length);
                $$('.count-text-product').text(searchData.product.length);
                toggleFavoriteBtn();
            }

            function drawPagination(tabName, data) {
                if (data[tabName].length < 1) {
                    let pane = $$('.tab-content #result-' + tabName);
                    pane.find('.not-found').removeClass('d-none')
                    return;
                }
                let grid = $$('#pagination-grid-' + tabName);

                pageOptions.dataSource = data[tabName];
                pageOptions.callback = function (response, pagination) {
                    let dataObj = {};
                    dataObj[tabName] = response
                    $$('#data-container-' + tabName).html(resultTemplate[tabName](dataObj));
                    toggleFavoriteBtn();
                    // $$("body,html").animate({scrollTop:$$('.search-tab').offset().top},0)
                }
                $$.pagination(grid, pageOptions);
                pageOptions.dataSource = [];
                pageOptions.callback = null;
            }

            function urlParam(name) {
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(url);
                if (results == null) {
                    return null;
                } else {
                    return results[1] || 0;
                }
            }

            function removeRegExp(str) {
                var reg = /[\{\}\[\]\/?.,;:|\)*~`!^\-_+<>@\#$%&\\\=\(\'\"]/gi
                if (reg.test(str)) {
                    return str.replace(reg, "");
                } else {
                    return str;
                }
            }

            function getSearchData() {
                keyword = removeRegExp(keyword);

                const url = "/search/" + keyword;
                if (keyword.length < 2) {
                    confirmPopup('검색어는 특수문자를 제외한 2자이상 입니다.', 'error')
                    return;
                }
                $$.ajax({
                    type: 'get',
                    url: url,
                    dataType: "JSON",
                    cache: false,
                    success: function (res) {
                        render(res);
                    },
                });
            }

            function convertProgress(value) {
                let str;
                switch (value) {
                    case 'ing':
                        str = '진행중';
                        break;
                    case 'pre':
                        str = '준비중';
                        break;
                    case 'end':
                        str = '종료';
                        break;
                }
                return str;
            }

            return {
                init: function () {
                    Handlebars.registerHelper('progress', function (str) {
                        return convertProgress(str);
                    });
                    Handlebars.registerHelper('isFavorite', function (type, id) {
                        return typeof favorites[type + '_' + id] !== 'undefined';
                    });
                    Handlebars.registerHelper('getDateStatus', function (start, end) {
                        let now = moment(resultData.today).format('YMMD');
                        let startDate = moment(start).format('YMMD');
                        let endDate = moment(end).format('YMMD');
                        if (now < startDate) return convertProgress('pre');
                        else if (startDate <= now && now <= endDate) return convertProgress('ing');
                        else return convertProgress('end');
                    });
                    Handlebars.registerHelper('isFavoriteAvailable', function (start) {
                        let now = moment(resultData.today).format('YMMD');
                        let startDate = moment(start).format('YMMD');
                        return (now >= startDate);
                    });
                    addListeners();
                    getSearchData();
                },
            }
        })(jQuery);

        $(function () {
            searchResult.init();
        });
    </script>
@stop
