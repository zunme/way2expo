<template>
  <div class="page page-expo">
    <div class="navbar navbar-new">
      <div class="navbar-bg"></div>
      <div class="navbar-inner sliding">
        <div class="left">
          <a href="#" class="link back">
            <i class="icon icon-back"></i>
            <span class="if-not-md">Back</span>
          </a>
        </div>
        <!--div class="title">{{$expo->expo_name}}</div-->
        <div class="right">
          <a href="#" class="link icon-only icon-only2 globalToggleExpoLink" id="expoFavorite" onClick="toggleexpo(this)" data-id="{{$expo->id}}">
            @if( $expoFavorite)
            <i class="material-icons isfavorite">star</i>
			<i class="material-icons unfavorite hide">star_border</i>
            @else
			<i class="material-icons isfavorite hide">star</i>
			<i class="material-icons unfavorite">star_border</i>			  
            @endif
          </a>

          <a href="#" data-actions="#share-pop" class="actions-open link icon-only icon-only2">
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


    <div class="fab-backdrop"></div>
    <div class="fab fab-right-top snsshare-icons" style="right: 68px;">
      <a href="#" class="link icon-only icon-only2">
        <i class="material-icons">share</i>
        <i class="icon f7-icons">xmark</i>
      </a>
      <div class="fab-buttons fab-buttons-bottom sns-share-link">
        <a href="#" class="bg_facebook fab-close">
        </a>
        <a href="#" class="bg_kakaotalk fab-close">
        </a>
      </div>
    </div>

    <div class="page-content" id="expo_page_content">
      <section>
        <div class="top-img-header header-filter border-radius background-pos-top"
          filter-color="lightgray" style="background-image: url({{$expo->getImageUrl()}});" id="expo_head_img_area">
          <!--img src="{{$expo->getImageUrl()}}" class="border-radius" style="width:100%;"-->
			<div class="expo_fix_title_wrap" style="    color: white;
    font-size: 18px;
    padding: 10px;
    position: fixed;
    top: 60px;z-index: 3;">
				<div class="expo_fix_title_exponame">
					{{$expo->expo_name}}
				</div>
				<div class="expo_fix_title_duration">
					{{$expo->expo_open_date->format('Y-m-d')}} ~ {{$expo->expo_close_date->format('Y-m-d')}}
				</div>
			</div>
			
          <div class="expo-detail-top-img-over"style="display:none">
            <div class="expo-detail-top-img-over-inner">
              <div>
                @if ( !empty($expo->expo_url) )
                <a href="{{$expo->expo_url}}" target="_blank" class="link external circle_btn_36"><i class="material-icons">home</i></a>
                @endif
                @if ( !empty($expo->expo_info_phone) )
                <a href="tel:{{$expo->expo_info_phone}}" target="_blank" class="link external circle_btn_36">
                  <i class="material-icons">phone</i>
                </a>
                @endif
                @if ( !empty($expo->expo_info_email) )
                <a href="mailto:{{$expo->expo_info_email}}" target="_blank" class="link external circle_btn_36">
                  <i class="material-icons">email</i>
                </a>
                @endif
                @if ( !empty($expo->expo_location) )
                <a href="https://m.search.naver.com/search.naver?query={{urlencode($expo->expo_location)}}" target="_blank" class="link external circle_btn_36"><i class="material-icons">location_on</i></a>
                @endif
              </div>
              <div>
                @if( empty( $myBooth) )
                  @if( $myCompanyId > 0 )
                  <a href="/expo/{{$expo->expo_code}}/booth" class="button button-fill">
                    부스만들기
                  </a>
                  @else
                    <a href="#" class="button button-fill popup-open" data-popup=".popup-make-booth">
                      부스만들기
                    </a>
                  @endif
                @else
                <a href="#" class="button button-fill" @click="viewbooth">
                  내부스보기
                </a>
                @endif
                <!--a href="#" class="button button-fill" @click="createPopup">Create Dynamic Popup</a>
                <a href="#" class="button button-fill popup-open" data-popup=".demo-popup-swipe">Swipe To Close</a>
                <a href="#" class="button button-fill popup-open" data-popup=".demo-popup-swipe-handler">With Swipe Handler</a-->
              </div>
            </div>
          </div>
        </div>

        <div id="expo_head_tab_area" style="position:relative;margin-top: 6px;">
          <div class="toolbar toolbar-top tabbar"  style="top:0;background-color:white;">
            <div class="toolbar-inner">
              <a href="#tab-expo1" class="tab-link tab-link-active font-15">소개</a>
              <a href="#tab-expo2" class="tab-link  font-15">부스</a>
              <a href="#tab-expo3" class="tab-link  font-15">전시상품</a>
              <a href="#tab-expo4" class="tab-link  font-15">출품안내</a>				
            </div>
          </div>
        </div>

        <!--div class="tabs-animated-wrap" style="height: calc( 100vh - 220px);"-->
          <div class="tabs" id="expo_tabs">

            <div id="tab-expo1" class="page-content pt-0 tab tab-active">

				<a href="#" class="scrolltotopbooth hide" @click="scrolltop">
					<i class="material-icons" >keyboard_arrow_up</i>
				</a>	
			
			<div class="expo_etc_info_wrap block" >
				<div class="expo_etc_info_inner">
					@if ( !empty($expo->expo_url) )
					<a href="{{$expo->expo_url}}" target="_blank" class="link external circle_btn_36"><i class="material-icons">home</i></a>
					@endif
					@if ( !empty($expo->expo_info_phone) )
					<a href="tel:{{$expo->expo_info_phone}}" target="_blank" class="link external circle_btn_36">
					  <i class="material-icons">phone</i>
					</a>
					@endif
					@if ( !empty($expo->expo_info_email) )
					<a href="mailto:{{$expo->expo_info_email}}" target="_blank" class="link external circle_btn_36">
					  <i class="material-icons">email</i>
					</a>
					@endif
					@if ( !empty($expo->expo_location) )
					<a href="https://m.search.naver.com/search.naver?query={{urlencode($expo->expo_location)}}" target="_blank" class="link external circle_btn_36"><i class="material-icons">location_on</i></a>
					@endif


				</div>
			</div>
							
				
              <div class="block">
				 <div id="panzoom" style="position:relative;">
					<img src="{{$expo->getImageUrl()}}" style="width:100%;">
                <div class="expo-description-box">
                  {!! nl2br($expo->expo_description) !!}
                </div>					 
	@foreach( $expo->expoAttach  as $attach)
					<img src="{{ secure_url('/storage/'. $attach->url) }}" style="width:100%;" />
                  @endforeach
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

            <div id="tab-expo2" class="page-content pt-0 tab">
