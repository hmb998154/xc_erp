<?php
namespace App\Model\Product;

use App\Http\Controllers\Com\Common;
use App\Model\Erp\Staff;
use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * 产品类
 */

class Product extends Model {
	/**
	 * [$table 产品表]
	 *
	 * @var string
	 */
	protected $table = "erp_product_info";

	/**
	 * 获取单个产品信息
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public static function getProductSingle($request)
	{
		$select = [
			'pro_id',
			'factory_id',
			'staff_id',
			'product_name',
			'product_fee',
			'product_six_nine_code',
			'erp_product_info.brand_id',
			'erp_brand.brand_name',
		];
		$res = self::where("pro_id",$request->pro_id)
				->leftJoin("erp_brand","erp_product_info.brand_id","=","erp_brand.brand_id")
				->select($select)
				->first();
		$arr = collect($res)->toArray();
		return _success($arr);
	}

	/**
	 * 获取所有商品信息
	 * @return [type] [description]
	 */
	public static function getProductInfo()
	{
		$select = [
			'factory_id',
			'product_code',
			'product_fee',
			'product_model',
			'brand_id',
			'product_art_no',
			'product_specifications',
			'create_time',
			'product_bar_code_img',
			'packing_img',
		];

		$res = self::where("erp_product_info.status",4)
				->leftJoin("erp_brand","erp_product_info.brand_id","=","erp_brand.brand_id")
				->select($select)
				->get();
		$arr = collect($res)->toArray();
		return $arr;
	}

	/**
	 * [newProductAdd 新品申报]
	 *
	 * @param  [type] $input [description]
	 * @return [type]        [description]
	 */
	public static function newProductAdd($input) {
		$products = [
			'factory_id' => $input['supplier'],
			'product_name' => $input['product_name'],
			'product_fee' => change_fee($input['product_fee']),
			'product_six_nine_code' => $input['product_six_nine_code'],
			'product_model' => $input['product_model'],
			'product_code' => $input['product_code'],
			'product_material' => $input['product_material'],
			'product_art_no' => $input['product_art_no'],
			'product_bar_code' => $input['product_bar_code'],
			'product_parm' => $input['product_parm'],
			'check_fee' => $input['check_fee'],
			'product_size' => $input['product_size'],
			'brand_id' => $input['brand_id'],
			'product_specifications' => $input['product_specifications'],
			'cate_id' => $input['cate_id'],
			'packing_size' => $input['packing_size'],
			'create_time' => getTime(),
			'staff_id' => _get_staff_id(),
		];

		if (!empty($input['product_bar_code_img'])) {
			$products['product_bar_code_img'] = $input['product_bar_code_img'];
			$products['product_bar_code_min_img'] = common::processingPic($input['product_bar_code_img']);
		}
		if (!empty($input['packing_img'])) {
			$products['packing_img'] = $input['packing_img'];
			$products['packing_min_img'] = common::processingPic($input['packing_img']);
		}

		return self::insertGetId($products);
	}

	/**
	 * [getProductList 申购确认商品列表]
	 *
	 * @param  [array] $input [查询数组集]
	 * @return [array]        [结果集数组]
	 */
	public static function getProductCheckList($input) {
		$select = ['erp_product_info.*','erp_product_stock.stock_num'];
		$where = [['status','=',4]];
		if (!empty($input['product_cate'])) {
			$where[] = ['cate_id', '=', $input['product_cate']];
		}
		if (!empty($input['product_name'])) {
			$where[] = ['product_name', 'like', "%" . $input['product_name'] . "%"];
		}
		if (!empty($input['status'])) {
			$where[] = ['status', '=', $input['status']];
		}
		if (!empty($input['pro_id'])) {
			$where[] = ['pro_id', '=', $input['pro_id']];
			$select = ['erp_product_info.*', 'erp_supplier.factory_name', 'erp_supplier.factory_address', 'erp_supplier.factory_code'];
			$query = self::where($where)->select($select);
			$query = $query->leftJoin('erp_supplier', 'erp_supplier.supplier_id', '=', 'erp_product_info.factory_id');
			$products = $query->first()->toArray();
			return $products;
		}
		$query = self::where($where)->select();
		$query = $query->leftJoin("erp_product_stock",'erp_product_stock.product_info_id','=','erp_product_info.pro_id');
		$count = $query->count();
		$pages = $query->paginate(config('common.page'));
		$products = $query->get();
		$data = [
			'count' => $count,
			'pages' => $pages,
			'products' => $products,
		];
		return $data;
	}

	/**
	 * 取商品信息
	 * 
	 * @return [type]        [object]
	 */
	public static function productList(){
		$select = ['pro_id','factory_id','product_name','brand_id','cate_id','status' ];
		return self::where('status',4)->select($select)->get();
	}

