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

<script src="/assets/layer/layui/layui.js" type="text/javascript" ></script>
<link rel="stylesheet" href="/assets/layer/layui/css/layui.css"  media="all">
<div class="page-content clearfix">
    <div class="handling_style" id="order_hand">
        
            <div class="order_list_style" id="order_list_style" style="float: left;margin-left: 0;">
                <form action="/order/orderList" method="get">
                    <div class="search_style">
                        <ul class="search_content clearfix">
                            <li>
                                <input name="order_sn" type="text" class="text_add" placeholder="订单号" style=" width:250px" />
                            </li>
                            <li>
                                <input name="order_plan_sn" type="text" class="text_add" placeholder="计划订单号" style=" width:250px" />
                            </li>
                            <li>
                                <input name="product_name" type="text" class="text_add" placeholder="品名" style=" width:250px" />
                            </li>
                            <li>
                                <label class="l_f">时间</label>
                                <input class="inline laydate-icon" name="start_time" id="start" style=" margin-left:10px;">
                            </li>
                            <li>
                                <label class="l_f">到</label>
                                <input class="inline laydate-icon" name="end_time" id="end" style=" margin-left:10px;">
                            </li>
                            <li>
                                <select name="order_type" class="text_add">
                                    <option value="" >订单种类</option>
                                    <option value="1">主订单</option>
                                     <option value="2">子订单</option>
                                </select>
                            </li>
                            <li>
                                <select name="status" class="text_add">
                                    <option value="" >状态</option>
                                    <option value="1">执行中</option>
                                    <option value="2">已完成</option>
                                    <option value="3">待审核</option>
                                    <option value="3">有异议</option>
                                    <option value="3">售后中</option>
                                </select>
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
                <a href="javascript:void()" id="ads_add" class="btn btn-warning"><i class="fa icon-plus"></i>发起销售订单</a>
                <!-- <a href="javascript:ovid()" class="btn btn-danger"><i class="icon-trash"></i>批量删除</a> -->
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
                                <th width="180px">订单号</th>
                                <th width="180px">品名</th>
                                <th width="80px">数量</th>
                                <th width="80px">单价</th>
                                <th width="100px">金额</th>
                                <th width="120px">订单发起时间</th>
                                <th width="120px">订单完成时间</th>
                                <th width="80px">合同单价</th>
                                <th width="70px">状态</th>
                                <th width="350px">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $list)
                            <tr>
                                <td>
                                    <label>
                                        <input type="checkbox" class="ace">
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <td>{{$list['order_sn']}}</td>
                                <td>{{$list['product_name']}}</td>
                                <td>{{$list['pro_num']}}</td>
                                <td>{{$list['pro_price']}}</td>
                                <td>{{$list['pro_num']*$list['pro_price']}}</td>
                                <td>{{$list['create_time']}}</td>
                                <td></td>
                                <td></td>
                                <td class="td-status">
                                @if($list['order_verify']==1)
                                    <span class="label label-success radius">已审核</span>
                                @else
                                    <span class="label label-success radius">未审核</span>
                                @endif
                                </td>
                                <td>
                                    <a title="添加子订单"   href="javascript:;" onclick="order_child_add(this,'1')"  class="btn btn-xs btn-info order_detailed" >
                                        <i class="fa icon-plus bigger-120">子订单</i>
                                    </a> 
                                    <a onclick="order_service(this,'{{$list["order_id"]}}')" href="javascript:;" title="售后" class="btn btn-xs btn-info order_detailed">
                                        <i class="fa fa-cubes bigger-120">售后</i>
                                    </a>

                                    <a title="追溯" href="javascript:;" onclick="flow_detailed(this,'{{$list['order_id']}}')" class="btn btn-xs btn-info order_detailed">
                                        <i class="fa fa-list bigger-120">追溯</i>
                                    </a>
                                    <a title="删除" href="javascript:;" onclick="Order_form_del(this,'1')" class="btn btn-xs btn-info order_detailed">
                                        <i class="fa fa-trash  bigger-120">详情</i>
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


