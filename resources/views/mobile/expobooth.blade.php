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
        <!--div class="title">{{$booth->booth_title}}</div-->
        <div class="right">
          <a href="#" class="link icon-only icon-only2" id="expoBoothFavorite" onClick="togglebooth(this)" data-id="{{$booth->id}}">
            @if( empty($favorite->id) )
			  <i class="material-icons isfavorite hide">star</i>
			  <i class="material-icons unfavorite">star_outline</i>
			@else
			  <i class="material-icons isfavorite">star</i>
			  <i class="material-icons unfavorite hide">star_outline</i>				  
			@endif
          </a>
          <a href="#" data-actions="#share-pop-booth" class="actions-open link icon-only icon-only2">
            <i class="material-icons">share</i>
          </a>
		<a href="/m/search" class="link icon-only icon-only2"><i class="icon material-icons">search</i></a>
          <a href="/m/notilist" class="link icon-only">
            <i class="icon material-icons md-only">notifications
              <span class="badge color-red noti-cnt">{{empty($notiCount)?'0': $notiCount}}</span>
            </i>
          </a>
          <a href="/m/menu" class="link icon-only menu-icon">
            <i class="icon material-icons">menu</i>
          </a>
        </div>
      </div>
    </div>
    <div class="page-content" id="booth_page_content">
      <section>
        <div class="top-img-header header-filter border-radius "
          filter-color="lightgray-"
          style="background-image: url({{$booth->getMobileImageUrl()}});min-height:250px;max-height:40vh;overflow: hidden;" id="booth_head_img_area">
			<div class="booth_fix_title_wrap" style="    color: white;
    font-size: 18px;
    padding: 10px;
    position: fixed;
    top: 60px;">
				<div>
					{{$booth->expoBooth->expo_name}}
				</div>
				<div>
					{{$booth->booth_title}}
				</div>				
			</div>
          <!--img src="{{$booth->getMobileImageUrl()}}" class="border-radius" style="width:100%;"-->


          <div class="expo-detail-top-img-over" style="display:none;">

          </div>
			
        </div>
		  
        <div id="booth_head_tab_area">
          <div class="toolbar toolbar-top tabbar tabbar-scrollable"  style="top:0;background-color:white;position:relative;">
<span class="toolbar_right_btn hide disable" @click="scrollright">
	<i class="material-icons">arrow_left</i>
</span>			  
<div class="toolbar-inner">
	<a href="/m/live/view/{{$booth->id}}" class="tab-link booth_live_on_tag view_live_btn hide" data-booth_id="{{$booth->id}}"><i class="material-icons">live_tv</i></a>
	<a href="#tab-booth-1" class="tab-link tab-link-active">소개</a>
	<a href="#tab-booth-3" class="tab-link">전시상품</a>
	<a href="#tab-booth-2" class="tab-link">1:1 화상회의</a>

	@if ( empty(\Auth::user()) || \Auth::user()->company_id != $booth->company_id )
	<a href="/m/card/exchange/{{$booth->id}}" class="tab-link">비즈니스문의</a>
	@else
	<a href="/m/live/{{\Crypt::encryptString($booth->id)}}" class="tab-link">방송하기</a>
	<a href="/expo/megashow2020/booth/{{$booth->id}}" class="tab-link">
	<i class="material-icons">settings</i>
	</a>
	@endif					
</div>		  
<span class="toolbar_left_btn hide" @click="scrollleft">
	<i class="material-icons">arrow_right</i>
</span>
          </div>
        </div>
		<div id="fixed_area">
			
		  </div>
        <!--div class="tabs-animated-wrap"-->
          <div class="tabs" id="booth_tabs">
            <div id="tab-booth-1" class="page-content pt-0 tab tab-active" style="background-color:#999999;">
				
<a href="#" class="scrolltotopbooth hide"  @click="scrolltop">
	<i class="material-icons" >keyboard_arrow_up</i>
