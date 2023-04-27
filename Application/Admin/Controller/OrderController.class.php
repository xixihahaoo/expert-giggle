<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class OrderController extends BaseController {
    public function ocontent()
	{
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		$order = D('order');
		$users = D('userinfo');
		$binfo = D('bankinfo');
		$pinfo = D('productinfo');
		$manager = D('managerinfo');
		$account = D('accountinfo');
		//获取订单id
		$oid = I('get.oid');
		//查询订单数据基本信息
		$oinfo = $order->where('oid='.$oid)->find();
		//客户信息
		$uinfo = $users->where('uid='.$oinfo['uid'])->find();
		//商品信息
		$goods = $pinfo->where('pid='.$oinfo['pid'])->find();
		//银行卡信息
		$bank = $binfo->where('uid='.$oinfo['uid'])->field('bnkmber')->find();
		//身份证信息
		$mger = $manager->where('uid='.$oinfo['uid'])->field('mname,brokerid')->find();
		//用户账户信息
		$acount = $account->where('uid='.$oinfo['uid'])->field('balance')->find();

		$this->assign('oinfo',$oinfo);
		$this->assign('uinfo',$uinfo);
		$this->assign('goods',$goods);
		$this->assign('bank',$bank);
		$this->assign('mger',$mger);
		$this->assign('acount',$acount);
		$this->display();
	}
	public function olist(){
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();

		$tq=C('DB_PREFIX');
		$order = D('order');
		$pinfo = D('productinfo');
		$step = I('get.step');
		//重命名数据库字段名，以免多表查询字段重复
		$liestr = $tq.'order.uid as uid,'.$tq.'order.selltime as selltime,'.$tq.'userinfo.username as username,'.$tq.'order.buytime as buytime,'.$tq.'order.ptitle as ptitle,'.$tq.'order.commission as commission,'.$tq.'order.oid as oid,'.$tq.'order.ploss as ploss,'.$tq.'order.onumber as onumber,'.$tq.'order.ostyle as ostyle,'.$tq.'order.ostaus as ostaus,'.$tq.'order.fee as fee,'.$tq.'order.pid as pid,'.$tq.'order.buyprice as buyprice,'.$tq.'order.sellprice as sellprice,'.$tq.'order.orderno as orderno,'.$tq.'accountinfo.balance as balance,'.$tq.'productinfo.cid as cid,'.$tq.'productinfo.wave as wave';
		//die;
		if($step == "search"){

			//获取订单号，生产模糊条件
			$orderno = I('post.orderno');
			//获取用户名，生产模糊条件
			$username = I('post.username');
			//获取订单时间
			$buytime = I('post.buytime');
			//获取订单类型
			$ostyle = I('post.ostyle');
			//获取订单盈亏
			$ploss = I('post.ploss');
			//获取订单状态
			$ostaus = I('post.ostaus');
			if($orderno){
				$where['orderno'] = array('like','%'.I('post.orderno').'%');
			}
			if($username){
				$where['username'] = array('like','%'.I('post.username').'%');
			}
			if($buytime){
				$today = date("Y-m-d",strtotime($buytime));
				$today = explode('-', $today);
				$begintime = mktime(0,0,0,$today[1],$today[2],$today[0]);
				$endtime = mktime(23,59,59,$today[1],$today[2],$today[0]);
				$where['buytime'] = array('between',array($begintime,$endtime));
			}
			if($ostyle!=""){
				$where['ostyle'] = $ostyle;
			}
			if($ploss=='0'){
				$where['ploss'] = array('egt','0');
			}else if($ploss=='1'){
				$where['ploss'] = array('lt','0');
			}
			if($ostaus!=""){
				$where['ostaus'] = $ostaus;
			}
//			$this->ajaxReturn($ploss);

			$orders = $order->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'accountinfo.uid='.$tq.'userinfo.uid','left')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid','left')->field($liestr)->order($tq.'order.oid desc')->where($where)->select();
			//$this->ajaxReturn($order->getLastSql());
			foreach($orders as $k => $v){
				$orders[$k]['buytime'] = date("Y-m-d H:m",$orders[$k]['buytime']);
			}
			if($orders){
				$this->ajaxReturn($orders);
			}else{
				$this->ajaxReturn("null");
			}

		}else{
			//分页
			$count = $order->count();
	        $pagecount = 15;
	        $page = new \Think\Page($count , $pagecount);
	        $page->parameter = $row; //此处的row是数组，为了传递查询条件
	        $page->setConfig('first','首页');
	        $page->setConfig('prev','&#8249;');
	        $page->setConfig('next','&#8250;');
	        $page->setConfig('last','尾页');
	        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
	        $show = $page->show();
			//订单列表
			$orders = $order->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'accountinfo.uid='.$tq.'userinfo.uid','left')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid','left')->field($liestr)->order($tq.'order.oid desc')->limit($page->firstRow.','.$page->listRows)->select();
			//今日统计
			$today = date("Y-m-d",time());
			$today = explode('-', $today);
			$begintime = mktime(0,0,0,$today[1],$today[2],$today[0]);
			$endtime = mktime(23,59,59,$today[1],$today[2],$today[0]);
			$where['buytime'] = array('between',array($begintime,$endtime));
			$statis = $order->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')->field('onumber,uprice,ploss')->where($where)->select();
			foreach($statis as $k => $v){
				$total = $v['onumber']*$v['uprice'];
				$totals += $total;
				$number = $v['onumber'];
				$num += $number;
				$ploss = $v['ploss'];
				$tploss += $ploss;
			}
			//echo $v['onumber']*$v[''];
			$this->assign('totals',$totals);
			$this->assign('tploss',$tploss);
			$this->assign('num',$num);
			$this->assign('page',$show);
			$this->assign('orders',$orders);
		}
		//统计
		//$today=strtotime(date('Y-m-d 00:00:00'));
		//create_time
		$this->display();
	}


	public function tlist(){


		// $sql = "SELECT oid FROM wp_journal WHERE `type` = 2 GROUP BY oid HAVING COUNT(oid) > 2";
		// $result = M()->query($sql);
		// $oidARr = array();
		// foreach ($result as $key => $value) {
		// 	array_push($oidARr, $value['oid']);
		// }
		// echo implode(',', $oidARr);








		$type    = '1';
		//判断用户是否登陆
		$user = A('Admin/User');
		$user->checklogin();

		$tq		 = C('DB_PREFIX');
		$journal = D('journal');
		$user 	 = D('userinfo');

		$where 	 	= "";
		$orderno 	=  trim(I('get.orderno'));
		$username 	= trim(I('get.username'));
		$starttime 	= urldecode(trim(I('get.starttime')));
		$endtime 	= urldecode(trim(I('get.endtime')));
		$ostyle 	= trim(I('get.ostyle'));
		$ploss 		= trim(I('get.ploss'));
		$ostaus 	= trim(I('get.ostaus'));
		$datetype 	= intval(I('get.datetype'));
		$oid 		= trim(I('get.oid'));

		if($oid)
		{
			$oids = getDownuids($oid);
			$where['uid'] = array("in",implode(',',$oids));
			$sea['oid'] = $oid;
		}
		if($orderno){
			$where['jno'] = $orderno;
		}

		//手机号查找
		if($username){
			$where['jusername'] = $username;
			$sea['username'] 	= $username;
		}

        //日期查找
		if($starttime && $endtime){
			$start_time  	  = strtotime($starttime);
			$end_time 		  = strtotime($endtime);
			$where['jtime']	  = array('between',''.$start_time.','.$end_time.'');
			$sea['starttime'] = $starttime;
			$sea['endtime']   = $endtime;
		}

		if($ostyle!=""){
			$where['jostyle'] = array("eq",$ostyle);
			$sea['ostyle'] = $ostyle;
		}

		if($ploss=='0'){
			$where['jploss'] = array("gt",0);
			$sea['ploss'] = 0;
		}else if($ploss=='1'){
			$where['jploss'] = array("lt",0);
			$sea['ploss'] = 1;
		}
		if($ostaus!=""){
			if($ostaus == '4')
			{
				$where['jtype'] = '建仓';
				$sea['ostaus'] = 4;
			}
			if($ostaus == '1')
			{
				$where['jtype'] = '平仓';
				$sea['ostaus'] = 1;
			}
		}
		
		 $otype7     = trim(I('get.otype7'));
         $otype     = trim(I('get.otype'));
         $jingjiren = trim(I('get.jingjiren'));
         $userss    = trim(I('get.user'));
         $option    = trim(I('get.option'));

        //特别运营中心和运营中心筛选
         if($otype7 != ''){
         
         	$userarr  = array();
         	$userarr1 = array();
         	$userarr2 = array();
         
         	$ship = M("UserinfoRelationship")->field('user_id')->where(array('parent_user_id' => $otype7))->select();
         	foreach ($ship as $key => $value) {
         		array_push($userarr, $value['user_id']);
         	}
         	$p_user_id = implode(',',array_unique($userarr));
         
         	$users = M("UserinfoRelationship")->field('user_id')->where('parent_user_id  in('.$p_user_id.')')->select();
         	foreach ($users as $key => $value) {
         		array_push($userarr1, $value['user_id']);
         	}
         	$user_id = implode(',',array_unique($userarr1));
         	
         	$users1 = M("UserinfoRelationship")->field('user_id')->where('parent_user_id  in('.$user_id.')')->select();
         	foreach ($users1 as $key => $val) {
         
         		array_push($userarr2,$val['user_id']);
         	}
         	$id = implode(',',array_unique($userarr2));
         
         	$where['uid'] = array('in',$id);
         	$sea['otype7'] = $otype7;
         	$this->assign('parent_user_id',$otype7);
         
         }
         
        if($otype != ''){

            $userarr  = array();
            $userarr1 = array();
            
        	$ship = M("UserinfoRelationship")->field('user_id')->where(array('parent_user_id' => $otype))->select();
            foreach ($ship as $key => $value) {
            	array_push($userarr, $value['user_id']);
            }
            $user_id = implode(',',array_unique($userarr));

        	$users = M("UserinfoRelationship")->field('user_id')->where('parent_user_id  in('.$user_id.')')->select();

            foreach ($users as $key => $val) {

                array_push($userarr1,$val['user_id']);
            }
            $id = implode(',',array_unique($userarr1));

        	$where['uid'] = array('in',$id);
        	$sea['otype'] = $otype;
        	$this->assign('user_id',$otype);
        	 
        }

        //经纪人筛选
        if($jingjiren != ''){

            $userarr  = array();
            $userarr1 = array();
        	$ship = M("UserinfoRelationship")->field('user_id')->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {

            	array_push($userarr, $value['user_id']);
            }
            $id = implode(',',array_unique($userarr));

        	$where['uid'] = array('in',$id);
        	$sea['jingjiren'] = $jingjiren;
        	$this->assign('jingjiren',$this->get_username($jingjiren));
        }

        //用户筛选
        if($userss != ''){

            $id = $userss;
        	$where['uid'] = array('in',$id);
        	$sea['user'] = $userss;
        	$this->assign('user',$this->get_username($userss));
        }

        if($option) {
           $where['remarks'] = $option;
           $sea['option'] 	 = $option;
           $this->assign('op_name',$option);
        }

		//昨天
		$this->assign("starttimeYesterday", date('Y-m-d 06:00:00',strtotime('-1 day')));
		$this->assign("endtimeYesterday", date('Y-m-d 05:00:00'));
		//今天
//		$this->assign("starttimeToday", date('Y-m-d 06:00:00'));
//		$this->assign("endtimeToday", date('Y-m-d 05:00:00',strtotime('+1 day')));
		//本周
		$this->assign("starttimeWeek", date('Y-m-d 06:00:00',strtotime('-1 monday')));
		$this->assign("endtimeWeek", date('Y-m-d 05:00:00',strtotime('+1 day')));
		//上周
		$this->assign("starttimeLastWeek", date('Y-m-d 06:00:00',strtotime('-2 monday')));
		$this->assign("endtimeLastWeek", date('Y-m-d 05:00:00',strtotime('-1 monday')));
		//上月
		$this->assign("starttimeLastMonth", date('Y-m-01 06:00:00',strtotime('-1 month')));
		$this->assign("endtimeLastMonth", date('Y-m-d H:i:s',strtotime(date('Y-m-t 05:00:00',strtotime('-1 month')))+ 3600*24));


		if($datetype > 0){
			$sea['datetype'] = $datetype;
			$this->assign("datetype", $datetype);
		}

		$where['type'] = $type;       //区分真实和模拟交易

		if(count($where) == 1){  //只有一个条件表示是默认列表
			$starttime = strtotime(date('Y-m-d')." 06:00:00");
			$endtime = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
			$where['jtime']	  = array('between',''.$starttime.','.$endtime.'');
			$sea['starttime'] = date('Y-m-d H:i:s',$starttime);
			$sea['endtime']   = date('Y-m-d H:i:s',$endtime);
		}

		$this->assign("sea",$sea);
		$count = $journal->where($where)->count();
		$pagecount = 10;
		$page = new \Think\Page($count , $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first','首页');
		$page->setConfig('prev','上一页');
		$page->setConfig('next','下一页');
		$page->setConfig('last','尾页');
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$start = $page->firstRow;
		$end = $page->listRows;

		$tlist = $journal->where($where)->order('oid desc')->limit($start,$end)->select();

		foreach ($tlist as $key => $value) {
			 $profit = M('order')->field('endprofit,endloss,pid')->where(array('oid' => $value['oid']))->find();
			 $tlist[$key]['endprofit'] = $profit['endprofit'];
			 $tlist[$key]['endloss']   = $profit['endloss'];

             $info = M('OptionInfo')->where(array('option_id' => $profit['pid']))->find();
			 $tlist[$key]['jbuyprice']  = sprintf("%.".$info['capital_length']."f",$value['jbuyprice']); //建仓价
			 $tlist[$key]['jsellprice'] = sprintf("%.".$info['capital_length']."f",$value['jsellprice']); //平仓价

		}

		$where['jtype'] = '平仓';

        $order_jploss  = $journal->where($where)->sum('jploss');



        $where['jtype'] = '建仓';
        $order_count   = $journal->where($where)->count();
        $order_jfee    = $journal->where($where)->sum('jfee');
        $order_juprice = $journal->where($where)->sum('juprice');
        $sumbuymoney   = $order_jfee + $order_juprice;

	    $this->assign('sumbuymoney',$sumbuymoney);
	    $this->assign('sumploss',$order_jploss);
	    $this->assign('sumfee',$order_jfee);
	    $this->assign('count',$order_count);

        $uids = $journal->distinct(true)->field('uid')->where($where)->select();
        $tlistArr = array();
        foreach ($uids as $key => $value) {
        	array_push($tlistArr,$value['uid']);
        }
        $tlistId = implode(',',array_unique($tlistArr));
        $map['uid'] = array('in',$tlistId);

        $account['money_total']    = M('accountinfo')->where($map)->sum('money_total');
        $account['recharge_total'] = M('accountinfo')->where($map)->sum('recharge_total');
	    $this->assign('account',$account);


		$show = $page->show();
		$this->assign('tlist',$tlist);
		$this->assign('page',$show);
		$this->assign('info',$user->field('uid,username')->where(array("otype" => 5))->select());
		$this->assign('info7',$user->field('uid,username')->where(array("otype" => 7))->select());
		$this->assign('option_name',M('option')->select());
		$this->display();
	}


	//模拟交易
	public function moni(){

	    $type    = '2';
		//判断用户是否登陆
		$user 	= A('Admin/User');
		$user->checklogin();

		$tq 	 = C('DB_PREFIX');
		$journal = D('journal');
		$user 	 = D('userinfo');

		$orderno 	= trim(I('get.orderno'));//订单编号
		$username 	= trim(I('get.username'));
		$starttime 	= urldecode(trim(I('get.starttime')));
		$endtime 	= urldecode(trim(I('get.endtime')));
		$ostyle 	= trim(I('get.ostyle'));
		$ploss 		= trim(I('get.ploss'));
		$ostaus 	= trim(I('get.ostaus'));
		$oid 		= trim(I('get.oid'));

		if($oid)
		{
			$oids = getDownuids($oid);
			$where['uid'] = array("in",implode(',',$oids));
			$sea['oid'] = $oid;
		}
		if($orderno){
			$where['jno'] = $orderno;
		}

		//手机号查找
		if($username){
			$where['jusername'] = $username;
			$sea['username'] 	= $username;
		}

        //日期查找
		if($starttime && $endtime){
			$start_time  = strtotime($starttime);
			$end_time 	= strtotime($endtime);
			$where['jtime']	  = array('between',''.$start_time.','.$end_time.'');
			$sea['starttime'] = $starttime;
			$sea['endtime']   = $endtime;
		} else {
			$start_time = strtotime(date('Y-m-d')." 06:00:00");
			$end_time = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
			$where['jtime']	  = array('between',''.$start_time.','.$end_time.'');
			$sea['starttime'] = date('Y-m-d H:i:s',$start_time);
			$sea['endtime']   = date('Y-m-d H:i:s',$end_time);
		}

		if($ostyle!=""){
			$where['jostyle'] = array("eq",$ostyle);
			$sea['ostyle'] = $ostyle;
		}

		if($ploss=='0'){
			$where['jploss'] = array("gt",0);
			$sea['ploss'] = 0;
		}else if($ploss=='1'){
			$where['jploss'] = array("lt",0);
			$sea['ploss'] = 1;
		}

		if($ostaus!=""){
			if($ostaus == '4')
			{
				$where['jtype'] = '建仓';
				$sea['ostaus'] = 4;
			}
			if($ostaus == '1')
			{
				$where['jtype'] = '平仓';
				$sea['ostaus'] = 1;
			}
		}

         $otype     = trim(I('get.otype'));
         $jingjiren = trim(I('get.jingjiren'));
         $userss    = trim(I('get.user'));
         $option    = trim(I('get.option'));

        //运营中心筛选
        if($otype != ''){

            $userarr  = array();
            $userarr1 = array();
        	$ship = M("UserinfoRelationship")->field('user_id')->where(array('parent_user_id' => $otype))->select();
            foreach ($ship as $key => $value) {
            	array_push($userarr, $value['user_id']);
            }
            $user_id = implode(',',array_unique($userarr));

        	$users = M("UserinfoRelationship")->field('user_id')->where('parent_user_id  in('.$user_id.')')->select();

            foreach ($users as $key => $val) {

                array_push($userarr1,$val['user_id']);
            }
            $id = implode(',',array_unique($userarr1));

        	$where['uid'] = array('in',$id);
        	$sea['otype'] = $otype;
        	$this->assign('user_id',$otype);
        }

        //经纪人筛选
        if($jingjiren != ''){

            $userarr  = array();
            $userarr1 = array();
        	$ship = M("UserinfoRelationship")->field('user_id')->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {

            	array_push($userarr, $value['user_id']);
            }
            $id = implode(',',array_unique($userarr));

        	$where['uid'] = array('in',$id);
        	$sea['jingjiren'] = $jingjiren;
        	$this->assign('jingjiren',$this->get_username($jingjiren));
        }

        //用户筛选
        if($userss != ''){

            $id = $userss;
        	$where['uid'] = array('in',$id);
        	$sea['user'] = $userss;
        	$this->assign('user',$this->get_username($userss));
        }

        if($option) {
           $where['remarks'] = $option;
           $sea['option'] = $option;
           $this->assign('op_name',$option);
        }

		$where['type'] = $type;       //区分真实和模拟交易
		$this->assign("sea",$sea);
		$count = $journal->where($where)->count();
		$pagecount = 10;
		$page = new \Think\Page($count , $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first','首页');
		$page->setConfig('prev','上一页');
		$page->setConfig('next','下一页');
		$page->setConfig('last','尾页');
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$start = $page->firstRow;
		$end = $page->listRows;

		$tlist = $journal->where($where)->order('oid desc')->limit($start,$end)->select();
		foreach ($tlist as $key => $value) {
			 $profit = M('order')->field('endprofit,endloss,pid')->where(array('oid' => $value['oid']))->find();
			 $tlist[$key]['endprofit'] = $profit['endprofit'];
			 $tlist[$key]['endloss']   = $profit['endloss'];

             $info = M('OptionInfo')->where(array('option_id' => $profit['pid']))->find();
			 $tlist[$key]['jbuyprice']  = sprintf("%.".$info['capital_length']."f",$value['jbuyprice']); //建仓价
			 $tlist[$key]['jsellprice'] = sprintf("%.".$info['capital_length']."f",$value['jsellprice']); //平仓价
		}


		$where['jtype'] = '平仓';

       //总订单
       $order_jploss  = $journal->where($where)->sum('jploss');

       $where['jtype'] = '建仓';
       $order_count   = $journal->where($where)->count();
       $order_jfee    = $journal->where($where)->sum('jfee');
       $order_juprice = $journal->where($where)->sum('juprice');
       $sumbuymoney   = $order_jfee + $order_juprice;

	   $this->assign('sumbuymoney',$sumbuymoney);
	   $this->assign('sumploss',$order_jploss);
	   $this->assign('sumfee',$order_jfee);
	   $this->assign('count',$order_count);


		$show = $page->show();
		$this->assign('tlist',$tlist);
		$this->assign('page',$show);
		$this->assign('info',$user->field('uid,username')->where(array("otype" => 5))->select());
		$this->assign('option_name',M('option')->select());
		$this->display();

	}

	 public function daochu(){
		$type    = I('get.type');

		$user 	 = A('Admin/User');
		$user->checklogin();

		$tq			= C('DB_PREFIX');
		$journal 	= D('journal');
		$user 		= D('userinfo');
		$where = "";

		$orderno 	= trim(I('get.orderno'));//订单编号
		$username 	= trim(I('get.username'));
		$starttime 	= urldecode(trim(I('get.starttime')));
		$endtime 	= urldecode(trim(I('get.endtime')));
		$ostyle 	= trim(I('get.ostyle'));
		$ploss 		= trim(I('get.ploss'));
		$ostaus 	= trim(I('get.ostaus'));
		$oid 		= trim(I('get.oid'));

		if($oid)
		{
			$oids = getDownuids($oid);
			$where['uid'] 	= array("in",implode(',',$oids));
			$sea['oid'] 	= $oid;
		}
		if($orderno){
			$where['jno'] 	= $orderno;
		}

		//手机号查找
		if($username){
			$where['jusername'] = $username;
			$sea['username'] 	= $username;
		}

        //日期查找
		if($starttime && $endtime){
			$start_time  = strtotime($starttime);
			$end_time 	= strtotime($endtime);
			$where['jtime']	  = array('between',''.$start_time.','.$end_time.'');
		} else {
			$start_time = strtotime(date('Y-m-d')." 06:00:00");
			$end_time = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
			$where['jtime']	  = array('between',''.$start_time.','.$end_time.'');
		}

		if($ostyle!=""){
			$where['jostyle'] = array("eq",$ostyle);
			$sea['ostyle'] = $ostyle;
		}
		if($ploss=='0'){
			$where['jploss'] = array("gt",0);
			$sea['ploss'] = 0;
		}else if($ploss=='1'){
			$where['jploss'] = array("lt",0);
			$sea['ploss'] = 1;
		}
		if($ostaus!=""){
			if($ostaus == '4')
			{
				$where['jtype'] = '建仓';
				$sea['ostaus'] = 4;
			}
			if($ostaus == '1')
			{
				$where['jtype'] = '平仓';
				$sea['ostaus'] = 1;
			}
		}

         $otype     = trim(I('get.otype'));
         $jingjiren = trim(I('get.jingjiren'));
         $userss    = trim(I('get.user'));
         $option    = trim(I('get.option'));

        //运营中心筛选
        if($otype != ''){

            $userarr  = array();
            $userarr1 = array();
        	$ship = M("UserinfoRelationship")->field('user_id')->where(array('parent_user_id' => $otype))->select();
            foreach ($ship as $key => $value) {
            	array_push($userarr, $value['user_id']);
            }
            $user_id = implode(',',array_unique($userarr));

        	$users = M("UserinfoRelationship")->field('user_id')->where('parent_user_id  in('.$user_id.')')->select();

            foreach ($users as $key => $val) {

                array_push($userarr1,$val['user_id']);
            }
            $id = implode(',',array_unique($userarr1));

        	$where['uid'] = array('in',$id);
        	$sea['otype'] = $otype;
        	$this->assign('user_id',$otype);
        }

        //经纪人筛选
        if($jingjiren != ''){

            $userarr  = array();
            $userarr1 = array();
        	$ship = M("UserinfoRelationship")->field('user_id')->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {

            	array_push($userarr, $value['user_id']);
            }
            $id = implode(',',array_unique($userarr));

        	$where['uid'] = array('in',$id);
        	$sea['jingjiren'] = $jingjiren;
        	$this->assign('jingjiren',$this->get_username($jingjiren));
        }

        //用户筛选
        if($userss != ''){

            $id = $userss;
        	$where['uid'] = array('in',$id);
        	$sea['user'] = $userss;
        	$this->assign('user',$this->get_username($userss));
        }

        if($option) {
           $where['remarks'] = $option;
           $sea['option'] = $option;
           $this->assign('op_name',$option);
        }

		$where['type'] = $type;       //区分真实和模拟交易


		$tlist = $journal->order('jtime desc')->where($where)->select();
        foreach ($tlist as $key => $value) {
			$profit = M('order')->field('endprofit,endloss,pid')->where(array('oid' => $value['oid']))->find();
			$tlist[$key]['endprofit'] = $profit['endprofit'];
			$tlist[$key]['endloss']   = $profit['endloss'];

            $info = M('OptionInfo')->where(array('option_id' => $profit['pid']))->find();
			$tlist[$key]['jbuyprice']  = sprintf("%.".$info['capital_length']."f",$value['jbuyprice']); //建仓价
			$tlist[$key]['jsellprice'] = sprintf("%.".$info['capital_length']."f",$value['jsellprice']); //平仓价
        }

		$data[0] = array(
			'编号','用户','类型','操作时间','产品信息','数量（手）','方向','金额','手续费','买价','卖价',"出入金","盈亏",'止盈','止损','运营中心','经纪人','经纪人昵称','一级推广','二级推广'
		);
		foreach($tlist as $key=>$val)
		{
			$data[$key+1][] = $val['jno'];
			$data[$key+1][] = $val['jusername'];
			$data[$key+1][] = $val['jtype'];
			$data[$key+1][] = date("Y-m-d H:i:s",$val['jtime']);
			$data[$key+1][] = $val['remarks'];
			$data[$key+1][] = $val['number'];
			if($val['jostyle'] == 1)
			{
				$data[$key+1][] = "买跌";
			}else{
				$data[$key+1][] = "买涨";
			}
			$data[$key+1][] = $val['juprice']*$val['number'];
			$data[$key+1][] = $val['jfee'];
			$data[$key+1][] = $val['jbuyprice'];
			$data[$key+1][] = $val['jsellprice'];
			$data[$key+1][] = $val['jaccess'];
			$data[$key+1][] = $val['jploss'];
			$data[$key+1][] = $val['endprofit'];
			$data[$key+1][] = $val['endloss'];
			$data[$key+1][] = change(exchange($val['uid'],2));
			$data[$key+1][] = change(exchange($val['uid'],1));
			$data[$key+1][] = agent_name(exchange($val['uid'],1));
			$data[$key+1][] = promotion($val['uid']);
			$data[$key+1][] = promotion($val['uid'],2);

		}
		$name = $type == 1 ? '实盘交易流水':'模拟交易流水';
		$name=$name;  //生成的Excel文件文件名
		$res=$this->push($data,$name);
	}


	public function push($data,$name){
		import("Excel.class.php");
		$excel = new Excel();
		$excel->download($data,$name);
	}



	private function get_username($uid = 0) {

		 $info = M("userinfo a")->field('a.uid,a.username,b.busername')->join('left join wp_bankinfo as b on a.uid = b.uid')->where(array('a.uid'=> $uid))->find();

         $info['username'] = !empty($info['busername']) ? $info['busername'] : $info['username'];

		 return $info ? $info : null;
	}

}
