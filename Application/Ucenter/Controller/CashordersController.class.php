<?php
/**
 * @author: FrankHong
 * @datetime: 2016/12/2 20:36
 * @filename: OrderfController.class.php
 * @description: 运营中心订单模块
 * @note: 
 * 
 */

namespace Ucenter\Controller;


class CashordersController extends CommonController
{
    /**
     * @functionname: cash_list
     * @author: FrankHong
     * @date: 2016-12-03 14:18:26
     * @description: 运营中心订单列表--现金订单
     * @note:
     *
     * 1.所有经纪人
     * 2.所有用户
     * 3.所有订单
     */
    public function cash_list() {
        
        $type    = '1';
        $journal = M('journal');
        $user    = M('userinfo');
        $where   = "";
          
         $user        = trim(I('get.user'));
         $starttime   = urldecode(trim(I('get.start_time')));
         $endtime     = urldecode(trim(I('get.end_time')));
         $utel        = trim(I('get.utel'));
         $jostyle     = trim(I('get.jostyle'));
         $jploss      = trim(I('get.ploss'));
         $status      = trim(I('get.status'));
         $option_name = trim(I('get.option_name'));
         $datetype = trim(I('get.datetype'));



        //联动用户筛选
        if($user != ''){
            
            $id = $user; 
            $where['uid'] = array('in',$id);
            $sea['user'] = $user;
            $this->assign('user',$user);
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
        
        //普通会员列表
        $ship = M("UserinfoRelationship")->where(array('parent_user_id' => session('cuid')))->select();
        $shipArr = array();
        foreach ($ship as $key => $value) {
              array_push($shipArr,$value['user_id']);
        }
        $shipid = implode(',',$shipArr);
        $info = M("userinfo a")->field('a.uid,a.username,b.busername')->join('left join wp_bankinfo as b on a.uid = b.uid')->where('a.uid in ('.$shipid.')')->select();
        foreach ($info as $key => $value) {
            $info[$key]['username'] = !empty($value['busername']) ? $value['busername'] : $value['username'];
        }
        $this->assign('info',$info);
        
        //判断是否有筛选条件
        if(empty($user)) {
             $where['uid'] = array('in',$shipid);
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

        if(count($where) == 2){  //只有2个条件表示是默认列表
            $starttime = strtotime(date('Y-m-d')." 06:00:00");
            $endtime = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
            $where['jtime']	  = array('between',''.$starttime.','.$endtime.'');
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
        $this->assign('sumploss',$order_jploss);

        //统计全部
        $where['jtype'] = '建仓';
        $order_count   = $journal->where($where)->count();
        $order_jfee    = $journal->where($where)->sum('jfee');
        $order_juprice = $journal->where($where)->sum('juprice');
        $sumbuymoney   = $order_jfee + $order_juprice;

        $this->assign('sumbuymoney',$sumbuymoney);
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
     * @functionname: order_list_gold
     * @author: FrankHong
     * @date: 2016-12-05 17:14:16
     * @description: 现金或模拟订单导出excel
     * @note:
     */
    
    public function cash_daochu() 
    {
        $type    = trim(I('get.type'));
        if($type != 1)$type = 2;
        $name    = $type == 1 ? '现金订单' : '积分订单'; 
        $journal = M('journal');
        $user    = M('userinfo');
        $where   = "";
          
        $user        = trim(I('get.user'));
        $starttime   = urldecode(trim(I('get.start_time')));
        $endtime     = urldecode(trim(I('get.end_time')));
        $utel        = trim(I('get.utel'));
        $jostyle     = trim(I('get.jostyle'));
        $jploss      = trim(I('get.ploss'));
        $status      = trim(I('get.status'));
        $option_name = trim(I('get.option_name'));
 
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
            $status = $status==1 ? '建仓':'平仓';
            $where['jtype'] = $status;
        }
        
        //交易品种筛选
        if($option_name) {
           $where['remarks'] = $option_name;
        }
        
        //普通会员列表
        $ship = M("UserinfoRelationship")->where(array('parent_user_id' => session('cuid')))->select();
        $shipArr = array();
        foreach ($ship as $key => $value) {
              array_push($shipArr,$value['user_id']);
        }
        $shipid = implode(',',$shipArr);
        $info = M("userinfo")->where('uid in ('.$shipid.')')->select();
        $this->assign('info',$info);
        
        //判断是否有筛选条件
        if(empty($user)) {

             $where['uid'] = array('in',$shipid);
        }
      

        $where['type'] = $type;       //区分真实和模拟交易

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
     * @functionname: order_list_gold
     * @author: FrankHong
     * @date: 2016-12-05 17:14:16
     * @description: 积分订单
     * @note:
     */
    public function order_list_gold()
    {

        $type    = '2';
        $journal = D('journal');
        $user = D('userinfo');
        $where = "";
          
         $user        = trim(I('get.user'));
         $starttime   = urldecode(trim(I('get.start_time')));
         $endtime     = urldecode(trim(I('get.end_time')));
         $utel        = trim(I('get.utel'));
         $jostyle     = trim(I('get.jostyle'));
         $jploss      = trim(I('get.ploss'));
         $status      = trim(I('get.status'));
         $option_name = trim(I('get.option_name'));
 
        //联动用户筛选
        if($user != ''){
            
            $id = $user; 
            $where['uid'] = array('in',$id);
            $sea['user'] = $user;
            $this->assign('user',$user);
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
        
        //普通会员列表
        $ship = M("UserinfoRelationship")->where(array('parent_user_id' => session('cuid')))->select();
        $shipArr = array();
        foreach ($ship as $key => $value) {
              array_push($shipArr,$value['user_id']);
        }
        $shipid = implode(',',$shipArr);
        $info = M("userinfo a")->field('a.uid,a.username,b.busername')->join('left join wp_bankinfo as b on a.uid = b.uid')->where('a.uid in ('.$shipid.')')->select();
        foreach ($info as $key => $value) {
            $info[$key]['username'] = !empty($value['busername']) ? $value['busername'] : $value['username'];
        }
        $this->assign('info',$info);
        
        //判断是否有筛选条件
        if(empty($user)) {

             $where['uid'] = array('in',$shipid);
        }
      

        $where['type'] = $type;       //区分真实和模拟交易
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
     * @functionname: order_detail
     * @author: FrankHong
     * @date: 2016-12-06 15:59:28
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
        $orderObj   = M('journal');
        $orderRs11    = $orderObj->where('jtype="平仓" and oid='.$orderId)->find();
        $orderRs1   = $orderObj->where('jtype="建仓" and oid='.$orderId)->find();
        $orderRs    = isset($orderRs11) ? $orderRs11 : $orderRs1;

        $userObj    = M('userinfo');
        $userRs     = $userObj->where('uid='.$orderRs['uid'])->find();
        
        $bankinfo   = M('bankinfo');
        $bankRs     = $bankinfo->where('uid='.$orderRs['uid'])->find();

        $order      = M('order');
        $ordreRs2   = $order->where('oid='.$orderRs['oid'])->find();

        $orderRs['nickname']    = $bankRs['busername'];
        $orderRs['buy_date']    = date('Y-m-d H:i:s', $orderRs1['jtime']);
        $time                   = $orderRs11 ? date('Y-m-d H:i:s',$orderRs11['jtime']) : '持仓中';
        $orderRs['sell_date']   = $time; 
        $orderRs['ploss']       = $orderRs11 ? $orderRs11['jploss'] : '持仓中';

        $orderRs['endprofit']   = $ordreRs2['endprofit'];
        $orderRs['endloss']     = $ordreRs2['endloss'];

        $orderRs['type_n']      = $orderRs['type'] == 1 ? '现金' : '积分';
        $orderRs['style_n']     = $orderRs['jostyle'] == 1 ? '<span class="label label-sm label-success">买跌</span>' : '<span class="label label-sm label-danger">买涨</span>';

        // $feeObj = M('fee_receive');
        // $feeRs  = $feeObj->field('profit_rmb')->where('order_id='.$orderId.' and type=1')->select();


        // if(!$feeRs)
        // {
        //     $orderRs['commission']  = 0;
        // }
        // else
        // {
        //     $orderRs['commission']  = array_sum($feeRs);
        // }


        if($orderRs['jploss'] > 0)
        {
            $orderRs['ploss_style'] = 'red';
        }
        if($orderRs['jploss'] < 0)
        {
            $orderRs['ploss_style'] = 'green';
        }


        $this->assign('orderRs', $orderRs);
        $this->display();
    }

        public function ajax_get_brokers(){
        if(IS_AJAX){
            $parent_id = I('get.parent_id',0,'intval');
            if($parent_id <1) $this->AjaxReturn(array('msg'=>'父级id不存在','status'=>0));
            $relationshipobj=M('userinfo_relationship');
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

            $where['uid']=array('IN',$ids);
            $userobj = M('userinfo');
            $res = $userobj->field('uid,username')->where($where)->order('uid DESC')->select();
            $data=array('msg'=>'成功','status'=>1,'data'=>$res);
            $this->AjaxReturn($data);
        }
        $this->error('您访问的页面不存在','index/index');
        
    }

    private function push($data,$name){
        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data,$name);
    }

}