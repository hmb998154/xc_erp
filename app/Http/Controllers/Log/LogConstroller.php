<?php

namespace App\Http\Controllers\Log;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Controllers\Com\Common;
use App\Model\Log\Log;

class LogConstroller extends Controller
{
    /**
     * 显示
     * @return [type] [description]
     */
    public function loginList(Request $req)
    {   
        $res =  Log::listInfo($req);
        return view("Log.loginList",$res);
    }

    /**
     * 删除
     * @param Request $req [description]
     */
    public function LogDel(Request $req)
    {
        return Log::DelLog($req);
    }
}
