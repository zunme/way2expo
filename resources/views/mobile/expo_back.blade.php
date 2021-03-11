@extends('mobile.defaultlayout')
@section('css')
<style>
  /* page navbar color */
:root{
    --navbar-bg-new-color : #666;
}
.navbar-new .navbar-bg{
  --f7-navbar-bg-color : rgb(247, 247, 248);
}
.navbar-new .title{
 color : var(--navbar-bg-new-color);
}
.navbar.navbar-new a.link, .navbar.navbar-new .material-icons{
  color : var(--navbar-bg-new-color);
}
</style>
<style>
.background-pos-top{background-position:center top !important;}
.pt-0{padding-top: 0 !important;}
.pl-0 {padding-left: 0 !important}
.pr-0 {padding-right: 0 !important}
.pb-0 {padding-bottom: 0 !important}
.count_span{margin-left:10px;}
.demo-card-header-pic{
  margin-bottom: 26px;
}
.demo-card-header-pic .card-header {
  min-height: 300px;
  background-position: center top;
  }
.expo_over{
    flex-grow: 1;
    background-color: rgb(51 51 51 / 73%);
    padding: 10px 5px;
    display: flex;
    /*justify-content: space-between;*/
    justify-content: flex-end;
    box-shadow: var(--f7-card-box-shadow);
}
.expo_over_inner_wrap{
  display: flex;
  align-items: center;
  padding-left: 5px;
  padding-right: 5px;
}
.expo_over_inner_wrap > .material-icons , .expo_over_inner_wrap >.count_span {
    font-size: 17px !important;
}
.card-expo-title{
  font-size: 16px;
  font-weight: 500;
  color: #6b6b6b;
}
.expo-title{
  margin-bottom: 5px;
}
.expo-opentime{
  font-size: 14px;
}
.expo-location{
  font-size: 14px;
}

#search-expo-fail-box{
  text-align: center;
  color: #669FAB;
  padding: 40px 5px;
  display:none;
}
#search-expo-fail-box .material-icons{
  font-size: 60px;
}

.icon-only2{
  width: 40px !important;
  padding: 0 0 0 10px !important;
}
</style>
<style>
.expo-detail-top-img-over{
  position: absolute;
    z-index: 2;
    bottom: 0;
    right: 0;
    left: 0;
    padding: 10px 20px;

    border-bottom-left-radius: var(--top-img-border-left-radius);
    border-bottom-right-radius: var(--top-img-border-right-radius);
    background-color: rgb(51 51 51 / 50%);
}
.expo-detail-top-img-over-inner{
  display: flex;
  justify-content: space-between;
}
.expo-detail-top-img-over a{
  color:white;
}
.circle_btn_36{
  padding: 3px;
    height: 36px;
    width: 36px;
    background: black;
    border-radius: 50%;
}
.expo-description-box{
  padding: 10px;
font-size: 14px;
font-weight: 500;
color: #333;
}
.fixedtoolbar{
  background-color: white;
  position: fixed;
  top: 56px;
  z-index: 100;
}
.pop-close-icon-btn{
  position: absolute;
  right: 0;
  z-index: 10;
}
.pop-close-icon-btn > a > .material-icons{
  color:#666;
}
.pop-office-change p {
  font-size: 16px;
}
.pop-office-icon{
  font-size: 52px;
  padding: 15px;
  background-color: #494975;
  color: white;
  border-radius: 50%;
}
.pop-office-change-title{
  display: flex;
  padding: 10px 5px;
}
.pop-office-change-title > .material-icons {
  font-size: 16px;
  line-height: 30px;
  height: 30px;
}
.pop-office-change-title > .office-change-subtitle{
  line-height: 22px;
  font-size: 20px;
  vertical-align: baseline;
  margin-top: 5px;
  height: 30px;
  padding-left: 10px;
}
</style>
@endsection
@section('main-header')
<div class="top-img-header  header-filter border-radius {{$expoConfig['mobile']['expo_title_size']}}" filter-color="{{$expoConfig['mobile']['expo_title_filter']}}" style="background-image: url(https://way2expo.com/wp-content/themes/way2expo/dist/assets/images/temp/bg-page-header.png);">
  <div class="top-img-title">
    <p>
      박람회
    </p>
  </div>
