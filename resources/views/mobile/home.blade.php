<div class="page page-home">


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
				
				<a class="link icon-only searchbar-enable" data-searchbar=".searchbar-components">

					<i class="icon material-icons">search</i>
				</a>
				<!-- <a href="#" class="link icon-only panel-open" data-panel="left"> -->
                <a href="/m/menu" class="link icon-only">
                  <i class="icon material-icons">menu</i>
                </a>
            </div>
			
			<form class="searchbar searchbar-expandable searchbar-components searchbar-init" data-bar=".searchbar-components">
				<div class="searchbar-inner">
					<div class="searchbar-input-wrap">
						<input type="search" id="globalsearchstr" onKeyUp="globalsearchkey(this)" placeholder="검색어를 입력해주세요">
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
							<a href="#" onClick="globalsearch('globalsearchstr')">
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
          filter-color="lightdust"
          style="background-image: url({{$header_image->getImageUrl()}});
            ">
          <div class="top-img-title">
            <p>
              {{$header_image->alt}}
            </p>
          </div>
        </div>
        @if( !empty($mobile_banner_header) )
          <div class="default-wrap default-size-box default_bg">
            <div class="block-title title-font">추천 박람회</div>
            <div class="wrap">
               @include('mobile.inc.banner', ['banners'=>$mobile_banner_header
                        , 'banner_config'=> [
                              'between'=> $expoConfig['mobile']['banner']['space']['header'],
                              'perView'=> $expoConfig['mobile']['banner']['perview']['header'],
                              'arrow'=> $expoConfig['mobile']['banner']['arrow']['header'],
                              'class' => '',
                    ] ])
            </div>
          </div>
        @endif		  
		  
<div class="default-wrap default-size-box default_bg elevation-2" style="background-color: rgb(6 18 32 / 89%);">

    <div class="block-title title-font" style="color:white">
      LIVE EXPO NOW
    </div>

  <div class="booth_liveon_inner_wrap mainhome-liveon">
    <div class="booth_liveon_inner">
		
		
		
		@foreach( $vods as $vod)
		<div class="item_liveonbooth">
			<a href="{{$vod->mov_url}}" class="external" target="_blank">
			  <div class="item_liveonbooth-wrap">
				<div class="item_liveonbooth-img livevod" style="background-image: url({{$vod->img_url}});">
				</div>
				<div>
				  <div class="item_liveonbooth-title">{{$vod->title}}</div>
				</div>

			  </div>
			</a>
		</div>
		@endforeach
		
		
		
    </div>
    <div class="booth_liveon_inner_empty">
      진행중인 라이브가 없습니다.
    </div>
  </div>
</div>
		  
		  


	
        <div class="default-wrap default-size-box default_bg elevation-2" style="background-color: rgb(6 18 32 / 89%);">
          <a href="/expo">
            <div class="block-title title-font chevronicon" style="color:white">진행중인 박람회</div>
          </a>

          <div class="row home-expo-card-row"
            style="
            background-color: rgb(255 255 255 / 25%);
            border-top: 1px solid rgb(255 255 255 / 36%);
            ">
            @forelse ( $expos as $exporow )
              <div class="col-50 home-expo-card-row-col elevation-0">
                  <a href="/expo/{{$exporow->expo_code}}">
                      <div class="home-expo-card-header-img background-pos-top"
                        style="background-image: url({{$exporow->getImageUrl()}});
                      ">
                      </div>
                      <div class="home-expo-card-body">
                          <div class="bottom-line">
                              <div>{{$exporow->expo_name}}</div>
                              <div>{{$exporow->expo_open_date->format('Y-m-d')}}~{{$exporow->expo_close_date->format('Y-m-d')}}</div>

                          </div>

                      </div>
                  </a>
              </div>
           @empty
           <div class="col-100" style="margin-right:8px">
             <div class="home-card-none-col">
               현재 진행중인 박람회가 없습니다.
             </div>
           </div>
           @endforelse
          </div>

        </div>

@if ( isset( $site_config['m_banner_booth_area']) )		  
		  {!! $site_config['m_banner_booth_area']->val !!}
@endif		  
@if ( isset( $site_config['m_banner_prd_area']) )		  
		  {!! $site_config['m_banner_prd_area']->val !!}
@endif		  
		  
		  
        <div class="default-wrap default-size-box default_bg elevation-2" style="background-color: rgb(0 0 0 / 71%);">
          <a href="/expo">
            <div class="block-title title-font chevronicon" style="color:white">모집중인 박람회</div>
          </a>

          <div class="row home-expo-card-row"
            style="
            background-color: rgb(255 255 255 / 25%);
            border-top: 1px solid rgb(255 255 255 / 36%);
            ">
            @forelse ( $recruting as $exporow )
              <div class="col-50 home-expo-card-row-col elevation-0">
                  <a href="/expo/{{$exporow->expo_code}}">
                      <div class="home-expo-card-header-img background-pos-top"
                        style="background-image: url({{$exporow->getImageUrl()}}">
                      </div>
                      <div class="home-expo-card-body">
                          <div class="bottom-line">
                              <div>{{$exporow->expo_name}}</div>
                              <div>{{$exporow->expo_open_date->format('Y-m-d')}}~{{$exporow->expo_close_date->format('Y-m-d')}}</div>
                          </div>

                      </div>
                  </a>
              </div>
           @empty
           <div class="col-100" style="margin-right:8px">
             <div class="home-card-none-col">
               현재 모집중인 박람회가 없습니다.
             </div>
           </div>
           @endforelse
          </div>

        </div>

      </section>
      <!-- footer -->
      @include('mobile.footer')
      <!-- / footer -->


    </div><!--  /page-content-->
</div><!-- /page -->
