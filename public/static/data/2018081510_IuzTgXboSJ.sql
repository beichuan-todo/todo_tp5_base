-- CLTPHP SQL Backup
-- Time:2018-08-15 10:59:37
-- http://www.cltphp.com 

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