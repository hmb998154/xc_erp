@extends('index')
@section('content')
<div class="page-content clearfix">
    <div id="Member_Ratings">
      <div class="d_Confirm_Order_style">
    <div class="search_style">
     	<form action="/menu/getMenuAllList" method="get">
      <ul class="search_content clearfix">
       <li><label class="l_f">菜单名称</label><input name="search" type="text"  class="text_add" placeholder="输入菜单名称"  style=" width:400px"/></li>
       <li style="width:90px;">
         <select class="form-control add_option par_id_select" name="par_id_select" id="form-field-select-1" >
          <option value="0" >选择分类</option>
          @foreach($par_info as $row)
          <option   value="{{$row['menu_id']}}">{{$row['menu_name']}}</option>
          @endforeach
         </select>
       </li>
       <li style="width:90px;"><button type="submit" class="btn_search"><i class="icon-search"></i>查询</button></li>
      </ul>
     	</form>
    </div>
     <!---->
     <div class="border clearfix">
       <span class="l_f">
        <a href="javascript:ovid()" id="member_add" class="btn btn-warning"><i class="icon-plus"></i>添加菜单</a>
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
			<th width="100">菜单名</th>
			<th width="120">请求方式</th>
			<th width="180">上一级</th>
      <th width="150">icon</th>
      <th width="150">是否为菜单</th>
			<th width="150">创建时间</th>
			<th width="70">状态</th>                
			<th width="250">操作</th>
		</tr>
	</thead>
	<tbody>
		@foreach($info as $menu)
		<tr>
          <!-- <td><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td> -->
          <td title="{{$menu->menu_id}}" class="staff_id">{{$menu->menu_id}}</td>
          <td>{{$menu->menu_name}}</td>
          <td>{{$menu->url}}</td>
          <td>{{$menu->par_id}}</td>
          <td>{{$menu->icon}}</td>
          <td>{{$menu->is_menu}}</td>
          <td>{{$menu->create_time}}</td>
          <td class="td-status">
          	@if($menu->is_delete == "yes")
          	<span class="label label-default radius">{{change_status($menu->is_delete)}}</span>
          	@else
          	<span class="label label-success radius" >{{change_status($menu->is_delete)}}</span>
          	@endif
          </td>
          <td class="td-manage">
          	@if($menu->is_delete == "no")
          	<a onclick="member_stop(this,'10001')" href="javascript:;" title="停用" class="btn btn-xs  btn-success is_delete"><i class="icon-ok bigger-120"></i></a>
          	@else
          	<a style="text-decoration:none" class="btn btn-xs is_delete" onclick="member_start(this,id)" href="javascript:;" title="启用" ><i class="icon-ok bigger-120"></i></a>
          	@endif
          <!-- <a onClick="member_stop(t his,'10001')"  href="javascript:;" title="停用"  class="btn btn-xs btn-success"><i class="icon-ok bigger-120"></i></a>  -->
          <a title="编辑" onclick="member_edit('{{$menu->menu_id}}')" href="javascript:;"  class="btn btn-xs  btn-info" ><i class="icon-edit bigger-120"></i></a> 
          <a title="删除" href="javascript:;"  onclick="member_del(this,'{{$menu->menu_id}}')" class="btn btn-xs  btn-danger" ><i class="icon-trash  bigger-120"></i></a>
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
<!--添加菜单图层-->
<div class="add_menber" id="add_menber_style" style="display:none">
     <table class="table table-bordered">
     <tbody>
     <tr><td class="name">菜单名</td><td class="munber"><span class="add_name"><input value="" name="菜单名" id="menu_name_add" type="text"  class="text_add staff_name"/></span></td></tr>
     <tr><td class="name">URL</td><td class="munber"><span class="add_name"><input value="" name="URL：" id="url_add" type="text"  class="text_add"/></span></td></tr>
     <tr><td class="name">图标</td><td class="munber"><span class="add_name"><input name="图标" type="text" value="icon-desktop" class="text_add" id="icon_add"/></span></td></tr>
     <tr><td class="name">选择菜单</td>

    <td class="munber">
       <div class="formControls  skin-minimal">
               <label><input name="form-field-radio " class="add_is_menu" value="yes" type="radio" class="ace" checked><span class="lbl">是</span></label>&nbsp;&nbsp;
               <label><input name="form-field-radio " class="add_is_menu" value="no" type="radio" class="ace"><span class="lbl">否</span></label>
        </div>
     </td>
   </tr>
     <tr><td class="name">排序</td><td class="munber"><span class="add_name"><input value="" name="排序" type="text"  class="text_add" id="add_row_sort" /></span></td></tr>
     <tr>
        <td class="name">所属分类</td><td class="munber">
          <span class="formControls col-3">
          <select class="form-control add_option par_id_add" id="form-field-select-1" >
             <option value="0">--选择所属分类--</option>
             @foreach($par_info as $info)
             <option value="{{$info['menu_id']}}">{{$info['menu_name']}}</option>
             @endforeach 
          </select>
          </span>   
      </td>
   </tr>
     </tbody>
    </table>
 </div>

 <div class="add_menber2" id="add_menber_style2" style="display:none">
 	<table class="table table-bordered">
       <tbody>
       <tr><td class="name">菜单名</td><td class="munber"><span class="add_name"><input value="" name="菜单名" type="text"  id="edit_menu_name" class="text_add"/></span></td></tr>
       <tr><td class="name">url</td><td class="munber"><span class="add_name"><input value="" name="url" type="text"  class="text_add" id="edit_menu_url"/></span></td></tr>
       <tr><td class="name">图标</td><td class="munber"><span class="add_name"><input value="" name="图标" type="text"  class="text_add" id="edit_icon" /></span></td></tr>
       <tr><td class="name">排序</td><td class="munber"><span class="add_name"><input value="" name="排序" type="text"  class="text_add" id="edit_row_sort" /></span></td></tr>
  
       <tr>
          <td>是否菜单</td>
       <td class="munber">
          <div class="formControls  skin-minimal">
                  <label><input name="edit_is_menu" class=edit_is_menu" value="yes" type="radio" class="ace"><span class="lbl">是</span></label>&nbsp;&nbsp;
                  <label><input name="edit_is_menu" class=edit_is_menu" value="no" type="radio" class="ace"><span class="lbl">否</span></label>
           </div>
        </td>
       </tr>

       <tr>
       		<td class="name">所属分类</td><td class="munber">
       			<span class="formControls col-3 r_f">
       			<select class="form-control  edit_par_id" id="form-field-select-1">
               <option value="0">--选择所属分类--</option>
       			   @foreach($par_info as $edit_info)
       			   <option value="{{$edit_info['menu_id']}}">{{$edit_info['menu_name']}}</option>
       			   @endforeach
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