</a>	
				
              <div class="block block-booth-intro">
                <div class="block-booth-intro-inner">
                  <div class="block-title">

                    <div class="chip">
                      <div class="chip-media bg-color-blue" style="background-color: #2677b7 !important;">

                        <i class="icon material-icons md-only">loyalty</i>
                      </div>
                      <div class="chip-label">{{$booth->booth_title}}</div>
                    </div>
                  </div>
					<div id="panzoombooth" style="position:relative;">					
					
						  <!--img src="{{$booth->getDesktopImageUrl()}}" width="100%" /-->
						  <img src="{{$booth->getMobileImageUrl()}}" width="100%" />

						  <div class="block">
							{{$booth->booth_intro}}
						  </div>
						  <div class="" id="player" data-url="{{$booth->booth_youtube_url}}">
						  </div>

						  @foreach( $booth->boothAttach  as $attach)
						  <img src="{{ secure_url('/storage/'. $attach->url) }}" style="width:100%;display: block;font-size:0;">
						  @endforeach
						<div class="expo_booth_tag_wrap">
							<div class="expo_booth_tag_inner display-flex">
								@foreach( $booth->tags  as $tag)
								<a href="/m/search/{{urlencode($tag->name)}}" class="badge expo_booth_tag">
									#{{$tag->name}}
								</a>
								@endforeach
							</div>
						</div>
<a href="#" style="    position: fixed;
    bottom: 0px;
    right: 0px;
    padding: 10px;
    display: flex;;
				   " @click="photo">
	<i class="material-icons" style="
		border: 1px solid #eee;
		color: white;
		background-color: #777;
		opacity: .7;">zoom_out_map</i>
