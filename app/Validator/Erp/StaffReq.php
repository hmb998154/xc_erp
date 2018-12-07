<?php 
namespace App\Validator\Erp;
use Validator;

/**
 * 登录验证
 */
class StaffReq
{
	public function check($arr)
	{
		if(empty($arr)){
			return _error(2000,"参数不能为空");
		}

		$rules = [
			'staff_name' => 'required|regex:/^[\x{4e00}-\x{9fa5}]+$/u',
			'passwd' => 'required|max:12|min:6',
			'staff_phone' => 'required|',
		];

		$message = [
			"staff_name.required" => "用户名不能为空",
			// "staff_name.regex" => "用户名请求参数异常",
			"passwd.required" => "密码不能为空",
			"passwd.max" => "密码最大12位",
			"passwd.min" => "密码至少6位数",
			"staff_phone.required" => "手机号不能为空",
			// "staff_phone.regex" => "手机号不规范",
		];

	    $validator = Validator::make($arr,$rules,$message);
	    if ($validator->fails()) {
	    	  $res = $validator->messages();
	    	  return  _error(2000, $res->first());
	    }
	    return self::checkAdd($arr);
	}

	/**
	 * 检测用户密码一致
	 * @param  [type] $arr [description]
	 * @return [type]      [description]
	 */
	private static function checkAdd($arr)
	{
		if($arr['passwd'] !== $arr['qr_passwd']){
			return  _error(1008,config('errors.1008'));
		}
	}
}
 ?>