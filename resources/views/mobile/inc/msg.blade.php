<html lang="ko" class="md device-pixel-ratio-3 device-desktop device-windows"><head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, viewport-fit=cover">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta http-equiv="Content-Security-Policy" content="default-src * 'self' 'unsafe-inline' 'unsafe-eval' data: gap:">
  <meta name="csrf-token" content="vPUx1av2RUrPHuuxCbxEbHUTOHDwy7UZ0yBuklTa">
  <meta name="theme-color" content="#9fb9bf">

  <title>Way2expo</title>
  <link rel="manifest" href="/manifest.webmanifest">
  <link rel="apple-touch-icon" sizes="76x76" href="/image/favicon.png">
  <link rel="icon" href="/image/fav32.png" sizes="32x32">
  <link rel="apple-touch-icon" href="/image/fav180.png" sizes="180x180">
  <link rel="icon" href="/image/fav192.png" sizes="192x192">
  <meta name="msapplication-TileImage" content="/image/fav270.png">
  <link rel="icon" type="image/png" href="/image/favicon.png">

  <meta name="”robots”" content="”index”">
  <meta property="og:site_name" content="Laravel">
  <meta property="og:type" content="website">

    <meta property="og:title" content="Way2EXPO 온라인 박람회">
  <meta property="og:image" content="https://murflim.run.goorm.io/image/bg-logo-poster.png">
  <meta property="og:description" content="Way2EXPO 온라인 박람회">
  <meta name="description" content="Way2EXPO 온라인 박람회">
  <meta name="keywords" content="way2expo,온라인박람회,박람회, ">
  <meta property="og:url" content="https://murflim.run.goorm.io">
  
  <meta property="og:locale" content="ko_KR">
  <meta name="twitter:card" content="summary_large_image">
<!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

  <link rel="stylesheet" href="/packages/core/css/framework7.bundle.min.css">
  <!--
    <link rel="stylesheet" href="/packages/css/newapp.css">
	  <link rel="stylesheet" href="/packages/css/default.css">
    <link rel="stylesheet" href="/packages/css/test.css">
    -->
  <link rel="stylesheet" href="{{ mix('/css/mobile.css') }}">
</head>

<body>
  <div id="app" class="framework7-root">
    <div class="view view-main view-init safe-areas" data-master-detail-breakpoint="800">
      <div class="page page-home page-current page-with-navbar-large">
          <div class="page-content page-none-padding-top">
            <div class="error_msg_wrap">
              
              <div class="error_msg_inner">
                <div class="error_msg">
                  {{$msg}}    
                </div>
                <div class="error_msg_goto">
                  <a href="/" class="error_msg_goto_link">
                    <i class="material-icons">home</i>
                  </a>
                </div>
              </div>
              
            </div>
          </div><!--  /page-content-->
      </div><!-- /page -->
    </div><!-- / view -->	  
  </div><!-- / app -->
</body></html>