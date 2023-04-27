<?php
// +----------------------------------------------------------------------
// | 运营中心分布控制器
// +----------------------------------------------------------------------
// | Author: wang <admin>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use Think\Controller;

class BranchController extends Controller
{
    /**
     * 运营中心分布展示
     * @author wang
    */
	public function index()
	{	

		$userinfoObj 	= M('userinfo');

		$utel 	  = trim(I('get.utel'));
		$username = trim(I('get.username'));

		if($utel)
		{
			$map['utel'] = ''.$utel.'';
			$sea['utel'] = $utel;
		}

		if($username)
		{
			$map['username'] = array('like',''.$username.'%');
			$sea['username'] = $username;
		}

		$map['otype'] 	= 7;

        $count = $userinfoObj->where($map)->count();
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea;
        $page->setConfig('first','首页');
        $page->setConfig('prev','&#8249;');
        $page->setConfig('next','&#8250;');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

		$field 	= 'uid,username,utel,utime,last_login_ip';
		$data 	= $userinfoObj->field($field)->where($map)->limit($page->firstRow.','.$page->listRows)->select();

		$sea['count'] = $count;
		$this->assign('sea',$sea);
		$this->assign('page',$show);
		$this->assign('data',$data);
		$this->display();
	}

    /**
     * 数据导出
     * @author wang
    */
    public function daochu()
    {
		$userinfoObj 	= M('userinfo');

		$utel 	  = trim(I('get.utel'));
		$username = trim(I('get.username'));

		if($utel)
		{
			$map['utel'] = ''.$utel.'';
			$sea['utel'] = $utel;
		}

		if($username)
		{
			$map['username'] = array('like',''.$username.'%');
			$sea['username'] = $username;
		}

		$map['otype'] 	= 7;

		$field 	= 'uid,username,utel,utime,last_login_ip';
		$data 	= $userinfoObj->field($field)->where($map)->select();

		$list[0] = array('编号','用户名','手机号','注册时间','登陆IP');

		foreach ($data as $key => $value) {
			$list[$key+1][] = $value['uid'];
			$list[$key+1][] = $value['username'];
			$list[$key+1][] = $value['utel'];
			$list[$key+1][] = date('Y-m-d H:i:s',$value['utime']);
			$list[$key+1][] = $value['last_login_ip'];
		}

		$this->push($list,'运营中心分部');

    }


    public function show_operate()
    {
        $uid     = trim(I('get.uid'));

        $userObj         = M('userinfo');
        $accountObj      = M('accountinfo');
        $relationshipObj = M('userinfo_relationship');
        

        $relationshipData = $relationshipObj->distinct(true)->field('user_id')->where(array('parent_user_id' => $uid))->select();
        $relationshipArr = array();
        foreach ($relationshipData as $key => $value) {
            array_push($relationshipArr, $value['user_id']);
        }
        $user_id = implode(',', $relationshipArr);
        
        $map['uid']   = array('in',$user_id);
        $map['otype'] = 5;

        $count = $userObj->where($map)->count();
        $pagecount = 1;
        $page = new \Think\Page($count , $pagecount);
        $page->setConfig('first','首页');
        $page->setConfig('prev','&#8249;');
        $page->setConfig('next','&#8250;');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $user    = $userObj->field('uid,username,utel,lastlog,utime')->where($map)->limit($page->firstRow.','.$page->listRows)->select();

        $userArr = array();
        foreach ($user as $key => $value) {
            array_push($userArr, $value['uid']);
        }
        $uid = implode(',', $userArr);

        $account    = $accountObj->field('uid,balance')->where('uid in('.$uid.')')->select();

        $accountArr = array();
        foreach ($account as $key => $value) {
            $accountArr[$value['uid']] = $value;
        }

        foreach ($user as $key => $value) {
            $user[$key]['balance'] = $accountArr[$value['uid']]['balance'];
            $user[$key]['lastlog'] = empty($value['lastlog']) ? '暂未登录' : date('Y-m-d H:i:s',$value['lastlog']);
        }

        $this->assign('page',$show);
        $this->assign('user',$user);
        $this->display();
    }


