<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
	<head>
	<meta charset="utf-8" />
	<title>后台管理ERP</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="/assets/css/font-awesome.min.css" />
	<!--[if IE 7]>
	  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
	<![endif]-->
	<link rel="stylesheet" href="/assets/css/ace.min.css" />
	<link rel="stylesheet" href="/assets/css/ace-rtl.min.css" />
	<link rel="stylesheet" href="/assets/css/ace-skins.min.css" />
    <link rel="stylesheet" href="/css/style.css"/>
	<!--[if lte IE 8]>
	  <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
	<![endif]-->
	<script src="/assets/js/ace-extra.min.js"></script>
	<!--[if lt IE 9]>
	<script src="/assets/js/html5shiv.js"></script>
	<script src="/assets/js/respond.min.js"></script>
	<![endif]-->
    <!--[if !IE]> -->
	<script src="/js/jquery-1.9.1.min.js"></script>       
	<!-- 公共类 -->
	<script src="/assets/js/common.js" type="text/javascript"></script>
	<!-- <![endif]-->
	<!--[if IE]>
     <script type="text/javascript">window.jQuery || document.write("<script src='/assets/js/jquery-1.10.2.min.js'>"+"<"+"script>");</script>
    <![endif]-->
	<script type="text/javascript">
		if("ontouchend" in document) document.write("<script src='/assets/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
	</script>
	<script src="/assets/js/bootstrap.min.js"></script>
	<script src="/assets/js/typeahead-bs2.min.js"></script>
	<!--[if lte IE 8]>
	  <script src="/assets/js/excanvas.min.js"></script>
	<![endif]-->
	<script src="/assets/js/ace-elements.min.js"></script>
	<script src="/assets/js/ace.min.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript"></script>
	<script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <script src="/js/jquery.nicescroll.js" type="text/javascript"></script>
<style type="text/css">
	.d_Confirm_Order_style{
	}
	#navbar{
		position: fixed;
		width: 100%;
	}
</style>
<script type="text/javascript">	
 $(function(){ 

 var cid = $('#nav_list> li>.submenu');
	  cid.each(function(i){ 
       $(this).attr('id',"Sort_link_"+i);
    })  
 })

 jQuery(document).ready(function(){ 	
    $.each($(".submenu"),function(){
	var $aobjs=$(this).children("li");
	var rowCount=$aobjs.size();
	var divHeigth=$(this).height();
    $aobjs.height(divHeigth/rowCount);	  	
  }); 
    //初始化宽度、高度

    $("#main-container").height($(window).height()-76); 
	$("#iframe").height($(window).height()-140); 
	 
	$(".sidebar").height($(window).height()-99); 
    var thisHeight = $("#nav_list").height($(window).outerHeight()-173); 
	$(".submenu").height();
	$("#nav_list").children(".submenu").css("height",thisHeight);
	
    //当文档窗口发生改变时 触发  
    $(window).resize(function(){
	$("#main-container").height($(window).height()-76); 
	$("#iframe").height($(window).height()-140);
	$(".sidebar").height($(window).height()-99); 
	
	var thisHeight = $("#nav_list").height($(window).outerHeight()-173); 
	$(".submenu").height();
	$("#nav_list").children(".submenu").css("height",thisHeight);
  });
    $(document).on('click','.iframeurl',function(){
        var cid = $(this).attr("name");
		var cname = $(this).attr("title");
        $("#iframe").attr("src",cid).ready();
		$("#Bcrumbs").attr("href",cid).ready();
		$(".Current_page a").attr('href',cid).ready();	
        $(".Current_page").attr('name',cid);
		$(".Current_page").html(cname).css({"color":"#333333","cursor":"default"}).ready();	
		$("#parentIframe").html('<span class="parentIframe iframeurl"> </span>').css("display","none").ready();	
		$("#parentIfour").html(''). css("display","none").ready();		
    });
});

$(document).on('click','.link_cz > li',function(){
	$('.link_cz > li').removeClass('active');
	$(this).addClass('active');
});

