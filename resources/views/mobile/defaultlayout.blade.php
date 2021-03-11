<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, viewport-fit=cover">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta http-equiv="Content-Security-Policy" content="default-src * 'self' 'unsafe-inline' 'unsafe-eval' data: gap:">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="theme-color" content="#9fb9bf">

  <title>Way2expo</title>
  <link rel="manifest" href="/manifest.webmanifest">
  <link rel="apple-touch-icon" sizes="76x76" href="/image/favicon.png">
  <link rel="icon" href="/image/fav32.png" sizes="32x32" />
  <link rel="apple-touch-icon" href="/image/fav180.png" sizes="180x180" />
  <link rel="icon" href="/image/fav192.png" sizes="192x192" />
  <meta name="msapplication-TileImage" content="/image/fav270.png" />
  <link rel="icon" type="image/png" href="/image/favicon.png">

  <meta name=”robots” content=”index”>
  <meta property="og:site_name" content="@yield('meta_site_name', env('APP_NAME') )" />
  <meta property="og:type" content="website" />

  @if( empty($meta) )
  <meta property="og:title" content="Way2EXPO 온라인 박람회">
  <meta property="og:image" content="{{\URL::to('/image/bg-logo-poster.png')}}">
  <meta property="og:description" content="Way2EXPO 온라인 박람회">
  <meta name="description" content="Way2EXPO 온라인 박람회">
  <meta name="keywords" content="way2expo,온라인박람회,박람회, @yield('meta_keywords','')">
  <meta property="og:url" content="{{\URL::to( '/' )}}">
  @else
  <meta name="description" content="{{$meta->description}}" />
  <meta property="og:title" content="{{$meta->title}}" />
  <meta property="og:description" content="{{$meta->description}}" />
  <meta property="og:image" content="{{$meta->image}}" />
  <meta property="og:url" content="{{$meta->url}}" />
  <meta name="keywords" content="way2expo,온라인박람회,박람회, @yield('meta_keywords','')">
  @endif

  <meta property="og:locale" content="ko_KR" />
  <meta name="twitter:card" content="summary_large_image" />

  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

  <link rel="stylesheet" href="/packages/core/css/framework7.bundle.min.css">

  <link rel="stylesheet" href="{{ mix('/css/mobile.css') }}">
  <link rel="stylesheet" href="/assets/css/mobile.custom.css">
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-NQME7X9GGX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
</script>

  <style>

    .page-content::-webkit-scrollbar {
      display: none;
    }
	  .login-screen-page.modal-in{
		  z-index:60000;
	  }
	  
	  
  </style>
  @yield('css')
  <script>
    var csrftoken = "{{ csrf_token() }}";
	  var loaded = false;

  </script>
	<script src="{{ mix('/js/mobile_route.js') }}"></script>
</head>