</a>
					</div>
					
                </div>
              </div>

              <div class="block block-booth-intro">
                <div class="block-booth-intro-inner">
                  <div class="block-title">
                    <div class="chip">
                      <div class="chip-media bg-color-blue" style="background-color: #2677b7 !important;">

                        <i class="icon material-icons md-only">business</i>
                      </div>
                      <div class="chip-label">회사명 : {{$booth->companyBooth->company_name}}</div>
                    </div>
                  </div>
                  @if( !empty($booth->companyBooth->company_image_url) )
                  <img src="{{ $booth->companyBooth->getImageUrl() }}" width="100%" />
                  @endif
                  <div class="block-title" style="padding-top:2px;padding-bottom:2px;margin-top:5px;margin-bottom:5px;margin-right: 4px;">
                    <div class="display-flex flex-direction-column text-align-right">
                      @if( !empty($booth->companyBooth->company_url) )
                      <div class="chip-block">
                        <div class="chip chip-right">
                          <div class="chip-label">
                            <a href="{{$booth->companyBooth->company_url}}" class="external" target="_blank" style="color: inherit;">
                            {{$booth->companyBooth->company_url}}
                            <a/>
                          </div>
                          <div class="chip-media bg-color-blue">
                            <a href="{{$booth->companyBooth->company_url}}" class="external" target="_blank" style="color: inherit;">
                              <i class="icon material-icons md-only">home</i>
                            </a>
                          </div>
                        </div>
                      </div>
                      @endif
                      @if( !empty($booth->companyBooth->company_email) )
                      <div class="chip-block">
                        <div class="chip chip-right">
                          <div class="chip-label">{{$booth->companyBooth->company_email}}</div>
                          <div class="chip-media bg-color-blue">
                            <a href="mailto:{{$booth->companyBooth->company_url}}" class="external" style="color: inherit;">
                              <i class="icon material-icons md-only">email</i>
                            </a>
                          </div>
                        </div>
                      </div>
                      @endif
                      @if( !empty($booth->companyBooth->company_tel1) )
                      <div class="chip-block">
                        <div class="chip chip-right">
                          <div class="chip-label">{{$booth->companyBooth->company_tel1}}</div>
                          <div class="chip-media bg-color-blue">
                            <a href="tel:{{$booth->companyBooth->company_tel1}}" class="external" style="color: inherit;">
                              <i class="icon material-icons md-only">phone</i>
                            </a>
                          </div>
                        </div>
                      </div>
                      @endif
                    </div>
                  </div>
                  @if( !empty($booth->companyBooth->company_info1) )
                  <div class="block-title company_info_box">
                    {{$booth->companyBooth->company_info1}}
                  </div>
                  @endif

                  <div class="display-flex justify-content-flex-end">
                  @if( !empty($booth->companyBooth->company_attachment_file_url1) )
                    <a href="/m-company-file?id={{$booth->companyBooth->id}}&file=1" class="external">
                      <div class="chip">
                        <div class="chip-media" style="background-color: #333 !important;">
                            <i class="icon material-icons md-only">save_alt</i>
                        </div>
                        <div class="chip-label">기업소개서#1</div>
                      </div>
                    </a>
                  @endif
                  @if( !empty($booth->companyBooth->company_attachment_file_url2) )
                    <a href="/m-company-file?id={{$booth->companyBooth->id}}&file=2" class="external">
                      <div class="chip">
                        <div class="chip-media" style="background-color: #333 !important;">
                            <i class="icon material-icons md-only">save_alt</i>
                        </div>
                        <div class="chip-label">기업소개서#2</div>
                      </div>
                    </a>
                  @endif
                  </div>

                </div>
              </div>
            </div>


            <div id="tab-booth-2" class="page-content pt-0 tab" style="background-color:white;">
              <div class="block">
                 <div class="block-title flex">
                   <div class="draw-select-btn" style="width:130px;">
                     <input type="text" class="custom_input_box draw-select-btn pickerDate" id="meet-date" readonly="readonly"/>
                   </div>
                 </div>

                <div class="list">
                  <ul id="booth_meeting_timetable">
                    @foreach( $timetables['data'] as $time)
                    <li data-date="{{$time['date']}}" data-time='{{$time['startTime']}}' data-booth="{{$booth->id}}">
                      @if( $time['avail_date'] && $time['reservation_available'] )
                      <a href="/expo/{{$expo->expo_code}}/{{$booth->id}}/reserve/{{$time['date']}}/{{$time['startTime']}}"
                        class="item-link item-content time-enabled"
                        @click='reserveMeeting'>
                        <div class="item-media">
                          <i class="material-icons">more_time</i>
                        </div>
                        <div class="item-inner">
                          <div class="item-title">{{ $time['startTimeDisplay'] }}:00 ~ {{ $time['endTimeDisplay'] }}:00</div>
                          <div class="item-after">신청</div>
                        </div>
                      </a>
                      @else
                      <a href="#" class="item-link item-content time-disabled">
                        <div class="item-media">
                          <i class="material-icons">disabled_by_default</i>
                        </div>
                        <div class="item-inner">
                          <div class="item-title">{{ $time['startTimeDisplay'] }}:00 ~ {{ $time['endTimeDisplay'] }}:00</div>
                          <div class="item-after"></div>
                        </div>
                      </a>
                      @endif
                    </li>
                    @endforeach
                  </ul>
                </div>
              </div>

            </div><!-- /tab-2 -->

				
			<div id="tab-booth-3" class="page-content pt-0 tab" style="background-color:white;">
				<div class="expo_booth_ready_wrap" >
					<div class="expo_booth_ready_inner">
					전시상품 준비중입니다.
					</div>
				</div>
				 <div class="list media-list product-list">
					<ul id="booth_prd_list_ul">

					</ul>
					<div class="display-flex justify-content-center list_page_wrap" id="booth_product_list_page_wrap">


					</div>
				</div>
				
			</div><!-- /tab-3 -->
			<div id="tab-booth-4" class="page-content pt-0 tab" style="background-color:white;">
				<div class="min-100vh">
					
				</div>
			</div><!-- /tab-4 -->
				
          </div><!-- /tabs -->
        <!--/div--> <!-- /tabs-animated-wrap -->
      </section>
    </div><!-- / page-content -->

    <div class="actions-modal" id="share-pop-booth">
      <div>
        <div class="actions-group snsbuttons">
          <div class="actions-button actions-close" @click="snsbooth('facebook')">
                <div class="actions-button-media">
                  <img src="/image/sns/facebook.png" width="48" style="max-width: 100%">
                </div>
                <div class="actions-button-text">FACEBOOK</div>
          </div>
          <div class="actions-button actions-close"  @click="snsbooth('kakao')">
                <div class="actions-button-media">
                  <img src="/image/sns/kakaotalk.png" width="48" style="max-width: 100%">
                </div>
                <div class="actions-button-text">카카오톡</div>
          </div>
          <div class="actions-button actions-close"  @click="snsbooth('naverband')">
                <div class="actions-button-media">
                  <img src="/image/sns/naverband.png" width="48" style="max-width: 100%">
                </div>
                <div class="actions-button-text">BAND</div>
          </div>
          <div class="actions-button actions-close"  @click="snsbooth('twitter')">
                <div class="actions-button-media">
                  <img src="/image/sns/twitter.png" width="48" style="max-width: 100%">
                </div>
                <div class="actions-button-text">Twitter</div>
          </div>
          <div class="actions-button actions-close"  @click="snsbooth('telegram')">
                <div class="actions-button-media">
                  <img src="/image/sns/telegram.png" width="48" style="max-width: 100%">
                </div>
                <div class="actions-button-text">Telegram</div>
          </div>
          <div class="actions-button actions-close"  @click="snsbooth('kakaostory')">
                <div class="actions-button-media">
                  <img src="/image/sns/kakaostory.png" width="48" style="max-width: 100%">
                </div>
                <div class="actions-button-text">kakaostory</div>
          </div>
          <div class="actions-button actions-close"  @click="snsbooth('naverblog')">
                <div class="actions-button-media">
                  <img src="/image/sns/naverblog.png" width="48" style="max-width: 100%">
                </div>
                <div class="actions-button-text">Naver Blog</div>
          </div>
		  <div class="actions-button actions-close clipboard" data-clipboard="{{secure_url('/expo/'.$expo->expo_code)}}" @click="clipboardcopy">
                <div class="actions-button-media">
                  <i class="material-icons">link</i>
                </div>
                <div class="actions-button-text">{{secure_url('/expo/'.$booth->expoBooth->expo_code.'/'.$booth->id)}}</div>
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
        booth_id: '{{$booth->id}}',
        expo_id: '{{$booth->expo_id}}',
        expo_code : '{{$expo->expo_code}}',
        dates: @json($dates),
        startdate : '{{$startdate}}',
        target : null,
        'sns' : {
          'title' : '{{$booth->booth_title}}',
          'image' : '{{ \URL::to( $booth->getMobileImageUrl() ) }}',
          'url' : '{{\URL::to( '/expo/'.$expo->expo_code .'/'.$booth->id )}}',
          'description' : `{{$booth->booth_intro}}`,
        },
        liveoncheck : '',
        remon : null,
        remonInterval : null,
		tabtofix : false,
		titletofix : false,
		imgtofix : false,
		myPhotoBrowser : null,
		beforescroll : {},
		compiled_prdtemplate : null,
		compiled_pagetemplate : null,
		  
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
pagetemplate:`

		<span class="page_last {{#js_if "this.current_page == 1 "}} disabled{{/js_if}}"

		{{#js_if "this.current_page != 1 "}}
			onClick="{{../event}}(1)"
		{{/js_if}}

			>
			<i class="material-icons">first_page</i>
		</span>

		<span class="page_prev {{#js_if "this.current_page == 1 "}} disabled{{/js_if}}"

		{{#js_if "this.current_page != 1 "}}
			onClick="{{../event}}({{prev_page}})"
		{{/js_if}}

			>
			<i class="material-icons">chevron_left</i>
		</span>

		<div class="page_wrap display-flex">
			{{#each paging}}
			<span class="justify-content-center {{#if current}} page_current {{/if}}" onClick="{{../event}}({{page}})">{{page}}</span>
			{{/each}}
		</div>
		
		<span class="page_next {{#js_if "this.current_page == this.last_page "}} disabled{{/js_if}}"

		{{#js_if "this.current_page != this.last_page "}}
			onClick="{{../event}}({{next_page}})"
		{{/js_if}}
				>
			<i class="material-icons">chevron_right</i>
		</span>

		<span class="page_last {{#js_if "this.current_page == this.last_page "}} disabled{{/js_if}}"

		{{#js_if "this.current_page != this.last_page "}}
			onClick="{{../event}}({{last_page}})"
		{{/js_if}}
				>
			<i class="material-icons">last_page</i>
		</span>

		`,		  
