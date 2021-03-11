@extends('desktop.layouts.none')
@section('css')
    <style>
        .dataTables_empty {
            text-align: center;
            font-weight: 500;
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
    </style>
@endsection
@section('body-class', '')
@section('header','')
@section('body')
    <div class="main">
        <div class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-2">
                        @include('desktop.my.inc.mylnb')
                    </div>
                    <div class="col-10">
                        <ul class="nav nav-pills nav-pills-black p-0" id="tab-favorites" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link nav-expo active" data-toggle="tab" href="#expo" role="tablist"
                                   aria-expanded="true">
                                    박람회
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-booth" data-toggle="tab" href="#booth" role="tablist"
                                   aria-expanded="true">
                                    부스
                                </a>
                            </li>
                            {{--                            <li class="nav-item">--}}
                            {{--                                <a class="nav-link nav-product" data-toggle="tab" href="#product" role="tablist"--}}
                            {{--                                   aria-expanded="true">--}}
                            {{--                                    전시상품--}}
                            {{--                                </a>--}}
                            {{--                            </li>--}}
                        </ul>
                        <div class="tab-content tab-space pt-4">
                            <div class="tab-pane active" id="expo" aria-expanded="true">
                                <div class="tab-pane-body"></div>
                            </div>
                            <div class="tab-pane" id="booth" aria-expanded="true">
                                <div class="tab-pane-body"></div>
                            </div>
                            <div class="tab-pane" id="product" aria-expanded="true">
                                <div class="tab-pane-body"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-after')
    @include('desktop.my.template')
@endsection
@section('page-script')
    <script src="/assets/js/plugins/pagination.min.js" type="text/javascript"></script>
    <script>
        const myFavorites = (function ($$) {
            const initData = {
                today: '{{$today}}',
                favorites: {
                    expo: @json($expos),
                    booth: @json($booths),
                },
            }
            const favoritesTab = $$('#tab-favorites');
            const templates = {
                target: null,
                expo: Handlebars.compile($$('#template-favorites-expo').html()),
                expoItem: Handlebars.compile($$('#template-favorites-expo-item').html()),
                booth: Handlebars.compile($$('#template-favorites-booth').html()),
                boothItem: Handlebars.compile($$('#template-favorites-booth-item').html()),
                product: Handlebars.compile($$('#template-favorites-product').html()),
                productItem: Handlebars.compile($$('#template-favorites-product-item').html()),
            }
            let defaultPageOptions = {
                className: "page-item",
                ulClassName: "pagination",
                showPrevious: true,
                showNext: true,
                showPageNumbers: true,
                showNavigator: false,
                prevText: '이전',
                nextText: '다음',
                hideWhenLessThanOnePage: true,
            };

            let tabStatus = {
                paneId: null,
                paneEle: null,
                selectedTabEle: null,
            }

            function getFavoriteData() {
                $$.ajax({
                    type: 'GET',
                    url: '/my/favorites',
                    dataType: "JSON",
                    cache: false,
                    success: function (res) {
                        console.log(res)
                    }
                });
            }

            function drawPaneContainer(tabId) {
                let templateId = tabId + 'Item';
                let result = templates.target.html(templates[tabId](initData.favorites));
                let pageContent = $$('<div/>', {
                    id: 'booth-favorites-pagination',
                    appendTo: result,
                });
                let pagination = $$('<div/>', {
                    id: 'booth-favorites-container',
                    appendTo: result,
                });

                let options = {
                    dataSource: initData.favorites[tabId],
                    pageSize: 4 * 2,
                    callback: function (data, pagination) {
                        if (data.length > 0) {
                            pageContent.html(templates[templateId]({data: data}));
                            onClickRemoveFavorite();
                        } else {
                            tabStatus.paneEle.find('.not-found').removeClass('d-none');
                        }
                    }
                }
                pagination.pagination(_.assignIn(defaultPageOptions, options))
            }


            favoritesTab.on('show.bs.tab', function (e) {
                tabStatus.selectedTabEle = $$(e.target);
                tabStatus.paneId = tabStatus.selectedTabEle.attr('href').replace('#', '');
                tabStatus.paneEle = $$('#' + tabStatus.paneId);
                templates.target = tabStatus.paneEle.find('.tab-pane-body')
                drawPaneContainer(tabStatus.paneId);
            });
            Handlebars.registerHelper('getDateStatus', function (start, end) {
                let now = moment(initData.today).format('YMMD');
                let startDate = moment(start).format('YMMD');
                let endDate = moment(end).format('YMMD');
                if (now < startDate) return convertProgress('pre');
                else if (startDate <= now && now <= endDate) return convertProgress('ing');
                else return convertProgress('end');
            });

            function convertProgress(value) {
                let str;
                switch (value) {
                    case 'ing':
                        str = '진행';
                        break;
                    case 'pre':
                        str = '예정';
                        break;
                    default:
                        str = '종료'
                }
                return str;
            }

            function showTab(tabId) {
                tabStatus.selectedTabEle = favoritesTab.find('.nav-' + tabId);
                tabStatus.paneId = tabStatus.selectedTabEle.attr('href').replace('#', '');
                tabStatus.paneEle = $$('#' + tabStatus.paneId);
                templates.target = tabStatus.paneEle.find('.tab-pane-body')
                tabStatus.selectedTabEle.tab('show');
                drawPaneContainer(tabId);

            }

            function onClickRemoveFavorite() {
                $$('.btn-favorite-remove').unbind();
                $$('.btn-favorite-remove').on('click', function (e) {
                    e.preventDefault();
                    let type = $$(this).data('favorite')
                    let id = $$(this).data('id')
                    let card = $$(this).closest('div');
                    let data = {};
                    data[type + '_id'] = id;
                    $.ajax({
                        url: "/my/favorites/" + type,
                        method: "POST",
                        data: data,
                        dataType: 'JSON',
                        success: function (res) {
                            if (res.result === 'OK') {
                                _.remove(initData.favorites[type], function (o) {
                                    return o[type + '_id'] === id;
                                });
                                showTab(type);
                                Swal2.fire({
                                    toast: false,
                                    text: res.msg,
                                    position: 'center',
                                    showConfirmButton: true,
                                    timer: 3000,
                                    icon: "success",
                                    // timerProgressBar: true,
                                    didOpen: function (toast) {
                                        toast.addEventListener('mouseenter', Swal2.stopTimer)
                                        toast.addEventListener('mouseleave', Swal2.resumeTimer)
                                    }
                                }).then(function (value) {
                                    if (value) {
                                        // window.location.reload();
                                    }
                                });


                            }
                        }
                    });
                });
            }

            if (window.location.hash) {
                showTab(window.location.hash.replace('#', ''));
                history.replaceState('', document.title, window.location.pathname);
            } else {
                showTab('expo');
            }
        }(jQuery));
        $(function () {
        });
    </script>
@stop
