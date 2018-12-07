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
       <li><label class="l_f">供应商信息</label><input name="search" type="text"  class="text_add" placeholder="供应商名称 电话"  style=" width:400px"/></li>
       <li><label class="l_f">添加时间</label><input name="create_time" class="inline laydate-icon" id="start" style=" margin-left:10px;"></li>
       <li style="width:90px;"><button type="submit" class="btn_search"><i class="icon-search"></i>查询</button></li>
      </ul>
     	</form>
    </div>
     <!---->
     <div class="border clearfix">
       <span class="l_f">
        <a href="javascript:ovid()" id="member_add" class="btn btn-warning"><i class="icon-plus"></i>添加经销商</a>
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
     <li class="clearfix"><label class="label_name">所属角色</label>
        <span class="formControls col-3">
        <select class="form-control add_option role_id" id="form-field-select-1">
           <option value="0">--选择所属角色--</option>
            @foreach($roles as $info)
            <option value="{{$info['role_id']}}">{{$info['role_name']}}</option>
            @endforeach
                   </select>
        </span>
     </li>
    </ul>
 </div>

 <div class="add_menber2" id="add_menber_style2" style="display:none">

      <table class="table table-bordered">
          <tbody>
          <tr><td class="name">用户名</td><td class="munber"><span class="add_name"><input value="" name="用户名" type="text"  id="edit_staff_name" class="text_add"/></span></td></tr>
          <tr><td class="name">手机号</td><td class="munber"><span class="add_name"><input value="" name="手机号" type="text"  class="text_add" id="edit_staff_phone"/></span></td></tr>
          <tr><td class="name">公司名称</td><td class="munber"><span class="add_name"><input value="" name="公司名称" type="text"  class="text_add" id="edit_company_name"/></span></td></tr>
          <tr><td class="name">公司地址</td><td class="munber"><span class="add_name"><input value="" name="公司地址" type="text"  class="text_add" id="edit_company_address" /></span></td></tr>
          <tr>
              <td class="name">所属分类</td><td class="munber">
                <span class="formControls col-3">
                <select class="form-control add_option edit_role_id" id="form-field-select-1">
                </select>
                </span>
              </td>
          </tr>
          </tbody>
         </table>
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
          	arr['role_id'] = $(".role_id").val();
          	var res_code = ajax_req('/erp/userAdd',arr,"post",false);
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
function member_edit2(id){
  // var res = get_ajax('/erp/findUserInfo',id,"get");
  var arr = {}
  arr['staff_id'] = id;
	var res = ajax_req('/erp/findUserInfo',arr,"get");
  console.log(res);
  if(res.status != 200){
      layer_info(res.msg,2);exit;
  }

  var info = res.data;
  $("#edit_staff_phone").val(info['staff_phone']);
  $("#edit_staff_name").val(info['staff_name']);
  $("#edit_company_name").val(info['company_name']);
  $("#edit_company_address").val(info['company_address']);
  $(".edit_role_id").val(info['edit_role_id']);

  var res_role = ajax_req('/erp/getStaffRoleList',"","get");
  if(res_role.status != 200){
      layer.alert(res_role.msg,{title: '提示框', icon:2});exit;
      // layer_info(res.msg,2);exit;
  }
  // var res_role = get_ajax('/erp/getStaffRoleList',id,"get");

  $(".edit_role_id").append("<option value='0'>--选择所属角色--</option>");
  $.each(res_role.data,function(i,val){
    $(".edit_role_id").append("<option "+val['select']+" value='"+val['role_id']+"'>"+val['role_name']+"</option>");
  });
  

  layer.open({type: 1,title: '修改用户信息',
    maxmin: false, 
    shadeClose:false, //点击遮罩关闭层
    area : ['400px' , '380px'],
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
        arr['role_id'] = $(".edit_role_id").val();
        arr = JSON.stringify(arr);
        // 调用函数
        var res = get_ajax('/erp/userEdit',arr);
        if(res.status == 200){
          layer.alert(res.msg,{title: '提示框', icon:1}); 
          location.href = window.location.href;
        }else{
          layer.alert(res.msg,{title: '提示框', icon:2}); 
          layer.close(index); 
        }
    }
  });
}


/*用户-删除*/
function member_del(obj,id){
	layer.confirm('删除无法恢复，确认要删除吗？',{icon: 2, title:'提示'},function(index){
    var staff_id = get_user_id($(obj));
    // 调用函数
    var res = ajax_req('/erp/userDel',{'staff_id':staff_id});
    if(res.status != 200){
      layer.alert(res.msg,{title: '提示框', icon:2}); exit;
    }else{
		  $(obj).parents("tr").remove();
      layer.alert(res.msg,{title: '提示框', icon:1});
      layer.close();
		  window.location.href = window.location.href
    }
	});
}
laydate({
    elem: '#start',
    event: 'focus' 
});

</script>

@endsection('content')