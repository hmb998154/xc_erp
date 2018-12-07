<?php 
namespace App\Http\Controllers\Com;
use App\Model\Erp\StaffRole;
use App\Model\Erp\Menu;
use Storage;
use App\Model\Erp\Staff;
use App\Model\Erp\StaffSupplier;
use App\Libs\Images\ImgUpload;

/**
 * 公共类
 */
class Common
{	

	/**
	 * 导出文件
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public static function exportExcel($arr)
	{
	    $string="";
	    foreach ($arr as $key => $value) 
	    {
	        foreach ($value as $k => $val)
	        {
	            $value[$k]=iconv('utf-8','gb2312',$value[$k]);
	        }

	        $string .= implode(",",$value)."\n"; //用英文逗号分开 
	    }
	    $filename = date('Ymd').'.csv'; //设置文件名
	    header("Content-type:text/csv"); 
	    header("Content-Disposition:attachment;filename=".$filename); 
	    header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
	    header('Expires:0'); 
	    header('Pragma:public'); 
	    return $string;
	}

	/**
	 * 获取用户-》供应商id
	 * @return [type] [description]
	 */
	public static function getStaffSuppilerId()
	{
		$res = Staff::where("staff_id",_get_staff_id())->select("type")->first();
		if($res->type == 2){
			$arr = StaffSupplier::leftJoin("erp_staff_supplier","erp_staff.staff_id","=","erp_staff_supplier.self_staff_id")
						->select("supplier_id")
						->first();
			$arr = collect($arr)->toArray();
			return $arr['supplier_id'];
		}else{
			return  false;
		}
	}

	/**
	 * [获取用户角色 description]
	 * @return [type] [description]
	 */
	public static function getRole($req = "")
	{
		$staff_id = _get_staff_id($req);
		$res = StaffRole::where("staff_id",$staff_id)	
				->leftJoin("erp_role","erp_staff_role.role_id","=","erp_role.role_id")
				->select("erp_role.role_id","erp_role.role_name")->first();

		switch ($res->role_name) {
			case '销售员':
				return '/index/saleList';
				break;
			case '供应商':
				return '/index/supplier';
				break;
			case '供应商子账户':
				return '/index/supplier';
				break;
			case '采购员':
				return '/index/saleList';
				break;
			case '财务':
				return '/index/finalList';
				break;
			case '仓库管理员':
				return '/index/finalList';
				break;
			default:
				return '/index/defaults';
				break;
		}
	}

	/*获取用户角色*/
	
	public static function getRoles()
	{
		$staff_id = _get_staff_id();
		$res = StaffRole::where("staff_id",$staff_id)	
				->leftJoin("erp_role","erp_staff_role.role_id","=","erp_role.role_id")
				->select("erp_role.role_id","erp_role.role_name")->first();
		$role = [
			'role_id'=>$res->role_id,
			'rodl_name' =>$res->role_name,
		];
		return $role;
	}

	/**
	 * 检测用户授权
	 * @param  menu_id $value [菜单id]
	 * @return [type]        [description]
	 */
	public static function checkAuthority($url)
	{
		if(in_array($url,config('sys.access_public'))){
			// return _error(2000,"无权限");
		}
		$res_menu = Menu::where("url",$url)->select("menu_id")->first();
		$menu = collect($res_menu)->toArray();
		if(empty($menu)){
			return _error(2000,"url:".$url."未配置");
		}
		$menu_id = $menu['menu_id'];

		$res_staff_role = StaffRole::where("staff_id",_get_staff_id())
				->leftJoin("erp_role","erp_staff_role.role_id","=","erp_role.role_id")
				->leftJoin("erp_role_menu","erp_staff_role.role_id","=","erp_role_menu.role_id")
				->select("menu_id")
				->first();
		if(!empty($res_staff_role)){
			$res = explode(",", $res_staff_role->menu_id);
			if(in_array($menu_id, $res)){
				return _success();
			}else{
				return _error(2000,"url:".$url."无权限");
			}
		}else{
			return _error(2000,"url:".$url."无权限");
		}
	}

	/**
	 * 获取用户id
	 * @return [type] [description]
	 */
	public static function get_staff_id()
	{
		return session("staff_id",1);
	}

	/*对象转数组*/
	public static function objectToArray($data){
		return array_map('get_object_vars',$data);
	}

	//数组转json封装
	public static function arrayToJson($code,$msg,$data=array()){
		if(!is_numeric($code)){
			return false;
		}
		$arr = array(
			'code'=> $code,
			'data' =>$data,
			'msg' => $msg
		);
		return json_encode($arr);
	}

	/*生成时间*/
	public static function getTime(){
    	return date('Y-m-d H:i:s');
    }

    /*获取角色Id*/

    public static function getRoleInfo(){
    	$staffId = _get_staff_id();
    }

    /**
     * 单个图片上传
     */
    public static function picUpload($file){
    	if($file->isValid()){
            $name = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $path = $file->getRealPath();
            $fileName=md5(uniqid($name));
            $minFileName = $fileName .'_min.'.$ext;
            $fileName = $fileName .'.'.$ext;
            Storage::disk('product')->put($fileName,file_get_contents($path));
            $data['pic']='imgs/product/'.$fileName;
            $savePath = public_path()."/imgs/product/".$minFileName;
            ImgUpload::compressed_image($path,$savePath);
            return _success($data);
        }
    }

    /**
	 * 处理图片
	 */
	public static function processingPic($picUrl=''){
		$num = strripos($picUrl,'.');
		$foot = substr($picUrl,$num);
		$head = substr($picUrl,0,$num).'_min';
		return  $head.$foot;
	}

}


