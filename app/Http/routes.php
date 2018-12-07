<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

Route::group(['namespace' => 'Index', 'middleware' => 'check'], function () {
	Route::any('/', 'IndexController@index');
	Route::any('/index', 'IndexController@index');
	Route::any('/saleList', 'IndexController@saleList');
	Route::any('/finalList', 'IndexController@finalList');
	Route::any('/index', 'IndexController@index');
	Route::any('/supplier', 'IndexController@supplier');

});

Route::group(['namespace' => 'Index', 'prefix' => 'index'], function () {
	Route::any('/login', 'IndexController@login');
	Route::any('/defaults', 'IndexController@defaults');
	Route::any('/saleList', 'IndexController@saleList');
	Route::any('/finalList', 'IndexController@finalList');
	Route::any('/supplier', 'IndexController@supplier');

});

/*订单路由*/
Route::group(['namespace' => 'Order'], function () {
	Route::group(['prefix' => 'order'], function () {
		Route::any('/orderList', 'OrderController@orderList')->name('order.list');
		Route::any('/test', 'OrderController@test');
		Route::any('/salesList', 'OrderController@salesList');
		Route::any('/salesOrderAdd', 'OrderController@salesOrderAdd')->name('order.add');
		Route::any('/createFlowConfig', 'OrderController@createFlowConfig');
		Route::any('/createChildOrder', 'OrderController@createChildOrder'); //发起子订单
		Route::any('/orderDissent', 'OrderController@orderDissent'); /*订单异议*/
		Route::any('/deliveryOrderManage', 'OrderController@deliveryOrderManage'); /*送货单管理*/
		Route::any('/ajaxOrder', 'OrderController@ajaxOrder'); /*ajax子订单商品*/
		Route::any('/orderTrace', 'OrderController@orderTrace');
		Route::any('/orderAddNext', 'OrderController@orderAddNext')->name('order.done');
		Route::any('/orderNext', 'OrderController@orderNext')->name('order.next');
		Route::any('/orderCreate', 'OrderController@orderCreate')->name('order.create');

		


		// 代办
		Route::any('/todo', 'OrderController@todo');
		//代办操作执行
		Route::any('/orderTodo', 'OrderController@orderTodo');
		Route::any('/orderDone', 'OrderController@orderDone');
		// 已办
		Route::any('/todone', 'OrderController@todone');

		
		// 号段绑定
		Route::any('/codeBind', 'OrderController@codeBind');
		// 号段列表
		Route::any('/codeList', 'OrderController@codeList');
		// 删除
		Route::any('/delCode', 'OrderController@delCode');
		// 新增
		Route::any('/codeAdd', 'OrderController@codeAdd');
		Route::any('/downCodeList', 'OrderController@downCodeList');

	});
});

/*产品*/
Route::group(['namespace' => 'Product'], function(){
	Route::group(['prefix' => 'pro'], function(){
		Route::any('/newProduct','ProductController@newProduct');
		Route::any('/ajaxGetSupplier','ProductController@ajaxGetSupplier');
		Route::any('/productList','ProductController@productList');
		Route::any('/productScheduleList','ProductController@productScheduleList');
		Route::any('/productDetailed','ProductController@productDetailed');
		Route::any('/productEditDone','ProductController@productEditDone');
		Route::any('/productRemark', 'ProductController@productRemark');
		Route::any('/productCheckRecode', 'ProductController@productCheckRecode');
		Route::any('/checkImgUpload', 'ProductController@checkImgUpload');



		// 商品类目
		Route::any('/cateList','ProductController@cateList');
		Route::any('/cateEdit','ProductController@cateEdit');
		Route::any('/cateDel','ProductController@cateDel');
		Route::any('/cateAdd','ProductController@cateAdd');
		// 获取单个类目信息
		Route::any('/getSingleCate','ProductController@getSingleCate');
		// 商品品牌
		Route::any('/brandList','ProductController@brandList');
		Route::any('/brandEdit','ProductController@brandEdit');
		Route::any('/brandDel','ProductController@brandDel');
		Route::any('/brandAdd','ProductController@brandAdd');
		// 获取单个品牌信息
		Route::any('/getSingleBrand','ProductController@getSingleBrand');
		// 获取单个商品信息
		Route::any('/getProductSingle','ProductController@getProductSingle');
	});
});

/*系统设置路由*/

Route::group(['namespace' => 'Sys'], function () {
	Route::group(['prefix' => 'sys'], function () {
		Route::any('/addNode', 'SysController@addNode'); /*添加节点*/
		Route::any('/addFlow', 'SysController@addFlow'); /*添加流程*/
		Route::any('/nodeList', 'SysController@nodeList'); /*节点列表*/
		Route::any('/flowList', 'SysController@flowList'); /*流程列表*/
		Route::any('/flowConfigList', 'SysController@flowConfigList'); /*流程配置列表*/
		Route::any('/ajaxGetNodes', 'SysController@ajaxGetNodes'); //流程配置管理
		Route::any('/nodeDel', 'SysController@nodeDel'); //流程配置管理
		Route::any('/nodeEdit', 'SysController@nodeEdit'); //流程配置管理  nodeEditDode
		Route::any('nodeEditDode', 'SysController@nodeEditDode');
		Route::any('flowEdit', 'SysController@flowEdit'); //流程编辑
		Route::any('flowDel', 'SysController@flowDel'); //流程删除
		Route::any('flowEditDone', 'SysController@flowEditDone');
	});
	Route::group(['prefix' => 'cflow'], function () {
		Route::any('/flowConfigList', 'CflowController@flowConfigList');
		Route::any('/addFlowConfig', 'CflowController@addFlowConfig');
		Route::any('/flowConfigDel', 'CflowController@flowConfigDel');
		Route::any('/flowConfigEdit', 'CflowController@flowConfigEdit');
		Route::any('/flowConfigEditDone', 'CflowController@flowConfigEditDone');
	});
});

