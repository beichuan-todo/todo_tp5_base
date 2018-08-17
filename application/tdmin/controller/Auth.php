<?php
/**
 * @project : tdbase
 * @auther  : 秋水
 * @date    : 2018/7/4
 * @desc    : 权限控制器
 */

namespace app\tdmin\controller;

use app\common\controller\Auth as CommonAuth;

class Auth extends Common {

	/**
	 * 菜单列表页
	 * @author 秋水
	 * @DateTime 2018-07-05T13:40:58+0800
	 * @return
	 */
	public function ruleList()
	{
        $model = model('AuthRule');

        $list = $model->order('id asc')->select();

        $arr = left_nav_rule($list);
        $this->assign('list',$arr);

		return $this->fetch();
	}

	/**
	 * 添加菜单
	 * @author 秋水
	 * @DateTime 2018-07-05T15:14:37+0800
	 */
	public function addRule()
	{
        if(request()->isPost()){
        	$param = input('post.');
        	if(!isset($param['status'])){
        		$param['status'] = 0;
        	} else {
        		$param['status'] = 1;
        	}
        	
        	$param['update_time'] = $param['create_time'] = time();
        	$r = model('AuthRule')->insert($param);
        	if($r) {
        		$this->addActionLog(1, '添加菜单【'.$param['title'].'】成功');
        		return $this->success('添加成功', url('auth/rule_list'));
        	} else {
        		$this->addActionLog(1, '添加菜单【'.$param['title'].'】失败');
        		return $this->error('添加失败');
        	}
        } else {
	        $model = model('AuthRule');

	        $list = $model->where([['status','eq',1]])->order('id asc')->select();

	        $arr = left_nav_rule($list);
	        $this->assign('list',$arr);
        	return $this->fetch();
        }
	}

	/**
	 * 修改菜单
	 * @author 秋水
	 * @DateTime 2018-07-05T22:17:49+0800
	 * @return   [type]                   [description]
	 */
	public function editRule()
	{
		if(request()->isPost()){
        	$param = input('post.');
        	if(!isset($param['status'])){
        		$param['status'] = 0;
        	} else {
        		$param['status'] = 1;
        	}

        	$param['update_time'] = time();
        	$r = model('AuthRule')->update($param);
			if($r) {
				$this->addActionLog(1, '修改菜单【'.$param['title'].'】成功');
        		return $this->success('修改成功', url('auth/ruleList'));
        	} else {
        		$this->addActionLog(1, '修改菜单【'.$param['title'].'】失败');
        		return $this->error('修改失败');
        	}
        } else {
	        $model = model('AuthRule');

	        $list = $model->where([['status','eq',1]])->order('id asc')->select();

	        $arr = left_nav_rule($list);

	        $rule_id = input('param.id', 0);
	        $data = $model->where([['id','eq',$rule_id]])->find();

	        $this->assign('data', $data);
	        $this->assign('list', $arr);
        	return $this->fetch();
        }
	}

	/**
	 * 删除菜单
	 * @author 秋水
	 * @DateTime 2018-07-05T22:35:12+0800
	 * @return   [type]                   [description]
	 */
	public function delRule()
	{
		$id = input('param.id', 0);

		$r = model('AuthRule')->where([['id','eq',$id]])->delete();

		if($r) {
			$this->addActionLog(1, '删除菜单【id='.$id.'】成功');
    		return $this->success('删除成功', url('auth/rule_list'));
    	} else {
			$this->addActionLog(1, '删除菜单【id='.$id.'】失败');
    		return $this->error('删除失败');
    	}
	}

	/**
	 * 修改菜单状态
	 * @author 秋水
	 * @DateTime 2018-07-06T09:44:47+0800
	 * @return   [type]                   [description]
	 */
	public function changeRuleStatus()
	{
		$id = input('param.id', 0);
		$model = model('AuthRule');

		$data = $model->where([['id','eq',$id]])->find();
		if(!$data) {
			return json(array('code'=>-1,'msg'=>'参数错误'));
		}

		if($data['status'] == 1) {
			$update = array('status'=>0);
		} else {
			$update = array('status'=>1);
		}

		$r = $model->where([['id','eq',$id]])->update($update);
		if($r) {
			$this->addActionLog(1, '修改菜单【id='.$id.'】状态成功');
			return json(array('code'=>1,'msg'=>'修改成功','data'=>$update['status']));
		} else {
			$this->addActionLog(1, '修改菜单【id='.$id.'】状态失败');
			return json(array('code'=>-1,'msg'=>'修改失败'));
		}
	}

