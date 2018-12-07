<?php 
namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Com\Common;
use App\Model\Erp\Sys;
use App\Validator\Sys\NodeReq;
use App\Validator\Sys\FlowReq;
use DB;


/*系统设置类*/

class SysController extends Controller
{
	/*添加节点*/

	public function addNode(Request $request){
		$input = $request->all();
		if(!empty($input)){
			$check = NodeReq::checkNode($input);
			if(!empty($check)){
				return $check;
			}
			if($id = Sys::addNode($input)){
				return _success($id);
			}
			return _error();
		}
	}

	/*添加流程*/

	public function addFlow(Request $request){
		$input = $request->all();
		if(!empty($input)){
			$check = FlowReq::checkFlow($input);
			if(!empty($check)){
				return $check;
			}
			if($id = Sys::addFlow($input)){
				return _success($id);
			}
			return _error();
		}
	}

	/*节点列表*/
  
	public function nodeList(Request $request){
		$input = $request->all();
		$data = Sys::getNodeList($input);
		$data['flows'] = Sys::getFlows();
		return view('nodeList',$data);
	}

	/*节点删除*/

	public function nodeDel(Request $request){
		$input = $request->all();
		if(!empty($input)){
			if($id = Sys::nodeDel($input)){
				return _success($id);
			}
			return _error();
		}
	}

	
	/*节点编辑*/

	public function nodeEdit(Request $request){
		$input = $request->all();
		if(!empty($input)){
			if($data = Sys::getNode($input)){
				return _success($data[0]);
			}
			return _error();
		}
	}


	/*节点编辑提交*/
	
	public function nodeEditDode(Request $request){
		$input = $request->all();
		if(!empty($input)){
			$check = NodeReq::checkNode($input);
			if(!empty($check)){
				return $check;
			}
			if($id = Sys::nodeEdit($input)){
				return _success($id);
			}
			return _error();
		}
	}


	/*流程列表*/ 

	public function flowList(Request $request){
		$input = $request->all();
		$data = Sys::getFlowList($input);
		return view('flowList',$data);
	}

	/*流程配置列表*/

	public function flowConfigList(){
		$data['flows'] = Sys::getFlows();
		$data['flowConfigList'] = Sys::getFlowConfig();
		return view('flowConfigList',$data);
	}



	public function ajaxGetNodes(Request $request){
		return  _success(Sys::getNodes());
	}

	

	/*添加流程配置*/

	public function flowConfigAdd(Request $request){
		$input = $request->all();
		if(!empty($input)){
			$input = Sys::flowConfigAdd($input);
			print_r($input);
		}
	}


	/*流程删除*/

	public function flowDel(Request $request){
		$input = $request->all();
		if(!empty($input)){
			if($id = Sys::flowDel($input)){
				return _success($id);
			}
			return _error();
		}
	}


	/*流程编辑*/

	public function flowEdit(Request $request){
		$input = $request->all();
		if(!empty($input)){
			if($data = Sys::getFlow($input)){
				return _success($data[0]);
			}
			return _error();
		}
	}


	/*流程编辑提交*/
	
	public function flowEditDone(Request $request){
		$input = $request->all();
		if(!empty($input)){
			$check = FlowReq::checkFlow($input);
			if(!empty($check)){
				return $check;
			}
			if($id = Sys::flowEdit($input)){
				return _success($id);
			}
			return _error();
		}
	}







}