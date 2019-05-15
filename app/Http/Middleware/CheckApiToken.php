<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Common\MyController;
use Closure;

class CheckApiToken extends MyController
{
    //字段对应提示用语
    protected $fields = [
        'apiToken' => 'apiToken',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        /*   $rules = [
               'apiToken' => 'required',
           ];
           $res   = $this->validation($request, $rules, $this->fields);
           if ($res['code']!= 200) {
              return $this->response('',$res['msg'],$res['code']);
           }*/


     /*   $res=(new UserService())->checkUser($request);
            $res=json_decode($res,true);
            if($res['code']!=200){
               return $this->response('',$res['msg'],$res['code']);
            }*/

        return $next($request);
    }
}
