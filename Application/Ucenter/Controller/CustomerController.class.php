<?php
// 本类由系统自动生成，仅供测试用途
namespace Ucenter\Controller;
use Ucenter\Controller\CommonController;
class CustomerController extends CommonController{
     //会员列表
	public function customerlist()
    {
		$userinfo = M("userinfo");
		$tq=C('DB_PREFIX');
		// $otype = M("userinfo")->where("uid=".$_SESSION['cuid'])->getField("otype");
		$otype = M("userinfo")->where("uid=".$_SESSION['cuid'])->find();
	//	 var_dump($otype);die;
		if($otype['otype'] == 2)
		{
			$t = 4;
		}else if($otype['otype'] == 4)
		{
			$t = 1;
		}else if($otype['otype'] == 1)
		{
			$t = 0;
		}
		//过滤搜索
		$huilist = $userinfo->where("otype = ".$t." and oid = ".$_SESSION['cuid'])->select();
		// echo $userinfo->getLastsql();exit;
		$this->assign("huilist",$huilist);
		$where = "";
		//获取用户名，生产模糊条件
		$username = $_GET['username'];
		//获取订单时间
		$starttime = date('Y-m-d',strtotime($_GET["starttime"]));
		$endtime = date('Y-m-d',strtotime($_GET["endtime"]));
		//获取订单类型
		$type = $_GET['type'];
		//获取订单盈亏
		$ploss = $_GET['ploss'];
		//获取订单状态
		$ostaus = $_GET['ostaus'];
		$oid = $_GET['oid'];
		$phone = $_GET['phone'];
		if($oid)
		{
			$oids = getDownuids($oid);
			$where[$tq.'userinfo.uid'] = array("in",implode(',',$oids));
			$sea['oid'] = $oid;
		}else{
			$oids = getDownuids($_SESSION['cuid']);
			$where[$tq.'userinfo.uid'] = array("in",implode(',',$oids));
			$sea['oid'] = $oid;
		}
		// var_dump($sea);
		if($username){
			$where[$tq.'userinfo.username'] = array('like','%'.$_GET["username"].'%');
			$sea['username'] = $_GET["username"];
		}
		if($phone){
			$where[$tq.'userinfo.utel'] = array('like','%'.$_GET["phone"].'%');
			$sea['phone'] = $_GET["phone"];
		}
		if($_GET["starttime"] && $_GET["endtime"]){
			$starttime = strtotime($starttime." 00:00:00");
			$endtime = strtotime($endtime." 23:59:59");
			$where[$tq.'userinfo.utime'] = array('between',array($starttime,$endtime));
			$sea['starttime'] = $_GET["starttime"];
			$sea['endtime'] = $_GET["endtime"];
		}
		
            $count =$userinfo->join($tq.'managerinfo on '.$tq.'userinfo.uid='.$tq.'managerinfo.uid')
	    	->where($where)->count();
	    	$pagecount = 10;
	        $page = new \Think\Page($count , $pagecount);
	        $page->parameter = $row; //此处的row是数组，为了传递查询条件
	        $page->setConfig('first','首页');
	        $page->setConfig('prev','上一页');
	        $page->setConfig('next','下一页');
	        $page->setConfig('last','尾页');
	        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
	        $show = $page->show();
	    	$list=$userinfo->join($tq.'managerinfo on '.$tq.'userinfo.uid='.$tq.'managerinfo.uid')
	    	->where($where)->limit($page->firstRow.','.$page->listRows)->select();
			$nummoney=$userinfo->join($tq.'managerinfo on '.$tq.'userinfo.uid='.$tq.'managerinfo.uid')->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid')->where($where)->sum($tq.'accountinfo.balance');
			// var_dump($list);die;
	    	foreach ($list as $k => $v) {
	    		$sum[]=M('order')->where('uid='.$v['uid'])->sum('onumber');
	    		$accoun[]=M('accountinfo')->field('balance')->where('uid='.$v['uid'])->find();
				$list[$k]['upusername'] = M("userinfo")->where("uid=".$v['oid'])->getField("username");
	    	}
	    	foreach ($list as $key => $value) {
	    		foreach ($sum as $k => $v) {
	    			if($key==$k){
	    				$list[$key]['sum'] = $sum[$k];	
	    			}
	    		}
	    		foreach ($accoun as $ky => $va) {
	    			if($key==$ky){
	    				$list[$key]['balance'] = $accoun[$ky]['balance'];
	    			}
	    		}
	    	}

        // var_dump($list);die;
		$this->assign('nummoney',$nummoney);
	    $this->assign('ulist',$list);
	    $this->assign('sea',$sea);
        $this->assign('page',$show);
		$this->display();
    }
	public function customeradd()
    {
    	header("Content-type: text/html; charset=utf-8");
        //获取登录代理商的id
        $myuid=$_SESSION['cuid'];
    	if (IS_POST) {
	    	$uid=I('post.uid');
	    	$mid=I('post.mid');
	    	$userinfo=D('userinfo');
	    	$managerinfo=M('managerinfo');
            // 自动验证 创建数据集
            if ($userinfo->create()) {
               //验证身份证正确性
               $broker= A('Ucenter/Account');
               $broker->checkIdCard(I('post.brokerid'));
               if($uid!=''&&$mid!=''){
                    //修改
                    $data['uid']=$uid;
                    $data['utel']=I('post.utel');
                    $data['address']=I('post.address');
                    $userinfo->save($data);
                    $mana['mid']=$mid;
                    $mana['brokerid']=I('post.brokerid');
                    $managerinfo->save($mana); 
                    redirect(U('Customer/customerlist'),1, '修改成功...');
                }else{
                    //添加
                    $user=$userinfo->field('username')->where('uid='.$myuid)->find();
                    $data['managername']=$user['username'];
                    $data['username']=I('post.username');
                    $data['utel']=I('post.utel');
                    $data['utime']=date(time());
                    $data['upwd']=md5(I('post.username'));
                    $data['address']=I('post.address');
                    $data['otype']=0;
                    $data['oid']=$myuid;
                    if ($uid = $userinfo->add($data)) {
                          $brok['uid']=$uid;
                          $brok['brokerid']=I('post.brokerid');
                          $managerinfo->add($brok);
                          $accid['uid']=$uid;
                          M('accountinfo')->add($accid);
                    }
                    redirect(U('Customer/customerlist'),1, '新增用户成功...');
                }
            }else{
                $this->error($userinfo->getError());
            }
    	}
    	//判断跳转到修改页面或者新增页面
		$uid=I('get.uid');
    	if($uid){
    		$user=M('userinfo')->where('uid='.$uid)->find();
    		$usermsg=M('managerinfo')->where('uid='.$uid)->find();
    		$user['brokerid']=$usermsg['brokerid'];
    		$user['mid']=$usermsg['mid'];
    		$this->assign('user',$user);
    	}	
    	$this->display();
    }

