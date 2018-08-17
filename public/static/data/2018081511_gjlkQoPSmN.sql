-- TD SQL Backup
-- Time:2018-08-15 11:01:18
-- http://www.tdod.com 

--
-- 表的结构 `td_action_log`
-- 
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- 
-- 导出`td_action_log`表中的数据 `td_action_log`
--
INSERT INTO `td_action_log` VALUES (1,1,'admin',2,'登录后台',1531733894,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (2,1,'admin',1,'重置密码成功',1531734435,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (3,1,'admin',2,'登录后台',1532047531,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (4,1,'admin',2,'登录后台',1534206180,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (5,1,'admin',1,'修改菜单【id=12】状态成功',1534211026,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (6,1,'admin',1,'修改菜单【id=12】状态成功',1534211028,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (7,1,'admin',1,'修改菜单【id=12】状态成功',1534211033,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (8,1,'admin',1,'修改菜单【id=9】状态成功',1534211062,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (9,1,'admin',1,'修改菜单【id=9】状态成功',1534211063,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (10,1,'admin',1,'修改菜单【id=17】状态成功',1534211096,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (11,1,'admin',1,'修改菜单【id=17】状态成功',1534211097,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (12,1,'admin',1,'修改菜单【id=17】状态成功',1534211099,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (13,1,'admin',1,'修改菜单【id=12】状态成功',1534211109,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (14,1,'admin',1,'修改菜单【id=17】状态成功',1534211111,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (15,1,'admin',2,'登录后台',1534226457,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (16,1,'admin',2,'登录后台',1534296114,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (17,1,'admin',1,'添加菜单【数据管理】成功',1534296175,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (18,1,'admin',1,'修改菜单【数据管理】成功',1534296241,'127.0.0.1');
INSERT INTO `td_action_log` VALUES (19,1,'admin',2,'登录后台',1534298796,'127.0.0.1');
--
-- 表的结构 `td_auth_admin`
-- 
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

-- 
-- 导出`td_auth_admin`表中的数据 `td_auth_admin`
--
INSERT INTO `td_auth_admin` VALUES (1,'admin','b7b251166d36c32d34676c80dbc64a0a',1,'管理员','12345','127.0.0.1',1534298796,1530754723,1531734435);
INSERT INTO `td_auth_admin` VALUES (4,'test1','14e1b600b1fd579f47433b88e8d85291',8,'测试用户','13484190141','127.0.0.1',1530882220,1530882208,1530882208);
--
-- 表的结构 `td_auth_group`
-- 
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

-- 
-- 导出`td_auth_group`表中的数据 `td_auth_group`
--
INSERT INTO `td_auth_group` VALUES (1,'超级管理员',1,'',1446535750,1446535750);
INSERT INTO `td_auth_group` VALUES (8,'访客',1,'1,2,3,10,13,14,15,16,4,5,6,9,12,17',1484203483,1486697792);
--
-- 表的结构 `td_auth_group_access`
-- 
DROP TABLE IF EXISTS `td_auth_group_access`;
CREATE TABLE `td_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- 导出`td_auth_group_access`表中的数据 `td_auth_group_access`
--
INSERT INTO `td_auth_group_access` VALUES (1,1);
INSERT INTO `td_auth_group_access` VALUES (4,8);
--
-- 表的结构 `td_auth_rule`
-- 
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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- 
-- 导出`td_auth_rule`表中的数据 `td_auth_rule`
--
INSERT INTO `td_auth_rule` VALUES (1,'#','系统管理',1,1,'fa fa-gear','',0,7,1446535750,1484296512);
INSERT INTO `td_auth_rule` VALUES (2,'tdmin/auth/userlist','用户管理',1,1,'fa-arrow','',1,0,1446535750,1530867176);
INSERT INTO `td_auth_rule` VALUES (3,'tdmin/auth/grouplist','角色管理',1,1,'','',1,0,1446535750,1530801876);
INSERT INTO `td_auth_rule` VALUES (4,'tdmin/auth/rulelist','菜单管理',1,1,'','',1,0,1446535750,1530801724);
INSERT INTO `td_auth_rule` VALUES (5,'tdmin/auth/addrule','添加菜单',1,1,'','',4,0,1530798553,1530801655);
INSERT INTO `td_auth_rule` VALUES (6,'tdmin/auth/editurl','修改菜单',1,1,'','',4,0,1530798593,1530801700);
INSERT INTO `td_auth_rule` VALUES (9,'tdmin/auth/delrule','删除菜单',1,1,'','',4,0,1530801128,1530801707);
INSERT INTO `td_auth_rule` VALUES (10,'tdmin/auth/addgroup','添加角色',1,1,'','',3,0,1530801813,1530801813);
INSERT INTO `td_auth_rule` VALUES (12,'tdmin/auth/changerulestatus','修改菜单状态',1,1,'','',4,2,1530837260,1530846401);
INSERT INTO `td_auth_rule` VALUES (13,'tdmin/auth/editgroup','修改角色',1,1,'','',3,0,1530866941,1530866941);
INSERT INTO `td_auth_rule` VALUES (14,'tdmin/auth/delgroup','删除角色',1,1,'','',3,0,1530866968,1530866968);
INSERT INTO `td_auth_rule` VALUES (15,'tdmin/auth/permissionlist','分配权限',1,1,'','',3,0,1530867004,1530867004);
INSERT INTO `td_auth_rule` VALUES (16,'tdmin/auth/changegrouprule','提交分配权限',1,1,'','',3,0,1530867114,1530867114);
INSERT INTO `td_auth_rule` VALUES (17,'tdmin/action_log/list','操作日志',1,1,'','',1,0,1531732610,1531732610);
INSERT INTO `td_auth_rule` VALUES (18,'tdmin/database/database','数据管理',1,1,'','',1,0,1534296175,1534296241);
--
-- 表的结构 `td_member`
-- 
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