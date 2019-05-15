<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/4/2
 * Time: 11:19
 */

namespace App\Services;


use App\Http\Controllers\Common\Controller;

class BaseService extends Controller
{
    public function response($data,$msg,$code=200){
        return json_encode([
            'msg'=>$msg,
            'code'=>$code,
            'data'=>$data,
        ]);
    }

}