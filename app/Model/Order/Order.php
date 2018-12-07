<?php

namespace App\Model\Order;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Com\Common;
use App\Model\Erp\Staff;
use DB;

class Order extends Model
{
	protected $table = 'erp_order';
	public $timestamps = false;

	/*销售订单列表*/

	public static function getOrderList($arr=""){

		$select  = ['order_id','order_sn','supplier','product_name','order_mark','status','create_time','order_type','is_delete','order_verify'];
		$where[] = ['is_delete','=','no'];
		if(!empty($arr['order_sn'])){
			$where[]= ['order_sn','=',$arr['order_sn']];
		}
		/*if(!empty($arr['order_plan_sn'])){
			$where[]= ['order_plan_sn','=',$arr['order_plan_sn']];
		}*/
		if(!empty($arr['product_name'])){
			$where[]= ['product_name','like',"%".$arr['product_name']."%"];
		}
		if(!empty($arr['start_time'])){
			$startTime =date('Y-m-d H:i:s',strtotime($arr['start_time']));
			$where[]= ['create_time','>=',$startTime];
		}
		if(!empty($arr['end_time'])){
			$endTime =date('Y-m-d H:i:s',strtotime($arr['end_time']));
			$where[]= ['create_time','<=',$endTime];
		}
		if(!empty($arr['order_type'])){
			$where[]= ['order_type','=',$arr['order_type']];
		}
		if(!empty($arr['status'])){
			$where[]= ['status','=',$arr['status']];
		}
		$query = self::where($where);
		$count = $query->count();
		$pages = $query->paginate(config('common.page'));
		$orders = $query->select($select)->get()->toArray();
		$data = [
			'count' =>$count,
			'pages' =>$pages,
			'orders' =>$orders,
		];
		return $data;
	}

	/*根据id取一条订单数据*/

	public static function getOrderOne($id){
		return self::where('order_id',$id)->first()->toArray();
	}

	/*根据订单号取一条订单数据*/

	public static function getOrderSn($orderSn){
		return self::where('order_sn',$orderSn)->first()->toArray();
	}

	/*销售订单添加*/

	public static function salesOrderAdd($data){
		$data['create_time'] = getTime();
		$data['status'] = 1;
		$data['staff_id'] = _get_staff_id();
		$data['order_type'] = 1;
		$data['pro_num'] = abs($data['pro_num']);
		DB::beginTransaction();
		try {
			$id = self::insertGetId($data);
			$time = getTime();
			self::createOrderNode($id,$data['flow_id']);
			$datas = [
				'status' =>4,
				'update_time'=>$time,
				'active_time'=>$time,
				'finish_time'=>$time,
				'staff_id'=>_get_staff_id()
			];
			DB::table('erp_order_node')->where('flow_id',$data['flow_id'])->where('order_id',$id)->where('position',1)->update($datas);
			$nextNodeId = DB::table('erp_order_node')->where('flow_id',$data['flow_id'])->where('order_id',$id)->where('position',1)->value('next_node_id');
			$datas = [
				'status' =>2,
				'update_time'=>$time,
				'active_time'=>$time,
				'staff_id'=>_get_staff_id()
			];
			self::updateFlowStatus($nextNodeId,$data['flow_id'],$id,$datas);
			DB::commit();
			return true;
		} catch (Exception $e) {
			DB::rollBack();
			return false;
		}
	}

	/**
	*更新订单状态
	* @param $preNodeId 节点id
	* @param $flowId    流程id
	* @param $orderId   订单id
	* @param $data      更新的数据
	*/
	public static function updateFlowStatus($preNodeId,$flowId,$orderId,$data){
		return DB::table('erp_order_node')->where('flow_id',$flowId)->where('order_id',$orderId)->where('pre_node_id',$preNodeId)->update($data);
	}


	/*取订单流程节点*/

	public static function getFirstNode($flowId,$orderId,$position){
		return objToArr(DB::table('erp_order_node')->where('flow_id',$flowId)->where('order_id',$orderId)->where('position',$position)->get());
	}

	/*子订单添加*/

	public static function childOrderAdd($input){
		$orderSn = $input['order_sn'];
		$order = self::getOrderSn($orderSn);
		$data = [
			'order_id' => $order['order_id'],
			'order_plan_status' => config('order.default_order_plan_status'),
			'order_plan_sn' => self::createOrderSn(),
			'order_plan_price' =>$order['pro_price'],
			'order_plan_num' =>$input['pro_num'],
			'create_time' => common::getTime(),
			'is_delete' => config('order.is_delete'),
			'order_type' => config('order.default_child_order_type'),
		];

		DB::beginTransaction();
		try {
			DB::table('erp_order')->where('order_sn',$orderSn)->update(['pro_num_lock' => $order['pro_num_lock']+$input['pro_num']]);
			$id = DB::table('erp_order_plan')->insertGetId($data);
			self::createOrderNode($id);
			DB::commit();
			return true;
		} catch (Exception $e) {
			DB::rollBack();
			return false;
		}
	}

