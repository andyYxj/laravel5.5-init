<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/6/14
 * Time: 15:43
 */

//jwt路由注册
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'App\Http\Controllers\Api\SuperAdmin\User\UserController@login');
    Route::post('logout', 'App\Http\Controllers\Api\SuperAdmin\User\UserController@logout');
    Route::post('refresh', 'App\Http\Controllers\Api\SuperAdmin\User\UserController@refresh');
    Route::post('me', 'App\Http\Controllers\Api\SuperAdmin\User\UserController@me');
});