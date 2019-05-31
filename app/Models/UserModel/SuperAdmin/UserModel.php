<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/21
 * Time: 10:19
 */

namespace App\Models\UserModel\SuperAdmin;

use App\Models\UserModel\BaseUserModel;


class UserModel extends BaseUserModel
{
   // use  HasRoles,Notifiable;

    public $table='users';
    public $guard_name = 'super_admin';

}