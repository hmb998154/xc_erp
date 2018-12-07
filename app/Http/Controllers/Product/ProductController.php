<?php
namespace App\Http\Controllers\Product;

use App\Http\Controllers\Com\Common;
use App\Http\Controllers\Controller;
use App\Model\Product\Product;
use DB;
use Storage;
use Illuminate\Support\Collection;
use App\Model\Product\Cate;
use App\Model\Product\Brand;
use App\Model\Product\Supplier;
use Illuminate\Http\Request;
use App\Model\Product\ProductCheck;

/**
 * 产品类
 */
class ProductController extends Controller {

	/**
	 * [newProduct 新品申报]
	 *
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function newProduct(Request $request) {
		$file = $request->file('file');
		if ($file) {
			return common::picUpload($file);
		}
		$input = $request->all();
		if ($input) {
			if ($id = Product::newProductAdd($input)) {
				return _success($id);
			}
			return _error();
		}
		$data['cate'] = Cate::getCateEnableLists();
		$data['brand'] = Brand::getBrandEnableLists();
		$data['supplier'] = Supplier::getSupplierList();
		return view('pro.newProduct', $data);
	}

	/**
	 * [ajaxGetSupplier ajax获到当前供应商]
	 *
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function ajaxGetSupplier(Request $request) {
		$input = $request->all();
		if ($input) {
			$supplier = supplier::getSupplier($input['id']);
			if ($supplier) {
				return _success($supplier);
			}
			return _error();
		}
	}

	/**
	 * [productList 商品列表]
	 *
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function productList(Request $request) {
		$input = $request->all();
		$data = Product::getProductCheckList($input);
		$data['cate'] = Cate::getCateEnableLists();
		return view('pro.productList', $data);
	}

	/**
	 * [productScheduleList 申购进度]
	 *
	 * @param  Request $reqeust [description]
	 * @return [type]           [description]
	 */
	public function productScheduleList(Request $reqeust) {
		$input = $reqeust->all();
		$data = Product::getProductList($input);
		return view('pro.productScheduleList', $data);
	}

	/**
	 * [productDetailed 申购进度详细]
	 *
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function productDetailed(Request $request) {
		$input = $request->all();
		$data = [
			'product' =>Product::getProductList($input) ,
			'supplier' => Supplier::getSupplierList(),
			'remark' =>Product::getRemark($input) ,
			'check' =>ProductCheck::getCheckList($input['pro_id']) , 
			'cate' =>Cate::getCateEnableLists() ,
			'brand' => Brand::getBrandEnableLists(),
		];
		return view('pro.productDetailed', $data);
	}

	/**
	 * [productEditDone 申购进度编辑提交]
	 *
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function productEditDone(Request $request) {
		$input = $request->all();
		if (!empty($input)) {
			return Product::productEditDone($input);
		}
	}


	/**
	 * 获取类目列表
	 * @return [type] [description]
	 */
	public function cateList(Request $request)
	{
		$res = Cate::cateList($request);
		return view('pro.cateList',$res);
	}

	/**
	 * 获取类目列表
	 * @return [type] [description]
	 */
	public function getSingleCate(Request $request)
	{
		return Cate::getSingleCate($request);
	}

	/**
	 * 编辑类目
	 * @return [type] [description]
	 */
	public function cateEdit(Request $request)
	{
		return Cate::cateEdit($request);
	}

	/**
	 * 新增类目
	 * @return [type] [description]
	 */
	public function cateAdd(Request $request)
	{
		return Cate::cateAdd($request);
	}

	/**
	 * 删除类目
	 * @return [type] [description]
	 */
	public function cateDel(Request $request)
	{
		return Cate::cateDel($request);
	}


	/**
	 * 获取品牌列表
	 * @return [type] [description]
	 */
	public function brandList(Request $request)
	{
		$res = Brand::brandList($request);
		return view('pro.brandList',$res);
	}

	/**
	 * 获取类目列表
	 * @return [type] [description]
	 */
	public function getSingleBrand(Request $request)
	{
		return Brand::getSingleBrand($request);
	}

	/**
	 * 编辑品牌
	 * @return [type] [description]
	 */
	public function brandEdit(Request $request)
	{
		return Brand::brandEdit($request);
	}

	/**
	 * 新增品牌
	 * @return [type] [description]
	 */
	public function brandAdd(Request $request)
	{
		return Brand::brandAdd($request);
	}

	/**
	 * 删除品牌
	 * @return [type] [description]
	 */
	public function brandDel(Request $request)
	{
		return Brand::brandDel($request);
	}
	
	/**
	 * [ProductRemark 留言提交]
	 *
	 * @param Request $request [description]
	 */
	public function productRemark(Request $request) {
		$input = $request->all();
		if (!empty($input)) {
			return Product::productRemark($input);
		}
	}

	/**
	 * [ProductCheck 送检记录]
	 *
	 * @param Request $request [description]
	 */
	public function productCheckRecode(Request $request) {
		$input = $request->all();
		if (!empty($input)) {
			return Product::checkRecode($input);
		}
	}

	/**
	 * [checkImgUpload 送检信息上传图片]
	 *
	 * @param  Request $reqeuest [description]
	 * @return [type]            [description]
	 */
	public function checkImgUpload(Request $request){
		$input  = $request->all();
		if(!empty($input)){
			return Product::checkImgUpload($input);
		}
	}

	/**
	 * 获取单个产品信息
	 * @return [type] [description]
	 */
	public function getProductSingle(Request $request)
	{
		
		return Product::getProductSingle($request);
	}

}