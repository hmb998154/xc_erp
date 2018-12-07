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
     	<form action="/erp/getRoleList" method="get">
      <ul class="search_content clearfix">
       <li><label class="l_f">角色名称</label><input name="search" type="text"  class="text_add" placeholder="输入角色名称"  style=" width:400px"/></li>
       <li><label class="l_f">添加时间</label><input name="create_time" class="inline laydate-icon" id="start" style=" margin-left:10px;"></li>
       <li style="width:90px;"><button type="submit" class="btn_search"><i class="icon-search"></i>查询</button></li>
      </ul>
     	</form>
    </div>
     <!---->
     <div class="border clearfix">
       <span class="l_f">
        <a href="javascript:ovid()" id="member_add" class="btn btn-warning"><i class="icon-plus"></i>添加角色</a>
        <!-- <a href="javascript:ovid()" id="member_add" class="btn btn-danger"><i class="icon-plus"></i>批量删除</a> -->
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
				<th width="100">角色名</th>
				<th width="70">时间</th>                
				<th width="70">状态</th>                
				<th width="250">操作</th>
			</tr>
		</thead>
	<tbody>
		@foreach($info as $user)
		<tr>
          <!-- <td><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td> -->
          <td title="{{$user->role_id}}" class="role_id">{{$user->role_id}}</td>
          <td>{{$user->role_name}}</td>
          <td title="" class="create_time">{{$user->create_at}}</td>
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
          <a title="编辑" onclick="member_edit2('{{$user->role_id}}')" href="javascript:;"  class="btn btn-xs  btn-info" ><i class="icon-edit bigger-120"></i></a> 
          <a title="删除" href="javascript:;"  onclick="member_del(this,'{{$user->role_id}}')" class="btn btn-xs  btn-danger" ><i class="icon-trash  bigger-120"></i></a>
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
   <div class="Competence_add_style clearfix">
   </style>
      <!--权限分配-->
      <div class="Assign_style">
         <div class="Select_Competence">
        <!--   <ul class=" page-content">
           <li><label class="label_name">角色名称：</label><span class="add_name"><input value="" name="角色名" type="text"  id="edit_role_name" class="text_add"/></span><div class="prompt r_f"></div></li>
          </ul> -->
          <form action="" method="post">
         <dl class="permission-list">
      <!-- <dt><label class="middle"><input name="user-Character-0" class="ace" type="checkbox" id="id-disable-check"><span class="lbl">权限分配</span></label></dt> -->
      <dt>
        <!-- <label class="middle"><span class="lbl">权限分配221</span></label> -->
        <label class="label_name">角色名称：</label><span class="add_name"><input value="" name="角色名" type="text"  id="role_name" class="text_add"/></span>
      </dt>
      <dd>
      @foreach($menus['info'] as $arr)
         <dl class="cl permission-list2">
      <dt>
        <label class="middle">
          <input type="checkbox" {{$arr['check']}} value="{{$arr['menu_id']}}" class="ace"  name="menu_id" >
          <span class="lbl">{{$arr['menu_name']}}</span>
        </label>
      </dt>
             <dd>
         @if($arr['sub'] != "" )
              @foreach($arr['sub'] as $subs)
           <label class="middle">
            <input type="checkbox" value="{{$subs['menu_id']}}"  class="ace" name="menu_id" >
            <span class="lbl">{{$subs['menu_name']}}</span>
          </label>
                @endforeach
        @else
            <label class="middle">
              <input type="checkbox" value="{{$arr['menu_id']}}" class="ace" name="menu_id" >
              <span class="lbl">xxxx</span>
            </label>
        @endif 
        </dd>
        </dl>
      @endforeach
      </dd>
        </dl> 
        </form>
         </div> 
     </div>
   </div>
 </div>

 <!-- 编辑 -->
 <div class="add_menber2" id="add_menber_style2" style="display:none">
    <ul class=" page-content">
     <li><label class="label_name">角色名称：</label><span class="add_name"><input value="" name="角色名" type="text"  id="edit_role_name" class="text_add"/></span><div class="prompt r_f"></div></li>
    </ul>

    <div class="Competence_add_style clearfix">
    <style>
    	.Select_Competence{
    		width: 100%
    	}
    </style>
       <!--权限分配-->
       <div class="Assign_style">
          <div class="Select_Competence">
          	<form action="/erp/roleList">
          <dl class="permission-list">
    		<!-- <dt><label class="middle"><input name="user-Character-0" class="ace" type="checkbox" id="id-disable-check"><span class="lbl">权限分配</span></label></dt> -->
    		<dt class=""><label class="middle"><span class="lbl">权限分配</span></label></dt>
     
        <dd class="edit_info">
        
    		</dd>
    	    </dl> 
    	    </form>
          </div> 
      </div>
    </div>
  </div>

    <!--添加菜单-->
    <div id="add_ads_style"  style="display:none">
     <div class="add_adverts">
     <ul>
      <li>
      	<label class="label_name">菜单</label>
      	  <span class="cont_style">
      	  <input type="text" id="menu_name" value="" placeholder="请输入菜单名称">
      	</span>
      </li>
      <li>
      <label class="label_name">分类</label>
      <span class="cont_style">
      <select class="form-control par_id" id="form-field-select-1">
        <option value="">子菜单分类</option>
      </select></span>
      </li>

     </ul>
     </div>
    </div>

    <script type="text/javascript">
    //初始化宽度、高度  

    /*字数限制*/
    function checkLength(which) {
    	var maxChars = 200; //
    	if(which.value.length > maxChars){
    	   layer.open({
    	   icon:2,
    	   title:'提示框',
    	   content:'您出入的字数超多限制!',	
        });
    		// 超过限制的字数了就将 文本框中的内容按规定的字数 截取
    		which.value = which.value.substring(0,maxChars);
    		return false;
    	}else{
    		var curr = maxChars - which.value.length; //250 减去 当前输入的
    		document.getElementById("sy").innerHTML = curr.toString();
    		return true;
    	}
    };
    /*按钮选择*/
    $(function(){
    	$(".permission-list dt input:checkbox").click(function(){
    		$(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
    	});
    	$(".permission-list2 dd input:checkbox").click(function(){
    		var l =$(this).parent().parent().find("input:checked").length;
    		var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
    		if($(this).prop("checked")){
    			$(this).closest("dl").find("dt input:checkbox").prop("checked",true);
    			$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
    		}
    		else{
    			if(l==0){
    				$(this).closest("dl").find("dt input:checkbox").prop("checked",false);
    			}
    			if(l2==0){
    				$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
    			}
    		}
    		
    	});
    });


    // 打开菜单
    function open_menu(){

    	  layer.open({
            type: 1,
            title: '添加广告',
    		maxmin: true, 
    		shadeClose: false, //点击遮罩关闭层
            area : ['800px' , ''],
            content:$('#add_ads_style'),
    		btn:['提交','取消'],
    		yes:function(index,layero){	
    		 var num=0;
    		 var str="";
         $(".add_adverts input[type$='text']").each(function(n){
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
      			var num=0;
      			var str="";
      	      	var arr = {};
      	      	arr['menu_name'] = $("#menu_name").val();
      	      	arr['par_id'] = $(".par_id").val();
      	      	arr = JSON.stringify(arr);
      	      	// 调用函数
      	      	var a = url_post('/erp/menuAdd',arr);
              	layer.alert('添加成功！',{title: '提示框',icon:1,});
    			layer.close(index);	
    			window.location.href = window.location.href;
    		  }		  		     				
    		}
        });
    }

    </script>

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
    layer.open({type: 1,title: '添加角色',maxmin: false, shadeClose: true, area : ['800px' , '600px'],content:$('#add_menber_style'),btn:['提交','取消'],
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
            var par_id = "";
            $('input:checkbox[name=menu_id]:checked').each(function(i){
            if(0==i){
            par_id = $(this).val();
            }else{
            par_id += (","+$(this).val());
            }
            });

          	var arr = {};
            arr['role_name'] = $("#role_name").val();
            arr['menu_id'] = par_id;

          	var res_code = get_ajax('/erp/roleConfig',arr,"post",false);
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
	var role_id = get_role_id($(obj));

	layer.confirm('确认要停用吗？',{icon: 2, title:'提示'},function(index){
		$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs is_delete" onClick="member_start(this,id)" href="javascript:;" title="启用"><i class="icon-ok bigger-120"></i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">禁用</span>');
		var arr = {};
		arr['role_id'] = role_id;
		arr['is_delete'] = change_code(res_text);
		// var arr = JSON.stringify(arr);
		
		// 调用函数
    var res = ajax_req('/erp/roleEdit',arr,"post");
    if(res.status != 200){
      layer.alert(res.msg,{icon: 2});
    }else{
      $(obj).remove()
		  layer.msg('已停用!',{icon: 1,time:1000});
    }
    // url_post('/erp/roleEdit',arr,"/erp/userList");
	});
}

/*用户-启用*/
function member_start(obj,id){
	var res_text = get_text($(obj),'.is_delete');
	var role_id = get_role_id($(obj));

	layer.confirm('确认要启用吗？',{icon: 1, title:'提示'},function(index){
		$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs btn-success is_delete" onClick="member_stop(this,id)" href="javascript:;" title="停用"><i class="icon-ok bigger-120"></i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">启用</span>');
		
		var arr = {};
		arr['role_id'] = role_id;
		arr['is_delete'] = change_code(res_text);
		// var arr = JSON.stringify(arr);
		
		// 调用函数
		var res = ajax_req('/erp/roleEdit',arr,"post");
		$(obj).remove();
		layer.msg('已启用!',{icon: 6,time:1000});
	});
}


/*角色-编辑*/
function member_edit2(id){
  // 获取角色编辑信息
  var info = get_ajax("/menu/menusRoleInfo",id,"get","false","");
  if(info.status != 200){
    layer_info(info.msg,2);exit;
  }
  info  = info.data;
  $(".edit_info").html("");
   $.each(info['arr'], function(i,val){     
   var num = 0;
    var info_num = "edit_dl_"+i;
    var info_num_dd = "edit_dl_dd"+i;
    $(".edit_info").append("<dl class='cl permission-list2 "+info_num+"'><dt><label class='middle'><input type='checkbox'"+ val['checked']+ " name='menu_info_id' value='"+val['menu_id']+"' class='ace'  ><span class='lbl'>"+val['menu_name']+"</span></label></dt><dd class='sub_info "+info_num_dd+"'></dd></dl>");
    if(val['sub'] != ""){
        $.each(val['sub'],function(j,val2){
          if(j == num){
           $("."+info_num_dd).append("<label class='middle'><input type='checkbox' alt="+val2['url']+" name='menu_info_id' "+val2['checked']+" value='"+val2['menu_id']+"'class='ace sub_ace' name='user-Character-0-0-0'><span class='lbl' alt="+val2['url']+" >"+val2['menu_name']+"</span></label>");
          }else{
            return ;
          }
          num++;

      })
    }
  });


	// // var res = get_ajax('/erp/roleFind',id,"post,false");
	$("#edit_role_name").val(info.info);

	  layer.open({
        type: 1,
        title: '修改角色信息',
		maxmin: false, 
		shadeClose:false, //点击遮罩关闭层
        area : ['800px' , '800px'],
        content:$('#add_menber_style2'),
		btn:['提交','取消'],
		yes:function(index,layero){	
		 var num=0;
		 var str="";
     	var par_id = "";
      $('input:checkbox[name="menu_info_id"]:checked').each(function(i){
      if(0==i){
      par_id = $(this).val();
      }else{
      par_id += (","+$(this).val());
      }
      });
      	var arr = {};
      	arr['role_id'] = id;
        arr['role_name'] = $("#edit_role_name").val();
      	arr['menu_id'] = par_id;
      	
      	var info = ajax_req('/erp/roleEdit',arr);
        if(info.status != 200){
            layer.alert(info.msg,{title: '提示框',icon:2,});
        }else{
          layer.alert('添加成功！',{title: '提示框',icon:1,});
          layer.close(index); 
          location.href = window.location.href;
        }
		}
    });
}


/*用户-删除*/
function member_del(obj,id){
	layer.confirm('删除无法恢复，确认要删除吗？',{icon: 2, title:'提示'},function(index){
    var info = ajax_req('/erp/roleDel',{'role_id':id},"get");
    if(info.status != 200){
        layer.alert(info.msg,{title:'提示框',icon:2});
    }else{
		    $(obj).parents("tr").remove();
        layer.alert(info.msg,{title:'提示框',icon:1});
        layer.close(index);  
		    window.location.href = window.location.href;
    }
	});
}
laydate({
    elem: '#start',
    event: 'focus' 
});

</script>

@endsection('content')