<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/21
 * Time: 10:19
 */

namespace App\Models\UserModel;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class UserModel extends Authenticatable
{
    use  HasRoles,Notifiable;

    protected $table='users';
    protected $guard_name = 'super_admin';

}