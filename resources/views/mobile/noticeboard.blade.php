<template>
  <div class="page">
    <div class="navbar">
      <div class="navbar-bg"></div>
      <div class="navbar-inner sliding">
        <div class="left">
          <a href="#" class="link back">
            <i class="icon icon-back"></i>
            <span class="if-not-md">Back</span>
          </a>
        </div>
        <div class="title">공지사항</div>
      </div>
    </div>
@verbatim
    <div data-infinite-distance="50" class="page-content infinite-scroll-content" @infinite="loadMore">
      <div class="list simple-list">
        <ul>
          {{#each items}}
			<li key="{{id}}" >
				<a href="/m/notice/{{id}}">
					{{#js_if " this.noti=='Y' " }}[공지] {{/js_if}}
					{{#js_if " this.noti=='N' " }}{{id}}. {{/js_if}}
					{{title}}
				</a>
			</li>
          {{/each}}
        </ul>
      </div>
      {{#if hasMoreItems}}
      <div class="preloader infinite-scroll-preloader"></div>
      {{/if}}
    </div>
@endverbatim
  </div>
</template>
<script>
  return {
    data: function () {
      return {
        allowInfinite: true,
        hasMoreItems: true,
        lastItem: 0,
        items: [],
      }
    },
    methods: {
      loadMore: function () {
        var self = this;
        var $ = self.$$;
        if (!self.allowInfinite) return;
        self.allowInfinite = false;
		  
		axios({
			method: 'get',
			url: '/mobileapi/posts/list',
			params: {
				last_idx : self.lastItem ,
			}
		}).then(function (response) {
			var res = response.data;
			var lastitem = self.lastItem ;
			if(res.noti.length > 0 ||  res.data.length > 0){
				if ( res.noti.length > 0){
					for(var i=0; i < res.noti.length; i++){
						lastitem = res.noti[i].id;
						self.items.push( res.noti[i] )
					}
				}
				if ( res.data.length > 0){
					for(var i=0; i < res.data.length; i++){
						lastitem = res.data[i].id;
						self.items.push( res.data[i] )
					}
				}        
				self.$setState({
					lastItem: lastitem,
					items: self.items,
				  })
        if( res.data.length <20) {
          self.hasMoreItems = false;
        }
				else self.allowInfinite = true;
			}
			else {
				self.$setState({
					hasMoreItems : false
				});
			}
		}).catch(error => {
			toastmessage('잠시후에 이용해주세요')
		});
      }
    },
	on: {
		 pageInit: function () {
			 var self = this;
			 self.loadMore();
		 }
	}
	  
  }
</script>
