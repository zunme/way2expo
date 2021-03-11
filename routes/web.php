<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\Front\HomeController@index')->name('home');

/* Login */
Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');

/* Start Desktop */
Route::prefix('/join')->name('join.')->group(function () {
    Route::get('/', 'App\Http\Controllers\Front\UserController@showRegisterForm')->name('index');
    Route::post('/', 'App\Http\Controllers\Front\UserController@showRegisterForm');
    Route::get('identity', 'App\Http\Controllers\Front\UserController@registerIdentity')->name('identity');
    Route::get('form', 'App\Http\Controllers\Front\UserController@registerForm')->name('form');
    Route::get('done', 'App\Http\Controllers\Front\UserController@registerComplete')->name('done');

    Route::name('post.')->group(function () {
        Route::post('check', 'App\Http\Controllers\Front\UserController@check')->name('check');
        Route::post('agree', 'App\Http\Controllers\Front\UserController@postRegisterAgree')->name('agree');
        Route::post('identity', 'App\Http\Controllers\Front\UserController@postRegisterIdentity')->name('identity');
//        Route::post('form', 'App\Http\Controllers\Front\UserController@postRegister')->name('form');
        Route::post('register', 'App\Http\Controllers\Front\UserController@register')->name('register');
    });
});

Route::get('find', 'App\Http\Controllers\Front\UserController@showFindForm');

Route::get('search', 'App\Http\Controllers\Front\SearchController@index');
Route::get('search/{keyword}', 'App\Http\Controllers\Front\SearchController@result');

/* Start Confirm-password */
Route::get('confirm-password', 'App\Http\Controllers\Front\MyController@show')
    ->middleware(['auth'])
    ->name('password.confirm');
Route::post('confirm-password', 'App\Http\Controllers\Front\MyController@store');
/* End Confirm-password */

