<template>
  <div class="page page-cardexchangelist" data-name="cardexchangelist">
   <div class="navbar navbar-new">
      <div class="navbar-bg"></div>
      <div class="navbar-inner sliding">
        <div class="left">
          <a href="#" class="link back">
            <i class="icon icon-back"></i>
            <span class="if-not-md">Back</span>
          </a>
        </div>
        <div class="title">비즈니스문의</div>
        <div class="right">
          <a href="/m/notilist" class="link icon-only">
            <i class="icon material-icons md-only">notifications
              <span class="badge color-red noti-cnt">0</span>
            </i>
          </a>
          <!--a href="#" class="link icon-only panel-open menu-icon"  style="margin-left:12px;" data-panel="left"-->
			<a href="/m/menu" class="link icon-only menu-icon">
            <i class="icon material-icons">menu</i>
          </a>
        </div>
      </div>
    </div>
	
	  
	  
	  
	  
	  
	  
	<div class="toolbar tabbar toolbar-top">
      <div class="toolbar-inner">
		@if($user->company_id > 0)	
		<a href="#tab-card-list-receive" class="tab-link tab-link-active">신청 받은 문의</a>
		 @endif
		  
        <a href="#tab-card-list-send" class="tab-link @if($user->company_id < 1) tab-link-active @endif">신청한 문의</a>
      </div>
    </div>
	  
    <div class="tabs">
		
@if($user->company_id > 0)		
      <div class="page-content tab infinite-scroll-content card-scroll-content page-card-receive tab-active" @infinite="loadmore" id="tab-card-list-receive">
      
		<div class="business_card-delete_wrap">
			<span @click="deletecard">선택삭제</span>
		</div>
        <div class="business_card-list">
			<form id="card_delete_form">
				
			<!-- senderOrReceiver -->
        	<div id="budinesscard_receive_list"></div>
				
			</form>
			
		</div>
        <div class="preloader infinite-scroll-preloader"></div>		  
		    
      </div>
@endif		
		
      <div class="page-content tab infinite-scroll-content card-scroll-content page-card-send @if($user->company_id < 1) tab-active @endif" @infinite="loadmoreSend" id="tab-card-list-send">

		  
        <div class="list media-list chevron-center business_card-list">
			<form id="card_deleteSend_form">
				
			<!-- senderOrReceiver -->
			<div class="list">
				<ul id="budinesscard_send_list">
				</ul>	
			</div>

				
			</form>
			
		</div>
        <div class="preloader infinite-scroll-preloader"></div>	
		  
      </div>
		
    </div><!-- / tabs -->  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
    
  </div>
	<!--style>
		.business_card-list .business_card-item-chck{
			width:20px;
		}
		.business_card-list a.item-content{
			flex-grow: 1;
		}
		.business_card-list .item-inner{    width: 150px;min-width:150px;}
		
	</style-->
<style>
	#budinesscard_send_list li .item-date:before {
    font-family: framework7-core-icons;
    font-weight: 400;
    font-style: normal;
    line-height: 1;
    letter-spacing: normal;
    text-transform: none;
    white-space: nowrap;
    word-wrap: normal;
    direction: ltr;
    -webkit-font-smoothing: antialiased;
    text-rendering: optimizeLegibility;
    -moz-osx-font-smoothing: grayscale;
    font-feature-settings: 'liga';
    text-align: center;
    display: block;
    width: 100%;
    height: 100%;
    font-size: 20px;
    position: absolute;
    top: 50%;
    width: 8px;
    height: 14px;
    margin-top: -7px;
    right: calc(var(--f7-list-item-padding-horizontal) + var(--f7-safe-area-right));
    content:'chevron_down';
}
	#budinesscard_send_list li.expanded_msg .item-date:before {
		 content:'chevron_up';
	}