	/*映射节点*/

	public static function createOrderNode($orderId,$flowId){
		$nodes = objToArr(DB::table('erp_flow_config')->where('flow_id',$flowId)->get());
		foreach ($nodes as $val) {
			$data = [
				'order_id' =>$orderId,
				'pre_node_id' =>$val['pre_node_id'],
				'next_node_id' =>$val['next_node_id'],
				'role_id' => $val['role_id'],
				'flow_id' =>$val['flow_id'],
				'status' =>1,
				'create_time' =>getTime(),
				'position' =>$val['position'],
			];
			DB::table('erp_order_node')->insert($data);
		}
	}

	/*子孙树*/
	public static function subTree($arr,$id,$lev=1){
	    $subs=array();
	    foreach ($arr as $v) {
	        if($v['pre_node_id']==$id){
	            $v['lev']=$lev;
	            $subs[]=$v;
	            $subs=array_merge($subs,self::subTree($arr,$v['next_node_id'],$lev+1));
	        }
	    }
	    return $subs;
	}


    /*生成订单sn*/

    public static function createOrderSn(){
    	return "xc_". date("Ymd").uniqid();
    }


    /*订单追溯*/

    public static function getOrderTrace($input){
    	$orderSn = self::where('order_id',$input['order_id'])->value('order_sn');
    	$select = [
    		'erp_order_node.*','erp_node.node_name','erp_role.role_name'
    	];
    	$query = DB::table('erp_order_node')->where('order_id',$input['order_id'])->select($select);
    	$query = $query->leftJoin('erp_role','erp_role.role_id','=', 'erp_order_node.role_id');
		$query = $query->leftJoin('erp_node','erp_node.node_id','=', 'erp_order_node.pre_node_id');
		$nodes = objToArr($query->get());
		foreach ($nodes as  &$val) {
			switch ($val['status']) {
				case '1':
					$val['status'] ='未激活';
					break;
				case '2':
					$val['status'] ='已激活';
					break;
				case '3':
					$val['status'] ='已忽略';
					break;
				case '4':
					$val['status'] ='已完成';
					break;
				default:
					$val['status'] ='未激活';
					break;
			}
		}
		$data = [
			'nodes' => $nodes,
			'order_sn' => $orderSn,
		]; 
    	return $data;
    }


    /*取侍办任务*/

    public static function getTodo($input){
    	$staffId = _get_staff_id();
		$role =json_decode(Staff::findUserInfo($staffId),true);
		if(!empty($role['data']['role_id'])){
			$select = [
	    		'erp_order_node.*',
	    		'erp_node.node_name',
	    		'erp_role.role_name',
	    		'erp_order.staff_id',
	    		'erp_order.order_sn',
	    		'erp_staff.staff_name',
	    		'erp_flow.flow_name',
	    	];
	    	$where = [
	    		['erp_order_node.role_id','=',$role['data']['role_id']],
	    		['erp_order_node.status','=',2],
	    	];
	    	if(!empty($input['order_sn'])){
	    		$orderId = self::where('order_sn',$input['order_sn'])->value('order_id');
	    		$where[] = ['erp_order_node.order_id','=',$orderId];
	    	}
	    	if(!empty($input['start_time'])){
	    		$startTime = date('Y-m-d H:i:s',strtotime($input['start_time']));
				$where[] = ['erp_order_node.active_time','>=',$startTime];
	    	}
	    	$query = DB::table('erp_order_node')->where($where)->select($select);
	    	$query = $query->leftJoin('erp_role','erp_role.role_id','=', 'erp_order_node.role_id');
	    	$query = $query->leftJoin('erp_flow','erp_flow.flow_id','=', 'erp_order_node.flow_id');
			$query = $query->leftJoin('erp_node','erp_node.node_id','=', 'erp_order_node.pre_node_id');
			$query = $query->leftJoin('erp_order','erp_order.order_id','=','erp_order_node.order_id');
			$query = $query->leftJoin('erp_staff','erp_staff.staff_id','=','erp_order.staff_id');
			$count = $query->count();
			$pages = $query->paginate(config('common.page'));
			$task = objToArr($query->get());
			$data = [
				'count' => $count,
				'pages' => $pages,
				'task' =>$task,
			];
			return $data;
		}
		return false;
    }

    /*取节点模板*/

    public static  function getBlade($input){
    	$node = DB::table('erp_order_node')->where('id',$input['id'])->first();
    	$order = DB::table('erp_order')->where('order_id',$node->order_id)->first();
    	$blade = DB::table('erp_node_blade')->where('node_id',$node->pre_node_id)->value('blade');
    	$data = [
    		'blade'=>$blade,
    		'node' => $node,
    		'order' =>$order,
    	];
    	return $data;
    }


}
