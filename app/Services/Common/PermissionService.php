<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/28
 * Time: 17:43
 */

namespace App\Services\Common;


use App\Services\BaseService;
use Spatie\Permission\Models\Permission;

class PermissionService extends BaseService
{

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


}