    /**
     * 删除运营分部
     * @author wang
    */
    public function branch_del()
    {
    	$uid    = trim(I('post.uid'));
        $data   = array();

        $userinfoObj        = M('userinfo');
        $relationshipObj    = M('userinfo_relationship');

        if(empty($uid))
        {
            $data['status'] = 0;
            $data['msg']    = 'uid不能为空';
            $this->ajaxReturn($data,'JSON');
        }

        $info = $relationshipObj->field('user_id')->where(array('parent_user_id' => $uid))->select();
        if($info)
        {
            $data['status'] = 0;
            $data['msg']    = '该下级存在运营中心';
            $this->ajaxReturn($data,'JSON');
        }

        $status = $userinfoObj->where(array('uid' => $uid,'otype' => 7))->delete();
        $ship   = $relationshipObj->where(array('user_id' => $uid))->delete();
        if($status && $ship)
        {
            $data['status'] = 1;
            $data['msg']    = '删除成功';
            $this->ajaxReturn($data,'JSON'); 
        } else {
            $data['status'] = 0;
            $data['msg']    = '删除失败';
            $this->ajaxReturn($data,'JSON');
        }
    }






    /**
     * 添加运营分部
     * @author wang
    */
    public function add()
    {
    	if(IS_AJAX)
    	{
    		$userObj 	 = M('userinfo');

            $data        = array();

            $tel    	 = I('post.tel');
            $username 	 = I("post.username");
            $pwd    	 = I('post.pwd');
            $notpwd      = I('post.notpwd');

           if(empty($tel)){

                $data['status'] = 0;
                $data['msg']    = '手机号码不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(!preg_match('/^1\d{10}$/',$tel)){

                $data['status'] = 0;
                $data['msg']    = '手机号填写错误';
                $this->ajaxReturn($data,'JSON');
            }

            if($userObj->field('uid')->where('utel='.$tel.' and ustatus in(0,1) and otype=7')->find()) {

                $data['status'] = 0;
                $data['msg']    = '手机号已经被注册了!';
                $this->ajaxReturn($data,'JSON');
        	}

            if(trim($username) == ''){

                $data['status'] = 0;
                $data['msg']    = '用户名不能为空';
                $this->ajaxReturn($data,'JSON');
            }


            if(trim($pwd) == ''){

                $data['status'] = 0;
                $data['msg']    = '密码不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(!preg_match('/^[A-Za-z0-9]+$/', trim($pwd))){

                $data['status'] = 0;
                $data['msg']    = '密码不能包含中文或特殊字符';
                $this->ajaxReturn($data,'JSON');
            }

            if(trim($notpwd) != $pwd){

                $data['status'] = 0;
                $data['msg']    = '密码必须一致';
                $this->ajaxReturn($data,'JSON');
            }

                $map['username']   = $username;
                $map['upwd']  	   = md5(trim($pwd));
                $map['utel']  	   = $tel;
                $map['utime'] 	   = time();
                $map['otype']      = 7;
                $map['ustatus']    = 0;
                $map['reg_ip']     = get_client_ip();    //用户注册ip
                $result = $userObj->add($map);

                $where['user_id']        = $result;
                $where['parent_user_id'] = 0;
                $where['user_type']      = 7;
                $ship = M('UserinfoRelationship')->add($where);

                if($result && $ship){

                    $data['status'] = 1;
                    $data['msg']    = '注册成功!';
                    $this->ajaxReturn($data,'JSON');
                } else {
                    
                    $data['status'] = 0;
                    $data['msg']    = '注册失败!';
                    $this->ajaxReturn($data,'JSON');
                }
    	}

    	$this->display();
    }



    /**
     * 数据导出方法
     * @author wang
    */
    private function push($data,$name){

        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data,$name);
    }
}

?>