
<div class="page-content clearfix ">
   <div class="alert alert-block alert-success">
    <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
    <i class="icon-ok green"></i>欢迎 {{Session::get('staff_name')}} 使用<strong class="green">后台管理系统</strong>
   </div>
   <div class="state-overview clearfix">
      <div class="col-lg-3 col-sm-6">
          <section class="panel">
          <a href="#" title="">
              <div class="symbol terques">
                 <i class="icon-user"></i>
              </div>
              <div class="value">
                  <h1>默认首页</h1>
                  <p>代办任务</p>
              </div>
          </a>
          </section>
      </div>
  </div>
</div>
<script type="text/javascript">
//面包屑返回值
var index = parent.layer.getFrameIndex(window.name);
parent.layer.iframeAuto(index);
$('.no-radius').on('click', function(){
	var cname = $(this).attr("title");
	var chref = $(this).attr("href");
	var cnames = parent.$('.Current_page').html();
	var herf = parent.$("#iframe").attr("src");
    parent.$('#parentIframe').html(cname);
    parent.$('#iframe').attr("src",chref).ready();;
	parent.$('#parentIframe').css("display","inline-block");
	parent.$('.Current_page').attr({"name":herf,"href":"javascript:void(0)"}).css({"color":"#4c8fbd","cursor":"pointer"});
    parent.layer.close(index);
});
     $(document).ready(function(){
		  $(".t_Record").width($(window).width()-640);
		  //当文档窗口发生改变时 触发  
    $(window).resize(function(){
		 $(".t_Record").width($(window).width()-640);
		});
 });
	 
 </script>   
