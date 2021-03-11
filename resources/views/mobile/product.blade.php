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
        <!--div class="title">title</div-->
        <div class="right">
			<a href="#" class="globalTogglePrdLink link icon-only icon-only2" id="expoFavorite" onclick="toggleprd(this)" data-id="{{$prd->id}}">
				@if( $prd->isfavorite == 1 )
				<i class="material-icons isfavorite">favorite</i>
				<i class="material-icons unfavorite hide">favorite_border</i>
				@else
				<i class="material-icons isfavorite hide">favorite</i>
				<i class="material-icons unfavorite">favorite_border</i>
				@endif
			</a>			
          <!--a href="/m/notilist" class="link icon-only">
            <i class="icon material-icons md-only">notifications
              <span class="badge color-red noti-cnt">0</span>
            </i>
          </a-->
				  <a href="/m/search" class="link icon-only icon-only2"><i class="icon material-icons">search</i></a>
          <a href="/m/menu" class="link icon-only menu-icon">
            <i class="icon material-icons">menu</i>
          </a>
        </div>
      </div>
    </div>
	<div class="toolbar toolbar-bottom display-flex product_info_bottom_toolbar">
		<div>
						<a href="#" class="globalTogglePrdLink link icon-only icon-only2" id="expoFavorite" onclick="toggleprd(this)" data-id="{{$prd->id}}">
				@if( $prd->isfavorite == 1 )
				<i class="material-icons isfavorite">favorite</i>
				<i class="material-icons unfavorite hide">favorite_border</i>
				@else
				<i class="material-icons isfavorite hide">favorite</i>
				<i class="material-icons unfavorite">favorite_border</i>
				@endif
			</a>
		</div>
		<div>
			@if ( !empty($prd->prd_url) )
			<div class="bottom_prdinfo_url">
				<a href="{{$prd->prd_url}}" target="_blank" class="bottom_prdinfo_url_inner external">
					구매하기
				</a>	
			</div>
			@else
			<div class="bottom_prdinfo_url_none">
				
			</div>
			@endif
		</div>
	</div>
    <div class="page-content" id="prdinfo_pagecontent">
		<div class="product_info_title_top">
			{{$prd->prd_title}}
		</div>		
	<!-- 배너 -->
		<div class="prdinfo_banner_wrap">
            <div data-pagination='{"el": ".swiper-pagination", "clickable": true}'
                  data-navigation='{"nextEl": ".swiper-button-next","prevEl":".swiper-button-prev"}'
                  data-space-between="0"
                  data-slides-per-view="1"
                  data-loop="false"
                  data-centered-slides="true"
				  data-auto-height="true"
                  class="swiper-container swiper-init  ">

				  <div class="swiper-pagination"></div>
				  <div class="swiper-wrapper">
					  
					<div class="swiper-slide" data-src=".">
						<a style="width:100%">
						  <img src="/storage/{{$prd->prd_img1}}" style="max-width:100%; max-height:300px;">
						</a>
					</div>
					@if( !empty( $prd->prd_img2 )) 
					<div class="swiper-slide" data-src=".">
						<a style="width:100%">
						  <img src="/storage/{{$prd->prd_img2}}" style="max-width:100%; max-height:300px;">
						</a>
					</div>					  
					@endif
					@if( !empty( $prd->prd_img3 )) 
					<div class="swiper-slide" data-src=".">
						<a style="width:100%">
						  <img src="/storage/{{$prd->prd_img3}}" style="max-width:100%; max-height:300px;">
						</a>
					</div>					  
					@endif
					@if( !empty( $prd->prd_img4 )) 
					<div class="swiper-slide" data-src=".">
						<a style="width:100%">
						  <img src="/storage/{{$prd->prd_img4}}" style="max-width:100%; max-height:300px;">
						</a>
					</div>					  
					@endif
				  </div>
			  </div>

		</div>
<!-- 배너 -->
		<div class="product_info_title_center">
			{{$prd->prd_title}}
		</div>
		@if($prd->prd_viewprice =='Y')
		<div class="product_info_price_wrap">
			<div class="product_info_price_1stline">
				<div class="product_info_price_org">
					{{ number_format($prd->prd_org_price)}} 원
				</div>
				<div class="product_info_price_discount">
					{{$prd->prd_price_percent}}%
				</div>
			</div>
			<div class="product_info_price_2ndline">
				{{ number_format($prd->prd_price)}} 원
			</div>
		</div>
		@else
		<div class="product_info_pricehide_wrap">
			<div>
				가격협의
			</div>
		</div>
		@endif
		
		@if ( !empty($prd->prd_url) )
		<div class="prdinfo_url_wrap">
			<div class="prdinfo_url_inner">
				<a href="{{$prd->prd_url}}" target="_blank" class="prdinfo_url_inner external">
					구매하기
				</a>	
			</div>
			<div class="prdinfo_url_msg">
				구매하기 클릭 시 구매가능한 외부로 이동합니다.
			</div>
		</div>
		@endif
		
		<div class="prdinfo_detail_wrap">
			<div class="prdinfo_detail_inner" id="product_info_detail_imgs">
				 <div class="zoom-info-wrap">
					 <div class="zoom-info-inner">
						 <span class="zoom-info">확대해서 보실수 있습니다.</span>
					 </div>
				 </div>
				@forelse ( $images as $image)
					<img src="/storage/{{$image->url}}" class="lazy">
				<!--/pinch-zoom-->
				@empty
					<div class="prdinfo_none_detail_wrap">
						<div class="prdinfo_none_detail_inner">
							 상세정보가 없습니다.
						</div>	
					</div>
				@endforelse
				@if (!empty($images))
				<a href="#" style="    position: fixed;
					bottom: 46px;
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
				@endif
			</div>
		</div>
    </div><!-- / page-content -->


  </div><!-- / page -->
</template>
<script>
  return {
    data: function () {
      return {
		  'data' : {
			  myPhotoBrowser : null,
			  hammertime : null,
			  currentScale :100,
		  }
      }
    },
    methods: {
		photo: function() {
			var self = this;
			  self.data.myPhotoBrowser.open();
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
		if(self.data.myPhotoBrowser != null ) self.data.myPhotoBrowser.destroy();
		  self.data.hammertime.off('pinchin');
		  self.data.hammertime.off('pinchout');
		  self.data.hammertime.destroy();
      },
      pageInit: function () {
        var self = this;
        var today = new Date();
        var app = self.$app;
		
		var photo=[];
		  	$$("#product_info_detail_imgs").find("img").each( function() {
				photo.push($$(this).attr('src')) 
				/*panzoom = Panzoom(this, { contain: 'outside', startScale: 1 })*/
			});
		   self.data.myPhotoBrowser = app.photoBrowser.create({photos:photo, theme:'dark'});
		  
		  var pinch = document.querySelector('#product_info_detail_imgs');
		  
		  self.data.hammertime = new Hammer(pinch);
		  
		  self.data.hammertime.get('pinch').set({ enable: true,direction: Hammer.DIRECTION_ALL });
		  self.data.hammertime.get("pan").set({ enable: false });
		  
		  self.data.hammertime.on("pinchout", function(el) {
			  var pct= self.data.currentScale + 1;
			  if( pct > 200 ) pct = 200
			  self.data.currentScale = pct;
			$("#product_info_detail_imgs > img").css("width", pct + "%" )
		  });
		   self.data.hammertime.on("pinchin", function(el) {
			  var pct= self.data.currentScale - 1;
			  if( pct < 100 ) pct = 100
			  self.data.currentScale = pct;
			$("#product_info_detail_imgs > img").css("width", pct + "%" )
		  });

      },
    }
  }
</script>
