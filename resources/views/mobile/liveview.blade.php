<template>
    <div class="page page-liveview" data-name="liveview">
        <div class="navbar navbar-new">
            <div class="navbar-bg"></div>
            <div class="navbar-inner sliding">
                <div class="left">
                    <a href="#" class="link back">
                        <i class="icon icon-back"></i>
                        <span class="if-not-md">Back</span>
                    </a>
                </div>
                <div class="title">[라이브] {{$booth->booth_title}}</div>
                <div class="right">
                </div>
            </div>
        </div>

<div class="toolbar messagebar fab-morph-target" style="height: 308px;">
    
        <div class="toolbar-inner elevation-5">
            <div>
                <div class="livemsgwrap" id="livemsgareawrap">
                    <div class="display-flex justify-content-space-between"
                        style="position: relative;height: 28px;padding-left: 10px;padding-right:10px;">
                        <div class="display-flex">
                            <div class="input-dropdown-wrap sm">
                                <select class="scrollonoff" @change='selectchange'>
                                    <option disabled>자동스크롤</option>
                                    <option value="on">ON</option>
                                    <option value="off">OFF</option>
                                </select>
                            </div>
                            <i class="material-icons chatdelbtn" @click="delchatlog">delete</i>
                        </div>
                        <a class="fab-close  resizemessages">
                            <i class="material-icons downicon">keyboard_arrow_down</i>
                        </a>
                    </div>
                    <div class="livemsgwrapbox" id="livemsgwrapbox">
                        <a href="#" id="setlastmsgpost" class="hide" @click="moveToBottom"><i class="material-icons">double_arrow</i></a>
                        <div class="messages" id="livemsgarea">
                        </div>
                    </div>
                </div>
                <div class="msgbar-wrap display-flex elevation-1">             
                    <div class="messagebar-area" style="margin-left: 18px;">
                        @auth
                        <input type="text" id="livemsginput" class="resizable" placeholder="Message"
                            style="max-height: 316px;" disabled>
                        @endauth
                        @guest
                            <input type="text" class="resizable" placeholder="로그인후 채팅이 가능합니다." style="max-height: 316px;width: 100%;" disabled>                            
                        @endguest
                    </div>
                    @auth
                    <a href="#" class="link icon-only color-teal " @click="sendmsg">
                        <i class="icon material-icons" style="color: #999999;">send</i>
                    </a>
                    @endauth
                    @guest
                    <a href="#" class="link icon-only color-teal ">
                        <i class="icon material-icons" style="color: #999999;">send</i>
                    </a>                        
                    @endguest
                </div>
            </div>
    
        </div>
    
    </div>
    
    <div class="fab fab-right-bottom fab-morph" id="msgfab" data-morph-to=".toolbar.messagebar"
        style="margin-bottom: 0;opacity: 1;">
        <a href="#" class="" style="">
            <i class="icon material-icons">chat_bubble</i>
        </a>
    </div>


        <div class="page-content" style="max-height: 100vh;overflow: hidden;">
            <div class="videowrap">
                <video id="remoteVideo" autoplay controls playsinline style="z-index:1;background: rgba(0, 0, 0, 0.5);"></video>

               <!--div class="live_likebtn_wrap" style="position: absolute;z-index: 10;border: 0;right: 30px;">
                    <input id="toggle-heart" type="checkbox" @change="uncheckheart"/>
                    <label for="toggle-heart" aria-label="like">❤</label>
                </div-->
                <div class="live_likebtn2_wrap hide">
                    <div class="likeV2" id="livelikebtn2" aria-role="button" tabindex="0" @click="liveheart">
						<div id="like-count-div">{{$channels->like_count}}</div>
                        <div class="like-heart-tiny like-heart-solid"></div>
                        <div class="like-heart-tiny like-heart-solid"></div>
                        <div class="like-heart-tiny like-heart-solid"></div>
                    
                        <!--div class="like-heart like-heart-white"></div>
                        <div class="like-heart like-heart-solid"></div>
                        <div class="like-heart like-heart-outline"></div-->
                        <div class="like-heart-label" aria-label="like">❤</div>
                    </div>
                </div>

            </div>
            <a href="#" class="color-teal" @click="restart" id="videostartbtn"
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <i class="material-icons  color-teal" style="font-size: 50px;
    border-radius: 50%;
    background-color: black;">play_arrow</i>
            </a>
			
			
			

			
			
			
        </div><!-- / page-content -->

		<div class="confirm-pop-wrap live-view-confirm-pop_wrap">
			<div class="live-view-confirm-pop_inner">
				<div class="live-view-confirm-pop">
					<div class="live-view-confirm-pop-cont_wrap">
						@include("mobile.inc.liveviewconfirm")
					</div>
					
				</div>		
			</div>
		</div>
		
		
