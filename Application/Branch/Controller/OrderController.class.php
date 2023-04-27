<?php
/**
 * @author: wang
 * @datetime: 2017/5/28 16:08
 * @filename: OrderController.class.php
 * @description:  订单模块
 * @note: 
 * 
 */
namespace Branch\Controller;
use Think\Controller;
use Org\Util\Excel;

class OrderController extends CommonController
{

    /**
     * @author: wang
     * @datetime: 2017/5/28 16:08
     * @filename: OrderController.class.php
     * @description:  现金订单模块
     * @note: 
     * 
     */
    public function cash_list()
    {
        $type       = 1;
        $journal    = D('journal');
        $user       = D('userinfo');
        $where      = "";
          
         $operate   = trim(I('get.operate'));
         $jinjiren  = trim(I('get.jinjiren'));
         $user      = trim(I('get.user'));
         $starttime = urldecode(trim(I('get.start_time')));
         $endtime   = urldecode(trim(I('get.end_time')));
         $utel      = trim(I('get.utel'));
         $jostyle   = trim(I('get.jostyle'));
         $jploss    = trim(I('get.ploss'));
         $status    = trim(I('get.status'));
         $option_name = trim(I('get.option_name'));
         $datetype    = trim(I('get.datetype'));

        $userinfoRelationshipObj    = M('userinfo_relationship');

        //运营中心
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $operateinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

        $operateIdArr  = array();
        foreach($operateinfoRelationshipRs as $k => $v)
        {
            array_push($operateIdArr, $v['user_id']);
        }

        $operateIdStr  = implode(',', array_unique($operateIdArr));
        

        $userinfoObj            = M('userinfo');
        $operateinfoWhereArr    = 'uid in ('.$operateIdStr.')';

        $operateinfoRs    = $userinfoObj->field('uid,username,nickname')->where($operateinfoWhereArr)->select();
        $operateinfoRs1   = array();
        foreach($operateinfoRs as $k => $v)
        {
            $operateinfoRs1[$v['uid']]    = $v;
        }
        $this->assign('operateinfoRs',$operateinfoRs);


        //经纪人
        $agentinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$operateIdStr.')')->select();
        $agentIdArr     = array();
        $agentIdArr2    = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
            $agentIdArr2[$v['user_id']] = $v;
        }

        $agentIdStr  = implode(',', array_unique($agentIdArr));

        $userinfoObj        = M('userinfo');
        $agentinfoWhereArr  = 'uid in ('.$agentIdStr.')';

        $agentinfoRs    = $userinfoObj->field('uid,username,nickname')->where($agentinfoWhereArr)->select();
        $agentinfoRs1   = array();
        foreach($agentinfoRs as $k => $v)
        {
            $agentinfoRs1[$v['uid']]    = $v;
        }
         
        //用户
        $ship = M("UserinfoRelationship")->where('parent_user_id in('.$agentIdStr.')')->select();
        $shipArr = array();
        foreach ($ship as $key => $value) {
            array_push($shipArr,$value['user_id']);               
        }
        $where['uid'] = array('in',implode(',',array_unique($shipArr)));


        //联动运营中心筛选
        if($operate)
        {
            $agentArr = array();
            $agentinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$operate.')')->select();
            foreach ($agentinfoRelationshipRs as $key => $value) {
                 array_push($agentArr,$value['user_id']);
            }
            $agentId = implode(',',array_unique($agentArr));
            
            $userArr = array();
            $userinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$agentId.')')->select();
            foreach ($userinfoRelationshipRs as $key => $value) {
                 array_push($userArr,$value['user_id']);
            }
            $userIdStr = implode(',',array_unique($userArr));
            $sea['operate'] = $operate;
        }

        //联动经纪人筛选
        if($jinjiren != ''){
            
            $userarr  = array();
            $userarr1 = array(); 
            $ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jinjiren))->select();
            foreach ($ship as $key => $value) {
                
                array_push($userarr, $value['user_id']);
            }
            $id = implode(',',array_unique($userarr));

            $where['uid'] = array('in',$id);
            $sea['jinjiren'] = $jinjiren;
            $this->assign('jinjiren',$this->get_username($jinjiren));
        }

        //联动用户筛选
        if($user != ''){
            
            $id = $user; 
            $where['uid'] = array('in',$id);
            $sea['user'] = $user;
            $this->assign('user',$this->get_username($user));
        }

        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where['jtime'] = array('between',array($start_time,$end_time));
            $sea['start_time'] = $starttime;
            $sea['end_time'] = $endtime;
            $this->assign('time',$sea);
        }    

        //手机号码筛选
        if($utel) {
            $where['jusername'] = array('like','%'.$utel.'%');
            $sea['utel'] = $utel;
            $this->assign('utel',$utel);
        }

        //订单类型筛选
        if($jostyle){
            $sea['jostyle'] = $jostyle;
            $this->assign('jostyle',$jostyle);
            $jostyle = $jostyle == 1?0:1;
            $where['jostyle'] = $jostyle;
        }

        //订单盈亏筛选
        if($jploss) {
          if($jploss == 1) {
            $where['jploss'] = array('gt',0);
          } else {
            $where['jploss'] = array('lt',0);
          }
            $this->assign('jploss',$jploss);
            $sea['ploss'] = $jploss;
        }

        //订单状态筛选
        if($status) {
            $this->assign('status',$status);
            $sea['status'] = $status;
            $status = $status==1 ? '建仓':'平仓';
            $where['jtype'] = $status;
        }
        
        //交易品种筛选
        if($option_name) {
           $where['remarks'] = $option_name;
           $sea['option_name'] = $option_name;
           $this->assign('op_name',$option_name);
        }

        //昨天
        $this->assign("starttimeYesterday", date('Y-m-d 06:00:00',strtotime('-1 day')));
        $this->assign("endtimeYesterday", date('Y-m-d 05:00:00'));
        //今天
