@extends('index')
@section('content')
<div class="margin clearfix">
 <div class="stystems_style">
  <div class="tabbable">
  <ul class="nav nav-tabs" id="myTab">
    <li class="active"><a data-toggle="tab" href="#home"><i class="green fa fa-home bigger-110"></i>&nbsp;基本设置</a></li>
  </ul>
    <div class="tab-content">
    <div id="home" class="tab-pane active">
         <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>公司名称： </label>
          <div class="col-sm-9"><input type="text"  name="factory_name"  placeholder="" value="" class="col-xs-10 factory_name "></div>
          </div>
           <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>公司地址： </label>
          <div class="col-sm-9"><input type="text"  name="factory_address"  placeholder="" value="" class="col-xs-10 factory_address "></div>
        </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">营业执照证件号： </label>
          <div class="col-sm-9"><input type="text"  name="business_license"  placeholder="" value="" class="col-xs-10 business_license "></div>
          </div>
         <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">法人姓名： </label>
          <div class="col-sm-9"><input type="text"  name="legal_name"  placeholder="" value="" class="col-xs-10 legal_name"></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">法人身份证号码： </label>
          <div class="col-sm-9"><input type="text"  name="Legal_idcard"  placeholder="" value="" class="col-xs-10 Legal_idcard"></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">工厂货号: </label>
          <div class="col-sm-9"><input type="text"  name="factory_code"  placeholder="" value="" class="col-xs-10 factory_code "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">工厂面积： </label>
          <div class="col-sm-9"><input type="text"  name="factory_area"  placeholder="" value="" class="col-xs-10 factory_area "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">仓储面积： </label>
          <div class="col-sm-9"><input type="text"  name="storage_area"  placeholder="" value="" class="col-xs-10 storage_area "></div>
          </div>
           <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">年生产规模： </label>
          <div class="col-sm-9"><input type="text"  name="scale_of_productio"  placeholder="" value="" class="col-xs-10 scale_of_productio "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">日产量: </label>
          <div class="col-sm-9"><input type="text"  name="day_dev_num"  placeholder="" value="" class="col-xs-10 day_dev_num "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">工厂等级: </label>
          <div class="col-sm-9"><input type="text"  name="factory_level"  placeholder="" value="" class="col-xs-10 factory_level "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">生产资质: </label>
          <div class="col-sm-9"><input type="text"  name="dev_qualifications"  placeholder="" value="" class="col-xs-10 dev_qualifications "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">信誉度: </label>
          <div class="col-sm-9"><input type="text"  name="reputation"  placeholder="" value="" class="col-xs-10 reputation "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1">保证金: </label>
          <div class="col-sm-9"><input type="text"  name="bond"  placeholder="" value="" class="col-xs-10 bond "></div>
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
      var res = ajax_req('/supplier/getSupplierSingle',{'supplier_id':arr},"get","false");
      if(res.status != 200){
        layer.alert(res.msg,{title: '提示框', icon:2}); exit;
      }else{
        var res_data = res.data;
        $(".factory_name").val(res_data.factory_name);
        $(".factory_address").val(res_data.factory_address);
        $(".business_license").val(res_data.business_license);
        $(".legal_name").val(res_data.legal_name);
        $(".Legal_idcard").val(res_data.Legal_idcard);
        $(".factory_code").val(res_data.factory_code);
        $(".factory_area").val(res_data.factory_area);
        $(".storage_area").val(res_data.storage_area);
        $(".scale_of_productio").val(res_data.scale_of_productio);
        $(".day_dev_num").val(res_data.day_dev_num);
        $(".factory_level").val(res_data.factory_level);
        $(".dev_qualifications").val(res_data.dev_qualifications);
        $(".reputation").val(res_data.reputation);
        $(".bond").val(res_data.bond);
      }
    }
  });

  function backinfo() {
    window.location.href = "/supplier/supplierList";
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
      arr['supplier_id'] = res_code;
      res = ajax_req('/supplier/supplierEdit',arr,"post","false");
    }else{
      res = ajax_req('/supplier/supplierInsert',arr,"post","false");
    }
    
    if(res.status != 200){
      layer.alert(res.msg,{title: '提示框', icon:2}); exit;
    }else{
      layer.alert(res.msg,{title: '提示框', icon:1});
      layer.close();
      location.href = "/supplier/supplierList";
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
