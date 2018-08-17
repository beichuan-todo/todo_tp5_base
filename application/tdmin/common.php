<?php
// +----------------------------------------------------------------------
// +----------------------------------------------------------------------
// | Author: 秋水
// +----------------------------------------------------------------------

// 后台模块公共文件

/**
 * 整理菜单树方法
 * @author 秋水
 * @DateTime 2018-07-05T10:39:50+0800
 * @param    [type]                   $param [description]
 * @return   [type]                          [description]
 */
function prepare_menu($param)
{
    $module     = strtolower(request()->module());
    $controller = strtolower(request()->controller());
    $action     = strtolower(request()->action());
    $url        = $module."/".$controller."/".$action;

    $parent = []; //父类
    $child = [];  //子类

    foreach($param as $key=>$vo){

        if($vo['pid'] == 0){
            $vo['href'] = '#';
            $parent[] = $vo;
        }else{
            $vo['href'] = url($vo['name']); //跳转地址
            $child[] = $vo;
        }
    }

    foreach($parent as $key=>$vo){
    	$vo_child = array();
        $parent[$key]['spread'] = false;
        foreach($child as $k=>$v){
            if($v['name'] === $url) {
                $v['selected'] = true;
                $parent[$key]['spread'] = true;
            } else {
                $v['selected'] = false;
            }
            if($v['pid'] == $vo['id']){
                $vo_child[] = $v;
            }
        }
        $parent[$key]['child'] = $vo_child;
    }
    unset($child);
    return $parent;
}

/**
 * 获取菜单编辑页展示列表
 * @author 秋水
 * @DateTime 2018-07-05T14:53:27+0800
 * @param    [type]                   $cate     [description]
 * @param    string                   $lefthtml [description]
 * @param    integer                  $pid      [description]
 * @param    integer                  $lvl      [description]
 * @param    integer                  $leftpin  [description]
 * @return   [type]                             [description]
 */
function left_nav_rule($cate ,$lefthtml = '— — ', $pid=0 ,$lvl=0, $leftpin=0 )
{
    $arr=array();
    foreach ($cate as $v){
        if($v['pid']==$pid){
            $v['lvl']=$lvl + 1;
            $v['leftpin']=$leftpin + $lvl*20;//左边距
            $v['lefthtml']=str_repeat($lefthtml,$lvl);
            //$v['lefthtml']='<span style="display:inline-block;width:24px;"></span>'.$lefthtml;//str_repeat($lefthtml,$lvl);
            $arr[]=$v;
            $arr= array_merge($arr,left_nav_rule($cate,$lefthtml,$v['id'] ,$lvl+1, $leftpin+15));
        }
    }
    return $arr;
}

function action_log_type($type)
{
    $r = '-';
    switch ($type) {
        case 1:
            $r = '基本操作';
            break;
        case 2:
            $r = '登录';
            break;
        
        default:
            # code...
            break;
    }

    return $r;
}
