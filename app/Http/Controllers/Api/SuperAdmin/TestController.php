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
    public $service;
    public function __construct()
    {
        $this->service = new RolePermissionService();
    }

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


    //###########################角色为主的接口  begin #########################
    //创建角色
    public function createRole(Request $request)
    {
        return $this->service->createRole($request);
    }

    /**
     * 删除角色本身
     * @param Request $request
     * @return string
     */
    public function removeRole(Request $request){
         return $this->service->removeRole($request);
    }

    /**
     * 给一个角色添加一个权限
     * @param Request $request
     * @return string
     */
    public function attachPermissionToRole(Request $request)
    {
        return $this->service->attachPermissionToRole($request);
    }

    /**
     * 新增独立的权限数据，用于权限数据的初始录入
     * @param Request $request
     */
    public function addPermissions(Request $request){
        return $this->service->addPermissions($request);
    }

    /**
     * 给一个角色同步多个权限，会删除原先角色所有的权限，以当前同步的为准
     * @param Request $request
     * @return mixed
     */
    public function syncPermissionsToRole(Request $request){
        return $this->service->syncPermissionsToRole($request);
    }

    /**
     * 判断一个角色是否有某个权限
     * @param Request $request
     */
    public function roleHasPermission(Request $request){
        return $this->service->roleHasPermission($request);
    }

    //###########################角色为主的接口  end #########################




   //###########################用户为主的接口  begin ################
    /**
     * 给用户关联角色
     * @param Request $request
     * @return mixed
     */
    public function attachRolesToUser(Request $request)
    {
        return $this->service->attachRolesToUser($request);
    }

    /**
     * 移除用户的角色
     * @param Request $request
     * @return string
     */
    public function removeRoleFromUser(Request $request){
        return $this->service->removeRoleFromUser($request);
    }

    /**
     * 判断一个用户是否有某个角色
     * @param Request $request
     */
    public function userHasRole(Request $request){
        return $this->service->userHasRole($request);
    }

    //######################用户为主的接口 end##########################




}