<?php

namespace App\Model\Log;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
	protected $table = 'erp_oper_log';
	public $timestamps = false;

	/**
	 * 操作登录日子
	 * @param [type] $arr [description]
	 */
	public static  function loginLogAdd($req ="")
	{
		$arr = [
			'staff_id' => _get_staff_id(),
			'ip' => get_ip(),
			// 'req' => json_encode($req->all()),
			'create_time' => date("Y-m-d H:i:s")
		];
		$res = self::insert($arr);
		return _success($res);
	}

	/**
	 * 查询日志
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public static  function listInfo($req='')
	{
		$select = [
			"erp_staff.staff_name",
			"erp_oper_log.login_log_id",
			"erp_oper_log.ip",
			"erp_oper_log.req",
			"erp_oper_log.create_time",
		];

		$res = self::leftJoin("erp_staff","erp_oper_log.staff_id","=","erp_staff.staff_id")->select($select)->orderBy("login_log_id","desc");
		if(!empty($req->get('search'))){
			$res = $res->where("erp_staff.staff_name","like","%".$req->get('search')."%");
		}
		$sum = $res->count();

		$res = $res->paginate(config('common.page'));
		// $res = collect($res)->toArray();
		$arr = [
			'info'=>$res,
			'sum'=>$sum
		];
		return $arr;
	}

	/**
	 * [getInfo 获取列表信息]
	 * @param  [type] $arr [description]
	 * @return [type]      [description]
	 */
	public static function getInfo($arr)
	{
		return  self::where("staff_id",_get_staff_id())->get();
	}

	/**
	 * 删除
	 * @param [type] $req [description]
	 */
	public static function DelLog($req)
	{
		$res = self::where("login_log_id",$req->login_log_id)->delete();
		return _success();
	}
}
