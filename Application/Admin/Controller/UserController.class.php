<?php

namespace Admin\Controller;
use Org\Util\Log;
class UserController extends BaseController {
	
	
	//管理员登陆
	public function signin()
	{
	 	if(IS_POST){
	 		header("Content-type: text/html; charset=utf-8");
			
			$user = D("userinfo");
				
			//查询条件
			$where = array();
			$where['username'] = trim(I('post.username'));
			$where['ustatus']  = 0;
			$where['otype']    = array('in','3,5,6,7');
			//$where['ustatus'] = "1";
			$result = $user->where($where)->field("uid,upwd,username,nickname,utel,utime,otype,ustatus,vertus")->find();
			//验证用户

			if(empty($result)){
				$this->error('登录失败,用户名不存在!');
			}else{	
				$map['lastlog'] = time();
                $map['last_login_ip']   = get_client_ip();
				M('userinfo')->where('username ="'.I('post.username').'"')->save($map);


				if($result['upwd'] == md5(I('post.password'))){
					if($result['vertus'] != 1)
					{
						$this->error('对不起,你还没通过平台审核，不能登录!');
					}
					//session
					$logData = array(
						'cTime'=>$map['lastlog'],
						'uname'=>$result['username'],
						'uid'=>$result['uid'],
						'ip'=>$map['last_login_ip'],
						'status'=>1
					);
					if($result['otype']==2&&$result['ustatus']==0)
					{
					    session('cuid',$result['uid']);
					    session('userotype',$result['otype']);
						session('newusername',$result['username']);
						$loginSign = M("login_log")->add($logData);
						session('login_sign', $loginSign);
						$this->success('登录成功,正跳转至系统会员单位首页...', U('Ucenter/Ordinary/agentlist'));
					}
					
					elseif ($result['otype']==3&&$result['ustatus']==0)
				
					{
						session('userid',$result['uid']);
						session('cuid',$result['uid']);
						session('userotype',$result['otype']);
						session('username',$result['username']);
						$loginSign = M("login_log")->add($logData);
						session('login_sign', $loginSign);
						$this->success('登录成功,正跳转至系统管理员首页...', U('admin/Index/index'));
					}elseif ($result['otype']==4&&$result['ustatus']==0)
				
					{
						session('cuid',$result['uid']);
						session('newusername',$result['username']);  
						session('userotype',$result['otype']);
						$this->success('登录成功,正跳转至系统普通会员首页...', U('Ucenter/Account/agentlist'));
					}
					elseif ($result['otype']==1&&$result['ustatus']==0)
				
					{
						session('cuid',$result['uid']);
						session('newusername',$result['username']);  
						session('userotype',$result['otype']);
						$loginSign = M("login_log")->add($logData);
						session('login_sign', $loginSign);
						$this->success('登录成功,正跳转至系统经纪人首页...', U('Ucenter/Trade/tradelist'));
					}
                    elseif ($result['otype']==5&&$result['ustatus']==0)
                    {
                         session('cuid',$result['uid']);
                        session('newusername',$result['username']);
                        session('userotype',$result['otype']);
                        session('new_nickname',$result['username']);
						$loginSign = M("login_log")->add($logData);
						session('login_sign', $loginSign);
                        $this->success('登录成功,正跳转至运营中心管理后台首页...', U('Ucenter/indexf/index'));
                    }
                    elseif ($result['otype']==6&&$result['ustatus']==0)
                    {
                        session('cuid',$result['uid']);
                        session('newusername',$result['username']);
                        session('new_nickname',$result['username']);
                        session('userotype',$result['otype']);
						M("login_log")->add($logData);
                        $this->success('登录成功,正跳转至机构管理后台首页...', U('Ucenter/indexs/index'));
                    }
                    elseif ($result['otype']==7&&$result['ustatus']==0)
                    {
                        session('cuid',$result['uid']);
                        session('newusername',$result['username']);
                        session('new_nickname',$result['username']);
                        session('userotype',$result['otype']);
						M("login_log")->add($logData);
                        $this->success('登录成功,正跳转至特别运营后台首页...', U('Branch/index/index'));
                    }
					else{
						$logData['status'] = 0;
						M("login_log")->add($logData);
						$this->error('登录失败,用户名不存在!');
					}
					
				}
                else
                {
                    $this->error('登录失败,密码错误！');
                }
				
			}
	 	}else{
	 		$this->display();
		}
	}
	
	//管理员信息
	public function personalinfo(){
		$this->checklogin();
		
		$uid = $_SESSION['uid'];
		$user = D('userinfo');
		$person = $user->where('uid='.$uid)->find();
		
		$this->assign('person',$person);
		$this->display();
	}
	
