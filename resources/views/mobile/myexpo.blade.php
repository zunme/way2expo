<template>
  <div class="page page-myexpo" data-name="myexpo">
    <div class="navbar navbar-new">
      <div class="navbar-bg"></div>
      <div class="navbar-inner sliding">
        <div class="left">
          <a href="#" class="link back">
            <i class="icon icon-back"></i>
            <span class="if-not-md">Back</span>
          </a>
        </div>
        <div class="title">참여한 박람회</div>
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
      <div>
        <div class="row mybooth-card-row">
          @forelse ( $booths as $booth )
          <div class="col-50 elevation-2" style="position:relative">
            @if( $today <= $booth->expoBooth->expo_close_date->format('Y-m-d') )
			<div class="display-flex justify-content-space-between mybooth_menu_wrpa">
				<a href="/expo/{{$booth->expoBooth->expo_code}}/booth/{{$booth->id}}">
				  <i class="material-icons elevation-1">edit</i>
				</a>
				<a href="/m/live/{{\Crypt::encryptString($booth->id)}}">
				  <i class="material-icons elevation-1">live_tv</i>
				</a>
			</div>
            @endif
            <a href="/expo/{{$booth->expoBooth->expo_code}}/{{$booth->id}}">
              <div class="mybooth-card-header-img background-pos-top"
                  style="background-image: url({{$booth->expoBooth->getImageUrl()}});    min-height: 150px;">
              </div>
              <div class="mybooth-card-body">
                <div class="bottom-line">
					<div class="ellipsis">{{$booth->expoBooth->expo_name}}</div>
					<div class="ellipsis">{{$booth->expoBooth->expo_open_date->format('Y-m-d')}}~{{$booth->expoBooth->expo_close_date->format('Y-m-d')}}</div>

					<div class="ellipsis text-align-right">
						{{$booth->booth_title}}
					</div>
                </div>
                <div class="bottom-line">
                  <div class="display-flex justify-content-space-between">
                    <span>미팅신청</span>
                    <span>{{$booth->meeting_cnt}}</span>
                  </div>
                  <div class="display-flex justify-content-space-between">
                    <span>조회</span>
                    <span>{{$booth->boothMeta->visitor_count}}</span>
                  </div>
                </div>
              </div>
            </a>
			@if( $today <= $booth->expoBooth->expo_close_date->format('Y-m-d') )
			<div class="display-flex justify-content-space-between mybooth_bottom_menu">
				<a href="/expo/{{$booth->expoBooth->expo_code}}/booth/{{$booth->id}}">
				  수정
				</a>
				<!--a href="/m/myproduct/{{$booth->id}}">
				  상품
				</a-->
				<a href="/m/live/{{\Crypt::encryptString($booth->id)}}">
				  방송
				</a>
			</div>
            @endif
          </div>
          @empty
          <div class="col-100 elevation-2 text-align-center" style="background-color:white;padding:30px 5px;margin-right:8px;margin-top:100px;">
            참여한 박람회가 없습니다.
          </div>
          @endforelse
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
