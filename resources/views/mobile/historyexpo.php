<template>
    <div class="page page-historyexpo" data-name="historyexpo">
      <div class="navbar navbar-new">
        <div class="navbar-bg"></div>
        <div class="navbar-inner sliding">
          <div class="left">
            <a href="#" class="link back">
              <i class="icon icon-back"></i>
              <span class="if-not-md">Back</span>
            </a>
          </div>
          <div class="title">내가 본 박람회</div>
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
  

        <div class="list search-list searchbar-found no-gap" style="margin: 15px 10px 20px;">
          <ul class="row no-gap" style="padding-left: 8px;border-radius: 5px;">

          {{#each data.expos}}
            <li class="item-content col-50 history_expo_li">
              <div class="item-inner">
                <div class="card demo-card-header-pic booth-card mb-10" style="margin-left: 0;">
                  <a href="/expo/{{doc._id}}" data-transition="f7-dive"
                    style="height:100%;background-image:url({{doc.img}})"
                    valign="bottom" class="card-header pl-0 pr-0 pb-0">

                  </a>
				<div class="expo_fav_wrap">					
				  <a href="#" class="link icon-only icon-only2 history_expo_favorite globalToggleExpoLink" 
						 onclick="toggleexpo(this)" data-code="{{doc._id}}">
						<i class="material-icons isfavorite hide">star</i>
						<i class="material-icons unfavorite">star_border</i>
				  </a>
				</div>
                  <div class="card-content booth-card-content-padding">
                    <a href="/expo/{{doc._id}}" data-transition="f7-dive" class="">
                      <div class="card-expo-title" style="font-size: 14px;">{{doc.title}}</div>
                      <div class="card-expo-title-small">{{doc.start}}~{{doc.end}}</div>
                    </a>
                  </div>
                </div>
              </div>
            </li>
          {{else }}
          <li>
<div>
  보신 박람회가 없습니다.
</div>
          </li>
          {{/each}} 

          </ul>
        </div>

      </div><!-- / page-content -->
  
  
    </div><!-- / page -->
  </template>
  <script>
    return {
      data: function () {
        return myexpoDB.allDocs({
                include_docs: true,
                attachments: true
                }).then(function (result) {
                  return ({data : {'expos' : rowSort( result.rows) , 'favorite': [] }})
                }).catch(function (err) {
                  return ({data : {'expos' : [], 'favorite': [] } })
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
				url: '/mobile/favoritelist/expo',
			}).then(function (response) {
				var res = response.data.data;
				$$(res).each ( function (i, item){
					var expo = $$(".history_expo_favorite[data-code='"+item.expo_code+"']")
					$(expo).children('.unfavorite').addClass("hide")
					$(expo).children('.isfavorite').removeClass("hide")
					$(expo).data("id", item.id )
				})
			})
			.catch(function (error) {

			}); 
		},
      }
    }
  </script>
  