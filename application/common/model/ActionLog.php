<?php
/* @project : tdbase
 * @auther  : 秋水
 * @date    : 2018/7/16
 * @desc    : 后台用户模型
 */

namespace app\common\model;

class ActionLog extends Common {

	/**
	 * 添加日志
	 * @author 秋水
	 * @DateTime 2018-07-16T17:23:06+0800
	 * @param    array                   $user    用户信息
	 * @param    int                   $type    1基本操作 2登录
	 * @param    string                   $content 操作详情描述
	 */
	public function add_log($user,$type,$content)
	{
		$time_now = time();
		$ip = request()->ip();

		$add_data = array(
			'uid' => $user['id'],
			'uname' => $user['username'],
			'type' => $type,
			'content' => $content,
			'create_time' => $time_now,
			'ip' => $ip);
		$r = $this->insert($add_data);
		return $r;
	}
}