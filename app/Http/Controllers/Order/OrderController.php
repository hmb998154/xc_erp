<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Com\Common;
use App\Http\Controllers\Controller;
use App\Model\Erp\Sys;
use App\Model\Order\Order as orderModel;
use App\Model\Product\Product;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Model\Product\ProductBar;
use App\Model\Product\BarCode;

class OrderController extends Controller
{
	/**
	 * 导出商品号段
	 * @return [type] [description]
	 */
	public function downCodeList(Request $request)
	{
		return BarCode::downCodeList($request);
	}

	/**
	 * 号段绑定
	 * @param string $value [description]
	 */
	public function codeBind(Request $request)
	{
		// return ProductBar::codeBind($request);
		return view("Order.codeBind");
	}

	/**
	 * 删除条码编号
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function delCode(Request $request)
	{
		return ProductBar::delCode($request);
	}

	/**
	 * 生成号段
	 * @return [type] [description]
	 */
	public function codeAdd(Request $request)
	{
		return ProductBar::codeAdd($request);
	}

	/**
	 * 号段列表
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function codeList(Request $request)
	{
		$arr =  ProductBar::codeList($request);
		return view("Order.codeList",$arr);
	}

    /**
     * 代办任务
     * @return [type] [description]
     */
    public function todo(Request $request)
    {
        $input = $request->all();
        $data = orderModel::getTodo($input);
        return view('Order.todo', $data);
    }

    /*订单列表*/

    public function orderList(Request $request)
    {
        $input = $request->all();
        $data = orderModel::getOrderList($input);
        $data['order_sn'] = orderModel::createOrderSn();
        $data['flows'] = Sys::getFlows();
        $data['role'] = common::getRoles();
        return view("orderList", $data);
    }

    /*销售订单添加*/

    public function salesOrderAdd()
    {
        $data = [
            'product' => Product::productList(),
        ];
        return view('Order.addOrder', $data);
    }

    /**
     *ajax取数据
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    public function orderAddNext(Request $request)
    {
        $input = $request->all();
        if (!empty($input)) {
            $res = $this->add($input);
            return _success($res);
        }
    }

    /**
     * 下一步
     * @return [type] [description]
     */
    public function orderNext(Request $request)
    {
        $input = $request->all();
        $info = Redis::hget($input['info'], 'order');
        $data = json_decode($info, true);
        $data['_token'] = $input['info'];
        return view('Order.orderNext', $data);
    }

