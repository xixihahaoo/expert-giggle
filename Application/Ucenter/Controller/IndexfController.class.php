<?php
/**
 * @author: FrankHong
 * @datetime: 2016/11/30 16:08
 * @filename: IndexfController.class.php
 * @description: 运营中心首页，主做统计
 * @note: 
 * 
 */

namespace Ucenter\Controller;


class IndexfController extends CommonController
{

    public function index()
    {

        $mObj       = M();
        $returnRs   = array();

        $userinfoRelationshipObj    = M('userinfo_relationship');

        //运营中心用户信息
        $userinfoObj    = M('userinfo');
        // $proxyInfoArr   = 'uid='.NOW_UID;
        // $proxyInfoRs    = $userinfoObj->where($proxyInfoArr)->find();


        //经纪人
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $agentinfoRelationshipRs    = $userinfoRelationshipObj->field('user_id')->where($whereArr)->select();

        $agentIdArr = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
        }
        $agentIdStr  = implode(',', array_unique($agentIdArr));

        $agentinfoWhereArr  = 'uid in ('.$agentIdStr.')';

        $agentinfoRs    = $userinfoObj->field('uid')->where($agentinfoWhereArr)->select();
        // $agentinfoRs1   = array();
        // foreach($agentinfoRs as $k => $v)
        // {
        //     $agentinfoRs1[$v['uid']]    = $v;
        // }
        $returnRs['agent_total']= count($agentinfoRs);

        //用户
        $userinfoRelationshipRs = $userinfoRelationshipObj->field('user_id,parent_user_id')->where('parent_user_id in ('.$agentIdStr.')')->select();
        $returnRs['user_total'] = count($userinfoRelationshipRs);

