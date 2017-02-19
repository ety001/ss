<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    Log::info('test_api');
    return 'hello world';
});

Route::get('user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('regin', 'Api\UserController@Regin')->name('regin');
