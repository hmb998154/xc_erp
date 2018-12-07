@extends('index')
@section('content')
<script src="/assets/layer/layui/layui.js" type="text/javascript" ></script>
<link rel="stylesheet" href="/assets/layer/layui/css/layui.css"  media="all">
<div class="layui container">
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
			    <th>id</th>
			    <th>条形码</th>
			    <th>操作</th>
			  </tr> 
			</thead>
			<tbody id="tbodys">
			  <tr>
			    <td>1</td>
			    <td><input type="text" name="pro_code" class="code" id="code" onblur="getProductDetail()" /></td>
			    <td>
			    	<a class="layui-btn    layui-btn-sm" href="javascript:;" onclick="focusNextInput()" lay-event="del"><i class="layui-icon"></i></a>
			    	<a class="layui-btn   layui-btn-sm" href="javascript:;" onclick="code_del(this,1)" lay-event="del">删除</a>
			    </td>
			  </tr>
			</tbody>
		</table>
		 <div class="layui-form-item" style="text-align: center;padding-top: 50px;">
		    <div class="layui-input-block">
		      <button class="layui-btn layui-btn-primary " lay-submit="" lay-filter="demo1">立即提交</button>
		      <!-- <button type="reset" class="layui-btn layui-btn-primary">重置</button> -->
		    </div>
		 </div>
	</div>
</div>

	
</body>
</html>

<script>
	layui.use(['form', 'layedit', 'laydate'], function(){
		  var form = layui.form
		  ,layer = layui.layer
		  ,layedit = layui.layedit
		  ,laydate = layui.laydate;
		    //监听提交
		  form.on('submit(demo1)', function(data){
		    inputs = $("input[name='pro_code']");
		    // console.log(inputs);
			$.each( inputs, function(i, n){
			   alert($(inputs[i]).val());
			});
		    return false;
		  });
	});

</script>

<script>
	/**
	 * [keyDown 检测扫码按键]
	 *
	 * @param  {[type]} e [description]
	 * @return {[type]}   [description]
	 */
	function keyDown(e){
		//IE内核浏览器
		 if (navigator.appName == 'Microsoft Internet Explorer'){
	           var keycode = event.keyCode;
	           var realkey = String.fromCharCode(event.keyCode);
	     }else {//非IE内核浏览器
	           var keycode = e.which;
	           var realkey = String.fromCharCode(e.which);
	     }
       // console.log('按键码:' + keycode +  '字符: ' + realkey);
       //监听enter键
       if(keycode==13){
       		focusNextInput();
       }
	} 
	document.onkeydown=keyDown;

	/**
	 * [focusNextInput 光标下移]
	 *
	 * @param  {[type]} thisInput [description]
	 * @return {[type]}           [description]
	 */
	function focusNextInput(){ 
		$("input").removeClass("cur_input");
   		var html = addNewGoodLine();
   		$("#tbodys").append(html);
		$(".cur_input").focus();
		var id = $(".cur_input").parent('td').parent('tr').prev('tr').children('td').eq(0).text();
		console.log(id);
		id = Number(id)+1;
		$(".cur_input").parent().prev('td').text(id);
	} 




	/**
	 * [addNewGoodLine 添加一行]
	 */
	function addNewGoodLine(){
		var html  = '<tr class="new_products">';
			html += '<td></td>';
			html += '<td>';
			html += '<input type="text" name="pro_code" class="code cur_input" onblur="getProductDetail()" />';
			html += '</td>';
			html += '<td><a class="layui-btn  layui-btn-sm" href="javascript:;" onclick="focusNextInput()" lay-event="del"><i class="layui-icon"></i></a><a class="layui-btn  layui-btn-sm" lay-event="del"  href="javascript:;" onclick="code_del(this,1)">删除</a></td>'
			html += '</tr>';
			return html;
	}

	/**
	 * [code_del 删除一行]
	 *
	 * @param  {[type]} obj [description]
	 * @param  {[type]} id  [description]
	 * @return {[type]}     [description]
	 */
	function code_del(obj,id){

		$(obj).parent().parent('tr').remove();
	    // layer.close(index);
	    /*layer.confirm('确认要删除这行吗？',{icon: 2, title:'提示'},function(index){
	        // 调用函数
	        var res = ajax_req('/sys/nodeDel',{'node_id':id});
	        if(res.status != 200){
	          layer.alert('删除失败',{title: '提示框', icon:2}); exit;
	        }else{
	            $(obj).parents("tr").remove();
	            layer.alert('删除成功',{title: '提示框',icon:1,},function(index){
	                layer.close(index);
	            });
	        }
	    });*/
	}

	 

	function getProductDetail(){
		//获取商品的详细信息，然后赋值
		
	}


	

</script>
@endsection('content')