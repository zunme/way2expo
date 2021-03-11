<!-- 배너 -->
@php
  $bannerConfig = [
  'between'=> empty( $banner_config['between'] ) ? '0' : $banner_config['between'] ,
  'perView'=> empty( $banner_config['perView'] ) ? '1' : $banner_config['perView'] ,
  'arrow'=> empty( $banner_config['arrow'] ) || $banner_config['arrow'] != 'on' ? 'off' : 'on' ,
  'class' => empty( $banner_config['class'] ) ? '' : $banner_config['class'] ,
  'auto' => empty( $banner_config['auto'] ) || $banner_config['auto']==true ? 'swiper-auto-play' : '' ,
  'loop' => empty( $banner_config['loop'] ) || $banner_config['auto']== true ? 'true' : 'false' ,
  'center' => empty( $banner_config['center'] ) || $banner_config['center']== true ? 'true' : 'false' ,
  'page' => empty( $banner_config['page'] ) || $banner_config['page']== true ? true : false ,
  ];

  if( count( $banners ) == 1) {
    $bannerConfig['auto'] ='';
    $bannerConfig['arrow'] ='off';
    $bannerConfig['perView'] ='1';
    $bannerConfig['loop'] ='false';
    $bannerConfig['page'] =false;
  }
@endphp
@if( !empty($banners) )
            <div data-pagination='{"el": ".swiper-pagination", "clickable": true}'
                  data-navigation='{"nextEl": ".swiper-button-next","prevEl":".swiper-button-prev"}'
                  data-space-between="{{$bannerConfig['between']}}"
                  data-slides-per-view="{{$bannerConfig['perView']}}"
                  data-loop="{{$bannerConfig['loop']}}"
                  data-centered-slides="{{$bannerConfig['center']}}"
                  class="swiper-container swiper-init {{$bannerConfig['auto']}} {{$bannerConfig['class']}}">

              <div class="swiper-pagination"></div>

              <div class="swiper-wrapper">
                @foreach( $banners as $banner)
                <div class="swiper-slide @if($banner->banner_class=='_blank' || $banner->banner_class=='external' ) link-external @endif"
                      data-src="{{$banner->url}}">
                    <a href="{{$banner->url}}"
                        @if ($banner->banner_class=='_blank')
                        target="_blank"
                        @endif
                        class="link @if($banner->banner_class=='_blank' || $banner->banner_class=='external') external @endif" style="width:100%">
                      <img src="{{$banner->getImageUrl()}}" style="width:100%">
                    </a>
                </div>
                @endforeach
              </div>
              @if( $bannerConfig['arrow'] =='on')
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
              @endif
            </div>
@endif
@php
  //dd( $bannerConfig)
@endphp
<!-- 배너 -->
