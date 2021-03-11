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
        <div class="title">찜한 상품</div>
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

	<div data-infinite-distance="50" class="page-content infinite-scroll-content infinite-scroll-bottom favorite_product_content" @infinite="prdlist" >
@verbatim		
<div class="list media-list product-list">
	<ul>
	{{#if favorites.length }}
		{{#favorites}}
<li class="product_zzim_li" data-prd="{{id}}">
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
			<a class="" onclick="toggleprd(this)" data-id="{{id}}" data-remove="Y">
					<i class="material-icons isfavorite">favorite</i>
			</a>
		</div>
	</div>
</li>
		{{/favorites}}
	{{else}}
		{{#js_if " this.status == 'done' && this.favorites.length == 0 "}}
			<li class="nonezzime">
				<div class="expo_booth_ready_wrap">
					<div class="expo_booth_ready_inner">
					일치하는 데이터가 없습니다.
					</div>
				</div>
			</li>
		{{/js_if}}
	{{/if}}
		
	{{#js_if " this.status == 'error' "}}
	<!-- 연동오류발생 -->
		<li class="li_loading_error">데이터 연동중 오류가 발생하였습니다.</li>
	{{/js_if}}
		
	</ul>
	{{#if hasMoreItems}}
	<div class="preloader infinite-scroll-preloader"></div>
	{{/if}}
</div>
@endverbatim			
	</div><!-- / page-content -->

  </div><!-- / page -->
</template>
<script>
  return {
    data: function () {
      return {
		allowInfinite: true,
		hasMoreItems: true,
		lastpage: 1,
		favorites : [],
		status : 'before',
		loading : true,
	  }
    },
    methods: {
		prdlist : function() {
			var self = this;
			var url = "/mobileapi/favorite/myprd"
			if (!self.loading || !self.hasMoreItems) return;

			self.loading = false;

			axios({
				method: 'get',
				url: url,
				params: {
					page : self.lastpage ,
				}
			}).then(function (response) {
				var res = response.data.data
				if( res.total > 0 && res.data.length > 0 ){
					let favorites = self.favorites.concat(res.data);
					let hasMoreItems = true;
					if( res.last_page <= res.current_page){
						hasMoreItems = false;
					}
					self.lastpage = self.lastpage  + 1
					self.$setState({
						status : 'done',
						hasMoreItems: hasMoreItems,
						favorites : favorites
					});
					self.loading = true;
				} else {
					self.$setState({
						status : 'done',
						hasMoreItems: false
					});									
				}
				

			});
			
		},
		changeprdFavorite : function ( data ){
			var self = this;
			if( data.isFavorite ){
				axios({
					method: 'get',
					url: '/mobileapi/favorite/myprd/item/'+data.product_id,
				}).then(function (response) {
					var res = response.data
					if( res.data.length > 0 ){
						let favorites = res.data.concat(self.favorites);
						self.$setState({
							favorites : favorites
						});
					}
					
				});			
			}else {
				let favorites = self.favorites;
				var product_id = Number(data.product_id);
				const idx = favorites.findIndex(function(item) {
					return item.id === product_id }
				   )
				if (idx > -1) {
					favorites.splice(idx, 1)
					self.$setState({
						favorites : favorites
					});
				}
				
			}
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
		  etcEvents.off('product_favorite_change');
      },
      pageInit: function () {
        var self = this;
        var today = new Date();
        var app = self.$app;
		self.prdlist();
		etcEvents.on('product_favorite_change', function (data) {
		  self.changeprdFavorite(data);
		})
      },
    }
  }
</script>
