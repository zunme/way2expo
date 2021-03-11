<!-- 배너 -->
@php
    $bannerConfig = [
    'between'=> empty( $banner_config['between'] ) ? '0' : $banner_config['between'] ,
    'perView'=> empty( $banner_config['perView'] ) ? '1' : $banner_config['perView'] ,
    'arrow'=> empty( $banner_config['arrow'] ) || $banner_config['arrow'] != 'on' ? 'off' : 'on' ,
    'indicators'=> empty( $banner_config['indicators'] ) || $banner_config['indicators'] != 'on' ? 'off' : 'on' ,
    'class' => empty( $banner_config['class'] ) ? '' : $banner_config['class'] ,
    'auto' => empty( $banner_config['auto'] ) || $banner_config['auto']==true ? 'swiper-auto-play' : '' ,
    'loop' => empty( $banner_config['loop'] ) || $banner_config['auto']== true ? 'true' : 'false' ,
    'center' => empty( $banner_config['center'] ) || $banner_config['center']== true ? 'true' : 'false' ,
    'page' => empty( $banner_config['page'] ) || $banner_config['page']== true ? true : false ,
    ];

    if( count( $banners ) == 1) {
      $bannerConfig['auto'] ='';
      $bannerConfig['arrow'] ='off';
      $bannerConfig['indicators'] ='off';
      $bannerConfig['perView'] ='1';
      $bannerConfig['loop'] ='false';
      $bannerConfig['page'] =false;
    }
@endphp
@if( count( $banners ) > 0 )
    <div class="section p-0 pt-4 position-relative">
        <div id="expo-ad-banner" class="expo-ad-banner" style="min-height:350px;">
            @foreach( $banners as $banner)
                <div class="carousel-item {{($loop->first)?'active':''}}">
                    <a href="{{$banner->url}}"
                       @if ($banner->banner_class=='_blank')
                       target="_blank"
                       @endif
                       class="link @if($banner->banner_class=='_blank' || $banner->banner_class=='external') external @endif" style="width:100%">
                        <img class="img w-100"
                             src="{{$banner->getImageUrl()}}"
                             alt="" style="">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
@php
    //dd( $bannerConfig)
@endphp
<!-- 배너 -->
