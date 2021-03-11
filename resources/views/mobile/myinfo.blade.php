<template>
  <div class="page page-myinfo" data-name="myinfo">
    <div class="navbar navbar-new">
      <div class="navbar-bg"></div>
      <div class="navbar-inner sliding">
        <div class="left">
          <a href="#" class="link back">
            <i class="icon icon-back"></i>
            <span class="if-not-md">Back</span>
          </a>
        </div>
        <div class="title">내 정보</div>
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

@verbatim
	{{#if passwordcheck}}
@endverbatim		
		
      <div class="my-info-block">
        <form id="myinfo-myinform">
          <div class="myinfo-inner-wrap">
            <div class="block-title">기본정보</div>
            <div class="list no-last-li-hairlines" style="margin-bottom: 10px;">
              <ul>
                <li class="item-content item-input item-input-outline">
                  <div class="item-title box-item-label">이메일</div>
                  <div class="item-inner">
                    
                    <div class="item-input-wrap">
                      <input type="text" class="" value="{{$user->email}}" disabled>
                    </div>
                  </div>
                </li>
                <li class="item-content item-input item-input-outline">
                  <div class="item-title box-item-label">이름</div>
                  <div class="item-inner">
                    
                    <div class="item-input-wrap">
                      <input type="text" class="" name="name" value="{{$user->name}}" disabled>
                      <!--span class="input-clear-button"></span-->
                    </div>
                  </div>
                </li>
                <li class="item-content item-input item-input-outline item-myinfo-hp">
                  <div class="item-title box-item-label">휴대전화</div>
                  <div class="item-inner">
                    <div class="item-input-wrap">
                      <input type="text" class="myinfo_hp" value="{{$user->tel}}" readonly>
                    </div>
                  </div>
                  <a href="#" @click="changehp" class="button button-fill" style="background-color: #5278b7;padding-left:10px;padding-right:10px;">변경</a>
                </li>

				  
                <li class="item-content item-input item-input-outline">
                  <div class="item-title box-item-label">지역</div>
                  <div class="item-inner">
                    
                    <div class="item-input-wrap">
                      <select name="area">
						  <option value="">선택</option>
						  @foreach( $areas as $area )
						  <option value="{{$area}}"
							@if ( $area == $user->meta->area)
							  selected
							@endif
						   >{{$area}}</option>
						  @endforeach
					  </select>
                    </div>
                  </div>
                </li>
                <li class="item-content item-input item-input-outline">
                  <div class="item-title box-item-label">연령대</div>
                  <div class="item-inner">
                    
                    <div class="item-input-wrap">
                      <select name="age">
						  <option value="">선택</option>
						  @foreach( $ages as $age )
						  <option value="{{$age}}"
							@if ( $age == $user->meta->age)
							  selected
							@endif
						   >{{$age}}대</option>
						  @endforeach
					  </select>
                    </div>
                  </div>
                </li>
				  
                <li class="item-content item-input item-input-outline">
                  <div class="item-title box-item-label">카카오연동</div>
                  <div class="item-inner">
                    
                    <div class="item-kakaoconnect-wrap">
						@verbatim
							{{#if sns}}
						<div class="item-kakaoconnect-connected">
							연동됨
						</div>
						<div class="item-kakaoconnect-Disconnection" @click="kakaodisconnect">
							연동해제
						</div>						
							{{else}}
						<a class="item-kakaoconnect-connect external" href="/mobile/social/kakao" >
							연동하기
						</a>
							{{/if}}
						@endverbatim
                    </div>
					  
                  </div>
                </li>

			  <li class="item-content item-input item-input-outline">
                  <div class="item-title box-item-label">마케팅 수신동의</div>
                  <div class="item-inner">
                    <div class="item-marketing-wrap">
						<div class="item-marketing-checkwrap">
							<input type="checkbox" value="Y" name="agree_marketing">	
							<label>동의함</label>
						</div>
						<a href="/m/marketing" class="">내용보기</a>
                    </div>
                  </div>
                </li>
				  
                <li class="item-content item-input item-input-outline justify-content-flex-end" style="padding:4px 15px;">
                  <a href="#" @click="myInfoSave" class="button button-fill" style="background-color: #5278b7;padding-left:10px;padding-right:10px;">수정</a>
                </li>
              </ul>
            </div>

          </div>
        </form>
      </div>
@verbatim
      <div class="my-info-block">
        <form id="myinfo-password">
          <div class="myinfo-inner-wrap">		  
            <div class="block-title" @click="toggle('pwd')">
				<span>비밀번호 변경</span>
				{{#js_if "this.showPassword == false "}}
				<i class="icon material-icons">expand_more</i>
				{{/js_if}}
				{{#js_if "this.showPassword == true "}}
				<i class="icon material-icons">expand_less</i>
				{{/js_if}}
			</div>
            <div class="list no-last-li-hairlines" style="margin-bottom: 10px;">
              <ul class="
					{{#js_if "this.showPassword == false "}}
						 hide
					{{/js_if}}
				">
                <li class="item-content item-input item-input-outline">
                  <div class="item-inner">
                    <div class="item-title item-floating-label">현재 비밀번호</div>
                    <div class="item-input-wrap">
                      <input type="password" class="" name="current_password">
                    </div>
                  </div>
                </li>
                <li class="item-content item-input item-input-outline">
                  <div class="item-inner">
                    <div class="item-title item-floating-label">변경할 비밀번호</div>
                    <div class="item-input-wrap">
                      <input type="password" class="" name="password">
                      <!--span class="input-clear-button"></span-->
                    </div>
                  </div>
                </li>
                <li class="item-content item-input item-input-outline">
                  <div class="item-inner">
                    <div class="item-title item-floating-label">비밀번호 확인</div>
                    <div class="item-input-wrap">
                      <input type="password" class="" name="password_confirmation">
                      <span class="input-clear-button"></span>
                    </div>
                  </div>
                </li>
                <li class="item-content item-input item-input-outline justify-content-flex-end" style="padding:4px 15px;">
                  <a href="#" @click="myPassword" class="button button-fill" style="background-color: #5278b7;padding-left:10px;padding-right:10px;">수정</a>
                </li>
              </ul>
            </div>

          </div>
        </form>
      </div>
@endverbatim		

 <div class="my-info-block">
	<form id="myinfo-additional">
		<div class="myinfo-inner-wrap">
		@verbatim
			<div class="block-title" @click="toggle('additional')">
				<span>추가정보</span>
				{{#js_if "this.showadditional == false "}}
				<i class="icon material-icons">expand_more</i>
				{{/js_if}}
				{{#js_if "this.showadditional == true "}}
				<i class="icon material-icons">expand_less</i>
				{{/js_if}}				
			</div>
			<div class="list no-last-li-hairlines">
				<ul class="
					{{#js_if "this.showadditional == false "}}
						 hide
					{{/js_if}}
				">
        @endverbatim

<li class="item-content item-input item-input-outline">
  <div class="item-title box-item-label">업종</div>
  <div class="item-inner">
	<div class="item-input-wrap">
	  <select name="industry">
		<option value="">선택</option>
		 @foreach( $industry as $row)
		  <option value="{{$row}}"
			@if ( $row == $user->meta->industry )
				  selected
			@endif
				  >{{$row}}</option>
		 @endforeach
	  </select>
	</div>
  </div>
</li>
<li class="item-content item-input item-input-outline">
  <div class="item-title box-item-label">기업명</div>
  <div class="item-inner">
	<div class="item-input-wrap">
	  <input type="text" name="company_name" value="{{$user->meta->company_name}}" />
	</div>
  </div>
</li>	
	
<li class="item-content item-input item-input-outline">
  <div class="item-title box-item-label">기업 홈페이지</div>
  <div class="item-inner">
	<div class="item-input-wrap">
	  <input type="text" name="company_site" value="{{$user->meta->company_site}}" />
	</div>
  </div>
</li>
<li class="item-content item-input item-input-outline">
  <div class="item-title box-item-label">기업 전화번호</div>
  <div class="item-inner">
	<div class="item-input-wrap">
	  <input type="text" name="company_tel" value="{{$user->meta->company_tel}}" />
	</div>
  </div>
</li>
<li class="item-content item-input item-input-outline">
  <div class="item-title box-item-label">기업 주소</div>
  <div class="item-inner">
		<div class="myinfo_td companyaddr_line">
			<div class="company_zip_line">
				<div class="item-input-wrap">
					<input type="text" name="company_zip" id="company_zip" value="{{$user->meta->company_zip}}" />
				</div>
				<div class="register-zip-btn" @click="zip">
					우편번호
				</div>
			</div>
			<div class="item-input-wrap">
				<input type="text" name="company_address1" id="company_address1"
					   value="{{$user->meta->company_address1}}" />
			</div>
			<div class="item-input-wrap">
				<input type="text" name="company_address2" id="company_address2"
					   value="{{$user->meta->company_address2}}" />
			</div>
		</div>
  </div>
</li>					
<li class="item-content item-input item-input-outline">
  <div class="item-title box-item-label">소개글</div>
  <div class="item-inner">
	<div class="item-input-wrap">
	  <textarea name="intro">{{$user->meta->intro}}</textarea>
	</div>
  </div>
</li>	
<li class="item-content item-input item-input-outline">
  <div class="item-title box-item-label">부서/직책</div>
  <div class="item-inner">
	<div class="item-input-wrap">
	  <div class="myinfo_td companyposition_line">
			<div class="item-input-wrap">
				<input type="text" name="company_dept" value="{{$user->meta->company_dept}}" />
				<span class="input-clear-button"></span>
			</div>
			<div class="item-input-wrap input-dropdown-wrap">
				<select placeholder="선택" name="company_position">
				  	<option value="">선택</option>
					@foreach ( $company_position as $pos)
					<option value="{{$pos}}"
						@if ( $pos == $user->meta->company_position )
							  selected
						@endif
						>{{$pos}}</option>
					@endforeach
				</select>
			 </div>			
		</div>
	</div>
  </div>
</li>						
@verbatim					
<li class="item-content item-input item-input-outline myinfo_interests">
  <div class="item-title box-item-label">관심분야1</div>
  <div class="myinfo_interests-item-inner">
		<div class="myinfo_interests_td1">
			<div class="item-input-wrap input-dropdown-wrap">
				<select placeholder="선택" name="category_pid1" @change="changeinterest" data-target="1">
				  <option value="">선택</option>
				  {{#each ../categories}}
				  <option value="{{id}}" data-code="{{code1}}"
					{{#js_if " this.id == @root.category_pid1 "}}
					  selected
					{{/js_if}}
				  >{{name}}</option>
				  {{/each}}
				</select>
			 </div>
		</div>
		<div class="myinfo_interests_td2">
			<div class="item-input-wrap input-dropdown-wrap">
				<select placeholder="선택" name="category_id1">
				  <option value="" selected>선택</option>
				  {{#each ../subselect1 }}
				  <option value="{{id}}" data-code="{{code1}}"
						  {{#js_if " this.id == @root.category_id1 "}}
						  selected
						  {{/js_if}}
						  >{{name}}</option>
				  {{/each}}								
				</select>
			 </div>
		</div>		  
  </div>
</li>
<li class="item-content item-input item-input-outline myinfo_interests">
  <div class="item-title box-item-label">관심분야2</div>
  <div class="myinfo_interests-item-inner">
		<div class="myinfo_interests_td1">
			<div class="item-input-wrap input-dropdown-wrap">
				<select placeholder="선택" name="category_pid2" @change="changeinterest" data-target="2">
				  <option value="">선택</option>
				  {{#each ../categories}}
				  <option value="{{id}}" data-code="{{code1}}"
					{{#js_if " this.id == @root.category_pid2 "}}
					  selected
					{{/js_if}}
						  >{{name}}</option>
				  {{/each}}
				</select>
			 </div>
		</div>
		<div class="myinfo_interests_td2">
			<div class="item-input-wrap input-dropdown-wrap">
				<select placeholder="선택" name="category_id2">
				  <option value="">선택</option>
				  {{#each ../subselect2 }}
				  <option value="{{id}}" data-code="{{code1}}"
					{{#js_if " this.id == @root.category_id2 "}}
					  selected
					{{/js_if}}
					>{{name}}</option>
				  {{/each}}								
				</select>
			 </div>
		</div>		  
  </div>
</li>
<li class="item-content item-input item-input-outline myinfo_interests">
  <div class="item-title box-item-label">관심분야3</div>
  <div class="myinfo_interests-item-inner">
		<div class="myinfo_interests_td1">
			<div class="item-input-wrap input-dropdown-wrap">
				<select placeholder="선택" name="category_pid3" @change="changeinterest" data-target="3">
				  <option value="">선택</option>
				  {{#each ../categories}}
				  <option value="{{id}}" data-code="{{code1}}"
					{{#js_if " this.id == @root.category_pid3 "}}
					  selected
					{{/js_if}}
						  >{{name}}</option>
				  {{/each}}
				</select>
			 </div>
		</div>
		<div class="myinfo_interests_td2">
			<div class="item-input-wrap input-dropdown-wrap">
				<select placeholder="선택" name="category_id3">
				  <option value="">선택</option>
				  {{#each ../subselect3 }}
				  <option value="{{id}}" data-code="{{code1}}"
				    {{#js_if " this.id == @root.category_id3 "}}
					  selected
					{{/js_if}}
						  >{{name}}</option>
				  {{/each}}								
				</select>
			 </div>
		</div>		  
  </div>
</li>
@endverbatim
<li class="item-content item-input item-input-outline">
  <div class="item-title box-item-label">관람목적</div>
  <div class="item-inner">
	<div class="item-input-wrap">
	  <select name="purpose_viewing">
		<option value="">선택</option>
		 @foreach( $purpose as $row)
		  <option value="{{$row}}"
			@if ( $row == $user->meta->purpose_viewing )
				  selected
			@endif
				  >{{$row}}</option>
		 @endforeach
	  </select>
	</div>
  </div>
</li>
                <li class="item-content item-input item-input-outline justify-content-flex-end" style="padding:4px 15px;">
                  <a href="#" @click="myadditional" class="button button-fill" style="background-color: #5278b7;padding-left:10px;padding-right:10px;">수정</a>
                </li>					
					
				</ul>
			</div>
		</div>
	</form>
</div>		
		
		
		
@verbatim		
	{{else}} <!-- 비밀번호 확인 창 -->
		<div class="password_check_wrap">
			<div class="password_check_inner">
				<div class="password_check_title">
					비밀번호 확인
				</div>
				
				<div class="password_check_content_wrap">

					<div class="password_check_content_input">
						<div class="list no-last-li-hairlines">
							<ul>
								<li class="item-content item-input item-input-outline">
									<div class="item-title box-item-label">비밀번호</div>
									<div class="item-inner">

									<div class="item-input-wrap">
									  <input type="password" class="" name="password_check">
									</div>
									</div>
								</li>
							</ul>
						</div>							
					</div>
				</div>
				<div class="password_check_btn_wrap">
					<div class="password_check_btn" @click="pwdcheck">
						체크
					</div>					
				</div>

			</div>
		</div>	
	{{/if}}
    <form name="chnagehp" method="post" action="https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb">
      	<input type="hidden" name="m" value="checkplusService">
		    <input type="hidden" name="EncodeData" value="{{enc}}">
    </form>
@endverbatim			
				
    </div><!-- / page-content -->

  </div><!-- / page -->
	<style>
			.toggle_icon_down > .expand_less {
		display:none;
	}
	.toggle_icon_up > .expand_more {
		display:none;
	}	
	</style>
</template>
<script>
  return {
    data: function () {
      return {
        enc : '',
        passwordcheck : true,
        sns : @if ($user->kakao_id > 0 ) true @else false @endif ,
        showPassword : false,
        showadditional : true,
        categories : @json($category),
        subcategories : @json($subcategory),
        subselect1: null,
        subselect2: null,
        subselect3: null,
        category_pid1 : '{{$user->meta->category_pid1}}',
        category_id1 : '{{$user->meta->category_id1}}',
        category_pid2 : '{{$user->meta->category_pid2}}',
        category_id2 : '{{$user->meta->category_id2}}',
        category_pid3 : '{{$user->meta->category_pid3}}',
        category_id3 : '{{$user->meta->category_id3}}',
      }
    },
    methods: {
      changehp : async function () {
        var self = this;
        const { data } = await axios.get('/mobile/change/hp');
        self.$setState({
          enc : data,
        })
        setTimeout( function() {$$("form[name='chnagehp']").submit();}, 100 );
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
		changeinterest : function(e) {
			var self = this;
			
			var target = $$(e.target)
			var no = $$(target).data("target")
			if ( self['category_pid'+no] == '' ){
				$$("select[name=category_id"+no+"] option:first-child").prop("selected", true);	
			}
			
			var code = $$(target).children("option:selected").data("code")
			var obj = {}
			obj[ 'subselect'+no ] = self.subcategories[ code ];
			obj[ 'category_pid'+no ] = '';
			obj[ 'category_id'+no ] = '';
			self.$setState(obj)
		},
		toggle : function (e){
			var self = this;
			if( e =='pwd'){
				let toggle = true;
				if ( self.showPassword ) toggle = false;
				self.$setState({
					showPassword : toggle,
				})		
			}else if ( e =='additional'){
				let toggle = true;
				if ( self.showadditional ) toggle = false;
				self.$setState({
					showadditional : toggle,
				})		
			}
		},
		kakaodisconnect : function() {
			var self = this;
			var url = "/mobileapi/disconnect/kakao";
			$$.ajax({
			   url:url,
			   method:"POST",
			   dataType:'json',
			   success:function(res)
			   {
				self.$setState({
					sns : false,
				  })
				 console.log (self.sns )
				 console.log (self.passwordcheck )
			   },
			   error: function ( err ){
				 ajaxError(err);
			   }
			 });			
		},
	  pwdcheck: function(){
		  var self = this;
        $$.ajax({
           url:"/mobileapi/checkpwd",
           method:"POST",
           dataType:'json',
           data:{password_check : $$("input[name=password_check]").val()},
           success:function(res)
           {
			   if( res.success ){
				self.$setState({
					passwordcheck : true,
				  })	   
			   }else toastmessage("비밀번호를 확인해주세요")
		     
           },
           error: function ( err ){
             ajaxError(err);
           }
         });
		  
	  
	  },
      cardsave: function() {
		
        $$.ajax({
           url:"/mobileapi/my/card/save",
           method:"POST",
           dataType:'json',
           data:$$("#myinfo-mycard").serialize(),
           success:function(res)
           {
             toastmessage('저장되었습니다.')
			 
           },
           error: function ( err ){
             ajaxError(err);
           }
         });
      },
      myInfoSave: function() {
        $$.ajax({
           url:"/mobileapi/myinfo/edit",
           method:"POST",
           dataType:'json',
           data:$$("#myinfo-myinform").serialize(),
           success:function(res)
           {
             toastmessage('저장되었습니다.')
           },
           error: function ( err ){
             ajaxError(err);
           }
         });
      },
	  myadditional : function() {
        $$.ajax({
          url:"/mobileapi/myinfo/additional",
          method:"POST",
          dataType:'json',
          data:$$("#myinfo-additional").serialize(),
          success:function(res)
          {
            toastmessage('변경되었습니다.')
            $("input[type=password]").val('')
          },
          error: function ( err ){
            ajaxError(err);
          }
        });		  
	  },
      myPassword: function() {
        $$.ajax({
          url:"/user/password",
          method:"PUT",
          dataType:'json',
          data:$$("#myinfo-password").serialize(),
          success:function(res)
          {
            toastmessage('변경되었습니다.')
            $("input[type=password]").val('')
          },
          error: function ( err ){
            ajaxError(err);
          }
        });
      },
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
		$$(".page-previous[data-name='cardexcnahgehpage']").remove();
      },
      pageInit: function () {
        var self = this;
        var today = new Date();
        var app = self.$app;

        if( $$(".after-slash.hide").length < 1 ){
          $$(".after-slash").removeClass('slash-hide');
        }else $$(".after-slash").addClass('slash-hide');
		
		 
		for ( var i =0; i < self.categories.length ;i++ ){
			if (self.categories[i].id == self.category_pid1){
				self.$setState({
				subselect1 : self.subcategories[ self.categories[i].code1 ],
			  })
			}
			if (self.categories[i].id == self.category_pid2){
				self.$setState({
				subselect2 : self.subcategories[ self.categories[i].code1 ],
			  })
			}
			if (self.categories[i].id == self.category_pid3){
				self.$setState({
				subselect3 : self.subcategories[ self.categories[i].code1 ],
			  })
			}
		}
		 
        $(".cardfill").on( "keyup", function (e) {
          let str = $(this).val();
          let target = $$(this).data('target');
          let hide = $$(target).data('hide');
          let nonestr = $$(target).data('none');

          if (str == ''){
            if( hide == 'self') {
              console.log ( "self hide")
              $$(target).addClass("hide");
            }
            else if (hide=='parent') {
              console.log ( "parent hide")
              $$(target).parent().addClass("hide");}
            else $$(target).text( nonestr) ;
          }else {
            if( hide == "self") {
              $$(target).removeClass("hide");
            }
            else if (hide=='parent') {
              $$(target).parent().removeClass("hide");
            }
            $$(target).text( str) ;
          }
          if( $$(".after-slash.hide").length < 1 ){
            $$(".after-slash").removeClass('slash-hide');
          }else $$(".after-slash").addClass('slash-hide');
        })
        fnpreivewupload()
		  setTimeout( function() {$$(".page-previous[data-name='cardexcnahgehpage']").remove();},1000);
      },
    }
  }
</script>
