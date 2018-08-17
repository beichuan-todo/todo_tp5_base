<?php
/**
 * @project : tdbase
 * @auther  : 秋水
 * @date    : 2018/7/4
 * @desc    : 后台公共制器
 */
namespace app\tdmin\controller;

use \think\Controller;
use app\common\controller\Auth as CommonAuth;

class Common extends Controller {

	/**
	 * 构造函数
	 * @author 秋水
	 * @DateTime 2018-07-04T14:26:42+0800
	 * @return   [type]                   [description]
	 */
	protected function initialize()
    {
		parent::initialize();

        if(!session('admin_uid')){
            $this->redirect(url('login/index'));
        }
        
        $auth = new CommonAuth();
    
        $module     = strtolower(request()->module());
        $controller = strtolower(request()->controller());
        $action     = strtolower(request()->action());
        $url        = $module."/".$controller."/".$action;

        //跳过检测以及主页权限
        if(session('admin_uid')!=1){

            if(!in_array($url, ['tdmin/index/index','tdmin/index/content','tdmin/index/indexpage'])){
                if(!$auth->check($url,session('admin_uid'))){
                    $this->error('抱歉，您没有操作权限');
                }
            }
        }

        $node = model('AuthRule');
        if(config('template')['theme_name'] == "new"){
            $menu_list=json_encode($node->getMenu(session('rule')));
        }else{
            $menu_list=$node->getMenu(session('rule'));
        }

        //设置用户基本字段
        $this->assign([
            'username' => session('admin_username'),
            'realname' => session('admin_realname'),
            'menu' => $menu_list,
            'rolename' => session('rolename')
        ]);
	}

    /**
     * 添加操作日志
     * @author 秋水
     * @DateTime 2018-07-16T17:35:59+0800
     * @param    int                   $type    1基本操作 2登录
     * @param    [type]                   $content [description]
     */
    protected function addActionLog($type, $content)
    {
        $uid = session('admin_uid');
        $user = model('AuthAdmin')->where([['id','eq',$uid]])->find();
        if(!$user) {
            return false;
        }

        $r = model('ActionLog')->add_log($user,$type,$content);
    }
}
