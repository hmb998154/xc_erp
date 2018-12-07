<?php

namespace App\Http\Controllers\Erp;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Com\Common;
use App\Model\Erp\Menu;
use App\Model\Erp\RoleMenu;
use App\Http\Requests\Erp\MenuReqDel;
use App\Http\Requests\Erp\MenuReqAdd;

class MenuController extends Controller
{   

    public function checkAuth(Request $req)
    {
        $url = $req->get('url');
        return Common::checkAuthority($url);
    }

    /**
    *获取 侧边 菜单信息
     * @return [type] [description]
     */
    public function getRoleMenuList()
    {
        $res =  Menu::getRoleMenuInfo();
        return _success($res);
    }

    /**
     * 获取菜单
     * @return [type] [description]
     */
    public function getMenuList()
    {
        $all = Input::all();
        $res =  Menu::getMenuInfo($all);
        return view('Erp.menuList',$res);
    }

    /**
     * 查询菜单信息
     * @return [type] [description]
     */
    public function findMenuInfo()
    {
        $id = Input::get("data");
        return Menu::findSingleInfo($id);
    }


    /**
     * 获取角色菜单信息
     * @return [type] [description]
     */
    public function menusRoleInfo()
    {
        $role_id = Input::get("data");
        return RoleMenu::getInfo($role_id);
    }

    /**
     * 获取侧边栏
     * @return [type] [description]
     */
    public function getSideList()
    {
        $res =  Menu::getMenuInfo();
        return _success($res);
    }

    /**
     * 获取菜单信息列表
     * @return [type] [description]
     */
    public function getMenuAllList()
    {
        $all = Input::all();
        $res =  Menu::getAllMenusInfo($all);
        return view('Erp.menuAllList',$res);
    }

    /**
     * 添加菜单
     * @return [type] [description]
     */
    public function menuAdd(MenuReqAdd $req)
    {

        // $arr = Input::get('data');
        return Menu::addMenu($req);
    }


    /**
     * 添加列表
     * @return [type] [description]
     */
    public function menuAddList()
    {
        $all = Input::all();
        $res =  Menu::getMenuInfo($all);
        return view('Erp.menuAddList',$res);
    }

    /**
     * 查询菜单
     * @return [type] [description]
     */
    public function menuFind()
    {
    	return  Menu::findMenu(Input::get('id'));
    }

    /**
     * 编辑菜单
     * @return [type] [description]
     */
    public function menuEdit(Request $req)
    {
    	return  Menu::editMenu($req);
    }

    /**
     * 删除菜单
     * @return [type] [description]
     */
    public function menuDel(MenuReqDel $req)
    {
    	return  Menu::delMenu($req);
    }
}