	/**
    * 用户注销
    */
    public function signinout()
    {
        // 清楚所有session
        header("Content-type: text/html; charset=utf-8");
        session(null);
        redirect(U('User/signin'), 2, '正在退出登录...');
    }
	
	
	//会员列表
    public function ulist()
    {
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();


		if (I('get.phone')) {
			$map['a.utel'] = array('like', '%' . trim(I('get.phone')) . '%');
			$sea['phone'] = I('get.phone');
		}

		if (I('get.username')) {
			$map['_complex']['a.username'] = array('like', '%' . trim(I('get.username')) . '%');
			$map['_complex']['c.busername'] = array('like', '%' . trim(I('get.username')) . '%');
			$map['_complex']['a.utel'] = array('like', '%' . trim(I('get.username')) . '%');
			$map['_complex']['_logic'] = 'OR';
			$sea['username'] = trim(I('get.username'));
		}
		$oid = I('get.oid');
		$jjr = I('get.jjr');//经纪人id
		if($jjr){
			$userarr=array();
			$ship=M('userinfoRelationship')->where(array('parent_user_id'=>$jjr))->select();
			foreach($ship as $key=>$value){
				array_push($userarr,$value['user_id']);
				$id=implode(',',array_unique($userarr));
			}
			$jjr_userinfo=M('userinfo')->field('username')->where(array('uid'=>$jjr))->find();
			$map['a.uid']=array('IN',$id);
			$this->assign('jjr_info',$jjr_userinfo['username']);
			$this->assign('user_id', $oid);
			$sea['jjr'] = I('get.jjr');
		}else if ($oid) {
			$userarr = array();
			$userarr1 = array();
			$ship = M("UserinfoRelationship")->where(array('parent_user_id' => $oid))->select();
			foreach ($ship as $key => $value) {
				array_push($userarr, $value['user_id']);
			}
			$user_id = implode(',', array_unique($userarr));
			$users = M("UserinfoRelationship")->where('parent_user_id  in(' . $user_id . ')')->select();
			foreach ($users as $key => $val) {
				array_push($userarr1, $val['user_id']);
			}
			$id = implode(',', array_unique($userarr1));

			$map['a.uid'] = array('in', $id);
			$this->assign('user_id', $oid);
			$sea['oid'] = I('get.oid');
		}

        $sort = 'a.utime desc';
        //余额排序
        $cat   = trim(I('get.cat'));
        $sorts = trim(I('get.sort')); 
        if($cat)
        {   
             $sort = $cat.' '.$sorts.'';
             $sea['cat'] = $cat;
             $sea['sort'] = $sorts;
        }

		$this->assign('sea', $sea);

		$map['a.otype'] = 4;
		$map['a.ustatus'] = array('in', '0,1');

		$count = M('userinfo a')->where($map)->count();
		$pagecount = 10;
		$page = new \Think\Page($count, $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first', '首页');
		$page->setConfig('prev', '&#8249;');
		$page->setConfig('next', '&#8250;');
		$page->setConfig('last', '尾页');
		$page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
		$show = $page->show();

		$field = "a.*,b.balance,b.gold,c.busername,b.income_total,b.recharge_total,b.loss_total,b.money_total,d.money";
		$info = M("userinfo a")->field($field)->
		join('left join wp_bankinfo as c on a.uid = c.uid')->
		join('wp_accountinfo as b on a.uid = b.uid')->
		join('left join wp_extension as d on a.uid = d.user_id')->
		where($map)->
		order($sort)->
		limit($page->firstRow . ',' . $page->listRows)->select();
		//订单数量,佣金
		$fee_receive_obj = M('fee_receive');
		$journal_obj = M('journal');



        $userIdArr  = array();
		foreach ($info as $k => $v) {

            array_push($userIdArr, $v['uid']);

			$ocount = M('order')->where('uid=' . $v['uid'])->count();
			$info[$k]['ocount'] = $ocount;
			//推广佣金
			$info[$k]['fee_receive'] += $v['money'];
			//订单统计，持仓平仓条数
			$info[$k]['total_jc'] = $journal_obj->where(array('uid'=>$v['uid'],'jtype'=>'建仓','type'=>1))->count();
			$info[$k]['total_pc'] = $journal_obj->where(array('uid'=>$v['uid'],'jtype'=>'平仓','type'=>1))->count();

            $info[$k]['total_fee'] = $journal_obj->where(array('uid'=>$v['uid'],'jtype'=>'建仓','type'=>1))->sum('jfee');

            $info[$k]['total_ploss'] = $journal_obj->where(array('uid'=>$v['uid'],'jtype'=>'平仓','type'=>1))->sum('jploss');
		}

        //add by Frank@2017-03-13 11:51:46
        // $userIdStr  = implode(',', array_unique($userIdArr));
        // $balanceRs  = M()->query('SELECT uid, SUM(bpprice) as total_sum FROM wp_balance WHERE uid in ('.$userIdStr.') and isverified=1 AND `status`=1 group by uid');
        // foreach($balanceRs as $k => $v)
        // {
        //     $balanceRs1[$v['uid']]  = $v;
        // }

        // foreach($info as $k => $v)
        // {
        //     $info[$k]['leiji_chongzhi'] = empty($balanceRs1[$v['uid']]['total_sum']) ? round(0, 2) : $balanceRs1[$v['uid']]['total_sum'];
        // }




		$summoney = M("userinfo a")->
		join('wp_accountinfo as b on a.uid = b.uid')->
		join('left join wp_bankinfo as c on a.uid = c.uid')->
		join('left join wp_extension as d on a.uid = d.user_id')->
		where($map)->
		sum('b.balance');

		//佣金计算
		$infos = M("userinfo a")->field($field)->
		join('left join wp_bankinfo as c on a.uid = c.uid')->
		join('wp_accountinfo as b on a.uid = b.uid')->
		join('left join wp_extension as d on a.uid = d.user_id')->
		where($map)
		->select();
		$infosArr = array();
		foreach ($infos as $key => $value) {
			array_push($infosArr,$value['uid']);
		}
		$infosId = implode(',',array_unique($infosArr));
        
		$fee_receive = M('extension')->where('user_id in ('.$infosId.')')->sum('money');
		$this->assign('fee_receive',$fee_receive);

		$this->assign('ulist', $info);
		$this->assign('summoney', $summoney);
		$this->assign('page', $show);
		$this->assign('info', M('userinfo')->where('otype=5')->select());
		$this->display();

	}

	public function ajax_get_brokers(){
        if(IS_AJAX){
            $userobj         = M('userinfo a');
            $relationshipobj = M('userinfo_relationship');
            
            $parent_id = I('get.parent_id',0,'intval');
            
            if($parent_id < 1) $this->AjaxReturn(array('msg'=>'父级id不存在','status'=>0));
            $ids_arr = $relationshipobj->field('user_id')->where(array('parent_user_id'=>$parent_id))->select();
            $ids='';
            
            if($ids_arr){
                foreach($ids_arr as $v){
                    if(!empty($ids)){
                        $ids .=','.$v['user_id'];
                    }else{
                        $ids = $v['user_id'];
                    }
                }
            }
            $where['a.uid']=array('IN',$ids);
            $res = $userobj->field('a.uid,a.username,b.busername')->join('left join wp_bankinfo as b on a.uid = b.uid')->where($where)->order('uid DESC')->select();
            foreach ($res as $key => $value) {
                $res[$key]['username'] = !empty($value['busername']) ? $value['busername'] : $value['username'];
            }

            $data=array('msg'=>'成功','status'=>1,'data'=>$res);
            $this->AjaxReturn($data);
        }
		$this->error('您访问的页面不存在','index/index');
		
		
	}
	//会员列表
    public function daochu()
    {
    	$this->checklogin();
    	$tq=C('DB_PREFIX');
    	$user = M('userinfo a');
    	$order = M('order');
    	$feeReceive = M('FeeReceive');


    	if (I('get.phone')) {
			$map['a.utel'] = array('like', '%' . trim(I('get.phone')) . '%');
			$sea['phone'] = I('get.phone');
		}

		if (I('get.username')) {
			$map['_complex']['a.username'] = array('like', '%' . trim(I('get.username')) . '%');
			$map['_complex']['c.busername'] = array('like', '%' . trim(I('get.username')) . '%');
			$map['_complex']['a.utel'] = array('like', '%' . trim(I('get.username')) . '%');
			$map['_complex']['_logic'] = 'OR';
			$sea['username'] = trim(I('get.username'));
		}
		$oid = I('get.oid');
		$jjr = I('get.jjr');//经纪人id
		if($jjr){
			$userarr=array();
			$ship=M('userinfoRelationship')->where(array('parent_user_id'=>$jjr))->select();
			foreach($ship as $key=>$value){
				array_push($userarr,$value['user_id']);
				$id=implode(',',array_unique($userarr));
			}
			$jjr_userinfo=M('userinfo')->field('username')->where(array('uid'=>$jjr))->find();
			$map['a.uid']=array('IN',$id);
			$this->assign('jjr_info',$jjr_userinfo['username']);
			$this->assign('user_id', $oid);
		}else if ($oid) {
			$userarr = array();
			$userarr1 = array();
			$ship = M("UserinfoRelationship")->where(array('parent_user_id' => $oid))->select();
			foreach ($ship as $key => $value) {
				array_push($userarr, $value['user_id']);
			}
			$user_id = implode(',', array_unique($userarr));
			$users = M("UserinfoRelationship")->where('parent_user_id  in(' . $user_id . ')')->select();
			foreach ($users as $key => $val) {
				array_push($userarr1, $val['user_id']);
			}
			$id = implode(',', array_unique($userarr1));

			$map['a.uid'] = array('in', $id);
			$this->assign('user_id', $oid);
		}

		$sort = 'a.utime desc';
        //余额排序
        $cat   = trim(I('get.cat'));
        $sorts = trim(I('get.sort')); 
        if($cat)
        {   
             $sort = $cat.' '.$sorts.'';
             $sea['cat'] = $cat;
             $sea['sort'] = $sorts;
        }

		$this->assign('sea', $sea);

		//查询用户和账户信息
		$map['a.otype'] = 4;
		$map['a.ustatus'] = array('in', '0,1');

		$field = "a.*,b.balance,b.gold,c.busername,b.income_total,b.recharge_total,b.loss_total,b.money_total,d.money";
		$ulist = M("userinfo a")->field($field)->
		join('left join wp_bankinfo as c on a.uid = c.uid')->
		join('wp_accountinfo as b on a.uid = b.uid')->
		join('left join wp_extension as d on a.uid = d.user_id')->
		where($map)->
		order($sort)->
		select();

		$data[0] = array('编号','用户名称','手机号','创建时间','最近登录时间','订单数量','帐户余额','账户金币','累计充值','累计提现','佣金余额','运营中心','经纪人');
		foreach($ulist as $k => $v){
			$username = empty($v['busername']) ? $v['username'] : $v['busername'];
			$lastlog  = empty($v['lastlog']) ? '未登录过' : date("Y-m-d H:i:s",$v['lastlog']);

			$data[$k+1][] = $v['uid'];
			$data[$k+1][] = $username;
			$data[$k+1][] = $v['utel'];
			$data[$k+1][] = date("Y-m-d H:i:s",$v['utime']);
			$data[$k+1][] = $lastlog;
			$data[$k+1][] = $order->where('uid='.$v['uid'])->count();
			$data[$k+1][] = number_format($v['balance'],2);
			$data[$k+1][] = number_format($v['gold'],2);
			$data[$k+1][] = number_format($v['recharge_total'],2);
			$data[$k+1][] = number_format($v['money_total'],2);
			$data[$k+1][] = $v['money'];
			$data[$k+1][] = change(exchange($v['uid'],2));
			$data[$k+1][] = change(exchange($v['uid'],1));
		}

		$name='客户列表';  //生成的Excel文件文件名
		$res=$this->push($data,$name);
	}


	public function push($data,$name){
		import("Excel.class.php");
		$excel = new Excel();
		$excel->download($data,$name);
	}


	public function recommend(){
		$recommend=M("webconfig")->field("recommend,recommend2")->where("id=1")->find();
 
		$this->assign("recommend",$recommend['recommend']);
		$this->assign("recommend2",$recommend['recommend2']);
		$this->display();
	}


	public function act_recommend(){
 
		$recommend=$_POST['recommend'];
		$recommend2=$_POST['recommend2'];
		$data['recommend']=$recommend;
		$data['recommend2']=$recommend2;
		M("webconfig")->where("id=1")->save($data);
		$this->success("修改成功",U("index/index"));
	}


	//代理商申请列表
	public function agentlist(){
		$tq=C('DB_PREFIX');
    	$user = D('userinfo');
    	$managerinfo = D('managerinfo');
    	$list=$user->join($tq.'managerinfo on '.$tq.'userinfo.uid='.$tq.'managerinfo.uid')->where($tq.'userinfo.agenttype=1')->order($tq.'userinfo.uid desc')->select();

		$this->assign('list',$list);
		$this->display();
	}


	//处理代理申请是否通过
	public function edituser(){
		$user = D('userinfo');
		$uid=I('get.uid');
		$otype=I('get.otype');

		if ($otype==0) {
			//拒绝
			$date['uid']=$uid;
			$date['agenttype']=0;
			if($user->save($date)){
				M('managerinfo')->where('uid='.$uid)->delete();
			}

		}else{
			//通过
			$date['uid']=$uid;
			$date['agenttype']=2;
			$date['otype']=1;
			$user->save($date);
		}
	   $this->redirect('User/agentlist');
	}


	public function jingjishen()
	{
		$uid = $_REQUEST['uid'];
		$row = M('userinfo')->where('uid='.$uid)->find();
		if($row['agenttype'] == 1)
		{
			echo 3;exit;
		}
		$map['agenttype'] = 1;
		$t = M('userinfo')->where('uid='.$uid)->save($map);
		if($t)
		{
			echo 1;exit;
		}else{
			echo 2;exit;
		}
	}


	//修改会员
	public function updateuser()
    {
    	//检测用户是否登陆
    	$this->checklogin();
		
		//实例化数据表
		$tq=C('DB_PREFIX');    
		$user = D('userinfo');
		$manager = D('managerinfo');
		$bank = D('bankinfo');
		$acinfo = D('accountinfo');
		$order = D('order');
		//判断如果是post，执行修改用户方法，否则显示视图
		if(IS_POST){
			$uid = I('post.uid');				//用户id
			$username = I('post.username');		//用户名
			$mname = I('post.mname');			//真实姓名
			$upwd = I('post.upwd');				//密码
//			$otype = I('post.otype');			//用户类型
//            if($otype=='客户'){
//                $otype=0;
//            }else if($otype=='会员'){
//                $otype=2;
//            }else if($otype=='代理商'){
//                $otype=1;
//            }
			$utel = I('post.utel');				//手机号码
			$brokerid = I('post.brokerid');		//身份证号码
			$banknumber = I('post.banknumber');	//银行卡号
			$branch = I('post.branch');			//开户行地址
			$bankname = I('post.bankname');		//所属银行
			$province = I('post.province');		//省份
			$city = I('post.city');				//城市
			$busername = I('post.busername');	//持卡人		
			$busernames = I('post.busernames');	//姓名
			$balance = I('post.balance');		//账户余额
			$gold    = I('post.gold');		    //账户金币
			//取值，如果没有做修改，保存原有值
			$users = $user->where('uid='.$uid)->find();
			$mginfo = $manager->where('uid='.$uid)->find();
			$banks = $bank->where('uid='.$uid)->find();
			$accinfo = $acinfo->where('uid='.$uid)->find();
			
			//判断密码是否为空
			if(!empty($upwd)){
				$users['upwd'] = md5($upwd);
			}
			//判断电话是否为空
			if(!empty($utel)){
				$users['utel'] = $utel;
			}
			//判断真实姓名是否为空
			if(!empty($mname)){
				$mginfo['mname'] = $mname;
			}
			//判断身份证号码是否为空
			if(!empty($brokerid)){	
				$banks['card'] = $brokerid;
			}
			//判断银行卡号是否为空
			if(!empty($banknumber)){
				$banks['banknumber'] = $banknumber;
			}
			//判断开户行地址是否为空
			if(!empty($branch)){
				$banks['branch'] = $branch;
			}
			//判断所属银行是否为空
			if(!empty($bankname)){
				$banks['bankname'] = $bankname;
			}

			//判断持卡人是否为空
			if(!empty($busername)){
				$banks['busername'] = $busername;
			}

			//判断持卡人是否为空
			if(!empty($busernames)){
				$banks['busername'] = $busernames;
			}

		    //判断省
			if(!empty($province)){
				$banks['province'] = $province;
			}

			//判断市
			if(!empty($city)){
				$banks['city'] = $city;
			}

			//判断账户余额
			if(!empty($balance)){
				$accinfo['balance'] = $balance;
			}

			//判断账户金币
			if(!empty($gold)){
				$accinfo['gold'] = $gold;
			}
		    
			//修改用户基本信息
			$resultUser = $user->where('uid='.$uid)->save($users);
			//修改用户真实信息
			$resultManager = $manager->where('uid='.$uid)->save($mginfo);
			//修改账户余额
			if($acinfo->where('uid='.$uid)->find())
			{
				$trueAcinfo = $acinfo->where('uid='.$uid)->setInc('balance',$balance);
			} else {
				$balan['uid'] = $uid;
				$balan['balance'] = $balance;
				$trueAcinfo = $acinfo->add($balan);
			}

			if($trueAcinfo){

                 $info = M('userinfo')->field('otype')->where(array('uid' => $uid))->find();
                 if($info['otype'] == 5)
                 {
                 	$where['user_type'] = 2;
                 }

                 $where['user_id'] = $uid;
                 $where['account'] = $balance;
                 $where['type']    = 3;
                 $where['create_time'] = time();
				 $res = M("UserJournal")->add($where);

				 //生成用户流水
				 if($balance > 0) {
				 	 $msg = '资金变动增加['.$balance.']元';
				 } else {
				 	 $msg = '资金变动扣除['.$balance.']元';
				 }
                 $map['uid']      = $uid;
                 $map['type']     = 6;
                 $map['oid']      = $res;
                 $map['note']     = $msg;
                 $map['balance']  = $acinfo->where(array('uid' => $uid))->sum('balance');
                 $map['op_id']    = session('userid');
                 $map['dateline'] = time();
                 M("MoneyFlow")->add($map);

                //添加充值记录
                if($balance > 0) {
                    $r['b_type']        = 1;
                    $r['bptype']        = '充值';
                    $r['bptime']        = time();
                    $r['bpprice']       = $balance;
                    $r['remarks']       = '管理员手动充值';
                    $r['uid']           = $uid;
                    $r['isverified']    = 1;
                    $r['cltime']        = time();
                    $r['balanceno']     = time().mt_rand();;
                    $r['shibpprice']    = $map['balance'];
                    $r['status']        = 1;
                    $r['pay_type']      = 30;
                    M('balance')->add($r);

                    //添加累计充值
                    $acinfo->where('uid='.$uid)->setInc('recharge_total',$balance);
                }
			}
			//修改账户金币
			if($acinfo->where('uid='.$uid)->find()) {

               	$falseAcinfo = $acinfo->where('uid='.$uid)->setInc('gold',$gold);
			} else {
				$balan['uid'] = $uid;
				$balan['gold'] = $gold;
				$falseAcinfo = $acinfo->add($balan);
			}
            if($falseAcinfo){

                 $where['user_id'] = $uid;
                 $where['account'] = $gold;
                 $where['type']    = 4;
                 $where['create_time'] = time();
				 M("UserJournal")->add($where);
            }

			//判断用户是否存在银行卡信息
			if($banks['uid']==$uid){
				//修改银行卡信息
				$resultBank = $bank->where('uid='.$uid)->save($banks);				
			}else{
				$banks['uid'] = $uid;
				//添加银行卡信息
				$resultBank = $bank->add($banks);
			}
			if($resultUser || $resultManager || $resultBank || $trueAcinfo || $falseAcinfo){
				$this->success('修改成功');
			}else if($resultUser==0 || $resultManager==0 || $resultBank==0 || $trueAcinfo==0 || $falseAcinfo==0){
				$this->error('未做任何修改');
			}else{
				$this->error('修改失败');
			}
			
		}else{
			//根据获取的用户id查询该用户的信息，展示视图
			$uid=I('get.uid');
			//需要查询的字段
			$field = $tq.'userinfo.uid as uid,'.$tq.'userinfo.username as username,'.$tq.'userinfo.oid as oid,'.$tq.'userinfo.managername as managername,'.$tq.'userinfo.otype as otype,'.$tq.'userinfo.utel as utel,'.$tq.'managerinfo.mname as mname,'.$tq.'managerinfo.brokerid as brokerid,'.$tq.'bankinfo.bankname as bankname,'.$tq.'bankinfo.province as province,'.$tq.'bankinfo.card as card,'.$tq.'bankinfo.city as city,'.$tq.'bankinfo.branch as branch,'.$tq.'bankinfo.banknumber as banknumber,'.$tq.'bankinfo.bankname as bankname,'.$tq.'bankinfo.busername as busername,'.$tq.'accountinfo.balance as balance,'.$tq.'accountinfo.gold as gold,'.$tq.'userinfo.utime as utime,'.$tq.'userinfo.ustatus as ustatus,'.$tq.'city.name as name'; 
			//修改用户显示的数据
			$userme = $user->join($tq.'managerinfo on '.$tq.'userinfo.uid='.$tq.'managerinfo.uid','left')->join($tq.'bankinfo on '.$tq.'userinfo.uid='.$tq.'bankinfo.uid','left')->join($tq.'accountinfo on '.$tq.'accountinfo.uid='.$tq.'bankinfo.uid','left')->join($tq.'city on '.$tq.'city.id='.$tq.'bankinfo.city','left')->field($field)->where($tq.'userinfo.uid='.$uid)->find();
			
			$sys = $user->field('otype')->where('uid='.$userme['oid'])->find();
			//账户余额
			$account = $acinfo->field('balance,gold')->where('uid='.$uid)->find();
			$account['balance'] = number_format($account['balance'],2);
			
			$this->assign('sys',$sys);
			$this->assign('userme',$userme);
			$this->assign('account',$account);
			$this->assign('city',M('city')->where(array('level' => 1))->select());
			$this->display();
		}
		
	}


	 /**
     * 省市联动
     * @author wang <admin>
     */
    public function city(){
         if(IS_AJAX) {
             $id = I('post.id');
             $city = M('city')->where(array('parent_id' => $id))->select();
             if(!$city) {
                    $this->ajaxReturn('不存在','JSON');
             } else {
                    $this->ajaxReturn($city,'JSON');
             }
        } else {
             $this->ajaxReturn('程序异常','JSON');
        }
    }
	
	/**
	  * 重置密码表单页
	  * $uid  用户uid
	*/
	public function resetpwd($uid=null){
		if($uid < 1){
			redirect(U(''), 2, '用户id不存在');
		}
		$userinfo = M('userinfo')->field('username')->where(array('uid'=>$uid))->find();
		$this->assign('username', $userinfo['username']);
		$this->assign('uid',$uid);
		$this->display();
	}
	
	public function resetop(){
		$uid = I('post.uid',0);
		$password = I('post.password',null);
		$password2 = I('post.password2', null);
		if($uid < 1){
			$data['post'] = I('post.');
			$data['status'] = 0;
			$data['msg'] = '用户id不存在';
			$this->ajaxReturn($data,'JSON');
		}
		
		if(trim($password) == '' || trim($password2) == ''){

        $data['status'] = 0;
        $data['msg']    = '密码不能为空';
        $this->ajaxReturn($data,'JSON');
            }
		if(trim($password2) != $password){

            $data['status'] = 0;
            $data['msg']    = '密码必须一致';
             $this->ajaxReturn($data,'JSON');
            } 

        if(!preg_match('/^[A-Za-z0-9]+$/', trim($password))){

            $data['status'] = 0;
            $data['msg']    = '密码不能包含中文或特殊字符';
            $this->ajaxReturn($data,'JSON');
            }		
		
		$userObj = M('userinfo');
		$pwd=array('upwd'=>md5($password));
		$userObj->where(array('uid'=>$uid))->save($pwd);
		$data['status'] = 1;
		$data['msg'] = '修改成功';
		$this->ajaxReturn($data,'JSON');
	}
	
	public function index()
	{
		$this->display('ulist');		
	}
	/**
	 * 添加会员
	 * */
	public function addmenber(){
		
		$this->display();	
	}
    /**
     * 添加客户
     * */
    public function adduser(){

        if(IS_POST) {

            $jingjiren      = trim(I('post.jingjiren'));    //经纪人
            $utel           = trim(I('post.utel'));    //手机号
            $nickname       = trim(I('post.nickname'));    //昵称
            $upwd           = trim(I('post.upwd'));    //密码
            $confimUpwd     = trim(I('post.confimUpwd'));  //密码

            if(empty($jingjiren))
                $this->error('机构不能为空','adduser');

            if(empty($utel))
                $this->error('手机号码不能为空','adduser');

            if(empty($upwd))
                $this->error('请填写密码','adduser');

            if(empty($confimUpwd))
                $this->error('确认密码不能为空','adduser');

            if($upwd != $confimUpwd)
                $this->error('密码输入不一致','adduser');

            $userinfo             = M("userinfo");
            $accountinfo          = M("accountinfo");
            $UserinfoRelationship = M("UserinfoRelationship");


            if($userinfo->field('uid')->where('utel='.$utel.' and ustatus in(0,1) and otype=4')->find())
                $this->error('手机号已经被注册了','adduser');

            if($userinfo->field('uid')->where('uid='.$jingjiren.' and otype=6')->find())
                $this->error('所选机构系统不存在','adduser');


            $userinfo->startTrans();

            $map['username']    = $utel;
            $map['upwd']        = md5($upwd);
            $map['utel']        = $utel;
            $map['utime']       = time();
            $map['agenttype'] = 0;
            $map['otype']     = 4;
            $map['ustatus']   = 0;
            $map['usertype']  = 0;  //不是微信用户
            $map['wxtype']    = 1;  //微信还没注册
            $map['nickname']  = $nickname;//用户昵称
            $map['reg_ip']    = get_client_ip();    //用户注册ip
            $result = $userinfo->add($map);

            $account['uid']  = $result;
            $account['gold'] = gold();  //赠送金币
            $info = $accountinfo->add($account);

            //用户关系表
            $rela['user_id']        = $result;
            $rela['parent_user_id'] = $jingjiren; //代理商id
            $rela['user_type']      = 4;
            $ship = $UserinfoRelationship->add($rela);

            if($result && $info && $ship){
                $userinfo->commit();
                $this->success('注册成功','ulist');
            } else {
                $userinfo->rollback();
                $this->error('注册失败','adduser');
            }

        }else {
            $this->assign('info',M('userinfo')->field('uid,username')->where(array("otype" => 5))->select());
            $this->display();
        }
    }

	public function userdel(){
		$user = D('userinfo');
		//单个删除
		$uid = I('get.uid');
		$result = $user->where(array('uid='.$uid))->setField('ustatus',2);         //用户 2已删除

		// $accountinfo = M("accountinfo")->where('uid='.$uid)->delete();          //用户信息
		// $order = M("order")->where('uid='.$uid)->delete();                      //用户订单
		// $journal = M("journal")->where('uid='.$uid)->delete();                  //用户订单日志
		// $extension = M('extension')->where('user_id=',$uid)->delete();          //用户佣金
		// $UserJournal = M('UserJournal')->where('user_id=',$uid)->delete();      //用户金额日志
		// $balance = M('balance')->where('uid='.$uid)->delete();                  //用户充值提现
		// $bankinfo = M('bankinfo')->where('uid='.$uid)->delete();                //用户银行信息
        // $UserinfoOpen = M("UserinfoOpen")->where('user_id='.$uid)->delete();    //用户微信
        // $UserinfoRelationship = M("UserinfoRelationship")->where('user_id='.$uid)->delete();//用户关系

		if($result!==FALSE){
			$this->success("成功删除！",U("User/ulist"));
		}else{
			$this->error('删除失败！');
		}
	}


	public function daochu_rechare(){
		$this->checklogin();
		$tq       = C('DB_PREFIX');
		$balance  = M('balance a');

        $yunying   = trim(I('get.yunying'));              //运营中心
        $jingjiren = trim(I('get.jingjiren'));            //经纪人	
        $user      = trim(I('get.user'));			      //用户
        $user_type = trim(I('get.user_type'));            //用户类型
        $utel      = trim(I('get.utel'));                 //手机号码
        $status    = trim(I('get.status'));               //充值状态
        $pay_type  = trim(I('get.pay_type'));			  //充值渠道
        $balanceno = trim(I('get.balanceno'));			  //充值单号

		$starttime = urldecode(trim(I('get.starttime')));
		$endtime   = urldecode(trim(I('get.endtime')));

        if($yunying) {

        	$relation = M('userinfo_relationship')->where(array('parent_user_id' => $yunying))->select();
        	$relationArr = array();
        	$relationArr1 = array();
        	foreach ($relation as $key => $value) {
        		 array_push($relationArr,$value['user_id']);
        	}
        	$relationId = implode(',',array_unique($relationArr));
        	$users = M('userinfo_relationship')->where('parent_user_id in('.$relationId.')')->select();
            foreach ($users as $key => $value) {
            	 array_push($relationArr1,$value['user_id']);
            }
            $userId = implode(',',array_unique($relationArr1));
            $map['a.uid'] = array('in',$userId);
        }

        if($jingjiren) {
            $relationArr2 = array();
        	$jingjiren_user = M('userinfo_relationship')->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
            	 array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['a.uid'] = array('in',$userId1);
        }
        
        if($user) {
            $map['a.uid'] = $user;
        }

	      if($user_type){
	      	 $map['c.otype']   = $user_type;
	      	 $sea['user_type'] = $user_type;
	      }

	      if($utel){
	      	 $map['c.utel'] = array('like','%'.$utel.'%');
	      }

	      if($status) {
	      	if($status == 1) {
               $map['a.status'] = 0;
               $map['a.isverified'] = 0;
	      	} else if($status == 2) {
	      	   $map['a.status'] = 1;
	      	   $map['a.isverified'] = 1;
	      	} else {
	      	   $map['a.status'] = 1;
	      	   $map['a.isverified'] = 0;
	      	}
	      }

  	      if($pay_type)
	      {
      	 	$map['a.pay_type'] = $pay_type;
	      }

	      if($balanceno)
	      {
      	 	$map['a.balanceno'] = $balanceno;
	      }

	      if($starttime && $endtime) {
			$start_time  = strtotime($starttime);
			$end_time 	 = strtotime($endtime);
	      	$map['a.bptime']  = array('between',''.$start_time.','.$end_time.'');
	      } else {
			$start_time = strtotime(date('Y-m-d')." 06:00:00");
			$end_time = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
	      	$map['a.bptime']  = array('between',''.$start_time.','.$end_time.'');
	      }

        $map['a.b_type'] = 1;
        $field = 'a.*,b.busername,c.utel,c.username,c.otype,d.pay_name';
        $rechargelist = $balance->
                field($field)->
                join('left join '.$tq.'bankinfo as b  on a.uid = b.uid')->
                join('left join '.$tq.'userinfo as c on a.uid = c.uid')->
                join('left join dict_pay_type as d on a.pay_type = d.id')->
                where($map)->
                select();

		$data[0] = array('编号','订单号','用户名','手机号','用户类型','创建时间','充值金额','账户余额','状态','充值渠道');
		foreach($rechargelist as $k => $v){
			$username = !empty($v['busername']) ? $v['busername'] : $v['username'];
			if($v['otype'] == 4)
			{
				$otype = '普通客户';
			} else if($v['otype'] == 5)
			{
				$otype = '运营中心';
			}

			$data[$k+1][] = $v['bpid'];
			$data[$k+1][] = $v['balanceno'];
			$data[$k+1][] = $username;
			$data[$k+1][] = $v['utel'];
			$data[$k+1][] = $otype;
			$data[$k+1][] = date("Y-m-d H:i:s",$v['bptime']);
			$data[$k+1][] = number_format($v['bpprice'],2);
			$data[$k+1][] = number_format($v['shibpprice'],2);
            if($v['isverified'] == 1 && $v['status'] == 1) {
            	$data[$k+1][] = '充值成功';
            } else if($v['isverified'] == 1 && $v['status'] == 0) {
            	$data[$k+1][] = '充值失败';
            } else if($v['isverified'] == 0 && $v['status'] == 0) {
            	$data[$k+1][] = '未处理';
            } else {
            	$data[$k+1][] = '不存在';
            }

			$data[$k+1][] = $v['pay_name'];
		}
		$name='充值流水记录';  //生成的Excel文件文件名
		$res=$this->push($data,$name);
	}

    public function chongzhi(){
      	//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();

        $yunying   = trim(I('get.yunying'));              //运营中心
        $jingjiren = trim(I('get.jingjiren'));            //经纪人	
        $user      = trim(I('get.user'));			      //用户
        $user_type = trim(I('get.user_type'));            //用户类型
        $utel      = trim(I('get.utel'));                 //手机号码
        $status    = trim(I('get.status'));               //充值状态
        $pay_type  = trim(I('get.pay_type'));			  //充值渠道
        $balanceno = trim(I('get.balanceno'));			  //充值单号

		$starttime = urldecode(trim(I('get.starttime')));
		$endtime   = urldecode(trim(I('get.endtime')));

        if($yunying) {

        	$relation = M('userinfo_relationship')->where(array('parent_user_id' => $yunying))->select();
        	$relationArr = array();
        	$relationArr1 = array();
        	foreach ($relation as $key => $value) {
        		 array_push($relationArr,$value['user_id']);
        	}
        	$relationId = implode(',',array_unique($relationArr));
        	$users = M('userinfo_relationship')->where('parent_user_id in('.$relationId.')')->select();
            foreach ($users as $key => $value) {
            	 array_push($relationArr1,$value['user_id']);
            }
            $userId = implode(',',array_unique($relationArr1));
            $map['a.uid'] = array('in',$userId);
            $sea['yunying'] = $yunying;
            $this->assign('yunying',$yunying);
        }

        if($jingjiren) {
            $relationArr2 = array();
        	$jingjiren_user = M('userinfo_relationship')->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
            	 array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['a.uid'] = array('in',$userId1);
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren',$this->get_username($jingjiren));
        }
        
        if($user) {
            $map['a.uid'] = $user;
            $sea['user'] = $user;
            $this->assign('user',$this->get_username($user));
        }

	      if($user_type){
	      	 $map['c.otype']   = $user_type;
	      	 $sea['user_type'] = $user_type;
	      }

	      if($utel){
	      	 $map['c.utel'] = $utel;
	      	 $sea['utel']   = $utel;
	      }

	      if($status) {
	      	if($status == 1) {
               $map['a.status'] = 0;
               $map['a.isverified'] = 0;
	      	} else if($status == 2) {
	      	   $map['a.status'] = 1;
	      	   $map['a.isverified'] = 1;
	      	} else {
	      	   $map['a.status'] = 1;
	      	   $map['a.isverified'] = 0;
	      	}
	      	$sea['status'] = $status;
	      }

	      if($pay_type)
	      {
      	 	$map['a.pay_type'] = $pay_type;
      	 	$sea['pay_type'] 	= $pay_type;
	      }

	      if($balanceno)
	      {
      	 	$map['a.balanceno'] = $balanceno;
      	 	$sea['balanceno'] 	= $balanceno;
	      }

	      if($starttime && $endtime) {
			$start_time  = strtotime($starttime);
			$end_time 	 = strtotime($endtime);
	      	$map['a.bptime']  = array('between',''.$start_time.','.$end_time.'');
	      	$sea['starttime'] = $starttime;
	      	$sea['endtime']   = $endtime;
	      } else {
			$start_time = strtotime(date('Y-m-d')." 06:00:00");
			$end_time = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
	      	$map['a.bptime']  = array('between',''.$start_time.','.$end_time.'');
	      	$sea['starttime'] = date('Y-m-d H:i:s',$start_time);
	      	$sea['endtime']   = date('Y-m-d H:i:s',$end_time);
	      }

	

      $map['a.b_type'] = 1;

      $count = M("balance a")->
                    join('left join wp_bankinfo as b on a.uid = b.uid')->
                    join('wp_userinfo as c on a.uid = c.uid')->
                    join('left join wp_accountinfo as d on a.uid = d.uid')->
                    where($map)->
                    count();
	   //分页
	   $pagecount = 10;
	   $page = new \Think\Page($count , $pagecount);
	   $page->parameter = $sea; //此处的row是数组，为了传递查询条件
	   $page->setConfig('first','首页');
	   $page->setConfig('prev','&#8249;');
	   $page->setConfig('next','&#8250;');
	   $page->setConfig('last','尾页');
	   $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
	   $show = $page->show();
       
       $field = 'a.*,b.busername,c.username,c.utel,c.otype,d.balance,e.pay_name';
       $rechargelist = M("balance a")->
                    field($field)->
                    join('left join wp_bankinfo as b on a.uid = b.uid')->
                    join('wp_userinfo as c on a.uid = c.uid')->
                    join('left join wp_accountinfo as d on a.uid = d.uid')->
                    join('left join dict_pay_type as e on a.pay_type = e.id')->
                    where($map)->
                    order('a.bpid desc')->
                    limit($page->firstRow.','.$page->listRows)->
                    select();
      
       $sum = M("balance a")->
                    field($field)->
                    join('left join wp_bankinfo as b on a.uid = b.uid')->
                    join('wp_userinfo as c on a.uid = c.uid')->
                    join('left join wp_accountinfo as d on a.uid = d.uid')->
                    join('left join dict_pay_type as e on a.pay_type = e.id')->
                    where($map)->
                    select();
      foreach ($sum as $key => $value) {
      	  if($value['status'] == 1 && $value['isverified'] == 1) $amount['chengong'] += $value['bpprice'];
      	  $amount['amount'] += $value['bpprice'];
      }

      $this->assign('rechargelist',$rechargelist);
      $this->assign('page',$show);
      $this->assign('sea',$sea);
      $this->assign('amount',$amount);   //总充值金额
      $this->assign('info',M('userinfo')->where(array('otype' => 5))->select());
      $this->assign('payType',M()->table('dict_pay_type')->select());
      $this->display('recharge');
    }


    public function withdrawal(){

		//判断用户是否登陆
	  $user= A('Admin/User');
	  $user->checklogin();

      $yunying   = trim(I('get.yunying'));              //运营中心
      $jingjiren = trim(I('get.jingjiren'));            //经纪人	
      $user      = trim(I('get.user'));			        //用户
      $user_type = trim(I('get.user_type'));            //用户类型
      $utel      = trim(I('get.utel'));                 //手机号码
      $status    = trim(I('get.status'));               //提现状态
	  $starttime = urldecode(trim(I('get.starttime')));
	  $endtime   = urldecode(trim(I('get.endtime')));
      
      if($yunying) {

        	$relation = M('userinfo_relationship')->where(array('parent_user_id' => $yunying))->select();
        	$relationArr = array();
        	$relationArr1 = array();
        	foreach ($relation as $key => $value) {
        		 array_push($relationArr,$value['user_id']);
        	}
        	$relationId = implode(',',array_unique($relationArr));
        	$users = M('userinfo_relationship')->where('parent_user_id in('.$relationId.')')->select();
            foreach ($users as $key => $value) {
            	 array_push($relationArr1,$value['user_id']);
            }
            $userId = implode(',',array_unique($relationArr1));
            $map['a.uid'] = array('in',$userId);
            $sea['yunying'] = $yunying;
            $this->assign('yunying',$yunying);
        }

        if($jingjiren) {
            $relationArr2 = array();
        	$jingjiren_user = M('userinfo_relationship')->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
            	 array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['a.uid'] = array('in',$userId1);
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren',$this->get_username($jingjiren));
        }
        
        if($user) {
            $map['a.uid'] = $user;
            $sea['user'] = $user;
            $this->assign('user',$this->get_username($user));
        }

	      if($user_type){
	      	 $map['c.otype']   = $user_type;
	      	 $sea['user_type'] = $user_type;
	      }

	      if($utel){
	      	 $map['c.utel'] = array('like','%'.$utel.'%');
	      	 $sea['utel']   = $utel;
	      }

	      //ctime为null表示未审核  1同意  2拒绝 4以代付 5代付中 6代付失败

	      if($status) {
	      	if($status == 1) {
               $map['a.status'] = 1;
               $map['a.isverified'] = 1;
               $map['a.cltime']  = array('exp','is not null');
	      	} else if($status == 2){
	      	   $map['a.status'] = 0;
	      	   $map['a.isverified'] = 0;
	      	   $map['a.cltime']  = array('exp','is not null');
	      	} else if($status == 4){
	      	   $map['a.status'] = 1;
	      	   $map['a.isverified'] = 2;
	      	   $map['a.cltime']  = array('exp','is not null');
	      	} else if($status == 5){
	      	   $map['a.status'] = 2;
	      	   $map['a.isverified'] = 2;
	      	   $map['a.cltime']  = array('exp','is not null');
	      	} else if($status == 6){
	      	   $map['a.status'] = 3;
	      	   $map['a.isverified'] = 2;
	      	   $map['a.cltime']  = array('exp','is not null');
	      	} else {
	      	   $map['a.cltime']  = array('exp','is null');
	      	}
	      	$sea['status'] = $status;
	      }

	      if($starttime && $endtime) {
			$start_time  = strtotime($starttime);
			$end_time 	 = strtotime($endtime);
	      	$map['a.bptime'] = array('between',''.$start_time.','.$end_time.'');
	      	$sea['starttime'] = $starttime;
	      	$sea['endtime']   = $endtime;
	      } 
	  //     else {
			// $start_time = strtotime(date('Y-m-d')." 06:00:00");
			// $end_time = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
	  //     	$map['a.bptime'] = array('between',''.$start_time.','.$end_time.'');
	  //     	$sea['starttime'] = date('Y-m-d H:i:s',$start_time);
	  //     	$sea['endtime']   = date('Y-m-d H:i:s',$end_time);
	  //     }

       $map['a.b_type'] = 2;
       $count =     M("balance a")-> 
                    join('left join wp_bankinfo as b on a.uid = b.uid')->
                    join('wp_userinfo as c on a.uid = c.uid')->
                    join('left join wp_accountinfo as d on a.uid = d.uid')->
                    where($map)->
                    count();
	   //分页
	   $pagecount = 10;
	   $page = new \Think\Page($count , $pagecount);
	   $page->parameter = $sea; //此处的row是数组，为了传递查询条件
	   $page->setConfig('first','首页');
	   $page->setConfig('prev','&#8249;');
	   $page->setConfig('next','&#8250;');
	   $page->setConfig('last','尾页');
	   $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
	   $show = $page->show();

       $rechargelist = M("balance a")-> 
                    join('left join wp_bankinfo as b on a.uid = b.uid')->
                    join('wp_userinfo as c on a.uid = c.uid')->
                    join('left join wp_accountinfo as d on a.uid = d.uid')->
                    where($map)->order('a.bpid desc')->
                    limit($page->firstRow.','.$page->listRows)->
                    select();

        $sum = M("balance a")-> 
                    join('left join wp_bankinfo as b on a.uid = b.uid')->
                    join('wp_userinfo as c on a.uid = c.uid')->
                    join('left join wp_accountinfo as d on a.uid = d.uid')->
                    where($map)->
                    select();

      foreach ($sum as $key => $value) {

      	$amount['amount'] += $value['bpprice'];	//总提现

    	if($value['status'] == 1 && $value['isverified'] == 1)
    	{
    		$amount['chengong'] += $value['bpprice'];	//通过
    	}

  	  	if($value['status'] == 0 && $value['isverified'] == 0 && !empty($value['cltime']))
  	  	{
  	  		$amount['refuse'] += $value['bpprice'];	//拒绝
  	  	}

  	  	if($value['status'] == 0 && $value['isverified'] == 0 && empty($value['cltime']))
  	  	{
  	  		$amount['pending'] += $value['bpprice'];	//待处理
  	  	}

  	  	if($value['status'] == 1 && $value['isverified'] == 2 )
  	  	{
  	  		$amount['HavePay'] += $value['bpprice'];	//已代付
  	  	}

  	  	if($value['status'] == 2 && $value['isverified'] == 2 )
  	  	{
  	  		$amount['PayIn'] += $value['bpprice'];	//代付中
  	  	}

  	  	if($value['status'] == 3 && $value['isverified'] == 2 )
  	  	{
  	  		$amount['PaymentFailed'] += $value['bpprice'];	//代付失败
  	  	}
      }

      $amount['amount'] 		= number_format($amount['amount'],2);
      $amount['chengong'] 		= number_format($amount['chengong'],2);
      $amount['refuse'] 		= number_format($amount['refuse'],2);
      $amount['pending'] 		= number_format($amount['pending'],2);
      $amount['HavePay'] 		= number_format($amount['HavePay'],2);
      $amount['PayIn'] 			= number_format($amount['PayIn'],2);
      $amount['PaymentFailed'] 	= number_format($amount['PaymentFailed'],2);


      $this->assign('rechargelist',$rechargelist);
      $this->assign('page',$show);
      $this->assign('sea',$sea);
      $this->assign('amount',$amount);
      $this->assign('info',M('userinfo')->where(array('otype' => 5))->select());
      $this->display();
    }

    public function daochu_withdrawal() {

      	$this->checklogin();
		$tq       = C('DB_PREFIX');
		$balance  = M('balance a');

		$yunying   = trim(I('get.yunying'));              //运营中心
        $jingjiren = trim(I('get.jingjiren'));            //经纪人	
        $user      = trim(I('get.user'));			        //用户
        $user_type = trim(I('get.user_type'));            //用户类型
        $utel      = trim(I('get.utel'));                 //手机号码
        $status    = trim(I('get.status'));               //提现状态
	    $starttime = urldecode(trim(I('get.starttime')));
	    $endtime   = urldecode(trim(I('get.endtime')));
      
        if($yunying) {

        	$relation = M('userinfo_relationship')->where(array('parent_user_id' => $yunying))->select();
        	$relationArr = array();
        	$relationArr1 = array();
        	foreach ($relation as $key => $value) {
        		 array_push($relationArr,$value['user_id']);
        	}
        	$relationId = implode(',',array_unique($relationArr));
        	$users = M('userinfo_relationship')->where('parent_user_id in('.$relationId.')')->select();
            foreach ($users as $key => $value) {
            	 array_push($relationArr1,$value['user_id']);
            }
            $userId = implode(',',array_unique($relationArr1));
            $map['a.uid'] = array('in',$userId);
        }

        if($jingjiren) {
            $relationArr2 = array();
        	$jingjiren_user = M('userinfo_relationship')->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
            	 array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['a.uid'] = array('in',$userId1);
        }
        
        if($user) {
            $map['a.uid'] = $user;
        }

	      if($user_type){
	      	 $map['c.otype']   = $user_type;
	      }

	      if($utel){
	      	 $map['c.utel'] = array('like','%'.$utel.'%');
	      }

	      //ctime为null表示未审核  1同意  2拒绝 4以代付 5代付中 6代付失败

	      if($status) {
	      	if($status == 1) {
               $map['a.status'] = 1;
               $map['a.isverified'] = 1;
               $map['a.cltime']  = array('exp','is not null');
	      	} else if($status == 2){
	      	   $map['a.status'] = 0;
	      	   $map['a.isverified'] = 0;
	      	   $map['a.cltime']  = array('exp','is not null');
	      	} else if($status == 4){
	      	   $map['a.status'] = 1;
	      	   $map['a.isverified'] = 2;
	      	   $map['a.cltime']  = array('exp','is not null');
	      	} else if($status == 5){
	      	   $map['a.status'] = 2;
	      	   $map['a.isverified'] = 2;
	      	   $map['a.cltime']  = array('exp','is not null');
	      	} else if($status == 6){
	      	   $map['a.status'] = 3;
	      	   $map['a.isverified'] = 2;
	      	   $map['a.cltime']  = array('exp','is not null');
	      	} else {
	      	   $map['a.cltime']  = array('exp','is null');
	      	}
	      	$sea['status'] = $status;
	      }

	      if($starttime && $endtime) {
			$start_time  = strtotime($starttime);
			$end_time 	 = strtotime($endtime);
	      	$map['a.bptime'] = array('between',''.$start_time.','.$end_time.'');
	      } 
	  //     else {
			// $start_time = strtotime(date('Y-m-d')." 06:00:00");
			// $end_time = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
	  //     	$map['a.bptime'] = array('between',''.$start_time.','.$end_time.'');
	  //     }

        $map['a.b_type'] = 2;
        $field = 'a.*,b.busername,c.utel,c.username,c.otype';
        $rechargelist = $balance->
                field($field)->
                join('left join '.$tq.'bankinfo as b  on a.uid = b.uid')->
                join('left join '.$tq.'userinfo as c on a.uid = c.uid')->
                where($map)->
                select();

		$data[0] = array('编号','用户名','手机号','用户类型','创建时间','审核时间','提现金额','账户余额','状态','理由');
		foreach($rechargelist as $k => $v){
			$username = !empty($v['busername']) ? $v['busername'] : $v['username'];
			$cltime   = empty($v['cltime']) ? '--' :date('Y-m-d H:i:s',$v['cltime']);
			if($v['otype'] == 4)
			{
				$otype = '普通客户';
			} else if($v['otype'] == 5)
			{
				$otype = '运营中心';
			}

			$data[$k+1][] = $v['bpid'];
			$data[$k+1][] = $username;
			$data[$k+1][] = $v['utel'];
			$data[$k+1][] = $otype;
			$data[$k+1][] = date("Y-m-d H:i:s",$v['bptime']);
			$data[$k+1][] = $cltime;
			$data[$k+1][] = number_format($v['bpprice'],2);
			$data[$k+1][] = number_format($v['shibpprice'],2);
            if(empty($v['cltime'])) {
            	$data[$k+1][] = '未处理';
            } else {
            	 if($v['isverified'] == 1 && $v['status'] == 1) {
            	 	$data[$k+1][] = '提现成功';
            	 } else if($v['isverified'] == 2 && $v['status'] == 1) {
            	 	$data[$k+1][] = '已代付';
            	 } else if($v['isverified'] == 2 && $v['status'] == 2) {
            	 	$data[$k+1][] = '代付中';
            	 } else if($v['isverified'] == 2 && $v['status'] == 3) {
            	 	$data[$k+1][] = '代付失败';
            	 } else {
            	 	$data[$k+1][] = '拒绝申请';
            	 }
            }
			$data[$k+1][] = $v['remarks'];
		}
		$name='提现流水记录';      //生成的Excel文件文件名
		$res=$this->push($data,$name);	
    }


	//更新充值提现状态
	public function upbalance(){
		$uid=islogin();
		if(!$uid)
		{
		    $this->ajaxReturn('login');
		}
		
		//获取参数
		$bpid       = trim(I('post.bpid'));
		$b_type     = trim(I('post.b_type'));
		$isverified = trim(I('post.isverified'));
		$remarks    = trim(I('post.remarks'));
		$rebpprce   = trim(I('post.rebpprce'));
		$userid     = trim(I('post.userid'));
		$cltime     = time();

		
		if($b_type == 2){
            $balance = M("balance")->where(array('bpid' => $bpid))->find();
            if(!empty($balance['cltime'])){
                $this->ajaxReturn("null");
            } 

			 if($isverified == 1){   //同意

                 $data['isverified'] = 1;
                 $data['status']     = 1;
                 $data['cltime']     = $cltime;
                 $data['remarks']    = $remarks;
                 $isver = M("balance")->where(array('bpid' => $bpid))->save($data);
			 }else if($isverified == 2){   //代付
                 $data['isverified'] = 2;
                 $data['cltime']     = $cltime;
                 $data['remarks']    = $remarks;
				 
				 
				Log::debugArr($balance['balanceno'], 'upbalance_daifu');
				
				$type="daifu";
				$q = new \Org\Util\ZNanPay();
				$rs = $q->postOrderDaifu($type, $balance);
				Log::debugArr($rs['status'], 'upbalance_daifu');
				if ($rs['status'] == 1) {
					$data['status']     = 2; // 代付中
				} else {
					$data['status']     = 3; // 代付失败
				}

				Log::debugArr($rs['status'], 'upbalance_daifu');
				 //$isver=true;
                 $isver = M("balance")->where(array('bpid' => $bpid))->save($data);
			 } else {    //拒绝
			 	 $data['cltime']     = $cltime;
			 	 $data['isverified'] = 0;
                 $data['remarks']    = $remarks;
                 $res = M("balance")->where(array('bpid' => $bpid))->save($data);

                if($res){
                    $isver = M("accountinfo")->where(array('uid' => $userid))->setInc('balance',$rebpprce);
                    $infos = M('userinfo')->where(array('uid' => $userid))->find();
                    if($infos['otype'] == 5)
                    {
                    	$map['user_type'] = 2;
                    }
	                //用户资金流水表
	                $map['uid']      = $userid;
	                $map['type']     = 3;
	                $map['oid']      = $bpid;
	                $map['note']     = '管理员拒绝提现增加['.$rebpprce.']元';
	                $map['balance']  = M('accountinfo')->where(array('uid'=>$userid))->sum('balance');
	                $map['op_id']    = session('userid');
	                $map['dateline'] = time();
	                $money_flow = M("MoneyFlow")->add($map);
                 }
			 }
		}
		
		if($isver){
			$this->ajaxReturn("success");	
		}else{
			$this->ajaxReturn("null");
		}
		
	}
	
	
	public function checklogin()
	{
		$uid=islogin(); 
		if(!$uid)
		{
		    $this->error('请登录','/index.php/Admin/User/signin');
		}
	}


	public function dongtis(){
		$this->checklogin();
		$uid=$_REQUEST['uid'];
		$types=$_REQUEST['types'];
		/*var_dump($uid."---".$types);
		exit;*/
		if($types==1){
			$a['ustatus']=1;
			$dongtis=M("userinfo")->where("uid = '".$uid."'")->save($a);
		}else if($types==2){
			$a['ustatus']=0;
			$dongtis=M("userinfo")->where("uid = '".$uid."'")->save($a);
		}
		if($dongtis){
			$this->success("操作成功!");
		}else{
			$this->error('操作失败,请重试!');
		}
	}


 /**
  * 佣金转入记录
  * @author wang <admin>
  */
   public function extension(){

		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();


	    $utel      = trim(I('get.utel'));                  //手机号码
	    $starttime = urldecode(trim(I('get.starttime')));           //开始时间
	    $endtime   = urldecode(trim(I('get.endtime')));            //结束时间
        $yunying   = trim(I('get.yunying'));        	//运营中心
        $jingjiren = trim(I('get.jingjiren'));         //经纪人	
        $user      = trim(I('get.user'));			  //用户


	    if($utel) {
	        $map['_complex']['b.username'] = array('like','%'.$utel.'%');
	        $map['_complex']['c.busername'] = array('like', '%'.$utel.'%');
	        $map['_complex']['_logic'] = 'OR';
	        $sea['utel'] = $utel;
	    }
	        
	    if($starttime && $endtime) {
	    	$start_time = strtotime($starttime);
	    	$end_time   = strtotime($endtime);
            $map['a.create_time'] = array('between',''.$start_time.','.$end_time.'');
            $sea['starttime']     = $starttime;
            $sea['endtime']       = $endtime;
	    }

        if($yunying) {

        	$relation = M('userinfo_relationship')->where(array('parent_user_id' => $yunying))->select();
        	$relationArr = array();
        	$relationArr1 = array();
        	foreach ($relation as $key => $value) {
        		 array_push($relationArr,$value['user_id']);
        	}
        	$relationId = implode(',',array_unique($relationArr));
        	$users = M('userinfo_relationship')->where('parent_user_id in('.$relationId.')')->select();
            foreach ($users as $key => $value) {
            	 array_push($relationArr1,$value['user_id']);
            }
            $userId = implode(',',array_unique($relationArr1));
            $map['a.user_id'] = array('in',$userId);
            $sea['yunying'] = $yunying;
            $this->assign('yunying',$yunying);
        }

        if($jingjiren) {
            $relationArr2 = array();
        	$jingjiren_user = M('userinfo_relationship')->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
            	 array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['a.user_id'] = array('in',$userId1);
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren',$this->get_username($jingjiren));
        }
        
        if($user) {
            $map['a.user_id'] = $user;
            $sea['user'] = $user;
            $this->assign('user',$this->get_username($user));
        }

        $map['a.type'] = 1;

	    $count = M('UserJournal a')->
	                join('left join wp_userinfo as b on a.user_id = b.uid')->
                    join('left join  wp_bankinfo as c on a.user_id = c.uid')->
                    where($map)->
                    count();

		$pagecount = 10;   //每页显示的数量
		$page = new \Think\Page($count , $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first','首页');
		$page->setConfig('prev','&#8249;');
		$page->setConfig('next','&#8250;');
		$page->setConfig('last','尾页');
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
		$show = $page->show();
        
        $map['a.type'] = 1;
        $field = 'a.*,b.username,b.utel,b.rid,c.busername';
        $commission = M('UserJournal a')->
                      field($field)->
                      join(' left join wp_userinfo as b on a.user_id = b.uid')->
                      join(' left join wp_bankinfo as c on a.user_id = c.uid')->
                      where($map)->
                      limit($page->firstRow,$page->listRows)->
                      select();

        // vD(M()->getLastSql());
        // vD($commission);
	    $sum = M('UserJournal a')->
	                join('left join wp_userinfo as b on a.user_id = b.uid')->
                    join('left join  wp_bankinfo as c on a.user_id = c.uid')->
                    where($map)->
                    sum('account');

	    $this->assign('sum',$sum);                                       //总提金额
	    $this->assign('commission',$commission);
	    $this->assign('page',$show);
	    $this->assign('sea',$sea);
	    $this->assign('info',M("userinfo")->where('otype=5')->select()); //运营中心
	    $this->display();
   }

  public function daochu_extension()
   {    
   		$utel      = trim(I('get.utel'));                  //手机号码
	    $starttime = urldecode(trim(I('get.starttime')));           //开始时间
	    $endtime   = urldecode(trim(I('get.endtime')));            //结束时间
        $yunying   = trim(I('get.yunying'));        	//运营中心
        $jingjiren = trim(I('get.jingjiren'));         //经纪人
        $user      = trim(I('get.user'));			  //用户

	    if($utel) {
	        $map['_complex']['b.username'] = array('like','%'.$utel.'%');
	        $map['_complex']['c.busername'] = array('like', '%'.$utel.'%');
	        $map['_complex']['_logic'] = 'OR';
	        $sea['utel'] = $utel;
	    }
	        
	    if($starttime && $endtime) {
	    	$start_time = strtotime($starttime);
	    	$end_time   = strtotime($endtime);
            $map['a.create_time'] = array('between',''.$start_time.','.$end_time.'');
            $sea['starttime']     = $starttime;
            $sea['endtime']       = $endtime;
	    }

        if($yunying) {

        	$relation = M('userinfo_relationship')->where(array('parent_user_id' => $yunying))->select();
        	$relationArr = array();
        	$relationArr1 = array();
        	foreach ($relation as $key => $value) {
        		 array_push($relationArr,$value['user_id']);
        	}
        	$relationId = implode(',',array_unique($relationArr));
        	$users = M('userinfo_relationship')->where('parent_user_id in('.$relationId.')')->select();
            foreach ($users as $key => $value) {
            	 array_push($relationArr1,$value['user_id']);
            }
            $userId = implode(',',array_unique($relationArr1));
            $map['a.user_id'] = array('in',$userId);
            $sea['yunying'] = $yunying;
            $this->assign('yunying',$yunying);
        }

        if($jingjiren) {
            $relationArr2 = array();
        	$jingjiren_user = M('userinfo_relationship')->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
            	 array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['a.user_id'] = array('in',$userId1);
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren',M('userinfo')->where(array('uid' => $jingjiren))->find());
        }
        
        if($user) {
            $map['a.user_id'] = $user;
            $sea['user'] = $user;
            $this->assign('user',M('userinfo')->where(array('uid' => $user))->find());
        }

        $map['a.type'] = 1;
        $field = 'a.*,b.username,b.utel,b.rid,c.busername';
        $commission = M('UserJournal a')->
                      field($field)->
                      join('left join wp_userinfo as b on a.user_id = b.uid')->
                      join('left join wp_bankinfo as c on a.user_id = c.uid')->
                      where($map)->
                      select();

   	 	$data[0] = array('编号','用户名','手机号码','上级','转入金额','转入时间');
		foreach($commission as $k => $v){
			$username  = !empty($v['busername']) ? $v['busername'] : $v['username'];
			$uname     = M('userinfo')->where(array('uid' => $v['rid']))->getField('username');
			$busername = M('bankinfo')->where(array('uid' => $v['rid']))->getField('busername');
            $name      = !empty($busername) ? $busername : $uname;

			$data[$k+1][] = $v['id'];
			$data[$k+1][] = $username;
			$data[$k+1][] = $v['utel'];
			$data[$k+1][] = empty($name) ? '无' : $name;
			$data[$k+1][] = empty($v['account']) ? '0.00' : $v['account'];
			$data[$k+1][] = date('Y-m-d H:i:s',$v['create_time']);
		}
		$name='佣金转入记录';      //生成的Excel文件文件名
		$res=$this->push($data,$name);
   }

 /**
  * 佣金审核
  * @author wang <admin>
  */ 
 
 public function extension_upbalance(){


       $bpid       = I('post.bpid');         //佣金id
       $isverified = I('post.isverified');  //1同意 2不同意
       $remarks    = I('post.remarks');     //理由
       $rebpprce   = I('post.rebpprce');    //提现金额
       $userid     = I('post.userid');    //用户userid
       if($isverified == '1'){
              $data['ustyle']      = $isverified;
              $data['handle_time'] = time();
              $data['reason']      = $remarks;
              if(M('extension')->where(array('user_id' => $userid))->setDec('money',$rebpprce)){

              	  $result =M('commission')->where(array('comid' => $bpid))->save($data);
              }

       } else {

              $data['ustyle']      = $isverified;
              $data['handle_time'] = time();
              $data['reason']      = $remarks;
              $result = M('commission')->where(array('comid' => $bpid))->save($data);
            
       }
         if($result){

         	 $this->ajaxReturn("success");  //成功
         } else {

         	 $this->ajaxReturn("null");    //失败
         }
              	
 }

 /**
  * 推广员流水
  * @author wang <admin>
  */
  public function extension_water(){
             
        //判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();

        $phone     = trim(I('get.phone'));    //手机号
        $status    = trim(I('get.status'));   //计算状态
        $user_type = trim(I('get.user_type')); //用户类型 
        $starttime = urldecode(trim(I('get.starttime')));
	    $endtime   = urldecode(trim(I('get.endtime')));  //结束时间
	    $otype     = trim(I('get.otype'));
        $jingjiren = trim(I('get.jingjiren'));
        $userss    = trim(I('get.user'));

        if($phone) {
        	$map['b.utel'] = array('like','%'.$phone.'%');
        	$sea['phone'] = $phone;
        }

        if($status) {
           $map['a.status'] = $status;
           $sea['status'] = $status;
        }

        if($user_type) {
           if($user_type == 3) {
              $map['a.user_id'] = 0;
           } else {
              $map['b.otype'] = $user_type;
           }
          $sea['user_type'] = $user_type;
        }


        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
        	$map['a.create_time'] = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime'] = $endtime;	
        } else {
			$start_time = strtotime(date('Y-m-d')." 06:00:00");
			$end_time = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
	      	$map['a.create_time'] = array('between',array($start_time,$end_time));
	      	$sea['starttime'] = date('Y-m-d H:i:s',$start_time);
	      	$sea['endtime']   = date('Y-m-d H:i:s',$end_time);
        }

        if($otype) {
            $userarr  = array();
            $userarr1 = array(); 
        	$ship = M("UserinfoRelationship")->where(array('parent_user_id' => $otype))->select();
            foreach ($ship as $key => $value) {
            	array_push($userarr, $value['user_id']);
            }
            $user_id = implode(',',array_unique($userarr));
  
        	$users = M("UserinfoRelationship")->where('parent_user_id  in('.$user_id.')')->select();

            foreach ($users as $key => $val) {
            	 
                array_push($userarr1,$val['user_id']);
            }
            $id = implode(',',array_unique($userarr1));
            $id = !empty($id) ? $id.','.$otype : $otype;
        	$map['a.user_id'] = array('in',$id);
        	$sea['otype'] = $otype;
        	$this->assign('user_id',$otype);
        }

        if($jingjiren) {

            $userarr  = array();
        	$ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {
            	array_push($userarr, $value['user_id']);
            }
            $user_id = implode(',',array_unique($userarr));
        	$map['a.user_id'] = array('in',$user_id);

        	$sea['jingjiren'] = $jingjiren;
        	$this->assign('jingjiren',$this->get_username($jingjiren));
        }

        if($userss){
            
            $uid = $userss; 
        	$map['a.user_id'] = array('in',$uid);
        	$sea['user'] = $userss;
        	$this->assign('use',$this->get_username($userss));
        }


        
        $FeeReceive =  M('FeeReceive a'); //流水表初始化
        $userinfo   =  M('userinfo');    // 用户表初始化
        $order      =  M('order');
        $bankinfo   =  M('bankinfo');
        
        $map['a.type'] = array('in','1,2,3');

        $count = $FeeReceive->join('left join wp_userinfo as b on a.user_id = b.uid')->where($map)->count();   //总数量
		$pagecount = 10;   //每页显示的数量
		$page = new \Think\Page($count, $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first', '首页');
		$page->setConfig('prev', '&#8249;');
		$page->setConfig('next', '&#8250;');
		$page->setConfig('last', '尾页');
		$page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
		$show = $page->show();
		
		$receive = $FeeReceive->join('left join wp_userinfo as b on a.user_id = b.uid')->where($map)->order('a.order_id desc')->limit($page->firstRow, $page->listRows)->select();

		$receiveArr  = array();
		$receiveArr2 = array();
		$receiveArr3 = array();
		foreach ($receive as $key => $value) {
		    array_push($receiveArr,$value['user_id']);
		    array_push($receiveArr2,$value['purchaser_id']);
		    array_push($receiveArr3,$value['order_id']);
		}
		$receiveId  = implode(',',array_unique($receiveArr));
		$receiveId2 = implode(',',array_unique($receiveArr2));
		$receiveId3 = implode(',',array_unique($receiveArr3));
		
		$info   = $userinfo->where('uid in('.$receiveId.')')->select();
		$info2  = $userinfo->where('uid in('.$receiveId2.')')->select();
        $info3  = $order->where('oid in('.$receiveId3.')')->select();
        $info4  = $bankinfo->where('uid in('.$receiveId2.')')->select();

        foreach ($info as &$value) {
        	switch ($value['otype']) {
        		case 4:
        			$value['type'] = '普通会员';
        			break;
        		case 5:
        			$value['type'] = '运营中心';
        			break;
        	}
        	$infoArr[$value['uid']] = $value;
        }

        foreach ($info2 as $key => $value) {
            $infoArr2[$value['uid']] = $value;
        }
        
        foreach ($info3 as $k => $v) {
        	$orderArr[$v['oid']] = $v;
        }
        
        foreach ($info4 as $key => $value) {
        	 $infoArr4[$v['uid']] = $value;
        }
         
        foreach ($receive as $key => $value) {
        	$receive[$key]['username']  = $infoArr[$value['user_id']]['username'];
        	$receive[$key]['utel']      = $infoArr[$value['user_id']]['utel'];
        	$receive[$key]['type']      = $infoArr[$value['user_id']]['type'];

        	$receive[$key]['pid']       = $orderArr[$value['order_id']]['pid'];

        	$receive[$key]['purchaser'] = !empty($infoArr4[$value['purchaser_id']]['busername']) ? $infoArr4[$value['purchaser_id']]['busername'] : $infoArr2[$value['purchaser_id']]['username'];
            
            if($value['type'] == 3)
            {
            	//计算运营中心
            	$user_rmb = $FeeReceive->where(array('a.order_id' => $value['order_id'],'a.type' => 1))->sum('profit_rmb');
            	$receive[$key]['profit_rmb'] = $value['profit_rmb'].'-'.$user_rmb.'='.($value['profit_rmb'] - $user_rmb);
            }

        }

    	$field = 'a.order_id,a.user_id,a.profit_rmb,a.type,a.status,b.uid';
        $count = $FeeReceive->field($field)->join('left join wp_userinfo as b on a.user_id = b.uid')->where($map)->select();
        foreach ($count as $key => $value) {
            if($value['type'] == 1)
            {
            	$account['user_rmb'] += $value['profit_rmb'];
            }

            if($value['type'] == 2)
            {
               $account['exchange_rmb'] += $value['profit_rmb'];
            }

            if($value['type'] == 3)
            {
               $user_rmb = $FeeReceive->where(array('a.order_id' => $value['order_id'],'a.type' => 1))->sum('profit_rmb');
               $account['operate_rmb'] += ($value['profit_rmb'] - $user_rmb);
            }

        	if($value['status'] == 1) {
               $account['count'] += count($value['status']);
            } 
            if($value['status'] == 2) {
                $account['count_stop'] += count($value['status']);
            }
        }

        $this->assign('user',$receive);
        $this->assign('page',$show);
        $this->assign('sea',$sea);
        $this->assign('account',$account);
        $this->assign('info',M('userinfo')->where(array('otype' => 5))->select());
	    $this->display();
  }

  public function daochu_ExtensionWater()
  { 
        $phone     = trim(I('get.phone'));    //手机号
        $status    = trim(I('get.status'));   //计算状态
        $user_type = trim(I('get.user_type')); //用户类型 
        $starttime = urldecode(trim(I('get.starttime')));
	    $endtime   = urldecode(trim(I('get.endtime')));  //结束时间
	    $otype     = trim(I('get.otype'));
        $jingjiren = trim(I('get.jingjiren'));
        $userss    = trim(I('get.user'));

        if($phone) {
        	$map['b.utel'] = array('like','%'.$phone.'%');
        	$sea['phone'] = $phone;
        }

        if($status) {
           $map['a.status'] = $status;
           $sea['status'] = $status;
        }

        if($user_type) {
           if($user_type == 3) {
              $map['a.user_id'] = 0;
           } else {
              $map['b.otype'] = $user_type;
           }
          $sea['user_type'] = $user_type;
        }


        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
        	$map['a.create_time'] = array('between',array($start_time,$end_time));
        } else {
			$start_time = strtotime(date('Y-m-d')." 06:00:00");
			$end_time = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
	      	$map['a.create_time'] = array('between',array($start_time,$end_time));
        }

        if($otype) {
            $userarr  = array();
            $userarr1 = array(); 
        	$ship = M("UserinfoRelationship")->where(array('parent_user_id' => $otype))->select();
            foreach ($ship as $key => $value) {
            	array_push($userarr, $value['user_id']);
            }
            $user_id = implode(',',array_unique($userarr));
  
        	$users = M("UserinfoRelationship")->where('parent_user_id  in('.$user_id.')')->select();

            foreach ($users as $key => $val) {
            	 
                array_push($userarr1,$val['user_id']);
            }
            $id = implode(',',array_unique($userarr1));
            $id = !empty($id) ? $id.','.$otype : $otype;
        	$map['a.user_id'] = array('in',$id);
        }

        if($jingjiren) {

            $userarr  = array();
        	$ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {
            	array_push($userarr, $value['user_id']);
            }
            $user_id = implode(',',array_unique($userarr));
        	$map['a.user_id'] = array('in',$user_id);
        }

        if($userss){
            
            $uid = $userss; 
        	$map['a.user_id'] = array('in',$uid);
        }
        
        $FeeReceive =  M('FeeReceive a'); //流水表初始化
        $userinfo   =  M('userinfo');    // 用户表初始化
        $order      =  M('order');
        $bankinfo   =  M('bankinfo');
        
        $map['a.type'] = array('in','1,2,3');
		
		$receive = $FeeReceive->join('left join wp_userinfo as b on a.user_id = b.uid')->where($map)->order('a.order_id desc')->select();

		$receiveArr  = array();
		$receiveArr2 = array();
		$receiveArr3 = array();
		foreach ($receive as $key => $value) {
		    array_push($receiveArr,$value['user_id']);
		    array_push($receiveArr2,$value['purchaser_id']);
		    array_push($receiveArr3,$value['order_id']);
		}
		$receiveId  = implode(',',array_unique($receiveArr));
		$receiveId2 = implode(',',array_unique($receiveArr2));
		$receiveId3 = implode(',',array_unique($receiveArr3));
		
		$info   = $userinfo->where('uid in('.$receiveId.')')->select();
		$info2  = $userinfo->where('uid in('.$receiveId2.')')->select();
        $info3  = $order->where('oid in('.$receiveId3.')')->select();
        $info4  = $bankinfo->where('uid in('.$receiveId2.')')->select();

        foreach ($info as &$value) {
        	switch ($value['otype']) {
        		case 4:
        			$value['type'] = '普通会员';
        			break;
        		case 5:
        			$value['type'] = '运营中心';
        			break;
        	}
        	$infoArr[$value['uid']] = $value;
        }

        foreach ($info2 as $key => $value) {
            $infoArr2[$value['uid']] = $value;
        }
        
        foreach ($info3 as $k => $v) {
        	$orderArr[$v['oid']] = $v;
        }
        
        foreach ($info4 as $key => $value) {
        	 $infoArr4[$v['uid']] = $value;
        }
         
        foreach ($receive as $key => $value) {
        	$receive[$key]['username']  = $infoArr[$value['user_id']]['username'];
        	$receive[$key]['utel']      = $infoArr[$value['user_id']]['utel'];
        	$receive[$key]['type']      = $infoArr[$value['user_id']]['type'];

        	$receive[$key]['pid']       = $orderArr[$value['order_id']]['pid'];

        	$receive[$key]['purchaser'] = !empty($infoArr4[$value['purchaser_id']]['busername']) ? $infoArr4[$value['purchaser_id']]['busername'] : $infoArr2[$value['purchaser_id']]['username'];
        	if($value['type'] == 3)
            {
            	//计算运营中心
            	$user_rmb = $FeeReceive->where(array('a.order_id' => $value['order_id'],'a.type' => 1))->sum('profit_rmb');
            	$receive[$key]['profit_rmb'] = $value['profit_rmb'].'-'.$user_rmb.'='.($value['profit_rmb'] - $user_rmb);
            }

        }
        
  	   	$data[0] = array('编号','用户','用户类型','手机号码','产品名称','状态','获得佣金','操作时间','购买人');
		foreach($receive as $k => $v){

			$option_name = M('option')->where(array('id' => $v['pid']))->getField('capital_name');


			$data[$k+1][] = $v['order_id'];

			$data[$k+1][] = !empty(getUsername($v['user_id'])) ? getUsername($v['user_id']) : '交易所';

			$data[$k+1][] = !empty($v['type']) ? $v['type'] : '交易所';
			$data[$k+1][] = !empty($v['utel']) ? $v['utel'] : '--';
			$data[$k+1][] = $option_name;
			if($v['status'] == 1) {
				$data[$k+1][] = '已结算';
			} else {
				$data[$k+1][] = '未结算';
			}
			$data[$k+1][] = $v['profit_rmb'];
			$data[$k+1][] = date('Y-m-d H:i:s',$v['create_time']);
			$data[$k+1][] = getUsername($v['purchaser_id']);
		}
		$name='佣金流水';      //生成的Excel文件文件名
		$res=$this->push($data,$name);
  }

  /**
  * 推广员列表
  * @author wang <admin>
  */
	public function ExtensionList(){

		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();

		if (I('get.phone')) {
			$map['a.utel'] = array('like', '%' . trim(I('get.phone')) . '%');
			$sea['phone']   = I('get.phone');
			$this->assign('phone', trim(I('get.phone')));
		}
		if (I('get.username')) {//查询用户名可能是银行账户姓名，可能是用户名
			$map['_complex']['a.username']=array('like', '%' . I('get.username') . '%');
			$map['_complex']['c.busername'] = array('like','%'.trim(I('get.username')).'%');
			$map['_complex']['_logic']='OR';
			$sea['username']   = I('get.username');
			$this->assign('username', trim(I('get.username')));
		}

        $otype = trim(I('get.otype'));
        $jingjiren = trim(I('get.jingjiren'));
        $userss = trim(I('get.user'));

        if($otype) {
            $userarr  = array();
            $userarr1 = array(); 
        	$ship = M("UserinfoRelationship")->where(array('parent_user_id' => $otype))->select();
            foreach ($ship as $key => $value) {
            	array_push($userarr, $value['user_id']);
            }
            $user_id = implode(',',array_unique($userarr));
  
        	$users = M("UserinfoRelationship")->where('parent_user_id  in('.$user_id.')')->select();

            foreach ($users as $key => $val) {
            	 
                array_push($userarr1,$val['user_id']);
            }
            $id = implode(',',array_unique($userarr1));

        	$map['a.uid'] = array('in',$id);
        	$username = M('userinfo')->where(array('uid'=> $otype))->find();
        	$sea['otype'] = $otype;
        	$this->assign('user_id',$username['uid']);
        }
        if($jingjiren) {
        	$userarr  = array();
            $userarr1 = array(); 
        	$ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {
            	
            	array_push($userarr, $value['user_id']);
            }
            $userid = implode(',',array_unique($userarr));

        	$map['a.uid'] = array('in',$userid);
        	$sea['jingjiren'] = $jingjiren;
        	$this->assign('jingjiren',$this->get_username($jingjiren));
        }

        if($userss != ''){
            
            $uid = $userss; 
        	$map['a.uid'] = array('in',$uid);
        	$sea['user'] = $userss;
        	$this->assign('use',$this->get_username($userss));
        }


		if (I('get.superior')) {
			$map['_complex']['a.username']=array('like', '%' . trim(I('get.superior')) . '%');
			$map['_complex']['c.busername'] = array('like','%'.trim(I('get.superior')).'%');
			$map['_complex']['_logic']='OR';
			// $field = 'a.*,b.busername';
   //          $userinfo = M('userinfo a')->field($field)->join('left join wp_bankinfo as b on a.uid = b.uid')->where($where)->select();
   //          $RidArr = array();
   //          foreach ($userinfo as $key => $value) {
   //          	array_push($RidArr,$value['uid']);
   //          }
   //          $map['a.rid'] = implode(',',$RidArr);
            $sea['superior'] = I('get.superior');
			$this->assign('superior', trim(I('get.superior')));
		}

        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));
        if($starttime && $endtime)
        {
        	$start_time = strtotime($starttime);
        	$end_time   = strtotime($endtime);
        	$map['a.utime'] = array('between',array($start_time,$end_time));
        	$sea['starttime'] = $starttime;
        	$sea['endtime']   = $endtime;
        }


