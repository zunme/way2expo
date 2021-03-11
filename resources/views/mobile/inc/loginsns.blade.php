<template>
  <div class="page page-booth" data-name="loginsns">
    <div class="navbar navbar-new">
      <div class="navbar-bg"></div>
      <div class="navbar-inner sliding">
        <div class="left">
        </div>
        <div class="title">카카오 계정 연결</div>
        <div class="right">
          <a href="/m/notilist" class="link icon-only">
            <i class="icon material-icons md-only">notifications
              <span class="badge color-red noti-cnt">0</span>
            </i>
          </a>
          <!--a href="#" class="link icon-only panel-open menu-icon"  style="margin-left:12px;" data-panel="left"-->
			<a href="/m/menu" class="link icon-only menu-icon">
            <i class="icon material-icons">menu</i>
          </a>
        </div>
      </div>
    </div>
    <div class="page-content">

<div class="login-screen-title">
        <div class="login-brand">
          <img src="/image/fav180.png" alt="logo" width="100" class="shadow-light ">
        </div>
        <div class="snslogin-title1">
          SNS 계정연결 안내
        </div>
		<div class="snslogin-title2">
          Way2Expo 계정에 연결해주세요
        </div>
		<div class="snslogin-title3">
          	<div class="snslogin-title3-sub">
			  기존회원이라면 로그인하여 <span>최초 1회</span> 연결 이후 간편하게 이용 가능합니다.
			</div>
			<div class="snslogin-title3-sub">
			  sns 계정연결은 로그인 후 마이페이지에서도 할 수 있습니다.
			</div>
        </div>
      </div>		
		
		
		
	<form id="loginsns-form">
        <div class="card card-primary">
              <!--div class="card-header"><h4>카카오 계정 연결</h4></div-->

              <div class="card-body">
                <div class="list">
                  <ul>
                    <li class="item-content item-input">
                      <div class="item-inner">
                                              <div class="item-title item-label with-padding">이메일</div>
                                              <div class="item-input-wrap">
                                                <input type="email" name="email" placeholder="Email을 입력해주세요" class="" >
                                                <span class="input-clear-button"></span>
                                              </div>
                                            </div>
                    </li>
                    <li class="item-content item-input">
                      <div class="item-inner">
                        <div class="display-flex justify-content-space-between">
                          <div class="item-title item-label with-padding">비밀번호</div>
                          <!--div class="item-title item-label with-padding" style="width: auto;"><a href="/forgot-password" class="external">비밀번호찾기</a></div-->
                        </div>
                        <div class="item-input-wrap">
                          <input type="password" name="password" autocomplete="current-password" placeholder="비밀번호를 입력해주세요" id="demo-password-2"  required="">
                          <span class="input-clear-button"></span>
                        </div>
                      </div>
                    </li>
                    <!--li class="item-content item-input">
                      <div class="item-inner">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                          <label class="custom-control-label" for="remember-me" style="font-size:13px">자동로그인</label>
                        </div>
                      </div>
                    </li-->
                    <li >
                      	<a href="#" class="list-button" @click="connectid">
							로그인하여 연결
						</a>
                    </li>

                  </ul>
                </div>
              </div>
       </div>
      </form>
		<div class="snslogin-sub-wrap">
			<a href="/m/findpassword" class="snslogin-find-pwd">
				아이디, 비밀번호 찾기
			</a>
			<a href="/m/register" class="snslogin-join">
				회원가입
			</a>
		</div>
		
		
    </div><!-- / page-content -->
  </div><!-- / page -->
</template>
<script>
  return {
    data: function () {
      return {
      }
    },
    methods: {
		connectid : function () {
			var self = this
			$$.ajax({
			   url:"/login",
			   method:"POST",
			   data:$$("#loginsns-form").serialize(),
			   success:function(res)
			   {
	
				 window.location.replace("/");
	
			   },
			   error: function ( err ){
				 ajaxError(err);
				 if( typeof err.responseJSON.message!= 'undefined' &&  err.responseJSON.message=='refresh' ) {
				   $(document).trigger('reserved', { status: 'refresh' })
				 }
			   }
			 });			
		}
    },
    on: {
      pageBeforeRemove: function () {
        var self = this;
        // Destroy popup when page removed
        if (self.notificationFull) self.notificationFull.destroy();
        if (self.popup) self.popup.destroy();
        if (self.popupSwipe) self.popupSwipe.destroy();
        if (self.popupSwipeHandler) self.popupSwipeHandler.destroy();
        if (self.popupPush) self.popupPush.destroy();
      },
      pageInit: function () {
        var self = this;
        var today = new Date();
        var app = self.$app;
		$$(".panel.panel-right").remove();
      },
    }
  }
</script>
