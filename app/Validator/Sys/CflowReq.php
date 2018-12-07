<?php 
namespace App\Validator\Sys;
use Validator;

/*流程验证类*/

class CflowReq
{	
	/*检测流程*/
	
	public static function checkFlow($arr)
	{
		if(empty($arr)){
			return _error(2000,"参数不能为空");
		}
		$rules = [
			'flow_id' => 'required',
			'pre_node' => 'required',
			// 'next_node' => 'required',
			'role_id' => 'required',
		];
	    $message = [
	    	"flow_id.required" => "请选择流程",
	    	"pre_node.required" => "请选择当前节点",
	    	// "next_node.required" => "请选择下一个节点",
	    	"role_id.required" => "请选择角色",
	    ];
	    $validator = Validator::make($arr,$rules,$message);
	    if ($validator->fails()) {
	    	  $res = $validator->messages();
	    	  return  _error(2000, $res->first());
	    }
	}

	/*编辑流程*/
	
	public static function checkFlowEdit($arr)
	{
		if(empty($arr)){
			return _error(2000,"参数不能为空");
		}
		$rules = [
			'flow_id' => 'required',
			'pre_node_id' => 'required',
			// 'next_node_id' => 'required',
			'role_id' => 'required',
		];
	    $message = [
	    	"flow_id.required" => "请选择流程",
	    	"pre_node_id.required" => "请选择当前节点",
	    	// "next_node_id.required" => "请选择下一个节点",
	    	"role_id.required" => "请选择角色",
	    ];
	    $validator = Validator::make($arr,$rules,$message);
	    if ($validator->fails()) {
	    	  $res = $validator->messages();
	    	  return  _error(2000, $res->first());
	    }
	}
}
