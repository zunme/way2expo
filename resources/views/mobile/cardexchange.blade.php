<template>
  <div class="page page-booth" data-name="cardexcnahgehpage">
    <div class="navbar navbar-new">
      <div class="navbar-bg"></div>
      <div class="navbar-inner sliding">
        <div class="left">
          <a href="#" class="link back">
            <i class="icon icon-back"></i>
            <span class="if-not-md">Back</span>
          </a>
        </div>
        <div class="title">비즈니스문의</div>
        <div class="right">
          <a href="/m/notilist" class="link icon-only">
            <i class="icon material-icons md-only">notifications
              <span class="badge color-red noti-cnt">0</span>
            </i>
          </a>
		  <a href="/m/menu" class="link icon-only menu-icon"  style="margin-left:12px;">
            <i class="icon material-icons">menu</i>
          </a>
        </div>
      </div>
    </div>
    <div class="page-content"  style="background-color:#eee">
@if( empty($user->card->user_id) && empty($user->business_card_front) && empty($user->business_card_back) )
      <div class="block mt-15 mb-15"  style="background-color:white;padding-top: 10px;padding-bottom: 10px;">
        <a href="/m/mycardinfo">
          <div class="myinfo-none-card">
            등록된 명함과 정보가 없습니다.
            <br>명함(정보)을 등록해주세요.
          </div>
        </a>
      </div>