<!--售后-->
<div id="order_service" style="display:none">
    <div class="add_adverts" style="padding: 2% 3% 0 5%;">
        <label class="l_f" style="margin-bottom: 10px;">请详细描述问题</label>
        <ul>
            <li>
                <span class="cont_style">
                    <textarea name="remark" id="remark" cols="" rows="" class="textarea" 
                    style="width: 400px;height: 200px; resize: none;border: 1px solid #dddddd;"></textarea>
                </span>
            </li>
        </ul>
    </div>
</div>
<!-- 追溯流程 -->
<div id="order_flow_detailed" style="display:none">
    <div class="add_adverts" style="padding: 2% 3% 0 3%;">
        <label class="l_f" style="margin-bottom: 10px;" id="order_sn"></label>
        <table  id="demo" class="table table-striped table-bordered table-hover"  lay-filter="test11" style="padding-bottom: 20px;"></table>
        <script type="text/html" id="toolbartmp">
          <div class="layui-btn-container">
            <button class="layui-btn layui-btn-sm" lay-event="edit">查看</button>
          </div>
        </script>
    </div>
</div>
<script type="text/javascript">
    layui.use('table', function(){
        var table = layui.table;
        window.flow_detailed =function(obj,id){
            var res = ajax_req('/order/orderTrace',{'order_id':id});
            var datas = res.data.nodes;
            var order_sn = res.data.order_sn;
            $("#order_sn").text("订单号："+order_sn);
            console.log(datas);
            if(datas){
                 table.render({
                    elem: '#demo',
                    method:'post',
                    cols: [[
                        {field:'create_time', width:180, title: '时间', sort: true,align:'center'},
                        {field:'node_name', width:150, title: '事件',align:'center'},
                        {field:'role_name', width:120, title: '经办角色', sort: true,align:'center'},
                        {field:'status', width:120, title: '状态',align:'center'},
                       /* {field:'right',  width:175, title: '详情',sort: true,toolbar:"#toolbartmp"}*/
                    ]],
                    data:datas,
                });
            }
            layer.open({
                type: 1,
                title: '追溯',
                maxmin: true,
                shadeClose: false,
                area: ['800px', ''],
                content: $('#order_flow_detailed'),
                yes: function(index, layero) {
                    layer.close(index);
                }
            });
        }

        table.on('tool(test11)', function(obj){
          console.log(obj.data.id);
          test2(obj.data.id);
        });


        
    });
</script>




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

  laydate({
    elem: '#end',
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
            res = ajax_req(url,query);
            if(res.status ==200){
                layer.alert(res.msg,{title: '提示框',icon:1,});
                 location.reload(); 
            }else{
                layer.alert(res.msg,{title: '提示框',icon:1,});
            }
        }
    });
});


/*售后*/
function order_service(obj,id){
    layer.open({
        type: 1,
        title: '售后',
        maxmin: true,
        shadeClose: false,
        //点击遮罩关闭层
        area: ['450px', ''],
        content: $('#order_service'),
        btn: ['提交', '取消'],
        yes: function(index, layero) {
            var query = new Object();
            query.order_id = id;
            var url = '/sys/nodeEditDode';
            console.log(query);return false;
            var result = ajax_req(url,query);
            if(result.status ==200){
                layer.alert('编辑成功',{title: '提示框',icon:1,},function(){
                    location.reload(); 
                });
            }else{
                layer.alert('编辑失败',{title: '提示框',icon:1,});
            }
        }
    });
}

/*售后*/
function test2(id){
    layer.open({
        type: 1,
        title: '售后',
        maxmin: true,
        shadeClose: false,
        //点击遮罩关闭层
        area: ['450px', ''],
        content: $('#order_service'),
        btn: ['提交', '取消'],
        yes: function(index, layero) {
            var query = new Object();
            query.order_id = id;
            var url = '/sys/nodeEditDode';
            console.log(query);return false;
            var result = ajax_req(url,query);
            if(result.status ==200){
                layer.alert('编辑成功',{title: '提示框',icon:1,},function(){
                    location.reload(); 
                });
            }else{
                layer.alert('编辑失败',{title: '提示框',icon:1,});
            }
        }
    });
}

/*追溯*/


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