<div>
	<div>
		@if( !empty($banners) )
		@include('mobile.inc.banner', ['banners'=>$banners])
		@endif
	</div>
	<div class="display-flex expo_booth_list_wrap">
	@if ( $expo->open=='Y' || $expo->getProgressStatus() != 'pre' )
		<div class="expo_booth_list_inner" style="">		
			<div class="list search-list searchbar-found no-gap" style="margin: 15px 10px 20px;">
				<ul class="row no-gap" id="expo_booth_list_ul" style="padding-left: 8px;border-radius: 5px;">
				</ul>
				<div class="display-flex justify-content-center" id="expo_booth_list_page_wrap">

				</div>
			</div>	
		</div><!-- /flex-grow-->
		@else
		<div class="expo_booth_ready_wrap">
			<div class="expo_booth_ready_inner">
			부스 준비중입니다.
			</div>
		</div>
		@endif
	</div><!-- /wrap-->
</div>

              </div><!-- /tab-2 -->
			  
			  
<div id="tab-expo3"  class="page-content pt-0 tab">
	<div class="expo_booth_ready_wrap" >
		<div class="expo_booth_ready_inner">
		상품을 준비중입니다.
		</div>
	</div>
	 <div class="list media-list product-list">
		<ul id="expo_prd_list_ul">

		</ul>
		<div class="display-flex justify-content-center list_page_wrap" id="expo_product_list_page_wrap">


		</div>
	</div>
</div><!-- /tab-3 -->
<div id="tab-expo4" class="page-content pt-0 tab ">
 @include('mobile.inc.exhibitguide')