		$map['a.code'] 	= array('neq', '');
		$map['a.otype'] = 4;
		$count = M("userinfo a")->where($map)->count();   //总数量

		$pagecount = 10;   //每页显示的数量
		$page = new \Think\Page($count, $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first', '首页');
		$page->setConfig('prev', '&#8249;');
		$page->setConfig('next', '&#8250;');
		$page->setConfig('last', '尾页');
		$page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
		$show = $page->show();
		$field = 'a.uid,c.busername,a.username,a.utel,b.money,a.rid,a.code,a.utime';
		$userobj = M('userinfo a');
		$user = $userobj->
			join('left join wp_bankinfo as c on a.uid = c.uid')->
			join('left join wp_extension as b  on a.uid = b.user_id')->
			field($field)->
			where($map)->
			limit($page->firstRow, $page->listRows)->
			order('a.utime desc')->
			select();
		$account = M('userinfo a')->join('left join wp_extension as b  on a.uid = b.user_id')->where($map)->sum('b.money');

		$this->assign('user', $user);
		$this->assign('page', $show);
		$this->assign('account', $account); //总佣金额
		$this->assign('info',M("userinfo")->where('otype=5')->select());
		$this->assign('sea',$sea);
		$this->display('ExtensionList');
	}

   
   public function daochu_extensionlist()
   {    
		if (I('get.phone')) {
			$map['a.utel'] = array('like', '%' . trim(I('get.phone')) . '%');
		}
		if (I('get.username')) {//查询用户名可能是银行账户姓名，可能是用户名
			$map['_complex']['a.username']=array('like', '%' . I('get.username') . '%');
			$map['_complex']['c.busername'] = array('like','%'.trim(I('get.username')).'%');
			$map['_complex']['_logic']='OR';
		}

        $otype = trim(I('get.otype'));
        $jingjiren = trim(I('get.jingjiren'));
        $userss = trim(I('get.user'));

        if($otype) {
            $userarr  = array();
            $userarr1 = array(); 
        	$ship = M("UserinfoRelationship")->where(array('parent_user_id' => $otype))->select();
            foreach ($ship as $key => $value) {
            	array_push($userarr, $value['user_id']);
            }
            $user_id = implode(',',array_unique($userarr));
  
        	$users = M("UserinfoRelationship")->where('parent_user_id  in('.$user_id.')')->select();

            foreach ($users as $key => $val) {
            	 
                array_push($userarr1,$val['user_id']);
            }
            $id = implode(',',array_unique($userarr1));

        	$map['a.uid'] = array('in',$id);
        	$username = M('userinfo')->where(array('uid'=> $otype))->find();
        }
        if($jingjiren) {
        	$userarr  = array();
            $userarr1 = array(); 
        	$ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {
            	
            	array_push($userarr, $value['user_id']);
            }
            $userid = implode(',',array_unique($userarr));

        	$map['a.uid'] = array('in',$userid);
        }

        if($userss != ''){
            
            $uid = $userss; 
        	$map['a.uid'] = array('in',$uid);
        	$sea['user'] = $userss;
        }


		if (I('get.superior')) {
			$map['_complex']['a.username']=array('like', '%' . trim(I('get.superior')) . '%');
			$map['_complex']['c.busername'] = array('like','%'.trim(I('get.superior')).'%');
			$map['_complex']['_logic']='OR';
			// $field = 'a.*,b.busername';
   //          $userinfo = M('userinfo a')->field($field)->join('left join wp_bankinfo as b on a.uid = b.uid')->where($where)->select();
   //          $RidArr = array();
   //          foreach ($userinfo as $key => $value) {
   //          	array_push($RidArr,$value['uid']);
   //          }
   //          $map['a.rid'] = implode(',',$RidArr);
		}

        $starttime = urldecode(trim(I('get.starttime')));
        $endtime   = urldecode(trim(I('get.endtime')));
        if($starttime && $endtime)
        {
        	$start_time = strtotime($starttime);
        	$end_time   = strtotime($endtime);
        	$map['a.utime'] = array('between',array($start_time,$end_time));
        }


		$map['a.code'] 	= array('neq', '');
		$map['a.otype'] = 4;

		$field = 'a.uid,c.busername,a.username,a.utel,b.money,a.rid,a.code,a.utime';
		$userobj = M('userinfo a');
		$user = $userobj->
			join('left join wp_bankinfo as c on a.uid = c.uid')->
			join('left join wp_extension as b  on a.uid = b.user_id')->
			field($field)->
			where($map)->
			order('a.utime desc')->
			select();

   	 	$data[0] = array('编号','用户名','手机号码','当前佣金','上级','推广码','注册日期');
		foreach($user as $k => $v){
			$username  = !empty($v['busername']) ? $v['busername'] : $v['username'];
			$uname     = M('userinfo')->where(array('uid' => $v['rid']))->getField('username');
			$busername = M('bankinfo')->where(array('uid' => $v['rid']))->getField('busername');
            $name      = !empty($busername) ? $busername : $uname;

			$data[$k+1][] = $v['uid'];
			$data[$k+1][] = $username;
			$data[$k+1][] = $v['utel'];
			$data[$k+1][] = empty($v['money']) ? '0.00' : $v['money'];
			$data[$k+1][] = empty($name) ? '无' : $name;
			$data[$k+1][] = $v['code'];
			$data[$k+1][] = date('Y-m-d H:i:s',$v['utime']);
		}
		$name='推广员列表';      //生成的Excel文件文件名
		$res=$this->push($data,$name);
   }

