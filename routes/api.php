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
Route::group(['prefix' => 'superAdmin', 'middleware'=>'superAdmin.rolePermission'], function () {
    //测试相关
    Route::match(['get', 'post'], 'test/router/index', 'Api\SuperAdmin\TestController@index')->name('test/router/index');//测试

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


//超管后台 角色权限测试路由(说明：所有权限不得直接赋值给用户，必须赋值给角色，尽管插件支持对用户直接赋值权限)
Route::group(['prefix' => 'superRole'], function () {

    //角色模块
    Route::match(['get', 'post'], 'super/admin/user/role/add', 'Api\SuperAdmin\RolePermission\UserRoleController@add')->name('super/admin/user/role/add');//增加角色
    Route::match(['get', 'post'], 'super/admin/user/role/info', 'Api\SuperAdmin\RolePermission\UserRoleController@info')->name('super/admin/user/role/info');//角色详情
    Route::match(['get', 'post'], 'super/admin/user/role/del', 'Api\SuperAdmin\RolePermission\UserRoleController@del')->name('super/admin/user/role/del');//删除角色
    Route::match(['get', 'post'], 'super/admin/user/role/edit', 'Api\SuperAdmin\RolePermission\UserRoleController@edit')->name('super/admin/user/role/edit');//编辑角色
    Route::match(['get', 'post'], 'super/admin/user/role/list', 'Api\SuperAdmin\RolePermission\UserRoleController@list')->name('super/admin/user/role/list');//角色列表，包含搜索

    //权限模块
    Route::match(['get', 'post'], 'super/admin/user/permission/add', 'Api\SuperAdmin\RolePermission\UserPermissionController@add')->name('super/admin/user/permission/add');//增加角色
    Route::match(['get', 'post'], 'super/admin/user/permission/info', 'Api\SuperAdmin\RolePermission\UserPermissionController@info')->name('super/admin/user/permission/info');//角色详情
    Route::match(['get', 'post'], 'super/admin/user/permission/del', 'Api\SuperAdmin\RolePermission\UserPermissionController@del')->name('super/admin/user/permission/del');//删除角色
    Route::match(['get', 'post'], 'super/admin/user/permission/edit', 'Api\SuperAdmin\RolePermission\UserPermissionController@edit')->name('super/admin/user/permission/edit');//编辑角色
    Route::match(['get', 'post'], 'super/admin/user/permission/list', 'Api\SuperAdmin\RolePermission\UserPermissionController@list')->name('super/admin/user/permission/list');//角色列表，包含搜索

    //用户-角色
    Route::match(['get', 'post'], 'super/admin/user/role/attachRolesToUser', 'Api\SuperAdmin\RolePermission\UserRolePermissionController@attachRolesToUser')->name('super/admin/user/role/attachRolesToUser');//给用户增加角色
    Route::match(['get', 'post'], 'super/admin/user/role/removeRoleFromUser', 'Api\SuperAdmin\RolePermission\UserRolePermissionController@removeRoleFromUser')->name('super/admin/user/role/removeRoleFromUser');//移除用户的角色
    Route::match(['get', 'post'], 'super/admin/user/role/syncRolesToUser', 'Api\SuperAdmin\RolePermission\UserRolePermissionController@syncRolesToUser')->name('super/admin/user/role/syncRolesToUser');//同步角色给用户(相当于先删除，后增加)
    Route::match(['get', 'post'], 'super/admin/user/role/userHasRole', 'Api\SuperAdmin\RolePermission\UserRolePermissionController@userHasRole')->name('super/admin/user/role/userHasRole');//判断用户是否有某一个角色
    Route::match(['get', 'post'], 'super/admin/user/role/userHasAnyRole', 'Api\SuperAdmin\RolePermission\UserRolePermissionController@userHasAnyRole')->name('super/admin/user/role/userHasAnyRole');//判断用户是否有给出的角色中的任何一个
    Route::match(['get', 'post'], 'super/admin/user/role/userHasAllRoles', 'Api\SuperAdmin\RolePermission\UserRolePermissionController@userHasAllRoles')->name('super/admin/user/role/userHasAllRoles');//判断一个用户是否包含给出的角色中的所有角色

    //角色-权限
    Route::match(['get', 'post'], 'super/admin/user/role/attachPermissionToRole', 'Api\SuperAdmin\RolePermission\UserRolePermissionController@attachPermissionToRole')->name('super/admin/user/role/attachPermissionToRole');//新增一个权限同时赋值给一个角色
    Route::match(['get', 'post'], 'super/admin/user/role/attachPermissionsToRole', 'Api\SuperAdmin\RolePermission\UserRolePermissionController@attachPermissionsToRole')->name('super/admin/user/role/attachPermissionsToRole');//把一个或者多个已经存在的权限赋值给一个角色
    Route::match(['get', 'post'], 'super/admin/user/role/revokePermissionFromRole', 'Api\SuperAdmin\RolePermission\UserRolePermissionController@revokePermissionFromRole')->name('super/admin/user/role/revokePermissionFromRole');//解绑一个角色上的一个权限
    Route::match(['get', 'post'], 'super/admin/user/role/syncPermissionsToRole', 'Api\SuperAdmin\RolePermission\UserRolePermissionController@syncPermissionsToRole')->name('super/admin/user/role/syncPermissionsToRole');//给一个角色赋予(同步)多个权限，会删除原先角色所有的权限，以当前同步的为准
    Route::match(['get', 'post'], 'super/admin/user/role/roleHasPermission', 'Api\SuperAdmin\RolePermission\UserRolePermissionController@roleHasPermission')->name('super/admin/user/role/roleHasPermission');//判断某个角色是否有某个权限?


    //用户-角色-权限
    Route::match(['get', 'post'], 'super/admin/user/role/listUserPermissionsViaRoles', 'Api\SuperAdmin\RolePermission\UserRolePermissionController@listUserPermissionsViaRoles')->name('super/admin/user/role/listPermissionsViaRoles');//获取一个用户的所有角色下的所有权限(结果会有分类标识)
    Route::match(['get', 'post'], 'super/admin/user/role/userHasPermissionThoughRole', 'Api\SuperAdmin\RolePermission\UserRolePermissionController@userHasPermissionThoughRole')->name('super/admin/user/role/userHasPermissionThoughRole');//获取一个用户的所有角色下的所有权限(结果会有分类标识)


});
