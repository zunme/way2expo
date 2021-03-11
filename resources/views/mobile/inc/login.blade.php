<template>

  <div class="page no-toolbar no-navbar no-swipeback login-screen-page login_page">
    <div class="login-close-btn">
      <a href="#" @click="close">
        <i class="material-icons">close</i>
      </a>
    </div>
    <div class="page-content login-screen-content">

      <div class="login-screen-title">
        <div class="login-brand">
          <img src="/image/fav180.png" alt="logo" class="shadow-light">
        </div>
        <div class="login-screen-title-sub">
          성공적 비즈니스의 첫걸음 Way2Expo
        </div>
      </div>

      <form id="login-form">
        <div class="card card-primary">

              <div class="card-body">
                <div class="list">
                  <ul>
                    <li class="item-content item-input item-input-with-value">
                      <div class="item-inner">
                        <div class="item-title item-label with-padding">사용자 이메일</div>
                        <div class="item-input-wrap">
                          <input type="email" name="email" placeholder="E-mail을 입력해주세요" id="demo-username-2" class="input-with-value">
                          <span class="input-clear-button"></span>
                        </div>
                      </div>
                    </li>
                    <li class="item-content item-input">
                      <div class="item-inner">
                        <div class="item-title item-label with-padding">비밀번호</div>
                        <div class="item-input-wrap">
                          <input type="password" name="password" required autocomplete="current-password" placeholder="비밀번호를 입력해주세요" id="demo-password-2">
                          <span class="input-clear-button"></span>
                        </div>
                      </div>
                    </li>
                    <li class="item-content item-input">
                      <div class="item-inner">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                          <label class="custom-control-label" for="remember-me">로그인 상태 유지</label>
                        </div>
                      </div>
                    </li>
                    <li class="login_find_li">
                      <div class="login_find_wrap">
                        <a href="/m/find">
                          아이디, 비밀번호 찾기
                        </a>
                      </div>
                      <div class="login_find_reg_wrap">
                        <a href="/m/register">
                          회원가입
                        </a>
                      </div>
                    </li>
                    <li class="login_loginbtn_li">
                      <a href="#" class="list-button" @click="signIn">로그인</a>
                    </li>
                    <li class="login_loginkakao_li" >
                      <div class="login_login_kakao_title">
                        간편 로그인
                      </div>
                      <div class="login_loginkakao_wrap">
                        <a href="/mobile/social/kakao" class="list-button kakao-login-btn external " >카카오 로그인</a>  
                      </div>
                      
                    </li>
                  </ul>
                </div>
              </div>
       </div>
      </form>

    </div>
  </div>
</template>
<script>
  return {
    data: function () {
    return {
        data : {
          login : false,
        }
      }
    },
    methods: {
      close : function () {
        var $ = this.$;
        var app = this.$app;
        var router = this.$router;

        app.loginScreen.close();
        router.back();
      },
      signIn: function () {
        var self = this
        $$.ajax({
           url:"/login",
           method:"POST",
           data:$$("#login-form").serialize(),
           success:function(res)
           {
             self.data.login = true;
			   if( window.location.pathname =='/m/login'){
				   window.location.replace("/")
			   }else reloadcurrent()
           },
           error: function ( err ){
             ajaxError(err);
             if( typeof err.responseJSON.message!= 'undefined' &&  err.responseJSON.message=='refresh' ) {
               $(document).trigger('reserved', { status: 'refresh' })
             }
           }
         });
      },
      /*
      signInback: function () {
        var $ = this.$;
        var app = this.$app;
        var router = this.$router;
        var username = $('input#demo-username-2').val();
        var password = $('input#demo-password-2').val();
        app.dialog.alert('Username: ' + username + '<br>Password: ' + password, function () {
          app.loginScreen.close();
          router.back();
        })
      }
      */
    },
    on: {
      pageBeforeOut: function(){
        var self = this;
        if( !self.data.login && isLogined ){ 
          window.reloadcurrent();
          $$(".page.page-previous").remove();
          /*
          window.reloadcurrent();
          */
        }
      },
	  pageInit: function() {	
	  }
    }
  }
</script>
