/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80011
 Source Host           : localhost
 Source Database       : tdbase

 Target Server Type    : MySQL
 Target Server Version : 80011
 File Encoding         : utf-8

 Date: 07/23/2018 13:40:18 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `td_action_log`
-- ----------------------------
DROP TABLE IF EXISTS `td_action_log`;
CREATE TABLE `td_action_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `uname` varchar(20) DEFAULT NULL,
  `type` int(11) DEFAULT '1' COMMENT '1后台操作 2登录',
  `content` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `td_action_log`
-- ----------------------------
BEGIN;
INSERT INTO `td_action_log` VALUES ('1', '1', 'admin', '2', '登录后台', '1531733894', '127.0.0.1'), ('2', '1', 'admin', '1', '重置密码成功', '1531734435', '127.0.0.1'), ('3', '1', 'admin', '2', '登录后台', '1532047531', '127.0.0.1');
COMMIT;

-- ----------------------------
--  Table structure for `td_auth_admin`
-- ----------------------------
DROP TABLE IF EXISTS `td_auth_admin`;
CREATE TABLE `td_auth_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL COMMENT '登录名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `group_id` int(11) DEFAULT NULL,
  `real_name` varchar(30) NOT NULL COMMENT '真实姓名',
  `telephone` varchar(20) NOT NULL COMMENT '手机号',
  `last_login_ip` varchar(15) DEFAULT NULL COMMENT '最近登录IP',
  `last_login_time` int(11) DEFAULT NULL COMMENT '最近登录时间',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='后台管理员表';

-- ----------------------------
--  Records of `td_auth_admin`
-- ----------------------------
BEGIN;
INSERT INTO `td_auth_admin` VALUES ('1', 'admin', 'b7b251166d36c32d34676c80dbc64a0a', '1', '管理员', '12345', '127.0.0.1', '1532047531', '1530754723', '1531734435'), ('4', 'test1', '14e1b600b1fd579f47433b88e8d85291', '8', '测试用户', '13484190141', '127.0.0.1', '1530882220', '1530882208', '1530882208');
COMMIT;

-- ----------------------------
--  Table structure for `td_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `td_auth_group`;
CREATE TABLE `td_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(255) NOT NULL DEFAULT '',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `td_auth_group`
-- ----------------------------
BEGIN;
INSERT INTO `td_auth_group` VALUES ('1', '超级管理员', '1', '', '1446535750', '1446535750'), ('8', '访客', '1', '1,2,3,10,13,14,15,16,4,5,6,9,12,17', '1484203483', '1486697792');
COMMIT;

-- ----------------------------
--  Table structure for `td_auth_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `td_auth_group_access`;
CREATE TABLE `td_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `td_auth_group_access`
-- ----------------------------
BEGIN;
INSERT INTO `td_auth_group_access` VALUES ('1', '1'), ('4', '8');
COMMIT;

-- ----------------------------
--  Table structure for `td_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `td_auth_rule`;
CREATE TABLE `td_auth_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 启用 0 未启用',
  `css` varchar(20) NOT NULL COMMENT '样式',
  `condition` char(100) NOT NULL DEFAULT '',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父栏目ID',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `td_auth_rule`
-- ----------------------------
BEGIN;
INSERT INTO `td_auth_rule` VALUES ('1', '#', '系统管理', '1', '1', 'fa fa-gear', '', '0', '7', '1446535750', '1484296512'), ('2', 'tdmin/auth/user_list', '用户管理', '1', '1', 'fa-arrow', '', '1', '0', '1446535750', '1530867176'), ('3', 'tdmin/auth/group_list', '角色管理', '1', '1', '', '', '1', '0', '1446535750', '1530801876'), ('4', 'tdmin/auth/rule_list', '菜单管理', '1', '1', '', '', '1', '0', '1446535750', '1530801724'), ('5', 'tdmin/auth/add_rule', '添加菜单', '1', '1', '', '', '4', '0', '1530798553', '1530801655'), ('6', 'tdmin/auth/edit_url', '修改菜单', '1', '1', '', '', '4', '0', '1530798593', '1530801700'), ('9', 'tdmin/auth/del_rule', '删除菜单', '1', '1', '', '', '4', '0', '1530801128', '1530801707'), ('10', 'tdmin/auth/add_group', '添加角色', '1', '1', '', '', '3', '0', '1530801813', '1530801813'), ('12', 'tdmin/auth/change_rule_status', '修改菜单状态', '1', '1', '', '', '4', '2', '1530837260', '1530846401'), ('13', 'tdmin/auth/edit_group', '修改角色', '1', '1', '', '', '3', '0', '1530866941', '1530866941'), ('14', 'tdmin/auth/del_group', '删除角色', '1', '1', '', '', '3', '0', '1530866968', '1530866968'), ('15', 'tdmin/auth/permission_list', '分配权限', '1', '1', '', '', '3', '0', '1530867004', '1530867004'), ('16', 'tdmin/auth/change_group_rule', '提交分配权限', '1', '1', '', '', '3', '0', '1530867114', '1530867114'), ('17', 'tdmin/action_log/list', '操作日志', '1', '1', '', '', '1', '0', '1531732610', '1531732610');
COMMIT;

-- ----------------------------
--  Table structure for `td_member`
-- ----------------------------
DROP TABLE IF EXISTS `td_member`;
CREATE TABLE `td_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(30) NOT NULL COMMENT '登录名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `nickname` varchar(30) NOT NULL COMMENT '昵称',
  `telephone` varchar(20) NOT NULL COMMENT '电话',
  `openid` varchar(32) NOT NULL COMMENT '微信openid',
  `headimg` varchar(100) NOT NULL COMMENT '头像地址',
  `status` tinyint(1) NOT NULL COMMENT '状态：0禁用，1正常',
  `balance` decimal(10,2) NOT NULL COMMENT '账户余额',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