<body>
  <div id="app">
    <div class="panel panel-left panel-cover panel-resizable panel-init">
      <div class="page">
        <div class="page-content">

          <div class="list links-list">
            <ul>
              <li>
                <a href="/expo" class="link panel-close">박람회</a>
              </li>
              <li>
                <a href="/siteinfo" class="panel-close">서비스소개</a>
              </li>
            </ul>
          </div>
          @auth
          @if( $user->company_id > 0 )
          <div class="block-title">My Company</div>
          <div class="list links-list">
            <ul>
              <li>
                <a href="/m/myexpo" class="panel-close">참여 박람회</a>
              </li>
              <li>
                <a href="/m/company" class="panel-close">회사 정보</a>
              </li>
            </ul>
          </div>
          @endif
          <div class="block-title">내 화상회의</div>
          <div class="list links-list">
            <ul>
              @if( $user->company_id > 0 )
              <li>
                <a href="/m/meeting/receive" class="panel-close">요청받은 화상회의</a>
              </li>
              @endif
              <li>
                <a href="/m/meeting/send" class="panel-close">신청한 화상회의</a>
              </li>
            </ul>
          </div>
          <div class="block-title">My</div>
          <div class="list links-list">
            <ul>
              <li>
                <a href="/m/myinfo" class="panel-close">내 정보</a>
              </li>
              <!--li>
                <a href="#" class="panel-close" onClick="openSwipe()">비밀번호변경</a>
              </li-->
              <li>
                <a href="/m/cardexchange" class="panel-close">받은 명함</a>
              </li>
              <li>
                <a href="/m/favorite" class="panel-close">즐겨찾기</a>
              </li>
              <li>
                <a href="/m/history/expo" class="panel-close">내가 본 박람회</a>
              </li>
              <li>
                <a href="/m/history/booth" class="panel-close">내가 본 부스</a>
              </li>
              <li>
                <form method="POST" action="/logout">
                  @csrf
                  <a href="/logout" class="menu-dropdown-link menu-close" onclick="event.preventDefault();
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
            <a href="/login" class=" col button button-raised button-fill link panel-close">로그인</a>
          </div>
          @endguest

        </div>
      </div>
    </div>
    <div class="panel panel-right panel-reveal panel-resizable panel-init">
     
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
    <div class="view view-main view-init safe-areas" data-master-detail-breakpoint="800" data-url="/expo">

      @yield('body')

      <div class="popup app-swipe-handler default-swipe-hancler">
        <div class="page">
          <div class="swipe-handler"></div>
          <div class="page-content">
            <div class="block-title" style="text-align: center;
                    font-size: 19px;
                    font-weight: 600;
                    margin-bottom: 20px;
                    line-height: 19px;">패스워드 변경</div>
            <div class="block">
              <form id="changepwdform">
                <div class="list no-hairlines-md">
                  <ul>
                    <li class="item-content item-input item-input-outline">
                      <div class="item-text-line">
                        현재 비밀번호
                      </div>
                      <div class="item-inner">
                        <div class="item-title item-floating-label">Password</div>
                        <div class="item-input-wrap">
                          <input type="password" name="current_password" placeholder="Your password" class="">
                          <span class="input-clear-button"></span>
                        </div>
                      </div>
                    </li>
                    <li class="item-content item-input item-input-outline">
                      <div class="item-text-line">
                        변경할 비밀번호
                      </div>
                      <div class="item-inner">
                        <div class="item-title item-floating-label">Password</div>
                        <div class="item-input-wrap">
                          <input type="password" name="password" placeholder="Your password" class="">
                          <span class="input-clear-button"></span>
                        </div>
                      </div>
                    </li>
                    <li class="item-content item-input item-input-outline">
                      <div class="item-text-line">
                        비밀번호 확인
                      </div>
                      <div class="item-inner">
                        <div class="item-title item-floating-label">Password</div>
                        <div class="item-input-wrap">
                          <input type="password" name="password_confirmation" placeholder="Your password" class="">
                          <span class="input-clear-button"></span>
                        </div>
                      </div>
                    </li>
                    <li class="item-content item-input item-input-outline"
                      style="justify-content: center;padding:20px 15px;">
                      <a href="#" class="button button-fill" onClick="changePwd()">비밀번호변경</a>
                    </li>
                  </ul>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div><!-- / view -->	  
  </div><!-- / app -->
	
<canvas id="canvas"></canvas>
  @yield('page-after')
  <script>
    @auth
    let isLogined = true;
    @endauth
    @guest
    let isLogined = false;
    @endguest
  </script>

<script>
    var snsDefaultImage = '{{ \URL::to( Config::get('expo.default_image') ) }}';
    var snsDefaultUrl = '{{ \URL::to('/')}}';
    var temptest;
    let global_noti_cnt =0;
    let remon;
	var booth_live = {}
	var liveontemplate=null;	
