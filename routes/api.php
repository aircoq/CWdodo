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
    $api->get('cat', 'App\Http\Controllers\Api\IndexController@Cat');
    $api->get('user/login', 'App\Http\Controllers\Api\UserController@login');
    $api->get('index/my_order', 'App\Http\Controllers\Api\IndexController@MyOrder');//查看我的订单
    $api->get('user/band', 'App\Http\Controllers\Api\UserController@bandPhone');//小程序绑定手机
    $api->post('appointment', 'App\Http\Controllers\Api\IndexController@makeAppointment');//发起寄养
    $api->get('pet/show', 'App\Http\Controllers\Admin\PetController@show');//查看宠物详情
    $api->get('pet/myShow', 'App\Http\Controllers\Api\IndexController@myShow');//查看我的宠物列表
    $api->post('pet/store', 'App\Http\Controllers\Admin\PetController@store');//新增宠物
    $api->put('pet/update', 'App\Http\Controllers\Admin\PetController@wechatUpdate');//编辑宠物信息
    $api->put('pet/updatePetImg', 'App\Http\Controllers\Admin\PetController@updatePetImg');//新增或更新宠物头像
    $api->put('pet/delete', 'App\Http\Controllers\Admin\PetController@wechatDestroy');//删除宠物
    $api->post('uploadImg', 'App\Http\Controllers\Api\IndexController@uploadImg');//上传图片


});