@else
		<form name="card_exchange_form" >
		  
		  

		
		<div class="block cardexchange_top_inc">
			@include('mobile.inc.boothcardprivacy')
		</div>
		

		
		  
		 
	<div class="block mt-15 mb-15"  style="background-color:white">
        <div class="list" style="margin-top: 5px;margin-bottom: 5px">
          <ul>
            <li>
                <div class="item-inner" style="line-height:26px;padding-right:0;">
                  <div class="item-title">
                    명함
                  </div>
                  <a href="/m/mycardinfo">
                    <div class="item-after">
                      명함 수정
                      <i class="material-icons">keyboard_arrow_right</i>
                    </div>
                  </a>
                </div>

            </li>
          </ul>
        </div>
		
        @if( !empty($user->business_card_front) )
        <div style="padding: 5px 0;color: #666;">
          <div>명함앞면</div>
          <div class="myinfo-card-image-wrap">
            <div class="fn-preivew-upload">
              <img src="/storage/{{$user->business_card_front}}" width=100%;>
            </div>
          </div>
        </div>
        @endif
        @if( !empty($user->business_card_back) )
        <div style="padding: 5px 0;color: #666;">
          <div>명함뒷면</div>
          <div class="myinfo-card-image-wrap">
            <div class="fn-preivew-upload">
              <img src="/storage/{{$user->business_card_back}}" width=100%;>
            </div>
          </div>
        </div>
        @endif

		
			<!-- 텍스트명함 --> 

		<div>
          <div style="padding: 5px 0">
            <div>명함(텍스트)</div>
            @if( empty($user->card->user_id) )
            <div class="myinfo-none-card">
              등록된 텍스트 명함이 없습니다.
              <div style="margin-top: 16px;padding: 0 20px;">
                <a href="" class="button button-fill">텍스트명함등록</a>
              </div>
            </div>
            @else
            <div class="business_card_inner">
              <div class="display-flex justify-content-space-between">
                <div class="card-filed-name"  data-none="이름" data-hide="false">
                  @if( empty($user->card->card_name))
                    이름
                  @else
                  {{$user->card->card_name}}
                  @endif
                </div>
                <div class="display-flex">
                  <div class="card-filed-position after-slash
                    @if(empty($user->card->position)) hide @endif"  data-none="" data-hide="self">
                    {{$user->card->card_position}}
                  </div>
                  <div class="card-filed-dept  after-slash
                    @if(empty($user->card->card_dept)) hide @endif"  data-none="" data-hide="self">
                    {{$user->card->card_dept}}
                  </div>
                </div>
              </div>
              <div class="display-flex justify-content-flex-end card-flex"
                style="min-height:24px;;margin-top:-10px;margin-bottom: 12px;">
                <div class="card-filed-company
                @if(empty($user->card->card_company)) hide @endif"
                data-none="" data-hide="self" >{{$user->card->card_company}}</div>
              </div>
              <div class="display-flex flex-direction-column">
                  <div class="display-flex card-icon-line card-flex">
                    <i class="material-icons">phone</i>
                    <div class="card-filed-phone card-filed-icon"  data-none="전화번호" data-hide="false">
                      @if(empty($user->card->card_tel))
                      전화번호
                      @else
                      {{$user->card->card_tel}}
                      @endif
                    </div>
                  </div>
                  <div class="display-flex card-icon-line card-flex">
                    <i class="material-icons">mail</i>
                    <div class="card-filed-email card-filed-icon" data-none="이메일" data-hide="false">
                      @if(empty($user->card->email))
                      이메일
                      @else
                      {{$user->card->email}}
                      @endif
                    </div>
                  </div>
                  <div class="display-flex card-icon-line card-flex @if(empty($user->card->card_homepage)) hide @endif">
                    <i class="material-icons">home</i>
                    <div class="card-filed-homepage card-filed-icon" data-none="" data-hide="parent" >{{$user->card->card_homepage}}</div>
                  </div>
                  <div class="display-flex card-icon-line card-flex @if(empty($user->card->card_addr)) hide @endif">
                    <i class="material-icons">location_city</i>
                    <div class="card-filed-addr card-filed-icon" data-none="" data-hide="parent">{{$user->card->card_addr}}</div>
                  </div>
              </div>
            </div>
            @endif

          </div>
        </div>

		<!-- /텍스트명함 -->	
		
		
		
        
		  
		  
      </div><!--block -->
		
		
		@if( empty($user->card->user_id) && empty($user->business_card_front) && empty($user->business_card_back) )

		@else
	<div class="block mt-15 mb-15"  style="background-color:white;padding: 0 15px 15px;">
        <div class="list" style="margin-top: 5px;margin-bottom: 5px">
          <ul>
            <li>
                <div class="item-inner" style="line-height:26px;padding-right:0;">
                  <div class="item-title">
                    소개 및 인사말
                  </div>
                </div>

            </li>
          </ul>
        </div>
        <div class="cardexchange_button_wrap">
            <input type="hidden" name="company_id" value="{{$company_id}}">
			<input type="hidden" name="booth_id" value="{{$booth->id}}">
            <textarea class="custclass" name="message"></textarea>
            <div class="display-flex">
				<div class="cardexchange_button_cancel_wrap">
				<button type="button" class="button button-fill" @click="cancel">취소</button>	
				</div>
              <div  class="cardexchange_button_send_wrap">
                <button type="button" class="button button-fill" @click="exchange">보내기</button>
              </div>
            </div>
        </div>
      </div>
		@endif
		
		</form>
@endif		
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
	  cancel : function () {
		  app.dialog.confirm(               
               `비즈니스문의를 취소하시겠습니까?<br>작성한 내용은 저장되지 않습니다.`,
			  `Way2Expo`,
			  function() {
				  history.back(2)
			  },
			  function() {
			  },
               
             );
	  },

      exchange : function() {

        $$.ajax({
           url:"/mobileapi/card/exchange",
           method:"POST",
           data:$$("form[name=card_exchange_form]").serialize(),
           dataType:'JSON',
           cache: false,
           success:function(res)
           {
             app.dialog.create({
               title: 'Way2Expo',
               text: `비즈니스 문의가<br>정상적으로 전달되었습니다.`,
               buttons: [
                     {
                       text: '확인',
                     },
               ],
               on: {
                  closed : function () {
                    //$$(".page.page-previous").remove();
                    app.views.main.router.back();
                  }
                }
             }).open();
           },
           error: function ( err ){
             ajaxError(err);
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
      },
    }
  }
</script>
