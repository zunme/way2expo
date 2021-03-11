Date.prototype.format = function (f) {
    if (!this.valueOf()) return " ";
      var weekKorName = ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"];
      var weekKorShortName = ["일", "월", "화", "수", "목", "금", "토"];
      var weekEngName = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
      var weekEngShortName = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
      var d = this;
      return f.replace(/(yyyy|yy|MM|dd|KS|KL|ES|EL|HH|hh|mm|ss|a\/p)/gi, function ($1) {
          switch ($1) {
              case "yyyy": return d.getFullYear(); // 년 (4자리)
              case "yy": return (d.getFullYear() % 1000).zf(2); // 년 (2자리)
              case "MM": return (d.getMonth() + 1).zf(2); // 월 (2자리)
              case "dd": return d.getDate().zf(2); // 일 (2자리)
              case "KS": return weekKorShortName[d.getDay()]; // 요일 (짧은 한글)
              case "KL": return weekKorName[d.getDay()]; // 요일 (긴 한글)
              case "ES": return weekEngShortName[d.getDay()]; // 요일 (짧은 영어)
              case "EL": return weekEngName[d.getDay()]; // 요일 (긴 영어)
              case "HH": return d.getHours().zf(2); // 시간 (24시간 기준, 2자리)
              case "hh": return ((h = d.getHours() % 12) ? h : 12).zf(2); // 시간 (12시간 기준, 2자리)
              case "mm": return d.getMinutes().zf(2); // 분 (2자리)
              case "ss": return d.getSeconds().zf(2); // 초 (2자리)
              case "a/p": return d.getHours() < 12 ? "오전" : "오후"; // 오전/오후 구분
              default: return $1;
          }
      });
  };
  String.prototype.string = function (len) { var s = '', i = 0; while (i++ < len) { s += this; } return s; };
  String.prototype.zf = function (len) { return "0".string(len - this.length) + this; };
  Number.prototype.zf = function (len) { return this.toString().zf(len); };
  
  $$(function() {
      $$.ajaxSetup({
         headers: {
          'X-CSRF-TOKEN': csrftoken
         }
      });
      $$(document).ajaxStart( function() {
        app.preloader.show()
      })
      $$(document).ajaxStop( function() {
        app.preloader.hide();
        refreshToken();
      })
    })
    function reloadpage( ){
      window.location.replace( app.views.main.router.currentRoute.url );
      return;
      $$(".page.page-previous").remove();
      app.views.main.router.navigate( app.views.main.router.currentRoute.url , {ignoreCache  : true,
          reloadCurrent : true
      });
    }
    function loginNeedAlert() {
      app.dialog.confirm('로그인이 필요한 서비스입니다<br>로그인 하시겠습니까?','Way2Expo', function () {
        //app.views.main.router.navigate('/login');return;
        history_back = false;
        window.location.href="/login"
      });
    }
