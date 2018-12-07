<?php 
namespace App\Model\Erp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Com\Common;
use Illuminate\Support\Collection;
use App\Model\Erp\Sys;
use DB;

/*系统流程配置类*/

class Cflow extends Model
{

	protected $table='erp_flow_config';
	public $timestamps = false;

	/*添加流程配置*/

	public static function addFlowConfig($input){
		$preNodeName = Sys::getNodeName($input['pre_node']);
		$nextNodeName = Sys::getNodeName($input['next_node']);
		$data = [
			'pre_node_id' => $input['pre_node'],
			'next_node_id' => $input['next_node'],
			'flow_id' => $input['flow_id'],
			'role_id' => $input['role_id'],
			'create_time' => getTime(),
			'admin_id' => _get_staff_id(),
			'cflow_name' =>$preNodeName,
			'position' => $input['position'],
		];
		if($input['position']!=3){
			$data['remark'] = $preNodeName.' > '.$nextNodeName;
		}else{
			$data['remark'] = $preNodeName;
		}
		
		return self::insertGetId($data);
	}

	/*根据查询取流程配置列表*/

	public static function getFlowConfigList($input){
		$select = [
			'erp_flow_config.*','erp_staff.staff_name','erp_role.role_name','erp_flow.flow_name','erp_node.node_name'
		];
		$where[] = ['erp_flow_config.is_delete','=','no'];
		if(!empty($input['cflow_name'])){
			$where[]= ['erp_flow_config.cflow_name','=',$input['cflow_name']];
		}
		if(!empty($input['start_time'])){
			$startTime =date('Y-m-d H:i:s',strtotime($input['start_time']));
			$where[]= ['erp_flow.create_time','>=',$startTime];
		}
		if(!empty($input['flow_id'])){
			$where[] = ['erp_flow.flow_id','=',$input['flow_id']];
		}
		$query = self::where($where)->select($select);
		$query = $query->leftJoin("erp_staff","erp_staff.staff_id","=","erp_flow_config.admin_id");
		$query = $query->leftJoin('erp_role','erp_role.role_id','=', 'erp_flow_config.role_id');
		$query = $query->leftJoin('erp_flow','erp_flow.flow_id','=', 'erp_flow_config.flow_id');
		$query = $query->leftJoin('erp_node','erp_node.node_id','=', 'erp_flow_config.pre_node_id');
		$count = $query->count();
		$pages = $query->paginate(config('common.page'));
		$cflows = $query->get()->toArray();
		$data = [
			'count' =>$count,
			'pages' =>$pages,
			'cflows' =>$cflows,
		];
		return $data;
	}


	/*流程配置删除*/

	public static function flowConfigDel($input){
		return  self::where('id',$input['id'])->delete();
	}

	/*根据id取流程配置*/

	public static function getFlowConfig($input){
		return self::where('id',$input['id'])->first()->toArray();
	}

	/*配置编辑*/

	public static function flowConfigEdit($input){
		$preNodeName = Sys::getNodeName($input['pre_node_id']);
		$nextNodeName = Sys::getNodeName($input['next_node_id']);
		$data = [
			'pre_node_id' => $input['pre_node_id'],
			'next_node_id' => $input['next_node_id'],
			'flow_id' => $input['flow_id'],
			'role_id' => $input['role_id'],
			'update_time' => getTime(),
			'cflow_name' =>$preNodeName
		];

		if($input['position']!=3){
			$data['remark'] = $preNodeName.' > '.$nextNodeName;
		}else{
			$data['remark'] = $preNodeName;
		}
		if($input['position'] == 1){
			$count = self::where('flow_id',$input['flow_id'])->where('position',1)->where('id','<>',$input['id'])->count();
			if(!empty($count)){
				return _error(1000,'出错啦！流程已有首节点');
			}
		}
		if($input['position'] == 3){
			$count = self::where('flow_id',$input['flow_id'])->where('position',3)->where('id','<>',$input['id'])->count();
			if(!empty($count)){
				return _error(1000,'出错啦！流程已有尾节点');
			}
		}
		$id = self::where('id',$input['id'])->update($data);
		if($id){
			return _success($id);
		}
		return _error();
	}

}