  /**
  * 推广员下级流水
  * @author wang <admin>
  */
   public function subordinate(){

        $user_id = trim(I('get.user_id'));
        $level   = trim(I('get.level'));
        $status  = trim(I('get.status'));
        $starttime = urldecode(trim(I('get.starttime')));
        $endtime = urldecode(trim(I('get.endtime')));

       if($starttime  && $endtime)
        {
        	$start_time = strtotime($starttime);
        	$end_time   = strtotime($endtime);
            $where = ' and a.create_time between '.$start_time.' and '.$end_time.'';
            $sea['starttime'] = $starttime;
            $sea['endtime'] = $endtime;
            $this->assign('sea',$sea);
        }


        $optionIdArr     = array();
        $optionIdArr_two = array();
		$userobj=M('userinfo');
        //一年有效期
        $userinfo = M()->query("select uid from wp_userinfo where UNIX_TIMESTAMP(NOW()) < utime+365*24*60*60 and rid = ".$user_id." ");
        foreach ($userinfo as $key => $value) {
        	 array_push($optionIdArr,$value['uid']);
        }

        $uid   = implode(',',array_unique($optionIdArr));

        $water  = M()->query("select a.*,b.*,c.*,d.id,d.capital_name from wp_fee_receive as a left join wp_userinfo as b on a.purchaser_id = b.uid left join wp_order as c on a.order_id = c.oid left join wp_option as d on c.pid = d.id where unix_timestamp(now()) < b.utime+365*24*60*60  and a.type = 1  and a.purchaser_id in(".$uid.") and a.user_id = ".$user_id." ".$where."");

        foreach ($water as $key => $val) {
          
              $aa[$key]['lavel']        = '一级';
              $aa[$key]['id']           = $val['id'];
              $aa[$key]['purchaser_id'] = $val['purchaser_id'];
              $aa[$key]['username']     = $val['username'];
              $aa[$key]['profit_rmb']   = $val['profit_rmb'];  //一级
              $aa[$key]['create_time']  = date("Y-m-d H:i:s",$val['create_time']);
              $aa[$key]['status']       = $val['status'];
              $aa[$key]['fee_rmb']      = $val['fee_rmb'];  //手续费
              $aa[$key]['onumber']      = $val['onumber'].'手';
              $aa[$key]['capital_name'] = $val['capital_name'];
        }

         //二级
        $user_two = M()->query("select * from wp_userinfo where UNIX_TIMESTAMP(NOW()) < utime+365*24*60*60 and rid in(".$uid.")");
	       foreach ($user_two as $value) {
	           
	           array_push($optionIdArr_two,$value['uid']);
	       }
       
        $water_two = implode(',',array_unique($optionIdArr_two));
        $two = M()->query("select a.*,b.*,c.*,d.id,d.capital_name from wp_fee_receive as a left join wp_userinfo as b on a.purchaser_id = b.uid left join wp_order as c on a.order_id = c.oid left join wp_option as d on c.pid = d.id where unix_timestamp(now()) < b.utime+365*24*60*60  and a.type = 1 and a.purchaser_id in(".$water_two.") and a.user_id = ".$user_id." ".$where."");
        foreach ($two as $key => $value) {

              $bb[$key]['lavel']        = '二级';
              $bb[$key]['id']           = $value['id'];
              $bb[$key]['purchaser_id'] = $value['purchaser_id'];
              $bb[$key]['username']     = $value['username'];
              $bb[$key]['profit_rmb']   = $value['profit_rmb'];
              $bb[$key]['create_time']  = date("Y-m-d H:i:s",$value['create_time']);
              $bb[$key]['status']       = $value['status'];
              $bb[$key]['fee_rmb']      = $value['fee_rmb'];   //手续费
              $bb[$key]['onumber']      = $value['onumber'].'手';
              $bb[$key]['capital_name'] = $value['capital_name'];
         }

        $a = count($aa) >= count($bb) ? $aa : $bb;
       // $a = !empty($bb[0]['lavel']) ? $bb : $aa;
        foreach ($a as $kkk => $vvv) {
             switch ($level) {
             	case 1:
             		 $user[] = $aa[$kkk];
             		break;
             	case 2:
             		 $user[] = $bb[$kkk];
             		break;
             	default:
             	    $user[] = $aa[$kkk];
             		$user[] = $bb[$kkk];
             		break;
             }
            
         }
   
   

        $user = array_filter($user);
        $arr = array();
        foreach ($user as $key => $value) {
               if(empty($status)) {
                   $users[] = $value;
               } else {
                   if($value['status'] == $status)
	               {
	               	 $users[] = $value;
	               }
               }
            array_push($arr,$value['username']);
        }
//        echo implode(',',array_unique($arr));


        $datetime = array();
        foreach ($users as $v) {
			$datetime[] = $v['create_time'];
			$currency   += $v['fee_rmb'];      //总手续费
			$profit_rmb += $v['profit_rmb'];  //总佣金
		}
        array_multisort($datetime,SORT_DESC,$users);
        $users = $this->array_page($users,10);


        $this->assign('user',$users);
        $this->assign('currency',$currency);  
        $this->assign('profit_rmb',$profit_rmb);
        $this->assign('level',$level);
        $this->assign('status',$status);
        $this->assign('username',M('userinfo')->field('username,uid')->where(array('uid' => $user_id))->find());
        $this->display();
   }

