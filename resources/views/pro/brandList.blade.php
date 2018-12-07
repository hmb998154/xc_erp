@extends('index')
@section('content')
<div class="page-content clearfix">
    <div id="Member_Ratings">
      <div class="d_Confirm_Order_style">
    <div class="search_style">
     	<form action="/pro/brandList" method="get">
      <ul class="search_content clearfix">
       <li><label class="l_f">品牌名称</label><input name="search" type="text"  class="text_add" placeholder="输入品牌名称"  style=" width:400px"/></li>
       <li style="width:90px;"><button type="submit" class="btn_search"><i class="icon-search"></i>查询</button></li>
      </ul>
     	</form>
    </div>
     <!---->
     <div class="border clearfix">
       <span class="l_f">
        <a href="javascript:ovid()" id="member_add" class="btn btn-warning"><i class="icon-plus"></i>添加品牌</a>
        <!-- <a href="javascript:ovid()" class="btn btn-danger"><i class="icon-trash"></i>批量删除</a> -->
       </span>
       <span class="r_f">共：<b>{{$sum}}</b>条</span>
     </div>
     <!---->
     <div class="table_menu_list">
       <table class="table table-striped table-bordered table-hover" id="sample-table">
		<thead>
		 <tr>
			<!-- <th width="25"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th> -->
			<th width="80">ID</th>
      <th width="100">品牌名称</th>
      <th width="100">操作</th>
		</tr>
	</thead>
	<tbody>
		@foreach($info as $menu)
		<tr>
          <!-- <td><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td> -->
          <td title="{{$menu->brand_id}}" class="staff_id">{{$menu->brand_id}}</td>
          <td>{{$menu->brand_name}}</td>
          <td class="td-manage">
          <!-- <a onClick="member_stop(t his,'10001')"  href="javascript:;" title="停用"  class="btn btn-xs btn-success"><i class="icon-ok bigger-120"></i></a>  -->
          <a title="编辑" onclick="member_edit('{{$menu->brand_id}}')" href="javascript:;"  class="btn btn-xs  btn-info" ><i class="icon-edit bigger-120"></i></a> 
          <a title="删除" href="javascript:;"  onclick="member_del(this,'{{$menu->brand_id}}')" class="btn btn-xs  btn-danger" ><i class="icon-trash  bigger-120"></i></a>
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

<!-- 添加 -->
<div class="add_menber" id="add_menber_style" style="display:none">
     <table class="table table-bordered">
     <tbody>
     <tr>
      <td class="name">品牌名称</td>
      <td class="munber"><span class="add_name"><input value="" name="菜单名" id="brand_name_add" type="text"  class="text_add staff_name"/></span></td>
    </tr>
     </tbody>
    </table>
 </div>

<!-- 编辑 -->
 <div class="add_menber2" id="add_menber_style2" style="display:none">
 	<table class="table table-bordered">
       <tbody>
       <tr><td class="name">品牌名称</td><td class="munber"><span class="add_name"><input value="" name="品牌名称" type="text"  id="edit_brand_name" class="text_add"/></span></td></tr>
       
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

// 品牌-添加 
 $('#member_add').on('click', function(){
 	$(".add_option").append("")
    layer.open({
        type: 1,
        title: '添加菜单',
		maxmin: false, 
		shadeClose: true, //点击遮罩关闭层
        area : ['20%' , ''],
        content:$('#add_menber_style'),
		btn:['提交','取消'],
		yes:function(index,layero){	
			  
		 var num=0;
		 var str="";
     
		  if(num>0){  return false;}	 	
        else{
        	var arr = {};
        	arr['brand_name'] = $("#brand_name_add").val();
          var info = ajax_req('/pro/brandAdd',arr,"post","false","no");
        	if(info.status == 200){
		     	  layer.close(index);	
            layer.alert('添加成功！',{title: '提示框',icon:1,});
        		window.location.href = window.location.href;
        	}else{
		     	  layer.alert(info.msg,{title: '提示框',icon:2});
        	}
		  }		  		     				
		}
    });
});