@endverbatim	
      }
    },
    methods: {
	  scrollleft : function() {
		  var scroll = $$("#booth_page_content .toolbar-inner").prop('scrollWidth') - $$("#booth_page_content .toolbar-inner").prop('clientWidth')
		  $$('#booth_page_content .toolbar-inner').animate({scrollLeft: 300}, 400);
	  },
	  scrollright : function() {
		  $$('#booth_page_content .toolbar-inner').animate({scrollLeft: 0}, 400);
	  },
	  scrolltop : function(e) {
		  var self = this;
		  $$(e.target).closest('.tab').scrollTop(0)
		  //$$("#booth_page_content").scrollTop(self.checkheight)
	  },
	  photo: function() {
		var self = this;
		  self.myPhotoBrowser.open();
	  },		
      snsbooth : function(sns) {
        var self = this;
        snsShare( sns, self.sns);
      },
		clipboardcopy: function(e) {
			
			var tmpTextarea = document.createElement('textarea');
			tmpTextarea.value = $$(e.target).text();

			document.body.appendChild(tmpTextarea);
			tmpTextarea.select();
			tmpTextarea.setSelectionRange(0, 9999);  // 셀렉트 범위 설정

			document.execCommand('copy');
			document.body.removeChild(tmpTextarea);
		},		
      togglefavorite : function () {
        var self = this;
        $$.ajax({
           url:"/mobileapi/favorite/booth",
           method:"POST",
           data:{'booth_id': self.booth_id },
           success:function(res)
           {
             if( res.data == 'off'){
               $$("#expoBoothFavorite").html('<i class="material-icons">star_outline</i>')
               noti('즐겨찾기에서 삭제되었습니다.', '');

             }else if( res.data == 'on' ){
               $$("#expoBoothFavorite").html('<i class="material-icons">star</i>')
               noti('즐겨찾기에 추가되었습니다.','');
             }
          },
           error: function ( err ){
             ajaxError(err);
           }
         });
      },
      reserveMeeting : function ( e ){
        var self = this;
        self.$setState({
          target: e.target,
        });
      },
      setReserved : function ( ){
      },
      drawTimetable : function ( data, checkLogin ) {
        var self = this;
        var clickMethod = ( checkLogin ) ? '@click="reserveMeeting"' : 'onClick="loginNeedAlert()"';

        $$("#booth_meeting_timetable").empty();
		let i = 1;
        $$.each(data, function(key, value){
          let str='';
		  var suffix = ordinal_suffix_of(i);
		  i++;			
          if ( value.avail_date && value.reservation_available){
            let url = ( checkLogin ) ? `/expo/${self.expo_code}/${self.booth_id}/reserve/${value.date}/${value.startTimeDisplay}` : '#';

            str =`
            <a href="${url}"
              class="item-link item-content time-enabled"
              ${clickMethod} >
              <div class="item-media">
                <!--i class="material-icons">more_time</i-->
				${suffix}
              </div>
              <div class="item-inner">
                <div class="item-title">${value.startTimeDisplay}:00 ~ ${value.endTimeDisplay}:00</div>
                <div class="item-after">신청가능</div>
              </div>
            </a>
            `
          }else {
            str =`
            <a href="#" class="item-link item-content time-disabled">
              <div class="item-media">
                <!--i class="material-icons">disabled_by_default</i-->
				${suffix}
              </div>
              <div class="item-inner">
                <div class="item-title">${value.startTimeDisplay}:00 ~ ${value.endTimeDisplay}:00</div>
                <div class="item-after">신청불가</div>
              </div>
            </a>
            `
          }
          let li = `
          <li data-date="${value.date} "data-time='${value.startTime}' data-booth="${self.booth_id}">
            ${str}
          </li>
          `;
          $$("#booth_meeting_timetable").append(li);
        });
      },
      checkBoothLive : async function() {
        var self = this;
        var searchResult = await self.remon.fetchCasts();
        for ( var i=0 ;i < searchResult.length; i++) { 
          if(searchResult[i].id.includes('booth_{{$booth->id}}_',0) ) {
            $$(".view_live_btn").removeClass("hide")
            return;
          }
        }
        $$(".view_live_btn").addClass("hide")
      },
	  prdlist: function(page){
		var self = this;  
		var url = "/mobileapi/prdlist/{{$expo->id}}/{{$booth->id}}"
		  
	  	if (self.compiled_prdtemplate == null){
	  		self.compiled_prdtemplate = Template7.compile(self.prdtemplate);
			self.compiled_pagetemplate = Template7.compile(self.pagetemplate);
  		}else{
			$$("#tab-booth-3").animate({scrollTop: 26}, 200,'easeOutQuart')
		}
		  
 
		axios({
			method: 'get',
			url: url,
			params: {
				page : page ,
			}
		}).then(function (response) {
			var res = response.data.data
			var eachside = 2;
			var startpage = 1;
			var pagedata = {
				'current_page' : res.current_page,
				'last_page' : res.last_page,
				'prev_page' : res.current_page,
				'next_page' : res.last_page,
				'paging' : [],
				'event' : 'boothprdlistpaging',
			}
			if( res.total > 0 ){
				$$("#tab-booth-3 > .expo_booth_ready_wrap").addClass("hide")
				$$("#booth_prd_list_ul").html(self.compiled_prdtemplate(res));
			   if (res.current_page > eachside){
				   startpage = res.current_page - eachside;
			   }
			   if( startpage + eachside*2 - 1 > res.last_page ){
				   startpage = res.last_page -  eachside*2 + 1
			   }
			   if ( startpage < 1) startpage = 1
			   for( var i=0 ; i <eachside*2; i++){
				   page = startpage + i;
				   if( page > res.last_page) break;
				   pagedata.paging.push({'page': page, 'current' : (page==res.current_page) ? true : false })
			   }
			   pagedata.prev_page = res.current_page -1;
			   pagedata.next_page = res.current_page +1;
				
			   $$("#booth_product_list_page_wrap").html( self.compiled_pagetemplate(pagedata) )
				
			}
		});
		  
		  
		  
		  
	  },		
    },
    on: {
      pageBeforeRemove: function () {
        var self = this;
        var app = self.$app;
        // Destroy popup when page removed
        if (self.notificationFull) self.notificationFull.destroy();
        if (self.popup) self.popup.destroy();
        if (self.popupSwipe) self.popupSwipe.destroy();
        if (self.popupSwipeHandler) self.popupSwipeHandler.destroy();
        if (self.popupPush) self.popupPush.destroy();
        if (app.picker) app.picker.destroy();
		self.myPhotoBrowser.destroy()
        $$(document).off('reserved');
		$$("#booth_page_content").off("scroll");
		  $$("#booth_tabs > div").off("scroll");
		  $$('#booth_page_content .toolbar-inner').off("scroll");
		  etcEvents.off('booth_prd_page');
		  
      },
      pageInit: function () {
        var self = this;
        var today = new Date();
        var app = self.$app;
        var pickerDevice = app.picker.create({
          inputEl: '.pickerDate',
          cols: [
            {
              textAlign: 'center',
              //values: ['2020-10-19','2020-10-20','2020-10-21','2020-10-22'],
              values : self.dates,
              //displayValues : ['2020-10-19','2020-10-20','2020-10-21','2020-10-22'],
              textAlign : 'left'
            }
          ],
          value : [ self.startdate ],
          on : {
            change : function ( picker, val , displayValues){
              $$.ajax({
                 url:"/reserve-timetable",
                 method:"get",
                 data:{'booth': self.booth_id, 'date' : val[0] },
                 success:function(res)
                 {
                  if( res.result=='OK'){
                    self.drawTimetable( res.data, res.checkLogin)
                  }else {
                    $$("#booth_meeting_timetable").empty();
                  }
                 },
                 error: function ( err ){
                   ajaxError(err);
                 }
               });
            },
            close : function (picker) {
              return false;
            },
          }

        });
        $$(document).on('reserved', function (e) {
          var v = pickerDevice.getValue()
          pickerDevice.emit('change', '',v )
        });
        var expodoc = {
          "_id" : "{{$booth->id}}",
          "expo_code" : "{{$expo->expo_code}}",
          "expo_name" : "{{$expo->expo_name}}",
          "booth_title" : "{{$booth->booth_title}}",
          "img" : "{{$booth->getMobileImageUrl()}}",
          "date" : "{{\Carbon\Carbon::now()}}"
        }
		
		$$("#booth_tabs > div").each(function () {
			var id = $(this).attr('id')
			self.beforescroll[id] =0;
		})
		  
		self.checkheight = $$("#booth_head_img_area").height() - ($$(".booth_fix_title_wrap").height()+ 30 ) 
		var height = $$("#app").height() - (  ($$(".booth_fix_title_wrap").height()+ 30 ) + $$("#booth_head_tab_area").height()+6 +$$(".navbar").height());
		$$("#booth_tabs").css('max-height',  height )
		$$("#booth_tabs").css('height',  height )
		  
		$$("#booth_page_content").on("scroll", function (e) { 
			
			
			if( $(e.target).scrollTop() >= self.checkheight ){
				if( !self.imgtofix ) {
					var imgarea = $$("#booth_head_img_area").height();
					var top = $$("#booth_head_img_area").height() - ($$(".booth_fix_title_wrap").height() + 20 + 10 ) 
					
					$("#booth_page_content").addClass("imgtofix")
					$$("#booth_head_img_area").css("top", (top) * -1 + $$(".navbar").height() )
					$$("#booth_page_content").children("section").css('padding-top' , imgarea + $$(".navbar").height()  )
					$$("#booth_head_tab_area").css("top", ($$(".booth_fix_title_wrap").height() + 20 + 10 + $$(".navbar").height() ) )

					 self.imgtofix = true;
				}
			}else {
				if( self.imgtofix ) {
					$("#booth_page_content").removeClass("imgtofix")
					$$("#booth_head_img_area").css("top", 'inherit')
					$$("#booth_page_content").children("section").css('padding-top', 0)
					$$("#booth_head_tab_area").css("top", 0 )

					self.imgtofix = false;
					self.tabtofix = false;
				}
			}			
		})
		$$("#booth_tabs > div").on("scroll", function (e) {
			var id = $$(e.target).attr('id');
			var scrolldirection = 'none';
			if( typeof self.beforescroll[id] == 'undefined'){
				 scrolldirection = 'none'
			}else if( self.beforescroll[id] <= $$(e.target).scrollTop() ) {
				scrolldirection = "down"
			}else scrolldirection = "up"	
			
			self.beforescroll[id] = $$(e.target).scrollTop();
			
			if( !self.tabtofix && scrolldirection=='down' && $$(e.target).scrollTop() > 150 ){
				//$$("#expo_page_content").scrollTop(self.checkheight)
				if( !self.imgtofix) $$("#booth_page_content").animate({scrollTop: self.checkheight}, 200,'easeOutQuart')

				$$(e.target).find(".scrolltotopbooth").removeClass("hide")
				
				self.tabtofix = true;
			}else if( self.tabtofix && scrolldirection=='up' && $$(e.target).scrollTop() < 150) {
				if( self.imgtofix) $$("#booth_page_content").animate({scrollTop: 0 }, 100,'easeOutQuart')
				$$(e.target).find(".scrolltotopbooth").addClass("hide")
				self.tabtofix = false;
			}
		});
		  
		  
			var element = "#booth_page_content .toolbar-inner";
		  
			if( $$(element).prop('scrollWidth') > $$(element).prop('clientWidth') ) {
				$$(".toolbar_left_btn").removeClass("hide")
				$$(".toolbar_right_btn").removeClass("hide")
				$$(element + '> a').last().css("padding-right" ,40)
				$$(element ).css("padding-left" ,30)
			 }	
		    var vscrollcheck = null 
			$$('#booth_page_content .toolbar-inner').on("scroll", function(e) { 
				
				var scroll = $$(e.target).scrollLeft();
				if (vscrollcheck==null)  vscrollcheck = $$(element).prop('scrollWidth') - $$(element).prop('clientWidth')  ;
				
				if( scroll >=  vscrollcheck ){
					$$(e.target).next().addClass("disable")
				}else if( scroll <= 2){
					$$(e.target).prev().addClass("disable")
				}else if(scroll <= vscrollcheck-2 ) {
					$$(e.target).next().removeClass("disable")
					$$(e.target).prev().removeClass("disable")
				}
			});;
		  
		  
		  
			var playerstr = previewYoutube("#player");
			if (playerstr != '' ){
			  $$("#player").html (playerstr).addClass("ytplayer")
			}
		  
		  
			var photo=[];
			$$("#panzoombooth").find("img").each( function() {
				photo.push($$(this).attr('src')) 
			});

		  
			self.myPhotoBrowser = app.photoBrowser.create({photos:photo, theme:'dark'});
		  
		  @if( $expo->open_date <= \Carbon\Carbon::now() )
		  self.prdlist(1);
		  @endif
		  
		  etcEvents.on('booth_prd_page', function (page) {
		  	self.prdlist(page.page)
		  })
        myBootmDB.get('{{$booth->id}}').then(function (doc) {
          myBootmDB.remove(doc)
          myBootmDB.put(expodoc);
        }).catch(function (err) {
          myBootmDB.put(expodoc)
        });
        myBootmDB.allDocs({
                include_docs: true,
                attachments: true
                }).then(function (result) {
                  if( result.total_rows > 30){
                    sorted = rowSort( result.rows)
                    var popdata = sorted[ sorted.length - 1 ];
                    myBootmDB.remove(popdata.id, popdata.value.rev , function (err){
                      console.log (err)
                    })
                  }
                }).catch(function (err) {
                  console.log(err);
                });
			if( typeof booth_live['booth_{{$booth->id}}'] != 'undefined')	{
				$$(".view_live_btn").removeClass("hide")
			}
  
      },
    }
  }
</script>
