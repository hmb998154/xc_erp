<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.7.2/css/amazeui.min.css">
<!-- <link rel="stylesheet" href="/assets/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="/css/shopin.css">

<!--引入CSS-->
<link rel="stylesheet" type="text/css" href="/assets/css/webuploader.css">
<link rel="stylesheet" href="/webupload/control/css/zyUpload.css" type="text/css">

<script src="/assets/js/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="/assets/js/common.js" type="text/javascript"></script>

<script src="/assets/layer/layer.js" type="text/javascript"></script>
<script src="/assets/laydate/laydate.js" type="text/javascript"></script>

<!--引入JS-->
<script type="text/javascript" src="/assets/js/webuploader.js"></script>
<!-- <script src="/assets/larer/larer.js" type="text/javascript"></script> -->


<!-- 上传图片 -->
<!-- <script src="/webupload/core/zyFile.js"></script>
<script src="/webupload/control/js/zyUpload.js"></script>
<script src="/webupload/core/jq22.js"></script>
 -->
<title>申请入驻</title>
<style>
  .tab{
    width: 100%;
  }
</style>
<script type="text/javascript">
  function init(){
    $(".tab-1").hide();
    $(".tab-2").hide();
    $(".tab-3").hide();
    $(".tab-4").hide();
  }

  function open_dis(id) {
    $('.tab').hide();
    $("."+id).show();
  }

  // function test() {
  //   var user_info = {};
  //   user_info['staff_name'] = $(".staff_name").val();
  //   user_info['staff_phone'] = $(".staff_phone").val();
  //   user_info['passwd'] = $(".passwd").val();
  //   user_info['qr_passwd'] = $(".qr_passwd").val();

  //   user_info['nick_name'] = $(".nick_name").val();
  //   user_info['email'] = $(".email").val();
  //   user_info['company_name'] = $(".company_name").val();
  //   user_info['company_address'] = $(".company_address").val();

  //   user_info['business_license_name'] = $(".business_license_name").val();
  //   // user_info['business_license_img'] = $(".business_license_img").val();
  //   user_info['business_license_img'] = $(".business_license_img");
  //   user_info['corporation_name'] = $(".corporation_name").val();
  //   user_info['corporation_idcard'] = $(".corporation_idcard").val();
  //   // user_info['corporation_img'] = $(".corporation_img").val();
  //   user_info['corporation_img'] = $(".corporation_img");
  //   user_info['shop_name'] = $(".shop_name").val();
  //   user_info['main_produce'] = $(".main_produce").val();
  //   user_info['year_sale_size'] = $(".year_sale_size").val();
  //   user_info['company_num'] = $(".company_num").val();
  //   user_info['sale_staff_name'] = $(".sale_staff_name").val();
   
  //    var infos = JSON.stringify(user_info);
  //    dd(infos)
  //   //  

  //   // var res = ajax_req("/dealer/shopAddInfo",infos,"post","false","no");

  //   var formdata=new FormData();
  //   //formdata.append('name', 'uploadImage');
  //   formdata.append('uploadImage',$('.business_license_name').get(0));
  //   // formdata.append('recid',str);
  //   var res = ajax_upload('/dealer/shopAddInfo',ajax_upload);
  //   dd(res);
  //   // var res = ajax_req("/dealer/shopAddInfo",user_info,"post","false","no");
  //   if(res.status != 200){
  //     layer.alert(res.msg,{icon: 2});
  //   }else{
  //     layer.alert(res.msg,{icon: 1});
  //   }
  // }
</script>
</head>
@if(isset($error))
<script>
  alert('{{$error}}' );