	/**
	 * [getProductList 商品列表]
	 *
	 * @param  [array] $input [查询数组集]
	 * @return [array]        [结果集数组]
	 */
	public static function getProductList($input) {
		$select = ['erp_product_info.*'];
		$where = [];
		if (!empty($input['product_name'])) {
			$where[] = ['product_name', 'like', "%" . $input['product_name'] . "%"];
		}
		if (!empty($input['status'])) {
			$where[] = ['status', '=', $input['status']];
		}
		/*获取单个商品*/
		if (!empty($input['pro_id'])) {
			$where[] = ['pro_id', '=', $input['pro_id']];
			$select = ['erp_product_info.*', 'erp_supplier.factory_name', 'erp_supplier.factory_address', 'erp_supplier.factory_code'];
			$query = self::where($where)->select($select);
			$query = $query->leftJoin('erp_supplier', 'erp_supplier.supplier_id', '=', 'erp_product_info.factory_id');
			$products = $query->first()->toArray();
			$products['product_fee'] = change_fee($products['product_fee'],2);
			return $products;
		}
		$query = self::where($where)->select();
		$count = $query->count();
		$pages = $query->paginate(config('common.page'));
		$products = $query->get();
		$data = [
			'count' => $count,
			'pages' => $pages,
			'products' => $products,
		];
		return $data;
	}

	/**
	 * [productEditDone 申购编辑提交]
	 *
	 * @param  [array] $input [description]
	 * @return [array]        [description]
	 */
	public static function productEditDone($input) {
		$products = [];
		foreach ($input as $key => $val) {
			if (!empty($val)) {
				$products[$key] = $val;
			}
		}
		$products['product_fee'] = change_fee($products['product_fee']);
		if (!empty($input['product_bar_code_img'])) {
			$products['product_bar_code_img'] = $input['product_bar_code_img'];
			$products['product_bar_code_min_img'] = common::processingPic($input['product_bar_code_img']);
		}
		if (!empty($input['packing_img'])) {
			$products['packing_img'] = $input['packing_img'];
			$products['packing_min_img'] = common::processingPic($input['packing_img']);
		}
		$info = self::where('pro_id',$input['pro_id'])->first();
		if (!empty($input['lock_code']) && $input['lock_code'] == 2) {
			if($info->status==1){
				return _error(1000, '请先审核通过');
			}
			$roleInfo = Staff::findSingle();
			$roleInfo = collect($roleInfo)->toArray();
			$roleId = $roleInfo['res']['role_id'];
			if ($roleId == 4 || $roleId == 1) {
				if ($res = self::where('pro_id', $input['pro_id'])->update(['lock_code' => $input['lock_code']])) {
					return _success($res);
				}
				return _error();
			}
			return _error(1000, '你无权限操作');
		}
		if (!empty($input['status']) && $input['status'] == 2) {
			if ($res = self::where('pro_id', $input['pro_id'])->update(['status' => $input['status']])) {
				return _success($res);
			}
			return _error();
		}

		if(!empty($input['status']) && $input['status'] ==4){
			$lockCode = self::where('pro_id',$input['pro_id'])->value('lock_code');
			if($lockCode ==2){
				if ($res = self::where('pro_id', $input['pro_id'])->update(['status' => $input['status']])) {
					return _success($res);
				}
				return _error();
			}
			return _error(1000,"请先锁定数据");
		}
		$res = self::where('pro_id', $input['pro_id'])->update($products);
		if ($res) {
			return _success($res);
		}
		return _error();
	}


	/**
	 * [productRemark 留言提交]
	 *
	 * @param  [type] $input [description]
	 * @return [type]        [description]
	 */
	public static function productRemark($input) {
		$remarks = [
			'staff_id' => _get_staff_id(),
			'remark' => trim($input['remark']),
			'product_info_id' => $input['pro_id'],
			'create_time' => getTime(),
		];
		if ($res = DB::table('erp_product_remark')->insertGetId($remarks)) {
			return _success($res);
		}
		return _error();
	}

	/**
	 * [getRemark 根据产品取留言内容]
	 *
	 * @param  [type] $productId [description]
	 * @return [type]            [description]
	 */
	public static function getRemark($input) {
		if ($input['pro_id']) {
			$select = [
				'erp_product_remark.*',
				'erp_staff.staff_name',
			];
			return DB::table('erp_product_remark')
				->select($select)
				->leftJoin('erp_staff', 'erp_staff.staff_id', '=', 'erp_product_remark.staff_id')
				->where('product_info_id', $input['pro_id'])
				->get();
		}
		return flase;
	}

	/**
	 * [checkRecode 送检记录]
	 *
	 * @param  [type] $input [description]
	 * @return [type]        [description]
	 */
	public static function checkRecode($input) {
		$datas = [
			'check_time' => $input['check_time'],
			'check_name' => $input['check_name'],
			'check_status' => $input['check_status'],
			'product_info_id' => $input['pro_id'],
			'staff_id' => _get_staff_id(),
		];
		DB::beginTransaction();
		try {
			$id = DB::table('erp_product_check')->insertGetId($datas);
			DB::commit();
			return _success($id);
		} catch (Exception $e) {
			DB::rollBack();
			return _error();
		}
	}

	/**
	 * [checkImgUpload 送检图片上传]
	 *
	 * @param  [type] $input [description]
	 * @return [type]        [description]
	 */
	public static function checkImgUpload($input){
		if (!empty($input['check_img'])) {
			$products['check_img'] = $input['check_img'];
			$res = self::where('pro_id', $input['pro_id'])->update(['check_img' => $input['check_img']]);
			if($res){
				return _success($res);
			}
			return _error();
		}
	}

}
