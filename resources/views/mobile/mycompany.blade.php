<template>
    <div class="page page-mycompany" data-name="mycompany">
        <div class="navbar navbar-new">
            <div class="navbar-bg"></div>
            <div class="navbar-inner sliding">
                <div class="left">
                    <a href="#" class="link back">
                        <i class="icon icon-back"></i>
                        <span class="if-not-md">Back</span>
                    </a>
                </div>
                <div class="title">회사정보</div>
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
            <form id="company-edit-form">
            <div class="block-title">기본정보</div>
            <div class="list inline-labels no-hairlines-md">
                <ul>
                    <li class="item-content item-input">
                        <div class="item-inner">
                            <div class="item-title item-label">회사명</div>
                            <div class="item-input-wrap">
                                <input type="text" placeholder="회사명" class="disabledbg" value="{{$company->company_name}}"
                                    disabled>
                                <span class="input-clear-button"></span>
                            </div>
                        </div>
                    </li>
                    <li class="item-content item-input">
                        <div class="item-inner">
                            <div class="item-title item-label">전화번호</div>
                            <div class="item-input-wrap">
                                <input type="text" placeholder="전화번호" class="disabledbg" name="company_tel1" value="{{$company->company_tel1}}" >
                                <span class="input-clear-button"></span>
                            </div>
                        </div>
                    </li>
                    <li class="item-content item-input">
                        <div class="item-inner">
                            <div class="item-title item-label">이메일</div>
                            <div class="item-input-wrap">
                                <input type="text" placeholder="이메일" name="company_email" class="disabledbg" value="{{$company->company_email}}" >
                                <span class="input-clear-button"></span>
                            </div>
                        </div>
                    </li>
                    <li class="item-content item-input">
                        <div class="item-inner">
                            <div class="item-title item-label">주소</div>
                            <div class="item-input-wrap">
                                <textarea class="disabledbg" disabled>{{$company->company_address1}}</textarea>
                            </div>
                        </div>
                    </li>




                </ul>
            </div>
            <div class="block-title">추가정보</div>
            <div class="list inline-labels no-hairlines-md">

                    <input type="hidden" name="id" value="{{$company->id}}">
                    <ul>
                        <li class="item-content item-input">
                            <div class="item-inner">
                                <div class="item-title item-label">홈페이지</div>
                                <div class="item-input-wrap">
                                    <input type="text" name="company_url" placeholder="홈페이지" value="{{$company->company_url}}" class=""
                                        >
                                    <span class="input-clear-button"></span>
                                </div>
                            </div>
                        </li>
                        <li class="item-content item-input">
                            <div class="item-inner">
                                <div class="item-title item-label">첨부파일</div>
                                <div class="item-input-wrap">
                                    <input type="file" name="select_file">
                                    <a href="/m-company-file?id={{$company->id}}&file=1" class="external">
                                        <div class="display-flex company_file_row">
                                            @if ( $company->company_attachment_file_url1)
                                            <div class="display-flex company_file_col-dn">
                                                <i class="material-icons">save_alt</i>
                                                <div>첨부파일 다운로드</div>
                                            </div>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="item-content item-input">
                            <div class="item-inner">
                                <div class="item-title item-label">회사 이미지</div>
                            </div>
                        </li>
                        <li class="item-content item-input"
                            style="padding-right: calc(var(--f7-list-item-padding-horizontal) + var(--f7-safe-area-left));">
                            <div class="company-image-wrap">
                                <div class="fn-preivew-upload" data-url="/m-user-cardsave" data-useform="off"
                                    data-inputname="select_img">
                                    <img src="{{$company->getImageUrl()}}" width=100%;>

                                </div>
                            </div>
                        </li>
                        <li class="item-content item-input" style="margin-top:15px;">
                            <div class="item-inner justify-content-flex-end">
                                <a href="#" class="button button-fill" style="padding-left: 15px;padding-right: 15px;"
                                    @click="save">수정</a>
                            </div>
                        </li>
                    </ul>
                
            </div>
</form>
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
        save : function(e) {
            var area = $$("#company-edit-form").find('.fn-preivew-upload');
            area = area[0];

            var self = this;
            $$.ajax({
                url:"/mobileapi/company/edit",
                method:"POST",
                data:new FormData( document.getElementById('company-edit-form') ),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(res)
                {
                    $$("input[type=file]").each( function () { $$(this).val('');});
                    $$(area).find('input[type=file]').val("");
                    $$(area).find('.fn-preivew-upload-closebtn').addClass("hide");
                    $$(area).children(".previwe-default-img").attr('src', $$(area).children("img.img-preview-cls").attr('src')
                    ).removeClass('hide');
                    $$(area).children("img.img-preview-cls").remove();
                    app.dialog.create({
                        title: self.title,
                        text: `수정 완료`,
                        buttons: [
                            {
                                text: '확인',
                            },
                        ],
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
        fnpreivewupload();
      },
    }
  }
</script>