<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/29
 * Time: 14:37
 */

namespace App\Models\PermissionModel;


use App\Traits\ModelTrait;
use Spatie\Permission\Models\Permission;

class PermissionModel extends Permission
{
    use ModelTrait;
    protected $table='permissions';
}