	/**
	 * 会员组列表
	 * @author 秋水
	 * @DateTime 2018-07-06T09:45:01+0800
	 * @return   [type]                   [description]
	 */
	public function groupList()
	{
        $model = model('AuthGroup');

        $page = input('param.page', 1);
        $limit = input('param.limit', 10);

        $list = $model->where([['id','neq',1]])->order('id asc')->page($page,$limit)->select();
        $count = $model->count();

        $this->assign('count',$count);
        $this->assign('limit',$limit);
        $this->assign('page',$page);
        $this->assign('list',$list);

		return $this->fetch();
	}

	/**
	 * 添加角色
	 * @author 秋水
	 * @DateTime 2018-07-06T11:03:44+0800
	 */
	public function addGroup()
	{
        if(request()->isPost()){
        	$param = input('post.');
        	if(!isset($param['status'])){
        		$param['status'] = 0;
        	} else {
        		$param['status'] = 1;
        	}
        	
        	$param['update_time'] = $param['create_time'] = time();
        	$r = model('AuthGroup')->insert($param);
        	if($r) {
        		return $this->success('添加成功', url('auth/groupList'));
        	} else {
        		return $this->error('添加失败');
        	}
        } else {
        	return $this->fetch();
        }
    }

    /**
     * 修改角色
     * @author 秋水
     * @DateTime 2018-07-06T11:09:48+0800
     * @return   [type]                   [description]
     */
    public function editGroup()
    {
        if(request()->isPost()){
        	$param = input('post.');
        	if(!isset($param['status'])){
        		$param['status'] = 0;
        	} else {
        		$param['status'] = 1;
        	}
        	
        	$param['update_time'] = time();
        	$r = model('AuthGroup')->update($param);
        	if($r) {
        		return $this->success('修改成功', url('auth/groupList'));
        	} else {
        		return $this->error('修改失败');
        	}
        } else {
        	$id = input('param.id', 0);
        	$data = model('AuthGroup')->where([['id','eq',$id]])->find();

        	$this->assign('data',$data);
        	return $this->fetch();
        }
    }

	/**
	 * 修改菜单状态
	 * @author 秋水
	 * @DateTime 2018-07-06T09:44:47+0800
	 * @return   [type]                   [description]
	 */
	public function changeGroupStatus()
	{
		$id = input('param.id', 0);
		$model = model('AuthGroup');

		$data = $model->where([['id','eq',$id]])->find();
		if(!$data) {
			return json(array('code'=>-1,'msg'=>'参数错误'));
		}

		if($data['status'] == 1) {
			$update = array('status'=>0);
		} else {
			$update = array('status'=>1);
		}

		$r = $model->where([['id','eq',$id]])->update($update);
		if($r) {
			return json(array('code'=>1,'msg'=>'修改成功','data'=>$update['status']));
		} else {
			return json(array('code'=>-1,'msg'=>'修改失败'));
		}
	}

	/**
	 * 删除角色
	 * @author 秋水
	 * @DateTime 2018-07-06T11:25:29+0800
	 * @return   [type]                   [description]
	 */
	public function delGroup()
	{
		$id = input('param.id', 0);

		$r = model('AuthGroup')->where([['id','eq',$id]])->delete();

		if($r) {
    		return $this->success('删除成功', url('auth/groupList'));
    	} else {
    		return $this->error('删除失败');
    	}
	}

	/**
	 * 分配权限
	 * @author 秋水
	 * @DateTime 2018-07-06T16:51:59+0800
	 * @return   [type]                   [description]
	 */
	public function permissionList()
	{
		$id = input('param.id', 0);

		$common_auth = new CommonAuth();

		$list = $common_auth->getNodeInfo($id);
		$data = model('AuthGroup')->where([['id','eq',$id]])->find();

		$this->assign('list', $list);
		$this->assign('data', $data);
		return $this->fetch();
	}