</div><!-- /tab-4 -->
			  
            </div> <!-- /tabs -->
          <!--/div--> <!-- /tabs-animate -->
      </section>
    </div><!-- / page-content -->
    <div class="actions-modal" id="share-pop">
      <div>
        <div class="actions-group snsbuttons">
          <div class="actions-button actions-close" @click="sns('facebook')">
                <div class="actions-button-media">
                  <img src="/image/sns/facebook.png" width="48" style="max-width: 100%">
                </div>
                <div class="actions-button-text">FACEBOOK</div>
          </div>
          <div class="actions-button actions-close"  @click="sns('kakao')">
                <div class="actions-button-media">
                  <img src="/image/sns/kakaotalk.png" width="48" style="max-width: 100%">
                </div>
                <div class="actions-button-text">카카오톡</div>
          </div>
          <div class="actions-button actions-close"  @click="sns('naverband')">
                <div class="actions-button-media">
                  <img src="/image/sns/naverband.png" width="48" style="max-width: 100%">
                </div>
                <div class="actions-button-text">BAND</div>
          </div>
          <div class="actions-button actions-close"  @click="sns('twitter')">
                <div class="actions-button-media">
                  <img src="/image/sns/twitter.png" width="48" style="max-width: 100%">
                </div>
                <div class="actions-button-text">Twitter</div>
          </div>
          <div class="actions-button actions-close"  @click="sns('telegram')">
                <div class="actions-button-media">
                  <img src="/image/sns/telegram.png" width="48" style="max-width: 100%">
                </div>
                <div class="actions-button-text">Telegram</div>
          </div>
          <div class="actions-button actions-close"  @click="sns('kakaostory')">
                <div class="actions-button-media">
                  <img src="/image/sns/kakaostory.png" width="48" style="max-width: 100%">
                </div>
                <div class="actions-button-text">kakaostory</div>
          </div>
          <div class="actions-button actions-close"  @click="sns('naverblog')">
                <div class="actions-button-media">
                  <img src="/image/sns/naverblog.png" width="48" style="max-width: 100%">
                </div>
                <div class="actions-button-text">Naver Blog</div>
          </div>
		  <div class="actions-button actions-close clipboard" data-clipboard="{{secure_url('/expo/'.$expo->expo_code)}}" @click="clipboardcopy">
                <div class="actions-button-media">
                  <i class="material-icons">link</i>
                </div>
                <div class="actions-button-text">{{secure_url('/expo/'.$expo->expo_code)}}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="popup popup-make-booth">
      <div class="page">
        <div class="navbar">
          <div class="navbar-bg"></div>
          <div class="navbar-inner">
            <div class="title" style="flex-grow:1;text-align:center;">
              기업회원 전환 안내
            </div>
            <div class="pop-close-icon-btn"><a href="#" class="link popup-close"><i class="material-icons">close</i></a></div>
          </div>
        </div>
        <div class="toolbar toolbar-bottom">
          <div class="toolbar-inner" style="justify-content: center;">
            <a href="mailto:{{ Config::get('expo.email') }}" class="external button button-fill color-blue" data-popup=".demo-popup" style="min-width: 80%;">
              전환신청 메일보내기
            </a>
          </div>
        </div>
        <div class="page-content">
          <div class="block pop-office-change" style="text-align:center;">
            <p><i class="material-icons pop-office-icon">business</i></p>
            <p>온라인 부스는 기업회원 전용 메뉴입니다.</p>
            <p>기업회원이 되면 다양한 서비스를 이용할 수 있습니다..</p>
          </div>
          <div class="block pop-office-change">
            <div class="pop-office-change-inner">
              <div class="pop-office-change-title">
                <i class="material-icons">done_outline</i>
                <div class="office-change-subtitle">부스만들기</div>
              </div>
            </div>
            <div class="pop-office-change-inner">
              <div class="pop-office-change-title">
                <i class="material-icons">done_outline</i>
                <div class="office-change-subtitle">박람회 참여</div>
              </div>
            </div>
            <div class="pop-office-change-inner">
              <div class="pop-office-change-title">
                <i class="material-icons">done_outline</i>
                <div class="office-change-subtitle">방송하기</div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="popup demo-popup-swipe">
      <div class="page">
        <div class="navbar">
          <div class="navbar-bg"></div>
          <div class="navbar-inner">
            <div class="title">Swipe To Close</div>
            <div class="right"><a href="#" class="link popup-close">Close</a></div>
          </div>
        </div>
        <div class="page-content">
          <div style="height: 100%" class="display-flex justify-content-center align-items-center">
            <p>Swipe me up or down</p>
          </div>
        </div>
      </div>
    </div>
    <div class="popup demo-popup-swipe-handler">
      <div class="page">
        <div class="swipe-handler"></div>
        <div class="page-content">
          <div class="block-title block-title-large">Hello!</div>
          <div class="block block-strong">
