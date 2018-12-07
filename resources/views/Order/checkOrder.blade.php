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


<div class="margin clearfix">

 <div class="At_button">
	<button onclick="through_save('this','123');" class="btn btn-primary radius" type="submit">通  过</button>
	<button onclick="cancel_save();" class="btn btn-danger  btn-warning" type="button">拒  绝</button>
	<button onclick="return_close();" class="btn btn-default radius" type="button">返回上一步</button>
 </div>
</div>
</body>
</html>
<script>
//通过
var index = parent.layer.getFrameIndex(window.name);
parent.layer.iframeAuto(index);

function through_save(obj, id) {
    layer.confirm('确认通过审核？',function(index) {
    	var query = new Object();
		var url = '/order/orderVerify';
		query.order_id = $(this).val();
		var res = ajax_req(url,query);
		if(res.code==200){
		    $("#order_sn").val(res.data.order_sn);
		    $("#supplier").val(res.data.supplier);
		    $('#pro_price').val(res.data.pro_price);
		    $("#pro_nums").text(res.data.pro_num - res.data.pro_num_lock);
		    $("#pro_nums_lock").text(res.data.pro_num_lock);
		}
         if(res.status ==200){
	        layer.alert(res.msg,{title: '提示框',icon:1,},function(index){
	            location.reload(); 
	        });
	    }else{
	        layer.alert(res.msg,{title: '提示框',icon:1,});
	    }
        parent.$('#parentIframe').css("display", "none");
        parent.$('.Current_page').css({
            "color": "#333333"
        });
    });

}

//返回操作
function return_close() {
    location.href = "/order/todo";
    parent.$('#parentIframe').css("display", "none");
    parent.$('.Current_page').css({
        "color": "#333333"
    });

}
//拒绝
function cancel_save() {
    var index = layer.open({
        type: 1,
        title: '内容',
        maxmin: true,
        shadeClose: false,
        area: ['600px', ''],
        content: ('<div class="shop_reason"><span class="content">请说明拒绝该申请人申请店铺的理由，以便下次在申请时做好准备。</span><textarea name="请填写拒绝理由" class="form-control" id="form_textarea" placeholder="请填写拒绝理由" onkeyup="checkLength(this);"></textarea><span class="wordage">剩余字数：<span id="sy" style="color:Red;">500</span>字</span></div>'),
        btn: ['确定', '取消'],
        yes: function(index, layero) {
            if ($('.form-control').val() == "") {
                layer.alert('回复内容不能为空！', {
                    title: '提示框',
                    icon: 0,
                })
            } else {
                layer.msg('提交成功!', {
                    icon: 1,
                    time: 1000
                });
                layer.close(index);

            }
        }
    })

}
/*字数限制*/
function checkLength(which) {
    var maxChars = 500; //
    if (which.value.length > maxChars) {
        layer.open({
            icon: 2,
            title: '提示框',
            content: '您输入的字数超过限制!',
        });
        // 超过限制的字数了就将 文本框中的内容按规定的字数 截取
        which.value = which.value.substring(0, maxChars);
        return false;
    } else {
        var curr = maxChars - which.value.length; //减去当前输入的
        document.getElementById("sy").innerHTML = curr.toString();
        return true;
    }
};
</script>

@endsection('content')
