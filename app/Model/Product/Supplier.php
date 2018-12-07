<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Com\Common;
use App\Model\Erp\Staff;
use DB;

/**
 * 供应商类
 */
class Supplier extends Model
{
	protected $table="erp_supplier";

	/**
	 * 获取供应商
	 */

	public static function  getSupplierList(){
		return self::get();
	}


	/**
	 * id获取供应商
	 */
	public static function getSupplier($supplierId){
		return self::where('supplier_id',$supplierId)->first();
	}

}