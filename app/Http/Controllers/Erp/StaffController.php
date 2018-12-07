<?php

namespace App\Http\Controllers\Erp;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Libs\Captch\Captch;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\Logging\Log;
use App\Model\Erp\Staff;
use App\Model\Erp\Menu;
use App\Validator\Erp\StaffReq;
use App\Http\Requests\Erp\StaffUser;
use App\Http\Controllers\Com\Common;

use App\Http\Requests\Erp\StaffAddReq;
use App\Http\Requests\Erp\StaffDelReq;
use App\Http\Requests\Erp\StaffChangeReq;
use App\Http\Requests\Erp\StaffEditReq;

class StaffController extends Controller
{
    /**
     * 个人信息
     * @return [type] [description]
     */
    public function adminInfo()
    {
        $res = Staff::findSingle();
        return view("Erp.adminInfo",$res);
    }

    
    /**
     * 添加账户
     * @param  StaffReq $obj 请求对象   
     * @return [type]        [description]
     */
    public function userAdd(StaffAddReq $req)
    {
    	return  Staff::addUser($req);
    }
    

    /**
     * 删除账户
     * @param  Staff  $obj [description]
     * @return [type]      [description]
     */
    public function userDel(StaffDelReq $req)
    {
        // $staff_id = Input::get('staff_id');
        return  Staff::userDel($req->staff_id);
        // return  Staff::userDel($req->get('staff_id'));
    }

    /**
     * 修改
     */
    public function userEdit(StaffEditReq $req)
    {
        $staff = new Staff();
        return $staff->editUser($req);
    }

    /**
     * 用户列表
     * @return [type] [description]
     */
    public function userList()
    {
        $arr = Input::get('arr');
        if(!empty($arr)){
            $arr = json_decode($arr,true);
        }

        if(Input::get('create_time')){
            $arr['create_time'] = Input::get('create_time');
        }
        if(Input::get('search')){
            $arr['search'] = Input::get('search');
        }
        $res = Staff::selectUser($arr);
        return view('Erp.userList',$res);
    }


    /**
     * 获取用户信息
     * @return [type] [description]
     */
    public function findUserInfo(Request $req)
    {
        return Staff::findUserInfo($req->get('staff_id'));
    }

    /**
     * 修改用户信息
     * @return [type] [description]
     */
    public function changeUserInfo()
    {
        $arr = Input::get('data');
        return  Staff::changeInfo($arr);
    }

    /**
     * 修改密码
     * @return [type] [description]
     */
    public function changePass(StaffChangeReq $req)
    {
        return  Staff::changePwd($req);
    }

    /**
     * 获取角色
     * @return [type] [description]
     */
    public function getRoleList()
    {
        $all = Input::all();
        $res =  Role::getRoleList($all);
    }

    /**
     * 重置用户密码
     * @return [type] [description]
     */
    public function resetPwd(Request $req)
    {
        return Staff::resetPasswd($req);
    }
}
