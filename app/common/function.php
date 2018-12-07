<?php
use Illuminate\Support\Facades\Redis;

/**
 * 转为_success格式
 */
if (!function_exists('check_config')) {
	function check_config($data = "") {

	}
}

/**
 * 请求ip地址
 */
if (!function_exists('get_ip')) {
	function get_ip() {
		$ip = $_SERVER['REMOTE_ADDR'];
		return $ip;
	}
}

/**
 * 请求时间转为时间数组
 */
if (!function_exists('change_time')) {
	function change_time($arr) {
		$arrs[0] = $arr . " 00:00:00";
		$arrs[1] = $arr . " 23:59:59";
		return $arrs;
	}
}

/**
 * 请求时间转为时间数组
 */
if (!function_exists('toRes')) {
	function toRes($status = '200', $msg = '') {
		return [
			'status' => 200,
			'msg' => $msg,
		];
	}
}

/**
 * 切换状态显示
 */
if (!function_exists('change_status')) {
	function change_status($data = "") {
		switch ($data) {
		case 'yes':
			return '禁用';
			break;
		case 'no':
			return '启用';
			break;
		}
	}
}

/**
 * 成功json
 */
if (!function_exists('_success')) {
	function _success($data = "") {
		$arr = [
			'status' => 200,
			'msg' => "请求成功",
			'data' => $data,
		];
		return json_encode($arr, JSON_UNESCAPED_UNICODE);
	}
}

/**
 * 错误json
 */
if (!function_exists('_error')) {
	function _error($status = 1000, $msg = "请求失败", $data = "") {
		$arr = [
			'status' => $status,
			'msg' => $msg,
			'data' => $data,
		];
		return json_encode($arr, JSON_UNESCAPED_UNICODE);
	}
}

/**
 * 获取系统错误提示消息
 * @param int $status 状态码
 * @return string
 */
if (!function_exists('_get_sys_error')) {
	function _get_sys_error($error) {
		$sysError = config('sys.sys_error');

		return $sysError[$error];
	}
}

/**
 * json 转为数组 格式
 */
if (!function_exists('_arr')) {
	function _arr($data = "") {
		return json_decode($data, true);
	}
}

/**
 * json响应
 *
 * @param array $data
 * @return Illuminate\Http\JsonResponse
 */
if (!function_exists('_json_response')) {
	function _json_response($data = []) {
		return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
	}
}

/**
 * 获取 staff_id
 *
 * @param array $data
 * @return Illuminate\Http\JsonResponse
 */
if (!function_exists('_get_staff_id')) {
	function _get_staff_id($req = "") {
		if (empty($req)) {
			return session()->get('staff_id');
		} else {
			$res = Redis::hget("staff_info", $req);
			$arr = json_decode($res, true);
			return $arr['staff_id'];
		}
	}
}

/**
 * 加密 md5
 *
 */
if (!function_exists('_md5')) {
	function _md5($arr) {
		return md5($arr);
	}
}

/*生成时间*/

function getTime() {
	return date('Y-m-d H:i:s');
}

/*对象转数组*/

function objToArr($obj) {
	return array_map('get_object_vars', $obj);
}

/*
打印SQL默认是关闭的，需要在/vendor/larave/illuminate/database/Connection.php中打开。
设置　protected $loggingQueries = true;
 */

function showSql() {
	$log = DB::getQueryLog();
	print_r($log);exit;
}

/*查找子孙树*/

function sub_tree($arr, $id, $lev = 1) {
	$subs = array();
	foreach ($arr as $v) {
		if ($v['parent'] == $id) {
			$v['lev'] = $lev;
			$subs[] = $v;
			$subs = array_merge($subs, sub_tree($arr, $v['id'], $lev + 1));
		}
	}
	return $subs;
}

/**
 * 重置密码 resetPwd
 */
if (!function_exists('resetPwd')) {
	function resetPwd() {
		return _md5(123456);
	}
}

/**
 * 送检状态 显示中文
 */
if (!function_exists('product_check_change')) {
	function product_check_change($param) {
		switch ($param) {
		case '1':
			return "未送检";
			break;
		case '2':
			return "未送检";
			break;
		default:
			break;
		}
	}
}


/**
 * 转换查询时间 
 */
if (!function_exists('change_create_time')) {
	function change_create_time($param) {
		$start = $param." 00:00:00";
		$end = $param." 23:59:59";
		$arr = [
			'start' => $start,
			'end' => $end,
		];
		return $arr;
	}
}


/**
 *  转换价格
 */
if (!function_exists('change_fee')) {
	function change_fee($param , $status = "1") {
		switch ($status) {
			case '1':
				return $param * 100;
				break;
			case '2':
				return $param / 100;
				break;
			default:
				return $param * 100;
				break;
		}
	}
}

/**
 *  生成订单sn
 */
if (!function_exists('order_sn')) {
	function order_sn() {
		return "XS".date("Ymd").rand(10000,99999).rand(10,99);
	}
}

/**
 *  生成条码sn
 */
if (!function_exists('bar_sn')) {
	function bar_sn($length) {
		return "TM".date("YmdHis").rand(1000,9999);
	}
}
