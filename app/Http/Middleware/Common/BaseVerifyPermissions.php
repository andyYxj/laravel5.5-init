<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/30
 * Time: 14:42
 */

namespace App\Http\Middleware\Common;

use App\Services\Common\RolePermission\RolePermissionService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Route;
use Closure;

class BaseVerifyPermissions
{
    use ResponseTrait;

    public function handle($request, Closure $next)
    {
        $routeUri            = Route::current()->uri;//完整的路由，包含api+prefix+Route::match第二个参数的uri
        $request->permission = $routeUri;
        $res                 = (new RolePermissionService($request))->userHasPermissionThoughRole($request);

        if ($res->getData()->code != 200) {
            return $this->response('', '您没有该权限', 404);
        }

        return $next($request);
    }

}