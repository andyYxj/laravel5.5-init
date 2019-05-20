<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/20
 * Time: 13:41
 */

namespace App\Http\Controllers\Api\SuperAdmin;


use App\Http\Controllers\Common\MyController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class TestController extends MyController
{
    public function index(Request $request){

        $a=Request::getRequestUri();//完整路由
        $b=app('router')->getRoutes();//获取所有路由1
        $c=Route::getRoutes();//获取所有路由2

        // 获取当前路由实例
        $route = Route::current();
        // 获取当前路由名称
        $name = Route::currentRouteName();//name函数指定的路由
        // 获取当前路由action属性
        $action = Route::currentRouteAction();
        echo $request->getName();
    }

}