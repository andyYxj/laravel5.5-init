<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/27
 * Time: 14:32
 */

namespace App\Models\RoleModel;




use App\Traits\ModelTrait;
use Spatie\Permission\Models\Role;

/**
 * 权限相关的 model不要继承自 BaseModel，直接继承自laravel-permisson 自带的model
 * Class RoleModel
 * @package App\Models\RoleModel
 */
class RoleModel extends Role
{
    use ModelTrait;
    protected $table='roles';
    protected $guard_name = 'superadmin_api';

}