</script>
  <script src="/assets/js/mobile.js"></script>
  <script src="{{ mix('/js/mobile_bootstrap.js') }}"></script>
  

  <script src="/packages/js/kakao.min.js"></script>
  <script src="/packages/js/sns.js"></script>
  <script src="/packages/core/js/framework7.bundle.js"></script>
	
  <script src="{{ mix('/js/mobile_app.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/@remotemonster/sdk/remon.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js" integrity="sha512-UXumZrZNiOwnTcZSHLOfcTs0aos2MzBWHXOHOuB0J/R44QB0dwY5JgfbvljXcklVf65Gc4El6RjZ+lnwd2az2g==" crossorigin="anonymous"></script>
	
	<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
	
  <script>
    var myexpoDB = new PouchDB('expolist');
    var myBootmDB = new PouchDB('boothlist');
	  
    @if ( !empty($user->id) )
	  Echo.private('noti.{{$user->id}}')
		.listen('NotiEvent', (e) => {
			noti(e.data.title, e.data.content)
			++global_noti_cnt;
			$$(".noti-cnt").each( function () {
			  $$(this).text ( global_noti_cnt );
			})
		});
	 @if ( $user->company_id > 0 )
	  const beamsClient = new PusherPushNotifications.Client({
		instanceId: '{{\Config::get('beam.id')}}',
	  });

	  beamsClient.start()
	  	.then(beamsClient => beamsClient.getDeviceId())
		.then(deviceId =>
		  console.log('Successfully registered')
		 )
		.then(() => beamsClient.addDeviceInterest('company_{{$user->company_id}}'))
		.then(() => console.log(''))
		.catch(console.error);	  
	  @endif
    @endif
  
    Kakao.init('{{ Config::get('expo.kakaokey') }}');

  
     setInterval(refreshToken, 1000 * 60 * 10);

    function reloadcurrent( ){
      let url = app.views.main.router.currentRoute.url;
      if ( url =='/login') {
        let his = app.views.main.router.history
        url = his[ his.length-2 ];
        app.views.main.router.back();
      }
      window.location.replace( url );
      return;
      $$(".page.page-previous").remove();
      app.views.main.router.navigate( url , {ignoreCache  : true,
          reloadCurrent : true
      });
    }
    function fnHistoryBack(){
      app.views.main.router.back()
    }
    function changePwd(){
      $$.ajax({
         url:"/user/password",
         method:"PUT",
         dataType:'json',
         data:$$("#changepwdform").serialize(),
         success:function(res)
         {
           toastmessage('변경되었습니다.')
           globalPopMy.close();
         },
         error: function ( err ){
           ajaxError(err);
         }
       });
    }
    
    function custClick(t){
      let key = $$(t).data("key")
      $(document).trigger('mbclick', {target : t, key : key, name : $$(t).data("name") } );
    }
	let remon_default_cfg = {
		credential: {key: "{{\Config::get('remotemonster.key')}}", serviceId: "{{\Config::get('remotemonster.serviceId')}}"},
		view: {local: '#dummy', remote: '#dummy'},
		media: {audio: false, video: false}
	};
	
	let booth_live_remon = new Remon({config: remon_default_cfg});
	setInterval(async function () {
		fnBoothLiveCheck();
	}, 5000);	
	setInterval(async function () {
		fnliveBoothRedraw();
	}, 30000);
	fnBoothLiveCheck();

	if(liveontemplate!=null) fnLiveOnBoothprc(booth_live,booth_live , {});
	  
	Template7.registerHelper('diffday', function (startday, endday, options) {
		var text = ['예정','진행중','종료']
		if ( moment().diff(moment(startday),"days") < 0 ) return text[0];
		else if ( moment().diff(moment(endday),"days") > 0 ) return text[2];
		else return text[1];
		
	});
	Template7.registerHelper('numberformat', function (num){
		return new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(num)
	});
  Template7.registerHelper('dateOnlyformat', function (time){
    return new Date(time).format('yyyy-MM-dd');
  });
  Template7.registerHelper('nl2br', function (value){
    return value.replace(/\n/g, '<br>')
  });	  
	var etcEvents = new Framework7.Events();
	function boothlistpaging(page){
		etcEvents.emit( 'page',{page:page})
	}
	function expoprdlistpaging (page){
		etcEvents.emit( 'expo_prd_page',{page:page})
	}
	function boothprdlistpaging (page){
		etcEvents.emit( 'booth_prd_page',{page:page})
	}
	function myprdreload (){
		etcEvents.emit( 'my_prd_list_reload',{page:0})
	}
	  
	function expofavorite (expo_id, isFavorite){
		etcEvents.emit( 'expo_favorite_change',{expo_id:expo_id, isFavorite : isFavorite})
	}
	function boothfavorite (booth_id, isFavorite){
		etcEvents.emit( 'booth_favorite_change',{booth_id:booth_id, isFavorite : isFavorite})
	}
	function productfavorite (product_id, isFavorite){
		etcEvents.emit( 'product_favorite_change',{product_id:product_id, isFavorite : isFavorite})
	}
	  
  </script>
  @yield('script')

	@verbatim
	<script id="liveonbooth-mainhome" type="text/template">
      <div class="item_liveonbooth booth_{{id}}" data-id="booth_{{id}}">
        <a href="/expo/{{expo_booth.expo_code}}/{{id}}">
          <div class="item_liveonbooth-wrap">
            <div class="item_liveonbooth-img liveimgbg" data-id="booth_{{id}}" data-channel="{{channel}}"  style="background-image: url({{liveimg}});">
            </div>
            <div>
              <div class="item_liveonbooth-title">{{booth_title}}</div>
            </div>

          </div>
        </a>
      </div>	
	</script>
	@endverbatim
	<script>
		loaded = true;
	</script>
</body>
	
</html>