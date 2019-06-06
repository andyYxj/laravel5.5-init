<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/30
 * Time: 11:11
 */

namespace App\Services\SuperAdmin;


use App\Models\UserModel\UserModel;
use App\Services\BaseService;

/**
 * 超管后台 用户服务层
 * Class UserService
 * @package App\Services\SuperAdmin
 */
class UserService extends BaseService
{
    public function info($request)
    {
        try {
            $user = UserModel::findOrFail($request->uid);
            return $this->response($user, '获取用户信息成功', 200);
        } catch (\Throwable $t) {
            return $this->response('', '获取用户信息异常', 500);
        }
    }
}