cont
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  return {
    data : function() {
      return {
        'data' : {
          'title' : '{{$expo->expo_name}}',
          'image' : '{{ \URL::to( '/storage/'.$expo->expo_image_url ) }}',
          'url' : '{{\URL::to( '/expo/'.$expo->expo_code )}}',
          'description' : `{{$expo->expo_description}}`,
			'myPhotoBrowser' : null,
        },
		myPhotoBrowser : null,
		imgtofix : false,
		tabtofix : false,
		beforescroll : {},
		compiled_searchtemplate : null,
	    compiled_pagetemplate : null,
		compiled_prdtemplate : null,
@verbatim		  
		searchtemplate:`
{{#each data}}
<li class="item-content col-50">
	<div class="item-inner">
	  <div class="card demo-card-header-pic booth-card mb-10 elevation-3" style="margin-left: 0;">

		  <a href="/expo/{{../../expo_code}}/{{id}}" data-transition="f7-dive" style="height:100%;background-image:url(/storage/{{booth_mobile_image_url}})" valign="bottom" class="card-header expo_booth_card_header pl-0 pr-0 pb-0">
			  <div class="booth_live_on_in_expo booth_live_on_tag elevation-5 display-flex flex-direction-column hide" data-booth_id="{{id}}">
				  <i class="material-icons align-self-center">live_tv</i>
				  <div style="font-size: 14px;">
					  LIVE ON
				  </div>
			  </div>
		  </a>

		<div class="expo_detail_booth_fav_wrap" style="position: absolute;top: 0px;right: 0px;padding: 6px;">
			<a href="#" class="globalToggleBoothLink" onclick="togglebooth(this)" data-id="{{id}}" style="color:red;">
				<i class="material-icons isfavorite
{{#js_if " this.isfavorite !='true' "}} hide {{/js_if}}
				">favorite</i>
				<i class="material-icons unfavorite 
{{#js_if " this.isfavorite !='false' "}} hide {{/js_if}}">favorite_border</i>
												</a>
		</div>


		  <div class="card-content booth-card-content-padding">
			  <a href="/expo/isfavorite/{{id}}" data-transition="f7-dive" class="">
				  <div class="card-expo-title">{{booth_title}}</div>
				  <div class="card-expo-title booth_company_name">
					{{#company_booth}}
						{{company_name}}
					{{/company_booth}}
				  </div>
			  </a>
		  </div>

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
							가격 문의
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
    },
    methods: {
	  scrolltop : function(e) {
		  var self = this;
		  $$(e.target).closest('.tab').scrollTop(0)
		  //$$("#booth_page_content").scrollTop(self.checkheight)
	  },		
	  photo: function() {
		var self = this;
		  self.data.myPhotoBrowser.open();
	  },
      sns : function(sns) {
        var self = this;
        snsShare( sns, self.data);
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
           url:"/mobileapi/favorite/expo",
           method:"POST",
           data:{'expo_id': {{$expo->id}} },
           success:function(res)
           {
             if( res.data == 'remove'){
               $$("#expoFavorite").html('<i class="material-icons">star_outline</i>')
               self.showNotificationFull('즐겨찾기에서 삭제되었습니다.', '');

             }else if( res.data == 'add' ){
               $$("#expoFavorite").html('<i class="material-icons">star</i>')
               self.showNotificationFull('즐겨찾기에 추가되었습니다.','');
             }
          },
           error: function ( err ){
             console.log ( "error")
             ajaxError(err);
           }
         });
      },
	  prdlist: function(page){
		var self = this;  
		var url = "/mobileapi/prdlist/{{$expo->id}}"
		
	  	if (self.compiled_prdtemplate == null){
	  		self.compiled_prdtemplate = Template7.compile(self.prdtemplate);
			//self.compiled_pagetemplate = Template7.compile(self.pagetemplate);
  		}else{
			$$("#tab-expo3").animate({scrollTop: 26}, 200,'easeOutQuart')
		}
		 if( self.compiled_pagetemplate == null )self.compiled_pagetemplate = Template7.compile(self.pagetemplate);
		 
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
				'event' : 'expoprdlistpaging',
			}
			if( res.total > 0 ){
				$$("#tab-expo3 > .expo_booth_ready_wrap").addClass("hide")
				$$("#expo_prd_list_ul").html(self.compiled_prdtemplate(res));
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
				
			   $$("#expo_product_list_page_wrap").html( self.compiled_pagetemplate(pagedata) )
				
			}
		});
	  },
	  boothlist : function(page) {
	  	var self = this;
	  	if (self.compiled_searchtemplate == null){
	  		self.compiled_searchtemplate = Template7.compile(self.searchtemplate);
			self.compiled_pagetemplate = Template7.compile(self.pagetemplate);
  		}
		var url = "/mobileapi/boothlist/{{$expo->id}}/"
		  
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
			res['expo_code'] = '{{$expo->expo_code}}'

			$$("#expo_booth_list_ul").html(self.compiled_searchtemplate(res))
			if( res.total > 0) {
				var pagedata = {
					'current_page' : res.current_page,
					'last_page' : res.last_page,
					'prev_page' : res.current_page,
					'next_page' : res.last_page,
					'paging' : [],
					'event' : 'boothlistpaging',
				}
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
				
			   $$("#expo_booth_list_page_wrap").html( self.compiled_pagetemplate(pagedata) )
			}
			//
		});
		  
	  },
      viewbooth: function () {
        var self = this;
        app.tab.show('#tab-2',false);
        app.searchbar.search('#booth-search-in-expo', '#내부스')
      },
      showNotificationFull: function (title, text) {
        var self = this;
        // Create notification
        if ( self.notificationFull ) self.notificationFull.destroy();
        //if (!self.notificationFull) {
          self.notificationFull = self.$app.notification.create({
            icon: '<img src="/image/fav32.png" style="width:16px;">',
            title: 'Way2EXPO',
            titleRightText: 'now',
            subtitle: title,
            text: text,
            closeTimeout: 3000,
          });
        //}
        // Open it
        self.notificationFull.open();
      },
      createPopup: function () {
        var self = this;
        // Create popup
        if (!self.popup) {
          self.popup = self.$app.popup.create({
            content: '\
              <div class="popup">\
                <div class="page">\
                  <div class="navbar">\
                    <div class="navbar-bg"></div>\
                    <div class="navbar-inner">\
                      <div class="title">Dynamic Popup</div>\
                      <div class="right"><a href="#" class="link popup-close">Close</a></div>\
                    </div>\
                  </div>\
                  <div class="page-content">\
                    <div class="block">\
                      <p>This popup was created dynamically</p>\
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse faucibus mauris leo, eu bibendum neque congue non. Ut leo mauris, eleifend eu commodo a, egestas ac urna. Maecenas in lacus faucibus, viverra ipsum pulvinar, molestie arcu. Etiam lacinia venenatis dignissim. Suspendisse non nisl semper tellus malesuada suscipit eu et eros. Nulla eu enim quis quam elementum vulputate. Mauris ornare consequat nunc viverra pellentesque. Aenean semper eu massa sit amet aliquam. Integer et neque sed libero mollis elementum at vitae ligula. Vestibulum pharetra sed libero sed porttitor. Suspendisse a faucibus lectus.</p>\
                    </div>\
                  </div>\
                </div>\
              </div>\
            '
          });
        }
        // Open it
        self.popup.open();
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
		  self.data.myPhotoBrowser.destroy()
		  $$("#expo_tabs > div").off("scroll");
		  $$("#expo_page_content").off("scroll");
		  etcEvents.off('page')
		  etcEvents.off('expo_prd_page');
      },
      pageInit: function () {
        var self = this;
        self.popupSwipe = self.$f7.popup.create({
          el: '.demo-popup-swipe',
          swipeToClose: true,
        });
        self.popupSwipeHandler = self.$f7.popup.create({
          el: '.demo-popup-swipe-handler',
          swipeToClose: 'to-bottom',
          swipeHandler: '.swipe-handler'
        });
        self.popupPush = self.$f7.popup.create({
          el: '.demo-popup-push',
          swipeToClose: true,
          push: true,
        });
		  
		$$("#expo_tabs > div").each(function () {
			var id = $(this).attr('id')
			self.beforescroll[id] =0;
		})
		  
		self.checkheight = $$("#expo_head_img_area").height() - ($$(".expo_fix_title_wrap").height()+ 30 ) 
		  
		var height = $$("#app").height() - (  ($$(".expo_fix_title_wrap").height()+ 30 ) + $$("#expo_head_tab_area").height()+6 +$$(".navbar").height());
		  
		$$("#expo_tabs").css('max-height',  height )
		$$("#expo_tabs").css('height',  height )
		  
		$$("#expo_page_content").on("scroll", function (e) { 
			if( $(e.target).scrollTop() >= self.checkheight ){
				if( !self.imgtofix ) {
				var imgarea = $$("#expo_head_img_area").height();
				var top = $$("#expo_head_img_area").height() - ($$(".expo_fix_title_wrap").height() + 20 + 10 ) 

				$("#expo_page_content").addClass("imgtofix")
				$$("#expo_head_img_area").css("top", (top) * -1 + $$(".navbar").height() )
				$$("#expo_page_content").children("section").css('padding-top' , imgarea + $$(".navbar").height()  )
				$$("#expo_head_tab_area").css("top", ($$(".expo_fix_title_wrap").height() + 20 + 10 + $$(".navbar").height() ) )
					 self.imgtofix = true;
				}
			}else {
				if( self.imgtofix ) {
					$$("#expo_page_content").removeClass("imgtofix")
					$$("#expo_head_img_area").css("top", 'inherit')
					$$("#expo_page_content").children("section").css('padding-top', 0)
					$$("#expo_head_tab_area").css("top", 0 )
					self.imgtofix = false;
					self.tabtofix = false;
				}
			}			
		})	
		$$("#expo_tabs > div").on("scroll", function (e) {
			var id = $$(e.target).attr('id');
			var scrolldirection = 'none';
			if( typeof self.beforescroll[id] == 'undefined'){
				 scrolldirection = 'none'
			}else if( self.beforescroll[id] <= $$(e.target).scrollTop() ) {
				scrolldirection = "down"
			}else scrolldirection = "up"	
			
			self.beforescroll[id] = $$(e.target).scrollTop();
			
			if( !self.tabtofix &&  scrolldirection=='down' && $$(e.target).scrollTop() > 25 ){
				//$$("#expo_page_content").scrollTop(self.checkheight)
				$$(e.target).scrollTop(26)
				if( !self.imgtofix) 				$$("#expo_page_content").animate({scrollTop: self.checkheight}, 200,'easeOutQuart')
				
				$$(e.target).find(".scrolltotopbooth").removeClass("hide")
				self.tabtofix = true;
			}else if( self.tabtofix &&  scrolldirection=='up' && $$(e.target).scrollTop() < 25) {

				if( self.imgtofix) $$("#expo_page_content").animate({scrollTop: 0 }, 100,'easeOutQuart')
				$$(e.target).find(".scrolltotopbooth").addClass("hide")
				self.tabtofix = false;
			}
		});
		  
		@if( $expo->open=='Y' || $expo->getProgressStatus() != 'pre')
		self.boothlist(1)
		  @if( $expo->getProgressStatus() != 'pre' )
		  	self.prdlist(1)
		  @endif
		@endif
		 
		etcEvents.on('page', function (page) {
		  self.boothlist(page.page)
		})
		  
		etcEvents.on('expo_prd_page', function (page) {
		  self.prdlist(page.page)
		})
		  
        var expodoc = {
          "_id" : "{{$expo->expo_code}}",
          "title" : "{{$expo->expo_name}}",
          "img" : "{{$expo->getImageUrl()}}",
          "start" : "{{$expo->expo_open_date->format('Y-m-d')}}",
          "end" : "{{$expo->expo_close_date->format('Y-m-d')}}",
          "date" : "{{\Carbon\Carbon::now()}}"
        }
        myexpoDB.get('{{$expo->expo_code}}').then(function (doc) {
          myexpoDB.remove(doc)
          myexpoDB.put(expodoc);
        }).catch(function (err) {
          myexpoDB.put(expodoc)
        });
        myexpoDB.allDocs({
                include_docs: true,
                attachments: true
                }).then(function (result) {
                  if( result.total_rows > 30){
                    sorted = rowSort( result.rows)
                    var popdata = sorted[ sorted.length - 1 ];
                    myexpoDB.remove(popdata.id, popdata.value.rev , function (err){
                      console.log (err)
                    })
                  }
                }).catch(function (err) {
                  console.log(err);
                });	
		  //Panzoom(document.getElementById("panzoom"), {});
		  	var photo=[];
		  	$$("#panzoom").find("img").each( function() {
				photo.push($$(this).attr('src')) 
			});
		   self.data.myPhotoBrowser = app.photoBrowser.create({photos:photo, theme:'dark'});
      },
    }
  }
</script>
