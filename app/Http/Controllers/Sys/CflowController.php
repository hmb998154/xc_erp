<?php 
namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Com\Common;
use App\Model\Erp\Sys;
use App\Model\Erp\Cflow as cflowModel;
use App\Validator\Sys\CflowReq;
use DB;

/*流程配置类*/

class CflowController extends Controller
{
	/*流程配置列表*/

	public function flowConfigList(Request $request){
		$input = $request->all();
		$flows = Sys::getFlows();
		$nodes = Sys::getNodes();
		$roles = Sys::getRoles();
		$cflows = cflowModel::getFlowConfigList($input);
		$data = [
			'flows' => $flows,
			'nodes' => $nodes,
			'roles' => $roles,
			'count' => $cflows['count'],
			'pages' => $cflows['pages'],
			'cflows' => $cflows['cflows']
		];
		return view('flowConfigList',$data);
	}

	/*添加流程配置*/

	public function addFlowConfig(Request $request){
		$input = $request->all();
		if(!empty($input)){
			$check = CflowReq::checkFlow($input);
			if(!empty($check)){
				return $check;
			}
			if($id = cflowModel::addFlowConfig($input)){
				return _success($id);
			}
			return _error();
		}
	}

	/*删除流程配置*/

	public function flowConfigDel(Request $request){
		$input = $request->all();
		if(!empty($input)){
			if($id = cflowModel::flowConfigDel($input)){
				return _success($id);
			}
			return _error();
		}
	}

	/*编辑流程配置*/

	public function flowConfigEdit(Request $request){
		$input = $request->all();
		if(!empty($input)){
			if($data = cflowModel::getFlowConfig($input)){
				return _success($data);
			}
			return _error();
		}
	}


	/*编辑提交*/
	
	public function flowConfigEditDone(Request $request){
		$input = $request->all();
		if(!empty($input)){
			$check = CflowReq::checkFlowEdit($input);
			if(!empty($check)){
				return $check;
			}
			return cflowModel::flowConfigEdit($input);
		}
	}

}