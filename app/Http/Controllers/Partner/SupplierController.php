<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Controllers\Com\Common;
use App\Model\Partner\Supplier;
use  App\Http\Requests\Partner\SupplierReqInsert;

/**
 *  供应商
 */
class SupplierController extends Controller
{

    // 品控类表
    /**
     * 获取工厂单个信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getSingleList(Request $request)
    {
        return Supplier::getSingleList($request);
    }

    /**
     *  品控实际厂能列表
     * @param string $value [description]
     */
    public function  ProductControlInfo(Request $request)
    {
        return Supplier::ProductControlInfo($request);
    }

    /**
     * 品控实际仓能
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function supplierPKEdit(Request $request)
    {
        return Supplier::supplierPkEdit($request);
    }
    /**
     *  厂能品控列表
     * @return [type] [description]
     */
    public function qualityList(Request $request)
    {
        $res = Supplier::supplierList($request);
        return view("Partner.qualityList",$res);
    }

    /**
     *  供应商列表
     * @return [type] [description]
     */
    public function supplierList(Request $request)
    {
    	$res = Supplier::supplierList($request);
    	return view("Partner.supplierList",$res);
    }

    /**
     * 删除供应商信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function supplierDel(Request $request)
    {
    	return Supplier::supplierDel($request);
    }

    /**
     * 编辑供应商信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function supplierEdit(Request $request)
    {
        return Supplier::supplierEdit($request);
    }

 

    /**
     * 获取单个供应商信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getSupplierSingle(Request $request)
    {
        $res =  Supplier::getSupplierSingle($request->supplier_id);
        return _success($res);
    }

    /**
     * 新增供应商列表
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function supplierAdd(Request $request)
    {
    	return view("Partner.supplierAdd");
    }

    /**
     * 新增供应商
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function supplierInsert(SupplierReqInsert $request)
    {
    	return Supplier::supplierInsert($request);
    }
}
