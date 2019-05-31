<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/29
 * Time: 14:53
 */

namespace App\Http\Controllers\Api\SuperAdmin\RolePermission;


use App\Http\Controllers\Common\MyController;
use App\Services\Common\RolePermission\RolePermissionService;
use Illuminate\Http\Request;

class UserRolePermissionController extends MyController
{
    private $service;
    private $request;

    public function __construct(Request $request)
    {
        //guardName 字段 做为权限组的标识，按照模块来，基本原则为如果需要，将超管，b端，c端分别做不同的guardName划分，规定为：超管后台的super_admin,b端后台的位b_admin,c端的为c_admin
        //不同的控制器对应不同的guardName，调用的服务层代码一致
        $request->guardName = 'super_admin';
        $request->node="SuperAdmin";//该node为 Models/UserModel/下的模块名称，其他的模块可能为BAdmin，CAdmin，然后在目录下建立同名的UserModel，只能为UserModel
        $this->request      = $request;
        $this->service      = new RolePermissionService($request);
    }

    //###################用户-角色相关  begin##############

    /**
     * 给用户关联角色
     * @param Request $request
     * @return mixed
     */
    public function attachRolesToUser()
    {
        return $this->service->attachRolesToUser($this->request);
    }

    /**
     * role 为角色的名称，不是id
     * 取消角色跟用户的关联，一个个删除
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeRoleFromUser()
    {
        return $this->service->removeRoleFromUser($this->request);
    }

    /**
     * 给用户同期角色（会删除用户之前所有角色信息）
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncRolesToUser()
    {
        return $this->service->syncRolesToUser($this->request);
    }

    /**判断一个用户是否有指定的角色
     * @return \Illuminate\Http\JsonResponse
     */
    public function userHasRole()
    {
        return $this->service->userHasRole($this->request);
    }

    /**
     * 判断一个用户是否包含给出的角色中的任何一个
     */
    public function userHasAnyRole()
    {
        return $this->service->userHasAnyRole($this->request);
    }

    /**
     * 判断一个用户是否包含给出的角色中的所有角色
     */
    public function userHasAllRoles()
    {
        return $this->service->userHasAllRoles($this->request);
    }
    //###################用户-角色相关  end##############


    //##################角色-权限相关 begin#####################

    /**
     *新增一个权限同时赋值给一个角色
     * @return string
     */
    public function attachPermissionToRole()
    {
        return $this->service->attachPermissionToRole($this->request);
    }

    /**
     *把一个或者多个已经存在的权限赋值给一个角色
     */
    public function attachPermissionsToRole()
    {
        return $this->service->attachPermissionsToRole($this->request);
    }

    /**
     * 解绑一个角色上的一个权限
     * @return mixed
     */
    public function revokePermissionFromRole()
    {
        return $this->service->revokePermissionFromRole($this->request);
    }

    /**给一个角色赋予(同步)多个权限，会删除原先角色所有的权限，以当前同步的为准
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncPermissionsToRole()
    {
        return $this->service->syncPermissionsToRole($this->request);
    }

    /**
     *判断某个角色是否有某个权限
     */
    public function roleHasPermission()
    {
        return $this->service->roleHasPermission($this->request);
    }

    //##################角色-权限相关end#####################

    //##################用户-角色-权限相关 begin###################

    /**
     * 获取一个用户的所有角色下的所有权限(结果会有分类标识)
     */
    public function listUserPermissionsViaRoles()
    {
        return $this->service->listUserPermissionsViaRoles($this->request);
    }

    /**
     * 用户是否含有指定角色下的权限
     * @return \Illuminate\Http\JsonResponse
     */
    public function userHasPermissionThoughRole(){
        return $this->service->userHasPermissionThoughRole($this->request);
    }

    //##################用户-角色-权限相关 end###################


}