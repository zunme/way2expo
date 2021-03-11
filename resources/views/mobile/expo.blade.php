<div class="page page-expo">


    <div class="navbar navbar-large navbar-transparent">
        <div class="navbar-bg"></div>
        <div class="navbar-inner">
            <div class="left">
                <a href="/" class="link external">
                    <img class="navbar-logo-img" src="/image/logo/logo-way2expo.svg" />
                </a>
            </div>
            <div class="title"></div>
            <div class="right">
              <a href="/m/notilist" class="link icon-only">
                <i class="icon material-icons md-only">notifications
                  <span class="badge color-red noti-cnt">{{empty($notiCount)?'0': $notiCount}}</span>
                </i>
              </a>
				
				<a class="link icon-only searchbar-enable" data-searchbar=".searchbar-components2">

					<i class="icon material-icons">search</i>
				</a>
				
                <a href="/m/menu" class="link icon-only">
                  <i class="icon material-icons">menu</i>
                </a>
            </div>
			
			<form class="searchbar searchbar-expandable searchbar-components2 searchbar-init" data-bar=".searchbar-components2">
				<div class="searchbar-inner">
					<div class="searchbar-input-wrap">
						<input type="search" id="globalsearchstr2" onKeyUp="globalsearchkey(this)" placeholder="검색어를 입력해주세요">
						<i class="searchbar-icon"></i>
						<span class="" style="
  	transition-duration: .1s;
	position: absolute;
	top: 50%;
	border: none;
	padding: 0;
	margin: 0;
	outline: 0;
	z-index: 1;
	cursor: pointer;
	background: 0 0;
	opacity: 1;
	pointer-events: auto;
	visibility: visible;
	width: 48px;
	height: 48px;
	right: 0;
	margin-top: -16px;
											  ">
							<a href="#" onClick="globalsearch('globalsearchstr2')">
								<i class="icon material-icons" style="color:black">search</i>
							</a>
						</span>
						<!--span class="input-clear-button"></span-->
					</div>
					
					<span class="searchbar-disable-button if-not-aurora">Cancel</span>
				</div>
			</form>
			
			
        </div>
    </div> <!-- navbar -->
	
    <div class="page-content page-none-padding-top">
		<div class="searchbar-backdrop"></div>
        <section class="default-main-page">

          <div class="top-img-header  header-filter border-radius {{$expoConfig['mobile']['expo_title_size']}}"
            filter-color="{{$expoConfig['mobile']['expo_title_filter']}}"
            style="background-image: url(/image/bg-logo-poster.png);">
            <div class="top-img-title">
              <p>
                박람회
              </p>
            </div>
          </div>


<!-- body -->
<!-- 배너 -->
@if( !empty($mobile_banner_header) )
          <div class="wrap">
 @include('mobile.inc.banner', ['banners'=>$mobile_banner_header
          , 'banner_config'=> [
                'between'=> $expoConfig['mobile']['banner']['space']['header'],
                'perView'=> $expoConfig['mobile']['banner']['perview']['header'],
                'arrow'=> $expoConfig['mobile']['banner']['arrow']['header'],
                'class' => '',
      ] ])
          </div>
@endif
<!-- 배너 -->



          <div class="wrap">
            <div class="new-block-size box">
              <p class="segmented segmented-strong">
              <button class="button 
                @if ( $active == 'all') 
                button-active 
                @endif" onClick="changeview('all')">전체</button>
              <button class="button 
                @if( $active == 'ing') 
                  button-active 
                @endif" onClick="changeview('ing')">진행</button>
              <button class="button"  onClick="changeview('pre')">예정</button>
              <button class="button" onClick="changeview('end')">종료</button>
              <span class="segmented-highlight"></span>
              </p>
            </div>
          </div>
          <div class="wrap mt-0">
            <div class="new-block-size box">
              <div id="search-prc-expo-fail-box" class="search-prc-expo-fail-box">
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
                    valign="bottom" class="card-header expo_main_card_header pl-0 pr-0 pb-0">
                  <div class="expo_over hide">
                    <div class="expo_over_inner_wrap">
                      <i class="material-icons">remove_red_eye</i>
                      <span class="count_span">{{$row->expoMeta->visitor_count}}</span>
                    </div>
                  </div>
                </a>
                <div class="card-content card-content-padding">
                  <a href="/expo/{{$row->expo_code}}"  data-transition="f7-cover-v" class="">
				  <div class="card-expo-title expo-progress">
					  @if ( $row->getProgressStatus() == 'ing')
					  [진행중]
					  @elseif ( $row->getProgressStatus() == 'pre')
					  [예정]
					  @else 
					  [종료]
					  @endif
				  </div>	  
                  <div class="card-expo-title expo-title">{{$row->expo_name}}</div>
                  <div class="card-expo-title expo-opentime">{{$row->expo_open_date->format('Y-m-d')}} ~ {{$row->expo_close_date->format('Y-m-d')}}</div>
                  <!--div class="card-expo-title expo-location">
                    @if ( empty($row->expo_location) )
                      온라인
                    @else
                      {{$row->expo_location}}
                    @endif
                  </div-->
                </a>
                </div>
              </div>
@endforeach

            </div>
          </div>

<!-- 배너 -->
@if( !empty($mobile_banner_footer) )
          <div class="wrap">
 @include('mobile.inc.banner', ['banners'=>$mobile_banner_footer
          , 'banner_config'=> [
                'between'=> $expoConfig['mobile']['banner']['space']['footer'],
                'perView'=> $expoConfig['mobile']['banner']['perview']['footer'],
                'arrow'=> $expoConfig['mobile']['banner']['arrow']['footer'],
      ] ])
          </div>
@endif

        </section>
      <!-- footer -->
      @include('mobile.footer')
      <!-- / footer -->


    </div><!--  /page-content-->
</div><!-- /page -->
