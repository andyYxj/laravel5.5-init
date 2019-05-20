<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/4/3
 * Time: 11:58
 */

namespace App\Services\Cart;


use App\models\CartModel\BusinessCartModel;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

/**
 * 商家购物车 服务层
 * Class BusinessCartService
 * @package App\Services\Cart
 */
class BusinessCartService extends BaseService
{
    protected $model;

    public function __construct()
    {
        $this->model = new BusinessCartModel();
    }

    public function add($request)
    {
        try {
            $cart = BusinessCartModel::where(
                ['goods_id' => $request->goodsId, 'status' => 0, 'deleted_at' => null])
                ->first();

            //存在同样的商品-修改数量
            if (!empty($cart)) {
                $data = [
                    'num'         => $request->num,
                    'total_money' => (int)($request->num) * ($request->purchasePrice),//小计金额
                ];
                $res  = $this->model->where('id', $cart->id)->update($data);
                if (!empty($res)) {
                    return $this->response('', '存在同名商品，商品数量更新成功!');
                }
                return $this->response('', '存在同名商品，商品数量更新失败!');
            }

            //否则，新增商品到购物车
            $this->model->buyer_id         = $request->buyerId;//购买者id
            $this->model->business_id      = $request->businessId; //商户id
            $this->model->business_name    = $request->businessName;
            $this->model->goods_id         = $request->goodsId;
            $this->model->goods_name       = $request->goodsName;
            $this->model->purchase_price   = $request->purchasePrice;//进货价格
            $this->model->sell_price       = $request->sellPrice;//售价
            $this->model->num              = $request->num;
            $this->model->status           = 0;//状态0-刚加入购物车，1-已经被提交为订单
            $this->model->settlement_price = $request->settlementPrice;//结算价格
            $this->model->total_money      = (int)($request->num) * ($request->purchasePrice);
            $this->model->goods_url        = $request->goodsUrl;//商品主图


            $res = $this->model->save();

            if (!empty($res)) {
                return $this->response('', '加入购物车成功');

            } else {
                return $this->response('', '加入购物车失败', 500);
            }

        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '新增(更新)购物车异常', 500);
        }

    }

    /**
     * 修改购物车的一个商品的信息
     * @param $request
     * @return string
     */
    public function edit($request)
    {
        try {
            $cart = BusinessCartModel::where(
                ['id' => $request->id, 'deleted_at' => null, 'status' => 0])
                ->first();

            if (empty($cart)) {
                return $this->response('', '不存在该id的购物车信息', 500);
            }

            $data = [
                'num'         => $request->num,
                'total_money' => (int)($request->num) * ($cart->purchase_price),
            ];

            $res = $this->model->where('id', $request->id)->update($data);
            if (!empty($res)) {
                return $this->response('', '购物车商品修改成功');
            } else {
                return $this->response('', '购物车商品修改失败', 500);
            }

        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '更新购物车异常', 500);
        }
    }

    /**
     * 删除购物车中的商品
     * @param $request
     * @return string
     */
    public function del($request)
    {
        try {
            $cart = BusinessCartModel::where('id', $request->id)->first();
            if (empty($cart)) {
                return $this->response('', '不存在该id的购物车信息', 404);
            }

            $res = $this->model->where('id', $request->id)->delete();

            if ($res) {
                return $this->response('', '购物车商品删除成功');
            }

        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '购物车商品删除异常',500);
        }

    }

    /**
     * 购物车列表
     * @param $request
     * @return string
     */
    public function list($request)
    {
        try {
            $dbResult = DB::table('cart')->where(['deleted_at' => null, 'status' => 0]);
            if (!empty($request->name)) {
                $dbResult = $dbResult->where('name', 'like', '%' . $request->name . '%');
            }

            $res = $this->model->buildPaginate($dbResult, $request);

            return $this->response($res, '查询成功');

        } catch (\Throwable $t) {
            return $this->response($t->getMessage(), '查询失败', 500);
        }
    }

}