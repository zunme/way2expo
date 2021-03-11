@if( $ispage != true )
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#2196f3">
    <meta http-equiv="Content-Security-Policy" content="default-src * 'self' 'unsafe-inline' 'unsafe-eval' data: gap:">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Way2expo</title>

    <link rel="apple-touch-icon" sizes="76x76" href="/image/favicon.png">
    <link rel="icon" href="/image/fav32.png" sizes="32x32" />
    <link rel="apple-touch-icon" href="/image/fav180.png" sizes="180x180" />
    <link rel="icon" href="/image/fav192.png" sizes="192x192" />
    <meta name="msapplication-TileImage" content="/image/fav270.png" />
    <link rel="icon" type="image/png" href="/image/favicon.png">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name=”robots” content=”index”>
    <meta property="og:site_name" content="@yield('meta_site_name', env('APP_NAME') )" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="Url.ToString()">

    <meta property="og:title" content="@yield('meta_title', 'Way2EXPO 온라인 박람회')">
    <meta property="og:image" content="@yield('meta_image', env("DEFAULT_HOST_URL", "https://www.way2expo.com").Config::get('setting.default_image') )">
    <meta property="og:description" content="@yield('meta_description','Way2EXPO 온라인 박람회')">
    <meta name="description" content="@yield('meta_name_description','Way2EXPO 온라인 박람회')">
    <meta name="keywords" content="way2expo,온라인박람회,박람회, @yield('meta_keywords','')">
    @yield('metatag')


	  <!--     Fonts and icons     -->
  	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    <link rel="stylesheet" href="/packages/core/css/framework7.bundle.min.css">
    <link rel="stylesheet" href="/packages/css/newapp.css">
	<link rel="stylesheet" href="/packages/css/default.css">


	<style>
		/* mobile 이 아닐경우 */
		/* 스크롤바 */
		/*
		.scroll-design::-webkit-scrollbar-track
		{
			-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
			background-color: #F5F5F5;
		  border-radius: 10px;
		}

		.scroll-design::-webkit-scrollbar
		{
			width: 6px;
			background-color: #F5F5F5;
		  border-radius: 10px;
		}

		.scroll-design::-webkit-scrollbar-thumb
		{
			background-color: #0976b4;
		  border-radius: 10px;
		}
	*/
	.page-content::-webkit-scrollbar {
	  display: none;
	}
	/* Hide scrollbar for IE, Edge and Firefox */
	.page-content {
	  -ms-overflow-style: none;  /* IE and Edge */
	  scrollbar-width: none;  /* Firefox */
	}
	</style>
  <style>
  section.default-main-footer{
    background-color: #555;
    padding: 20px 10px 0 10px;
    color: white;
    display: flex;
    justify-content: center;
  }
  section.default-main-footer > .default-main-footer-wrap{
    max-width: 400px;
    width: 100%;
  }
  section.default-main-footer * {
    color:white;
  }
  .flex{
    display: flex;
  }
  .flex_center{
    justify-content: center;
  }
  .flex_between{
    justify-content: space-between;;
  }
  .footer-inlinne-item{
    padding-left: 8px;
    padding-right: 8px;
    font-size: 15px;
    font-weight: 500;
    position: relative;
  }
  .footer-inlinne-item:not(:first-child)::before {
      content: "";
      display: block;
      position: absolute;
      top: 5px;
      left: -1px;
      width: 1px;
      height: 10px;
      background-color: #dbe0e8;
  }
  .default-main-footer > .default-main-footer-wrap > .flex.pd-10{
    padding-bottom:10px;
  }
  .default-main-footer > .default-main-footer-wrap > .bottomlile{
    border-bottom-color: rgb(119 118 118 / 47%);
    border-bottom-style: solid;
    border-bottom-width: 1px;
  }
  .default-main-footer .color-gray{
    color: #cecece;
    font-size: 12px;
  }
  .copyright{
    color: #cecece;
    font-size: 12px;
  }
  </style>
	 <link rel="stylesheet" href="/packages/css/test.css">
   @yield('css')

</head>

