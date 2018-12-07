<?php 
namespace App\Model\Partner;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Com\Common;
use Illuminate\Support\Collection;
use DB;
use App\Model\Erp\Staff;

use App\Libs\Images\ResDemo;
use App\Libs\Images\ImgUpload;

/**
 * 经销商
 */
class Dealer extends Model
{
	protected $table = 'erp_dealer';
	public $timestamps = false;
	
	public function getList($req)
	{

	}

	/**
	 * 商铺入驻
	 * @param [type] $req [description]
	 */
	public function addInfo($req)
	{
		try {
			DB::beginTransaction();
			$resdemo = new ResDemo();
			// 上传图片营业执照
			$business_license_img = $resdemo->upload_file($_FILES['business_license_img']);
			if($business_license_img['status'] != 200){
				return toRes(2000,$business_license_img['msg']);
			}else{
				$business_license_img = $business_license_img['msg'];
			}

			$corporation_img = $resdemo->upload_file($_FILES['corporation_img']);
			if($corporation_img['status'] != 200){
				return toRes(2000,$corporation_img['msg']);
			}else{
				$corporation_img = $corporation_img['msg'];
			}
			// 1录入用户信息
			$arr_staff = [
				'nick_name' 		=> $req->get('nick_name'),
				'staff_name' 		=> $req->get('staff_name'),
				'passwd' 			=> _md5($req->get('passwd')),
				'staff_phone' 		=> $req->get('staff_phone'),
				'email' 			=> $req->get('email'),
				'company_name' 		=> $req->get('company_name'),
				'company_address' 	=> $req->get('company_address'),
				'is_delete' 		=> "yes",
				'is_enable' 		=> 'no', //未启用
				'create_time' 		=> date("Y-m-d H:i:s",time())
			];
			$staff_id = Staff::insertGetId($arr_staff);

			if(empty($staff_id)){
				return _error(3000,config('errors.3000'));
			}   
			// 公司信息 商铺信息录入
			$arr_dealer = [
				'staff_id' 				=> $staff_id,
				'business_license_name' => $req->get('business_license_name'),
				'corporation_name' 		=> $req->get('corporation_name'),
				'corporation_idcard' 	=> $req->get('corporation_idcard'),
				'business_license_img' 	=> $business_license_img,
				'shop_name' 			=> $req->get('shop_name'),
				'main_produce' 			=> $req->get('main_produce'),
				'year_sale_size' 		=> $req->get('year_sale_size'),
				'corporation_img' 		=> $corporation_img,
				'company_num' 			=> $req->get('company_num'),
				'sale_staff_name' 		=> $req->get('sale_staff_name'),
				'code' 					=> 1, //1待审核，2已审核，3已驳回
				'create_time' 			=> date("Y-m-d H:i:s",time())
			];
			$res = self::insert($arr_dealer);
			DB::commit();
			return toRes(200,"");
		} catch (Exception $e) {
			DB::rollback();
			return toRes(2000,$e->getMessage());
		}
	}
}  