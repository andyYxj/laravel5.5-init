<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/30
 * Time: 10:49
 */

namespace App\Http\Middleware\SuperAdmin;

use App\Services\Common\RolePermissionService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Route;
use Closure;

/**
 * 验证权限中间件
 * Class VerifyPermissions
 * @package App\Http\Middleware\Common
 */
class VerifyPermissions
{
    use ResponseTrait;

    public function handle($request, Closure $next)
    {
        $request->guardName  = 'super_admin';
        $routeUri            = Route::current()->uri;//完整的路由，包含api+prefix+Route::match第二个参数的uri
        $request->permission = $routeUri;
        $res                 = (new RolePermissionService($request))->userHasPermissionThoughRole($request);

        if ($res->getData()->code != 200) {
            return $this->response('', '您没有该权限', 404);
        }

        return $next($request);
    }

}