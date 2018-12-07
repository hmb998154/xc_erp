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
           <form action="/sys/nodeList" method="get">
                    <div class="search_style">
                        <ul class="search_content clearfix">
                            <li>
                                <label class="l_f">节点名称</label>
                                <input name="node_name" type="text" class="text_add" placeholder="节点名称" style=" width:350px" />
                            </li>


                            <li>
                                <label class="l_f">创建时间</label>
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
                <a href="javascript:ovid()" id="ads_add" class="btn btn-info"><i class="fa icon-plus"></i>添加节点</a>
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
                            <th width="150px">节点名称</th>
                            <th width="120px">创建人</th>
                            <th width="150px">创建时间</th>
                            <th width="250px">备注</th>
                            <th width="120px">操作</th></tr>
                    </thead>
                    <tbody>
                        @foreach($nodes as $list)
                        <tr>
                            <td>
                                <label>
                                    <input type="checkbox" value="{{$list['node_id']}}" class="ace">
                                    <span class="lbl"></span>
                                </label>
                            </td>
                            <td>{{$list['node_name']}}</td>
                            <td>{{$list['staff_name']}}</td>
                            <td>{{$list['create_time']}}</td>
                            <td>{{$list['remark']}}</td>
      
                            <td>
                                <a title="编辑" href="javascript:;" onclick="node_edit(this,'{{$list["node_id"]}}')" class="btn btn-xs  btn-info">
                                    <i class="icon-edit bigger-120"></i>
                                </a>
                                 <a title="删除" href="javascript:;" onclick="node_del(this,'{{$list["node_id"]}}')" class="btn btn-xs  btn-warning">
                                    <i class="icon-trash  bigger-120"></i>
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
                <label class="label_name" style="min-width: 85px;">节点名称</label>
                <span class="cont_style">
                    <input name="node_name" type="text" id="node_name" value=""  placeholder="" class="col-xs-10 col-sm-5" ></span>
            </li>
            <li>
                <label class="label_name" style="min-width: 85px;">选择流程</label>
                <span class="cont_style">
                    <select class="form-control" id="flow" name="flow">
                        <option value="">选择流程</option>
                        @foreach($flows as $list)
                            <option value="{{$list['flow_id']}}">{{$list['flow_name']}}</option>
                        @endforeach                    
                    </select>
                </span>
            </li>

        
 
            <li>
                <label class="label_name" style="margin-right: 15px">备注</label> 
                <span class="cont_style">
                    <textarea name="remark" id="remark" cols="" rows="" class="textarea" 
                    style="width: 400px;height: 200px; resize: none;border: 1px solid #dddddd;"></textarea>
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
 $(".order_list_style").height($(window).height()-120);
  //当文档窗口发生改变时 触发  
    $(window).resize(function(){
  $(".widget-box").height($(window).height());
   $(".order_list_style").width($(window).width()-234);
    $(".order_list_style").height($(window).height()-30);
});

/*节点-删除*/
function node_del(obj,id){
    layer.confirm('删除无法恢复，确认要删除吗？',{icon: 2, title:'提示'},function(index){
        // 调用函数
        var res = ajax_req('/sys/nodeDel',{'node_id':id});
        if(res.status != 200){
          layer.alert('删除失败',{title: '提示框', icon:2}); exit;
        }else{
            $(obj).parents("tr").remove();
            layer.alert('删除成功',{title: '提示框',icon:1,},function(index){
                layer.close(index);
            });
        }
    });
}

/*节点编辑*/
function node_edit(obj,id){
    var arr={};
    var res = ajax_req('/sys/nodeEdit',{'node_id':id});
    var node = res.data;
    $("#node_name").val(node.node_name);
    $('#flow').val(node.flow_id);
    $('#remark').val(node.remark);
    layer.open({
        type: 1,
        title: '编辑节点',
        maxmin: true,
        shadeClose: false,
        //点击遮罩关闭层
        area: ['800px', ''],
        content: $('#add_ads_style'),
        btn: ['提交', '取消'],
        yes: function(index, layero) {
            var query = new Object();
            query.node_name = $("#node_name").val();
            query.flow_id = $("#flow").val();
            query.remark = $("#remark").val();
            query.node_id = id;
            var url = '/sys/nodeEditDode';
            var result = ajax_req(url,query);
            if(result.status ==200){
                layer.alert(result.msg,{title: '提示框',icon:1,},function(){
                    location.reload(); 
                });
            }else{
                layer.alert(result.msg,{title: '提示框',icon:1,});
            }
        }
    });
}

var arrs =1;

/*******添加节点*********/

$('#ads_add').on('click',function() {
    layer.open({
        type: 1,
        title: '添加节点',
        maxmin: true,
        shadeClose: false,
        //点击遮罩关闭层
        area: ['800px', ''],
        content: $('#add_ads_style'),
        btn: ['提交', '取消'],
        yes: function(index, layero) {
            var query = new Object();
            query.node_name = $("#node_name").val();
            query.flow_id = $("#flow").val();
            query.remark = $("#remark").val();
/*            if(query.node_name ==''){
                layer.alert('节点名称不能为空');return false;
            }
            if(query.flow_id ==''){
                layer.alert('请选择流程');return false;
            }*/
            var url = '/sys/addNode';
            res = ajax_req(url,query);
            if(res.status == 200){
                layer.alert(res.msg,{title: '提示框',icon:1,},function(){
                    location.reload(); 
                });
            }else{
                console.log(res);
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