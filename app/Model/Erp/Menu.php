<?php
namespace App\Model\Erp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Com\Common;
use DB;
use App\Model\Erp\StaffRole;

class Menu extends Model
{
    protected $table = 'erp_menu';
    public $timestamps = false;

    /**
     * 获取用户菜单列表
     * @return [type] [description]
     */
    public static function getRoleMenuInfo()
    {
        $staff_id = _get_staff_id();
        $where = [
            'is_delete' => 'no',
            // 'par_id' => 0,
            'is_menu' => "yes",
        ];

        $res = StaffRole::where("staff_id",$staff_id)
                ->leftJoin("erp_role_menu","erp_staff_role.role_id","=","erp_role_menu.role_id")
                
                ->select(['erp_role_menu.menu_id'])
                ->first();
        $arrs = [];
        if(!empty($res->menu_id)){
            $arr_menu = explode(",", $res->menu_id);
            $res_menu = Menu::whereIn("menu_id",$arr_menu)->where($where)->orderBy("row_sort","asc")->get();
            $res_menu = collect($res_menu)->toArray();

            foreach ($res_menu as  $value) {
                // if($value['par_id'] == 0){
                if($value['par_id'] == 0){
                    $arrs[] = $value;
                }
            }
        }
        foreach ($arrs as  &$value) {
            $value['sub'] = "";
            foreach ($res_menu as $value2) {
                if($value['menu_id'] == $value2['par_id']){
                    $value['sub'][] = $value2;
                }else{
                    // $value['sub'] = "";
                }
            }
        }
        return $arrs;
    }

    /**
     * 获取单个信息
     * @param  string $menu_id [description]
     * @return json          [description]
     */
    public static function findSingleInfo($menu_id='')
    {
        $select = [
            'menu_id',
            'menu_name',
            'icon',
            'is_menu',
            'row_sort',
            'url',
            'par_id',
        ];
        $res = self::where("menu_id",$menu_id)->select($select)->first();
        $res = collect($res)->toArray();
        return  _success($res);
    }

    /**
     * 获取用户菜单
     * @param  string $staff_id [用户id]
     * @return [type]           [description]
     */
    public static function getSessionBar($staff_id = "")
    {
    }

    /**
     * 获取菜单信息
     * @param  string $arr [description]
     * @return arr      [description]
     */
    public static function getMenuInfo($type = "")
    {
        
    	// $res =  self::where("id_delete","no")->get();
        $where = ['is_delete' => 'no','par_id' => 0];
        if(empty($type)){
            $where['is_menu'] = "yes";
        }

        $res = self::where($where)->orderBy("menu_id","asc")->get();
        $res = collect($res)->toArray();
        $par_arr = $res;
        foreach ($res as &$value) {
            $where = ['is_delete' => 'no','par_id' => $value['menu_id']];
            if(empty($type)){
                $where['is_menu'] = "yes";
            }

            $arr = self::where($where)->get();
            $arr = collect($arr)->toArray();
            $value['sub'] = $arr;
        }

        $arr = [
            'info' => $res,
            'par' => $par_arr,
        ];
    	return $arr;
    }

    /**
     * 获取菜单层级列表
     * @return [type] [description]
     */
    public static function getInfoList()
    {
        $where = [
            'is_delete' => 'no',
            'par_id' => 0,
        ];

        $par_info = self::where($where)->get();
        $par_info = collect($par_info)->toArray();
        return $par_info;
    }

    /**
     * 获取菜单所有列表
     * @param  string $arr [参数集合]
     * @return [arr]      [description]
     */
    public static function getAllMenusInfo($arr = "")
    {
        $res = self::whereIn("is_delete",['no','yes'])->orderBy("menu_id","desc");
        if(!empty($arr['par_id'])){
           $res = $res->where('par_id',$arr['par_id']);
        }

        if(!empty($arr['search'])){
           $res = $res->where('menu_name',"like","%".$arr['search']."%")->orWhere('url',"like","%".$arr['search']."%");

        }

        if(!empty($arr['par_id_select'])){
           $res = $res->where("par_id",$arr['par_id_select']);

        }

        $sum = $res->count();
        $res = $res->paginate(config('common.page'));
        
        $par_info = self::getInfoList();
        
        // $res = collect($res)->toArray();
        $arr = [
            'info' => $res,
            'sum' => $sum,
            'par_info' => $par_info,
        ];
        return $arr;
    }


    /**
     * 添加角色
     * @param string $arr [description]
     */
    public static  function addMenu($req = '')
    {
        try {
            DB::beginTransaction();
            $res_data = [
                'menu_name' => $req->menu_name,
                'url' => $req->url,
            ];
            $check = self::where($res_data)->count();
            if(!empty($check)){
                return _error(1011,config('errors.1011'));
            }
            $res_data['par_id'] = $req->par_id ? $req->par_id : 0;
            $res_data['create_time'] = date("Y-m-d H:i:s");
            $res_data['row_sort'] = $req->row_sort;
            $res_data['icon'] = $req->icon;
            $res = self::insert($res_data);
            DB::commit();
            return  _success($res);
        } catch (Exception $e) {
            DB::rollBack();
            return  _error(2000,$e->getMessage());
        }
    }

    /**
     *  编辑角色
     * @param  string $arr [参数]
     * @return [json]      [description]
     */
    public static  function editMenu($arr = '')
    {
        $menu_id = $arr->menu_id;
        try {
            DB::beginTransaction();
            if(!empty($arr->is_delete)){
                $is_delete = change_status($arr->is_delete);
                
                self::where('menu_id',$arr->menu_id)->update(['is_delete' => $arr->is_delete]);
            }else{
                
                $arr_change = [
                    'menu_name' => $arr->menu_name,
                    'icon'      => $arr->icon,
                    'url'       => $arr->url,
                    'par_id'    => $arr->par_id,
                    'is_menu'   => $arr->is_menu,
                    'row_sort'  => $arr->row_sort,
                ];
                $check = self::where('menu_id',$menu_id)->update($arr_change);
            }
            DB::commit();
            return  _success();
        } catch (Exception $e) {
            DB::rollBack();
            return  _error(2000,$e->getMessage());
        }
    }

    /**
     *  删除角色
     * @param  [type] $req [参数]
     * @return [json]          [description]
     */
    public static  function delMenu($req)
    {
        try {
            DB::beginTransaction();
            $check = self::where('menu_id',$req->menu_id)->delete();
            DB::commit();
            return  _success();
        } catch (Exception $e) {
            DB::rollBack();
            return  _error(2000,$e->getMessage());
        }
    }

    /**
     *  查询菜单信息
     * @param  [type] $menu_id [菜单编号ID]
     * @return [json]          [description]
     */
    public static function findMenu($menu_id)
    {
        $res = self::where('menu_id',$menu_id)->find();
        return  _success($res);
    }
}
