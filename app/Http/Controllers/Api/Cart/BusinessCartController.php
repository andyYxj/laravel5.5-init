<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/4/3
 * Time: 11:52
 */

namespace App\Http\Controllers\Api\Cart;


use App\Http\Controllers\Common\MyController;
use App\Services\Cart\BusinessCartService;
use Illuminate\Http\Request;

/**
 *  商家订货订单-购物车 类
 * Class BusinessCartController
 * @package App\Http\Controllers\Api\Cart
 */
class BusinessCartController extends MyController
{
    private $service;

    public function __construct()
    {
        $this->service = new BusinessCartService();
    }

    //字段对应提示用语
    protected $fields = [
        'id'              => '主键id',
        'num'             => '购物车指定商品购买数量',
        'businessId'      => '商家id',
        'buyerId'         => '购买者id(此处购买者为商家，=businessId)',
        'businessName'    => '商家名字',
        'goodsId'         => '商品id',
        'goodsName'       => '商品名字',
        'purchasePrice'   => '进货价格',
        'sellPrice'       => '售价',
        'goodsUrl'        => '商品url',
        'settlementPrice' => '商品结算价格'
    ];


    /**
     * 增加商品到购物车
     * @param Request $request
     */
    public function add(Request $request)
    {
        $rules = [
            'businessId'      => 'required|integer',
            'buyerId'         => 'required|integer',
            'businessName'    => 'required|string',
            'goodsId'         => 'required|integer',
            'goodsName'       => 'required|string',
            'purchasePrice'   => 'required|numeric',
            'settlementPrice' => 'required|integer',
            'goodsUrl'        => 'required|string',
            'num'             => 'required|integer',
        ];
        $res   = $this->validation($request, $rules, $this->fields);
        if ($res['code'] == 500) {
            return json_encode($res);
        }
        return $this->service->add($request);
    }

    /**
     * 对购物车中单个商品修改提交
     * @param Request $request
     */
    public function edit(Request $request)
    {
        $rules = [
            'id'  => 'required|integer',
            'num' => 'required|integer',
        ];
        $res   = $this->validation($request, $rules, $this->fields);
        if ($res['code'] == 500) {
            return json_encode($res);
        }
        return $this->service->edit($request);
    }

    /**
     * 删除购物车中某个商品
     * @param Request $request
     */
    public function del(Request $request)
    {
        $rules = [
            'id' => 'required|integer',
        ];
        $res   = $this->validation($request, $rules, $this->fields);
        if ($res['code'] == 500) {
            return json_encode($res);
        }

        return $this->service->del($request);
    }

    /**
     * 购物车中商品列表
     * @param Request $request
     */
    public function list(Request $request)
    {
        return $this->service->list($request);
    }

}