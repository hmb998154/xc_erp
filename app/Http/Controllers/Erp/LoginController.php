<?php

namespace App\Http\Controllers\Erp;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Libs\Captch\Captch;
use Input;
use Log;
use App\Model\Erp\Staff;
use App\Http\Requests\Erp\StaffRq;
use Session;
use App\Validator\Erp\LoginReq;
use Storage;
// use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    public function shopIn()
    {
        return view("Login.shopIn");
    }
    /**
     * 显示页面
     * @return [type] [description]
     */
    public function login()
    {
        return view("Login.login");
    }

    /**
     * 用户登录
     * @param  Request $request [description]
     * @return [type]           [description]
     */ 
    public function in(Request $request)
    {
        $arr = $request->get('arr');
        $res =  LoginReq::check($arr);

        if(!empty($res)){
         return $res;
        }
        $staff = new Staff();
        return  $staff->inserSession($arr);
    }

    /**
     * 注销
     * @return [type] [description]
     */
    public function out()
    {
        session()->put('captcha','');
        session()->put('staff_id','');
        return redirect("/erp/login");
    }

    /**
     * 获取验证码
     * @return [type] [description]
     */
    public function getVerifyCode()
    {
        return Captch::demo();
    }
}
