<?php
/**
 * @author: FrankHong
 * @datetime: 2016/11/30 16:08
 * @filename: IndexsController.class.php
 * @description: 经纪人首页，主做统计
 * @note: 
 * 
 */

namespace Ucenter\Controller;


class IndexsController extends CommonController
{

    public function index()
    {
        $mObj       = M();
        $returnRs   = array();

        $userinfoRelationshipObj    = M('userinfo_relationship');

        //经纪人用户信息
        $userinfoObj    = M('userinfo');
        // $proxyInfoArr   = 'uid='.NOW_UID;
        // $proxyInfoRs    = $userinfoObj->where($proxyInfoArr)->find();


        //用户
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $userinfoRelationshipRs = $userinfoRelationshipObj->field('user_id')->where($whereArr)->select();

        $userIdArr  = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
        }
        $userIdStr  = implode(',', array_unique($userIdArr));

        $userinfoWhereArr   = 'uid in ('.$userIdStr.')';

        $userinfoRs     = $userinfoObj->field('uid')->where($userinfoWhereArr)->select();
        // $userinfoRs1    = array();
        // foreach($userinfoRs as $k => $v)
        // {
        //     $userinfoRs1[$v['uid']]    = $v;
        // }
        $returnRs['user_total']= empty($userinfoRs) ? 0 : count($userinfoRs);


        //需要从这里添加条件
        $userinfoWhereArr   = 'uid in ('.$userIdStr.')';
        $orderRs            = $mObj->field('jploss')->table('view_wp_journal')->where($userinfoWhereArr)->select();

        $totalMoney = array();
        foreach($orderRs as $k =>$v)
        {
            array_push($totalMoney, $v['jploss']);
        }

        $returnRs['total_money']    = number_format(array_sum($totalMoney),2) ;

        //手续费  总金额  订单个数
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

        $returnRs['account']        = number_format($accountinfoRs['balance']);

        //佣金
        $feeObj = M('fee_receive');

        $feeWhereArr    = 'type = 1  and user_id in ('.$userIdStr.')';
        $feeRs          = $feeObj->field('profit_rmb')->where($feeWhereArr)->select();
        $totalCommission= array();
        foreach($feeRs as $k => $v)
        {
            array_push($totalCommission, $v['profit_rmb']);
        }
        $returnRs['total_commission']  = number_format(array_sum($totalCommission),2);


        //本月交易信息统计
        
//        $orderWeek = $mObj->table('view_wp_journal')->where("uid in(".$userIdStr.") and YEARWEEK(FROM_UNIXTIME(jtime,'%Y-%m-%d %H:%i:%s')) = YEARWEEK(now())")->select();

        $orderWeek = $mObj->table('view_wp_journal')->where("uid in(".$userIdStr.") and DATE_FORMAT(FROM_UNIXTIME(jtime),'%Y%m') = DATE_FORMAT(CURDATE(), '%Y%m')")->select();

        $totalmoneyWeek = array();

        foreach($orderWeek as $k =>$v)
        {
            array_push($totalmoneyWeek, $v['jploss']);
        }

        $returnWeek['total_money']    = number_format(array_sum($totalmoneyWeek),2) ;


        //手续费  总金额  订单个数
//        $orderFeeWeek            =  $mObj->table('view_wp_journal_jian')->where("uid in(".$userIdStr.") and YEARWEEK(FROM_UNIXTIME(jtime,'%Y-%m-%d %H:%i:%s')) = YEARWEEK(now())")->select();
        $orderFeeWeek            =  $mObj->table('view_wp_journal_jian')->where("uid in(".$userIdStr.") and DATE_FORMAT(FROM_UNIXTIME(jtime),'%Y%m') = DATE_FORMAT(CURDATE(), '%Y%m')")->select();

        $totalFeeWeek   = array();
        $totalCountWeek = array();

        foreach ($orderFeeWeek as $key => $v) {
            array_push($totalFeeWeek, $v['jfee']);
            array_push($totalCountWeek, $v['juprice']+$v['jfee']);
        }

        $returnWeek['total_fee']      = number_format(array_sum($totalFeeWeek),2);
        $returnWeek['total_count']    = number_format(array_sum($totalCountWeek),2);
        $returnWeek['order_total']    = empty($orderFeeWeek) ? 0 : count($orderFeeWeek);


        //自己获得佣金
//        $feeWhereWeek   = "type = 3  and user_id in (".NOW_UID.") and YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s')) = YEARWEEK(now())";
        $feeWhereWeek   = "type = 3  and user_id in (".NOW_UID.") and DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y%m') = DATE_FORMAT(CURDATE(), '%Y%m')";

        $feeWeek          = $feeObj->where($feeWhereWeek)->select();
        $totalWeek= array();
        foreach($feeWeek as $k => $v)
        {
            array_push($feeWeek, $v['profit_rmb']);
        }
        $returnWeek['total_commission']  = number_format(array_sum($feeWeek),2);

        //下面的用户获得佣金
//        $feeWhereArrWeek    = "type = 1  and user_id in (".$userIdStr.") and YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s')) = YEARWEEK(now())";
        $feeWhereArrWeek    = "type = 1  and user_id in (".$userIdStr.") and DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y%m') = DATE_FORMAT(CURDATE(), '%Y%m')";
  
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