        $userIdArr      = array();
        $userRelArr     = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
            $userRelArr[$v['user_id']]['agent_id']  = $v['parent_user_id'];
        }
        $userIdStr      = implode(',', array_unique($userIdArr));

        //vD($userIdStr);


        //需要从这里添加条件
        $userinfoWhereArr   = 'uid in ('.$userIdStr.')';
        $orderRs            = $mObj->field('jploss')->table('view_wp_journal')->where($userinfoWhereArr)->select();
     
        $totalMoney = array();
        foreach($orderRs as $k =>$v)
        {
            // $orderRs1[$v['oid']]    = $v;
            array_push($totalMoney, $v['jploss']);
        }

        $returnRs['total_money']    = number_format(array_sum($totalMoney),2) ;


        //总金额  手续费  订单个数
        $orderFee            = $mObj->field('jfee,juprice')->table('view_wp_journal_jian')->where($userinfoWhereArr)->select();

        $totalFee   = array();
        $totalCount = array();

        foreach ($orderFee as $key => $v) {
            array_push($totalFee, $v['jfee']);
            array_push($totalCount, $v['juprice']+$v['jfee']);
        }

        $returnRs['total_fee']      = number_format(array_sum($totalFee),2);
        $returnRs['total_count']    = number_format(array_sum($totalCount),2);
        $returnRs['order_total']    = count($orderFee);


        //保证金
        $accountinfoObj = M('accountinfo');
        $accountinfoRs  = $accountinfoObj->field('balance')->where('uid=' . NOW_UID)->find();

        $returnRs['account']        = number_format($accountinfoRs['balance'],2);

        //手续费
        $feeObj = M('fee_receive');

        $feeWhereArr    = 'type = 3 and status = 1 and user_id in ('.NOW_UID.')';
        $feeRs          = $feeObj->field('order_id,profit_rmb')->where($feeWhereArr)->select();
        $totalCommission= array();
        $orderIdArr = array();
        foreach($feeRs as $k => $v)
        {
            array_push($totalCommission, $v['profit_rmb']);
            array_push($orderIdArr,$v['order_id']);
        }
        $returnRs['total_commission']  = number_format(array_sum($totalCommission),2);


        //自己获取的佣金
        // $order_id = implode(',',array_unique($orderIdArr));
        // $feeWhereArr    = 'type = 1 and order_id in('.$order_id.')';
        // $feeRs          = $feeObj->where($feeWhereArr)->select();
        // $totalCommissionSell= array();
        // foreach($feeRs as $k => $v)
        // {
        //     array_push($totalCommissionSell, $v['profit_rmb']);
        // }
        // $returnRs['sell_commission']  = $returnRs['total_commission'] - (number_format(array_sum($totalCommissionSell),2));


        //下面的用户获得佣金

        $feeWhereArr    = 'type = 1 and user_id in ('.$userIdStr.')';
        $feeRs          = $feeObj->field('profit_rmb')->where($feeWhereArr)->select();
        $totalCommissionUser= array();
        foreach($feeRs as $k => $v)
        {
            array_push($totalCommissionUser, $v['profit_rmb']);
        }
        $returnRs['total_user_commission']  = number_format(array_sum($totalCommissionUser),2);
        

        //本周交易信息统计
        
        $orderWeek = $mObj->table('view_wp_journal')->where("uid in(".$userIdStr.") and YEARWEEK(FROM_UNIXTIME(jtime,'%Y-%m-%d %H:%i:%s')) = YEARWEEK(now())")->select();

        $totalmoneyWeek = array();
        foreach($orderWeek as $k =>$v)
        {
            array_push($totalmoneyWeek, $v['jploss']);
        }

        $returnWeek['total_money']    = number_format(array_sum($totalmoneyWeek),2) ;


        //手续费  总金额  订单个数
        $orderFeeWeek            =  $mObj->table('view_wp_journal_jian')->where("uid in(".$userIdStr.") and YEARWEEK(FROM_UNIXTIME(jtime,'%Y-%m-%d %H:%i:%s')) = YEARWEEK(now())")->select();

        $totalFeeWeek   = array();
        $totalCountWeek = array();

        foreach ($orderFeeWeek as $key => $v) {
            array_push($totalFeeWeek, $v['jfee']);
            array_push($totalCountWeek, $v['juprice']+$v['jfee']);
        }

        $returnWeek['total_fee']      = number_format(array_sum($totalFeeWeek),2);
        $returnWeek['total_count']    = number_format(array_sum($totalCountWeek),2);
        $returnWeek['order_total']    = empty($orderFeeWeek) ? 0 : count($orderFeeWeek);


        //手续费
        $feeWhereWeek   = "type = 3 and status = 1 and user_id in (".NOW_UID.") and YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s')) = YEARWEEK(now())";
        $feeWeek          = $feeObj->where($feeWhereWeek)->select();
        $totalWeek= array();
        $orderIdWeek = array();
        foreach($feeWeek as $k => $v)
        {
            array_push($feeWeek, $v['profit_rmb']);
            array_push($orderIdWeek,$v['order_id']);
        }
        $returnWeek['total_commission']  = number_format(array_sum($feeWeek),2);

        //自己获取的佣金
        $order_id = implode(',',array_unique($orderIdWeek));
        $feeWhereArr    = 'type = 1 and order_id in('.$order_id.') and YEARWEEK(FROM_UNIXTIME(create_time,"%Y-%m-%d %H:%i:%s")) = YEARWEEK(now())';
        $feeRs          = $feeObj->where($feeWhereArr)->select();
        $totalCommissionSell= array();
        foreach($feeRs as $k => $v)
        {
            array_push($totalCommissionSell, $v['profit_rmb']);
        }
        $returnWeek['sell_commission']  = $returnWeek['total_commission'] - (number_format(array_sum($totalCommissionSell),2));


        //用户推广佣金
        $feeWhereArrWeek    = "type = 1 and user_id in (".$userIdStr.") and YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s')) = YEARWEEK(now())";
        $feeRsWeek          = $feeObj->where($feeWhereArrWeek)->select();
        $totalCommissionWeek= array();
        foreach($feeRsWeek as $k => $v)
        {
            array_push($totalCommissionWeek, $v['profit_rmb']);
        }
        $returnWeek['total_user_commission']  = number_format(array_sum($totalCommissionWeek),2);

        $this->assign('returnWeek',$returnWeek);
        $this->assign('returnRs', $returnRs);
        $this->display();
    }


}