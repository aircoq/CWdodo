<?php

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
/******    证书路由    **************************************************/
Route::any('/','Home\IndexController@index');//设置默认访问控制器方法名
//Route::any('/chk_version','Api\IndexController@chk_version');//获取app版本信息
//Route::get('/reg_protocol','Admin\IndexController@reg_protocol');//注册协议
//Route::get('/privacy','Admin\IndexController@privacy');//隐私协议

/******    后台路由    **************************************************/
Route::group(['namespace' => 'Admin','prefix'=>'admin'],function (){
    # 后台展示模块
    Route::match(['get', 'post'],'login','IndexController@login')->name('admin.login');
    # 后台防翻墙
    Route::middleware(['CheckAdmin','web'])->group(function () {//带‘/’的只能ajax访问
//    Route::middleware(['web'])->group(function () {
        # 后台首页
        Route::any('index', 'IndexController@index');
        Route::any('dashboard', 'IndexController@dashboard');
        # 管理员模块
        Route::resource('admin','AdminController');
        Route::post('admin/ajax_list','AdminController@ajax_list');//管理员数据展示页
        Route::post('admin/re_store','AdminController@re_store');//恢复管理员
        Route::match(['get', 'post'],'avatar_upload','AdminController@avatar_upload');//上传头像
        Route::resource('auth','AuthController');
        Route::resource('role','RoleController');
        Route::get('logout','IndexController@logout');
        # 用户模块
        Route::resource('user','UserController');
    });
});










































/******    前台路由    **************************************************/