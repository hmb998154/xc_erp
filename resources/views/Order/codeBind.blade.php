@extends('index')
@section('content')
<style>
  .unit_single{
    margin-left: 10px;
  }

</style>
<div class="margin clearfix">
 <div class="stystems_style">
  <div class="tabbable">
  <ul class="nav nav-tabs" id="myTab">
    <li class="active"><a data-toggle="tab" href="#home"><i class="green fa fa-home bigger-110"></i>&nbsp;商品条码号段</a></li>
  </ul>
    <div class="tab-content">
    <div id="home" class="tab-pane active">
         <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>商品名称 </label>
          <div class="col-sm-9"><input type="text"  name="product_name"  placeholder="" value="" class="col-xs-10 product_name "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>商品69编码 </label>
           <div class="col-sm-9"><input type="text"  name="factory_name"  placeholder="" value="" class="col-xs-10 product_six_nine_code "></div>
           </div>

           <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>品牌名称 </label>
          <div class="col-sm-9"><input type="text"  name="brand_name"  placeholder="" value="" class="col-xs-10 brand_name "></div>
        </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">商品位数 </label>
          <div class="col-sm-9"><input type="text"  name="bar_code_digs"  placeholder="" value="" class="col-xs-10 bar_code_digs "></div>
          </div>
         <div class="form-group unit_single">
          <label class="col-sm-1 control-label no-padding-right" for="form-field-1">单位类型 </label>
          <div class="col-sm-9">
            <select class="pro_unit_type" id="" name="pro_unit_type">
                <option value="0" >选择分类</option>
                <option value="1" selected="selected">箱</option>
                <option value="2">件</option>
              </select>
              <input type="text"  name="pro_unit"  placeholder="请输入单位数量" value="" class=" control-label no-padding-left">
          </div>
          </div>
           <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">条码数量: </label>
           <div class="col-sm-9"><input type="text"  name="sum"  placeholder="" value="" class="col-xs-10 sum "></div>
           </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">商品前缀: </label>
          <div class="col-sm-9"><input type="text"  name="pro_prefix"  placeholder="例如：1111" value="" class="col-xs-10 pro_prefix "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">后缀起始 </label>
          <div class="col-sm-9"><input type="text"  name="suffix_code"  placeholder="例如：2222" value="" class="col-xs-10 suffix_code "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">备注 </label>
          <div class="col-sm-9">
            <input type="text"  name="remark"  placeholder="" value="" class="col-xs-10 remark ">
          </div>
          </div>
          </div>
          <div class="Button_operation"> 
        <button onclick="article_save_submit();" class="btn btn-primary radius" type="button"><i class="fa fa-save "></i>&nbsp;保存</button>
        <button onclick="backinfo()" class="btn btn-default radius" type="button">&nbsp;&nbsp;返回&nbsp;&nbsp;</button>
      </div>
        </div>
        <div id="profile" class="tab-pane">
        </div>
        <div id="dropdown" class="tab-pane">
    </div>
    </div>
    </div>
 </div>
</div>
<script>
  $(function(){
    var arr = check_supplier_id();

    if(arr != null){
      var res = ajax_req('/pro/getProductSingle',{'pro_id':arr},"get","false","false");
      dd(res);
      if(res.status != 200){
        layer.alert(res.msg,{title: '提示框', icon:2}); exit;
      }else{
        var res_data = res.data;
        $(".brand_name").val(res_data.brand_name);
        $(".product_six_nine_code").val(res_data.product_six_nine_code);
        $(".product_name").val(res_data.product_name);
      }
    }
  });

  function backinfo() {
    window.location.href = "/pro/codeList";
  }
  /**
   * [article_save_submit description]
   * @param  {[type]} argument [description]
   * @return {[type]}          [description]
   */
  function article_save_submit() {
    var str="";
    var arr = {};
    var num = 0;
    
     $("input[type$='text']").each(function(n){
          arr[$(this).attr("name")] = $(this).val();
     });
    var res_code = check_supplier_id();
    var res = "";
    if(res_code != null){
      arr['product_info_id'] = res_code;
      res = ajax_req('/order/codeAdd',arr,"post","false");
    }else{
      // res = ajax_req('/supplier/supplierInsert',arr,"post","false");
    }
    
    if(res.status != 200){
      layer.alert(res.msg,{title: '提示框', icon:2}); exit;
    }else{
      layer.alert(res.msg,{title: '提示框', icon:1});
      layer.close();
      location.href = "/order/codeList";
    }
  }

  // 检查是否为编辑
  function check_supplier_id() {
    $ext = window.location.search;
    var arr = $ext.split('=');
    if(arr[1] != ""){
      return arr[1];
    }else{
      return null;
    }
  }
</script>
@endsection('content')
