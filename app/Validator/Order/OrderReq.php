<?php 
namespace App\Validator\Order;
use Validator;

/*订单验证类*/

class OrderReq
{	
	/*检测订单添加*/
	
	public static function checkOrderAdd($arr)
	{
		if(empty($arr)){
			return _error(2000,"参数不能为空");
		}
		$rules = [
			'flow_id' => 'required',
			'supplier' => 'required',
			'product_name' => 'required',
			'pro_num' => 'required|integer|min:1',
			'pro_price' => 'required|numeric|min:0.01',
		];
	    $message = [
	    	"flow_id.required" => "请选择流程",
	    	"supplier.required" => "请选择供应商",
	    	"product_name.required" => "请选择商品",
	    	"pro_num.required" =>"商品数量不能为空",
	    	"pro_num.integer" => "商品数量只能是整数",
	    	"pro_num.min" => "商品数量不能小于１",
	    	"pro_price.required" => "商品价格不能为空",
	    	"pro_price.numeric" => "商品价格只能是数字",
	    	"pro_price.min" => "商品价格不能小于0.01",
	    ];
	    $validator = Validator::make($arr,$rules,$message);
	    if ($validator->fails()) {
	    	  $res = $validator->messages();
	    	  return  _error(2000, $res->first());
	    }
	}

	
}