//      $this->assign("starttimeToday", date('Y-m-d 06:00:00'));
//      $this->assign("endtimeToday", date('Y-m-d 05:00:00',strtotime('+1 day')));
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

        if(count($where) == 2){  //只有2个条件表示是默认列表
            $starttime = strtotime(date('Y-m-d')." 06:00:00");
            $endtime = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
            $where['jtime']   = array('between',''.$starttime.','.$endtime.'');
            $sea['start_time'] = date('Y-m-d H:i:s',$starttime);
            $sea['end_time']   = date('Y-m-d H:i:s',$endtime);
            $this->assign('time',$sea);
        }


        $this->assign("sea",$sea);
        $count = $journal->where($where)->count();
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','<<');
        $page->setConfig('next','>>');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $start = $page->firstRow;
        $end = $page->listRows;

        $tlist = $journal->where($where)->order('oid desc')->limit($start,$end)->select();
        //echo M()->getLastSql();
        
        $userIdArr = array();
        foreach ($tlist as $key => $value) {
             array_push($userIdArr,$value['oid']);
        }

        $userId = implode(',',array_unique($userIdArr));
        $order = M('order')->where('oid in('.$userId.')')->select();

        foreach ($order as $key => $value) {
             
             $ordreRs3[$value['oid']] = $value;
        }

        foreach ($tlist as $key => $value) {
             
             $tlist[$key]['endprofit'] = $ordreRs3[$value['oid']]['endprofit'];
             $tlist[$key]['endloss']   = $ordreRs3[$value['oid']]['endloss'];
             $info = M('OptionInfo')->where(array('option_id' => $ordreRs3[$value['oid']]['pid']))->find();
             $tlist[$key]['jbuyprice']  = sprintf("%.".$info['capital_length']."f",$value['jbuyprice']); //建仓价
             $tlist[$key]['jsellprice'] = sprintf("%.".$info['capital_length']."f",$value['jsellprice']); //平仓价
        }


        //用于统计
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


        //$uids   = M()->query('select distinct(uid) from wp_journal');
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

        $this->assign('totalCount',$count);
        $nowStart = !I('get.p')?1:I('get.p');
        $this->assign('nowStart',$nowStart);
        $this->assign('nowEnd',ceil($count/$pagecount));
        $this->assign('tlist',$tlist);
        $this->assign('page',$show);
        $this->assign('option_name',M('option')->select());
        $this->display();
    }

    /**
     * @author: wang
     * @datetime: 2017/5/28 16:08
     * @filename: OrderController.class.php
     * @description:  积分订单模块
     * @note: 
     * 
     */
    public function order_list_gold()
    {
        $type       = 2;
        $journal    = D('journal');
        $user       = D('userinfo');
        $where      = "";
          
         $operate   = trim(I('get.operate'));
         $jinjiren  = trim(I('get.jinjiren'));
         $user      = trim(I('get.user'));
         $starttime = urldecode(trim(I('get.start_time')));
         $endtime   = urldecode(trim(I('get.end_time')));
         $utel      = trim(I('get.utel'));
         $jostyle   = trim(I('get.jostyle'));
         $jploss    = trim(I('get.ploss'));
         $status    = trim(I('get.status'));
         $option_name = trim(I('get.option_name'));
         $datetype    = trim(I('get.datetype'));

        $userinfoRelationshipObj    = M('userinfo_relationship');

        //运营中心
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $operateinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

        $operateIdArr  = array();
        foreach($operateinfoRelationshipRs as $k => $v)
        {
            array_push($operateIdArr, $v['user_id']);
        }

        $operateIdStr  = implode(',', array_unique($operateIdArr));
        

        $userinfoObj            = M('userinfo');
        $operateinfoWhereArr    = 'uid in ('.$operateIdStr.')';

        $operateinfoRs    = $userinfoObj->field('uid,username,nickname')->where($operateinfoWhereArr)->select();
        $operateinfoRs1   = array();
        foreach($operateinfoRs as $k => $v)
        {
            $operateinfoRs1[$v['uid']]    = $v;
        }
        $this->assign('operateinfoRs',$operateinfoRs);


        //经纪人
        $agentinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$operateIdStr.')')->select();
        $agentIdArr     = array();
        $agentIdArr2    = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
            $agentIdArr2[$v['user_id']] = $v;
        }

        $agentIdStr  = implode(',', array_unique($agentIdArr));

        $userinfoObj        = M('userinfo');
        $agentinfoWhereArr  = 'uid in ('.$agentIdStr.')';

        $agentinfoRs    = $userinfoObj->field('uid,username,nickname')->where($agentinfoWhereArr)->select();
        $agentinfoRs1   = array();
        foreach($agentinfoRs as $k => $v)
        {
            $agentinfoRs1[$v['uid']]    = $v;
        }
         
        //用户
        $ship = M("UserinfoRelationship")->where('parent_user_id in('.$agentIdStr.')')->select();
        $shipArr = array();
        foreach ($ship as $key => $value) {
            array_push($shipArr,$value['user_id']);               
        }
        $where['uid'] = array('in',implode(',',array_unique($shipArr)));


        //联动运营中心筛选
        if($operate)
        {
            $agentArr = array();
            $agentinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$operate.')')->select();
            foreach ($agentinfoRelationshipRs as $key => $value) {
                 array_push($agentArr,$value['user_id']);
            }
            $agentId = implode(',',array_unique($agentArr));
            
            $userArr = array();
            $userinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$agentId.')')->select();
            foreach ($userinfoRelationshipRs as $key => $value) {
                 array_push($userArr,$value['user_id']);
            }
            $userIdStr = implode(',',array_unique($userArr));
            $sea['operate'] = $operate;
        }

        //联动经纪人筛选
        if($jinjiren != ''){
            
            $userarr  = array();
            $userarr1 = array(); 
            $ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jinjiren))->select();
            foreach ($ship as $key => $value) {
                
                array_push($userarr, $value['user_id']);
            }
            $id = implode(',',array_unique($userarr));

            $where['uid'] = array('in',$id);
            $sea['jinjiren'] = $jinjiren;
            $this->assign('jinjiren',$this->get_username($jinjiren));
        }

        //联动用户筛选
        if($user != ''){
            
            $id = $user; 
            $where['uid'] = array('in',$id);
            $sea['user'] = $user;
            $this->assign('user',$this->get_username($user));
        }

        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where['jtime'] = array('between',array($start_time,$end_time));
            $sea['start_time'] = $starttime;
            $sea['end_time'] = $endtime;
            $this->assign('time',$sea);
        }    

        //手机号码筛选
        if($utel) {
            $where['jusername'] = array('like','%'.$utel.'%');
            $sea['utel'] = $utel;
            $this->assign('utel',$utel);
        }

        //订单类型筛选
        if($jostyle){
            $sea['jostyle'] = $jostyle;
            $this->assign('jostyle',$jostyle);
            $jostyle = $jostyle == 1?0:1;
            $where['jostyle'] = $jostyle;
        }

        //订单盈亏筛选
        if($jploss) {
          if($jploss == 1) {
            $where['jploss'] = array('gt',0);
          } else {
            $where['jploss'] = array('lt',0);
          }
            $this->assign('jploss',$jploss);
            $sea['ploss'] = $jploss;
        }

        //订单状态筛选
        if($status) {
            $this->assign('status',$status);
            $sea['status'] = $status;
            $status = $status==1 ? '建仓':'平仓';
            $where['jtype'] = $status;
        }
        
        //交易品种筛选
        if($option_name) {
           $where['remarks'] = $option_name;
           $sea['option_name'] = $option_name;
           $this->assign('op_name',$option_name);
        }

        //昨天
        $this->assign("starttimeYesterday", date('Y-m-d 06:00:00',strtotime('-1 day')));
        $this->assign("endtimeYesterday", date('Y-m-d 05:00:00'));
        //今天
