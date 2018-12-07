<?php

namespace App\Model\Order;

use Illuminate\Database\Eloquent\Model;

class OperLog extends Model
{
	protected $table = 'erp_oper_log';
	public $timestamps = false;

	/**
	 * 操作登录日子
	 * @param [type] $arr [description]
	 */
	public static  function addInfo($req ="")
	{
		dd(get_ip());
		$arr = [
			'staff_id' => _get_staff_id(),
			'ip' => get_ip(),
			'req' => $req
			'create_time' => date("Y-m-d H:i:s");
		];
		return  self::insert($arr);
	}

	/**
	 * [getInfo description]
	 * @param  [type] $arr [description]
	 * @return [type]      [description]
	 */
	public static function getInfo($arr)
	{
		return  self::where("staff_id",_get_staff_id())->get();
	}
}
