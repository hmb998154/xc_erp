<?php
namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Controllers\Com\Common;

/**
 * 用户登录首页
 */
class IndexController extends Controller
{
    private $data  = null;
   

    public function __construct()
    {
        $res = Common::getRole();
        if($res == "/"){
            $idnex = "home";
        }else{
            $arr = explode("/", $res);
            $index = $arr['2'];
        }
        $this->data = $index;
    }
    
    /**
     * 首页
     * @return [type] [description]
     */
    public function index()
    {   
    	$data = [
    		'index'=>$this->data,
    	];
    	return view("index",$data);
    }

    /**
     * 供应商
     * @return [type] [description]
     */
    public function supplier()
    {   
        $data = [
            'index'=>$this->data,
        ];
        return view("index",$data);
    }

    

    /**
     * 销售员
     * @return [type] [description]
     */
    public function saleList()
    {   
        $data = [
            'index'=> $this->data
        ];
        return view("index",$data);
    }

    /**
     * 默认首页
     * @return [type] [description]
     */
    public function defaults()
    {   
        $data = [
            'index'=>$this->data,
        ];
        return view("index",$data);
    }
    
    public function login()
    {
        return view('login');
    }

    /**
     * 财务
     * @return [type] [description]
     */
    public function finalList()
    {
        $data = [
            'index'=>$this->data,
        ];
        return view("index",$data);
    }
}
