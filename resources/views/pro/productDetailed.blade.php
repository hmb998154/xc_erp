@extends('index')
@section('content')
<script src="/assets/layer/layui/layui.js" type="text/javascript" ></script>
<script src="/assets/js/elevatezoom/jquery.elevateZoom-3.0.8.min.js" type="text/javascript" ></script>
<link rel="stylesheet" href="/assets/layer/layui/css/layui.css"  media="all">
<style type="text/css">
    .layui-form-label{padding: 0;};
    #layui-upload-img{width: 92px;height: 92px;margin: 0 10px 10px 0;}
    .layui-input-inline{min-width: 300px;}
    hr{background: #6f6f6f;max-width: 800px;margin-bottom: 15px;margin-top: 15px;}
</style>
<div class="layui-tab layui-tab-brief">
    <ul class="layui-tab-title" style="background: #eee;">
        <li class="layui-this">商品信息</li>
        <li>留言板</li>
        <li>送检信息</li>
    </ul>
    <div class="layui-tab-content">

        <!-- tab1 -->
        <div class="layui-tab-item layui-show">
            <div class="layui-container">
                <form class="layui-form" action="" style="padding-top: 50px;">
                    <label class="layui-form-label">
                        <b>商品信息</b>
                    </label>
                    <hr>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">商品名称（必填）</label>
                            <div class="layui-input-inline">
                                <input type="text" name="product_name" id="product_name" autocomplete="off" value="{{$product['product_name']}}" class="layui-input"></div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">商品型号</label>
                            <div class="layui-input-inline">
                                <input type="text" name="product_model"  value="{{$product['product_model']}}" autocomplete="off" class="layui-input"></div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">商品价格</label>
                            <div class="layui-input-inline">
                                <input type="text" name="product_fee" value="{{$product['product_fee']}}"  autocomplete="off" class="layui-input"></div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">商品69码</label>
                            <div class="layui-input-inline">
                                <input type="text" name="product_six_nine_code" value="{{$product['product_six_nine_code']}}"  autocomplete="off" class="layui-input"></div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">平台商家编码</label>
                            <div class="layui-input-inline">
                                <input type="text" name="product_code" value="{{$product['product_code']}}"  autocomplete="off" class="layui-input"></div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">商品材质</label>
                            <div class="layui-input-inline">
                                <input type="text" name="product_material" value="{{$product['product_material']}}"   autocomplete="off" class="layui-input"></div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">商品货号</label>
                            <div class="layui-input-inline">
                                <input type="text" name="product_art_no"   value="{{$product['product_art_no']}}"  autocomplete="off" class="layui-input"></div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">商品条码</label>
                            <div class="layui-input-inline">
                                <input type="text" name="product_bar_code"    value="{{$product['product_bar_code']}}" autocomplete="off" class="layui-input"></div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">商品参数</label>
                            <div class="layui-input-inline">
                                <input type="text" name="product_parm"   value="{{$product['product_parm']}}" autocomplete="off" class="layui-input"></div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">送检费用</label>
                            <div class="layui-input-inline">
                                <input type="text" name="check_fee"   value="{{$product['check_fee']}}" autocomplete="off" class="layui-input"></div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">商品尺寸</label>
                            <div class="layui-input-inline">
                                <input type="text" name="product_size"  value="{{$product['product_size']}}" autocomplete="off" class="layui-input"></div>
                        </div>

                        <div class="layui-inline">
                            <label class="layui-form-label">商品品牌</label>
                            <div class="layui-input-inline">
                                <select name="brand_id"  lay-search="" >
                                  <option value=""></option>
                                    @foreach($brand  as $list)
                                    <option value="{{$list->brand_id}}" @if($product['brand_id']== $list->brand_id) selected = "selected" @endif> {{$list->brand_name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">商品规格</label>
                            <div class="layui-input-inline">
                                <input type="text" name="product_specifications"  value="{{$product['product_specifications']}}" autocomplete="off" class="layui-input"></div>
                        </div>

                        <div class="layui-inline">
                            <label class="layui-form-label">商品类目</label>
                            <div class="layui-input-inline">
                                <select name="cate_id"  lay-search="" >
                                  <option value=""></option>
                                  @foreach($cate  as $list)
                                  <option value="{{$list->cate_id}}" @if($product['cate_id'] == $list->cate_id) selected ="selected" @endif>{{$list->cate_name}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <label class="layui-form-label">商品封样</label>
                    <div class="layui-upload" style="margin-left: 120px;">
                        <button type="button" class="layui-btn" id="pro_pic1">上传图片</button>
                        <div class="layui-upload-list">
                            <img class="layui-upload-img" src="{{asset($product['product_bar_code_min_img'])}}" id="pro_src1"
                            style="width: 92px;height: 92px;margin: 0 10px 10px 0;">
                            <p id="demoText"></p>
                        </div>
                    </div>
                    <label class="layui-form-label">
                        <b>工厂信息</b>
                    </label>
                    <hr>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">工厂名称</label>
                            <div class="layui-input-inline">
                                <select name="factory_id" lay-filter="supplier">
                                    <option value="">请选择工厂</option>
                                    @foreach($supplier as $list)
                                        <option value="{{$list->supplier_id}}"  @if($product['factory_id'] == $list->supplier_id) selected = "selected" @endif >{{$list->factory_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">工厂货号</label>
                            <div class="layui-input-inline">
                                <input type="text" id="factory_code" value="{{$product['factory_code']}}" autocomplete="off" class="layui-input" disabled="disabled"></div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">工厂地址</label>
                            <div class="layui-input-inline" style="min-width:700px;">
                                <input type="text" id="factory_address"  value="{{$product['factory_address']}}" autocomplete="off" class="layui-input" disabled="disabled"></div>
                        </div>
                    </div>
                    <label class="layui-form-label">
                        <b>包装信息</b>
                    </label>
                    <hr>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">包装尺寸</label>
                            <div class="layui-input-inline" style="min-width:700px;">
                                <input type="text" name="packing_size"  value="{{$product['packing_size']}}" autocomplete="off" class="layui-input"></div>
                        </div>
                    </div>
                    <label class="layui-form-label">包装图片</label>
                    <div class="layui-upload" style="margin-left: 120px;">
                        <button type="button" class="layui-btn" id="pro_pic2">上传图片</button>
                        <div class="layui-upload-list">
                            <img class="layui-upload-img" src="{{asset($product['packing_min_img'])}}" id="pro_src2" style="width: 92px;height: 92px;margin: 0 10px 10px 0;">
                            <p id="demoText2"></p>
                        </div>
                    </div>
                    <div class="layui-form-item" style="padding-left:25%;margin-top:50px; margin-bottom: 200px;">
                        <div class="layui-input-block">
                            <input type="hidden" name="product_bar_code_img" id="product_bar_code_img" autocomplete="off" class="layui-input">
                            <input type="hidden" name="packing_img" id="packing_img" autocomplete="off" class="layui-input">
                            <input type="hidden" name="pro_id" value="{{$product['pro_id']}}" id="product_id" autocomplete="off" class="layui-input">
                            @if($product['lock_code'] != 2)
                                <button class="layui-btn" lay-submit="" lay-filter="product_info">保存信息</button>
                                <button type="layui-btn" class="layui-btn layui-btn-primary" lay-submit=""  lay-filter="product_lock">锁定数据</button>
                            @else
                                <input type="layui-btn" class="layui-btn layui-btn-primary" value="数据已锁定" disabled="disabled">
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- tab2 -->
        <div class="layui-tab-item">
            <div class="layui-container">
                <form class="layui-form" action="" style="padding-top: 50px;">
                     <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">留言信息</label>
                        <div class="layui-input-block">
                          <textarea  class="layui-textarea" id="remark_show" style="min-width:500px;min-height: 300px; max-width: 650px;" disabled="disabled">@foreach($remark as $list) {{$list->create_time}}  {{$list->staff_name}}    {{$list->remark}}  &#10 @endforeach</textarea>
                        </div>
                      </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                              <input type="text" name="remark" id="remark" lay-verify="required" autocomplete="off" style="max-width:630px;" placeholder="请输入留言内容" class="layui-input">
                            </div>
                        </div>
                      <div class="layui-form-item" style="padding-left:25%;margin-top:50px; margin-bottom: 100px;">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="product_remark">提交留言</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- tab3 -->
        <div class="layui-tab-item">
            <div class="layui-container">
                <form class="layui-form" action="" style="padding-top: 50px;">
                    <div class="layui-btn-group demoTable" style="padding-top: 30px;">
                      <button class="layui-btn" data-type="getCheckData" id="check_in">送检录入</button>
                    </div>

                    <div class="layui-form">
                      <table class="layui-table">
                        <colgroup>
                          <col width="150">
                          <col width="150">
                          <col width="200">
                          <col >
                        </colgroup>
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>商品名称</th>
                            <th>检测机购</th>
                            <th>状态</th>
                          </tr>
                        </thead>
                        <tbody id="tbodys">
                            @foreach($check as $list)
                              <tr>
                                <td>{{$list->check_id}}</td>
                                <td >{{$list->product_name}}</td>
                                <td>{{$list->check_name}}</td>
                                <td>
                                    @if($list->check_status==1)
                                        未送检
                                    @elseif($list->check_status ==2)
                                        已送检
                                    @endif
                                </td>
                              </tr>
                            @endforeach
                        </tbody>
                      </table>
                    </div>

                    <div style="margin-top:50px; position: absolute;">
                        <label class="layui-form-label" ><b>送检图片</b></label>
                        <div class="layui-upload" style="margin-left: 120px;">
                            <button type="button" class="layui-btn" id="pro_pic3">上传图片</button>
                            <div class="layui-upload-list">
                               <a href="{{asset($product['check_img'])}}" target="_blank"><img class="layui-upload-img" src="{{asset($product['check_img'])}}" id="pro_src3"  data-zoom-image="{{asset($product['check_img'])}}" style="width: 92px;height: 92px;margin: 0 10px 10px 0;"></a>
                                <p id="demoText3"></p>
                            </div>
                        </div>

                        <div class="layui-form-item" id="checkIn" style="display: none; position: relative;left: 280px; top: -165px;">
                            <div class="layui-inline">
                                <label class="layui-form-label">送检日期</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="check_time" id="check_time"  lay-verify="required"  id="check_time" autocomplete="off" class="layui-input"></div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">状态类型</label>
                                <div class="layui-input-inline">
                                    <select name="check_status" lay-verify="required" id="check_status">
                                         <option value=""></option>
                                        <option value="1">未送检</option>
                                        <option value="2">已送检</option>
                                    </select>
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">送检机构</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="check_name" id="check_name" lay-verify="required" autocomplete="off" class="layui-input"></div>
                            </div>


                            <div class="layui-form-item" style="position: relative;left: 280px; top: 30px;" >
                                <div class="layui-input-block">
                                    <input type="hidden" name="check_img" id="check_img" autocomplete="off" class="layui-input">
                                    <button class="layui-btn" lay-submit="" lay-filter="product_check_recode">确定</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
                    <div class="layui-form-item" style="position: relative;left: 30%;top: 350px;">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="check_confirm">申购确认</button>
                            <button type="reset" class="layui-btn layui-btn-primary"><a href="/pro/productScheduleList">返 回</a></button>
                        </div>
                    </div>

                    <script type="text/javascript">
                        $('#check_in').on("click",function(){
                            $("#checkIn").css('display','block');
                            return false;
                        })
                    </script>

            </div>
        </div>

    </div>
</div>

<script type="text/javascript">


 $("#pro_src3").elevateZoom({
    scrollZoom : true,
    zoomWindowWidth:600,
    zoomWindowHeight:400
});

layui.use(['upload','form','element','table','laydate','layer'], function() {
        var form = layui.form;
        var $ = layui.jquery,
        upload = layui.upload,
        element = layui.element,
        table = layui.table,
        laydate = layui.laydate,
        layer = layui.layer;

        //日期
        laydate.render({
            elem: '#check_time'
        });
        form.on('select(supplier)', function(data){
            var id = data.value;
            var url = '/pro/ajaxGetSupplier';
            var query = {'id':id};
            if(id>0){
                var res = ajax_req(url,query,type = "post",async = true , is_check = "no");
                if(res.status==200){
                    console.log(res.data.factory_address);
                    $("#factory_code").val(res.data.factory_code);
                    $("#factory_address").val(res.data.factory_address);
                }
            }
        });

        //图片上传
        var uploadInst = upload.render({
            elem: '#pro_pic1',
            url: '/pro/newProduct',
            before: function(obj) {
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result) {
                    $('#pro_src1').attr('src', result); //图片链接（base64）
                });
            },
            done: function(res) {
                if(res.status ==200){
                    console.log(res.data.pic);
                    $("#product_bar_code_img").val(res.data.pic);
                    return layer.msg('上传成功');
                 }else{
                    return layer.msg('上传失败');
                 }
            },
            error: function() {
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click',
                function() {
                    uploadInst.upload();
                });
            }
        });

         //图片上传
        var uploadInst = upload.render({
            elem: '#pro_pic2',
            url: '/pro/newProduct',
            before: function(obj) {
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result) {
                    $('#pro_src2').attr('src', result); //图片链接（base64）
                });
            },
            done: function(res) {
               if(res.status ==200){
                    console.log(res.data.pic);
                    $("#packing_img").val(res.data.pic);
                    return layer.msg('上传成功');
                 }else{
                    return layer.msg('上传失败');
                 }
            },
            error: function() {
                //演示失败状态，并实现重传
                var demoText = $('#demoText2');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click',
                function() {
                    uploadInst.upload();
                });
            }
        });

        //送检图片上传
        var uploadInst = upload.render({
            elem: '#pro_pic3',
            url: '/pro/newProduct',
            before: function(obj) {
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result) {
                    $('#pro_src3').attr('src', result); //图片链接（base64）
                });
            },
            done: function(res) {
               if(res.status ==200){
                    $("#check_img").val(res.data.pic);
                    var query = new Object();
                    query.pro_id = $("#product_id").val();
                    query.check_img = $("#check_img").val();
                    var urls = '/pro/checkImgUpload';
                    var result  = ajax_req(urls,query,type ="post",async = true,is_check ="no");
                    if(result.status==200){
                        $("#check_img").val(res.data.pic);
                        return layer.msg('上传成功');
                    }else{
                         return layer.msg('上传失败');
                    }
                 }else{
                    return layer.msg('上传失败');
                 }
            },
            error: function() {
                //演示失败状态，并实现重传
                var demoText = $('#demoText3');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click',
                function() {
                    uploadInst.upload();
                });
            }
        });

        // 商品信息
        form.on('submit(product_info)', function(data){
            var query = data.field;
            var url = '/pro/productEditDone';
            var res = ajax_req(url,query,type = "post",async = true , is_check = "no");
            if(res.status == 200){
                 layer.alert(res.msg,{title: '提示框',icon:1,},function(){
                    location.reload();
                });
            }else{
                layer.alert(res.msg,{title: '提示框',icon:1,});
            }
            return false;
        });
        /**
         * [product_lock 锁定]
         *
         * @return {[type]} [description]
         */
        form.on('submit(product_lock)', function(index){
            layer.confirm('确定锁定吗?锁定后将不能再编辑!', {icon: 3, title:'提示'}, function(index){
                var query = new Object();
                query.lock_code = 2;
                query.pro_id = $("#product_id").val();
                var url ='/pro/productEditDone';
                var res = ajax_req(url,query,type = "post",async= true, is_check= "no");
                if(res.status == 200){
                    layer.alert(res.msg, function(index){
                        layer.close(index);
                        location.reload();
                    });
                }else{
                    layer.alert(res.msg,{title: '提示框',icon:1,});
                }
            });
            return false;
        });

        /**
         * [check_confirm 申购确认]
         *
         * @return {[type]} [description]
         */
        form.on('submit(check_confirm)', function(index){
            layer.confirm('确定申购确认!', {icon: 3, title:'提示'}, function(index){
                var query = new Object();
                query.status = 4;
                query.pro_id = $("#product_id").val();
                var url ='/pro/productEditDone';
                var res = ajax_req(url,query,type = "post",async= true, is_check= "no");
                if(res.status == 200){
                    layer.alert(res.msg, function(index){
                        layer.close(index);
                        window.location.href = "productScheduleList";
                    });
                }else{
                    layer.alert(res.msg,{title: '提示框',icon:1,});
                }
            });
            return false;
        });



        /**
         * [留言信息提交]
         *
         * @param  {[type]} index) [description]
         * @return {[type]}        [description]
         */
        form.on('submit(product_remark)',function(index){
            var query =new Object();
            query.pro_id = $("#product_id").val();
            query.remark = $("#remark").val();
            var url = '/pro/productRemark';
            var res  = ajax_req(url,query,type ="post",async = true,is_check ="no");
            if(res.status == 200){
                layer.alert(res.msg, function(index){
                    var content = getDate() + '        '+ $("#remark").val();
                    $("#remark_show").append(content);
                    $("#remark").val('');
                    layer.close(index);
                });
            }else{
                layer.alert(res.msg);
            }
            return false;
        });

        /**
         * [送检记录]
         *
         * @return {[type]}          [description]
         */
        form.on('submit(product_check_recode)',function(index){
            var query =new Object();
            query.pro_id = $("#product_id").val();
            query.check_time = $("#check_time").val();
            query.check_name = $("#check_name").val();
            query.check_status = $("#check_status").val();
            var url = '/pro/productCheckRecode';
            var res  = ajax_req(url,query,type ="post",async = true,is_check ="no");
            if(res.status == 200){
                layer.alert(res.msg, function(index){
                    var product_name  = $("#product_name").val();
                    // var next_id =Number($("#tbodys tr:last td:first").text())+1;
                    var next_id =res.data;
                    var status = query.check_status;
                    if(status ==1){
                        status = "未送检";
                    }else if(query.check_status==2){
                        status = "已送检";
                    }
                    var html = "<tr><td>"+next_id +"</td><td>"+product_name +'</td><td>'+query.check_name +'</td><td>'+ status +"</td>";
                    $("#tbodys").append(html);
                    layer.close(index);
                });
            }else{
                layer.alert(res.msg);
            }
            return false;
        });


        /**
         * [getDate 取当前时间]
         *
         * @return {[type]} [description]
         */
        function getDate() {
            var date = new Date();
            var seperator1 = "-";
            var year = date.getFullYear();
            var month = date.getMonth() + 1;
            var strDate = date.getDate();
            var hour = date.getHours()+':';
            var minute = date.getMinutes()+':';
            var second = date.getSeconds();
             if (second >= 1 && second <= 9) {
                second = "0" + second;
            }
            if (month >= 1 && month <= 9) {
                month = "0" + month;
            }
            if (strDate >= 0 && strDate <= 9) {
                strDate = "0" + strDate;
            }
            var currentdate = year + seperator1 + month + seperator1 + strDate + ' ' + hour + minute + second;
            return currentdate;
        }


    });
</script>
</body>

</html>


@endsection('content')