//      $this->assign("starttimeToday", date('Y-m-d 06:00:00'));
//      $this->assign("endtimeToday", date('Y-m-d 05:00:00',strtotime('+1 day')));
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

        if(count($where) == 2){  //只有2个条件表示是默认列表
            $starttime = strtotime(date('Y-m-d')." 06:00:00");
            $endtime = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
            $where['jtime']   = array('between',''.$starttime.','.$endtime.'');
            $sea['start_time'] = date('Y-m-d H:i:s',$starttime);
            $sea['end_time']   = date('Y-m-d H:i:s',$endtime);
            $this->assign('time',$sea);
        }


        $this->assign("sea",$sea);
        $count = $journal->where($where)->count();
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','<<');
        $page->setConfig('next','>>');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $start = $page->firstRow;
        $end  = $page->listRows;
        $show = $page->show();

        $tlist = $journal->where($where)->order('oid desc')->limit($start,$end)->select();
        
        $userIdArr = array();
        foreach ($tlist as $key => $value) {
             array_push($userIdArr,$value['oid']);
        }

        $userId = implode(',',array_unique($userIdArr));
        $order = M('order')->where('oid in('.$userId.')')->select();

        foreach ($order as $key => $value) {
             
             $ordreRs3[$value['oid']] = $value;
        }

        foreach ($tlist as $key => $value) {
             
             $tlist[$key]['endprofit'] = $ordreRs3[$value['oid']]['endprofit'];
             $tlist[$key]['endloss']   = $ordreRs3[$value['oid']]['endloss'];
             $info = M('OptionInfo')->where(array('option_id' => $ordreRs3[$value['oid']]['pid']))->find();
             $tlist[$key]['jbuyprice']  = sprintf("%.".$info['capital_length']."f",$value['jbuyprice']); //建仓价
             $tlist[$key]['jsellprice'] = sprintf("%.".$info['capital_length']."f",$value['jsellprice']); //平仓价
        }


        //用于统计
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
      
    
        $this->assign('totalCount',$count);
        $nowStart = !I('get.p')?1:I('get.p');
        $this->assign('nowStart',$nowStart);
        $this->assign('nowEnd',ceil($count/$pagecount));
        $this->assign('tlist',$tlist);
        $this->assign('page',$show);
        $this->assign('option_name',M('option')->select());
        $this->display();
    }

    /**
     * @author: wang
     * @datetime: 2017/5/28 16:08
     * @filename: OrderController.class.php
     * @description:  订单导出
     * @note: 
     * 
     */
    public function cash_daochu()
    {
        $type    = trim(I('get.type'));
        if($type != 1)$type = 2;
        $name    = $type == 1 ? '现金订单' : '积分订单'; 

        $journal    = D('journal');
        $user       = D('userinfo');
        $where      = "";
          
         $operate   = trim(I('get.operate'));
         $jinjiren  = trim(I('get.jinjiren'));
         $user      = trim(I('get.user'));
         $starttime = urldecode(trim(I('get.start_time')));
         $endtime   = urldecode(trim(I('get.end_time')));
         $utel      = trim(I('get.utel'));
         $jostyle   = trim(I('get.jostyle'));
         $jploss    = trim(I('get.ploss'));
         $status    = trim(I('get.status'));
         $option_name = trim(I('get.option_name'));
         $datetype    = trim(I('get.datetype'));

        $userinfoRelationshipObj    = M('userinfo_relationship');

        //运营中心
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $operateinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

        $operateIdArr  = array();
        foreach($operateinfoRelationshipRs as $k => $v)
        {
            array_push($operateIdArr, $v['user_id']);
        }

        $operateIdStr  = implode(',', array_unique($operateIdArr));
        

        $userinfoObj            = M('userinfo');
        $operateinfoWhereArr    = 'uid in ('.$operateIdStr.')';

        $operateinfoRs    = $userinfoObj->field('uid,username,nickname')->where($operateinfoWhereArr)->select();
        $operateinfoRs1   = array();
        foreach($operateinfoRs as $k => $v)
        {
            $operateinfoRs1[$v['uid']]    = $v;
        }
        $this->assign('operateinfoRs',$operateinfoRs);


        //经纪人
        $agentinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$operateIdStr.')')->select();
        $agentIdArr     = array();
        $agentIdArr2    = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
            $agentIdArr2[$v['user_id']] = $v;
        }

        $agentIdStr  = implode(',', array_unique($agentIdArr));

        $userinfoObj        = M('userinfo');
        $agentinfoWhereArr  = 'uid in ('.$agentIdStr.')';

        $agentinfoRs    = $userinfoObj->field('uid,username,nickname')->where($agentinfoWhereArr)->select();
        $agentinfoRs1   = array();
        foreach($agentinfoRs as $k => $v)
        {
            $agentinfoRs1[$v['uid']]    = $v;
        }
         
        //用户
        $ship = M("UserinfoRelationship")->where('parent_user_id in('.$agentIdStr.')')->select();
        $shipArr = array();
        foreach ($ship as $key => $value) {
            array_push($shipArr,$value['user_id']);               
        }
        $where['uid'] = array('in',implode(',',array_unique($shipArr)));


        //联动运营中心筛选
        if($operate)
        {
            $agentArr = array();
            $agentinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$operate.')')->select();
            foreach ($agentinfoRelationshipRs as $key => $value) {
                 array_push($agentArr,$value['user_id']);
            }
            $agentId = implode(',',array_unique($agentArr));
            
            $userArr = array();
            $userinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$agentId.')')->select();
            foreach ($userinfoRelationshipRs as $key => $value) {
                 array_push($userArr,$value['user_id']);
            }
            $userIdStr = implode(',',array_unique($userArr));
        }

        //联动经纪人筛选
        if($jinjiren != ''){
            
            $userarr  = array();
            $userarr1 = array(); 
            $ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jinjiren))->select();
            foreach ($ship as $key => $value) {
                
                array_push($userarr, $value['user_id']);
            }
            $id = implode(',',array_unique($userarr));

            $where['uid'] = array('in',$id);
        }

        //联动用户筛选
        if($user != ''){
            
            $id = $user; 
            $where['uid'] = array('in',$id);
        }

        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where['jtime'] = array('between',array($start_time,$end_time));
        }    

        //手机号码筛选
        if($utel) {
            $where['jusername'] = array('like','%'.$utel.'%');
        }

        //订单类型筛选
        if($jostyle){
            $this->assign('jostyle',$jostyle);
            $jostyle = $jostyle == 1?0:1;
            $where['jostyle'] = $jostyle;
        }

        //订单盈亏筛选
        if($jploss) {
          if($jploss == 1) {
            $where['jploss'] = array('gt',0);
          } else {
            $where['jploss'] = array('lt',0);
          }

        }

        //订单状态筛选
        if($status) {
            $this->assign('status',$status);
            $status = $status==1 ? '建仓':'平仓';
            $where['jtype'] = $status;
        }
        
        //交易品种筛选
        if($option_name) {
           $where['remarks'] = $option_name;
        }

        //昨天
        $this->assign("starttimeYesterday", date('Y-m-d 06:00:00',strtotime('-1 day')));
        $this->assign("endtimeYesterday", date('Y-m-d 05:00:00'));
        //今天
