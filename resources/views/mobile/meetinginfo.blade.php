<template>
    <div class="page page-meetinginfo" data-name="meetinginfo">
        <div class="navbar navbar-new">
            <div class="navbar-bg"></div>
            <div class="navbar-inner sliding">
                <div class="left">
                    <a href="#" class="link back">
                        <i class="icon icon-back"></i>
                        <span class="if-not-md">Back</span>
                    </a>
                </div>
                <div class="title">미팅요청 상세</div>
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

<div class="list no-hairlines-md">
    <ul>
        <li class="item-content item-input">
            <div class="item-inner">
                <div class="item-title item-label">박람회</div>
                <div class="item-input-wrap">
                    <input type="text" value="{{$meeting->expo_name}}" disabled>
                </div>
            </div>
        </li>
        <li class="item-content item-input">
            <div class="item-inner">
                <div class="item-title item-label">부스</div>
                <div class="item-input-wrap">
                    <input type="text" value="{{$meeting->booth_title}}" disabled>
                </div>
            </div>
        </li>
<li class="item-content item-input">
    <div class="item-inner">
        <div class="item-title item-label">신청인</div>
        <div class="item-input-wrap">
            <input type="text" value="{{$meeting->name}}" disabled>
        </div>
    </div>
</li>
<li class="item-content item-input">
    <div class="item-inner">
        <div class="item-title item-label">미팅 일자</div>
        <div class="item-input-wrap">
            <input type="text" value="{{$meeting->meeting_date}} {{sprintf("%02d",$meeting->meeting_time)}}시" disabled>
        </div>
    </div>
</li>
<li class="item-content item-input">
    <div class="item-inner">
        <div class="item-title item-label">요청 내용</div>
        <div class="item-input-wrap">
            {!! nl2br($meeting->meeting_msg) !!}
        </div>
    </div>
</li>           
    </ul>
</div>
<div class="display-flex justify-content-flex-end meeting-confirm-wrap">
    @if ( $meeting->meeting_status=='R')
        @if ( $now->timestamp >= $meetingtime->timestamp)
           
            <a href="#" class="button button-fill color-gray">이미 미팅승인가능시간이 지났습니다.</a>
        @else                
            <a href="#" @click="deny" class="button button-fill color-deeporange">거절</a>
            <a href="#" @click="accept" class="button button-fill color-teal">승인</a>
        @endif
    @elseif ( $meeting->meeting_status=='A')
    <div class="display-flex" data-time="{{$meetingtime->toIso8601String() }}">
        <a href='/meeting/{{ \Crypt::encryptString($meeting->id) }}' class="external button button-fill color-teal" target="_blank">미팅참가</a>
    </div>
    @else
    <a href="#" class="button button-fill color-gray">요청 거절 완료</a>
    @endif
</div>

        </div><!-- / page-content -->
    </div><!-- / page -->
</template>
<script>
    return {
    data: function () {
      return {
          data : {
              status : '',
              status_text : '',
              meeting_id : '{{$meeting->id}}'
          }
      }
    },
    methods: {
        meeting : function (e) {
            var datetime = $$(e.target).parent().data('time');
            var date = new Date( datetime );
            var check = new Date( Date.now() + 1000 * 60*5 );
            if( date > check ){
                moment.locale("ko");
                var formatdate = moment( datetime );
                toastmessage( formatdate.local().format('LLL') + ' 에 입장해주세요' );
            }else {
                app.views.main.router.navigate( '/meeting/{{ \Crypt::encryptString($meeting->id) }}' , {ignoreCache : true,
                    reloadCurrent : true
                });
            }
        },
        accept : function() {
            var self = this;
            self.data.status='A';
            self.data.status_text ='<span class="font-color-success">승인</span>';
            self.senddata()
        },
        deny : function() {
            var self = this;
            //self.$app.router.back({url :'/m/meeting/receive'})
            self.data.status='D';
            self.data.status_text ='<span class="font-color-red">거절</span>';
            self.senddata()
        },
        senddata : function () {
            var self = this;
            $$.ajax({
                url:"/mobileapi/meeting_confirm", //"/m-meeting-confirm", //"/api/mobile/meeting_confirm"
                method:"POST",
                data: self.data,
                success:function(res)
                {
                    noti('미팅요청을 승인하였습니다.', '');
                    //$$("li").find('div.item-status[data-meeitngid='+ self.data.meeting_id +']').html(self.data.status_text);
                    app.views.main.router.back('/m/meeting/receive',{force: true, ignoreCache: true, reload: true})
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
        
        //app.views.main.router.back( );
      },
    }
  }
</script>