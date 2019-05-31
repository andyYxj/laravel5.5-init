<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/28
 * Time: 17:42
 */

namespace App\Services\Common;


use App\Models\RoleModel\RoleModel;
use App\Services\BaseService;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

/**
 * 角色服务层
 * Class RoleService
 * @package App\Services\Common
 */
class RoleService extends BaseService
{
    private $model;

    public function __construct()
    {
        $this->model = new RoleModel();
    }

    /**
     * 创建 角色
     * @param $request
     */
    public function add($request)
    {
        try {
            Role::create(['guard_name' => $request->guardName, 'name' => $request->roleName]);
            return $this->response('', '创建角色成功', 200);
        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '添加失败', 400);
        }
    }

    /**
     * 删除角色本身,支持通过角色id批量删除，入参为json数组
     * @param $request
     */
    public function del($request)
    {
        try {
            $role = Role::destroy(json_decode($request->ids));
            if ($role) {
                return $this->response('', '删除角色成功!', 200);
            }
            return $this->response('', '删除角色失败!', 400);
        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '删除角色异常', 500);
        }
    }

    /**
     * 修改角色名称
     * @param $request
     * @return string
     */
    public function edit($request)
    {
        try {
            $role = Role::where('id', $request->id)->update(['name' => $request->name]);
            if ($role) {
                return $this->response('', '角色修改成功!', 200);
            }
            return $this->response('', '角色修改失败!', 400);
        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '角色修改异常', 500);
        }
    }

    /**
     * 详情
     * @param $request
     */
    public function info($request)
    {
        try {

            if (is_numeric($request->role)) {
                $role = Role::findById($request->role, $request->guardName);
            } else {
                $role = Role::findByName($request->role, $request->guardName);
            }

            return $this->response($role, '查询成功', 200);

        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '查询异常', 500);
        }
    }

    /**
     * 角色列表
     */
    public function list($request)
    {
        try {
            $dbResult = DB::table('roles');
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