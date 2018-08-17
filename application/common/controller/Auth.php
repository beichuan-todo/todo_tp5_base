<?php
/* @project : tdshop
 * @auther  : 秋水
 * @date    : 2018/7/5
 * @desc    : 权限管理服务层模型
 */

namespace app\common\controller;

use think\Controller;

class Auth extends Controller {
    //默认配置
    protected $_config = array(
        'auth_on'           => true,                      // 认证开关
        'auth_type'         => 1,                         // 认证方式，1为实时认证；2为登录认证。
        'auth_group'        => 'td_auth_group',        // 用户组数据表名
        'auth_group_access' => 'td_auth_group_access', // 用户-用户组关系表
        'auth_rule'         => 'td_auth_rule',         // 权限规则表
        'auth_user'         => 'td_auth_admin'             // 用户信息表
    );

	/**
	 * 获取权限信息
	 * @author 秋水
	 * @DateTime 2018-07-05T10:12:23+0800
	 * @param    int                   $group_id 用户组id
	 * @return   array
	 */
	public function getRoleInfo($group_id)
    {
        $result = model('authGroup')->where('id', $group_id)->find();
        if(empty($result['rules'])){
            $where = '';
        }else{
            $where = 'id in('.$result['rules'].')';
        }

        $res = model('authRule')->field('name')->where($where)->select();

        $result_name = array();
        foreach($res as $key=>$vo){
            if('#' != $vo['name']){
                $result_name[] = $vo['name'];
            }
        }

        $result['name'] = $result_name;
        return $result;
	}

	/**
	 * 查看用户是否有权限
	 * @author 秋水
	 * @DateTime 2018-07-05T10:29:49+0800
	 * @param    [type]                   $name     [description]
	 * @param    [type]                   $uid      [description]
	 * @param    integer                  $type     [description]
	 * @param    string                   $mode     [description]
	 * @param    string                   $relation [description]
	 * @return   [type]                             [description]
	 */
	public function check($name, $uid, $type=1, $mode='url', $relation='or')
    {
        // if (!$this->_config['auth_on'])
        //     return true;
		
        $authList = $this->getAuthList($uid,$type); //获取用户需要验证的所有有效规则列表
		
        if (is_string($name)) {
            $name = strtolower($name);
            if (strpos($name, ',') !== false) {
                $name = explode(',', $name);
            } else {
                $name = array($name);
            }
        }
        $list = array(); //保存验证通过的规则名
        if ($mode=='url') {
            $REQUEST = unserialize( strtolower(serialize($_REQUEST)) );
        }
        foreach ( $authList as $auth ) {
            $query = preg_replace('/^.+\?/U','',$auth);
            if ($mode=='url' && $query!=$auth ) {
                parse_str($query,$param); //解析规则中的param
                $intersect = array_intersect_assoc($REQUEST,$param);
                $auth = preg_replace('/\?.*$/U','',$auth);
                if ( in_array($auth,$name) && $intersect==$param ) {  //如果节点相符且url参数满足
                    $list[] = $auth ;
                }
            }else if (in_array($auth , $name)){
                $list[] = $auth ;
            }
        }
		//dump($list);exit;
        if ($relation == 'or' and !empty($list)) {
            return true;
        }
        $diff = array_diff($name, $list);
        if ($relation == 'and' and empty($diff)) {
            return true;
        }
        return false;
    }

