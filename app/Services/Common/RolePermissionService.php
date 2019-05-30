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
    protected $userModelName;

    public function __construct($request)
    {
        $this->userModelName = $request->userModelName;
    }

    /**
     * $roles 为一个json数组 [ "学生", "老师"]
     * 关联的依据，需要对应UserModel里面的 $guard_name 变量的值一致，借此来支持多UserModel
     * 给用户关联角色，支持批量增加
     * @param $request
     */
    public function attachRolesToUser($request)
    {
        try {
            $user = UserModel::find($request->uid);//不同的userModel需要使用不同的Model，重写一个方法
            $user->assignRole(json_decode($request->roles));
            return $this->response('', '关联用户成功', 200);
        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '关联角色异常', 500);
        }
    }


    /**
     * role 为角色的名称，不是id
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
     * 给用户同期角色（会删除用户之前所有角色信息）
     * @param $request
     */
    public function syncRolesToUser($request)
    {
        try {
            $user = UserModel::find($request->uid);
            $user->syncRoles(json_decode($request->roles));
            return $this->response('', '同步角色给用户成功', 200);
        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '同步角色给用户异常', 500);
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
     * 判断一个用户是否包含给出的角色中的任何一个
     * @param $request
     */
    public function userHasAnyRole($request)
    {
        try {
            $user = UserModel::find($request->uid);
            $role = $user->hasAnyRole(json_decode($request->roles));
            if ($role) {
                return $this->response('', '至少含有列表中角色的一个', 200);
            }
            return $this->response('', '不含有列表中角色的任何一个', 400);
        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '判断异常', 500);
        }

    }

    /**
     * 判断一个用户是否包含给出的角色中的所有角色
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userHasAllRoles($request)
    {
        try {
            $user = UserModel::find($request->uid);
            $role = $user->hasAllRoles(json_decode($request->roles));
            if ($role) {
                return $this->response('', '用户含有列表中所有角色', 200);
            }
            return $this->response('', '用户不含有列表中所有角色', 400);
        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '判断异常', 500);
        }

    }

    /**
     * 新增一个权限同时赋值给一个角色
     * @return string
     */
    public function attachPermissionToRole($request)
    {
        DB::beginTransaction();
        try {
            $permission = Permission::create(['guard_name' => $request->guardName, 'name' => $request->name]);
            $role       = Role::where('id', '=', $request->roleId)->firstOrFail();
            $permission->assignRole($role);
            DB::commit();
            return $this->response('', '新增权限同时赋值给对应角色成功', 200);
        } catch (\Throwable $t) {
            DB::rollback();//事务回滚
            return $this->response($t->getMessage(), '新增权限同时赋值给对应角色成异常', 500);
        }

    }


    /**
     * 把一个或者多个已经存在的权限赋值给一个角色
     *
     * $request->permissions，可以为 string|array|\Spatie\Permission\Contracts\Permission|\Illuminate\Support\Collection
     * 实际传入参数全部统一为 json数组 ["老师"，"学生"]，哪怕只有一个,统一使用id传入，不用name
     * @param $request
     */
    public function attachPermissionsToRole($request)
    {
        try {
            $role = Role::where('id', '=', $request->roleId)->firstOrFail();
            $role->givePermissionTo(json_decode($request->permissions));
            return $this->response('', '权限赋值给角色成功', 200);
        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '权限赋值给角色异常', 500);
        }
    }

    /**
     * 解绑一个角色上的一个权限，支持传入的值为权限id
     * @param $request
     */
    public function revokePermissionFromRole($request)
    {
        try {
            $role = Role::where('id', '=', $request->roleId)->firstOrFail();
            $role->revokePermissionTo($request->permission);
            return $this->response('', '解绑角色上的权限成功', 200);
        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '解绑角色上的权限异常', 500);
        }

    }

    /**
     * 获取一个用户的所有角色下的所有权限(结果会有分类标识)
     * @param $request
     */
    public function listUserPermissionsViaRoles($request)
    {
        try {
            $user        = UserModel::find($request->uid);
            $permissions = $user->getPermissionsViaRoles();
            return $this->response($permissions, '获取用户角色下的权限成功', 200);
        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '获取用户角色下的权限异常', 500);
        }

    }


    /**
     * 给一个角色赋予(同步)多个权限，会删除原先角色所有的权限，以当前同步的为准
     * $request->permissions，可以为 string|array|\Spatie\Permission\Contracts\Permission|\Illuminate\Support\Collection
     * 如果是int 则采用findById方式，如果是字符串，则是findByName，如果是数组 findByName
     * 权限格式支持的实际方式包括 26或者[26,27],或者'test路由'或者['test路由'，'test路由2']，此处统一采用[26,27]
     * 参考 HasPermission中 getStoredPermission（）
     *
     * @param $request
     * @return string
     */
    public function syncPermissionsToRole($request)
    {
        DB::beginTransaction();
        try {
            $role = Role::where('id', '=', $request->roleId)->firstOrFail();
            $role->syncPermissions(json_decode($request->permissions));
            DB::commit();
            return $this->response('', '同步角色的权限成功', 200);

        } catch (\Throwable $t) {
            DB::rollback();
            return $this->response($t->getMessage(), '批量同步权限给角色异常', 500);
        }
    }


    /**
     * 判断某个角色是否有某个权限
     * @param $request
     */
    public function roleHasPermission($request)
    {
        try {
            $role = Role::where('id', '=', $request->roleId)->firstOrFail();
            $res  = $role->hasPermissionTo($request->permission);
            if ($res) {
                return $this->response('', '角色拥有该权限', 200);
            }
        } catch (\Throwable  $t) {
            return $this->response($t->getMessage(), '判断异常', 500);
        }
    }

}