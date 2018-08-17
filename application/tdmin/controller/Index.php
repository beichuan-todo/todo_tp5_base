<?php
/**
 * @project : tdbase
 * @auther  : 秋水
 * @date    : 2018/7/4
 * @desc    : 后台主控制器
 */
namespace app\tdmin\controller;

class Index extends Common {

	/**
	 * 构造函数
	 * @author 秋水
	 * @DateTime 2018-07-04T14:26:07+0800
	 * @return
	 */
	protected function initialize() {
		parent::initialize();
	}

	/**
	 * 首页
	 * @author 秋水
	 * @DateTime 2018-07-04T14:26:17+0800
	 * @return
	 */
	public function index()
	{
		return $this->fetch();
	}

	/**
	 * 展示内容
	 * @author 秋水
	 * @DateTime 2018-07-05T22:35:53+0800
	 * @return   [type]                   [description]
	 */
	public function content()
	{
		return $this->fetch();
	}
}
