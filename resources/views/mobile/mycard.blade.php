<template>
  <div class="page page-myinfo" data-name="myinfo">
    <div class="navbar navbar-new">
      <div class="navbar-bg"></div>
      <div class="navbar-inner sliding">
        <div class="left">
          <a href="#" class="link back">
            <i class="icon icon-back"></i>
            <span class="if-not-md">Back</span>
          </a>
        </div>
        <div class="title">명함관리</div>
        <div class="right">
          <a href="/m/notilist" class="link icon-only">
            <i class="icon material-icons md-only">notifications
              <span class="badge color-red noti-cnt">0</span>
            </i>
          </a>
          <a href="/m/menu" class="link icon-only menu-icon">
            <i class="icon material-icons">menu</i>
          </a>
        </div>
      </div>
    </div>
    <div class="page-content">

      <div class="my-info-block">
          <div class="myinfo-inner-wrap">
            <div class="block-title">내명함</div>
            @if( empty($user->card->user_id) && empty($user->business_card_front) && empty($user->business_card_back) )
            <div class="myinfo-none-card">
              등록된 명함이 없습니다.
              <br>명함을 등록해주세요.
            </div>
            @endif
            <div style="padding: 5px 15px;color: #666;">
              <div>명함앞면</div>
              <div class="myinfo-card-image-wrap">
                <div class="fn-preivew-upload" data-url="/mobileapi/my/cardimgsave">
                  @if( empty($user->business_card_front) )
                  <img src="https://via.placeholder.com/450x250/eee/666?text=Business%20CARD%20Upload" width=100%;/>
                  @else
                  <img src="/storage/{{$user->business_card_front}}" width=100%;>
                  @endif
                  <form>
                    <input type="hidden" name="cardtype" value="business_card_front">
                  </form>
                </div>
              </div>

            </div>
            <div style="padding: 5px 15px;color: #666;">
              <div>명함뒷면</div>

              <div  class="myinfo-card-image-wrap">

                <div class="fn-preivew-upload" data-url="/mobileapi/my/cardimgsave">
                  @if( empty($user->business_card_back) )
                  <img src="https://via.placeholder.com/450x250/eee/666?text=Business%20CARD%20Upload" width=100%;/>
                  @else
                  <img src="/storage/{{$user->business_card_back}}" width=100%;>
                  @endif
                  <form>
                    <input type="hidden" name="cardtype" value="business_card_back">
                  </form>

                </div>
              </div>
            </div>
            <div>
              <div class="business_card">
                <div>전송정보</div>
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
                        @if(empty($user->card->card_position)) hide @endif"  data-none="" data-hide="self">
                        @if( !empty($user->card->card_position) )
                        {{$user->card->card_position}}
                        @endif
                      </div>
                      <div class="card-filed-dept  after-slash
                        @if(empty($user->card->card_dept)) hide @endif"  data-none="" data-hide="self">
                        @if( !empty($user->card->card_dept) )
                        {{$user->card->card_dept}}
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="display-flex justify-content-flex-end card-flex"
                    style="min-height:24px;;margin-top:-10px;margin-bottom: 12px;">
                    <div class="card-filed-company
                    @if(empty($user->card->card_company)) hide @endif"
                    data-none="" data-hide="self" >
                    @if( !empty($user->card->card_company) )
                    {{$user->card->card_company}}
                    @endif
                  </div>
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
                        <div class="card-filed-homepage card-filed-icon" data-none="" data-hide="parent" >
                          @if( !empty($user->card->card_homepage) )
                          {{$user->card->card_homepage}}
                          @endif
                        </div>
                      </div>
                      <div class="display-flex card-icon-line card-flex @if(empty($user->card->card_addr)) hide @endif">
                        <i class="material-icons">location_city</i>
                        <div class="card-filed-addr card-filed-icon" data-none="" data-hide="parent">
                          @if( !empty($user->card->card_addr) )
                          {{$user->card->card_addr}}
                          @endif
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="list no-last-li-hairlines" style="margin-bottom: 10px;    max-height: 30vh;
    overflow: scroll;">
              <form id="myinfo-mycard">
                <ul>

                  <li class="item-content item-input item-input-outline">
                    <div class="item-inner">
                      <div class="item-title item-floating-label">전송정보 이름</div>
                      <div class="item-input-wrap">
                        <input type="text" class="cardfill" data-target=".card-filed-name" name="card_name" value=@if(!empty($user->card->card_name)) "{{$user->card->card_name}}" @endif >
                      </div>
                    </div>
                  </li>
                  <li class="item-content item-input item-input-outline">
                    <div class="item-inner">
                      <div class="item-title item-floating-label">전송정보 전화번호</div>
                      <div class="item-input-wrap">
                        <input type="text" class="cardfill" data-target=".card-filed-phone" name="card_tel"
                        value="@if(!empty($user->card->card_tel)) {{$user->card->card_tel}} @endif" >


                      </div>
                    </div>
                  </li>
                  <li class="item-content item-input item-input-outline">
                    <div class="item-inner">
                      <div class="item-title item-floating-label">전송정보 이메일</div>
                      <div class="item-input-wrap">
                        <input type="text" class="cardfill" data-target=".card-filed-email" name="card_email"
                        value="@if(!empty($user->card->card_email)) {{$user->card->card_email}} @endif" >
                      </div>
                    </div>
                  </li>
                  <li class="item-content item-input item-input-outline">
                    <div class="item-inner">
                      <div class="item-title item-floating-label">전송정보 회사 이름</div>
                      <div class="item-input-wrap">
                        <input type="text" class="cardfill" data-target=".card-filed-company" name="card_company"
                        value="@if(!empty($user->card->card_company)) {{$user->card->card_company}} @endif" >
                      </div>
                    </div>
                  </li>
                  <li class="item-content item-input item-input-outline">
                    <div class="item-inner">
                      <div class="item-title item-floating-label">전송정보 부서</div>
                      <div class="item-input-wrap">
                        <input type="text" class="cardfill" data-target=".card-filed-dept" name="card_dept"
                        value="@if(!empty($user->card->card_dept)) {{$user->card->card_dept}} @endif" >
                      </div>
                    </div>
                  </li>
                  <li class="item-content item-input item-input-outline">
                    <div class="item-inner">
                      <div class="item-title item-floating-label">전송정보 직책</div>
                      <div class="item-input-wrap">
                        <input type="text" class="cardfill" data-target=".card-filed-position" name="card_position"
                        value="@if(!empty($user->card->card_position)) {{$user->card->card_position}} @endif" >
                      </div>
                    </div>
                  </li>

                  <li class="item-content item-input item-input-outline">
                    <div class="item-inner">
                      <div class="item-title item-floating-label">전송정보 홈페이지</div>
                      <div class="item-input-wrap">
                        <input type="text" class="cardfill" data-target=".card-filed-homepage" name="card_homepage"
                        value="@if(!empty($user->card->card_homepage)) {{$user->card->card_homepage}} @endif" >
                      </div>
                    </div>
                  </li>
                  <li class="item-content item-input item-input-outline">
                    <div class="item-inner">
                      <div class="item-title item-floating-label">전송정보 주소</div>
                      <div class="item-input-wrap">
                        <input type="text" class="cardfill" data-target=".card-filed-addr" name="card_addr" 
                        value="@if(!empty($user->card->card_addr)) {{$user->card->card_addr}} @endif" >
                      </div>
                    </div>
                  </li>

                  <li class="item-content item-input item-input-outline justify-content-flex-end" style="padding:4px 15px;">
                    <a href="#" class="button button-fill" @click="cardsave" style="background-color: #5278b7;padding-left:10px;padding-right:10px;">저장</a>
                  </li>
                </ul>
              </form>
            </div>

          </div>
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
      cardsave: function() {
		
        $$.ajax({
           url:"/mobileapi/my/card/save",
           method:"POST",
           dataType:'json',
           data:$$("#myinfo-mycard").serialize(),
           success:function(res)
           {
             toastmessage('저장되었습니다.')
			 
           },
           error: function ( err ){
             ajaxError(err);
           }
         });
      },
      myInfoSave: function() {
        $$.ajax({
           url:"/mobileapi/myinfo/edit",
           method:"POST",
           dataType:'json',
           data:$$("#myinfo-myinform").serialize(),
           success:function(res)
           {
             toastmessage('저장되었습니다.')
           },
           error: function ( err ){
             ajaxError(err);
           }
         });
      },
      myPassword: function() {
        $$.ajax({
          url:"/user/password",
          method:"PUT",
          dataType:'json',
          data:$$("#myinfo-password").serialize(),
          success:function(res)
          {
            toastmessage('변경되었습니다.')
            $("input[type=password]").val('')
          },
          error: function ( err ){
            ajaxError(err);
          }
        });
      },
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
		$$(".page-previous[data-name='cardexcnahgehpage']").remove();
      },
      pageInit: function () {
        var self = this;
        var today = new Date();
        var app = self.$app;

        if( $$(".after-slash.hide").length < 1 ){
          $$(".after-slash").removeClass('slash-hide');
        }else $$(".after-slash").addClass('slash-hide');

        $(".cardfill").on( "keyup", function (e) {
          let str = $(this).val();
          let target = $$(this).data('target');
          let hide = $$(target).data('hide');
          let nonestr = $$(target).data('none');

          if (str == ''){
            if( hide == 'self') {
              console.log ( "self hide")
              $$(target).addClass("hide");
            }
            else if (hide=='parent') {
              console.log ( "parent hide")
              $$(target).parent().addClass("hide");}
            else $$(target).text( nonestr) ;
          }else {
            if( hide == "self") {
              $$(target).removeClass("hide");
            }
            else if (hide=='parent') {
              $$(target).parent().removeClass("hide");
            }
            $$(target).text( str) ;
          }
          if( $$(".after-slash.hide").length < 1 ){
            $$(".after-slash").removeClass('slash-hide');
          }else $$(".after-slash").addClass('slash-hide');
        })
        fnpreivewupload()
		  setTimeout( function() {$$(".page-previous[data-name='cardexcnahgehpage']").remove();},1000);
      },
    }
  }
</script>
