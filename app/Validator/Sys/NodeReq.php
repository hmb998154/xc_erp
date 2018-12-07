<?php 
namespace App\Validator\Sys;
use Validator;

/*节点验证类*/

class NodeReq
{	
	/*检测节点*/
	
	public static function checkNode($arr)
	{
		if(empty($arr)){
			return _error(2000,"参数不能为空");
		}
		$rules = [
			'node_name' => 'required|regex:/^[\x{4e00}-\x{9fa5}]+$/u',
			'flow_id' => 'required',
		];
	    $message = [
	    	"node_name.required" => "节点名称不能为空",
	    	"node_name.regex" => "节点名称必须中文",
	    	"flow_id.required" => "请选择流程",
	    ];
	    $validator = Validator::make($arr,$rules,$message);
	    if ($validator->fails()) {
	    	  $res = $validator->messages();
	    	  return  _error(2000, $res->first());
	    }
	}
}
