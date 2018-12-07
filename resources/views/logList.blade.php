@extends('index')
@section('content')

<script src="/assets/js/typeahead-bs2.min.js"></script>
<!-- page specific plugin scripts -->
<script src="/assets/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/jquery.dataTables.bootstrap.js"></script>

<!-- <script type="text/javascript" src="js/H-ui.js"></script>  -->
<!-- <script type="text/javascript" src="/js/H-ui.admin.js"></script>  -->

<script src="/assets/layer/layer.js" type="text/javascript" ></script>
<script src="/assets/laydate/laydate.js" type="text/javascript"></script>

<div class="page-content clearfix">
    <div id="Member_Ratings">
      <div class="d_Confirm_Order_style">
    <div class="search_style">
     	<form action="/erp/userList" method="get">
      <ul class="search_content clearfix">
       <li><label class="l_f">会员名称</label><input name="search" type="text"  class="text_add" placeholder="输入用户名称、电话"  style=" width:400px"/></li>
       <li><label class="l_f">添加时间</label><input name="create_time" class="inline laydate-icon" id="start" style=" margin-left:10px;"></li>
       <li style="width:90px;"><button type="submit" class="btn_search"><i class="icon-search"></i>查询</button></li>
      </ul>
     	</form>
    </div>
     <!---->
     <div class="border clearfix">
       <span class="l_f">
        <a href="javascript:ovid()" id="member_add" class="btn btn-warning"><i class="icon-plus"></i>添加用户</a>
        <!-- <a href="javascript:ovid()" class="btn btn-danger"><i class="icon-trash"></i>批量删除</a> -->
       </span>
       <span class="r_f">共：<b>{{ $sum }}</b>条</span>
     </div>
     <!---->
     <div class="table_menu_list">
       <table class="table table-striped table-bordered table-hover" id="sample-table">
		<thead>
		 <tr>

				<!-- <th width="25"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th> -->
				<th width="80">ID</th>
				<th width="100">用户名</th>
				<th width="120">手机</th>
				<th width="150">角色</th>
				<th width="180">加入时间</th>
                <th width="100">公司名称</th>
				<th width="200">公司地址</th>
				<th width="70">状态</th>                
				<th width="250">操作</th>
			</tr>
		</thead>
	<tbody>
		@foreach($info as $user)
		<tr>
          <!-- <td><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td> -->
          <td title="{{$user->staff_id}}" class="staff_id">{{$user->staff_id}}</td>
          <td><u style="cursor:pointer" class="text-primary" onclick="member_show('张三','member-show.html','10001','500','400')">{{$user->staff_name}}</u></td>
          <td>{{$user->staff_phone}}</td>
          <td>{{$user->role_name}}</td>
          <td>{{$user->create_time}}</td>
          <td>{{$user->company_name}}</td>
          <td>{{$user->company_address}}</td>
          <td class="td-status">
          	@if($user->is_delete == "yes")
          	<span class="label label-default radius">
          	@else
          	<span class="label label-success radius">
          	@endif
          		{{change_status($user->is_delete)}}
          	</span>
          </td>
          <td class="td-manage">
          	@if($user->is_delete == "no")
          	<a onclick="member_stop(this,'10001')" href="javascript:;" title="停用" class="btn btn-xs  btn-success is_delete"><i class="icon-ok bigger-120"></i></a>
          	@else
          	<a style="text-decoration:none" class="btn btn-xs   is_delete" onclick="member_start(this,id)" href="javascript:;" title="启用" ><i class="icon-ok bigger-120"></i></a>
          	@endif
          <!-- <a onClick="member_stop(this,'10001')"  href="javascript:;" title="停用"  class="btn btn-xs btn-success"><i class="icon-ok bigger-120"></i></a>  -->
          <a title="编辑" onclick="member_edit2('{{$user->staff_id}}')" href="javascript:;"  class="btn btn-xs  btn-info" ><i class="icon-edit bigger-120"></i></a> 
          <a title="删除" href="javascript:;"  onclick="member_del(this,'1')" class="btn btn-xs  btn-warning" ><i class="icon-trash  bigger-120"></i></a>
          </td>
		</tr>
		@endforeach
      </tbody>
	</table>
	{!! $info->links() !!}
   </div>
  </div>
 </div>
