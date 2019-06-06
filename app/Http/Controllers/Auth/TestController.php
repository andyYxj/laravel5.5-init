<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/21
 * Time: 11:40
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Common\MyController;
use Illuminate\Http\Request;

class TestController extends MyController
{
    public function index(Request $request){
        $a=$request;
        var_dump($request);
    }

}