</style>	
</template>
<script>
  return {
    data: function () {
      return {
		  
		  data :{
			  senderOrReceiver : "receive", //send
			  allowInfinite : true,
			  hasMoreItems : true,
			  lastItem : 0,
			  compiledTempate : null,
			  
			  allowInfiniteSend : true,
			  nextPageSend : 1,
			  compiledTempateSebd : null,
			  
			  
			  noneTemplate : `
				
					<div class="business_none_wrap">
						<div class="business_none_inner">
							<div class="">
								비즈니스 문의가 없습니다.
							</div>
						</div>
					</div>
				
				`,
@verbatim			  
			  receivelisttemplate : `
				{{#each data}}
<div class="business_card-item-wrap">
	<div class="business_card-item-item-inner">
		<div class="business_card-item-chck">
			<input type="checkbox" name="business_card_del[]" value="{{id}}">
		</div>
		<a href="/m/card/view/{{id}}" onClick="etcEvents.emit( 'cardread',{target:this})" class="item-link">

			<div class="business_card-item-line business_card-item-detail_card">
				<div class="business_card-item-media">
					<div class="business_card-item-booth_title">
						{{booth_title}}
					</div>
{{#if user_id}}
	<div class="business_card-item-textcard">
		<div class="business_card-item-textcard_name">
			{{card_name}}
		</div>
		<div class="business_card-item-textcard_name">
			{{card_tel}}
		</div>
	</div>
{{else}}
	{{#if business_card_front}}

		<div class="business_card-item-imgcard"
			 style="    background-image: url(/storage/{{business_card_front}});min-width:30px;min-height:30px;"
			 >
			<img src="/storage/{{business_card_front}}" style="width:100%"/>
		</div>

	{{else}}

		<div class="business_card-item-imgcard"
			 style="    background-image: url(/storage/{{business_card_back}});min-width:30px;min-height:30px;"
			 >
			<img src="/storage/{{business_card_back}}" style="width:100%"/>
		</div>

	{{/if}}
{{/if}}
				</div>

				<div class="business_card-item-detail_read">

					<div class="business_card-item-detail_read_title read_{{read_yn}}">
						{{#js_if " this.read_yn =='Y' "}}확인{{/js_if}}
						{{#js_if " this.read_yn !='Y' "}}미확인{{/js_if}}

					</div>
				</div>

			</div>

			<div class="business_card-item-line business_card-item-detail_at">
				<div class="business_card-item-detail_at_title">
					{{dateOnlyformat created_at}}
				</div>
			</div>
		</a>
	</div>
</div>
				{{/each}}
				`,
			  listtemplateSend : `
{{#each data}}
<li onClick="etcEvents.emit( 'cardmessageToggle',{target:this})">
	 <div class="budinesscard_send_wrap">
	  <div class="budinesscard_send_inner">
		<div class="item-expo-title">{{expo_name}}</div>
		<div class="item-booth-title">{{booth_title}}</div>
	  </div>
	  <div class="item-date">
		{{dateOnlyformat created_at}}  
	  </div>
	</div>
	<div class="budinesscard_send_message hide">
		{{nl2br message}}
	</div>
</li>
{{/each}}
				`,
@endverbatim			  
		  }
      }
    },
    methods: {
		loadmore : function(e){
			var self = this;
			if (!self.data.allowInfinite) return;
			self.loaddata();
		},
		loadmoreSend : function(e){
			var self = this;
			if (!self.data.allowInfiniteSend) return;
			self.loaddataSend();
		},
		
		
		loaddataSend : function() {
			var self = this;
			if (!self.data.allowInfiniteSend) {
				return false;
			}
			self.data.allowInfiniteSend = false;

			axios({
				method: 'get',
				url: '/mobileapi/mycard/list/send',
				params : {
					page : self.data.nextPageSend
				},
			}).then(function (response) {
	  			let res = response.data.data;
				self.data.nextPageSend++;
					
				if( res.current_page == 1 && res.total < 1){
					$$("#budinesscard_send_list")
					.html(self.data.noneTemplate);
					$$("#tab-card-list-send").find(".infinite-scroll-preloader").hide()
					return;
				}
				$$("#budinesscard_send_list")
					.append(self.data.compiledTempateSend(res))
				if( res.current_page >= res.last_page){
					$$("#tab-card-list-send").find(".infinite-scroll-preloader").hide()
					return;
				}
				self.data.allowInfiniteSend = true;
  			}).catch(function (error) {
                $$("#tab-card-list-send").find(".infinite-scroll-preloader").hide()
				$$("#budinesscard_send_list")
					.html(self.data.noneTemplate);
				ajaxError ( error.response )
            });
		},
		
		
		loaddata : function() {
			var self = this;
			if (!self.data.allowInfinite) {
				return false;
			}
			self.data.allowInfinite = false;

			axios({
				method: 'get',
				url: '/mobileapi/mycard/list/receive',
				params : {
					item : self.data.lastItem
				},
			}).then(function (response) {
	  			let res = response.data.data;
				let len = res.data.length;
					
				if( len< 1){
					$$("#budinesscard_receive_list")
					.html(self.data.noneTemplate);
					$$("#tab-card-list-receive").find(".infinite-scroll-preloader").hide()
					return;
				}
				
				self.data.lastItem = res.data[ len-1 ].id ;
				$$("#budinesscard_receive_list")
					.append(self.data.compiledTempate(res))
				if( len < 10 ){
					$$("#tab-card-list-receive").find(".infinite-scroll-preloader").hide()
					return;
				}
				self.data.allowInfinite = true;
  			}).catch(function (error) {
				console.log ("====== error ==========")
				console.log ( error.response )
                $$("#tab-card-list-receive").find(".infinite-scroll-preloader").hide()
				$$("#budinesscard_receive_list")
					.html(self.data.noneTemplate);
				//ajaxError ( error.response )
            }); ;
		},
		deletecard : function() {
			var self = this;
            var app = self.$app;

			if( $$("input[name='business_card_del[]']:checked").length < 1){
				return;
			}
			app.dialog.confirm("선택하신 내용을 삭제하시겠습니까?", 'Way2Expo', ()=>{
				$$.ajax({
				   url: '/mobileapi/mycard/remove',
				   method:"POST",
				   data:$$("#card_delete_form").serialize(),
				   success:function(res)
				   {
					 $$("input[name='business_card_del[]']:checked").each( function() {
						 var card = this;
						 $$(card).closest('.business_card-item-wrap').fadeOut('slow', function(){
							$$(card).closest('.business_card-item-wrap').remove()		
							$$('#tab-card-list-receive').scrollTop(parseInt($$('#tab-card-list-receive').scrollTop())+1);
						 });
					 })
					 toastmessage('삭제되었습니다.');
				   },
				   error: function ( err ){
					 ajaxError(err);
				   }
				 });
			},
			()=>{
				
			});
			
			return;


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
		etcEvents.off('cardread');
		etcEvents.off('cardmessageToggle');
      },
      pageInit: function () {
        var self = this;
        var app = self.$app;
		 
		if (self.data.compiledTempate == null){
			self.data.compiledTempate = Template7.compile(self.data.receivelisttemplate);
			self.data.compiledTempateSend = Template7.compile(self.data.listtemplateSend);
		}
		etcEvents.on('cardread', function (target) {
		   var read = $$(target.target).closest('.business_card-item-wrap').find('.business_card-item-detail_read_title');
			$(read).addClass('read_N').removeClass('read_Y').text("확인")
		})
		etcEvents.on('cardmessageToggle', function (target) {
			var msg = $$(target.target).children('.budinesscard_send_message');
			if( $$(msg).hasClass('hide') )  {
				$$(msg).removeClass('hide')
				$$(target.target).addClass("expanded_msg")
			}
			else {
				$$(msg).addClass('hide')
				$$(target.target).removeClass("expanded_msg")
			}
		});
		  
		  setTimeout(()=>{
			  
			  @if($user->company_id > 0)
			  self.loaddata();
			  @endif
			  
			  self.loaddataSend();			  
		  }
		  ,300);
		
		  
      },
    }
  }
</script>