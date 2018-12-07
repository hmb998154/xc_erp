<?php

namespace App\Model\Erp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Com\Common;
use DB;
use App\Model\Erp\Menu;
use App\Model\Erp\RoleMenu;

class Role extends Model
{
    protected $table = 'erp_role';
    protected $primaryKey = 'role_id';
    public $timestamps = false;

    /**
     * 获取信息
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public static function infoList($staff_id = "")
    {
        $where = ['is_delete' => "no"];
        $res_role = Role::where($where)->select(['role_name','role_id'])->get();
        $role = collect($res_role)->toArray();
        $new_role_id = StaffRole::where("staff_id",$staff_id)->select("role_id")->first();
        if(!empty($new_role_id)){
            foreach ($role as  &$value) {
                if($value['role_id'] == $new_role_id->role_id){
                    $value['select'] = "selected = 'selected'";
                }else{
                    $value['select'] = "";
                }
            }
        }
        return _success($role);
    }

    /**
     *  配置角色信息
     * @param  [type] $arr [description]
     * @return [JSON]      [description]
     */
    public static function configInfo($arr)
    {
        try {
            DB::beginTransaction();
            $new_role = [
                'create_at'     => date("Y-m-d H:i:s",time()),
                'role_name'     => $arr['role_name']
            ];
            $id = self::insertGetId($new_role);
            $new_arr = [
                'role_id' => $id,
                'menu_id' => $arr['menu_id'],
            ];
            RoleMenu::insert($new_arr);
            DB::commit();
            return _success();
        } catch (Exception $e) {
            DB::rollBack();
            return _error($e->getMessage());
        }
    }

    /**
     *  用户角色列表
     * @param  string $arr [参数]
     * @return [ARR]      [description]
     */
    public static function getRoleList($arr = "")
    {
        $where = ["no","yes"];
        $res = self::whereIn("is_delete",$where)->orderBy("role_id","desc");
        if(!empty($arr['search'])){
            $res = $res->where('role_name',$arr['search']);
        }

        if(!empty($arr['create_time'])){
            $arr_time = change_time($arr['create_time']);
            $res = $res->whereBetween('create_at',$arr_time);
        }
    	$res = $res->paginate(config('common.page'));
        $sum = $res->count();

        // 获取菜单
        $config_menu = config('menu_config.default');
        $menus =  Menu::getMenuInfo(1);
        // 修改默认权限
        foreach ($menus['info'] as &$value) {
            $value['check'] = "";
            if(empty($value['subs'])){
                if(in_array($value['menu_id'] , $config_menu)){
                    $value['check'] = "checked:checked";
                }
            }else{
                foreach ($value['subs'] as &$value2) {
                    $value2['check'] = "";
                    if(in_array($value2['menu_id'] , $config_menu)){
                        $value2['check'] = "checked:checked";
                    }
                }
            }
        }
        $arr = [
            'info' => $res,
            'sum' => $sum,
            'menus' => $menus,
        ];
    	return  $arr;
    }

    /**
     *  添加角色
     * @param string $arr [description]
     */
    public static  function  addRole($arr = '')
    {
        try {
            DB::beginTransaction();
            $check = self::where($arr)->count();
            if(!empty($check)){
                return _error(1011,config('errors.1011'));
            }
            $arr['create_time'] = date("Y-m-d Hi:i:s",time());
            return _error($arr);
            $res = self::insert($arr);
            DB::commit();
            return  _success($res);
        } catch (Exception $e) {
            DB::rollBack();
            return  _error(2000,$e);
        }
    }

    /**
     *  编辑角色
     * @param  string $arr [description]
     * @return [type]      [description]
     */
    public static  function editRole($arr = '')
    {
        try {
            DB::beginTransaction();
            if(!empty($arr->is_delete)){
                self::where("role_id",$arr->role_id)->update(['is_delete'=>$arr->is_delete]);
            }else{ 
                $role_id = $arr->role_id;
                $menu_id = $arr->menu_id;
                $arr_role = [
                    'role_name' => $arr->role_name
                ];
                $res = self::where('role_id',$role_id)->update($arr_role);
                $res_count = RoleMenu::where("role_id",$role_id)->count();
                if(!empty($res_count)){
                    RoleMenu::where("role_id",$role_id)->update(['menu_id' => $arr->menu_id]);
                }else{
                    $arr_role = [
                        'role_id' => $role_id,
                        'menu_id' => $menu_id,
                    ];
                    RoleMenu::insert($arr_role);
                }
            }
            DB::commit();
            return  _success();
        } catch (Exception $e) {
            DB::rollBack();
            return  _error(2000,$e);
        }
    }

    /**
     * 删除角色
     */
    public static  function delRole($role_id)
    {
        try {
            DB::beginTransaction();
            $check = self::where('role_id',$role_id)->delete();
            DB::commit();
            return  _success();
        } catch (Exception $e) {
            DB::rollBack();
            return  _error(2000,$e->getMessage());
        }
    }

    /**
     * 查询角色信息
     */
    public static function findRole($role_id)
    {
        $res = self::where('role_id',$role_id)->first();
        $res = collect($res)->toArray();
        return  _success($res);
    }
}
