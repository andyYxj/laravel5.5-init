<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/24
 * Time: 10:09
 */

namespace App\Traits;


/**
 * 全局返回
 * Class Traits
 * @package App\Traits
 */
trait ResponseTrait
{

    /**
     * 全局返回
     * @param $data
     * @param $msg
     * @param int $code
     */
    public function response($data, $msg, $code = 200){
        return response()->json(['msg' => $msg, 'data' => $data, 'code' => $code], 200);
    }


    /**
     * 返回数组
     * @param $data
     * @param $msg
     * @param int $code
     * @return array
     */
    public function responseArray($data, $msg, $code = 200)
    {
        return [
            'msg'    => $msg,
            'code' => $code,
            'data'   => $data,
        ];
    }

}