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
     	<form action="/log/loginList" method="get">
      <ul class="search_content clearfix">
       <li><label class="l_f"></label><input name="search" type="text"  class="text_add" placeholder="输入用户名称"  style=" width:400px"/></li>
       <!-- <li><label class="l_f">添加时间</label><input name="create_time" class="inline laydate-icon" id="start" style=" margin-left:10px;"></li> -->
       <li style="width:90px;"><button type="submit" class="btn_search"><i class="icon-search"></i>查询</button></li>
      </ul>
     	</form>
    </div>
     <!---->
     <div class="border clearfix">
       <span class="l_f">
        <!-- <a href="javascript:ovid()" id="member_add" class="btn btn-warning"><i class="icon-plus"></i>添加用户</a> -->
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
				<th width="100">ip</th>
				<th width="120">操作人</th>
				<th width="180">加入时间</th>
				<th width="250">操作</th>
			</tr>
		</thead>
	<tbody>
		@foreach($info as $logs)
		<tr>
        <td title="{{$logs->login_log_id}}" class="login_log_id">{{$logs->login_log_id}}</td>
        <td>{{$logs->ip}}</td>
        <td>{{$logs->staff_name}}</td>
        <td>{{$logs->create_time}}</td>
        <td><a title="删除" href="javascript:;"  onclick="member_del(this,{{$logs->login_log_id}})" class="btn btn-xs  btn-danger" ><i class="icon-trash  bigger-120"></i></a></td>
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



/*日志-删除*/
function member_del(obj,login_log_id){

	layer.confirm('删除无法恢复，确认要删除吗？',{icon: 2, title:'提示'},function(index){
    var res = ajax_req('/log/LogDel',{'login_log_id':login_log_id});
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