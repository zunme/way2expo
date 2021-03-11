@verbatim
<template>

	<div class="page page-search" data-name="searchpage">
		<div class="navbar navbar-new">
			<div class="navbar-bg"></div>
			<div class="navbar-inner sliding">
				<div class="left">
					<a href="#" class="link back">
						<i class="icon icon-back"></i>
						<span class="if-not-md">Back</span>
					</a>
				</div>
				<div class="title">
					<input type="search" id="searchstrInsearch" @keyup="searchkeyup" placeholder="검색어를 입력해주세요"
						value="{{searchWord}}">
				</div>
				<div class="right">
					<a href="#" class="link icon-only" @click="search">
						<i class="icon material-icons">search</i>
					</a>
					<a href="/m/menu" class="link icon-only">
						<i class="icon material-icons">menu</i>
					</a>
				</div>
			</div>
		</div>
		
		<div class="toolbar tabbar toolbar-top">
			<div class="toolbar-inner">
				<a href="#tabs-searchres-all" id="btn_search_show_all"
					class="tab-link flex-direction-row tab-link-active">전체 <span class="searchres-all-cnt">{{res_count}}</span></a>
				<a href="#tabs-searchres-expo" class="tab-link flex-direction-row">박람회<span
						class="searchres-expo-cnt">{{expo_count}}</span></a>
				<a href="#tabs-searchres-booth" class="tab-link flex-direction-row">부스<span
						class="searchres-booth-cnt">{{booth_count}}</span></a>
				<a href="#tabs-searchres-prd" class="tab-link flex-direction-row">제품<span
						class="searchres-product-cnt">{{prd_count}}</span></a>
				<span class="tab-link-highlight" style="width: 33.3333%; transform: translate3d(0%, 0px, 0px);"></span>
			</div>
		</div>
		
		
		
		<div class="tabs-swipeable-wrap">
			<div class="tabs">
				
<!-- tab all -->				
<div id="tabs-searchres-all" class="page-content tab tab-active">
	
