@extends('desktop.layouts.none')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        .shuffle-item2 .card-pricing:hover .overlay {
            bottom: 0;
            height: 100%;
        }

        .shuffle-item .card-pricing .overlay {
            position: absolute;
            bottom: 100%;
            left: 0;
            right: 0;
            background-color: #000000c4;
            overflow: hidden;
            width: 100%;
            height: 0;
            transition: .5s ease;
        }

        .shuffle-item .card-pricing .overlay .text {
            color: white;
            font-size: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            text-align: center;
        }

        #image-preview-pc, #image-preview-mobile {
            width: 250px;
            height: 250px;
            border: 2px dashed #ddd;
            border-radius: 3px;
            position: relative;
            overflow: hidden;
            background-color: #ffffff;
            color: #ecf0f1;
        }

        .image-preview label, #callback-preview label {
            position: absolute;
            z-index: 5;
            opacity: 0.8;
            cursor: pointer;
            width: 140px;
            height: 29px;
            text-transform: uppercase;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            text-align: center;
            color: #fff;
            background-color: #3c4858;
            border-color: #3c4858;
            box-shadow: 0 2px 2px 0 rgba(60, 72, 88, .14), 0 3px 1px -2px rgba(60, 72, 88, .2), 0 1px 5px 0 rgba(60, 72, 88, .12);
            padding: .40625rem 1.25rem;
            font-size: .6875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }

        .image-preview-pc input, .image-preview-mobile input, #callback-preview input {
            line-height: 200px;
            font-size: 200px;
            position: absolute;
            opacity: 0;
            z-index: 10;
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
                    <div class="col-10">
                        <div class="row" id="shuffle-container" style="min-height:550px;">
                            @if (count($booths) > 0)
                                @foreach( $booths as $row )
                                    <div class="col-3 shuffle-item"
                                         data-groups='["{{$row->expoBooth->getProgressStatus()}}"]'
                                         data-date-created="{{$row->expoBooth->expo_open_date}}">
                                        <div class="card card-pricing position-relative mt-0"
                                             style="min-width:250px;max-width:250px;">
                                            <img class="card-img-top"
                                                 src="{{ (empty($row->booth_image_url)?'/image/expo_none.png':$row->booth_image_url) }}"
                                                 style="width:250px;height:250px;">
                                            <div
                                                style="position: absolute;top: 0;right:0;width: 100%;height: auto;z-index:1;text-align:right;">

                                            </div>
                                            <div class="card-body" style="padding-top:0 !important;">
                                                <h4 class="card-title m-0 pt-1 text-left">{{$row->expoBooth->expo_name}}</h4>
                                                <h5 class="card-title m-0 pt-1 text-left">{{$row->booth_title}}</h5>
                                                <p class="card-text m-0 text-left">{{date_format($row->expoBooth->expo_open_date,'Y.m.d')}}
                                                    ~ {{date_format($row->expoBooth->expo_close_date,'Y.m.d')}}</p>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <a href="/my/booth/product/{{ $row->id  }}" role="button"
                                                           class="btn btn-sm btn-black btn-block" style="z-index:2">전시상품관리</a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a href="/my/booth/live/{{ $row->id  }}" role="button"
                                                           class="btn btn-sm btn-black btn-block" style="z-index:2">LIVE
                                                            방송</a>
                                                    </div>
                                                </div>
                                                <a href="/my/booth/detail/{{ $row->id  }}"
                                                   class="stretched-link"></a>
                                            </div>
                                            <div class="overlay">
                                                <div class="text">수정 하기</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col m-auto text-center">
                                    <div class="info">
                                        <div class="icon">
                                            <button class="btn btn-danger btn-lg btn-fab btn-round btn-disabled">
                                                <i class="material-icons">search_off</i>
                                            </button>
                                        </div>
                                        <h4 class="info-title">개설된 부스가 없습니다.</h4>
                                        <a href="" role="button" class="btn btn-sm btn-black">부스 개설하기</a>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="/assets/js/plugins/jquery.uploadPreview.min.js" type="text/javascript"></script>

    <script src="/assets/js/plugins/shuffle.min.js" type="text/javascript"></script>
    <script>
        var booth_list = @json($booths);
        var expo_list = @json($expo_list);
        var Shuffle = window.Shuffle;
        var element = document.querySelector('#shuffle-container');
        var shuffleInstance = new Shuffle(element, {
            itemSelector: '.shuffle-item',
        });
        $(function () {
            $('.shuffle-item').on('layout.shuffle', function (evt, shuffle) {
                console.log(shuffle.visibleItems);
            });
            $('ul[role=tablist] > li > a').on('click', function (e) {
                e.preventDefault();
                if ($(this).data('status') === 'all') {
                    shuffleInstance.filter();
                } else {
                    shuffleInstance.filter($(this).data('status'));
                }
            })
            $('#modal-lg').on('hidden.bs.modal', function (e) {
                $.fn.uploadPreview = null;
                $('input[name=booth_youtube_url]').unbind();
                $('input[name=booth_movtype]').unbind();
                if ($('#select-expo').hasClass("select2-hidden-accessible")) {
                    $('#select-expo').select2('destroy');
                }
            })

        });

    </script>
    @include('desktop.my.booth.template')

@endsection
