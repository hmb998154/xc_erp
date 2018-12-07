<?php 
namespace App\Model\Erp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Com\Common;
use Illuminate\Support\Collection;
use DB;

/*系统model类*/
class Sys extends Model
{
	/*取所有流程*/

	public static function getFlows(){
		return objToArr(DB::table('erp_flow')->get());
	}

	/*取所有节点*/

	public static function getNodes(){
		return objToArr(DB::table('erp_node')->get());
	}

	/*取所有角色*/

	public static function getRoles(){
		return objToArr(DB::table('erp_role')->get());
	}

	/*根据查询取节点列表*/

	public static function getNodeList($input){
		$select = [
			'erp_node.*','erp_staff.staff_name'
		];
		$where[] = ['erp_node.is_delete','=','no'];
		if(!empty($input['node_name'])){
			$where[]= ['erp_node.node_name','=',$input['node_name']];
		}
		if(!empty($input['start_time'])){
			$startTime =date('Y-m-d H:i:s',strtotime($input['start_time']));
			$where[]= ['erp_node.create_time','>=',$startTime];
		}
		$query = DB::table('erp_node')->where($where)->select($select);
		$query = $query->leftJoin("erp_staff","erp_staff.staff_id","=","erp_node.staff_id");
		$count = $query->count();
		$pages = $query->paginate(config('common.page'));
		$nodes =objToArr($query->get());
		$data = [
			'count' =>$count,
			'pages' =>$pages,
			'nodes' =>$nodes,
		];
		return $data;
	}

	/*根据id取节点*/

	public static function getNode($nodeId){
		return objToArr(DB::table('erp_node')->where('node_id',$nodeId)->get());
	}

	/*根据id取节点名*/

	public static function getNodeName($nodeId){
		return DB::table('erp_node')->where('node_id',$nodeId)->value('node_name');
	}

	/*节点删除*/

	public static function nodeDel($input){
		$nodeId = $input['node_id'];
		if(self::getNodeConfig($nodeId)){
			return false;
		}
		return  DB::table('erp_node')->where('node_id',$nodeId)->delete();
	}

	/*查找节点配置*/

	public static function getNodeConfig($nodeId){
		return DB::table('erp_flow_config')->where('pre_node_id',$nodeId)->value('id');
	}

	/*查找流程配置*/

	public static function getFlowsConfig($flowId){
		return DB::table('erp_flow_config')->where('flow_id',$flowId)->value('id');
	}

	/*节点编辑*/

	public static function nodeEdit($input){
		$data = [
			'flow_id' => $input['flow_id'],
			'node_name' => $input['node_name'],
			'remark' => $input['remark']
		];
		return DB::table('erp_node')->where('node_id',$input['node_id'])->update($data);
	}

	/*添加节点*/

	public static function addNode($input){
		$input['create_time'] =common::getTime();
		$input['staff_id'] = common::get_staff_id();
		return DB::table('erp_node')->insert($input);
	}

	/*添加流程*/

	public static function addFlow($input){
		$input['create_time'] =getTime();
		$input['staff_id'] = _get_staff_id();
		return DB::table('erp_flow')->insert($input);
	}

	/*取流程配置列表*/

	public static function getflowConfig(){
		return objToArr(DB::table('erp_flow_config')->get());
	}

	/*根据查询取流程列表*/

	public static function getFlowList($input){
		$select = [
			'erp_flow.*','erp_staff.staff_name'
		];
		$where[] = ['erp_flow.is_delete','=','no'];
		if(!empty($input['flow_name'])){
			$where[]= ['erp_flow.flow_name','=',$input['flow_name']];
		}
		if(!empty($input['start_time'])){
			$startTime =date('Y-m-d H:i:s',strtotime($input['start_time']));
			$where[]= ['erp_flow.create_time','>=',$startTime];
		}
		$query = DB::table('erp_flow')->where($where)->select($select);
		$query = $query->leftJoin("erp_staff","erp_staff.staff_id","=","erp_flow.staff_id");
		$count = $query->count();
		$pages = $query->paginate(config('common.page'));
		$flows =objToArr($query->get());
		$data = [
			'count' =>$count,
			'pages' =>$pages,
			'flows' =>$flows,
		];
		return $data;
	}


	/*流程删除*/

	public static function flowDel($input){
		$flowId = $input['flow_id'];
		if(self::getFlowsConfig($flowId)){
			return false;
		}
		return  DB::table('erp_flow')->where('flow_id',$flowId)->delete();
	}

	/*根据id取流程*/

	public static function getFlow($flowId){
		return objToArr(DB::table('erp_flow')->where('flow_id',$flowId)->get());
	}

	/*节点编辑*/

	public static function flowEdit($input){
		$data = [
			'flow_name' => $input['flow_name'],
			'remark' => $input['remark']
		];
		return DB::table('erp_flow')->where('flow_id',$input['flow_id'])->update($data);
	}





}