{{#js_if " this.searchprc_expo && this.searchprc_booth && this.searchprc_prd && this.res_count == 0" }}
	<div class="search-none-result_wrap">
		{{#if searchWord}}
		<div class="search-none-result_inner">
			<div class="search-none-result_title">
				[<span>{{searchWord}}</span>] 관련 검색결과
			</div>
			
			<div class="search-none-result_box">
				<div class="search-none-result_box_inner">
					<div class="search-none-result_box_icon_wrap">
						<i class="material-icons">search_off</i>
					</div>
					<div class="search-none-result_box_icon_title">검색결과가 없습니다.</div>
				</div>
			</div>
		</div>
		{{/if}}
	  
		<div class="search-top-keyword_wrap">
			<div class="search-top-keyword_inner">
				<div class="search-top-keyword_title">
					이번주 고객들이 가장 많이 검색한 단어입니다.	
				</div>
				<div class="search-top-keyword_tag_wrap">
					<ul class="search-top-keyword_tag_inner">
						{{#searwordRank}}
						<li>{{search}}</li>
						{{/searwordRank}}
					</ul>
				</div>
			</div>
		</div>
	</div>
{{/js_if}}
	
{{#js_if " !this.searchprc_expo || !this.searchprc_booth || !this.searchprc_prd || (this.searchprc_expo && this.searchprc_booth && this.searchprc_prd && this.res_count>0)" }}	
	<div class="search-res-total_wrap">
		
		<!-- 전체 엑스포 -->
		<div class="search-res-total_inner">
			<div class="block-title  {{#js_if "this.expo_count>4"}} more_view {{/js_if}} ">박람회
				<span class="searchres-booth-cnt">{{expo_count}}</span>
				<a href="#" class="more_view_link" @click="chagetab('expo')">
					<span>more +</span>
				</a>
			</div>
		{{#if searchprc_expo }}
			{{#if expo_count}}
			<div class="list media-list list-searchres list-searchres-expo_wrap">
				<ul class="search-list-wrap tabs-searchres-exporows">
					{{#expo_slice}}
					@endverbatim
						@include("mobile.inc.searchpartexpo")
					@verbatim
					{{/expo_slice}}
				</ul>
			</div>
			{{else}}
				<div class="search-none-result-part_wrap">
					<div class="search-none-result_box">
						<div class="search-none-result_box_inner">
							<div class="search-none-result_box_icon_wrap">
								<i class="material-icons">search_off</i>
							</div>
							<div class="search-none-result_box_icon_title">검색결과가 없습니다.</div>
						</div>
					</div>
				</div>
			{{/if}}
		{{else}}
			<div class="preloader infinite-scroll-preloader"></div>
		{{/if}}
			
		</div>		
		<!-- /전체 엑스포 -->
		
		
		<!-- 전체 부스 -->
		<div class="search-res-total_inner">
			<div class="block-title  {{#js_if "this.booth_count>4"}} more_view {{/js_if}} ">부스
				<span class="searchres-booth-cnt">{{booth_count}}</span>
				<a href="#" class="more_view_link" @click="chagetab('booth')">
					<span>more +</span>
				</a>
			</div>
		{{#if searchprc_booth }}
			{{#if booth_count}}
			<div class="list media-list list-searchres list-searchres-booth_wrap">
				<ul class="search-list-wrap tabs-searchres-boothrows">
					{{#booth_slice}}
					@endverbatim
						@include("mobile.inc.searchpartbooth")
					@verbatim
					{{/booth_slice}}
				</ul>
			</div>
			{{else}}
				<div class="search-none-result-part_wrap">
					<div class="search-none-result_box">
						<div class="search-none-result_box_inner">
							<div class="search-none-result_box_icon_wrap">
								<i class="material-icons">search_off</i>
							</div>
							<div class="search-none-result_box_icon_title">검색결과가 없습니다.</div>
						</div>
					</div>
				</div>
			{{/if}}
		{{else}}
			<div class="preloader infinite-scroll-preloader"></div>
		{{/if}}
			
		</div>
		<!-- / 전체 부스 -->

		
		<!-- 전체 상품 -->
		<div class="search-res-total_inner">
			<div class="block-title  {{#js_if "this.prd_count>4"}} more_view {{/js_if}} ">제품
				<span class="searchres-booth-cnt">{{prd_count}}</span>
				<a href="#" class="more_view_link" @click="chagetab('prd')">
					<span>more +</span>
				</a>
			</div>
		{{#if searchprc_prd }}
			{{#if prd_count}}
			<div class="list media-list product-list list-searchres list-searchres-prd_wrap">
				<ul class="search-list-wrap tabs-searchres-prdrows">
				{{#prd_slice}}
					@endverbatim
						@include("mobile.inc.searchpartprd")
					@verbatim
					{{/prd_slice}}
				</ul>
			</div>

			{{else}}
				<div class="search-none-result-part_wrap">
					<div class="search-none-result_box">
						<div class="search-none-result_box_inner">
							<div class="search-none-result_box_icon_wrap">
								<i class="material-icons">search_off</i>
							</div>
							<div class="search-none-result_box_icon_title">검색결과가 없습니다.</div>
						</div>
					</div>
				</div>
			{{/if}}
		{{else}}
			<div class="preloader infinite-scroll-preloader"></div>
		{{/if}}
			
		</div>
		<!-- / 전체 상품 -->
		
	</div><!-- / search-res-total_wrap -->
{{/js_if}}			 

</div>
<!-- / tab all -->


<div id="tabs-searchres-expo" class="page-content tab tab_searchres infinite-scroll-content" data-target="expo">
	{{#if searchprc_expo }}
		{{#if expo_count}}
		<div class="list media-list list-searchres list-searchres-expo_wrap">
			<ul class="search-list-wrap tabs-searchres-exporows">
				{{#expo}}
				@endverbatim
					@include("mobile.inc.searchpartexpo")
				@verbatim
				{{/expo}}
			</ul>
		</div>
		{{else}}
			<div class="search-none-result-part_wrap">
				<div class="search-none-result_box">
					<div class="search-none-result_box_inner">
						<div class="search-none-result_box_icon_wrap">
							<i class="material-icons">search_off</i>
						</div>
						<div class="search-none-result_box_icon_title">검색결과가 없습니다.</div>
					</div>
				</div>
			</div>
		{{/if}}
	{{/if}}
	{{#if expo_allowInfinite}}
		<div class="preloader infinite-scroll-preloader"></div>
	{{/if}}
</div> <!-- /tab expo -->

<div id="tabs-searchres-booth" class="page-content tab tab_searchres infinite-scroll-content" data-target="booth">
	{{#if searchprc_booth }}
		{{#if booth_count}}
		<div class="list media-list list-searchres list-searchres-booth_wrap">
			<ul class="search-list-wrap tabs-searchres-boothrows">
				{{#booth}}
				@endverbatim
					@include("mobile.inc.searchpartbooth")
				@verbatim
				{{/booth}}
			</ul>
		</div>
		{{else}}
			<div class="search-none-result-part_wrap">
				<div class="search-none-result_box">
					<div class="search-none-result_box_inner">
						<div class="search-none-result_box_icon_wrap">
							<i class="material-icons">search_off</i>
						</div>
						<div class="search-none-result_box_icon_title">검색결과가 없습니다.</div>
					</div>
				</div>
			</div>
		{{/if}}
	{{/if}}
	{{#if booth_allowInfinite}}
		<div class="preloader infinite-scroll-preloader"></div>
	{{/if}}
</div>


<div id="tabs-searchres-prd" class="page-content tab tab_searchres infinite-scroll-content" data-target="product">

	{{#if searchprc_prd }}
		{{#if prd_count}}
			<div class="list media-list list-searchres list-searchres-prd_wrap">
				<ul class="search-list-wrap tabs-searchres-prdrows">
				{{#prd}}
				@endverbatim
					@include("mobile.inc.searchpartprd")
				@verbatim
				{{/prd}}
				</ul>
			</div>
		{{else}}
			<div class="search-none-result-part_wrap">
				<div class="search-none-result_box">
					<div class="search-none-result_box_inner">
						<div class="search-none-result_box_icon_wrap">
							<i class="material-icons">search_off</i>
						</div>
						<div class="search-none-result_box_icon_title">검색결과가 없습니다.</div>
					</div>
				</div>
			</div>
		{{/if}}
	{{/if}}
	{{#if product_allowInfinite}}
		<div class="preloader infinite-scroll-preloader"></div>
	{{/if}}


</div>

			</div><!-- / tabs -->
		</div><!-- / tabs-swipeable-wrap -->
		
	</div>
</template>
<script>
return {
	data: function () {
		return {
			isFirst : true,
			perpage : 5,
			searchprc_expo : false,
			searchprc_booth : false,
			searchprc_prd : false,
			res_count : 0,
			searwordRank : [],
			expo:null,
			expo_slice:null,
			expo_count: 0,
			booth:null,
			booth_slice:null,
			booth_count: 0,
			prd:null,
			prd_slice:null,
			prd_count: 0,	
			
			booth_pages:[],
			expo_pages:[],
			prd_pages:[],
			
			expo_allowInfinite: true,
			booth_allowInfinite: true,
			product_allowInfinite: true,
		}
	},
	methods: {
    chagetab : function ( tab ){
      $("a[href='#tabs-searchres-" +tab+ "']").trigger('click')
    },
		searchkeyup : function (e) {
			var self = this;
			var str = removeRegExp( $("#searchstrInsearch").val() );
			$("#searchstrInsearch").val( str );

			if(e.code=='Enter') {
				if( str.length < 2 ){
					toastmessage('검색어는 특수문자를 제외한 2자이상 입니다')
					return false;
				}			
				self.search();
			}
		},
		search : function() {
			var self = this;
			
			var str = $("#searchstrInsearch").val();
			$("#searchstring").text(str)
			if ( !self.isFirst && str != '' ) return;
			axios({
				method: 'get',
				url: '/mobileapi/searchrank',
				params : {
					searchstr : str
				}
			}).then(function (response) {
				var res = response.data.data
				if( res.length > 0 ){
					self.$setState({
						searwordRank : res,
					});
				}else {
					
				}
			});
			
			if( str != '' ){
				self.$setState({
					searchprc_expo : false,
					searchprc_booth : false,
					searchprc_prd : false,
					res_count : 0,
					expo:null,
					expo_slice:null,
					expo_count: 0,
					booth:null,
					booth_slice:null,
					booth_count: 0,
					prd:null,
					prd_slice:null,
					prd_count: 0,	

					booth_pages:[],
					expo_pages:[],
					prd_pages:[],

					expo_allowInfinite: true,
					booth_allowInfinite: true,
					product_allowInfinite: true,
				});
				$("#btn_search_show_all").trigger("click")
				self.searchExpo(str);
				self.searchBooth(str);
				self.searchPrd(str);
			}else {
				self.$setState({
					searchprc_expo : true,
					expo_allowInfinite : false,
					searchprc_booth : true,
					booth_allowInfinite : false,
					searchprc_prd : true,
					product_allowInfinite : false,
				});					
			}
		},
		searchBooth : function(str) {
			var self = this;
			axios({
				method: 'get',
				url: '/mobileapi/searchbooth',
				params : {
					searchstr : str
				}
			}).then(function (response) {
				var res = response.data.data
				if( res.length > 0 ){
					const booth_slice = res.slice(0,4);
					const len = res.length;
					let booth_allowInfinite = true;
					let pages = new Array(Math.ceil(len / self.perpage))
					  .fill()
					  .map(_ => res.splice(0, self.perpage))
					if ( pages.length < 2) booth_allowInfinite = false;
					const first = pages.shift();
					self.$setState({
						booth_pages : pages,
						booth : first,
						booth_slice : booth_slice,
						booth_count : len,
						res_count :( self.res_count + len),
						searchprc_booth : true,
						booth_allowInfinite : booth_allowInfinite,
					});
				}else {
					self.$setState({
						searchprc_booth : true,
						booth_allowInfinite : false,
					});					
				}
			});			
		},
		searchExpo : function(str) {
			var self = this;
			axios({
				method: 'get',
				url: '/mobileapi/searchexpo',
				params : {
					searchstr : str
				}
			}).then(function (response) {
				var res = response.data.data
				if( res.length > 0 ){
					const expo_slice = res.slice(0,4);
					const len = res.length;
					let expo_allowInfinite = true;
					let pages = new Array(Math.ceil(len / self.perpage))
					  .fill()
					  .map(_ => res.splice(0, self.perpage))
					if ( pages.length < 2) expo_allowInfinite = false;
					const first = pages.shift();
					self.$setState({
						expo_pages : pages,
						expo : first,
						expo_slice : expo_slice,
						expo_count : len,
						res_count :( self.res_count + len),
						searchprc_expo : true,
						expo_allowInfinite : expo_allowInfinite,
					});
				}else {
					self.$setState({
						searchprc_expo : true,
						expo_allowInfinite : false,
					});					
				}
			});			
		},
		searchPrd : function(str) {
			var self = this;
			axios({
				method: 'get',
				url: '/mobileapi/searchprd',
				params : {
					searchstr : str
				}
			}).then(function (response) {
				var res = response.data.data
				if( res.length > 0 ){
					const prd_slice = res.slice(0,4);
					const len = res.length;
					let product_allowInfinite = true;
					let pages = new Array(Math.ceil(len / self.perpage))
					  .fill()
					  .map(_ => res.splice(0, self.perpage))
					if ( pages.length < 2) product_allowInfinite = false;
					const first = pages.shift();
					self.$setState({
						prd_pages : pages,
						prd : first,
						prd_slice : prd_slice,
						prd_count : len,
						res_count :( self.res_count + len),
						searchprc_prd : true,
						product_allowInfinite : product_allowInfinite,
					});
				}else {
					self.$setState({
						searchprc_prd : true,
						product_allowInfinite : false,
					});					
				}
			});			
		},		
		paging : function( target ){
			var self = this;
			if ( target == 'booth'){
				let first = self.booth_pages.shift();
				let booth_allowInfinite = true;
				if ( self.booth_pages.length < 1) booth_allowInfinite = false;
				self.$setState({
					booth : self.booth.concat(first) ,
					booth_allowInfinite : booth_allowInfinite,
				});
			}else if (target == 'product'){
				let first = self.prd_pages.shift();
				let product_allowInfinite = true;
				if ( self.prd_pages.length < 1) product_allowInfinite = false;
				self.$setState({
					prd : self.prd.concat(first) ,
					product_allowInfinite : product_allowInfinite,
				});
			}
		}
	},
	on: {
		pageBeforeRemove: function () {
			var self = this;
			$('.infinite-scroll-content.tab_searchres').off('infinite');
		},
		pageInit: function () {
			var self = this;
			var today = new Date();
			var app = self.$app;
			self.search();
			//app.infiniteScroll.create(".infinite-scroll-content.tab")
			$('.infinite-scroll-content.tab_searchres').on('infinite', function (e) {
				var target = $(e.target).data('target')
				if( target=="expo"){
					if( !self.expo_allowInfinite) return;
					else self.expo_allowInfinite = false;
				}else if( target=="booth"){
					if( !self.booth_allowInfinite) return;
					else self.booth_allowInfinite = false;
					self.paging( target )
				}else if( target=="product"){
					if( !self.product_allowInfinite) return;
					else self.product_allowInfinite = false;
					self.paging( target )
				}else return false;

			});
			 $$(".searchbar-init").each( function() {
				if ( $$(this).hasClass('searchbar-enabled') ){
					app.searchbar.toggle($$(this).data("bar"))
				}
			 });
		}
	}
}
@endverbatim
