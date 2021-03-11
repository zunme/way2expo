<section class="default-main-footer">
  <div class="default-main-footer-wrap">
    <div class="flex flex_center">
      <a href="/siteinfo" data-transition="f7-cover" class="footer-inlinne-item">서비스소개</a>
      <a href="/m/notice" data-transition="f7-circle" class="footer-inlinne-item">공지사항</a>
    </div>
    <div class="flex flex_center pd-10">
      <a href="#" class="footer-inlinne-item popup-open" data-popup=".popup-terms">이용약관</a>
      <a href="#" class="footer-inlinne-item popup-open" data-popup=".popup-privacy">개인정보처리방침</a>
    </div>
    <div class="flex flex_between pd-10 bottomlile">
      <h2>Way2EXPO</h2>
      <address style="padding-top: 15px;" class="color-gray">
                인천 서구 마중 5로 17 | 대표 유원식<br>
                사업자등록번호 131-86-30990
      </address>
    </div>
    <div class="flex flex_between mt-10 pd-10">
      <div>
                <div style="font-size:16px;font-weight:600;">고객센터</div>
                <div class="color-gray">운영시간 : 08:30 ~ 17:30(평일)</div>
                <div class="color-gray">점심시간 : 12:00 ~ 13:00</div>
      </div>
      <div>
        <a href="tel:15778764" class="external"><h2 style="margin-bottom: 0px;
    margin-top: 7px;
    font-size: 20px;
    text-align: right;">1577-8764</h2></a>
        <a href="mailto:{{$expoConfig['email']}}" class="external" style="color: #e0e0e0;">{{$expoConfig['email']}}</a>
      </div>
    </div>

    <div class="flex" style="justify-content:flex-end;">
      <p class="copyright" >
        Copyright 2020 way2expo co.ltd. All rights reserved
      </p>
    </div>
  </div>
</section>
<!-- popup -->
<div class="popup popup-terms">
  <div class="page">
    <div class="navbar">
      <div class="navbar-bg"></div>
      <div class="navbar-inner">
        <div class="title">이용약관</div>
        <div class="right"><a href="#" class="link popup-close" style="color:black">Close</a></div>
      </div>
    </div>
    <div class="page-content">
      <div class="block">
        @include('termsofuse')
      </div>
    </div>
  </div>
</div>
<div class="popup popup-privacy">
  <div class="page">
    <div class="navbar">
      <div class="navbar-bg"></div>
      <div class="navbar-inner">
        <div class="title">개인정보처리방침</div>
        <div class="right"><a href="#" class="link popup-close" style="color:black">Close</a></div>
      </div>
    </div>
    <div class="page-content">
      <div class="block">
        @include('privacypolicy')
      </div>
    </div>
  </div>
</div>
<!-- / popup -->
