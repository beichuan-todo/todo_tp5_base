<?php
/* @project : tdbase
 * @auther  : 秋水
 * @date    : 2018/7/5
 * @desc    : 用户权限模型
 */

namespace app\common\model;

class AuthRule extends Common {

	/**
	 * 获取菜单
	 * @author 秋水
	 * @DateTime 2018-07-05T10:34:21+0800
	 * @param    string                   $nodeStr [description]
	 * @return   [type]                            [description]
	 */
	public function getMenu($nodeStr = '') {

        //超级管理员没有节点数组
        $where = empty($nodeStr) ? 'status = 1' : 'status = 1 and id in('.$nodeStr.')';
        $result = $this->where($where)->order('sort')->select();
        if(config('template')['theme_name'] == "default"){
            $new_result=array();
            foreach($result as $k => $v){
                $new_result[$k]['id'] = $v['id'];
                $new_result[$k]['pid'] = $v['pid'];
                $new_result[$k]['name'] = $v['name'];
                $new_result[$k]['title'] = $v['title'];
                $new_result[$k]['icon'] = $v['css'];

                $new_result[$k]['spread'] = false;
                $new_result[$k]['selected'] = false;
                // $new_result[$k]['href']=$v['href'];
            }
            $menu = getMenuList($new_result);
        }else{
            $menu = prepare_menu($result);
        }

        return $menu;
    }
}