<template>
  <div class="popup reserve-meeting-pop" name="reserve-pop">
    <div class="view">
      <div class="page">
        <div class="navbar">
          <div class="navbar-bg"></div>
          <div class="navbar-inner">
            <div class="title" style="flex-grow:1;text-align:center;">
            1:1 화상회의 신청
            </div>
            <div class="pop-close-icon-btn"><a href="#" class="link popup-close"><i class="material-icons">close</i></a></div>
          </div>
        </div>
        <div class="page-content">

@if( $msgcode !='')
<div class="block">
  <div class="display-flex justify-content-center flex-direction-column text-align-center">
  @if ( $msgcode=="date")
    <h3>이미 {{$dupl->meeting_time}}시에 화상회의를 신청하셨습니다.</h3>
    <p>
      <div class="success-checkmark">
        <div class="check-icon">
          <span class="icon-line line-tip"></span>
          <span class="icon-line line-long"></span>
          <div class="icon-circle"></div>
          <div class="icon-fix"></div>
        </div>
      </div>
    </p>
    @if ($dupl->meeting_status=="R")
    <p>
      담당자가 신청내용 확인 후 승인이 되면 해당 시간에 미팅이 진행됩니다.
    </p>
    @else
    <p>
      메뉴 &gt; 내 화상회의 &gt; 신청한 화상회의에서 확인 가능합니다.
    </p>
    @endif
  @elseif ( $msgcode=="time")
    <script>
      $(document).trigger('reserved', { foo: 'bar' });
    </script>
    <h3>다른 시간을 선택해주세요.</h3>
    <div>
      선택하신 시간은 이미 예약이 되어있습니다.<br>
      다른 시간을 선택하신 하신 후 미팅신청을 해주세요
    </div>
  @endif
  </div>
</div>
@else
<form id="meetingform" class="form-toggle">
  <input type="hidden" name="expo_code" value="{{$expo_code}}">
  <input type="hidden" name="booth_id" value="{{$booth_id}}">
  <input type="hidden" name="meeting_date" value="{{$date}}">
  <input type="hidden" name="meeting_time" value="{{$time}}">
          <div class="block">

            <div class="list inline-labels no-hairlines-md">
              <ul>
                <li class="item-content">

                  <div class="item-inner">
                    <div class="">신청일자</div>
                    <div class="">
                      {{$date}} 
                      {{sprintf('%2d', $time)}}:00 ~ {{sprintf('%2d', ((int)$time+1) )}} :00
                    </div>
                  </div>
                </li>
              </ul>
            </div>
			<div class="meeting_form_privacy_wrap">
				<div class="meeting_form_privacy_inner">
					<div class="meeting_form_privacy_title">
						개인정보 제공동의
					</div>
					<div class="meeting_form_privacy_info_wrap">
						<div class="meeting_form_privacy_info_wrap">
							@include('mobile.inc.meetingprivacy')
						</div>
					</div>
					<div class="meeting_form_privacy_check_wrap">
						<div class="meeting_form_privacy_check_inner">
							<input type="checkbox" name="agree" value="Y"> 동의합니다
						</div>
					</div>
				</div>	
			</div>
            <div class="list no-hairlines-md">
              <ul>
                <li class="item-content item-input">

                  <div class="item-inner">
                    <div class="item-title">신쳥코멘트</div>
                    <div class="item-input-wrap">
                      <textarea placeholder="1:1 화상회의를 신청하는 간단한 사유를 입력해주시기 바랍니다." class="outline" name="meeting_msg"></textarea>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="flex flex_center">
              <a href="#" class="button button-fill color-orange popup-close buttons-agree">취소</a>
              <a href="#" class="button button-fill color-blue  buttons-agree" @click='setReserved'>신청하기</a>
            </div>
          </div>
</form>
@endif
          <div class="form-toggle">
              <div class="">
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style></style>

<script>
  return {
    methods: {
      setReserved : function () {
        var self = this
        $$.ajax({
           url:"/mobileapi/meeting/reserve",
           method:"POST",
           data:$$("#meetingform").serialize(),
           success:function(res)
           {
             history_back = true;
             $(document).trigger('reserved', { foo: 'bar' });
             app.dialog.create({
               title: '미팅 신청 완료',
               text: `미팅 신청이 완료되었습니다.<br>담당자가 신청내용 확인 후 승인이 되면 해당 시간에 미팅이 진행됩니다.`,
               buttons: [
                     {
                       text: '확인',
                     },
               ],
               on: {
                  closed : function () {
                    history_back = false;
                    app.popup.close('.reserve-meeting-pop')
                  }
                }
             }).open();
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
  }
</script>