/* Start My */
Route::middleware('auth:web')
    ->prefix('my')
    ->name('my.')
    ->group(function () {
        Route::get('/favorites', 'App\Http\Controllers\Front\MyController@showFavorites');
        Route::post('/favorites/expo', 'App\Http\Controllers\Front\ExpoController@favoritetoggle');
        Route::post('/favorites/booth', 'App\Http\Controllers\Front\BoothController@favorite');
        Route::post('/favorites/product', 'App\Http\Controllers\Front\ProductController@favorite');
        Route::get('/dibs', 'App\Http\Controllers\Front\MyController@dibs');
        Route::get('/latest', 'App\Http\Controllers\Front\MyController@latest');
        Route::get('/noticount', 'App\Http\Controllers\Front\MyController@noticount');
        Route::post('/notiupdate', 'App\Http\Controllers\Front\MyController@notiupdate');
        Route::get('/notifications', 'App\Http\Controllers\Front\MyController@showNotifications');
        Route::post('/notification-list', 'App\Http\Controllers\Front\MyController@getNotificationList');

        Route::get('/', 'App\Http\Controllers\Front\MyController@showMyInfoForm');
        Route::get('info', 'App\Http\Controllers\Front\MyController@showMyInfoForm')->name('info');
        Route::post('info/edit', 'App\Http\Controllers\Front\MyController@edit')->name('info.edit');
        Route::post('info/changePassword', 'App\Http\Controllers\Front\UserController@changePassword');
        Route::post('info/connectKakao', 'App\Http\Controllers\Front\MyController@connectKakao');
        Route::post('info/disconnectKakao', 'App\Http\Controllers\Front\MyController@disconnectKakao');

        Route::get('card', 'App\Http\Controllers\Front\MyController@showMyCardForm');
        Route::post('card/save', 'App\Http\Controllers\Front\MyController@myCardSave');
        Route::post('card/exchange', 'App\Http\Controllers\Front\MyController@myCardExchange');
        Route::get('card/exchange/{booth_id}', 'App\Http\Controllers\Front\MyController@showCardExchange')->where(['booth_id'=>'[0-9]*']);;

        Route::get('meeting/send', 'App\Http\Controllers\Front\MyController@showSendMeetingList');
        Route::post('meeting/send/list', 'App\Http\Controllers\Front\MyController@getSendMeetingList');
        Route::post('meeting/send/confirm', 'App\Http\Controllers\Front\MyController@confirmMeeting');

        Route::get('meeting/receive', 'App\Http\Controllers\Front\MyController@showManageMeeting');
        Route::get('meeting/receive/{id}', 'App\Http\Controllers\Front\MyController@showManageMeeting')->where(['id' => '[0-9]*']);
        Route::post('meeting/receive/list', 'App\Http\Controllers\Front\MyController@getReserveMeetingList');
        Route::post('meeting/confirm', 'App\Http\Controllers\Front\MyController@confirmMeeting');
        /* End Request */

        /* Start Booth */
        Route::get('booth', 'App\Http\Controllers\Front\BoothController@myBooths')->name('booth');
        Route::get('booth/detail/{booth_id}', 'App\Http\Controllers\Front\MyController@showDetailBooth')->where(['booth_id' => '[0-9]*']);
        Route::get('booth/live/{booth_id}', 'App\Http\Controllers\Front\MyController@showLiveBooth')->where(['booth_id' => '[0-9]*']);
        Route::post('booth/live/{booth_id}', 'App\Http\Controllers\Front\MyController@postShowLiveBooth');
        Route::post('booth/save', 'App\Http\Controllers\Front\BoothController@save')->name('booth.save');
        Route::post('booth/delimage', 'App\Http\Controllers\Front\BoothController@deleteDetailBoothImage');
        Route::post('booth/attachsort', 'App\Http\Controllers\Front\BoothController@changeSortDetailBoothImage');
        /* End Booth */

        /* Start Product */
        Route::get('booth/product/{booth_id}', 'App\Http\Controllers\Front\MyController@showManageProduct')->where(['booth_id' => '[0-9]*']);
        Route::post('booth/product/list', 'App\Http\Controllers\Front\ProductController@getMyBoothProducts');
        Route::post('booth/product/detail', 'App\Http\Controllers\Front\ProductController@getMyBoothProductDetail');
        Route::post('booth/product/save', 'App\Http\Controllers\Front\ProductController@save');
        Route::post('booth/product/copy', 'App\Http\Controllers\Front\ProductController@copy');
        Route::post('booth/product/display', 'App\Http\Controllers\Front\ProductController@setdisplay');
        Route::post('booth/product/removedetail', 'App\Http\Controllers\Front\ProductController@delDetailImage');
        Route::post('booth/product/removeimage', 'App\Http\Controllers\Front\ProductController@delPreviewImage');
        Route::post('booth/product/attachsort', 'App\Http\Controllers\Front\ProductController@changeSort');
        /* End Product */

        Route::get('exchange/send', 'App\Http\Controllers\Front\MyController@showContactList');
        Route::post('exchange/send/list', 'App\Http\Controllers\Front\MyController@getExchangeList');
        Route::get('exchange/receive', 'App\Http\Controllers\Front\MyController@showManageExchange');
        Route::post('exchange/receive/list', 'App\Http\Controllers\Front\MyController@getExchangeReceiveList');
        Route::post('exchange/send/list', 'App\Http\Controllers\Front\MyController@getExchangeSendList');
        Route::post('exchange/view', 'App\Http\Controllers\Front\MyController@getExchangeDetail');
        Route::post('exchange/remove', 'App\Http\Controllers\Front\MyController@removeExchange');

        /* End Manage */
    });
/* End my */

/* Start EntryForm */
Route::middleware('auth:web')->prefix('/entry')->name('entry.')->group(function () {
    Route::get('/', 'App\Http\Controllers\Front\EntryFormController@showForm');
    Route::post('save', 'App\Http\Controllers\Front\EntryFormController@create');

    Route::name('post.')->group(function () {
    });
});
/* end EntryForm */

/* Start Download */
Route::get('download', 'App\Http\Controllers\Front\DownloadController@download')->name('download');
/* End Download */

/* Start */
Route::post('banners', 'App\Http\Controllers\Front\HomeController@getBanners');
Route::post('products', 'App\Http\Controllers\Front\ProductController@getProducts');
Route::post('product/detail', 'App\Http\Controllers\Front\ProductController@detail');
/* End */

