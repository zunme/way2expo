<template>
  <div class="page page-favoritelist" data-name="favoritelist">
    <div class="navbar navbar-new with-tabbar">
      <div class="navbar-bg"></div>
      <div class="navbar-inner sliding">
        <div class="left">
          <a href="#" class="link back">
            <i class="icon icon-back"></i>
            <span class="if-not-md">Back</span>
          </a>
        </div>
        <div class="title">즐겨찾기</div>
        <div class="right">
          <a href="/m/notilist" class="link icon-only">
            <i class="icon material-icons md-only">notifications
              <span class="badge color-red noti-cnt">0</span>
            </i>
          </a>
          <a href="/m/menu" class="link icon-only menu-icon">
            <i class="icon material-icons">menu</i>
          </a>
        </div>
      </div>

      <div class="toolbar tabbar toolbar-top favorite-topbar" style="    top: calc(var(--f7-navbar-height) + var(--f7-safe-area-top));">
      <div class="toolbar-inner">
        <a href="#tab-favorite-expo" class="tab-link tab-link-active">박람회</a>
        <a href="#tab-favorite-booth" class="tab-link">부스</a>
      <span class="tab-link-highlight" style="width: 33.3333%; transform: translate3d(0%, 0px, 0px);"></span></div>
    </div>

    </div>
<div class="tabs" style="padding-top: 48px;">

      <div id="tab-favorite-expo" class="page-content tab tab-active">

            <div class="row favorite-expo-card-row"  style="" >
				
@verbatim
	{{#if expos.length}}
		{{#each expos}}
	<div class="col-50 favorite-expo-card-row-col elevation-1" data-expoid="{{id}}" >
	  <a href="/expo/{{expo_code}}">
		  <div class="favorite-expo-card-header-img background-pos-top"
			style="background-image: url(/storage/{{expo_image_url}});">

		  </div>
	  </a>
	  <div class="expo_fav_wrap">
		  <a href="#" class="link icon-only icon-only2" 
				 onclick="toggleexpo(this)" data-id="{{id}}" data-delete="off">
					<i class="material-icons isfavorite">star</i>
		  </a>
	  </div>

	  <div class="favorite-expo-card-body">
		<a href="/expo/{{expo_code}}">
		  <div class="bottom-line">
			  <div>{{expo_name}}</div>
			  <div>{{expo_open_date}}~{{expo_close_date}}</div>
		  </div>
		</a>
	  </div>


	</div>			
		{{/each}}
	{{else}}
		<div class="col-100" style="margin-right:8px">
			<div class="favorite-card-none-col">
			일치하는 데이터가 없습니다.
			</div>
		</div>
	{{/if}}
@endverbatim
            </div>
      </div>

	
      <div id="tab-favorite-booth" class="page-content tab">
          <div class="row favorite-booth-card-row"  style="" >
@verbatim
	{{#if booths.length}}
		{{#each booths}}
<div class="col-50 favorite-booth-card-row-col" data-boothid="{{id}}">
	<a href="/expo/{{expo_code}}/{{id}}">
		<div class="favorite-expo-card-header-img background-pos-top"
		style="background-image: url(/storage/{{booth_mobile_image_url}});
		">

		</div>
	</a>
	<a href="#" class="" onclick="togglebooth(this)" data-id="{{id}}" data-delete="off">
		<i class="material-icons isfavorite">favorite</i>
	</a>
	<div class="favorite-expo-card-body">
		<a href="/expo/{{expo_code}}/{{id}}">
			<div class="bottom-line">
				<div>{{booth_title}}</div>
			</div>
		</a>
	</div>
</div>			  
		{{/each}}
	{{else}}
		<div class="col-100" style="margin-right:8px">
			<div class="favorite-card-none-col">
			일치하는 데이터가 없습니다.
			</div>
		</div>  
	{{/if}}

@endverbatim		  
  
            </div>
      </div>

	
    </div>


  </div><!-- / page -->
</template>
<script>
  return {
    data: function () {
      return {
		  booths : [],
		  expos :[]
      }
    },
    methods: {
		loadExpo : function() {
			var self = this;
			axios({
				method: 'get',
				url: '/mobile/favoritelist/expo',
			}).then(function (response) {
				var res = response.data.data;
				self.$setState({
						expos : res
				});
			});			
		},
		loadBooth : function() {
			var self = this;
			axios({
				method: 'get',
				url: '/mobile/favoritelist/booth',
			}).then(function (response) {
				var res = response.data.data;
				self.$setState({
						booths : res
				});
			});			
		},		
		changeExpoFavorite : function ( data ){
			var self = this;
			self.loadExpo();
			return;
			if( !data.isFavorite){
				$$( ".favorite-expo-card-row-col").each( function () {
					if ( $$(this).data("expoid" ) == data.expo_id ) {
						$$(this).remove();
					}
				});
			}
		},
		changeBoothFavorite : function ( data ){
			var self = this;
			self.loadBooth();
			return;
			if( !data.isFavorite){
				$$( ".favorite-booth-card-row-col").each( function () {
					if ( $$(this).data("boothid" ) == data.booth_id ) {
						$$(this).remove();
					}
					
				});
			}
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
		  etcEvents.off('expo_favorite_change')
		  etcEvents.off('booth_favorite_change')
      },
      pageInit: function () {
        var self = this;
        var today = new Date();
        var app = self.$app;
		etcEvents.on('expo_favorite_change', function (data) {
		  self.changeExpoFavorite(data);
		})
		etcEvents.on('booth_favorite_change', function (data) {
		  self.changeBoothFavorite(data);
		})
		self.loadExpo();
		self.loadBooth();
      },
    }
  }
</script>
