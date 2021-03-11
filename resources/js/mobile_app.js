// Dom7
var $ = Dom7;
var history_state = { 'pop' : '' , 'target' : ''};
var history_back = true;
var historylog = [];
var openeddialog = null;

// Theme
var theme = 'md';
if (document.location.search.indexOf('theme=') >= 0) {
  theme = document.location.search.split('theme=')[1].split('&')[0];
}

// Init App
var app = new Framework7({
  id: 'io.framework7.testapp',
  root: '#app',
  theme: theme,
  cache: false,
  statusbar: {
	iosOverlaysWebView: true,
	iosBackgroundColor : "#35a8e0",
	androidBackgroundColor:"#35a8e0",
	iosTextColor:"#FFFFFF",
	androidTextColor:"#FFFFFF",
  },

  data() {
    return {
      activeStrongButton: 0,
      pathname : '',
    }
  },
  methods: {
    setStrongButton(index) {
      this.$setState({ activeStrongButton: index })
    },
    openSwipe : function () {
      globalPopMy.open();
    }
  },
  touch: {
    tapHold: true,
    tapHoldDelay: 750,
    disableContextMenu: true,
    tapHoldPreventClicks: false,
  },
  
  routes: routes,
	pushState: true,
	uniqueHistory: true,
  popup: {
    closeOnEscape: true,
  },
  sheet: {
    closeOnEscape: true,
  },
  dialog: {
    closeOnEscape: true,
  },
  popover: {
    closeOnEscape: true,
  },
  actions: {
    closeOnEscape: true,
  },
  vi: {
    placementId: 'pltd4o7ibb9rc653x14',
  },
	view: {
		iosDynamicNavbar: false,
		xhrCache: false,
		cache: false,
		componentCache:false,

		stackPages: false,
		pushState: true,
    pushStateSeparator: '',
		uniqueHistory: true,
		history: true,
	},
  on: {
    pageMounted: function () {
    },
	init: function () {
	},
	pageBeforeRemove : function (event, page){
		if( openeddialog != null ){
			openeddialog.close();
			openeddialog = null;
		}
	},
    pageInit: function (evnet, page) {
		if($(".page.stacked").length > 4) $(".view-main").children(".page.stacked")[0].remove();
      if (this.data.pathname != location.pathname) {
        this.data.pathname = location.pathname;
      }
      if (typeof event == 'undefined') return;
      if (!isLogined) {
        $$(".noti-cnt").each(function () {
          global_noti_cnt = '0';
          $$(this).text('0');
        })
        return;
      }
      this.request({
       url: '/noticount',
       method:'get',
       success: function (xhr){
         $$(".noti-cnt").each(function () {
           global_noti_cnt = xhr;
           $$(this).text ( xhr );
         })
       }
     })
	  },
	  popupOpen: function (popup) {
          if( typeof popup.route =='undefined'){
            history_state = { 'pop' : 'popup' , 'target' : ''};
            history.pushState( history_state , '', '#popup');
			      history_back = true;
          } else history_back = false;
	  },
	  popupClose: function (popup) {
		 if ( openeddialog != null ) openeddialog.close();
      	if ( history_back ){
    			history.back(-1);
    		} else {
    			history_back = true;
    		}
	  },
	  dialogOpen: function (dialog) {
			openeddialog = dialog;
     },
	   dialogClose: function (dialog) {
		   openeddialog = null;
	   },
	  cardOpened : function ( el ){
		history_state = { 'pop' : 'on' , 'target' : 'card'};
        history.pushState( history_state , '', '');
	  },
	  cardClosed : function ( el ){
	  },
	  fabOpen : function (el) {
		history_state = { 'pop' : 'on' , 'target' : 'fab'};
        history.pushState( history_state , '', '');
	  },
	  fabClose : function (el) {
		  if ( history_back ){
				history.back(-1);
		  } else {
			history_back = true;
		  }
	  },
	  sheetOpen : function (el) {
		  
		  history_state = { 'pop' : 'on' , 'target' : 'sheet'};
         history.pushState( history_state , '', '');
	  },
	  sheetClose : function (el) {
      if ( history_back ){
        history.back(-1);
      } else {
        history_back = true;
      }
	  },
    actionsOpen : function (el) {
      history_state = { 'pop' : 'on' , 'target' : 'actions'};
      history.pushState( history_state , '', '');
    },
    actionsClose : function (el) {
      if ( history_back ){
        history.back(-1);
      } else {
        history_back = true;
      }
    },
  }
});

window.onpopstate = function (event) {
	var temp_state = history_state;
	if (event.state) { history_state = event.state; }
	else {
   		history_state = { 'pop' : '' , 'target' : ''}
	}
	if ( temp_state.pop == 'popup'){
	  history_back = false;
	  app.popup.close('.popup.modal-in', true);
	}else if (temp_state.pop == 'on') {
    if( temp_state.target == 'actions') {
      history_back = false;
      app.actions.close(".actions-modal.modal-in")
    }else if( temp_state.target == 'dialog') {
		if( history_back ){
			history_back = false;
		   app.dialog.close(".dialog.modal-in")	
		}else history_back = true;
    }else if( temp_state.target == 'sheet') {
      history_back = false;
      app.sheet.close(".sheet-modal.modal-in")
    }else if( temp_state.target == 'gp') {
		  history_back = false;
		  gp_close();
    }
  }
  else history_back = true;

}
var globalPopMy = app.popup.create({
    el: '.app-swipe-handler',
    swipeToClose: 'to-bottom',
  });
function openSwipe() {
  globalPopMy.open();
}

