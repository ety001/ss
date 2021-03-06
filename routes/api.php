<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegin;

use App\Libs\Cli;
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

Route::get('test', function(Request $request) {
    //Log::info('test_api');
    //$cli = new Cli();
    //return $cli->test_check();
    //return get_weidian_order_info('775013371427196');
});

Route::get('user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('regin', 'Api\UserController@Regin')->name('regin');

Route::post('login', 'Api\UserController@Login')->name('login');

Route::group(['middleware' => ['auth.api']], function()
{
    Route::post('auth', 'Api\UserController@Auth')->name('auth');
    Route::post('user', 'Api\UserController@Dashboard')->name('user_dashboard');
    Route::post('service/status/{sid?}', 'Api\ServiceController@status')->name('service_status');
    Route::post('service/buy/{sid}', 'Api\ServiceController@buy')->name('service_buy');
});