Route::get('notice', 'App\Http\Controllers\Front\HomeController@index');
Route::get('notice/list', 'App\Http\Controllers\Front\HomeController@postlist');
Route::get('notice/{id}', 'App\Http\Controllers\Front\HomeController@postview')->where(['id' => '[0-9]*']);
Route::get('notice/filedown', 'App\Http\Controllers\Front\HomeController@filedn');

Route::get('contact', 'App\Http\Controllers\Front\ContactController@index');
Route::post('contact/save', 'App\Http\Controllers\Front\ContactController@save');
Route::view('terms-use', 'desktop.terms_use');
Route::view('terms-privacy', 'desktop.terms_privacy');
Route::view('terms-email', 'desktop.terms_email');
Route::view('service', 'desktop.service');
/* Desktop End */

/* Start Expo */

Route::post('/refresh', 'App\Http\Controllers\Front\ExpoController@refresh');
Route::group(['prefix' => '/expo'], function () {

    Route::get('/', 'App\Http\Controllers\Front\ExpoController@index')->name('expo');
    Route::get( '{expo_code}','App\Http\Controllers\Front\ExpoController@index');
    /* start mobile */
    Route::get( '{expo_code2}/booth','App\Http\Controllers\Front\ExpoController@index');
    Route::get( '{expo_code2}/booth/{booth_id2}','App\Http\Controllers\Front\ExpoController@index');
    /* end mobile */
    Route::get( '{expo_code}/{booth_id}','App\Http\Controllers\Front\ExpoController@index');
    Route::get('{expo_code}/{booth_id}/reserve/{date}/{time}', 'App\Http\Controllers\Front\ExpoController@index');
});

Route::get('/expo-page', 'App\Http\Controllers\Front\ExpoController@index')->name('expopage');
Route::get('/expo-meta/{expo_code}', 'App\Http\Controllers\Front\ExpoController@expodetail')->where(['expo_code' => '[a-zA-Z0-9_-]*']);

Route::get('/expo-meta/{expo_code}/{booth_id}', 'App\Http\Controllers\Front\ExpoController@booth')->where(['expo_code' => '[a-zA-Z0-9_-]*', 'booth_id' => '[0-9]*']);

/* End Expo*/

/* start Meeting */
Route::get('/reserve/{expo_code}/{booth_id}/{date}/{time}', 'App\Http\Controllers\Front\MeetingController@reserveform')
    ->where(['expo_code' => '[a-zA-Z0-9_-]*', 'booth_id' => '[0-9]*', 'date' => '[0-9]{4}-[0-9]{2}-[0-9]{2}', 'time' => '[0-9]{2}']);
Route::post('/reserve', 'App\Http\Controllers\Front\MeetingController@reserve');

Route::get('/reserve-timetable', 'App\Http\Controllers\Front\MeetingController@timetable');
Route::get('/meeting/{meeting_id}','App\Http\Controllers\Front\MeetingController@meeting' );
/*end Meeting*/

/* start booth*/
Route::get('/booth/favorite', 'App\Http\Controllers\Front\BoothController@index')->name('booth.favorite');
Route::post('/booth/favorite', 'App\Http\Controllers\Front\BoothController@favorite');
/* endbooth */

/* start Live */
Route::get('/live/view/{booth_id}', 'App\Http\Controllers\Front\LiveController@view');
Route::post('/live/view/{booth_id}/banned-list', 'App\Http\Controllers\Front\LiveController@getBannedUsers');
Route::post('/live/channels/{channel_id}', 'App\Http\Controllers\Front\LiveController@getChannelListOnAPI');
Route::post('/live/getVisitors', 'App\Http\Controllers\Front\LiveController@getVisitors');

Route::middleware(['auth'])->group(function(){
    Route::post('/live/create', 'App\Http\Controllers\Front\LiveController@create');
    Route::post('/live/close', 'App\Http\Controllers\Front\LiveController@close');
    Route::post('/live/force-close', 'App\Http\Controllers\Front\LiveController@closeOnAPI');
    Route::post('/live/commands', 'App\Http\Controllers\Front\LiveController@commands');
    Route::post('/live/thumb', 'App\Http\Controllers\Front\LiveController@thumb');
});

Route::get('/remotemonster-webhook', 'App\Http\Controllers\Front\LiveController@webhook');
Route::post('/remotemonster-webhook', 'App\Http\Controllers\Front\LiveController@recordDone');
/* end Live */


