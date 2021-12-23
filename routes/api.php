<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', 'CustomAuthController@login');
    Route::post('/logout', 'CustomAuthController@logout');
    Route::post('/refresh', 'CustomAuthController@refresh');
    Route::get('/user-profile', 'CustomAuthController@me');
});

Route::post('auth/register', 'CustomAuthController@register');
Route::get('auth/check-number', 'StaffController@checkIfNumberRegistered');

Route::prefix("user")->group(function(){
    Route::get('{id}', 'StaffController@profile');
});

Route::prefix('news')->group(function () {
    Route::get('/get', 'NewsController@get');
});

Route::get('/colek-service', 'ColekController@colek');
Route::get('/auth/colek', 'ColekController@colek');
Route::post('/auth/registerNumber', 'StaffController@registerNumber');

Route::prefix("ktp")->group(function () {
    $cr = "KTPController";
    Route::get('findNikMobile/{nik}', "$cr@findNikMobile");
    Route::post('{nik}/uploadVerification', "$cr@uploadVerification");
});

Route::prefix("pengajuan")->group(function (){
    $cr = "PengajuanSKUController";
    $cr2 = "PengajuanTrackingController";
    Route::any('self-check', "$cr@selfCheck");
    Route::any('history', "$cr2@getHistory");
    Route::any('activeEvent', "$cr@getActiveEvent");
    Route::any('currentUser', "$cr@getCurrentUser");
    Route::post('upload', "$cr@upload");
});

Route::prefix('chat')->group(function () {
    Route::post('/store', 'ChatController@store');
    Route::delete('/{id}/delete', 'RSChatController@delete');
    Route::get('/get', 'RSChatController@getAll');
    Route::get('topic/{id}/get', 'ChatController@getByTopic');
    Route::get('user/{id}/get', 'ChatController@getByUser');
});


Route::group(['middleware' => ['auth:api']], function () {
    Route::prefix('user')->group(function () {
        Route::post('/update-photo', 'StaffController@updateProfilePhoto');
        Route::post('/update-data', 'StaffController@update');
        Route::post('/change-password', 'StaffController@updatePassword');
    });

    Route::prefix('mnotification')->group(function () {
        Route::get('get', 'MNotificationController@getByUser');
        Route::get('user/{id}', 'MNotificationController@getByUser');
    });

    Route::prefix('price')->group(function () {
        Route::get('/', 'PriceController@getAll');
    });

    Route::post('save-user', 'UserController@saveUser');
    Route::put('edit-user', 'UserController@editUser');
});






