<?php 
namespace App\Validator\Erp;
use Validator;

/**
 * 登录验证
 */
class LoginReq
{	
	/**
	 *检测
	 * @param  [type] $arr [description]
	 * @return [type]      [description]
	 */
	public static function check($arr)
	{
		if(empty($arr)){
			return _error(2000,"参数不能为空");
		}

		$rules = [
			// 'staff_name' => 'required|regex:/^[\x{4e00}-\x{9fa5}]+$/u',
			'staff_name' => 'required',
			'passwd' => 'required|',
			'code' => 'required|',	
		];
	    $message = [
	    	"staff_name.required" => "用户名不能为空",
	    	"passwd.required" => "密码不能为空",
	    	"code.required" => "验证码不能为空",
	    ];

	    $validator = Validator::make($arr,$rules,$message);
	    if ($validator->fails()) {
	    	  $res = $validator->messages();
	    	  return  _error(2000, $res->first());
	    }
	}
}
 ?>