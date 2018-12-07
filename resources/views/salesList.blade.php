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
            <div class="search_style">
                <ul class="search_content clearfix">
                    <li>
                        <label class="l_f">订单编号</label>
                        <input name="" type="text" class="text_add" value="" placeholder="输入订单编号" style=" width:250px" /></li>
                    <li>
                        <label class="l_f">交易时间</label>
                        <input class="inline laydate-icon" id="start" style=" margin-left:10px;"></li>
                    <li style="width:90px;">
                        <button type="button" class="btn_search">
                            <i class="fa fa-search"></i>查询</button>
                    </li>
                </ul>
            </div>

             <!---->
             <div class="border clearfix">
               <span class="l_f">
                <a href="javascript:void()" id="ads_add" class="btn btn-warning"><i class="fa fa-plus"></i>发起销售订单</a>
                <!-- <a href="javascript:ovid()" class="btn btn-danger"><i class="icon-trash"></i>批量删除</a> -->
               </span>
               <span class="r_f">共：<b>{{$count}}</b>条</span>
             </div>
             <!---->
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
                            <th width="120px">销售订单编号</th>
                            <th width="120px">供货商名称</th>
                            <th width="250px">商品名称</th>
                            <th width="100px">发起时间</th>
                            <th width="100px">可用库存</th>
                            <th width="100px">锁定库存</th>
                            <th width="80px">订单数量</th>
                            <th width="80px">单价</th>
                            <th width="70px">状态</th>
                            <th width="100px">备注</th>
                            <th width="150px">操作</th></tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <label>
                                    <input type="checkbox" class="ace">
                                    <span class="lbl"></span>
                                </label>
                            </td>
                            <td>{{$order['order_sn']}}</td>
                            <td class="order_product_name">
                                {{$order['supplier']}}
                            </td>
                            <td>{{$order['product_name']}}</td>
                            <td>{{$order['create_time']}}</td>
                            <td>{{$order['pro_num']}}</td>
                            <td>{{$order['pro_num']}}</td>
                            <td>{{$order['pro_num']}}</td>
                            <td>{{$order['pro_price']}}</td>
                            <td class="td-status">
                                @if($order['order_verify']==1)
                                    <span class="label label-success radius">已审核</span>
                                @else
                                    <span class="label label-success radius">未审核</span>
                                @endif
                            </td>
                            <td>{{$order['order_mark']}}</td>
                            <td>
                                <a title="作废" href="javascript:;" onclick="Order_form_del(this,'1')" class="btn btn-xs btn-warning">
                                    <i class="fa fa-trash  bigger-120">作废</i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {!! $pages->links() !!}
        </div>
    </div>
</div>


<!--发起销售订单-->
<div id="add_ads_style" style="display:none">
    <div class="add_adverts">
        <ul>
            <li>
                <label class="label_name" style="min-width: 85px;">订单编号</label>
                <span class="cont_style">
                    <input name="order_sn" type="text" id="order_sn" value="{{$order_sn}}" disabled="disabled" placeholder="0" class="col-xs-10 col-sm-5" ></span>
            </li>
            <li>
                <label class="label_name" style="min-width: 85px;">流程</label>
                <span class="cont_style">
                    <select class="form-control" id="flows">
                        <option value="">选择流程</option>
                        @foreach($flows as $flow)
                            <option value="{{$flow['flow_id']}}">{{$flow['flow_name']}}</option>
                        @endforeach
                    </select>
                </span>
                
            </li>
            <li>
                <label class="label_name" style="min-width: 85px;">供应商</label>
                <span class="cont_style">
                    <select class="form-control" id="supplier">
                        <option value="">选择供应商</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </span>
                
            </li>
            <li>
                <label class="label_name" style="min-width: 85px;">商品</label>   
                <span class="cont_style">
                    <select class="form-control" id="product_name">
                        <option value="">选择商品</option>
                        <option value="123">123</option>
                        <option value="456">456</option>
                        <option value="789">789</option>
                    </select>
                </span>
            </li>
            <li><span style="padding: 4%;">当前商品可用库存XX，锁定库存XX</span></li>
            <li>
                <label class="label_name" style="min-width: 85px;">商品数量</label>
                <span class="cont_style" style="width:120px">
                    <input name="pro_num" type="text" id="pro_num" placeholder="0" class="col-xs-10 col-sm-5" style="width:120px">
                </span>
            </li>
            <li>
                <label class="label_name" style="min-width: 85px;">商品单价</label>
                <span class="cont_style">
                    <input name="pro_price" type="text" id="pro_price" placeholder="0" class="col-xs-10 col-sm-5" style="width:120px"></span>
            </li>
            <li>
                <label class="label_name" style="margin-right: 15px">备注</label> 
                <span class="cont_style">
                    <textarea name="order_mark" id="order_mark" cols="" rows="" class="textarea" 
                    style="width: 400px;height: 150px; resize: none;border: 1px solid #dddddd;"></textarea>
                </span>
            </li>
           
        </ul>
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
 $(".order_list_style").height($(window).height()-30);
  //当文档窗口发生改变时 触发  
    $(window).resize(function(){
  $(".widget-box").height($(window).height());
   $(".order_list_style").width($(window).width()-234);
    $(".order_list_style").height($(window).height()-30);
});


/*******发起销售订单*********/

$('#ads_add').on('click',function() {
    layer.open({
        type: 1,
        title: '发起销售订单',
        maxmin: true,
        shadeClose: false,
        //点击遮罩关闭层
        area: ['800px', ''],
        content: $('#add_ads_style'),
        btn: ['提交', '取消'],
        yes: function(index, layero) {
            var query = new Object();
            query.order_sn = $("#order_sn").val();
            query.supplier = $("#supplier").val();
            query.product_name = $("#product_name").val();
            query.pro_num = $("#pro_num").val();
            query.pro_price = $("#pro_price").val();
            query.order_mark = $("#order_mark").val();
            query.flow_id = $("#flows").val();
            var url = '/order/salesOrderAdd';
            result = ajax_req(url,query);
            if(result.status ==200){
                layer.alert('添加成功',{title: '提示框',icon:1,});
                 location.reload(); 
            }else{
                layer.alert('操作失败',{title: '提示框',icon:1,});
            }
        }
    });
});


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