  /**
   * 下级推广员
   * @author wang <admin>
   */
   public function lowerlevel()
   {
   	    $userinfo = M('userinfo a');

        $user_id  = trim(I('get.user_id'));
        $level    = trim(I('get.level'));
        $username = trim(I('get.username'));
        $starttime = urldecode(trim(I('get.starttime')));
        $endtime = urldecode(trim(I('get.endtime')));

        $optionIdArr = array();

        if(!empty($username))
        {   if($level == 1) 
        	{
				$one_map['_complex']['a.username']  = array('like', '%' .$username. '%');
				$one_map['_complex']['b.busername'] = array('like','%'.$username.'%');
				$one_map['_complex']['_logic']='OR';
        	} else if($level == 2)
        	{
        		$two_map['_complex']['a.username']  = array('like', '%' .$username. '%');
				$two_map['_complex']['b.busername'] = array('like','%'.$username.'%');
				$two_map['_complex']['_logic']='OR';
        	} else {
        		$one_map['_complex']['a.username']  = array('like', '%' .$username. '%');
				$one_map['_complex']['b.busername'] = array('like','%'.$username.'%');
				$one_map['_complex']['_logic']='OR';
				$two_map['_complex']['a.username']  = array('like', '%' .$username. '%');
				$two_map['_complex']['b.busername'] = array('like','%'.$username.'%');
				$two_map['_complex']['_logic']='OR';
        	}
        	$this->assign('username',$username);
        }

        if($starttime  && $endtime)
        {
        	$start_time = strtotime($starttime);
        	$end_time   = strtotime($endtime);
            $one_map['a.utime'] = array('between',array($start_time,$end_time));
            $two_map['a.utime'] = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime'] = $endtime;
            $this->assign('sea',$sea);
        }


        $field = 'a.*,b.busername';

        $one_map['a.rid'] = $user_id;
        $one_level = $userinfo->field($field)->join('left join wp_bankinfo as b on a.uid = b.uid')->where($one_map)->select();
        foreach ($one_level as $key => $val) {
        	 $one[$key]['lavel']         = '一级';
             $one[$key]['uid']           = $val['uid'];
             $one[$key]['utel']          = $val['utel'];
             $one[$key]['utime']         = date("Y-m-d H:i:s",$val['utime']);
             $one[$key]['lastlog']       = !empty($val['lastlog'])  ? date("Y-m-d H:i:s",$val['lastlog']) : '尚未登陆';
             $one[$key]['last_login_ip'] = !empty($val['last_login_ip'])  ? $val['last_login_ip'] : '尚未登陆';
             $one[$key]['rid']           = $val['rid'];
        }


        $one_null = $userinfo->where(array('rid' => $user_id))->select();
        foreach ($one_null as $key => $val) {
        	 array_push($optionIdArr,$val['uid']);
        }

        $uid   = implode(',',array_unique($optionIdArr));
        if(!empty($uid)) {
            $two_map['a.rid'] = array('in',$uid);
            $two_level = $userinfo->field($field)->join('left join wp_bankinfo as b on a.uid = b.uid')->where($two_map)->select();
        }
        
        // echo M()->getLastSql();

        foreach ($two_level as $key => $value) {

        	 $two[$key]['lavel']         = '二级';
             $two[$key]['uid']           = $value['uid'];
             $two[$key]['utel']          = $value['utel'];
             $two[$key]['utime']         = date("Y-m-d H:i:s",$value['utime']);
             $two[$key]['lastlog']       = !empty($value['lastlog']) ? date("Y-m-d H:i:s",$value['lastlog']) : '尚未登陆';
             $two[$key]['last_login_ip'] = !empty($value['last_login_ip']) ? $value['last_login_ip'] : '尚未登陆';
             $two[$key]['rid'] = $value['rid'];
        }        
        
        $type = isset($one) ? $one : $two;
        foreach ($type as $k => $v) {
            switch ($level) {
             	case 1:
             		 $user[] = $one[$k];
             		break;
             	case 2:
             		 $user[] = $two[$k];
             		break;
             	default:
             	    $user[] = $one[$k];
             		$user[] = $two[$k];
             		break;
             }
        }


        $user = array_filter($user);
        $datetime = array();
        foreach ($user as $v) {
			$datetime[] = $v['utime'];
			if($v['lavel'] == '一级') {
				$count['one'] += count($v['lavel']);
			} 
			if($v['lavel'] == '二级') {
				$count['two'] += count($v['lavel']);
			}
			$count['count'] += count($v['lavel']);
		}
		array_multisort($datetime,SORT_DESC,$user);
		$user = $this->array_page($user,10);
        $this->assign('user',$user);
        $this->assign('user_id',$user_id);
        $this->assign('level',$level);

        $this->assign('count',$count);
        $this->display();
   }