<body>
    <div id="app">
        <div class="panel panel-left panel-cover panel-resizable panel-init">
            <div class="page">
                <div class="page-content">

					<div class="list links-list">
						<ul>
							<li>
								<a href="/expo" class="link external panel-close">박람회</a>
							</li>
							<li>
								<a  href="/siteinfo" class="panel-close">서비스소개</a>
							</li>
						</ul>
					</div>
@auth
					<div class="block-title">My Company</div>
					<div class="list links-list">
						<ul>
							<li>
								<a href="/accordion/" class="panel-close">참여 박람회</a>
							</li>
							<li>
								<a href="/accordion/" class="panel-close">내 부스</a>
							</li>
						</ul>
					</div>
					<div class="block-title">내 화상회의</div>
					<div class="list links-list">
						<ul>
							<li>
								<a href="/accordion/" class="panel-close">요청받은 화상회의</a>
							</li>
							<li>
								<a href="/accordion/" class="panel-close">신청한 화상회의</a>
							</li>
						</ul>
					</div>
					<div class="block-title">My</div>
					<div class="list links-list">
						<ul>
							<li>
								<a href="/accordion/" class="panel-close">내 정보</a>
							</li>
							<li>
								<a href="/accordion/" class="panel-close">비밀번호변경</a>
							</li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" class="menu-dropdown-link menu-close"
                        onclick="event.preventDefault();
                        this.closest('form').submit();">
                        {{ __('Logout') }}
                    </a>
                </form>
              </li>
						</ul>
					</div>
@endauth
@guest
					<div class="login-btn-box">
						<a href="/login" class="external col button button-raised button-fill">로그인</a>
					</div>
@endguest

                </div>
            </div>
        </div>
        <div class="panel panel-right panel-reveal panel-resizable panel-init">
            <div class="view view-init view-right" data-name="right" data-url="/">
                <div class="page">
                    <div class="navbar">
                        <div class="navbar-bg"></div>
                        <div class="navbar-inner sliding">
                            <div class="title">Right Panel</div>
                        </div>
                    </div>
                    <div class="page-content">

                    </div>
                </div>
            </div>
        </div>
        <div class="view view-main view-init safe-areas" data-master-detail-breakpoint="800" data-url="/expo">

@endif
<!-- ispage -->
            <div class="page page-home">


                <div class="navbar navbar-large navbar-transparent">
                    <div class="navbar-bg"></div>
                    <div class="navbar-inner">
                        <div class="left">
                            <a href="#" class="link">
                                <img class="navbar-logo-img" src="/image/logo/logo-way2expo.svg" />
                            </a>
                        </div>
                        <div class="title"></div>
                        <div class="right">
              							<a href="#" class="link icon-only panel-open menu-icon" data-panel="left">
              								<i class="icon material-icons">menu</i>
                            </a>
                        </div>
                    </div>
                </div> <!-- navbar -->

                <div class="page-content page-none-padding-top">
          					<section class="default-main-page">
          @section('main-header')
          						<div class="top-img-header  header-filter border-radius" filter-color="logocolor4" style="background-image: url(https://picsum.photos/600/350);">
          							<div class="top-img-title">
          								<p>
          									WAY2EXPO
          								</p>
          							</div>
          						</div>
          @show
          @yield('body')
          					</section>
                  <!-- footer -->
                  @include('mobile.footer')
                  <!-- / footer -->



                </div><!--  /page-content-->
            </div><!-- /page -->


@if( $ispage != true )
        </div><!-- / view -->
    </div><!-- / app -->
    @yield('page-after')
	<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
	<script>
	var $$ = jQuery.noConflict();
	</script>

  <script src="/packages/core/js/framework7.bundle.js"></script>
  <script>
  $$(function() {
      $$.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
         }
      });
    })
    function ajaxError(jqXHR ){
      if( jqXHR.status == 401){
        app.dialog.confirm('로그인이 필요한 서비스입니다<br>로그인 하시겠습니까?','Way2Expo', function () {
          location.href="/login"
        });
        return;
      }
    }
    </script>
  </script>
  @yield('script')

</body>

</html>
@endif <!-- ispage -->
