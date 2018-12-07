@extends('index')
@section('content')
<script src="/assets/layer/layui/layui.js" type="text/javascript" ></script>
<link rel="stylesheet" href="/assets/layer/layui/css/layui.css"  media="all">
<style>
    .layui-form-label{min-width: 86px;}
    #formId{font-size: 12px;}
    /*.layui-input-inline{min-width: 160px;}*/
    .layui-containers{margin-left: 25px;}
</style>
<blockquote class="layui-elem-quote layui-text" style="margin-bottom: 30px;">
 发起销售订单
</blockquote>
<div class="layui-container" >
	<form class="layui-form" action="" >
		<div class="layui-form">
			<table class="layui-table" lay-filter="test">
				<colgroup>
				  <col width="150">
				  <col width="150">
				  <col width="200">
				  <col>
				</colgroup>
				<thead>
					  <tr>
					  	<td></td>
					    <td>商品名称</td>
					    <td>商品数量</td>
					    <td>商品价格</td>
					    <td>商品运费</td>
					  </tr> 
				</thead>
				<tbody id="tbodys">
					@foreach($product as $lists)
						<tr style="background: #F9F9F9;">
							<td>供应商名称</td>
						    <td colspan="4">{{$lists['factory_name']}}</td>
						</tr>
						@foreach($lists['info'] as $list )
						<tr>
						  <td></td>
						  <td>{{$list['product_name']}}</td>
						  <td>{{$list['product_num']}}</td>
						  <td>{{$list['product_price']}}</td>
						  <td></td>
						</tr>
						@endforeach
						<tr>
						  	<td colspan="4"></td>
							<td ><input class="product_fee" type="text" name="fee"  lay-verify="required|number"  supplier_id="{{$lists['factory_id']}}"  class="code" /></td>
						</tr>
					@endforeach
				</tbody>
			</table>
			 <div class="layui-form-item" style="text-align: center;padding-top: 50px;">
			    <div class="layui-input-block">
			    	<input type="hidden" id="_token" value="{{$_token}}">
			      	<button class="layui-btn " lay-submit="" lay-filter="next_done">确定</button>
			      	<button type="reset" onclick="return_last();" class="layui-btn layui-btn-primary">取消</button>
			    </div>
			 </div>
		</div>
	</form>


    
</div>
<script type="text/javascript">
layui.use(['form', 'layedit', 'laydate','table'], function(){
    var form = layui.form
    ,layer = layui.layer
    ,layedit = layui.layedit
    ,laydate = layui.laydate
    ,table = layui.table;

 	form.on('submit(next_done)', function(data){      
		var query = {};
		query.info ={};
		var url = "{{route('order.create')}}";
		$(".product_fee").each(function(i){
			var fee = $(this).val();
			var supplier_id = $(this).attr("supplier_id");
			query.info[i]= {'fee':fee,'supplier_id':supplier_id};
		});
		query.token = $("#_token").val();
		// console.log(query);
        var res = ajax_req(url,query,type = "post",async= true, is_check= "no");
        if(res.status ==200){
            layer.alert(res.msg,{title: '提示框',icon:1,},function(){
                location.href="{{route('order.list')}}";
            });
         }else{
            layer.alert(res.msg);
         }
        return false;
    });
    window.return_last = function(){
        location.href = "{{route('order.list')}}"
    }


});

</script>
</body>

</html>


@endsection('content')
