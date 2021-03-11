@extends('desktop.layouts.none')
@section('head-script')
@endsection
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
@section('body')
@section('header','')
<div class="main">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="container">
                @if( !empty($desktop_banner_header) )
                    @include('desktop.inc.banner', ['banners'=>$desktop_banner_header
                             , 'banner_config'=> [
                                   'between'=> $expoConfig['desktop']['banner']['space']['header'],
                                   'perView'=> $expoConfig['desktop']['banner']['perview']['header'],
                                   'arrow'=> $expoConfig['desktop']['banner']['arrow']['header'],
                                   'class' => '',
                         ] ])
                @endif
                <div class="row justify-content-between pt-3">
                    <div class="col-12 ml-auto mr-auto">
                        <ul class="nav nav-pills nav-pills-black p-0 justify-content-center" id="tab-expo"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#all"
                                   role="tablist" aria-expanded="true">
                                    전체
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#ing"
                                   role="tablist"
                                   aria-expanded="false">
                                    진행중
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#pre"
                                   role="tablist"
                                   aria-expanded="false">
                                    모집중
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#end"
                                   role="tablist"
                                   aria-expanded="false">
                                    종료
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content tab-space justify-content-center">
                            <div class="tab-pane active" id="all">
                                <div class="tab-pane-body"></div>
                            </div>
                            <div class="tab-pane" id="ing">
                                <div class="tab-pane-body"></div>
                            </div>
                            <div class="tab-pane" id="pre">
                                <div class="tab-pane-body"></div>
                            </div>
                            <div class="tab-pane" id="end">
                                <div class="tab-pane-body"></div>
                            </div>
                        </div>

                    </div>
                </div>

                {{--                <div class="row" id="shuffle-container" style="min-height:550px;">--}}
                {{--                    @forelse( $expo as $row )--}}
                {{--                        <div class="col-3 d-flex justify-content-center shuffle-item"--}}
                {{--                             data-groups='["{{$row->getProgressStatus()}}"]'--}}
                {{--                             data-date-created="{{$row->expo_open_date}}">--}}
                {{--                            <div class="card position-relative" style="min-width:250px;max-width:250px;">--}}
                {{--                                @if(empty($row->expo_image_url))--}}
                {{--                                    <img class="card-img-top" src="/image/expo_none.png"--}}
                {{--                                         style="width:250px;height:250px;">--}}
                {{--                                @else--}}
                {{--                                    <img class="card-img-top" src="{{$row->getImageUrl()}}"--}}
                {{--                                         style="width:250px;height:250px;">--}}
                {{--                                @endif--}}
                {{--                                <div class="card-body p-0" style="min-height:104px;">--}}
                {{--                                    <div class="card-badge text-center">--}}
                {{--                                        <!----}}
                {{--                                        <span class="badge badge-black">#검색키워드</span>--}}
                {{--                                        <span class="badge badge-black">#검색키워드</span>--}}
                {{--                                        <span class="badge badge-black">#검색키워드</span>--}}
                {{--                                        -->--}}
                {{--                                    </div>--}}
                {{--                                    <h4 class="card-title m-0 pt-1 pl-2 pr-2 shuffle-item__title">{{$row->expo_name}}</h4>--}}
                {{--                                    <p class="card-text m-0 pl-2 pr-2">{{date_format($row->expo_open_date,'Y.m.d')}}--}}
                {{--                                        ~ {{date_format($row->expo_close_date,'Y.m.d')}}</p>--}}
                {{--                                    <a href="/expo/{{$row->expo_code}}" class="stretched-link" role="button"></a>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    @empty--}}
                {{--                    @endforelse--}}
                {{--                    <div class="col text-center shuffle-not-found" style="display:none;">--}}
                {{--                        <div class="info">--}}
                {{--                            <div class="icon">--}}
                {{--                                <button class="btn btn-danger btn-lg btn-fab btn-round btn-disabled">--}}
                {{--                                    <i class="material-icons">search_off</i>--}}
                {{--                                </button>--}}
                {{--                            </div>--}}
                {{--                            <h4 class="info-title">박람회 정보가 없습니다.</h4>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-after')
    @verbatim
        <script id="template-expo" type="text/x-handlebars-template">
            <div class="col text-center not-found d-none">
                <div class="info">
                    <div class="icon">
                        <button class="btn btn-danger btn-lg btn-fab btn-round btn-disabled">
                            <i class="material-icons">search_off</i>
                        </button>
                    </div>
                    <h4 class="info-title">박람회 정보가 없습니다.</h4>
                </div>
            </div>
            <div id="data-container"></div>
            <div id="pagination-grid"></div>
        </script>
        <script id="template-expo-item" type="text/x-handlebars-template">
            <div class="row">
                {{#each expos}}
                <div class="col-3">
                    <div class="card" style="min-width:250px;max-width:250px;">
                        <a href="/expo/{{expo_code}}">
                            {{#if expo_image_url}}
                                <img class="card-img-top" src="/storage/{{expo_image_url}}"
                                                 style="width:250px;height:250px;">
                            {{else}}
                                <img class="card-img-top" src="/assets/img/logo/bg-logo.png"
                                                 style="width:250px;height:250px;">
                            {{/if}}
                        </a>
                        <div class="d-flex justify-content-between">
                            <span>{{getDateStatus expo_open_date expo_close_date}}</span>
                            <button class="btn btn-sm btn-black btn-fab btn-round btn-favorite" data-id="{{id}}" data-favorite="expo">
                                <i class="material-icons {{#if (isFavorite id)}}text-warning{{/if}}">star</i>
                            </button>
                        </div>
                        <h4 class="m-0 p-0"><strong>{{expo_name}}</strong></h4>
                        <div class="d-flex justify-content-end">
                            {{dateformat expo_open_date 'Y.MM.DD'}} ~ {{dateformat expo_close_date 'Y.MM.DD'}}
                        </div>
                     </div>
                </div>
                {{/each}}
            </div>
        </script>
    @endverbatim
@stop
@section('page-script')
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="/assets/js/plugins/pagination.min.js" type="text/javascript"></script>

    <script>
        const expo = function ($$) {
            const initData = {
                expos: @json($expo),
                today: '{{$today}}',
                favorites: @json($favorite),
                filtered: null,
            }
            let favorites = {};
            _.forIn(initData.favorites, function (value, key) {
                favorites['expo_' + value.expo_id] = true;
            });

            const template = {
                expo: Handlebars.compile($$("#template-expo").html()),
                expoCard: Handlebars.compile($$("#template-expo-item").html()),
            }
            let pageOptions = {
                pageSize: 4 * 1,
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
            const tab = $$('#tab-expo');
            const slider = $$('#expo-ad-banner');

            let paneId = 'all'
            let pane = $$('.tab-content').find('#' + paneId);
            let templateContainer = pane.find('.tab-pane-body');

            Handlebars.registerHelper('getDateStatus', function (start, end) {
                let now = moment(initData.today).format('YMMD');
                let startDate = moment(start).format('YMMD');
                let endDate = moment(end).format('YMMD');
                if (now < startDate) return convertProgress('pre');
                else if (startDate <= now && now <= endDate) return convertProgress('ing');
                else return convertProgress('end');
            });

            Handlebars.registerHelper('isFavorite', function (id) {
                return typeof favorites['expo_' + id] !== 'undefined';
            });

            tab.on('show.bs.tab', function (e) {
                paneId = $$(e.target).attr('href').replace('#', '');
                pane = $$('.tab-content').find('#' + paneId);
                templateContainer = pane.find('.tab-pane-body');
                drawContainer(paneId);
            });
            drawContainer('all');
            slider.slick({
                autoplay: true,
                autoplaySpeed: 3000,
                dots: false,
                touchMove: false,
                infinite: true,
                adaptiveHeight: false
            });

            function filter(id) {
                initData.filtered = _.filter(initData.expos, function (o) {
                    if (id === 'ing') {
                        return (moment(o.expo_open_date) <= moment(initData.today) && moment(o.expo_close_date) > moment(initData.today)) ? o : null;
                    }
                    if (id === 'pre') {
                        return (moment(o.expo_recruit_start_date) <= moment(initData.today) && moment(o.expo_recruit_end_date) > moment(initData.today)) ? o : null;
                    }
                    if (id === 'end') {
                        return (moment(o.expo_close_date) <= moment(initData.today)) ? o : null;
                    }
                    return null;
                });
                return initData.filtered;
            }

            function drawContainer(id) {
                templateContainer.html(template.expo());
                const paginationContainer = pane.find('#pagination-grid');
                const dataContainer = pane.find('#data-container');

                if (id === 'all') {
                    pageOptions.dataSource = initData.expos;
                } else {
                    pageOptions.dataSource = filter(id);
                }
                pageOptions.callback = function (data,pagination) {
                    if (data.length > 0) {
                        dataContainer.html(template.expoCard({expos: data}));
                        toggleFavoriteBtn();
                    } else {
                        paginationContainer.empty();
                        pane.find('.not-found').removeClass('d-none');
                    }
                }
                paginationContainer.pagination(pageOptions);

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
        }(jQuery)
    </script>
@endsection