// 菜单-添加 
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
        	arr['menu_name'] = $("#menu_name_add").val();
        	arr['url'] = $("#url_add").val();  
        	arr['icon'] = $("#icon_add").val();
          arr['par_id'] = $(".par_id_add").val();
          arr['row_sort'] = $("#add_row_sort").val();
        	arr['is_menu'] = $(".add_is_menu").val();
        	var res_code = ajax_req('/menu/menuAdd',arr);
        	if(res_code.status == 200){
		     	  layer.close(index);	
            layer.alert('添加成功！',{title: '提示框',icon:1,});
        		window.location.href = window.location.href;
        	}else{
		     	  layer.alert(res_code.msg,{title: '提示框',icon:2});
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
	var res = get_ajax('/menu/findMenuInfo',id,"get");
  dd(res);
  if(res.status != 200){
    layer_info(res.msg,2);exit;
    // layer.alert(res.msg,{title: '提示框', icon:1}); exit;
  }
  var info = res.data;
  $("#edit_menu_name").val(info.menu_name);
  $("#edit_menu_url").val(info.url);
  $("#edit_icon").val(info.icon);
  $("#edit_par_id").val(info.par_id);
  $("#edit_row_sort").val(info.row_sort);

  if(info.is_menu == "yes"){
     $("input:radio[name=edit_is_menu][value=yes]").attr("checked",true);  
  }else{
     $("input:radio[name=edit_is_menu][value=no]").attr("checked",true);  
  }

  $(".edit_par_id").find("option[value='"+info.par_id+"']").attr("selected",true);

  layer.open({
      type: 1,
      title: '修改菜单信息',
      maxmin: false, 
      shadeClose:false, //点击遮罩关闭层
      area : ['400px' , '400px'],
      content:$('#add_menber_style2'),
      btn:['提交','取消'],
  yes:function(index,layero){ 
   var num=0;
   var str="";

      var arr = {};
      arr['menu_id'] = id;
      arr['menu_name'] = $("#edit_menu_name").val();
      arr['url'] = $("#edit_menu_url").val();
      arr['icon'] = $("#edit_icon").val();
      arr['par_id'] = $(".edit_par_id").val();
      arr['row_sort'] = $("#edit_row_sort").val();
      arr['is_menu'] = $("input[name='edit_is_menu']:checked").val();
      // arr = JSON.stringify(arr);
      // var res = url_post('/menu/menuEdit',arr);
      var res = ajax_req('/menu/menuEdit',arr);
      if(res.status == 200){
        layer_info(res.msg,1);
        window.location.href = window.location.href
      }else{
        layer_info(res.msg,2);
      }
      // larer_info(res.msg,1);
      // window.location.href = window.location.href ;
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
		var menu_id = {};
		menu_id['menu_id'] = id;
		var res = ajax_req('/menu/menuDel',menu_id,"get");
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