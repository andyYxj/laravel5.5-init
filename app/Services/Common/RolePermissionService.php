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

class RolePermissionService extends BaseService
{
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
     * 给一个角色添加权限
     * @return string
     */
    public function addPermissionToRole($request)
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
}