    /**
     * 获取权限列表
     * @author 秋水
     * @DateTime 2018-07-05T10:31:02+0800
     * @param    [type]                   $uid  [description]
     * @param    [type]                   $type [description]
     * @return   [type]                         [description]
     */
    protected function getAuthList($uid,$type)
    {
        static $_authList = array(); //保存用户验证通过的权限列表
        $t = implode(',',(array)$type);
        if (isset($_authList[$uid.$t])) {
            return $_authList[$uid.$t];
        }

        if( $this->_config['auth_type']==2 && session('_auth_list_'.$uid.$t)){
            return \think\Session::get('_auth_list_'.$uid.$t);
        }

        //读取用户所属用户组
        $groups = $this->getGroups($uid);
        $ids = array();//保存用户所属用户组设置的所有权限规则id
        foreach ($groups as $g) {
            $ids = array_merge($ids, explode(',', trim($g['rules'], ',')));
        }
        $ids = array_unique($ids);
        if (empty($ids)) {
            $_authList[$uid.$t] = array();
            return array();
        }

        $map = array(
        	['id','in',$ids],
        	['type','eq',$type],
        	['status','eq',1]
        );
        //读取用户组所有权限规则
        $rules = model('AuthRule')->where($map)->field('condition,name')->select();

        //循环规则，判断结果。
        $authList = array();   //
        foreach ($rules as $rule) {
            if (!empty($rule['condition'])) { //根据condition进行验证
                $user = $this->getUserInfo($uid);//获取用户信息,一维数组

                $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $rule['condition']);
                //dump($command);//debug
                @(eval('$condition=(' . $command . ');'));
                if ($condition) {
                    $authList[] = strtolower($rule['name']);
                }
            } else {
                //只要存在就记录
                $authList[] = strtolower($rule['name']);
            }
        }
        $_authList[$uid.$t] = $authList;
        if($this->_config['auth_type']==2){
            //规则列表结果保存到session
            \think\Session::set('_auth_list_'.$uid.$t, $authList);
        }
        return array_unique($authList);
    }

    /**
     * 获取用户的用户组
     * @author 秋水
     * @DateTime 2018-07-05T10:43:38+0800
     * @param    [type]                   $uid [description]
     * @return   [type]                        [description]
     */
    public function getGroups($uid)
    {
        static $groups = array();
        if (isset($groups[$uid]))
            return $groups[$uid];
        $user_groups = model('AuthGroupAccess')
            ->alias('a')
            ->join("td_auth_group g", "g.id=a.group_id")
            ->where("a.uid='$uid' and g.status='1'")
            ->field('uid,group_id,title,rules')->select();
        $groups[$uid] = $user_groups ? $user_groups : array();
        return $groups[$uid];
    }

    /**
     * 获取菜单列表
     * @author 秋水
     * @DateTime 2018-07-06T11:30:34+0800
     * @return   [type]                   [description]
     */
    public function getMenuList() {
    	$node = model('AuthRule');
    	$list = $node->getMenu();

    	return json($list);
    }

    /**
     * 获取节点信息
     * @author 秋水
     * @DateTime 2018-07-06T11:28:44+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function getNodeInfo($id)
    {
        $result = model('AuthRule')->field('id,title,pid')->select();
        $str = "";
        $role = model('AuthGroup');
        $rule = $role->getRuleById($id);

        if(!empty($rule)){
            $rule = explode(',', $rule);
        }
        // foreach($result as $key=>$vo){
        //     $str .= '{ "id": "' . $vo['id'] . '", "pId":"' . $vo['pid'] . '", "name":"' . $vo['title'].'"';

        //     if(!empty($rule) && in_array($vo['id'], $rule)){
        //         $str .= ' ,"checked":1';
        //     }

        //     $str .= '},';
        // }

        // return "[" . substr($str, 0, -1) . "]";
        $result_arr = array();
        foreach($result as $key=>$vo){
            $str .= '{ "id": "' . $vo['id'] . '", "pId":"' . $vo['pid'] . '", "name":"' . $vo['title'].'"';
            $item = array(
                'id' => $vo['id'],
                'pid' => $vo['pid'],
                'name' => $vo['title']
            );

            if(!empty($rule) && in_array($vo['id'], $rule)){
                $item['checked'] = 1;
            } else {
                $item['checked'] = 0;
            }
            $result_arr[] = $item;
        }
        $result_arr = left_nav_rule($result_arr);

        return $result_arr;
    }
}