</script>
@endif
<body  onload='init()' style="top:-175px; font-size: 14px">
<form action="/dealer/shopAddInfo" method="post" enctype="multipart/form-data" id="avatar">
<div class='progress'>
  <div class='progress_inner'>
    <div class='progress_inner__step'  onclick="open_dis('tab-0')">
      <label for='step-1'>注册账号</label>
    </div>
    <div class='progress_inner__step' onclick="open_dis('tab-1')">
      <label for='step-2'>联系人信息</label>
    </div>
    <div class='progress_inner__step' onclick="open_dis('tab-2')">
      <label for='step-3'>公司信息</label>
    </div>
    <div class='progress_inner__step' onclick="open_dis('tab-3')">
      <label for='step-4'>店铺信息</label>
    </div>
    <div class='progress_inner__step' onclick="open_dis('tab-4')">
      <label for='step-5'>提交审核</label>
    </div>
    <input checked='checked' id='step-1' name='step' type='radio'>
    <input id='step-2' name='step' type='radio'>
    <input id='step-3' name='step' type='radio'>
    <input id='step-4' name='step' type='radio'>
    <input id='step-5' name='step' type='radio'>
    <div class='progress_inner__bar'></div>
    <div class='progress_inner__bar--set'></div>

    <div class='progress_inner__tabs'>
    
      <div class='tab tab-0'>
        <h1>注册账号</h1>
        <p>
         
           <div class="am-form-group am-form am-form-icon am-form-feedback">
             <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">用户名</label>
             <div class="am-u-sm-10"><input type="text" id="doc-ipt-3-a " class="am-form-field nick_name" name="nick_name" placeholder="输入你的用户名"></div>
           </div>
           <div class="am-form-group am-form am-form-icon am-form-feedback">
             <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label ">密码</label>
             <div class="am-u-sm-10"><input type="password"  class="am-form-field passwd" name="passwd" placeholder="输入你的密码"></div>
           </div>

           <div class="am-form-group am-form am-form-icon am-form-feedback">
             <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label ">确认密码</label>
             <div class="am-u-sm-10"><input type="password"  class="am-form-field qr_passwd" name="qr_passwd" placeholder="确认输入你的密码"></div>
           </div>
         
        </p>
      </div>

      <div class='tab tab-1'>
        <h1>联系人信息</h1>
            <p>
              
                <div class="am-form-group am-form am-form-icon am-form-feedback">
                  <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">联系人姓名</label>
                  <div class="am-u-sm-10"><input type="text"  class="am-form-field staff_name" name="staff_name" placeholder="输入你的联系人姓名"></div>
                </div>
                <div class="am-form-group am-form am-form-icon am-form-feedback">
                  <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">联系人手机</label>
                  <div class="am-u-sm-10"><input type="text"  class="am-form-field staff_phone" name="staff_phone" placeholder="输入你的联系人手机"></div>
                </div>

                <div class="am-form-group am-form am-form-icon am-form-feedback">
                  <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">联系人电子邮箱</label>
                  <div class="am-u-sm-10"><input type="text"  class="am-form-field email" name="email" placeholder="确认输入你的联系人电子邮箱"></div>
                </div>
                <div class="am-form-group am-form am-form-icon am-form-feedback">
                  <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">销售人员姓名</label>
                  <div class="am-u-sm-10"><input type="text"  class="am-form-field sale_staff_name" name="sale_staff_name" placeholder="确认输入销售人员姓名"></div>
                </div>
              
            </p>
      </div>
      <div class='tab tab-2'>
            <h1>公司信息</h1>
            <p>
              <!-- <div id="demo" class="demo"></div> -->
             <div class="am-form-group am-form am-form-icon am-form-feedback">
             </div>
                <div class="am-form-group am-form am-form-icon am-form-feedback">
                  <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">公司名称</label>
                  <div class="am-u-sm-10"><input type="text"  class="am-form-field company_name" name="company_name" placeholder="输入你的联系人公司名称"></div>
                </div>
                <div class="am-form-group am-form am-form-icon am-form-feedback">
                  <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">公司地址</label>
                  <div class="am-u-sm-10"><input type="text"  class="am-form-field company_address" name="company_address" placeholder="输入你的公司地址"></div>
                </div>

                <div class="am-form-group am-form am-form-icon am-form-feedback">
                  <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">营业执照证件号</label>
                  <div class="am-u-sm-10"><input type="text"  class="am-form-field business_license_name" name="business_license_name" placeholder="确认输入你的营业执照证件号"></div>
                </div>

                <div class="am-form-group am-form am-form-icon am-form-feedback">
                  <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">营业执照证件图片</label>
                  <div class="am-u-sm-10">
                    <div class="am-form-group am-form-file">
                      <button type="button" class="am-btn am-btn-danger am-btn-sm">
                        <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
                      <input id="doc-form-file" type="file" name="business_license_img" multiple>
                    </div>
                    <div id="file-list"></div>
                    <script>
                      $(function() {
                        $('#doc-form-file').on('change', function() {
                          var fileNames = '';
                          $.each(this.files, function() {
                            fileNames += '<span class="am-badge">' + this.name + '</span> ';
                          });
                          $('#file-list').html(fileNames);
                        });
                      });
                    </script>
                  </div>
                </div>

                 <div class="am-form-group am-form am-form-icon am-form-feedback">
                  <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">公司人员数量</label>
                  <div class="am-u-sm-10"><input type="text"  class="am-form-field company_num" name="company_num" placeholder="确认输入公司人员数量"></div>
                </div>

                <div class="am-form-group am-form am-form-icon am-form-feedback">
                  <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">法人姓名</label>
                  <div class="am-u-sm-10"><input type="text"  class="am-form-field corporation_name" name="corporation_name" placeholder="确认输入法人姓名"></div>
                </div>

                <div class="am-form-group am-form am-form-icon am-form-feedback">
                  <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">法人身份证号码</label>
                  <div class="am-u-sm-10"><input type="text"  class="am-form-field corporation_idcard" name="corporation_idcard" placeholder="确认输入法人身份证号码"></div>
                </div>

                <div class="am-form-group am-form am-form-icon am-form-feedback">
                  <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">法人身份证图片</label>
                    
                   <div class="am-u-sm-10">
                     <div class="am-form-group am-form-file">
                       <button type="button" class="am-btn am-btn-danger am-btn-sm">
                         <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
                       <input id="doc-form-file2" type="file" name="corporation_img" >
                     </div>
                     <div id="file-list2"></div>
                     <script>
                       $(function() {
                         $('#doc-form-file2').on('change', function() {
                           var fileNames = '';
                           $.each(this.files, function() {
                             fileNames += '<span class="am-badge">' + this.name + '</span> ';
                           });
                           $('#file-list2').html(fileNames);
                         });
                       });
                     </script>
                   </div>
                </div>

                
      </div>
      <div class='tab tab-3'>
        <h1>店铺信息</h1>
        <p>
          <p>
            
              <div class="am-form-group am-form am-form-icon am-form-feedback">
                <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">店铺名称</label>
                <div class="am-u-sm-10"><input type="text"  class="am-form-field shop_name" name="shop_name" placeholder="输入你的店铺名称"></div>
              </div>
              <div class="am-form-group am-form am-form-icon am-form-feedback">
                <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">主炒产品</label>
                <div class="am-u-sm-10"><input type="text"  class="am-form-field main_produce" name="main_produce" placeholder="输入你的主炒产品"></div>
              </div>

              <div class="am-form-group am-form am-form-icon am-form-feedback">
                <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">年销售规模</label>
                <div class="am-u-sm-10"><input type="text"  class="am-form-field year_sale_size" name="year_sale_size" placeholder="确认输入你的年销售规模"></div>
              </div>
            
          </p>
        </p>
      </div>
      <div class='tab tab-4'>
        <h1>提交审核</h1>
        <!-- <p><button type="button" class="am-btn am-btn-primary am-radius onsubmit" >提交</button></p> -->
        <p><button type="submit" class="am-btn am-btn-primary am-radius onsubmit" >提交</button></p>
      </div>
    </div>
    <div class='progress_inner__status'>
      <div class='box_base'></div>
      <div class='box_lid'></div>
      <div class='box_ribbon'></div>
      <div class='box_bow'>
        <div class='box_bow__left'></div>
        <div class='box_bow__right'></div>
      </div>
      <div class='box_item'></div>
      <div class='box_tag'></div>
      <div class='box_string'></div>
    </div>
  </div>
</div>
</form>
<script>
  function test() { 
    // var formData = new FormData($("#avatar")); 
    // dd(formData);
    $.ajax({ 
     url: "/dealer/shopAddInfo",
     type: 'post', 
     data: formData, 
     contentType: false, 
     processData: false, 
     success: function (returndata) { 
      dd(returndata);
     }, 
     error: function (returndata) { 
      dd(returndata);
     } 
    }); 
  }
</script>
</body>
</html>