	/**
	 * 修改角色权限
	 * @author 秋水
	 * @DateTime 2018-07-06T16:52:07+0800
	 * @return   [type]                   [description]
	 */
	public function changeGroupRule()
	{
		$rule_str = input('param.rule_str', '');
		$group_id = input('param.group_id', 0);

		$r = model('AuthGroup')->where([['id','eq',$group_id]])->update(array('rules'=>$rule_str));
		if($r) {
			return json(array('code'=>1,'msg'=>'修改成功'));
		} else {
			return json(array('code'=>0,'msg'=>'修改失败'));
		}
	}

	/**
	 * 用户列表
	 * @author 秋水
	 * @DateTime 2018-07-06T16:55:06+0800
	 * @return   [type]                   [description]
	 */
	public function userList()
	{
		$page = input('param.page', 1);
		$limit = input('param.limit', 10);

		$model = model('AuthAdmin');
		$list = $model
		->field('a.*,b.title as group_name')
		->alias('a')
		->join([['td_auth_group b','a.group_id=b.id']])
		->order('a.id desc')
		->page($page,$limit)
		->select();
		$count = $model->count();

		$this->assign('page', $page);
		$this->assign('limit', $limit);
		$this->assign('count', $count);
		$this->assign('list', $list);
		return $this->fetch();
	}

	/**
	 * 添加用户
	 * @author 秋水
	 * @DateTime 2018-07-06T17:51:38+0800
	 */
	public function addUser()
	{
		if(request()->isPost()){
			$param = input('post.');

			$model = model('AuthAdmin');
			//查看是否存在相同账号的用户
			$data = $model->where([['username','eq',$param['username']]])->find();
			if($data) {
				return $this->error('账号存在');
			}
			$param['password'] = md5(md5($param['password']));
			$param['create_time'] = $param['update_time'] = time();
			$id = $model->insertGetId($param);
			$r = model('AuthGroupAccess')->insert(array('uid'=>$id,'group_id'=>$param['group_id']));
			if($r) {
				$this->addActionLog(1, '添加用户【'.$param['username'].'】成功');
				return $this->success('添加成功', 'tdmin/auth/user_list');
			} else {
				$this->addActionLog(1, '添加用户【'.$param['username'].'】失败');
				return $this->error('添加失败');
			}
		} else {
			$group_list = model('AuthGroup')->order('id asc')->select();

			$this->assign('group_list', $group_list);

			return $this->fetch();
		}
	}

	/**
	 * 修改用户信息
	 * @author 秋水
	 * @DateTime 2018-07-06T17:55:32+0800
	 * @return   [type]                   [description]
	 */
	public function editUser()
	{
		if(request()->isPost()){
			$param = input('post.');

			if($param['password'] != '') {
				$param['password'] = md5(md5($param['password']));
			} else {
				unset($param['password']);
			}
			$param['update_time'] = time();
			$r = model('AuthAdmin')->update($param);
			$r = model('AuthGroupAccess')->where([['uid','eq',$param['id']]])->update(array('group_id'=>$param['group_id']));
			if($r) {
				return $this->success('修改成功', 'tdmin/auth/user_list');
			} else {
				return $this->error('修改失败');
			}
		} else {
			$id = input('param.id', 0);

			$data = model('AuthAdmin')->where([['id','eq',$id]])->find();
			$group_list = model('AuthGroup')->order('id asc')->select();

			$this->assign('data', $data);
			$this->assign('group_list', $group_list);

			return $this->fetch();
		}
	}

	/**
	 * 删除用户
	 * @author 秋水
	 * @DateTime 2018-07-06T20:39:50+0800
	 * @return   [type]                   [description]
	 */
	public function delUser()
	{
		$id = input('param.id', 0);

		$r = model('AuthAdmin')->where([['id','eq',$id]])->delete();

		if($r) {
			$this->addActionLog(1, '删除用户【id='.$id.'】成功');
    		return $this->success('删除成功', url('auth/user_list'));
    	} else {
    		return $this->error('删除失败');
    	}
	}
}