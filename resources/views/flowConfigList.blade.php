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
                <form action="/cflow/flowConfigList" method="get">
                    <div class="search_style">
                        <ul class="search_content clearfix">
                            <li>
                                <label class="l_f">流程配置名称</label>
                                <input name="cflow_name" type="text" class="text_add" placeholder="配置名称" style=" width:350px" />
                            </li>


                            <li>
                                <label class="l_f">创建时间</label>
                                <input class="inline laydate-icon" name="start_time" id="start" style=" margin-left:10px;">
                            </li>
                           
                            <li style="width:90px;">
                                <button type="submit" class="btn_search"><i class="fa fa-search"></i>查询</button>
                            </li>
                            
                        </ul>
                        <button type="button" class="btn btn-xs  btn-default r_f" onclick="back()">上一页</button>
                    </div>
                </form>
            
             <!---->
             <div class="border clearfix">
               <span class="l_f">
                <a href="javascript:void()" id="ads_add" class="btn btn-info"><i class="fa icon-plus"></i>添加流程配置</a>
               </span>
               <span class="r_f">共：<b>{{$count}}</b>条</span>
             </div>

            <!--交易订单列表-->
            <div class="Orderform_list">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                        <tr>
                            <th width="28px">id</th>
                            <th width="180px">标题</th>
                            <th width="150px">当前节点</th>
                            <th width="150px">下个节点</th>
                            <th width="120px">流程</th>
                            <th width="100px">角色</th>
                            <th width="150px">创建时间</th>
                            <th width="150px">节点位置</th>
                            <th width="120px">操作</th></tr>
                    </thead>
                    <tbody>
                        @foreach($cflows as $list)
                        <tr>
                            <td>{{$list['id']}}</td>
                            <td>{{$list['remark']}}</td>
                            <td>{{$list['cflow_name']}}</td>
                            <td>{{$list['node_name']}}</td>
                            <td>{{$list['flow_name']}}</td>
                            <td>{{$list['role_name']}}</td>
                            <td>{{$list['create_time']}}</td>
                            @if($list['position'] == 1)
                            <td>首节点</td>
                            @elseif($list['position'] == 2)
                            <td>中间节点</td>
                            @elseif($list['position'] ==3)
                            <td>尾节点</td>
                            @endif
                            <td>
                                <a title="编辑" href="javascript:;" onclick="cflow_edit(this,'{{$list['id']}}')" class="btn btn-xs  btn-info">
                                    <i class="icon-edit bigger-120"></i>
                                </a>
                                 <a title="删除" href="javascript:;" onclick="cflow_del(this,'{{$list['id']}}')" class="btn btn-xs  btn-warning">
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
            <li id="flow_dis">
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
                <label class="label_name" style="min-width: 85px;">当前节点</label>
                <span class="cont_style">
                    <select class="form-control" id="pre_node" name="pre_node">
                        <option value="">选择节点</option>
                        @foreach($nodes as $list)
                            <option value="{{$list['node_id']}}">{{$list['node_name']}}</option>
                        @endforeach                    
                    </select>
                </span>
            </li>
             <li>
                <label class="label_name" style="min-width: 85px;margin-right: 20px;">节点位置</label>
                    <span class="add_name">
                         <label><input name="node_pos" type="radio" class="ace" value="1"><span  class="lbl">首节点</span></label>&nbsp;&nbsp;&nbsp;
                         <label><input name="node_pos" type="radio" checked="checked" value="2"  class="ace"><span class="lbl">中间节点</span></label>&nbsp;&nbsp;&nbsp;
                         <label><input name="node_pos" type="radio"  class="ace"  value="3" id="node_pos2"><span class="lbl">尾节点</span></label>
                     </span>
                 <div class="prompt r_f"></div>
             </li>

            <li id="next">
                <label class="label_name" style="min-width: 85px;">下一节点</label>
                <span class="cont_style">
                    <select class="form-control" id="next_node" name="next_node">
                        <option value="">选择节点</option>
                        @foreach($nodes as $list)
                            <option value="{{$list['node_id']}}">{{$list['node_name']}}</option>
                        @endforeach                    
                    </select>
                </span>
            </li>
            <script>
               $("input[type='radio']").on('click',function(){
                    var node_pos= $("input[type='radio']:checked").val();
                    if(node_pos !=3){
                        $("#next").css("display",'block');
                    }else{
                         $("#next").css("display",'none');
                    }
                });
            </script>

           
            <li>
                <label class="label_name" style="min-width: 85px;">所属角色</label>
                <span class="cont_style">
                    <select class="form-control" id="role" name="role">
                        <option value="">所属角色</option>
                        @foreach($roles as $list)
                            <option value="{{$list['role_id']}}">{{$list['role_name']}}</option>
                        @endforeach                    
                    </select>
                </span>
            </li>
            <li style="display: none" id="remarks">
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
function cflow_del(obj,id){
    layer.confirm('删除无法恢复，确认要删除吗？',{icon: 2, title:'提示'},function(index){
        var res = ajax_req('/cflow/flowConfigDel',{'id':id});
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

/*编辑*/

function cflow_edit(obj,id){
    var arr={};
    var res = ajax_req('/cflow/flowConfigEdit',{'id':id});
    // console.log($res);return false;
    var cflow = res.data;
    $("#pre_node").val(cflow.pre_node_id);
    $("#next_node").val(cflow.next_node_id);
    $('#role').val(cflow.role_id);
    $('#flow').val(cflow.flow_id);
    $('#remark').val(cflow.remark);
    // $("#remarks").css('display','block');
    $("#flow_dis").css('display','none');
    layer.open({
        type: 1,
        title: '配置编辑',
        maxmin: true,
        shadeClose: false,
        //点击遮罩关闭层
        area: ['800px', ''],
        content: $('#add_ads_style'),
        btn: ['提交', '取消'],
        yes: function(index, layero) {
            var query = new Object();
            query.pre_node_id =  $("#pre_node").val();
            query.next_node_id =  $("#next_node").val();
            query.flow_id = $("#flow").val();
            query.role_id = $('#role').val();
            query.remark = $("#remark").val();
            query.position = $("input[type='radio']:checked").val();
            query.id = id;
            var url = '/cflow/flowConfigEditDone';
            // console.log(query);return false;
            var result = ajax_req(url,query);
            if(result.status ==200){
                layer.alert(result.msg,{title: '提示框',icon:1,},function(){
                    location.reload(); 
                });
            }else{
                layer.alert(result.msg,{title: '提示框',icon:0,});
            }
        }
    });
}

/*******添加流程配置*********/

$('#ads_add').on('click',function() {
    $("#remarks").css('display','none');
    layer.open({
        type: 1,
        title: '流程配置',
        maxmin: true,
        shadeClose: false,
        //点击遮罩关闭层
        area: ['800px', ''],
        content: $('#add_ads_style'),
        btn: ['提交', '取消'],
        yes: function(index, layero) {
            var query = new Object();
            query.flow_id = $("#flow").val();
            query.remark = $("#remark").val();
            query.role_id = $("#role").val();
            query.pre_node = $("#pre_node").val();
            query.next_node = $("#next_node").val();
            query.position = $("input[type='radio']:checked").val();
            /*if(query.flow_id==''){
                tipid("请选择流程");return false;
            }
            if(query.pre_node==''){
                tipid("请选择当前节点");return false;
            }
            if(query.next_node==''){
                tipid("请选择后节点");return false;
            }
            if(query.role_id==''){
                tipid("请选择角色");return false;
            }*/
            var url = '/cflow/addFlowConfig';
            var res = ajax_req(url,query);
            // console.log(result);return false;
            if(res.status ==200){
                layer.alert(res.msg,{title: '提示框',icon:1,},function(){
                    location.reload(); 
                });
            }else{
                layer.alert(res.msg,{title: '提示框',icon:1,});
            }
        }
    });
});

function tipid(msg){
     layer.alert(msg,{title: '提示框',icon:1,});
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

function back() {
    history.back(-1);
}
</script>
@endsection('content')