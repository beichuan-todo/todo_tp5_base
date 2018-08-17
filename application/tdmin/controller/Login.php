<?php
/**
 * @project : tdbase
 * @auther  : 秋水
 * @date    : 2018/7/4
 * @desc    : 登录控制器
 */

namespace app\tdmin\controller;
use think\Controller;
use think\Db;
use org\Verify;
use com\Geetestlib;
use app\common\controller\Auth;

class Login extends Controller {
    /**
     * 展示登录页面
     * @author 秋水
     * @DateTime 2018-07-05T10:58:02+0800
     * @return   [type]                   [description]
     */
    public function index()
    {
        return $this->fetch('login');
    }

    /**
     * 执行登录操作
     * @author 秋水
     * @DateTime 2018-07-05T10:58:12+0800
     * @return   [type]                   [description]
     */
    public function doLogin()
    {
        $username = input("param.username");
        $password = input("param.password");

        $hasUser = model('AuthAdmin')->where('username', $username)->find();
        if(empty($hasUser)){
            return $this->error('管理员不存在');
        }

        if(md5(md5($password)) != $hasUser['password']){
            return $this->error('用户名或密码错误');
        }

        //获取该管理员的角色信息
        $auth = new Auth();
        $info = $auth->getRoleInfo($hasUser['group_id']);
        session('admin_username', $username);
        session('admin_realname', $hasUser['real_name']);
        session('admin_uid', $hasUser['id']);
        session('rolename', $info['title']);  //角色名
        session('rule', $info['rules']);  //角色节点
        session('name', $info['name']);  //角色权限

        //记录操作日志
        model('ActionLog')->add_log($hasUser,2,'登录后台');
  
        //更新管理员状态
        $param = [
            'last_login_ip' => request()->ip(),
            'last_login_time' => time()
        ];

        $r = model('AuthAdmin')->where('id', $hasUser['id'])->update($param);
        return $this->success('登录成功', 'index/index');
    }

    /**
     * 验证码验证（尚未开发）
     * @author 秋水
     * @DateTime 2018-07-05T10:59:23+0800
     * @return   [type]                   [description]
     */
    public function checkVerify()
    {
        $verify = new Verify();
        $verify->imageH = 32;
        $verify->imageW = 100;
		$verify->codeSet = '0123456789';
        $verify->length = 4;
        $verify->useNoise = false;
        $verify->fontSize = 14;
        return $verify->entry();
    }


    /**
     * 退出登录
     * @author 秋水
     * @DateTime 2018-07-05T10:59:37+0800
     * @return   [type]                   [description]
     */
    public function loginOut()
    {
        session(null);
        return $this->success('退出登录', '/tdmin');
    }
}