//      $this->assign("starttimeToday", date('Y-m-d 06:00:00'));
//      $this->assign("endtimeToday", date('Y-m-d 05:00:00',strtotime('+1 day')));
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
        }

        $where['type'] = $type;       //区分真实和模拟交易

        if(count($where) == 2){  //只有2个条件表示是默认列表
            $starttime = strtotime(date('Y-m-d')." 06:00:00");
            $endtime = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
            $where['jtime']   = array('between',''.$starttime.','.$endtime.'');
            $sea['start_time'] = date('Y-m-d H:i:s',$starttime);
            $sea['end_time']   = date('Y-m-d H:i:s',$endtime);
            $this->assign('time',$sea);
        }


        $tlist = $journal->where($where)->order('oid desc')->select();
        
        $userIdArr = array();
        foreach ($tlist as $key => $value) {
             array_push($userIdArr,$value['oid']);
        }

        $userId = implode(',',array_unique($userIdArr));
        $order = M('order')->where('oid in('.$userId.')')->select();

        foreach ($order as $key => $value) {
             
             $ordreRs3[$value['oid']] = $value;
        }

        foreach ($tlist as $key => $value) {
             
             $tlist[$key]['endprofit'] = $ordreRs3[$value['oid']]['endprofit'];
             $tlist[$key]['endloss']   = $ordreRs3[$value['oid']]['endloss'];
             $info = M('OptionInfo')->where(array('option_id' => $ordreRs3[$value['oid']]['pid']))->find();
             $tlist[$key]['jbuyprice']  = sprintf("%.".$info['capital_length']."f",$value['jbuyprice']); //建仓价
             $tlist[$key]['jsellprice'] = sprintf("%.".$info['capital_length']."f",$value['jsellprice']); //平仓价
        }


        $data[0] = array('订单id','用户姓名','手机号码','商品','方向','保证金','手续费','买入价','卖出价','止损金额','止盈金额','浮动盈亏','出入金','订单状态','建仓时间','平仓时间');
        foreach ($tlist as $key => $value) {
            $jsellprice = !empty($value['jsellprice']) ? $value['jsellprice'] : '--';
            $ploss      = $value['jtype'] == '建仓' ? '--' : $value['jploss'];
            $jostyle    = $value['jostyle'] == 0 ? '买涨' : '买跌';
            $jtime      = $value['jtype'] == '建仓' ? '--' : date('Y-m-d H:i:s',$value['jtime']);

            $data[$key+1][] = $value['oid'];
            $data[$key+1][] = getUsername($value[uid]);
            $data[$key+1][] = $value['jusername'];
            $data[$key+1][] = $value['remarks'];
            $data[$key+1][] = $value['jtype'];
            $data[$key+1][] = $value['juprice'];
            $data[$key+1][] = $value['jfee'];
            $data[$key+1][] = $value['jbuyprice'];
            $data[$key+1][] = $jsellprice;
            $data[$key+1][] = $value['endloss'];
            $data[$key+1][] = $value['endprofit'];
            $data[$key+1][] = $ploss;
            $data[$key+1][] = $value['jaccess'];
            $data[$key+1][] = $jostyle;
            $data[$key+1][] = Jiancangtime($value[oid]);
            $data[$key+1][] = $jtime;
        }
        $name=$name;
        $this->push($data,$name);
    }


    /**
     * @functionname: order_detail
     * @author: wang
     * @datetime: 2017/5/28 16:08
     * @description: 订单详细页面
     * @note:
     */
    public function order_detail()
    {
        $orderId    = I('get.order_id');
        if(!$orderId)
        {
            $this->display('Common/error_not_found');
            die();
        }

        $mObj       = M();
        $orderObj   = M('order');
        $orderRs    = $orderObj->where('oid='.$orderId)->find();


        $userObj    = M('userinfo');
        $userRs     = $userObj->where('uid='.$orderRs['uid'])->find();


        $orderExtraRs   = $mObj->table('view_wp_orders')->where('oid='.$orderId)->find();
        $currencyRs     = get_setting_config('find', 'SYSTEM_CURRENCY_TYPE');
        $currencyRs1    = $currencyRs['datas'];

        $orderRs['rate']        = $currencyRs1[$orderExtraRs['currency']]['rate'];

        $orderRs['nickname']    = $userRs['nickname'];
        $orderRs['buy_date']    = date('Y-m-d H:i:s', $orderRs['buytime']);
        $orderRs['sell_date']   = date('Y-m-d H:i:s', $orderRs['selltime']);

        $orderRs['type_n']      = $orderRs['type'] == 1 ? '现金' : '积分';
        $orderRs['status_n']    = $orderRs['ostaus'] == 1 ? '结算完成' : '持仓中';
        $orderRs['style_n']     = $orderRs['ostyle'] == 1 ? '<span class="label label-sm label-danger">看空</span>' : '<span class="label label-sm label-success">看多</span>';


        //推广佣金
        $feeObj = M('fee_receive');
        $orderRs['commission']  = $feeObj->where('order_id='.$orderId.' and type=1')->sum('profit_rmb');
        $orderRs['commission']  = empty($orderRs['commission']) ? '0.00' : $orderRs['commission'];


        if($orderRs['ploss'] > 0)
        {
            $orderRs['ploss_style'] = 'red';
        }
        if($orderRs['ploss'] < 0)
        {
            $orderRs['ploss_style'] = 'green';
        }


        $this->assign('orderRs', $orderRs);
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


    private function push($data,$name){
        $excel = new Excel();
        $excel->download($data,$name);
    }

    private function get_username($uid = 0) {
         
         $info = M("userinfo a")->field('a.uid,a.username,b.busername')->join('left join wp_bankinfo as b on a.uid = b.uid')->where(array('a.uid'=> $uid))->find();

         $info['username'] = !empty($info['busername']) ? $info['busername'] : $info['username'];

         return $info ? $info : null;
    }

}