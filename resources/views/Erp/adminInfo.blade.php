@extends('index')
@section('content')
<style>
  #Personal{
    left: 50%;
  }
</style>
<div class="" style="width: 100%">
<div class="clearfix">
 <div class="admin_info_style">
   <div class="admin_modify_style" id="Personal">
     <!-- <div class="type_title">管理员信息 </div> -->
      <div class="xinxi">
        <div class="form-group"><label class="col-sm-3 control-label no-padding-right" for="form-field-1">用户名： </label>
          <div class="col-sm-9"><input type="text" name="用户名" id="staff_name" value="{{$res['staff_name']}}" class="col-xs-7 text_info" disabled="disabled">
          &nbsp;&nbsp;&nbsp;<a href="javascript:ovid()" onclick="change_Password()" class="btn btn-warning btn-xs">修改密码</a></div>
          
          </div>
          <div class="form-group"><label class="col-sm-3 control-label no-padding-right" for="form-field-1">移动电话： </label>
          <div class="col-sm-9"><input type="text" name="移动电话" id="staff_phone" value="{{$res->staff_phone}}" class="col-xs-7 text_info" disabled="disabled"></div>
          </div>
         
           <div class="form-group"><label class="col-sm-3 control-label no-padding-right" for="form-field-1">角色： </label>
          <div class="col-sm-9" > <span>{{$res->role_name}}</span></div>
          </div>
           <div class="form-group"><label class="col-sm-3 control-label no-padding-right" for="form-field-1">注册时间： </label>
          <div class="col-sm-9" > <span>{{$res->create_time}}</span></div>
          </div>
           <div class="Button_operation clearfix"> 
				<button onclick="modify();" class="btn btn-danger radius" type="submit">修改信息</button>				
				<button onclick="save_info();" class="btn btn-success radius" type="button">保存修改</button>              
			</div>
      </div>
    </div>
 </div>
</div>
</div>
 <!--修改密码样式-->
         <div class="change_Pass_style" id="change_Pass">
            <ul class="xg_style">
             <li><label class="label_name">原&nbsp;&nbsp;密&nbsp;码</label><input name="原密码" type="password" class="old_passwd" id="password"></li>
             <li><label class="label_name">新&nbsp;&nbsp;密&nbsp;码</label><input name="新密码" type="password" class="passwd" id="Nes_pas"></li>
             <li><label class="label_name">确认密码</label><input name="再次确认密码" type="password" class="qr_passwd" id="c_mew_pas"></li>
            </ul>
         </div>
<script>

 //按钮点击事件
function modify(){
	 $('.text_info').attr("disabled", false);
	 $('.text_info').addClass("add");
	 $('#Personal').find('.xinxi').addClass("hover");
	 $('#Personal').find('.btn-success').css({'display':'block'});
};

function save_info(){
	   var num=0;
		 var str="";
     $(".xinxi input[type$='text']").each(function(n){
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
           var arr = {};
           arr['staff_phone'] = $("#staff_phone").val();
           arr['staff_name'] = $("#staff_name").val();
           var res = get_ajax("/erp/changeUserInfo",arr,"post");
           if(res.status == 200){
             layer.alert(res.msg,{title: '提示框',icon:1,}); 
             // window.location.href = "/erp/out";
           }else{
             layer.alert(res.msg,{title: '提示框',icon:2,}); 
             layer.close(index);      
           }
         
			  $('#Personal').find('.xinxi').removeClass("hover");
			  $('#Personal').find('.text_info').removeClass("add").attr("disabled", true);
			  $('#Personal').find('.btn-success').css({'display':'none'});
			 layer.close(index);
		  }		  		
	};	

 //初始化宽度、高度    
 //    $(".admin_modify_style").height($(window).height()); 
	// $(".recording_style").width($(window).width()-400); 
 //    //当文档窗口发生改变时 触发  
 //    $(window).resize(function(){
	// $(".admin_modify_style").height($(window).height()); 
	// $(".recording_style").width($(window).width()-400); 
 //  });


  //修改密码
  function change_Password(){
	   layer.open({
    type: 1,
	title:'修改密码',
	area: ['300px','300px'],
	shadeClose: true,
	content: $('#change_Pass'),
	btn:['确认修改'],
	yes:function(index, layero){		
		   if ($("#password").val()==""){
			  layer.alert('原密码不能为空!',{title: '提示框',icon:0,
			 });
			return false;
          } 
		  if ($("#Nes_pas").val()==""){
			  layer.alert('新密码不能为空!',{title: '提示框',icon:0,
			 });
			return false;
          } 
		   
		  if ($("#c_mew_pas").val()==""){
			  layer.alert('确认新密码不能为空!',{title: '提示框',icon:0,
			 });
			return false;
          }
		    if(!$("#c_mew_pas").val || $("#c_mew_pas").val() != $("#Nes_pas").val() )
        {
            layer.alert('密码不一致!',{title: '提示框',icon:0,
			 });
			 return false;
        }   
		 else{	
        var arr = {};
        arr['old_passwd'] = $(".old_passwd").val();
        arr['passwd'] = $(".passwd").val();
        arr['qr_passwd'] = $(".qr_passwd").val();
        var res = ajax_req("/erp/changePass",arr,"post",false);
        if(res.status == 200){
          layer.alert(res.msg,{title: '提示框',icon:1,}); 
          window.location.href = "/erp/out";
        }else{
          layer.alert(res.msg,{title: '提示框',icon:2,}); 
          layer.close(index);      
        }
		  }	 
	}
    });
	  }
</script>
<script>
jQuery(function($) {
		var oTable1 = $('#sample-table').dataTable( {
		"aaSorting": [[ 1, "desc" ]],//默认第几个排序
		"bStateSave": true,//状态保存
		"aoColumnDefs": [
		  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
		  {"orderable":false,"aTargets":[0,2,3,4,5,6]}// 制定列不参与排序
		] } );
			$('table th input:checkbox').on('click' , function(){
				var that = this;
				$(this).closest('table').find('tr > td:first-child input:checkbox')
				.each(function(){
					this.checked = that.checked;
					$(this).closest('tr').toggleClass('selected');
				});
			});
});</script>
@endsection('content')