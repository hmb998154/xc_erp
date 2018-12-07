<?php
namespace App\Model\Erp;

use App\Http\Controllers\Com\Common;
use App\Model\Erp\Menu;
use App\Model\Erp\Role;
use App\Model\Erp\StaffRole;
use App\Model\Log\Log;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Staff extends Model {
	protected $table = 'erp_staff';

	/**
	 * 查询用户信息
	 * @param  string $staff_id [description]
	 * @return [type]           [description]
	 */
	public static function findUserInfo($staff_id = "") {
		$select = [
			'erp_staff.staff_id',
			'erp_staff.staff_name',
			'erp_staff.staff_phone',
			'erp_staff.company_name',
			'erp_staff.company_address',
			'erp_role.role_name',
			'erp_role.role_id',
		];
		$res = self::where("erp_staff.staff_id", $staff_id)
			->leftJoin("erp_staff_role", "erp_staff.staff_id", "=", "erp_staff_role.staff_id")
			->leftJoin("erp_role", "erp_staff_role.role_id", "=", "erp_role.role_id")
			->select($select)
			->first();
		$arr = collect($res)->toArray();
		return _success($arr);
	}

	/**
	 * 获取个人信息
	 * @return [obj] [description]
	 */
	public static function findSingle() {
		$select = [
			'erp_staff.staff_id',
			'staff_name',
			'staff_phone',
			'role_name',
			'erp_staff.create_time',
			'erp_role.role_id',
			'erp_role.role_name',
		];
		$res = Staff::where("erp_staff.staff_id", _get_staff_id())
			->leftJoin("erp_staff_role", "erp_staff.staff_id", "=", "erp_staff_role.staff_id")
			->leftJoin("erp_role", "erp_staff_role.role_id", "=", "erp_role.role_id")
			->select($select)->first();
		// $res_log = LoginLog::where("staff_id",_get_staff_id())->paginate();
		// $log = collect($res_log)->toArray();
		$arr = [
			// 'logs' => $log,
			'res' => $res,
		];
		return $arr;
	}

	/**
	 * 获取用户
	 * @param  string $arr [参数集合]
	 * @return [ARR]      [description]
	 */
	public static function selectUser($arr = "") {
		$select = [
			'erp_staff.staff_id',
			'erp_staff.staff_name',
			'erp_staff.staff_phone',
			'erp_staff.company_name',
			'erp_staff.company_address',
			'erp_staff.type',
			'erp_staff.is_delete',
			'erp_staff.create_time',
			'erp_role.role_name',
		];
		$res = self::leftJoin("erp_staff_role", "erp_staff.staff_id", "=", "erp_staff_role.staff_id")
			->leftJoin("erp_role", "erp_staff_role.role_id", "=", "erp_role.role_id")
			->select($select)
			->orderBy("erp_staff.staff_id", "desc");

		if (isset($arr['is_delete'])) {
			$res = $res->where('erp_staff.is_delete', $arr['is_delete']);
		}
		if (!empty($arr['search'])) {
			$res = $res->orWhere('erp_staff.staff_phone', "like", "%" . $arr['search'] . "%")
				->orWhere('erp_staff.staff_name', "like", "%" . $arr['search'] . "%");
		}
		if (isset($arr['create_time'])) {
			$create_time_first = $arr['create_time'] . " 00:00:00";
			$create_time_end = $arr['create_time'] . " 23:59:59";
			$res = $res->whereBetween('erp_staff.create_time', [$create_time_first, $create_time_end]);
		}
		$sum = $res->count();
		$res = $res->paginate(config('common.page'));
		// ->toArray();
		$role_select = ["role_id", "role_name"];
		$res_role = Role::where("is_delete", "no")->select($role_select)->get()->toArray();
		$all = [
			'info' => $res,
			'sum' => $sum,
			'roles' => $res_role,
		];
		return $all;
	}

	/**
	 * 用户登录
	 * @param  [type] $arr [description]
	 * @return JSON      [description]
	 */
	public function inserSession($req) {
		if (strtoupper(session('captcha')) != strtoupper($req['code'])) {
			return _error(1001, config('errors.1001'));
		}

		$arr = [
			'staff_name' => $req['staff_name'],
			'passwd' => _md5($req['passwd']),
			'is_delete' => "no",
		];

		$res = Redis::hget('staff_info', $req['staff_name']);
		if (!empty($res)) {
			$res_info = json_decode($res, true);
			if ($res_info['passwd'] == _md5($req['passwd'])) {
				session()->put("staff_id", $res_info['staff_id']);
				session()->put("staff_name", $req['staff_name']);
				$url = Common::getRole($req['staff_name']);
				Log::loginLogAdd();
				return _success($url);
			} else {
				return _error(1000, config('errors.1000'));
			}
		} else {
			$res_staff = self::where($arr)->first();
			$res_menus = Menu::getMenuInfo();
			if (empty($res_staff)) {
				return _error(1000, config('errors.1000'));
			} else {
				session()->put("staff_id", $res_staff->staff_id);
				session()->put("staff_name", $req['staff_name']);
				$url = Common::getRole();
				Log::loginLogAdd();
				$arr_new = [
					'staff_id' => $res_staff->staff_id,
					'staff_name' => $res_staff->staff_name,
					'passwd' => $res_staff->passwd,
					'nick_name' => $res_staff->nick_name,
					'staff_phone' => $res_staff->staff_phone,
					'req_time' => date("Y-m-d H:i:s"),
					'is_delete' => 'no',
					'type' => $res_staff->type,
					'par_id' => $res_staff->par_id,
				];
				Redis::hset("staff_info", $req['staff_name'], json_encode($arr_new));
				return _success($url);
			}
		}
	}

	/**
	 * 添加用户
	 * @param JSON $arr [description]
	 */
	public static function addUser($req) {

		$arr = [
			'staff_name' => $req->staff_name,
			'staff_phone' => $req->staff_phone,
			'passwd' => $req->passwd,
			'qr_passwd' => $req->qr_passwd,
			'role_id' => $req->role_id,
		];
		try {
			DB::beginTransaction();
			unset($arr['qr_passwd']);
			$role_id = $arr['role_id'];
			unset($arr['role_id']);
			$arr['passwd'] = _md5($arr['passwd']);
			$res_staff = self::where(['staff_name' => $arr['staff_name']])->first();
			if (isset($res_staff->staff_name)) {
				return _error(1006, config('errors.1006'));
			}

			$res_staff = self::where(['staff_phone' => $arr['staff_phone']])->first();
			if (isset($res_staff->staff_name)) {
				return _error(1007, config('errors.1007'));
			}

			$arr['create_time'] = date("Y-m-d H:i:s");
			$staff_id = self::insertGetId($arr);
			$arr_role = [
				'staff_id' => $staff_id,
				'role_id' => $role_id,
			];
			StaffRole::insert($arr_role);
			DB::commit();
			return _success();
		} catch (Exception $e) {
			DB::rollback();
			return _error(2000, $e->getMessage());
		}

	}

	/**
	 * 获取用户
	 * @param  [type] $arr [description]
	 * @return json      [description]
	 */
	public function getUser($arr) {
		$res = self::insert($arr);
		if (empty($res)) {
			return _error(1003, config('errors.1003'));
		} else {
			return _success();
		}
	}

	/**
	 * 删除用户
	 */
	public static function userDel($user_id) {
		$res = self::where("staff_id", $user_id)->where("is_delete", "yes")->count();
		if (!empty($res)) {
			return _error(1010, config('errors.1010'));
		}
		$res = self::where('staff_id', $user_id)->delete();
		if (empty($res)) {
			return _error(1002, config('errors.1002'));
		} else {
			return _success();
		}
	}

	/**
	 * 编辑用户 和状态
	 * @param  string $user_id 用户编号id
	 * @param  [type] $arr     [参数集合]
	 * @return [json]          [description]
	 */
	// public function editUser($user_id='',$arr)
	public function editUser($req) {
		$user_id = $req->staff_id;
		try {
			DB::beginTransaction();
			if (isset($req->is_delete)) {
				if ($req->is_delete == "启用") {
					$arr['is_delete'] = "no";
				} else {
					$arr['is_delete'] = "yes";
				}
				$res = self::where('staff_id', $user_id)->update($arr);
			} else {
				$res_del = self::where('staff_id', $user_id)->select("is_delete")->first();
				if ($res_del->is_delete == "yes") {
					return _error(1012, config('errors.1012'));
				}

				$arr_edit = [
					'staff_id' => $req->staff_id,
					'staff_name' => $req->staff_name,
					'staff_phone' => $req->staff_phone,
					'company_name' => $req->company_name,
					'company_address' => $req->company_address,
				];
				$res = self::where('staff_id', $user_id)->update($arr_edit);
				StaffRole::where("staff_id", $user_id)->update(['role_id' => $req->role_id]);
			}
			DB::commit();
			return _success();
		} catch (Exception $e) {
			DB::rollback();
			return _error(2000, $e->getMessage());
		}
	}

	/**
	 * 修改密码
	 * @param  [type] $arr [description]
	 * @return [JSON]      [description]
	 */
	public static function changePwd($arr) {
		try {
			DB::beginTransaction();
			$staff_id = _get_staff_id();
			$where = [
				'staff_id' => $staff_id,
				'passwd' => _md5($arr->old_passwd),
			];

			$res = self::where($where)->first();
			if (empty($res)) {
				return _error(1009, config('errors.1009'));
			}
			self::where('staff_id', $staff_id)->update(['passwd' => _md5($arr->passwd)]);
			$rds_info = Redis::hget("staff_info", $res->staff_name);

			$arr_info = json_decode($rds_info, true);
			$arr_info['passwd'] = _md5($arr['passwd']);
			$rds_info = Redis::hset("staff_info", $res->staff_name, json_encode($arr_info));
			DB::commit();
			return _success();
		} catch (Exception $e) {
			DB::rollback();
			return _error(2000, $e->getMessage());
		}
	}

	/**
	 * 修改用户信息
	 * @param  string $arr [description]
	 * @return [json]      [description]
	 */
	public static function changeInfo($arr = "") {
		$update = [
			'staff_name' => $arr['staff_name'],
			'staff_phone' => $arr['staff_phone'],
		];
		$res = self::where("staff_id", _get_staff_id())->update($update);
		if (!empty($res)) {
			return _success();
		}
	}

	/**
	 * 密码重置
	 */
	public static function resetPasswd($req) {
		self::where("staff_id", $req->staff_id)->update(['passwd' => resetPwd()]);
		return _success();
	}
}
