<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/28
 * Time: 17:53
 */

namespace App\Http\Controllers\Api\SuperAdmin\RolePermission;


use App\Http\Controllers\Common\MyController;
use App\Services\Common\RoleService;
use Illuminate\Http\Request;

class UserRoleController extends MyController
{
    private $service;
    private $request;


    public function __construct(Request $request)
    {
        //该字段 做为权限组的标识，按照模块来，基本原则为如果需要，将超管，b端，c端分别做不同的guardName划分，规定为：超管后台的super_admin,b端后台的位b_admin,c端的为c_admin
        //不同的控制器对应不同的guardName，调用的服务层代码一致
        $request->guardName = 'super_admin';
        $this->request      = $request;
        $this->service = new RoleService();
    }

    /**
     * 增加角色
     * @param Request $request
     */
    public function add()
    {
        return $this->service->add($this->request);
    }

    /**
     * 删除角色本身,支持通过角色id批量删除，入参为json数组
     * @return string
     */
    public function del(){
        return $this->service->del($this->request);
    }

    /**
     * 编辑角色
     */
    public function edit(){
        return $this->service->edit($this->request);
    }

    /**
     * 角色详情
     * @return string
     */
    public function info(){
        return $this->service->info($this->request);
    }

    /**
     * 角色列表
     */
    public function list(){
        return $this->service->list($this->request);
    }

}