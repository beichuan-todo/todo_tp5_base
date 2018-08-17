<?php
/**
 * @project : tdbase
 * @auther  : 秋水
 * @date    : 2018/7/7
 * @desc    : 后台我的信息控制器
 */
namespace app\tdmin\controller;

class My extends Common {

	/**
	 * 我的资料修改
	 * @author 秋水
	 * @DateTime 2018-07-07T07:58:05+0800
	 * @return   [type]                   [description]
	 */
	public function myProfile()
	{
		if(request()->isPost()) {
    		$param = input('post.');

	        $uid = session('admin_uid');

	        $param['update_time'] = time();

	        $r = model('AuthAdmin')->where([['id','eq',$uid]])->update($param);

	        if($r) {
				session('admin_realname', $param['real_name']);
	        	return $this->success('修改成功','tdmin/index/content');
	        } else {
	        	return $this->error('修改失败');
	        }
    	} else {
	        $uid = session('admin_uid');

	        $data = model('AuthAdmin')->field('username,group_id,real_name,telephone')->where([['id','eq',$uid]])->find();
	        $group = model('AuthGroup')->where([['id','eq',$data['group_id']]])->find();
	        $data['group_name'] = $group?$group['title']:'-';

	        if(!$data) {
	            return $this->error('用户信息错误');
	        }

	        $this->assign('data',$data);
	        return $this->fetch();
	    }
	}

	public function resetPassword()
	{
		if(request()->isPost()) {
			$param = input('post.');

			$uid = session('admin_uid');

			$model = model('AuthAdmin');
			$data = $model->where([['id','eq',$uid]])->find();
			if(!$data) {
				return $this->error('用户信息错误');
			}
			if(md5(md5($param['opassword'])) !== $data['password']) {
				return $this->error('原始密码不正确');
			}

			if($param['npassword'] !== $param['rpassword']) {
				return $this->error('两次输入密码不一致');
			}
			$password = md5(md5($param['npassword']));
			$r = $model->where([['id','eq',$uid]])->update(array('password'=>$password,'update_time'=>time()));

			if($r) {
				$this->add_action_log(1, '重置密码成功');
				return $this->success('修改成功','tdmin/index/content');
			} else {
				return $this->error('修改失败');
			}
		} else {
			return $this->fetch();
		}
	}
}