	public function customerdetail()
    {
    	$uid=I('get.uid');
    	//普通会员信息
    	$user=M('userinfo')->where('uid='.$uid)->find();
    	$usermsg=M('managerinfo')->where('uid='.$uid)->find();
    	$account=M('accountinfo')->where('uid='.$uid)->find();
    	//普通会员上线信息
    	$ouid=M('userinfo')->where('uid='.$user['oid'])->find();

    	$user['brokerid']=$usermsg['brokerid'];
    	$user['mname']=$usermsg['mname'];
    	$user['balance']=$account['balance'];
    	$user['oname']=$ouid['username'];

    	$this->assign('user',$user);
		$this->display();
    }
	public function verifylist()
	{
		$uid = $_SESSION['cuid'];
		// var_dump($uid);die;
		$user = M('userinfo')->where('oid='.$uid)->order("vertus desc")->select();
		// var_dump($user);die;
		$this->assign("ulist",$user);
		$this->display();
	}
	public function verifyeditok()
	{
		$uid = $_POST['uid'];
		$map['vertus']=1;
		$map['agenttype']=2;
		$map['otype']=1;
		$res = M('userinfo')->where('uid='.$uid)->save($map);
		if($res)
		{
			echo 1;die;
		}else{
			echo 0;die;
		}
	}
	public function verifyeditno()
	{
		$uid = $_REQUEST['uid'];
		// var_dump($uid);die;
		$userinfo=M('userinfo')->where('uid='.$uid)->find();
		// var_dump($userinfo);die;
		$map['oid']=$userinfo['rid'];
		$map['vertus']=1;
		$map['agenttype']=0;
		$map['otype']=0;
		$res = M('userinfo')->where('uid='.$uid)->save($map);
		if($res)
		{
			echo 1;die;
		}else{
			echo 0;die;
		}
	}
}