<div class="gp_mask" onClick="gp_close()"></div>
<div class="gp_panel2">
		<div class="gp_panel_header_wrap">
				<div class="gp_panel_header_inner">
					<!--div class="gp_panel_header_title">
					  타이틀
					</div-->
					<i class="material-icons" @click="closegp">close</i>
				</div>
			</div>
		<div data-infinite-distance="50" class="page-content infinite-scroll-content infinite-scroll-bottom gp_panel_product_list_wrap" @infinite="prdlist" >

			<div class="list media-list product-list">
				<ul>
				</ul>
				<div class="preloader infinite-scroll-preloader"></div>
			</div>				
			
		</div>
</div>
		
		
    </div><!-- / page -->
</template>
<script>
    return {
    data: function () {
      return {
          data : {
              config : {
                    credential: {
                    key: '{{$cfg['key']}}',
                    serviceId: '{{$cfg['serviceId']}}',
                    wsurl: 'wss://signal.remotemonster.com/ws',
                    resturl: 'https://signal.remotemonster.com/rest'
                    },
                    view: {
                        remote: '#remoteVideo',
                        local: '#localVideo'
                    },
                    media: {
                        audio: true,
                        video: true
                    }
                },
                rejoin : false,
                channel_id : "{{$channel_id}}",
                userkey : '{{$userkey}}',
                name : '{{$username}}',
                member_type : 'member',
                mute : {{$mute}},
                ban :false,
                maxline : 1000,
                autoscroll : 'on',
                preventScroll : false,
                preventScrollTimer : null,              
		  
		  
		  
allowInfinite: true,
        hasMoreItems: true,
        lastpage: 1,
		compiled_prdtemplate : null,
@verbatim		  
		prdtemplate: `
{{#each data}}
<li>
	<div class="item-content prdlistslayout2 prdliststyle2">
		<div class="item-media">
			<a href="/m/product/{{id}}">
				<div class="prdimg" style="background-image: url(/storage/{{prd_img1}});">
				</div>
			</a>
		</div>
		<div class="item-inner ">
			<div class="item-title-row">
				<a href="/m/product/{{id}}" class="new-list-item-title-ellipsis2">{{prd_title}}
				</a>
			</div>
			<div class="prd-item-company-name" style="display:none">Beatles</div>
			<a href="/m/product/{{id}}" class="prd-item-price-wrap display-flex justify-content-space-between">
				<div class="prd-item-price-down">

				</div>
				<div class="prd-item-price-inner">
					{{#js_if " this.prd_viewprice == 'Y' " }}
						<div class="prd-item-before_price">
							<span class="prd-item-before_price_tag2">{{numberformat prd_org_price}} 원</span>
							<span class="pricedntag">{{prd_price_percent}}%</span>
						</div>
						<div class="prd-item-after_price">
							{{numberformat prd_price}} 원
						</div>
					{{/js_if}}
					{{#js_if " this.prd_viewprice == 'N' " }}
						<div class="prd-item-after_price prd-item-none-price">
							가격 협의
						</div>
					{{/js_if}}

				</div>
			</a>
		</div>
		<div class="prd-item-fav prd-item-fav-outer display-flex">
			<a class="globalTogglePrdLink" onclick="toggleprd(this)" data-id="{{id}}">
					<i class="material-icons isfavorite
	{{#js_if " this.isfavorite != true "}} hide {{/js_if}}
					">favorite</i>
					<i class="material-icons unfavorite 
	{{#js_if " this.isfavorite != false "}} hide {{/js_if}}">favorite_border</i>
			</a>
		</div>
	</div>
</li>
{{/each}}
		`,
@endverbatim
		  
		  
            }
        }
    },
    methods: {
		
		
		
	closegp : function(e) {
		  $$(e.target).closest(".gp_panel2").removeClass('show')
		  // $(".page.page-current .gp_panel2").removeClass("show")
	  },
	  opengp : function(e){
		  $(".page.page-current .gp_panel2").addClass("show")
	  },
	  prdlist: function(){
		var self = this;  
		var url = "/mobileapi/prdlist/{{$booth->expoBooth->id}}/{{$booth->id}}"
		if (!self.data.hasMoreItems) return;
		  
	  	if (self.data.compiled_prdtemplate == null){
	  		self.data.compiled_prdtemplate = Template7.compile(self.data.prdtemplate);
  		} 

 		self.data.hasMoreItems = false;
		  
		axios({
			method: 'get',
			url: url,
			params: {
				page : self.data.lastpage ,
			}
		}).then(function (response) {
			var res = response.data.data

			if( res.total > 0 && res.data.length > 0 ){
				
				$$(".page.page-current .gp_panel2 ul").append(self.data.compiled_prdtemplate(res));

				if( res.last_page == res.current_page){
					$$(".page.page-current .gp_panel2 ul").next().addClass("hide")
					self.data.hasMoreItems= false
				}else {
					self.data.lastpage = self.data.lastpage +1;
				    self.data.hasMoreItems = true;
				}
				
				self.data.lastpage = self.data.lastpage +1;
				self.data.hasMoreItems = true;
			}else {
				$$(".page.page-current .gp_panel2 ul").next().addClass("hide")
				self.data.hasMoreItems= false
			}
		});
	  },
		  
		  
		back : function() {
			history.back()
		},
		agree: function() {
			var self = this;
			if( $$("#liveview_agree_checkbox:checked").val() =='Y') {
				$$(".live-view-confirm-pop_wrap").hide()
				self.start();
			}else {
				var msg = $$("#liveview_agree_checkbox").data("msg")
				toastmessage(msg)
			}
		},		
		drawHeart: function() {
			var self = this;
            $$("#livelikebtn2").blur();
			$$("#livelikebtn2").removeClass('like-liked')
            setTimeout( function() {
				$$("#livelikebtn2").addClass('like-liked')
            }, 10)
            if( typeof self.data.toggleheartclear !='undefined') {
				clearTimeout(self.data.toggleheartclear)
			}
            self.data.toggleheartclear = setTimeout( function() {
                $$("#livelikebtn2").blur();
				$$("#livelikebtn2").removeClass('like-liked')
            }, 1000)
		},
        liveheart : function (e) {
            var self = this;
            @guest
                $$("#livelikebtn2").blur();
                toastmessage("로그인 후 사용이 가능합니다.");
                return;
            @endguest
			axios({
                method: 'post',
                url: '/mobile/livecmd/like',
                data: {
                    booth_id: '{{$booth->id}}',
                    channel_id: self.data.channel_id,
                }
            }).then(function (response) {
        		$$("#livelikebtn2").blur();
				$("#like-count-div").text( response.data.data )
				setTimeout( function() {
					$$("#livelikebtn2").focus();
				}, 10)
				if( typeof self.data.toggleheartclear !='undefined') {
					clearTimeout(self.data.toggleheartclear)
				}
				self.data.toggleheartclear = setTimeout( function() {
					$$("#livelikebtn2").blur();
					$$("#livelikebtn2").removeClass('like-liked')
				}, 1000)

				self.sendprc(response.data.data , 'addlike');        
            })
			


        },
        uncheckheart: function () {
            var self = this;
            console.log ( "draw....")
            if( self.data.toggleheart == 'on' && $$("#toggle-heart").prop("checked") ) return;
            if( typeof self.data.toggleheartclear !='undefined') clearTimeout(self.data.toggleheartclear)
            console.log ( "....")
            self.data.toggleheart = 'on';
            self.data.toggleheartclear = setTimeout( function() {
                $$("#toggle-heart").prop("checked", false);
                self.data.toggleheart = 'off';
            }, 800)
        },                
        sendmsg : function() {
            var self = this;
            if( self.data.mute ) return;
            //self.sendprc( wordFilterCheck($$("#livemsginput").val()),'message' );
			self.sendprc( badWordfilter($$("#livemsginput").val(),true),'message' );
        },
        sendprc : function ( msg, command ){
            var self = this;
            //msg = encodeURIComponent(escape(msg));
			msg = encodeURIComponent(escapeHtml(msg));
            let body = {
                command : command ,
                body : msg,
                sender : {
                    key : self.data.userkey,
                    name : self.data.name,
                    type : self.data.member_type,
                },
                target : {
                    key : null,
                    memo : null,
                }
            }
            if( typeof remon != 'undefined'){
                if( self.data.mute && command !='addlike'){
                    toastmessage('채팅 차단 상태입니다.')
                    return;
                }
                try {
                    $$("#livemsginput").val('')
                    remon.sendMessage( JSON.stringify(body) );
                    if( command=='message') self.prcliveMsg( true, body )
                } catch (error) {
                    console.log (error)
                }
            }else toastmessage('방송중이 아닙니다.')
        },
        prcliveMsg : function ( ismine, msg ){
            var self = this;
            var target = $$(".livemsgwrap > .messages");
            var txt = document.createElement('textarea');
                //txt.innerHTML = unescape(msg.body);
				txt.innerHTML = decodeURIComponent(msg.body);
            var message = txt.value;
            message = message.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;" ).replace(/"/g, "&quot;" ).replace(/'/g, "&quot;" );
            var tpl="";
            moment.locale("ko");
            var ctime = moment().local().format('LT');

            if ( self.data.autoscroll=='on' && self.data.preventScroll == false && $$("#livemsgarea > div.message").length > self.data.maxline ){
                var delno = $$("#livemsgarea > div.message").length - self.data.maxline;
                for( var i=0; i < delno ; i++) $$("#livemsgarea > div:nth-child(1)").remove();
            }
            if( ismine){
                tpl = `
                <div class="message message-sent small-font">
                <div class="message-content">
                    <div class="message-bubble">
                        <div class="message-text">
                            ${message}
                        </div>
                    </div>
                    <div class="message-bubble-time">
                        ${ctime}
                    </div>                    
                </div>
                </div>
                `
            }else if(msg.sender.type == 'manager') {
                tpl = `
                <div class="message message-received message-last message-tail small-font">
                <!--div class="message-avatar" style="background-image:url(https://ui-avatars.com/api/?name=Manager&background=0D8ABC&color=fff)">
                </div-->
                <i class="material-icons manager-avatar">supervisor_account</i>
                <div class="message-content">
                    <!--div class="message-name">${msg.sender.name}</div-->
                    <div class="message-bubble-time">
                                            ${ctime}
                    </div>                    
                    <div class="message-bubble">
                        <div class="message-text">
                            ${message}
                        </div>
                    </div>
                </div>
                </div>
                `;
            }else {
                tpl = `
                <div class="message message-received small-font">
                <div class="message-content">
                    <div class="message-name">${msg.sender.name}</div>
                    <div class="message-bubble">
                        <div class="message-text">
                            ${message}
                        </div>
                    </div>
                    <div class="message-bubble-time">
                        ${ctime}
                    </div>                    
                </div>
                </div>
                `;
            }

            var t = $$("#livemsgwrapbox").scrollTop()
            var bh = $$("#livemsgwrapbox").innerHeight();
            $$("#livemsgarea").append(tpl);
            var ah = $$("#livemsgwrapbox").innerHeight();
            var diffH = ah-bh
            var newset = parseInt(t) - diffH ;

            if( !self.data.preventScroll && self.data.autoscroll=='on') {
                console.log ( "move btm 1")
                $("#livemsgareawrap .livemsgwrapbox").scrollTop( $("#livemsgareawrap .livemsgwrapbox")[0].scrollHeight)
                $$("#setlastmsgpost").addClass('hide')
            }else {
                $$("#livemsgwrapbox").scrollTop( newset )
                $$("#setlastmsgpost").removeClass('hide')
            }
        },
        getLiveMsg: function (data) {
            var self = this;
            var txt = document.createElement('textarea');
            txt.innerHTML = data;
            let msg = JSON.parse(txt.value);
            //if( msg.command =='message') fnprcLiveMsg( false, msg )
            if( msg.command =='message') self.prcliveMsg( false, msg )
			else if( msg.command =='join'){
				console.log ( msg.sender.name +" 님이 입장하셨습니다.")
			}
			else if ( msg.command =='addlike' ){
				self.drawHeart()
				if(  msg.body > parseInt( $("#like-count-div").text() ) ) $("#like-count-div").text( msg.body );
			}
            else if( msg.target.key == self.data.userkey){
                if ( msg.command =='block'){
                    self.data.mute = true;
                    noti('채팅', '채팅이 차단되었습니다.')
                    $$("#livemsginput").attr("disabled", true);
                    $$("#livemsginput").val("");
                    $$("#livemsginput").attr('placeholder','채팅이 차단되었습니다')
                }else if ( msg.command =='unblock'){
                    self.data.mute = false;
                    noti('채팅', '채팅이 차단이 해제되었습니다.')
                    $$("#livemsginput").attr("disabled", false);
                    $$("#livemsginput").val("");
                    $$("#livemsginput").attr('placeholder','message')
                }else if ( msg.command =='ban'){
                    self.data.ban = true;
                    noti('채팅', '강제퇴장되었습니다.')
                    remon.close();
                    $$("#videostartbtn").remove();
                    history.back();
                }
            }
        },
        stop : function () {
            remon.close();
        },
		restart: function(){
			var self = this;
			self.data.rejoin = true;
			console.log ( "self.data.rejoin : " + self.data.rejoin )
			self.start();
		},
        start: function (e) {
            var self = this;
            var app = self.$app;
            let config = self.data.config;
            if (typeof remon != 'undefined'){
                self.data.rejoin = true;
                remon.close();
				remon = undefined;
            }
            const listener = {
                onCreateChannel(chid) {
                    console.log(`EVENT FIRED: onConnect: ${chid}`);
                },
				onJoin() {
			        moment.locale("ko");
                    var msg = moment().local().format('LLL')
                    $$("#livemsgarea").append(`<div class="messages-title"><b>${msg}</b></div>`);
                    $$("#videostartbtn").hide();
                    $$("#videoclosebtn").removeClass('hide').show();
				},
                onComplete() {

                    app.fab.open('#msgfab', '.toolbar.messagebar')
                    if( self.data.mute == false ) $$("#livemsginput").attr("disabled", false)
                    else {
                        $$("#livemsginput").attr('placeholder','채팅이 차단되었습니다')
                    }		
                    $$(".live_likebtn2_wrap").removeClass("hide")
					let body = {
						command : 'join' ,
						body : '',
						sender : {
							key : self.data.userkey,
							name : self.data.name,
							type : self.data.member_type,
						}
					}
					remon.sendMessage( JSON.stringify(body) );
					self.data.rejoin = false;
                },
                onDisconnectChannel() {
                // is called when other peer hang up.
                    console.log("some viewer is exited")
                },
                onClose() {
                // is called when remon.close() method is called.
                    console.log('EVENT FIRED: onClose');
                    $$("#videostartbtn").show();
                    $$("#videoclosebtn").hide();                
                    remon.close();
                    $$("#livemsginput").attr("disabled", true);
					console.log ( "close self.data.rejoin : " + self.data.rejoin )
                    if( !self.data.rejoin){
                        remon = undefined
                        if( self.data.ban == false ) noti('방송종료', '방송이 종료되었습니다.')
                        history.back();
                    }
                },
                onError(error) {
                    console.log(`EVENT FIRED: onError: ${error}`);
                    if( error == `"2031"` ){
                        app.dialog.alert('방송중이 아닙니다.', 'Way2EXPO', function() {history.back();})
                    }

                },
                onStat(result) {
					console.log ( result )
					if( result.nowRemoteFrameRate == 0 ){
						toastmessage('방송 연결이 지연되고 있습니다.')
					}
                },
                onMessage(msg) {
                    console.log ("get message");
                    self.getLiveMsg(msg)
                }
            };
            if( typeof remon != 'undefined'){
                remon.close();
            }
            remon = new Remon({ config  , listener});
            remon.joinCast( self.data.channel_id );
        },
        selectchange: function (e) {
            var self = this;
            self.data.autoscroll = $(e.target).val()
        },
         moveToBottom : function() {
             var self = this;
            if( self.data.autoscroll=='on' ) $$("#setlastmsgpost").addClass('hide')
            clearTimeout( self.data.preventScrollTimer)
            self.data.preventScroll = false;
            console.log ( "move btm with fnc")
            $("#livemsgareawrap .livemsgwrapbox").scrollTop( $("#livemsgareawrap .livemsgwrapbox")[0].scrollHeight);
        },
        delchatlog : function() {
            var self = this;
            var app = self.$app;

            self.dialog = app.dialog.confirm('메시지 창을 지우시겠습니까?', 'Delete', function() {
                moment.locale("ko");
                var msg = moment().local().format('LLL')
                $$("#livemsgarea").empty().html(`<div class="messages-title"><b>${msg}</b></div>`);
            })
        }        
    },
    on: {
      pageBeforeRemove: function () {
        var self = this;
        try{
            remon.close()
        }catch(e){
            console.log (e)
        }
        remon = undefined;
        // Destroy popup when page removed
        if (self.notificationFull) self.notificationFull.destroy();
        if (self.popup) self.popup.destroy();
        if (self.popupSwipe) self.popupSwipe.destroy();
        if (self.popupSwipeHandler) self.popupSwipeHandler.destroy();
        if (self.popupPush) self.popupPush.destroy();
        if( self.dialog ) self.dialog.destroy();

        $('input#livemsginput').off('keyup')
        $("#livemsgwrapbox").off( 'touchmove');
        $("#livemsgwrapbox").off('scroll');
        $("#msgfab").off("fab:open");
        if( typeof remon !='undefined'){
            remon.close();
            remon = undefined;
        }        
      },
      pageInit: function () {
        var self = this;
        var today = new Date();
        var app = self.$app;
        console.log ( self.data.config )
        $$('input#livemsginput').on('keyup', function (e) {
            if (e.keyCode === 13) {
                self.sendmsg();
            }
        })
        //self.start();

        $("#msgfab").on("fab:open", function() {
            self.moveToBottom()
        })
        $("#livemsgwrapbox").touchmove(function(){
            if( !self.data.preventScroll )self.data.preventScroll = true;
            clearTimeout( self.data.preventScrollTimer)
            self.data.preventScrollTimer = setTimeout(function() {
                self.data.preventScroll = false;
                console.log ( "move btm with time" + self.data.autoscroll)
                if( self.data.autoscroll=='on'){
                    console.log ( "move btm with time prc")
                    $$("#setlastmsgpost").addClass('hide')
                    $("#livemsgareawrap .livemsgwrapbox").scrollTop( $("#livemsgareawrap .livemsgwrapbox")[0].scrollHeight)
                }
            },6000);
        })
        $("#livemsgwrapbox").on('scroll', function (){
            console.log ( "move : " + self.data.preventScroll)
            if( self.data.preventScroll){
                console.log ( "end - " + ($$("#livemsgwrapbox").scrollTop() + $$("#livemsgwrapbox").innerHeight() + 5 < $$("#livemsgwrapbox")[0].scrollHeight))
                if($$("#livemsgwrapbox").scrollTop() + $$("#livemsgwrapbox").innerHeight() + 5  < $$("#livemsgwrapbox")[0].scrollHeight) {
                    //self.moveToBottom()
                    $$("#setlastmsgpost").removeClass('hide')
                    return;
                }else $$("#setlastmsgpost").addClass('hide')
            }
            else $$("#setlastmsgpost").addClass('hide')
        })
		  self.prdlist();
      },
    }
  }
</script>