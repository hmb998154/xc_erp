<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Com\Common;
use App\Model\Erp\Staff;
use DB;

/**
 * 供应商类
 */
class Cate extends Model
{
	protected $table="erp_cate";
	public $timestamps = false;

	/**
	 * 获取可用类目类表
	 * @return [type] [description]
	 */
	public static function getCateEnableList()
	{
		$res =self::where("is_delete","no")->get();
		return _success($res);
	}

	public static function getCateEnableLists()
	{
		$res =self::where("is_delete","no")->get();
		return $res;
	}

	/**
	 * 获取单个类目信息
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function getSingleCate($request)
	{	
		$select = [
			'cate_id',
			'cate_name',
			'is_delete',
		];
		$res = self::select($select)->first();
		return _success($res);
	}

	/**
	 * 获取类目
	 * @return [type] [description]
	 */
	public static function cateList($request)
	{
		$select = [
			'cate_id',
			'cate_name',
			'is_delete',
		];
		
		$res = self::select($select);
		if($request->is_delete){
			$res = $res->where("is_delete",$request->is_delete);
		}

		if($request->search){
			$res = $res->where("cate_name","like","%".$request->search."%");
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
	 * 编辑类目
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function cateEdit($request)
	{
		try {
			DB::beginTransaction();
			$arr = ['cate_name' => $request->cate_name];
			$res = self::where("cate_id",$request->cate_id)->update($arr);
			DB::commit();
			return _success();
		} catch (Exception $e) {
			DB::rollBack();
			return _error(2000,$e->getMessage());
		}
	}

	/**
	 * 删除类目
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function cateDel($request)
	{
		try {
			DB::beginTransaction();
			$res = self::where("cate_id",$request->cate_id)->delete();
			DB::commit();
			return _success();
		} catch (Exception $e) {
			DB::rollBack();
			return _error(2000,$e->getMessage());
		}
	}

	/**
	 * 新增类目
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function cateAdd($request)
	{
		try {
			DB::beginTransaction();
			$res = self::where("cate_name",$request->cate_name)->count();
			if(!empty($res)){
				return _error(3002,config('errors.3002'));
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