/*********************点击事件*********************/
$( document).ready(function(){
  $('#nav_list,.link_cz').find('li.home').on('click',function(){
	$('#nav_list,.link_cz').find('li.home').removeClass('active');
	$(this).addClass('active');
  });												
	//时间设置
  function currentTime(){ 
    var d=new Date(),str=''; 
    str+=d.getFullYear()+'年'; 
    str+=d.getMonth() + 1+'月'; 
    str+=d.getDate()+'日'; 
    str+=d.getHours()+'时'; 
    str+=d.getMinutes()+'分'; 
    str+= d.getSeconds()+'秒'; 
    return str; 
} 

setInterval(function(){$('#time').html(currentTime)},1000); 

$('#Exit_system').on('click', function(){
      layer.confirm('是否确定退出系统？', {
     btn: ['是','否'] ,//按钮
	 icon:2,
    }, 
	function(){
	  location.href="/erp/out";
    });
});
});
function link_operating(name,title){
    var cid = $(this).name;
	var cname = $(this).title;
    $("#iframe").attr("src",cid).ready();
	$("#Bcrumbs").attr("href",cid).ready();
	$(".Current_page a").attr('href',cid).ready();	
    $(".Current_page").attr('name',cid);
	$(".Current_page").html(cname).css({"color":"#333333","cursor":"default"}).ready();	
	$("#parentIframe").html('<span class="parentIframe iframeurl"> </span>').css("display","none").ready();	
	$("#parentIfour").html(''). css("display","none").ready();		
}

function onload(){
	var dis_ul = "";
    $.ajax({
       url : "/menu/getRoleMenuList",
       data:{data:""},
       async : false,
       type : "POST",
       dataType : 'json',
       success : function(result){
       // 获取数据
        // var info = result.data.info;
        var info = result.data;
        $.each(info, function(i,val){      
             if(val['sub'] != ""){
             	var class_first = "first_"+i;
               $("#nav_list").append("<li class='"+class_first+"'><a href='javascript:void(0)' class='dropdown-toggle li'><i class='"+val['icon']+"'></i><span class='menu-text'>"+val['menu_name']+"</span><b class='arrow icon-angle-down'></b></a></li>");
                var num = 0;
                var sub_name = 'sub_'+i;
                $("."+"first_"+i).append("<ul class='submenu "+sub_name+"' ></ul>");
                $.each(val['sub'], function(j,val2){ 
                	if(val2['url'] == window.location.pathname){
                		$("."+"first_"+i+" ul").append("<li class='home active'><a href='"+val2['url']+"'  title='"+val2['menu_name']+"' class='iframeurl' id='article_list.html'><i class='icon-double-angle-right'></i>"+val2['menu_name']+"</a></li>");
	                	dis_ul = "."+"first_"+i+" ul";
	                	$("dis_ul").attr("class","submenu "+sub_name+" open");
	                	$(dis_ul).css("display","block");

                	}else{
                		$("."+"first_"+i+" ul").append("<li class='home '><a href='"+val2['url']+"'  title='"+val2['menu_name']+"' class='iframeurl' id='article_list.html'><i class='icon-double-angle-right'></i>"+val2['menu_name']+"</a></li>");
                	}
                });
             }else{
             	$("#nav_list").append("<li><a href='"+val['url']+"' class='dropdown-toggle li'><i class='"+val['icon']+"'></i><span class='menu-text'>"+val['menu_name']+"</span></a></li>");
             }
         });   
        
       },error:function(error){
           alert("error");
       }
   }); 
}

function test2() {
	// $(this).addClass("active");
}

</script>	
</head>
<body onload="onload()">
<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
			try{ace.settings.check('navbar' , 'fixed')}catch(e){}
	</script>
	<div class="navbar-container" id="navbar-container">
		<div class="navbar-header pull-left">
			<a href="/" class="navbar-brand">
				<small>					
				<img src="/images/logo.png" width="200px">
				</small>
			</a><!-- /.brand -->
		</div><!-- /.navbar-header -->
		<div class="navbar-header operating pull-left">
		
		</div> 
       <ul class="nav ace-nav">	
        <li class="light-blue">
		<a data-toggle="dropdown" href="#" class="dropdown-toggle">
		 <span  class="time"><em id="time"></em></span><span class="user-info"><small>欢迎光临 </small>{{Session::get('staff_name')}}</span>
		 <i class="icon-caret-down"></i>
		</a>
		<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
		 <li><a href="/erp/adminInfo" name="admin_info.html" title="个人信息" class="iframeurl"><i class="icon-user"></i>个人资料</a></li>
		 <li class="divider"></li>
		 <li><a href="javascript:void(0)" id="Exit_system"><i class="icon-off"></i>退出</a></li>
		</ul>
	   </li>
       </div>
</div>
