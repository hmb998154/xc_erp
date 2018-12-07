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


<!--发起子订单-->
<div id="add_ads_style" style="display:block;">
    <div class="add_adverts">
        <ul>
            <li>
                <label class="label_name" style="min-width: 85px;">商品</label>
                <span class="cont_style">
                    <select class="form-control"  id="product_names">
                        <option value="">请选择商品</option>
                        @foreach($orders as $list)
                            <option  value="{{$list['order_id']}}">{{$list['product_name']}}</option>
                        @endforeach
                    </select>
                </span>
                
            </li>
            <li>
                <label class="label_name" style="min-width: 85px;">主订单号</label>
                <span class="cont_style" style="min-width: 200px;">
                    <input name="order_sn" type="text" id="order_sn" value="" disabled="disabled" placeholder="0" class="col-xs-10 col-sm-5" >
                </span>
            </li>
            <li>
                <label class="label_name" style="min-width: 85px;">供应商</label>
                <span class="cont_style">
                    <input name="supplier" type="text" id="supplier" value="" disabled="disabled" placeholder="0" class="col-xs-10 col-sm-5" ></span>
            </li>
            
            <li>
                <label class="label_name" style="min-width: 85px;">商品单价</label>
                <span class="cont_style">
                    <input name="pro_price" type="text" id="pro_price" disabled="disabled" placeholder="0" class="col-xs-10 col-sm-5" style="width:120px"></span>
            </li>
            <li><span>当前商品可用库存 <b id="pro_nums">XX</b> ，锁定库存 <b id="pro_nums_lock">XX</b> </span></li>
            <li>
                <label class="label_name" style="min-width: 85px;">拆分商品数量</label>
                <span class="cont_style" style="width:120px">
                    <input name="pro_num" type="text" id="pro_num" placeholder="0" class="col-xs-10 col-sm-5" style="width:120px">
                </span>
            </li>
            
            <li>
                <label class="label_name" style="margin-right: 15px">备注</label> 
                <span class="cont_style">
                    <textarea name="order_mark" id="order_mark" cols="" rows="" class="textarea" 
                    style="width: 500px;height: 300px; resize: none;border: 1px solid #dddddd;"></textarea>
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



/*更新选择的商品数据*/

$("#product_names").change(function(){
   // console.log($(this).val());
   var query = new Object();
   var url = '/order/ajaxOrder';
   query.order_id = $(this).val();
   var res = hajax(url,query);
   if(res.code==200){
        $("#order_sn").val(res.data.order_sn);
        $("#supplier").val(res.data.supplier);
        $('#pro_price').val(res.data.pro_price);
        $("#pro_nums").text(res.data.pro_num - res.data.pro_num_lock);
        $("#pro_nums_lock").text(res.data.pro_num_lock);
   }
 });
var arrs =1;

/*******发起子订单*********/

$('#child_order_add').on('click',function() {
    layer.open({
        type: 1,
        title: '发起子订单',
        maxmin: true,
        shadeClose: false,
        //点击遮罩关闭层
        area: ['800px', ''],
        content: $('#add_ads_style'),
        btn: ['提交', '取消'],
        yes: function(index, layero) {
            var query = new Object();
            var url = '/order/createChildOrder';
            var pro_num = $("#pro_num").val();
            var pro_nums = $("#pro_nums").text();
            if(parseInt(pro_num) > parseInt(pro_nums)){
                layer.alert("数量不能大于可用库存",{title: '提示框',icon:1,});
                return false;
            }
            query.order_sn = $("#order_sn").val();
            query.pro_num = $("#pro_num").val();
            res = hajax(url,query);
            if(res.code ==200){
                layer.alert(res.msg,{title: '提示框',icon:1,},function(index){
                    location.reload(); 
                });
            }else{
                layer.alert(res.msg,{title: '提示框',icon:1,});
            }
        }
    });
});

/*hajax发送数据*/

function hajax(url,data,type = "post",async = false) {
    $.ajax({
        url:url,
        type:type,
        data:data,
        dataType:'json',
        async : false,
        success:function(res){
            arrs = res;
        },error:function(error){
            console.log(error);
        }
    });
    return arrs;
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