</div>
@endsection
@section('body')
  <!-- 배너 -->
  @if( !empty($mobile_banner_header) )
						<div class="wrap">
                <!-- class new-block-size -->
							<div data-pagination='{"el": ".swiper-pagination"}' data-navigation='{"nextEl": ".swiper-button-next","prevEl":".swiper-button-prev"}' data-space-between="{{$expoConfig['mobile']['banner']['space']['header']}}" data-slides-per-view="{{$expoConfig['mobile']['banner']['perview']['header']}}" data-loop="true" class="swiper-container swiper-init swiper-auto-play">
								<div class="swiper-pagination"></div>
								<div class="swiper-wrapper">
                  @foreach( $mobile_banner_header as $banner)
									<div class="swiper-slide @if($banner->banner_class=='_blank') link-external @endif" data-src="/accordion/">

										<a href="{{$banner->url}}" class="link @if($banner->banner_class=='_blank') external @endif" style="width:100%"><img src="{{$banner->getImageUrl()}}" style="width:100%"></a>
									</div>
                  @endforeach
									<!--div class="swiper-slide link-src" data-src="/accordion/" style="background-image: url(https://picsum.photos/600/300);background-size: cover;">
										slide 2
									</div-->
								</div>
                @if( $expoConfig['mobile']['banner']['arrow']['header'] =='on')
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                @endif
							</div>
						</div>
 @endif
 <!-- 배너 -->



						<div class="wrap">
							<div class="new-block-size box">
							  <p class="segmented segmented-strong">
								<button class="button button-active" onClick="changeview('all')">전체</button>
								<button class="button" onClick="changeview('ing')">진행</button>
								<button class="button"  onClick="changeview('pre')">예정</button>
								<button class="button" onClick="changeview('end')">종료</button>
								<span class="segmented-highlight"></span>
							  </p>
							</div>
						</div>
            <div class="wrap mt-0">
              <div class="new-block-size box">
                <div id="search-expo-fail-box">
                  <div>
                    <i class="material-icons">search_off</i>
                  </div>
                  <div>
                    조회된 결과가 없습니다.
                  </div>
                </div>
@foreach( $expo as $row )

                <div class="card demo-card-header-pic expo-card" data-progress="{{$row->getProgressStatus()}}">
                  <a href="/expo/{{$row->expo_code}}" data-transition="f7-cover-v" style="height:100%;background-image:url({{$row->getImageUrl()}})"
                      valign="bottom" class="card-header pl-0 pr-0 pb-0">
                    <div class="expo_over">
                      <div class="expo_over_inner_wrap">
                        <i class="material-icons">remove_red_eye</i>
                        <span class="count_span">{{$row->expoMeta->visitor_count}}</span>
                      </div>
                    </div>
                  </a>
                  <div class="card-content card-content-padding">
                    <a href="/expo/{{$row->expo_code}}"  data-transition="f7-cover-v" class="">
                    <div class="card-expo-title expo-title">{{$row->expo_name}}</div>
                    <div class="card-expo-title expo-opentime">{{$row->expo_open_date->format('Y-m-d')}} ~ {{$row->expo_close_date->format('Y-m-d')}}</div>
                    <div class="card-expo-title expo-location">
                      @if ( empty($row->expo_location) )
                        온라인
                      @else
                        {{$row->expo_location}}
                      @endif
                    </div>
                  </a>
                  </div>
                </div>
@endforeach

              </div>
            </div>


  @if( !empty($mobile_banner_footer) )
						<div class="wrap">
							<div data-pagination='{"el": ".swiper-pagination"}' data-navigation='{"nextEl": ".swiper-button-next","prevEl":".swiper-button-prev"}' data-space-between="{{$expoConfig['mobile']['banner']['space']['footer']}}" data-slides-per-view="{{$expoConfig['mobile']['banner']['perview']['footer']}}" data-loop="true" data-centered-slides="true" class="swiper-container swiper-init swiper-auto-play">
								<div class="swiper-pagination"></div>
								<div class="swiper-wrapper">
                  @foreach($mobile_banner_footer as $banner)
									<div class="swiper-slide link-src @if($banner->banner_class=='_blank') link-external @endif" data-src="{{$banner->url}}">
										<a href="{{$banner->url}}" class="link @if($banner->banner_class=='_blank') external @endif" style="width:100%"><img src="{{$banner->getImageUrl()}}" style="width:100%"></a>
									</div>
                  @endforeach
								</div>
                @if( $expoConfig['mobile']['banner']['arrow']['footer'] =='on')
								<div class="swiper-button-prev"></div>
								<div class="swiper-button-next"></div>
                @endif
							</div>
						</div>
 @endif
@endsection

@section('script')
<script src="/packages/js/expo_routes.js"></script>
<script src="/packages/js/newapp.js"></script>
<script>
function changeview( status ){
  $$("#search-expo-fail-box").hide();
  if( status =='all'){
    var cnt = document.querySelectorAll(".expo-card").length;
    if ( cnt < 1){
      $$("#search-expo-fail-box").show();
    } else $$(".expo-card").fadeIn(100);
  }else {
      var cnt = document.querySelectorAll(".expo-card[data-progress*='" + status +"']").length;
      if ( cnt < 1){
        $$("#search-expo-fail-box").show();
         $$(".expo-card").fadeOut(100);
      }else {
        $$(".expo-card").each( function ( ){
          var datastatus = $$(this).data('progress');
          if( datastatus == status ) $$(this).show();
          else $$(this).fadeOut(100);
        })
      }
  }

}
</script>
@endsection
