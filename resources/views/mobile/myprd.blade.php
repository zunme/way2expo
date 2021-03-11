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
        <div class="title">상품관리</div>
        <div class="right">

          <a href="/m/menu" class="link icon-only menu-icon">
            <i class="icon material-icons" >menu</i>
          </a>
        </div>
      </div>
    </div>
    <div class="page-content">
			<div class="list no-hairlines-md mt-0 mb-0">
				<ul>
					<li class="item-content item-input item-input-with-value">
						<div class="item-inner">
							<div class="item-title item-label">부스</div>
							<div class="item-input-wrap input-dropdown-wrap">
								<select id="prd_select_booth" name="prd_select_booth" class="input-with-value" @change="changeselect">
									<option value="">부스를 선택해주세요</option>
									@foreach( $booths as $booth)
									<option value="{{$booth->id}}" 
											@if( $booth->id == $booth_id)
										selected 
											@endif
									>[{{$booth->expoBooth->expo_name}}]{{$booth->booth_title}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</li>
				</ul>
			</div><!-- /booth list-->
		<div class="display-flex justify-content-flex-end myprd_menu_wrap" >
			<a class="button popup-open" href="#" @click="toggleCopy"><i class="material-icons">content_copy</i></a>
			
			<a class="button"  @click="addurl"><i class="material-icons">library_add</i></a>
		</div>
		

		<div id="prd_my_list" class="list media-list product-list">
			<div class="expo_booth_ready_wrap">
				<div class="expo_booth_ready_inner">
					부스를 선택해주세요.
				</div>
			</div>
	  	</div>
		<div id="prd_my_page">
			
	  	</div>
		
		
		
		
		
		
		
		
		
		
		
			<!-- popup-->
<div class="popup demo-popup-swipe-handler myprd_copy_popup">
	<div class="page">
		<div class="toolbar toolbar-bottom">
			<div class="toolbar-inner">
			<a class="link"></a>
			<a class="link" @click="copyprc">상품복사</a>
			</div>
		</div>
		
		<div class="swipe-handler myprd_copy_swipe-handler">
		</div>
		<div class="page-content">

<!-- copy -->
			<div class="myprd_copy_toggle_wrap">
				<div class="myprd_copy_toggle_inner">
					<div class="list no-hairlines-md mt-0 mb-0">
						<ul>
							<li class="item-content item-input item-input-with-value">
								<div class="item-inner">
									<div class="item-title item-label">복사할 부스</div>
									<div class="item-input-wrap input-dropdown-wrap">
										<select id="prd_copy_select_booth" name="prd_copy_select_booth" class="input-with-value" @change="changeCopyBooth">
											<option value="">복사할 부스를 선택해주세요</option>
											@foreach( $booths as $booth)
											<option value="{{$booth->id}}">
												[{{$booth->expoBooth->expo_name}}]{{$booth->booth_title}}
											</option>
											@endforeach
										</select>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div id="prd_my_list_copy" class="list media-list product-list">
				<div class="expo_booth_ready_wrap">
					<div class="expo_booth_ready_inner">
						복사할 부스를 선택해주세요.
					</div>
				</div>
			</div>
			<div id="prd_my_page_copy">
			
	  		</div>
			<!-- /copy -->			
			
		</div><!-- /popup page-content -->
	</div>
</div>
	<!-- /popup -->
		
    </div><!-- / page-content -->
	  
	  
  </div><!-- / page -->
</template>

<script>
  return {
    data: function () {
      return {
		  popupSwipeHandler : null,
		  isChange : false,
		  boothId : {{$booth_id}},
		  
		  page : 1,
		  compiled_prd : null,
		  nonepage :`			<div class="expo_booth_ready_wrap">
				<div class="expo_booth_ready_inner">
					등록된 제품이 없습니다.
				</div>
			</div>`,
		  prdtemplate : `
	@verbatim 
	<ul>
		{{#each products}}
{{#js_if "this.prd_use_yn == 'N' "}}
		<li class="prd_display_not">
{{/js_if}}

{{#js_if "this.prd_use_yn == 'Y' && this.prd_display_yn == 'Y' "}}
		<li class="prd_display_on">
{{/js_if}}

{{#js_if "this.prd_use_yn == 'Y' && this.prd_display_yn == 'N' "}}
		<li  class="prd_display_off">
{{/js_if}}
		
			<div class="item-content prdlistslayout2 prdliststyle2">
				{{#if ../../isCopy }}
				<div>
					<input type="checkbox" name="copy_prd[]" value="{{id}}">
				</div>
				{{/if}}
				<div class="item-media">
{{#if ../../isCopy }}
					<a href="/m/product/my/{{id}}" class="external" target="productview">
{{else}}
					<a href="/m/product/my/{{id}}">
{{/if}}
						<div class="prdimg" style="background-image: url(/storage/thumb/{{prd_img1}});">
						</div>
					</a>
				</div>
				<div class="item-inner ">
					<div class="item-title-row">
{{#if ../../isCopy }}
					<a href="/m/product/my/{{id}}" class="new-list-item-title-ellipsis2 external" target="productview">{{prd_title}}</a>
{{else}}
					<a href="/m/product/my/{{id}}" class="new-list-item-title-ellipsis2">{{prd_title}}</a>
{{/if}}
						
					</div>
					<div class="prd-item-company-name" style="display:none">Beatles</div>

{{#if ../../isCopy }}
					<a href="/m/product/my/{{id}}" target="productview" class="prd-item-price-wrap display-flex justify-content-space-between external">
{{else}}
					<a href="/m/product/my/{{id}}" class="prd-item-price-wrap display-flex justify-content-space-between">
{{/if}}
					
						<div class="prd-item-price-down">

						</div>
						<div class="prd-item-price-inner">
							{{#js_if "this.prd_viewprice == 'Y'" }}
							<div class="prd-item-before_price">
								<span class="prd-item-before_price_tag2">{{prd_org_price}} 원</span>
								<span class="pricedntag">{{prd_price_percent}}%</span>
							</div>
							<div class="prd-item-after_price">
								{{prd_price}}원
							</div>
							{{/js_if}}
							{{#js_if "this.prd_viewprice == 'N'" }}
							<div class="prd-item-after_price prd-item-none-price">
								가격 협의
							</div>
							{{/js_if}}
						</div>
					</a>
				</div>
{{#if ../../isCopy }}
{{else}}
	{{#js_if "this.prd_use_yn == 'Y' "}}
				<div class="display-flex my_prd_item_edit">
					<a href="/m/editprd/{{id}}">
						<i class="material-icons">edit</i>
					</a>
				</div>
	{{/js_if}}
{{/if}}
			</div>
		</li>
		{{/each}}
	</ul>
	@endverbatim 
			`,
      }
    },
    methods: {
		copyprc : function() {
			var self = this;
			if ( $$("input[name='copy_prd[]']:checked").length < 1){
				toastmessage('복사할 상품을 선택해주세요')
				return;
			}
			var target = $$("#prd_select_booth option:selected");
			var boothIid = $$(target).val();
			
			var self = this;
			var app = self.$app;
			app.dialog.confirm( $$("#prd_select_booth option:selected").text() + "로 복사하시겠습니까",
			   'way2Expo', 
				function(){
					console.log ( "copy prc")
					$$("input[name='copy_prd[]']:checked").each( function() {
						var data = { booth_id : boothIid, prd_id : $$(this).val() }
						var check = this;
						//
						$$.ajax({
							   url: '/mobileapi/myprdlist/copy',
							   method:"POST",
							   data:data,
							   dataType:'JSON',
							   success:function(res)
							   {
								 $$(check).prop("checked", false);
								 self.isChange = true;
								 if ( $$("input[name='copy_prd[]']:checked").length < 1){
										toastmessage('복사를 완료하였습니다.')
									    self.loaddata();
										return;
									}
							   },
							   error: function ( err ){
								 ajaxError(err);
							   }
						 });
						
					});
				},
			    function() {})
			
		},
		toggleCopy : function (e) {
			var self = this;
			
			if( self.boothId < 1 ) {
				toastmessage('관리할 부스를 선택해주세요')
				return;
			}
			
			self.popupSwipeHandler.open();
		},
		changeCopyBooth: function (e) {
			var self = this;
			var id = $(e.target).val();
			$("#prd_my_list_copy").empty();
			if( id < 1 || id == ''){
				return;
			}
			self.loaddata( $(e.target).val() );			
		},
		changeselect : function (e){
			var self = this;
			$("#prd_my_list").empty();
			self.boothId =  ($(e.target).val())
			self.loaddata();
		},
		addurl : function() {
			var self = this;
			var app = self.$app;
			var val = $$("#prd_select_booth  option:selected").val();
			if( self.boothId > 0 ) app.views.main.router.navigate('/m/addprd/' + self.boothId )
			else {
				toastmessage('부스를 선택해주세요')
			}
		},
		loaddata : function ( booth_id ) {
			var self = this;
			var id;
			var isCopy = false;
			if( typeof booth_id != 'undefined') {
				id = booth_id;
				isCopy = true;
			}
			else if( self.boothId < 1 || self.boothId == ''){
				return;
			}else id = self.boothId;
			app.preloader.show()
			axios({
				method: 'get',
				url: '/mobileapi/myprdlist' ,
				params: {
					page : self.page ,
					boothId : id ,
				}
			}).then(function (response) {
				if( response.data.products.length < 1){
					if( !isCopy){
						$("#prd_my_list").html( self.nonepage)
						$("#prd_my_page").empty();
						return;	
					}else {
						$("#prd_my_list_copy").html( self.nonepage)
						$("#prd_my_page_copy").empty();
						return;
					}
					
				}
				 
				if(self.compiled_prd == null ) self.compiled_prd = Template7.compile( self.prdtemplate );
				response.data['isCopy'] = isCopy;
				console.log(response.data)
				
				if( !isCopy) $("#prd_my_list").html( self.compiled_prd(response.data) )
				else $("#prd_my_list_copy").html( self.compiled_prd(response.data) )
				app.preloader.hide()
			}).catch(function (error) {
				console.log(error);
				toastmessage('잠시후에 이용해주세요')
			}).finally(function () {
				app.preloader.hide()
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
        if (self.popupSwipeHandler) {
			self.popupSwipeHandler.off('close')
			self.popupSwipeHandler.destroy();
		}
        if (self.popupPush) self.popupPush.destroy();
		 etcEvents.off('my_prd_list_reload')
      },
      pageInit: function () {
        var self = this;
        var today = new Date();
        var app = self.$app;
		if( self.boothId > 0 ) self.loaddata();
		etcEvents.on('my_prd_list_reload', function () {
			console.log ( "on reload")
		  self.loaddata()
		})
		self.loaddata()
		  self.popupSwipeHandler = app.popup.create({
			el: '.myprd_copy_popup',
	        swipeToClose: 'to-bottom',
    	    swipeHandler: '.myprd_copy_swipe-handler',

		  });
		  self.popupSwipeHandler.on('close', function (popup) {
			  console.log ( "close......")
			  $$("#prd_copy_select_booth option:first-child").prop('selected', true)
			  $("#prd_my_list_copy").empty();
		  });
		  
      },
    }
  }
</script>
