<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//路由前缀/api/
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->get('test', 'App\Http\Controllers\Api\UserController@test');
    $api->get('dog', 'App\Http\Controllers\Api\IndexController@Dog');
    $api->get('cat', 'App\Http\Controllers\Api\UserController@Cat');
});