  /**
   * 数组分页
   * @author wang <admin>
   */
   public function array_page($array,$rows){

        $count=count($array);
        $Page = new \Think\Page($count, $rows);
       // $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $Page->setConfig('first', '首页');
	    $Page->setConfig('prev', '&#8249;');
	    $Page->setConfig('next', '&#8250;');
	    $Page->setConfig('last', '尾页');
	    $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $Page->show();

        $list=array_slice($array,$Page->firstRow,$Page->listRows);
        $this->assign('page',$show);
        return $list;
}

 
 /**
  * 资金流水
  * @author wang <admin>
  */
 
 public function money_flow(){

		//判断用户是否登陆
	   $user= A('Admin/User');
	   $user->checklogin();

       $MoneyFlow            = M('MoneyFlow');
       $userinfo             = M('userinfo');
       $UserinfoRelationship = M('UserinfoRelationship');
       $bankinfo             = M('bankinfo');

       $utel      = trim(I('get.utel'));
       $type      = trim(I('get.type'));
       $yunying   = trim(I('get.yunying'));
       $jingjiren = trim(I('get.jingjiren'));
       $user      = trim(I('get.user'));
       $starttime = urldecode(trim(I('get.starttime')));
       $endtime   = urldecode(trim(I('get.endtime')));
       $operator  = trim(I('get.operator'));  //操作人


       if($utel) {
       	  $searchArr = array();
          $where['utel'] = array('like','%'.$utel.'%');
       	  $info = $userinfo->where($where)->select();
          foreach ($info as $key => $value) {
          	  array_push($searchArr,$value['uid']);
          }
          $searchId = implode(',',array_unique($searchArr));
          $map['uid'] = array('in',$searchId);
          $sea['utel'] = $utel;
       } 

       if($type) {
            $map['type'] = $type;
            $sea['type'] = $type;
       }

       if($operator) {
       	    $map['op_id'] = $operator;
       	    $this->assign('op_id',$operator);
            $sea['operator'] = $operator;
       }

        if($yunying) {

        	$relation = $UserinfoRelationship->where(array('parent_user_id' => $yunying))->select();
        	$relationArr = array();
        	$relationArr1 = array();
        	foreach ($relation as $key => $value) {
        		 array_push($relationArr,$value['user_id']);
        	}
        	$relationId = implode(',',array_unique($relationArr));
        	$users = $UserinfoRelationship->where('parent_user_id in('.$relationId.')')->select();
            foreach ($users as $key => $value) {
            	 array_push($relationArr1,$value['user_id']);
            }
            $userId = implode(',',array_unique($relationArr1));
            $map['uid'] = array('in',$userId);
            $sea['yunying'] = $yunying;
        }

        if($jingjiren) {
            $relationArr2 = array();
        	$jingjiren_user = $UserinfoRelationship->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
            	 array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['uid'] = array('in',$userId1);
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren',$this->get_username($jingjiren));
        }
        
        if($user) {
            $map['uid'] = $user;
            $sea['user'] = $user;
            $this->assign('user',$this->get_username($user));
        }

        if($starttime && $endtime) {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $map['dateline'] = array('between',''.$start_time.','.$end_time.'');
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        } else {
			$start_time = strtotime(date('Y-m-d')." 06:00:00");
			$end_time = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
	      	$map['dateline'] = array('between',''.$start_time.','.$end_time.'');
	      	$sea['starttime'] = date('Y-m-d H:i:s',$start_time);
	      	$sea['endtime']   = date('Y-m-d H:i:s',$end_time);
        }

       $map['user_type'] = array('neq',2);

       $count = $MoneyFlow->where($map)->count();   //总数量
	   $pagecount = 15;   //每页显示的数量
	   $page = new \Think\Page($count, $pagecount);
	   $page->parameter = $sea; //此处的row是数组，为了传递查询条件
	   $page->setConfig('first', '首页');
	   $page->setConfig('prev', '&#8249;');
	   $page->setConfig('next', '&#8250;');
	   $page->setConfig('last', '尾页');
	   $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
	   $show = $page->show();
       $Flow = $MoneyFlow->where($map)->order('dateline  desc')->limit($page->firstRow, $page->listRows)->select();
       $Flow_money = $MoneyFlow->field('note')->where($map)->order('dateline  desc')->select();
       $flowArr = array();
       $flowArr2 = array();
       foreach ($Flow as $key => $value) {
       	  array_push($flowArr,$value['uid']);
       	  array_push($flowArr2,$value['op_id']);
       }
       $flowId  = implode(',',array_unique($flowArr));
       $flowId1 = implode(',',array_unique($flowArr2));
       
       $info = $userinfo->field('uid,username,utel')->where('uid in('.$flowId.')')->select();
       $infoArr = array();
       foreach ($info as $key => $value) {
       	  $infoArr[$value['uid']] = $value;
       }

       $info1 = $userinfo->field('username,uid')->where('uid in('.$flowId1.')')->select();
       $infoArr1 = array();
       foreach ($info1 as $key => $value) {
       	  $infoArr1[$value['uid']] = $value;
       }

       $bank = $bankinfo->field('uid,busername')->where('uid in('.$flowId.')')->select();
       $infoArr2 = array();
       foreach ($bank as $key => $value) {
       	    $infoArr2[$value['uid']] = $value;
       }

       $bank1 = $bankinfo->field('uid.busername')->where('uid in('.$flowId1.')')->select();
       $infoArr3 = array();
       foreach ($bank1 as $key => $value) {
       	    $infoArr3[$value['uid']] = $value;
       }

       foreach ($Flow as $key => $value) {

       	   $Flow[$key]['busername']     = $infoArr2[$value['uid']]['busername'];
       	   $Flow[$key]['username']      = $infoArr[$value['uid']]['username'];
       	   $Flow[$key]['utel']          = $infoArr[$value['uid']]['utel'];

       	   $Flow[$key]['account']       = substr($value['note'],strrpos($value['note'],'[')+1);
           $Flow[$key]['account']       = preg_replace("/]元/", "",$Flow[$key]['account']);

           $Flow[$key]['operator']      = $infoArr1[$value['op_id']]['username'];
           $Flow[$key]['operator_name'] = $infoArr3[$value['op_id']]['busername'];
       }

       //无分页
       foreach ($Flow_money as $key => $value) {
       	   $Flow_money[$key]['account']  = substr($value['note'],strrpos($value['note'],'[')+1);
           $Flow_money[$key]['account']  = preg_replace("/]元/", "",$Flow_money[$key]['account']);
           $money += $Flow_money[$key]['account'];
       }

       $this->assign('flow',$Flow);
       $this->assign('page',$show);
       $this->assign('sea',$sea);
       $this->assign('yunying',$userinfo->field('username,uid')->where('otype=5')->select());
       $this->assign('money',$money);
       $this->assign('info',$userinfo->field('uid,username')->where(array('otype' =>3))->select());
       $this->display();
 }

