<?php 
namespace App\Model\Order;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Com\Common;
use DB;

//计划订单model类
class Porder extends Model
{
	protected $table ="erp_order_plan";

	/*子订单列表*/

	public static function getChildOrderList($arr=""){
		$select  = ['order_id','order_sn','pro_price','pro_num','supplier','product_name','order_mark','status','flow_config_id','create_time','order_type','is_delete'];
		$where[] = ['is_delete','=','no'];
		/*if(!empty($arr['order_sn'])){
			$where[]= ['order_sn','=',$arr['order_sn']];
		}
		if(!empty($arr['order_plan_sn'])){
			$where[]= ['order_plan_sn','=',$arr['order_plan_sn']];
		}
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
		}*/
		$count = self::join('erp_order as o','')->where($where)->count();
		$pages = self::join('erp_order')->where($where)->paginate(config('common.page'));
		$orders = self::join('erp_order')->where($where)->select($select)->get()->toArray();
		$data = [
			'count' =>$count,
			'pages' =>$pages,
			'orders' =>$orders,
		];
		return $data;
	}

}