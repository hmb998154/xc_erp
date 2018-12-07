<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;
use App\Model\Erp\Staff;
use DB;
use App\Model\Product\ProductBar;
use App\Http\Controllers\Com\Common;
/**
 * 商品条码
 */
class BarCode extends Model
{
	protected $table="erp_bar_code";
	public $timestamps = false;

	/**
	 * 导出号段
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public static function downCodeList($request)
	{
		$res = ProductBar::where("order_id",$request->order_id)
				->where("status","no")
				->leftJoin("erp_bar_code","erp_product_bar.pro_bar_id","=","erp_bar_code.pro_bar_id")
				->select("bar_code_sn")
				->get();
		$arr = collect($res)->toArray();
		return Common::exportExcel($arr);
	}
}