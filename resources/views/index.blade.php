@include("head")
<div class="main-container" id="main-container">
	<script type="text/javascript">
		try{ace.settings.check('main-container' , 'fixed')}catch(e){}
	</script>
	<div class="main-container-inner">
		<a class="menu-toggler" id="menu-toggler" href="#" style="margin-top: 75px; z-index: 10000;position: fixed;">
			<span class="menu-text"></span>
		</a>
		@include('sidebar')

		<div class="main-content">
        <script type="text/javascript">
			try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
		</script>
			<div class="breadcrumbs" id="breadcrumbs" >
				<ul class="breadcrumb">
					<li>
						<i class="icon-home home-icon"></i>
						<a href="/">首页</a>
					</li>
					<li class="active"><span class="Current_page iframeurl"></span></li>
	                <li class="active" id="parentIframe"><span class="parentIframe iframeurl"></span></li>
					<li class="active" id="parentIfour"><span class="parentIfour iframeurl"></span></li>
				</ul>
			</div>				
		
         <!-- <iframe id="iframe" "name="iframe" frameborder="0" src="">  </iframe> -->
  	<!-- <div id="iframe" style="border:0; width:100%; background-color:#FFF;"name="iframe" frameborder="0" > -->
  		<div class="content_all " style="margin-top:0px; margin-bottom:35px;position: relative; top: 120px; ">
        @if(isset($index))
       		 @include($index)
        <!-- 切换页面 -->
        @else
        	@yield("content")
        @endif
    </div>
  	<!-- </div> -->
<!-- /.page-content -->
		</div><!-- /.main-content -->	
     {{-- 隐藏小图标  sidebar_hiddle --}}  
                  <!-- /#ace-settings-container -->		
	</div><!-- /.main-container-inner -->
</div>
@include('foot')