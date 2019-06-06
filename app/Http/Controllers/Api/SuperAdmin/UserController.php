<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/30
 * Time: 11:10
 */

namespace App\Http\Controllers\Api\SuperAdmin;


use App\Http\Controllers\Common\MyController;
use App\Services\SuperAdmin\UserService;
use Illuminate\Http\Request;

/**
 * 超管后台 用户控制器
 * Class UserController
 * @package App\Http\Controllers\Api\SuperAdmin
 */
class UserController extends MyController
{
    protected $service;
    public function __construct()
    {
        $this->service=new UserService();
    }

    /**
     *获取用户信息
     */
    public function info(Request $request){
        return $this->service->info($request);
    }

}