Route::group(['namespace' => 'Erp', 'middleware' => 'check_auth'], function () {
	Route::group(['prefix' => 'erp'], function () {
		// 登录相关
		Route::any('/login', 'LoginController@login');
		Route::any('/in', 'LoginController@in');
		Route::any('/out', 'LoginController@out');
		Route::any('/getVerifyCode', 'LoginController@getVerifyCode');
		Route::any('/checkVerify', 'LoginController@checkVerify');
		Route::any('/checkLogin', 'LoginController@checkLogin');
		// 入驻
		Route::any('/shopIn', 'LoginController@shopIn');

		// 账户相关
		Route::any('/userAdd', 'StaffController@userAdd');
		Route::any('/userEdit', 'StaffController@userEdit');
		Route::any('/staffList', 'StaffController@staffList');
		Route::any('/userDel', 'StaffController@userDel');
		// 重置密码
		Route::any('/resetPwd', 'StaffController@resetPwd');

		// 获取用户信息
		Route::any('/findUserInfo', 'StaffController@findUserInfo');
		// 个人信息
		Route::any('/adminInfo', 'StaffController@adminInfo');
		Route::any('/userList', 'StaffController@userList');
		Route::any('/changePass', 'StaffController@changePass');
		Route::any('/changeUserInfo', 'StaffController@changeUserInfo');

		// 角色管理
		Route::any('/getRoleList', 'RoleController@getRoleList');
		Route::any('/roleAdd', 'RoleController@roleAdd');
		Route::any('/roleFind', 'RoleController@roleFind');
		Route::any('/roleEdit', 'RoleController@roleEdit');
		Route::any('/roleDel', 'RoleController@roleDel');
		Route::any('/roleConfig', 'RoleController@roleConfig');
		// 获取角色接口列表信息
		Route::any('/getStaffRoleList', 'RoleController@getStaffRoleList');

	});

	Route::group(['prefix' => 'menu'], function () {
		// 菜单管理
		Route::any('/getMenuList', 'MenuController@getMenuList');
		Route::any('/getMenuAllList', 'MenuController@getMenuAllList');
		Route::any('/getSideList', 'MenuController@getSideList');
		Route::any('/getMemusInfo', 'MenuController@getMemusInfo');
		Route::any('/menuAdd', 'MenuController@menuAdd');
		Route::any('/menuAddList', 'MenuController@menuAddList');
		Route::any('/menuFind', 'MenuController@menuFind');
		Route::any('/menuEdit', 'MenuController@menuEdit');
		Route::any('/menuDel', 'MenuController@menuDel');
		Route::any('/menusRoleInfo', 'MenuController@menusRoleInfo');
		Route::any('/findMenuInfo', 'MenuController@findMenuInfo');
		Route::any('/getRoleMenuList', 'MenuController@getRoleMenuList');

		// 检测角色权限
		Route::any('/checkAuth', 'MenuController@checkAuth');
	});
});

// 公共接口
Route::group(['namespace' => 'Com', 'prefix' => 'com'], function () {
	// 上传图片
	Route::any('/webUpload', 'CommonConstroller@webUpload');
});

// 公共 配置接口	
Route::group(['namespace' => 'Com', 'prefix' => 'config'], function(){
	// 新品送检类表
	Route::any('/proCheck', 'CommonConstroller@proCheck');
});


// 日志管理
Route::group(['namespace' => 'Log', 'prefix' => 'log'], function () {
	// 列表
	Route::any('/loginList', 'LogConstroller@loginList');
	Route::any('/LogDel', 'LogConstroller@LogDel');
});

// 第三方
Route::group(['namespace' => 'Partner'], function () {
	Route::group(['prefix' => 'supplier'], function () {
		//供应商
		Route::any('/supplierList', 'SupplierController@supplierList');
		// 视图
		Route::any('/supplierAdd', 'SupplierController@supplierAdd');
		// 接口
		Route::any('/supplierInsert', 'SupplierController@supplierInsert');
		Route::any('/supplierDel', 'SupplierController@supplierDel');
		Route::any('/supplierEdit', 'SupplierController@supplierEdit');
		// 获取单个供应商信息
		Route::any('/getSupplierSingle', 'SupplierController@getSupplierSingle');

		// 获取品控 - 工厂信息
		Route::any('/getSingleList', 'SupplierController@getSingleList');
	});

	Route::group(['prefix' => 'dealer'], function () {
		//  经销商
		Route::any('/dealerList', 'DealerController@dealerList');
		Route::any('/shopAddInfo', 'DealerController@shopAddInfo');
	});

	// 品控
	Route::group(['prefix' => 'pk'], function () {
		// 品控厂能列表
		Route::any('/qualityList', 'SupplierController@qualityList');
		// 品控厂能实际
		Route::any('/productControlInfo', 'SupplierController@productControlInfo');
		// 品控实际厂能
		Route::any('/supplierPKEdit', 'SupplierController@supplierPKEdit');
	});
});
