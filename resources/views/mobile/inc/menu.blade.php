<template>
<div class="panel panel-left panel-cover">
	<div class="view">
		<div class="page">
			<div class="page-content">

			  <div class="list links-list">
				<ul>
				  <li class="mainmenu-li-home">
					<a href="/" class="link panel-close external">Way2Expo</a>
				  </li>					
				  <li class="mainmenu-li-expo">
					<a href="/expo" class="link panel-close external">박람회</a>
				  </li>
				  <li  class="mainmenu-li-service">
					<a href="/siteinfo" class="panel-close">서비스소개</a>
				  </li>
				</ul>
			  </div>
          @auth
          @if( $user->company_id > 0 )
          <div class="block-title mainmenu-title-company">My Company</div>
          <div class="list links-list">
            <ul>
              <li  class="mainmenu-li-myexpo">
                <a href="/m/myexpo" class="panel-close">참여 박람회</a>
              </li>
				<!--li  class="mainmenu-li-service">
					<a href="/m/myproduct" class="panel-close">상품관리</a>
				</li-->
              <li class="mainmenu-li-mycompany">
                <a href="/m/company" class="panel-close">회사 정보</a>
              </li>
			
            </ul>
          </div>
          @endif
  
          <div class="block-title mainmenu-title-my">My</div>
          <div class="list links-list">
            <ul>
              <li class="mainmenu-li-myinfo">
                <a href="/m/myinfo" class="panel-close">내 정보</a>
              </li>
			  <li class="mainmenu-li-myinfo">
                <a href="/m/mycardinfo" class="panel-close">명함관리</a>
              </li>
              <!--li>
                <a href="#" class="panel-close" onClick="openSwipe()">비밀번호변경</a>
              </li-->
              <li  class="mainmenu-li-mycardexchange">
                <a href="/m/cardexchange" class="panel-close">비즈니스문의</a>
              </li>
              <li class="mainmenu-li-meeting_send">
                <a href="/m/meeting/send" class="panel-close">신청한 1:1 화상회의</a>
              </li>	
              @if( $user->company_id > 0 )
              <li  class="mainmenu-li-meeting_reserve">
                <a href="/m/meeting/receive" class="panel-close">요청받은 1:1 화상회의</a>
              </li>
              @endif					
              <li class="mainmenu-li-myfavorite">
                <a href="/m/favorite" class="panel-close">즐겨찾기</a>
              </li>
			  <li class="mainmenu-li-myfavoriteproduct">
                <a href="/m/favorite/product" class="panel-close">찜</a>
              </li>
				
              <li  class="mainmenu-li-seenexpo">
                <a href="/m/history/expo" class="panel-close">내가 본 박람회</a>
              </li>
              <li class="mainmenu-li-seenbooth">
                <a href="/m/history/booth" class="panel-close">내가 본 부스</a>
              </li>
              <li  class="mainmenu-li-logout">
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
            <a href="/m/login" class=" col button button-raised button-fill link panel-close">로그인</a>
          </div>
          @endguest

        </div>
			
		</div>
	</div>
</div>
</template>
