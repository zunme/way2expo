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
        <div class="title">신청한 미팅</div>
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
      <div class="list media-list">
            <ul>
              @verbatim
              {{#if data.data.length }}
              {{#each data.data }}
              <li>
                <div class="item-link item-content">
                  <div class="item-media">
                    1:1
                  </div>
                  <div class="item-inner">
                    <div class="item-title-row.with_status">
                      <div class="item-title">{{expo_name}} 박람회</div>
                      <!--div class="item-after">...</div-->
                    </div>
                    <div class="item-subtitle">[{{company_name}}]회사에 1:1 신청</div>
                    <div class="item-text">
                      {{meeting_date}} {{meeting_time}}시 ~ {{addtime meeting_time}}시
                    </div>
                    <div class="item-createdat">
                      {{dateformat created_at}}
                    </div>
                  </div>
                  <div class="item-status">
                  {{#if meeting_confirmed}}
                      <a href='/meeting/{{meeting_cid}}' class="external" target="_blank">미팅참가</a>
                      {{else}}
                        {{getstatus meeting_status}}
                      {{/if}}
                  </div>
                </div>
                </li>
              {{/each}}
              {{else}}
              <div class="nullmeetinginfowrap">
                신청한 화상회의가 없습니다.
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
      return new Promise((resolve) => {
        fetch('/m-meeting-sendlist')
          .then(res => res.json())
          .then(data => resolve({ data }))
      });
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
      },
    }
  }
</script>
