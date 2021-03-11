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
        <div class="title">회원가입</div>
        <div class="right">
          <!--a href="#" class="link icon-only panel-open menu-icon"  style="margin-left:12px;" data-panel="left"-->
			<a href="/m/menu" class="link icon-only menu-icon">
            <i class="icon material-icons">menu</i>
          </a>
        </div>
      </div>
    </div>
    <div class="page-content">
		<div class="register-wrap">
	
@verbatim
			<div class="register-step-wrap ">
				<div class="register-step-1 {{#js_if "this.regstep == 1"}}active-step{{/js_if}}">01.약관동의</div>
				<div class="register-step-1 {{#js_if "this.regstep == 2"}}active-step{{/js_if}}">02.본인인증</div>
				<div class="register-step-1 {{#js_if "this.regstep == 3"}}active-step{{/js_if}}">03.정보입력</div>
				<div class="register-step-1 {{#js_if "this.regstep == 4"}}active-step{{/js_if}}">04.완료</div>
			</div>
		
@endverbatim
			
			
@verbatim
	{{#js_if "this.regstep == 1"}}
@endverbatim			
<!-- step 1 -->
<div class="register-step-wrap">
	<form id="register_step_1_form">		
		<div class="register-step-page register-step-page1">
			<div class="register_agree_wrap">
				<input type="checkbox" id="register-check-agree-all" @click='toggleagree'>
				Way2Expo 서비스 이용에 모두 동의합니다.
			</div>
			<div class="register_agree_service_wrap">
				<div class="register_agree_service_inner">
					<div class="register_agree_service_title">
						[필수] 서비스 약관동의
					</div>
					<div class="register_agree_service_txt_wrap">
						@include('mobile.inc.termsservice')
					</div>
					<div class="register_agree_check_wrap">
						<input type="checkbox" name="agree_service" value="Y"> 동의
					</div>
				</div>
				<div class="register_agree_service_inner">
					<div class="register_agree_service_title">
						[선택] 마켓팅 이용 동의
					</div>
					<div class="register_agree_service_txt_wrap">
						@include('mobile.inc.termsmarketting')
					</div>
					<div class="register_agree_check_wrap">
						<input type="checkbox" name="agree_marketing" value="Y"> 동의
					</div>
				</div>			
			</div>
		</div>
		<div class="register-nextstep-wrap">
			<div class="register-nextstep-btn" @click="nextstep">
				다음
			</div>
		</div>
	</form>
</div>	
<!-- / step 1 -->			
@verbatim
	{{/js_if}}
	{{#js_if "this.regstep == 2"}}
<!-- step 2 -->
			
<div class="register-step-wrap">
	<form id="register_step_2_form" name="form_chk" method="post" action="https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb">
		
    <input type="hidden" name="agree_service" value="{{agree_service}}">
		<input type="hidden" name="agree_marketing" value="{{agree_marketing}}">
		<input type="hidden" name="m" value="checkplusService">
		<input type="hidden" name="EncodeData" value="{{enc}}">
		<div class="register-step-page register-step-page2">
			<div class="register-step2_title1">가입여부와 실명확인을 위하여 아래 인증방법을 통해 인증해주세요.</div>
			<div class="register-step2_img">
				<a href="#" class="register-step2_img-link" @click="verification">휴대폰 본인인증</a>
			</div>
			<div class="register-step2_title2">인증이 완료되면 다음 화면으로 이동합니다.</div>
			<div class="register-step2_title3">본인 인증시 제공되는 정보는 해당 인증기관에서 직접 수집하며, 인증 이외의 용도로 이용 또는 저장되지 않습니다.</div>
		</div>
	</form>
</div>
<!-- / step 2 -->
	{{/js_if}}
	{{#js_if "this.regstep == 3"}}
<!-- step 3 -->
<div class="register-step-wrap">
	<form id="register_step_3_form">
		<input type="hidden" name="agree_service" value="{{agree_service}}">
		<input type="hidden" name="agree_marketing" value="{{agree_marketing}}">
		
		<div class="register-step-page register-step-page3">
			<div class="register_step_3_title1">
				기본 정보
			</div>
			<div class="register_step_3_info_wrap register_step_3_info1_wrap">
				<div class="register_step_3_row">
					<div class="register_step_3_info_th required">
						이름
					</div>
					<div class="register_step_3_info_td name+line">
						<input type="text" value="{{user_name}}" disabled>
					</div>
				</div>
				<div class="register_step_3_row">
					<div class="register_step_3_info_th required">
						이메일 주소
					</div>
					<div class="register_step_3_info_td email_line">
						<div class="item-input-wrap">
							<input type="text" name="email" placeholder="Email address" />
							<span class="input-clear-button"></span>
						  </div>
						<div class="register_step_3_btn_duplicate">
							중복확인
						</div>
					</div>
				</div>
				<div class="register_step_3_row">
					<div class="register_step_3_info_th required">
						휴대전화
					</div>
					<div class="register_step_3_info_td email_line">
						<input type="text" value="{{mobile_no}}" disabled>
					</div>
				</div>
				<div class="register_step_3_row">
					<div class="register_step_3_info_th">
						지역
					</div>
					<div class="register_step_3_info_td area_line">
						<div class="item-input-wrap input-dropdown-wrap">
							<select placeholder="지역" name="area">
							  <option value="">선택</option>
							{{#each areas}}
							  <option value="{{this}}">{{this}}</option>
							{{/each}}
							</select>
						 </div>
					</div>
				</div>
				<div class="register_step_3_row">
					<div class="register_step_3_info_th">
						연령대
					</div>
					<div class="register_step_3_info_td age_line">
						<div class="item-input-wrap input-dropdown-wrap">
							<select placeholder="연령대" name="age">
							  <option value="">선택</option>
							{{#each ages}}
							  <option value="{{this}}">{{this}}</option>
							{{/each}}
							</select>
						 </div>
					</div>
				</div>

				<div class="register_step_3_row">
					<div class="register_step_3_info_th required">
						비밀번호
					</div>
					<div class="register_step_3_info_td pwd_line">
						<div class="item-input-wrap">
							<input type="password" name="password" placeholder="비밀번호" />
							<span class="input-clear-button"></span>
						</div>
					</div>
				</div>	
				<div class="register_step_3_row">
					<div class="register_step_3_info_th">
						비밀번호 확인
					</div>
					<div class="register_step_3_info_td pwd_confirm_line">
						<div class="item-input-wrap">
							<input type="password" name="password_confirmation" placeholder="비밀번호 확인" />
							<span class="input-clear-button"></span>
						</div>
					</div>
				</div>					
			</div>
			
			<div class="register_step_3_title2">
				소속된 회사의 추가정보를 입력하시면 way2expo에서 출품업체와의 비즈니스 매칭 서비스를 제공해드립니다.
			</div>
			<div class="register_step_3_info_wrap register_step_3_info2_wrap">
				<div class="register_step_3_info2_header_wrap">
					<div class="register_step_3_info2_header_inner">
						<div class="register_step_3_info2_header_title">
							추가정보입력
						</div>
						<div class="register_step_3_info2_header_expander" @click="expander">
							{{#if expander_open}}
							<i class="material-icons">arrow_drop_up</i>
							{{else}}
							<i class="material-icons">arrow_drop_down</i>
							{{/if}}
						</div>
					</div>
				</div>
				<div class="register_step_3_info2_body_wrap {{#if expander_open}}opened{{else}}closed hide{{/if}}">
					<div class="register_step_3_info2_body_sub_title1">
						정확한 회사정보를 입력해주시면 [1:1 화상회의] 및 [비즈니스문의] 서비스 이용이 편리해 집니다.
					</div>
					<div class="register_step_3_info2_body_inner">
						
	<div class="register_step_3_row">
		<div class="register_step_3_info_th">
			관심분야
		</div>
		<div class="register_step_3_info_td interests_line">
			<div class="register_step_3_info_td_sub">
				최대 3개까지 중복선택가능
			</div>
			<div class="register_step_3_interests_wrap">
				
				
				
				<div class="register_step_3_interests_row">
					<div class="register_step_3_interests_th">
						분야1
					</div>
					<div class="register_step_3_interests_td1">
						<div class="item-input-wrap input-dropdown-wrap">
							<select placeholder="선택" name="category_pid1" @change="changeinterest" data-target="1">
							  <option value="">선택</option>
							  {{#each ../categories}}
							  <option value="{{id}}" data-code="{{code1}}">{{name}}</option>
							  {{/each}}
							</select>
						 </div>
					</div>
					<div class="register_step_3_interests_td2">
						<div class="item-input-wrap input-dropdown-wrap">
							<select placeholder="선택" name="category_id1">
							  <option value="">선택</option>
							  {{#each ../subselect1 }}
							  <option value="{{id}}" data-code="{{code1}}">{{name}}</option>
							  {{/each}}								
							</select>
						 </div>
					</div>
				</div>
				
				<div class="register_step_3_interests_row">
					<div class="register_step_3_interests_th">
						분야2
					</div>
					<div class="register_step_3_interests_td1">
						<div class="item-input-wrap input-dropdown-wrap">
							<select placeholder="선택" name="category_pid2" @change="changeinterest" data-target="2">
							  <option value="">선택</option>
							  {{#each ../categories}}
							  <option value="{{id}}" data-code="{{code1}}">{{name}}</option>
							  {{/each}}
							</select>
						 </div>
					</div>
					<div class="register_step_3_interests_td2">
						<div class="item-input-wrap input-dropdown-wrap">
							<select placeholder="선택" name="category_id2">
							  <option value="">선택</option>
							  {{#each ../subselect2 }}
							  <option value="{{id}}" data-code="{{code1}}">{{name}}</option>
							  {{/each}}								
							</select>
						 </div>
					</div>
				</div>
				
				<div class="register_step_3_interests_row">
					<div class="register_step_3_interests_th">
						분야3
					</div>
					<div class="register_step_3_interests_td1">
						<div class="item-input-wrap input-dropdown-wrap">
							<select placeholder="선택" name="category_pid3" @change="changeinterest" data-target="3">
							  <option value="">선택</option>
							  {{#each ../categories}}
							  <option value="{{id}}" data-code="{{code1}}">{{name}}</option>
							  {{/each}}
							</select>
						 </div>
					</div>
					<div class="register_step_3_interests_td2">
						<div class="item-input-wrap input-dropdown-wrap">
							<select placeholder="선택" name="category_id3">
							  <option value="">선택</option>
							  {{#each ../subselect3 }}
							  <option value="{{id}}" data-code="{{code1}}">{{name}}</option>
							  {{/each}}								
							</select>
						 </div>
					</div>
				</div>
					
			</div> <!-- /register_step_3_interests_wrap -->
			
		</div>
	</div> <!-- register_step_3_row 관심분야-->
						
						
						
	<div class="register_step_3_row">
		<div class="register_step_3_info_th">
			관람목적
		</div>
		<div class="register_step_3_info_td purpose_line">
			<div class="item-input-wrap input-dropdown-wrap">
				<select placeholder="선택" name="purpose_viewing">
				  <option value="">선택</option>
				{{#each purpose}}
				  <option value="{{this}}">{{this}}</option>
				{{/each}}

				</select>
			 </div>
		</div>
	</div>
	<div class="register_step_3_row">
		<div class="register_step_3_info_th">
			업종
		</div>
		<div class="register_step_3_info_td purpose_line">
			<div class="item-input-wrap input-dropdown-wrap">
				<select placeholder="선택" name="industry">
				  <option value="">선택</option>
							{{#each industry}}
							  <option value="{{this}}">{{this}}</option>
							{{/each}}
					
				</select>
			 </div>
		</div>
	</div>	
	<div class="register_step_3_row">
		<div class="register_step_3_info_th">
			기업명
		</div>
		<div class="register_step_3_info_td companyname_line">
			<div class="item-input-wrap">
				<input type="text" name="company_name" />
				<span class="input-clear-button"></span>
			</div>
		</div>
	</div>
	<div class="register_step_3_row">
		<div class="register_step_3_info_th">
			부서/직책
		</div>
		<div class="register_step_3_info_td companyposition_line">
			<div class="item-input-wrap">
				<input type="text" name="company_dept" />
				<span class="input-clear-button"></span>
			</div>
			<div class="item-input-wrap input-dropdown-wrap">
				<select placeholder="선택" name="company_position">
				  	<option value="">선택</option>
					{{#each company_position}}
					  <option value="{{this}}">{{this}}</option>
					{{/each}}

				</select>
			 </div>			
		</div>
	</div>
	<div class="register_step_3_row">
		<div class="register_step_3_info_th">
			기업 홈페이지
		</div>
		<div class="register_step_3_info_td companyhome_line">
			<div class="item-input-wrap">
				<input type="text" name="company_site" />
				<span class="input-clear-button"></span>
			</div>
		</div>
	</div>
	<div class="register_step_3_row">
		<div class="register_step_3_info_th">
			기업 전화번호
		</div>
		<div class="register_step_3_info_td companytel_line">
			<div class="item-input-wrap">
				<input type="text" name="company_tel" />
				<span class="input-clear-button"></span>
			</div>
		</div>
	</div>
	<div class="register_step_3_row">
		<div class="register_step_3_info_th">
			기업주소
		</div>
		<div class="register_step_3_info_td companyaddr_line">
			<div class="company_zip_line">
				<div class="item-input-wrap">
					<input type="text" name="company_zip" id="company_zip" />
				</div>
				<div class="register-zip-btn" @click="zip">
					우편번호
				</div>
			</div>
			<div class="item-input-wrap">
				<input type="text" name="company_address1" id="company_address1" />
			</div>
			<div class="item-input-wrap">
				<input type="text" name="company_address2" id="company_address2" />
			</div>
		</div>
	</div>
	<div class="register_step_3_row">
		<div class="register_step_3_info_th">
			소개글
		</div>
		<div class="register_step_3_info_td companyintro_line">
			<div class="item-input-wrap">
				<textarea name="intro">
				</textarea>
			</div>
		</div>
	</div>
					</div>
				</div>
			</div>
		</div>
		
		
	</form>
	<div class="register-nextstep-wrap">
		<div class="register-nextstep-btn" @click="step3">
			다음
		</div>
	</div>
</div>
<!-- / step 3 -->
	{{/js_if}}
	{{#js_if "this.regstep == 4"}}
<!-- step 4 -->
<div class="register-step-wrap">
	<div class="register-step4-inner">
		<div class="register-step-page register-step-page4">
			<div class="register-step4-title1">
				회원가입이 완료되었습니다.
			</div>
			<div class="register-step4-title2">
				박람회, 전시회로 가는 길! 여기는 Way2Expo 입니다.
			</div>
			<div class="register-step4-info-wrap">
				<div class="register-step4-info-inner">
					<div class="register-step4-info-row">
						<div class="register-step4-info-th">
							이름
						</div>
						<div class="register-step4-info-td">
							{{user_name}}
						</div>
					</div>
<div class="register-step4-info-row">
					<div class="register-step4-info-th">
							아이디 (이메일)
						</div>
						<div class="register-step4-info-td">
							{{user_id}}
						</div>
					</div>					
				</div>
			</div>
			<div class="register-step4-info-footer">
				<div class="register-step4-info-footer-inner">
					<a href="#" @click="gotohome" class="external register-btn-home">메인</a>
					<a href="/login" class="register-btn-login">로그인</a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- / step 4 -->
	{{/js_if}}	
@endverbatim		

		</div> 
    </div><!-- / page-content -->
  </div><!-- / page -->
	<style>
		.active-step{
			font-size:18px ;
			font-weight:800;
		}
		.register_step_3_info_td{position:relative;}
		.register_step_3_info_th{width:150px;}
		.register_step_3_info_td.email_line > input { min-width:30px;}
	</style>
</template>
<script>
  return {
    data: function () {
      return {
		  regstep : {{$data['step']}},
		  agree_service : "{{$data['agree_service']}}",
		  agree_marketing : "{{$data['agree_marketing']}}",
      user_name: "{{$data['cert']->name}}",
      mobile_no: "{{$data['cert']->mobile_no}}",
      enc : "",
        
		  user_id : "",
		  expander_open: true,
			  
		  areas : @json($areas),
		  ages : @json($ages),
		  interestsNo : ['1','2','3'],
		  categories : @json($category),
		  purpose : @json($purpose),
		  industry : @json($industry),
		  company_position : @json($company_position),
		  subcategories : @json($subcategory),
		  subselect1: null,
		  subselect2: null,
		  subselect3: null,
		  regdata : [{'name':'type', 'value':'reg'}],
      }
    },
    methods: {
		gotohome : function() {
			location.replace('/');
		},
	  	expander: function() {
			var self = this;
			var expander = true;
			if( self.expander_open) expander = false;
			self.$setState({
				expander_open : expander,
			})
		},
		changeinterest : function(e) {
			var self = this;
			
			var target = $$(e.target)
			var no = $$(target).data("target")
			var code = $$(target).children("option:selected").data("code")
			var obj = {}
			obj[ 'subselect'+no ] = self.subcategories[ code ]
			self.$setState(obj)
		},
		zip : function () {
			new daum.Postcode({
				oncomplete: function(data) {
					var roadAddr = data.roadAddress; // 도로명 주소 변수
					var extraRoadAddr = ''; // 참고 항목 변수
					if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
						extraRoadAddr += data.bname;
					}
					if(data.buildingName !== '' && data.apartment === 'Y'){
					   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
					}
					if(extraRoadAddr !== ''){
						extraRoadAddr = ' (' + extraRoadAddr + ')';
					}
					document.getElementById('company_zip').value = data.zonecode;
                	document.getElementById("company_address1").value = roadAddr;
					
					if(roadAddr !== ''){
						document.getElementById("company_address2").value = extraRoadAddr;
					} else {
						document.getElementById("company_address2").value = '';
					}
				}
			}).open();
		},
		nextstep : function() {
	  		var self = this;
			if( self.regstep==1) self.step1();
			return ;
		},
		nextstepprc : function() {
			var self = this;
			self.$setState({
				regstep : ++self.regstep,
			})
		},
		step1 : function () {
			var self = this;
			if($$("input[name=agree_service]:checked").val() != 'Y'){
				toastmessage("서비스약관에 동의해주세요");
				return;
			}
			let arr = $$("#register_step_1_form").serializeArray() 
			self.regdata = self.regdata.concat( arr );
			self.$setState({
				agree_service : ($$("input[name=agree_service]").prop("checked") ? 'Y':'N'),
        agree_marketing : ($$("input[name=agree_marketing]").prop("checked") ? 'Y':'N')
			})      
			self.nextstepprc();
		},
		step3 : function() {
			var self = this;
			$$.ajax({
			   url:"/mobile/register",
			   method:"POST",
			   data: $$("#register_step_3_form").serialize(),
			   success:function(res)
			   {
				 console.log (res);
			   self.$setState({
					regstep : 4,
				    user_name : res.data.name,
				    user_id : res.data.email,
				})
			  },
			   error: function ( err ){
				 console.log ( "error")
				 ajaxError(err);
			   }
			 });			
		},
		toggleagree : function(e) {
			var checked = $$(e.target).prop('checked')
			if( checked ) $$("#register_step_1_form input[type=checkbox]").each( function() {$$(this).prop("checked",true) })
			else $$("#register_step_1_form input[type=checkbox]").each( function() {$$(this).prop("checked",false) })
		},
		verification : function() {
			var self = this;
      //$$("#register_step_2_form").submit();
			$$.ajax({
			   url:"/mobile/nice",
			   method:"POST",
			   data: $$("#register_step_2_form").serialize(),
			   success:function(res)
			   {
				   if ( res != "false"){
                  self.$setState({
                    enc : res,
                  });
             setTimeout( function() {$$("#register_step_2_form").submit();}, 100 );
           }
			  },
			   error: function ( err ){
				 console.log ( "error")
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
		 $$(".panel.panel-right").empty();
      },
    }
  }
</script>
