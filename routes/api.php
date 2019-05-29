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


//商家后台-a demo
Route::group(['prefix' => 'sellerAdmin', 'middleware' => 'checkApiToken'], function () {

    //购物车相关
    Route::match(['get', 'post'], 'business/cart/add', 'Api\Cart\BusinessCartController@add')->name('business/cart/add');// 商家 订货订单 加入购物车
    Route::match(['get', 'post'], 'business/cart/edit', 'Api\Cart\BusinessCartController@edit')->name('business/cart/edit');// 商家 订货订单 编辑购物车
    Route::match(['get', 'post'], 'business/cart/del', 'Api\Cart\BusinessCartController@del')->name('business/cart/del');// 商家 订货订单 加入删除购物车商品
    Route::match(['get', 'post'], 'business/cart/list', 'Api\Cart\BusinessCartController@list')->name('business/cart/list');// 商家 订货订单 购物车列表

});


//超管后台
Route::group(['prefix' => 'superAdmin', 'middleware' => 'checkApiToken'], function () {
    //测试相关
    Route::match(['get', 'post'], 'test/router/index', 'Api\SuperAdmin\TestController@index')->name('test/router/inde');//测试

});


//角色权限测试路由
Route::group(['prefix' => 'role'], function () {
    Route::match(['get', 'post'], 'test/role/createRole', 'Api\SuperAdmin\TestController@createRole')->name('test/router/createRole');//增加角色
    Route::match(['get', 'post'], 'test/role/addPermissions', 'Api\SuperAdmin\TestController@addPermissions')->name('test/router/addPermissions');//增加权限
    Route::match(['get', 'post'], 'test/role/addPermissionToRole', 'Api\SuperAdmin\TestController@addPermissionToRole')->name('test/router/addPermissionToRole');//把权限赋值给角色
    Route::match(['get', 'post'], 'test/role/syncPermissionsToRole', 'Api\SuperAdmin\TestController@syncPermissionsToRole')->name('test/router/syncPermissionsToRole');//同步多个权限到一个角色
    Route::match(['get', 'post'], 'test/role/attachRolesToUser', 'Api\SuperAdmin\TestController@attachRolesToUser')->name('test/router/attachRolesToUser');//给用户附加角色
    Route::match(['get', 'post'], 'test/role/removeRoleFromUser', 'Api\SuperAdmin\TestController@removeRoleFromUser')->name('test/router/removeRoleFromUser');//移除用户的角色
    Route::match(['get', 'post'], 'test/role/userHasRole', 'Api\SuperAdmin\TestController@userHasRole')->name('test/router/userHasRole');//判断一个用户是否有某个角色
    Route::match(['get', 'post'], 'test/role/roleHasPermission', 'Api\SuperAdmin\TestController@roleHasPermission')->name('test/router/roleHasPermission');//判断一个用户是否有某个角色

});


//超管后台 角色权限测试路由
Route::group(['prefix' => 'superRole'], function () {
    Route::match(['get', 'post'], 'super/admin/user/role/add', 'Api\SuperAdmin\UserController@add')->name('super/admin/user/role/add');//增加角色
    Route::match(['get', 'post'], 'super/admin/user/role/info', 'Api\SuperAdmin\UserController@info')->name('super/admin/user/role/info');//角色详情
    Route::match(['get', 'post'], 'super/admin/user/role/del', 'Api\SuperAdmin\UserController@del')->name('super/admin/user/role/del');//删除角色
    Route::match(['get', 'post'], 'super/admin/user/role/edit', 'Api\SuperAdmin\UserController@edit')->name('super/admin/user/role/edit');//编辑角色
    Route::match(['get', 'post'], 'super/admin/user/role/list', 'Api\SuperAdmin\UserController@list')->name('super/admin/user/role/list');//角色列表，包含搜索

});