/**
 * 菜单-查看
 * @param  {[type]} title [description]
 * @param  {[type]} url   [description]
 * @param  {[type]} id    [description]
 * @param  {[type]} w     [description]
 * @param  {[type]} h     [description]
 * @return {[type]}       [description]
 */
function member_show(title,url,id,w,h){
	layer_show(title,url+'#?='+id,w,h);
}

/**
 * 菜单-停用
 * @param  {[type]} obj [description]
 * @param  {[type]} id  [description]
 * @return {[type]}     [description]
 */
function member_stop(obj,id){
	var res_text = get_text($(obj),'.is_delete');
	var menu_id = get_user_id($(obj));

	layer.confirm('确认要停用吗？',{icon: 2, title:'提示'},function(index){
		$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs is_delete" onClick="member_start(this,id)" href="javascript:;" title="启用"><i class="icon-ok bigger-120"></i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">禁用</span>');
		var arr = {};
		arr['menu_id'] = menu_id;
		arr['is_delete'] = change_code(res_text);
		// var arr = JSON.stringify(arr);
		// 调用函数
    // url_post('/menu/menuEdit',arr);
		var info = ajax_req('/menu/menuEdit',arr,"post","false","no");
    if(info.status != 200){
        layer.alert(info.msg,{title: '提示框',icon:2});
    }else{
      $(obj).remove();
      // larer_info(info.msg,1);
		  layer.msg('已停用!',{icon: 1,time:1000});
    }
	});
}

/**
 * 菜单-停用 -》 启用
 * @param  {[type]} obj [description]
 * @param  {[type]} id  [description]
 * @return {[type]}     [description]
 */
function member_start(obj,id){
	var res_text = get_text($(obj),'.is_delete');
	var menu_id = get_user_id($(obj));
	layer.confirm('确认要启用吗？',{icon: 1, title:'提示'},function(index){
		$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs btn-success is_delete" onClick="member_stop(this,id)" href="javascript:;" title="停用"><i class="icon-ok bigger-120"></i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">启用</span>');
		
		var arr = {};
		arr['menu_id'] = menu_id;
		arr['is_delete'] = change_code(res_text);
		
		// 调用函数
    var info = ajax_req('/menu/menuEdit',arr,"post","false","no");
		$(obj).remove();
		layer.msg('已启用!',{icon: 6,time:1000});
	});
}

/**
 * 菜单-编辑
 * @param  {[type]} id [description]
 * @return {[type]}    [description]
 */
function member_edit(id){
	var res = ajax_req('/pro/getSingleBrand',{'brand_id':id},"get");
  if(res.status != 200){
    layer_info(res.msg,2);exit;
  }
  var info = res.data;
  $("#edit_brand_name").val(info.brand_name);

  layer.open({
      type: 1,
      title: '修改菜单信息',
      maxmin: false, 
      shadeClose:false, //点击遮罩关闭层
      area : ['400px' , '200px'],
      content:$('#add_menber_style2'),
      btn:['提交','取消'],
  yes:function(index,layero){ 
      var arr = {};
      arr['brand_id'] = id;
      dd(id);
      arr['brand_name'] = $("#edit_brand_name").val();
    
      var res = ajax_req('/pro/brandEdit',arr);
      if(res.status == 200){
        layer_info(res.msg,1);
        window.location.href = window.location.href
      }else{
        layer_info(res.msg,2);
      }
  }
  });
}

/**
 * 菜单-删除
 * @param  {[type]} obj [description]
 * @param  {[type]} id  [description]
 * @return {[type]}     [description]
 */
function member_del(obj,id){
	layer.confirm('删除无法恢复，确认要删除吗？',{icon: 2, title:'提示'},function(index){
		var res = ajax_req('/pro/brandDel',{'brand_id':id},"get");
		if(res.status == 200){
      $(obj).parents("tr").remove();
      layer_info(res.msg,1);
      window.location.href = window.location.href
		}else{
			layer_info(res.msg,2);
		}
	});
}
laydate({
    elem: '#start',
    event: 'focus' 
});
</script>
@endsection('content')