</div>
<!--添加用户图层-->
<div class="add_menber" id="add_menber_style" style="display:none">
  
    <ul class=" page-content">
     <li><label class="label_name">用&nbsp;&nbsp;户 &nbsp;名：</label><span class="add_name"><input value="" name="用户名" id="staff_name" type="text"  class="text_add staff_name"/></span><div class="prompt r_f"></div></li>
     <li><label class="label_name">手机号：</label><span class="add_name"><input value="" name="手机号：" id="staff_phone" type="text"  class="text_add"/></span><div class="prompt r_f"></div></li>
     <li><label class="label_name">密&nbsp;&nbsp;&nbsp;&nbsp;码：</label><span class="add_name"><input name="密码" id="passwd" type="password"  class="text_add"/></span><div class="prompt r_f"></div></li>
     <li><label class="label_name">确认密码：</label><span class="add_name"><input name="密码" type="password"  class="text_add" id="qr_passwd"/></span><div class="prompt r_f"></div></li>
     <!-- <li><label class="label_name">公司地址：</label><span class="add_name"><input value="" name="公司地址：" type="text"  class="text_add"/></span><div class="prompt r_f"></div></li> -->
     <!-- <li><label class="label_name">公司名称：</label><span class="add_name"><input value="" name="公司名称：" type="text"  class="text_add"/></span><div class="prompt r_f"></div></li> -->

     <!-- <li><label class="label_name">移动电话：</label><span class="add_name">
     <label><input name="form-field-radio" type="radio" checked="checked" class="ace"><span class="lbl">男</span></label>&nbsp;&nbsp;&nbsp;
     <label><input name="form-field-radio" type="radio" class="ace"><span class="lbl">女</span></label>&nbsp;&nbsp;&nbsp;
     <label><input name="form-field-radio" type="radio" class="ace"><span class="lbl">保密</span></label>
     </span>
     <div class="prompt r_f"></div>
     </li> -->
     
     <!-- <li class="adderss"><label class="label_name">家庭住址：</label><span class="add_name"><input name="家庭住址" type="text"  class="text_add" style=" width:350px"/></span><div class="prompt r_f"></div>
     </li> -->
    <!--  <li><label class="label_name">状&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;态：</label><span class="add_name">
     <label><input name="form-field-radio1" type="radio" checked="checked" class="ace"><span class="lbl">员工</span></label>&nbsp;&nbsp;&nbsp;
     <label><input name="form-field-radio1"type="radio" class="ace"><span class="lbl">合作商</span></label></span><div class="prompt r_f"></div>
 	</li> -->
    </ul>
 </div>

 <div class="add_menber2" id="add_menber_style2" style="display:none">
  
    <ul class=" page-content">
     <li><label class="label_name">用&nbsp;户&nbsp;名&nbsp;：</label><span class="add_name"><input value="" name="用户名" type="text"  id="edit_staff_name" class="text_add"/></span><div class="prompt r_f"></div></li>
     <li><label class="label_name">手&nbsp;机&nbsp;号&nbsp;：</label><span class="add_name"><input value="" name="手机号" type="text"  class="text_add" id="edit_staff_phone"/></span><div class="prompt r_f"></div></li>
     <li><label class="label_name">公司名称：</label><span class="add_name"><input value="" name="公司名称" type="text"  class="text_add" id="edit_company_name"/></span><div class="prompt r_f" ></div></li>
     <li><label class="label_name">公司地址：</label><span class="add_name"><input value="" name="公司地址" type="text"  class="text_add" id="edit_company_address" /></span><div class="prompt r_f" ></div></li>
    </ul>
 </div>

</body>
</html>
<script>
jQuery(function($) {
				var oTable1 = $('#sample-table').dataTable( {
				"aaSorting": [[ 1, "desc" ]],//默认第几个排序
		"bStateSave": true,//状态保存
		"aoColumnDefs": [
		  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
		  {"orderable":false,"aTargets":[0,8,9]}// 制定列不参与排序
		] } );
				
				
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
			
			
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			})
/*用户-添加*/
 $('#member_add').on('click', function(){


    layer.open({
        type: 1,
        title: '添加用户',
		maxmin: true, 
		shadeClose: true, //点击遮罩关闭层
        area : ['800px' , ''],
        content:$('#add_menber_style'),
		btn:['提交','取消'],
		yes:function(index,layero){	
		 var num=0;
		 var str="";
     $(".add_menber input[type$='text']").each(function(n){
          if($(this).val() == "")
          {
			   layer.alert(str+=""+$(this).attr("name")+"不能为空！\r\n",{
                title: '提示框',				
				icon:0,								
          }); 
		    num++;
            return false;            
          } 
		 });
		  if(num>0){  return false;}	 	
          else{
          	var arr = {};
          	arr['staff_name'] = $("#staff_name").val();
          	arr['staff_phone'] = $("#staff_phone").val();
          	arr['passwd'] = $("#passwd").val();
          	arr['qr_passwd'] = $("#qr_passwd").val();
          	var res_code = get_ajax('/erp/userAdd',arr,"post",false);
          	if(res_code.status == 200){
				layer.alert('添加成功！',{title: '提示框',icon:1,});
				layer.close(index);	
          		window.location.href = window.location.href;
          	}else{
				layer.alert(res_code.msg,{title: '提示框',icon:2});
          	}
		  }		  		     				
		}
    });
});

