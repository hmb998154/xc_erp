<?php 
namespace app\Http\Controllers\Task 

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Com\Common;
use App\Model\Erp\Sys;
use DB;

/*待办事项类*/

class PendingWorkController extends Controller
{
	/*待办列表*/

	public function pendingWorkList(Request $request){
		return view('pendingWorkList');
	}
}