/* start company */

/* end company */

/* mobile용*/
  Route::get('/siteinfo-m', 'App\Http\Controllers\Front\MobileController@siteinfo');
  Route::get('/notice-m', 'App\Http\Controllers\Front\HomeController@notice');
  Route::get('/siteinfo', 'App\Http\Controllers\Front\HomeController@index' );
  Route::get('/notice', 'App\Http\Controllers\Front\HomeController@index' );

  Route::get('/m-meeting-receivelist', 'App\Http\Controllers\Front\MeetingController@receivejson');
  Route::get('/m-meeting-sendlist', 'App\Http\Controllers\Front\MeetingController@sendjson');
  Route::get('/m-meeting-confirmForm/{meeting_id}','App\Http\Controllers\Front\MeetingController@meetingConfirmForm')->where(['meeting_id' => '[0-9]*']);
  Route::get('/noticount', 'App\Http\Controllers\Front\MobileController@noticount');
  Route::get('/m-notilist', 'App\Http\Controllers\Front\MobileController@notilist');
  Route::get('/m-menu', 'App\Http\Controllers\Front\MobileMyController@menu');

  Route::get('/m-company-file', 'App\Http\Controllers\Front\MobileMyController@companyfiledn');
  Route::get('/noti', 'App\Http\Controllers\Front\MobileController@notitest');

  /*
  Route::post('/m-cardexchange', 'App\Http\Controllers\Front\MobileMyController@cardExchangeSave');
  Route::post('/m-user-cardsave', 'App\Http\Controllers\Front\MobileMyController@cardsave');
  */
  /* mobile web api */
    Route::group(['prefix'=>'mobileapi', 'as'=>'mobileapi.'], function() {
		Route::get('search', 'App\Http\Controllers\Front\MobileController@searchResult');
		Route::get('search/{searchstr}', 'App\Http\Controllers\Front\MobileController@searchResult');
		
		Route::get('searchrank', 'App\Http\Controllers\Front\MobileController@searchWordTop');
		Route::get('searchbooth', 'App\Http\Controllers\Front\MobileController@searchBooth');
		Route::get('searchexpo', 'App\Http\Controllers\Front\MobileController@searchExpo');
		Route::get('searchprd', 'App\Http\Controllers\Front\MobileController@searchPrd');
		
			
        Route::get('livecheck/{booth_id}', 'App\Http\Controllers\Front\MobileLiveController@livecheck');
        Route::any('remon', 'App\Http\Controllers\Front\MobileLiveController@remon');
        Route::match(['get', 'post'],'thumb', 'App\Http\Controllers\Front\MobileLiveController@thumb');
		Route::get('boothinfo/{booth_id}', 'App\Http\Controllers\Front\MobileLiveController@simpleBoothInfo');
  		Route::get('/posts/list', 'App\Http\Controllers\Front\HomeController@postlist');

        Route::group(['middleware' => ['auth:sanctum']] , function() {
            Route::post('/myinfo/edit', 'App\Http\Controllers\Front\MobileMyController@edituserinfo');
			Route::post('/myinfo/additional', 'App\Http\Controllers\Front\MobileMyController@additionaluserinfo');
            Route::post('/meeting_confirm','App\Http\Controllers\Front\MeetingController@meetingConfirm');
            Route::post('/booth/save', 'App\Http\Controllers\Front\BoothController@save');
            Route::post('/my/cardimgsave', 'App\Http\Controllers\Front\MobileMyController@cardsave');
            Route::post('/my/card/save', 'App\Http\Controllers\Front\MobileMyController@myCardSave');
            Route::post('/card/exchange', 'App\Http\Controllers\Front\MobileMyController@cardExchangeSave');

			Route::get('/mycard/list/send', 'App\Http\Controllers\Front\MobileMyController@cardSendList');
			Route::get('/mycard/list/receive', 'App\Http\Controllers\Front\MobileMyController@cardReceiveList');
			Route::get('/mycard/list/send', 'App\Http\Controllers\Front\MobileMyController@cardSendList');
			Route::post('/mycard/remove', 'App\Http\Controllers\Front\MobileMyController@cardremove');

            Route::post('/meeting/reserve', 'App\Http\Controllers\Front\MeetingController@reserve');
            Route::post('/company/edit', 'App\Http\Controllers\Front\CompanyController@edit');

            Route::post('/favorite/expo', 'App\Http\Controllers\Front\ExpoController@favoritetoggle');
            Route::post('/favorite/booth/', 'App\Http\Controllers\Front\BoothController@favorite');
            Route::post('/favorite/prd/', 'App\Http\Controllers\Front\MobileProductController@favoritetoggle');
			Route::get('/favorite/myprd/', 'App\Http\Controllers\Front\MobileProductController@favorite');
			Route::get('/favorite/myprd/item/{id}', 'App\Http\Controllers\Front\MobileProductController@favoriteItem');

			Route::post('/productmanage', 'App\Http\Controllers\Front\MobileProductController@productmanage');
			Route::get('/myprdlist', 'App\Http\Controllers\Front\MobileProductController@myPrdList');
			Route::post('/myprdlist/copy', 'App\Http\Controllers\Front\MobileProductController@copy');

			Route::post('checkpwd', 'App\Http\Controllers\Front\MobileMyController@checkpwd');

			Route::post('disconnect/kakao', 'App\Http\Controllers\Auth\MobileSocialController@disconnectKakao');

        });
		Route::get('/boothlist/{expo_id}', 'App\Http\Controllers\Front\ExpoController@boothlist');
		Route::get('/prdlist/{expo_id}', 'App\Http\Controllers\Front\MobileProductController@prdlist');
		Route::get('/prdlist/{expo_id}/{booth_id}', 'App\Http\Controllers\Front\MobileProductController@prdlist');

    });

  Route::group(['prefix'=>'mobile', 'as'=>'mobile.'], function() {
    Route::get('search', 'App\Http\Controllers\Front\MobileController@search');
	Route::get('snslogin', 'App\Http\Controllers\Front\MobileController@snslogin');

	Route::get('/posts/filedown', 'App\Http\Controllers\Front\HomeController@filedn');
	Route::get('/notice/{noticeid}', 'App\Http\Controllers\Front\HomeController@postview');
	Route::get('marketing', 'App\Http\Controllers\Front\MobileController@viewmarketing');


	Route::get('register', 'App\Http\Controllers\Front\MobileController@register');
	Route::get('register/step3', 'App\Http\Controllers\Front\MobileController@registerStep3');
	Route::post('registerprc', 'App\Http\Controllers\Front\MobileController@registerPrc');
    
  Route::post('nice', 'App\Http\Controllers\Front\MobileController@nice');
    
  Route::match(['post','get'], 'cert', 'App\Http\Controllers\Front\MobileController@certPrc');
  Route::match(['post','get'], 'cert/error', 'App\Http\Controllers\Front\MobileController@certErrprPrc');
    
  Route::get('finduser', 'App\Http\Controllers\Front\MobileController@finduser');
  
  Route::get('finduser/id', 'App\Http\Controllers\Front\MobileController@findid');
  Route::get('finduser/pwd', 'App\Http\Controllers\Front\MobileController@findpwd');
    
  Route::match(['post','get'], 'finduser/idprc', 'App\Http\Controllers\Front\MobileController@findidprc');
  Route::match(['post','get'], 'finduser/pwdprc', 'App\Http\Controllers\Front\MobileController@findpwdprd');
  
  Route::post('finduser/changepwdprc', 'App\Http\Controllers\Front\MobileController@changepwdprc');
  

  Route::match(['post','get'],'finduser/idprc/error', 'App\Http\Controllers\Front\MobileController@findidprcError');
  Route::match(['post','get'],'finduser/pwdprc/error', 'App\Http\Controllers\Front\MobileController@findidprcError');    
    
	Route::get('liveview/{id}', 'App\Http\Controllers\Front\MobileLiveController@viewlive');
	Route::get('product/{id}', 'App\Http\Controllers\Front\MobileProductController@prdinfo');



	Route::group(['middleware' => ['mobileauth']], function() {
		Route::get('reserve/{expo_code}/{booth_id}/{date}/{time}', 'App\Http\Controllers\Front\MeetingController@reserveform')
			->where(['expo_code'=>'[a-zA-Z0-9_-]*', 'booth_id'=>'[0-9]*', 'date' => '[0-9]{4}-[0-9]{2}-[0-9]{2}','time' => '[0-9]{2}']);

		Route::get('meeting-send', 'App\Http\Controllers\Front\MeetingController@sendlist');
		Route::get('meeting-receive', 'App\Http\Controllers\Front\MeetingController@receivelist');

		Route::get('my-info', 'App\Http\Controllers\Front\MobileMyController@myinfo');
		Route::get('mycard-info', 'App\Http\Controllers\Front\MobileMyController@mycardinfo');

		Route::get('my-expo', 'App\Http\Controllers\Front\MobileMyController@myexpo');
		Route::get('booth-create/{expo_code}', 'App\Http\Controllers\Front\MobileController@boothCreate')
				->where(['expo_code'=>'[a-zA-Z0-9_-]*']);
		Route::get('booth-create/{expo_code}/{booth_id}', 'App\Http\Controllers\Front\MobileController@boothCreate')
				->where(['expo_code'=>'[a-zA-Z0-9_-]*', 'booth_id'=>'[0-9]*']);
		Route::get('card/exchange/{company_id}', 'App\Http\Controllers\Front\MobileMyController@cardExchange')->where(['company_id'=>'[0-9]*']);;
		Route::get('history/booth', 'App\Http\Controllers\Front\MobileMyController@historyBooth');
		Route::get('history/expo', 'App\Http\Controllers\Front\MobileMyController@historyExpo');
		Route::get('favoritelist', 'App\Http\Controllers\Front\MobileMyController@favoritelist');
		Route::get('favoritelist/expo', 'App\Http\Controllers\Front\MobileMyController@favoritelistExpo');
		Route::get('favoritelist/booth', 'App\Http\Controllers\Front\MobileMyController@favoritelistBooth');
		Route::get('favoriteproductlist', 'App\Http\Controllers\Front\MobileMyController@favoriteproductlist');
		Route::get('favoritproduct', 'App\Http\Controllers\Front\MobileMyController@favoritproduct');

		Route::get('mycompany', 'App\Http\Controllers\Front\MobileMyController@mycompany');
		Route::get('myccardexchange', 'App\Http\Controllers\Front\MobileMyController@cardexchangelist');
		Route::get('card/view/{card_id}', 'App\Http\Controllers\Front\MobileMyController@cardview');

		Route::get('live/{id}', 'App\Http\Controllers\Front\MobileLiveController@startlive');

		Route::post('livecmd/cmd', 'App\Http\Controllers\Front\MobileLiveController@cmd');
		Route::get('livecmd/usercheck', 'App\Http\Controllers\Front\MobileLiveController@usercheck');
		Route::post('livecmd/start', 'App\Http\Controllers\Front\MobileLiveController@startcheck');
		Route::post('livecmd/close', 'App\Http\Controllers\Front\MobileLiveController@closecheck');
		Route::post('livecmd/like', 'App\Http\Controllers\Front\MobileLiveController@addLike');

    Route::get('change/hp', 'App\Http\Controllers\Front\MobileController@changehp');
    Route::match(['post','get'], 'change/hpprc', 'App\Http\Controllers\Front\MobileController@changehpprc');
    Route::match(['post','get'],'change/hppr/error', 'App\Http\Controllers\Front\MobileController@changehperror');
    
	});
	Route::get('link/{id}', 'App\Http\Controllers\Front\MobileProductController@prdlink');
	/*social*/
	Route::get('social/{provider}', [
		'as' => 'social.login',
		'uses' => 'App\Http\Controllers\Auth\MobileSocialController@execute',
	]);

  }); /* end mobile */