    /**
     * 生成订单
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function orderCreate(Request $request)
    {
        $input = $request->all();
        if (!empty($input)) {
            $info = $input['info'];
            $_token = $input['token'];
            if(Redis::hget($_token, 'order')){
                $data = Redis::hget($_token, 'order');
                $data = json_decode($data, true);
                $data = $data['product'];
                $orderData = [];
                $ids = [];
                DB::beginTransaction();
                try {
                    foreach ($data as $val) {
                        $orderSn = uniqid();
                        foreach ($val['info'] as $val2) {
                            $orderData = [
                                'order_sn' => $orderSn,
                                'staff_id' => _get_staff_id(),
                                'freight_fee' => 0,
                                'supplier_id' => $val2['factory_id'],
                                'supplier' => $val2['factory_name'],
                                'status' => 1,
                                'is_delete' => 'no',
                                'create_time' => getTime(),
                            ];
                            $orderProductData = [
                                'order_sn' => $orderSn,
                                'pro_id' => $val2['pro_id'],
                                'num' => $val2['product_num'],
                                'single_fee' => $val2['product_price'],
                                'remark' => $val2['remark'],
                            ];
                            DB::table('erp_order_product')->insert($orderProductData);
                        }
                        $id = DB::table('erp_order')->insertGetId($orderData);
                        if($id){
                            foreach ($info as $val3) {
                                if($val3['supplier_id'] == $orderData['supplier_id']){
                                    DB::table('erp_order')->where('order_id',$id)->update(['freight_fee'=>$val3['fee']]);
                                }
                            }
                            DB::table('erp_order_product')->where('order_sn',$orderSn)->update(['order_id'=>$id]);
                        }
                    }
                    DB::commit();
                    Redis::hdel($_token,'order');
                    return _success();
                } catch (Exception $e) {
                    DB::rollBack();
                    return _error();
                }
            }
            
        }
    }

    /**
     * [add 订单添加]
     * @param [type] $input [description]
     */
    public function add($input)
    {
        $data = [];
        foreach ($input as $val) {
            $select = [
                'erp_product_info.*',
                'erp_supplier.factory_name'
            ];
            $query = DB::table('erp_product_info')->where('pro_id', $val['pro_id']);
            $query = $query->leftJoin('erp_supplier', 'erp_supplier.supplier_id', '=', 'erp_product_info.factory_id');
            $query = $query->first();
            $query = collect($query)->toArray();
            $query['product_num'] = $val['product_num'];
            $query['product_price'] = $val['product_price'];
            $query['remark'] = $val['remark'];
            $data[] = $query;
        }
        $ids = [];
        foreach ($data as $val) {
            $ids[] = $val['factory_id'];
        }
        $ids = array_unique($ids);
        sort($ids);
        $list = [];
        foreach ($ids as $key => $val) {
            foreach ($data as $val2) {
                if ($val == $val2['factory_id']) {
                    $list[$key]['info'][] = $val2;
                    $list[$key]['factory_name'] = $val2['factory_name'];
                    $list[$key]['fee'] = 0;
                    $list[$key]['factory_id'] = $val2['factory_id'];
                    $list[$key]['pro_id'] = $val2['pro_id'];
                }
            }
        }
        // $lists['ids'] = $ids;
        $datas['product'] = $list;
        $list = [];
        $pInfo = uniqid();
        Redis::hset($pInfo, 'order', json_encode($datas));
        $list['info'] = $pInfo;
        return $list;
    }

    /*销售订单*/

    public function salesList()
    {
        $data = orderModel::getOrderList();
        $data['order_sn'] = orderModel::createOrderSn();
        $data['flows'] = Sys::getFlows();
        return view('salesList', $data);
    }

    /*创建流程*/

    public function createFlowConfig()
    {
        $res = orderModel::createFlowConfig();

    }

    /*发起子订单*/

    public function createChildOrder(Request $request)
    {
        if ($input = $request->all()) {
            if ($id = orderModel::childOrderAdd($input)) {
                return _success($id);
            }
            return _error();
        }
        $data = orderModel::getOrderList();
        return view('createChildOrder', $data);
    }

    /*ajax取子订单商品*/

    public function ajaxOrder(Request $request)
    {
        if ($orderId = $request->input('order_id')) {
            $order = orderModel::getOrderOne($orderId);
            if (!empty($order)) {
                return _success($order);
            }
            return _error();
        }
    }

    /*订单追溯*/

    public function orderTrace(Request $request)
    {
        $input = $request->all();
        if (!empty($input)) {
            if ($data = orderModel::getOrderTrace($input)) {
                return _success($data);
            }
            return _error();
        }
    }

    /*订单异议*/

    public function orderDissent()
    {
        return view('orderDissent');
    }

    /*送货单管理*/

    public function deliveryOrderManage()
    {
        return view('deliveryOrderManage');
    }

    /*订单审核*/

    public function orderVerify()
    {
        return 0;
    }

    /*订单操作执行*/

    public function orderTodo(Request $request)
    {
        $input = $request->all();
        if (!empty($input['id'])) {
            $data = orderModel::getBlade($input);
            $blade = $data['blade'];
            return view("Order.$blade", $data);
        }
    }

    public function orderDone(Request $request)
    {
        print_r($request);
    }

    /*测试*/
    public function test()
    {
        return view('test');
    }

    /*售后*/

    public function orderService()
    {
        return view('orderService');
    }

}
