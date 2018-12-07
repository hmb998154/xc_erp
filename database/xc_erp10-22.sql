/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50717
Source Host           : 127.0.0.1:3306
Source Database       : xc_erp

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2018-10-22 14:14:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for erp_brand
-- ----------------------------
DROP TABLE IF EXISTS `erp_brand`;
CREATE TABLE `erp_brand` (
  `brand_id` int(11) NOT NULL COMMENT '品牌方id',
  `cooperator_id` int(11) DEFAULT NULL COMMENT '合作商id',
  `brand_reg` varchar(255) DEFAULT NULL COMMENT '品牌注册证图片',
  `brand_certificate_of_auth` varchar(255) DEFAULT NULL COMMENT '品牌授权书图片',
  `reputation` varchar(20) DEFAULT NULL COMMENT '信誉度',
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='品牌方';

-- ----------------------------
-- Records of erp_brand
-- ----------------------------

-- ----------------------------
-- Table structure for erp_commodity_production
-- ----------------------------
DROP TABLE IF EXISTS `erp_commodity_production`;
CREATE TABLE `erp_commodity_production` (
  `production_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  `create_time` datetime DEFAULT NULL COMMENT '新品申购时间',
  `create_staff_id` int(11) DEFAULT NULL COMMENT '操作人',
  `enable` enum('yes','no') DEFAULT 'no',
  PRIMARY KEY (`production_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品生产（新品申购）';

-- ----------------------------
-- Records of erp_commodity_production
-- ----------------------------

-- ----------------------------
-- Table structure for erp_cooperator
-- ----------------------------
DROP TABLE IF EXISTS `erp_cooperator`;
CREATE TABLE `erp_cooperator` (
  `cooperator_id` int(11) NOT NULL,
  `type` tinyint(4) DEFAULT '1' COMMENT 'type 1经销商，2供应商,3品牌方',
  `business_licence_card` varchar(255) DEFAULT NULL COMMENT '营业执照证件',
  `scan_card` varchar(255) DEFAULT NULL COMMENT '扫描件',
  `business_licence_overtime` datetime DEFAULT NULL COMMENT '营业执照到期时间',
  `legal_name` varchar(20) DEFAULT NULL COMMENT '法人',
  `legal_idcard` varchar(18) DEFAULT NULL COMMENT '法人身份证号码',
  `legal_scan_idcard` varchar(255) DEFAULT NULL COMMENT '法人身份证扫描件',
  `is_delete` enum('yes','no') DEFAULT 'no',
  PRIMARY KEY (`cooperator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='合作商';

-- ----------------------------
-- Records of erp_cooperator
-- ----------------------------

-- ----------------------------
-- Table structure for erp_delivery_check
-- ----------------------------
DROP TABLE IF EXISTS `erp_delivery_check`;
CREATE TABLE `erp_delivery_check` (
  `delivery_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '送检id',
  `delivery_type` varchar(255) DEFAULT NULL,
  `content` text COMMENT '送检json对象',
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`delivery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='送检表';

-- ----------------------------
-- Records of erp_delivery_check
-- ----------------------------

-- ----------------------------
-- Table structure for erp_deliver_products
-- ----------------------------
DROP TABLE IF EXISTS `erp_deliver_products`;
CREATE TABLE `erp_deliver_products` (
  `deliver_id` int(11) NOT NULL AUTO_INCREMENT,
  `deliver_sn` varchar(255) DEFAULT NULL COMMENT '送货码SN',
  `deliver_product_time` datetime DEFAULT NULL,
  `deliver_product_name` varchar(20) DEFAULT NULL COMMENT '送货名称',
  `deliver_product_sum` varchar(10) DEFAULT NULL COMMENT '送货数量',
  `deliver_product_type` tinyint(4) DEFAULT NULL COMMENT '送货类型',
  PRIMARY KEY (`deliver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='补单送货单管理 (后期销售)';

-- ----------------------------
-- Records of erp_deliver_products
-- ----------------------------

-- ----------------------------
-- Table structure for erp_deparment_role
-- ----------------------------
DROP TABLE IF EXISTS `erp_deparment_role`;
CREATE TABLE `erp_deparment_role` (
  `deparment_role_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`deparment_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部门角色表';

-- ----------------------------
-- Records of erp_deparment_role
-- ----------------------------

-- ----------------------------
-- Table structure for erp_department
-- ----------------------------
DROP TABLE IF EXISTS `erp_department`;
CREATE TABLE `erp_department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) DEFAULT NULL,
  `id_delete` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部门表';

-- ----------------------------
-- Records of erp_department
-- ----------------------------

-- ----------------------------
-- Table structure for erp_distributor
-- ----------------------------
DROP TABLE IF EXISTS `erp_distributor`;
CREATE TABLE `erp_distributor` (
  `create_staff_id` int(11) NOT NULL COMMENT '销售员创建用户id',
  `distributor_id` int(11) DEFAULT NULL COMMENT '经销商id',
  `cooperator_id` int(11) DEFAULT NULL COMMENT '合作商id',
  `shop_name` varchar(60) DEFAULT NULL COMMENT '店铺名称',
  `main_produce` varchar(255) DEFAULT NULL COMMENT '主炒产品',
  `year_sale_size` int(11) DEFAULT NULL COMMENT '年销售规模',
  `company_num` int(11) DEFAULT NULL COMMENT '公司人员数量',
  `reputation` varchar(20) DEFAULT NULL COMMENT '信誉度',
  `is_delete` enum('yes','no') DEFAULT 'no',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`create_staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='经销商表';

-- ----------------------------
-- Records of erp_distributor
-- ----------------------------

-- ----------------------------
-- Table structure for erp_flow
-- ----------------------------
DROP TABLE IF EXISTS `erp_flow`;
CREATE TABLE `erp_flow` (
  `flow_id` int(11) NOT NULL,
  `flow_name` varchar(255) DEFAULT NULL COMMENT '流程名称',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `is_delete` enum('yes','no') DEFAULT 'no',
  PRIMARY KEY (`flow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='主流程';

-- ----------------------------
-- Records of erp_flow
-- ----------------------------

-- ----------------------------
-- Table structure for erp_login_log
-- ----------------------------
DROP TABLE IF EXISTS `erp_login_log`;
CREATE TABLE `erp_login_log` (
  `login_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL COMMENT '操作者',
  `ip_login` varchar(255) DEFAULT NULL COMMENT 'ip地址',
  `req` varchar(255) DEFAULT NULL COMMENT '请求参数',
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`login_log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='登录日志';

-- ----------------------------
-- Records of erp_login_log
-- ----------------------------
INSERT INTO `erp_login_log` VALUES ('1', '1', '192.168.1.1', null, '2018-09-25 17:07:14');
INSERT INTO `erp_login_log` VALUES ('2', '2', '127.0.0.1', null, '2018-10-16 17:07:35');

-- ----------------------------
-- Table structure for erp_menu
-- ----------------------------
DROP TABLE IF EXISTS `erp_menu`;
CREATE TABLE `erp_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) DEFAULT NULL COMMENT '菜单名称',
  `url` varchar(255) DEFAULT NULL COMMENT '请求地址',
  `par_id` int(11) DEFAULT NULL COMMENT '上一级的id',
  `icon` varchar(20) DEFAULT NULL COMMENT '小图标',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `is_delete` enum('no','yes') DEFAULT 'no',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8 COMMENT='菜单管理';

-- ----------------------------
-- Records of erp_menu
-- ----------------------------
INSERT INTO `erp_menu` VALUES ('1', '首页', '/', '0', '1', '0000-00-00 00:00:00', 'no');
INSERT INTO `erp_menu` VALUES ('2', '用户管理', null, '0', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('3', '用户列表', '/erp/userList', '2', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('4', '用户删除', '/erp/delUser', '2', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('7', '用户添加', '/erp/addUser', '2', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('8', '首页', '/', '1', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('20', '订单管理', null, '0', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('21', '产品管理', null, '0', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('42', '供应商', null, '0', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('43', '经销商', null, '0', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('44', '发起订单', null, '43', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('45', '经销商列表', null, '42', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('46', '申请入驻', null, '43', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('47', '计划任务', null, '43', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('48', '产品列表', null, '21', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('49', '分类管理', null, '21', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('50', '品牌管理', '/pro/brandList', '21', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('51', '订单列表', '/order/orderList', '20', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('52', '订单列表', '/order/saleList', '20', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('53', '合同管理', '/contract/contractList', '0', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('54', '合同列表', '/contract/contractList', '53', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('55', '合同计划', '/contract/planTask', '53', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('56', '交易管理', '/transaction/transactionList', '0', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('57', '交易订单', '/transaction/transactionList', '56', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('58', '订单列表', '/transaction/transactionOrderList', '56', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('59', '退款列表', '/transaction/transactionBackList', '56', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('60', '支付管理', '/pay/payList', '0', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('61', '账户管理', '/pay/accountList', '60', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('62', '账户管理', '/pay/configList', '60', null, null, 'no');
INSERT INTO `erp_menu` VALUES ('70', '售后管理', '/afterSale/afterSaleList', '0', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('71', '售后列表', '/afterSale/afterSaleList', '70', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('72', '新品送检', '/afterSale/productCheck', '70', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('73', '送货单管理', '/afterSale/deliveryList', '70', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('74', '售后跟进', '/afterSale/afterSaleLog', '70', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('75', '财务管理', '/final/finalList', '0', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('76', '财务对账', '/final/finalList', '75', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('77', '报表信息', '/final/reportList', '75', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('78', '入库审核', '/final/storageCheck', '75', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('79', '订单异常', '/final/orderError', '75', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('80', '系统管理', '/sys/sysList', '0', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('81', '权限管理', '', '0', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('82', '添加菜单', '/erp/menuAdd', '81', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('83', '菜单列表', '/erp/getUserAllList', '81', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('84', '用户管理', '/erp/userList', '81', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('85', '角色列表', '/erp/getRoleList', '81', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('86', '登录日志', '/log/loginList', '80', '', null, 'no');
INSERT INTO `erp_menu` VALUES ('87', '个人心中', '/erp/adminInfo', '0', '', null, 'no');

-- ----------------------------
-- Table structure for erp_node
-- ----------------------------
DROP TABLE IF EXISTS `erp_node`;
CREATE TABLE `erp_node` (
  `node_id` int(11) NOT NULL,
  `flow_id` int(11) DEFAULT NULL COMMENT '流程id',
  `node_name` varchar(255) DEFAULT NULL COMMENT '节点名称',
  `is_delete` enum('yes','no') DEFAULT 'no',
  PRIMARY KEY (`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='节点表';

-- ----------------------------
-- Records of erp_node
-- ----------------------------

-- ----------------------------
-- Table structure for erp_order
-- ----------------------------
DROP TABLE IF EXISTS `erp_order`;
CREATE TABLE `erp_order` (
  `order_id` int(10) NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(20) NOT NULL COMMENT '主订单SN',
  `add_admin_id` int(10) NOT NULL COMMENT '发起人',
  `pro_price` int(11) DEFAULT NULL COMMENT '商品价格',
  `pro_num` int(10) DEFAULT NULL COMMENT '商品数量',
  `supplier` varchar(20) DEFAULT NULL COMMENT '供货商',
  `product_name` varchar(60) DEFAULT NULL COMMENT '商品名称',
  `order_mark` varchar(255) DEFAULT NULL COMMENT '订单备注（销售）',
  `status` tinyint(4) NOT NULL COMMENT '主订单状态：1进行中 ,2已完成',
  `flow_id` int(10) DEFAULT NULL COMMENT '流程id',
  `create_time` datetime DEFAULT NULL COMMENT '订单生成时间',
  `finish_time` datetime DEFAULT NULL COMMENT '完成时间',
  `is_delete` enum('yes','no') DEFAULT 'no',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of erp_order
-- ----------------------------
INSERT INTO `erp_order` VALUES ('1', '1', '0', '535685', null, null, null, null, '0', null, null, null, 'no');

-- ----------------------------
-- Table structure for erp_order_node
-- ----------------------------
DROP TABLE IF EXISTS `erp_order_node`;
CREATE TABLE `erp_order_node` (
  `order_node_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `flow_id` int(11) DEFAULT NULL COMMENT '流程id',
  `status` tinyint(4) DEFAULT NULL COMMENT ' 1未激活，2已激活，3已忽略，4已完成',
  `staff_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `active_time` datetime DEFAULT NULL COMMENT '激活时间',
  `ignore_time` datetime DEFAULT NULL COMMENT '忽略时间',
  `finish_time` datetime DEFAULT NULL COMMENT '完成时间',
  PRIMARY KEY (`order_node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单流程表';

-- ----------------------------
-- Records of erp_order_node
-- ----------------------------

-- ----------------------------
-- Table structure for erp_order_plan
-- ----------------------------
DROP TABLE IF EXISTS `erp_order_plan`;
CREATE TABLE `erp_order_plan` (
  `order_plan_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT '1' COMMENT '关联订单',
  `order_plan_type` int(10) DEFAULT '1' COMMENT '计划订单状态 1执行中，2已完成 3代审核 4有异议 5售后中 6待生产，7生产中，8待收货，9财务对账 10订单完成',
  `order_plan_sn` varchar(20) DEFAULT NULL COMMENT '计划订单sn',
  `objection_id` int(11) DEFAULT NULL COMMENT '异议发起人',
  `order_plan_price` int(11) DEFAULT NULL COMMENT '计划单价',
  `order_plan_num` int(11) DEFAULT NULL COMMENT '计划数量',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `finish_time` datetime DEFAULT NULL COMMENT '完成时间',
  `objection_time` datetime DEFAULT NULL COMMENT '异议发起时间',
  `id_delete` enum('yes','no') DEFAULT 'no',
  PRIMARY KEY (`order_plan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='计划订单';

-- ----------------------------
-- Records of erp_order_plan
-- ----------------------------

-- ----------------------------
-- Table structure for erp_order_sale
-- ----------------------------
DROP TABLE IF EXISTS `erp_order_sale`;
CREATE TABLE `erp_order_sale` (
  `sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL COMMENT '业务员id',
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='业务销售表';

-- ----------------------------
-- Records of erp_order_sale
-- ----------------------------

-- ----------------------------
-- Table structure for erp_price_log
-- ----------------------------
DROP TABLE IF EXISTS `erp_price_log`;
CREATE TABLE `erp_price_log` (
  `price_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL COMMENT '订单',
  `req` varchar(255) DEFAULT NULL,
  `rsp` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`price_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资金日志';

-- ----------------------------
-- Records of erp_price_log
-- ----------------------------

-- ----------------------------
-- Table structure for erp_products_check
-- ----------------------------
DROP TABLE IF EXISTS `erp_products_check`;
CREATE TABLE `erp_products_check` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT '1' COMMENT '1通过 2驳回 3待审核',
  `mark` varchar(255) DEFAULT NULL COMMENT '驳回备注',
  `content` varchar(255) DEFAULT NULL COMMENT '审核json对象',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='商品审核表';

-- ----------------------------
-- Records of erp_products_check
-- ----------------------------

-- ----------------------------
-- Table structure for erp_role
-- ----------------------------
DROP TABLE IF EXISTS `erp_role`;
CREATE TABLE `erp_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) DEFAULT NULL,
  `is_delete` enum('yes','no') DEFAULT 'no',
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of erp_role
-- ----------------------------
INSERT INTO `erp_role` VALUES ('1', '超级管理员', 'no', null, null);
INSERT INTO `erp_role` VALUES ('2', '管理员', 'no', null, null);
INSERT INTO `erp_role` VALUES ('3', '销售员', 'no', null, null);
INSERT INTO `erp_role` VALUES ('4', '采购员', 'no', null, null);
INSERT INTO `erp_role` VALUES ('5', '供应商', 'no', null, null);
INSERT INTO `erp_role` VALUES ('6', '仓库管理员', 'no', null, null);
INSERT INTO `erp_role` VALUES ('7', '财务', 'no', null, null);
INSERT INTO `erp_role` VALUES ('8', '2312323', 'no', null, null);
INSERT INTO `erp_role` VALUES ('9', '2222', 'no', null, null);
INSERT INTO `erp_role` VALUES ('10', '3333', 'no', null, null);
INSERT INTO `erp_role` VALUES ('11', '2222', 'no', null, null);
INSERT INTO `erp_role` VALUES ('12', '324234', 'no', null, null);
INSERT INTO `erp_role` VALUES ('13', '哈哈哈哈哈啊哈', 'no', null, null);
INSERT INTO `erp_role` VALUES ('14', '234', 'no', null, null);
INSERT INTO `erp_role` VALUES ('15', '1111', 'no', null, null);
INSERT INTO `erp_role` VALUES ('16', '333222', 'no', null, null);
INSERT INTO `erp_role` VALUES ('19', '4444', 'no', null, null);
INSERT INTO `erp_role` VALUES ('20', '管理员1222', 'no', null, null);
INSERT INTO `erp_role` VALUES ('21', '22222332', 'no', null, null);
INSERT INTO `erp_role` VALUES ('22', '12', 'no', null, null);
INSERT INTO `erp_role` VALUES ('23', '234234 ', 'no', null, null);

-- ----------------------------
-- Table structure for erp_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `erp_role_menu`;
CREATE TABLE `erp_role_menu` (
  `role_menu_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `menu_id` varchar(255) DEFAULT NULL COMMENT '权限列表',
  PRIMARY KEY (`role_menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色菜单';

-- ----------------------------
-- Records of erp_role_menu
-- ----------------------------

-- ----------------------------
-- Table structure for erp_staff
-- ----------------------------
DROP TABLE IF EXISTS `erp_staff`;
CREATE TABLE `erp_staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(255) DEFAULT NULL COMMENT '用户名',
  `passwd` varchar(255) DEFAULT NULL COMMENT '密码',
  `staff_phone` varchar(255) DEFAULT NULL COMMENT '手机号',
  `company_name` varchar(255) DEFAULT NULL COMMENT '公司名称',
  `company_address` varchar(255) DEFAULT NULL COMMENT '公司地址',
  `type` tinyint(4) DEFAULT '1' COMMENT '类型 1员工，2合作商',
  `is_delete` enum('yes','no') DEFAULT 'no',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COMMENT='员工用户表';

-- ----------------------------
-- Records of erp_staff
-- ----------------------------
INSERT INTO `erp_staff` VALUES ('9', '敖德萨所多sad', null, '3123123', '3', '12', '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('15', '我去额1111112323', null, '3123', '12312', '水电费 ', '1', 'yes', null);
INSERT INTO `erp_staff` VALUES ('18', null, null, '12', null, '1', '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('19', '234234', null, null, null, null, '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('30', '11', '22', '33', null, null, '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('31', '张晓', '333', '111', null, null, '1', 'yes', null);
INSERT INTO `erp_staff` VALUES ('32', '张晓22', '333', '111', null, null, '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('33', '萧大四的', '2231', '111', null, null, '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('34', '哈撒大苏打', '1132', '123', null, null, '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('35', '小次奥', '1132', '123', null, null, '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('38', '嘻嘻嘻', '21321312', '222', '地址', '啊啊啊啊', '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('39', '行啊的', 'a68a6962afed86edd5ee808161151b4b', '12233', null, null, '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('41', '测试二', '4297f44b13955235245b2497399d7a93', '2131231', '222', '333', '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('42', '测试', '96e79218965eb72c92a549dd5a330112', '123456', '222', '3', '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('43', '测试3', '96e79218965eb72c92a549dd5a330112', '123456', '32423', '222', '1', 'yes', null);
INSERT INTO `erp_staff` VALUES ('45', 'asdasadasd', null, null, null, null, '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('46', 'asda', null, null, null, null, '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('47', 'd', null, null, null, null, '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('48', 'asd', null, null, null, null, '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('49', 'asd', null, null, null, null, '1', 'no', null);
INSERT INTO `erp_staff` VALUES ('56', '23423', null, '23123', '123123', '123', '1', 'yes', null);

-- ----------------------------
-- Table structure for erp_staff_role
-- ----------------------------
DROP TABLE IF EXISTS `erp_staff_role`;
CREATE TABLE `erp_staff_role` (
  `role_staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`role_staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='员工角色关系表';

-- ----------------------------
-- Records of erp_staff_role
-- ----------------------------
INSERT INTO `erp_staff_role` VALUES ('1', '1', '1');
INSERT INTO `erp_staff_role` VALUES ('2', '2', '2');
INSERT INTO `erp_staff_role` VALUES ('3', '3', '3');
INSERT INTO `erp_staff_role` VALUES ('4', '4', '4');
INSERT INTO `erp_staff_role` VALUES ('5', '5', '5');
INSERT INTO `erp_staff_role` VALUES ('6', '6', '6');
INSERT INTO `erp_staff_role` VALUES ('7', '7', '7');
INSERT INTO `erp_staff_role` VALUES ('8', '8', '8');
INSERT INTO `erp_staff_role` VALUES ('9', '9', '9');

-- ----------------------------
-- Table structure for erp_supplier
-- ----------------------------
DROP TABLE IF EXISTS `erp_supplier`;
CREATE TABLE `erp_supplier` (
  `supplier_id` int(11) NOT NULL COMMENT '供应商id',
  `cooperator_id` int(11) DEFAULT NULL COMMENT '合作商id',
  `factory_area` varchar(255) DEFAULT NULL COMMENT '工厂面积',
  `storage_area` varchar(255) DEFAULT NULL COMMENT '仓储面积',
  `scale_of_productio` varchar(10) DEFAULT NULL COMMENT '年生产规模',
  `factory_level` varchar(10) DEFAULT NULL COMMENT '工厂等级',
  `day_dev_num` int(11) DEFAULT NULL COMMENT '日产量',
  `dev_qualifications` varchar(255) DEFAULT NULL COMMENT '生产资质',
  `reputation` varchar(10) DEFAULT NULL COMMENT '信誉度',
  `bond` int(11) DEFAULT NULL COMMENT '保证金',
  `type` tinyint(255) DEFAULT NULL COMMENT '发货状态id',
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='供应商表';

-- ----------------------------
-- Records of erp_supplier
-- ----------------------------

-- ----------------------------
-- Table structure for order_log
-- ----------------------------
DROP TABLE IF EXISTS `order_log`;
CREATE TABLE `order_log` (
  `order_id` int(11) NOT NULL,
  `supplier` varchar(255) DEFAULT NULL COMMENT '供货商',
  `product_name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `supplier_num` int(11) DEFAULT NULL COMMENT '库存',
  `supplier_lock_num` int(11) DEFAULT NULL COMMENT '锁定库存',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单日志';

-- ----------------------------
-- Records of order_log
-- ----------------------------

-- ----------------------------
-- Table structure for order_product_attribute
-- ----------------------------
DROP TABLE IF EXISTS `order_product_attribute`;
CREATE TABLE `order_product_attribute` (
  `product_attribute_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `imgs` varchar(255) DEFAULT NULL COMMENT '商品图片',
  `product_attribute_name` varchar(255) DEFAULT NULL COMMENT '商品属性名称',
  `product_attribute_value` varchar(255) DEFAULT NULL COMMENT '商品属性值',
  PRIMARY KEY (`product_attribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品属性表';

-- ----------------------------
-- Records of order_product_attribute
-- ----------------------------

-- ----------------------------
-- Table structure for order_product_attribute_log
-- ----------------------------
DROP TABLE IF EXISTS `order_product_attribute_log`;
CREATE TABLE `order_product_attribute_log` (
  `product_attribute_log_id` int(11) NOT NULL,
  `product_attribute_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `imgs` varchar(255) DEFAULT NULL COMMENT '商品图片',
  `product_attribute_name` varchar(255) DEFAULT NULL,
  `product_attribute_value` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL COMMENT '修改的时间',
  PRIMARY KEY (`product_attribute_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品属性修改日志表（待定）';

-- ----------------------------
-- Records of order_product_attribute_log
-- ----------------------------

-- ----------------------------
-- Table structure for order_product_info
-- ----------------------------
DROP TABLE IF EXISTS `order_product_info`;
CREATE TABLE `order_product_info` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_type` tinyint(4) DEFAULT NULL COMMENT '1上架 2下架 ',
  `product_code` tinyint(4) DEFAULT NULL COMMENT '1入库 2出库',
  `create_time` datetime DEFAULT NULL,
  `up_time` datetime DEFAULT NULL COMMENT '上架时间',
  `down_time` datetime DEFAULT NULL COMMENT '下架时间',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品参数表';

-- ----------------------------
-- Records of order_product_info
-- ----------------------------

-- ----------------------------
-- Table structure for order_purchase
-- ----------------------------
DROP TABLE IF EXISTS `order_purchase`;
CREATE TABLE `order_purchase` (
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `oper_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT '1登记中，2采购中，采购完成',
  PRIMARY KEY (`purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='采购表';

-- ----------------------------
-- Records of order_purchase
-- ----------------------------

-- ----------------------------
-- Table structure for order_stock
-- ----------------------------
DROP TABLE IF EXISTS `order_stock`;
CREATE TABLE `order_stock` (
  `stock_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL COMMENT '供货商',
  `product_name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `oper_id` int(11) DEFAULT NULL COMMENT '操作者',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库存表';

-- ----------------------------
-- Records of order_stock
-- ----------------------------
