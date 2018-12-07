@extends('index')
@section('content')
<script src="/assets/layer/layui/layui.js" type="text/javascript" ></script>
<link rel="stylesheet" href="/assets/layer/layui/css/layui.css"  media="all">
<style>
    .layui-form-label{min-width: 86px;}
    #formId{font-size: 12px;}
    /*.layui-input-inline{min-width: 160px;}*/
    .layui-containers{margin-left: 25px;}
</style>
<blockquote class="layui-elem-quote layui-text" style="margin-bottom: 30px;">
 发起销售订单
</blockquote>
<div class="layui-containers" >
    <form class="layui-form" action="" >
        <div id="formId">
            <div class="row orders" id="order_row">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <div class="layui-input-inline">
                           <select name="pro_id"  lay-verify="required">
                                <option value="">请选择商品</option>
                                @foreach($product as $list)
                                    <option value="{{$list->pro_id}}" >{{$list->product_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" >商品单价</label>
                            <div class="layui-input-inline">
                                <input type="num" name="product_price"  lay-verify="required|number"  autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" >商品数量</label>
                            <div class="layui-input-inline">
                                <input type="num" name="product_num" lay-verify="required|number"   autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" >备注</label>
                            <div class="layui-input-inline">
                                <input type="text" name="remark"    autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <a class="layui-btn    layui-btn-sm" href="javascript:;" onclick="add_row()" lay-event="del"><i class="layui-icon"></i></a>
                        <a class="layui-btn   layui-btn-sm" href="javascript:;" onclick="del_row(this,1)" lay-event="del" style="margin-left: 10px;">删除</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block" style="margin-left: 28%;margin-top:60px;">
              <button class="layui-btn"  lay-submit="" lay-filter="next">下一步</button>
              <button type="reset" onclick="return_last()" class="layui-btn layui-btn-primary">返回</button>
            </div>
        </div>

    </form>



    
</div>
<script type="text/javascript">
layui.use(['form', 'layedit', 'laydate'], function(){
    var form = layui.form
    ,layer = layui.layer
    ,layedit = layui.layedit
    ,laydate = layui.laydate
    ,layer = layui.layer;
    // 商品信息
    form.on('submit(next)', function(data){      
         var query = {};
         var url = "{{route('order.done')}}";
         $(".orders").each(function(i){
            var product_price = $(this).find( "input[name='product_price']").val();
            var pro_id = $(this).find( "select[name='pro_id']").val();
            var product_num = $(this).find( "input[name='product_num']").val();
            var remark = $(this).find( "input[name='remark']").val();
            query[i]= {'product_price':product_price,'pro_id':pro_id,'product_num':product_num,'remark':remark};
         });
        console.log(query);
        var res = ajax_req(url,query,type = "post",async= true, is_check= "no");
        if(res.status==200){
            location.href="{{route('order.next')}}?info="+res.data.info;
        }else{
            location.reload();
        }
        return false;
    });
    var html = $("#formId").html();
    window.add_row =function(){
        $("#formId").append(html);
        form.render();
    }
    window.del_row = function(obj){
        $(obj).parent().parent().remove();
    }
    window.return_last = function(){
        location.href = "{{route('order.list')}}"
    }
});



</script>
</body>

</html>


@endsection('content')
