<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/28
 * Time: 17:43
 */

namespace App\Services\Common\RolePermission;


use App\Models\PermissionModel\PermissionModel;
use App\Services\BaseService;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionService extends BaseService
{
    private $model;

    public function __construct()
    {
        $this->model = new PermissionModel();
    }


    /**
     * 新增独立的权限数据，用于权限数据的初始录入
     * @param $request
     */
    public function add($request)
    {
        try {
            Permission::create(['guard_name' => $request->guardName, 'name' => $request->name]);
            return $this->response('', '权限录入成功', 200);
        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '权限录入异常', 500);
        }
    }

    /**
     * 删除权限
     * @param $request
     */
    public function del($request)
    {
        try {
            $role = Permission::destroy(json_decode($request->ids));
            if ($role) {
                return $this->response('', '删除权限成功!', 200);
            }
            return $this->response('', '删除权限失败!', 400);
        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '删除权限异常', 500);
        }

    }

    /**
     * 编辑权限
     * @param $request
     */
    public function edit($request)
    {
        try {
            $role = Permission::where('id', $request->id)->update(['name' => $request->name]);
            if ($role) {
                return $this->response('', '权限修改成功!', 200);
            }
            return $this->response('', '权限修改失败!', 400);
        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '权限修改异常', 500);
        }

    }

    /**
     * 权限详情
     * @param $request
     */
    public function info($request)
    {
        try {
            if (is_int($request->permission)) {
                $role = Permission::findById($request->permission, $request->guardName);
            } else {
                $role = Permission::findByName($request->permission, $request->guardName);
            }

            return $this->response($role, '查询成功', 200);

        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '查询异常', 500);
        }

    }

    /**
     * 权限列表
     * @param $request
     */
    public function list($request)
    {
        try {
            $dbResult = DB::table('permissions');
            if (!empty($request->name)) {
                $dbResult = $dbResult->where('name', 'like', '%' . $request->name . '%');
            }
            $res = $this->model->buildPaginate($dbResult, $request);

            return $this->response($res, '查询成功');

        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '查询失败', 500);
        }

    }


}