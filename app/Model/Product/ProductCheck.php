<?php 
namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use DB;

/**
 * 申购送检
 */
class ProductCheck extends Model
{
	protected $table = 'erp_product_check';
	public $timestamps = false;

	/**
	 * 送检列表
	 * @return [type] [description]
	 */
	public static function getCheckList($pro_id = "")
	{
		$select = [
			'erp_product_check.*',
			'erp_product_info.product_name',
		];
		$res = self::where("erp_product_check.product_info_id",$pro_id)
				->select($select)
				->Join("erp_staff","erp_staff.staff_id","=","erp_product_check.staff_id")
				->Join("erp_product_info","erp_product_info.pro_id","=","erp_product_check.product_info_id")
				->get();
		return $res;
	}

	/**
	 * [送检列表插入 description]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function checkInsert($request)
	{
		try {
			DB::beginTransaction();
			$arr = [
				'produdt_info_id' 	=> $request->produdt_info_id,
				'check_name' 		=> $request->check_name,
				'staff_id' 			=> _get_staff_id(),
				'check_time' 		=> $request->check_time,
				'check_status' 		=> $request->check_status,
			];
			$res = self::insert($arr);
			DB::commit();			
			return _success($res);
		} catch (Exception $e) {
			DB::rollback();
			return _error(2000,$e->getMessage());
		}
	}
}  