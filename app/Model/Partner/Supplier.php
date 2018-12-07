<?php 
namespace App\Model\Partner;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Com\Common;
use Illuminate\Support\Collection;
use DB;
use App\Model\Erp\Staff;

use App\Libs\Images\ResDemo;
use App\Libs\Images\ImgUpload;
use App\Model\Erp\ProductInfo;

/**
 * 供应商
 */
class Supplier extends Model
{
	protected $table = 'erp_supplier';
	public $timestamps = false;

	/**
	 * 品控实际厂能更新
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function supplierPkEdit($request)
	{
		try {
			DB::beginTransaction();
			$update_arr = [
				'actual_energy' 			=>	$request->actual_energy,
			];
			self::where('supplier_id',$request->supplier_id)->update($update_arr);
			DB::commit();
			return _success();
		} catch (Exception $e) {
			DB::rollback();
			return _error(2000,$e->getMessage());
		}
	}
	/**
	 * [品控实际产品 description]
	 */
	public function ProductControlInfo($request)
	{
		try {
			DB::begintransation();
			$arr = [
				'actual_energy' => $request->actual_energy,
			];
			self::where("supplier_id",$request->supplier_id)->update($arr);
			DB::commint();
			return _success();
		} catch (Exception $e) {
			DB::rollback();
			return _error($e->getMessage());
		}
	}	

	/**
	 * 编辑供应商信息
	 * @param  string $request [description]
	 * @return [type]          [description]
	 */
	public static function supplierEdit($request = '')
	{
		try {
			DB::beginTransaction();
			$update_arr = [
				'factory_name' 			=>	$request->factory_name,
				'factory_address' 		=>	$request->factory_address,
				'factory_area' 			=>	$request->factory_area,
				'storage_area' 			=>	$request->storage_area,
				'scale_of_productio' 	=>	$request->scale_of_productio,
				'factory_level' 		=>	$request->factory_level,
				'day_dev_num' 			=>	$request->day_dev_num,
				'dev_qualifications' 	=>	$request->dev_qualifications,
				'reputation' 			=>	$request->reputation,
				'factory_code' 			=>	$request->factory_code,
				'bond' 					=>	$request->bond,
				'legal_name' 			=>	$request->legal_name,
				'business_license' 		=>	$request->business_license,
				'Legal_idcard' 			=>	$request->Legal_idcard,
			];
			self::where('supplier_id',$request->supplier_id)->update($update_arr);
			DB::commit();
			return _success();
		} catch (Exception $e) {
			DB::rollback();
			return _error(2000,$e->getMessage());
		}
	}

	/**
	 * 获取单个供应商信息
	 * @param string $value [description]
	 */
	public static function getSupplierSingle($supplier_id)
	{
		$select = [
			'supplier_id',
			'factory_name',
			'factory_area', 
			'storage_area',
			'scale_of_productio',
			'factory_level',
			'day_dev_num',
			'dev_qualifications',
			'reputation',
			'factory_code',
			'bond',
			'actual_energy',
		];
		$res = self::where("supplier_id",$supplier_id)->first();   
		return $res;
	}

	/**
	 * 获取指定供应商列表信息
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */ 
	public static function getSupplier()
	{
		$arr = [
			'supplier_id',
			'factory_name',
			'factory_address',
			'factory_code',
		];
		$arr = self::select($arr)->get();
		return $arr;
	}

	/**
	 * 删除供应商 
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function supplierDel($request)
	{
		try {
			DB::beginTransaction();
			self::where("supplier_id",$request->supplier_id)->delete();
			DB::commit();
			return _success();
		} catch (Exception $e) {
			DB::rollback();
			return _error(2000,$e->getMessage());
		}
	}

	/**
	 * [供应商新增 description]
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public static function supplierInsert($request)
	{
		$arr = $request->all();
		try {
			DB::beginTransaction();
			$res_count = self::where("factory_name",$request->factory_name)->count();
			if(!empty($res_count)){
				return _error(2000,config('errors.3004'));
			}
			$arr['create_time'] = date("Y-m-d H:i:s",time());
			$res = self::insert($arr);
			DB::commit();
			return _success();
		} catch (Exception $e) {
			DB::rollback();
			return _error(2000,$e->getMessage());
		}
		
	}

	/**
	 * 新增供应商信息
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public static function supplierAdd($request)
	{
		try {
			DB::beginTransaction();
			$res =self::insert($request);
			DB::commit();			
			return _success($res);
		} catch (Exception $e) {
			DB::rollback();
			return _error(2000,$e->getMessage());
		}
	}

	/**
	 * 获取单个供应商信息
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function getSingleList($request)
	{
		$select = [
			'supplier_id',
			'factory_name',
			'factory_address',
			'day_dev_num',
			'actual_energy',
		];
		$res = self::where("supplier_id",$request->supplier_id)->select($select)->first();
		return _success($res);
	}	

	/**
	 * 获取供应商列表
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function supplierList($request)
	{
		$select = [
			'supplier_id',
			'factory_name',
			'factory_address',
			'business_license',
			'legal_name',
			'Legal_idcard',
			'factory_area',
			'storage_area',
			'scale_of_productio',
			'factory_level',
			'day_dev_num',
			'dev_qualifications',
			'reputation',
			'factory_code',
			'bond',
			'actual_energy',
		];
		$res = self::select($select);
		if(!empty($request->search)){
			$res = $res->where("factory_name","like","%".$request->search."%");
		}

		// 请求查询时间
		if(!empty($request->create_time)){
			$arr_time = change_create_time($request->create_time);
			$res = $res->whereBetween("create_time",[$arr_time['start'],$arr_time['end']]);
		}
		

		$sum = $res->count();
		$res = $res->orderBy("supplier_id","desc")->paginate(config('common.page'));;
		$all = [
			'info' => $res,
			'sum'  => $sum
		];
		return $all;
	}
}  