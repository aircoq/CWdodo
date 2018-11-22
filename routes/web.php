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

    Route::match(['get', 'post'],'login','IndexController@login')->name('admin.login');//后台登陆
    Route::get('logout','IndexController@logout');//后台登出
    Route::match(['get', 'post'],'err404','IndexController@err404')->name('admin.404');//404
    # 后台防翻墙
    Route::middleware(['CheckAdminAuth'])->group(function () {//带‘/’的只能ajax访问
//   Route::group(['middleware' => 'web'],function (){//重置，无验证项
        # 后台首页
        Route::any('index', 'IndexController@index');
        Route::any('dashboard', 'IndexController@dashboard');
        # 管理员模块
        Route::resource('admin','AdminController');
        Route::post('/admin/restore','AdminController@re_store')->name('admin.restore');//恢复管理员
        Route::match(['get', 'post'],'avatar_upload','AdminController@avatar_upload')->name('admin.upload');//上传头像
        Route::resource('auth','AuthController');
        Route::post('/auth/restore','AuthController@re_store')->name('auth.restore');//恢复权限
        Route::resource('role','RoleController');
        Route::post('/role/restore','RoleController@re_store')->name('role.restore');//恢复角色
        # 用户模块
        Route::resource('user','UserController');
        Route::post('/user/restore','UserController@re_store')->name('user.restore');//恢复用户
        # 门店管理模块
        Route::resource('inn','InnForPetController');
        Route::post('/inn/restore','InnForPetController@re_store')->name('inn.restore');//恢复门店
        # 商品模块
        Route::resource('goods_type','GoodsTypeController');//商品类型
        Route::post('goods_type/restore','GoodsTypeController@re_store')->name('goods_type.restore');
        Route::resource('goods_attr','GoodsAttrController');//商品属性
        Route::post('goods_attr/restore','GoodsAttrController@re_store')->name('goods_attr.restore');
        Route::resource('goods_category','GoodsCategoryController');//商品分类
        Route::resource('goods_brand','GoodsBrandController');//商品品牌
        Route::resource('goods','GoodsController');//商品管理
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