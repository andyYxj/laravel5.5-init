<?php
/**
 * Created by yuxianjun001@icloud.com
 * User: yuxianjun
 * Date: 2018/3/12 0012
 * Time: 下午 5:31
 */

namespace App\Http\Controllers\Common;

use Illuminate\Support\Facades\Validator;


class MyController  extends Controller
{

    protected $validatorMessage = [
        'unique'   => ':attribute 已存在',
        'required' => ':attribute 为必填项',
        'min'      => ':attribute 长度不能小于 :min 个字符',
        'max'      => ':attribute 长度不能大于 :max 个字符',
        'integer'  => ':attribute 的值必须为整数',
        'numeric'  => ':attribute 的值必须为数字',
        'same'     => ':attribute 和 :other 的值必须一致',
        'size'     => ':attribute 的大小必须等于 :size.',
        'between'  => ':attribute 的值必须在 :min 和 :max 之间',
        'in'       => ':attribute 的值必须为 :values 其中之一',
        'after'    => ':attribute 必须大于 :date',
    ];

    /**
     * 统一接口返回格式
     * status！= 200  均作为异常处理
     * @param $code
     * @param $data
     * @param $msg
     * @return string
     */
    public function response($data, $msg, $code = 200)
    {
        return json_encode([
            'msg'    => $msg,
            'code' =>$code,
            'data'   =>$data,
        ]);
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

    //表单验证
    public function validation($request, $rules, $fields)
    {
        try {
            $validator = Validator::make($request->all(), $rules, $this->validatorMessage, $fields);
            if ($validator->fails()) {
                $data = $validator->errors()->getMessages();
                return $this->responseArray($data, '参数验证失败', 500);
                //return $this->responseArray($validator->errors()->toArray(), '参数验证失败', 500);
            }
            return $this->responseArray('', '验证通过', 200);

        } catch (\Throwable $t) {
            return $this->responseArray('', '验证异常', 505);
        }

    }


}