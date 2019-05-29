<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/27
 * Time: 10:12
 */

namespace App\Services\Common;


use App\Models\UserModel\UserModel;
use App\Services\BaseService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class RolePermissionService extends BaseService
{
    use HasRoles;

    //###########################角色为主的接口  begin #########################
    /**
     * 创建 角色
     * @param $request
     */
    public function createRole($request)
    {
        try {
            Role::create(['guard_name' => $request->guardName, 'name' => $request->roleName]);
            return $this->response('', '创建角色成功', 200);
        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '添加失败', 400);
        }
    }

    /**
     * 删除角色本身
     * @param $request
     */
    public function removeRole($request){
        try{
            $role=Role::
             $this->response('', '删除角色成功!', 200);
        }catch (\Throwable $t){
            return $this->response($t->getMessage(), '删除角色异常', 500);
        }
    }

    /**
     * 给一个角色添加一个权限
     * @return string
     */
    public function attachPermissionToRole($request)
    {
        DB::beginTransaction();
        try {
            $permission = Permission::create(['guard_name' => $request->guardName, 'name' => $request->permissionName]);
            $role       = Role::where('id', '=', $request->roleId)->firstOrFail();
            $permission->assignRole($role);
            DB::commit();
            return $this->response('', '权限赋值成功', 200);
        } catch (\Throwable $t) {
            DB::rollback();//事务回滚
            return $this->response($t->getMessage(), '添加权限异常', 500);
        }

    }

    /**
     * 新增独立的权限数据，用于权限数据的初始录入
     * @param $request
     */
    public function addPermissions($request){
        try{
            $permission=Permission::create(['guard_name' => $request->guardName,'name'=>$request->permissionName]);
            return $this->response('', '权限录入成功', 200);
        }catch (\Throwable $t){
            return $this->response($t->getMessage(), '权限录入异常', 500);
        }
    }

    /**
     * $request->permissions，可以为 string|array|\Spatie\Permission\Contracts\Permission|\Illuminate\Support\Collection
        如果是int 则采用findById方式，如果是字符串，则是findByName，如果是数组 findByName
        权限格式支持的实际方式包括 26或者[26,26],或者'test路由'或者['test路由'，'test路由2']，此处统一采用[26,27]
        参考 HasPermission中 getStoredPermission（）
        给一个角色赋予(同步)多个权限，会删除原先角色所有的权限，以当前同步的为准
     * @param $request
     * @return string
     */
    public function syncPermissionsToRole($request){
        DB::beginTransaction();
        try{
            $role       = Role::where('id', '=', $request->roleId)->firstOrFail();
            $res=$role->syncPermissions(json_decode($request->permissions));
            DB::commit();
            return $this->response('', '同步角色的权限成功', 200);

        }catch (\Throwable $t){
            DB::rollback();
            return $this->response($t->getMessage(), '批量同步权限给角色异常', 500);
        }
    }


    /**
     * @param $request
     */
    public function roleHasPermission($request){
        try{
            $role       = Role::where('id', '=', $request->roleId)->firstOrFail();
            $role->hasPermissionTo($request->permission);
        }catch (\Throwable  $t){
            return $this->response($t->getMessage(), '判断异常', 500);
        }

    }

    //###########################角色为主的接口  end #########################

    //###########################用户为主的接口  begin ################
    /**
     * $roles 为一个json数组 [ "Google", "Runoob", "Taobao" ]
     * 给用户关联角色，支持批量增加
     * @param $request
     */
    public function attachRolesToUser($request)
    {
        try {
            $user = UserModel::find($request->uid);
            $user->assignRole(json_decode($request->roles));
            return $this->response('', '关联用户成功', 200);
        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '关联角色异常', 500);
        }
    }

    /**
     * 移除用户的角色，一个个移除
     * @param $request
     */
    public function removeRoleFromUser($request)
    {
        try {
            $user = UserModel::find($request->uid);
            $user->removeRole($request->role);
            return $this->response('', '移除用户角色成功', 200);

        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '移除用户角色异常', 500);
        }

    }

    /**
     * 判断一个用户是否有指定的角色
     * @param $request
     */
    public function userHasRole($request)
    {
        try {
            $user = UserModel::find($request->uid);
            $res  = $user->hasRole($request->role);
            if ($res) {
                return $this->response('', '用户拥有该角色', 200);
            }
            return $this->response('', '用户没有该角色', 404);

        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '判断异常', 500);
        }
    }

    //###########################用户为主的接口  end ################


}