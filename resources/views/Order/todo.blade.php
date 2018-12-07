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
    <div class="handling_style" id="order_hand">
        <div class="order_list_style" id="order_list_style" style="float: left;margin-left: 0;">
           <form action="/order/todo" method="get">
                    <div class="search_style">
                        <ul class="search_content clearfix">
                            <li>
                            	<label class="l_f">订单号</label>
                                <input name="order_sn" type="text" class="text_add" placeholder="订单号" style=" width:350px" />
                            </li>

                            <li>
                                <label class="l_f">时间</label>
                                <input class="inline laydate-icon" name="start_time" id="start" style=" margin-left:10px;">
                            </li>
                            <li style="width:90px;">
                                <button type="submit" class="btn_search"><i class="fa fa-search"></i>查询</button>
                            </li>
                        </ul>
                    </div>
                </form>
             <!---->
             <div class="border clearfix">
               <span class="l_f">
<!--                 <a href="javascript:ovid()" id="ads_add" class="btn btn-info"><i class="fa icon-plus"></i>添加节点</a> -->
               </span>
               <span class="r_f">共：<b>{{$count}}</b>条</span>
             </div>

            <!--交易订单列表-->
            <div class="Orderform_list">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                        <tr>
                            <th width="25px">
                                <label>
                                    <input type="checkbox" class="ace">
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            <th width="100px">待办事项</th>
                            <th width="100px">订单号</th>
                            <th width="100px">创建人</th>
                             <th width="100px">激活时间</th>
                             <th width="100px">工作流</th>
                            <th width="300px">操作</th></tr>
                    </thead>
                    <tbody>
                    	@foreach($task as $list)
                        <tr>
                            <td>
                                <label>
                                    <input type="checkbox" class="ace">
                                    <span class="lbl"></span>
                                </label>
                            </td>
                            <td>{{$list['node_name']}}</td>
                            <td>{{$list['order_sn']}}</td>
                            <td>{{$list['staff_name']}}</td>
                            <td>{{$list['active_time']}}</td>
                            <td>{{$list['flow_name']}}</td>
                            <td>
                                <a title="详细" href="/order/orderTodo?id={{$list['id']}}"  class="btn btn-xs btn-info Refund_detailed">
  								{{$list['node_name']}}
                                </a>
                               
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $pages->links() !!}
            </div>
        </div>
    </div>
</div>

</body>

</html>
<script>
$(function() { 
  $("#order_hand").fix({
    float : 'left',
    //minStatue : true,
    skin : 'green', 
    durationTime :false,
    spacingw:30,//设置隐藏时的距离
      spacingh:250,//设置显示时间距
    table_menu:'.order_list_style',
  });
});


//时间
 laydate({
    elem: '#start',
    event: 'focus' 
});

//初始化宽度、高度  
 $(".widget-box").height($(window).height()); 
$(".order_list_style").width($(window).width()-220);
 $(".order_list_style").height($(window).height()-120);
  //当文档窗口发生改变时 触发  
    $(window).resize(function(){
  $(".widget-box").height($(window).height());
   $(".order_list_style").width($(window).width()-234);
    $(".order_list_style").height($(window).height()-30);
});


/*******操作*********/

function goto_done(obj,id,node_name){
	if(node_name=="审核订单"){
		var actions ='#order_check';
	}
	if(node_name=="采购子订单"){
		var actions = '#order_child';
	}
	layer.open({
        type: 1,
        title: node_name,
        maxmin: true,
        shadeClose: false,
        //点击遮罩关闭层
        area: ['800px', ''],
        content: $(actions),
        btn: ['提交', '取消'],
        yes: function(index, layero) {
            var query = new Object();
            query.order_sn = $("#order_sn").val();
            query.supplier = $("#supplier").val();
            query.product_name = $("#product_name").val();
            query.pro_num = $("#pro_num").val();
            query.pro_price = $("#pro_price").val();
            query.order_mark = $("#order_mark").val();
            var url = '/order/salesOrderAdd';
            res = ajax_req(url,query);
            if(res.status ==200){
                layer.alert(res.msg,{title: '提示框',icon:1,});
                 location.reload(); 
            }
        }
    });
}


//订单列表
jQuery(function($) {
    var oTable1 = $('#sample-table').dataTable( {
    "aaSorting": [[ 1, "desc" ]],//默认第几个排序
    "bStateSave": true,//状态保存
    "aoColumnDefs": [
      //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
      {"orderable":false,"aTargets":[0,2,3,4,5,6,8,9]}// 制定列不参与排序
    ] } );
                 //全选操作
        $('table th input:checkbox').on('click' , function(){
          var that = this;
          $(this).closest('table').find('tr > td:first-child input:checkbox')
          .each(function(){
            this.checked = that.checked;
            $(this).closest('tr').toggleClass('selected');
          });
            
        });
      });
</script>
@endsection('content')