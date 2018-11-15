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
    Route::middleware(['CheckAdmin'])->group(function () {//带‘/’的只能ajax访问
//   Route::group(['middleware' => 'web'],function (){//重置，无验证项
        # 后台首页
        Route::any('index', 'IndexController@index');
        Route::any('dashboard', 'IndexController@dashboard');
        # 管理员模块
        Route::resource('admin','AdminController');
        Route::post('admin/ajax_list','AdminController@ajax_list');//管理员数据展示页
        Route::post('admin/re_store','AdminController@re_store');//恢复管理员
        Route::match(['get', 'post'],'avatar_upload','AdminController@avatar_upload');//上传头像
        Route::resource('auth','AuthController');
        Route::post('auth/ajax_list','AuthController@ajax_list');//管理权限列表
        Route::post('auth/re_store','AuthController@re_store');//恢复权限
        Route::resource('role','RoleController');
        Route::post('role/ajax_list','RoleController@ajax_list');//角色列表
        Route::post('role/re_store','RoleController@re_store');//恢复角色
        Route::get('logout','IndexController@logout');
        # 用户模块
        Route::resource('user','UserController');
        Route::post('user/ajax_list','UserController@ajax_list');//用户数据展示页
        Route::post('user/re_store','UserController@re_store');//恢复用户
        # 门店管理模块
        Route::resource('inn_for_pet','InnForPetController');
        Route::post('inn_for_pet/ajax_list','InnForPetController@ajax_list');//门店数据展示页
        Route::post('inn_for_pet/re_store','InnForPetController@re_store');//恢复门店
        # 商品模块
        Route::resource('goods_type','GoodsTypeController');
        Route::resource('goods_attr','GoodsAttrController');
        Route::resource('goods_category','GoodsCategoryController');
        Route::resource('goods_brand','GoodsBrandController');
        Route::resource('goods','GoodsController');
    });
});



















/******    前台路由    **************************************************/
Route::group(['namespace' => 'Home','prefix'=>'home'],function (){
    # 登陆
    Route::match(['get', 'post'],'login','IndexController@login')->name('home.login');

    # 前台防翻墙
    Route::middleware(['CheckUser'])->group(function () {//带‘/’的只能ajax访问
        Route::match(['get', 'post'],'avatar_upload','IndexController@avatar_upload');//用户上传头像
    });

});