function refreshToken() {
      return;
      if (typeof app == 'undefined') return;
       app.request({
        url: '/refresh',
        method:'post',
        headers: {
          'X-CSRF-TOKEN': csrftoken
        },
        success: function (xhr) {
          
          console.log ("refresh:"+xhr)
          $$('meta[name="csrf-token"]').attr('content', xhr)
          csrftoken = xhr
          $$.ajaxSetup({
             headers: {
              'X-CSRF-TOKEN': xhr
             }
          });
        }
      })
      return;
    }
    function ajaxError(jqXHR ){
      if( jqXHR.status == 401){
        return loginNeedAlert();
        return;
      }else if(jqXHR.status == 403) {
        toastmessage('권한이 없습니다.');return;
      }else if(jqXHR.status != 422 && jqXHR.status != 500 && jqXHR.status !=400) {
          toastmessage('잠시후에 이용해주세요');
          return;
      }else {
        var msg ;
        var exception ;
		  
        if (jqXHR.responseJSON ) {
          msg = jqXHR.responseJSON.errors;
          exception = jqXHR.responseJSON.exception;
        }else if ( typeof jqXHR.data == "object"){
		  msg = jqXHR.data.errors;
          exception = jqXHR.data.exception;
		}
        if(msg) {
          for(key in msg) {
            if(msg.hasOwnProperty(key)) {
              if(key.indexOf('.') < 0 ) {
                $$('input[name='+key+']').focus();
              }
  
              if ( $$.isNumeric( key )) {
                toastmessage(msg);
              } else {
                toastmessage(msg[key][0]);
              }
              break;
            }
          }
        } else {
          toastmessage('시스템 오류입니다');
        }
      }
    }
  
   function noti(title,text){
       let notidialog = app.notification.create({
         icon: '<img src="/image/fav32.png" style="width:16px;">',
         title: 'Way2EXPO',
         titleRightText: 'now',
         subtitle: title,
         text: text,
         closeTimeout: 3000,
         closeOnClick: true,
         on:{
           closed : function (){
             notidialog.destroy()
           }
         }
       });
     notidialog.open();
   }
   function toastmessage ( text ){
      let toastbottom = app.toast.create({
         text: text ,
         position: 'bottomcenter',
         closeTimeout: 2000,
         closeButton : true,
         on:{
           closed : function (){
             toastbottom.destroy()
           }
         }
       });
     toastbottom.open();
   }
   function alertmessage( text ){
     app.dialog.alert(text, 'Way2EXPO');
   }
  
  function changeview( status ){
    $$(".search-prc-expo-fail-box").hide();
    if( status =='all'){
      var cnt = document.querySelectorAll(".expo-card").length;
      if ( cnt < 1){
        $$(".search-prc-expo-fail-box").show();
      } else $$(".expo-card").fadeIn(100);
    }else {
        var cnt = document.querySelectorAll(".expo-card[data-progress*='" + status +"']").length;
        if ( cnt < 1){
          $$(".search-prc-expo-fail-box").show();
           $$(".expo-card").fadeOut(100);
        }else {
          $$(".expo-card").each( function ( ){
            var datastatus = $$(this).data('progress');
            if( datastatus == status ) $$(this).show();
            else $$(this).fadeOut(100);
          })
        }
    }
  
  }
  Template7.registerHelper('addtime', function (time){
    return parseInt(time)+1;
  });
  Template7.registerHelper('getstatus', function (status){
    if (status == 'R') return '<span class="font-color-orange">대기중</span>'
    if (status == 'E') return '<span class="font-color-gray">종료</span>'
    if( status =='D') return '<span class="font-color-red">미팅거절</span>'
    if( status =='A') return '<span class="font-color-success">미팅종료</span>'
    if( status =='C') return '<span class="font-color-red">반려</span>'
  });
  Template7.registerHelper('dateformat', function (time){
    return new Date(time).format('yyyy-MM-dd HH:mm:ss');
  });
  Template7.registerHelper('dateformat', function (time){
    return new Date(time).format('yyyy-MM-dd HH:mm:ss');
  });

  function fnImgPreview(obj) {
      var reader = new FileReader();
      var target = $(obj).data('type');
      var maxwidth = $(obj).data('maxwidth');
      var maxheight = $(obj).data('maxheight');
  
      reader.onload = (e) => {
          var img = $$("<img />");
          var area = $$(".img-previewarea[data-type='" +target+ "']");
          img.attr('src', e.target.result).addClass('img-preview-cls');
  
          if( typeof maxwidth != 'undefined') img.css('max-width', maxwidth);
          if( typeof maxheight != 'undefined') img.css('max-height', maxheight);
          if ( typeof maxwidth == 'undefined' && typeof  maxheight == 'undefined' ) {
            img.css("width", '100%');
          }
          $$(area).empty();
          $$(area).append(img)
      };
      reader.readAsDataURL(obj.files[0]);
  }

  function fnpreivewupload(){
      let template = `
      <div class="fn-preivew-upload-wrap">
        <div class="fn-preivew-upload-inner">
          <label class="fn-preview-upload-filebtn">
            <i class="material-icons elevation-3">folder</i>
            <input type="file" name="{{inputname}}" style="display:none" onChange="fnImgPreview_file(this)">
          </label>
          <label class="fn-preview-upload-upbtn hide" onClick="fnImgPreview_upload(this)">
            <i class="material-icons elevation-3">cloud_upload</i>
          </label>
        </div>
      </div>
      `
      var closebtn = '<i class="material-icons fn-preivew-upload-closebtn hide" onclick="fnImgPreview_cancel(this)">close</i>'
      var compiledImgTemplate = Template7.compile(template);

      $$(".fn-preivew-upload").each( function() {
        let self = this;
        let templatedata = {'inputname' : 'fnpreviefile' }
        if( typeof $$(self).data('inputname') != 'undefined') templatedata.inputname = $$(self).data('inputname');
        let html = compiledImgTemplate( templatedata );

        if( !$$(self).hasClass('fn-preivew-upload-inited')){
          $$(self).append(closebtn);
          if( typeof $$(self).data('useform') != 'undefined' && $$(self).data('useform') == 'off'){
            $$(self).append(html);
          }else {
            if ( $$(self).find("form").length < 1 ) { let form=$$("<form>").append(html);
              $$(self).append(form);
            }else {
              $$(self).find("form").append(html);
            }
          }
          $$(self).addClass('fn-preivew-upload-inited');
        }
      });
    }
  
  function fnImgPreview_file(obj){
    var reader = new FileReader();
    var area = $$(obj).closest('.fn-preivew-upload');
    var maxwidth = $(area).data('maxwidth');
    var maxheight = $(area).data('maxheight');
    reader.onload = (e) => {
      var img = $$("<img />");
      img.attr('src', e.target.result).addClass('img-preview-cls');
  
      if( typeof maxwidth != 'undefined') img.css('max-width', maxwidth);
      if( typeof maxheight != 'undefined') img.css('max-height', maxheight);
      if ( typeof maxwidth == 'undefined' && typeof  maxheight == 'undefined' ) {
        img.css("width", '100%');
      }
  
      $$(area).children("img.img-preview-cls").remove();
      $$(area).children("img").addClass("hide").addClass("previwe-default-img");
      $$(area).prepend(img)
      $$(area).children('.fn-preivew-upload-closebtn').removeClass("hide");
      $$(area).find('.fn-preview-upload-upbtn').removeClass('hide');
    };
    reader.readAsDataURL(obj.files[0])
  }
  
  function fnImgPreview_cancel(btn){
    var area = $$(btn).closest('.fn-preivew-upload');
    $$(area).find('.fn-preview-upload-upbtn').addClass("hide");
    $$(area).children("img.img-preview-cls").remove();
    $$(area).children(".previwe-default-img").removeClass("hide");
    $$(btn).addClass('hide')
    $$(area).find('input[type=file]').val("");
  }
  function fnImgPreview_upload(btn){
    app.dialog.confirm('업로드 하시겠습니까?','Way2EXPO', function () {
      fnImgPreview_upload_prc(btn);
    });
  }
  function fnImgPreview_upload_prc(btn){
    var area = $$(btn).closest('.fn-preivew-upload');
    var form = $$(area).find('form')
    var url = $$(area).data('url')
    console.log( url )
    $$.ajax({
           url: url,
           method:"POST",
           data:new FormData( form[0] ),
           dataType:'JSON',
           contentType: false,
           cache: false,
           processData: false,
           success:function(res)
           {
             toastmessage('변경되었습니다.');
             var area = $$(btn).closest('.fn-preivew-upload');
             $$(area).find('.fn-preview-upload-upbtn').addClass("hide");
             $$(area).find('.fn-preivew-upload-closebtn').addClass("hide");
             $$(area).find('input[type=file]').val("");
  
             $$(area).children("img.img-preview-cls").remove();
             $$(area).children(".previwe-default-img").attr('src', res.data ).removeClass('hide')
  
           },
           error: function ( err ){
             ajaxError(err);
           }
         });
  }
  function rowSort( rows ){
    return rows.sort( function (a,b) {
      return ( a.doc.date > b.doc.date ) ? -1 : ( a.doc.date < b.doc.date ) ? 1: 0;
    });
  }
	async function fnBoothLiveCheck() {
		var obj = {};
		var newliveOn = {};
		
		var removed = [];
		var oldLive = booth_live;
		
		var searchResult = await booth_live_remon.fetchCasts();
		for ( var i=0 ;i < searchResult.length; i++) { 
		  var idSplit = searchResult[i].id.split("_");
		  if ( idSplit.length == 3  && idSplit[0] =='booth'){
			  var booth_id = 'booth_' + idSplit[1];
			  obj[booth_id] = idSplit[2];
			  if( typeof booth_live[booth_id] == 'undefined' ){
				  newliveOn[booth_id] = idSplit[2];
			  }
		  }
		}
		fnLiveOnBoothprc ( obj ,newliveOn, oldLive  )
		booth_live = obj;
		for (const [key, value] of Object.entries(oldLive)) {
			if( typeof obj[ key ] == 'undefined') {
				var temp = key.split("_")
				$$(".item_liveonbooth.booth_" + temp[1] ).each( function() {
					$$(this).remove();
				})
		  		//removeLiveOnBooth( key );
			}
		}
		
	}
	
	function fnliveBoothRedraw() {
		$$(".item_liveonbooth-img.liveimgbg").each( function() {
			var booth_id = $$(this).data("id");
			var channel = $$(this).data("channel");
			var newimg = "url('/storage/thumb/" + booth_id +"_"+ channel +".jpg?ver=" + (new Date().getTime()) + "')";
			$$(this).fadeTo('fast', 0.3, function()
					{
						$(this).css('background-image', newimg );
					}).fadeTo('fast', 1);
			
		})
	}
	
	function fnLiveOnBoothprc ( obj , newliveOn) {  
		if( liveontemplate==null ){
			liveontemplate = Template7.compile($("#liveonbooth-mainhome").html());
		}
		$$(".booth_live_on_tag").each( function() {
			var booth_id = $(this).data('booth_id');
			if( typeof obj[ 'booth_' + booth_id ] != 'undefined') {
				$(this).removeClass("hide");
				//if( typeof oldLive[ booth_id] == 'undefined') newLiveOn = true;
			} else {
				$(this).addClass("hide");
			}
		});
		if( Object.keys(obj).length < 1 ) {
			$$(".booth_liveon_inner_wrap").each( function() {
				//console.log ( $(this).children('.booth_liveon_inner').empty() )
			})
		}else {
			for (const [key, value] of Object.entries(newliveOn)) {
			  addliveboothinfo( {id : key, channel : value});
			};
		}
	}
	
	function addliveboothinfo( data ){
		var temp = data.id.split("_");
		var img = "/storage/thumb/" + data.id + '_' + data.channel + ".jpg?ver=" + (new Date().getTime());
		axios({
			method: 'get',
			url: '/mobileapi/boothinfo/' + temp[1],
			data: {
				booth_id : temp[0] ,
				channel_id :data.channel,
			}
		}).then(function (response) {
			var res = response.data.data
			res['liveimg'] = img
			res['channel'] = data.channel
			$$(".booth_liveon_inner").each( function() {
				$$(this).prepend( liveontemplate(res) )
			});

		});
	} 

	function removeRegExp(str){  
	  var reg = /[\{\}\[\]\/?.,;:|\)*~`!^\-_+<>@\#$%&\\\=\(\'\"]/gi
	  if(reg.test(str)){
		return str.replace(reg, "");    
	  } else {
		return str;
	  }  
	}	  
	function globalsearchkey(){
		var inp=$(event.target).attr("id");
		var str = removeRegExp($("#"+inp).val() );
		$("#"+inp).val( str );
		
		if ( event.keyCode == 13 ) {
			if( str.length < 2 ){
				toastmessage('검색어는 특수문자를 제외한 2자이상 입니다')
				return false;
			}			
			globalsearch( inp );
		}
	} 
	function globalsearch( id ){
		var searchstr = encodeURI( document.getElementById(id).value);
		if ( searchstr == '' ) return;
		console.log ( document.getElementById(id).value )
		//app.views.main.router.navigate('/m/search/'+searchstr)
		app.views.main.router.navigate("/m/search",{
		    context: {
		    searchWord: document.getElementById(id).value ,
		  }
        });		
	}
	function viewSearchTab (id){
		$("#btn_search_show_"+ id).trigger("click")
	}
	
	 function changeSearch(str){
		 $(document).trigger('changeSearch', { search: str })
	 }
function ordinal_suffix_of(i) {
    var j = i % 10,
        k = i % 100;
    if (j == 1 && k != 11) {
        return i + "st";
    }
    if (j == 2 && k != 12) {
        return i + "nd";
    }
    if (j == 3 && k != 13) {
        return i + "rd";
    }
    return i + "th";
}
function YouTubeGetID(url) {
	var ID = '';
	url = url.replace(/(>|<)/gi, '').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
	if (url[2] !== undefined) {
		ID = url[2].split(/[^0-9a-z_\-]/i);
		ID = ID[0];
	} else {
		ID = url;
	}
	return ID;
}
function previewYoutube( target ){
	if( typeof $(target).data("url") =='undefined') return '';
	var val = $(target).data("url")
	if( val == '' ) return "";
	
	var id = YouTubeGetID(val);
	var embed = `<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"width="100%" height="100%" type="text/html" src="https://www.youtube.com/embed/${id}?autoplay=1&fs=0&iv_load_policy=3&showinfo=0&rel=0&cc_load_policy=0&start=0&end=0" frameborder="0" allowfullscreen></iframe>`;
	return embed;	
}




