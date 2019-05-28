<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/20
 * Time: 13:41
 */

namespace App\Http\Controllers\Api\SuperAdmin;


use App\Http\Controllers\Common\MyController;
use App\Services\Common\RolePermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class TestController extends MyController
{
    public function index(Request $request)
    {

        $a = Request::getRequestUri();//完整路由
        $b = app('router')->getRoutes();//获取所有路由1
        $c = Route::getRoutes();//获取所有路由2

        // 获取当前路由实例
        $route = Route::current();
        // 获取当前路由名称
        $name = Route::currentRouteName();//name函数指定的路由
        // 获取当前路由action属性
        $action = Route::currentRouteAction();
        echo $request->getName();
    }

    //添加角色
    public function addRole(Request $request)
    {
        $rolePer = new RolePermissionService();
        return $rolePer->createRole($request);
    }

    /**
     * 给一个角色添加权限
     * @param Request $request
     * @return string
     */
    public function attachPermissionToRole(Request $request)
    {
        $permission = new RolePermissionService();
        return $permission->addPermissionToRole($request);
    }

    /**
     * 给用户关联角色
     * @param Request $request
     * @return mixed
     */
    public function attachRolesToUser(Request $request)
    {
        $permission = new RolePermissionService();
        return $permission->attachRolesToUser($request);
    }

    /**
     * 移除用户的角色
     * @param Request $request
     * @return string
     */
    public function removeRoleFromUser(Request $request){
        $permission = new RolePermissionService();
        return $permission->removeRoleFromUser($request);
    }

    /**
     * 判断一个用户是否有某个角色
     * @param Request $request
     */
    public function userHasRole(Request $request){
        $permission = new RolePermissionService();
        return $permission->userHasRole($request);
    }

    /**
     * 判断一个角色是否有某个角色
     * @param Request $request
     */
    public function roleHasPermission(Request $request){
        $permission = new RolePermissionService();
        return $permission->roleHasPermission($request);
    }


}