/*用户-查看*/
function member_show(title,url,id,w,h){
	// console.log($url);
	layer_show(title,url+'#?='+id,w,h);
}

/*用户-停用*/
function member_stop(obj,id){
	var res_text = get_text($(obj),'.is_delete');
	var staff_id = get_user_id($(obj));

	layer.confirm('确认要停用吗？',{icon: 2, title:'提示'},function(index){
		$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs is_delete" onClick="member_start(this,id)" href="javascript:;" title="启用"><i class="icon-ok bigger-120"></i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">禁用</span>');
		var arr = {};
		arr['staff_id'] = staff_id;
		arr['is_delete'] = res_text;
		var arr = JSON.stringify(arr);
		
		// 调用函数
		url_post('/erp/userEdit',arr,"/erp/userList");
		$(obj).remove()

		layer.msg('已停用!',{icon: 1,time:1000});
	});
}

/*用户-启用*/
function member_start(obj,id){
	var res_text = get_text($(obj),'.is_delete');
	var staff_id = get_user_id($(obj));
	// console.log(staff_id);
	layer.confirm('确认要启用吗？',{icon: 1, title:'提示'},function(index){
		$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs btn-success is_delete" onClick="member_stop(this,id)" href="javascript:;" title="停用"><i class="icon-ok bigger-120"></i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">启用</span>');
		
		var arr = {};
		arr['staff_id'] = staff_id;
		arr['is_delete'] = res_text;
		var arr = JSON.stringify(arr);
		
		// 调用函数
		url_post('/erp/userEdit',arr,"/erp/userList");
		$(obj).remove();
		layer.msg('已启用!',{icon: 6,time:1000});
	});
}

/*用户-编辑*/
function member_edit(id){
	  layer.open({
        type: 1,
        title: '修改用户信息',
		maxmin: true, 
		shadeClose:false, //点击遮罩关闭层
        area : ['800px' , ''],
        content:$('#add_menber_style'),
		btn:['提交','取消'],
		yes:function(index,layero){	
		 var num=0;
		 var str="";
     $(".add_menber input[type$='text']").each(function(n){
          if($(this).val()=="")
          {
			   layer.alert(str+=""+$(this).attr("name")+"不能为空！\r\n",{
                title: '提示框',				
				icon:0,								
          }); 
		    num++;
            return false;            
          } 
		 });
		  if(num>0){  return false;}	 	
          else{
			  layer.alert('添加成功！',{
               title: '提示框',				
			icon:1,		
			  });
			   layer.close(index);	
		  }		  		     				
		}
    });
}


/*用户-编辑*/
function member_edit2(id){
	var res = get_ajax('/erp/findUserInfo',id,"post,false");
	$("#edit_staff_phone").val(res.data.staff_phone);
	$("#edit_staff_name").val(res.data.staff_name);
	$("#edit_company_name").val(res.data.company_name);
	$("#edit_company_address").val(res.data.company_address);

	  layer.open({
        type: 1,
        title: '修改用户信息',
		maxmin: false, 
		shadeClose:false, //点击遮罩关闭层
        area : ['300px' , ''],
        content:$('#add_menber_style2'),
		btn:['提交','取消'],
		yes:function(index,layero){	
		 var num=0;
		 var str="";
     	
      	var arr = {};
      	arr['staff_id'] = id;
      	arr['staff_name'] = $("#edit_staff_name").val();
      	arr['staff_phone'] = $("#edit_staff_phone").val();
      	arr['company_name'] = $("#edit_company_name").val();
      	arr['company_address'] = $("#edit_company_address").val();
      	
      	arr = JSON.stringify(arr);
      	// 调用函数
      	var a = url_post('/erp/userEdit',arr);
      	console.log(a);
      	// console.log($("#eidt_staff_phone").val());
      	location.href = window.location.href;
		  layer.alert('添加成功！',{
           title: '提示框',				
		icon:1,		
		  });
		   layer.close(index);	
		}
    });
}


/*用户-删除*/
function member_del(obj,id){
	layer.confirm('删除无法恢复，确认要删除吗？',{icon: 2, title:'提示'},function(index){
		$(obj).parents("tr").remove();

		var staff_id = get_user_id($(obj));
		// 调用函数
		// url_post('/erp/userDel',staff_id,"/erp/userList");
		var code = url_post('/erp/userDel',staff_id);
		window.location.href = window.location.href
	});
}
laydate({
    elem: '#start',
    event: 'focus' 
});

</script>

@endsection('content')