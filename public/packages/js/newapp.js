// Dom7
var $ = Dom7;

var history_state = { 'pop' : '' , 'target' : ''};
var history_back = true;

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
        activeStrongButton: 0
      }
    },
    methods: {
      setStrongButton(index) {
		  console.log ( index )
		  console.log (this);
        this.$setState({ activeStrongButton: index })
      }
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
    /*
    pushStateRoot: (function() {
      return location.pathname;
    })(),
    pushStateSeparator: '#!',
    */
		uniqueHistory: true,
		history: true,
	},
  on : {
    /*
	  pageInit: function (page) {
	  },
    pageBeforeRemove: function (event, page) {
    },
    */
	  popupOpen: function (popup) {
          if( typeof popup.route =='undefined'){
            history_state = { 'pop' : 'popup' , 'target' : ''};
            history.pushState( history_state , '', '');
          } else history_back = false;
	  },
	  popupClose: function (popup) {
      	if ( history_back ){
    			console.log ( "on close popup with back")
    			history.back(-1);
    		} else {
    			history_back = true;
    			console.log ( "on close popup only")
    		}
	  },
    dialogOpen: function (dialog) {
      console.log ( "on close dialog ")
           history_state = { 'pop' : 'dialog' , 'target' : ''};
           history.pushState( history_state , '', '');
    },
    dialogClose: function (dialog) {
        if ( history_back ){
          console.log ( "on close dialog with back")
          history.back(-1);
        } else {
          history_back = true;
          console.log ( "on close dialog only")
        }
    },
	  cardOpened : function ( el ){
		console.log ( "card open")
		history_state = { 'pop' : 'on' , 'target' : 'card'};
        history.pushState( history_state , '', '');
	  },
	  cardClosed : function ( el ){
		  console.log ( "card close")
	  },
	  fabOpen : function (el) {
		  console.log ( "fabopen")
		history_state = { 'pop' : 'on' , 'target' : 'fab'};
        history.pushState( history_state , '', '');
	  },
	  fabClose : function (el) {
		  console.log ( "fab close")

	  },
	  sheetOpen : function (el) {
		  console.log ( "sheet open")
		  history_state = { 'pop' : 'on' , 'target' : 'sheet'};
         history.pushState( history_state , '', '');
	  },
	  sheetClose : function (el) {
		  console.log ( "sheet close")
	  },
  }
});

/*swiper.autoplay.start();*/

window.onpopstate = function (event) {
	var temp_state = history_state;
	if (event.state) { history_state = event.state; }
	else {
   		history_state = { 'pop' : '' , 'target' : ''}
	}
	if ( temp_state.pop == 'popup'){
	  history_back = false;
	  console.log ( "close popup")
	  app.popup.close('.modal-in', true);
	}
  history_back = true;

}
/*
  return {
    data() {
      return {
        activeStrongButton: 0
      }
    },
    methods: {
      setStrongButton(index) {
        this.$setState({ activeStrongButton: index })
      }
    }.
  }
  */
