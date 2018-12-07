<?php 
namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use DB;
use App\Model\Product\BarCode;

/**
 * 商品条码
 */
class ProductBar extends Model
{
	protected $table = 'erp_product_bar';
	public $timestamps = false;

	/**
	 * 删除条码编号
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public static function delCode($request)
	{
		try {
			DB::beginTransaction();
			$res = BarCode::where("bar_code_id",$request->bar_code_id)->delete();
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			return _error(2000,$e->getMessage());
		}
	}

	/**
	 * 生成号段
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function codeAdd($request)
	{
		try {
			DB::beginTransaction();
			$arr = [
				'order_id' 				=> $request->order_id,
				'product_info_id' 		=> $request->product_info_id,
				'bar_code_digs' 		=> $request->bar_code_digs,
				'pro_unit_type' 		=> $request->pro_unit_type,
				'pro_unit' 				=> $request->pro_unit,
				'pro_prefix' 			=> $request->pro_prefix,
				'suffix_code' 			=> $request->suffix_code,
				'type' 					=> $request->type,
				'remark' 				=> $request->remark
			];

			$id = self::insertGetId($arr);

			$sum = $request->sum;
			$new_arr = [];
			for($i = 0; $i < $sum; $i++){
				$new_arr[$i] = [
					'pro_bar_id' 		=> $id,
					'pro_id' 			=> $request->product_info_id,
					'bar_code_sn' 		=> $request->pro_prefix.bar_sn($request->bar_code_digs).$request->suffix_code,
					'status' 			=> "no",
					'create_time' 		=> date("Y-m-d H:i:s"),
				];
			}
			BarCode::insert($new_arr);
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			return _error(2000,$e->getMessage());
		}
	}

	/**
	 * 号段列表请求
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function codeList($request)
	{
		$select = [
			'erp_product_bar.product_info_id',
			'erp_bar_code.bar_code_id',
			'product_name',
			'erp_product_info.product_six_nine_code',
			'pro_unit_type',
			'pro_unit',
			'pro_prefix',
			'suffix_code',
			'bar_code_preview',
			'bar_code_sn',
			'type',
			'erp_product_bar.remark',
			'erp_bar_code.create_time',
		];

		$res = BarCode::where("erp_bar_code.status","no")->select($select);

		if(!empty($request->pro_id)){
			$res = $res->where("erp_bar_code.pro_id",$request->pro_id);
		}

		if(!empty($request->search)){
			$res = $res->where("erp_bar_code.bar_code_sn","like","%".$request->search."%");
		}

		if(!empty($request->create_time)){
			$arr_time = change_time($request->create_time);
			$res = $res->whereBetween('erp_bar_code.create_time', $arr_time);
		}

		$sum = $res->count();

		$res = $res->leftJoin("erp_product_info","erp_bar_code.pro_id","=","erp_product_info.pro_id")
				->leftJoin("erp_product_bar","erp_bar_code.pro_bar_id","=","erp_product_bar.pro_bar_id")
				->paginate(config('common.page'));

		// $res = $res->leftJoin("erp_product_info","erp_product_bar.product_info_id","=","erp_product_info.pro_id")
		// 		->leftJoin("erp_bar_code","erp_product_bar.pro_bar_id","=","erp_bar_code.pro_bar_id")
		// 		->paginate(config('common.page'));
		$arrs = [
			'info' => $res,
			'sum'  => $sum
		];
		return $arrs;
	}

	/**
	 * 号段生成
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public static function codeBind($request='')
	{
		try {
			DB::beginTransaction();
			$sum = $request->sum();
			$arr = [];
			for($i = 0; $i < $sum; $i++){
				$arr[$i] = [
					'product_info_id' 		=> $request->product_info_id,
					'bar_code_id' 			=> $request->bar_code_id,
					'bar_code' 				=> $request->bar_code,
					'product_six_nine_code' => $request->product_six_nine_code,
					'bar_code_digs' 		=> $request->bar_code_digs,
					'pro_unit_type' 		=> $request->pro_unit_type,
					'pro_unit' 				=> $request->pro_unit, 
					'pro_prefix' 			=> $request->pro_prefix,
					'suffix_code' 			=> $request->suffix_code,
					'bar_code_preview' 		=> $request->bar_code_preview,
					'type' 					=> 1,
					'remark' 				=> $request->remark,
					'create_time' 			=> date('Y-m-d H:i:s',time()),
				];
			}
			self::insert($arr);
			DB::commit();
			return _success();
		} catch (Exception $e) {
			DB::rollback();
			return _error(2000,$e->getMessage());
		}
		
	}
}  