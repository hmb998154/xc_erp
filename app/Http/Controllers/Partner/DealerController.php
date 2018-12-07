<?php

namespace App\Http\Controllers\Partner;
 
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use App\Http\Controllers\Com\Common;
use App\Model\Partner\Dealer;
use Illuminate\Support\Facades\Input;

/**
 *  经销商
 */
class DealerController extends Controller
{       
    /**
     *  
     * @return [type] [description]
     */
    public function dealerList(Request $req)
    {
        $dealer = new Dealer();
        $res = $dealer->getList($req);
        return view("dealerList");
    }


    /**
     *经销商入驻
     * @param  Request $req [description]
     * @return [type]       [description]
     */
    public function shopAddInfo(Request $req)
    {
        $dealer = new Dealer();
        $res =  $dealer->addInfo($req);
        if($res['status'] != 200){
            return view("shopin",['error' => $res['msg']]);
        }else{
            return redirect("/");
        }
    }
}
