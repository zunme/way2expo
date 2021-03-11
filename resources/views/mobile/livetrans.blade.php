<template>
    <div class="page page-livetrans" data-name="livetrans">
        <div class="navbar navbar-new">
            <div class="navbar-bg"></div>
            <div class="navbar-inner sliding">
                <div class="left">
                    <a href="#" class="link back">
                        <i class="icon icon-back"></i>
                        <span class="if-not-md">Back</span>
                    </a>
                </div>
                <div class="title">방송하기</div>
                <div class="right livecontroller">
					<a href="#" @click="vireremoteprc" id="myvideoview" class="hide">
                        <i class="material-icons button button-fill color-blue" style="color:white">personal_video</i>
                    </a>
					
                    <a href="#" @click="videoflip" id="videoflip" class="hide">
                        <i class="material-icons button button-fill color-blue" style="color:white">flip_camera_ios</i>
                    </a>
                    
                    <!--a href="#" @click="start" id="videostartbtn">
                        <i class="material-icons button button-fill color-teal hide" style="font-size: 24px;
    background-color: #ff0434;
    color: white;">play_arrow</i>
                    </a-->
					<a href="#" class="hide" @click="startbroad" id="videostartbtn">
                        방송시작
                    </a>
					<a href="#" class="" @click="testbroad" id="testvideostartbtn">
                        방송테스트
                    </a>
                    <a href="#" @click="stop" id="videoclosebtn" class="hide">
                        <i class="material-icons button button-fill color-teal">stop</i>
                    </a>
                </div>
            </div>
        </div>
        <div class="toolbar messagebar fab-morph-target" style="height: 308px;">

            <div class="toolbar-inner elevation-5">
                <div>
                    <div class="livemsgwrap" id="livemsgareawrap">
                        <div class="display-flex justify-content-space-between" style="position: relative;height: 28px;padding-left: 10px;padding-right:10px;">
                            <div class="display-flex">
                                <div class="input-dropdown-wrap sm">
                                    <select class="scrollonoff" @change='selectchange'>
                                        <option disabled>자동스크롤</option>
                                        <option value="on">ON</option>
                                        <option value="off">OFF</option>
                                    </select>
                                </div>
                                <i class="material-icons chatdelbtn" @click="delchatlog">delete</i>
								<div class="display-flex" style="position: relative;    line-height: 28px;" @click="viewuser">
									<div class="userplus-solid">
										<i class="material-icons" style="color: white;background:red;border-radius:50%">exposure_plus_1</i>										
									</div>
									<i class="material-icons chatdelbtn" style="margin-left: 16px;color: blue;">how_to_reg</i>
									<span class="live-viewer-count" style="color:#aaa">0</span>
								</div>
                            </div>
                            <a class="fab-close  resizemessages">
                                <i class="material-icons downicon">keyboard_arrow_down</i>
                            </a>
                        </div>
                        <div class="livemsgwrapbox viewmanagerbox" id="livemsgwrapbox">
                        <a href="#" id="setlastmsgpost" class="hide" @click="moveToBottom"><i class="material-icons">double_arrow</i></a>
                            <div class="messages" id="livemsgarea" >
                            </div>
                        </div>
                    </div>
                    <div class="msgbar-wrap display-flex elevation-1">
                        <div class="messagebar-area" style="margin-left: 18px;">
                            <input type="text" id="livemsginput" class="resizable" placeholder="Message" style="max-height: 316px;">
                        </div>
                        <a href="#" class="link icon-only color-teal " @click="sendmsg">
                            <i class="icon material-icons" style="color: #999999;">send</i>
                        </a>

                    </div>
                </div>

            </div>
        
        </div>
		
        <div class="fab fab-right-bottom fab-morph hide" id="msgfab"  data-morph-to=".toolbar.messagebar"
            style="margin-bottom: 0;opacity: 1;">
            <a href="#" class="" style="width: 40px;height: 40px">
                <i class="icon material-icons">chat_bubble</i>
            </a>
        </div>


        <div class="ban_sheet morph-target" style="min-height: 41vh;" data-key="">
            <div class="block-title chooseusername">Choose Something</div>
            <a class="ban_sheet_close" @click="closebansheet">
                <i class="material-icons">close</i>
            </a>
            <div class="list links-list">
                <ul>
                    <li class="cmd_usermute"><a href="#" @click="usermute">채팅금지</a></li>
                    <li class="cmd_usermuted"><a href="#" @click="userunmute">채팅금지 해제</a></li>
                    <li class="cmd_userban"><a href="#" @click="userban">강제퇴장</a></li>
                    <li class="cmd_userbaned"><a href="#" @click="userunban">강제퇴장 해제</a></li>
                </ul>
            </div>
        </div>

	    <div class="etc_sheet morph-target" style="" data-key="">
			<div class="block-title etc_shtte_title" style="padding-right:40px;clear:both">시청자 리스트
				<span class="live-viewer-guestcount" style="float: right;">0</span>
			</div>
            <a class="ban_sheet_close" @click="closeetcsheet" >
                <i class="material-icons">close</i>
            </a>
            <div class="" style="max-height: 40vh;
    overflow-y: scroll;
    margin-bottom: 10px;
    padding: 10px;">
                <div class="row" id="etc_sheet_content">

				</div>
            </div>
        </div>
		
        <div class="page-content" style="max-height: 100vh;overflow: hidden;position:relative;">


			<div class="videowrap hide">
				
					<video id="remoteVideo" class="hide" autoplay muted style="
	position: absolute;
   	background: #eee;
    top: 0px;
    left: 0px;
    max-height: calc(100vh - 60px);
    border: 1px solid white;
    width: 100px;
								  ">
					</video>
				
                <video id="localVideo" autoplay muted></video>
				<div class="live_likebtn2_wrap">
                    <div class="likeV2" id="livelikebtn2">
						<div id="like-count-div">0</div>
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
			<div id="testbroadmsg_wrap" class="hide">
				<div class="testbroadmsg_inner">
					<div class="testbroadmsg">
						테스트 방송중입니다.<br>
						방송상태를 확인해 주세요<br>
						<span style="font-size:14px;">( 60초후 자동종료됩니다. )</span>
					</div>
				</div>
			</div>
        </div><!-- / page-content -->

		<div class="confirm-pop-wrap live-confirm-pop_wrap">
			<div class="live-confirm-pop_inner">
				<div class="live-confirm-pop">
					<div class="live-confirm-pop-cont_wrap">
						@include("mobile.inc.livetransconfirm")
					</div>
					
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
                        video : {
                            codec: 'h264',
                            'maxBandwidth' : '3000',
                            'frameRate' : {'max' : 25, 'min' : 15,},
							/*
                            'defaultWidth' : '1280',
                            'defaultHeight' : '720',
                            'width' : {
                                'max' : '1280',
                                'min' : '480'
                            },
                            'height' : {
                                'max' : '1280',
                                'min' : '480'
                            },*/
                        },
                        audio: {
                            channelCount: 2,
                            maxBandwidth: 128,
                            autoGainControl: false,
                            echoCancellation: false,
                            noiseSuppression: false,
                        },
						record: true,
        				recordUrl: "{{$app->make('url')->to('/mobileapi/recdone')}}",
                    },
                    rtc: {audioType: "voice"}
                },
                channel_id : "{{$channel_id}}",
                userkey : '{{$userkey}}',
                name : '{{$user->name}}',
                member_type : 'manager',
                maxline : 1000,
                autoscroll : 'on',
                preventScroll : false,
                preventScrollTimer : null,
                toggleheart : 'off',
			  	userList : {},
			  	guestCount : 0,
			  	userCount : 0,
			  	cpTimer : null,
			    remoteviewer : null,
			    testboradstatus : false,
            }
        }
    },
    methods: {
		back : function() {
			history.back()
		},
		agree: function() {
			if( $$("#livetran_agree_checkbox:checked").val() =='Y') {
				$$(".live-confirm-pop_wrap").hide()
			}else {
				toastmessage('방송규정 동의가 필요합니다.')
			}
		},
		drawHeart: function() {
			var self = this;
			$$("#livelikebtn2").removeClass('like-liked')
            setTimeout( function() {
				$$("#livelikebtn2").addClass('like-liked')
            }, 10)
            if( typeof self.data.toggleheartclear !='undefined') {
				clearTimeout(self.data.toggleheartclear)
			}
            self.data.toggleheartclear = setTimeout( function() {
				$$("#livelikebtn2").removeClass('like-liked')
            }, 1000)
		},		
		isEmptyObject : function(param) {
		  return Object.keys(param).length === 0 && param.constructor === Object;
		},
		closeetcsheet : function() {
			$(".etc_sheet").removeClass("fab-morph-target-visible");
		},
		templateView: function( user ){
			var tpl = $$(`<div class="display-flex templateUserListli">`);
			$(tpl).append(`<div class="live-viewer-name">${ user.name }</div>`)
			if(  user.mute ) $(tpl).append('<i class="material-icons" style="font-size:14px;color:red;line-height:14px;">mic_off</i>')
			if(  user.ban ) $(tpl).append('<i class="material-icons" style="font-size:14px;color:red;line-height:14px;">block</i>')
			return tpl
		},
		viewuser: function () {
			var self = this;
			$("#etc_sheet_content").empty();
			if( !self.isEmptyObject(self.data.userList) ){
				for ( var i in  self.data.userList ){
					var wrap = `<div class="col-50 live-viewer-li"  style="color: #4c4c4c;" data-key="${ self.data.userList[i].key }" onClick="custClick(this)" data-name="${ self.data.userList[i].name }" data-viewuuid="${ self.data.userList[i].uuid }" />`
					
					var tpl = self.templateView( self.data.userList[i] )
					var temp = $$(wrap).append(tpl)
					$$("#etc_sheet_content").append( temp )
				}
			}else{
				$("#etc_sheet_content").append("<div class='col-100 display-flex justify-content-center nouser_sheet_content'><div style='margin: 30px 0;'>시청자 리스트가 없습니다.</div></div>")
			}
			$(".etc_sheet").addClass("fab-morph-target-visible");
		},
        sendmsg : function() {
            var self = this;
            self.sendprc( badWordfilter($$("#livemsginput").val(),true) );
        },
        sendprc : function ( msg, command ){
            var self = this;
            if( typeof command =='undefined') command = 'message';
            if( command == 'message'){
                if( typeof msg =='undefined' || msg == '') return;
            }
            //msg = escape(msg);
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
                try {
                    remon.sendMessage( JSON.stringify(body) );
                    self.prcLiveMsg( true, body )
                    $$("#livemsginput").val('')
                } catch (error) {
                    console.log (error)
                }
            }else toastmessage('방송중이 아닙니다.')
        },
        stop : function () {
            remon.close();
        },
		capture : function () {
			var self = this;
			var canvas = document.createElement('canvas');
			var video = document.getElementById('localVideo');
			canvas.width = video.videoWidth;
			canvas.height = video.videoHeight;

			var context = canvas.getContext('2d');
			context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
			var imgsrc = canvas.toDataURL("image/jpg");
		/*
			$("#video_thumbnail_img").attr("src", imgsrc);
			var dataURL = canvas.toDataURL();
			*/
			axios({
				method: 'post',
				url: '/mobileapi/thumb',
				data: {
					booth_id : '{{$booth->id}}',
					channel_id : self.data.channel_id  ,
					imgBase64: canvas.toDataURL()
				}
			}) 	
		},
		startbroad : function() {
			var self = this;
			if(self.testboradstatus){
				self.start();	
			}else {
				self.testboradstatus = true;
				remon.close();
			}
			
		},
		testbroad : function() {
			$("#videostartbtn").addClass("hide")
			//$$("#localVideo").parent().addClass("hide")
			var self = this;
			let config = self.data.config;
			
			//config.view.local = "#test"
			let channel_id = 'test_'+ self.uniqid();
			self.data.channel_id = channel_id;
			const listener = {
                onCreateChannel(chid) {
					$$("#remoteVideo").removeClass("hide")
					$$("#localVideo").parent().removeClass("hide")
					$$("#testbroadmsg_wrap").removeClass("hide")
					document.getElementById('localVideo').muted = true
					setTimeout( function() {
						if( typeof remon != 'undefined' && !self.testboradstatus){
							remon.close();
						}
					}, 60000)
                },
                onComplete() {
					self.vireremoteprc();
					$("#videostartbtn").removeClass("hide")
					$("#testvideostartbtn").addClass("hide")
                },
                onDisconnectChannel() {
                },
                onClose() {
                    remon.close();
                    remon = undefined
					$$("#testbroadmsg_wrap").addClass("hide")
					$$("#localVideo").parent().removeClass("hide")
					self.vireremoteprc();
					if(self.testboradstatus){
						self.start();
					}else {
						$("#videostartbtn").addClass("hide")
						$("#testvideostartbtn").removeClass("hide")
					}
                },
                onError(error) {
                },
                onStat(result) {
					if( result.nowLocalFrameRate == 0 ){
						toastmessage('방송 연결이 지연되고 있습니다.')
					}//else remon.close();
                },
                onMessage(msg) {
                }
            };
			remon = new Remon({ config , listener});
			remon.createCast( channel_id );
		},
		vireremoteprc : function () {
			var self = this;
			if( self.data.remoteviewer != null){
				console.log ( "close")
				self.data.remoteviewer.close();
				$$("#remoteVideo").addClass("hide")
				self.data.remoteviewer = null;
				return;
			}
			$$("#remoteVideo").removeClass("hide")
			const config = {
				credential: {
                    key: '{{$cfg['key']}}',
                    serviceId: '{{$cfg['serviceId']}}',
                    wsurl: 'wss://signal.remotemonster.com/ws',
                    resturl: 'https://signal.remotemonster.com/rest'
				},
			  view: {
				remote: '#remoteVideo'
			  },
			  media: {
				video : true,
				audio : false
			  }
			}
			const listener = {
                onComplete() {
					document.getElementById('remoteVideo').muted = "mute"
					document.getElementById('remoteVideo').muted = true
				}
			}
			self.data.remoteviewer = new Remon({ config,listener })
			self.data.remoteviewer.joinCast(self.data.channel_id)
			console.log ( "view")
			//document.getElementById('localVideo')
		},
		
        start: function (e) {
            var self = this;
            var channel_id = "booth_{{$booth->id}}_" + self.uniqid();
            self.data.channel_id = channel_id;
			$("#msgfab").removeClass("hide")
            let config = self.data.config;

            const listener = {
                onCreateChannel(chid) {
                    console.log(`EVENT FIRED: onConnect: ${chid}`);
					$$("#remoteVideo").removeClass("hide")
					document.getElementById('localVideo').muted = true
					
					moment.locale("ko");
                    var msg = moment().local().format('LLL')
                    $$("#livemsgarea").append(`<div class="messages-title"><b>${msg}</b></div>`);                                
                    $$("#videostartbtn").hide();
                    $$("#videoclosebtn").removeClass('hide').show();
                    $$("#videoflip").removeClass('hide').show();
					$$("#myvideoview").removeClass('hide').show();
					$("#like-count-div").text( '0' )
                    app.fab.open('#msgfab', '.toolbar.messagebar')
					self.data.userList = {};
					self.data.guestCount = 0;
					self.data.userCount = 0;
					self.usercounting();
                },
                onComplete() {
					console.log(`complete...`);

            		var element = document.getElementById('localVideo');
    				element.muted = "muted";
					document.getElementById('localVideo').muted = true
					
					self.data.cpTimer = setInterval(function () {
						self.capture();
					}, 60000);
					self.capture();
					setTimeout( function() {
						self.capture();
					},10000)
					setTimeout ( function () {
						self.vireremoteprc();
					},2000)
					
                },
                onDisconnectChannel() {
                // is called when other peer hang up.
                    console.log("some viewer is exited")
                },
                onClose() {
					clearInterval(self.data.cpTimer)
                    axios({
                        method: 'post',
                        url: '/mobile/livecmd/close',
                        data: {
                            booth_id: '{{$booth->id}}',
                            channel_id: self.data.channel_id,
                        }
                    })                
                    console.log('EVENT FIRED: onClose');
                    $$("#videostartbtn").show();
                    $$("#videoclosebtn").hide(); 
                    $$("#videoflip").hide();  
					$$("#myvideoview").hide();
					$$("#remoteVideo").addClass("hide")
					
                    if( typeof remon.close() != 'undefined') remon.close();
					if ( self.data.vireremote != null) self.data.vireremote.close();
					
                    remon = undefined
					self.vireremote = null
                    noti('방송종료', '방송이 종료되었습니다.')
					//clearInterval( self.data.cpTimer );
                },
                onError(error) {
                    console.log(`EVENT FIRED: onError: ${error}`);
                },
                onStat(result) {
					if( result.nowLocalFrameRate == 0 ){
						toastmessage('방송 연결이 지연되고 있습니다.')
					}
                    //console.log(`EVENT FIRED: onStat: ${result}`);
                    console.log(result.nowLocalFrameRate);
                },
                onMessage(msg) {

                    self.getLiveMsg(msg);
                }
            };
            axios({
                method: 'post',
                url: '/mobile/livecmd/start',
                data: {
                    booth_id: '{{$booth->id}}',
                    channel_id: self.data.channel_id,
                }
            }).then(function (response) {
                remon = new Remon({ config , listener});
                remon.createCast( self.data.channel_id );
                console.log ( self.data.channel_id )
            })
            .catch(function (error) {
                toastmessage(error.response.data.errors.msg)
            });            
            return;
        },
        getLiveMsg: function (data) {
            var self = this;
            var txt = document.createElement('textarea');
            txt.innerHTML = data;
            let msg = JSON.parse(txt.value);
            if( msg.command =='message') self.prcLiveMsg( false, msg )
			else if( msg.command =='join'){
				self.userjoin(msg)
			}
			else if ( msg.command =='addlike' ){
				self.drawHeart()
				if(  msg.body > parseInt( $("#like-count-div").text() ) ) $("#like-count-div").text( msg.body );
			}
        },
		userjoin : function ( msg ){
			var self = this;
			var usercount = self.data.userCount;
			var guestcount = self.data.userCount;
			
			if( msg.sender.key != "guestUser") {
				console.log ( msg.sender.name +" 님이 입장하셨습니다.")
				axios({
					method: 'get',
					url: '/mobile/livecmd/usercheck',
					params: {
						booth_id: '{{$booth->id}}',
						user_key : msg.sender.key
					},
				}).then(function (response) {
					var data = response.data.data
					for(var i=0; i < self.data.userList.length ; i ++ ){
						if (  self.data.userList[i].uuid == data.uuid ) return;
					}
					msg.sender['uuid'] =  data.uuid;
					msg.sender['ban'] =  data.ban;
					msg.sender['mute'] =  data.mute;
					if( typeof  self.data.userList['u_'+ data.uuid]  =='undefined') {
					   self.data.userCount = self.data.userCount +1;				   
				    }
					//self.data.userList.push( msg.sender);
					self.data.userList['u_'+ data.uuid ] = msg.sender;
					self.usercounting();
				});
				
			}else {
			   self.data.guestCount = self.data.guestCount +1;
			   self.usercounting();
		   }
			$(".userplus-solid").removeClass("ani")
			setTimeout( function() {
				$(".userplus-solid").addClass("ani")
			},50)
		},
		usercounting: function() {
			var self = this;
			var usercount = self.data.userCount;
			var guestcount = self.data.guestCount;
			
			$$(".live-viewer-count").each( function() {
				$$(this).text( guestcount + usercount );
			})
			$$(".live-viewer-guestcount").each( function() {
				$$(this).text( guestcount );
			})
		},
        prcLiveMsg : function ( ismine, msg ){
            var self = this;
            var target = $$(".livemsgwrap > .messages");
			var message = decodeURIComponent(msg.body);
			message = message.replace(/&#x2F;&quot;/g, '"').replace(/&#x2F;&#39;/g, "'")
			/*
            var txt = document.createElement('textarea');
                txt.innerHTML = unescape(msg.body);
            var message = txt.value;
            message = message.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;" ).replace(/"/g, "&quot;" ).replace(/'/g, "&quot;" );
			*/
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
                <div class="message message-received message-last small-font">
                <div class="message-avatar" style="background-image:url(https://ui-avatars.com/api/?name=Manager&background=0D8ABC&color=fff)">
                </div>
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
            }else {
                tpl = `
                <div class="message message-received message-last small-font">
                    <!--div class="message-avatar" onClick="custClick(this)" data-key="${msg.sender.key}" data-name="${msg.sender.name}"
                        style="background-image:url(https://ui-avatars.com/api/?name=Mb&background=0D8ABC&color=fff)">
                    </div-->
                    <!--i class="material-icons member-avatar"
                    onClick="custClick(this)" data-key="${msg.sender.key}" data-name="${msg.sender.name}" >more_horiz</i-->
                <div class="message-content">
                    <div class="message-name" onClick="custClick(this)" data-key="${msg.sender.key}" data-name="${msg.sender.name}">${msg.sender.name}</div>
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
        usermute: function (e){
            var self = this;
            let key = $$(e.target).closest('.ban_sheet').data('key')
            console.log (key)
            self.chatcommand( key, 'block');
        },
        userunmute: function (e){
            var self = this;
            let key = $$(e.target).closest('.ban_sheet').data('key')
            self.chatcommand( key, 'unblock');
        },        
        userban: function (e){
            var self = this;
            let key = $$(e.target).closest('.ban_sheet').data('key')
            console.log (key)
            self.chatcommand( key, 'ban');
        },
        userunban: function (e){
            var self = this;
            let key = $$(e.target).closest('.ban_sheet').data('key')
            self.chatcommand( key, 'unban');
        },
        chatcommand : function (targetkey, command ) {
            var self = this;
            let body = {
                command : command ,
                body : '',
                sender : {
                    key : self.data.userkey,
                    name : self.data.name,
                    type : self.data.member_type,
                },
                target : {
                    key : targetkey,
                    memo : null,
                }
            }
            axios({
                method: 'post',
                url: '/mobile/livecmd/cmd',
                data: {
                    booth_id: '{{$booth->id}}',
                    cmd: command,
                    user_key : targetkey
                }
            }).then(function (response) {
                if( typeof remon != 'undefined'){
					var data = response.data.data;
					console.log ( data );
					try {
						self.data.userList['u_'+ data.uuid ].ban = data.ban ;
						self.data.userList['u_'+ data.uuid ].mute = data.mute ;
						var tpl = self.templateView(self.data.userList['u_'+ data.uuid ])
						$$("div.live-viewer-li[data-viewuuid='"+data.uuid+"']").html(tpl)
					} catch (error) {
                        console.log (error)
                    }
					if( typeof self.data.userList['u_'+ data.uuid ] != 'undefined'){
						body.target.key = self.data.userList['u_'+ data.uuid ].key;
						try {
							remon.sendMessage( JSON.stringify(body) );
							toastmessage('처리되었습니다.')
						} catch (error) {
							toastmessage('처리되었습니다.')
							console.log (error)
						}						
					}
					toastmessage('처리되었습니다.')
                }else toastmessage('처리되었습니다.')
                $(".ban_sheet").removeClass("fab-morph-target-visible");
            })
            .catch(function (error) {
                console.log(error);
            });
            return;
            if( typeof remon != 'undefined'){
                console.log ( body )
                try {
                    remon.sendMessage( JSON.stringify(body) );
                    $(".ban_sheet").removeClass("fab-morph-target-visible");
                } catch (error) {
                    console.log (error)
                }
            }else toastmessage('방송중이 아닙니다.')
        },
		openbansheet : function (e){
            var self = this;
            axios({
                method: 'get',
                url: '/mobile/livecmd/usercheck',
                params: {
                    booth_id: '{{$booth->id}}',
                    user_key : e.detail.key
                },
            }).then(function (response) {
                var data = response.data.data
                if( data.ban){
                    $$(".cmd_userban").addClass("hide");
                    $$(".cmd_userbaned").removeClass("hide");
                }else {
                    $$(".cmd_userban").removeClass("hide");
                    $$(".cmd_userbaned").addClass("hide");
                }
                if( data.mute){
                    $$(".cmd_usermute").addClass("hide");
                    $$(".cmd_usermuted").removeClass("hide");
                }else {
                    $$(".cmd_usermute").removeClass("hide");
                    $$(".cmd_usermuted").addClass("hide");
                }
                $$(".chooseusername").text("선택된 유저 [ "+e.detail.name +" ]");
                $$(".ban_sheet").data("key", e.detail.key);
                $(".ban_sheet").addClass("fab-morph-target-visible");                
            })
            .catch(function (error) {
                console.log ( error );
                toastmessage('잠시후에 이용해주세요')
            });
        },        
        closebansheet : function() {
            $(".ban_sheet").removeClass("fab-morph-target-visible");
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
        },
        uniqid : function() {
            return moment().format('X')
            const c = Date.now()/1000;
            let d = c.toString(16).split(".").join("");
            while(d.length < 12) d +="0" ;
             return d; 
        },
        videoflip : function() {
            remon.switchCamera();
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
        if( self.dialog ) self.dialog.destroy();
		
        $('#hostmsginput').off('keyup')
        $(document).off('mbclick');
        $("#livemsgwrapbox").off( 'touchmove');
        $("#livemsgwrapbox").off('scroll');
        $("#msgfab").off("fab:open")
        if( typeof remon !='undefined'){
            remon.close();
            remon = undefined;
        }
        axios({
            method: 'post',
            url: '/mobile/livecmd/close',
            data: {
                booth_id: '{{$booth->id}}',
                channel_id: self.data.channel_id,
            }
        })  
	    clearInterval( self.data.cpTimer );
      },
      pageInit: function () {
        var self = this;
        var today = new Date();
        var app = self.$app;
		  document.getElementById('localVideo').muted = true
		  document.getElementById('remoteVideo').muted = true
		//self.testbroad();
	
        $('input').on('keyup', function (e) {
            var name="test";
            if (e.keyCode === 13) {
                self.sendmsg();
            }
        })
        $(document).on('mbclick', function (e) {
            self.openbansheet(e)
        });
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
            if( self.data.preventScroll){
                if($$("#livemsgwrapbox").scrollTop() + $$("#livemsgwrapbox").innerHeight() + 5  < $$("#livemsgwrapbox")[0].scrollHeight) {
                    //self.moveToBottom()
                    $$("#setlastmsgpost").removeClass('hide')
                    return;
                }else $$("#setlastmsgpost").addClass('hide')
            }
            else $$("#setlastmsgpost").addClass('hide')
        })
		  
      },
    }
  }
</script>