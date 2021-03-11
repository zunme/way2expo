@verbatim
<template>
  <div class="page page-finduser" data-name="finduser">
    
    <div class="page-content page-finduser-content">
      <div class="finduser_wrap">
          <a href="#" class="link back">
            <i class="material-icons">close</i>
          </a>
        <div class="finduser_inner">
          
          <div class="finduser_segment_wrap">
            <div class="segmented">
              <a class="button {{#js_if " this.type != 'pwd' " }}button-active{{/js_if}}" data-tab="findid" @click="segmentbtn">아이디 찾기</a>
              <a class="button {{#js_if " this.type == 'pwd' " }}button-active{{/js_if}}" data-tab="findpwd" @click="segmentbtn">비밀번호찾기</a>
            </div>
          </div>
          <div class="tabs finduser_segment_tabs">
            <div class="tab {{#js_if " this.type != 'pwd' " }}tab-active{{/js_if}}" data-tab="findid">
              <div class="finduser_segment_tab_wrap">
                {{#js_if " this.type == 'id' " }}
                  {{#unless res}}
                    <div class="finduser_segment_tab_find_error">
                      일치하는 정보가 없습니다.
                    </div>
                  {{else}}
                    <div class="finduser_segment_tab_findres1">
                      고객님의 아이디는 
                    </div>
                    <div class="finduser_segment_tab_findres1">
                      {{finddata}} 
                    </div>
                    <div class="finduser_segment_tab_findres1">
                      입니다
                    </div>
                    <div class="finduser_segment_tab_findres_login">
                      <a href="/m/login">로그인</a>
                    </div>
                  {{/unless}}
                {{/js_if}}
                {{#js_if " this.type != 'id' " }}
                <div class="finduser_segment_tab_desc1">
                  아이디 찾기를 위해 본인인증을 진행해주세요
                </div>
                <div class="finduser_segment_tab_btn">
                  <a href="#" @click="findid">
                    본인인증
                  </a>
                </div>
                <div class="finduser_segment_tab_desc2">
                  본인인증 시 제공되는 정보는 해당 인증기관에서 직접 수집하며,
                  인증 이외의 용도로 이용 또는 저장되지 않습니다.
                </div>
                {{/js_if}}
              </div>
            </div>
            <div class="tab {{#js_if " this.type == 'pwd' " }}tab-active{{/js_if}}" data-tab="findpwd">
              <div class="finduser_segment_tab_wrap">
                {{#unless changed}}
                  {{#js_if " this.type == 'pwd' && !this.res" }}
                  <div class="finduser_segment_tab_pwd_ERROR">
                    비밀번호 찾기에 실패하였습니다
                  </div>
                  {{/js_if}}
                  {{#unless prdprc}}
                  <div class="finduser_segment_tab_pwd_desc1">
                    비밀번호 찾기를 위해 아이디 입력과 본인인증을 진행해주세요
                  </div>
                  <div class="finduser_segment_tab_input wrap">
                      <div class="item-input-wrap">
                        <input type="text" name="useremail">
                      </div>                  
                  </div>
                  <div class="finduser_segment_tab_pwd_btn">
                    <a href="#" @click="findpwd">
                      본인인증
                    </a>
                  </div>
                  <div class="finduser_segment_tab_pwd_desc2">
                    본인인증 시 제공되는 정보는 해당 인증기관에서 직접 수집하며,
                    인증 이외의 용도로 이용 또는 저장되지 않습니다.
                  </div> 
                  {{else}}
                  <form id="chnagepwdform">
                    <div class="finduser_segment_tab_pwd_desc1">
                      비밀번호를 재설정해 주시기 바랍니다.
                    </div>
                    <div class="finduser_segment_tab_input wrap">
                        <div class="item-input-wrap">
                          <input type="password" name="password">
                        </div> 
                    </div>
                    <div class="finduser_segment_tab_input wrap">
                        <div class="item-input-wrap">
                          <input type="password" name="password_confirmation">
                        </div>
                    </div>                  
                    <div class="finduser_segment_tab_pwd_btn">
                      <a href="#" @click="changepwd">
                        확인
                      </a>
                    </div>
                    <div class="finduser_segment_tab_pwd_desc2">
                      본인인증 시 제공되는 정보는 해당 인증기관에서 직접 수집하며,
                      인증 이외의 용도로 이용 또는 저장되지 않습니다.
                    </div>                   
                  </form>
                  {{/unless}}
                {{else}}
                <div class="finduser_change_pwd_completed">
                  비밀번호를 재설정이 완료되었습니다.
                </div>
                <div class="finduser_change_pwd_completed_btn_wrap">
                  <a href="/m/login" class="finduser_login_btn" >로그인</a>
                  <a href="/" class="external finduser_home_btn">메인</a>
                </div>
                {{/unless}}
                
              </div>
            </div>
          </div>
        </div>
      </div>
      
      
      <form id="register_step_2_form" name="form_chk" method="post" action="https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb">
        <input type="hidden" name="m" value="checkplusService">
        <input type="hidden" name="EncodeData" value="{{enc}}">
      </form>
      
      
    </div><!-- / page-content -->
  </div><!-- / page -->
</template>
<script>
  return {
    data: function () {
      return {
		    enc : "",
@endverbatim
        type : "{{$result['type']}}",
        finddata : "{{$result['find']}}",
        msg : "{{$result['msg']}}",
        res : {{ $result['res'] ? 'true' : 'false' }},
        prdprc : {{  $result['type']=='pwd' && $result['res'] ? 'true' : 'false' }} ,
        changed : false,
@verbatim
      }
    },
    methods: {
      segmentbtn : (e)=>{
        var self = this;
        
        var datatab = $(e.target).data('tab');
        
        $(e.target).parent().find(".button").removeClass('button-active');
        $(e.target).addClass('button-active');
        
        $$(".finduser_segment_tabs > .tab").removeClass("tab-active");
        $$(".finduser_segment_tabs > .tab[data-tab='"+ datatab +"']").addClass("tab-active");
      },
      findid : async function () {
        var self = this;
        const { data } = await axios.get('/mobile/finduser/id');
        self.$setState({
          enc : data,
        })
        setTimeout( function() {$$("#register_step_2_form").submit();}, 100 );
      },
      findpwd : async function () {
        var self = this;
        var email = $("input[name='useremail']").val() ;
        const { data } = await axios.get('/mobile/finduser/pwd',{ params: { 'email': email } });
        self.$setState({
          enc : data,
        })
        setTimeout( function() {$$("#register_step_2_form").submit();}, 100 );
      },
      changepwd: function () {
        var self = this;
        $$.ajax({
           url: '/mobile/finduser/changepwdprc',
           method:"POST",
           data: $$("#chnagepwdform").serialize(),
           dataType:'JSON',
           success:function(res)
           {
              self.$setState({
                changed : true,
              })
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
@endverbatim