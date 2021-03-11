<template>
  <div class="page page-expo">
    <div class="navbar navbar-new">
      <div class="navbar-bg"></div>
      <div class="navbar-inner sliding">
        <div class="left">
          <a href="#" class="link back">
            <i class="icon icon-back"></i>
            <span class="if-not-md">Back</span>
          </a>
        </div>
        <div class="title">요청받은 1:1 화상회의</div>
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
	 <div class="">
		<p class="segmented segmented-strong">
          <button class="button button-active" data-state="" @click="changetab">전체</button>
          <button class="button" data-state="R" @click="changetab">대기</button>
		  <button class="button" data-state="confirmed" @click="changetab">승인</button>
		  <button class="button" data-state="A" @click="changetab">종료</button>
          <button class="button" data-state="D" @click="changetab">반려</button>
          <span class="segmented-highlight"></span>
        </p> 
	  </div>
      <div class="list media-list">
            <ul>
@verbatim
{{#if data.data.length }}
{{#each data.data }}

{{#if meeting_confirmed}}
<li class="meeting_status" data-status="confirmed">
{{else}}
<li class="meeting_status" data-status="{{meeting_status}}">
{{/if}}	
  <div class="item-link item-content">
    <div class="item-media">
      <a href="/m/meeting/info/{{id}}" class="item-link item-content">
      1:1
      </a>
    </div>
    <div class="item-inner">
      <a href="/m/meeting/info/{{id}}" class="item-link">
        <div class="item-title-row.with_status">
          <div class="item-title">{{expo_name}} 박람회</div>
          <!--div class="item-after">...</div-->
        </div>
        <div class="item-subtitle">{{name}}님 1:1 신청</div>
        <div class="item-text">
          {{meeting_date}} {{meeting_time}}시 ~ {{addtime meeting_time}}시
        </div>
        <div class="item-createdat">
          {{dateformat created_at}}
        </div>
      </a>
    </div>
    <div class="item-status" data-meeitngid="{{id}}">
        {{#if meeting_confirmed}}
          <a href='/meeting/{{meeting_cid}}' class="external"
            target="_blank">미팅참가</a>
        {{else}}
        <a href="/m/meeting/info/{{id}}" class="item-link">
          {{getstatus meeting_status}}
        </a>
        {{/if}}
    </div>
  </div>
  </li>
{{/each}}
{{else}}
  <div class="nullmeetinginfowrap">
    요청받은 화상회의가 없습니다.
  </div>
{{/if}}
@endverbatim
            </ul>
          </div>
    </div><!-- / page-content -->

  </div>
</template>
<script>
  return {
    data : function() {
      /*
      return {
        'data' : {
        }
      }
      */

      return new Promise((resolve) => {
        fetch('/m-meeting-receivelist')
          .then(res => res.json())
          .then(data => resolve({ data }))
      });

    },
    methods: {
		changetab : function(e) {
			let state = $$(e.target).data('state');
			$$(e.target).parent().children('button').removeClass("button-active");
			$$(e.target).addClass("button-active");
			
			if( state ==''){
				$$("li.meeting_status").show();
				return;
			}
			$$("li.meeting_status").each( function() {
				if( state == 'A' && $$(this).data('status') =='E' ) $$(this).show();
				else if ($$(this).data('status') == state) $$(this).show();
				else $$(this).hide();
			})
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
      },
    }
  }
</script>
