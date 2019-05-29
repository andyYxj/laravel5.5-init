<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/28
 * Time: 17:53
 */

namespace App\Http\Controllers\Api\SuperAdmin;


use App\Http\Controllers\Common\MyController;
use App\Services\Common\RoleService;
use Illuminate\Http\Request;

class UserController extends MyController
{
    private $service;
    private $request;


    public function __construct(Request $request)
    {
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