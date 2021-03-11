var routes = [
	
  {
    path: '/',
    url: '/?page=true',
    on : {
      pageInit :function ( event, page ){
        $$(".segmented-strong > button").on( "click", function (e) {
        	var btn  = e.target;
        	$$(btn).parent("p").children('button.button-active').removeClass("button-active");
        	$$(btn).addClass("button-active");
        })
        $$(".segmented-strong > button.button-active").trigger("click");
		if(liveontemplate!=null) fnLiveOnBoothprc(booth_live,booth_live , {})
      },
      pageBeforeRemove: function (event, page) {
          $$(".segmented-strong > button").off( "click")
      },
    }
  },
  {
	path: '/expo',

	async: function (routeTo, routeFrom, resolve, reject) {
		if( !loaded ) resolve({url: '/page404.html'});
		else resolve({url: '/expo-page'});
	},
	on : {
	  pageInit :function ( event, page ){
		$$(".segmented-strong > button").on( "click", function (e) {
			var btn  = e.target;
			$$(btn).parent("p").children('button.button-active').removeClass("button-active");
			$$(btn).addClass("button-active");
		})
		$$(".segmented-strong > button.button-active").trigger("click");
		if(liveontemplate!=null) fnLiveOnBoothprc(booth_live,booth_live , {})		
	  },
	  pageBeforeRemove: function (event, page) {
		  $$(".segmented-strong > button").off( "click")
	  },
	}
  },
  {
	path: '/m/search',
	name:'search',
	componentUrl:'/mobile/search' ,
	options: {
		context: {
		  searchWord: '',
		},
	  },
  },
  {
	path: '/m/search/:searchstr',
	name:'search',
	componentUrl:'/mobile/search?searchstr={{searchstr}}' ,
	options: {
		context: {
		  searchWord: '',
		},
	  },
  },
  {
    path: '/login',
    componentUrl: '/login',
    name: 'login',
  },
  {
    path: '/m/login',
    componentUrl: '/login',
    name: 'login',
  },	
  {
    path: '/m/snslogin',
    componentUrl: '/mobile/snslogin',
    name: 'snslogin',
  },
  {
    path: '/m/register',
    componentUrl: '/mobile/register',
    name: 'registermember',
  },
  {
    path: '/m/register/step3',
    componentUrl: '/mobile/register/step3',
    name: 'registerstep3',
  },
  {
    path: '/m/find',
    componentUrl: '/mobile/finduser',
    name: 'finduser',
  },	  
  {
    path: '/siteinfo',
    url : '/siteinfo-m',
  },
	{
    path: '/m/marketing',
    componentUrl: '/mobile/marketing',
    name: 'agreemarketing',		
	},
  {
    path: '/m/notice',
    componentUrl:'/notice-m'
  },
  {
    path: '/m/notice/:noticeid',
    componentUrl:'/mobile/notice/{{noticeid}}'
  },	
	
  {
    path: '/expo/:expocode',
    componentUrl:'/expo-meta/{{expocode}}'
  },
  {
    path: '/expo/:expocode/booth',
    name:'boothmake',
    componentUrl:'/mobile/booth-create/{{expocode}}'
  },
  {
    path: '/expo/:expocode/booth/:boothid',
    name:'boothupdate',
    componentUrl:'/mobile/booth-create/{{expocode}}/{{boothid}}'
  },
  {
    path: '/expo/:expocode/:boothid',
    name:'boothpage',
    componentUrl:'/expo-meta/{{expocode}}/{{boothid}}'
  },

  {
    path: '/expo/:expocode/:boothid/reserve/:date/:time',
    popup: {
      componentUrl: '/mobile/reserve/{{expocode}}/{{boothid}}/{{date}}/{{time}}',
    },
  },
  {
    path: '/m/card/exchange/:company',
    name:'cardexchange',
    componentUrl:'/mobile/card/exchange/{{company}}'
  },
  {
    path: '/m/card/view/:card_id',
    name:'cardexchangeview',
    componentUrl:'/mobile/card/view/{{card_id}}'
  },	
  {
    path: '/m/meeting/receive',
    name:'meetingreceive',
    componentUrl:'/mobile/meeting-receive'
  },
  {
    path: '/m/meeting/info/:id',
    name: 'meetinginfo',
    componentUrl: '/m-meeting-confirmForm/{{id}}'
  },
  {
    path: '/m/meeting/send',
    name:'meetingsend',
    componentUrl:'/mobile/meeting-send'
  },
  {
    path: '/m/live/:id',
    name: 'live',
    componentUrl: '/mobile/live/{{id}}'
  },
  {
    path: '/m/live/view/:id',
    name: 'live',
    componentUrl: '/mobile/liveview/{{id}}'
  },
  {
    path: '/m/myinfo',
    name:'myinfo',
    componentUrl:'/mobile/my-info'
  },
  {
    path: '/m/mycardinfo',
    name:'mycardinfo',
    componentUrl:'/mobile/mycard-info'
  },	
  {
    path: '/m/myexpo',
    name:'myexpo',
    componentUrl:'/mobile/my-expo'
  },
  {
    path: '/m/history/booth',
    name:'boothhistory',
    componentUrl:'/mobile/history/booth'
  },
  {
    path: '/m/history/expo',
    name:'expohistory',
    componentUrl:'/mobile/history/expo'
  },
  {
    path: '/m/favorite',
    name:'favoritelist',
    componentUrl:'/mobile/favoritelist'
  },
  {
    path: '/m/favorite/product',
    name:'favoriteproductlist',
    componentUrl:'/mobile/favoriteproductlist'
  },	
  {
    path: '/m/company',
    name:'mycompany',
    componentUrl:'/mobile/mycompany'
  },
  {
    path: '/m/cardexchange',
    name: 'cardexchangelist',
    componentUrl: '/mobile/myccardexchange'
  },
  {
    path: '/m/cardexchange/send',
    name: 'cardexchangelist',
    componentUrl: '/mobile/myccardexchange/send'
  },
  {
    path: '/m/cardexchange/receive',
    name: 'cardexchangelist',
    componentUrl: '/mobile/myccardexchange/receive'
  },	
  {
    path: '/m/myproduct',
    name:'myproductall',
    componentUrl:'/mobile/myproduct'
  },

	
  {
    path: '/m/myproduct/:boothid',
    name:'myproduct',
    componentUrl:'/mobile/myproduct/{{boothid}}'
  },
  {
    path: '/m/addprd/:boothid',
    name:'addprd',
    componentUrl:'/mobile/myproduct/add/{{boothid}}'
  },
  {
    path: '/m/editprd/:prdid',
    name:'editprd',
    componentUrl:'/mobile/myproduct/edit/{{prdid}}'
  },	
  {
	path: "/m/product/:prdid",
	name:'prdinfo',
    componentUrl:'/mobile/product/{{prdid}}'
  },
  {
	path: "/m/product/my/:prdid",
	name:'myprdinfo',
    componentUrl:'/mobile/product/my/{{prdid}}'
  },	
  {
    path: '/m/notilist',
    panel: {
      componentUrl: '/m-notilist',
      on : {
        open: function (panel) {
          global_noti_cnt = 0;
          $$(".noti-cnt").each( function () {
            $$(this).text ( '0' );
          })
        },
      }
    }
  },
  {
    path: '/m/menu',
    panel: {
      componentUrl: '/m-menu',
      on : {
        open: function (panel) {
 
        },
      }
    }
  },	
  {
      path: '/left-panel/',
      panel: {
        componentUrl: '/test/panel-component.html',
      }

  },
  {
    path: '/login',
    loginScreen: {
      url: '/test/login-screen.html',

    },
  },

  {
    path: '(.*)',
    url: './pages/404.html',
  },
]

