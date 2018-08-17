<?php
/* @project : tdshop
 * @auther  : 秋水
 * @date    : 2018/7/4
 * @desc    : 后台公共制器
 */
namespace app\tdmin\controller;

class Index extends Common {
	protected function initialize() {
		parent::initialize();
	}

	function index() {
		return $this->fetch();
	}
}