Route::group(['prefix'=>'m'], function() {
    Route::fallback('App\Http\Controllers\Front\HomeController@index');
 });
/* mobile */

/* kakao unlink */
Route::get('/social/kakao/unlink', 'App\Http\Controllers\Front\MyController@disconnectKakao');

/***
 * ADMIN
 * stisla : /admin_assets/stisla/pages/index.html
 ***/
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('login', ['as' => 'login', 'uses' => 'App\Http\Controllers\Auth\AdminLoginController@showLoginForm']);
    Route::post('login', 'App\Http\Controllers\Auth\AdminLoginController@login');
    Route::group(['middleware' => ['auth:admin'], 'namespace' => 'App\Http\Controllers\Admin' ], function() {
        Route::get('/', ['as' => 'home', 'uses' => 'AdminController@home']);


    /* Start Booth */
    Route::get('/booth', ['as' => 'booth', 'uses' => 'BoothController@index']);
    Route::get('/booth-list', 'BoothController@list');
    Route::post('/booth-save', 'BoothController@save');
    Route::post('/booth-deldetail', 'BoothController@deleteDetailImage');
    /* End Booth */

        /* Start Company */
        Route::get('/company', ['as' => 'company', 'uses' => 'CompanyController@index']);
        Route::get('/company-list', ['as' => 'company', 'uses' => 'CompanyController@list']);
        Route::post('/company-save', ['as' => 'company', 'uses' => 'CompanyController@save']);
        Route::get('/company-searchuser', 'CompanyController@userlist');
        Route::post('/company-changemaster', 'CompanyController@changemaster');
        Route::post('/company-addpserson', 'CompanyController@addpserson');
        Route::post('/company-delpserson', 'CompanyController@delpserson');
        Route::post('/company-delfile', 'CompanyController@delfile');

        /* End Company */

        /* Start Expo */
        Route::get('/expo-list', ['as' => 'expo', 'uses' => 'ExpoController@list_k']);
        /* End Expo */

        Route::get('/user', ['as' => 'user', 'uses' => 'UserController@index']);
        Route::post('/user', 'UserController@usercreate');
        Route::get('/userlist', 'UserController@userlist');
        Route::get('/userlogin', 'UserController@userlogin');

        Route::get('/expo', ['as' => 'expo', 'uses' => 'ExpoController@expo']);
        Route::post('/expo', 'ExpoController@expocreate');
        Route::get('/expolist', 'ExpoController@expolist');
        Route::post('/expo/del', 'ExpoController@expodelete');
        Route::post('/expo/delattach', 'ExpoController@deleteAttach');
        Route::post('/expo/attachsort', 'ExpoController@attachsort');

        Route::get('/entry', 'EntryFormController@index');
        Route::get('/entrylist', 'EntryFormController@list');

        Route::get('/category', 'CategoryController@showManageCategory');
        Route::post('/category-add', 'CategoryController@addCategory');
        Route::post('/category-remove', 'CategoryController@removeCategory');

        Route::get('/banner', ['as' => 'banner', 'uses' => 'AdminController@banner']);
        Route::get('/bannerlist', 'AdminController@bannerlist');
        Route::post('/banner', 'AdminController@bannercreate');
        Route::post('/banner/del', 'AdminController@bannerdelete');
        Route::post('/banner/update', 'AdminController@bannerupdate');

        Route::get('/meeting', 'AdminController@meeting');
        Route::get('/meetinglist', 'AdminController@meetinglist');
		Route::get('/vod', 'AdminController@vod');
		Route::post('/vod', 'AdminController@vodform');
		Route::get('/vod/info', 'AdminController@vodinfo');
		Route::post('/vod/sort', 'AdminController@vodsort');

		Route::get('/config', 'AdminController@siteconfig');
		Route::post('/config', 'AdminController@siteconfigUpdate');

		Route::get('/product', 'ProductController@index');
		Route::get('/product/list', 'ProductController@prdlist');
		Route::get('/product/info', 'ProductController@prdinfo');
		Route::post('/product/update', 'ProductController@prdupdate');
		Route::post('/product/changeblock', 'ProductController@changeblock');


        Route::get('/contact', 'ContactController@index');
        Route::get('/contactlist', 'ContactController@list');

		Route::get('/posts', 'PostsController@index');
		Route::get('/posts/list', 'PostsController@postslist');
		Route::get('/posts/info', 'PostsController@postsinfo');
		Route::get('/posts/filedown', 'PostsController@filedn');
		Route::post('/posts/save', 'PostsController@postupdate');
		Route::post('/posts/removePost', 'PostsController@postremove');
		Route::post('/posts/removeAttach', 'PostsController@removeAttach');
    });
});
