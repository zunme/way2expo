<template>
  <div class="page page-booth" data-name="boothpage">
    <div class="navbar navbar-new">
      <div class="navbar-bg"></div>
      <div class="navbar-inner sliding">
        <div class="left">
          <a href="#" class="link back">
            <i class="icon icon-back"></i>
            <span class="if-not-md">Back</span>
          </a>
        </div>
        <div class="title">문의 내용</div>
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
		
		<div class="card_view_wrap">
			<div class="card_view_info_wrap">
				<div class="card_view_title">
					문의내용
				</div>
				<div class="card_view_info_inner">
					<div class="display-flex">
						<div class="card_view_info_title">
							보낸일시
						</div>
						<div class="card_view_info_content">
							{{$card->created_at}}
						</div>					
					</div>
					<div class="display-flex">
						<div class="card_view_info_title">
							소개 및 인사말
						</div>
						<div class="card_view_info_content">
							{!! nl2br(e($card->message)) !!}
						</div>					
					</div>
				</div>
			</div>
			<div class="card_view_card_wrap">
				<div class="card_view_title">
					명함
				</div>
				<div class="card_view_card_inner">
<!-- -->
					
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
					
		@if( !empty($user->card->user_id) )
<!-- 텍스트명함 --> 

		<div>
          <div style="padding: 5px 0">
            <div>명함(텍스트)</div>
  
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


          </div>
        </div>
		<!-- /텍스트명함 -->	
		@endif
					
<!-- -->
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