   public function daochu_moneyFlow() 
   {

       $MoneyFlow            = M('MoneyFlow');
       $userinfo             = M('userinfo');
       $UserinfoRelationship = M('UserinfoRelationship');
       $bankinfo             = M('bankinfo');

       $utel      = trim(I('get.utel'));
       $type      = trim(I('get.type'));
       $yunying   = trim(I('get.yunying'));
       $jingjiren = trim(I('get.jingjiren'));
       $user      = trim(I('get.user'));
       $starttime = urldecode(trim(I('get.starttime')));
       $endtime   = urldecode(trim(I('get.endtime')));
       $operator  = trim(I('get.operator'));  //操作人


       if($utel) {
       	  $searchArr = array();
          $where['utel'] = array('like','%'.$utel.'%');
       	  $info = $userinfo->where($where)->select();
          foreach ($info as $key => $value) {
          	  array_push($searchArr,$value['uid']);
          }
          $searchId = implode(',',array_unique($searchArr));
          $map['uid'] = array('in',$searchId);
       } 

       if($type) {
            $map['type'] = $type;
       }

       if($operator) {
       	    $map['op_id'] = $operator;
       }

        if($yunying) {

        	$relation = $UserinfoRelationship->where(array('parent_user_id' => $yunying))->select();
        	$relationArr = array();
        	$relationArr1 = array();
        	foreach ($relation as $key => $value) {
        		 array_push($relationArr,$value['user_id']);
        	}
        	$relationId = implode(',',array_unique($relationArr));
        	$users = $UserinfoRelationship->where('parent_user_id in('.$relationId.')')->select();
            foreach ($users as $key => $value) {
            	 array_push($relationArr1,$value['user_id']);
            }
            $userId = implode(',',array_unique($relationArr1));
            $map['uid'] = array('in',$userId);
        }

        if($jingjiren) {
            $relationArr2 = array();
        	$jingjiren_user = $UserinfoRelationship->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
            	 array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['uid'] = array('in',$userId1);
        }
        
        if($user) {
            $map['uid'] = $user;
        }

    	if($starttime && $endtime) {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $map['dateline'] = array('between',''.$start_time.','.$end_time.'');
        } else {
			$start_time = strtotime(date('Y-m-d')." 06:00:00");
			$end_time = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
	      	$map['dateline'] = array('between',''.$start_time.','.$end_time.'');
        }

       $map['user_type'] = array('neq',2);

       $Flow = $MoneyFlow->where($map)->order('dateline  desc')->select();
       $flowArr = array();
       $flowArr2 = array();
       foreach ($Flow as $key => $value) {
       	  array_push($flowArr,$value['uid']);
       	  array_push($flowArr2,$value['op_id']);
       }
       $flowId  = implode(',',array_unique($flowArr));
       $flowId1 = implode(',',array_unique($flowArr2));
       
       $info = $userinfo->field('uid,username,utel')->where('uid in('.$flowId.')')->select();
       $infoArr = array();
       foreach ($info as $key => $value) {
       	  $infoArr[$value['uid']] = $value;
       }

       $info1 = $userinfo->field('username,uid')->where('uid in('.$flowId1.')')->select();
       $infoArr1 = array();
       foreach ($info1 as $key => $value) {
       	  $infoArr1[$value['uid']] = $value;
       }

       $bank = $bankinfo->field('uid,busername')->where('uid in('.$flowId.')')->select();
       $infoArr2 = array();
       foreach ($bank as $key => $value) {
       	    $infoArr2[$value['uid']] = $value;
       }

       $bank1 = $bankinfo->field('uid.busername')->where('uid in('.$flowId1.')')->select();
       $infoArr3 = array();
       foreach ($bank1 as $key => $value) {
       	    $infoArr3[$value['uid']] = $value;
       }

       foreach ($Flow as $key => $value) {
       	   
       	   $Flow[$key]['username']      = $infoArr[$value['uid']]['username'];
       	   $Flow[$key]['busername']     = $infoArr2[$value['uid']]['busername'];
       	   $Flow[$key]['utel']          = $infoArr[$value['uid']]['utel'];

       	   $Flow[$key]['account']       = substr($value['note'],strrpos($value['note'],'[')+1);
           $Flow[$key]['account']       = preg_replace("/]元/", "",$Flow[$key]['account']);

           $Flow[$key]['operator']      = $infoArr1[$value['op_id']]['username'];
           $Flow[$key]['operator_name'] = $infoArr3[$value['op_id']]['busername'];

       }

		$data[0] = array('编号','用户名','手机号码','资金变动描述','变动金额','操作人','操作时间');
		foreach($Flow as $k => $v){
			$username = !empty($v['busername']) ? $v['busername'] : $v['username'];
			$operator_name = !empty($v['operator_name']) ? $v['operator_name'] : $v['operator'];
			$data[$k+1][] = $v['id'];
			$data[$k+1][] = $username;
			$data[$k+1][] = $v['utel'];
			$data[$k+1][] = $v['note'];
			$data[$k+1][] = number_format($v['account'],2);
			$data[$k+1][] = $operator_name;
			$data[$k+1][] = date('Y-m-d H:i:s',$v['dateline']);
		}
		$name='资金流水记录';      //生成的Excel文件文件名
		$res=$this->push($data,$name);
   }

