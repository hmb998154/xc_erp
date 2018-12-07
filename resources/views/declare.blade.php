@extends('index')
@section('content')
<script src="/assets/layer/layui/layui.js" type="text/javascript" ></script>
<link rel="stylesheet" href="/assets/layer/layui/css/layui.css"  media="all">
<style type="text/css">
    .layui-form-label{padding: 0;};
    #layui-upload-img{width: 92px;height: 92px;margin: 0 10px 10px 0;}
    .layui-input-inline{min-width: 300px;}
    hr{background: #6f6f6f;max-width: 800px;margin-bottom: 15px;margin-top: 15px;}
</style>

<div class="layui-container">
    <form class="layui-form" action="" style="padding-top: 50px;">
        <label class="layui-form-label"><b>商品信息</b></label>
        <hr>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">商品名称（必填）</label>
                <div class="layui-input-inline">
                    <input type="tel" name="phone" lay-verify="required|phone" autocomplete="off" class="layui-input"></div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">商品型号</label>
                <div class="layui-input-inline">
                    <input type="text" name="email" lay-verify="email" autocomplete="off" class="layui-input"></div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">平台商家编码</label>
                <div class="layui-input-inline">
                    <input type="tel" name="phone" lay-verify="required|phone" autocomplete="off" class="layui-input"></div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">商品材质</label>
                <div class="layui-input-inline">
                    <input type="text" name="email" lay-verify="email" autocomplete="off" class="layui-input"></div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">商品货号</label>
                <div class="layui-input-inline">
                    <input type="tel" name="phone" lay-verify="required|phone" autocomplete="off" class="layui-input"></div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">商品条码</label>
                <div class="layui-input-inline">
                    <input type="text" name="email" lay-verify="email" autocomplete="off" class="layui-input"></div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">商品参数</label>
                <div class="layui-input-inline">
                    <input type="tel" name="phone" lay-verify="required|phone" autocomplete="off" class="layui-input"></div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">送检费用</label>
                <div class="layui-input-inline">
                    <input type="text" name="email" lay-verify="email" autocomplete="off" class="layui-input"></div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">商品尺寸</label>
                <div class="layui-input-inline">
                    <input type="tel" name="phone" lay-verify="required|phone" autocomplete="off" class="layui-input"></div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">商品品牌</label>
                <div class="layui-input-inline">
                    <input type="text" name="email" lay-verify="email" autocomplete="off" class="layui-input"></div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">商品规格</label>
                <div class="layui-input-inline">
                    <input type="tel" name="phone" lay-verify="required|phone" autocomplete="off" class="layui-input"></div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">商品类目</label>
                <div class="layui-input-inline">
                    <input type="text" name="email" lay-verify="email" autocomplete="off" class="layui-input"></div>
            </div>
        </div>
        <label class="layui-form-label">商品封样</label>
        <div class="layui-upload" style="margin-left: 120px;">
            <button type="button" class="layui-btn" id="test1">上传图片</button>
            <div class="layui-upload-list">
                <img class="layui-upload-img" id="demo1" style="width: 92px;height: 92px;margin: 0 10px 10px 0;">
                <p id="demoText"></p>
            </div>
        </div>

        <label class="layui-form-label"><b>工厂信息</b></label>
        <hr>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">工厂名称</label>
                <div class="layui-input-inline">
                    <input type="tel" name="phone" lay-verify="required|phone" autocomplete="off" class="layui-input"></div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">工厂货号</label>
                <div class="layui-input-inline">
                    <input type="text" name="email" lay-verify="email" autocomplete="off" class="layui-input"></div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">工厂地址</label>
                <div class="layui-input-inline" style="min-width:700px;">
                    <input type="tel" name="phone" lay-verify="required|phone" autocomplete="off" class="layui-input"></div>
            </div>
            
        </div>


        <label class="layui-form-label"><b>包装信息</b></label>
        <hr>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">包装尺寸</label>
                <div class="layui-input-inline" style="min-width:700px;">
                    <input type="tel" name="phone" lay-verify="required|phone" autocomplete="off" class="layui-input"></div>
            </div>
            
        </div>


        <label class="layui-form-label">包装图片</label>
        <div class="layui-upload" style="margin-left: 120px;">
            <button type="button" class="layui-btn" id="test2">上传图片</button>
            <div class="layui-upload-list">
                <img class="layui-upload-img" id="demo2" style="width: 92px;height: 92px;margin: 0 10px 10px 0;">
                <p id="demoText2"></p>
            </div>
        </div>


  <div class="layui-form-item" style="padding-left:25%;margin-top:50px; margin-bottom: 200px;">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>

        <script type="text/javascript">layui.use('upload',
            function() {
                var $ = layui.jquery,
                upload = layui.upload;

                //普通图片上传
                var uploadInst = upload.render({
                    elem: '#test1',
                    url: '/order/test',
                    before: function(obj) {
                        //预读本地文件示例，不支持ie8
                        obj.preview(function(index, file, result) {
                            $('#demo1').attr('src', result); //图片链接（base64）
                        });
                    },
                    done: function(res) {
                        //如果上传失败
                        if (res.code > 0) {
                            return layer.msg('上传失败');
                        }
                        //上传成功
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

                 //普通图片上传
                var uploadInst = upload.render({
                    elem: '#test2',
                    url: 'order/test',
                    before: function(obj) {
                        //预读本地文件示例，不支持ie8
                        obj.preview(function(index, file, result) {
                            $('#demo2').attr('src', result); //图片链接（base64）
                        });
                    },
                    done: function(res) {
                        //如果上传失败
                        if (res.code > 0) {
                            return layer.msg('上传失败');
                        }
                        //上传成功
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
            });
        </script>
    </form>
</div>
</body>

</html>


@endsection('content')