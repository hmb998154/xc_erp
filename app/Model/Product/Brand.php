<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Com\Common;
use App\Model\Erp\Staff;
use DB;

/**
 * 供应商类
 */
class Brand extends Model
{
	protected $table="erp_brand";
	public $timestamps = false;

	/**
	 * 获取可用品牌类表
	 * @return [type] [description]
	 */
	public static function getBrandEnableList()
	{
		$res = self::where("is_delete","no")->get();
		return _success($res);
	}

	public static function getBrandEnableLists()
	{
		$res = self::where("is_delete","no")->get();
		return $res;
	}

	/**
	 * 获取单个品牌信息
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function getSingleBrand($request)
	{	
		$select = [
			'brand_id',
			'brand_name',
			'is_delete',
		];
		$res = self::select($select)->first();
		return _success($res);
	}

	/**
	 * 获取品牌
	 * @return [type] [description]
	 */
	public static function BrandList($request)
	{
		$select = [
			'brand_id',
			'brand_name',
			'is_delete',
		];
		
		$res = self::select($select);
		if($request->is_delete){
			$res = $res->where("is_delete",$request->is_delete);
		}

		if($request->search){
			$res = $res->where("brand_name","like","%".$request->search."%");
		}
		$sum = $res->count();
		$res = $res->paginate(config('common.page'));
		$arr = [
			'info' => $res,
			'sum' => $sum,
		];
		return $arr; 
	}

	/**
	 * 编辑品牌
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function brandEdit($request)
	{
		try {
			DB::beginTransaction();
			$arr = ['brand_name' => $request->brand_name];
			$res = self::where("brand_id",$request->brand_id)->update($arr);
			DB::commit();
			return _success();
		} catch (Exception $e) {
			DB::rollBack();
			return _error(2000,$e->getMessage());
		}
	}

	/**
	 * 删除品牌
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function brandDel($request)
	{
		try {
			DB::beginTransaction();
			$res = self::where("brand_id",$request->brand_id)->delete();
			DB::commit();
			return _success();
		} catch (Exception $e) {
			DB::rollBack();
			return _error(2000,$e->getMessage());
		}
	}

	/**
	 * 新增品牌
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function brandAdd($request)
	{
		try {
			DB::beginTransaction();
			$res = self::where("brand_name",$request->brand_name)->count();
			if(!empty($res)){
				return _error(3002,config('errors.3003'));
			}
			$all = $request->all();
			self::insert($all);
			DB::commit();
			return _success();
		} catch (Exception $e) {
			DB::rollBack();
			return _error(2000,$e->getMessage());
		}
	}
}