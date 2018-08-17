<?php
/**
 * Created by 北川
 * Date: 2018/8/15 11:21
 */

namespace app\tdmin\controller;


class Cache extends Common
{
    public function cache(){
        return $this->fetch();
    }
    public function clearCache2(){
        $cache_type = input('post.cache');
        foreach ($cache_type as $v ){
            $dir = RUNTIME_PATH . $v;
            $res = dir_delete($dir);
        }
        $result = array();
        if($res === true){
            $result['code'] = 1;
            $result['msg'] = ['清除缓存成功！'];
        }else{
            $result['code'] = 0;
            $result['msg'] = ['清除缓存失败！'];
        }
        return $result;
    }
    public function clearCache()
    {
        $c1 = ROOT_PATH . 'runtime/cache';
        $c2 = ROOT_PATH . 'runtime/temp';
        $res1 = dir_delete($c1);
        $res2 = dir_delete($c2);
        if ($res1&&$res2) {
            $result['info'] = '清除缓存成功!';
            $result['status'] = 1;
        } else {
            $result['info'] = '清除缓存失败!';
            $result['status'] = 0;
        }
        $result['url'] = url('Index/index');
        return $result;
    }
}