   	private function get_username($uid = 0) {
         
		 $info = M("userinfo a")->field('a.uid,a.username,b.busername')->join('left join wp_bankinfo as b on a.uid = b.uid')->where(array('a.uid'=> $uid))->find();

         $info['username'] = !empty($info['busername']) ? $info['busername'] : $info['username'];

		 return $info ? $info : null;
	}


    public function online_user(){

        $user= A('Admin/User');
        $user->checklogin();

        $set = array (
            'host'        =>  '127.0.0.1',
            'port'        => 11211,
            'timeout'     => false,
            'persistent'  =>  false,
        );
        $cache = \Think\Cache::getInstance("memcache", $set);
        $users = $cache->get("online_user");


        $loginUser = $guestUser = array();
        foreach($users as $ssid=>$user){

            if($user['lasttime'] < time()-180){//3分钟内的才算在线
                unset($users[$ssid]);
            }else if($user['user_id'] > 0){
                $loginUser[] = $user;
            }else{
                $guestUser[] = $user;
            }
        }

        $cache->set("online_user",$users);  //更新memcache

        $this->assign('loginUser',$loginUser);
        $this->assign('guestUser',$guestUser);
        $this->display();
    }

	/**
	*	客户交易冻结
	*	@author wang
	**/
	public function frozen()
	{
		$uid 	= trim(I('get.uid'));

		$trade_frozen = trim(I('get.trade_frozen'));

		if(empty($uid) || !isset($trade_frozen))
		{
			$this->error('用户编号不存在');
		}

		$userinfoObj = M('userinfo');

		$res = $userinfoObj->where(array('uid' => $uid))->setField('trade_frozen',$trade_frozen);
		if($res){

			$this->success("操作成功！");

		}else{

			$this->error('操作失败！');
		}
	}
}