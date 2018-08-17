<?php
/**
 * @project : tdbase
 * @auther  : 秋水
 * @date    : 2018/7/16
 * @desc    : 操作日志控制器
 */

namespace app\tdmin\controller;

class ActionLog extends Common {

	/**
	 * 操作日志列表展示
	 * @author 秋水
	 * @DateTime 2018-07-16T17:47:41+0800
	 * @return   [type]                   [description]
	 */
	public function list()
	{
		$keywords = input('param.keywords', '');
		$page = input('param.page', 1);
		$limit = input('param.limit', 10);

		$model = model('ActionLog');

		$where = array();
		if($keywords != '') {
			$where[] = ['uname','like',"%$keywords%"];
		}

        $list = $model->where($where)->page($page, $limit)->order('create_time asc')->select();

        $this->assign('limit', $limit);
        $this->assign('page', $page);
        $this->assign('count', count($list));
        $this->assign('list',$list);

		return $this->fetch();
	}
}