$$.easing.jswing = $$.easing.swing;

$$.extend($$.easing,
{
    def: 'easeOutQuad',
    swing: function (x, t, b, c, d) {
        //alert($.easing.default);
        return $$.easing[$$.easing.def](x, t, b, c, d);
    },
    easeInQuad: function (x, t, b, c, d) {
        return c*(t/=d)*t + b;
    },
    easeOutQuad: function (x, t, b, c, d) {
        return -c *(t/=d)*(t-2) + b;
    },
    easeInOutQuad: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t + b;
        return -c/2 * ((--t)*(t-2) - 1) + b;
    },
    easeInCubic: function (x, t, b, c, d) {
        return c*(t/=d)*t*t + b;
    },
    easeOutCubic: function (x, t, b, c, d) {
        return c*((t=t/d-1)*t*t + 1) + b;
    },
    easeInOutCubic: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t*t + b;
        return c/2*((t-=2)*t*t + 2) + b;
    },
    easeInQuart: function (x, t, b, c, d) {
        return c*(t/=d)*t*t*t + b;
    },
    easeOutQuart: function (x, t, b, c, d) {
        return -c * ((t=t/d-1)*t*t*t - 1) + b;
    },
    easeInOutQuart: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
        return -c/2 * ((t-=2)*t*t*t - 2) + b;
    },
    easeInQuint: function (x, t, b, c, d) {
        return c*(t/=d)*t*t*t*t + b;
    },
    easeOutQuint: function (x, t, b, c, d) {
        return c*((t=t/d-1)*t*t*t*t + 1) + b;
    },
    easeInOutQuint: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
        return c/2*((t-=2)*t*t*t*t + 2) + b;
    },
    easeInSine: function (x, t, b, c, d) {
        return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
    },
    easeOutSine: function (x, t, b, c, d) {
        return c * Math.sin(t/d * (Math.PI/2)) + b;
    },
    easeInOutSine: function (x, t, b, c, d) {
        return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
    },
    easeInExpo: function (x, t, b, c, d) {
        return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
    },
    easeOutExpo: function (x, t, b, c, d) {
        return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
    },
    easeInOutExpo: function (x, t, b, c, d) {
        if (t==0) return b;
        if (t==d) return b+c;
        if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
        return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
    },
    easeInCirc: function (x, t, b, c, d) {
        return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
    },
    easeOutCirc: function (x, t, b, c, d) {
        return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
    },
    easeInOutCirc: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
        return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
    },
    easeInElastic: function (x, t, b, c, d) {
        var s=1.70158;var p=0;var a=c;
        if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
        if (a < Math.abs(c)) { a=c; var s=p/4; }
        else var s = p/(2*Math.PI) * Math.asin (c/a);
        return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
    },
    easeOutElastic: function (x, t, b, c, d) {
        var s=1.70158;var p=0;var a=c;
        if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
        if (a < Math.abs(c)) { a=c; var s=p/4; }
        else var s = p/(2*Math.PI) * Math.asin (c/a);
        return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
    },
    easeInOutElastic: function (x, t, b, c, d) {
        var s=1.70158;var p=0;var a=c;
        if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
        if (a < Math.abs(c)) { a=c; var s=p/4; }
        else var s = p/(2*Math.PI) * Math.asin (c/a);
        if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
        return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
    },
    easeInBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        return c*(t/=d)*t*((s+1)*t - s) + b;
    },
    easeOutBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
    },
    easeInOutBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
        return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
    },
    easeInBounce: function (x, t, b, c, d) {
        return c - $.easing.easeOutBounce (x, d-t, 0, c, d) + b;
    },
    easeOutBounce: function (x, t, b, c, d) {
        if ((t/=d) < (1/2.75)) {
            return c*(7.5625*t*t) + b;
        } else if (t < (2/2.75)) {
            return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
        } else if (t < (2.5/2.75)) {
            return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
        } else {
            return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
        }
    },
    easeInOutBounce: function (x, t, b, c, d) {
        if (t < d/2) return $.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
        return $.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
    }
});

	function toggleexpo(expo) {
		var id = $(expo).data("id");
		axios({
			method: 'post',
			url: '/mobileapi/favorite/expo',
			data: {
				expo_id : id,
			}
		}).then(function (response) {
			var isFavorite = false;
			var res = response.data.data;
			if( res=='add' ){
				$(expo).children('.isfavorite').removeClass("hide")
				$(expo).children('.unfavorite').addClass("hide")
				isFavorite = true;
				noti('즐겨찾기에 추가되었습니다.','');
			}else {
				if( $(expo).data("delete") == 'off' ){
					
				}else {
					$(expo).children('.isfavorite').addClass("hide")
					$(expo).children('.unfavorite').removeClass("hide")
				}
				noti('즐겨찾기에서 삭제되었습니다.', '');
			}
			expofavorite(id, isFavorite);
			$$(".globalToggleExpoLink").each( function() {
				if( $$(this).data('id') == id ) {
					if( res=='add' ){
						$(this).children('.unfavorite').addClass("hide")
						$(this).children('.isfavorite').removeClass("hide")
					}else {
						$(this).children('.isfavorite').addClass("hide")
						$(this).children('.unfavorite').removeClass("hide")
					}
				}
			})				
		})
		.catch(function (error) {
			if( error.response )ajaxError( error.response)
			else toastmessage('잠시후에 이용해주세요')
		});       
	 }
	 function togglebooth(booth) {
		var id = $(booth).data("id");
		axios({
			method: 'post',
			url: '/mobileapi/favorite/booth',
			data: {
				booth_id : id,
			}
		}).then(function (response) {
			var isFavorite = false;
			var res = response.data.data;
			if( res=='add' ){
				$(booth).children('.unfavorite').addClass("hide")
				$(booth).children('.isfavorite').removeClass("hide")
				noti('즐겨찾기에 추가되었습니다.','');
				isFavorite = true;
			}else {
				if( $(booth).data("delete") == 'off' ){
					
				}else {
					$(booth).children('.isfavorite').addClass("hide")
					$(booth).children('.unfavorite').removeClass("hide")
				}
				noti('즐겨찾기에서 삭제되었습니다.', '');
			}
			boothfavorite(id, isFavorite);
			$$(".globalToggleBoothLink").each( function() {
				if( $$(this).data('id') == id ) {
					if( res=='add' ){
						$(this).children('.unfavorite').addClass("hide")
						$(this).children('.isfavorite').removeClass("hide")
					}else {
						$(this).children('.isfavorite').addClass("hide")
						$(this).children('.unfavorite').removeClass("hide")
					}
				}
			})
		})
		.catch(function (error) {
			if( error.response )ajaxError( error.response)
			else toastmessage('잠시후에 이용해주세요')
		});       
	 }	  
