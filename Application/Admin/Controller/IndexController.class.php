<?php

namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
 
    public function index()
    {
  
    	header("Content-type: text/html; charset=utf-8");
    	$user= A('Admin/User');
		$user->checklogin();
        
        $arr = array();
        //运营中心
        $extend_count = M("userinfo")->where(array('otype' => 5))->count();
        $this->assign("extend_count",$extend_count);
        
        //经纪人
        $agent_count = M("userinfo")->where(array('otype' => 6))->count();
        $this->assign("agent_count",$agent_count);

        //用户
        $user_count = M("userinfo")->where(array('otype' => 4))->count();
        $this->assign('user_count',$user_count);
        $this->assign('date',date('Y-m-d',time()));

        //最近7天的订单
        $order_count = M("journal")->where('DATE_SUB(CURDATE(),INTERVAL 7 DAY) <= FROM_UNIXTIME(jtime,"%Y-%m-%d") and type = 1 and jtype = "建仓"')->count();
        $this->assign('order_count',$order_count);
        
        //今天的订单
        $day_count = M("journal")->where('TO_DAYS(FROM_UNIXTIME(jtime,"%Y-%m-%d")) = TO_DAYS(CURDATE()) and type = 1 and jtype = "建仓" ')->count();
        $this->assign('day_count',$day_count);

        //最近30天交易总额
        $order = M("journal")->where('DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= FROM_UNIXTIME(jtime,"%Y-%m-%d") and type = 1 and jtype = "建仓"')->sum('jaccess');

        $setting = M("setting")->where(array('name' => 'SYSTEM_CURRENCY_TYPE'))->find();
        $setting = unserialize($setting['datas']);
        $this->assign('sum',number_format(abs($order),2));

        //最近30天提现总额
        $balance = M("balance")->where('DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= FROM_UNIXTIME(cltime,"%Y-%m-%d") and b_type = 2 and isverified = 1 and status = 1')->sum('bpprice');
        $this->assign('balance',number_format($balance,2));
        
        //最近30天充值总额
        $point = M("balance")->where('DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= FROM_UNIXTIME(cltime,"%Y-%m-%d") and b_type = 1 and isverified = 1 and status = 1')->sum('bpprice');
        $this->assign('point',number_format($point,2));

        //交易所佣金
        $exchange_rmb = M('FeeReceive')->where(array('type' => 2))->sum('profit_rmb');
        $this->assign('exchange_rmb',number_format($exchange_rmb,2));

        //运营中心佣金
        $operate_rmb = M('FeeReceive')->where(array('type' => 3))->sum('profit_rmb');
        $this->assign('operate_rmb',number_format($operate_rmb,2));

        //普通用户总佣金
        $sum_rmb = M('FeeReceive')->where(array('type' => 1))->sum('profit_rmb');
        $this->assign('sum_rmb',number_format($sum_rmb,2));

         //分页
		   $count = M("journal")->where('TO_DAYS(FROM_UNIXTIME(jtime,"%Y-%m-%d")) = TO_DAYS(CURDATE()) and type=1')->count();
		   $pagecount = 6;
		   $page = new \Think\Page($count , $pagecount);
		//   $page->parameter = $row; //此处的row是数组，为了传递查询条件
		   $page->setConfig('first','首页');
		   $page->setConfig('prev','&#8249;');
		   $page->setConfig('next','&#8250;');
		   $page->setConfig('last','尾页');
		   $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
		   $show = $page->show();
        
        $field = 'a.*,b.username,c.endprofit,c.endloss';
        $orders = M("journal a")->join('left join wp_userinfo as b on a.uid = b.uid')->join('left join wp_order as c on a.oid = c.oid')->where('TO_DAYS(FROM_UNIXTIME(a.jtime,"%Y-%m-%d")) = TO_DAYS(CURDATE()) and a.type = 1')->order('a.jtime desc')->limit($page->firstRow.','.$page->listRows)->select();
        
        $this->assign("orders",$orders);
        $this->assign('page',$show);
        $this->display();

   }
}