<template>
  <div class="popup reserve-meeting-pop" name="reserve-pop">
    <div class="view">
      <div class="page">
        <div class="navbar">
          <div class="navbar-bg"></div>
          <div class="navbar-inner">
            <div class="title" style="flex-grow:1;text-align:center;">
            1:1 미팅 신청
            </div>
            <div class="pop-close-icon-btn"><a href="#" class="link popup-close"><i class="material-icons">close</i></a></div>
          </div>
        </div>
        <div class="page-content">
          <div class="block">

            <div class="list inline-labels no-hairlines-md">
              <ul>
                <li class="item-content">

                  <div class="item-inner">
                    <div class="item-title item-label">신청시간</div>
                    <div class="item-input-wrap">
                      2020-10-09<br>
                      09:00 ~ 10:00
                    </div>
                  </div>
                </li>
              </ul>
            </div>

            <div class="list no-hairlines-md">
              <ul>
                <li class="item-content item-input">

                  <div class="item-inner">
                    <div class="item-title item-label">신쳥내용</div>
                    <div class="item-input-wrap">
                      <textarea placeholder="신청내용을 적어주세요" class="outline"></textarea>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="flex flex_center">
              <a href="#" class="button button-fill color-orange popup-close buttons-agree">close</a>
              <a href="#" class="button button-fill color-blue  buttons-agree" @click='setReserved'>신청하기</a>
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
        $(document).trigger('reserved', { foo: 'bar' });
        app.popup.close('.reserve-meeting-pop')
      }
    },
  }
</script>
