 var arrs = {};
/**
 * 公共函数  code: 0警告 1报错 2正常 
 * @param  {[type]} url      [description]
 * @param  {[type]} arr      [description]
 * @param  {String} back_url [description]
 * @return {[type]}          [description]
 */
function url_post(url,arr,back_url = "") {
	  $.post(url,{
	  	data:arr
	  },
	  function(data,status){
	  	var arr = JSON.parse(data);
	  	if(arr.status== 200){
	  		arrs = arr;
	  	}else{
	  		arrs =  success(arr);
	  		console.log(arr.msg);
	  		return arrs;
	  	}
	 });
	  console.log(arrs);
	  return arrs;
}

/**
 * 检测url
 * @param  {[type]}  url   [请求地址]
 * @param  {[type]}  arr   [请求参数]
 * @param  {String}  type  [请求参数]
 * @param  {Boolean} async [是否同步]
 * @return {[type]}        [description]
 */
function check_url(url,arr,type = "post",async = true,is_check = "") {
	var arrs = "";
	if(is_check == "yes"){
		$.ajax({
	       url : url,
	       data:{url:arr},
	       async : false,
	       type : type,
	       dataType : 'json',
	       success : function(result){
	       	arrs =  success(result);
	       },error:function(error){
	       		var new_error = {};
	       		new_error['status'] = error.status;
	       		new_error['msg'] = error.responseText;
	       		arrs =  success(new_error);
	       }
	   });
	}
	return arrs;
}

/**
 * 获取ajax
 * @param  {[type]}  url   [请求地址]
 * @param  {[type]}  arr   [请求参数]
 * @param  {String}  type  [请求参数]
 * @param  {Boolean} async [是否同步]
 * @param  {is_check} async [是否验证]
 * @return {[type]}        [description]
 */
function get_ajax(url,arr,type = "post",async = true, is_check ="yes") {
	var res_url = check_url("/menu/checkAuth",url,"post", async,is_check);
	if(res_url.status == 200 || res_url == ""){
		$.ajax({
	       url : url,
	       data:{data:arr},
	       async : false,
	       type : type,
	       dataType : 'json',
	       success : function(result){
	       	arrs =  success(result);
	       	// var arr = JSON.parse(result);
	       },error:function(error){
	       		var new_error = {};
	       		new_error['status'] = error.status;
	       		new_error['msg'] = error.responseText;
	       		arrs =  success(new_error);
	       		// arrs =  success(error.responseText);
	       		// layer_info(arr['error'],2);
	       }
	   });

	}else{
		arrs =  success(res_url);
	}
	return arrs;
}

/**
 * 获取ajax
 * @param  {[type]}  url   [请求地址]
 * @param  {[type]}  arr   [请求参数]
 * @param  {String}  type  [请求参数]
 * @param  {Boolean} async [是否同步]
 * @return {[type]}        [description]
 */
function ajax_req(url,arr,type = "post",async = true , is_check = "yes") {
	var res_url = check_url("/menu/checkAuth",url,"post",async,is_check);
	if(res_url.status == 200 || res_url == ""){
		$.ajax({
	       url : url,
	       data:arr,
	       async : false,
	       // contentType:false,
	       // processData:false,
	       type : type,
	       dataType : 'json',
	       success : function(result){
	       	arrs =  success(result);
	       },error:function(error){
	       	dd("qingqiu 失败");
	       	dd(error);
	       		var new_error = {};
	       		new_error['status'] = error.status;
	       		new_error['msg'] = error.statusText;
	       		arrs =  success(new_error);
	       }
	   });
	}else{
		arrs =  success(res_url);
	}
	return arrs;
}


/**
 * 获取ajax
 * @param  {[type]}  url   [请求地址]
 * @param  {[type]}  arr   [请求参数]
 * @param  {String}  type  [请求参数]
 * @param  {Boolean} async [是否同步]
 * @return {[type]}        [description]
 */
function ajax_upload(url,arr,type = "post",async = true , is_check = "yes") {
    
    $.ajax({
        url:url,
        type:'post',
        contentType:false,
        data:arr,
        processData:false,
        success:function(info){    
            // $('.backimg').attr('src',JSON.parse(info).msg);
            arrs =  success(info);
        },
        error:function(err){
            arrs =  success(err);
        }
    });
    return  arrs;
}





/**
 * 
 * @param  {[type]} data [description]
 * @return {[type]}      [description]
 */
function success(data) {
	return data;
}

/**
 * 获取用户信息
 * @param  {[type]} $obj [description]
 * @return {[type]}      [description]
 */
function get_user_id($obj) {
	var staff_id = $obj.parents("tr").children(".staff_id").html();
	return staff_id;
}

/**
 * 获取用户信息
 * @param  {[type]} $obj [description]
 * @return {[type]}      [description]
 */
function get_role_id($obj) {
	var staff_id = $obj.parents("tr").children(".role_id").html();
	return staff_id;
}

/**
 * 获取元素信息
 * @param  {[type]} $obj        [description]
 * @param  {[type]} $class_name [description]
 * @return {[type]}             [description]
 */
function get_text($obj,$class_name) {
	var res = $obj.parents("tr").find($class_name).attr('title');
	return res;
}

/**
 * 弹窗提示
 * @param  {[type]} $msg  [description]
 * @param  {[type]} $code [description]
 * @return {[type]}       [description]
 */
function layer_info($msg,$code) {
	return layer.alert($msg,{title: '提示框',	icon:$code}); 	
}

/**
 * 获取checkbox
 * @param  {[type]} argument [description]on
 * @return {[type]}          [description]
 */
function get_checkbox(argument) {
	var par_id = "";
	$('input:checkbox[name='+argument+']:checked').each(function(i){
	if(0==i){
	par_id = $(this).val();
	}else{
	par_id += (","+$(this).val());
	}
	});
	return $par_id;
}

// 显示
function dd(param = "",type ="") {
	if(type == 1){
		console.log(param);exit;
	}else{
		console.log(param);
	}
}

/**
 * 切换显示
 * @param  {String} code [description]
 * @return {[type]}      [description]
 */
function change_code(code = "") {
	switch(code)
	{
	case '启用':
		return 'no';
	  break;
	case '禁用':
		return 'yes';
	  break;
	case '停用':
		return 'yes';
	  break;
	}
}

