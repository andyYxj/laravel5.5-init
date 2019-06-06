<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/30
 * Time: 15:57
 */

namespace App\Models\UserModel;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class BaseUserModel extends Model
{
    use  HasRoles;

    public $table='';
    public $guard_name = '';

}