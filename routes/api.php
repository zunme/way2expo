<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MobileController;

use App\Models\User;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);

Route::get('banner/list/type/{bannertype}', [MobileController::class, 'bannerListType']);
Route::get('homedata', [MobileController::class, 'homedata']);
Route::get('boothSimpleInfo', [MobileController::class, 'boothSimpleInfo']);
Route::get('expo/info/{expocode}', [MobileController::class, 'expoInfo']);

Route::group(['middleware' => ['auth:sanctum']] , function() {
    Route::get('/me', function(Request $request) {
        return auth()->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::fallback(function(Request $request) {
   	return response()->json([
			'status' => 'Error',
			'message' => 'Unauthorized(2)',
			'data' => ''
		], 401 );
});