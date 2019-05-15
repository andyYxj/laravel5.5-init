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
