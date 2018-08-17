<?php
/* @project : tdbase
 * @auther  : 秋水
 * @date    : 2018/7/5
 * @desc    : 用户组模型
 */

namespace app\common\model;

class AuthGroup extends Common {

	/**
	 * 根据角色id获取权限
	 * @author 秋水
	 * @DateTime 2018-07-06T11:39:45+0800
	 * @param    [type]                   $id [description]
	 * @return   [type]                       [description]
	 */
    public function getRuleById($id)
    {
        $res = $this->field('rules')->where('id', $id)->find();
        return $res['rules'];
    }
}