function toggleprd (btn) {
 var id = $(btn).data("id");
 var rem = $(btn).data("remove");
	
	axios({
		method: 'post',
		url: '/mobileapi/favorite/prd',
		data: {
			prd_id : id,
		}
	}).then(function (response) {
		var res = response.data.data;
		var isFavorite = false;
		if( res=='add' ){
			$(btn).children('.isfavorite').removeClass("hide")
			$(btn).children('.unfavorite').addClass("hide")
			isFavorite = true;
			noti('즐겨찾기에 추가되었습니다.','');
		}else {
			$(btn).children('.isfavorite').addClass("hide")
			$(btn).children('.unfavorite').removeClass("hide")
			noti('즐겨찾기에서 삭제되었습니다.', '');
			if( rem=='Y') {
				var scroll = $$(btn).closest('.infinite-scroll-content')
				$$(btn).closest('li').remove()
				if(scroll.length > 0 ) {
					var scrolltop = $$(scroll).scrollTop( );
					$$(scroll).scrollTop( $$(scroll).scrollTop( )-10)
					$$(scroll).scrollTop( $$(scroll).scrollTop( )+10)					
				}
			}
		}
		productfavorite (id, isFavorite)
		$$(".globalTogglePrdLink").each( function() {
			var remit = $(btn).data("remove");
			if( $$(this).data('id') == id ) {
				var remitSelf = $(this).data("remove")
				if( res=='add' ){
					$(this).children('.unfavorite').addClass("hide")
					$(this).children('.isfavorite').removeClass("hide")
				}else {
					$(this).children('.isfavorite').addClass("hide")
					$(this).children('.unfavorite').removeClass("hide")
					if( remit=='Y') {
						var scroll = $$(btn).closest('.infinite-scroll-content')
						$$(btn).closest('li').remove()
						if(scroll.length > 0 ) {
							var scrolltop = $$(scroll).scrollTop( );
							$$(scroll).scrollTop( $$(scroll).scrollTop( )-10)
							$$(scroll).scrollTop( $$(scroll).scrollTop( )+10)					
						}
					}
					if ( remitSelf =='Y'){
						var scroll = $$(this).closest('.infinite-scroll-content')
						$$(this).closest('li').remove()
						if(scroll.length > 0 ) {
							var scrolltop = $$(scroll).scrollTop( );
							$$(scroll).scrollTop( $$(scroll).scrollTop( )-10)
							$$(scroll).scrollTop( $$(scroll).scrollTop( )+10)					
						}						
					}
				}
			}
		})				
	})
	.catch(function (error) {
		if( error.response )ajaxError( error.response)
		else toastmessage('잠시후에 이용해주세요')
	});       
}
	  function gp_close() {
		  $$("#__gp").removeClass("show")
		   $(".gp_panel").removeClass("show")
		  return;
		  if ( history_back ){
			history.back(-1);
		  } else {
			history_back = true;
		  }		  
	  }
	  function gp_open(){
		  $(".gp_panel2").addClass("show");return;
		  history_state = { 'pop' : 'on' , 'target' : 'gp'};
		  history.pushState( history_state , '', '');		  
		  $$("#__gp").addClass("show")
		 app.infiniteScroll.create("#gpscroll")
		  $('#').on('infinite', function (e) {
		  });
	  }