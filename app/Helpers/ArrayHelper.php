<?php
/**
 * 数组 辅助函数，辅助函数使用类的静态方法调用，
 * 减少性能开销
 * Created by yuxianjun001@icloud.com
 * User: yuxianjun
 * Date: 2018/3/13 0013
 * Time: 下午 4:57
 */

namespace App\Helpers;


class ArrayHelper
{
   public static function getLastItemOfArray($array){
       if(!empty($array)){
           return array_slice($array,-1,1);
       }
       return false;
    }

    /**
     * 对象转数组
     * 支持 循环转
     * @param $obj
     * @return array|void
     */
    public static  function ObjectToArray($obj) {
        if(is_object($obj)) {
            $array = (array)$obj;
        } if(is_array($obj)) {
            foreach($obj as $key=>$value) {
                $array[$key] = self::ObjectToArray($value);
            }
        }
        return $array;
    }


    /**
     * 数组转对象
     * @param $arr
     * @return object|void
     */
    public static function arrayToObject($arr) {
        if (gettype($arr) != 'array') {
            return;
        }
        foreach ($arr as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object') {
                $arr[$k] = (object)array_to_object($v);
            }
        }
        return (object)$arr;
    }

}