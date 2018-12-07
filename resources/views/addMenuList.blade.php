@extends('index')
@section('content')
<!-- 
<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="css/style.css"/>       
<link href="assets/css/codemirror.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="font/css/font-awesome.min.css" /> -->
<!--[if lte IE 8]>
  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
<![endif]-->
<!-- <script src="js/jquery-1.9.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/typeahead-bs2.min.js"></script>           	
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/layer/layer.js" type="text/javascript" ></script>          
<script src="assets/laydate/laydate.js" type="text/javascript"></script>
<script src="js/dragDivResize.js" type="text/javascript"></script>
 -->

<div class="Competence_add_style clearfix">
	<!-- 左侧注释 -->
	<!--   <div class="left_Competence_add">
	   <div class="title_name">添加权限</div>
	    <div class="Competence_add">
	     <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 权限名称 </label>
	       <div class="col-sm-9"><input type="text" id="form-field-1" placeholder=""  name="权限名称" class="col-xs-10 col-sm-5"></div>
		</div>
	     <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 权限描述 </label>
	      <div class="col-sm-9"><textarea name="权限描述" class="form-control" id="form_textarea" placeholder="" onkeyup="checkLength(this);"></textarea><span class="wordage">剩余字数：<span id="sy" style="color:Red;">200</span>字</span></div>
		</div>
	    <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 用户选择 </label>
	       <div class="col-sm-9">
	       <label class="middle"><input class="ace" type="checkbox" id="id-disable-check"><span class="lbl"> sm123456</span></label>
	       <label class="middle"><input class="ace" type="checkbox" id="id-disable-check"><span class="lbl"> admin</span></label>
	       <label class="middle"><input class="ace" type="checkbox" id="id-disable-check"><span class="lbl"> admin123456</span></label>
	       <label class="middle"><input class="ace" type="checkbox" id="id-disable-check"><span class="lbl"> style_name</span></label>
	       <label class="middle"><input class="ace" type="checkbox" id="id-disable-check"><span class="lbl"> username</span></label>
	       <label class="middle"><input class="ace" type="checkbox" id="id-disable-check"><span class="lbl"> adminname</span></label>
	       <label class="middle"><input class="ace" type="checkbox" id="id-disable-check"><span class="lbl"> sm12345</span></label>
	       <label class="middle"><input class="ace" type="checkbox" id="id-disable-check"><span class="lbl"> 天使的行</span></label>
		</div>   
	   </div>
	   <div class="Button_operation">
					<button onclick="article_save_submit();" class="btn btn-primary radius" type="submit"><i class="fa fa-save "></i> 保存并提交</button>
					<button onclick="article_save();" class="btn btn-secondary  btn-warning" type="button"><i class="fa fa-reply"></i> 返回上一步</button>
					<button onclick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
				</div>
	   </div>
	   </div> -->

<style>
	.Select_Competence{
		width: 100%
	}
</style>
   <!--权限分配-->
   <div class="Assign_style">
      <div class="title_name"><button class="btn btn-danger"  onclick="open_menu()">添加菜单</button></div>
      <div class="Select_Competence">
      	<form action="erp/roleList">
      <dl class="permission-list">
		<!-- <dt><label class="middle"><input name="user-Character-0" class="ace" type="checkbox" id="id-disable-check"><span class="lbl">权限分配</span></label></dt> -->
		<dt><label class="middle"><span class="lbl">权限分配</span></label></dt>
		<dd>
		@foreach($info as $arr)
			 <dl class="cl permission-list2">
			 <dt><label class="middle"><input type="checkbox" value="" class="ace"  name="user-Character-0-0" id="id-disable-check"><span class="lbl">{{$arr['menu_name']}}</span></label></dt>
	         <dd>
			 @if($arr['sub'] != "" )
	         	@foreach($arr['sub'] as $subs)
			   <label class="middle"><input type="checkbox" value=""  class="ace" name="user-Character-0-0-0" id="user-Character-0-0-0"><span class="lbl">{{$subs['menu_name']}}</span></label>
	            @endforeach
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
  	<label class="label_name">参数</label>
  	  <span class="cont_style">
  	  <input type="text" id="url" value="" placeholder="">
  	</span>
  </li>
  <li>
  	<label class="label_name">样式</label>
  	  <span class="cont_style">
  	  <input type="text" id="icon" value="" placeholder="">
  	</span>
  </li>
  <li>
  <label class="label_name">分类</label>
  <span class="cont_style">
  <select class="form-control par_id" id="form-field-select-1">
    <option value="">子菜单分类</option>
    @foreach($par as $arr)
    <option value="{{$arr['menu_id']}}">{{$arr['menu_name']}}</option>
    @endforeach
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
   //   $(".add_adverts input[type$='text']").each(function(n){
   //        if($(this).val()=="")
   //        {
               
			//    layer.alert(str+=""+$(this).attr("name")+"不能为空！\r\n",{
   //              title: '提示框',				
			// 	icon:0,								
   //        }); 
		 //    num++;
   //          return false;            
   //        } 
		 // });
		  if(num>0){  return false;}	 	
          else{
  			var num=0;
  			var str="";
  	      	var arr = {};
  	      	arr['menu_name'] = $("#menu_name").val();
  	      	arr['par_id'] = $(".par_id").val();
  	      	arr['url'] = $("#url").val();
  	      	arr['icon'] = $("#icon").val();
  	      	arr = JSON.stringify(arr);
  	      	// 调用函数
  	      	var a = url_post('/erp/menuAdd',arr);
          	layer.alert('添加成功！',{title: '提示框',icon:1,});
			layer.close(index);	
			// window.location.href = window.location.href;
		  }		  		     				
		}
    });
}

</script>


@endsection('content')