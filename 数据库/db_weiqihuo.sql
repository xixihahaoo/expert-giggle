/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : db_weiqihuo

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 17/02/2023 10:23:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for dict_duanxin_service
-- ----------------------------
DROP TABLE IF EXISTS `dict_duanxin_service`;
CREATE TABLE `dict_duanxin_service`  (
  `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '短信平台服务商名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '短信类型表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dict_duanxin_service
-- ----------------------------
INSERT INTO `dict_duanxin_service` VALUES (1, '起点');
INSERT INTO `dict_duanxin_service` VALUES (2, '启信');
INSERT INTO `dict_duanxin_service` VALUES (3, '阿里大于');

-- ----------------------------
-- Table structure for dict_jl_pay
-- ----------------------------
DROP TABLE IF EXISTS `dict_jl_pay`;
CREATE TABLE `dict_jl_pay`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单号码',
  `code` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单编码',
  `post_data` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单提交参数',
  `url` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单提交地址',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `order_no`(`order_no`) USING BTREE,
  UNIQUE INDEX `code`(`code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '九龙网关支付临时订单提交' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for dict_pay_type
-- ----------------------------
DROP TABLE IF EXISTS `dict_pay_type`;
CREATE TABLE `dict_pay_type`  (
  `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pay_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付类型名称',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '支付类型表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dict_pay_type
-- ----------------------------
INSERT INTO `dict_pay_type` VALUES (1, '中信扫码支付', '2017-01-09 15:28:39');
INSERT INTO `dict_pay_type` VALUES (2, '首信易扫码支付', '2017-01-09 15:28:42');
INSERT INTO `dict_pay_type` VALUES (3, '首信易银联支付', '2017-01-13 16:03:19');
INSERT INTO `dict_pay_type` VALUES (4, '环迅微信扫码支付', '2017-02-06 17:28:59');
INSERT INTO `dict_pay_type` VALUES (5, '环迅支付宝扫码支付', '2017-02-07 14:53:52');
INSERT INTO `dict_pay_type` VALUES (6, '钱通微信扫码支付', '2017-05-11 22:56:49');
INSERT INTO `dict_pay_type` VALUES (7, '钱通支付宝扫码支付', '2017-05-11 22:56:55');
INSERT INTO `dict_pay_type` VALUES (8, '钱通快捷支付', '2017-06-12 18:37:09');
INSERT INTO `dict_pay_type` VALUES (9, '中南微信扫码支付', '2017-06-12 18:37:09');
INSERT INTO `dict_pay_type` VALUES (10, '中南支付宝扫码支付', '2017-06-12 18:37:09');
INSERT INTO `dict_pay_type` VALUES (11, '中南快捷支付', '2017-06-12 18:37:09');
INSERT INTO `dict_pay_type` VALUES (12, '中南QQ扫码支付', '2017-08-16 22:50:46');
INSERT INTO `dict_pay_type` VALUES (14, '二维码支付宝扫码支付', '2017-11-03 10:19:57');
INSERT INTO `dict_pay_type` VALUES (17, '二维码微信扫码支付', '2017-11-06 09:32:09');
INSERT INTO `dict_pay_type` VALUES (18, '二维码支付宝扫码支付', '2017-11-06 09:32:30');
INSERT INTO `dict_pay_type` VALUES (20, '畅佰微信支付', '2017-06-25 10:49:02');
INSERT INTO `dict_pay_type` VALUES (21, '畅佰支付宝支付', '2017-06-25 10:49:12');
INSERT INTO `dict_pay_type` VALUES (22, '畅佰快捷支付', '2017-06-25 10:49:23');
INSERT INTO `dict_pay_type` VALUES (23, '易通快捷', '2017-07-19 23:13:09');
INSERT INTO `dict_pay_type` VALUES (24, '易通微信公众号支付', '2017-08-17 10:21:08');
INSERT INTO `dict_pay_type` VALUES (25, '恒生国际微信支付', '2017-08-30 22:26:59');
INSERT INTO `dict_pay_type` VALUES (26, '九龙快捷支付', '2017-10-16 16:09:58');
INSERT INTO `dict_pay_type` VALUES (27, '九龙网关支付', '2017-10-16 16:09:58');
INSERT INTO `dict_pay_type` VALUES (28, '支付宝手动扫码充值', '2018-09-10 14:55:44');
INSERT INTO `dict_pay_type` VALUES (29, '微信手动扫码充值', '2018-09-10 14:55:55');
INSERT INTO `dict_pay_type` VALUES (30, '管理员手动充值', '2018-09-13 14:03:09');
INSERT INTO `dict_pay_type` VALUES (31, '网银手动充值', '2018-09-14 17:19:33');

-- ----------------------------
-- Table structure for dict_userinfo_type
-- ----------------------------
DROP TABLE IF EXISTS `dict_userinfo_type`;
CREATE TABLE `dict_userinfo_type`  (
  `user_type_id` smallint(4) UNSIGNED NOT NULL DEFAULT 0,
  `user_type_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`user_type_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户类型表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dict_userinfo_type
-- ----------------------------
INSERT INTO `dict_userinfo_type` VALUES (3, '后台管理员');
INSERT INTO `dict_userinfo_type` VALUES (4, '普通用户');
INSERT INTO `dict_userinfo_type` VALUES (5, '运营中心');
INSERT INTO `dict_userinfo_type` VALUES (6, '代理');

-- ----------------------------
-- Table structure for log_cli
-- ----------------------------
DROP TABLE IF EXISTS `log_cli`;
CREATE TABLE `log_cli`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` smallint(4) UNSIGNED NULL DEFAULT 0 COMMENT '执行的类型，1,商品状态 2前几分钟休市  3佣金周结',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `script_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '执行的脚本的名称',
  `note` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '脚本运行备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for log_mobile_code
-- ----------------------------
DROP TABLE IF EXISTS `log_mobile_code`;
CREATE TABLE `log_mobile_code`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机号',
  `mobile_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机验证码',
  `type` tinyint(2) UNSIGNED NULL DEFAULT 1 COMMENT '1.起点，2.启信。3.阿里大于',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '短信日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wp_accountinfo
-- ----------------------------
DROP TABLE IF EXISTS `wp_accountinfo`;
CREATE TABLE `wp_accountinfo`  (
  `aid` int(50) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `balance` double(24, 2) NULL DEFAULT 0.00 COMMENT '用户资金帐户剩余金额',
  `money_total` decimal(10, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '用户提现累积金额',
  `recharge_total` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '累计充值金额',
  `income_total` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '累计盈利金额',
  `loss_total` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '累计亏损金额',
  `gold` double(24, 2) NULL DEFAULT 0.00 COMMENT '  金币',
  `frozen` double(255, 0) NULL DEFAULT NULL COMMENT '冻结金额',
  `pwd` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '交易密码',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `img` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '推荐二维码',
  `gold_threshold` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '运营中心 出金阈值',
  `frozen_threshold` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '运营中心 冻结阈值',
  PRIMARY KEY (`aid`) USING BTREE,
  UNIQUE INDEX `uid`(`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 184 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户资金表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_accountinfo
-- ----------------------------
INSERT INTO `wp_accountinfo` VALUES (1, 3, 1087926.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, '2018-10-05 20:54:03', NULL, 10500.00, 110000.00);
INSERT INTO `wp_accountinfo` VALUES (2, 5, 7224.00, 100.00, 4854.00, 57467.00, 13953.00, 90726.00, NULL, NULL, '2020-02-18 05:50:01', 'Uploads/qrcode/extension_mtve.png', 0.00, 0.00);

-- ----------------------------
-- Table structure for wp_action_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_action_log`;
CREATE TABLE `wp_action_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作',
  `action_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '操作描述',
  `uid` int(11) NULL DEFAULT NULL COMMENT '登录用户',
  `uname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登录用户名',
  `cTime` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `params` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '请求参数',
  `login_sign` int(11) NULL DEFAULT 0 COMMENT '某次登录标识',
  `request_method` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '请求方式（GET,POST）',
  `type` tinyint(1) NULL DEFAULT 0 COMMENT '日志类型，0普通流水日志，1手动记录日志',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_uname`(`uname`) USING BTREE,
  INDEX `idx_date`(`cTime`) USING BTREE,
  INDEX `idx_action`(`action`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '操作记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wp_agent_extra
-- ----------------------------
DROP TABLE IF EXISTS `wp_agent_extra`;
CREATE TABLE `wp_agent_extra`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `weixin_logo` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `agent_user_id` int(10) UNSIGNED NOT NULL COMMENT '经纪人用户id，对应userinfo',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_agent_extra
-- ----------------------------
INSERT INTO `wp_agent_extra` VALUES (1, '2018-09-07/5b91f35938c19.png', 3, '2018-09-07 11:41:13');

-- ----------------------------
-- Table structure for wp_appupdate
-- ----------------------------
DROP TABLE IF EXISTS `wp_appupdate`;
CREATE TABLE `wp_appupdate`  (
  `appid` int(11) NOT NULL,
  `v` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `andord_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ios_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`appid`) USING BTREE,
  INDEX `appid`(`appid`) USING BTREE,
  INDEX `v`(`v`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wp_balance
-- ----------------------------
DROP TABLE IF EXISTS `wp_balance`;
CREATE TABLE `wp_balance`  (
  `bpid` int(11) NOT NULL AUTO_INCREMENT,
  `b_type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '流水类型，1充值，2提现',
  `bptype` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收支类型',
  `bptime` int(20) NULL DEFAULT NULL COMMENT '操作时间',
  `bpprice` decimal(10, 2) NULL DEFAULT NULL COMMENT '申请提现金额',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `uid` int(11) NULL DEFAULT NULL,
  `isverified` int(11) NULL DEFAULT NULL COMMENT '判断申请是否通过，0失败，1成功',
  `cltime` int(20) NULL DEFAULT NULL COMMENT '审核时间',
  `balanceno` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单编号',
  `shibpprice` decimal(10, 2) UNSIGNED NOT NULL COMMENT '用户余额',
  `status` tinyint(1) NULL DEFAULT 0 COMMENT '0待处理  1完成 ',
  `pay_type` tinyint(2) UNSIGNED NULL DEFAULT 1 COMMENT '支付类型，参照dict_pay_type',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`bpid`) USING BTREE,
  INDEX `b_type`(`b_type`) USING BTREE,
  INDEX `balanceno`(`balanceno`) USING BTREE,
  INDEX `isverified`(`isverified`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '充值提现表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wp_bankinfo
-- ----------------------------
DROP TABLE IF EXISTS `wp_bankinfo`;
CREATE TABLE `wp_bankinfo`  (
  `bid` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '绑定',
  `bankname` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所属银行',
  `province` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '省份',
  `city` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '城市',
  `branch` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支行名',
  `banknumber` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '银行卡号',
  `busername` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `card` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '身份证号',
  `tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '银行预留手机号',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`bid`) USING BTREE,
  UNIQUE INDEX `uid`(`uid`) USING BTREE,
  INDEX `province`(`province`) USING BTREE,
  INDEX `city`(`city`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '银行卡表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wp_city
-- ----------------------------
DROP TABLE IF EXISTS `wp_city`;
CREATE TABLE `wp_city`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `sn` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `joinname` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `parent_id` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `level` tinyint(1) NOT NULL DEFAULT 0 COMMENT '层级',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '状态（0 未开通 1 已开通）',
  `coordinat` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '坐标',
  `baidu_code` smallint(6) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_name`(`name`) USING BTREE,
  INDEX `idx_parentid_vieworder`(`parent_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 910011 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_city
-- ----------------------------
INSERT INTO `wp_city` VALUES (110000, 'B-北京市', '', '北京市', 0, 1, 0, '', 131);
INSERT INTO `wp_city` VALUES (120000, 'T-天津市', '', '天津市', 0, 1, 0, '', 332);
INSERT INTO `wp_city` VALUES (130000, 'H-河北省', '', '河北省', 0, 1, 0, '', 25);
INSERT INTO `wp_city` VALUES (140000, 'S-山西省', '', '山西省', 0, 1, 0, '', 10);
INSERT INTO `wp_city` VALUES (150000, 'N-内蒙古自治区', '', '内蒙古自治区', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (210000, 'L-辽宁省', '', '辽宁省', 0, 1, 0, '', 19);
INSERT INTO `wp_city` VALUES (220000, 'J-吉林省', '', '吉林省', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (230000, 'H-黑龙江省', '', '黑龙江省', 0, 1, 0, '', 2);
INSERT INTO `wp_city` VALUES (310000, 'S-上海市', '', '上海市', 0, 1, 0, '', 289);
INSERT INTO `wp_city` VALUES (320000, 'J-江苏省', '', '江苏省', 0, 1, 0, '', 18);
INSERT INTO `wp_city` VALUES (330000, 'Z-浙江省', '', '浙江省', 0, 1, 0, '', 29);
INSERT INTO `wp_city` VALUES (340000, 'A-安徽省', '', '安徽省', 0, 1, 0, '', 23);
INSERT INTO `wp_city` VALUES (350000, 'F-福建省', '', '福建省', 0, 1, 0, '', 16);
INSERT INTO `wp_city` VALUES (360000, 'J-江西省', '', '江西省', 0, 1, 0, '', 31);
INSERT INTO `wp_city` VALUES (370000, 'S-山东省', '', '山东省', 0, 1, 1, '', 8);
INSERT INTO `wp_city` VALUES (410000, 'H-河南省', '', '河南省', 0, 1, 0, '', 30);
INSERT INTO `wp_city` VALUES (420000, 'H-湖北省', '', '湖北省', 0, 1, 0, '', 15);
INSERT INTO `wp_city` VALUES (430000, 'H-湖南省', '', '湖南省', 0, 1, 0, '', 26);
INSERT INTO `wp_city` VALUES (440000, 'G-广东省', '', '广东省', 0, 1, 0, '', 7);
INSERT INTO `wp_city` VALUES (450000, 'G-广西壮族自治区', '', '广西壮族自治区', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (460000, 'H-海南省', '', '海南省', 0, 1, 0, '', 21);
INSERT INTO `wp_city` VALUES (500000, 'C-重庆市', '', '重庆市', 0, 1, 0, '', 132);
INSERT INTO `wp_city` VALUES (510000, 'S-四川省', '', '四川省', 0, 1, 0, '', 32);
INSERT INTO `wp_city` VALUES (520000, 'G-贵州省', '', '贵州省', 0, 1, 0, '', 24);
INSERT INTO `wp_city` VALUES (530000, 'Y-云南省', '', '云南省', 0, 1, 0, '', 28);
INSERT INTO `wp_city` VALUES (540000, 'X-西藏自治区', '', '西藏自治区', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (610000, 'S-陕西省', '', '陕西省', 0, 1, 0, '', 27);
INSERT INTO `wp_city` VALUES (620000, 'G-甘肃省', '', '甘肃省', 0, 1, 0, '', 6);
INSERT INTO `wp_city` VALUES (630000, 'Q-青海省', '', '青海省', 0, 1, 0, '', 11);
INSERT INTO `wp_city` VALUES (640000, 'N-宁夏回族自治区', '', '宁夏回族自治区', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (650000, 'X-新疆维吾尔自治区', '', '新疆维吾尔自治区', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (710000, 'T-台湾省', '', '台湾省', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (810000, 'X-香港特别行政区', '', '香港特别行政区', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (820000, 'A-澳门特别行政区', '', '澳门特别行政区', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (110100, '北京市', '', '北京市,北京市', 110000, 2, 0, '', 131);
INSERT INTO `wp_city` VALUES (110200, '县', '', '北京市,县', 110000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (120100, '市辖区', '', '天津市,市辖区', 120000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (120200, '县', '', '天津市,县', 120000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (130100, '石家庄市', '', '河北省,石家庄市', 130000, 2, 0, '', 150);
INSERT INTO `wp_city` VALUES (130200, '唐山市', '', '河北省,唐山市', 130000, 2, 0, '', 265);
INSERT INTO `wp_city` VALUES (130300, '秦皇岛市', '', '河北省,秦皇岛市', 130000, 2, 0, '', 148);
INSERT INTO `wp_city` VALUES (130400, '邯郸市', '', '河北省,邯郸市', 130000, 2, 0, '', 151);
INSERT INTO `wp_city` VALUES (130500, '邢台市', '', '河北省,邢台市', 130000, 2, 0, '', 266);
INSERT INTO `wp_city` VALUES (130600, '保定市', '', '河北省,保定市', 130000, 2, 0, '', 307);
INSERT INTO `wp_city` VALUES (130700, '张家口市', '', '河北省,张家口市', 130000, 2, 0, '', 264);
INSERT INTO `wp_city` VALUES (130800, '承德市', '', '河北省,承德市', 130000, 2, 0, '', 207);
INSERT INTO `wp_city` VALUES (130900, '沧州市', '', '河北省,沧州市', 130000, 2, 0, '', 149);
INSERT INTO `wp_city` VALUES (131000, '廊坊市', '', '河北省,廊坊市', 130000, 2, 0, '', 191);
INSERT INTO `wp_city` VALUES (131100, '衡水市', '', '河北省,衡水市', 130000, 2, 0, '', 208);
INSERT INTO `wp_city` VALUES (140100, '太原市', '', '山西省,太原市', 140000, 2, 0, '', 176);
INSERT INTO `wp_city` VALUES (140200, '大同市', '', '山西省,大同市', 140000, 2, 0, '', 355);
INSERT INTO `wp_city` VALUES (140300, '阳泉市', '', '山西省,阳泉市', 140000, 2, 0, '', 357);
INSERT INTO `wp_city` VALUES (140400, '长治市', '', '山西省,长治市', 140000, 2, 0, '', 356);
INSERT INTO `wp_city` VALUES (140500, '晋城市', '', '山西省,晋城市', 140000, 2, 0, '', 290);
INSERT INTO `wp_city` VALUES (140600, '朔州市', '', '山西省,朔州市', 140000, 2, 0, '', 237);
INSERT INTO `wp_city` VALUES (140700, '晋中市', '', '山西省,晋中市', 140000, 2, 0, '', 238);
INSERT INTO `wp_city` VALUES (140800, '运城市', '', '山西省,运城市', 140000, 2, 0, '', 328);
INSERT INTO `wp_city` VALUES (140900, '忻州市', '', '山西省,忻州市', 140000, 2, 0, '', 367);
INSERT INTO `wp_city` VALUES (141000, '临汾市', '', '山西省,临汾市', 140000, 2, 0, '', 368);
INSERT INTO `wp_city` VALUES (141100, '吕梁市', '', '山西省,吕梁市', 140000, 2, 0, '', 327);
INSERT INTO `wp_city` VALUES (150100, '呼和浩特市', '', '内蒙古自治区,呼和浩特市', 150000, 2, 0, '', 321);
INSERT INTO `wp_city` VALUES (150200, '包头市', '', '内蒙古自治区,包头市', 150000, 2, 0, '', 229);
INSERT INTO `wp_city` VALUES (150300, '乌海市', '', '内蒙古自治区,乌海市', 150000, 2, 0, '', 123);
INSERT INTO `wp_city` VALUES (150400, '赤峰市', '', '内蒙古自治区,赤峰市', 150000, 2, 0, '', 297);
INSERT INTO `wp_city` VALUES (150500, '通辽市', '', '内蒙古自治区,通辽市', 150000, 2, 0, '', 64);
INSERT INTO `wp_city` VALUES (150600, '鄂尔多斯市', '', '内蒙古自治区,鄂尔多斯市', 150000, 2, 0, '', 283);
INSERT INTO `wp_city` VALUES (150700, '呼伦贝尔市', '', '内蒙古自治区,呼伦贝尔市', 150000, 2, 0, '', 61);
INSERT INTO `wp_city` VALUES (150800, '巴彦淖尔市', '', '内蒙古自治区,巴彦淖尔市', 150000, 2, 0, '', 169);
INSERT INTO `wp_city` VALUES (150900, '乌兰察布市', '', '内蒙古自治区,乌兰察布市', 150000, 2, 0, '', 168);
INSERT INTO `wp_city` VALUES (152200, '兴安盟', '', '内蒙古自治区,兴安盟', 150000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (152500, '锡林郭勒盟', '', '内蒙古自治区,锡林郭勒盟', 150000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (152900, '阿拉善盟', '', '内蒙古自治区,阿拉善盟', 150000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (210100, '沈阳市', '', '辽宁省,沈阳市', 210000, 2, 0, '', 58);
INSERT INTO `wp_city` VALUES (210200, '大连市', '', '辽宁省,大连市', 210000, 2, 0, '', 167);
INSERT INTO `wp_city` VALUES (210300, '鞍山市', '', '辽宁省,鞍山市', 210000, 2, 0, '', 320);
INSERT INTO `wp_city` VALUES (210400, '抚顺市', '', '辽宁省,抚顺市', 210000, 2, 0, '', 184);
INSERT INTO `wp_city` VALUES (210500, '本溪市', '', '辽宁省,本溪市', 210000, 2, 0, '', 227);
INSERT INTO `wp_city` VALUES (210600, '丹东市', '', '辽宁省,丹东市', 210000, 2, 0, '', 282);
INSERT INTO `wp_city` VALUES (210700, '锦州市', '', '辽宁省,锦州市', 210000, 2, 0, '', 166);
INSERT INTO `wp_city` VALUES (210800, '营口市', '', '辽宁省,营口市', 210000, 2, 0, '', 281);
INSERT INTO `wp_city` VALUES (210900, '阜新市', '', '辽宁省,阜新市', 210000, 2, 0, '', 59);
INSERT INTO `wp_city` VALUES (211000, '辽阳市', '', '辽宁省,辽阳市', 210000, 2, 0, '', 351);
INSERT INTO `wp_city` VALUES (211100, '盘锦市', '', '辽宁省,盘锦市', 210000, 2, 0, '', 228);
INSERT INTO `wp_city` VALUES (211200, '铁岭市', '', '辽宁省,铁岭市', 210000, 2, 0, '', 60);
INSERT INTO `wp_city` VALUES (211300, '朝阳市', '', '辽宁省,朝阳市', 210000, 2, 0, '', 280);
INSERT INTO `wp_city` VALUES (211400, '葫芦岛市', '', '辽宁省,葫芦岛市', 210000, 2, 0, '', 319);
INSERT INTO `wp_city` VALUES (220100, '长春市', '', '吉林省,长春市', 220000, 2, 0, '', 53);
INSERT INTO `wp_city` VALUES (220200, '吉林市', '', '吉林省,吉林市', 220000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (220300, '四平市', '', '吉林省,四平市', 220000, 2, 0, '', 56);
INSERT INTO `wp_city` VALUES (220400, '辽源市', '', '吉林省,辽源市', 220000, 2, 0, '', 183);
INSERT INTO `wp_city` VALUES (220500, '通化市', '', '吉林省,通化市', 220000, 2, 0, '', 165);
INSERT INTO `wp_city` VALUES (220600, '白山市', '', '吉林省,白山市', 220000, 2, 0, '', 57);
INSERT INTO `wp_city` VALUES (220700, '松原市', '', '吉林省,松原市', 220000, 2, 0, '', 52);
INSERT INTO `wp_city` VALUES (220800, '白城市', '', '吉林省,白城市', 220000, 2, 0, '', 51);
INSERT INTO `wp_city` VALUES (222400, '延边朝鲜族自治州', '', '吉林省,延边朝鲜族自治州', 220000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (230100, '哈尔滨市', '', '黑龙江省,哈尔滨市', 230000, 2, 0, '', 48);
INSERT INTO `wp_city` VALUES (230200, '齐齐哈尔市', '', '黑龙江省,齐齐哈尔市', 230000, 2, 0, '', 41);
INSERT INTO `wp_city` VALUES (230300, '鸡西市', '', '黑龙江省,鸡西市', 230000, 2, 0, '', 46);
INSERT INTO `wp_city` VALUES (230400, '鹤岗市', '', '黑龙江省,鹤岗市', 230000, 2, 0, '', 43);
INSERT INTO `wp_city` VALUES (230500, '双鸭山市', '', '黑龙江省,双鸭山市', 230000, 2, 0, '', 45);
INSERT INTO `wp_city` VALUES (230600, '大庆市', '', '黑龙江省,大庆市', 230000, 2, 0, '', 50);
INSERT INTO `wp_city` VALUES (230700, '伊春市', '', '黑龙江省,伊春市', 230000, 2, 0, '', 40);
INSERT INTO `wp_city` VALUES (230800, '佳木斯市', '', '黑龙江省,佳木斯市', 230000, 2, 0, '', 42);
INSERT INTO `wp_city` VALUES (230900, '七台河市', '', '黑龙江省,七台河市', 230000, 2, 0, '', 47);
INSERT INTO `wp_city` VALUES (231000, '牡丹江市', '', '黑龙江省,牡丹江市', 230000, 2, 0, '', 49);
INSERT INTO `wp_city` VALUES (231100, '黑河市', '', '黑龙江省,黑河市', 230000, 2, 0, '', 39);
INSERT INTO `wp_city` VALUES (231200, '绥化市', '', '黑龙江省,绥化市', 230000, 2, 0, '', 44);
INSERT INTO `wp_city` VALUES (232700, '大兴安岭地区', '', '黑龙江省,大兴安岭地区', 230000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (310100, '市辖区', '', '上海市,市辖区', 310000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (310200, '县', '', '上海市,县', 310000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (320100, '南京市', '', '江苏省,南京市', 320000, 2, 0, '', 315);
INSERT INTO `wp_city` VALUES (320200, '无锡市', '', '江苏省,无锡市', 320000, 2, 0, '', 317);
INSERT INTO `wp_city` VALUES (320300, '徐州市', '', '江苏省,徐州市', 320000, 2, 0, '', 316);
INSERT INTO `wp_city` VALUES (320400, '常州市', '', '江苏省,常州市', 320000, 2, 0, '', 348);
INSERT INTO `wp_city` VALUES (320500, '苏州市', '', '江苏省,苏州市', 320000, 2, 0, '', 224);
INSERT INTO `wp_city` VALUES (320600, '南通市', '', '江苏省,南通市', 320000, 2, 0, '', 161);
INSERT INTO `wp_city` VALUES (320700, '连云港市', '', '江苏省,连云港市', 320000, 2, 0, '', 347);
INSERT INTO `wp_city` VALUES (320800, '淮安市', '', '江苏省,淮安市', 320000, 2, 0, '', 162);
INSERT INTO `wp_city` VALUES (320900, '盐城市', '', '江苏省,盐城市', 320000, 2, 0, '', 223);
INSERT INTO `wp_city` VALUES (321000, '扬州市', '', '江苏省,扬州市', 320000, 2, 0, '', 346);
INSERT INTO `wp_city` VALUES (321100, '镇江市', '', '江苏省,镇江市', 320000, 2, 0, '', 160);
INSERT INTO `wp_city` VALUES (321200, '泰州市', '', '江苏省,泰州市', 320000, 2, 0, '', 276);
INSERT INTO `wp_city` VALUES (321300, '宿迁市', '', '江苏省,宿迁市', 320000, 2, 0, '', 277);
INSERT INTO `wp_city` VALUES (330100, '杭州市', '', '浙江省,杭州市', 330000, 2, 0, '', 179);
INSERT INTO `wp_city` VALUES (330200, '宁波市', '', '浙江省,宁波市', 330000, 2, 0, '', 180);
INSERT INTO `wp_city` VALUES (330300, '温州市', '', '浙江省,温州市', 330000, 2, 0, '', 178);
INSERT INTO `wp_city` VALUES (330400, '嘉兴市', '', '浙江省,嘉兴市', 330000, 2, 0, '', 334);
INSERT INTO `wp_city` VALUES (330500, '湖州市', '', '浙江省,湖州市', 330000, 2, 0, '', 294);
INSERT INTO `wp_city` VALUES (330600, '绍兴市', '', '浙江省,绍兴市', 330000, 2, 0, '', 293);
INSERT INTO `wp_city` VALUES (330700, '金华市', '', '浙江省,金华市', 330000, 2, 0, '', 333);
INSERT INTO `wp_city` VALUES (330800, '衢州市', '', '浙江省,衢州市', 330000, 2, 0, '', 243);
INSERT INTO `wp_city` VALUES (330900, '舟山市', '', '浙江省,舟山市', 330000, 2, 0, '', 245);
INSERT INTO `wp_city` VALUES (331000, '台州市', '', '浙江省,台州市', 330000, 2, 0, '', 244);
INSERT INTO `wp_city` VALUES (331100, '丽水市', '', '浙江省,丽水市', 330000, 2, 0, '', 292);
INSERT INTO `wp_city` VALUES (340100, '合肥市', '', '安徽省,合肥市', 340000, 2, 0, '', 127);
INSERT INTO `wp_city` VALUES (340200, '芜湖市', '', '安徽省,芜湖市', 340000, 2, 0, '', 129);
INSERT INTO `wp_city` VALUES (340300, '蚌埠市', '', '安徽省,蚌埠市', 340000, 2, 0, '', 126);
INSERT INTO `wp_city` VALUES (340400, '淮南市', '', '安徽省,淮南市', 340000, 2, 0, '', 250);
INSERT INTO `wp_city` VALUES (340500, '马鞍山市', '', '安徽省,马鞍山市', 340000, 2, 0, '', 358);
INSERT INTO `wp_city` VALUES (340600, '淮北市', '', '安徽省,淮北市', 340000, 2, 0, '', 253);
INSERT INTO `wp_city` VALUES (340700, '铜陵市', '', '安徽省,铜陵市', 340000, 2, 0, '', 337);
INSERT INTO `wp_city` VALUES (340800, '安庆市', '', '安徽省,安庆市', 340000, 2, 0, '', 130);
INSERT INTO `wp_city` VALUES (341000, '黄山市', '', '安徽省,黄山市', 340000, 2, 0, '', 252);
INSERT INTO `wp_city` VALUES (341100, '滁州市', '', '安徽省,滁州市', 340000, 2, 0, '', 189);
INSERT INTO `wp_city` VALUES (341200, '阜阳市', '', '安徽省,阜阳市', 340000, 2, 0, '', 128);
INSERT INTO `wp_city` VALUES (341300, '宿州市', '', '安徽省,宿州市', 340000, 2, 0, '', 370);
INSERT INTO `wp_city` VALUES (341500, '六安市', '', '安徽省,六安市', 340000, 2, 0, '', 298);
INSERT INTO `wp_city` VALUES (341600, '亳州市', '', '安徽省,亳州市', 340000, 2, 0, '', 188);
INSERT INTO `wp_city` VALUES (341700, '池州市', '', '安徽省,池州市', 340000, 2, 0, '', 299);
INSERT INTO `wp_city` VALUES (341800, '宣城市', '', '安徽省,宣城市', 340000, 2, 0, '', 190);
INSERT INTO `wp_city` VALUES (350100, '福州市', '', '福建省,福州市', 350000, 2, 0, '', 300);
INSERT INTO `wp_city` VALUES (350200, '厦门市', '', '福建省,厦门市', 350000, 2, 0, '', 194);
INSERT INTO `wp_city` VALUES (350300, '莆田市', '', '福建省,莆田市', 350000, 2, 0, '', 195);
INSERT INTO `wp_city` VALUES (350400, '三明市', '', '福建省,三明市', 350000, 2, 0, '', 254);
INSERT INTO `wp_city` VALUES (350500, '泉州市', '', '福建省,泉州市', 350000, 2, 0, '', 134);
INSERT INTO `wp_city` VALUES (350600, '漳州市', '', '福建省,漳州市', 350000, 2, 0, '', 255);
INSERT INTO `wp_city` VALUES (350700, '南平市', '', '福建省,南平市', 350000, 2, 0, '', 133);
INSERT INTO `wp_city` VALUES (350800, '龙岩市', '', '福建省,龙岩市', 350000, 2, 0, '', 193);
INSERT INTO `wp_city` VALUES (350900, '宁德市', '', '福建省,宁德市', 350000, 2, 0, '', 192);
INSERT INTO `wp_city` VALUES (360100, '南昌市', '', '江西省,南昌市', 360000, 2, 0, '', 163);
INSERT INTO `wp_city` VALUES (360200, '景德镇市', '', '江西省,景德镇市', 360000, 2, 0, '', 225);
INSERT INTO `wp_city` VALUES (360300, '萍乡市', '', '江西省,萍乡市', 360000, 2, 0, '', 350);
INSERT INTO `wp_city` VALUES (360400, '九江市', '', '江西省,九江市', 360000, 2, 0, '', 349);
INSERT INTO `wp_city` VALUES (360500, '新余市', '', '江西省,新余市', 360000, 2, 0, '', 164);
INSERT INTO `wp_city` VALUES (360600, '鹰潭市', '', '江西省,鹰潭市', 360000, 2, 0, '', 279);
INSERT INTO `wp_city` VALUES (360700, '赣州市', '', '江西省,赣州市', 360000, 2, 0, '', 365);
INSERT INTO `wp_city` VALUES (360800, '吉安市', '', '江西省,吉安市', 360000, 2, 0, '', 318);
INSERT INTO `wp_city` VALUES (360900, '宜春市', '', '江西省,宜春市', 360000, 2, 0, '', 278);
INSERT INTO `wp_city` VALUES (361000, '抚州市', '', '江西省,抚州市', 360000, 2, 0, '', 226);
INSERT INTO `wp_city` VALUES (361100, '上饶市', '', '江西省,上饶市', 360000, 2, 0, '', 364);
INSERT INTO `wp_city` VALUES (370100, '济南市', 'jn', '山东省,济南市', 370000, 2, 1, '', 288);
INSERT INTO `wp_city` VALUES (370200, '青岛市', '', '山东省,青岛市', 370000, 2, 1, '', 236);
INSERT INTO `wp_city` VALUES (370300, '淄博市', '', '山东省,淄博市', 370000, 2, 1, '', 354);
INSERT INTO `wp_city` VALUES (370400, '枣庄市', '', '山东省,枣庄市', 370000, 2, 0, '', 172);
INSERT INTO `wp_city` VALUES (370500, '东营市', '', '山东省,东营市', 370000, 2, 0, '', 174);
INSERT INTO `wp_city` VALUES (370600, '烟台市', '', '山东省,烟台市', 370000, 2, 0, '', 326);
INSERT INTO `wp_city` VALUES (370700, '潍坊市', '', '山东省,潍坊市', 370000, 2, 0, '', 287);
INSERT INTO `wp_city` VALUES (370800, '济宁市', '', '山东省,济宁市', 370000, 2, 0, '', 286);
INSERT INTO `wp_city` VALUES (370900, '泰安市', '', '山东省,泰安市', 370000, 2, 0, '', 325);
INSERT INTO `wp_city` VALUES (371000, '威海市', '', '山东省,威海市', 370000, 2, 0, '', 175);
INSERT INTO `wp_city` VALUES (371100, '日照市', '', '山东省,日照市', 370000, 2, 0, '', 173);
INSERT INTO `wp_city` VALUES (371200, '莱芜市', '', '山东省,莱芜市', 370000, 2, 0, '', 124);
INSERT INTO `wp_city` VALUES (371300, '临沂市', '', '山东省,临沂市', 370000, 2, 0, '', 234);
INSERT INTO `wp_city` VALUES (371400, '德州市', '', '山东省,德州市', 370000, 2, 0, '', 372);
INSERT INTO `wp_city` VALUES (371500, '聊城市', '', '山东省,聊城市', 370000, 2, 0, '', 366);
INSERT INTO `wp_city` VALUES (371600, '滨州市', '', '山东省,滨州市', 370000, 2, 0, '', 235);
INSERT INTO `wp_city` VALUES (371700, '菏泽市', '', '山东省,菏泽市', 370000, 2, 0, '', 353);
INSERT INTO `wp_city` VALUES (410100, '郑州市', '', '河南省,郑州市', 410000, 2, 0, '', 268);
INSERT INTO `wp_city` VALUES (410200, '开封市', '', '河南省,开封市', 410000, 2, 0, '', 210);
INSERT INTO `wp_city` VALUES (410300, '洛阳市', '', '河南省,洛阳市', 410000, 2, 0, '', 153);
INSERT INTO `wp_city` VALUES (410400, '平顶山市', '', '河南省,平顶山市', 410000, 2, 0, '', 213);
INSERT INTO `wp_city` VALUES (410500, '安阳市', '', '河南省,安阳市', 410000, 2, 0, '', 267);
INSERT INTO `wp_city` VALUES (410600, '鹤壁市', '', '河南省,鹤壁市', 410000, 2, 0, '', 215);
INSERT INTO `wp_city` VALUES (410700, '新乡市', '', '河南省,新乡市', 410000, 2, 0, '', 152);
INSERT INTO `wp_city` VALUES (410800, '焦作市', '', '河南省,焦作市', 410000, 2, 0, '', 211);
INSERT INTO `wp_city` VALUES (410900, '濮阳市', '', '河南省,濮阳市', 410000, 2, 0, '', 209);
INSERT INTO `wp_city` VALUES (411000, '许昌市', '', '河南省,许昌市', 410000, 2, 0, '', 155);
INSERT INTO `wp_city` VALUES (411100, '漯河市', '', '河南省,漯河市', 410000, 2, 0, '', 344);
INSERT INTO `wp_city` VALUES (411200, '三门峡市', '', '河南省,三门峡市', 410000, 2, 0, '', 212);
INSERT INTO `wp_city` VALUES (411300, '南阳市', '', '河南省,南阳市', 410000, 2, 0, '', 309);
INSERT INTO `wp_city` VALUES (411400, '商丘市', '', '河南省,商丘市', 410000, 2, 0, '', 154);
INSERT INTO `wp_city` VALUES (411500, '信阳市', '', '河南省,信阳市', 410000, 2, 0, '', 214);
INSERT INTO `wp_city` VALUES (411600, '周口市', '', '河南省,周口市', 410000, 2, 0, '', 308);
INSERT INTO `wp_city` VALUES (411700, '驻马店市', '', '河南省,驻马店市', 410000, 2, 0, '', 269);
INSERT INTO `wp_city` VALUES (420100, '武汉市', '', '湖北省,武汉市', 420000, 2, 0, '', 218);
INSERT INTO `wp_city` VALUES (420200, '黄石市', '', '湖北省,黄石市', 420000, 2, 0, '', 311);
INSERT INTO `wp_city` VALUES (420300, '十堰市', '', '湖北省,十堰市', 420000, 2, 0, '', 216);
INSERT INTO `wp_city` VALUES (420500, '宜昌市', '', '湖北省,宜昌市', 420000, 2, 0, '', 270);
INSERT INTO `wp_city` VALUES (420600, '襄樊市', '', '湖北省,襄樊市', 420000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (420700, '鄂州市', '', '湖北省,鄂州市', 420000, 2, 0, '', 122);
INSERT INTO `wp_city` VALUES (420800, '荆门市', '', '湖北省,荆门市', 420000, 2, 0, '', 217);
INSERT INTO `wp_city` VALUES (420900, '孝感市', '', '湖北省,孝感市', 420000, 2, 0, '', 310);
INSERT INTO `wp_city` VALUES (421000, '荆州市', '', '湖北省,荆州市', 420000, 2, 0, '', 157);
INSERT INTO `wp_city` VALUES (421100, '黄冈市', '', '湖北省,黄冈市', 420000, 2, 0, '', 271);
INSERT INTO `wp_city` VALUES (421200, '咸宁市', '', '湖北省,咸宁市', 420000, 2, 0, '', 362);
INSERT INTO `wp_city` VALUES (421300, '随州市', '', '湖北省,随州市', 420000, 2, 0, '', 371);
INSERT INTO `wp_city` VALUES (422800, '恩施土家族苗族自治州', '', '湖北省,恩施土家族苗族自治州', 420000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (429000, '省直辖行政单位', '', '湖北省,省直辖行政单位', 420000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (430100, '长沙市', '', '湖南省,长沙市', 430000, 2, 0, '', 158);
INSERT INTO `wp_city` VALUES (430200, '株洲市', '', '湖南省,株洲市', 430000, 2, 0, '', 222);
INSERT INTO `wp_city` VALUES (430300, '湘潭市', '', '湖南省,湘潭市', 430000, 2, 0, '', 313);
INSERT INTO `wp_city` VALUES (430400, '衡阳市', '', '湖南省,衡阳市', 430000, 2, 0, '', 159);
INSERT INTO `wp_city` VALUES (430500, '邵阳市', '', '湖南省,邵阳市', 430000, 2, 0, '', 273);
INSERT INTO `wp_city` VALUES (430600, '岳阳市', '', '湖南省,岳阳市', 430000, 2, 0, '', 220);
INSERT INTO `wp_city` VALUES (430700, '常德市', '', '湖南省,常德市', 430000, 2, 0, '', 219);
INSERT INTO `wp_city` VALUES (430800, '张家界市', '', '湖南省,张家界市', 430000, 2, 0, '', 312);
INSERT INTO `wp_city` VALUES (430900, '益阳市', '', '湖南省,益阳市', 430000, 2, 0, '', 272);
INSERT INTO `wp_city` VALUES (431000, '郴州市', '', '湖南省,郴州市', 430000, 2, 0, '', 275);
INSERT INTO `wp_city` VALUES (431100, '永州市', '', '湖南省,永州市', 430000, 2, 0, '', 314);
INSERT INTO `wp_city` VALUES (431200, '怀化市', '', '湖南省,怀化市', 430000, 2, 0, '', 363);
INSERT INTO `wp_city` VALUES (431300, '娄底市', '', '湖南省,娄底市', 430000, 2, 0, '', 221);
INSERT INTO `wp_city` VALUES (433100, '湘西土家族苗族自治州', '', '湖南省,湘西土家族苗族自治州', 430000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (440100, '广州市', '', '广东省,广州市', 440000, 2, 0, '', 257);
INSERT INTO `wp_city` VALUES (440200, '韶关市', '', '广东省,韶关市', 440000, 2, 0, '', 137);
INSERT INTO `wp_city` VALUES (440300, '深圳市', '', '广东省,深圳市', 440000, 2, 0, '', 340);
INSERT INTO `wp_city` VALUES (440400, '珠海市', '', '广东省,珠海市', 440000, 2, 0, '', 140);
INSERT INTO `wp_city` VALUES (440500, '汕头市', '', '广东省,汕头市', 440000, 2, 0, '', 303);
INSERT INTO `wp_city` VALUES (440600, '佛山市', '', '广东省,佛山市', 440000, 2, 0, '', 138);
INSERT INTO `wp_city` VALUES (440700, '江门市', '', '广东省,江门市', 440000, 2, 0, '', 302);
INSERT INTO `wp_city` VALUES (440800, '湛江市', '', '广东省,湛江市', 440000, 2, 0, '', 198);
INSERT INTO `wp_city` VALUES (440900, '茂名市', '', '广东省,茂名市', 440000, 2, 0, '', 139);
INSERT INTO `wp_city` VALUES (441200, '肇庆市', '', '广东省,肇庆市', 440000, 2, 0, '', 338);
INSERT INTO `wp_city` VALUES (441300, '惠州市', '', '广东省,惠州市', 440000, 2, 0, '', 301);
INSERT INTO `wp_city` VALUES (441400, '梅州市', '', '广东省,梅州市', 440000, 2, 0, '', 141);
INSERT INTO `wp_city` VALUES (441500, '汕尾市', '', '广东省,汕尾市', 440000, 2, 0, '', 339);
INSERT INTO `wp_city` VALUES (441600, '河源市', '', '广东省,河源市', 440000, 2, 0, '', 200);
INSERT INTO `wp_city` VALUES (441700, '阳江市', '', '广东省,阳江市', 440000, 2, 0, '', 199);
INSERT INTO `wp_city` VALUES (441800, '清远市', '', '广东省,清远市', 440000, 2, 0, '', 197);
INSERT INTO `wp_city` VALUES (441900, '东莞市', '', '广东省,东莞市', 440000, 2, 0, '', 119);
INSERT INTO `wp_city` VALUES (442000, '中山市', '', '广东省,中山市', 440000, 2, 0, '', 187);
INSERT INTO `wp_city` VALUES (445100, '潮州市', '', '广东省,潮州市', 440000, 2, 0, '', 201);
INSERT INTO `wp_city` VALUES (445200, '揭阳市', '', '广东省,揭阳市', 440000, 2, 0, '', 259);
INSERT INTO `wp_city` VALUES (445300, '云浮市', '', '广东省,云浮市', 440000, 2, 0, '', 258);
INSERT INTO `wp_city` VALUES (450100, '南宁市', '', '广西壮族自治区,南宁市', 450000, 2, 0, '', 261);
INSERT INTO `wp_city` VALUES (450200, '柳州市', '', '广西壮族自治区,柳州市', 450000, 2, 0, '', 305);
INSERT INTO `wp_city` VALUES (450300, '桂林市', '', '广西壮族自治区,桂林市', 450000, 2, 0, '', 142);
INSERT INTO `wp_city` VALUES (450400, '梧州市', '', '广西壮族自治区,梧州市', 450000, 2, 0, '', 304);
INSERT INTO `wp_city` VALUES (450500, '北海市', '', '广西壮族自治区,北海市', 450000, 2, 0, '', 295);
INSERT INTO `wp_city` VALUES (450600, '防城港市', '', '广西壮族自治区,防城港市', 450000, 2, 0, '', 204);
INSERT INTO `wp_city` VALUES (450700, '钦州市', '', '广西壮族自治区,钦州市', 450000, 2, 0, '', 145);
INSERT INTO `wp_city` VALUES (450800, '贵港市', '', '广西壮族自治区,贵港市', 450000, 2, 0, '', 341);
INSERT INTO `wp_city` VALUES (450900, '玉林市', '', '广西壮族自治区,玉林市', 450000, 2, 0, '', 361);
INSERT INTO `wp_city` VALUES (451000, '百色市', '', '广西壮族自治区,百色市', 450000, 2, 0, '', 203);
INSERT INTO `wp_city` VALUES (451100, '贺州市', '', '广西壮族自治区,贺州市', 450000, 2, 0, '', 260);
INSERT INTO `wp_city` VALUES (451200, '河池市', '', '广西壮族自治区,河池市', 450000, 2, 0, '', 143);
INSERT INTO `wp_city` VALUES (451300, '来宾市', '', '广西壮族自治区,来宾市', 450000, 2, 0, '', 202);
INSERT INTO `wp_city` VALUES (451400, '崇左市', '', '广西壮族自治区,崇左市', 450000, 2, 0, '', 144);
INSERT INTO `wp_city` VALUES (460100, '海口市', '', '海南省,海口市', 460000, 2, 0, '', 125);
INSERT INTO `wp_city` VALUES (460200, '三亚市', '', '海南省,三亚市', 460000, 2, 0, '', 121);
INSERT INTO `wp_city` VALUES (469000, '省直辖县级行政单位', '', '海南省,省直辖县级行政单位', 460000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (500100, '市辖区', '', '重庆市,市辖区', 500000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (500200, '县', '', '重庆市,县', 500000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (500300, '市', '', '重庆市,市', 500000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (510100, '成都市', '', '四川省,成都市', 510000, 2, 0, '', 75);
INSERT INTO `wp_city` VALUES (510300, '自贡市', '', '四川省,自贡市', 510000, 2, 0, '', 78);
INSERT INTO `wp_city` VALUES (510400, '攀枝花市', '', '四川省,攀枝花市', 510000, 2, 0, '', 81);
INSERT INTO `wp_city` VALUES (510500, '泸州市', '', '四川省,泸州市', 510000, 2, 0, '', 331);
INSERT INTO `wp_city` VALUES (510600, '德阳市', '', '四川省,德阳市', 510000, 2, 0, '', 74);
INSERT INTO `wp_city` VALUES (510700, '绵阳市', '', '四川省,绵阳市', 510000, 2, 0, '', 240);
INSERT INTO `wp_city` VALUES (510800, '广元市', '', '四川省,广元市', 510000, 2, 0, '', 329);
INSERT INTO `wp_city` VALUES (510900, '遂宁市', '', '四川省,遂宁市', 510000, 2, 0, '', 330);
INSERT INTO `wp_city` VALUES (511000, '内江市', '', '四川省,内江市', 510000, 2, 0, '', 248);
INSERT INTO `wp_city` VALUES (511100, '乐山市', '', '四川省,乐山市', 510000, 2, 0, '', 79);
INSERT INTO `wp_city` VALUES (511300, '南充市', '', '四川省,南充市', 510000, 2, 0, '', 291);
INSERT INTO `wp_city` VALUES (511400, '眉山市', '', '四川省,眉山市', 510000, 2, 0, '', 77);
INSERT INTO `wp_city` VALUES (511500, '宜宾市', '', '四川省,宜宾市', 510000, 2, 0, '', 186);
INSERT INTO `wp_city` VALUES (511600, '广安市', '', '四川省,广安市', 510000, 2, 0, '', 241);
INSERT INTO `wp_city` VALUES (511700, '达州市', '', '四川省,达州市', 510000, 2, 0, '', 369);
INSERT INTO `wp_city` VALUES (511800, '雅安市', '', '四川省,雅安市', 510000, 2, 0, '', 76);
INSERT INTO `wp_city` VALUES (511900, '巴中市', '', '四川省,巴中市', 510000, 2, 0, '', 239);
INSERT INTO `wp_city` VALUES (512000, '资阳市', '', '四川省,资阳市', 510000, 2, 0, '', 242);
INSERT INTO `wp_city` VALUES (513200, '阿坝藏族羌族自治州', '', '四川省,阿坝藏族羌族自治州', 510000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (513300, '甘孜藏族自治州', '', '四川省,甘孜藏族自治州', 510000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (513400, '凉山彝族自治州', '', '四川省,凉山彝族自治州', 510000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (520100, '贵阳市', '', '贵州省,贵阳市', 520000, 2, 0, '', 146);
INSERT INTO `wp_city` VALUES (520200, '六盘水市', '', '贵州省,六盘水市', 520000, 2, 0, '', 147);
INSERT INTO `wp_city` VALUES (520300, '遵义市', '', '贵州省,遵义市', 520000, 2, 0, '', 262);
INSERT INTO `wp_city` VALUES (520400, '安顺市', '', '贵州省,安顺市', 520000, 2, 0, '', 263);
INSERT INTO `wp_city` VALUES (522200, '铜仁地区', '', '贵州省,铜仁地区', 520000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (522300, '黔西南布依族苗族自治州', '', '贵州省,黔西南布依族苗族自治州', 520000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (522400, '毕节地区', '', '贵州省,毕节地区', 520000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (522600, '黔东南苗族侗族自治州', '', '贵州省,黔东南苗族侗族自治州', 520000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (522700, '黔南布依族苗族自治州', '', '贵州省,黔南布依族苗族自治州', 520000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (530100, '昆明市', '', '云南省,昆明市', 530000, 2, 0, '', 104);
INSERT INTO `wp_city` VALUES (530300, '曲靖市', '', '云南省,曲靖市', 530000, 2, 0, '', 249);
INSERT INTO `wp_city` VALUES (530400, '玉溪市', '', '云南省,玉溪市', 530000, 2, 0, '', 106);
INSERT INTO `wp_city` VALUES (530500, '保山市', '', '云南省,保山市', 530000, 2, 0, '', 112);
INSERT INTO `wp_city` VALUES (530600, '昭通市', '', '云南省,昭通市', 530000, 2, 0, '', 336);
INSERT INTO `wp_city` VALUES (530700, '丽江市', '', '云南省,丽江市', 530000, 2, 0, '', 114);
INSERT INTO `wp_city` VALUES (530800, '思茅市', '', '云南省,思茅市', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (530900, '临沧市', '', '云南省,临沧市', 530000, 2, 0, '', 110);
INSERT INTO `wp_city` VALUES (532300, '楚雄彝族自治州', '', '云南省,楚雄彝族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (532500, '红河哈尼族彝族自治州', '', '云南省,红河哈尼族彝族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (532600, '文山壮族苗族自治州', '', '云南省,文山壮族苗族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (532800, '西双版纳傣族自治州', '', '云南省,西双版纳傣族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (532900, '大理白族自治州', '', '云南省,大理白族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (533100, '德宏傣族景颇族自治州', '', '云南省,德宏傣族景颇族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (533300, '怒江傈僳族自治州', '', '云南省,怒江傈僳族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (533400, '迪庆藏族自治州', '', '云南省,迪庆藏族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (540100, '拉萨市', '', '西藏自治区,拉萨市', 540000, 2, 0, '', 100);
INSERT INTO `wp_city` VALUES (542100, '昌都地区', '', '西藏自治区,昌都地区', 540000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (542200, '山南地区', '', '西藏自治区,山南地区', 540000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (542300, '日喀则地区', '', '西藏自治区,日喀则地区', 540000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (542400, '那曲地区', '', '西藏自治区,那曲地区', 540000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (542500, '阿里地区', '', '西藏自治区,阿里地区', 540000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (542600, '林芝地区', '', '西藏自治区,林芝地区', 540000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (610100, '西安市', '', '陕西省,西安市', 610000, 2, 0, '', 233);
INSERT INTO `wp_city` VALUES (610200, '铜川市', '', '陕西省,铜川市', 610000, 2, 0, '', 232);
INSERT INTO `wp_city` VALUES (610300, '宝鸡市', '', '陕西省,宝鸡市', 610000, 2, 0, '', 171);
INSERT INTO `wp_city` VALUES (610400, '咸阳市', '', '陕西省,咸阳市', 610000, 2, 0, '', 323);
INSERT INTO `wp_city` VALUES (610500, '渭南市', '', '陕西省,渭南市', 610000, 2, 0, '', 170);
INSERT INTO `wp_city` VALUES (610600, '延安市', '', '陕西省,延安市', 610000, 2, 0, '', 284);
INSERT INTO `wp_city` VALUES (610700, '汉中市', '', '陕西省,汉中市', 610000, 2, 0, '', 352);
INSERT INTO `wp_city` VALUES (610800, '榆林市', '', '陕西省,榆林市', 610000, 2, 0, '', 231);
INSERT INTO `wp_city` VALUES (610900, '安康市', '', '陕西省,安康市', 610000, 2, 0, '', 324);
INSERT INTO `wp_city` VALUES (611000, '商洛市', '', '陕西省,商洛市', 610000, 2, 0, '', 285);
INSERT INTO `wp_city` VALUES (620100, '兰州市', '', '甘肃省,兰州市', 620000, 2, 0, '', 36);
INSERT INTO `wp_city` VALUES (620200, '嘉峪关市', '', '甘肃省,嘉峪关市', 620000, 2, 0, '', 33);
INSERT INTO `wp_city` VALUES (620300, '金昌市', '', '甘肃省,金昌市', 620000, 2, 0, '', 34);
INSERT INTO `wp_city` VALUES (620400, '白银市', '', '甘肃省,白银市', 620000, 2, 0, '', 35);
INSERT INTO `wp_city` VALUES (620500, '天水市', '', '甘肃省,天水市', 620000, 2, 0, '', 196);
INSERT INTO `wp_city` VALUES (620600, '武威市', '', '甘肃省,武威市', 620000, 2, 0, '', 118);
INSERT INTO `wp_city` VALUES (620700, '张掖市', '', '甘肃省,张掖市', 620000, 2, 0, '', 117);
INSERT INTO `wp_city` VALUES (620800, '平凉市', '', '甘肃省,平凉市', 620000, 2, 0, '', 359);
INSERT INTO `wp_city` VALUES (620900, '酒泉市', '', '甘肃省,酒泉市', 620000, 2, 0, '', 37);
INSERT INTO `wp_city` VALUES (621000, '庆阳市', '', '甘肃省,庆阳市', 620000, 2, 0, '', 135);
INSERT INTO `wp_city` VALUES (621100, '定西市', '', '甘肃省,定西市', 620000, 2, 0, '', 136);
INSERT INTO `wp_city` VALUES (621200, '陇南市', '', '甘肃省,陇南市', 620000, 2, 0, '', 256);
INSERT INTO `wp_city` VALUES (622900, '临夏回族自治州', '', '甘肃省,临夏回族自治州', 620000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (623000, '甘南藏族自治州', '', '甘肃省,甘南藏族自治州', 620000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (630100, '西宁市', '', '青海省,西宁市', 630000, 2, 0, '', 66);
INSERT INTO `wp_city` VALUES (632100, '海东地区', '', '青海省,海东地区', 630000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (632200, '海北藏族自治州', '', '青海省,海北藏族自治州', 630000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (632300, '黄南藏族自治州', '', '青海省,黄南藏族自治州', 630000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (632500, '海南藏族自治州', '', '青海省,海南藏族自治州', 630000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (632600, '果洛藏族自治州', '', '青海省,果洛藏族自治州', 630000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (632700, '玉树藏族自治州', '', '青海省,玉树藏族自治州', 630000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (632800, '海西蒙古族藏族自治州', '', '青海省,海西蒙古族藏族自治州', 630000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (640100, '银川市', '', '宁夏回族自治区,银川市', 640000, 2, 0, '', 360);
INSERT INTO `wp_city` VALUES (640200, '石嘴山市', '', '宁夏回族自治区,石嘴山市', 640000, 2, 0, '', 335);
INSERT INTO `wp_city` VALUES (640300, '吴忠市', '', '宁夏回族自治区,吴忠市', 640000, 2, 0, '', 322);
INSERT INTO `wp_city` VALUES (640400, '固原市', '', '宁夏回族自治区,固原市', 640000, 2, 0, '', 246);
INSERT INTO `wp_city` VALUES (640500, '中卫市', '', '宁夏回族自治区,中卫市', 640000, 2, 0, '', 181);
INSERT INTO `wp_city` VALUES (650100, '乌鲁木齐市', '', '新疆维吾尔自治区,乌鲁木齐市', 650000, 2, 0, '', 92);
INSERT INTO `wp_city` VALUES (650200, '克拉玛依市', '', '新疆维吾尔自治区,克拉玛依市', 650000, 2, 0, '', 95);
INSERT INTO `wp_city` VALUES (652100, '吐鲁番地区', '', '新疆维吾尔自治区,吐鲁番地区', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (652200, '哈密地区', '', '新疆维吾尔自治区,哈密地区', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (652300, '昌吉回族自治州', '', '新疆维吾尔自治区,昌吉回族自治州', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (652700, '博尔塔拉蒙古自治州', '', '新疆维吾尔自治区,博尔塔拉蒙古自治州', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (652800, '巴音郭楞蒙古自治州', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (652900, '阿克苏地区', '', '新疆维吾尔自治区,阿克苏地区', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (653000, '克孜勒苏柯尔克孜自治州', '', '新疆维吾尔自治区,克孜勒苏柯尔克孜自治州', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (653100, '喀什地区', '', '新疆维吾尔自治区,喀什地区', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (653200, '和田地区', '', '新疆维吾尔自治区,和田地区', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (654000, '伊犁哈萨克自治州', '', '新疆维吾尔自治区,伊犁哈萨克自治州', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (654200, '塔城地区', '', '新疆维吾尔自治区,塔城地区', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (654300, '阿勒泰地区', '', '新疆维吾尔自治区,阿勒泰地区', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (659000, '省直辖行政单位', '', '新疆维吾尔自治区,省直辖行政单位', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (110101, '东城区', '', '北京市,北京市,东城区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110102, '西城区', '', '北京市,北京市,西城区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110103, '崇文区', '', '北京市,北京市,崇文区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110104, '宣武区', '', '北京市,北京市,宣武区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110105, '朝阳区', '', '北京市,北京市,朝阳区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110106, '丰台区', '', '北京市,北京市,丰台区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110107, '石景山区', '', '北京市,北京市,石景山区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110108, '海淀区', '', '北京市,北京市,海淀区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110109, '门头沟区', '', '北京市,北京市,门头沟区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110111, '房山区', '', '北京市,北京市,房山区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110112, '通州区', '', '北京市,北京市,通州区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110113, '顺义区', '', '北京市,北京市,顺义区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110114, '昌平区', '', '北京市,北京市,昌平区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110115, '大兴区', '', '北京市,北京市,大兴区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110116, '怀柔区', '', '北京市,北京市,怀柔区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110117, '平谷区', '', '北京市,北京市,平谷区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110228, '密云县', '', '北京市,县,密云县', 110200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110229, '延庆县', '', '北京市,县,延庆县', 110200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120101, '和平区', '', '天津市,市辖区,和平区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120102, '河东区', '', '天津市,市辖区,河东区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120103, '河西区', '', '天津市,市辖区,河西区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120104, '南开区', '', '天津市,市辖区,南开区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120105, '河北区', '', '天津市,市辖区,河北区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120106, '红桥区', '', '天津市,市辖区,红桥区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120107, '塘沽区', '', '天津市,市辖区,塘沽区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120108, '汉沽区', '', '天津市,市辖区,汉沽区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120109, '大港区', '', '天津市,市辖区,大港区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120110, '东丽区', '', '天津市,市辖区,东丽区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120111, '西青区', '', '天津市,市辖区,西青区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120112, '津南区', '', '天津市,市辖区,津南区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120113, '北辰区', '', '天津市,市辖区,北辰区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120114, '武清区', '', '天津市,市辖区,武清区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120115, '宝坻区', '', '天津市,市辖区,宝坻区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120221, '宁河县', '', '天津市,县,宁河县', 120200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120223, '静海县', '', '天津市,县,静海县', 120200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120225, '蓟　县', '', '天津市,县,蓟　县', 120200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130101, '市辖区', '', '河北省,石家庄市,市辖区', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130102, '长安区', '', '河北省,石家庄市,长安区', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130103, '桥东区', '', '河北省,石家庄市,桥东区', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130104, '桥西区', '', '河北省,石家庄市,桥西区', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130105, '新华区', '', '河北省,石家庄市,新华区', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130107, '井陉矿区', '', '河北省,石家庄市,井陉矿区', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130108, '裕华区', '', '河北省,石家庄市,裕华区', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130121, '井陉县', '', '河北省,石家庄市,井陉县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130123, '正定县', '', '河北省,石家庄市,正定县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130124, '栾城县', '', '河北省,石家庄市,栾城县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130125, '行唐县', '', '河北省,石家庄市,行唐县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130126, '灵寿县', '', '河北省,石家庄市,灵寿县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130127, '高邑县', '', '河北省,石家庄市,高邑县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130128, '深泽县', '', '河北省,石家庄市,深泽县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130129, '赞皇县', '', '河北省,石家庄市,赞皇县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130130, '无极县', '', '河北省,石家庄市,无极县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130131, '平山县', '', '河北省,石家庄市,平山县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130132, '元氏县', '', '河北省,石家庄市,元氏县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130133, '赵　县', '', '河北省,石家庄市,赵　县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130181, '辛集市', '', '河北省,石家庄市,辛集市', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130182, '藁城市', '', '河北省,石家庄市,藁城市', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130183, '晋州市', '', '河北省,石家庄市,晋州市', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130184, '新乐市', '', '河北省,石家庄市,新乐市', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130185, '鹿泉市', '', '河北省,石家庄市,鹿泉市', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130201, '市辖区', '', '河北省,唐山市,市辖区', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130202, '路南区', '', '河北省,唐山市,路南区', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130203, '路北区', '', '河北省,唐山市,路北区', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130204, '古冶区', '', '河北省,唐山市,古冶区', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130205, '开平区', '', '河北省,唐山市,开平区', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130207, '丰南区', '', '河北省,唐山市,丰南区', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130208, '丰润区', '', '河北省,唐山市,丰润区', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130223, '滦　县', '', '河北省,唐山市,滦　县', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130224, '滦南县', '', '河北省,唐山市,滦南县', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130225, '乐亭县', '', '河北省,唐山市,乐亭县', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130227, '迁西县', '', '河北省,唐山市,迁西县', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130229, '玉田县', '', '河北省,唐山市,玉田县', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130230, '唐海县', '', '河北省,唐山市,唐海县', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130281, '遵化市', '', '河北省,唐山市,遵化市', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130283, '迁安市', '', '河北省,唐山市,迁安市', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130301, '市辖区', '', '河北省,秦皇岛市,市辖区', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130302, '海港区', '', '河北省,秦皇岛市,海港区', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130303, '山海关区', '', '河北省,秦皇岛市,山海关区', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130304, '北戴河区', '', '河北省,秦皇岛市,北戴河区', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130321, '青龙满族自治县', '', '河北省,秦皇岛市,青龙满族自治县', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130322, '昌黎县', '', '河北省,秦皇岛市,昌黎县', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130323, '抚宁县', '', '河北省,秦皇岛市,抚宁县', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130324, '卢龙县', '', '河北省,秦皇岛市,卢龙县', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130401, '市辖区', '', '河北省,邯郸市,市辖区', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130402, '邯山区', '', '河北省,邯郸市,邯山区', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130403, '丛台区', '', '河北省,邯郸市,丛台区', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130404, '复兴区', '', '河北省,邯郸市,复兴区', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130406, '峰峰矿区', '', '河北省,邯郸市,峰峰矿区', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130421, '邯郸县', '', '河北省,邯郸市,邯郸县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130423, '临漳县', '', '河北省,邯郸市,临漳县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130424, '成安县', '', '河北省,邯郸市,成安县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130425, '大名县', '', '河北省,邯郸市,大名县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130426, '涉　县', '', '河北省,邯郸市,涉　县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130427, '磁　县', '', '河北省,邯郸市,磁　县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130428, '肥乡县', '', '河北省,邯郸市,肥乡县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130429, '永年县', '', '河北省,邯郸市,永年县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130430, '邱　县', '', '河北省,邯郸市,邱　县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130431, '鸡泽县', '', '河北省,邯郸市,鸡泽县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130432, '广平县', '', '河北省,邯郸市,广平县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130433, '馆陶县', '', '河北省,邯郸市,馆陶县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130434, '魏　县', '', '河北省,邯郸市,魏　县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130435, '曲周县', '', '河北省,邯郸市,曲周县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130481, '武安市', '', '河北省,邯郸市,武安市', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130501, '市辖区', '', '河北省,邢台市,市辖区', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130502, '桥东区', '', '河北省,邢台市,桥东区', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130503, '桥西区', '', '河北省,邢台市,桥西区', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130521, '邢台县', '', '河北省,邢台市,邢台县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130522, '临城县', '', '河北省,邢台市,临城县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130523, '内丘县', '', '河北省,邢台市,内丘县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130524, '柏乡县', '', '河北省,邢台市,柏乡县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130525, '隆尧县', '', '河北省,邢台市,隆尧县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130526, '任　县', '', '河北省,邢台市,任　县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130527, '南和县', '', '河北省,邢台市,南和县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130528, '宁晋县', '', '河北省,邢台市,宁晋县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130529, '巨鹿县', '', '河北省,邢台市,巨鹿县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130530, '新河县', '', '河北省,邢台市,新河县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130531, '广宗县', '', '河北省,邢台市,广宗县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130532, '平乡县', '', '河北省,邢台市,平乡县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130533, '威　县', '', '河北省,邢台市,威　县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130534, '清河县', '', '河北省,邢台市,清河县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130535, '临西县', '', '河北省,邢台市,临西县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130581, '南宫市', '', '河北省,邢台市,南宫市', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130582, '沙河市', '', '河北省,邢台市,沙河市', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130601, '市辖区', '', '河北省,保定市,市辖区', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130602, '新市区', '', '河北省,保定市,新市区', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130603, '北市区', '', '河北省,保定市,北市区', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130604, '南市区', '', '河北省,保定市,南市区', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130621, '满城县', '', '河北省,保定市,满城县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130622, '清苑县', '', '河北省,保定市,清苑县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130623, '涞水县', '', '河北省,保定市,涞水县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130624, '阜平县', '', '河北省,保定市,阜平县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130625, '徐水县', '', '河北省,保定市,徐水县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130626, '定兴县', '', '河北省,保定市,定兴县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130627, '唐　县', '', '河北省,保定市,唐　县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130628, '高阳县', '', '河北省,保定市,高阳县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130629, '容城县', '', '河北省,保定市,容城县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130630, '涞源县', '', '河北省,保定市,涞源县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130631, '望都县', '', '河北省,保定市,望都县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130632, '安新县', '', '河北省,保定市,安新县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130633, '易　县', '', '河北省,保定市,易　县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130634, '曲阳县', '', '河北省,保定市,曲阳县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130635, '蠡　县', '', '河北省,保定市,蠡　县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130636, '顺平县', '', '河北省,保定市,顺平县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130637, '博野县', '', '河北省,保定市,博野县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130638, '雄　县', '', '河北省,保定市,雄　县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130681, '涿州市', '', '河北省,保定市,涿州市', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130682, '定州市', '', '河北省,保定市,定州市', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130683, '安国市', '', '河北省,保定市,安国市', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130684, '高碑店市', '', '河北省,保定市,高碑店市', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130701, '市辖区', '', '河北省,张家口市,市辖区', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130702, '桥东区', '', '河北省,张家口市,桥东区', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130703, '桥西区', '', '河北省,张家口市,桥西区', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130705, '宣化区', '', '河北省,张家口市,宣化区', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130706, '下花园区', '', '河北省,张家口市,下花园区', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130721, '宣化县', '', '河北省,张家口市,宣化县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130722, '张北县', '', '河北省,张家口市,张北县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130723, '康保县', '', '河北省,张家口市,康保县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130724, '沽源县', '', '河北省,张家口市,沽源县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130725, '尚义县', '', '河北省,张家口市,尚义县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130726, '蔚　县', '', '河北省,张家口市,蔚　县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130727, '阳原县', '', '河北省,张家口市,阳原县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130728, '怀安县', '', '河北省,张家口市,怀安县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130729, '万全县', '', '河北省,张家口市,万全县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130730, '怀来县', '', '河北省,张家口市,怀来县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130731, '涿鹿县', '', '河北省,张家口市,涿鹿县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130732, '赤城县', '', '河北省,张家口市,赤城县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130733, '崇礼县', '', '河北省,张家口市,崇礼县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130801, '市辖区', '', '河北省,承德市,市辖区', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130802, '双桥区', '', '河北省,承德市,双桥区', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130803, '双滦区', '', '河北省,承德市,双滦区', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130804, '鹰手营子矿区', '', '河北省,承德市,鹰手营子矿区', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130821, '承德县', '', '河北省,承德市,承德县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130822, '兴隆县', '', '河北省,承德市,兴隆县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130823, '平泉县', '', '河北省,承德市,平泉县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130824, '滦平县', '', '河北省,承德市,滦平县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130825, '隆化县', '', '河北省,承德市,隆化县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130826, '丰宁满族自治县', '', '河北省,承德市,丰宁满族自治县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130827, '宽城满族自治县', '', '河北省,承德市,宽城满族自治县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130828, '围场满族蒙古族自治县', '', '河北省,承德市,围场满族蒙古族自治县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130901, '市辖区', '', '河北省,沧州市,市辖区', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130902, '新华区', '', '河北省,沧州市,新华区', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130903, '运河区', '', '河北省,沧州市,运河区', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130921, '沧　县', '', '河北省,沧州市,沧　县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130922, '青　县', '', '河北省,沧州市,青　县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130923, '东光县', '', '河北省,沧州市,东光县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130924, '海兴县', '', '河北省,沧州市,海兴县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130925, '盐山县', '', '河北省,沧州市,盐山县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130926, '肃宁县', '', '河北省,沧州市,肃宁县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130927, '南皮县', '', '河北省,沧州市,南皮县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130928, '吴桥县', '', '河北省,沧州市,吴桥县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130929, '献　县', '', '河北省,沧州市,献　县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130930, '孟村回族自治县', '', '河北省,沧州市,孟村回族自治县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130981, '泊头市', '', '河北省,沧州市,泊头市', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130982, '任丘市', '', '河北省,沧州市,任丘市', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130983, '黄骅市', '', '河北省,沧州市,黄骅市', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130984, '河间市', '', '河北省,沧州市,河间市', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131001, '市辖区', '', '河北省,廊坊市,市辖区', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131002, '安次区', '', '河北省,廊坊市,安次区', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131003, '广阳区', '', '河北省,廊坊市,广阳区', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131022, '固安县', '', '河北省,廊坊市,固安县', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131023, '永清县', '', '河北省,廊坊市,永清县', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131024, '香河县', '', '河北省,廊坊市,香河县', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131025, '大城县', '', '河北省,廊坊市,大城县', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131026, '文安县', '', '河北省,廊坊市,文安县', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131028, '大厂回族自治县', '', '河北省,廊坊市,大厂回族自治县', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131081, '霸州市', '', '河北省,廊坊市,霸州市', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131082, '三河市', '', '河北省,廊坊市,三河市', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131101, '市辖区', '', '河北省,衡水市,市辖区', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131102, '桃城区', '', '河北省,衡水市,桃城区', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131121, '枣强县', '', '河北省,衡水市,枣强县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131122, '武邑县', '', '河北省,衡水市,武邑县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131123, '武强县', '', '河北省,衡水市,武强县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131124, '饶阳县', '', '河北省,衡水市,饶阳县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131125, '安平县', '', '河北省,衡水市,安平县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131126, '故城县', '', '河北省,衡水市,故城县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131127, '景　县', '', '河北省,衡水市,景　县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131128, '阜城县', '', '河北省,衡水市,阜城县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131181, '冀州市', '', '河北省,衡水市,冀州市', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131182, '深州市', '', '河北省,衡水市,深州市', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140101, '市辖区', '', '山西省,太原市,市辖区', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140105, '小店区', '', '山西省,太原市,小店区', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140106, '迎泽区', '', '山西省,太原市,迎泽区', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140107, '杏花岭区', '', '山西省,太原市,杏花岭区', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140108, '尖草坪区', '', '山西省,太原市,尖草坪区', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140109, '万柏林区', '', '山西省,太原市,万柏林区', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140110, '晋源区', '', '山西省,太原市,晋源区', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140121, '清徐县', '', '山西省,太原市,清徐县', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140122, '阳曲县', '', '山西省,太原市,阳曲县', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140123, '娄烦县', '', '山西省,太原市,娄烦县', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140181, '古交市', '', '山西省,太原市,古交市', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140201, '市辖区', '', '山西省,大同市,市辖区', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140202, '城　区', '', '山西省,大同市,城　区', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140203, '矿　区', '', '山西省,大同市,矿　区', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140211, '南郊区', '', '山西省,大同市,南郊区', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140212, '新荣区', '', '山西省,大同市,新荣区', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140221, '阳高县', '', '山西省,大同市,阳高县', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140222, '天镇县', '', '山西省,大同市,天镇县', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140223, '广灵县', '', '山西省,大同市,广灵县', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140224, '灵丘县', '', '山西省,大同市,灵丘县', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140225, '浑源县', '', '山西省,大同市,浑源县', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140226, '左云县', '', '山西省,大同市,左云县', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140227, '大同县', '', '山西省,大同市,大同县', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140301, '市辖区', '', '山西省,阳泉市,市辖区', 140300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140302, '城　区', '', '山西省,阳泉市,城　区', 140300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140303, '矿　区', '', '山西省,阳泉市,矿　区', 140300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140311, '郊　区', '', '山西省,阳泉市,郊　区', 140300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140321, '平定县', '', '山西省,阳泉市,平定县', 140300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140322, '盂　县', '', '山西省,阳泉市,盂　县', 140300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140401, '市辖区', '', '山西省,长治市,市辖区', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140402, '城　区', '', '山西省,长治市,城　区', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140411, '郊　区', '', '山西省,长治市,郊　区', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140421, '长治县', '', '山西省,长治市,长治县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140423, '襄垣县', '', '山西省,长治市,襄垣县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140424, '屯留县', '', '山西省,长治市,屯留县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140425, '平顺县', '', '山西省,长治市,平顺县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140426, '黎城县', '', '山西省,长治市,黎城县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140427, '壶关县', '', '山西省,长治市,壶关县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140428, '长子县', '', '山西省,长治市,长子县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140429, '武乡县', '', '山西省,长治市,武乡县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140430, '沁　县', '', '山西省,长治市,沁　县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140431, '沁源县', '', '山西省,长治市,沁源县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140481, '潞城市', '', '山西省,长治市,潞城市', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140501, '市辖区', '', '山西省,晋城市,市辖区', 140500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140502, '城　区', '', '山西省,晋城市,城　区', 140500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140521, '沁水县', '', '山西省,晋城市,沁水县', 140500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140522, '阳城县', '', '山西省,晋城市,阳城县', 140500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140524, '陵川县', '', '山西省,晋城市,陵川县', 140500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140525, '泽州县', '', '山西省,晋城市,泽州县', 140500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140581, '高平市', '', '山西省,晋城市,高平市', 140500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140601, '市辖区', '', '山西省,朔州市,市辖区', 140600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140602, '朔城区', '', '山西省,朔州市,朔城区', 140600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140603, '平鲁区', '', '山西省,朔州市,平鲁区', 140600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140621, '山阴县', '', '山西省,朔州市,山阴县', 140600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140622, '应　县', '', '山西省,朔州市,应　县', 140600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140623, '右玉县', '', '山西省,朔州市,右玉县', 140600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140624, '怀仁县', '', '山西省,朔州市,怀仁县', 140600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140701, '市辖区', '', '山西省,晋中市,市辖区', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140702, '榆次区', '', '山西省,晋中市,榆次区', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140721, '榆社县', '', '山西省,晋中市,榆社县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140722, '左权县', '', '山西省,晋中市,左权县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140723, '和顺县', '', '山西省,晋中市,和顺县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140724, '昔阳县', '', '山西省,晋中市,昔阳县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140725, '寿阳县', '', '山西省,晋中市,寿阳县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140726, '太谷县', '', '山西省,晋中市,太谷县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140727, '祁　县', '', '山西省,晋中市,祁　县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140728, '平遥县', '', '山西省,晋中市,平遥县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140729, '灵石县', '', '山西省,晋中市,灵石县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140781, '介休市', '', '山西省,晋中市,介休市', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140801, '市辖区', '', '山西省,运城市,市辖区', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140802, '盐湖区', '', '山西省,运城市,盐湖区', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140821, '临猗县', '', '山西省,运城市,临猗县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140822, '万荣县', '', '山西省,运城市,万荣县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140823, '闻喜县', '', '山西省,运城市,闻喜县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140824, '稷山县', '', '山西省,运城市,稷山县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140825, '新绛县', '', '山西省,运城市,新绛县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140826, '绛　县', '', '山西省,运城市,绛　县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140827, '垣曲县', '', '山西省,运城市,垣曲县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140828, '夏　县', '', '山西省,运城市,夏　县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140829, '平陆县', '', '山西省,运城市,平陆县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140830, '芮城县', '', '山西省,运城市,芮城县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140881, '永济市', '', '山西省,运城市,永济市', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140882, '河津市', '', '山西省,运城市,河津市', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140901, '市辖区', '', '山西省,忻州市,市辖区', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140902, '忻府区', '', '山西省,忻州市,忻府区', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140921, '定襄县', '', '山西省,忻州市,定襄县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140922, '五台县', '', '山西省,忻州市,五台县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140923, '代　县', '', '山西省,忻州市,代　县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140924, '繁峙县', '', '山西省,忻州市,繁峙县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140925, '宁武县', '', '山西省,忻州市,宁武县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140926, '静乐县', '', '山西省,忻州市,静乐县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140927, '神池县', '', '山西省,忻州市,神池县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140928, '五寨县', '', '山西省,忻州市,五寨县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140929, '岢岚县', '', '山西省,忻州市,岢岚县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140930, '河曲县', '', '山西省,忻州市,河曲县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140931, '保德县', '', '山西省,忻州市,保德县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140932, '偏关县', '', '山西省,忻州市,偏关县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140981, '原平市', '', '山西省,忻州市,原平市', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141001, '市辖区', '', '山西省,临汾市,市辖区', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141002, '尧都区', '', '山西省,临汾市,尧都区', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141021, '曲沃县', '', '山西省,临汾市,曲沃县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141022, '翼城县', '', '山西省,临汾市,翼城县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141023, '襄汾县', '', '山西省,临汾市,襄汾县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141024, '洪洞县', '', '山西省,临汾市,洪洞县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141025, '古　县', '', '山西省,临汾市,古　县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141026, '安泽县', '', '山西省,临汾市,安泽县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141027, '浮山县', '', '山西省,临汾市,浮山县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141028, '吉　县', '', '山西省,临汾市,吉　县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141029, '乡宁县', '', '山西省,临汾市,乡宁县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141030, '大宁县', '', '山西省,临汾市,大宁县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141031, '隰　县', '', '山西省,临汾市,隰　县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141032, '永和县', '', '山西省,临汾市,永和县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141033, '蒲　县', '', '山西省,临汾市,蒲　县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141034, '汾西县', '', '山西省,临汾市,汾西县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141081, '侯马市', '', '山西省,临汾市,侯马市', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141082, '霍州市', '', '山西省,临汾市,霍州市', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141101, '市辖区', '', '山西省,吕梁市,市辖区', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141102, '离石区', '', '山西省,吕梁市,离石区', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141121, '文水县', '', '山西省,吕梁市,文水县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141122, '交城县', '', '山西省,吕梁市,交城县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141123, '兴　县', '', '山西省,吕梁市,兴　县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141124, '临　县', '', '山西省,吕梁市,临　县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141125, '柳林县', '', '山西省,吕梁市,柳林县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141126, '石楼县', '', '山西省,吕梁市,石楼县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141127, '岚　县', '', '山西省,吕梁市,岚　县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141128, '方山县', '', '山西省,吕梁市,方山县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141129, '中阳县', '', '山西省,吕梁市,中阳县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141130, '交口县', '', '山西省,吕梁市,交口县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141181, '孝义市', '', '山西省,吕梁市,孝义市', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141182, '汾阳市', '', '山西省,吕梁市,汾阳市', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150101, '市辖区', '', '内蒙古自治区,呼和浩特市,市辖区', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150102, '新城区', '', '内蒙古自治区,呼和浩特市,新城区', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150103, '回民区', '', '内蒙古自治区,呼和浩特市,回民区', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150104, '玉泉区', '', '内蒙古自治区,呼和浩特市,玉泉区', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150105, '赛罕区', '', '内蒙古自治区,呼和浩特市,赛罕区', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150121, '土默特左旗', '', '内蒙古自治区,呼和浩特市,土默特左旗', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150122, '托克托县', '', '内蒙古自治区,呼和浩特市,托克托县', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150123, '和林格尔县', '', '内蒙古自治区,呼和浩特市,和林格尔县', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150124, '清水河县', '', '内蒙古自治区,呼和浩特市,清水河县', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150125, '武川县', '', '内蒙古自治区,呼和浩特市,武川县', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150201, '市辖区', '', '内蒙古自治区,包头市,市辖区', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150202, '东河区', '', '内蒙古自治区,包头市,东河区', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150203, '昆都仑区', '', '内蒙古自治区,包头市,昆都仑区', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150204, '青山区', '', '内蒙古自治区,包头市,青山区', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150205, '石拐区', '', '内蒙古自治区,包头市,石拐区', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150206, '白云矿区', '', '内蒙古自治区,包头市,白云矿区', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150207, '九原区', '', '内蒙古自治区,包头市,九原区', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150221, '土默特右旗', '', '内蒙古自治区,包头市,土默特右旗', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150222, '固阳县', '', '内蒙古自治区,包头市,固阳县', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150223, '达尔罕茂明安联合旗', '', '内蒙古自治区,包头市,达尔罕茂明安联合旗', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150301, '市辖区', '', '内蒙古自治区,乌海市,市辖区', 150300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150302, '海勃湾区', '', '内蒙古自治区,乌海市,海勃湾区', 150300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150303, '海南区', '', '内蒙古自治区,乌海市,海南区', 150300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150304, '乌达区', '', '内蒙古自治区,乌海市,乌达区', 150300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150401, '市辖区', '', '内蒙古自治区,赤峰市,市辖区', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150402, '红山区', '', '内蒙古自治区,赤峰市,红山区', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150403, '元宝山区', '', '内蒙古自治区,赤峰市,元宝山区', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150404, '松山区', '', '内蒙古自治区,赤峰市,松山区', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150421, '阿鲁科尔沁旗', '', '内蒙古自治区,赤峰市,阿鲁科尔沁旗', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150422, '巴林左旗', '', '内蒙古自治区,赤峰市,巴林左旗', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150423, '巴林右旗', '', '内蒙古自治区,赤峰市,巴林右旗', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150424, '林西县', '', '内蒙古自治区,赤峰市,林西县', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150425, '克什克腾旗', '', '内蒙古自治区,赤峰市,克什克腾旗', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150426, '翁牛特旗', '', '内蒙古自治区,赤峰市,翁牛特旗', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150428, '喀喇沁旗', '', '内蒙古自治区,赤峰市,喀喇沁旗', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150429, '宁城县', '', '内蒙古自治区,赤峰市,宁城县', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150430, '敖汉旗', '', '内蒙古自治区,赤峰市,敖汉旗', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150501, '市辖区', '', '内蒙古自治区,通辽市,市辖区', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150502, '科尔沁区', '', '内蒙古自治区,通辽市,科尔沁区', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150521, '科尔沁左翼中旗', '', '内蒙古自治区,通辽市,科尔沁左翼中旗', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150522, '科尔沁左翼后旗', '', '内蒙古自治区,通辽市,科尔沁左翼后旗', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150523, '开鲁县', '', '内蒙古自治区,通辽市,开鲁县', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150524, '库伦旗', '', '内蒙古自治区,通辽市,库伦旗', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150525, '奈曼旗', '', '内蒙古自治区,通辽市,奈曼旗', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150526, '扎鲁特旗', '', '内蒙古自治区,通辽市,扎鲁特旗', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150581, '霍林郭勒市', '', '内蒙古自治区,通辽市,霍林郭勒市', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150602, '东胜区', '', '内蒙古自治区,鄂尔多斯市,东胜区', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150621, '达拉特旗', '', '内蒙古自治区,鄂尔多斯市,达拉特旗', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150622, '准格尔旗', '', '内蒙古自治区,鄂尔多斯市,准格尔旗', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150623, '鄂托克前旗', '', '内蒙古自治区,鄂尔多斯市,鄂托克前旗', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150624, '鄂托克旗', '', '内蒙古自治区,鄂尔多斯市,鄂托克旗', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150625, '杭锦旗', '', '内蒙古自治区,鄂尔多斯市,杭锦旗', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150626, '乌审旗', '', '内蒙古自治区,鄂尔多斯市,乌审旗', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150627, '伊金霍洛旗', '', '内蒙古自治区,鄂尔多斯市,伊金霍洛旗', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150701, '市辖区', '', '内蒙古自治区,呼伦贝尔市,市辖区', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150702, '海拉尔区', '', '内蒙古自治区,呼伦贝尔市,海拉尔区', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150721, '阿荣旗', '', '内蒙古自治区,呼伦贝尔市,阿荣旗', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150722, '莫力达瓦达斡尔族自治旗', '', '内蒙古自治区,呼伦贝尔市,莫力达瓦达斡尔族自治旗', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150723, '鄂伦春自治旗', '', '内蒙古自治区,呼伦贝尔市,鄂伦春自治旗', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150724, '鄂温克族自治旗', '', '内蒙古自治区,呼伦贝尔市,鄂温克族自治旗', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150725, '陈巴尔虎旗', '', '内蒙古自治区,呼伦贝尔市,陈巴尔虎旗', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150726, '新巴尔虎左旗', '', '内蒙古自治区,呼伦贝尔市,新巴尔虎左旗', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150727, '新巴尔虎右旗', '', '内蒙古自治区,呼伦贝尔市,新巴尔虎右旗', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150781, '满洲里市', '', '内蒙古自治区,呼伦贝尔市,满洲里市', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150782, '牙克石市', '', '内蒙古自治区,呼伦贝尔市,牙克石市', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150783, '扎兰屯市', '', '内蒙古自治区,呼伦贝尔市,扎兰屯市', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150784, '额尔古纳市', '', '内蒙古自治区,呼伦贝尔市,额尔古纳市', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150785, '根河市', '', '内蒙古自治区,呼伦贝尔市,根河市', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150801, '市辖区', '', '内蒙古自治区,巴彦淖尔市,市辖区', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150802, '临河区', '', '内蒙古自治区,巴彦淖尔市,临河区', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150821, '五原县', '', '内蒙古自治区,巴彦淖尔市,五原县', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150822, '磴口县', '', '内蒙古自治区,巴彦淖尔市,磴口县', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150823, '乌拉特前旗', '', '内蒙古自治区,巴彦淖尔市,乌拉特前旗', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150824, '乌拉特中旗', '', '内蒙古自治区,巴彦淖尔市,乌拉特中旗', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150825, '乌拉特后旗', '', '内蒙古自治区,巴彦淖尔市,乌拉特后旗', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150826, '杭锦后旗', '', '内蒙古自治区,巴彦淖尔市,杭锦后旗', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150901, '市辖区', '', '内蒙古自治区,乌兰察布市,市辖区', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150902, '集宁区', '', '内蒙古自治区,乌兰察布市,集宁区', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150921, '卓资县', '', '内蒙古自治区,乌兰察布市,卓资县', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150922, '化德县', '', '内蒙古自治区,乌兰察布市,化德县', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150923, '商都县', '', '内蒙古自治区,乌兰察布市,商都县', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150924, '兴和县', '', '内蒙古自治区,乌兰察布市,兴和县', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150925, '凉城县', '', '内蒙古自治区,乌兰察布市,凉城县', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150926, '察哈尔右翼前旗', '', '内蒙古自治区,乌兰察布市,察哈尔右翼前旗', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150927, '察哈尔右翼中旗', '', '内蒙古自治区,乌兰察布市,察哈尔右翼中旗', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150928, '察哈尔右翼后旗', '', '内蒙古自治区,乌兰察布市,察哈尔右翼后旗', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150929, '四子王旗', '', '内蒙古自治区,乌兰察布市,四子王旗', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150981, '丰镇市', '', '内蒙古自治区,乌兰察布市,丰镇市', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152201, '乌兰浩特市', '', '内蒙古自治区,兴安盟,乌兰浩特市', 152200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152202, '阿尔山市', '', '内蒙古自治区,兴安盟,阿尔山市', 152200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152221, '科尔沁右翼前旗', '', '内蒙古自治区,兴安盟,科尔沁右翼前旗', 152200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152222, '科尔沁右翼中旗', '', '内蒙古自治区,兴安盟,科尔沁右翼中旗', 152200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152223, '扎赉特旗', '', '内蒙古自治区,兴安盟,扎赉特旗', 152200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152224, '突泉县', '', '内蒙古自治区,兴安盟,突泉县', 152200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152501, '二连浩特市', '', '内蒙古自治区,锡林郭勒盟,二连浩特市', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152502, '锡林浩特市', '', '内蒙古自治区,锡林郭勒盟,锡林浩特市', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152522, '阿巴嘎旗', '', '内蒙古自治区,锡林郭勒盟,阿巴嘎旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152523, '苏尼特左旗', '', '内蒙古自治区,锡林郭勒盟,苏尼特左旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152524, '苏尼特右旗', '', '内蒙古自治区,锡林郭勒盟,苏尼特右旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152525, '东乌珠穆沁旗', '', '内蒙古自治区,锡林郭勒盟,东乌珠穆沁旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152526, '西乌珠穆沁旗', '', '内蒙古自治区,锡林郭勒盟,西乌珠穆沁旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152527, '太仆寺旗', '', '内蒙古自治区,锡林郭勒盟,太仆寺旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152528, '镶黄旗', '', '内蒙古自治区,锡林郭勒盟,镶黄旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152529, '正镶白旗', '', '内蒙古自治区,锡林郭勒盟,正镶白旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152530, '正蓝旗', '', '内蒙古自治区,锡林郭勒盟,正蓝旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152531, '多伦县', '', '内蒙古自治区,锡林郭勒盟,多伦县', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152921, '阿拉善左旗', '', '内蒙古自治区,阿拉善盟,阿拉善左旗', 152900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152922, '阿拉善右旗', '', '内蒙古自治区,阿拉善盟,阿拉善右旗', 152900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152923, '额济纳旗', '', '内蒙古自治区,阿拉善盟,额济纳旗', 152900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210101, '市辖区', '', '辽宁省,沈阳市,市辖区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210102, '和平区', '', '辽宁省,沈阳市,和平区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210103, '沈河区', '', '辽宁省,沈阳市,沈河区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210104, '大东区', '', '辽宁省,沈阳市,大东区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210105, '皇姑区', '', '辽宁省,沈阳市,皇姑区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210106, '铁西区', '', '辽宁省,沈阳市,铁西区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210111, '苏家屯区', '', '辽宁省,沈阳市,苏家屯区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210112, '东陵区', '', '辽宁省,沈阳市,东陵区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210113, '新城子区', '', '辽宁省,沈阳市,新城子区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210114, '于洪区', '', '辽宁省,沈阳市,于洪区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210122, '辽中县', '', '辽宁省,沈阳市,辽中县', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210123, '康平县', '', '辽宁省,沈阳市,康平县', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210124, '法库县', '', '辽宁省,沈阳市,法库县', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210181, '新民市', '', '辽宁省,沈阳市,新民市', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210201, '市辖区', '', '辽宁省,大连市,市辖区', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210202, '中山区', '', '辽宁省,大连市,中山区', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210203, '西岗区', '', '辽宁省,大连市,西岗区', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210204, '沙河口区', '', '辽宁省,大连市,沙河口区', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210211, '甘井子区', '', '辽宁省,大连市,甘井子区', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210212, '旅顺口区', '', '辽宁省,大连市,旅顺口区', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210213, '金州区', '', '辽宁省,大连市,金州区', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210224, '长海县', '', '辽宁省,大连市,长海县', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210281, '瓦房店市', '', '辽宁省,大连市,瓦房店市', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210282, '普兰店市', '', '辽宁省,大连市,普兰店市', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210283, '庄河市', '', '辽宁省,大连市,庄河市', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210301, '市辖区', '', '辽宁省,鞍山市,市辖区', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210302, '铁东区', '', '辽宁省,鞍山市,铁东区', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210303, '铁西区', '', '辽宁省,鞍山市,铁西区', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210304, '立山区', '', '辽宁省,鞍山市,立山区', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210311, '千山区', '', '辽宁省,鞍山市,千山区', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210321, '台安县', '', '辽宁省,鞍山市,台安县', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210323, '岫岩满族自治县', '', '辽宁省,鞍山市,岫岩满族自治县', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210381, '海城市', '', '辽宁省,鞍山市,海城市', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210401, '市辖区', '', '辽宁省,抚顺市,市辖区', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210402, '新抚区', '', '辽宁省,抚顺市,新抚区', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210403, '东洲区', '', '辽宁省,抚顺市,东洲区', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210404, '望花区', '', '辽宁省,抚顺市,望花区', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210411, '顺城区', '', '辽宁省,抚顺市,顺城区', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210421, '抚顺县', '', '辽宁省,抚顺市,抚顺县', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210422, '新宾满族自治县', '', '辽宁省,抚顺市,新宾满族自治县', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210423, '清原满族自治县', '', '辽宁省,抚顺市,清原满族自治县', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210501, '市辖区', '', '辽宁省,本溪市,市辖区', 210500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210502, '平山区', '', '辽宁省,本溪市,平山区', 210500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210503, '溪湖区', '', '辽宁省,本溪市,溪湖区', 210500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210504, '明山区', '', '辽宁省,本溪市,明山区', 210500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210505, '南芬区', '', '辽宁省,本溪市,南芬区', 210500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210521, '本溪满族自治县', '', '辽宁省,本溪市,本溪满族自治县', 210500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210522, '桓仁满族自治县', '', '辽宁省,本溪市,桓仁满族自治县', 210500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210601, '市辖区', '', '辽宁省,丹东市,市辖区', 210600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210602, '元宝区', '', '辽宁省,丹东市,元宝区', 210600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210603, '振兴区', '', '辽宁省,丹东市,振兴区', 210600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210604, '振安区', '', '辽宁省,丹东市,振安区', 210600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210624, '宽甸满族自治县', '', '辽宁省,丹东市,宽甸满族自治县', 210600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210681, '东港市', '', '辽宁省,丹东市,东港市', 210600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210682, '凤城市', '', '辽宁省,丹东市,凤城市', 210600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210701, '市辖区', '', '辽宁省,锦州市,市辖区', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210702, '古塔区', '', '辽宁省,锦州市,古塔区', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210703, '凌河区', '', '辽宁省,锦州市,凌河区', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210711, '太和区', '', '辽宁省,锦州市,太和区', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210726, '黑山县', '', '辽宁省,锦州市,黑山县', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210727, '义　县', '', '辽宁省,锦州市,义　县', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210781, '凌海市', '', '辽宁省,锦州市,凌海市', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210782, '北宁市', '', '辽宁省,锦州市,北宁市', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210801, '市辖区', '', '辽宁省,营口市,市辖区', 210800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210802, '站前区', '', '辽宁省,营口市,站前区', 210800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210803, '西市区', '', '辽宁省,营口市,西市区', 210800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210804, '鲅鱼圈区', '', '辽宁省,营口市,鲅鱼圈区', 210800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210811, '老边区', '', '辽宁省,营口市,老边区', 210800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210881, '盖州市', '', '辽宁省,营口市,盖州市', 210800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210882, '大石桥市', '', '辽宁省,营口市,大石桥市', 210800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210901, '市辖区', '', '辽宁省,阜新市,市辖区', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210902, '海州区', '', '辽宁省,阜新市,海州区', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210903, '新邱区', '', '辽宁省,阜新市,新邱区', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210904, '太平区', '', '辽宁省,阜新市,太平区', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210905, '清河门区', '', '辽宁省,阜新市,清河门区', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210911, '细河区', '', '辽宁省,阜新市,细河区', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210921, '阜新蒙古族自治县', '', '辽宁省,阜新市,阜新蒙古族自治县', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210922, '彰武县', '', '辽宁省,阜新市,彰武县', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211001, '市辖区', '', '辽宁省,辽阳市,市辖区', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211002, '白塔区', '', '辽宁省,辽阳市,白塔区', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211003, '文圣区', '', '辽宁省,辽阳市,文圣区', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211004, '宏伟区', '', '辽宁省,辽阳市,宏伟区', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211005, '弓长岭区', '', '辽宁省,辽阳市,弓长岭区', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211011, '太子河区', '', '辽宁省,辽阳市,太子河区', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211021, '辽阳县', '', '辽宁省,辽阳市,辽阳县', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211081, '灯塔市', '', '辽宁省,辽阳市,灯塔市', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211101, '市辖区', '', '辽宁省,盘锦市,市辖区', 211100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211102, '双台子区', '', '辽宁省,盘锦市,双台子区', 211100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211103, '兴隆台区', '', '辽宁省,盘锦市,兴隆台区', 211100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211121, '大洼县', '', '辽宁省,盘锦市,大洼县', 211100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211122, '盘山县', '', '辽宁省,盘锦市,盘山县', 211100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211201, '市辖区', '', '辽宁省,铁岭市,市辖区', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211202, '银州区', '', '辽宁省,铁岭市,银州区', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211204, '清河区', '', '辽宁省,铁岭市,清河区', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211221, '铁岭县', '', '辽宁省,铁岭市,铁岭县', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211223, '西丰县', '', '辽宁省,铁岭市,西丰县', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211224, '昌图县', '', '辽宁省,铁岭市,昌图县', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211281, '调兵山市', '', '辽宁省,铁岭市,调兵山市', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211282, '开原市', '', '辽宁省,铁岭市,开原市', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211301, '市辖区', '', '辽宁省,朝阳市,市辖区', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211302, '双塔区', '', '辽宁省,朝阳市,双塔区', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211303, '龙城区', '', '辽宁省,朝阳市,龙城区', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211321, '朝阳县', '', '辽宁省,朝阳市,朝阳县', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211322, '建平县', '', '辽宁省,朝阳市,建平县', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211324, '喀喇沁左翼蒙古族自治县', '', '辽宁省,朝阳市,喀喇沁左翼蒙古族自治县', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211381, '北票市', '', '辽宁省,朝阳市,北票市', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211382, '凌源市', '', '辽宁省,朝阳市,凌源市', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211401, '市辖区', '', '市辖区', 211400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211402, '连山区', '', '连山区', 211400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211403, '龙港区', '', '龙港区', 211400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211404, '南票区', '', '南票区', 211400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211421, '绥中县', '', '绥中县', 211400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211422, '建昌县', '', '建昌县', 211400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211481, '兴城市', '', '兴城市', 211400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220101, '市辖区', '', '吉林省,长春市,市辖区', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220102, '南关区', '', '吉林省,长春市,南关区', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220103, '宽城区', '', '吉林省,长春市,宽城区', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220104, '朝阳区', '', '吉林省,长春市,朝阳区', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220105, '二道区', '', '吉林省,长春市,二道区', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220106, '绿园区', '', '吉林省,长春市,绿园区', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220112, '双阳区', '', '吉林省,长春市,双阳区', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220122, '农安县', '', '吉林省,长春市,农安县', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220181, '九台市', '', '吉林省,长春市,九台市', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220182, '榆树市', '', '吉林省,长春市,榆树市', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220183, '德惠市', '', '吉林省,长春市,德惠市', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220201, '市辖区', '', '吉林省,吉林市,市辖区', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220202, '昌邑区', '', '吉林省,吉林市,昌邑区', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220203, '龙潭区', '', '吉林省,吉林市,龙潭区', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220204, '船营区', '', '吉林省,吉林市,船营区', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220211, '丰满区', '', '吉林省,吉林市,丰满区', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220221, '永吉县', '', '吉林省,吉林市,永吉县', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220281, '蛟河市', '', '吉林省,吉林市,蛟河市', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220282, '桦甸市', '', '吉林省,吉林市,桦甸市', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220283, '舒兰市', '', '吉林省,吉林市,舒兰市', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220284, '磐石市', '', '吉林省,吉林市,磐石市', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220301, '市辖区', '', '吉林省,四平市,市辖区', 220300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220302, '铁西区', '', '吉林省,四平市,铁西区', 220300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220303, '铁东区', '', '吉林省,四平市,铁东区', 220300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220322, '梨树县', '', '吉林省,四平市,梨树县', 220300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220323, '伊通满族自治县', '', '吉林省,四平市,伊通满族自治县', 220300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220381, '公主岭市', '', '吉林省,四平市,公主岭市', 220300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220382, '双辽市', '', '吉林省,四平市,双辽市', 220300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220401, '市辖区', '', '吉林省,辽源市,市辖区', 220400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220402, '龙山区', '', '吉林省,辽源市,龙山区', 220400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220403, '西安区', '', '吉林省,辽源市,西安区', 220400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220421, '东丰县', '', '吉林省,辽源市,东丰县', 220400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220422, '东辽县', '', '吉林省,辽源市,东辽县', 220400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220501, '市辖区', '', '吉林省,通化市,市辖区', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220502, '东昌区', '', '吉林省,通化市,东昌区', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220503, '二道江区', '', '吉林省,通化市,二道江区', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220521, '通化县', '', '吉林省,通化市,通化县', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220523, '辉南县', '', '吉林省,通化市,辉南县', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220524, '柳河县', '', '吉林省,通化市,柳河县', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220581, '梅河口市', '', '吉林省,通化市,梅河口市', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220582, '集安市', '', '吉林省,通化市,集安市', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220601, '市辖区', '', '吉林省,白山市,市辖区', 220600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220602, '八道江区', '', '吉林省,白山市,八道江区', 220600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220621, '抚松县', '', '吉林省,白山市,抚松县', 220600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220622, '靖宇县', '', '吉林省,白山市,靖宇县', 220600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220623, '长白朝鲜族自治县', '', '吉林省,白山市,长白朝鲜族自治县', 220600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220625, '江源县', '', '吉林省,白山市,江源县', 220600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220681, '临江市', '', '吉林省,白山市,临江市', 220600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220701, '市辖区', '', '吉林省,松原市,市辖区', 220700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220702, '宁江区', '', '吉林省,松原市,宁江区', 220700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220721, '前郭尔罗斯蒙古族自治县', '', '吉林省,松原市,前郭尔罗斯蒙古族自治县', 220700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220722, '长岭县', '', '吉林省,松原市,长岭县', 220700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220723, '乾安县', '', '吉林省,松原市,乾安县', 220700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220724, '扶余县', '', '吉林省,松原市,扶余县', 220700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220801, '市辖区', '', '吉林省,白城市,市辖区', 220800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220802, '洮北区', '', '吉林省,白城市,洮北区', 220800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220821, '镇赉县', '', '吉林省,白城市,镇赉县', 220800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220822, '通榆县', '', '吉林省,白城市,通榆县', 220800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220881, '洮南市', '', '吉林省,白城市,洮南市', 220800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220882, '大安市', '', '吉林省,白城市,大安市', 220800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222401, '延吉市', '', '吉林省,延边朝鲜族自治州,延吉市', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222402, '图们市', '', '吉林省,延边朝鲜族自治州,图们市', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222403, '敦化市', '', '吉林省,延边朝鲜族自治州,敦化市', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222404, '珲春市', '', '吉林省,延边朝鲜族自治州,珲春市', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222405, '龙井市', '', '吉林省,延边朝鲜族自治州,龙井市', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222406, '和龙市', '', '吉林省,延边朝鲜族自治州,和龙市', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222424, '汪清县', '', '吉林省,延边朝鲜族自治州,汪清县', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222426, '安图县', '', '吉林省,延边朝鲜族自治州,安图县', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230101, '市辖区', '', '黑龙江省,哈尔滨市,市辖区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230102, '道里区', '', '黑龙江省,哈尔滨市,道里区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230103, '南岗区', '', '黑龙江省,哈尔滨市,南岗区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230104, '道外区', '', '黑龙江省,哈尔滨市,道外区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230106, '香坊区', '', '黑龙江省,哈尔滨市,香坊区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230107, '动力区', '', '黑龙江省,哈尔滨市,动力区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230108, '平房区', '', '黑龙江省,哈尔滨市,平房区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230109, '松北区', '', '黑龙江省,哈尔滨市,松北区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230111, '呼兰区', '', '黑龙江省,哈尔滨市,呼兰区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230123, '依兰县', '', '黑龙江省,哈尔滨市,依兰县', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230124, '方正县', '', '黑龙江省,哈尔滨市,方正县', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230125, '宾　县', '', '黑龙江省,哈尔滨市,宾　县', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230126, '巴彦县', '', '黑龙江省,哈尔滨市,巴彦县', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230127, '木兰县', '', '黑龙江省,哈尔滨市,木兰县', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230128, '通河县', '', '黑龙江省,哈尔滨市,通河县', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230129, '延寿县', '', '黑龙江省,哈尔滨市,延寿县', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230181, '阿城市', '', '黑龙江省,哈尔滨市,阿城市', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230182, '双城市', '', '黑龙江省,哈尔滨市,双城市', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230183, '尚志市', '', '黑龙江省,哈尔滨市,尚志市', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230184, '五常市', '', '黑龙江省,哈尔滨市,五常市', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230201, '市辖区', '', '黑龙江省,齐齐哈尔市,市辖区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230202, '龙沙区', '', '黑龙江省,齐齐哈尔市,龙沙区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230203, '建华区', '', '黑龙江省,齐齐哈尔市,建华区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230204, '铁锋区', '', '黑龙江省,齐齐哈尔市,铁锋区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230205, '昂昂溪区', '', '黑龙江省,齐齐哈尔市,昂昂溪区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230206, '富拉尔基区', '', '黑龙江省,齐齐哈尔市,富拉尔基区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230207, '碾子山区', '', '黑龙江省,齐齐哈尔市,碾子山区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230208, '梅里斯达斡尔族区', '', '黑龙江省,齐齐哈尔市,梅里斯达斡尔族区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230221, '龙江县', '', '黑龙江省,齐齐哈尔市,龙江县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230223, '依安县', '', '黑龙江省,齐齐哈尔市,依安县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230224, '泰来县', '', '黑龙江省,齐齐哈尔市,泰来县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230225, '甘南县', '', '黑龙江省,齐齐哈尔市,甘南县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230227, '富裕县', '', '黑龙江省,齐齐哈尔市,富裕县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230229, '克山县', '', '黑龙江省,齐齐哈尔市,克山县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230230, '克东县', '', '黑龙江省,齐齐哈尔市,克东县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230231, '拜泉县', '', '黑龙江省,齐齐哈尔市,拜泉县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230281, '讷河市', '', '黑龙江省,齐齐哈尔市,讷河市', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230301, '市辖区', '', '黑龙江省,鸡西市,市辖区', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230302, '鸡冠区', '', '黑龙江省,鸡西市,鸡冠区', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230303, '恒山区', '', '黑龙江省,鸡西市,恒山区', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230304, '滴道区', '', '黑龙江省,鸡西市,滴道区', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230305, '梨树区', '', '黑龙江省,鸡西市,梨树区', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230306, '城子河区', '', '黑龙江省,鸡西市,城子河区', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230307, '麻山区', '', '黑龙江省,鸡西市,麻山区', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230321, '鸡东县', '', '黑龙江省,鸡西市,鸡东县', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230381, '虎林市', '', '黑龙江省,鸡西市,虎林市', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230382, '密山市', '', '黑龙江省,鸡西市,密山市', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230401, '市辖区', '', '黑龙江省,鹤岗市,市辖区', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230402, '向阳区', '', '黑龙江省,鹤岗市,向阳区', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230403, '工农区', '', '黑龙江省,鹤岗市,工农区', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230404, '南山区', '', '黑龙江省,鹤岗市,南山区', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230405, '兴安区', '', '黑龙江省,鹤岗市,兴安区', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230406, '东山区', '', '黑龙江省,鹤岗市,东山区', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230407, '兴山区', '', '黑龙江省,鹤岗市,兴山区', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230421, '萝北县', '', '黑龙江省,鹤岗市,萝北县', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230422, '绥滨县', '', '黑龙江省,鹤岗市,绥滨县', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230501, '市辖区', '', '黑龙江省,双鸭山市,市辖区', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230502, '尖山区', '', '黑龙江省,双鸭山市,尖山区', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230503, '岭东区', '', '黑龙江省,双鸭山市,岭东区', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230505, '四方台区', '', '黑龙江省,双鸭山市,四方台区', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230506, '宝山区', '', '黑龙江省,双鸭山市,宝山区', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230521, '集贤县', '', '黑龙江省,双鸭山市,集贤县', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230522, '友谊县', '', '黑龙江省,双鸭山市,友谊县', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230523, '宝清县', '', '黑龙江省,双鸭山市,宝清县', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230524, '饶河县', '', '黑龙江省,双鸭山市,饶河县', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230601, '市辖区', '', '黑龙江省,大庆市,市辖区', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230602, '萨尔图区', '', '黑龙江省,大庆市,萨尔图区', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230603, '龙凤区', '', '黑龙江省,大庆市,龙凤区', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230604, '让胡路区', '', '黑龙江省,大庆市,让胡路区', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230605, '红岗区', '', '黑龙江省,大庆市,红岗区', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230606, '大同区', '', '黑龙江省,大庆市,大同区', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230621, '肇州县', '', '黑龙江省,大庆市,肇州县', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230622, '肇源县', '', '黑龙江省,大庆市,肇源县', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230623, '林甸县', '', '黑龙江省,大庆市,林甸县', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230624, '杜尔伯特蒙古族自治县', '', '黑龙江省,大庆市,杜尔伯特蒙古族自治县', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230701, '市辖区', '', '黑龙江省,伊春市,市辖区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230702, '伊春区', '', '黑龙江省,伊春市,伊春区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230703, '南岔区', '', '黑龙江省,伊春市,南岔区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230704, '友好区', '', '黑龙江省,伊春市,友好区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230705, '西林区', '', '黑龙江省,伊春市,西林区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230706, '翠峦区', '', '黑龙江省,伊春市,翠峦区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230707, '新青区', '', '黑龙江省,伊春市,新青区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230708, '美溪区', '', '黑龙江省,伊春市,美溪区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230709, '金山屯区', '', '黑龙江省,伊春市,金山屯区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230710, '五营区', '', '黑龙江省,伊春市,五营区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230711, '乌马河区', '', '黑龙江省,伊春市,乌马河区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230712, '汤旺河区', '', '黑龙江省,伊春市,汤旺河区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230713, '带岭区', '', '黑龙江省,伊春市,带岭区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230714, '乌伊岭区', '', '黑龙江省,伊春市,乌伊岭区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230715, '红星区', '', '黑龙江省,伊春市,红星区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230716, '上甘岭区', '', '黑龙江省,伊春市,上甘岭区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230722, '嘉荫县', '', '黑龙江省,伊春市,嘉荫县', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230781, '铁力市', '', '黑龙江省,伊春市,铁力市', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230801, '市辖区', '', '黑龙江省,佳木斯市,市辖区', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230802, '永红区', '', '黑龙江省,佳木斯市,永红区', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230803, '向阳区', '', '黑龙江省,佳木斯市,向阳区', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230804, '前进区', '', '黑龙江省,佳木斯市,前进区', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230805, '东风区', '', '黑龙江省,佳木斯市,东风区', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230811, '郊　区', '', '黑龙江省,佳木斯市,郊　区', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230822, '桦南县', '', '黑龙江省,佳木斯市,桦南县', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230826, '桦川县', '', '黑龙江省,佳木斯市,桦川县', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230828, '汤原县', '', '黑龙江省,佳木斯市,汤原县', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230833, '抚远县', '', '黑龙江省,佳木斯市,抚远县', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230881, '同江市', '', '黑龙江省,佳木斯市,同江市', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230882, '富锦市', '', '黑龙江省,佳木斯市,富锦市', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230901, '市辖区', '', '黑龙江省,七台河市,市辖区', 230900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230902, '新兴区', '', '黑龙江省,七台河市,新兴区', 230900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230903, '桃山区', '', '黑龙江省,七台河市,桃山区', 230900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230904, '茄子河区', '', '黑龙江省,七台河市,茄子河区', 230900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230921, '勃利县', '', '黑龙江省,七台河市,勃利县', 230900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231001, '市辖区', '', '黑龙江省,牡丹江市,市辖区', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231002, '东安区', '', '黑龙江省,牡丹江市,东安区', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231003, '阳明区', '', '黑龙江省,牡丹江市,阳明区', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231004, '爱民区', '', '黑龙江省,牡丹江市,爱民区', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231005, '西安区', '', '黑龙江省,牡丹江市,西安区', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231024, '东宁县', '', '黑龙江省,牡丹江市,东宁县', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231025, '林口县', '', '黑龙江省,牡丹江市,林口县', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231081, '绥芬河市', '', '黑龙江省,牡丹江市,绥芬河市', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231083, '海林市', '', '黑龙江省,牡丹江市,海林市', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231084, '宁安市', '', '黑龙江省,牡丹江市,宁安市', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231085, '穆棱市', '', '黑龙江省,牡丹江市,穆棱市', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231101, '市辖区', '', '黑龙江省,黑河市,市辖区', 231100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231102, '爱辉区', '', '黑龙江省,黑河市,爱辉区', 231100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231121, '嫩江县', '', '黑龙江省,黑河市,嫩江县', 231100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231123, '逊克县', '', '黑龙江省,黑河市,逊克县', 231100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231124, '孙吴县', '', '黑龙江省,黑河市,孙吴县', 231100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231181, '北安市', '', '黑龙江省,黑河市,北安市', 231100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231182, '五大连池市', '', '黑龙江省,黑河市,五大连池市', 231100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231201, '市辖区', '', '黑龙江省,绥化市,市辖区', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231202, '北林区', '', '黑龙江省,绥化市,北林区', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231221, '望奎县', '', '黑龙江省,绥化市,望奎县', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231222, '兰西县', '', '黑龙江省,绥化市,兰西县', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231223, '青冈县', '', '黑龙江省,绥化市,青冈县', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231224, '庆安县', '', '黑龙江省,绥化市,庆安县', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231225, '明水县', '', '黑龙江省,绥化市,明水县', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231226, '绥棱县', '', '黑龙江省,绥化市,绥棱县', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231281, '安达市', '', '黑龙江省,绥化市,安达市', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231282, '肇东市', '', '黑龙江省,绥化市,肇东市', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231283, '海伦市', '', '黑龙江省,绥化市,海伦市', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (232721, '呼玛县', '', '黑龙江省,大兴安岭地区,呼玛县', 232700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (232722, '塔河县', '', '黑龙江省,大兴安岭地区,塔河县', 232700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (232723, '漠河县', '', '黑龙江省,大兴安岭地区,漠河县', 232700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310101, '黄浦区', '', '上海市,市辖区,黄浦区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310103, '卢湾区', '', '上海市,市辖区,卢湾区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310104, '徐汇区', '', '上海市,市辖区,徐汇区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310105, '长宁区', '', '上海市,市辖区,长宁区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310106, '静安区', '', '上海市,市辖区,静安区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310107, '普陀区', '', '上海市,市辖区,普陀区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310108, '闸北区', '', '上海市,市辖区,闸北区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310109, '虹口区', '', '上海市,市辖区,虹口区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310110, '杨浦区', '', '上海市,市辖区,杨浦区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310112, '闵行区', '', '上海市,市辖区,闵行区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310113, '宝山区', '', '上海市,市辖区,宝山区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310114, '嘉定区', '', '上海市,市辖区,嘉定区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310115, '浦东新区', '', '上海市,市辖区,浦东新区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310116, '金山区', '', '上海市,市辖区,金山区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310117, '松江区', '', '上海市,市辖区,松江区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310118, '青浦区', '', '上海市,市辖区,青浦区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310119, '南汇区', '', '上海市,市辖区,南汇区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310120, '奉贤区', '', '上海市,市辖区,奉贤区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310230, '崇明县', '', '上海市,县,崇明县', 310200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320101, '市辖区', '', '江苏省,南京市,市辖区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320102, '玄武区', '', '江苏省,南京市,玄武区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320103, '白下区', '', '江苏省,南京市,白下区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320104, '秦淮区', '', '江苏省,南京市,秦淮区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320105, '建邺区', '', '江苏省,南京市,建邺区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320106, '鼓楼区', '', '江苏省,南京市,鼓楼区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320107, '下关区', '', '江苏省,南京市,下关区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320111, '浦口区', '', '江苏省,南京市,浦口区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320113, '栖霞区', '', '江苏省,南京市,栖霞区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320114, '雨花台区', '', '江苏省,南京市,雨花台区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320115, '江宁区', '', '江苏省,南京市,江宁区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320116, '六合区', '', '江苏省,南京市,六合区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320124, '溧水县', '', '江苏省,南京市,溧水县', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320125, '高淳县', '', '江苏省,南京市,高淳县', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320201, '市辖区', '', '江苏省,无锡市,市辖区', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320202, '崇安区', '', '江苏省,无锡市,崇安区', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320203, '南长区', '', '江苏省,无锡市,南长区', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320204, '北塘区', '', '江苏省,无锡市,北塘区', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320205, '锡山区', '', '江苏省,无锡市,锡山区', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320206, '惠山区', '', '江苏省,无锡市,惠山区', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320211, '滨湖区', '', '江苏省,无锡市,滨湖区', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320281, '江阴市', '', '江苏省,无锡市,江阴市', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320282, '宜兴市', '', '江苏省,无锡市,宜兴市', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320301, '市辖区', '', '江苏省,徐州市,市辖区', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320302, '鼓楼区', '', '江苏省,徐州市,鼓楼区', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320303, '云龙区', '', '江苏省,徐州市,云龙区', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320304, '九里区', '', '江苏省,徐州市,九里区', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320305, '贾汪区', '', '江苏省,徐州市,贾汪区', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320311, '泉山区', '', '江苏省,徐州市,泉山区', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320321, '丰　县', '', '江苏省,徐州市,丰　县', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320322, '沛　县', '', '江苏省,徐州市,沛　县', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320323, '铜山县', '', '江苏省,徐州市,铜山县', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320324, '睢宁县', '', '江苏省,徐州市,睢宁县', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320381, '新沂市', '', '江苏省,徐州市,新沂市', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320382, '邳州市', '', '江苏省,徐州市,邳州市', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320401, '市辖区', '', '江苏省,常州市,市辖区', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320402, '天宁区', '', '江苏省,常州市,天宁区', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320404, '钟楼区', '', '江苏省,常州市,钟楼区', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320405, '戚墅堰区', '', '江苏省,常州市,戚墅堰区', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320411, '新北区', '', '江苏省,常州市,新北区', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320412, '武进区', '', '江苏省,常州市,武进区', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320481, '溧阳市', '', '江苏省,常州市,溧阳市', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320482, '金坛市', '', '江苏省,常州市,金坛市', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320501, '市辖区', '', '江苏省,苏州市,市辖区', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320502, '沧浪区', '', '江苏省,苏州市,沧浪区', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320503, '平江区', '', '江苏省,苏州市,平江区', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320504, '金阊区', '', '江苏省,苏州市,金阊区', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320505, '虎丘区', '', '江苏省,苏州市,虎丘区', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320506, '吴中区', '', '江苏省,苏州市,吴中区', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320507, '相城区', '', '江苏省,苏州市,相城区', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320581, '常熟市', '', '江苏省,苏州市,常熟市', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320582, '张家港市', '', '江苏省,苏州市,张家港市', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320583, '昆山市', '', '江苏省,苏州市,昆山市', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320584, '吴江市', '', '江苏省,苏州市,吴江市', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320585, '太仓市', '', '江苏省,苏州市,太仓市', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320601, '市辖区', '', '江苏省,南通市,市辖区', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320602, '崇川区', '', '江苏省,南通市,崇川区', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320611, '港闸区', '', '江苏省,南通市,港闸区', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320621, '海安县', '', '江苏省,南通市,海安县', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320623, '如东县', '', '江苏省,南通市,如东县', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320681, '启东市', '', '江苏省,南通市,启东市', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320682, '如皋市', '', '江苏省,南通市,如皋市', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320683, '通州市', '', '江苏省,南通市,通州市', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320684, '海门市', '', '江苏省,南通市,海门市', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320701, '市辖区', '', '江苏省,连云港市,市辖区', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320703, '连云区', '', '江苏省,连云港市,连云区', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320705, '新浦区', '', '江苏省,连云港市,新浦区', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320706, '海州区', '', '江苏省,连云港市,海州区', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320721, '赣榆县', '', '江苏省,连云港市,赣榆县', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320722, '东海县', '', '江苏省,连云港市,东海县', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320723, '灌云县', '', '江苏省,连云港市,灌云县', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320724, '灌南县', '', '江苏省,连云港市,灌南县', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320801, '市辖区', '', '江苏省,淮安市,市辖区', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320802, '清河区', '', '江苏省,淮安市,清河区', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320803, '楚州区', '', '江苏省,淮安市,楚州区', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320804, '淮阴区', '', '江苏省,淮安市,淮阴区', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320811, '清浦区', '', '江苏省,淮安市,清浦区', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320826, '涟水县', '', '江苏省,淮安市,涟水县', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320829, '洪泽县', '', '江苏省,淮安市,洪泽县', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320830, '盱眙县', '', '江苏省,淮安市,盱眙县', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320831, '金湖县', '', '江苏省,淮安市,金湖县', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320901, '市辖区', '', '江苏省,盐城市,市辖区', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320902, '亭湖区', '', '江苏省,盐城市,亭湖区', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320903, '盐都区', '', '江苏省,盐城市,盐都区', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320921, '响水县', '', '江苏省,盐城市,响水县', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320922, '滨海县', '', '江苏省,盐城市,滨海县', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320923, '阜宁县', '', '江苏省,盐城市,阜宁县', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320924, '射阳县', '', '江苏省,盐城市,射阳县', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320925, '建湖县', '', '江苏省,盐城市,建湖县', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320981, '东台市', '', '江苏省,盐城市,东台市', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320982, '大丰市', '', '江苏省,盐城市,大丰市', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321001, '市辖区', '', '江苏省,扬州市,市辖区', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321002, '广陵区', '', '江苏省,扬州市,广陵区', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321003, '邗江区', '', '江苏省,扬州市,邗江区', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321011, '郊　区', '', '江苏省,扬州市,郊　区', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321023, '宝应县', '', '江苏省,扬州市,宝应县', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321081, '仪征市', '', '江苏省,扬州市,仪征市', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321084, '高邮市', '', '江苏省,扬州市,高邮市', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321088, '江都市', '', '江苏省,扬州市,江都市', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321101, '市辖区', '', '江苏省,镇江市,市辖区', 321100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321102, '京口区', '', '江苏省,镇江市,京口区', 321100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321111, '润州区', '', '江苏省,镇江市,润州区', 321100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321112, '丹徒区', '', '江苏省,镇江市,丹徒区', 321100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321181, '丹阳市', '', '江苏省,镇江市,丹阳市', 321100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321182, '扬中市', '', '江苏省,镇江市,扬中市', 321100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321183, '句容市', '', '江苏省,镇江市,句容市', 321100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321201, '市辖区', '', '江苏省,泰州市,市辖区', 321200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321202, '海陵区', '', '江苏省,泰州市,海陵区', 321200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321203, '高港区', '', '江苏省,泰州市,高港区', 321200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321281, '兴化市', '', '江苏省,泰州市,兴化市', 321200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321282, '靖江市', '', '江苏省,泰州市,靖江市', 321200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321283, '泰兴市', '', '江苏省,泰州市,泰兴市', 321200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321284, '姜堰市', '', '江苏省,泰州市,姜堰市', 321200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321301, '市辖区', '', '江苏省,宿迁市,市辖区', 321300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321302, '宿城区', '', '江苏省,宿迁市,宿城区', 321300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321311, '宿豫区', '', '江苏省,宿迁市,宿豫区', 321300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321322, '沭阳县', '', '江苏省,宿迁市,沭阳县', 321300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321323, '泗阳县', '', '江苏省,宿迁市,泗阳县', 321300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321324, '泗洪县', '', '江苏省,宿迁市,泗洪县', 321300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330101, '市辖区', '', '浙江省,杭州市,市辖区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330102, '上城区', '', '浙江省,杭州市,上城区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330103, '下城区', '', '浙江省,杭州市,下城区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330104, '江干区', '', '浙江省,杭州市,江干区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330105, '拱墅区', '', '浙江省,杭州市,拱墅区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330106, '西湖区', '', '浙江省,杭州市,西湖区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330108, '滨江区', '', '浙江省,杭州市,滨江区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330109, '萧山区', '', '浙江省,杭州市,萧山区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330110, '余杭区', '', '浙江省,杭州市,余杭区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330122, '桐庐县', '', '浙江省,杭州市,桐庐县', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330127, '淳安县', '', '浙江省,杭州市,淳安县', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330182, '建德市', '', '浙江省,杭州市,建德市', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330183, '富阳市', '', '浙江省,杭州市,富阳市', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330185, '临安市', '', '浙江省,杭州市,临安市', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330201, '市辖区', '', '浙江省,宁波市,市辖区', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330203, '海曙区', '', '浙江省,宁波市,海曙区', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330204, '江东区', '', '浙江省,宁波市,江东区', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330205, '江北区', '', '浙江省,宁波市,江北区', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330206, '北仑区', '', '浙江省,宁波市,北仑区', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330211, '镇海区', '', '浙江省,宁波市,镇海区', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330212, '鄞州区', '', '浙江省,宁波市,鄞州区', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330225, '象山县', '', '浙江省,宁波市,象山县', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330226, '宁海县', '', '浙江省,宁波市,宁海县', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330281, '余姚市', '', '浙江省,宁波市,余姚市', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330282, '慈溪市', '', '浙江省,宁波市,慈溪市', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330283, '奉化市', '', '浙江省,宁波市,奉化市', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330301, '市辖区', '', '浙江省,温州市,市辖区', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330302, '鹿城区', '', '浙江省,温州市,鹿城区', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330303, '龙湾区', '', '浙江省,温州市,龙湾区', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330304, '瓯海区', '', '浙江省,温州市,瓯海区', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330322, '洞头县', '', '浙江省,温州市,洞头县', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330324, '永嘉县', '', '浙江省,温州市,永嘉县', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330326, '平阳县', '', '浙江省,温州市,平阳县', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330327, '苍南县', '', '浙江省,温州市,苍南县', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330328, '文成县', '', '浙江省,温州市,文成县', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330329, '泰顺县', '', '浙江省,温州市,泰顺县', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330381, '瑞安市', '', '浙江省,温州市,瑞安市', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330382, '乐清市', '', '浙江省,温州市,乐清市', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330401, '市辖区', '', '浙江省,嘉兴市,市辖区', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330402, '秀城区', '', '浙江省,嘉兴市,秀城区', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330411, '秀洲区', '', '浙江省,嘉兴市,秀洲区', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330421, '嘉善县', '', '浙江省,嘉兴市,嘉善县', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330424, '海盐县', '', '浙江省,嘉兴市,海盐县', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330481, '海宁市', '', '浙江省,嘉兴市,海宁市', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330482, '平湖市', '', '浙江省,嘉兴市,平湖市', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330483, '桐乡市', '', '浙江省,嘉兴市,桐乡市', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330501, '市辖区', '', '浙江省,湖州市,市辖区', 330500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330502, '吴兴区', '', '浙江省,湖州市,吴兴区', 330500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330503, '南浔区', '', '浙江省,湖州市,南浔区', 330500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330521, '德清县', '', '浙江省,湖州市,德清县', 330500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330522, '长兴县', '', '浙江省,湖州市,长兴县', 330500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330523, '安吉县', '', '浙江省,湖州市,安吉县', 330500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330601, '市辖区', '', '浙江省,绍兴市,市辖区', 330600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330602, '越城区', '', '浙江省,绍兴市,越城区', 330600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330621, '绍兴县', '', '浙江省,绍兴市,绍兴县', 330600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330624, '新昌县', '', '浙江省,绍兴市,新昌县', 330600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330681, '诸暨市', '', '浙江省,绍兴市,诸暨市', 330600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330682, '上虞市', '', '浙江省,绍兴市,上虞市', 330600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330683, '嵊州市', '', '浙江省,绍兴市,嵊州市', 330600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330701, '市辖区', '', '浙江省,金华市,市辖区', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330702, '婺城区', '', '浙江省,金华市,婺城区', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330703, '金东区', '', '浙江省,金华市,金东区', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330723, '武义县', '', '浙江省,金华市,武义县', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330726, '浦江县', '', '浙江省,金华市,浦江县', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330727, '磐安县', '', '浙江省,金华市,磐安县', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330781, '兰溪市', '', '浙江省,金华市,兰溪市', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330782, '义乌市', '', '浙江省,金华市,义乌市', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330783, '东阳市', '', '浙江省,金华市,东阳市', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330784, '永康市', '', '浙江省,金华市,永康市', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330801, '市辖区', '', '浙江省,衢州市,市辖区', 330800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330802, '柯城区', '', '浙江省,衢州市,柯城区', 330800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330803, '衢江区', '', '浙江省,衢州市,衢江区', 330800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330822, '常山县', '', '浙江省,衢州市,常山县', 330800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330824, '开化县', '', '浙江省,衢州市,开化县', 330800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330825, '龙游县', '', '浙江省,衢州市,龙游县', 330800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330881, '江山市', '', '浙江省,衢州市,江山市', 330800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330901, '市辖区', '', '浙江省,舟山市,市辖区', 330900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330902, '定海区', '', '浙江省,舟山市,定海区', 330900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330903, '普陀区', '', '浙江省,舟山市,普陀区', 330900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330921, '岱山县', '', '浙江省,舟山市,岱山县', 330900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330922, '嵊泗县', '', '浙江省,舟山市,嵊泗县', 330900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331001, '市辖区', '', '浙江省,台州市,市辖区', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331002, '椒江区', '', '浙江省,台州市,椒江区', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331003, '黄岩区', '', '浙江省,台州市,黄岩区', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331004, '路桥区', '', '浙江省,台州市,路桥区', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331021, '玉环县', '', '浙江省,台州市,玉环县', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331022, '三门县', '', '浙江省,台州市,三门县', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331023, '天台县', '', '浙江省,台州市,天台县', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331024, '仙居县', '', '浙江省,台州市,仙居县', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331081, '温岭市', '', '浙江省,台州市,温岭市', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331082, '临海市', '', '浙江省,台州市,临海市', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331101, '市辖区', '', '浙江省,丽水市,市辖区', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331102, '莲都区', '', '浙江省,丽水市,莲都区', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331121, '青田县', '', '浙江省,丽水市,青田县', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331122, '缙云县', '', '浙江省,丽水市,缙云县', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331123, '遂昌县', '', '浙江省,丽水市,遂昌县', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331124, '松阳县', '', '浙江省,丽水市,松阳县', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331125, '云和县', '', '浙江省,丽水市,云和县', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331126, '庆元县', '', '浙江省,丽水市,庆元县', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331127, '景宁畲族自治县', '', '浙江省,丽水市,景宁畲族自治县', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331181, '龙泉市', '', '浙江省,丽水市,龙泉市', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340101, '市辖区', '', '安徽省,合肥市,市辖区', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340102, '瑶海区', '', '安徽省,合肥市,瑶海区', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340103, '庐阳区', '', '安徽省,合肥市,庐阳区', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340104, '蜀山区', '', '安徽省,合肥市,蜀山区', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340111, '包河区', '', '安徽省,合肥市,包河区', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340121, '长丰县', '', '安徽省,合肥市,长丰县', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340122, '肥东县', '', '安徽省,合肥市,肥东县', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340123, '肥西县', '', '安徽省,合肥市,肥西县', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340201, '市辖区', '', '安徽省,芜湖市,市辖区', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340202, '镜湖区', '', '安徽省,芜湖市,镜湖区', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340203, '马塘区', '', '安徽省,芜湖市,马塘区', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340204, '新芜区', '', '安徽省,芜湖市,新芜区', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340207, '鸠江区', '', '安徽省,芜湖市,鸠江区', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340221, '芜湖县', '', '安徽省,芜湖市,芜湖县', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340222, '繁昌县', '', '安徽省,芜湖市,繁昌县', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340223, '南陵县', '', '安徽省,芜湖市,南陵县', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340301, '市辖区', '', '安徽省,蚌埠市,市辖区', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340302, '龙子湖区', '', '安徽省,蚌埠市,龙子湖区', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340303, '蚌山区', '', '安徽省,蚌埠市,蚌山区', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340304, '禹会区', '', '安徽省,蚌埠市,禹会区', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340311, '淮上区', '', '安徽省,蚌埠市,淮上区', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340321, '怀远县', '', '安徽省,蚌埠市,怀远县', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340322, '五河县', '', '安徽省,蚌埠市,五河县', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340323, '固镇县', '', '安徽省,蚌埠市,固镇县', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340401, '市辖区', '', '安徽省,淮南市,市辖区', 340400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340402, '大通区', '', '安徽省,淮南市,大通区', 340400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340403, '田家庵区', '', '安徽省,淮南市,田家庵区', 340400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340404, '谢家集区', '', '安徽省,淮南市,谢家集区', 340400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340405, '八公山区', '', '安徽省,淮南市,八公山区', 340400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340406, '潘集区', '', '安徽省,淮南市,潘集区', 340400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340421, '凤台县', '', '安徽省,淮南市,凤台县', 340400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340501, '市辖区', '', '安徽省,马鞍山市,市辖区', 340500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340502, '金家庄区', '', '安徽省,马鞍山市,金家庄区', 340500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340503, '花山区', '', '安徽省,马鞍山市,花山区', 340500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340504, '雨山区', '', '安徽省,马鞍山市,雨山区', 340500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340521, '当涂县', '', '安徽省,马鞍山市,当涂县', 340500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340601, '市辖区', '', '安徽省,淮北市,市辖区', 340600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340602, '杜集区', '', '安徽省,淮北市,杜集区', 340600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340603, '相山区', '', '安徽省,淮北市,相山区', 340600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340604, '烈山区', '', '安徽省,淮北市,烈山区', 340600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340621, '濉溪县', '', '安徽省,淮北市,濉溪县', 340600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340701, '市辖区', '', '安徽省,铜陵市,市辖区', 340700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340702, '铜官山区', '', '安徽省,铜陵市,铜官山区', 340700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340703, '狮子山区', '', '安徽省,铜陵市,狮子山区', 340700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340711, '郊　区', '', '安徽省,铜陵市,郊　区', 340700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340721, '铜陵县', '', '安徽省,铜陵市,铜陵县', 340700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340801, '市辖区', '', '安徽省,安庆市,市辖区', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340802, '迎江区', '', '安徽省,安庆市,迎江区', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340803, '大观区', '', '安徽省,安庆市,大观区', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340811, '郊　区', '', '安徽省,安庆市,郊　区', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340822, '怀宁县', '', '安徽省,安庆市,怀宁县', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340823, '枞阳县', '', '安徽省,安庆市,枞阳县', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340824, '潜山县', '', '安徽省,安庆市,潜山县', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340825, '太湖县', '', '安徽省,安庆市,太湖县', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340826, '宿松县', '', '安徽省,安庆市,宿松县', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340827, '望江县', '', '安徽省,安庆市,望江县', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340828, '岳西县', '', '安徽省,安庆市,岳西县', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340881, '桐城市', '', '安徽省,安庆市,桐城市', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341001, '市辖区', '', '安徽省,黄山市,市辖区', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341002, '屯溪区', '', '安徽省,黄山市,屯溪区', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341003, '黄山区', '', '安徽省,黄山市,黄山区', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341004, '徽州区', '', '安徽省,黄山市,徽州区', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341021, '歙　县', '', '安徽省,黄山市,歙　县', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341022, '休宁县', '', '安徽省,黄山市,休宁县', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341023, '黟　县', '', '安徽省,黄山市,黟　县', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341024, '祁门县', '', '安徽省,黄山市,祁门县', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341101, '市辖区', '', '安徽省,滁州市,市辖区', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341102, '琅琊区', '', '安徽省,滁州市,琅琊区', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341103, '南谯区', '', '安徽省,滁州市,南谯区', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341122, '来安县', '', '安徽省,滁州市,来安县', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341124, '全椒县', '', '安徽省,滁州市,全椒县', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341125, '定远县', '', '安徽省,滁州市,定远县', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341126, '凤阳县', '', '安徽省,滁州市,凤阳县', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341181, '天长市', '', '安徽省,滁州市,天长市', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341182, '明光市', '', '安徽省,滁州市,明光市', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341201, '市辖区', '', '安徽省,阜阳市,市辖区', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341202, '颍州区', '', '安徽省,阜阳市,颍州区', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341203, '颍东区', '', '安徽省,阜阳市,颍东区', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341204, '颍泉区', '', '安徽省,阜阳市,颍泉区', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341221, '临泉县', '', '安徽省,阜阳市,临泉县', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341222, '太和县', '', '安徽省,阜阳市,太和县', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341225, '阜南县', '', '安徽省,阜阳市,阜南县', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341226, '颍上县', '', '安徽省,阜阳市,颍上县', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341282, '界首市', '', '安徽省,阜阳市,界首市', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341301, '市辖区', '', '安徽省,宿州市,市辖区', 341300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341302, '墉桥区', '', '安徽省,宿州市,墉桥区', 341300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341321, '砀山县', '', '安徽省,宿州市,砀山县', 341300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341322, '萧　县', '', '安徽省,宿州市,萧　县', 341300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341323, '灵璧县', '', '安徽省,宿州市,灵璧县', 341300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341324, '泗　县', '', '安徽省,宿州市,泗　县', 341300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341401, '庐江县', '', '安徽省,合肥市,庐江县', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341402, '巢湖市', '', '安徽省,合肥市,巢湖市', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341422, '无为县', '', '安徽省,芜湖市,无为县', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341423, '含山县', '', '安徽省,马鞍山市,含山县', 340500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341424, '和　县', '', '安徽省,马鞍山市,和　县', 340500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341501, '市辖区', '', '安徽省,六安市,市辖区', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341502, '金安区', '', '安徽省,六安市,金安区', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341503, '裕安区', '', '安徽省,六安市,裕安区', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341521, '寿　县', '', '安徽省,六安市,寿　县', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341522, '霍邱县', '', '安徽省,六安市,霍邱县', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341523, '舒城县', '', '安徽省,六安市,舒城县', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341524, '金寨县', '', '安徽省,六安市,金寨县', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341525, '霍山县', '', '安徽省,六安市,霍山县', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341601, '市辖区', '', '安徽省,亳州市,市辖区', 341600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341602, '谯城区', '', '安徽省,亳州市,谯城区', 341600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341621, '涡阳县', '', '安徽省,亳州市,涡阳县', 341600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341622, '蒙城县', '', '安徽省,亳州市,蒙城县', 341600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341623, '利辛县', '', '安徽省,亳州市,利辛县', 341600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341701, '市辖区', '', '安徽省,池州市,市辖区', 341700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341702, '贵池区', '', '安徽省,池州市,贵池区', 341700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341721, '东至县', '', '安徽省,池州市,东至县', 341700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341722, '石台县', '', '安徽省,池州市,石台县', 341700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341723, '青阳县', '', '安徽省,池州市,青阳县', 341700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341801, '市辖区', '', '安徽省,宣城市,市辖区', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341802, '宣州区', '', '安徽省,宣城市,宣州区', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341821, '郎溪县', '', '安徽省,宣城市,郎溪县', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341822, '广德县', '', '安徽省,宣城市,广德县', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341823, '泾　县', '', '安徽省,宣城市,泾　县', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341824, '绩溪县', '', '安徽省,宣城市,绩溪县', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341825, '旌德县', '', '安徽省,宣城市,旌德县', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341881, '宁国市', '', '安徽省,宣城市,宁国市', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350101, '市辖区', '', '福建省,福州市,市辖区', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350102, '鼓楼区', '', '福建省,福州市,鼓楼区', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350103, '台江区', '', '福建省,福州市,台江区', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350104, '仓山区', '', '福建省,福州市,仓山区', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350105, '马尾区', '', '福建省,福州市,马尾区', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350111, '晋安区', '', '福建省,福州市,晋安区', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350121, '闽侯县', '', '福建省,福州市,闽侯县', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350122, '连江县', '', '福建省,福州市,连江县', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350123, '罗源县', '', '福建省,福州市,罗源县', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350124, '闽清县', '', '福建省,福州市,闽清县', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350125, '永泰县', '', '福建省,福州市,永泰县', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350128, '平潭县', '', '福建省,福州市,平潭县', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350181, '福清市', '', '福建省,福州市,福清市', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350182, '长乐市', '', '福建省,福州市,长乐市', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350201, '市辖区', '', '福建省,厦门市,市辖区', 350200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350203, '思明区', '', '福建省,厦门市,思明区', 350200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350205, '海沧区', '', '福建省,厦门市,海沧区', 350200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350206, '湖里区', '', '福建省,厦门市,湖里区', 350200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350211, '集美区', '', '福建省,厦门市,集美区', 350200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350212, '同安区', '', '福建省,厦门市,同安区', 350200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350213, '翔安区', '', '福建省,厦门市,翔安区', 350200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350301, '市辖区', '', '福建省,莆田市,市辖区', 350300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350302, '城厢区', '', '福建省,莆田市,城厢区', 350300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350303, '涵江区', '', '福建省,莆田市,涵江区', 350300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350304, '荔城区', '', '福建省,莆田市,荔城区', 350300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350305, '秀屿区', '', '福建省,莆田市,秀屿区', 350300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350322, '仙游县', '', '福建省,莆田市,仙游县', 350300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350401, '市辖区', '', '福建省,三明市,市辖区', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350402, '梅列区', '', '福建省,三明市,梅列区', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350403, '三元区', '', '福建省,三明市,三元区', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350421, '明溪县', '', '福建省,三明市,明溪县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350423, '清流县', '', '福建省,三明市,清流县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350424, '宁化县', '', '福建省,三明市,宁化县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350425, '大田县', '', '福建省,三明市,大田县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350426, '尤溪县', '', '福建省,三明市,尤溪县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350427, '沙　县', '', '福建省,三明市,沙　县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350428, '将乐县', '', '福建省,三明市,将乐县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350429, '泰宁县', '', '福建省,三明市,泰宁县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350430, '建宁县', '', '福建省,三明市,建宁县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350481, '永安市', '', '福建省,三明市,永安市', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350501, '市辖区', '', '福建省,泉州市,市辖区', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350502, '鲤城区', '', '福建省,泉州市,鲤城区', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350503, '丰泽区', '', '福建省,泉州市,丰泽区', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350504, '洛江区', '', '福建省,泉州市,洛江区', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350505, '泉港区', '', '福建省,泉州市,泉港区', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350521, '惠安县', '', '福建省,泉州市,惠安县', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350524, '安溪县', '', '福建省,泉州市,安溪县', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350525, '永春县', '', '福建省,泉州市,永春县', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350526, '德化县', '', '福建省,泉州市,德化县', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350527, '金门县', '', '福建省,泉州市,金门县', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350581, '石狮市', '', '福建省,泉州市,石狮市', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350582, '晋江市', '', '福建省,泉州市,晋江市', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350583, '南安市', '', '福建省,泉州市,南安市', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350601, '市辖区', '', '福建省,漳州市,市辖区', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350602, '芗城区', '', '福建省,漳州市,芗城区', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350603, '龙文区', '', '福建省,漳州市,龙文区', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350622, '云霄县', '', '福建省,漳州市,云霄县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350623, '漳浦县', '', '福建省,漳州市,漳浦县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350624, '诏安县', '', '福建省,漳州市,诏安县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350625, '长泰县', '', '福建省,漳州市,长泰县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350626, '东山县', '', '福建省,漳州市,东山县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350627, '南靖县', '', '福建省,漳州市,南靖县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350628, '平和县', '', '福建省,漳州市,平和县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350629, '华安县', '', '福建省,漳州市,华安县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350681, '龙海市', '', '福建省,漳州市,龙海市', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350701, '市辖区', '', '福建省,南平市,市辖区', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350702, '延平区', '', '福建省,南平市,延平区', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350721, '顺昌县', '', '福建省,南平市,顺昌县', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350722, '浦城县', '', '福建省,南平市,浦城县', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350723, '光泽县', '', '福建省,南平市,光泽县', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350724, '松溪县', '', '福建省,南平市,松溪县', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350725, '政和县', '', '福建省,南平市,政和县', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350781, '邵武市', '', '福建省,南平市,邵武市', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350782, '武夷山市', '', '福建省,南平市,武夷山市', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350783, '建瓯市', '', '福建省,南平市,建瓯市', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350784, '建阳市', '', '福建省,南平市,建阳市', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350801, '市辖区', '', '福建省,龙岩市,市辖区', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350802, '新罗区', '', '福建省,龙岩市,新罗区', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350821, '长汀县', '', '福建省,龙岩市,长汀县', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350822, '永定县', '', '福建省,龙岩市,永定县', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350823, '上杭县', '', '福建省,龙岩市,上杭县', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350824, '武平县', '', '福建省,龙岩市,武平县', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350825, '连城县', '', '福建省,龙岩市,连城县', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350881, '漳平市', '', '福建省,龙岩市,漳平市', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350901, '市辖区', '', '福建省,宁德市,市辖区', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350902, '蕉城区', '', '福建省,宁德市,蕉城区', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350921, '霞浦县', '', '福建省,宁德市,霞浦县', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350922, '古田县', '', '福建省,宁德市,古田县', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350923, '屏南县', '', '福建省,宁德市,屏南县', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350924, '寿宁县', '', '福建省,宁德市,寿宁县', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350925, '周宁县', '', '福建省,宁德市,周宁县', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350926, '柘荣县', '', '福建省,宁德市,柘荣县', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350981, '福安市', '', '福建省,宁德市,福安市', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350982, '福鼎市', '', '福建省,宁德市,福鼎市', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360101, '市辖区', '', '江西省,南昌市,市辖区', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360102, '东湖区', '', '江西省,南昌市,东湖区', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360103, '西湖区', '', '江西省,南昌市,西湖区', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360104, '青云谱区', '', '江西省,南昌市,青云谱区', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360105, '湾里区', '', '江西省,南昌市,湾里区', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360111, '青山湖区', '', '江西省,南昌市,青山湖区', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360121, '南昌县', '', '江西省,南昌市,南昌县', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360122, '新建县', '', '江西省,南昌市,新建县', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360123, '安义县', '', '江西省,南昌市,安义县', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360124, '进贤县', '', '江西省,南昌市,进贤县', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360201, '市辖区', '', '江西省,景德镇市,市辖区', 360200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360202, '昌江区', '', '江西省,景德镇市,昌江区', 360200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360203, '珠山区', '', '江西省,景德镇市,珠山区', 360200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360222, '浮梁县', '', '江西省,景德镇市,浮梁县', 360200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360281, '乐平市', '', '江西省,景德镇市,乐平市', 360200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360301, '市辖区', '', '江西省,萍乡市,市辖区', 360300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360302, '安源区', '', '江西省,萍乡市,安源区', 360300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360313, '湘东区', '', '江西省,萍乡市,湘东区', 360300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360321, '莲花县', '', '江西省,萍乡市,莲花县', 360300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360322, '上栗县', '', '江西省,萍乡市,上栗县', 360300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360323, '芦溪县', '', '江西省,萍乡市,芦溪县', 360300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360401, '市辖区', '', '江西省,九江市,市辖区', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360402, '庐山区', '', '江西省,九江市,庐山区', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360403, '浔阳区', '', '江西省,九江市,浔阳区', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360421, '九江县', '', '江西省,九江市,九江县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360423, '武宁县', '', '江西省,九江市,武宁县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360424, '修水县', '', '江西省,九江市,修水县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360425, '永修县', '', '江西省,九江市,永修县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360426, '德安县', '', '江西省,九江市,德安县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360427, '星子县', '', '江西省,九江市,星子县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360428, '都昌县', '', '江西省,九江市,都昌县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360429, '湖口县', '', '江西省,九江市,湖口县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360430, '彭泽县', '', '江西省,九江市,彭泽县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360481, '瑞昌市', '', '江西省,九江市,瑞昌市', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360501, '市辖区', '', '江西省,新余市,市辖区', 360500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360502, '渝水区', '', '江西省,新余市,渝水区', 360500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360521, '分宜县', '', '江西省,新余市,分宜县', 360500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360601, '市辖区', '', '江西省,鹰潭市,市辖区', 360600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360602, '月湖区', '', '江西省,鹰潭市,月湖区', 360600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360622, '余江县', '', '江西省,鹰潭市,余江县', 360600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360681, '贵溪市', '', '江西省,鹰潭市,贵溪市', 360600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360701, '市辖区', '', '江西省,赣州市,市辖区', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360702, '章贡区', '', '江西省,赣州市,章贡区', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360721, '赣　县', '', '江西省,赣州市,赣　县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360722, '信丰县', '', '江西省,赣州市,信丰县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360723, '大余县', '', '江西省,赣州市,大余县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360724, '上犹县', '', '江西省,赣州市,上犹县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360725, '崇义县', '', '江西省,赣州市,崇义县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360726, '安远县', '', '江西省,赣州市,安远县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360727, '龙南县', '', '江西省,赣州市,龙南县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360728, '定南县', '', '江西省,赣州市,定南县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360729, '全南县', '', '江西省,赣州市,全南县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360730, '宁都县', '', '江西省,赣州市,宁都县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360731, '于都县', '', '江西省,赣州市,于都县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360732, '兴国县', '', '江西省,赣州市,兴国县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360733, '会昌县', '', '江西省,赣州市,会昌县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360734, '寻乌县', '', '江西省,赣州市,寻乌县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360735, '石城县', '', '江西省,赣州市,石城县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360781, '瑞金市', '', '江西省,赣州市,瑞金市', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360782, '南康市', '', '江西省,赣州市,南康市', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360801, '市辖区', '', '江西省,吉安市,市辖区', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360802, '吉州区', '', '江西省,吉安市,吉州区', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360803, '青原区', '', '江西省,吉安市,青原区', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360821, '吉安县', '', '江西省,吉安市,吉安县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360822, '吉水县', '', '江西省,吉安市,吉水县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360823, '峡江县', '', '江西省,吉安市,峡江县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360824, '新干县', '', '江西省,吉安市,新干县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360825, '永丰县', '', '江西省,吉安市,永丰县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360826, '泰和县', '', '江西省,吉安市,泰和县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360827, '遂川县', '', '江西省,吉安市,遂川县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360828, '万安县', '', '江西省,吉安市,万安县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360829, '安福县', '', '江西省,吉安市,安福县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360830, '永新县', '', '江西省,吉安市,永新县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360881, '井冈山市', '', '江西省,吉安市,井冈山市', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360901, '市辖区', '', '江西省,宜春市,市辖区', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360902, '袁州区', '', '江西省,宜春市,袁州区', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360921, '奉新县', '', '江西省,宜春市,奉新县', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360922, '万载县', '', '江西省,宜春市,万载县', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360923, '上高县', '', '江西省,宜春市,上高县', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360924, '宜丰县', '', '江西省,宜春市,宜丰县', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360925, '靖安县', '', '江西省,宜春市,靖安县', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360926, '铜鼓县', '', '江西省,宜春市,铜鼓县', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360981, '丰城市', '', '江西省,宜春市,丰城市', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360982, '樟树市', '', '江西省,宜春市,樟树市', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360983, '高安市', '', '江西省,宜春市,高安市', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361001, '市辖区', '', '江西省,抚州市,市辖区', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361002, '临川区', '', '江西省,抚州市,临川区', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361021, '南城县', '', '江西省,抚州市,南城县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361022, '黎川县', '', '江西省,抚州市,黎川县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361023, '南丰县', '', '江西省,抚州市,南丰县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361024, '崇仁县', '', '江西省,抚州市,崇仁县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361025, '乐安县', '', '江西省,抚州市,乐安县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361026, '宜黄县', '', '江西省,抚州市,宜黄县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361027, '金溪县', '', '江西省,抚州市,金溪县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361028, '资溪县', '', '江西省,抚州市,资溪县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361029, '东乡县', '', '江西省,抚州市,东乡县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361030, '广昌县', '', '江西省,抚州市,广昌县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361101, '市辖区', '', '江西省,上饶市,市辖区', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361102, '信州区', '', '江西省,上饶市,信州区', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361121, '上饶县', '', '江西省,上饶市,上饶县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361122, '广丰县', '', '江西省,上饶市,广丰县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361123, '玉山县', '', '江西省,上饶市,玉山县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361124, '铅山县', '', '江西省,上饶市,铅山县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361125, '横峰县', '', '江西省,上饶市,横峰县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361126, '弋阳县', '', '江西省,上饶市,弋阳县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361127, '余干县', '', '江西省,上饶市,余干县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361128, '鄱阳县', '', '江西省,上饶市,鄱阳县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361129, '万年县', '', '江西省,上饶市,万年县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361130, '婺源县', '', '江西省,上饶市,婺源县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361181, '德兴市', '', '江西省,上饶市,德兴市', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (370102, '历下区', '', '山东省,济南市,历下区', 370100, 3, 1, '117.082976,36.672219', 0);
INSERT INTO `wp_city` VALUES (370103, '市中区', '', '山东省,济南市,市中区', 370100, 3, 1, '117.003839,36.65753', 0);
INSERT INTO `wp_city` VALUES (370104, '槐荫区', '', '山东省,济南市,槐荫区', 370100, 3, 1, '116.907297,36.657584', 0);
INSERT INTO `wp_city` VALUES (370105, '天桥区', '', '山东省,济南市,天桥区', 370100, 3, 1, '116.993768,36.684162', 0);
INSERT INTO `wp_city` VALUES (370112, '历城区', '', '山东省,济南市,历城区', 370100, 3, 1, '117.071919,36.685787', 0);
INSERT INTO `wp_city` VALUES (370113, '长清区', '', '山东省,济南市,长清区', 370100, 3, 1, '116.758377,36.559896', 0);
INSERT INTO `wp_city` VALUES (370124, '平阴县', '', '山东省,济南市,平阴县', 370100, 3, 0, '116.462607,36.295031', 0);
INSERT INTO `wp_city` VALUES (370125, '济阳县', '', '山东省,济南市,济阳县', 370100, 3, 0, '117.17995,36.984145', 0);
INSERT INTO `wp_city` VALUES (370126, '商河县', '', '山东省,济南市,商河县', 370100, 3, 0, '117.16363,37.314939', 0);
INSERT INTO `wp_city` VALUES (370181, '章丘市', '', '山东省,济南市,章丘市', 370100, 3, 1, '117.532344,36.685415', 0);
INSERT INTO `wp_city` VALUES (370106, '高新区', '', '山东省,济南市,高新区', 370100, 3, 1, '117.138596,36.680866', 0);
INSERT INTO `wp_city` VALUES (370202, '市南区', '', '山东省,青岛市,市南区', 370200, 3, 1, '120.419417,36.08081', 0);
INSERT INTO `wp_city` VALUES (370203, '市北区', '', '山东省,青岛市,市北区', 370200, 3, 1, '120.381194,36.093682', 0);
INSERT INTO `wp_city` VALUES (370205, '四方区', '', '山东省,青岛市,四方区', 370200, 3, 1, '120.376979,36.131582', 0);
INSERT INTO `wp_city` VALUES (370211, '黄岛区', '', '山东省,青岛市,黄岛区', 370200, 3, 1, '120.203083,35.965711', 0);
INSERT INTO `wp_city` VALUES (370212, '崂山区', '', '山东省,青岛市,崂山区', 370200, 3, 1, '120.474431,36.114399', 0);
INSERT INTO `wp_city` VALUES (370213, '李沧区', '', '山东省,青岛市,李沧区', 370200, 3, 1, '120.439543,36.150804', 0);
INSERT INTO `wp_city` VALUES (370214, '城阳区', '', '山东省,青岛市,城阳区', 370200, 3, 1, '120.402818,36.313321', 0);
INSERT INTO `wp_city` VALUES (370281, '胶州市', '', '山东省,青岛市,胶州市', 370200, 3, 1, '120.040078,36.270389', 0);
INSERT INTO `wp_city` VALUES (370282, '即墨市', '', '山东省,青岛市,即墨市', 370200, 3, 1, '120.453685,36.395272', 0);
INSERT INTO `wp_city` VALUES (370283, '平度市', '', '山东省,青岛市,平度市', 370200, 3, 1, '119.966489,36.792517', 0);
INSERT INTO `wp_city` VALUES (370284, '胶南市', '', '山东省,青岛市,胶南市', 370200, 3, 1, '119.85631,35.852858', 0);
INSERT INTO `wp_city` VALUES (370285, '莱西市', '', '山东省,青岛市,莱西市', 370200, 3, 1, '120.524325,36.89394', 0);
INSERT INTO `wp_city` VALUES (370301, '市辖区', '', '山东省,淄博市,市辖区', 370300, 3, 1, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (370302, '淄川区', '', '山东省,淄博市,淄川区', 370300, 3, 1, '117.973141,36.649837', 0);
INSERT INTO `wp_city` VALUES (370303, '张店区', '', '山东省,淄博市,张店区', 370300, 3, 1, '118.024491,36.812252', 0);
INSERT INTO `wp_city` VALUES (370304, '博山区', '', '山东省,淄博市,博山区', 370300, 3, 1, '117.868187,36.500883', 0);
INSERT INTO `wp_city` VALUES (370305, '临淄区', '', '山东省,淄博市,临淄区', 370300, 3, 1, '118.316102,36.832231', 0);
INSERT INTO `wp_city` VALUES (370306, '周村区', '', '山东省,淄博市,周村区', 370300, 3, 1, '117.876221,36.808979', 0);
INSERT INTO `wp_city` VALUES (370321, '桓台县', '', '山东省,淄博市,桓台县', 370300, 3, 1, '118.104404,36.965538', 0);
INSERT INTO `wp_city` VALUES (370322, '高青县', '', '山东省,淄博市,高青县', 370300, 3, 1, '117.833145,37.177316', 0);
INSERT INTO `wp_city` VALUES (370323, '沂源县', '', '山东省,淄博市,沂源县', 370300, 3, 1, '118.177261,36.190893', 0);
INSERT INTO `wp_city` VALUES (370401, '市辖区', '', '山东省,枣庄市,市辖区', 370400, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (370402, '市中区', '', '山东省,枣庄市,市中区', 370400, 3, 0, '117.562576,34.870023', 0);
INSERT INTO `wp_city` VALUES (370403, '薛城区', '', '山东省,枣庄市,薛城区', 370400, 3, 0, '117.269659,34.801141', 0);
INSERT INTO `wp_city` VALUES (370404, '峄城区', '', '山东省,枣庄市,峄城区', 370400, 3, 0, '117.596999,34.778585', 0);
INSERT INTO `wp_city` VALUES (370405, '台儿庄区', '', '山东省,枣庄市,台儿庄区', 370400, 3, 0, '117.740275,34.568875', 0);
INSERT INTO `wp_city` VALUES (370406, '山亭区', '', '山东省,枣庄市,山亭区', 370400, 3, 0, '117.467742,35.105827', 0);
INSERT INTO `wp_city` VALUES (370481, '滕州市', '', '山东省,枣庄市,滕州市', 370400, 3, 0, '117.172526,35.119115', 0);
INSERT INTO `wp_city` VALUES (370501, '市辖区', '', '山东省,东营市,市辖区', 370500, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (370502, '东营区', '', '山东省,东营市,东营区', 370500, 3, 0, '118.588614,37.454925', 0);
INSERT INTO `wp_city` VALUES (370503, '河口区', '', '山东省,东营市,河口区', 370500, 3, 0, '118.531948,37.89215', 0);
INSERT INTO `wp_city` VALUES (370521, '垦利县', '', '山东省,东营市,垦利县', 370500, 3, 0, '118.554109,37.59377', 0);
INSERT INTO `wp_city` VALUES (370522, '利津县', '', '山东省,东营市,利津县', 370500, 3, 0, '118.261978,37.495939', 0);
INSERT INTO `wp_city` VALUES (370523, '广饶县', '', '山东省,东营市,广饶县', 370500, 3, 0, '118.413518,37.059529', 0);
INSERT INTO `wp_city` VALUES (370601, '市辖区', '', '山东省,烟台市,市辖区', 370600, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (370602, '芝罘区', '', '山东省,烟台市,芝罘区', 370600, 3, 0, '121.406649,37.546425', 0);
INSERT INTO `wp_city` VALUES (370611, '福山区', '', '山东省,烟台市,福山区', 370600, 3, 0, '121.274176,37.503605', 0);
INSERT INTO `wp_city` VALUES (370612, '牟平区', '', '山东省,烟台市,牟平区', 370600, 3, 0, '121.606971,37.392639', 0);
INSERT INTO `wp_city` VALUES (370613, '莱山区', '', '山东省,烟台市,莱山区', 370600, 3, 0, '121.451852,37.517386', 0);
INSERT INTO `wp_city` VALUES (370634, '长岛县', '', '山东省,烟台市,长岛县', 370600, 3, 0, '120.742877,37.927586', 0);
INSERT INTO `wp_city` VALUES (370681, '龙口市', '', '山东省,烟台市,龙口市', 370600, 3, 0, '120.485089,37.649805', 0);
INSERT INTO `wp_city` VALUES (370682, '莱阳市', '', '山东省,烟台市,莱阳市', 370600, 3, 0, '120.718225,36.985114', 0);
INSERT INTO `wp_city` VALUES (370683, '莱州市', '', '山东省,烟台市,莱州市', 370600, 3, 0, '119.948763,37.182657', 0);
INSERT INTO `wp_city` VALUES (370684, '蓬莱市', '', '山东省,烟台市,蓬莱市', 370600, 3, 0, '120.765381,37.816562', 0);
INSERT INTO `wp_city` VALUES (370685, '招远市', '', '山东省,烟台市,招远市', 370600, 3, 0, '120.440811,37.36105', 0);
INSERT INTO `wp_city` VALUES (370686, '栖霞市', '', '山东省,烟台市,栖霞市', 370600, 3, 0, '120.856186,37.34137', 0);
INSERT INTO `wp_city` VALUES (370687, '海阳市', '', '山东省,烟台市,海阳市', 370600, 3, 0, '121.165026,36.782244', 0);
INSERT INTO `wp_city` VALUES (370701, '市辖区', '', '山东省,潍坊市,市辖区', 370700, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (370702, '潍城区', '', '山东省,潍坊市,潍城区', 370700, 3, 0, '119.030323,36.732909', 0);
INSERT INTO `wp_city` VALUES (370703, '寒亭区', '', '山东省,潍坊市,寒亭区', 370700, 3, 0, '119.226555,36.780704', 0);
INSERT INTO `wp_city` VALUES (370704, '坊子区', '', '山东省,潍坊市,坊子区', 370700, 3, 0, '119.172471,36.660921', 0);
INSERT INTO `wp_city` VALUES (370705, '奎文区', '', '山东省,潍坊市,奎文区', 370700, 3, 0, '119.139263,36.714689', 0);
INSERT INTO `wp_city` VALUES (370724, '临朐县', '', '山东省,潍坊市,临朐县', 370700, 3, 0, '118.54945,36.51854', 0);
INSERT INTO `wp_city` VALUES (370725, '昌乐县', '', '山东省,潍坊市,昌乐县', 370700, 3, 0, '118.836327,36.713019', 0);
INSERT INTO `wp_city` VALUES (370781, '青州市', '', '山东省,潍坊市,青州市', 370700, 3, 0, '118.486195,36.690382', 0);
INSERT INTO `wp_city` VALUES (370782, '诸城市', '', '山东省,潍坊市,诸城市', 370700, 3, 0, '119.416232,36.00214', 0);
INSERT INTO `wp_city` VALUES (370783, '寿光市', '', '山东省,潍坊市,寿光市', 370700, 3, 0, '118.797395,36.861732', 0);
INSERT INTO `wp_city` VALUES (370784, '安丘市', '', '山东省,潍坊市,安丘市', 370700, 3, 0, '119.224447,36.484064', 0);
INSERT INTO `wp_city` VALUES (370785, '高密市', '', '山东省,潍坊市,高密市', 370700, 3, 0, '119.762091,36.388925', 0);
INSERT INTO `wp_city` VALUES (370786, '昌邑市', '', '山东省,潍坊市,昌邑市', 370700, 3, 0, '119.405026,36.865202', 0);
INSERT INTO `wp_city` VALUES (370801, '市辖区', '', '山东省,济宁市,市辖区', 370800, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (370802, '市中区', '', '山东省,济宁市,市中区', 370800, 3, 0, '116.59834,35.410529', 0);
INSERT INTO `wp_city` VALUES (370811, '任城区', '', '山东省,济宁市,任城区', 370800, 3, 0, '116.603067,35.413975', 0);
INSERT INTO `wp_city` VALUES (370826, '微山县', '', '山东省,济宁市,微山县', 370800, 3, 0, '117.135274,34.813496', 0);
INSERT INTO `wp_city` VALUES (370827, '鱼台县', '', '山东省,济宁市,鱼台县', 370800, 3, 0, '116.656851,35.017903', 0);
INSERT INTO `wp_city` VALUES (370828, '金乡县', '', '山东省,济宁市,金乡县', 370800, 3, 0, '116.318007,35.072589', 0);
INSERT INTO `wp_city` VALUES (370829, '嘉祥县', '', '山东省,济宁市,嘉祥县', 370800, 3, 0, '116.349103,35.413156', 0);
INSERT INTO `wp_city` VALUES (370830, '汶上县', '', '山东省,济宁市,汶上县', 370800, 3, 0, '116.495656,35.738789', 0);
INSERT INTO `wp_city` VALUES (370831, '泗水县', '', '山东省,济宁市,泗水县', 370800, 3, 0, '117.258592,35.670998', 0);
INSERT INTO `wp_city` VALUES (370832, '梁山县', '', '山东省,济宁市,梁山县', 370800, 3, 0, '116.10246,35.808064', 0);
INSERT INTO `wp_city` VALUES (370881, '曲阜市', '', '山东省,济宁市,曲阜市', 370800, 3, 0, '116.992898,35.587086', 0);
INSERT INTO `wp_city` VALUES (370882, '兖州市', '', '山东省,济宁市,兖州市', 370800, 3, 0, '116.754139,35.574016', 0);
INSERT INTO `wp_city` VALUES (370883, '邹城市', '', '山东省,济宁市,邹城市', 370800, 3, 0, '117.010251,35.411565', 0);
INSERT INTO `wp_city` VALUES (370901, '市辖区', '', '山东省,泰安市,市辖区', 370900, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (370902, '泰山区', '', '山东省,泰安市,泰山区', 370900, 3, 0, '117.141673,36.198221', 0);
INSERT INTO `wp_city` VALUES (370903, '岱岳区', '', '山东省,泰安市,岱岳区', 370900, 3, 0, '117.048356,36.193314', 0);
INSERT INTO `wp_city` VALUES (370921, '宁阳县', '', '山东省,泰安市,宁阳县', 370900, 3, 0, '116.813854,35.765334', 0);
INSERT INTO `wp_city` VALUES (370923, '东平县', '', '山东省,泰安市,东平县', 370900, 3, 0, '116.476836,35.94278', 0);
INSERT INTO `wp_city` VALUES (370982, '新泰市', '', '山东省,泰安市,新泰市', 370900, 3, 0, '117.774606,35.9145', 0);
INSERT INTO `wp_city` VALUES (370983, '肥城市', '', '山东省,泰安市,肥城市', 370900, 3, 0, '116.775571,36.18876', 0);
INSERT INTO `wp_city` VALUES (371001, '市辖区', '', '山东省,威海市,市辖区', 371000, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371002, '环翠区', '', '山东省,威海市,环翠区', 371000, 3, 0, '122.130016,37.507997', 0);
INSERT INTO `wp_city` VALUES (371081, '文登市', '', '山东省,威海市,文登市', 371000, 3, 0, '122.010782,37.15412', 0);
INSERT INTO `wp_city` VALUES (371082, '荣成市', '', '山东省,威海市,荣成市', 371000, 3, 0, '122.492783,37.171153', 0);
INSERT INTO `wp_city` VALUES (371083, '乳山市', '', '山东省,威海市,乳山市', 371000, 3, 0, '121.546627,36.92639', 0);
INSERT INTO `wp_city` VALUES (371101, '市辖区', '', '山东省,日照市,市辖区', 371100, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371102, '东港区', '', '山东省,日照市,东港区', 371100, 3, 0, '119.469044,35.4311', 0);
INSERT INTO `wp_city` VALUES (371103, '岚山区', '', '山东省,日照市,岚山区', 371100, 3, 0, '119.32544,35.127894', 0);
INSERT INTO `wp_city` VALUES (371121, '五莲县', '', '山东省,日照市,五莲县', 371100, 3, 0, '119.21533,35.75588', 0);
INSERT INTO `wp_city` VALUES (371122, '莒　县', '', '山东省,日照市,莒　县', 371100, 3, 0, '118.843408,35.585844', 0);
INSERT INTO `wp_city` VALUES (371201, '市辖区', '', '山东省,莱芜市,市辖区', 371200, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371202, '莱城区', '', '山东省,莱芜市,莱城区', 371200, 3, 0, '117.666511,36.208811', 0);
INSERT INTO `wp_city` VALUES (371203, '钢城区', '', '山东省,莱芜市,钢城区', 371200, 3, 0, '117.817565,36.06468', 0);
INSERT INTO `wp_city` VALUES (371301, '市辖区', '', '山东省,临沂市,市辖区', 371300, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371302, '兰山区', '', '山东省,临沂市,兰山区', 371300, 3, 0, '118.354369,35.057553', 0);
INSERT INTO `wp_city` VALUES (371311, '罗庄区', '', '山东省,临沂市,罗庄区', 371300, 3, 0, '118.290886,35.002253', 0);
INSERT INTO `wp_city` VALUES (371312, '河东区', '', '山东省,临沂市,河东区', 371300, 3, 0, '118.408395,35.093146', 0);
INSERT INTO `wp_city` VALUES (371321, '沂南县', '', '山东省,临沂市,沂南县', 371300, 3, 0, '118.472155,35.556096', 0);
INSERT INTO `wp_city` VALUES (371322, '郯城县', '', '山东省,临沂市,郯城县', 371300, 3, 0, '118.373758,34.619294', 0);
INSERT INTO `wp_city` VALUES (371323, '沂水县', '', '山东省,临沂市,沂水县', 371300, 3, 0, '118.634438,35.796019', 0);
INSERT INTO `wp_city` VALUES (371324, '苍山县', '', '山东省,临沂市,苍山县', 371300, 3, 0, '117.998342,34.865344', 0);
INSERT INTO `wp_city` VALUES (371325, '费　县', '', '山东省,临沂市,费　县', 371300, 3, 0, '117.983531,35.272807', 0);
INSERT INTO `wp_city` VALUES (371326, '平邑县', '', '山东省,临沂市,平邑县', 371300, 3, 0, '117.647023,35.511682', 0);
INSERT INTO `wp_city` VALUES (371327, '莒南县', '', '山东省,临沂市,莒南县', 371300, 3, 0, '118.841973,35.180764', 0);
INSERT INTO `wp_city` VALUES (371328, '蒙阴县', '', '山东省,临沂市,蒙阴县', 371300, 3, 0, '117.951355,35.716346', 0);
INSERT INTO `wp_city` VALUES (371329, '临沭县', '', '山东省,临沂市,临沭县', 371300, 3, 0, '118.657126,34.925862', 0);
INSERT INTO `wp_city` VALUES (371401, '市辖区', '', '山东省,德州市,市辖区', 371400, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371402, '德城区', '', '山东省,德州市,德城区', 371400, 3, 0, '116.305861,37.456977', 0);
INSERT INTO `wp_city` VALUES (371421, '陵　县', '', '山东省,德州市,陵　县', 371400, 3, 0, '116.66506,37.417105', 0);
INSERT INTO `wp_city` VALUES (371422, '宁津县', '', '山东省,德州市,宁津县', 371400, 3, 0, '116.806769,37.658025', 0);
INSERT INTO `wp_city` VALUES (371423, '庆云县', '', '山东省,德州市,庆云县', 371400, 3, 0, '117.391422,37.781366', 0);
INSERT INTO `wp_city` VALUES (371424, '临邑县', '', '山东省,德州市,临邑县', 371400, 3, 0, '116.873005,37.196245', 0);
INSERT INTO `wp_city` VALUES (371425, '齐河县', '', '山东省,德州市,齐河县', 371400, 3, 0, '116.766396,36.801266', 0);
INSERT INTO `wp_city` VALUES (371426, '平原县', '', '山东省,德州市,平原县', 371400, 3, 0, '116.440454,37.171302', 0);
INSERT INTO `wp_city` VALUES (371427, '夏津县', '', '山东省,德州市,夏津县', 371400, 3, 0, '116.008286,36.954411', 0);
INSERT INTO `wp_city` VALUES (371428, '武城县', '', '山东省,德州市,武城县', 371400, 3, 0, '116.075738,37.219188', 0);
INSERT INTO `wp_city` VALUES (371481, '乐陵市', '', '山东省,德州市,乐陵市', 371400, 3, 0, '117.238117,37.736112', 0);
INSERT INTO `wp_city` VALUES (371482, '禹城市', '', '山东省,德州市,禹城市', 371400, 3, 0, '116.644501,36.940282', 0);
INSERT INTO `wp_city` VALUES (371501, '市辖区', '', '山东省,聊城市,市辖区', 371500, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371502, '东昌府区', '', '山东省,聊城市,东昌府区', 371500, 3, 0, '115.995056,36.440201', 0);
INSERT INTO `wp_city` VALUES (371521, '阳谷县', '', '山东省,聊城市,阳谷县', 371500, 3, 0, '115.797707,36.12078', 0);
INSERT INTO `wp_city` VALUES (371522, '莘　县', '', '山东省,聊城市,莘　县', 371500, 3, 0, '115.677118,36.239915', 0);
INSERT INTO `wp_city` VALUES (371523, '茌平县', '', '山东省,聊城市,茌平县', 371500, 3, 0, '116.261674,36.586769', 0);
INSERT INTO `wp_city` VALUES (371524, '东阿县', '', '山东省,聊城市,东阿县', 371500, 3, 0, '116.254224,36.340983', 0);
INSERT INTO `wp_city` VALUES (371525, '冠　县', '', '山东省,聊城市,冠　县', 371500, 3, 0, '115.449025,36.489694', 0);
INSERT INTO `wp_city` VALUES (371526, '高唐县', '', '山东省,聊城市,高唐县', 371500, 3, 0, '116.237721,36.871735', 0);
INSERT INTO `wp_city` VALUES (371581, '临清市', '', '山东省,聊城市,临清市', 371500, 3, 0, '115.71151,36.844429', 0);
INSERT INTO `wp_city` VALUES (371601, '市辖区', '', '山东省,滨州市,市辖区', 371600, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371602, '滨城区', '', '山东省,滨州市,滨城区', 371600, 3, 0, '118.029389,37.432906', 0);
INSERT INTO `wp_city` VALUES (371621, '惠民县', '', '山东省,滨州市,惠民县', 371600, 3, 0, '117.515705,37.495838', 0);
INSERT INTO `wp_city` VALUES (371622, '阳信县', '', '山东省,滨州市,阳信县', 371600, 3, 0, '117.584636,37.647231', 0);
INSERT INTO `wp_city` VALUES (371623, '无棣县', '', '山东省,滨州市,无棣县', 371600, 3, 0, '117.632226,37.776001', 0);
INSERT INTO `wp_city` VALUES (371624, '沾化县', '', '山东省,滨州市,沾化县', 371600, 3, 0, '118.090098,37.787251', 0);
INSERT INTO `wp_city` VALUES (371625, '博兴县', '', '山东省,滨州市,博兴县', 371600, 3, 0, '118.117454,37.158968', 0);
INSERT INTO `wp_city` VALUES (371626, '邹平县', '', '山东省,滨州市,邹平县', 371600, 3, 0, '117.749569,36.869121', 0);
INSERT INTO `wp_city` VALUES (371701, '市辖区', '', '山东省,荷泽市,市辖区', 371700, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371702, '牡丹区', '', '山东省,荷泽市,牡丹区', 371700, 3, 0, '115.423105,35.257522', 0);
INSERT INTO `wp_city` VALUES (371721, '曹　县', '', '山东省,荷泽市,曹　县', 371700, 3, 0, '115.548597,34.831741', 0);
INSERT INTO `wp_city` VALUES (371722, '单　县', '', '山东省,荷泽市,单　县', 371700, 3, 0, '116.093816,34.800105', 0);
INSERT INTO `wp_city` VALUES (371723, '成武县', '', '山东省,荷泽市,成武县', 371700, 3, 0, '115.896161,34.958449', 0);
INSERT INTO `wp_city` VALUES (371724, '巨野县', '', '山东省,荷泽市,巨野县', 371700, 3, 0, '116.101549,35.401993', 0);
INSERT INTO `wp_city` VALUES (371725, '郓城县', '', '山东省,荷泽市,郓城县', 371700, 3, 0, '115.950089,35.605949', 0);
INSERT INTO `wp_city` VALUES (371726, '鄄城县', '', '山东省,荷泽市,鄄城县', 371700, 3, 0, '115.516657,35.569205', 0);
INSERT INTO `wp_city` VALUES (371727, '定陶县', '', '山东省,荷泽市,定陶县', 371700, 3, 0, '115.579417,35.077225', 0);
INSERT INTO `wp_city` VALUES (371728, '东明县', '', '山东省,荷泽市,东明县', 371700, 3, 0, '115.096578,35.29583', 0);
INSERT INTO `wp_city` VALUES (410101, '市辖区', '', '河南省,郑州市,市辖区', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410102, '中原区', '', '河南省,郑州市,中原区', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410103, '二七区', '', '河南省,郑州市,二七区', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410104, '管城回族区', '', '河南省,郑州市,管城回族区', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410105, '金水区', '', '河南省,郑州市,金水区', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410106, '上街区', '', '河南省,郑州市,上街区', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410108, '邙山区', '', '河南省,郑州市,邙山区', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410122, '中牟县', '', '河南省,郑州市,中牟县', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410181, '巩义市', '', '河南省,郑州市,巩义市', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410182, '荥阳市', '', '河南省,郑州市,荥阳市', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410183, '新密市', '', '河南省,郑州市,新密市', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410184, '新郑市', '', '河南省,郑州市,新郑市', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410185, '登封市', '', '河南省,郑州市,登封市', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410201, '市辖区', '', '河南省,开封市,市辖区', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410202, '龙亭区', '', '河南省,开封市,龙亭区', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410203, '顺河回族区', '', '河南省,开封市,顺河回族区', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410204, '鼓楼区', '', '河南省,开封市,鼓楼区', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410205, '南关区', '', '河南省,开封市,南关区', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410211, '郊　区', '', '河南省,开封市,郊　区', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410221, '杞　县', '', '河南省,开封市,杞　县', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410222, '通许县', '', '河南省,开封市,通许县', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410223, '尉氏县', '', '河南省,开封市,尉氏县', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410224, '开封县', '', '河南省,开封市,开封县', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410225, '兰考县', '', '河南省,开封市,兰考县', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410301, '市辖区', '', '河南省,洛阳市,市辖区', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410302, '老城区', '', '河南省,洛阳市,老城区', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410303, '西工区', '', '河南省,洛阳市,西工区', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410304, '廛河回族区', '', '河南省,洛阳市,廛河回族区', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410305, '涧西区', '', '河南省,洛阳市,涧西区', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410306, '吉利区', '', '河南省,洛阳市,吉利区', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410307, '洛龙区', '', '河南省,洛阳市,洛龙区', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410322, '孟津县', '', '河南省,洛阳市,孟津县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410323, '新安县', '', '河南省,洛阳市,新安县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410324, '栾川县', '', '河南省,洛阳市,栾川县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410325, '嵩　县', '', '河南省,洛阳市,嵩　县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410326, '汝阳县', '', '河南省,洛阳市,汝阳县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410327, '宜阳县', '', '河南省,洛阳市,宜阳县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410328, '洛宁县', '', '河南省,洛阳市,洛宁县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410329, '伊川县', '', '河南省,洛阳市,伊川县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410381, '偃师市', '', '河南省,洛阳市,偃师市', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410401, '市辖区', '', '河南省,平顶山市,市辖区', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410402, '新华区', '', '河南省,平顶山市,新华区', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410403, '卫东区', '', '河南省,平顶山市,卫东区', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410404, '石龙区', '', '河南省,平顶山市,石龙区', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410411, '湛河区', '', '河南省,平顶山市,湛河区', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410421, '宝丰县', '', '河南省,平顶山市,宝丰县', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410422, '叶　县', '', '河南省,平顶山市,叶　县', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410423, '鲁山县', '', '河南省,平顶山市,鲁山县', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410425, '郏　县', '', '河南省,平顶山市,郏　县', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410481, '舞钢市', '', '河南省,平顶山市,舞钢市', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410482, '汝州市', '', '河南省,平顶山市,汝州市', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410501, '市辖区', '', '河南省,安阳市,市辖区', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410502, '文峰区', '', '河南省,安阳市,文峰区', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410503, '北关区', '', '河南省,安阳市,北关区', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410505, '殷都区', '', '河南省,安阳市,殷都区', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410506, '龙安区', '', '河南省,安阳市,龙安区', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410522, '安阳县', '', '河南省,安阳市,安阳县', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410523, '汤阴县', '', '河南省,安阳市,汤阴县', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410526, '滑　县', '', '河南省,安阳市,滑　县', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410527, '内黄县', '', '河南省,安阳市,内黄县', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410581, '林州市', '', '河南省,安阳市,林州市', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410601, '市辖区', '', '河南省,鹤壁市,市辖区', 410600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410602, '鹤山区', '', '河南省,鹤壁市,鹤山区', 410600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410603, '山城区', '', '河南省,鹤壁市,山城区', 410600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410611, '淇滨区', '', '河南省,鹤壁市,淇滨区', 410600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410621, '浚　县', '', '河南省,鹤壁市,浚　县', 410600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410622, '淇　县', '', '河南省,鹤壁市,淇　县', 410600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410701, '市辖区', '', '河南省,新乡市,市辖区', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410702, '红旗区', '', '河南省,新乡市,红旗区', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410703, '卫滨区', '', '河南省,新乡市,卫滨区', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410704, '凤泉区', '', '河南省,新乡市,凤泉区', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410711, '牧野区', '', '河南省,新乡市,牧野区', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410721, '新乡县', '', '河南省,新乡市,新乡县', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410724, '获嘉县', '', '河南省,新乡市,获嘉县', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410725, '原阳县', '', '河南省,新乡市,原阳县', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410726, '延津县', '', '河南省,新乡市,延津县', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410727, '封丘县', '', '河南省,新乡市,封丘县', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410728, '长垣县', '', '河南省,新乡市,长垣县', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410781, '卫辉市', '', '河南省,新乡市,卫辉市', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410782, '辉县市', '', '河南省,新乡市,辉县市', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410801, '市辖区', '', '河南省,焦作市,市辖区', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410802, '解放区', '', '河南省,焦作市,解放区', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410803, '中站区', '', '河南省,焦作市,中站区', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410804, '马村区', '', '河南省,焦作市,马村区', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410811, '山阳区', '', '河南省,焦作市,山阳区', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410821, '修武县', '', '河南省,焦作市,修武县', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410822, '博爱县', '', '河南省,焦作市,博爱县', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410823, '武陟县', '', '河南省,焦作市,武陟县', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410825, '温　县', '', '河南省,焦作市,温　县', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410881, '济源市', '', '河南省,焦作市,济源市', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410882, '沁阳市', '', '河南省,焦作市,沁阳市', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410883, '孟州市', '', '河南省,焦作市,孟州市', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410901, '市辖区', '', '河南省,濮阳市,市辖区', 410900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410902, '华龙区', '', '河南省,濮阳市,华龙区', 410900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410922, '清丰县', '', '河南省,濮阳市,清丰县', 410900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410923, '南乐县', '', '河南省,濮阳市,南乐县', 410900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410926, '范　县', '', '河南省,濮阳市,范　县', 410900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410927, '台前县', '', '河南省,濮阳市,台前县', 410900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410928, '濮阳县', '', '河南省,濮阳市,濮阳县', 410900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411001, '市辖区', '', '河南省,许昌市,市辖区', 411000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411002, '魏都区', '', '河南省,许昌市,魏都区', 411000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411023, '许昌县', '', '河南省,许昌市,许昌县', 411000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411024, '鄢陵县', '', '河南省,许昌市,鄢陵县', 411000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411025, '襄城县', '', '河南省,许昌市,襄城县', 411000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411081, '禹州市', '', '河南省,许昌市,禹州市', 411000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411082, '长葛市', '', '河南省,许昌市,长葛市', 411000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411101, '市辖区', '', '河南省,漯河市,市辖区', 411100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411102, '源汇区', '', '河南省,漯河市,源汇区', 411100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411103, '郾城区', '', '河南省,漯河市,郾城区', 411100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411104, '召陵区', '', '河南省,漯河市,召陵区', 411100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411121, '舞阳县', '', '河南省,漯河市,舞阳县', 411100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411122, '临颍县', '', '河南省,漯河市,临颍县', 411100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411201, '市辖区', '', '河南省,三门峡市,市辖区', 411200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411202, '湖滨区', '', '河南省,三门峡市,湖滨区', 411200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411221, '渑池县', '', '河南省,三门峡市,渑池县', 411200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411222, '陕　县', '', '河南省,三门峡市,陕　县', 411200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411224, '卢氏县', '', '河南省,三门峡市,卢氏县', 411200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411281, '义马市', '', '河南省,三门峡市,义马市', 411200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411282, '灵宝市', '', '河南省,三门峡市,灵宝市', 411200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411301, '市辖区', '', '河南省,南阳市,市辖区', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411302, '宛城区', '', '河南省,南阳市,宛城区', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411303, '卧龙区', '', '河南省,南阳市,卧龙区', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411321, '南召县', '', '河南省,南阳市,南召县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411322, '方城县', '', '河南省,南阳市,方城县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411323, '西峡县', '', '河南省,南阳市,西峡县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411324, '镇平县', '', '河南省,南阳市,镇平县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411325, '内乡县', '', '河南省,南阳市,内乡县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411326, '淅川县', '', '河南省,南阳市,淅川县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411327, '社旗县', '', '河南省,南阳市,社旗县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411328, '唐河县', '', '河南省,南阳市,唐河县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411329, '新野县', '', '河南省,南阳市,新野县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411330, '桐柏县', '', '河南省,南阳市,桐柏县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411381, '邓州市', '', '河南省,南阳市,邓州市', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411401, '市辖区', '', '河南省,商丘市,市辖区', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411402, '梁园区', '', '河南省,商丘市,梁园区', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411403, '睢阳区', '', '河南省,商丘市,睢阳区', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411421, '民权县', '', '河南省,商丘市,民权县', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411422, '睢　县', '', '河南省,商丘市,睢　县', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411423, '宁陵县', '', '河南省,商丘市,宁陵县', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411424, '柘城县', '', '河南省,商丘市,柘城县', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411425, '虞城县', '', '河南省,商丘市,虞城县', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411426, '夏邑县', '', '河南省,商丘市,夏邑县', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411481, '永城市', '', '河南省,商丘市,永城市', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411501, '市辖区', '', '河南省,信阳市,市辖区', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411502, '师河区', '', '河南省,信阳市,师河区', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411503, '平桥区', '', '河南省,信阳市,平桥区', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411521, '罗山县', '', '河南省,信阳市,罗山县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411522, '光山县', '', '河南省,信阳市,光山县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411523, '新　县', '', '河南省,信阳市,新　县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411524, '商城县', '', '河南省,信阳市,商城县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411525, '固始县', '', '河南省,信阳市,固始县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411526, '潢川县', '', '河南省,信阳市,潢川县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411527, '淮滨县', '', '河南省,信阳市,淮滨县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411528, '息　县', '', '河南省,信阳市,息　县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411601, '市辖区', '', '河南省,周口市,市辖区', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411602, '川汇区', '', '河南省,周口市,川汇区', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411621, '扶沟县', '', '河南省,周口市,扶沟县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411622, '西华县', '', '河南省,周口市,西华县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411623, '商水县', '', '河南省,周口市,商水县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411624, '沈丘县', '', '河南省,周口市,沈丘县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411625, '郸城县', '', '河南省,周口市,郸城县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411626, '淮阳县', '', '河南省,周口市,淮阳县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411627, '太康县', '', '河南省,周口市,太康县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411628, '鹿邑县', '', '河南省,周口市,鹿邑县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411681, '项城市', '', '河南省,周口市,项城市', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411701, '市辖区', '', '河南省,驻马店市,市辖区', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411702, '驿城区', '', '河南省,驻马店市,驿城区', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411721, '西平县', '', '河南省,驻马店市,西平县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411722, '上蔡县', '', '河南省,驻马店市,上蔡县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411723, '平舆县', '', '河南省,驻马店市,平舆县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411724, '正阳县', '', '河南省,驻马店市,正阳县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411725, '确山县', '', '河南省,驻马店市,确山县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411726, '泌阳县', '', '河南省,驻马店市,泌阳县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411727, '汝南县', '', '河南省,驻马店市,汝南县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411728, '遂平县', '', '河南省,驻马店市,遂平县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411729, '新蔡县', '', '河南省,驻马店市,新蔡县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420101, '市辖区', '', '湖北省,武汉市,市辖区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420102, '江岸区', '', '湖北省,武汉市,江岸区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420103, '江汉区', '', '湖北省,武汉市,江汉区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420104, '乔口区', '', '湖北省,武汉市,乔口区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420105, '汉阳区', '', '湖北省,武汉市,汉阳区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420106, '武昌区', '', '湖北省,武汉市,武昌区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420107, '青山区', '', '湖北省,武汉市,青山区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420111, '洪山区', '', '湖北省,武汉市,洪山区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420112, '东西湖区', '', '湖北省,武汉市,东西湖区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420113, '汉南区', '', '湖北省,武汉市,汉南区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420114, '蔡甸区', '', '湖北省,武汉市,蔡甸区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420115, '江夏区', '', '湖北省,武汉市,江夏区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420116, '黄陂区', '', '湖北省,武汉市,黄陂区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420117, '新洲区', '', '湖北省,武汉市,新洲区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420201, '市辖区', '', '湖北省,黄石市,市辖区', 420200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420202, '黄石港区', '', '湖北省,黄石市,黄石港区', 420200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420203, '西塞山区', '', '湖北省,黄石市,西塞山区', 420200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420204, '下陆区', '', '湖北省,黄石市,下陆区', 420200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420205, '铁山区', '', '湖北省,黄石市,铁山区', 420200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420222, '阳新县', '', '湖北省,黄石市,阳新县', 420200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420281, '大冶市', '', '湖北省,黄石市,大冶市', 420200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420301, '市辖区', '', '湖北省,十堰市,市辖区', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420302, '茅箭区', '', '湖北省,十堰市,茅箭区', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420303, '张湾区', '', '湖北省,十堰市,张湾区', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420321, '郧　县', '', '湖北省,十堰市,郧　县', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420322, '郧西县', '', '湖北省,十堰市,郧西县', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420323, '竹山县', '', '湖北省,十堰市,竹山县', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420324, '竹溪县', '', '湖北省,十堰市,竹溪县', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420325, '房　县', '', '湖北省,十堰市,房　县', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420381, '丹江口市', '', '湖北省,十堰市,丹江口市', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420501, '市辖区', '', '湖北省,宜昌市,市辖区', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420502, '西陵区', '', '湖北省,宜昌市,西陵区', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420503, '伍家岗区', '', '湖北省,宜昌市,伍家岗区', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420504, '点军区', '', '湖北省,宜昌市,点军区', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420505, '猇亭区', '', '湖北省,宜昌市,猇亭区', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420506, '夷陵区', '', '湖北省,宜昌市,夷陵区', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420525, '远安县', '', '湖北省,宜昌市,远安县', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420526, '兴山县', '', '湖北省,宜昌市,兴山县', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420527, '秭归县', '', '湖北省,宜昌市,秭归县', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420528, '长阳土家族自治县', '', '湖北省,宜昌市,长阳土家族自治县', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420529, '五峰土家族自治县', '', '湖北省,宜昌市,五峰土家族自治县', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420581, '宜都市', '', '湖北省,宜昌市,宜都市', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420582, '当阳市', '', '湖北省,宜昌市,当阳市', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420583, '枝江市', '', '湖北省,宜昌市,枝江市', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420601, '市辖区', '', '湖北省,襄樊市,市辖区', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420602, '襄城区', '', '湖北省,襄樊市,襄城区', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420606, '樊城区', '', '湖北省,襄樊市,樊城区', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420607, '襄阳区', '', '湖北省,襄樊市,襄阳区', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420624, '南漳县', '', '湖北省,襄樊市,南漳县', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420625, '谷城县', '', '湖北省,襄樊市,谷城县', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420626, '保康县', '', '湖北省,襄樊市,保康县', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420682, '老河口市', '', '湖北省,襄樊市,老河口市', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420683, '枣阳市', '', '湖北省,襄樊市,枣阳市', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420684, '宜城市', '', '湖北省,襄樊市,宜城市', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420701, '市辖区', '', '湖北省,鄂州市,市辖区', 420700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420702, '梁子湖区', '', '湖北省,鄂州市,梁子湖区', 420700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420703, '华容区', '', '湖北省,鄂州市,华容区', 420700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420704, '鄂城区', '', '湖北省,鄂州市,鄂城区', 420700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420801, '市辖区', '', '湖北省,荆门市,市辖区', 420800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420802, '东宝区', '', '湖北省,荆门市,东宝区', 420800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420804, '掇刀区', '', '湖北省,荆门市,掇刀区', 420800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420821, '京山县', '', '湖北省,荆门市,京山县', 420800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420822, '沙洋县', '', '湖北省,荆门市,沙洋县', 420800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420881, '钟祥市', '', '湖北省,荆门市,钟祥市', 420800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420901, '市辖区', '', '湖北省,孝感市,市辖区', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420902, '孝南区', '', '湖北省,孝感市,孝南区', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420921, '孝昌县', '', '湖北省,孝感市,孝昌县', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420922, '大悟县', '', '湖北省,孝感市,大悟县', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420923, '云梦县', '', '湖北省,孝感市,云梦县', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420981, '应城市', '', '湖北省,孝感市,应城市', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420982, '安陆市', '', '湖北省,孝感市,安陆市', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420984, '汉川市', '', '湖北省,孝感市,汉川市', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421001, '市辖区', '', '湖北省,荆州市,市辖区', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421002, '沙市区', '', '湖北省,荆州市,沙市区', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421003, '荆州区', '', '湖北省,荆州市,荆州区', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421022, '公安县', '', '湖北省,荆州市,公安县', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421023, '监利县', '', '湖北省,荆州市,监利县', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421024, '江陵县', '', '湖北省,荆州市,江陵县', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421081, '石首市', '', '湖北省,荆州市,石首市', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421083, '洪湖市', '', '湖北省,荆州市,洪湖市', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421087, '松滋市', '', '湖北省,荆州市,松滋市', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421101, '市辖区', '', '湖北省,黄冈市,市辖区', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421102, '黄州区', '', '湖北省,黄冈市,黄州区', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421121, '团风县', '', '湖北省,黄冈市,团风县', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421122, '红安县', '', '湖北省,黄冈市,红安县', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421123, '罗田县', '', '湖北省,黄冈市,罗田县', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421124, '英山县', '', '湖北省,黄冈市,英山县', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421125, '浠水县', '', '湖北省,黄冈市,浠水县', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421126, '蕲春县', '', '湖北省,黄冈市,蕲春县', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421127, '黄梅县', '', '湖北省,黄冈市,黄梅县', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421181, '麻城市', '', '湖北省,黄冈市,麻城市', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421182, '武穴市', '', '湖北省,黄冈市,武穴市', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421201, '市辖区', '', '湖北省,咸宁市,市辖区', 421200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421202, '咸安区', '', '湖北省,咸宁市,咸安区', 421200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421221, '嘉鱼县', '', '湖北省,咸宁市,嘉鱼县', 421200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421222, '通城县', '', '湖北省,咸宁市,通城县', 421200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421223, '崇阳县', '', '湖北省,咸宁市,崇阳县', 421200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421224, '通山县', '', '湖北省,咸宁市,通山县', 421200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421281, '赤壁市', '', '湖北省,咸宁市,赤壁市', 421200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421301, '市辖区', '', '湖北省,随州市,市辖区', 421300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421302, '曾都区', '', '湖北省,随州市,曾都区', 421300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421381, '广水市', '', '湖北省,随州市,广水市', 421300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422801, '恩施市', '', '湖北省,恩施土家族苗族自治州,恩施市', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422802, '利川市', '', '湖北省,恩施土家族苗族自治州,利川市', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422822, '建始县', '', '湖北省,恩施土家族苗族自治州,建始县', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422823, '巴东县', '', '湖北省,恩施土家族苗族自治州,巴东县', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422825, '宣恩县', '', '湖北省,恩施土家族苗族自治州,宣恩县', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422826, '咸丰县', '', '湖北省,恩施土家族苗族自治州,咸丰县', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422827, '来凤县', '', '湖北省,恩施土家族苗族自治州,来凤县', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422828, '鹤峰县', '', '湖北省,恩施土家族苗族自治州,鹤峰县', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (429004, '仙桃市', '', '湖北省,省直辖行政单位,仙桃市', 429000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (429005, '潜江市', '', '湖北省,省直辖行政单位,潜江市', 429000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (429006, '天门市', '', '湖北省,省直辖行政单位,天门市', 429000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (429021, '神农架林区', '', '湖北省,省直辖行政单位,神农架林区', 429000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430101, '市辖区', '', '湖南省,长沙市,市辖区', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430102, '芙蓉区', '', '湖南省,长沙市,芙蓉区', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430103, '天心区', '', '湖南省,长沙市,天心区', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430104, '岳麓区', '', '湖南省,长沙市,岳麓区', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430105, '开福区', '', '湖南省,长沙市,开福区', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430111, '雨花区', '', '湖南省,长沙市,雨花区', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430121, '长沙县', '', '湖南省,长沙市,长沙县', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430122, '望城县', '', '湖南省,长沙市,望城县', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430124, '宁乡县', '', '湖南省,长沙市,宁乡县', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430181, '浏阳市', '', '湖南省,长沙市,浏阳市', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430201, '市辖区', '', '湖南省,株洲市,市辖区', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430202, '荷塘区', '', '湖南省,株洲市,荷塘区', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430203, '芦淞区', '', '湖南省,株洲市,芦淞区', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430204, '石峰区', '', '湖南省,株洲市,石峰区', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430211, '天元区', '', '湖南省,株洲市,天元区', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430221, '株洲县', '', '湖南省,株洲市,株洲县', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430223, '攸　县', '', '湖南省,株洲市,攸　县', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430224, '茶陵县', '', '湖南省,株洲市,茶陵县', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430225, '炎陵县', '', '湖南省,株洲市,炎陵县', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430281, '醴陵市', '', '湖南省,株洲市,醴陵市', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430301, '市辖区', '', '湖南省,湘潭市,市辖区', 430300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430302, '雨湖区', '', '湖南省,湘潭市,雨湖区', 430300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430304, '岳塘区', '', '湖南省,湘潭市,岳塘区', 430300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430321, '湘潭县', '', '湖南省,湘潭市,湘潭县', 430300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430381, '湘乡市', '', '湖南省,湘潭市,湘乡市', 430300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430382, '韶山市', '', '湖南省,湘潭市,韶山市', 430300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430401, '市辖区', '', '湖南省,衡阳市,市辖区', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430405, '珠晖区', '', '湖南省,衡阳市,珠晖区', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430406, '雁峰区', '', '湖南省,衡阳市,雁峰区', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430407, '石鼓区', '', '湖南省,衡阳市,石鼓区', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430408, '蒸湘区', '', '湖南省,衡阳市,蒸湘区', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430412, '南岳区', '', '湖南省,衡阳市,南岳区', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430421, '衡阳县', '', '湖南省,衡阳市,衡阳县', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430422, '衡南县', '', '湖南省,衡阳市,衡南县', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430423, '衡山县', '', '湖南省,衡阳市,衡山县', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430424, '衡东县', '', '湖南省,衡阳市,衡东县', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430426, '祁东县', '', '湖南省,衡阳市,祁东县', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430481, '耒阳市', '', '湖南省,衡阳市,耒阳市', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430482, '常宁市', '', '湖南省,衡阳市,常宁市', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430501, '市辖区', '', '湖南省,邵阳市,市辖区', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430502, '双清区', '', '湖南省,邵阳市,双清区', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430503, '大祥区', '', '湖南省,邵阳市,大祥区', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430511, '北塔区', '', '湖南省,邵阳市,北塔区', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430521, '邵东县', '', '湖南省,邵阳市,邵东县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430522, '新邵县', '', '湖南省,邵阳市,新邵县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430523, '邵阳县', '', '湖南省,邵阳市,邵阳县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430524, '隆回县', '', '湖南省,邵阳市,隆回县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430525, '洞口县', '', '湖南省,邵阳市,洞口县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430527, '绥宁县', '', '湖南省,邵阳市,绥宁县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430528, '新宁县', '', '湖南省,邵阳市,新宁县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430529, '城步苗族自治县', '', '湖南省,邵阳市,城步苗族自治县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430581, '武冈市', '', '湖南省,邵阳市,武冈市', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430601, '市辖区', '', '湖南省,岳阳市,市辖区', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430602, '岳阳楼区', '', '湖南省,岳阳市,岳阳楼区', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430603, '云溪区', '', '湖南省,岳阳市,云溪区', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430611, '君山区', '', '湖南省,岳阳市,君山区', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430621, '岳阳县', '', '湖南省,岳阳市,岳阳县', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430623, '华容县', '', '湖南省,岳阳市,华容县', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430624, '湘阴县', '', '湖南省,岳阳市,湘阴县', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430626, '平江县', '', '湖南省,岳阳市,平江县', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430681, '汨罗市', '', '湖南省,岳阳市,汨罗市', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430682, '临湘市', '', '湖南省,岳阳市,临湘市', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430701, '市辖区', '', '湖南省,常德市,市辖区', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430702, '武陵区', '', '湖南省,常德市,武陵区', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430703, '鼎城区', '', '湖南省,常德市,鼎城区', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430721, '安乡县', '', '湖南省,常德市,安乡县', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430722, '汉寿县', '', '湖南省,常德市,汉寿县', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430723, '澧　县', '', '湖南省,常德市,澧　县', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430724, '临澧县', '', '湖南省,常德市,临澧县', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430725, '桃源县', '', '湖南省,常德市,桃源县', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430726, '石门县', '', '湖南省,常德市,石门县', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430781, '津市市', '', '湖南省,常德市,津市市', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430801, '市辖区', '', '湖南省,张家界市,市辖区', 430800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430802, '永定区', '', '湖南省,张家界市,永定区', 430800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430811, '武陵源区', '', '湖南省,张家界市,武陵源区', 430800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430821, '慈利县', '', '湖南省,张家界市,慈利县', 430800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430822, '桑植县', '', '湖南省,张家界市,桑植县', 430800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430901, '市辖区', '', '湖南省,益阳市,市辖区', 430900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430902, '资阳区', '', '湖南省,益阳市,资阳区', 430900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430903, '赫山区', '', '湖南省,益阳市,赫山区', 430900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430921, '南　县', '', '湖南省,益阳市,南　县', 430900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430922, '桃江县', '', '湖南省,益阳市,桃江县', 430900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430923, '安化县', '', '湖南省,益阳市,安化县', 430900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430981, '沅江市', '', '湖南省,益阳市,沅江市', 430900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431001, '市辖区', '', '湖南省,郴州市,市辖区', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431002, '北湖区', '', '湖南省,郴州市,北湖区', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431003, '苏仙区', '', '湖南省,郴州市,苏仙区', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431021, '桂阳县', '', '湖南省,郴州市,桂阳县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431022, '宜章县', '', '湖南省,郴州市,宜章县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431023, '永兴县', '', '湖南省,郴州市,永兴县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431024, '嘉禾县', '', '湖南省,郴州市,嘉禾县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431025, '临武县', '', '湖南省,郴州市,临武县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431026, '汝城县', '', '湖南省,郴州市,汝城县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431027, '桂东县', '', '湖南省,郴州市,桂东县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431028, '安仁县', '', '湖南省,郴州市,安仁县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431081, '资兴市', '', '湖南省,郴州市,资兴市', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431101, '市辖区', '', '湖南省,永州市,市辖区', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431102, '芝山区', '', '湖南省,永州市,芝山区', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431103, '冷水滩区', '', '湖南省,永州市,冷水滩区', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431121, '祁阳县', '', '湖南省,永州市,祁阳县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431122, '东安县', '', '湖南省,永州市,东安县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431123, '双牌县', '', '湖南省,永州市,双牌县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431124, '道　县', '', '湖南省,永州市,道　县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431125, '江永县', '', '湖南省,永州市,江永县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431126, '宁远县', '', '湖南省,永州市,宁远县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431127, '蓝山县', '', '湖南省,永州市,蓝山县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431128, '新田县', '', '湖南省,永州市,新田县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431129, '江华瑶族自治县', '', '湖南省,永州市,江华瑶族自治县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431201, '市辖区', '', '湖南省,怀化市,市辖区', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431202, '鹤城区', '', '湖南省,怀化市,鹤城区', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431221, '中方县', '', '湖南省,怀化市,中方县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431222, '沅陵县', '', '湖南省,怀化市,沅陵县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431223, '辰溪县', '', '湖南省,怀化市,辰溪县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431224, '溆浦县', '', '湖南省,怀化市,溆浦县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431225, '会同县', '', '湖南省,怀化市,会同县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431226, '麻阳苗族自治县', '', '湖南省,怀化市,麻阳苗族自治县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431227, '新晃侗族自治县', '', '湖南省,怀化市,新晃侗族自治县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431228, '芷江侗族自治县', '', '湖南省,怀化市,芷江侗族自治县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431229, '靖州苗族侗族自治县', '', '湖南省,怀化市,靖州苗族侗族自治县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431230, '通道侗族自治县', '', '湖南省,怀化市,通道侗族自治县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431281, '洪江市', '', '湖南省,怀化市,洪江市', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431301, '市辖区', '', '湖南省,娄底市,市辖区', 431300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431302, '娄星区', '', '湖南省,娄底市,娄星区', 431300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431321, '双峰县', '', '湖南省,娄底市,双峰县', 431300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431322, '新化县', '', '湖南省,娄底市,新化县', 431300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431381, '冷水江市', '', '湖南省,娄底市,冷水江市', 431300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431382, '涟源市', '', '湖南省,娄底市,涟源市', 431300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433101, '吉首市', '', '湖南省,湘西土家族苗族自治州,吉首市', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433122, '泸溪县', '', '湖南省,湘西土家族苗族自治州,泸溪县', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433123, '凤凰县', '', '湖南省,湘西土家族苗族自治州,凤凰县', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433124, '花垣县', '', '湖南省,湘西土家族苗族自治州,花垣县', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433125, '保靖县', '', '湖南省,湘西土家族苗族自治州,保靖县', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433126, '古丈县', '', '湖南省,湘西土家族苗族自治州,古丈县', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433127, '永顺县', '', '湖南省,湘西土家族苗族自治州,永顺县', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433130, '龙山县', '', '湖南省,湘西土家族苗族自治州,龙山县', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440101, '市辖区', '', '广东省,广州市,市辖区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440102, '东山区', '', '广东省,广州市,东山区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440103, '荔湾区', '', '广东省,广州市,荔湾区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440104, '越秀区', '', '广东省,广州市,越秀区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440105, '海珠区', '', '广东省,广州市,海珠区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440106, '天河区', '', '广东省,广州市,天河区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440107, '芳村区', '', '广东省,广州市,芳村区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440111, '白云区', '', '广东省,广州市,白云区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440112, '黄埔区', '', '广东省,广州市,黄埔区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440113, '番禺区', '', '广东省,广州市,番禺区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440114, '花都区', '', '广东省,广州市,花都区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440183, '增城市', '', '广东省,广州市,增城市', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440184, '从化市', '', '广东省,广州市,从化市', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440201, '市辖区', '', '广东省,韶关市,市辖区', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440203, '武江区', '', '广东省,韶关市,武江区', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440204, '浈江区', '', '广东省,韶关市,浈江区', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440205, '曲江区', '', '广东省,韶关市,曲江区', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440222, '始兴县', '', '广东省,韶关市,始兴县', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440224, '仁化县', '', '广东省,韶关市,仁化县', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440229, '翁源县', '', '广东省,韶关市,翁源县', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440232, '乳源瑶族自治县', '', '广东省,韶关市,乳源瑶族自治县', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440233, '新丰县', '', '广东省,韶关市,新丰县', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440281, '乐昌市', '', '广东省,韶关市,乐昌市', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440282, '南雄市', '', '广东省,韶关市,南雄市', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440301, '市辖区', '', '广东省,深圳市,市辖区', 440300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440303, '罗湖区', '', '广东省,深圳市,罗湖区', 440300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440304, '福田区', '', '广东省,深圳市,福田区', 440300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440305, '南山区', '', '广东省,深圳市,南山区', 440300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440306, '宝安区', '', '广东省,深圳市,宝安区', 440300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440307, '龙岗区', '', '广东省,深圳市,龙岗区', 440300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440308, '盐田区', '', '广东省,深圳市,盐田区', 440300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440401, '市辖区', '', '广东省,珠海市,市辖区', 440400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440402, '香洲区', '', '广东省,珠海市,香洲区', 440400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440403, '斗门区', '', '广东省,珠海市,斗门区', 440400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440404, '金湾区', '', '广东省,珠海市,金湾区', 440400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440501, '市辖区', '', '广东省,汕头市,市辖区', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440507, '龙湖区', '', '广东省,汕头市,龙湖区', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440511, '金平区', '', '广东省,汕头市,金平区', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440512, '濠江区', '', '广东省,汕头市,濠江区', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440513, '潮阳区', '', '广东省,汕头市,潮阳区', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440514, '潮南区', '', '广东省,汕头市,潮南区', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440515, '澄海区', '', '广东省,汕头市,澄海区', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440523, '南澳县', '', '广东省,汕头市,南澳县', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440601, '市辖区', '', '广东省,佛山市,市辖区', 440600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440604, '禅城区', '', '广东省,佛山市,禅城区', 440600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440605, '南海区', '', '广东省,佛山市,南海区', 440600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440606, '顺德区', '', '广东省,佛山市,顺德区', 440600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440607, '三水区', '', '广东省,佛山市,三水区', 440600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440608, '高明区', '', '广东省,佛山市,高明区', 440600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440701, '市辖区', '', '广东省,江门市,市辖区', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440703, '蓬江区', '', '广东省,江门市,蓬江区', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440704, '江海区', '', '广东省,江门市,江海区', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440705, '新会区', '', '广东省,江门市,新会区', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440781, '台山市', '', '广东省,江门市,台山市', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440783, '开平市', '', '广东省,江门市,开平市', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440784, '鹤山市', '', '广东省,江门市,鹤山市', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440785, '恩平市', '', '广东省,江门市,恩平市', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440801, '市辖区', '', '广东省,湛江市,市辖区', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440802, '赤坎区', '', '广东省,湛江市,赤坎区', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440803, '霞山区', '', '广东省,湛江市,霞山区', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440804, '坡头区', '', '广东省,湛江市,坡头区', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440811, '麻章区', '', '广东省,湛江市,麻章区', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440823, '遂溪县', '', '广东省,湛江市,遂溪县', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440825, '徐闻县', '', '广东省,湛江市,徐闻县', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440881, '廉江市', '', '广东省,湛江市,廉江市', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440882, '雷州市', '', '广东省,湛江市,雷州市', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440883, '吴川市', '', '广东省,湛江市,吴川市', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440901, '市辖区', '', '广东省,茂名市,市辖区', 440900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440902, '茂南区', '', '广东省,茂名市,茂南区', 440900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440903, '茂港区', '', '广东省,茂名市,茂港区', 440900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440923, '电白县', '', '广东省,茂名市,电白县', 440900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440981, '高州市', '', '广东省,茂名市,高州市', 440900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440982, '化州市', '', '广东省,茂名市,化州市', 440900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440983, '信宜市', '', '广东省,茂名市,信宜市', 440900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441201, '市辖区', '', '广东省,肇庆市,市辖区', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441202, '端州区', '', '广东省,肇庆市,端州区', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441203, '鼎湖区', '', '广东省,肇庆市,鼎湖区', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441223, '广宁县', '', '广东省,肇庆市,广宁县', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441224, '怀集县', '', '广东省,肇庆市,怀集县', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441225, '封开县', '', '广东省,肇庆市,封开县', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441226, '德庆县', '', '广东省,肇庆市,德庆县', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441283, '高要市', '', '广东省,肇庆市,高要市', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441284, '四会市', '', '广东省,肇庆市,四会市', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441301, '市辖区', '', '广东省,惠州市,市辖区', 441300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441302, '惠城区', '', '广东省,惠州市,惠城区', 441300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441303, '惠阳区', '', '广东省,惠州市,惠阳区', 441300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441322, '博罗县', '', '广东省,惠州市,博罗县', 441300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441323, '惠东县', '', '广东省,惠州市,惠东县', 441300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441324, '龙门县', '', '广东省,惠州市,龙门县', 441300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441401, '市辖区', '', '广东省,梅州市,市辖区', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441402, '梅江区', '', '广东省,梅州市,梅江区', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441421, '梅　县', '', '广东省,梅州市,梅　县', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441422, '大埔县', '', '广东省,梅州市,大埔县', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441423, '丰顺县', '', '广东省,梅州市,丰顺县', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441424, '五华县', '', '广东省,梅州市,五华县', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441426, '平远县', '', '广东省,梅州市,平远县', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441427, '蕉岭县', '', '广东省,梅州市,蕉岭县', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441481, '兴宁市', '', '广东省,梅州市,兴宁市', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441501, '市辖区', '', '广东省,汕尾市,市辖区', 441500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441502, '城　区', '', '广东省,汕尾市,城　区', 441500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441521, '海丰县', '', '广东省,汕尾市,海丰县', 441500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441523, '陆河县', '', '广东省,汕尾市,陆河县', 441500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441581, '陆丰市', '', '广东省,汕尾市,陆丰市', 441500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441601, '市辖区', '', '广东省,河源市,市辖区', 441600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441602, '源城区', '', '广东省,河源市,源城区', 441600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441621, '紫金县', '', '广东省,河源市,紫金县', 441600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441622, '龙川县', '', '广东省,河源市,龙川县', 441600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441623, '连平县', '', '广东省,河源市,连平县', 441600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441624, '和平县', '', '广东省,河源市,和平县', 441600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441625, '东源县', '', '广东省,河源市,东源县', 441600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441701, '市辖区', '', '广东省,阳江市,市辖区', 441700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441702, '江城区', '', '广东省,阳江市,江城区', 441700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441721, '阳西县', '', '广东省,阳江市,阳西县', 441700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441723, '阳东县', '', '广东省,阳江市,阳东县', 441700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441781, '阳春市', '', '广东省,阳江市,阳春市', 441700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441801, '市辖区', '', '广东省,清远市,市辖区', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441802, '清城区', '', '广东省,清远市,清城区', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441821, '佛冈县', '', '广东省,清远市,佛冈县', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441823, '阳山县', '', '广东省,清远市,阳山县', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441825, '连山壮族瑶族自治县', '', '广东省,清远市,连山壮族瑶族自治县', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441826, '连南瑶族自治县', '', '广东省,清远市,连南瑶族自治县', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441827, '清新县', '', '广东省,清远市,清新县', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441881, '英德市', '', '广东省,清远市,英德市', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441882, '连州市', '', '广东省,清远市,连州市', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445101, '市辖区', '', '广东省,潮州市,市辖区', 445100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445102, '湘桥区', '', '广东省,潮州市,湘桥区', 445100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445121, '潮安县', '', '广东省,潮州市,潮安县', 445100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445122, '饶平县', '', '广东省,潮州市,饶平县', 445100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445201, '市辖区', '', '广东省,揭阳市,市辖区', 445200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445202, '榕城区', '', '广东省,揭阳市,榕城区', 445200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445221, '揭东县', '', '广东省,揭阳市,揭东县', 445200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445222, '揭西县', '', '广东省,揭阳市,揭西县', 445200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445224, '惠来县', '', '广东省,揭阳市,惠来县', 445200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445281, '普宁市', '', '广东省,揭阳市,普宁市', 445200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445301, '市辖区', '', '广东省,云浮市,市辖区', 445300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445302, '云城区', '', '广东省,云浮市,云城区', 445300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445321, '新兴县', '', '广东省,云浮市,新兴县', 445300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445322, '郁南县', '', '广东省,云浮市,郁南县', 445300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445323, '云安县', '', '广东省,云浮市,云安县', 445300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445381, '罗定市', '', '广东省,云浮市,罗定市', 445300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450101, '市辖区', '', '广西壮族自治区,南宁市,市辖区', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450102, '兴宁区', '', '广西壮族自治区,南宁市,兴宁区', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450103, '青秀区', '', '广西壮族自治区,南宁市,青秀区', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450105, '江南区', '', '广西壮族自治区,南宁市,江南区', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450107, '西乡塘区', '', '广西壮族自治区,南宁市,西乡塘区', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450108, '良庆区', '', '广西壮族自治区,南宁市,良庆区', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450109, '邕宁区', '', '广西壮族自治区,南宁市,邕宁区', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450122, '武鸣县', '', '广西壮族自治区,南宁市,武鸣县', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450123, '隆安县', '', '广西壮族自治区,南宁市,隆安县', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450124, '马山县', '', '广西壮族自治区,南宁市,马山县', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450125, '上林县', '', '广西壮族自治区,南宁市,上林县', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450126, '宾阳县', '', '广西壮族自治区,南宁市,宾阳县', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450127, '横　县', '', '广西壮族自治区,南宁市,横　县', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450201, '市辖区', '', '广西壮族自治区,柳州市,市辖区', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450202, '城中区', '', '广西壮族自治区,柳州市,城中区', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450203, '鱼峰区', '', '广西壮族自治区,柳州市,鱼峰区', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450204, '柳南区', '', '广西壮族自治区,柳州市,柳南区', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450205, '柳北区', '', '广西壮族自治区,柳州市,柳北区', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450221, '柳江县', '', '广西壮族自治区,柳州市,柳江县', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450222, '柳城县', '', '广西壮族自治区,柳州市,柳城县', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450223, '鹿寨县', '', '广西壮族自治区,柳州市,鹿寨县', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450224, '融安县', '', '广西壮族自治区,柳州市,融安县', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450225, '融水苗族自治县', '', '广西壮族自治区,柳州市,融水苗族自治县', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450226, '三江侗族自治县', '', '广西壮族自治区,柳州市,三江侗族自治县', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450301, '市辖区', '', '广西壮族自治区,桂林市,市辖区', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450302, '秀峰区', '', '广西壮族自治区,桂林市,秀峰区', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450303, '叠彩区', '', '广西壮族自治区,桂林市,叠彩区', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450304, '象山区', '', '广西壮族自治区,桂林市,象山区', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450305, '七星区', '', '广西壮族自治区,桂林市,七星区', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450311, '雁山区', '', '广西壮族自治区,桂林市,雁山区', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450321, '阳朔县', '', '广西壮族自治区,桂林市,阳朔县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450322, '临桂县', '', '广西壮族自治区,桂林市,临桂县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450323, '灵川县', '', '广西壮族自治区,桂林市,灵川县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450324, '全州县', '', '广西壮族自治区,桂林市,全州县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450325, '兴安县', '', '广西壮族自治区,桂林市,兴安县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450326, '永福县', '', '广西壮族自治区,桂林市,永福县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450327, '灌阳县', '', '广西壮族自治区,桂林市,灌阳县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450328, '龙胜各族自治县', '', '广西壮族自治区,桂林市,龙胜各族自治县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450329, '资源县', '', '广西壮族自治区,桂林市,资源县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450330, '平乐县', '', '广西壮族自治区,桂林市,平乐县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450331, '荔蒲县', '', '广西壮族自治区,桂林市,荔蒲县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450332, '恭城瑶族自治县', '', '广西壮族自治区,桂林市,恭城瑶族自治县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450401, '市辖区', '', '广西壮族自治区,梧州市,市辖区', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450403, '万秀区', '', '广西壮族自治区,梧州市,万秀区', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450404, '蝶山区', '', '广西壮族自治区,梧州市,蝶山区', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450405, '长洲区', '', '广西壮族自治区,梧州市,长洲区', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450421, '苍梧县', '', '广西壮族自治区,梧州市,苍梧县', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450422, '藤　县', '', '广西壮族自治区,梧州市,藤　县', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450423, '蒙山县', '', '广西壮族自治区,梧州市,蒙山县', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450481, '岑溪市', '', '广西壮族自治区,梧州市,岑溪市', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450501, '市辖区', '', '广西壮族自治区,北海市,市辖区', 450500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450502, '海城区', '', '广西壮族自治区,北海市,海城区', 450500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450503, '银海区', '', '广西壮族自治区,北海市,银海区', 450500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450512, '铁山港区', '', '广西壮族自治区,北海市,铁山港区', 450500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450521, '合浦县', '', '广西壮族自治区,北海市,合浦县', 450500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450601, '市辖区', '', '广西壮族自治区,防城港市,市辖区', 450600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450602, '港口区', '', '广西壮族自治区,防城港市,港口区', 450600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450603, '防城区', '', '广西壮族自治区,防城港市,防城区', 450600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450621, '上思县', '', '广西壮族自治区,防城港市,上思县', 450600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450681, '东兴市', '', '广西壮族自治区,防城港市,东兴市', 450600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450701, '市辖区', '', '广西壮族自治区,钦州市,市辖区', 450700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450702, '钦南区', '', '广西壮族自治区,钦州市,钦南区', 450700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450703, '钦北区', '', '广西壮族自治区,钦州市,钦北区', 450700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450721, '灵山县', '', '广西壮族自治区,钦州市,灵山县', 450700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450722, '浦北县', '', '广西壮族自治区,钦州市,浦北县', 450700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450801, '市辖区', '', '广西壮族自治区,贵港市,市辖区', 450800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450802, '港北区', '', '广西壮族自治区,贵港市,港北区', 450800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450803, '港南区', '', '广西壮族自治区,贵港市,港南区', 450800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450804, '覃塘区', '', '广西壮族自治区,贵港市,覃塘区', 450800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450821, '平南县', '', '广西壮族自治区,贵港市,平南县', 450800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450881, '桂平市', '', '广西壮族自治区,贵港市,桂平市', 450800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450901, '市辖区', '', '广西壮族自治区,玉林市,市辖区', 450900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450902, '玉州区', '', '广西壮族自治区,玉林市,玉州区', 450900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450921, '容　县', '', '广西壮族自治区,玉林市,容　县', 450900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450922, '陆川县', '', '广西壮族自治区,玉林市,陆川县', 450900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450923, '博白县', '', '广西壮族自治区,玉林市,博白县', 450900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450924, '兴业县', '', '广西壮族自治区,玉林市,兴业县', 450900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450981, '北流市', '', '广西壮族自治区,玉林市,北流市', 450900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451001, '市辖区', '', '广西壮族自治区,百色市,市辖区', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451002, '右江区', '', '广西壮族自治区,百色市,右江区', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451021, '田阳县', '', '广西壮族自治区,百色市,田阳县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451022, '田东县', '', '广西壮族自治区,百色市,田东县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451023, '平果县', '', '广西壮族自治区,百色市,平果县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451024, '德保县', '', '广西壮族自治区,百色市,德保县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451025, '靖西县', '', '广西壮族自治区,百色市,靖西县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451026, '那坡县', '', '广西壮族自治区,百色市,那坡县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451027, '凌云县', '', '广西壮族自治区,百色市,凌云县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451028, '乐业县', '', '广西壮族自治区,百色市,乐业县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451029, '田林县', '', '广西壮族自治区,百色市,田林县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451030, '西林县', '', '广西壮族自治区,百色市,西林县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451031, '隆林各族自治县', '', '广西壮族自治区,百色市,隆林各族自治县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451101, '市辖区', '', '广西壮族自治区,贺州市,市辖区', 451100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451102, '八步区', '', '广西壮族自治区,贺州市,八步区', 451100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451121, '昭平县', '', '广西壮族自治区,贺州市,昭平县', 451100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451122, '钟山县', '', '广西壮族自治区,贺州市,钟山县', 451100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451123, '富川瑶族自治县', '', '广西壮族自治区,贺州市,富川瑶族自治县', 451100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451201, '市辖区', '', '广西壮族自治区,河池市,市辖区', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451202, '金城江区', '', '广西壮族自治区,河池市,金城江区', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451221, '南丹县', '', '广西壮族自治区,河池市,南丹县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451222, '天峨县', '', '广西壮族自治区,河池市,天峨县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451223, '凤山县', '', '广西壮族自治区,河池市,凤山县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451224, '东兰县', '', '广西壮族自治区,河池市,东兰县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451225, '罗城仫佬族自治县', '', '广西壮族自治区,河池市,罗城仫佬族自治县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451226, '环江毛南族自治县', '', '广西壮族自治区,河池市,环江毛南族自治县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451227, '巴马瑶族自治县', '', '广西壮族自治区,河池市,巴马瑶族自治县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451228, '都安瑶族自治县', '', '广西壮族自治区,河池市,都安瑶族自治县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451229, '大化瑶族自治县', '', '广西壮族自治区,河池市,大化瑶族自治县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451281, '宜州市', '', '广西壮族自治区,河池市,宜州市', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451301, '市辖区', '', '广西壮族自治区,来宾市,市辖区', 451300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451302, '兴宾区', '', '广西壮族自治区,来宾市,兴宾区', 451300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451321, '忻城县', '', '广西壮族自治区,来宾市,忻城县', 451300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451322, '象州县', '', '广西壮族自治区,来宾市,象州县', 451300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451323, '武宣县', '', '广西壮族自治区,来宾市,武宣县', 451300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451324, '金秀瑶族自治县', '', '广西壮族自治区,来宾市,金秀瑶族自治县', 451300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451381, '合山市', '', '广西壮族自治区,来宾市,合山市', 451300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451401, '市辖区', '', '广西壮族自治区,崇左市,市辖区', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451402, '江洲区', '', '广西壮族自治区,崇左市,江洲区', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451421, '扶绥县', '', '广西壮族自治区,崇左市,扶绥县', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451422, '宁明县', '', '广西壮族自治区,崇左市,宁明县', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451423, '龙州县', '', '广西壮族自治区,崇左市,龙州县', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451424, '大新县', '', '广西壮族自治区,崇左市,大新县', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451425, '天等县', '', '广西壮族自治区,崇左市,天等县', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451481, '凭祥市', '', '广西壮族自治区,崇左市,凭祥市', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (460101, '市辖区', '', '海南省,海口市,市辖区', 460100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (460105, '秀英区', '', '海南省,海口市,秀英区', 460100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (460106, '龙华区', '', '海南省,海口市,龙华区', 460100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (460107, '琼山区', '', '海南省,海口市,琼山区', 460100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (460108, '美兰区', '', '海南省,海口市,美兰区', 460100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (460201, '市辖区', '', '海南省,三亚市,市辖区', 460200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469001, '五指山市', '', '海南省,省直辖县级行政单位,五指山市', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469002, '琼海市', '', '海南省,省直辖县级行政单位,琼海市', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469003, '儋州市', '', '海南省,省直辖县级行政单位,儋州市', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469005, '文昌市', '', '海南省,省直辖县级行政单位,文昌市', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469006, '万宁市', '', '海南省,省直辖县级行政单位,万宁市', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469007, '东方市', '', '海南省,省直辖县级行政单位,东方市', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469025, '定安县', '', '海南省,省直辖县级行政单位,定安县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469026, '屯昌县', '', '海南省,省直辖县级行政单位,屯昌县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469027, '澄迈县', '', '海南省,省直辖县级行政单位,澄迈县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469028, '临高县', '', '海南省,省直辖县级行政单位,临高县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469030, '白沙黎族自治县', '', '海南省,省直辖县级行政单位,白沙黎族自治县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469031, '昌江黎族自治县', '', '海南省,省直辖县级行政单位,昌江黎族自治县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469033, '乐东黎族自治县', '', '海南省,省直辖县级行政单位,乐东黎族自治县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469034, '陵水黎族自治县', '', '海南省,省直辖县级行政单位,陵水黎族自治县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469035, '保亭黎族苗族自治县', '', '海南省,省直辖县级行政单位,保亭黎族苗族自治县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469036, '琼中黎族苗族自治县', '', '海南省,省直辖县级行政单位,琼中黎族苗族自治县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469037, '西沙群岛', '', '海南省,省直辖县级行政单位,西沙群岛', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469038, '南沙群岛', '', '海南省,省直辖县级行政单位,南沙群岛', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469039, '中沙群岛的岛礁及其海域', '', '海南省,省直辖县级行政单位,中沙群岛的岛礁及其海域', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500101, '万州区', '', '重庆市,市辖区,万州区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500102, '涪陵区', '', '重庆市,市辖区,涪陵区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500103, '渝中区', '', '重庆市,市辖区,渝中区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500104, '大渡口区', '', '重庆市,市辖区,大渡口区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500105, '江北区', '', '重庆市,市辖区,江北区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500106, '沙坪坝区', '', '重庆市,市辖区,沙坪坝区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500107, '九龙坡区', '', '重庆市,市辖区,九龙坡区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500108, '南岸区', '', '重庆市,市辖区,南岸区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500109, '北碚区', '', '重庆市,市辖区,北碚区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500110, '万盛区', '', '重庆市,市辖区,万盛区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500111, '双桥区', '', '重庆市,市辖区,双桥区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500112, '渝北区', '', '重庆市,市辖区,渝北区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500113, '巴南区', '', '重庆市,市辖区,巴南区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500114, '黔江区', '', '重庆市,市辖区,黔江区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500115, '长寿区', '', '重庆市,市辖区,长寿区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500222, '綦江县', '', '重庆市,县,綦江县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500223, '潼南县', '', '重庆市,县,潼南县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500224, '铜梁县', '', '重庆市,县,铜梁县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500225, '大足县', '', '重庆市,县,大足县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500226, '荣昌县', '', '重庆市,县,荣昌县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500227, '璧山县', '', '重庆市,县,璧山县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500228, '梁平县', '', '重庆市,县,梁平县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500229, '城口县', '', '重庆市,县,城口县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500230, '丰都县', '', '重庆市,县,丰都县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500231, '垫江县', '', '重庆市,县,垫江县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500232, '武隆县', '', '重庆市,县,武隆县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500233, '忠　县', '', '重庆市,县,忠　县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500234, '开　县', '', '重庆市,县,开　县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500235, '云阳县', '', '重庆市,县,云阳县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500236, '奉节县', '', '重庆市,县,奉节县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500237, '巫山县', '', '重庆市,县,巫山县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500238, '巫溪县', '', '重庆市,县,巫溪县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500240, '石柱土家族自治县', '', '重庆市,县,石柱土家族自治县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500241, '秀山土家族苗族自治县', '', '重庆市,县,秀山土家族苗族自治县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500242, '酉阳土家族苗族自治县', '', '重庆市,县,酉阳土家族苗族自治县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500243, '彭水苗族土家族自治县', '', '重庆市,县,彭水苗族土家族自治县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500381, '江津市', '', '重庆市,市,江津市', 500300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500382, '合川市', '', '重庆市,市,合川市', 500300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500383, '永川市', '', '重庆市,市,永川市', 500300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500384, '南川市', '', '重庆市,市,南川市', 500300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510101, '市辖区', '', '四川省,成都市,市辖区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510104, '锦江区', '', '四川省,成都市,锦江区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510105, '青羊区', '', '四川省,成都市,青羊区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510106, '金牛区', '', '四川省,成都市,金牛区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510107, '武侯区', '', '四川省,成都市,武侯区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510108, '成华区', '', '四川省,成都市,成华区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510112, '龙泉驿区', '', '四川省,成都市,龙泉驿区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510113, '青白江区', '', '四川省,成都市,青白江区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510114, '新都区', '', '四川省,成都市,新都区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510115, '温江区', '', '四川省,成都市,温江区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510121, '金堂县', '', '四川省,成都市,金堂县', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510122, '双流县', '', '四川省,成都市,双流县', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510124, '郫　县', '', '四川省,成都市,郫　县', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510129, '大邑县', '', '四川省,成都市,大邑县', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510131, '蒲江县', '', '四川省,成都市,蒲江县', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510132, '新津县', '', '四川省,成都市,新津县', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510181, '都江堰市', '', '四川省,成都市,都江堰市', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510182, '彭州市', '', '四川省,成都市,彭州市', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510183, '邛崃市', '', '四川省,成都市,邛崃市', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510184, '崇州市', '', '四川省,成都市,崇州市', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510301, '市辖区', '', '四川省,自贡市,市辖区', 510300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510302, '自流井区', '', '四川省,自贡市,自流井区', 510300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510303, '贡井区', '', '四川省,自贡市,贡井区', 510300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510304, '大安区', '', '四川省,自贡市,大安区', 510300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510311, '沿滩区', '', '四川省,自贡市,沿滩区', 510300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510321, '荣　县', '', '四川省,自贡市,荣　县', 510300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510322, '富顺县', '', '四川省,自贡市,富顺县', 510300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510401, '市辖区', '', '四川省,攀枝花市,市辖区', 510400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510402, '东　区', '', '四川省,攀枝花市,东　区', 510400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510403, '西　区', '', '四川省,攀枝花市,西　区', 510400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510411, '仁和区', '', '四川省,攀枝花市,仁和区', 510400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510421, '米易县', '', '四川省,攀枝花市,米易县', 510400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510422, '盐边县', '', '四川省,攀枝花市,盐边县', 510400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510501, '市辖区', '', '四川省,泸州市,市辖区', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510502, '江阳区', '', '四川省,泸州市,江阳区', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510503, '纳溪区', '', '四川省,泸州市,纳溪区', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510504, '龙马潭区', '', '四川省,泸州市,龙马潭区', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510521, '泸　县', '', '四川省,泸州市,泸　县', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510522, '合江县', '', '四川省,泸州市,合江县', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510524, '叙永县', '', '四川省,泸州市,叙永县', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510525, '古蔺县', '', '四川省,泸州市,古蔺县', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510601, '市辖区', '', '四川省,德阳市,市辖区', 510600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510603, '旌阳区', '', '四川省,德阳市,旌阳区', 510600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510623, '中江县', '', '四川省,德阳市,中江县', 510600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510626, '罗江县', '', '四川省,德阳市,罗江县', 510600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510681, '广汉市', '', '四川省,德阳市,广汉市', 510600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510682, '什邡市', '', '四川省,德阳市,什邡市', 510600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510683, '绵竹市', '', '四川省,德阳市,绵竹市', 510600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510701, '市辖区', '', '四川省,绵阳市,市辖区', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510703, '涪城区', '', '四川省,绵阳市,涪城区', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510704, '游仙区', '', '四川省,绵阳市,游仙区', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510722, '三台县', '', '四川省,绵阳市,三台县', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510723, '盐亭县', '', '四川省,绵阳市,盐亭县', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510724, '安　县', '', '四川省,绵阳市,安　县', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510725, '梓潼县', '', '四川省,绵阳市,梓潼县', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510726, '北川羌族自治县', '', '四川省,绵阳市,北川羌族自治县', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510727, '平武县', '', '四川省,绵阳市,平武县', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510781, '江油市', '', '四川省,绵阳市,江油市', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510801, '市辖区', '', '四川省,广元市,市辖区', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510802, '市中区', '', '四川省,广元市,市中区', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510811, '元坝区', '', '四川省,广元市,元坝区', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510812, '朝天区', '', '四川省,广元市,朝天区', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510821, '旺苍县', '', '四川省,广元市,旺苍县', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510822, '青川县', '', '四川省,广元市,青川县', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510823, '剑阁县', '', '四川省,广元市,剑阁县', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510824, '苍溪县', '', '四川省,广元市,苍溪县', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510901, '市辖区', '', '四川省,遂宁市,市辖区', 510900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510903, '船山区', '', '四川省,遂宁市,船山区', 510900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510904, '安居区', '', '四川省,遂宁市,安居区', 510900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510921, '蓬溪县', '', '四川省,遂宁市,蓬溪县', 510900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510922, '射洪县', '', '四川省,遂宁市,射洪县', 510900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510923, '大英县', '', '四川省,遂宁市,大英县', 510900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511001, '市辖区', '', '四川省,内江市,市辖区', 511000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511002, '市中区', '', '四川省,内江市,市中区', 511000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511011, '东兴区', '', '四川省,内江市,东兴区', 511000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511024, '威远县', '', '四川省,内江市,威远县', 511000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511025, '资中县', '', '四川省,内江市,资中县', 511000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511028, '隆昌县', '', '四川省,内江市,隆昌县', 511000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511101, '市辖区', '', '四川省,乐山市,市辖区', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511102, '市中区', '', '四川省,乐山市,市中区', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511111, '沙湾区', '', '四川省,乐山市,沙湾区', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511112, '五通桥区', '', '四川省,乐山市,五通桥区', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511113, '金口河区', '', '四川省,乐山市,金口河区', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511123, '犍为县', '', '四川省,乐山市,犍为县', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511124, '井研县', '', '四川省,乐山市,井研县', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511126, '夹江县', '', '四川省,乐山市,夹江县', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511129, '沐川县', '', '四川省,乐山市,沐川县', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511132, '峨边彝族自治县', '', '四川省,乐山市,峨边彝族自治县', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511133, '马边彝族自治县', '', '四川省,乐山市,马边彝族自治县', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511181, '峨眉山市', '', '四川省,乐山市,峨眉山市', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511301, '市辖区', '', '四川省,南充市,市辖区', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511302, '顺庆区', '', '四川省,南充市,顺庆区', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511303, '高坪区', '', '四川省,南充市,高坪区', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511304, '嘉陵区', '', '四川省,南充市,嘉陵区', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511321, '南部县', '', '四川省,南充市,南部县', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511322, '营山县', '', '四川省,南充市,营山县', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511323, '蓬安县', '', '四川省,南充市,蓬安县', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511324, '仪陇县', '', '四川省,南充市,仪陇县', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511325, '西充县', '', '四川省,南充市,西充县', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511381, '阆中市', '', '四川省,南充市,阆中市', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511401, '市辖区', '', '四川省,眉山市,市辖区', 511400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511402, '东坡区', '', '四川省,眉山市,东坡区', 511400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511421, '仁寿县', '', '四川省,眉山市,仁寿县', 511400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511422, '彭山县', '', '四川省,眉山市,彭山县', 511400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511423, '洪雅县', '', '四川省,眉山市,洪雅县', 511400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511424, '丹棱县', '', '四川省,眉山市,丹棱县', 511400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511425, '青神县', '', '四川省,眉山市,青神县', 511400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511501, '市辖区', '', '四川省,宜宾市,市辖区', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511502, '翠屏区', '', '四川省,宜宾市,翠屏区', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511521, '宜宾县', '', '四川省,宜宾市,宜宾县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511522, '南溪县', '', '四川省,宜宾市,南溪县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511523, '江安县', '', '四川省,宜宾市,江安县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511524, '长宁县', '', '四川省,宜宾市,长宁县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511525, '高　县', '', '四川省,宜宾市,高　县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511526, '珙　县', '', '四川省,宜宾市,珙　县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511527, '筠连县', '', '四川省,宜宾市,筠连县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511528, '兴文县', '', '四川省,宜宾市,兴文县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511529, '屏山县', '', '四川省,宜宾市,屏山县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511601, '市辖区', '', '四川省,广安市,市辖区', 511600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511602, '广安区', '', '四川省,广安市,广安区', 511600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511621, '岳池县', '', '四川省,广安市,岳池县', 511600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511622, '武胜县', '', '四川省,广安市,武胜县', 511600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511623, '邻水县', '', '四川省,广安市,邻水县', 511600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511681, '华莹市', '', '四川省,广安市,华莹市', 511600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511701, '市辖区', '', '四川省,达州市,市辖区', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511702, '通川区', '', '四川省,达州市,通川区', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511721, '达　县', '', '四川省,达州市,达　县', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511722, '宣汉县', '', '四川省,达州市,宣汉县', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511723, '开江县', '', '四川省,达州市,开江县', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511724, '大竹县', '', '四川省,达州市,大竹县', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511725, '渠　县', '', '四川省,达州市,渠　县', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511781, '万源市', '', '四川省,达州市,万源市', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511801, '市辖区', '', '四川省,雅安市,市辖区', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511802, '雨城区', '', '四川省,雅安市,雨城区', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511821, '名山县', '', '四川省,雅安市,名山县', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511822, '荥经县', '', '四川省,雅安市,荥经县', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511823, '汉源县', '', '四川省,雅安市,汉源县', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511824, '石棉县', '', '四川省,雅安市,石棉县', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511825, '天全县', '', '四川省,雅安市,天全县', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511826, '芦山县', '', '四川省,雅安市,芦山县', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511827, '宝兴县', '', '四川省,雅安市,宝兴县', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511901, '市辖区', '', '四川省,巴中市,市辖区', 511900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511902, '巴州区', '', '四川省,巴中市,巴州区', 511900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511921, '通江县', '', '四川省,巴中市,通江县', 511900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511922, '南江县', '', '四川省,巴中市,南江县', 511900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511923, '平昌县', '', '四川省,巴中市,平昌县', 511900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (512001, '市辖区', '', '四川省,资阳市,市辖区', 512000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (512002, '雁江区', '', '四川省,资阳市,雁江区', 512000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (512021, '安岳县', '', '四川省,资阳市,安岳县', 512000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (512022, '乐至县', '', '四川省,资阳市,乐至县', 512000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (512081, '简阳市', '', '四川省,资阳市,简阳市', 512000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513221, '汶川县', '', '四川省,阿坝藏族羌族自治州,汶川县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513222, '理　县', '', '四川省,阿坝藏族羌族自治州,理　县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513223, '茂　县', '', '四川省,阿坝藏族羌族自治州,茂　县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513224, '松潘县', '', '四川省,阿坝藏族羌族自治州,松潘县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513225, '九寨沟县', '', '四川省,阿坝藏族羌族自治州,九寨沟县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513226, '金川县', '', '四川省,阿坝藏族羌族自治州,金川县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513227, '小金县', '', '四川省,阿坝藏族羌族自治州,小金县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513228, '黑水县', '', '四川省,阿坝藏族羌族自治州,黑水县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513229, '马尔康县', '', '四川省,阿坝藏族羌族自治州,马尔康县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513230, '壤塘县', '', '四川省,阿坝藏族羌族自治州,壤塘县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513231, '阿坝县', '', '四川省,阿坝藏族羌族自治州,阿坝县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513232, '若尔盖县', '', '四川省,阿坝藏族羌族自治州,若尔盖县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513233, '红原县', '', '四川省,阿坝藏族羌族自治州,红原县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513321, '康定县', '', '四川省,甘孜藏族自治州,康定县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513322, '泸定县', '', '四川省,甘孜藏族自治州,泸定县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513323, '丹巴县', '', '四川省,甘孜藏族自治州,丹巴县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513324, '九龙县', '', '四川省,甘孜藏族自治州,九龙县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513325, '雅江县', '', '四川省,甘孜藏族自治州,雅江县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513326, '道孚县', '', '四川省,甘孜藏族自治州,道孚县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513327, '炉霍县', '', '四川省,甘孜藏族自治州,炉霍县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513328, '甘孜县', '', '四川省,甘孜藏族自治州,甘孜县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513329, '新龙县', '', '四川省,甘孜藏族自治州,新龙县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513330, '德格县', '', '四川省,甘孜藏族自治州,德格县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513331, '白玉县', '', '四川省,甘孜藏族自治州,白玉县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513332, '石渠县', '', '四川省,甘孜藏族自治州,石渠县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513333, '色达县', '', '四川省,甘孜藏族自治州,色达县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513334, '理塘县', '', '四川省,甘孜藏族自治州,理塘县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513335, '巴塘县', '', '四川省,甘孜藏族自治州,巴塘县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513336, '乡城县', '', '四川省,甘孜藏族自治州,乡城县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513337, '稻城县', '', '四川省,甘孜藏族自治州,稻城县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513338, '得荣县', '', '四川省,甘孜藏族自治州,得荣县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513401, '西昌市', '', '四川省,凉山彝族自治州,西昌市', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513422, '木里藏族自治县', '', '四川省,凉山彝族自治州,木里藏族自治县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513423, '盐源县', '', '四川省,凉山彝族自治州,盐源县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513424, '德昌县', '', '四川省,凉山彝族自治州,德昌县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513425, '会理县', '', '四川省,凉山彝族自治州,会理县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513426, '会东县', '', '四川省,凉山彝族自治州,会东县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513427, '宁南县', '', '四川省,凉山彝族自治州,宁南县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513428, '普格县', '', '四川省,凉山彝族自治州,普格县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513429, '布拖县', '', '四川省,凉山彝族自治州,布拖县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513430, '金阳县', '', '四川省,凉山彝族自治州,金阳县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513431, '昭觉县', '', '四川省,凉山彝族自治州,昭觉县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513432, '喜德县', '', '四川省,凉山彝族自治州,喜德县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513433, '冕宁县', '', '四川省,凉山彝族自治州,冕宁县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513434, '越西县', '', '四川省,凉山彝族自治州,越西县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513435, '甘洛县', '', '四川省,凉山彝族自治州,甘洛县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513436, '美姑县', '', '四川省,凉山彝族自治州,美姑县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513437, '雷波县', '', '四川省,凉山彝族自治州,雷波县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520101, '市辖区', '', '贵州省,贵阳市,市辖区', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520102, '南明区', '', '贵州省,贵阳市,南明区', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520103, '云岩区', '', '贵州省,贵阳市,云岩区', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520111, '花溪区', '', '贵州省,贵阳市,花溪区', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520112, '乌当区', '', '贵州省,贵阳市,乌当区', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520113, '白云区', '', '贵州省,贵阳市,白云区', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520114, '小河区', '', '贵州省,贵阳市,小河区', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520121, '开阳县', '', '贵州省,贵阳市,开阳县', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520122, '息烽县', '', '贵州省,贵阳市,息烽县', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520123, '修文县', '', '贵州省,贵阳市,修文县', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520181, '清镇市', '', '贵州省,贵阳市,清镇市', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520201, '钟山区', '', '贵州省,六盘水市,钟山区', 520200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520203, '六枝特区', '', '贵州省,六盘水市,六枝特区', 520200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520221, '水城县', '', '贵州省,六盘水市,水城县', 520200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520222, '盘　县', '', '贵州省,六盘水市,盘　县', 520200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520301, '市辖区', '', '贵州省,遵义市,市辖区', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520302, '红花岗区', '', '贵州省,遵义市,红花岗区', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520303, '汇川区', '', '贵州省,遵义市,汇川区', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520321, '遵义县', '', '贵州省,遵义市,遵义县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520322, '桐梓县', '', '贵州省,遵义市,桐梓县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520323, '绥阳县', '', '贵州省,遵义市,绥阳县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520324, '正安县', '', '贵州省,遵义市,正安县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520325, '道真仡佬族苗族自治县', '', '贵州省,遵义市,道真仡佬族苗族自治县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520326, '务川仡佬族苗族自治县', '', '贵州省,遵义市,务川仡佬族苗族自治县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520327, '凤冈县', '', '贵州省,遵义市,凤冈县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520328, '湄潭县', '', '贵州省,遵义市,湄潭县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520329, '余庆县', '', '贵州省,遵义市,余庆县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520330, '习水县', '', '贵州省,遵义市,习水县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520381, '赤水市', '', '贵州省,遵义市,赤水市', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520382, '仁怀市', '', '贵州省,遵义市,仁怀市', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520401, '市辖区', '', '贵州省,安顺市,市辖区', 520400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520402, '西秀区', '', '贵州省,安顺市,西秀区', 520400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520421, '平坝县', '', '贵州省,安顺市,平坝县', 520400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520422, '普定县', '', '贵州省,安顺市,普定县', 520400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520423, '镇宁布依族苗族自治县', '', '贵州省,安顺市,镇宁布依族苗族自治县', 520400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520424, '关岭布依族苗族自治县', '', '贵州省,安顺市,关岭布依族苗族自治县', 520400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520425, '紫云苗族布依族自治县', '', '贵州省,安顺市,紫云苗族布依族自治县', 520400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522201, '铜仁市', '', '贵州省,铜仁地区,铜仁市', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522222, '江口县', '', '贵州省,铜仁地区,江口县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522223, '玉屏侗族自治县', '', '贵州省,铜仁地区,玉屏侗族自治县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522224, '石阡县', '', '贵州省,铜仁地区,石阡县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522225, '思南县', '', '贵州省,铜仁地区,思南县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522226, '印江土家族苗族自治县', '', '贵州省,铜仁地区,印江土家族苗族自治县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522227, '德江县', '', '贵州省,铜仁地区,德江县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522228, '沿河土家族自治县', '', '贵州省,铜仁地区,沿河土家族自治县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522229, '松桃苗族自治县', '', '贵州省,铜仁地区,松桃苗族自治县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522230, '万山特区', '', '贵州省,铜仁地区,万山特区', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522301, '兴义市', '', '贵州省,黔西南布依族苗族自治州,兴义市', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522322, '兴仁县', '', '贵州省,黔西南布依族苗族自治州,兴仁县', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522323, '普安县', '', '贵州省,黔西南布依族苗族自治州,普安县', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522324, '晴隆县', '', '贵州省,黔西南布依族苗族自治州,晴隆县', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522325, '贞丰县', '', '贵州省,黔西南布依族苗族自治州,贞丰县', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522326, '望谟县', '', '贵州省,黔西南布依族苗族自治州,望谟县', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522327, '册亨县', '', '贵州省,黔西南布依族苗族自治州,册亨县', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522328, '安龙县', '', '贵州省,黔西南布依族苗族自治州,安龙县', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522401, '毕节市', '', '贵州省,毕节地区,毕节市', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522422, '大方县', '', '贵州省,毕节地区,大方县', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522423, '黔西县', '', '贵州省,毕节地区,黔西县', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522424, '金沙县', '', '贵州省,毕节地区,金沙县', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522425, '织金县', '', '贵州省,毕节地区,织金县', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522426, '纳雍县', '', '贵州省,毕节地区,纳雍县', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522427, '威宁彝族回族苗族自治县', '', '贵州省,毕节地区,威宁彝族回族苗族自治县', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522428, '赫章县', '', '贵州省,毕节地区,赫章县', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522601, '凯里市', '', '贵州省,黔东南苗族侗族自治州,凯里市', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522622, '黄平县', '', '贵州省,黔东南苗族侗族自治州,黄平县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522623, '施秉县', '', '贵州省,黔东南苗族侗族自治州,施秉县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522624, '三穗县', '', '贵州省,黔东南苗族侗族自治州,三穗县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522625, '镇远县', '', '贵州省,黔东南苗族侗族自治州,镇远县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522626, '岑巩县', '', '贵州省,黔东南苗族侗族自治州,岑巩县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522627, '天柱县', '', '贵州省,黔东南苗族侗族自治州,天柱县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522628, '锦屏县', '', '贵州省,黔东南苗族侗族自治州,锦屏县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522629, '剑河县', '', '贵州省,黔东南苗族侗族自治州,剑河县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522630, '台江县', '', '贵州省,黔东南苗族侗族自治州,台江县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522631, '黎平县', '', '贵州省,黔东南苗族侗族自治州,黎平县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522632, '榕江县', '', '贵州省,黔东南苗族侗族自治州,榕江县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522633, '从江县', '', '贵州省,黔东南苗族侗族自治州,从江县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522634, '雷山县', '', '贵州省,黔东南苗族侗族自治州,雷山县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522635, '麻江县', '', '贵州省,黔东南苗族侗族自治州,麻江县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522636, '丹寨县', '', '贵州省,黔东南苗族侗族自治州,丹寨县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522701, '都匀市', '', '贵州省,黔南布依族苗族自治州,都匀市', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522702, '福泉市', '', '贵州省,黔南布依族苗族自治州,福泉市', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522722, '荔波县', '', '贵州省,黔南布依族苗族自治州,荔波县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522723, '贵定县', '', '贵州省,黔南布依族苗族自治州,贵定县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522725, '瓮安县', '', '贵州省,黔南布依族苗族自治州,瓮安县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522726, '独山县', '', '贵州省,黔南布依族苗族自治州,独山县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522727, '平塘县', '', '贵州省,黔南布依族苗族自治州,平塘县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522728, '罗甸县', '', '贵州省,黔南布依族苗族自治州,罗甸县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522729, '长顺县', '', '贵州省,黔南布依族苗族自治州,长顺县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522730, '龙里县', '', '贵州省,黔南布依族苗族自治州,龙里县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522731, '惠水县', '', '贵州省,黔南布依族苗族自治州,惠水县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522732, '三都水族自治县', '', '贵州省,黔南布依族苗族自治州,三都水族自治县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530101, '市辖区', '', '云南省,昆明市,市辖区', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530102, '五华区', '', '云南省,昆明市,五华区', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530103, '盘龙区', '', '云南省,昆明市,盘龙区', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530111, '官渡区', '', '云南省,昆明市,官渡区', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530112, '西山区', '', '云南省,昆明市,西山区', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530113, '东川区', '', '云南省,昆明市,东川区', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530121, '呈贡县', '', '云南省,昆明市,呈贡县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530122, '晋宁县', '', '云南省,昆明市,晋宁县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530124, '富民县', '', '云南省,昆明市,富民县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530125, '宜良县', '', '云南省,昆明市,宜良县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530126, '石林彝族自治县', '', '云南省,昆明市,石林彝族自治县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530127, '嵩明县', '', '云南省,昆明市,嵩明县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530128, '禄劝彝族苗族自治县', '', '云南省,昆明市,禄劝彝族苗族自治县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530129, '寻甸回族彝族自治县', '', '云南省,昆明市,寻甸回族彝族自治县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530181, '安宁市', '', '云南省,昆明市,安宁市', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530301, '市辖区', '', '云南省,曲靖市,市辖区', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530302, '麒麟区', '', '云南省,曲靖市,麒麟区', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530321, '马龙县', '', '云南省,曲靖市,马龙县', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530322, '陆良县', '', '云南省,曲靖市,陆良县', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530323, '师宗县', '', '云南省,曲靖市,师宗县', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530324, '罗平县', '', '云南省,曲靖市,罗平县', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530325, '富源县', '', '云南省,曲靖市,富源县', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530326, '会泽县', '', '云南省,曲靖市,会泽县', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530328, '沾益县', '', '云南省,曲靖市,沾益县', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530381, '宣威市', '', '云南省,曲靖市,宣威市', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530401, '市辖区', '', '云南省,玉溪市,市辖区', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530402, '红塔区', '', '云南省,玉溪市,红塔区', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530421, '江川县', '', '云南省,玉溪市,江川县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530422, '澄江县', '', '云南省,玉溪市,澄江县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530423, '通海县', '', '云南省,玉溪市,通海县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530424, '华宁县', '', '云南省,玉溪市,华宁县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530425, '易门县', '', '云南省,玉溪市,易门县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530426, '峨山彝族自治县', '', '云南省,玉溪市,峨山彝族自治县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530427, '新平彝族傣族自治县', '', '云南省,玉溪市,新平彝族傣族自治县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530428, '元江哈尼族彝族傣族自治县', '', '云南省,玉溪市,元江哈尼族彝族傣族自治县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530501, '市辖区', '', '云南省,保山市,市辖区', 530500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530502, '隆阳区', '', '云南省,保山市,隆阳区', 530500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530521, '施甸县', '', '云南省,保山市,施甸县', 530500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530522, '腾冲县', '', '云南省,保山市,腾冲县', 530500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530523, '龙陵县', '', '云南省,保山市,龙陵县', 530500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530524, '昌宁县', '', '云南省,保山市,昌宁县', 530500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530601, '市辖区', '', '云南省,昭通市,市辖区', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530602, '昭阳区', '', '云南省,昭通市,昭阳区', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530621, '鲁甸县', '', '云南省,昭通市,鲁甸县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530622, '巧家县', '', '云南省,昭通市,巧家县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530623, '盐津县', '', '云南省,昭通市,盐津县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530624, '大关县', '', '云南省,昭通市,大关县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530625, '永善县', '', '云南省,昭通市,永善县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530626, '绥江县', '', '云南省,昭通市,绥江县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530627, '镇雄县', '', '云南省,昭通市,镇雄县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530628, '彝良县', '', '云南省,昭通市,彝良县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530629, '威信县', '', '云南省,昭通市,威信县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530630, '水富县', '', '云南省,昭通市,水富县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530701, '市辖区', '', '云南省,丽江市,市辖区', 530700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530702, '古城区', '', '云南省,丽江市,古城区', 530700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530721, '玉龙纳西族自治县', '', '云南省,丽江市,玉龙纳西族自治县', 530700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530722, '永胜县', '', '云南省,丽江市,永胜县', 530700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530723, '华坪县', '', '云南省,丽江市,华坪县', 530700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530724, '宁蒗彝族自治县', '', '云南省,丽江市,宁蒗彝族自治县', 530700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530801, '市辖区', '', '云南省,思茅市,市辖区', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530802, '翠云区', '', '云南省,思茅市,翠云区', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530821, '普洱哈尼族彝族自治县', '', '云南省,思茅市,普洱哈尼族彝族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530822, '墨江哈尼族自治县', '', '云南省,思茅市,墨江哈尼族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530823, '景东彝族自治县', '', '云南省,思茅市,景东彝族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530824, '景谷傣族彝族自治县', '', '云南省,思茅市,景谷傣族彝族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530825, '镇沅彝族哈尼族拉祜族自治县', '', '云南省,思茅市,镇沅彝族哈尼族拉祜族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530826, '江城哈尼族彝族自治县', '', '云南省,思茅市,江城哈尼族彝族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530827, '孟连傣族拉祜族佤族自治县', '', '云南省,思茅市,孟连傣族拉祜族佤族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530828, '澜沧拉祜族自治县', '', '云南省,思茅市,澜沧拉祜族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530829, '西盟佤族自治县', '', '云南省,思茅市,西盟佤族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530901, '市辖区', '', '云南省,临沧市,市辖区', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530902, '临翔区', '', '云南省,临沧市,临翔区', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530921, '凤庆县', '', '云南省,临沧市,凤庆县', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530922, '云　县', '', '云南省,临沧市,云　县', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530923, '永德县', '', '云南省,临沧市,永德县', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530924, '镇康县', '', '云南省,临沧市,镇康县', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530925, '双江拉祜族佤族布朗族傣族自治县', '', '云南省,临沧市,双江拉祜族佤族布朗族傣族自治县', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530926, '耿马傣族佤族自治县', '', '云南省,临沧市,耿马傣族佤族自治县', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530927, '沧源佤族自治县', '', '云南省,临沧市,沧源佤族自治县', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532301, '楚雄市', '', '云南省,楚雄彝族自治州,楚雄市', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532322, '双柏县', '', '云南省,楚雄彝族自治州,双柏县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532323, '牟定县', '', '云南省,楚雄彝族自治州,牟定县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532324, '南华县', '', '云南省,楚雄彝族自治州,南华县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532325, '姚安县', '', '云南省,楚雄彝族自治州,姚安县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532326, '大姚县', '', '云南省,楚雄彝族自治州,大姚县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532327, '永仁县', '', '云南省,楚雄彝族自治州,永仁县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532328, '元谋县', '', '云南省,楚雄彝族自治州,元谋县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532329, '武定县', '', '云南省,楚雄彝族自治州,武定县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532331, '禄丰县', '', '云南省,楚雄彝族自治州,禄丰县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532501, '个旧市', '', '云南省,红河哈尼族彝族自治州,个旧市', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532502, '开远市', '', '云南省,红河哈尼族彝族自治州,开远市', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532522, '蒙自县', '', '云南省,红河哈尼族彝族自治州,蒙自县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532523, '屏边苗族自治县', '', '云南省,红河哈尼族彝族自治州,屏边苗族自治县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532524, '建水县', '', '云南省,红河哈尼族彝族自治州,建水县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532525, '石屏县', '', '云南省,红河哈尼族彝族自治州,石屏县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532526, '弥勒县', '', '云南省,红河哈尼族彝族自治州,弥勒县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532527, '泸西县', '', '云南省,红河哈尼族彝族自治州,泸西县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532528, '元阳县', '', '云南省,红河哈尼族彝族自治州,元阳县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532529, '红河县', '', '云南省,红河哈尼族彝族自治州,红河县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532530, '金平苗族瑶族傣族自治县', '', '云南省,红河哈尼族彝族自治州,金平苗族瑶族傣族自治县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532531, '绿春县', '', '云南省,红河哈尼族彝族自治州,绿春县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532532, '河口瑶族自治县', '', '云南省,红河哈尼族彝族自治州,河口瑶族自治县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532621, '文山县', '', '云南省,文山壮族苗族自治州,文山县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532622, '砚山县', '', '云南省,文山壮族苗族自治州,砚山县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532623, '西畴县', '', '云南省,文山壮族苗族自治州,西畴县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532624, '麻栗坡县', '', '云南省,文山壮族苗族自治州,麻栗坡县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532625, '马关县', '', '云南省,文山壮族苗族自治州,马关县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532626, '丘北县', '', '云南省,文山壮族苗族自治州,丘北县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532627, '广南县', '', '云南省,文山壮族苗族自治州,广南县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532628, '富宁县', '', '云南省,文山壮族苗族自治州,富宁县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532801, '景洪市', '', '云南省,西双版纳傣族自治州,景洪市', 532800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532822, '勐海县', '', '云南省,西双版纳傣族自治州,勐海县', 532800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532823, '勐腊县', '', '云南省,西双版纳傣族自治州,勐腊县', 532800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532901, '大理市', '', '云南省,大理白族自治州,大理市', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532922, '漾濞彝族自治县', '', '云南省,大理白族自治州,漾濞彝族自治县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532923, '祥云县', '', '云南省,大理白族自治州,祥云县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532924, '宾川县', '', '云南省,大理白族自治州,宾川县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532925, '弥渡县', '', '云南省,大理白族自治州,弥渡县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532926, '南涧彝族自治县', '', '云南省,大理白族自治州,南涧彝族自治县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532927, '巍山彝族回族自治县', '', '云南省,大理白族自治州,巍山彝族回族自治县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532928, '永平县', '', '云南省,大理白族自治州,永平县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532929, '云龙县', '', '云南省,大理白族自治州,云龙县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532930, '洱源县', '', '云南省,大理白族自治州,洱源县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532931, '剑川县', '', '云南省,大理白族自治州,剑川县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532932, '鹤庆县', '', '云南省,大理白族自治州,鹤庆县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533102, '瑞丽市', '', '云南省,德宏傣族景颇族自治州,瑞丽市', 533100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533103, '潞西市', '', '云南省,德宏傣族景颇族自治州,潞西市', 533100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533122, '梁河县', '', '云南省,德宏傣族景颇族自治州,梁河县', 533100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533123, '盈江县', '', '云南省,德宏傣族景颇族自治州,盈江县', 533100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533124, '陇川县', '', '云南省,德宏傣族景颇族自治州,陇川县', 533100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533321, '泸水县', '', '云南省,怒江傈僳族自治州,泸水县', 533300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533323, '福贡县', '', '云南省,怒江傈僳族自治州,福贡县', 533300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533324, '贡山独龙族怒族自治县', '', '云南省,怒江傈僳族自治州,贡山独龙族怒族自治县', 533300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533325, '兰坪白族普米族自治县', '', '云南省,怒江傈僳族自治州,兰坪白族普米族自治县', 533300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533421, '香格里拉县', '', '云南省,迪庆藏族自治州,香格里拉县', 533400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533422, '德钦县', '', '云南省,迪庆藏族自治州,德钦县', 533400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533423, '维西傈僳族自治县', '', '云南省,迪庆藏族自治州,维西傈僳族自治县', 533400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540101, '市辖区', '', '西藏自治区,拉萨市,市辖区', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540102, '城关区', '', '西藏自治区,拉萨市,城关区', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540121, '林周县', '', '西藏自治区,拉萨市,林周县', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540122, '当雄县', '', '西藏自治区,拉萨市,当雄县', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540123, '尼木县', '', '西藏自治区,拉萨市,尼木县', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540124, '曲水县', '', '西藏自治区,拉萨市,曲水县', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540125, '堆龙德庆县', '', '西藏自治区,拉萨市,堆龙德庆县', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540126, '达孜县', '', '西藏自治区,拉萨市,达孜县', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540127, '墨竹工卡县', '', '西藏自治区,拉萨市,墨竹工卡县', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542121, '昌都县', '', '西藏自治区,昌都地区,昌都县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542122, '江达县', '', '西藏自治区,昌都地区,江达县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542123, '贡觉县', '', '西藏自治区,昌都地区,贡觉县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542124, '类乌齐县', '', '西藏自治区,昌都地区,类乌齐县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542125, '丁青县', '', '西藏自治区,昌都地区,丁青县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542126, '察雅县', '', '西藏自治区,昌都地区,察雅县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542127, '八宿县', '', '西藏自治区,昌都地区,八宿县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542128, '左贡县', '', '西藏自治区,昌都地区,左贡县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542129, '芒康县', '', '西藏自治区,昌都地区,芒康县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542132, '洛隆县', '', '西藏自治区,昌都地区,洛隆县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542133, '边坝县', '', '西藏自治区,昌都地区,边坝县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542221, '乃东县', '', '西藏自治区,山南地区,乃东县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542222, '扎囊县', '', '西藏自治区,山南地区,扎囊县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542223, '贡嘎县', '', '西藏自治区,山南地区,贡嘎县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542224, '桑日县', '', '西藏自治区,山南地区,桑日县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542225, '琼结县', '', '西藏自治区,山南地区,琼结县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542226, '曲松县', '', '西藏自治区,山南地区,曲松县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542227, '措美县', '', '西藏自治区,山南地区,措美县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542228, '洛扎县', '', '西藏自治区,山南地区,洛扎县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542229, '加查县', '', '西藏自治区,山南地区,加查县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542231, '隆子县', '', '西藏自治区,山南地区,隆子县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542232, '错那县', '', '西藏自治区,山南地区,错那县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542233, '浪卡子县', '', '西藏自治区,山南地区,浪卡子县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542301, '日喀则市', '', '西藏自治区,日喀则地区,日喀则市', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542322, '南木林县', '', '西藏自治区,日喀则地区,南木林县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542323, '江孜县', '', '西藏自治区,日喀则地区,江孜县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542324, '定日县', '', '西藏自治区,日喀则地区,定日县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542325, '萨迦县', '', '西藏自治区,日喀则地区,萨迦县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542326, '拉孜县', '', '西藏自治区,日喀则地区,拉孜县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542327, '昂仁县', '', '西藏自治区,日喀则地区,昂仁县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542328, '谢通门县', '', '西藏自治区,日喀则地区,谢通门县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542329, '白朗县', '', '西藏自治区,日喀则地区,白朗县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542330, '仁布县', '', '西藏自治区,日喀则地区,仁布县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542331, '康马县', '', '西藏自治区,日喀则地区,康马县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542332, '定结县', '', '西藏自治区,日喀则地区,定结县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542333, '仲巴县', '', '西藏自治区,日喀则地区,仲巴县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542334, '亚东县', '', '西藏自治区,日喀则地区,亚东县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542335, '吉隆县', '', '西藏自治区,日喀则地区,吉隆县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542336, '聂拉木县', '', '西藏自治区,日喀则地区,聂拉木县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542337, '萨嘎县', '', '西藏自治区,日喀则地区,萨嘎县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542338, '岗巴县', '', '西藏自治区,日喀则地区,岗巴县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542421, '那曲县', '', '西藏自治区,那曲地区,那曲县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542422, '嘉黎县', '', '西藏自治区,那曲地区,嘉黎县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542423, '比如县', '', '西藏自治区,那曲地区,比如县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542424, '聂荣县', '', '西藏自治区,那曲地区,聂荣县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542425, '安多县', '', '西藏自治区,那曲地区,安多县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542426, '申扎县', '', '西藏自治区,那曲地区,申扎县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542427, '索　县', '', '西藏自治区,那曲地区,索　县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542428, '班戈县', '', '西藏自治区,那曲地区,班戈县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542429, '巴青县', '', '西藏自治区,那曲地区,巴青县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542430, '尼玛县', '', '西藏自治区,那曲地区,尼玛县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542521, '普兰县', '', '西藏自治区,阿里地区,普兰县', 542500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542522, '札达县', '', '西藏自治区,阿里地区,札达县', 542500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542523, '噶尔县', '', '西藏自治区,阿里地区,噶尔县', 542500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542524, '日土县', '', '西藏自治区,阿里地区,日土县', 542500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542525, '革吉县', '', '西藏自治区,阿里地区,革吉县', 542500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542526, '改则县', '', '西藏自治区,阿里地区,改则县', 542500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542527, '措勤县', '', '西藏自治区,阿里地区,措勤县', 542500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542621, '林芝县', '', '西藏自治区,林芝地区,林芝县', 542600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542622, '工布江达县', '', '西藏自治区,林芝地区,工布江达县', 542600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542623, '米林县', '', '西藏自治区,林芝地区,米林县', 542600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542624, '墨脱县', '', '西藏自治区,林芝地区,墨脱县', 542600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542625, '波密县', '', '西藏自治区,林芝地区,波密县', 542600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542626, '察隅县', '', '西藏自治区,林芝地区,察隅县', 542600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542627, '朗　县', '', '西藏自治区,林芝地区,朗　县', 542600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610101, '市辖区', '', '陕西省,西安市,市辖区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610102, '新城区', '', '陕西省,西安市,新城区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610103, '碑林区', '', '陕西省,西安市,碑林区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610104, '莲湖区', '', '陕西省,西安市,莲湖区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610111, '灞桥区', '', '陕西省,西安市,灞桥区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610112, '未央区', '', '陕西省,西安市,未央区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610113, '雁塔区', '', '陕西省,西安市,雁塔区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610114, '阎良区', '', '陕西省,西安市,阎良区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610115, '临潼区', '', '陕西省,西安市,临潼区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610116, '长安区', '', '陕西省,西安市,长安区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610122, '蓝田县', '', '陕西省,西安市,蓝田县', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610124, '周至县', '', '陕西省,西安市,周至县', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610125, '户　县', '', '陕西省,西安市,户　县', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610126, '高陵县', '', '陕西省,西安市,高陵县', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610201, '市辖区', '', '陕西省,铜川市,市辖区', 610200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610202, '王益区', '', '陕西省,铜川市,王益区', 610200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610203, '印台区', '', '陕西省,铜川市,印台区', 610200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610204, '耀州区', '', '陕西省,铜川市,耀州区', 610200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610222, '宜君县', '', '陕西省,铜川市,宜君县', 610200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610301, '市辖区', '', '陕西省,宝鸡市,市辖区', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610302, '渭滨区', '', '陕西省,宝鸡市,渭滨区', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610303, '金台区', '', '陕西省,宝鸡市,金台区', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610304, '陈仓区', '', '陕西省,宝鸡市,陈仓区', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610322, '凤翔县', '', '陕西省,宝鸡市,凤翔县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610323, '岐山县', '', '陕西省,宝鸡市,岐山县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610324, '扶风县', '', '陕西省,宝鸡市,扶风县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610326, '眉　县', '', '陕西省,宝鸡市,眉　县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610327, '陇　县', '', '陕西省,宝鸡市,陇　县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610328, '千阳县', '', '陕西省,宝鸡市,千阳县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610329, '麟游县', '', '陕西省,宝鸡市,麟游县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610330, '凤　县', '', '陕西省,宝鸡市,凤　县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610331, '太白县', '', '陕西省,宝鸡市,太白县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610401, '市辖区', '', '陕西省,咸阳市,市辖区', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610402, '秦都区', '', '陕西省,咸阳市,秦都区', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610403, '杨凌区', '', '陕西省,咸阳市,杨凌区', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610404, '渭城区', '', '陕西省,咸阳市,渭城区', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610422, '三原县', '', '陕西省,咸阳市,三原县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610423, '泾阳县', '', '陕西省,咸阳市,泾阳县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610424, '乾　县', '', '陕西省,咸阳市,乾　县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610425, '礼泉县', '', '陕西省,咸阳市,礼泉县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610426, '永寿县', '', '陕西省,咸阳市,永寿县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610427, '彬　县', '', '陕西省,咸阳市,彬　县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610428, '长武县', '', '陕西省,咸阳市,长武县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610429, '旬邑县', '', '陕西省,咸阳市,旬邑县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610430, '淳化县', '', '陕西省,咸阳市,淳化县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610431, '武功县', '', '陕西省,咸阳市,武功县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610481, '兴平市', '', '陕西省,咸阳市,兴平市', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610501, '市辖区', '', '陕西省,渭南市,市辖区', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610502, '临渭区', '', '陕西省,渭南市,临渭区', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610521, '华　县', '', '陕西省,渭南市,华　县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610522, '潼关县', '', '陕西省,渭南市,潼关县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610523, '大荔县', '', '陕西省,渭南市,大荔县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610524, '合阳县', '', '陕西省,渭南市,合阳县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610525, '澄城县', '', '陕西省,渭南市,澄城县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610526, '蒲城县', '', '陕西省,渭南市,蒲城县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610527, '白水县', '', '陕西省,渭南市,白水县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610528, '富平县', '', '陕西省,渭南市,富平县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610581, '韩城市', '', '陕西省,渭南市,韩城市', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610582, '华阴市', '', '陕西省,渭南市,华阴市', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610601, '市辖区', '', '陕西省,延安市,市辖区', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610602, '宝塔区', '', '陕西省,延安市,宝塔区', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610621, '延长县', '', '陕西省,延安市,延长县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610622, '延川县', '', '陕西省,延安市,延川县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610623, '子长县', '', '陕西省,延安市,子长县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610624, '安塞县', '', '陕西省,延安市,安塞县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610625, '志丹县', '', '陕西省,延安市,志丹县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610626, '吴旗县', '', '陕西省,延安市,吴旗县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610627, '甘泉县', '', '陕西省,延安市,甘泉县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610628, '富　县', '', '陕西省,延安市,富　县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610629, '洛川县', '', '陕西省,延安市,洛川县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610630, '宜川县', '', '陕西省,延安市,宜川县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610631, '黄龙县', '', '陕西省,延安市,黄龙县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610632, '黄陵县', '', '陕西省,延安市,黄陵县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610701, '市辖区', '', '陕西省,汉中市,市辖区', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610702, '汉台区', '', '陕西省,汉中市,汉台区', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610721, '南郑县', '', '陕西省,汉中市,南郑县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610722, '城固县', '', '陕西省,汉中市,城固县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610723, '洋　县', '', '陕西省,汉中市,洋　县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610724, '西乡县', '', '陕西省,汉中市,西乡县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610725, '勉　县', '', '陕西省,汉中市,勉　县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610726, '宁强县', '', '陕西省,汉中市,宁强县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610727, '略阳县', '', '陕西省,汉中市,略阳县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610728, '镇巴县', '', '陕西省,汉中市,镇巴县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610729, '留坝县', '', '陕西省,汉中市,留坝县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610730, '佛坪县', '', '陕西省,汉中市,佛坪县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610801, '市辖区', '', '陕西省,榆林市,市辖区', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610802, '榆阳区', '', '陕西省,榆林市,榆阳区', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610821, '神木县', '', '陕西省,榆林市,神木县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610822, '府谷县', '', '陕西省,榆林市,府谷县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610823, '横山县', '', '陕西省,榆林市,横山县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610824, '靖边县', '', '陕西省,榆林市,靖边县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610825, '定边县', '', '陕西省,榆林市,定边县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610826, '绥德县', '', '陕西省,榆林市,绥德县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610827, '米脂县', '', '陕西省,榆林市,米脂县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610828, '佳　县', '', '陕西省,榆林市,佳　县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610829, '吴堡县', '', '陕西省,榆林市,吴堡县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610830, '清涧县', '', '陕西省,榆林市,清涧县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610831, '子洲县', '', '陕西省,榆林市,子洲县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610901, '市辖区', '', '陕西省,安康市,市辖区', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610902, '汉滨区', '', '陕西省,安康市,汉滨区', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610921, '汉阴县', '', '陕西省,安康市,汉阴县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610922, '石泉县', '', '陕西省,安康市,石泉县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610923, '宁陕县', '', '陕西省,安康市,宁陕县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610924, '紫阳县', '', '陕西省,安康市,紫阳县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610925, '岚皋县', '', '陕西省,安康市,岚皋县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610926, '平利县', '', '陕西省,安康市,平利县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610927, '镇坪县', '', '陕西省,安康市,镇坪县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610928, '旬阳县', '', '陕西省,安康市,旬阳县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610929, '白河县', '', '陕西省,安康市,白河县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611001, '市辖区', '', '陕西省,商洛市,市辖区', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611002, '商州区', '', '陕西省,商洛市,商州区', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611021, '洛南县', '', '陕西省,商洛市,洛南县', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611022, '丹凤县', '', '陕西省,商洛市,丹凤县', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611023, '商南县', '', '陕西省,商洛市,商南县', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611024, '山阳县', '', '陕西省,商洛市,山阳县', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611025, '镇安县', '', '陕西省,商洛市,镇安县', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611026, '柞水县', '', '陕西省,商洛市,柞水县', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620101, '市辖区', '', '甘肃省,兰州市,市辖区', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620102, '城关区', '', '甘肃省,兰州市,城关区', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620103, '七里河区', '', '甘肃省,兰州市,七里河区', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620104, '西固区', '', '甘肃省,兰州市,西固区', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620105, '安宁区', '', '甘肃省,兰州市,安宁区', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620111, '红古区', '', '甘肃省,兰州市,红古区', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620121, '永登县', '', '甘肃省,兰州市,永登县', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620122, '皋兰县', '', '甘肃省,兰州市,皋兰县', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620123, '榆中县', '', '甘肃省,兰州市,榆中县', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620201, '市辖区', '', '甘肃省,嘉峪关市,市辖区', 620200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620301, '市辖区', '', '甘肃省,金昌市,市辖区', 620300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620302, '金川区', '', '甘肃省,金昌市,金川区', 620300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620321, '永昌县', '', '甘肃省,金昌市,永昌县', 620300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620401, '市辖区', '', '甘肃省,白银市,市辖区', 620400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620402, '白银区', '', '甘肃省,白银市,白银区', 620400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620403, '平川区', '', '甘肃省,白银市,平川区', 620400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620421, '靖远县', '', '甘肃省,白银市,靖远县', 620400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620422, '会宁县', '', '甘肃省,白银市,会宁县', 620400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620423, '景泰县', '', '甘肃省,白银市,景泰县', 620400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620501, '市辖区', '', '甘肃省,天水市,市辖区', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620502, '秦城区', '', '甘肃省,天水市,秦城区', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620503, '北道区', '', '甘肃省,天水市,北道区', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620521, '清水县', '', '甘肃省,天水市,清水县', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620522, '秦安县', '', '甘肃省,天水市,秦安县', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620523, '甘谷县', '', '甘肃省,天水市,甘谷县', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620524, '武山县', '', '甘肃省,天水市,武山县', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620525, '张家川回族自治县', '', '甘肃省,天水市,张家川回族自治县', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620601, '市辖区', '', '甘肃省,武威市,市辖区', 620600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620602, '凉州区', '', '甘肃省,武威市,凉州区', 620600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620621, '民勤县', '', '甘肃省,武威市,民勤县', 620600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620622, '古浪县', '', '甘肃省,武威市,古浪县', 620600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620623, '天祝藏族自治县', '', '甘肃省,武威市,天祝藏族自治县', 620600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620701, '市辖区', '', '甘肃省,张掖市,市辖区', 620700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620702, '甘州区', '', '甘肃省,张掖市,甘州区', 620700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620721, '肃南裕固族自治县', '', '甘肃省,张掖市,肃南裕固族自治县', 620700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620722, '民乐县', '', '甘肃省,张掖市,民乐县', 620700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620723, '临泽县', '', '甘肃省,张掖市,临泽县', 620700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620724, '高台县', '', '甘肃省,张掖市,高台县', 620700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620725, '山丹县', '', '甘肃省,张掖市,山丹县', 620700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620801, '市辖区', '', '甘肃省,平凉市,市辖区', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620802, '崆峒区', '', '甘肃省,平凉市,崆峒区', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620821, '泾川县', '', '甘肃省,平凉市,泾川县', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620822, '灵台县', '', '甘肃省,平凉市,灵台县', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620823, '崇信县', '', '甘肃省,平凉市,崇信县', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620824, '华亭县', '', '甘肃省,平凉市,华亭县', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620825, '庄浪县', '', '甘肃省,平凉市,庄浪县', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620826, '静宁县', '', '甘肃省,平凉市,静宁县', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620901, '市辖区', '', '甘肃省,酒泉市,市辖区', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620902, '肃州区', '', '甘肃省,酒泉市,肃州区', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620921, '金塔县', '', '甘肃省,酒泉市,金塔县', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620922, '安西县', '', '甘肃省,酒泉市,安西县', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620923, '肃北蒙古族自治县', '', '甘肃省,酒泉市,肃北蒙古族自治县', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620924, '阿克塞哈萨克族自治县', '', '甘肃省,酒泉市,阿克塞哈萨克族自治县', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620981, '玉门市', '', '甘肃省,酒泉市,玉门市', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620982, '敦煌市', '', '甘肃省,酒泉市,敦煌市', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621001, '市辖区', '', '甘肃省,庆阳市,市辖区', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621002, '西峰区', '', '甘肃省,庆阳市,西峰区', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621021, '庆城县', '', '甘肃省,庆阳市,庆城县', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621022, '环　县', '', '甘肃省,庆阳市,环　县', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621023, '华池县', '', '甘肃省,庆阳市,华池县', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621024, '合水县', '', '甘肃省,庆阳市,合水县', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621025, '正宁县', '', '甘肃省,庆阳市,正宁县', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621026, '宁　县', '', '甘肃省,庆阳市,宁　县', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621027, '镇原县', '', '甘肃省,庆阳市,镇原县', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621101, '市辖区', '', '甘肃省,定西市,市辖区', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621102, '安定区', '', '甘肃省,定西市,安定区', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621121, '通渭县', '', '甘肃省,定西市,通渭县', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621122, '陇西县', '', '甘肃省,定西市,陇西县', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621123, '渭源县', '', '甘肃省,定西市,渭源县', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621124, '临洮县', '', '甘肃省,定西市,临洮县', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621125, '漳　县', '', '甘肃省,定西市,漳　县', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621126, '岷　县', '', '甘肃省,定西市,岷　县', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621201, '市辖区', '', '甘肃省,陇南市,市辖区', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621202, '武都区', '', '甘肃省,陇南市,武都区', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621221, '成　县', '', '甘肃省,陇南市,成　县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621222, '文　县', '', '甘肃省,陇南市,文　县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621223, '宕昌县', '', '甘肃省,陇南市,宕昌县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621224, '康　县', '', '甘肃省,陇南市,康　县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621225, '西和县', '', '甘肃省,陇南市,西和县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621226, '礼　县', '', '甘肃省,陇南市,礼　县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621227, '徽　县', '', '甘肃省,陇南市,徽　县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621228, '两当县', '', '甘肃省,陇南市,两当县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622901, '临夏市', '', '甘肃省,临夏回族自治州,临夏市', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622921, '临夏县', '', '甘肃省,临夏回族自治州,临夏县', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622922, '康乐县', '', '甘肃省,临夏回族自治州,康乐县', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622923, '永靖县', '', '甘肃省,临夏回族自治州,永靖县', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622924, '广河县', '', '甘肃省,临夏回族自治州,广河县', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622925, '和政县', '', '甘肃省,临夏回族自治州,和政县', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622926, '东乡族自治县', '', '甘肃省,临夏回族自治州,东乡族自治县', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622927, '积石山保安族东乡族撒拉族自治县', '', '甘肃省,临夏回族自治州,积石山保安族东乡族撒拉族自治县', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623001, '合作市', '', '甘肃省,甘南藏族自治州,合作市', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623021, '临潭县', '', '甘肃省,甘南藏族自治州,临潭县', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623022, '卓尼县', '', '甘肃省,甘南藏族自治州,卓尼县', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623023, '舟曲县', '', '甘肃省,甘南藏族自治州,舟曲县', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623024, '迭部县', '', '甘肃省,甘南藏族自治州,迭部县', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623025, '玛曲县', '', '甘肃省,甘南藏族自治州,玛曲县', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623026, '碌曲县', '', '甘肃省,甘南藏族自治州,碌曲县', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623027, '夏河县', '', '甘肃省,甘南藏族自治州,夏河县', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630101, '市辖区', '', '青海省,西宁市,市辖区', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630102, '城东区', '', '青海省,西宁市,城东区', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630103, '城中区', '', '青海省,西宁市,城中区', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630104, '城西区', '', '青海省,西宁市,城西区', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630105, '城北区', '', '青海省,西宁市,城北区', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630121, '大通回族土族自治县', '', '青海省,西宁市,大通回族土族自治县', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630122, '湟中县', '', '青海省,西宁市,湟中县', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630123, '湟源县', '', '青海省,西宁市,湟源县', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632121, '平安县', '', '青海省,海东地区,平安县', 632100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632122, '民和回族土族自治县', '', '青海省,海东地区,民和回族土族自治县', 632100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632123, '乐都县', '', '青海省,海东地区,乐都县', 632100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632126, '互助土族自治县', '', '青海省,海东地区,互助土族自治县', 632100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632127, '化隆回族自治县', '', '青海省,海东地区,化隆回族自治县', 632100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632128, '循化撒拉族自治县', '', '青海省,海东地区,循化撒拉族自治县', 632100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632221, '门源回族自治县', '', '青海省,海北藏族自治州,门源回族自治县', 632200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632222, '祁连县', '', '青海省,海北藏族自治州,祁连县', 632200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632223, '海晏县', '', '青海省,海北藏族自治州,海晏县', 632200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632224, '刚察县', '', '青海省,海北藏族自治州,刚察县', 632200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632321, '同仁县', '', '青海省,黄南藏族自治州,同仁县', 632300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632322, '尖扎县', '', '青海省,黄南藏族自治州,尖扎县', 632300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632323, '泽库县', '', '青海省,黄南藏族自治州,泽库县', 632300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632324, '河南蒙古族自治县', '', '青海省,黄南藏族自治州,河南蒙古族自治县', 632300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632521, '共和县', '', '青海省,海南藏族自治州,共和县', 632500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632522, '同德县', '', '青海省,海南藏族自治州,同德县', 632500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632523, '贵德县', '', '青海省,海南藏族自治州,贵德县', 632500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632524, '兴海县', '', '青海省,海南藏族自治州,兴海县', 632500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632525, '贵南县', '', '青海省,海南藏族自治州,贵南县', 632500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632621, '玛沁县', '', '青海省,果洛藏族自治州,玛沁县', 632600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632622, '班玛县', '', '青海省,果洛藏族自治州,班玛县', 632600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632623, '甘德县', '', '青海省,果洛藏族自治州,甘德县', 632600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632624, '达日县', '', '青海省,果洛藏族自治州,达日县', 632600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632625, '久治县', '', '青海省,果洛藏族自治州,久治县', 632600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632626, '玛多县', '', '青海省,果洛藏族自治州,玛多县', 632600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632721, '玉树县', '', '青海省,玉树藏族自治州,玉树县', 632700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632722, '杂多县', '', '青海省,玉树藏族自治州,杂多县', 632700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632723, '称多县', '', '青海省,玉树藏族自治州,称多县', 632700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632724, '治多县', '', '青海省,玉树藏族自治州,治多县', 632700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632725, '囊谦县', '', '青海省,玉树藏族自治州,囊谦县', 632700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632726, '曲麻莱县', '', '青海省,玉树藏族自治州,曲麻莱县', 632700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632801, '格尔木市', '', '青海省,海西蒙古族藏族自治州,格尔木市', 632800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632802, '德令哈市', '', '青海省,海西蒙古族藏族自治州,德令哈市', 632800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632821, '乌兰县', '', '青海省,海西蒙古族藏族自治州,乌兰县', 632800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632822, '都兰县', '', '青海省,海西蒙古族藏族自治州,都兰县', 632800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632823, '天峻县', '', '青海省,海西蒙古族藏族自治州,天峻县', 632800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640101, '市辖区', '', '宁夏回族自治区,银川市,市辖区', 640100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640104, '兴庆区', '', '宁夏回族自治区,银川市,兴庆区', 640100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640105, '西夏区', '', '宁夏回族自治区,银川市,西夏区', 640100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640106, '金凤区', '', '宁夏回族自治区,银川市,金凤区', 640100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640121, '永宁县', '', '宁夏回族自治区,银川市,永宁县', 640100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640122, '贺兰县', '', '宁夏回族自治区,银川市,贺兰县', 640100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640181, '灵武市', '', '宁夏回族自治区,银川市,灵武市', 640100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640201, '市辖区', '', '宁夏回族自治区,石嘴山市,市辖区', 640200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640202, '大武口区', '', '宁夏回族自治区,石嘴山市,大武口区', 640200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640205, '惠农区', '', '宁夏回族自治区,石嘴山市,惠农区', 640200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640221, '平罗县', '', '宁夏回族自治区,石嘴山市,平罗县', 640200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640301, '市辖区', '', '宁夏回族自治区,吴忠市,市辖区', 640300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640302, '利通区', '', '宁夏回族自治区,吴忠市,利通区', 640300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640323, '盐池县', '', '宁夏回族自治区,吴忠市,盐池县', 640300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640324, '同心县', '', '宁夏回族自治区,吴忠市,同心县', 640300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640381, '青铜峡市', '', '宁夏回族自治区,吴忠市,青铜峡市', 640300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640401, '市辖区', '', '宁夏回族自治区,固原市,市辖区', 640400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640402, '原州区', '', '宁夏回族自治区,固原市,原州区', 640400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640422, '西吉县', '', '宁夏回族自治区,固原市,西吉县', 640400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640423, '隆德县', '', '宁夏回族自治区,固原市,隆德县', 640400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640424, '泾源县', '', '宁夏回族自治区,固原市,泾源县', 640400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640425, '彭阳县', '', '宁夏回族自治区,固原市,彭阳县', 640400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640501, '市辖区', '', '宁夏回族自治区,中卫市,市辖区', 640500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640502, '沙坡头区', '', '宁夏回族自治区,中卫市,沙坡头区', 640500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640521, '中宁县', '', '宁夏回族自治区,中卫市,中宁县', 640500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640522, '海原县', '', '宁夏回族自治区,中卫市,海原县', 640500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650101, '市辖区', '', '新疆维吾尔自治区,乌鲁木齐市,市辖区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650102, '天山区', '', '新疆维吾尔自治区,乌鲁木齐市,天山区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650103, '沙依巴克区', '', '新疆维吾尔自治区,乌鲁木齐市,沙依巴克区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650104, '新市区', '', '新疆维吾尔自治区,乌鲁木齐市,新市区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650105, '水磨沟区', '', '新疆维吾尔自治区,乌鲁木齐市,水磨沟区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650106, '头屯河区', '', '新疆维吾尔自治区,乌鲁木齐市,头屯河区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650107, '达坂城区', '', '新疆维吾尔自治区,乌鲁木齐市,达坂城区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650108, '东山区', '', '新疆维吾尔自治区,乌鲁木齐市,东山区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650121, '乌鲁木齐县', '', '新疆维吾尔自治区,乌鲁木齐市,乌鲁木齐县', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650201, '市辖区', '', '新疆维吾尔自治区,克拉玛依市,市辖区', 650200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650202, '独山子区', '', '新疆维吾尔自治区,克拉玛依市,独山子区', 650200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650203, '克拉玛依区', '', '新疆维吾尔自治区,克拉玛依市,克拉玛依区', 650200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650204, '白碱滩区', '', '新疆维吾尔自治区,克拉玛依市,白碱滩区', 650200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650205, '乌尔禾区', '', '新疆维吾尔自治区,克拉玛依市,乌尔禾区', 650200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652101, '吐鲁番市', '', '新疆维吾尔自治区,吐鲁番地区,吐鲁番市', 652100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652122, '鄯善县', '', '新疆维吾尔自治区,吐鲁番地区,鄯善县', 652100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652123, '托克逊县', '', '新疆维吾尔自治区,吐鲁番地区,托克逊县', 652100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652201, '哈密市', '', '新疆维吾尔自治区,哈密地区,哈密市', 652200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652222, '巴里坤哈萨克自治县', '', '新疆维吾尔自治区,哈密地区,巴里坤哈萨克自治县', 652200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652223, '伊吾县', '', '新疆维吾尔自治区,哈密地区,伊吾县', 652200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652301, '昌吉市', '', '新疆维吾尔自治区,昌吉回族自治州,昌吉市', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652302, '阜康市', '', '新疆维吾尔自治区,昌吉回族自治州,阜康市', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652303, '米泉市', '', '新疆维吾尔自治区,昌吉回族自治州,米泉市', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652323, '呼图壁县', '', '新疆维吾尔自治区,昌吉回族自治州,呼图壁县', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652324, '玛纳斯县', '', '新疆维吾尔自治区,昌吉回族自治州,玛纳斯县', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652325, '奇台县', '', '新疆维吾尔自治区,昌吉回族自治州,奇台县', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652327, '吉木萨尔县', '', '新疆维吾尔自治区,昌吉回族自治州,吉木萨尔县', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652328, '木垒哈萨克自治县', '', '新疆维吾尔自治区,昌吉回族自治州,木垒哈萨克自治县', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652701, '博乐市', '', '新疆维吾尔自治区,博尔塔拉蒙古自治州,博乐市', 652700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652722, '精河县', '', '新疆维吾尔自治区,博尔塔拉蒙古自治州,精河县', 652700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652723, '温泉县', '', '新疆维吾尔自治区,博尔塔拉蒙古自治州,温泉县', 652700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652801, '库尔勒市', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,库尔勒市', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652822, '轮台县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,轮台县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652823, '尉犁县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,尉犁县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652824, '若羌县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,若羌县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652825, '且末县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,且末县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652826, '焉耆回族自治县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,焉耆回族自治县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652827, '和静县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,和静县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652828, '和硕县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,和硕县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652829, '博湖县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,博湖县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652901, '阿克苏市', '', '新疆维吾尔自治区,阿克苏地区,阿克苏市', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652922, '温宿县', '', '新疆维吾尔自治区,阿克苏地区,温宿县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652923, '库车县', '', '新疆维吾尔自治区,阿克苏地区,库车县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652924, '沙雅县', '', '新疆维吾尔自治区,阿克苏地区,沙雅县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652925, '新和县', '', '新疆维吾尔自治区,阿克苏地区,新和县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652926, '拜城县', '', '新疆维吾尔自治区,阿克苏地区,拜城县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652927, '乌什县', '', '新疆维吾尔自治区,阿克苏地区,乌什县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652928, '阿瓦提县', '', '新疆维吾尔自治区,阿克苏地区,阿瓦提县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652929, '柯坪县', '', '新疆维吾尔自治区,阿克苏地区,柯坪县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653001, '阿图什市', '', '新疆维吾尔自治区,克孜勒苏柯尔克孜自治州,阿图什市', 653000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653022, '阿克陶县', '', '新疆维吾尔自治区,克孜勒苏柯尔克孜自治州,阿克陶县', 653000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653023, '阿合奇县', '', '新疆维吾尔自治区,克孜勒苏柯尔克孜自治州,阿合奇县', 653000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653024, '乌恰县', '', '新疆维吾尔自治区,克孜勒苏柯尔克孜自治州,乌恰县', 653000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653101, '喀什市', '', '新疆维吾尔自治区,喀什地区,喀什市', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653121, '疏附县', '', '新疆维吾尔自治区,喀什地区,疏附县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653122, '疏勒县', '', '新疆维吾尔自治区,喀什地区,疏勒县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653123, '英吉沙县', '', '新疆维吾尔自治区,喀什地区,英吉沙县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653124, '泽普县', '', '新疆维吾尔自治区,喀什地区,泽普县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653125, '莎车县', '', '新疆维吾尔自治区,喀什地区,莎车县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653126, '叶城县', '', '新疆维吾尔自治区,喀什地区,叶城县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653127, '麦盖提县', '', '新疆维吾尔自治区,喀什地区,麦盖提县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653128, '岳普湖县', '', '新疆维吾尔自治区,喀什地区,岳普湖县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653129, '伽师县', '', '新疆维吾尔自治区,喀什地区,伽师县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653130, '巴楚县', '', '新疆维吾尔自治区,喀什地区,巴楚县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653131, '塔什库尔干塔吉克自治县', '', '新疆维吾尔自治区,喀什地区,塔什库尔干塔吉克自治县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653201, '和田市', '', '新疆维吾尔自治区,和田地区,和田市', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653221, '和田县', '', '新疆维吾尔自治区,和田地区,和田县', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653222, '墨玉县', '', '新疆维吾尔自治区,和田地区,墨玉县', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653223, '皮山县', '', '新疆维吾尔自治区,和田地区,皮山县', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653224, '洛浦县', '', '新疆维吾尔自治区,和田地区,洛浦县', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653225, '策勒县', '', '新疆维吾尔自治区,和田地区,策勒县', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653226, '于田县', '', '新疆维吾尔自治区,和田地区,于田县', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653227, '民丰县', '', '新疆维吾尔自治区,和田地区,民丰县', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654002, '伊宁市', '', '新疆维吾尔自治区,伊犁哈萨克自治州,伊宁市', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654003, '奎屯市', '', '新疆维吾尔自治区,伊犁哈萨克自治州,奎屯市', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654021, '伊宁县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,伊宁县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654022, '察布查尔锡伯自治县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,察布查尔锡伯自治县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654023, '霍城县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,霍城县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654024, '巩留县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,巩留县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654025, '新源县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,新源县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654026, '昭苏县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,昭苏县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654027, '特克斯县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,特克斯县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654028, '尼勒克县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,尼勒克县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654201, '塔城市', '', '新疆维吾尔自治区,塔城地区,塔城市', 654200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654202, '乌苏市', '', '新疆维吾尔自治区,塔城地区,乌苏市', 654200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654221, '额敏县', '', '新疆维吾尔自治区,塔城地区,额敏县', 654200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654223, '沙湾县', '', '新疆维吾尔自治区,塔城地区,沙湾县', 654200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654224, '托里县', '', '新疆维吾尔自治区,塔城地区,托里县', 654200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654225, '裕民县', '', '新疆维吾尔自治区,塔城地区,裕民县', 654200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654226, '和布克赛尔蒙古自治县', '', '新疆维吾尔自治区,塔城地区,和布克赛尔蒙古自治县', 654200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654301, '阿勒泰市', '', '新疆维吾尔自治区,阿勒泰地区,阿勒泰市', 654300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654321, '布尔津县', '', '新疆维吾尔自治区,阿勒泰地区,布尔津县', 654300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654322, '富蕴县', '', '新疆维吾尔自治区,阿勒泰地区,富蕴县', 654300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654323, '福海县', '', '新疆维吾尔自治区,阿勒泰地区,福海县', 654300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654324, '哈巴河县', '', '新疆维吾尔自治区,阿勒泰地区,哈巴河县', 654300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654325, '青河县', '', '新疆维吾尔自治区,阿勒泰地区,青河县', 654300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654326, '吉木乃县', '', '新疆维吾尔自治区,阿勒泰地区,吉木乃县', 654300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (659001, '石河子市', '', '新疆维吾尔自治区,省直辖行政单位,石河子市', 659000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (659002, '阿拉尔市', '', '新疆维吾尔自治区,省直辖行政单位,阿拉尔市', 659000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (659003, '图木舒克市', '', '新疆维吾尔自治区,省直辖行政单位,图木舒克市', 659000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (659004, '五家渠市', '', '新疆维吾尔自治区,省直辖行政单位,五家渠市', 659000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810001, '香港', '', '香港特别行政区,香港', 810000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (810002, '中西区', '', '香港特别行政区,香港,中西区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810003, '九龙城区', '', '香港特别行政区,香港,九龙城区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810004, '南区', '', '香港特别行政区,香港,南区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810005, '黄大仙区', '', '香港特别行政区,香港,黄大仙区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810006, '油尖旺区', '', '香港特别行政区,香港,油尖旺区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810007, '葵青区', '', '香港特别行政区,香港,葵青区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810008, '西贡区', '', '香港特别行政区,香港,西贡区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810009, '屯门区', '', '香港特别行政区,香港,屯门区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810010, '荃湾区', '', '香港特别行政区,香港,荃湾区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810011, '东区', '', '香港特别行政区,香港,东区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810012, '观塘区', '', '香港特别行政区,香港,观塘区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810013, '深水步区', '', '香港特别行政区,香港,深水步区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810014, '湾仔区', '', '香港特别行政区,香港,湾仔区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810015, '离岛区', '', '香港特别行政区,香港,离岛区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810016, '北区', '', '香港特别行政区,香港,北区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810017, '沙田区', '', '香港特别行政区,香港,沙田区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810018, '大埔区', '', '香港特别行政区,香港,大埔区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810019, '元朗区', '', '香港特别行政区,香港,元朗区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (820001, '澳门', '', '澳门特别行政区,澳门', 820000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (820002, '澳门特别行政区', '', '澳门特别行政区,澳门,澳门', 820001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (710001, '台北市', '', '台湾省,台北市', 710000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (710002, '台北县', '', '台湾省,台北市,台北县', 710001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (710003, '基隆市', '', '台湾省,基隆市', 710000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (910005, '中山市', '', '广东省,中山市,中山市', 442000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (710004, '花莲县', '', '台湾省,基隆市,花莲县', 710003, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (910006, '东莞市', '', '广东省,东莞市,东莞市', 441900, 3, 0, '', 0);

-- ----------------------------
-- Table structure for wp_currency
-- ----------------------------
DROP TABLE IF EXISTS `wp_currency`;
CREATE TABLE `wp_currency`  (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `currency_code` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '货币代码',
  `currency_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '货币名称',
  `currency_tag` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '该币种通常叫法',
  `currency_sign` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '货币符号',
  `currency_rate` decimal(10, 4) NOT NULL DEFAULT 1.0000 COMMENT '汇率',
  `is_state` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1,0无效',
  PRIMARY KEY (`id`, `currency_code`) USING BTREE,
  INDEX `ind_disabled`(`is_state`) USING BTREE,
  INDEX `currency_code`(`currency_code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_currency
-- ----------------------------
INSERT INTO `wp_currency` VALUES (1, 'CNY', '人民币', '元', '￥', 1.0000, 1);
INSERT INTO `wp_currency` VALUES (2, 'HKD', '港元', '港元', 'HK', 1.0000, 1);
INSERT INTO `wp_currency` VALUES (3, 'USD', '美元', '美元', '＄', 1.0000, 1);
INSERT INTO `wp_currency` VALUES (4, 'EUR', '欧元', '欧元', '€', 1.0000, 1);
INSERT INTO `wp_currency` VALUES (5, 'GBP', '英镑', '英镑', '￡', 1.0000, 1);
INSERT INTO `wp_currency` VALUES (6, 'DEM', '马克', '马克', 'DM', 1.0000, 1);

-- ----------------------------
-- Table structure for wp_dict_option_type
-- ----------------------------
DROP TABLE IF EXISTS `wp_dict_option_type`;
CREATE TABLE `wp_dict_option_type`  (
  `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type_tag` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_dict_option_type
-- ----------------------------
INSERT INTO `wp_dict_option_type` VALUES (1, '无', 'none');
INSERT INTO `wp_dict_option_type` VALUES (2, '新商品', 'new');
INSERT INTO `wp_dict_option_type` VALUES (3, '热门商品', 'hot');

-- ----------------------------
-- Table structure for wp_extension
-- ----------------------------
DROP TABLE IF EXISTS `wp_extension`;
CREATE TABLE `wp_extension`  (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `user_id` int(12) NULL DEFAULT NULL COMMENT '用户id',
  `money` decimal(12, 2) NULL DEFAULT 0.00 COMMENT '可提取金额',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `create_time` int(12) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '佣金表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_extension
-- ----------------------------
INSERT INTO `wp_extension` VALUES (1, 5, 0.00, '2018-05-29 11:33:52', 1527564832);

-- ----------------------------
-- Table structure for wp_fee_receive
-- ----------------------------
DROP TABLE IF EXISTS `wp_fee_receive`;
CREATE TABLE `wp_fee_receive`  (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `order_id` int(12) NULL DEFAULT NULL COMMENT '订单流水 id',
  `user_id` int(12) NULL DEFAULT NULL COMMENT '领取人id  0表示交易所',
  `profit` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '佣金收益',
  `profit_rmb` decimal(60, 2) NULL DEFAULT 0.00 COMMENT '人民币佣金收益',
  `fee_rmb` decimal(10, 2) NULL DEFAULT NULL COMMENT '手续费 人民币',
  `type` tinyint(2) NULL DEFAULT NULL COMMENT '类型 1用户 2交易所 3运营中心  4 经纪人',
  `status` tinyint(1) NULL DEFAULT 2 COMMENT '1已经发放  2未发放',
  `purchaser_id` int(12) NULL DEFAULT NULL COMMENT '购买人id',
  `create_time` int(12) NULL DEFAULT NULL,
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `type`(`type`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `purchaser_id`(`purchaser_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wp_jl_banks
-- ----------------------------
DROP TABLE IF EXISTS `wp_jl_banks`;
CREATE TABLE `wp_jl_banks`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `order_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '快捷绑卡订单号',
  `contract_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '绑卡协议号',
  `phone` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '绑卡手机号',
  `id_no` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '证件号码',
  `card_no` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '银行卡号',
  `user_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '银行预留姓名',
  `bank_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '银行名称',
  `bank_abbr` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '银行缩写',
  `card_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '卡类型 0储蓄开 1信用卡',
  `card_sts` tinyint(1) NOT NULL DEFAULT 3 COMMENT '0.生效 1.无效 2.删除 3.短信待验证',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wp_journal
-- ----------------------------
DROP TABLE IF EXISTS `wp_journal`;
CREATE TABLE `wp_journal`  (
  `jno` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '日志编号',
  `uid` int(11) NULL DEFAULT NULL,
  `jtype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '平仓' COMMENT '操作类型，建仓，平仓',
  `jtime` int(20) NULL DEFAULT NULL COMMENT '操作时间',
  `jincome` double(255, 2) NULL DEFAULT NULL COMMENT '收支金额',
  `number` int(11) NULL DEFAULT NULL COMMENT '手数',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注： 产品名称',
  `balance` decimal(65, 2) NULL DEFAULT NULL COMMENT '用户余额',
  `jstate` int(11) NULL DEFAULT NULL COMMENT '0亏损，1盈利',
  `jusername` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `jostyle` int(11) NULL DEFAULT NULL COMMENT '0涨，1跌',
  `juprice` decimal(11, 2) NULL DEFAULT NULL COMMENT '产品单价',
  `jfee` decimal(11, 2) NULL DEFAULT 0.00 COMMENT '手续费',
  `jbuyprice` decimal(11, 5) NULL DEFAULT 0.00000 COMMENT '进仓价',
  `jsellprice` decimal(11, 5) NULL DEFAULT 0.00000 COMMENT '平仓价',
  `jaccess` decimal(11, 2) NULL DEFAULT NULL COMMENT '出入金额',
  `jploss` decimal(11, 2) NULL DEFAULT 0.00 COMMENT '盈亏金额',
  `oid` int(10) NULL DEFAULT NULL COMMENT '订单id',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `type` tinyint(1) NULL DEFAULT NULL COMMENT '1真实交易 2虚拟交易',
  `auto` tinyint(1) NULL DEFAULT NULL COMMENT '1 手动平仓 2自动平仓',
  `id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `jtime`(`jtime`) USING BTREE,
  INDEX `remarks`(`remarks`) USING BTREE,
  INDEX `jostyle`(`jostyle`) USING BTREE,
  INDEX `auto`(`auto`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `type`(`type`) USING BTREE,
  INDEX `jtype`(`jtype`) USING BTREE,
  INDEX `jusername`(`jusername`) USING BTREE,
  INDEX `auto_j`(`uid`, `jtype`, `oid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wp_login_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_login_log`;
CREATE TABLE `wp_login_log`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) UNSIGNED NOT NULL COMMENT '哪个用户ID',
  `uname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `cTime` datetime(0) NULL DEFAULT NULL COMMENT '登录时间',
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'IP',
  `status` tinyint(1) NULL DEFAULT 0 COMMENT '1为登录成功，0为失败',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wp_managerinfo
-- ----------------------------
DROP TABLE IF EXISTS `wp_managerinfo`;
CREATE TABLE `wp_managerinfo`  (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `poid` int(11) NULL DEFAULT NULL COMMENT '持仓人',
  `coid` int(11) NULL DEFAULT NULL COMMENT '平仓人',
  `mname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '法人名字',
  `brokerid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '法人代表身份证',
  `photoid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '会员资质',
  PRIMARY KEY (`mid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wp_money_flow
-- ----------------------------
DROP TABLE IF EXISTS `wp_money_flow`;
CREATE TABLE `wp_money_flow`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT 0 COMMENT '用户id',
  `type` smallint(2) NOT NULL DEFAULT 1 COMMENT '1持仓，2平仓，3提现，4充值，5佣金转入',
  `oid` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '关联的id号',
  `note` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '事件备注',
  `op_id` int(10) NOT NULL DEFAULT 0 COMMENT '操作人uid号,或管理员id',
  `balance` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '用户余额剩余',
  `dateline` int(10) NOT NULL DEFAULT 0 COMMENT '操作时间，时间戳格式',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `user_type` smallint(2) NOT NULL DEFAULT 1 COMMENT '用户类型 1普通用户  2运营中心',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `type`(`type`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `dateline`(`dateline`) USING BTREE,
  INDEX `user_type`(`user_type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '资金流动表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wp_newsclass
-- ----------------------------
DROP TABLE IF EXISTS `wp_newsclass`;
CREATE TABLE `wp_newsclass`  (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `fclass` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `isshow` tinyint(1) NULL DEFAULT 1 COMMENT '是否显示',
  `methodnm` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '分类类型，0系统分类，1默认-普通分类，2图片分类-用于轮换',
  PRIMARY KEY (`fid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '新闻分类表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_newsclass
-- ----------------------------
INSERT INTO `wp_newsclass` VALUES (1, '最新资讯', '2016-12-21 16:51:43', 1, 'News/index', 1);
INSERT INTO `wp_newsclass` VALUES (2, '最新行情', '2017-01-05 11:19:07', 1, 'News/analyse', 1);
INSERT INTO `wp_newsclass` VALUES (3, '行业资讯', '2016-11-23 16:38:59', 1, 'News/news', 1);
INSERT INTO `wp_newsclass` VALUES (5, '图片分类', '2017-01-04 16:31:15', 1, NULL, 2);
INSERT INTO `wp_newsclass` VALUES (6, '新手指引', '2017-01-04 16:31:21', 1, NULL, 1);
INSERT INTO `wp_newsclass` VALUES (7, '充值提示', '2018-09-11 17:51:07', 1, NULL, 1);
INSERT INTO `wp_newsclass` VALUES (8, '提现提示', '2018-09-11 17:51:16', 1, NULL, 1);

-- ----------------------------
-- Table structure for wp_newsinfo
-- ----------------------------
DROP TABLE IF EXISTS `wp_newsinfo`;
CREATE TABLE `wp_newsinfo`  (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `ntitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `ncontent` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容',
  `ncover` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '缩略图',
  `ncategory` int(11) NULL DEFAULT NULL COMMENT '新闻分类id',
  `ntime` int(20) NULL DEFAULT NULL COMMENT '发布时间',
  `start_date` int(11) NULL DEFAULT NULL COMMENT '活动开始时间',
  `end_date` int(11) NULL DEFAULT NULL COMMENT '活动结束时间',
  `temptime` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`nid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '新闻公告表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_newsinfo
-- ----------------------------
INSERT INTO `wp_newsinfo` VALUES (18, '新手指引', '&lt;p style=&quot;text-align: center;&quot;&gt;&lt;img src=&quot;http://hjb.hjb58.com/Uploads/2017-03-09/58c0d6cac5bbe.png&quot; alt=&quot;图片&quot;&gt;&lt;img src=&quot;http://hjb.hjb58.com/Uploads/2017-03-09/58c0d6cfbb3d2.png&quot; alt=&quot;图片&quot;&gt;&lt;img src=&quot;http://hjb.hjb58.com/Uploads/2017-03-09/58c0d6d407734.png&quot; alt=&quot;图片&quot;&gt;&lt;img src=&quot;http://hjb.hjb58.com/Uploads/2017-03-09/58c0d6da380ba.png&quot; alt=&quot;图片&quot;&gt;&lt;img src=&quot;http://hjb.hjb58.com/Uploads/2017-03-09/58c0d6dd1d75a.png&quot; alt=&quot;图片&quot;&gt;&lt;/p&gt;', '2016-11-16/582c41491c4b5.jpg', 6, 1488988800, NULL, NULL, '2017-03-09 12:15:33');
INSERT INTO `wp_newsinfo` VALUES (23, '风险提示', '  \r\n							    \r\n							    \r\n							    \r\n							  &lt;p&gt;风险提示：&lt;/p&gt;&lt;p&gt;一、期货交易本身是杠杆较高的交易方式，面临较高的本金亏损风险。&lt;/p&gt;&lt;p&gt;二、平台对接优先资金为外盘期货交易提供了更高的杠杆，在便捷交易的同时，也促成了更大的亏损风险。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;三、资金方优先资金有较高成本，因此交易手续费相较于交易所收费标准更高，高昂的交易成本也不利于投资者获利。&lt;/p&gt;&lt;p&gt;四、综合二、三，同时提高了交易杠杆和交易成本，客观上提高了投资者的亏损风险；请自行控制杠杆（合理调整止损点数）和交易成本（减少交易频率）。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;五、投资者通过平台的报单交易100%实盘入场撮合成交，投资者盈亏与交易平台无关，平台仅为您对接实盘交易主账户及由易盛信息提供的外盘API下单通道。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;六、平台本身并非期货公司，也并不提供经纪业务，仅做软件开发和服务，投资者如不认可平台在交易中的角色，请不要参与交易。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;请投资者清楚了解以上风险，以学习为主，谨慎投入实盘资金，如遇亏损请适可而止，并自行承担一切风险。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;如有异议，请不要参与交易！&lt;/p&gt;																												', '2017-01-24/5886d6fdd6716.jpg', 5, 1485187200, NULL, NULL, '2017-01-24 13:38:11');
INSERT INTO `wp_newsinfo` VALUES (24, '严控风险', '  \r\n							    \r\n							  &lt;p&gt;一、期货交易属于期货撮合交易，不同于现货otc见价成交的交易模式，和国内股票交易一&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;样，您的订单需发往交易所内寻找对手撮合成交，默认采用“市价”下单，是当下时点可以成交&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;的最优价格，但仍可能与您预期的价格不一致，您需要无条件理解并接受此价格。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;二、由于撮合交易和市价下单的特性，当您的账户出现止损或者强平时，止损或强平价格有可能超过系&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;统所设定的价格，导致实际亏损超出预期，以及亏损到超出您保证金的余额，甚至使您的账户金额为负&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;值——俗称“穿仓”，您需要无条件理解并承担穿仓带来的风险。当然，止损止盈或强平时也有可能获&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;得更有利于持仓方向的价格，例如“赢的更多，或者亏得更少”，这都是由于撮合交易的性质所决定的&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;三、系统提供的止盈止损是模式化的交易形式，目的是使交易更加简便和科学，每笔订单到达系&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;统设定的止盈止损点之前，您都可以根据行情变化随时平仓。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;四、系统仅提供下单通道，所有客户的交易订单均通过国内及香港期货公司主账户报往国内、国际各&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;大期货交易所撮合成交，如【香港交易所】、【芝加哥商品交易所】、【新加坡期货交易所】、【欧洲&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;期货交易所】、【上海期货交易所】、【大连商品交易所】、【郑州商品交易所】、【中国金融期货交&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;易所】。您的订单由您本人意愿报往场内与其他投资者撮合成交，平台仅代收交易所手续费以及提供。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;合作交易的资金方收取的手续费，交易盈亏都由您自行承担，如您对此有任何异议，请不要参与本交易&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;风险提示：&lt;/p&gt;&lt;p&gt;一、期货交易本身是杠杆较高的交易方式，面临较高的本金亏损风险。&lt;/p&gt;&lt;p&gt;二、系统对接优先资金为外盘期货交易提供了更高的杠杆，在便捷交易的同时，也促成了更大的亏损&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;风险。&lt;/p&gt;&lt;p&gt;三、资金方优先资金有较高成本，因此交易手续费相较于交易所收费标准更高，高昂的交易成本也不利&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;于投资者获利。&lt;/p&gt;&lt;p&gt;四、综合二、三，同时提高了交易杠杆和交易成本，客观上提高了投资者的亏损风险；请自行控&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;制杠杆（合理调整止损点数）和交易成本（减少交易频率）。&lt;/p&gt;&lt;p&gt;五、投资者通过平台的报单交易100%实盘入场撮合成交，投资者盈亏与交易平台无关，&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;平台仅为您对接实盘交易主账户及由易盛信息提供的外盘API下单通道。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;六、平台本身并非期货公司，也并不提供经纪业务，仅做软件开发和服务，投资者如不认可平台在&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;交易中的角色，请不要参与交易。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;请投资者清楚了解以上风险，以学习为主，谨慎投入实盘资金，如遇亏损请适可而止，并自行承担一切&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;风险。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;如有异议，请不要参与交易！&lt;/p&gt;  \r\n							  																					', '2017-01-24/5886d8f3f2dfa.jpg', 5, 1485187200, NULL, NULL, '2017-01-24 13:33:38');
INSERT INTO `wp_newsinfo` VALUES (25, '充值温馨提示', '  \r\n							    \r\n							    \r\n							    \r\n							  &lt;p class=&quot;text-highs&quot;&gt;温馨提示:&lt;/p&gt;&lt;p&gt;&lt;span&gt;1：付款之后请把‘支付凭证’以及在该平台登录‘手机号’发送给客服，&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;2：客服微信：DQ6175000&lt;/span&gt;&lt;/p&gt;																												', '2018-09-11/5b9791eb903b5.png', 7, 1536854400, NULL, NULL, '2018-09-14 11:28:57');
INSERT INTO `wp_newsinfo` VALUES (26, '提现温馨提示', '  \r\n							    \r\n							  &lt;p class=&quot;text-highs&quot;&gt;温馨提示:&lt;/p&gt;&lt;p&gt;1、消费用户提款每笔2元手续费。单笔出金金额最少12元。为防止恶意提款。每日提款申请次数最多为2次。超过次日处理&lt;/p&gt;&lt;p&gt;2、单笔充值无消费者提现时需提供身份证与银行卡给客服进行核实。如信息核实无误。将会在7-15个工作日内处理。未操作 者收取8%的手续费。最低2元；&lt;/p&gt;&lt;p&gt;3、周一至周五09:00-17:00以后的提款申请延至第二天处理。周五17:00后提款，延至下个工作日处理。提现到账时间最快2小时，最晚1个工作日，如遇节假日顺延。&lt;/p&gt;&lt;p&gt;4、周六周日提款延迟到周一处理，若节假日提款，一律节后第一个工作日处理。&lt;/p&gt;  \r\n							  																					', '2018-09-11/5b9792403663d.png', 8, 1537977600, NULL, NULL, '2018-09-27 08:48:52');

-- ----------------------------
-- Table structure for wp_option
-- ----------------------------
DROP TABLE IF EXISTS `wp_option`;
CREATE TABLE `wp_option`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_key` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '商品唯一编码',
  `capital_key` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT '资产类型',
  `capital_name` char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '资产名称',
  `capital_type` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL COMMENT '交易所名称',
  `commission` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '手续费',
  `start_time` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '开始时间 单位是分钟',
  `end_time` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '结束时间 单位是分钟',
  `sell_flag` int(1) UNSIGNED NULL DEFAULT 0 COMMENT '平仓状态，通过系统平常时间来判断，设置提前几分钟平仓,1正常运行不需要平仓，0进行平仓',
  `flag` int(11) NULL DEFAULT NULL COMMENT '开启1，关闭0',
  `global_flag` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '是否交易状态总开关，默认1，允许交易，0，关闭交易',
  `edit_time` int(11) NULL DEFAULT NULL COMMENT '编辑时间',
  `capital_dot_length` int(11) UNSIGNED NOT NULL DEFAULT 5 COMMENT '品种 波动点数',
  `Price` float NULL DEFAULT 0 COMMENT '当前价格(最新价格)',
  `Open` float NULL DEFAULT NULL COMMENT '今开',
  `Close` float NULL DEFAULT NULL COMMENT '昨收',
  `High` float NULL DEFAULT NULL COMMENT '最高',
  `Low` float NULL DEFAULT NULL COMMENT '最低',
  `Diff` float NULL DEFAULT NULL COMMENT '涨跌',
  `DiffRate` decimal(10, 2) NULL DEFAULT NULL COMMENT '涨跌幅度',
  `wave` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '每点 波动金额',
  `bp` decimal(10, 5) NULL DEFAULT NULL COMMENT '买入价',
  `bv` decimal(10, 0) NULL DEFAULT NULL COMMENT '买入量',
  `sp` decimal(10, 5) NULL DEFAULT NULL COMMENT '卖出价',
  `sv` decimal(10, 0) NULL DEFAULT NULL COMMENT '卖出量',
  `pid` int(12) NULL DEFAULT NULL COMMENT '分类id',
  `currency` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0.00' COMMENT '货币类型 USD美元 HKD港币 EUR欧元 ',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `capital_key`(`capital_key`) USING BTREE,
  INDEX `global_flag`(`global_flag`) USING BTREE,
  INDEX `flag`(`flag`) USING BTREE,
  INDEX `sell_flag`(`sell_flag`) USING BTREE,
  INDEX `currency`(`currency`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 74 CHARACTER SET = utf8 COLLATE = utf8_bin COMMENT = '产品表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_option
-- ----------------------------
INSERT INTO `wp_option` VALUES (10, 'HKSHI', 'HX_HSI', '恒指', '香港交易所', 0.00, '0900', '2359', 1, 1, 1, 1582357830, 1, 27280, 0, 27200, 27335, 27214, 80, 0.29, 45.00, 27280.00000, 6, 27281.00000, 2, 7, 'CNY', '2023-02-17 10:12:08');
INSERT INTO `wp_option` VALUES (59, 'HKCLG', 'hf_CL', '美原油', '纽约商业交易所', 0.00, '0900', '2000', 1, 1, 1, 1582357830, 100, 53.46, 0, 53.88, 53.86, 52.55, -0.42, -0.78, 70.00, 53.45000, 1, 53.46000, 2, 7, 'CNY', '2023-02-17 10:12:08');
INSERT INTO `wp_option` VALUES (60, 'HKGCG', 'hf_GC', '美黄金', '纽约商业交易所', 0.00, '1400', '2359', 1, 1, 1, 1582357830, 10, 1645.9, 0, 1620.5, 1652.1, 1621.6, 25.4, 1.57, 70.00, 1645.90000, 3, 1646.00000, 1, 7, 'CNY', '2023-02-17 10:12:08');
INSERT INTO `wp_option` VALUES (62, 'HKSIH', 'hf_SI', '美白银', '芝加哥商品交易所', 0.00, '1400', '2359', 1, 1, 1, 1582357830, 200, 18.455, 0, 18.319, 18.625, 18.335, 0.136, 0.74, 175.00, 18.45500, 2, 18.46000, 2, 7, 'CNY', '2023-02-17 10:12:08');
INSERT INTO `wp_option` VALUES (66, 'HKMHI', 'HX_MHI', '小恒指', '香港交易所', 0.00, '1400', '1300', 1, 1, 1, 1582357830, 1, 27271, 0, 27200, 27334, 27213, 71, 0.26, 9.00, 27270.00000, 8, 27271.00000, 1, 7, 'CNY', '2023-02-17 10:12:08');
INSERT INTO `wp_option` VALUES (67, 'HKCLG', 'hf_OIL', '小美原油', '纽约商业交易所', 0.00, '0900', '2000', 1, 1, 1, 1582357830, 100, 53.46, 0, 53.88, 53.86, 52.55, -0.42, -0.78, 7.00, 53.45000, 1, 53.46000, 2, 7, 'CNY', '2023-02-17 10:12:08');
INSERT INTO `wp_option` VALUES (68, 'HKSH0', 'nf_IF0', '沪深300', '纽约商业交易所', 0.00, '0900', '2000', 1, 1, 1, 1582268400, 100, 4158.6, 4130.2, 4137.6, 4192.6, 4130, 21, 0.51, 300.00, 4158.60000, 3, 4159.00000, 2, 6, 'CNY', '2023-02-17 10:12:08');
INSERT INTO `wp_option` VALUES (69, 'HKNFS', 'nf_SC0', '上海原油', '纽约商业交易所', 0.00, '0900', '2000', 1, 1, 1, 1582268402, 100, 415.4, 418, 419.6, 419.3, 413.6, -4.2, -1.00, 10.00, 415.40000, 2, 415.50000, 1, 6, 'CNY', '2023-02-17 10:12:08');
INSERT INTO `wp_option` VALUES (70, 'HKHFN', 'hf_NG', '天然气', '纽约商业交易所', 0.00, '0900', '2000', 1, 1, 1, 1582322390, 100, 1.917, 1.924, 1.931, 1.93, 1.874, -0.014, -0.73, 70.00, 1.91500, 1, 1.91600, 8, 7, 'CNY', '2023-02-17 10:12:08');
INSERT INTO `wp_option` VALUES (71, 'HKHFH', 'hf_CAD', '美铜', '纽约商业交易所', 0.00, '0900', '2000', 1, 1, 1, 1582357830, 200, 2.602, 0, 2.588, 2.6175, 2.5605, 0.014, 0.54, 100.00, 2.60150, 4, 2.60250, 1, 7, 'CNY', '2023-02-17 10:12:08');
INSERT INTO `wp_option` VALUES (72, 'HKHFC', 'HX_CN', 'A50', '纽约商业交易所', 0.00, '0900', '2000', 1, 1, 1, 1582357830, 10, 13902.5, 0, 13885, 13962.5, 13862.5, 17.5, 0.13, 1.75, 13902.50000, 5, 13907.50000, 3, 7, 'CNY', '2023-02-17 10:12:08');
INSERT INTO `wp_option` VALUES (73, 'HKHFE', 'fx_seurusd', '欧元美元', '纽约商业交易所', 0.00, '0900', '2000', 1, 1, 0, 1582357830, 5000, 1.08615, 0, 1.08045, 1.08785, 1.07975, 0.0057, 0.53, 175.00, 1.08615, 5, 1.08625, 5, 7, 'CNY', '2023-02-17 10:12:08');

-- ----------------------------
-- Table structure for wp_option_classify
-- ----------------------------
DROP TABLE IF EXISTS `wp_option_classify`;
CREATE TABLE `wp_option_classify`  (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分类名称',
  `create_time` int(12) NULL DEFAULT NULL COMMENT '添加时间',
  `temptime` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '产品分类表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_option_classify
-- ----------------------------
INSERT INTO `wp_option_classify` VALUES (6, '国内期货', 1480312861, '2016-11-28 14:17:46');
INSERT INTO `wp_option_classify` VALUES (7, '国际期货', 1480312875, '2016-12-07 16:36:18');

-- ----------------------------
-- Table structure for wp_option_contract
-- ----------------------------
DROP TABLE IF EXISTS `wp_option_contract`;
CREATE TABLE `wp_option_contract`  (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `option_id` int(12) NULL DEFAULT NULL COMMENT '产品id',
  `user_id` int(12) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT NULL COMMENT '1已经签署 2未签署',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `option_id`(`option_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '产品合同同意表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wp_option_deal_time
-- ----------------------------
DROP TABLE IF EXISTS `wp_option_deal_time`;
CREATE TABLE `wp_option_deal_time`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `option_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '商品id，对应option表id',
  `deal_time_start` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0000' COMMENT '交易开始时间',
  `deal_time_end` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0000' COMMENT '交易结束时间',
  `deal_time_type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '当前时间段，是否隔天默认1，不隔天，2隔天',
  `time_order` tinyint(2) NULL DEFAULT 1 COMMENT '交易时间排序',
  `temptime` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `option_id`(`option_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 309 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '产品交易时间表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_option_deal_time
-- ----------------------------
INSERT INTO `wp_option_deal_time` VALUES (75, 65, '0700', '0515', 2, 1, '2016-12-06 16:35:15');
INSERT INTO `wp_option_deal_time` VALUES (95, 64, '0700', '0515', 2, 1, '2016-12-09 12:38:31');
INSERT INTO `wp_option_deal_time` VALUES (110, 63, '1500', '0500', 2, 1, '2016-12-16 16:22:44');
INSERT INTO `wp_option_deal_time` VALUES (255, 59, '0700', '0555', 2, 1, '2018-09-12 16:14:58');
INSERT INTO `wp_option_deal_time` VALUES (256, 60, '0700', '0555', 2, 1, '2018-09-12 16:15:11');
INSERT INTO `wp_option_deal_time` VALUES (257, 62, '0700', '0555', 2, 1, '2018-09-12 16:15:54');
INSERT INTO `wp_option_deal_time` VALUES (258, 67, '0700', '0555', 2, 1, '2018-09-12 16:16:21');
INSERT INTO `wp_option_deal_time` VALUES (259, 70, '0700', '0555', 2, 1, '2018-09-12 16:17:06');
INSERT INTO `wp_option_deal_time` VALUES (260, 71, '0700', '0555', 2, 1, '2018-09-12 16:17:26');
INSERT INTO `wp_option_deal_time` VALUES (263, 73, '0700', '0555', 2, 1, '2018-09-12 16:20:02');
INSERT INTO `wp_option_deal_time` VALUES (278, 72, '0900', '1630', 1, 1, '2018-09-12 16:30:24');
INSERT INTO `wp_option_deal_time` VALUES (279, 72, '1700', '0440', 2, 2, '2018-09-12 16:30:24');
INSERT INTO `wp_option_deal_time` VALUES (294, 10, '0915', '1200', 1, 1, '2018-10-03 10:19:02');
INSERT INTO `wp_option_deal_time` VALUES (295, 10, '1300', '1630', 1, 2, '2018-10-03 10:19:02');
INSERT INTO `wp_option_deal_time` VALUES (296, 10, '1715', '2345', 1, 3, '2018-10-03 10:19:02');
INSERT INTO `wp_option_deal_time` VALUES (300, 66, '0915', '1200', 1, 1, '2018-10-06 17:31:29');
INSERT INTO `wp_option_deal_time` VALUES (301, 66, '1300', '1630', 1, 2, '2018-10-06 17:31:29');
INSERT INTO `wp_option_deal_time` VALUES (302, 66, '1715', '2345', 1, 3, '2018-10-06 17:31:29');
INSERT INTO `wp_option_deal_time` VALUES (303, 69, '0900', '1015', 1, 1, '2020-02-17 22:14:35');
INSERT INTO `wp_option_deal_time` VALUES (304, 69, '1030', '1130', 1, 2, '2020-02-17 22:14:35');
INSERT INTO `wp_option_deal_time` VALUES (305, 69, '1330', '1500', 1, 3, '2020-02-17 22:14:35');
INSERT INTO `wp_option_deal_time` VALUES (306, 68, '0900', '1015', 1, 1, '2020-02-17 22:15:37');
INSERT INTO `wp_option_deal_time` VALUES (307, 68, '1030', '1130', 1, 2, '2020-02-17 22:15:37');
INSERT INTO `wp_option_deal_time` VALUES (308, 68, '1330', '1500', 1, 3, '2020-02-17 22:15:37');

-- ----------------------------
-- Table structure for wp_option_info
-- ----------------------------
DROP TABLE IF EXISTS `wp_option_info`;
CREATE TABLE `wp_option_info`  (
  `option_id` int(10) NOT NULL COMMENT '产品id',
  `number` int(10) NOT NULL DEFAULT 1 COMMENT '几手',
  `profit` int(10) NOT NULL DEFAULT 0 COMMENT '止盈基数',
  `loss` int(10) NOT NULL DEFAULT 0 COMMENT '止损基数',
  `Bond` int(10) NOT NULL DEFAULT 0 COMMENT '止损保证金',
  `CounterFee` float(10, 2) NOT NULL DEFAULT 0.00 COMMENT '手续费',
  `commission` decimal(60, 0) UNSIGNED NOT NULL DEFAULT 0 COMMENT '交易所吃取佣金',
  `sort` smallint(20) NULL DEFAULT NULL COMMENT '商品排序',
  `hs_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '商品编码',
  `capital_length` tinyint(1) NULL DEFAULT NULL COMMENT '品种价格小数 位数'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '产品详情表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_option_info
-- ----------------------------
INSERT INTO `wp_option_info` VALUES (60, 1, 850, 170, 1400, 42.00, 0, 4, 'GC', 1);
INSERT INTO `wp_option_info` VALUES (59, 1, 450, 90, 1400, 36.00, 0, 3, 'CL', 2);
INSERT INTO `wp_option_info` VALUES (10, 1, 10000, 2000, 1800, 40.00, 0, 1, 'HSI', 0);
INSERT INTO `wp_option_info` VALUES (62, 1, 234, 0, 2800, 76.00, 0, 5, 'SI', 3);
INSERT INTO `wp_option_info` VALUES (66, 1, 0, 0, 270, 16.00, 0, 2, 'MHI', 0);
INSERT INTO `wp_option_info` VALUES (67, 1, 450, 90, 350, 5.60, 0, 6, 'CL', 2);
INSERT INTO `wp_option_info` VALUES (68, 1, 0, 0, 9000, 0.00, 0, 7, 'IF300', 4);
INSERT INTO `wp_option_info` VALUES (69, 1, 0, 0, 600, 0.00, 0, 8, 'SC', 1);
INSERT INTO `wp_option_info` VALUES (70, 1, 0, 0, 1400, 0.00, 0, 9, 'NG', 3);
INSERT INTO `wp_option_info` VALUES (71, 1, 0, 0, 1750, 0.00, 0, 10, 'HG', 4);
INSERT INTO `wp_option_info` VALUES (72, 1, 0, 0, 350, 0.00, 0, 11, 'CN', 0);
INSERT INTO `wp_option_info` VALUES (73, 1, 0, 0, 875, 0.00, 0, 12, 'EC', 4);

-- ----------------------------
-- Table structure for wp_option_play
-- ----------------------------
DROP TABLE IF EXISTS `wp_option_play`;
CREATE TABLE `wp_option_play`  (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `option_id` int(12) NULL DEFAULT NULL COMMENT '产品id',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '商品玩法',
  `temptime` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `option_id`(`option_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '产品玩法表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_option_play
-- ----------------------------
INSERT INTO `wp_option_play` VALUES (2, 10, '  \n    \n    \n    \n    \n    \n    \n    \n    \n    \n    \n    \n    \n    \n    \n  &lt;p class=&quot;intro&quot;&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易品种&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;恒指&lt;/span&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;货币单位&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;港币&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易单位&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;1个指数点&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;最小波动&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;50港元/点&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;波动盈亏&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;波动一个单位点=50港元&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易时间&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;上午 09:15:00 - 12:00:00 &amp;nbsp; &lt;/span&gt;下午13:00:00 - 16:30:00 &amp;nbsp; 夜间 17:15:00 - 23:45:00&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;b&gt;强制平仓时间&lt;/b&gt;：夜间 23:45:00&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;280元/手&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;汇率&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;10港币＝9人民币&lt;/span&gt;（汇率波动较大时，将会进行调整）&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;p class=&quot;intro&quot;&gt;&lt;span&gt;港交所恒指期货，每点50港元，最小波动1点（相当于最小波动盈亏人民币45元） ，可买涨买跌。&lt;/span&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;出入金规则&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;入金时间：全天24小时&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;出金时间：9：00-18:00，18:00后提现隔天到账；到账时间以银行为准，节假日顺延。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;提现手续费：入金有交易，单笔提现收取2元手续费；若入金未交易，单笔提现收取1%的手续费。&lt;/span&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做多（买涨）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做多（买涨）交易时，若价格上涨，账面为盈利状态；若价格下跌，账面则为亏损状态！&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做空（买跌）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做空（买跌）交易时，若价格下跌，账面为盈利状态；若价格上涨，账面则为亏损状态！&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止盈？&lt;/b&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易盈利金额触发（多于等于）指定的止盈金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证平仓后最终盈利金额一定大于等于止盈金额，有可能会小于触发的止盈金额。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止损？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易亏损金额触发（多于等于）指定的止损金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证卖出后最终亏损金额一定小于等于止损金额，有可能会大于止损金额。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;&lt;span&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是持仓时间？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;恒指期货最后持仓时间：&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;夜间 00:40:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当持仓时间到点后，持仓中的交易会被强制平仓，不保证成交价格，请务必在到期前自己选择卖出。&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;恒指期货每手交易综合费：280元（单向收取）&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;履约保证金&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;履约保证金为操盘手委托平台冻结用于履行交易亏损赔付义务的保证金。操盘手以冻结的履约保证金作为承担交易亏损赔付的上限。多出上限部分的亏损全部由合作的投资人承担。&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;实盘交易下单&lt;/b&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-list2&quot;&gt;您所有的恒指交易，全部通过期货公司的易盛API通道，下单到香港交易所进行对手价撮合成交。&lt;/p&gt;', '2018-09-12 16:26:51');
INSERT INTO `wp_option_play` VALUES (3, 59, '  \n    \n    \n    \n    \n    \n    \n    \n    \n    \n    \n    \n    \n    \n  &lt;div class=&quot;col-1 col-6&quot;&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易品种&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;美原油&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;货币单位：&lt;/b&gt;&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;美元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易单位&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;1000桶&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;最小波动&lt;/b&gt;:&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;0.01美元/桶&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;波动盈亏&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;波动一个单位点 = 10美元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易时间:&lt;/b&gt;&lt;/span&gt;夏令：06:00:00 - 次日04:55:00 &amp;nbsp; &amp;nbsp; &amp;nbsp;冬令：07:00:00 - 次日05:55:00&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;强制平仓时间&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;夏令：次日04:55:00 &amp;nbsp; &amp;nbsp; &amp;nbsp;&amp;nbsp;&lt;/span&gt;冬令：次日05:55:00&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;198元/手&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;汇率:&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;1美元＝7人民币&lt;/span&gt;（汇率波动较大时，将会进行调整）&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;纽约商品交易所美原油期货，每手1000桶，最小波动10美元（相当于最小波动盈亏人民币70元） ，可买涨买跌。&lt;/p&gt;&lt;br&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;出入金规则&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;入金时间：全天24小时&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;出金时间：9：00-18:00，18:00后提现隔天到账；到账时间以银行为准，节假日顺延。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;提现手续费：入金有交易，单笔提现收取2元手续费；若入金未交易，单笔提现收取1%的手续费。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做多（买涨）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做多（买涨）交易时，若价格上涨，账面为盈利状态；若价格下跌，账面则为亏损状态！&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做空（买跌）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做空（买跌）交易时，若价格下跌，账面为盈利状态；若价格上涨，账面则为亏损状态！&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;br&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止盈？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易盈利金额触发（多于等于）指定的止盈金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证平仓后最终盈利金额一定大于等于止盈金额，有可能会小于触发的止盈金额。&lt;/p&gt;&lt;br&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止损？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易亏损金额触发（多于等于）指定的止损金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证卖出后最终亏损金额一定小于等于止损金额，有可能会大于止损金额。&lt;/p&gt;&lt;br&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是持仓时间？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;美原油期货最后持仓时间：&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;夏令： 次日04:55:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;冬令： 次日05:55:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当持仓时间到点后，持仓中的交易会被强制平仓，不保证成交价格，请务必在到期前自己选择卖出。&lt;/p&gt;&lt;br&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;美原油期货每手交易综合费：198元（单向收取）&lt;/p&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;履约保证金&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;履约保证金为操盘手委托平台冻结用于履行交易亏损赔付义务的保证金。操盘手以冻结的履约保证金作为承担交易亏损赔付的上限。多出上限部分的亏损全部由合作的投资人承担。&lt;/p&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;实盘交易下单&lt;/b&gt;&lt;/p&gt;&lt;br&gt;&lt;p class=&quot;rule-list2&quot;&gt;您所有的美原油交易，全部通过期货公司的易盛API通道，下单到纽约商品交易所进行对手价撮合成交。&lt;/p&gt;&lt;/div&gt;', '2018-09-12 15:39:05');
INSERT INTO `wp_option_play` VALUES (4, 66, '  \n    \n    \n    \n    \n    \n    \n    \n    \n    \n    \n    \n  &lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易品种&lt;/b&gt;:&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;小恒指&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;货币单位&lt;/b&gt;:&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;港币&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易单位&lt;/b&gt;:&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;1个指数点&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;最小波动&lt;/b&gt;:&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;10港元/点&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;波动盈亏&lt;/b&gt;:&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;波动一个单位点=10港元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易时间&lt;/b&gt;:&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;上午 09:15:00 - 12:00:00 &amp;nbsp; &amp;nbsp;下午 13:00:00 - 16:30:00 &amp;nbsp;&amp;nbsp;&lt;/span&gt;夜间 17:15:00 - 23:45:00&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;强制平仓时间&lt;/b&gt;：&lt;/span&gt;夜间 23:45:00&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;80元/手&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;汇率&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;10港币＝9人民币 &amp;nbsp; &amp;nbsp;&lt;/span&gt;（汇率波动较大时，将会进行调整）&lt;/li&gt;&lt;/ul&gt;&lt;div class=&quot;cb&quot;&gt;&lt;/div&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;港交所小恒指期货，每点10港元，最小波动1点（相当于最小波动盈亏人民币9元） ，可买涨买跌。&lt;/p&gt;&lt;p class=&quot;intro&quot;&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;出入金规则&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;入金时间：全天24小时&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;出金时间：9：00-18:00，18:00后提现隔天到账；到账时间以银行为准，节假日顺延。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;&lt;br&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;提现手续费：入金有交易，单笔提现收取2元手续费；若入金未交易，单笔提现收取1%的手续费。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做多（买涨）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做多（买涨）交易时，若价格上涨，账面为盈利状态；若价格下跌，账面则为亏损状态！&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做空（买跌）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做空（买跌）交易时，若价格下跌，账面为盈利状态；若价格上涨，账面则为亏损状态！&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止盈？&lt;/b&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易盈利金额触发（多于等于）指定的止盈金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证平仓后最终盈利金额一定大于等于止盈金额，有可能会小于触发的止盈金额。&lt;/p&gt;&lt;p class=&quot;intro&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止损？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易亏损金额触发（多于等于）指定的止损金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证卖出后最终亏损金额一定小于等于止损金额，有可能会大于止损金额。&lt;/p&gt;&lt;p class=&quot;intro&quot;&gt;&lt;b&gt;&lt;span&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;/span&gt;&lt;br&gt;&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是持仓时间？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;小恒指期货最后持仓时间：&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;夜间 00:40:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当持仓时间到点后，持仓中的交易会被强制平仓，不保证成交价格，请务必在到期前自己选择卖出。&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;小恒指期货每手交易综合费：80元（单向收取）&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;履约保证金&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;履约保证金为操盘手委托平台冻结用于履行交易亏损赔付义务的保证金。操盘手以冻结的履约保证金作为承担交易亏损赔付的上限。多出上限部分的亏损全部由合作的投资人承担。&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;实盘交易下单&lt;/b&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-list2&quot;&gt;您所有的小恒指交易，全部通过期货公司的易盛API通道，下单到香港交易所进行对手价撮合成交。&lt;/p&gt;  \n  ', '2018-09-12 16:25:22');
INSERT INTO `wp_option_play` VALUES (5, 60, '&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易品种&lt;/b&gt;:&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;美黄金&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;货币单位&lt;/b&gt;:&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;美元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;b&gt;交易单位&lt;/b&gt;：&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;每手100盎司&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;最小波动&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;0.1美元/盎司&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;波动盈亏:&lt;/b&gt;&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;波动一个单位点 = 10美元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易时间&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;夏令：06:00:00 - 次日04:55:00 &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;&lt;/span&gt;冬令：07:00:00 - 次日05:55:00&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;强制平仓时间&lt;/b&gt;：&lt;/span&gt;夏令：次日04:55:00 &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; 冬令：次日05:55:00&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;198元/手&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;汇率&lt;/b&gt;：&lt;/span&gt;1美元＝7人民币 &amp;nbsp;（汇率波动较大时，将会进行调整）&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;div class=&quot;cb&quot;&gt;&lt;/div&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;纽约商品交易所美黄金期货，每手100盎司，最小波动10美元（相当于最小波动盈亏人民币70元） ，可买涨买跌。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;出入金规则&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;入金时间：全天24小时&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;出金时间：9：00-18:00，18:00后提现隔天到账；到账时间以银行为准，节假日顺延。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;提现手续费：入金有交易，单笔提现收取2元手续费；若入金未交易，单笔提现收取1%的手续费。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;b&gt;&lt;span&gt;&lt;/span&gt;&lt;/b&gt;&lt;/span&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做多（买涨）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做多（买涨）交易时，若价格上涨，账面为盈利状态；若价格下跌，账面则为亏损状态！&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做空（买跌）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做空（买跌）交易时，若价格下跌，账面为盈利状态；若价格上涨，账面则为亏损状态！&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止盈？&lt;/b&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易盈利金额触发（多于等于）指定的止盈金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证平仓后最终盈利金额一定大于等于止盈金额，有可能会小于触发的止盈金额。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止损？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易亏损金额触发（多于等于）指定的止损金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证卖出后最终亏损金额一定小于等于止损金额，有可能会大于止损金额。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是持仓时间？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;美黄金期货最后持仓时间：&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;夏令： 次日04:55:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;冬令： 次日05:55:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当持仓时间到点后，持仓中的交易会被强制平仓，不保证成交价格，请务必在到期前自己选择卖出。&lt;/p&gt;&lt;p&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;美黄金期货每手交易综合费：198元（单向收取）&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;履约保证金&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;履约保证金为操盘手委托平台冻结用于履行交易亏损赔付义务的保证金。操盘手以冻结的履约保证金作为承担交易亏损赔付的上限。多出上限部分的亏损全部由合作的投资人承担。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;实盘交易下单&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-list2&quot;&gt;您所有的美黄金交易，全部通过期货公司的易盛API通道，下单到纽约商品交易所进行对手价撮合成交。&lt;/p&gt;', '2018-09-12 15:41:57');
INSERT INTO `wp_option_play` VALUES (6, 62, '  \n    \n    \n    \n    \n    \n    \n    \n    \n    \n    \n    \n  &lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易品种&lt;/b&gt;:&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;美白银&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;货币单位&lt;/b&gt;:&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;美元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易单位&lt;/b&gt;:&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;每手5000盎司&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;最小波动&lt;/b&gt;:&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;0.005美元/盎司&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;b&gt;波动盈亏&lt;/b&gt;:&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;波动一个单位点 = 25美元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易时间&lt;/b&gt;:&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;夏令：06:00:00 - 次日04:55:00 &amp;nbsp; &amp;nbsp; &amp;nbsp;&amp;nbsp;&lt;/span&gt;冬令：07:00:00 - 次日05:55:00&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;强制平仓时间&lt;/b&gt;:&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;夏令：次日04:55:00 &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;&lt;/span&gt;冬令：次日05:55:00&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;:&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;260元/手&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;汇率&lt;/b&gt;:&lt;/span&gt;1美元＝7人民币 &amp;nbsp; （汇率波动较大时，将会进行调整）&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;div class=&quot;cb&quot;&gt;&lt;/div&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;纽约商品交易所美白银期货，每手5000盎司，最小波动25美元（相当于最小波动盈亏人民币175元） ，可买涨买跌。&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;出入金规则&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;入金时间：全天24小时&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;出金时间：9：00-18:00，18:00后提现隔天到账；到账时间以银行为准，节假日顺延。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;提现手续费：入金有交易，单笔提现收取2元手续费；若入金未交易，单笔提现收取1%的手续费。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;&lt;br&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做多（买涨）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做多（买涨）交易时，若价格上涨，账面为盈利状态；若价格下跌，账面则为亏损状态！&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做空（买跌）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做空（买跌）交易时，若价格下跌，账面为盈利状态；若价格上涨，账面则为亏损状态！&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止盈？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易盈利金额触发（多于等于）指定的止盈金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证平仓后最终盈利金额一定大于等于止盈金额，有可能会小于触发的止盈金额。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止损？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易亏损金额触发（多于等于）指定的止损金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证卖出后最终亏损金额一定小于等于止损金额，有可能会大于止损金额。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是持仓时间？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;美白银期货最后持仓时间：&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;夏令： 次日04:55:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;冬令： 次日05:55:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当持仓时间到点后，持仓中的交易会被强制平仓，不保证成交价格，请务必在到期前自己选择卖出。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;美白银期货每手交易综合费：260元（单向收取）&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;span&gt;&amp;nbsp; &amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;履约保证金&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;履约保证金为操盘手委托平台冻结用于履行交易亏损赔付义务的保证金。操盘手以冻结的履约保证金作为承担交易亏损赔付的上限。多出上限部分的亏损全部由合作的投资人承担。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;实盘交易下单&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-list2&quot;&gt;您所有的美白银交易，全部通过期货公司的易盛API通道，下单到纽约商品交易所进行对手价撮合成交。&lt;/p&gt;  \n  ', '2018-09-12 15:46:06');
INSERT INTO `wp_option_play` VALUES (7, 63, '  \n  &lt;p class=&quot;intro&quot;&gt;欧期所德指期货，每个指数点25欧元，最小波动0.5个指数点（相当于最小波动盈亏106.25元人民币） ，可买涨买跌。&lt;br&gt;　　&lt;a href=&quot;http://wpyyb.jnhyxx.com/activity/oneMinute.html&quot;&gt;&amp;gt;&amp;gt;一分钟了解如何交易和赚钱&lt;/a&gt;&lt;/p&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;新手练习&lt;/h3&gt;&lt;p&gt;如果您是新手，没有交易经验，建议您到模拟练习区进行模拟交易。&lt;/p&gt;&lt;p&gt;&lt;a href=&quot;http://wpyyb.jnhyxx.com/guoji/index.html?tradeType=2&amp;amp;commodity=DAX&quot;&gt;&amp;gt;&amp;gt;进入模拟练习区&lt;/a&gt;&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;交易时间&lt;/h3&gt;&lt;p&gt;买入时间：下午 15:00:00 – 次日04:58:00&lt;/p&gt;&lt;p&gt;卖出时间：下午 15:00:00 – 次日04:58:00&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;什么是止盈？&lt;/h3&gt;&lt;p&gt;当单笔交易盈利金额触发（多于等于）指定的止盈金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p&gt;由于市场的价格实时都在变动，不保证平仓后最终盈利金额一定大于等于止盈金额，有可能会小于触发的止盈金额。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;什么是止损？&lt;/h3&gt;&lt;p&gt;当单笔交易亏损金额触发（多于等于）指定的止损金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p&gt;由于市场的价格实时都在变动，不保证卖出后最终亏损金额一定小于等于止损金额，有可能会大于止损金额。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;什么是持仓时间？&lt;/h3&gt;&lt;p&gt;德指期货最后持仓时间：次日04:58:00&lt;/p&gt;&lt;p&gt;当持仓时间到点后，持仓中的交易会被强制平仓，不保证成交价格，请务必在到期前自己选择卖出。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;交易综合费&lt;/h3&gt;&lt;p&gt;德指期货每手交易综合费：35欧元（约297.5元人民币）&lt;/p&gt;&lt;p&gt;（买进卖出只收取一次）&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;履约保证金&lt;/h3&gt;&lt;p&gt;履约保证金为操盘手委托平台冻结用于履行交易亏损赔付义务的保证金。操盘手以冻结的履约保证金作为承担交易亏损赔付，但交易亏损可能超出保证金金额，超出部分的亏损全部由操盘手承担，投资人不承担交易亏损。&lt;/p&gt;&lt;p&gt;合作交易结束后，根据清结算结果，如交易盈利，操盘手冻结的履约保证金全额退还。如交易亏损，从冻结的履约保证金中，扣减操盘手所应承担的亏损赔付额，扣减后余额退还。如亏损超出保证金，则直接在操盘手账户余额中扣除。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;盈利如何分配？&lt;/h3&gt;&lt;p&gt;盈利100%归操盘手所有，投资人不参与盈利分成。&lt;/p&gt;&lt;p&gt;同上，如操盘手亏损超出保证金，投资人亦不承担超出部分亏损金额。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;实盘交易下单&lt;/h3&gt;&lt;p&gt;操盘手的所有德指交易，全部经由投资人的期货交易账户，下单到欧洲期货交易所。&lt;/p&gt;&lt;/div&gt;  \n  ', '2016-12-08 15:46:40');
INSERT INTO `wp_option_play` VALUES (8, 64, '  \n    \n  &lt;p class=&quot;intro&quot;&gt;芝加哥商品交易所期货，每个指数点50美元，最小波动0.25个指数点（相当于最小波动盈亏87.5元人民币） ，可买涨买跌。&lt;br&gt;　　&lt;a href=&quot;http://wpyyb.jnhyxx.com/activity/oneMinute.html&quot;&gt;&amp;gt;&amp;gt;一分钟了解如何交易和赚钱&lt;/a&gt;&lt;/p&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;新手练习&lt;/h3&gt;&lt;p&gt;如果您是新手，没有交易经验，建议您到模拟练习区进行模拟交易。&lt;/p&gt;&lt;p&gt;&lt;a href=&quot;http://wpyyb.jnhyxx.com/guoji/index.html?tradeType=2&amp;amp;commodity=NQ&quot;&gt;&amp;gt;&amp;gt;进入模拟练习区&lt;/a&gt;&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;交易时间&lt;/h3&gt;&lt;p&gt;上午 07:00:00 – 次日05:13:00&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;什么是止盈？&lt;/h3&gt;&lt;p&gt;当单笔交易盈利金额触发（多于等于）指定的止盈金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p&gt;由于市场的价格实时都在变动，不保证平仓后最终盈利金额一定大于等于止盈金额，有可能会小于触发的止盈金额。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;什么是止损？&lt;/h3&gt;&lt;p&gt;当单笔交易亏损金额触发（多于等于）指定的止损金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p&gt;由于市场的价格实时都在变动，不保证卖出后最终亏损金额一定小于等于止损金额，有可能会大于止损金额。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;什么是持仓时间？&lt;/h3&gt;&lt;p&gt;期货最后持仓时间：次日 05:13:00&lt;/p&gt;&lt;p&gt;当持仓时间到点后，持仓中的交易会被强制平仓，不保证成交价格，请务必在到期前自己选择卖出。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;交易综合费&lt;/h3&gt;&lt;p&gt;小纳指期货每手交易综合费：22.4美元（约168人民币）&lt;/p&gt;&lt;p&gt;（买进卖出只收取一次）&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;履约保证金&lt;/h3&gt;&lt;p&gt;履约保证金为操盘手委托平台冻结用于履行交易亏损赔付义务的保证金。操盘手以冻结的履约保证金作为承担交易亏损赔付，但交易亏损可能超出保证金金额，超出部分的亏损全部由操盘手承担，投资人不承担交易亏损。&lt;/p&gt;&lt;p&gt;合作交易结束后，根据清结算结果，如交易盈利，操盘手冻结的履约保证金全额退还。如交易亏损，从冻结的履约保证金中，扣减操盘手所应承担的亏损赔付额，扣减后余额退还。如亏损超出保证金，则直接在操盘手账户余额中扣除。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;盈利如何分配？&lt;/h3&gt;&lt;p&gt;盈利100%归操盘手所有，投资人不参与盈利分成。&lt;/p&gt;&lt;p&gt;同上，如操盘手亏损超出保证金，投资人亦不承担超出部分亏损金额。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;实盘交易下单&lt;/h3&gt;&lt;p&gt;操盘手的所有小纳指交易，全部经由投资人的期货交易账户，下单到芝加哥商品交易所。&lt;/p&gt;&lt;/div&gt;  \n  ', '2016-12-23 15:08:51');
INSERT INTO `wp_option_play` VALUES (9, 65, '  \n  &lt;p class=&quot;intro&quot;&gt;芝加哥商品交易所期货，每个指数点20美元，最小波动0.25个指数点（相当于最小波动盈亏37.5元人民币） ，可买涨买跌。&lt;br&gt;　　&lt;a href=&quot;http://wpyyb.jnhyxx.com/activity/oneMinute.html&quot;&gt;&amp;gt;&amp;gt;一分钟了解如何交易和赚钱&lt;/a&gt;&lt;/p&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;新手练习&lt;/h3&gt;&lt;p&gt;如果您是新手，没有交易经验，建议您到模拟练习区进行模拟交易。&lt;/p&gt;&lt;p&gt;&lt;a href=&quot;http://wpyyb.jnhyxx.com/guoji/index.html?tradeType=2&amp;amp;commodity=NQ&quot;&gt;&amp;gt;&amp;gt;进入模拟练习区&lt;/a&gt;&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;交易时间&lt;/h3&gt;&lt;p&gt;上午 07:00:00 – 次日05:13:00&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;什么是止盈？&lt;/h3&gt;&lt;p&gt;当单笔交易盈利金额触发（多于等于）指定的止盈金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p&gt;由于市场的价格实时都在变动，不保证平仓后最终盈利金额一定大于等于止盈金额，有可能会小于触发的止盈金额。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;什么是止损？&lt;/h3&gt;&lt;p&gt;当单笔交易亏损金额触发（多于等于）指定的止损金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p&gt;由于市场的价格实时都在变动，不保证卖出后最终亏损金额一定小于等于止损金额，有可能会大于止损金额。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;什么是持仓时间？&lt;/h3&gt;&lt;p&gt;期货最后持仓时间：次日 05:13:00&lt;/p&gt;&lt;p&gt;当持仓时间到点后，持仓中的交易会被强制平仓，不保证成交价格，请务必在到期前自己选择卖出。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;交易综合费&lt;/h3&gt;&lt;p&gt;小纳指期货每手交易综合费：22.4美元（约168人民币）&lt;/p&gt;&lt;p&gt;（买进卖出只收取一次）&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;履约保证金&lt;/h3&gt;&lt;p&gt;履约保证金为操盘手委托平台冻结用于履行交易亏损赔付义务的保证金。操盘手以冻结的履约保证金作为承担交易亏损赔付，但交易亏损可能超出保证金金额，超出部分的亏损全部由操盘手承担，投资人不承担交易亏损。&lt;/p&gt;&lt;p&gt;合作交易结束后，根据清结算结果，如交易盈利，操盘手冻结的履约保证金全额退还。如交易亏损，从冻结的履约保证金中，扣减操盘手所应承担的亏损赔付额，扣减后余额退还。如亏损超出保证金，则直接在操盘手账户余额中扣除。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;盈利如何分配？&lt;/h3&gt;&lt;p&gt;盈利100%归操盘手所有，投资人不参与盈利分成。&lt;/p&gt;&lt;p&gt;同上，如操盘手亏损超出保证金，投资人亦不承担超出部分亏损金额。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;实盘交易下单&lt;/h3&gt;&lt;p&gt;操盘手的所有小纳指交易，全部经由投资人的期货交易账户，下单到芝加哥商品交易所。&lt;/p&gt;&lt;/div&gt;  \n  ', '2016-12-08 15:45:32');
INSERT INTO `wp_option_play` VALUES (10, 67, '  \n    \n    \n    \n    \n    \n    \n    \n  &lt;p class=&quot;intro&quot;&gt;每手100桶，最小波动0.01点=1美元（相当于最小波动7元人民币），可买涨买跌。&lt;br&gt;　　&lt;/p&gt;&lt;div class=&quot;segment&quot;&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;交易时间&lt;/h3&gt;&lt;p&gt;上午 06:00:00 - 次日04:55:00（夏令时）&lt;/p&gt;&lt;p&gt;上午 07:00:00 - 次日05:55:00（冬令时）&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;什么是买涨？&lt;/h3&gt;&lt;p&gt;当您买涨时，价格涨了你就赚钱，跌了亏钱。&lt;/p&gt;&lt;p&gt;盈利示例：41美元买涨1手，41.1元卖出，涨了0.1美元，最终盈利：0.1美元*100桶=赚100美元=70元人民币。&lt;/p&gt;&lt;p&gt;亏损示例：41美元买涨1手，40.9元卖出，跌了0.1美元，最终亏损：0.1美元*100桶=亏100美元=70元人民币。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;什么是买跌？&lt;/h3&gt;&lt;p&gt;但您买跌时，价格跌了你就赚钱，涨了亏钱。&lt;/p&gt;&lt;p&gt;盈利示例：41美元买跌1手，40.9美元卖出，跌了0.1美元，最终盈利：0.1美元*100桶=赚100美元=70元人民币。&lt;/p&gt;&lt;p&gt;亏损示例：41美元买跌1手，41.1美元卖出，涨了0.1美元，最终亏损：0.1美元*100桶=亏100美元=70元人民币。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;什么是止盈？&lt;/h3&gt;&lt;p&gt;当单笔交易盈利金额触发（多于等于）指定的止盈金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p&gt;由于市场的价格实时都在变动，不保证平仓后最终盈利金额一定大于等于止盈金额，有可能会小于触发的止盈金额。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;什么是止损？&lt;/h3&gt;&lt;p&gt;当单笔交易亏损金额触发（多于等于）指定的止损金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p&gt;由于市场的价格实时都在变动，不保证卖出后最终亏损金额一定小于等于止损金额，有可能会大于止损金额。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;p&gt;当持仓时间到点后，持仓中的交易会被强制平仓，不保证成交价格，请务必在到期前自己选择卖出。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;交易综合费&lt;/h3&gt;&lt;p&gt;美原油期货每手交易综合费：35元人民币&lt;/p&gt;&lt;p&gt;（买进卖出只收取一次）&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;履约保证金&lt;/h3&gt;&lt;p&gt;履约保证金为操盘手委托平台冻结用于履行交易亏损赔付义务的保证金。操盘手以冻结的履约保证金作为承担交易亏损赔付，但交易亏损可能超出保证金金额，超出部分的亏损全部由操盘手承担，投资人不承担交易亏损。&lt;/p&gt;&lt;p&gt;合作交易结束后，根据清结算结果，如交易盈利，操盘手冻结的履约保证金全额退还。如交易亏损，从冻结的履约保证金中，扣减操盘手所应承担的亏损赔付额，扣减后余额退还。如亏损超出保证金，则直接在操盘手账户余额中扣除。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;盈利如何分配？&lt;/h3&gt;&lt;p&gt;盈利100%归操盘手所有，投资人不参与盈利分成。&lt;/p&gt;&lt;p&gt;同上，如操盘手亏损超出保证金，投资人亦不承担超出部分亏损金额。&lt;/p&gt;&lt;/div&gt;&lt;div class=&quot;segment&quot;&gt;&lt;h3&gt;实盘交易下单&lt;/h3&gt;&lt;p&gt;操盘手的所有美原油交易，全部经由投资人的期货交易账户，下单到纽约商业交易所。&lt;/p&gt;&lt;/div&gt;  \n  ', '2018-09-12 15:50:22');
INSERT INTO `wp_option_play` VALUES (11, 68, '&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;交易品种:沪深300&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;货币单位:人民币&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;交易单位&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;1个指数点&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;最小波动:300元&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;/点&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;波动盈亏:&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;波动一个单位点=300元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;p&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;交易时间&lt;/span&gt;：上午：9:00--11:30 &amp;nbsp;下午：13:00--15:15 &amp;nbsp;&amp;nbsp;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;p&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;最后交易日交易时间：上午：9:15至11:30,下午：13:00至15:00&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;结算时间：每个交易日下午4点针对客户账户进行结算，收取留仓费等费用。&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;br&gt;&lt;/li&gt;&lt;li&gt;强制平仓规则：当占用资金+浮动盈亏小于或者等于零时，系统自动平仓所有持仓单&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;/p&gt;&lt;/p&gt;&lt;/p&gt;&lt;/p&gt;&lt;/p&gt;&lt;/p&gt;&lt;/p&gt;&lt;/p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;交易综合费：500&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;元/手&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;汇率;&lt;/span&gt;1点＝300人民币（汇率波动较大时，将会进行调整）&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;div class=&quot;cb&quot;&gt;&lt;/div&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;出入金规则&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;入金时间：全天24小时&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;出金时间：9：00-18:00，18:00后提现隔天到账；到账时间以银行为准，节假日顺延。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;&lt;br&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;提现手续费：入金有交易，单笔提现收取2元手续费；若入金未交易，单笔提现收取1%的手续费。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;什么是做多（买涨）？&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做多（买涨）交易时，若价格上涨，账面为盈利状态；若价格下跌，账面则为亏损状态！&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;什么是做空（买跌）？&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做空（买跌）交易时，若价格下跌，账面为盈利状态；若价格上涨，账面则为亏损状态！&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;什么是止盈？&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易盈利金额触发（多于等于）指定的止盈金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证平仓后最终盈利金额一定大于等于止盈金额，有可能会小于触发的止盈金额。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;什么是止损？&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易亏损金额触发（多于等于）指定的止损金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证卖出后最终亏损金额一定小于等于止损金额，有可能会大于止损金额。&lt;/p&gt;&lt;p&gt;&lt;span&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;什么是持仓时间？&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;期货最后持仓时间：&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;夜间 00:40:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当持仓时间到点后，持仓中的交易会被强制平仓，不保证成交价格，请务必在到期前自己选择卖出。&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;交易综合费&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;每手交易综合费：500元（单向收取）&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;履约保证金&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;履约保证金为操盘手委托平台冻结用于履行交易亏损赔付义务的保证金。操盘手以冻结的履约保证金作为承担交易亏损赔付的上限。多出上限部分的亏损全部由合作的投资人承担。&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;实盘交易下单&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-list2&quot;&gt;您所有的小恒指交易，全部通过期货公司的易盛API通道，下单到香港交易所进行对手价撮合成交。&lt;/p&gt;', '2018-09-12 15:58:41');
INSERT INTO `wp_option_play` VALUES (12, 69, '  \n  33232', '2018-09-07 20:11:41');
INSERT INTO `wp_option_play` VALUES (13, 70, '  \n    \n  &lt;p&gt;&lt;li&gt;&lt;b&gt;交易品种&lt;/b&gt;：&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;天然气&lt;/span&gt;&lt;/li&gt;&lt;/p&gt;&lt;ul&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;货币单位&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;美元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易单位&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;每手10000百万英热&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;最小波动&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;0.001美元/百万英热&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;波动盈亏&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;波动一个单位点= 10美元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易时间&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;夏令：06:00:00 - 次日04:55:00 &amp;nbsp; &amp;nbsp;&amp;nbsp;&lt;/span&gt;冬令：07:00:00 - 次日05:55:00&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;强制平仓时间&lt;/b&gt;：&lt;/span&gt;夏令：次日04:55:00 &amp;nbsp; &amp;nbsp;冬令：次日05:55:00&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;220元/手&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;汇率&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;1美元＝7人民币 &amp;nbsp;&lt;/span&gt;（汇率波动较大时，将会进行调整）&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;p&gt;纽约商品交易所天然气期货，每手10000百万英热，最小波动10美元（相当于最小波动盈亏人民币70元） ，可买涨买跌。&lt;/p&gt;&lt;/span&gt;&lt;/li&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;出入金规则&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;入金时间：全天24小时&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;出金时间：9：00-18:00，18:00后提现隔天到账；到账时间以银行为准，节假日顺延。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;提现手续费：入金有交易，单笔提现收取2元手续费；若入金未交易，单笔提现收取1%的手续费。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做多（买涨）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做多（买涨）交易时，若价格上涨，账面为盈利状态；若价格下跌，账面则为亏损状态！&lt;/p&gt;&lt;p&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做空（买跌）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做空（买跌）交易时，若价格下跌，账面为盈利状态；若价格上涨，账面则为亏损状态！&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止盈？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易盈利金额触发（多于等于）指定的止盈金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证平仓后最终盈利金额一定大于等于止盈金额，有可能会小于触发的止盈金额。&lt;/p&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止损？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易亏损金额触发（多于等于）指定的止损金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证卖出后最终亏损金额一定小于等于止损金额，有可能会大于止损金额。&lt;/p&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是持仓时间？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;天然气期货最后持仓时间：&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;夏令： 次日04:55:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;冬令： 次日05:55:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当持仓时间到点后，持仓中的交易会被强制平仓，不保证成交价格，请务必在到期前自己选择卖出。&lt;/p&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;天然气期货每手交易综合费：220元（单向收取）&lt;/p&gt;&lt;br&gt;&lt;p class=&quot;rule-title&quot;&gt;履约保证金&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;履约保证金为操盘手委托平台冻结用于履行交易亏损赔付义务的保证金。操盘手以冻结的履约保证金作为承担交易亏损赔付的上限。多出上限部分的亏损全部由合作的投资人承担。&lt;/p&gt;&lt;br&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;实盘交易下单&lt;/b&gt;&lt;/p&gt;&lt;br&gt;&lt;p class=&quot;rule-list2&quot;&gt;您所有的天然气外汇交易，全部通过期货公司的易盛API通道，下单到纽约商品交易所进行对手价撮合成交。&lt;/p&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;  \n  ', '2018-09-12 16:02:01');
INSERT INTO `wp_option_play` VALUES (14, 71, '  \n  &lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易品种:&lt;/b&gt;&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;美铜&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;货币单位&lt;/b&gt;:&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;美元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易单位：&lt;/b&gt;&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;每手25000磅&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;最小波动：&lt;/b&gt;&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;0.0005美元/磅&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;波动盈亏：&lt;/b&gt;&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;波动一个单位点= 12.5美元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易时间：&lt;/b&gt;&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;夏令：06:00:00 - 次日04:55:00 &amp;nbsp; &amp;nbsp;&amp;nbsp;&lt;/span&gt;冬令：07:00:00 - 次日05:55:00&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;强制平仓时间：&lt;/b&gt;&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;夏令：次日04:55:00 &amp;nbsp; &amp;nbsp;&lt;/span&gt;冬令：次日05:55:00&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易综合费：&lt;/b&gt;&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;265元/手&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;汇率&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;1美元＝7人民币&lt;/span&gt;（汇率波动较大时，将会进行调整）&lt;/li&gt;&lt;/ul&gt;&lt;div class=&quot;cb&quot;&gt;&lt;/div&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;纽约商品交易所美铜期货，每手25000磅，最小波动12.5美元（相当于最小波动盈亏人民币87.5元） ，可买涨买跌。&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;出入金规则&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;入金时间：全天24小时&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;出金时间：9：00-18:00，18:00后提现隔天到账；到账时间以银行为准，节假日顺延。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;提现手续费：入金有交易，单笔提现收取2元手续费；若入金未交易，单笔提现收取1%的手续费。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;b&gt;&lt;span&gt;&lt;/span&gt;&lt;/b&gt;&lt;/span&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做多（买涨）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做多（买涨）交易时，若价格上涨，账面为盈利状态；若价格下跌，账面则为亏损状态！&lt;/p&gt;&lt;p&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做空（买跌）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做空（买跌）交易时，若价格下跌，账面为盈利状态；若价格上涨，账面则为亏损状态！&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止盈？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易盈利金额触发（多于等于）指定的止盈金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证平仓后最终盈利金额一定大于等于止盈金额，有可能会小于触发的止盈金额。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止损？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易亏损金额触发（多于等于）指定的止损金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证卖出后最终亏损金额一定小于等于止损金额，有可能会大于止损金额。&lt;/p&gt;&lt;p&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是持仓时间？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;美铜期货最后持仓时间：&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;夏令： 次日04:55:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;冬令： 次日05:55:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当持仓时间到点后，持仓中的交易会被强制平仓，不保证成交价格，请务必在到期前自己选择卖出。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;美铜期货每手交易综合费：265元（单向收取）&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;履约保证金&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;履约保证金为操盘手委托平台冻结用于履行交易亏损赔付义务的保证金。操盘手以冻结的履约保证金作为承担交易亏损赔付的上限。多出上限部分的亏损全部由合作的投资人承担。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;实盘交易下单&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-list2&quot;&gt;您所有的美铜交易，全部通过期货公司的易盛API通道，下单到纽约商品交易所进行对手价撮合成交。&lt;/p&gt;  \n  ', '2018-09-12 16:06:51');
INSERT INTO `wp_option_play` VALUES (15, 72, '&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易品种：&lt;/b&gt;&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;富时A50&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;货币单位&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;美元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易单位&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;2.5个指数点&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;最小波动&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;2.5美元/点&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;波动盈亏&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;波动一个单位点= 2.5美元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易时间&lt;/b&gt;：&lt;/span&gt;上午09:00-16:29 &amp;nbsp; &amp;nbsp;下午17:02- 次日04:40:00&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;\\&amp;quot;rule-list2\\&amp;quot;&quot; padding-top:=&quot;&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;强制平仓时间&lt;/b&gt;：&lt;/span&gt;次日04:40:00&lt;/li&gt;&lt;li&gt;&lt;br&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;88元/手&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;汇率&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;1美元＝7人民币 &amp;nbsp; &amp;nbsp;&lt;/span&gt;（汇率波动较大时，将会进行调整）&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;p&gt;新加坡交易所富时A50期货，每点2.5美元，最小波动2.5点（相当于最小波动盈亏人民币17.5元） ，可买涨买跌。&lt;/p&gt;&lt;p&gt;&lt;b&gt;出入金规则&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;入金时间：全天24小时&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;出金时间：9：00-18:00，18:00后提现隔天到账；到账时间以银行为准，节假日顺延。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;&lt;br&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;提现手续费：入金有交易，单笔提现收取2元手续费；若入金未交易，单笔提现收取1%的手续费。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做多（买涨）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做多（买涨）交易时，若价格上涨，账面为盈利状态；若价格下跌，账面则为亏损状态！&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做空（买跌）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做空（买跌）交易时，若价格下跌，账面为盈利状态；若价格上涨，账面则为亏损状态！&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止盈？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易盈利金额触发（多于等于）指定的止盈金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证平仓后最终盈利金额一定大于等于止盈金额，有可能会小于触发的止盈金额。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止损？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易亏损金额触发（多于等于）指定的止损金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证卖出后最终亏损金额一定小于等于止损金额，有可能会大于止损金额。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是持仓时间？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;富时A50期货最后持仓时间：&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;次日04:40:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当持仓时间到点后，持仓中的交易会被强制平仓，不保证成交价格，请务必在到期前自己选择卖出。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;富时A50期货每手交易综合费：88元（单向收取）&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;履约保证金&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;履约保证金为操盘手委托平台冻结用于履行交易亏损赔付义务的保证金。操盘手以冻结的履约保证金作为承担交易亏损赔付的上限。多出上限部分的亏损全部由合作的投资人承担。&lt;/p&gt;&lt;p&gt;&lt;b&gt;&lt;br&gt;&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;实盘交易下单&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-list2&quot;&gt;您所有的富时A50交易，全部通过期货公司的易盛API通道，下单到新加坡交易所进行对手价撮合成交。&lt;/p&gt;  \n  ', '2018-09-12 16:09:38');
INSERT INTO `wp_option_play` VALUES (16, 73, '&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易品种&lt;/b&gt;：&lt;/span&gt;欧元&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;货币单位&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;美元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易单位&lt;/b&gt;：&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;每手125000欧元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;最小波动&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;0.00005美元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;波动盈亏：&lt;/b&gt;&lt;/span&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;波动一个单位点=6.25美元&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易时间&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;夏令：06:00:00 - 次日04:55:00 &amp;nbsp; &amp;nbsp; &amp;nbsp;&lt;/span&gt;冬令：07:00:00 - 次日05:55:00&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;强制平仓时间&lt;/b&gt;：&lt;/span&gt;夏令：次日04:55:00 &amp;nbsp; &amp;nbsp; &amp;nbsp;冬令：次日05:55:00&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;text-align: center;&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;：&lt;/span&gt;&lt;span style=&quot;text-align: center;&quot;&gt;220元/手&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;p&gt;&lt;ul class=&quot;rule-list&quot;&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span class=&quot;rule-list2&quot; style=&quot;text-align: center;&quot;&gt;&lt;b&gt;汇率&lt;/b&gt;：&lt;/span&gt;1美元＝7人民币 &amp;nbsp; （汇率波动较大时，将会进行调整）&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;芝加哥商品交易所欧元外汇，每手125000欧元，最小波动6.25美元（相当于最小波动盈亏人民币43.75元） ，可买涨买跌。&lt;/p&gt;&lt;p&gt;&lt;b&gt;出入金规则&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;入金时间：全天24小时&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;出金时间：9：00-18:00，18:00后提现隔天到账；到账时间以银行为准，节假日顺延。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;提现手续费：入金有交易，单笔提现收取2元手续费；若入金未交易，单笔提现收取1%的手续费。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span&gt;&lt;span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做多（买涨）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做多（买涨）交易时，若价格上涨，账面为盈利状态；若价格下跌，账面则为亏损状态！&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是做空（买跌）？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当您进行做空（买跌）交易时，若价格下跌，账面为盈利状态；若价格上涨，账面则为亏损状态！&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;b&gt;什么是止盈？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易盈利金额触发（多于等于）指定的止盈金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证平仓后最终盈利金额一定大于等于止盈金额，有可能会小于触发的止盈金额。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是止损？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当单笔交易亏损金额触发（多于等于）指定的止损金额时，该笔交易会被强制平仓。&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;由于市场的价格实时都在变动，不保证卖出后最终亏损金额一定小于等于止损金额，有可能会大于止损金额。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;什么是持仓时间？&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;欧元外汇最后持仓时间：&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;夏令： 次日04:55:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;冬令： 次日05:55:00&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;当持仓时间到点后，持仓中的交易会被强制平仓，不保证成交价格，请务必在到期前自己选择卖出。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;交易综合费&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;欧元外汇每手交易综合费：220元（单向收取）&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;履约保证金&lt;/b&gt;&lt;/p&gt;&lt;p class=&quot;rule-content&quot;&gt;履约保证金为操盘手委托平台冻结用于履行交易亏损赔付义务的保证金。操盘手以冻结的履约保证金作为承担交易亏损赔付的上限。多出上限部分的亏损全部由合作的投资人承担。&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;rule-title&quot;&gt;&lt;b&gt;实盘交易下单&lt;/b&gt;&lt;/p&gt;&lt;p&gt;您所有的欧元外汇交易，全部通过期货公司的易盛API通道，下单到芝加哥商品交易所进行对手价撮合成交。&lt;/p&gt;', '2018-09-12 16:12:44');

-- ----------------------------
-- Table structure for wp_option_transaction
-- ----------------------------
DROP TABLE IF EXISTS `wp_option_transaction`;
CREATE TABLE `wp_option_transaction`  (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `option_id` int(10) NOT NULL COMMENT '产品id',
  `Stop_loss` int(55) NULL DEFAULT NULL COMMENT '触发止损',
  `stop_profit` int(55) NULL DEFAULT NULL COMMENT '触发止盈',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `option_id`(`option_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 92 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '产品止盈止损配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_option_transaction
-- ----------------------------
INSERT INTO `wp_option_transaction` VALUES (1, 60, 1400, 3500);
INSERT INTO `wp_option_transaction` VALUES (2, 60, 2800, 4200);
INSERT INTO `wp_option_transaction` VALUES (3, 60, 4200, 5600);
INSERT INTO `wp_option_transaction` VALUES (4, 60, 5600, 7000);
INSERT INTO `wp_option_transaction` VALUES (7, 59, 1400, 3500);
INSERT INTO `wp_option_transaction` VALUES (8, 59, 2800, 4200);
INSERT INTO `wp_option_transaction` VALUES (9, 59, 4200, 5600);
INSERT INTO `wp_option_transaction` VALUES (10, 59, 5600, 7000);
INSERT INTO `wp_option_transaction` VALUES (15, 10, 1800, 4500);
INSERT INTO `wp_option_transaction` VALUES (16, 62, 2800, 8750);
INSERT INTO `wp_option_transaction` VALUES (17, 62, 5600, 10500);
INSERT INTO `wp_option_transaction` VALUES (18, 63, 350, 550);
INSERT INTO `wp_option_transaction` VALUES (19, 64, 60, 120);
INSERT INTO `wp_option_transaction` VALUES (20, 65, 80, 160);
INSERT INTO `wp_option_transaction` VALUES (24, 62, 8400, 14000);
INSERT INTO `wp_option_transaction` VALUES (25, 62, 11200, 17500);
INSERT INTO `wp_option_transaction` VALUES (27, 63, 700, 1100);
INSERT INTO `wp_option_transaction` VALUES (28, 63, 1050, 1650);
INSERT INTO `wp_option_transaction` VALUES (29, 63, 1400, 2200);
INSERT INTO `wp_option_transaction` VALUES (30, 63, 1750, 2750);
INSERT INTO `wp_option_transaction` VALUES (31, 64, 120, 240);
INSERT INTO `wp_option_transaction` VALUES (32, 64, 180, 360);
INSERT INTO `wp_option_transaction` VALUES (33, 64, 240, 480);
INSERT INTO `wp_option_transaction` VALUES (34, 64, 300, 600);
INSERT INTO `wp_option_transaction` VALUES (35, 65, 160, 320);
INSERT INTO `wp_option_transaction` VALUES (36, 65, 240, 480);
INSERT INTO `wp_option_transaction` VALUES (37, 65, 320, 640);
INSERT INTO `wp_option_transaction` VALUES (38, 65, 400, 800);
INSERT INTO `wp_option_transaction` VALUES (39, 66, 270, 450);
INSERT INTO `wp_option_transaction` VALUES (40, 66, 540, 540);
INSERT INTO `wp_option_transaction` VALUES (41, 66, 810, 720);
INSERT INTO `wp_option_transaction` VALUES (42, 66, 1080, 900);
INSERT INTO `wp_option_transaction` VALUES (48, 10, 3600, 6750);
INSERT INTO `wp_option_transaction` VALUES (57, 67, 140, 350);
INSERT INTO `wp_option_transaction` VALUES (60, 67, 280, 420);
INSERT INTO `wp_option_transaction` VALUES (61, 67, 420, 560);
INSERT INTO `wp_option_transaction` VALUES (62, 68, 6000, 15000);
INSERT INTO `wp_option_transaction` VALUES (63, 68, 9000, 18000);
INSERT INTO `wp_option_transaction` VALUES (64, 68, 12000, 21000);
INSERT INTO `wp_option_transaction` VALUES (65, 68, 15000, 24000);
INSERT INTO `wp_option_transaction` VALUES (66, 69, 1500, 2000);
INSERT INTO `wp_option_transaction` VALUES (67, 69, 3000, 3500);
INSERT INTO `wp_option_transaction` VALUES (68, 69, 4500, 5000);
INSERT INTO `wp_option_transaction` VALUES (69, 69, 6000, 8000);
INSERT INTO `wp_option_transaction` VALUES (70, 70, 1400, 3500);
INSERT INTO `wp_option_transaction` VALUES (71, 70, 2800, 4200);
INSERT INTO `wp_option_transaction` VALUES (72, 70, 4200, 5600);
INSERT INTO `wp_option_transaction` VALUES (73, 70, 5600, 7000);
INSERT INTO `wp_option_transaction` VALUES (74, 71, 1750, 4375);
INSERT INTO `wp_option_transaction` VALUES (75, 71, 3500, 5250);
INSERT INTO `wp_option_transaction` VALUES (76, 71, 5250, 7000);
INSERT INTO `wp_option_transaction` VALUES (77, 71, 7000, 8750);
INSERT INTO `wp_option_transaction` VALUES (78, 72, 350, 875);
INSERT INTO `wp_option_transaction` VALUES (79, 72, 700, 1050);
INSERT INTO `wp_option_transaction` VALUES (80, 72, 1050, 1400);
INSERT INTO `wp_option_transaction` VALUES (81, 72, 1400, 1750);
INSERT INTO `wp_option_transaction` VALUES (82, 73, 875, 2187);
INSERT INTO `wp_option_transaction` VALUES (83, 73, 1750, 2625);
INSERT INTO `wp_option_transaction` VALUES (84, 73, 2625, 3500);
INSERT INTO `wp_option_transaction` VALUES (85, 73, 3500, 4375);
INSERT INTO `wp_option_transaction` VALUES (89, 10, 7200, 7200);
INSERT INTO `wp_option_transaction` VALUES (90, 10, 9000, 9000);
INSERT INTO `wp_option_transaction` VALUES (91, 67, 560, 700);

-- ----------------------------
-- Table structure for wp_option_user_special
-- ----------------------------
DROP TABLE IF EXISTS `wp_option_user_special`;
CREATE TABLE `wp_option_user_special`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户id,对应userinfo中的id',
  `option_id` int(10) NOT NULL COMMENT '产品id',
  `base_deal` tinyint(2) UNSIGNED NOT NULL DEFAULT 1 COMMENT '交易的基准手数，默认为1手',
  `win_money` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '止盈基数',
  `loss_money` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '止损基数',
  `base_money` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '止损保证金',
  `commission` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '运营中心收取佣金费',
  `platform_commission` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '平台手续费',
  `type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '商品的标签属性（1.默认无，2.新商品new，3.热门商品hot）',
  `option_intro` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '商品简介',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态，商品是否销售（1默认可售，0禁售）',
  `create_date` int(10) UNSIGNED NULL DEFAULT 0,
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `option_id`(`option_id`) USING BTREE,
  INDEX `type`(`type`) USING BTREE,
  INDEX `status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 55 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '运营中心产品配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_option_user_special
-- ----------------------------
INSERT INTO `wp_option_user_special` VALUES (7, 3, 10, 1, 0.00, 0.00, 0.00, 0.00, 280.00, 1, NULL, 1, 1527564743, '2018-09-12 09:11:51');
INSERT INTO `wp_option_user_special` VALUES (8, 3, 59, 1, 0.00, 0.00, 0.00, 0.00, 198.00, 1, NULL, 1, 1527564743, '2018-09-12 09:11:51');
INSERT INTO `wp_option_user_special` VALUES (9, 3, 60, 1, 0.00, 0.00, 0.00, 0.00, 198.00, 1, NULL, 1, 1527564743, '2018-09-17 08:43:12');
INSERT INTO `wp_option_user_special` VALUES (10, 3, 62, 1, 0.00, 0.00, 0.00, 0.00, 260.00, 1, NULL, 1, 1527564743, '2018-09-11 17:12:37');
INSERT INTO `wp_option_user_special` VALUES (11, 3, 66, 1, 0.00, 0.00, 0.00, 0.00, 80.00, 1, NULL, 1, 1527564743, '2018-09-11 17:12:16');
INSERT INTO `wp_option_user_special` VALUES (12, 3, 67, 1, 0.00, 0.00, 0.00, 0.00, 35.00, 1, NULL, 1, 1527564743, '2018-09-12 14:56:10');
INSERT INTO `wp_option_user_special` VALUES (13, 3, 68, 1, 0.00, 0.00, 0.00, 0.00, 1000.00, 1, '', 1, 1527564743, '2018-09-12 14:56:10');
INSERT INTO `wp_option_user_special` VALUES (14, 3, 69, 1, 0.00, 0.00, 0.00, 0.00, 500.00, 1, NULL, 1, 1527564743, '2018-09-12 14:56:10');
INSERT INTO `wp_option_user_special` VALUES (15, 3, 70, 1, 0.00, 0.00, 0.00, 0.00, 220.00, 1, '', 1, 1527564743, '2018-09-12 14:56:10');
INSERT INTO `wp_option_user_special` VALUES (16, 3, 71, 1, 0.00, 0.00, 0.00, 0.00, 265.00, 1, '', 1, 1527564743, '2018-09-12 15:11:23');
INSERT INTO `wp_option_user_special` VALUES (17, 3, 72, 1, 0.00, 0.00, 0.00, 0.00, 88.00, 1, '', 1, 1527564743, '2018-09-12 14:57:15');
INSERT INTO `wp_option_user_special` VALUES (18, 3, 73, 1, 0.00, 0.00, 0.00, 0.00, 220.00, 1, '', 1, 1527564743, '2018-09-12 14:57:15');

-- ----------------------------
-- Table structure for wp_order
-- ----------------------------
DROP TABLE IF EXISTS `wp_order`;
CREATE TABLE `wp_order`  (
  `oid` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `pid` int(11) NOT NULL COMMENT '产品ID',
  `ostyle` int(12) NOT NULL DEFAULT 0 COMMENT '0涨 1跌，',
  `buytime` int(20) NULL DEFAULT NULL COMMENT '建仓',
  `onumber` int(20) NULL DEFAULT 1 COMMENT '手数',
  `selltime` int(20) NULL DEFAULT 0 COMMENT '平仓',
  `ostaus` int(11) NULL DEFAULT NULL COMMENT '0交易，1平仓',
  `buyprice` decimal(12, 5) UNSIGNED NULL DEFAULT 0.00000 COMMENT '入仓价',
  `sellprice` decimal(12, 5) NULL DEFAULT 0.00000 COMMENT '平仓价',
  `endprofit` decimal(11, 2) NULL DEFAULT 0.00 COMMENT '止盈',
  `endloss` decimal(11, 2) NULL DEFAULT 0.00 COMMENT '止亏',
  `fee` decimal(12, 2) NULL DEFAULT NULL COMMENT '手续费',
  `orderno` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单编号',
  `ploss` decimal(12, 2) NULL DEFAULT 0.00 COMMENT '盈亏',
  `display` int(11) NULL DEFAULT 0 COMMENT '0,可查询，1不可查询',
  `is_hide` int(11) NOT NULL,
  `Bond` decimal(12, 2) NULL DEFAULT NULL COMMENT '保证金',
  `type` tinyint(1) NULL DEFAULT NULL COMMENT '1 实盘交易 2模拟交易',
  `auto` tinyint(1) NULL DEFAULT NULL COMMENT '1 手动平仓 2自动平仓',
  `exchange_fee` decimal(12, 2) NULL DEFAULT 0.00 COMMENT '交易所手续费',
  `operate_fee` decimal(12, 2) NULL DEFAULT 0.00 COMMENT '运营中心手续费',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`oid`, `is_hide`) USING BTREE,
  INDEX `ostaus`(`ostaus`) USING BTREE,
  INDEX `display`(`display`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE,
  INDEX `ploss`(`ploss`) USING BTREE,
  INDEX `auto`(`auto`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `type`(`type`) USING BTREE,
  INDEX `ostyle`(`ostyle`) USING BTREE,
  INDEX `buytime`(`buytime`) USING BTREE,
  INDEX `auto_o`(`oid`, `ostaus`) USING BTREE,
  INDEX `auto_pay`(`pid`, `ostaus`, `display`) USING BTREE COMMENT '平仓回款'
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wp_setting
-- ----------------------------
DROP TABLE IF EXISTS `wp_setting`;
CREATE TABLE `wp_setting`  (
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置名称',
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `datas` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '序列化后的信息',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `modify_date` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE,
  INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统应用配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_setting
-- ----------------------------
INSERT INTO `wp_setting` VALUES ('SYSTEM_CURRENCY_TYPE', '系统货币设置', 'a:6:{s:3:\"CNY\";a:3:{s:4:\"name\";s:9:\"人民币\";s:4:\"code\";s:3:\"CNY\";s:4:\"rate\";s:6:\"1.0000\";}s:3:\"HKD\";a:3:{s:4:\"name\";s:6:\"港元\";s:4:\"code\";s:3:\"HKD\";s:4:\"rate\";s:3:\"0.9\";}s:3:\"USD\";a:3:{s:4:\"name\";s:6:\"美元\";s:4:\"code\";s:3:\"USD\";s:4:\"rate\";s:1:\"7\";}s:3:\"EUR\";a:3:{s:4:\"name\";s:6:\"欧元\";s:4:\"code\";s:3:\"EUR\";s:4:\"rate\";s:3:\"7.5\";}s:3:\"GBP\";a:3:{s:4:\"name\";s:6:\"英镑\";s:4:\"code\";s:3:\"GBP\";s:4:\"rate\";s:7:\"10.0000\";}s:3:\"DEM\";a:3:{s:4:\"name\";s:6:\"马克\";s:4:\"code\";s:3:\"DEM\";s:4:\"rate\";s:6:\"1.0000\";}}', '2018-09-12 11:40:21', '2018-09-12 11:40:21');
INSERT INTO `wp_setting` VALUES ('SYSTEM_OPTION_NUMBER', '用户购买手数限制', 'a:1:{s:8:\"sys_date\";s:5:\"30|10\";}', '2018-09-17 10:19:48', '2018-09-17 10:19:48');
INSERT INTO `wp_setting` VALUES ('SYSTEM_OPTION_SELL_TIME', '交易时间内，商品提前几分钟全部强制平仓', NULL, '2016-12-09 15:17:56', '0000-00-00 00:00:00');
INSERT INTO `wp_setting` VALUES ('SYSTEM_OPTION_TIME', '商品开市、休市时间', 'a:1:{s:8:\"sys_date\";s:1:\"5\";}', '2016-12-21 14:59:25', '2016-12-21 14:59:25');

-- ----------------------------
-- Table structure for wp_site_stretch
-- ----------------------------
DROP TABLE IF EXISTS `wp_site_stretch`;
CREATE TABLE `wp_site_stretch`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公告标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公告内容',
  `start_time` int(11) NOT NULL DEFAULT 0 COMMENT '公告开始时间',
  `end_time` int(11) NOT NULL DEFAULT 0 COMMENT '公告结束时间',
  `dateline` int(11) NOT NULL DEFAULT 0 COMMENT '操作时间',
  `temptime` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `start_time`(`start_time`) USING BTREE,
  INDEX `end_time`(`end_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '站点公告表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_site_stretch
-- ----------------------------
INSERT INTO `wp_site_stretch` VALUES (26, '美国劳动节休市公告', '&lt;p&gt;尊敬的会员：&amp;nbsp;&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; 因本周一（9月4号）为美国劳动节公众假期，美国金融市场（美原油，纽约金，纽约银）将于周二（9月5号）凌晨01:00点提前休市。请大家知晓，提前做好安排！&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;2017/09/04&lt;/p&gt;  \r\n							', 1504490419, 1504548000, 1504490386, '2017-09-04 09:59:46');
INSERT INTO `wp_site_stretch` VALUES (27, '国庆节和中秋节休市通知', '  \r\n							  &lt;p&gt;尊敬的客户：&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; 1：由于下周10月01日国庆节和10月4日中秋节，香港交易所产品因节假日10月2日（周一）和10月5日（周四）将休市，其它产品不受影响。&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; 2：因国庆节假日影响，银行结算无法正常清算。10月2日至10月6日本系统暂停出金功能，入金及交易不受影响。10月9日恢复出金功能。请各位提前做好资金安排。&amp;nbsp;&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; 2017/09/28&lt;/p&gt;  \r\n														', 1538116192, 1507456800, 1536843756, '2018-09-13 21:02:36');
INSERT INTO `wp_site_stretch` VALUES (28, '冬令时通知', '&lt;p&gt;尊敬的客户，您好：&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;美国夏令时将会在11月05日（周日）正式结束，并转为冬令时。11月05日（周一），所有美国交易所,包括CME、CBOT、COMEX、 NYMEX、NYBOT等相关交易所交易时间（开市及收市）将延后一个小时。感谢您的关注。&lt;/p&gt;  \r\n							', 1509851877, 1509940801, 1509851863, '2017-11-05 11:17:43');
INSERT INTO `wp_site_stretch` VALUES (31, '【通知】', '  \r\n							    \r\n							    \r\n							    \r\n							    \r\n							    \r\n							    \r\n							    \r\n							  &lt;p&gt;&lt;b&gt;尊敬的会员：&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;b&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;您好！我司平台服务器完成，产品正常交易，由此给您造成的不便，敬请谅解，感谢广大用户对我司的理解与信任。&lt;/b&gt;&lt;/p&gt;&lt;p&gt;&lt;b&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;2018/10/08&lt;/b&gt;&lt;/p&gt;  \r\n																																																															', 1538959049, 1539100738, 1538977893, '2018-10-08 13:51:33');

-- ----------------------------
-- Table structure for wp_user_journal
-- ----------------------------
DROP TABLE IF EXISTS `wp_user_journal`;
CREATE TABLE `wp_user_journal`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT 0 COMMENT '用户id',
  `account` decimal(11, 2) NULL DEFAULT 0.00 COMMENT '出入金额',
  `type` tinyint(1) NULL DEFAULT NULL COMMENT '1用户佣金提取  2运营中心保证金 3用户金额变动 4用户金币',
  `create_time` int(12) NULL DEFAULT NULL COMMENT '处理时间',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `type`(`type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for wp_userinfo
-- ----------------------------
DROP TABLE IF EXISTS `wp_userinfo`;
CREATE TABLE `wp_userinfo`  (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户登录帐号',
  `upwd` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `trade_pwd` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '提款密码',
  `utel` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机号码',
  `utime` int(20) NULL DEFAULT NULL COMMENT '注册时间',
  `update_time` int(10) NULL DEFAULT NULL COMMENT '更新时间',
  `agenttype` int(20) NULL DEFAULT 0 COMMENT '0普通客户，1申请经纪人中，2经纪人',
  `s_domain` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '经纪人的域名串，xxx.ronmei.com',
  `s_domain_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '经纪人的域名对应的系统的名称',
  `otype` int(11) UNSIGNED NOT NULL COMMENT '	0客户，2会员单位，1经纪人,3超级管理员，4普通会员，新增加（5-运营中心，6-经纪人，7-运营中心分部）',
  `is_default` tinyint(1) NULL DEFAULT 0 COMMENT '是否是默认的经纪人，1，是默认，0 不是默认',
  `ustatus` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0正常状态，1冻结状态，2删除',
  `oid` int(11) NULL DEFAULT NULL COMMENT '上线字段',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '地址',
  `portrait` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像',
  `lastlog` int(20) NULL DEFAULT NULL COMMENT '最后登录时间',
  `managername` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '上线用户名',
  `comname` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公司名称',
  `comqua` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公司资质',
  `rebate` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '返点',
  `feerebate` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手续费返点',
  `usertype` int(11) NULL DEFAULT 0 COMMENT '0不是微信用户。1是微信用户',
  `wxtype` int(11) NULL DEFAULT 0 COMMENT '1表示微信还没注册，0微信已注册成会员。',
  `openid` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '存微信用户的id',
  `nickname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户昵称',
  `rid` int(11) NOT NULL DEFAULT 0 COMMENT '推荐人id',
  `vertus` int(1) NULL DEFAULT 1,
  `temptime` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '推荐码',
  `superior_id` tinyint(5) NULL DEFAULT NULL COMMENT '上级id',
  `reg_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '注册ip地址',
  `last_login_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '最后登陆ip',
  `is_slippage` tinyint(1) NULL DEFAULT 0 COMMENT '是否开启滑点 0关闭 1开启',
  `buyprice` tinyint(1) NULL DEFAULT 0 COMMENT '买入 滑点价',
  `sellprice` tinyint(1) NULL DEFAULT 0 COMMENT '平仓滑点价',
  `is_essential` tinyint(1) NULL DEFAULT 0 COMMENT '0 关闭 1必赢 2必输',
  `opentlist` tinyint(1) NULL DEFAULT 0 COMMENT '是否开放持仓监控功能（针对otype=6的机构），0为不开放，1为开放',
  `s_domain_trade` tinyint(1) NOT NULL DEFAULT 1,
  `token` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户唯一标识',
  `trade_frozen` tinyint(1) NULL DEFAULT 0 COMMENT '0正常交易 1交易冻结',
  PRIMARY KEY (`uid`) USING BTREE,
  UNIQUE INDEX `code`(`code`) USING BTREE,
  INDEX `utel`(`utel`) USING BTREE,
  INDEX `ustatus`(`ustatus`) USING BTREE,
  INDEX `otype`(`otype`) USING BTREE,
  INDEX `s_domain`(`s_domain`) USING BTREE,
  INDEX `upwd`(`upwd`) USING BTREE,
  INDEX `is_default`(`is_default`) USING BTREE,
  INDEX `rid`(`rid`) USING BTREE,
  INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 183 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_userinfo
-- ----------------------------
INSERT INTO `wp_userinfo` VALUES (1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', NULL, '13361665525', 1478491328, NULL, 0, '', '', 3, 0, 0, 0, '', '', 1676559821, '', '', '', '', '', 0, 0, '', 'admin', 0, 1, '2023-02-17 10:19:38', '', NULL, '', '123.171.242.237', 0, 0, 0, 0, 0, 1, '', 0);
INSERT INTO `wp_userinfo` VALUES (2, 'tebieyunying', 'e10adc3949ba59abbe56e057f20f883e', NULL, '18888888888', 1527530020, NULL, 0, NULL, NULL, 7, 0, 0, NULL, NULL, NULL, 1676559497, NULL, NULL, NULL, NULL, NULL, 0, 0, '', NULL, 0, 1, '2023-02-17 10:09:14', NULL, NULL, '219.72.35.178', '123.171.242.237', 0, 0, 0, 0, 0, 1, NULL, 0);
INSERT INTO `wp_userinfo` VALUES (3, 'yunyingzhongxin', 'e10adc3949ba59abbe56e057f20f883e', NULL, '000000000000', 1527530056, 1536551311, 0, '39', '鼎盛国际', 5, 0, 0, NULL, NULL, NULL, 1676559515, NULL, NULL, NULL, NULL, NULL, 0, 0, '', '15827378999', 0, 1, '2023-02-16 22:58:35', NULL, NULL, NULL, '123.171.242.237', 0, 0, 0, 0, 0, 1, NULL, 0);
INSERT INTO `wp_userinfo` VALUES (4, 'jingjiren', 'e10adc3949ba59abbe56e057f20f883e', NULL, '17777777777', 1527530056, NULL, 0, NULL, NULL, 6, 1, 0, NULL, NULL, NULL, 1539311774, NULL, NULL, NULL, NULL, NULL, 0, 0, '', NULL, 0, 1, '2023-02-17 10:09:22', 'yz9q', NULL, NULL, '119.163.107.106', 0, 0, 0, 0, 0, 1, NULL, 0);
INSERT INTO `wp_userinfo` VALUES (5, '123456', 'e10adc3949ba59abbe56e057f20f883e', '96e79218965eb72c92a549dd5a330112', '123456', 1527530145, NULL, 0, NULL, NULL, 4, 0, 0, NULL, NULL, NULL, 1676547480, NULL, NULL, NULL, NULL, NULL, 0, 1, '', '大侠', 0, 1, '2023-02-17 10:19:39', 'mtve', NULL, '219.72.35.178', '123.171.242.237', 0, 0, 0, 0, 0, 1, NULL, 0);

-- ----------------------------
-- Table structure for wp_userinfo_extra
-- ----------------------------
DROP TABLE IF EXISTS `wp_userinfo_extra`;
CREATE TABLE `wp_userinfo_extra`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `img_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片路径',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_userinfo_extra
-- ----------------------------
INSERT INTO `wp_userinfo_extra` VALUES (1, 4, 'Uploads/qrcode/extension_uid4.png');

-- ----------------------------
-- Table structure for wp_userinfo_rate
-- ----------------------------
DROP TABLE IF EXISTS `wp_userinfo_rate`;
CREATE TABLE `wp_userinfo_rate`  (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '佣金比率名称',
  `rate` tinyint(2) NULL DEFAULT NULL COMMENT '佣金比率',
  `class` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '级别 class_a',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `class`(`class`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_userinfo_rate
-- ----------------------------
INSERT INTO `wp_userinfo_rate` VALUES (1, '一级', 0, 'class_a');
INSERT INTO `wp_userinfo_rate` VALUES (2, '二级', 0, 'class_b');

-- ----------------------------
-- Table structure for wp_userinfo_relationship
-- ----------------------------
DROP TABLE IF EXISTS `wp_userinfo_relationship`;
CREATE TABLE `wp_userinfo_relationship`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `parent_user_id` int(11) NOT NULL COMMENT '上级id',
  `all_path` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '整个路径，当前id的所有父级id字串',
  `user_type` tinyint(1) UNSIGNED NOT NULL COMMENT '4普通用户 5运营中心 ，6经纪人 ，7运营中心分部',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `parent_user_id`(`parent_user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 177 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户关系表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_userinfo_relationship
-- ----------------------------
INSERT INTO `wp_userinfo_relationship` VALUES (1, '2018-05-29 01:53:40', 2, 0, NULL, 7);
INSERT INTO `wp_userinfo_relationship` VALUES (2, '2018-05-29 01:54:16', 3, 2, NULL, 5);
INSERT INTO `wp_userinfo_relationship` VALUES (3, '2018-05-29 01:54:16', 4, 3, NULL, 6);
INSERT INTO `wp_userinfo_relationship` VALUES (4, '2023-02-17 10:06:00', 5, 4, NULL, 4);

-- ----------------------------
-- Table structure for wp_userinfo_type
-- ----------------------------
DROP TABLE IF EXISTS `wp_userinfo_type`;
CREATE TABLE `wp_userinfo_type`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户类型名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_userinfo_type
-- ----------------------------
INSERT INTO `wp_userinfo_type` VALUES (1, '废弃');
INSERT INTO `wp_userinfo_type` VALUES (2, '废弃');
INSERT INTO `wp_userinfo_type` VALUES (3, '超级管理员');
INSERT INTO `wp_userinfo_type` VALUES (4, '普通会员');
INSERT INTO `wp_userinfo_type` VALUES (5, '运营中心');
INSERT INTO `wp_userinfo_type` VALUES (6, '经纪人');

-- ----------------------------
-- Table structure for wp_webconfig
-- ----------------------------
DROP TABLE IF EXISTS `wp_webconfig`;
CREATE TABLE `wp_webconfig`  (
  `id` int(11) NOT NULL,
  `isopen` int(11) NOT NULL DEFAULT 0 COMMENT '0开启，1关闭',
  `webname` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '网站名称',
  `notice` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公告',
  `tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '电话号码',
  `gold` double(8, 2) NULL DEFAULT 0.00 COMMENT '用户注册赠送金币',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '站点配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_webconfig
-- ----------------------------
INSERT INTO `wp_webconfig` VALUES (1, 1, '演示站', '你们好', '123123', 100000.00);

-- ----------------------------
-- Table structure for wp_wechat
-- ----------------------------
DROP TABLE IF EXISTS `wp_wechat`;
CREATE TABLE `wp_wechat`  (
  `wcid` int(11) NOT NULL AUTO_INCREMENT,
  `appid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'AppID(应用ID)',
  `appsecret` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'AppSecret(应用密钥)',
  `wxname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公众号名称',
  `wxlogin` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信原始账号',
  `wxurl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'url服务器地址',
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '令牌',
  `encodingaeskey` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '消息加密解密秘钥',
  `parterid` int(11) NULL DEFAULT NULL COMMENT '微信商户账号',
  `parterkey` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '32位密码',
  PRIMARY KEY (`wcid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_wechat
-- ----------------------------
INSERT INTO `wp_wechat` VALUES (2, 'wx8af0509b13b89111', '19e57bc630ccc7fa30d7fd92dfc84ccf', '米盘', '123456@qq.com', 'www.123456.com', 'bqsoftware', 'h836JG7S72nbMg1n4EgUOTf57ro7vKUU3bKICVZEp2Y', 0, '商户秘钥');

-- ----------------------------
-- Table structure for wp_wx_user
-- ----------------------------
DROP TABLE IF EXISTS `wp_wx_user`;
CREATE TABLE `wp_wx_user`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `bpid` int(200) NULL DEFAULT NULL,
  `openid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `score` int(10) NULL DEFAULT NULL,
  `nickname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sex` int(2) NULL DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `province` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `headimgurl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `privilege` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `unionid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- View structure for view_account_info_in
-- ----------------------------
DROP VIEW IF EXISTS `view_account_info_in`;
CREATE ALGORITHM = UNDEFINED DEFINER = `ronmei`@`%` SQL SECURITY DEFINER VIEW `view_account_info_in` AS select `wp_balance`.`uid` AS `uid`,sum(`wp_balance`.`bpprice`) AS `money_total` from `wp_balance` where ((`wp_balance`.`status` = 1) and (`wp_balance`.`b_type` = 1) and (`wp_balance`.`isverified` = 1)) group by `wp_balance`.`uid`;

-- ----------------------------
-- View structure for view_account_info_out
-- ----------------------------
DROP VIEW IF EXISTS `view_account_info_out`;
CREATE ALGORITHM = UNDEFINED DEFINER = `ronmei`@`%` SQL SECURITY DEFINER VIEW `view_account_info_out` AS select `wp_balance`.`uid` AS `uid`,sum(`wp_balance`.`bpprice`) AS `money_total` from `wp_balance` where ((`wp_balance`.`status` = 1) and (`wp_balance`.`b_type` = 2) and (`wp_balance`.`isverified` = 1)) group by `wp_balance`.`uid`;

-- ----------------------------
-- View structure for view_orders
-- ----------------------------
DROP VIEW IF EXISTS `view_orders`;
CREATE ALGORITHM = UNDEFINED DEFINER = `ronmei`@`%` SQL SECURITY DEFINER VIEW `view_orders` AS select `wp_order`.`oid` AS `oid`,`wp_order`.`uid` AS `uid`,`wp_order`.`pid` AS `pid`,`wp_order`.`ostyle` AS `ostyle`,`wp_order`.`buytime` AS `buytime`,`wp_order`.`onumber` AS `onumber`,`wp_order`.`selltime` AS `selltime`,`wp_order`.`ostaus` AS `ostaus`,`wp_order`.`buyprice` AS `buyprice`,`wp_order`.`sellprice` AS `sellprice`,`wp_order`.`endprofit` AS `endprofit`,`wp_order`.`endloss` AS `endloss`,`wp_order`.`fee` AS `fee`,`wp_order`.`orderno` AS `orderno`,`wp_order`.`ploss` AS `ploss`,`wp_order`.`display` AS `display`,`wp_order`.`is_hide` AS `is_hide`,`wp_order`.`Bond` AS `Bond`,`wp_order`.`type` AS `type`,`wp_order`.`auto` AS `auto`,`wp_order`.`tempdate` AS `tempdate`,from_unixtime(`wp_order`.`selltime`) AS `sell_date`,from_unixtime(`wp_order`.`buytime`) AS `buy_date` from `wp_order`;

-- ----------------------------
-- View structure for view_order_gold
-- ----------------------------
DROP VIEW IF EXISTS `view_order_gold`;
CREATE ALGORITHM = UNDEFINED DEFINER = `ronmei`@`%` SQL SECURITY DEFINER VIEW `view_order_gold` AS select `wp_order`.`uid` AS `uid`,sum(`wp_order`.`ploss`) AS `money_total` from `wp_order` where ((`wp_order`.`ostaus` = 1) and (`wp_order`.`type` = 2)) group by `wp_order`.`uid`;

-- ----------------------------
-- View structure for view_order_real
-- ----------------------------
DROP VIEW IF EXISTS `view_order_real`;
CREATE ALGORITHM = UNDEFINED DEFINER = `ronmei`@`%` SQL SECURITY DEFINER VIEW `view_order_real` AS select `wp_order`.`uid` AS `uid`,sum(`wp_order`.`ploss`) AS `money_total` from `wp_order` where ((`wp_order`.`ostaus` = 1) and (`wp_order`.`type` = 1)) group by `wp_order`.`uid`;

-- ----------------------------
-- View structure for view_order_user_commission
-- ----------------------------
DROP VIEW IF EXISTS `view_order_user_commission`;
CREATE ALGORITHM = UNDEFINED DEFINER = `ronmei`@`%` SQL SECURITY DEFINER VIEW `view_order_user_commission` AS select `wp_order`.`uid` AS `uid`,sum(`wp_order`.`fee`) AS `total_commission` from `wp_order` where ((`wp_order`.`ostaus` = 1) and (`wp_order`.`type` = 1)) group by `wp_order`.`uid`;

-- ----------------------------
-- View structure for view_order_user_fee_gold
-- ----------------------------
DROP VIEW IF EXISTS `view_order_user_fee_gold`;
CREATE ALGORITHM = UNDEFINED DEFINER = `ronmei`@`%` SQL SECURITY DEFINER VIEW `view_order_user_fee_gold` AS select `wp_order`.`uid` AS `uid`,sum(`wp_order`.`fee`) AS `total_commission` from `wp_order` where ((`wp_order`.`ostaus` = 1) and (`wp_order`.`type` = 2)) group by `wp_order`.`uid`;

-- ----------------------------
-- View structure for view_order_user_fee_real
-- ----------------------------
DROP VIEW IF EXISTS `view_order_user_fee_real`;
CREATE ALGORITHM = UNDEFINED DEFINER = `ronmei`@`%` SQL SECURITY DEFINER VIEW `view_order_user_fee_real` AS select `wp_order`.`uid` AS `uid`,sum(`wp_order`.`fee`) AS `total_commission` from `wp_order` where ((`wp_order`.`ostaus` = 1) and (`wp_order`.`type` = 1)) group by `wp_order`.`uid`;

-- ----------------------------
-- View structure for view_wp_journal
-- ----------------------------
DROP VIEW IF EXISTS `view_wp_journal`;
CREATE ALGORITHM = UNDEFINED DEFINER = `ronmei`@`%` SQL SECURITY DEFINER VIEW `view_wp_journal` AS select `wp_journal`.`uid` AS `uid`,`wp_journal`.`jtype` AS `jtype`,`wp_journal`.`remarks` AS `remarks`,`wp_journal`.`jfee` AS `jfee`,`wp_journal`.`type` AS `type`,`wp_journal`.`jploss` AS `jploss`,`wp_journal`.`jaccess` AS `jaccess`,`wp_journal`.`juprice` AS `juprice`,`wp_journal`.`jtime` AS `jtime` from `wp_journal` where ((`wp_journal`.`type` = 1) and (`wp_journal`.`jtype` = '平仓'));

-- ----------------------------
-- View structure for view_wp_journal_gold
-- ----------------------------
DROP VIEW IF EXISTS `view_wp_journal_gold`;
CREATE ALGORITHM = UNDEFINED DEFINER = `ronmei`@`%` SQL SECURITY DEFINER VIEW `view_wp_journal_gold` AS select `wp_journal`.`uid` AS `uid`,`wp_journal`.`jtype` AS `jtype`,`wp_journal`.`remarks` AS `remarks`,`wp_journal`.`jfee` AS `jfee`,`wp_journal`.`type` AS `type`,`wp_journal`.`jploss` AS `jploss`,`wp_journal`.`jaccess` AS `jaccess`,`wp_journal`.`juprice` AS `juprice` from `wp_journal` where ((`wp_journal`.`type` = 2) and (`wp_journal`.`jtype` = '平仓'));

-- ----------------------------
-- View structure for view_wp_journal_jian
-- ----------------------------
DROP VIEW IF EXISTS `view_wp_journal_jian`;
CREATE ALGORITHM = UNDEFINED DEFINER = `ronmei`@`%` SQL SECURITY DEFINER VIEW `view_wp_journal_jian` AS select `wp_journal`.`uid` AS `uid`,`wp_journal`.`jtype` AS `jtype`,`wp_journal`.`remarks` AS `remarks`,`wp_journal`.`jfee` AS `jfee`,`wp_journal`.`type` AS `type`,`wp_journal`.`jploss` AS `jploss`,`wp_journal`.`jaccess` AS `jaccess`,`wp_journal`.`juprice` AS `juprice`,`wp_journal`.`jtime` AS `jtime` from `wp_journal` where ((`wp_journal`.`type` = 1) and (`wp_journal`.`jtype` = '建仓'));

-- ----------------------------
-- View structure for view_wp_orders
-- ----------------------------
DROP VIEW IF EXISTS `view_wp_orders`;
CREATE ALGORITHM = UNDEFINED DEFINER = `ronmei`@`%` SQL SECURITY DEFINER VIEW `view_wp_orders` AS select `wp_order`.`oid` AS `oid`,`wp_order`.`uid` AS `uid`,`wp_order`.`pid` AS `pid`,`wp_option`.`capital_key` AS `capital_key`,`wp_option`.`capital_name` AS `capital_name`,`wp_option`.`currency` AS `currency`,`wp_order`.`fee` AS `fee`,`wp_order`.`ploss` AS `ploss`,`wp_order`.`Bond` AS `Bond`,`wp_order`.`ostaus` AS `ostaus` from (`wp_order` join `wp_option`) where ((`wp_order`.`pid` = `wp_option`.`id`) and (`wp_order`.`type` = 1) and (`wp_order`.`ostaus` = 1));

SET FOREIGN_KEY_CHECKS = 1;
