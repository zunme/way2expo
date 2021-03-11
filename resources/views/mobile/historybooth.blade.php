<template>
    <div class="page page-historyexpo" data-name="historybooth">
      <div class="navbar navbar-new">
        <div class="navbar-bg"></div>
        <div class="navbar-inner sliding">
          <div class="left">
            <a href="#" class="link back">
              <i class="icon icon-back"></i>
              <span class="if-not-md">Back</span>
            </a>
          </div>
          <div class="title">내가 본 부스</div>
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
      </div>
      <div class="page-content">
        @verbatim      

        <div class="list no-gap" style="margin: 15px 10px 20px;">
          <ul class="row no-gap" style="padding-left: 8px;border-radius: 5px;">

          {{#each data.boothes}}
            <li class="item-content col-50 history_booth_li">
              <div class="item-inner">
                <div class="card demo-card-header-pic booth-card mb-10" style="margin-left: 0;">
                  <a href="/expo/{{doc.expo_code}}/{{doc._id}}" data-transition="f7-dive"
                    style="height:100%;background-image:url({{doc.img}})"
                    valign="bottom" class="card-header pl-0 pr-0 pb-0">

                  </a>
<div class="booth_fav_wrap">
	<a href="#" class="globalToggleBoothLink history_booth_favorite" onclick="togglebooth(this)" data-id="{{doc._id}}" style="color:red;">
		<i class="material-icons isfavorite
hide 
		">favorite</i>
		<i class="material-icons unfavorite 
">favorite_border</i>
	</a>
</div>					
                  <div class="card-content booth-card-content-padding">
                    <a href="/expo/{{doc.expo_code}}/{{doc._id}}" data-transition="f7-dive" class="">
                      <div class="card-expo-title-small">{{doc.expo_name}}</div>
                      <div class="card-expo-title">{{doc.booth_title}}</div>
                    </a>
                  </div>
                </div>
              </div>
            </li>
          {{/each}} 

          </ul>
        </div>

        @endverbatim
      </div><!-- / page-content -->
  
  
    </div><!-- / page -->
  </template>
  <script>
    return {
      data: function () {
        return myBootmDB.allDocs({
                include_docs: true,
                attachments: true
                }).then(function (result) {
                  return ({data : {'boothes' : rowSort( result.rows)}})
                }).catch(function (err) {
                  return ({data : {'boothes' : []}})
                });

      },
      methods: {
  
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
        },
        pageInit: function () {
          var self = this;
          temptest = self
          var today = new Date();
          var app = self.$app;
			
			axios({
				method: 'get',
				url: '/mobile/favoritelist/booth',
			}).then(function (response) {
				var res = response.data.data;
				$$(res).each ( function (i, item){
					var booth = $$(".history_booth_favorite[data-id='"+item.id+"']")
					$(booth).children('.unfavorite').addClass("hide")
					$(booth).children('.isfavorite').removeClass("hide")
				})
			})
			.catch(function (error) {

			}); 
        },
      }
    }
  </script>
  