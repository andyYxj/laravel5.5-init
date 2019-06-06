<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/5/24
 * Time: 10:39
 */

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

trait ValidationTrait
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


    //表单验证
    public function validation($request, $rules, $fields)
    {
        try {
            $validator = Validator::make($request->all(), $rules, $this->validatorMessage, $fields);
            if ($validator->fails()) {
                //$data = $validator->errors()->getMessages();
                $errMsg = $validator->errors()->first();
                return $this->response('', $errMsg, 500);
            }
        } catch (\Throwable $t) {
            return $this->response('', '验证异常', 505);
        }

    }

}