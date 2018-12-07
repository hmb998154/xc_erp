<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/assets/css/font-awesome.min.css" />
		<!--[if IE 7]>
		  <link rel="stylesheet" href="/assets/css/font-awesome-ie7.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="/assets/css/ace.min.css" />
		<link rel="stylesheet" href="/assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="/assets/css/ace-skins.min.css" />
        <link rel="stylesheet" href="/css/style.css"/>
		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->
		<script src="/assets/js/ace-extra.min.js"></script>
		<!--[if lt IE 9]>
		<script src="/assets/js/html5shiv.js"></script>
		<script src="/assets/js/respond.min.js"></script>
		<![endif]-->
		<script src="/js/jquery-1.9.1.min.js"></script>        
        <script src="/assets/layer/layer.js" type="text/javascript"></script>
<title>登录</title>
</head>

<body class="login-layout Reg_log_style">

<div class="logintop">    
    <span>欢迎后台管理界面平台</span>    
    <ul>
    <li><a href="#">关于</a></li>
    <!-- <li><a href="/erp/shopIn">申请入驻</a></li> -->
    </ul>    
    </div>
    <div class="loginbody">
<div class="login-container">
	<div class="center">
	     <img src="/images/logo1.png" /></div>
							<div class="space-6"></div>
							<div class="position-relative">
								<div id="login-box" class="login-box widget-box no-border visible">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="icon-coffee green"></i>
												管理员登录
											</h4>

											<div class="login_icon"><img src="/images/login.png" /></div>

<form class="" id="form">
		<fieldset>
										<ul>
   <li class="frame_style form_error"><label class="user_icon"></label><input name="staff_name" title="用户名" type="text"  id="username" placeholder="用户名" /><i></i></li>
   <li class="frame_style form_error"><label class="password_icon"></label><input name="passwd" title="密码" type="password"   id="userpwd" placeholder="密码" /><i></i></li>
   <li class="frame_style form_error"><label class="Codes_icon"></label>
   		<input name="code" type="text"   id="Codes_text" placeholder="验证码" title="验证码" /><i></i>
   			<div class="Codes_region">
   				<!-- <img  src="/erp/getVerifyCode" width="80px;" height="40px" onclick="javascript:this.src=this.src+'?time='+Math.random();" > -->
   				<img src="/erp/getVerifyCode" width="80px;" height="40px" onclick="javascript:this.src=this.src+'?time='+Math.random();">

   			</div>
   </li>
  </ul>
								<div class="space"></div>
								<div class="clearfix">
									<label class="inline">
										<input type="checkbox" class="ace">
										<span class="lbl">保存密码</span>
									</label>

									<button type="button" class="width-35 pull-right btn btn-sm btn-primary" id="login_btn">
										<i class="icon-key"></i>
										登录
									</button>
								</div>

								<div class="space-4"></div>
							</fieldset>
						</form>

						<div class="social-or-login center">
							<span class="bigger-110">通知</span>
						</div>

						<div class="social-login center">
						本网站系统不再对IE8以下浏览器支持，请见谅。
						</div>
					</div><!-- /widget-main -->

					<div class="toolbar clearfix">
						

						
					</div>
				</div><!-- /widget-body -->
			</div><!-- /login-box -->
		</div><!-- /position-relative -->
	</div>
    </div>
    <div class="loginbm">版权所有  2018 协成智慧</div><strong></strong>


<script>
$('#login_btn').on('click', function(){
	     var num=0;
		 var str="";
     $("input[type$='text'],input[type$='password']").each(function(n){
          if($(this).val()=="")
          {
			   layer.alert(str+=""+$(this).attr("title")+"不能为空！\r\n",{
                title: '提示框',				
				icon:0,								
          }); 
		    num++;
            return false;            
          } 
		 });
		  if(num>0){  return false;}	 	
          else{
			  // layer.alert('登录成功！',{
     //           title: '提示框',				
			  //  icon:1,		
			  // });
	    //       location.href="/";
			  //  layer.close(index);	
			 	var data = {};
			 	  $('input[name]').each(function() {
			 	    data[this.getAttribute('name')] = this.value;
			 	});
			 	 // console.log(JSON.stringify(data));
			     $.post("/erp/in",{
			     	arr:data
			     },
			         function(data,status){
			         	// console.log(" 返回的data："+data);
			         	// console.log("返回的 status："+status);
			         	var arr = JSON.parse(data);
			         	console.log(arr);
			         	if(arr['status'] == 200){
			         		layer.alert(arr['msg'],{title: '提示框',	icon:1}); 	
			         		location.href = arr['data'];
			         	}else{
			   			   layer.alert(arr['msg'],{title: '提示框',	icon:2}); 	
			         	}
			     });
		  }		  		     						
	});


$('#login_btn').click(function(){
	// var arr = $("#form").serializeArray();
	// var arr = new Array()
	// arr['username'] = $("#username").val();
	// arr['userpwd'] = $("#userpwd").val();
	// arr['code'] = $("#code").val();
	// console.log(arr);
	// // var  arrs = JSON.parse(arr);
	// var arrs =JSON.stringify(arr);
	// console.log(arrs);

});


  $(document).ready(function(){
	 $("input[type='text'],input[type='password']").blur(function(){
        var $el = $(this);
        var $parent = $el.parent();
        $parent.attr('class','frame_style').removeClass(' form_error');
        if($el.val()==''){
            $parent.attr('class','frame_style').addClass(' form_error');
        }
    });
	$("input[type='text'],input[type='password']").focus(function(){		
		var $el = $(this);
        var $parent = $el.parent();
        $parent.attr('class','frame_style').removeClass(' form_errors');
        if($el.val()==''){
            $parent.attr('class','frame_style').addClass(' form_errors');
        } else{
			 $parent.attr('class','frame_style').removeClass(' form_errors');
		}
		});
	  })

</script>
</body>
</html>