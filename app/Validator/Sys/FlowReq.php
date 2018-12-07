<?php 
namespace App\Validator\Sys;
use Validator;

/*流程验证类*/

class FlowReq
{	
	/*检测流程*/
	
	public static function checkFlow($arr)
	{
		if(empty($arr)){
			return _error(2000,"参数不能为空");
		}
		$rules = [
			'flow_name' => 'required|regex:/^[\x{4e00}-\x{9fa5}]+$/u',
		];
	    $message = [
	    	"flow_name.required" => "流程名称不能为空",
	    	"flow_name.regex" => "流程名称必须为中文",
	    ];
	    $validator = Validator::make($arr,$rules,$message);
	    if ($validator->fails()) {
	    	  $res = $validator->messages();
	    	  return  _error(2000, $res->first());
	    }
	}
}
