<?php

namespace App\Model\Erp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Com\Common;
use DB;
use  App\Model\Erp\Menu;
use  App\Model\Erp\Role;

class RoleMenu extends Model
{
    protected $table = 'erp_role_menu';
    protected $primaryKey = 'role_menu_id';
    public $timestamps = false;

    /**
     * 获取角色菜单信息
     * @param  string $role_id [description]
     * @return json          [description]
     */
    public static function getInfo($role_id = "1")
    {
    	$res_role = Role::where("role_id",$role_id)->select()->select("role_name")->first();
    	// 权限配置
    	$res_config = Role::where("erp_role.role_id",$role_id)
    	    ->leftJoin("erp_role_menu","erp_role.role_id","=","erp_role_menu.role_id")
    	    ->select("menu_id")
    	    ->first();
    	$res_config = collect($res_config)->toArray();
    	// $self_config = [];
    	if(!empty($res_config)){
    	    $res_config = explode(",", $res_config['menu_id']);
    	}

    	$select = [
    		'menu_id',
    		'menu_name',
            'url'
    	];

    	$where = [
    	    'is_delete' => 'no',
    	    'par_id' => 0,
    	];

    	$res = Menu::where($where)->select($select)->get();
    	$res = collect($res)->toArray();
    	foreach ($res as &$value) {
    		if(in_array($value['menu_id'], $res_config)){
    			$value['checked'] = "checked";
    		}else{
    			$value['checked'] = "";
    		}

    	    $where = [
    	        'is_delete' => 'no',
    	        'par_id' => $value['menu_id'],
    	    ];

    	    $arr = Menu::where($where)->select($select)->get();
    	    $arr = collect($arr)->toArray();
    	    foreach ($arr as &$value2) {
    	    	if(in_array($value2['menu_id'], $res_config)){
    	    		$value2['checked'] = "checked = 'checked'";
    	    	}else{
    	    		$value2['checked'] = "";
    	    	}
    	    }
    	    $value['sub'] = $arr;
    	}
    	$arr = [
    		'info' => $res_role->role_name,
    		'arr' => $res
    	];
    	return _success($arr);
    }
}
