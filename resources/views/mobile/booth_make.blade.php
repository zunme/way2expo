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
        <div class="title">
          @if ( empty($booth->id))
          부스 생성
          @else
          부스 수정
          @endif

        </div>
        <div class="right">
          <a href="/m/notilist" class="link icon-only">
            <i class="icon material-icons md-only">notifications
              <span class="badge color-red noti-cnt">0</span>
            </i>
          </a>
          
		   <a href="/m/menu" class="link icon-only">
            <i class="icon material-icons">menu</i>
          </a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="block">
        <form id="booth-make-form">

            @if( !empty($booth->id))
              <input type="hidden" name="booth_id" value="{{$booth->id}}">
            @endif
            <div class="list no-hairlines-md">
              <ul>
                <li class="item-content item-input item-input-with-value">
                  <div class="item-inner">
                    <div class="item-title item-label">박람회</div>
                    <div class="item-input-wrap input-dropdown-wrap">
                      <select name="expo_id" placeholder="Please choose..."
                        class="input-with-value"
                        @if ( !empty($booth->id) )
                        disabled
                        @endif
                        >
                        <option value="">박람회 선택</option>
                        @forelse( $expos as $expo)
                        <option value="{{$expo->id}}"
                          @if ($expo->expo_code == $expo_code)
                            selected="selected"
                          @endif >
                          {{$expo->expo_name}}
                        </option>
                        @empty
                        <option value="">신청가능한 박람회가 없습니다.</option>
                        @endforelse
                      </select>

                      @if ( !empty($booth->id) )
                      <input type="hidden" name="expo_id" value="{{$expo->id}}">
                      @endif

                    </div>
                  </div>
                </li>
                <li class="item-content item-input item-input-outline">
                  <div class="item-inner">
                    <div class="item-title item-label">부스타이틀</div>
                    <div class="item-input-wrap">
                      <input type="text" name="booth_title" placeholder="부스타이틀" value="{{$booth->booth_title}}">
                      <span class="input-clear-button"></span>
                    </div>
                  </div>
                </li>
                <li class="item-content item-input item-input-outline">
                  <div class="item-inner">
                    <div class="item-title item-label">부스소개</div>
                    <div class="item-input-wrap">
                      <textarea placeholder="부스소개" name="booth_intro" class="">{{$booth->booth_intro}}</textarea>
                    </div>
                  </div>
                </li>
                <li class="item-content item-input item-input-outline">
                  <div class="item-inner">
                    <div class="item-title item-label">검색태그</div>
                    <div class="item-input-wrap">
                      <input type="text" name="tags[]" placeholder="Tag"  value="{{ isset($booth->tags[0]) ? $booth->tags[0]->name: ''}}">
                      <span class="input-clear-button"></span>
                    </div>
                  </div>
                  <div class="item-inner">
                    <div class="item-title item-label"></div>
                    <div class="item-input-wrap">
                      <input type="text" name="tags[]" placeholder="Tag"  value="{{isset($booth->tags[1]) ? $booth->tags[1]->name: ''}}">
                      <span class="input-clear-button"></span>
                    </div>
                  </div>
                  <div class="item-inner">
                    <div class="item-title item-label"></div>
                    <div class="item-input-wrap">
                      <input type="text" name="tags[]" placeholder="Tag"  value="{{isset($booth->tags[2]) ? $booth->tags[2]->name: ''}}">
                      <span class="input-clear-button"></span>
                    </div>
                  </div>
                </li>

                <li class="item-content item-input item-input-outline">
                  <div class="item-inner">
                    <div class="item-title item-label">데스크탑용 이미지</div>
                    <div class="item-input-wrap">
                      <input type="file" name="selectimg_pc" placeholder="image" data-maxheight='140px' data-maxwidth='100%' data-type="booth-desktop" onChange="fnImgPreview(this)">
                      <span class="input-clear-button"></span>
                    </div>
                  </div>
                  <div class="item-inner">
                    <div class="item-title item-label">모바일용 이미지</div>
                    <div class="item-input-wrap">
                      <input type="file" name="selectimg_mobile" placeholder="image" data-maxheight='140px' data-maxwidth='100%' data-type="booth-mobile" onChange="fnImgPreview(this)">
                      <span class="input-clear-button"></span>
                    </div>
                  </div>
                </li>
                <li class="item-content item-input item-input-outline">
                  <div class="item-inner">
                    <div class="item-input-wrap text-align-center img-previewarea" data-type="booth-desktop">
                      @if ( empty($booth->id))
                      이미지가 없습니다
                      @else
                      <img src="{{$booth->getDesktopImageUrl()}}" style="max-width:100%;max-height:140px;">
                      @endif
                    </div>
                  </div>
                  <div class="item-inner">
                    <div class="item-input-wrap text-align-center img-previewarea" data-type="booth-mobile">
                      @if ( empty($booth->id))
                      이미지가 없습니다
                      @else
                        <img src="{{$booth->getMobileImageUrl()}}" style="max-width:100%;max-height:140px;">
                      @endif
                    </div>
                  </div>
                </li>
                <li class="item-content item-input item-input-outline">
                  <div class="item-inner">
                    <div class="item-title item-label">유투브 영상</div>
                    <div class="item-input-wrap">
                      <input type="text" name="booth_youtube_url" placeholder="Youtube URL"  value="{{$booth->booth_youtube_url}}">
                      <span class="input-clear-button"></span>
                    </div>
                  </div>
                </li>
                <li class="item-content item-input item-input-outline">
                  <div class="item-inner align-items-flex-end mt-20" >
                    <a href="#" class="button button-fill" style="min-width:150px;" @click="save">
                    저장
                    </a>
                  </div>
                </li>
              </ul>
            </div>

        </form>
      </div>
    </div><!-- / page-content -->


  </div><!-- / page -->
</template>
<script>
  return {
    data: function () {
      return {
        title : "@if ( empty($booth->id))부스 생성@else부스 수정@endif"
      }
    },
    methods: {
      save : function () {
        var self = this
        $$.ajax({
           url:"/mobileapi/booth/save",
           method:"POST",
           data:new FormData( document.getElementById('booth-make-form') ),
           dataType:'JSON',
           contentType: false,
           cache: false,
           processData: false,
           success:function(res)
           {
             app.dialog.create({
               title: self.title,
               text: `${self.title} 완료`,
               buttons: [
                     {
                       text: '확인',
                     },
               ],
               on: {
                  closed : function () {
                    $$(".page.page-previous").remove();
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
