@extends('index')
@section('content')
<script src="/assets/js/typeahead-bs2.min.js"></script>
<!-- page specific plugin scripts -->


<!-- <script type="text/javascript" src="js/H-ui.js"></script>  -->
<!-- <script type="text/javascript" src="/js/H-ui.admin.js"></script>  -->

<script src="/assets/layer/layer.js" type="text/javascript" ></script>
<script src="/assets/laydate/laydate.js" type="text/javascript"></script>
<div class="page-content clearfix">
    <div class="handling_style" id="order_hand">
        <div class="order_list_style" id="order_list_style" style="float: left;margin-left: 0;">
           <form action="/pro/productScheduleList" method="get">
                    <div class="search_style">
                        <ul class="search_content clearfix">
                            <li>
                                <input name="product_name" type="text" class="text_add" placeholder="商品名称" style=" width:250px" />
                            </li>

                            <li style="display: none;">
                                <label class="l_f">时间</label>
                                <input class="inline laydate-icon" name="start_time" id="start" style=" margin-left:10px;">
                            </li>

                            <li>
                                <select name="status" class="text_add">
                                    <option value="" >申报状态</option>
                                    <option value="1">待审核</option>
                                     <option value="2">补充资料</option>
                                     <option value="3">已驳回</option>
                                     <option value="4">已上架</option>
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
                <!-- <a href="javascript:ovid()" class="btn btn-danger"><i class="icon-trash"></i>批量删除</a> -->
               </span>
               <span class="r_f">共：<b>{{$count}}</b>条</span>
             </div>
            <!--交易订单列表-->
            <div class="Orderform_list">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                        <tr>
                            <th width="50px">商品编号</th>
                            <th width="120px">商品名称</th>
                            <th width="120px">提交时间</th>
                            <th width="120px">申报状态</th>
                            <th width="120px">操作</th>
                    </thead>
                    <tbody>
                        @foreach($products as $list)
                        <tr>
                            <td>{{$list->pro_id}}</td>
                            <td>{{$list->product_name}}</td>
                            <td>{{$list->create_time}}</td>
                            <td>
                                @if($list->status == 1)
                                    待审核
                                @elseif($list->status ==2)
                                    补充资料
                                @elseif($list->status ==3)
                                    已驳回
                                @elseif($list->status ==4)
                                    已上架
                                @endif
                            </td>
                            <td>
                                 <a title="查看祥情" href="/pro/productDetailed?pro_id={{$list->pro_id}}"  class="btn btn-xs  btn-info">
                                    <i class=" ">查看祥情</i>
                                </a>
                                @if($list->status == 1 || $list->status==3)
                                 <a title="待审核" href="javascript:;" onclick="product_check(this,'{{$list->pro_id}}')" class="btn btn-xs  btn-info">
                                    <i class=" ">待审核</i>
                                </a>

                                @endif
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
                <label class="label_name" style="min-width: 85px;">销售订单编号</label>
                <span class="cont_style">
                    <input name="order_sn" type="text" id="order_sn" value="" disabled="disabled" placeholder="0" class="col-xs-10 col-sm-5" ></span>
            </li>
            <li>
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

            <span class="cont_style">
            <select class="form-control" id="product_name">
                <option value="">选择商品</option>
                <option value="123">123</option>
                <option value="456">456</option>
                <option value="789">789</option>
                </select>
            </span>
            </li>
            <li><span>当前商品可用库存XX，锁定库存XX</span></li>
            <li>
                <label class="label_name" style="min-width: 85px;">输入商品数量</label>
                <span class="cont_style" style="width:120px">
                    <input name="pro_num" type="text" id="pro_num" placeholder="0" class="col-xs-10 col-sm-5" style="width:120px">
                </span>
            </li>
            <li>
                <label class="label_name" style="min-width: 85px;">输入商品单价</label>
                <span class="cont_style">
                    <input name="pro_price" type="text" id="pro_price" placeholder="0" class="col-xs-10 col-sm-5" style="width:120px"></span>
            </li>
            <li>
                <label class="label_name" style="margin-right: 15px">备注</label>
                <span class="cont_style">
                    <textarea name="order_mark" id="order_mark" cols="" rows="" class="textarea"
                    style="width: 500px;height: 300px; resize: none;border: 1px solid #dddddd;height: 200px;width: 450px;">
                    </textarea>
                </span>
            </li>

        </ul>
    </div>
</div>



<!--审核-->
<div id="pro_check" style="display:none">
    <div class="add_adverts" style="padding: 2% 3% 0 5%;">
        <!-- <label class="l_f" style="margin-bottom: 10px;">备注</label>
        <ul>
            <li>
                <span class="cont_style">
                    <textarea name="remark" id="remark" cols="" rows="" class="textarea"
                    style="width: 400px;height: 200px; resize: none;border: 1px solid #dddddd;"></textarea>
                </span>
            </li>
        </ul> -->
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
    $(".order_list_style").height($(window).height()-120);
});

/**
 * [product_check 审核]
 *
 * @return {[type]} [description]
 */
function product_check(obj,pro_id){
    var query = new Object();
    query.pro_id = pro_id;
    query.status = 2;
    var url = '/pro/productEditDone';
    layer.open({
        type: 1,
        title: '审核商品',
        maxmin: true,
        shadeClose: false,
        //点击遮罩关闭层
        area: ['450px', ''],
        content: $('#pro_check'),
        btn: ['通过', '驳回','取消'],
        yes: function(index, layero) {
            var res = ajax_req(url,query,type = "post",async= true, is_check= "no");
            if(res.status ==200){
                layer.alert(res.msg,{title: '提示框',icon:1,},function(){
                    location.reload();
                });
            }else{
                layer.alert(res.msg,{title: '提示框',icon:1,});
            }
        },
        btn2: function(index, layero){
            query.status =3;
            var res = ajax_req(url,query,type = "post",async= true, is_check= "no");
            if(res.status ==200){
                layer.alert(res.msg,{title: '提示框',icon:1,},function(){
                    location.reload();
                });
            }else{
                layer.alert(res.msg,{title: '提示框',icon:1,});
            }
            //return false 开启该代码可禁止点击该按钮关闭
        }
    });
}


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
        var url = '/order/salesOrderAdd';
        res = ajax_req(url,query);
        if(res.code ==200){
            layer.alert(res.msg,{title: '提示框',icon:1,});
             location.reload();
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