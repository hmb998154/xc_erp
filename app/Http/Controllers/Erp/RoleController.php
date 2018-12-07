<?php

namespace App\Http\Controllers\Erp;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Com\Common;
use App\Model\Erp\Role;
use App\Http\Requests\Erp\RoleDelReq;

class RoleController extends Controller
{
    /** 
     * 获取角色
     * @return [type] [description]
     */
    public function getRoleList(Request $req)
    {
        $all = Input::all();
        $res =  Role::getRoleList($all);
        return view('Erp.roleList',$res);
    }

    /**
     * 获取角色列表信息
     * @return [type] [description]
     */
    public function getStaffRoleList()
    {

        return Role::infoList(Input::get("data"));
    }

    /**
     * 角色权限配置
     * @return [type] [description]
     */
    public function roleConfig()
    {
        $arr = Input::all();
        $arr = $arr['data'];
        return Role::configInfo($arr);
    }

    /**
     * 添加角色
     * @return [type] [description]
     */
    public function roleAdd()
    {
        $role_name = Input::get('data');
        return  Role::addRole($role_name);
    }

    /**
     * 查询角色
     * @return [type] [description]
     */
    public function roleFind()
    {
    	return  Role::findRole(Input::get('data'));
    }

    /**
     * 编辑角色
     * @return [type] [description]
     */
    public function roleEdit(Request $req)
    {
    	return  Role::editRole($req);
    }
    

    /**
     * 删除角色
     * @return [type] [description]
     */
    public function roleDel(RoleDelReq $req)
    {
    	return  Role::delRole($req->role_id);
    }
}
