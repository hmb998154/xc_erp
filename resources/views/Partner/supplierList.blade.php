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
     	<form action="/supplier/supplierList" method="get">
      <ul class="search_content clearfix">
       <li><label class="l_f">工厂名称</label><input name="search" type="text"  class="text_add" placeholder="工厂名称"  style=" width:400px"/></li>
       <li><label class="l_f">添加时间</label><input name="create_time" class="inline laydate-icon" id="start" style=" margin-left:10px;"></li>
       <!-- <li style="width:90px;">
         <select class="form-control add_option par_id_select" name="par_id_select" id="form-field-select-1" >
          <option value="0" >选择分类</option>
          <option   value=""></option>
         </select>
       </li> -->
        <li style="width:90px;"><button type="submit" class="btn_search"><i class="icon-search"></i>查询</button></li>
      </ul>
     	</form>
    </div>
     <!---->
     <div class="border clearfix">
       <span class="l_f">
        <a href="/supplier/supplierAdd" id="member_add" class="btn btn-warning"><i class="icon-plus"></i>添加供应商</a>
        <!-- <a href="javascript:ovid()" class="btn btn-danger"><i class="icon-trash"></i>批量删除</a> -->
       </span>
       <span class="r_f">共：<b>{{ $sum }}</b>条</span>
     </div>
     <!---->
     <div class="table_menu_list">
       <table class="table table-striped table-bordered " >
		<thead>
		 <tr>
				<!-- <th width="25"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th> -->
        <th width="80">id</th>
        <th width="200">工厂名称</th>
        <th width="200">营业执照证件号</th>
        <th width="120">法人姓名</th>
				<th width="180">法人身份证</th>
				<th width="100">工厂面积</th>
        <th width="100">仓储面积</th>
				<th width="100">年生产规模</th>
				<th width="100">工厂等级</th>
				<th width="100">日产量</th>
        <th width="100">生产资质</th>
				<th width="100">信誉度</th>
				<th width="100">工厂货号</th>                
        <th width="100">保证金</th>
				<th width="200">操作</th>
			</tr>
		</thead>
	<tbody>
		@foreach($info as $user) 
		<tr>
          <!-- <td><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td> -->
          <td title="{{$user['supplier_id']}}" class="supplier_id">{{$user->supplier_id}}</td>
          <td>{{$user->factory_name}}</td>
          <td>{{$user->business_license}}</td>
          <td>{{$user->legal_name}}</td>
          <td>{{$user->Legal_idcard}}</td>
          <td>{{$user->factory_area}}</td>
          <td>{{$user->storage_area}}</td>
          <td>{{$user->scale_of_productio}}</td>
          <td>{{$user->factory_level}}</td>
          <td>{{$user->day_dev_num}}</td>
          <td>{{$user->dev_qualifications}}</td>
          <td>{{$user->reputation}}</td>
          <td>{{$user->factory_code}}</td>
          <td>{{$user->bond}}</td>
          <td class="td-manage">
          <a title="编辑" href="/supplier/supplierAdd?supplier_id={{$user->supplier_id}}"  class="btn btn-xs  btn-info" ><i class="icon-edit bigger-120">编辑</i></a> 
          <a title="删除" href="javascript:;"  onclick="member_del(this,'{{$user->supplier_id}}')" class="btn btn-xs  btn-danger" ><i class="icon-trash  bigger-120"></i></a>
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
		
		// 调用函数
		var info = ajax_req('/erp/userEdit',arr);
    if(info.status != 200){
      layer.alert(res_code.msg,{title: '提示框',icon:2});
    }else{
      $(obj).remove()
      layer.msg('已停用!',{icon: 1,time:1000});
    }
	});
}

/*用户-启用*/
function member_start(obj,id){
	var res_text = get_text($(obj),'.is_delete');
	var staff_id = get_user_id($(obj));
	layer.confirm('确认要启用吗？',{icon: 1, title:'提示'},function(index){
		$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs btn-success is_delete" onClick="member_stop(this,id)" href="javascript:;" title="停用"><i class="icon-ok bigger-120"></i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">启用</span>');
		
		var arr = {};
		arr['staff_id'] = staff_id;
		arr['is_delete'] = res_text;
		
    // 调用函数
    var info = ajax_req('/erp/userEdit',arr);
    if(info.status != 200){
      layer.alert(res_code.msg,{title: '提示框',icon:2});
    }else{
      $(obj).remove()
      layer.msg('已停用!',{icon: 1,time:1000});
    }
	});
}

/*用户-编辑*/
function member_edit(id){
  var arr = {}
  arr['staff_id'] = id;
	var res = ajax_req('/erp/findUserInfo',arr,"post","false","no");
  if(res.status != 200){
      layer.alert(res.msg,{title: '提示框',icon:2});
  }

  var info = res.data;

  $("#edit_staff_phone").val(info['staff_phone']);
  $("#edit_staff_name").val(info['staff_name']);
  $("#edit_company_name").val(info['company_name']);
  $("#edit_company_address").val(info['company_address']);
  // $(".edit_role_id").val(info['edit_role_id']);

  // $(".edit_role_id").find("option[value='"+info.edit_role_id+"']").attr("selected",true);


  var res_role = ajax_req('/erp/getStaffRoleList',"","get");
  if(res_role.status != 200){
      layer.alert(res_role.msg,{title: '提示框', icon:2});exit;
  }

  $(".edit_role_id").append("<option value='0'>--选择所属角色--</option>");
  $.each(res_role.data,function(i,val){
    dd(val['role_id']);
    if(val['role_id'] == info['role_id']){
      dd("xiangtong");
      $(".edit_role_id").append("<option selected='selected' "+val['select']+" value='"+val['role_id']+"'>"+val['role_name']+"</option>");
    }else{
      $(".edit_role_id").append("<option "+val['select']+" value='"+val['role_id']+"'>"+val['role_name']+"</option>");
    }
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
        // 调用函数
        var res = ajax_req('/erp/userEdit',arr);
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


/*供应商-删除*/
function member_del(obj,id){
	layer.confirm('删除无法恢复，确认要删除吗？',{icon: 2, title:'提示'},function(index){
    var res = ajax_req('/supplier/supplierDel',{'supplier_id':id});
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