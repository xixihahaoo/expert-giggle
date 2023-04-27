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


class OrderfController extends CommonController
{
    /**
     * @functionname: order_list
     * @author: FrankHong
     * @date: 2016-12-03 14:18:26
     * @description: 运营中心订单列表--现金订单
     * @note:
     *
     * 1.所有经纪人
     * 2.所有用户
     * 3.所有订单
     */
    public function order_list()
    {
        $userinfoRelationshipObj    = M('userinfo_relationship');

        //经纪人
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $agentinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

        $agentIdArr  = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
        }
        $agentIdStr  = implode(',', array_unique($agentIdArr));

        $userinfoObj        = M('userinfo');
        $agentinfoWhereArr  = 'uid in ('.$agentIdStr.')';

        $agentinfoRs    = $userinfoObj->where($agentinfoWhereArr)->select();
        $agentinfoRs1   = array();
        foreach($agentinfoRs as $k => $v)
        {
            $agentinfoRs1[$v['uid']]    = $v;
        }

        //用户
        $userinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$agentIdStr.')')->select();

        $userIdArr      = array();
        $userRelArr     = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
            $userRelArr[$v['user_id']]['agent_id']  = $v['parent_user_id'];
        }
        $userIdStr      = implode(',', array_unique($userIdArr));


        $orderObj       = M('order');
        $orderWhereStr  = 'uid in ('.$userIdStr.') and type=1';


        $count      = $orderObj->where($orderWhereStr)->count();
        $pageObj    = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow   = $pageObj->show();

        $orderRs    = $orderObj
            ->where($orderWhereStr)
            ->order('tempdate desc, oid desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        $orderRs1   = array();
        $userIdArr  = array();
        $orderIdArr = array();
        foreach($orderRs as $k => $v)
        {
            array_push($userIdArr, $v['uid']);
            array_push($orderIdArr, $v['oid']);

            $orderRs1[$v['oid']]                = $v;
            $orderRs1[$v['oid']]['status_n']    = $v['ostaus'] == 1 ? '结算完成' : '持仓中';
            $orderRs1[$v['oid']]['style_n']     = $v['ostyle'] == 1 ? '看空' : '看多';
            $orderRs1[$v['oid']]['sell_date']   = !empty($v['selltime']) && $v['selltime'] != 0 ? date('Y-m-d H:i:s', $v['selltime']) : ' ';
            $orderRs1[$v['oid']]['buy_date']    = !empty($v['buytime']) && $v['buytime'] != 0 ? date('Y-m-d H:i:s', $v['buytime']) : ' ';
        }

        $userIdStr      = implode(',', array_unique($userIdArr));
        $orderUserRs    = $userinfoObj->where('uid in ('.$userIdStr.')')->select();
        foreach($orderUserRs as $k => $v)
        {
            $orderUserRs1[$v['uid']]    = $v;
        }

        $bankinfo    = M('bankinfo')->where('uid in ('.$userIdStr.')')->select();
        foreach($bankinfo as $k => $v)
        {
            $orderUserRs2[$v['uid']]    = $v;
        }


        $orderIdStr     = implode(',', array_unique($orderIdArr));

        //佣金
        $feeObj = M('fee_receive');
        $feeRs  = $feeObj->where('order_id in ('.$orderIdStr.')')->select();

        $feeTotalArr    = array();
        $feeUserArr     = array();
        foreach($feeRs as $k => $v)
        {
            if($v['user_id'] == NOW_UID)
            {
                $feeTotalArr[$v['order_id']]    = $v['surplus'];
            }

            if($v['type'] == 1)
            {
                $feeUserArr[$v['order_id']][]  = $v['profit'];
            }
        }

//        vD($feeUserArr);

        //获得所有商品
        $optionObj  = M('option');
        $optionRs   = $optionObj->select();
        foreach($optionRs as $k => $v)
        {
            $optionRs1[$v['id']]    = $v;
        }

        foreach($orderRs1 as $k => $v)
        {
            $orderRs2[$k]                   = $v;
            $orderRs2[$k]['u_name']         = $orderUserRs1[$v['uid']]['nickname'];
            $orderRs2[$k]['utel']           = $orderUserRs1[$v['uid']]['utel'];
            $orderRs2[$k]['busername']      = $orderUserRs2[$v['uid']]['busername'];
            $orderRs2[$k]['money_float']    = $v['ostaus'] == 0 ? $v['ploss'] : '';
            $orderRs2[$k]['money_finish']   = $v['ostaus'] == 1 ? $v['ploss'] : '';


            $orderRs2[$k]['fee_s1']         = !empty($feeUserArr[$k][0]) ? $feeUserArr[$k][0] : 0.00;
            $orderRs2[$k]['fee_s2']         = !empty($feeUserArr[$k][1]) ? $feeUserArr[$k][1] : 0.00;

            $orderRs2[$k]['fee_s']          = $orderRs2[$k]['fee_s1'] . '/' . $orderRs2[$k]['fee_s2'];

            $orderRs2[$k]['option_name']    = $optionRs1[$v['pid']]['capital_name'];

        }

        //vD($orderRs2);

        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('orderRs', $orderRs2);
        $this->assign('totalCount', $count);

        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
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
        $userinfoRelationshipObj    = M('userinfo_relationship');

        //经纪人
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $agentinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

        $agentIdArr  = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
        }
        $agentIdStr  = implode(',', array_unique($agentIdArr));

        $userinfoObj        = M('userinfo');
        $agentinfoWhereArr  = 'uid in ('.$agentIdStr.')';

        $agentinfoRs    = $userinfoObj->where($agentinfoWhereArr)->select();
        $agentinfoRs1   = array();
        foreach($agentinfoRs as $k => $v)
        {
            $agentinfoRs1[$v['uid']]    = $v;
        }

        //用户
        $userinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$agentIdStr.')')->select();

        $userIdArr      = array();
        $userRelArr     = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
            $userRelArr[$v['user_id']]['agent_id']  = $v['parent_user_id'];
        }
        $userIdStr      = implode(',', array_unique($userIdArr));

        $orderObj       = M('order');
        $orderWhereStr  = 'uid in ('.$userIdStr.') and type=2';


        $count      = $orderObj->where($orderWhereStr)->count();
        $pageObj    = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow   = $pageObj->show();

        $orderRs    = $orderObj
            ->where($orderWhereStr)
            ->order('tempdate desc, oid desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        $orderRs1   = array();
        $userIdArr  = array();
        $orderIdArr = array();
        foreach($orderRs as $k => $v)
        {
            array_push($userIdArr, $v['uid']);
            array_push($orderIdArr, $v['oid']);

            $orderRs1[$v['oid']]                = $v;
            $orderRs1[$v['oid']]['status_n']    = $v['ostaus'] == 1 ? '结算完成' : '持仓中';
            $orderRs1[$v['oid']]['style_n']     = $v['ostyle'] == 1 ? '看空' : '看多';
            $orderRs1[$v['oid']]['sell_date']   = !empty($v['selltime']) && $v['selltime'] != 0 ? date('Y-m-d H:i:s', $v['selltime']) : ' ';
            $orderRs1[$v['oid']]['buy_date']    = !empty($v['buytime']) && $v['buytime'] != 0 ? date('Y-m-d H:i:s', $v['buytime']) : ' ';
        }

        $userIdStr      = implode(',', array_unique($userIdArr));
        $orderUserRs    = $userinfoObj->where('uid in ('.$userIdStr.')')->select();
        foreach($orderUserRs as $k => $v)
        {
            $orderUserRs1[$v['uid']]    = $v;
        }

        $bankinfo    = M('bankinfo')->where('uid in ('.$userIdStr.')')->select();
        foreach($bankinfo as $k => $v)
        {
            $orderUserRs2[$v['uid']]    = $v;
        }


        $orderIdStr     = implode(',', array_unique($orderIdArr));

        //佣金
        $feeObj = M('fee_receive');
        $feeRs  = $feeObj->where('order_id in ('.$orderIdStr.')')->select();

        $feeTotalArr    = array();
        $feeUserArr     = array();
        foreach($feeRs as $k => $v)
        {
            if($v['user_id'] == NOW_UID)
            {
                $feeTotalArr[$v['order_id']]    = $v['surplus'];
            }

            if($v['type'] == 1)
            {
                $feeUserArr[$v['order_id']][]  = $v['profit'];
            }
        }

//        vD($feeUserArr);

        //获得所有商品
        $optionObj  = M('option');
        $optionRs   = $optionObj->select();
        foreach($optionRs as $k => $v)
        {
            $optionRs1[$v['id']]    = $v;
        }

        foreach($orderRs1 as $k => $v)
        {
            $orderRs2[$k]                   = $v;
            $orderRs2[$k]['u_name']         = $orderUserRs1[$v['uid']]['nickname'];
            $orderRs2[$k]['utel']           = $orderUserRs1[$v['uid']]['utel'];
            $orderRs2[$k]['busername']      = $orderUserRs2[$v['uid']]['busername'];
            $orderRs2[$k]['money_float']    = $v['ostaus'] == 0 ? $v['ploss'] : '';
            $orderRs2[$k]['money_finish']   = $v['ostaus'] == 1 ? $v['ploss'] : '';


            $orderRs2[$k]['fee_s1']         = !empty($feeUserArr[$k][0]) ? $feeUserArr[$k][0] : 0.00;
            $orderRs2[$k]['fee_s2']         = !empty($feeUserArr[$k][1]) ? $feeUserArr[$k][1] : 0.00;

            $orderRs2[$k]['fee_s']          = $orderRs2[$k]['fee_s1'] . '/' . $orderRs2[$k]['fee_s2'];

            $orderRs2[$k]['option_name']    = $optionRs1[$v['pid']]['capital_name'];


        }

        //vD($orderRs2);

        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('orderRs', $orderRs2);
        $this->assign('totalCount', $count);

        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
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



        $feeObj = M('fee_receive');
        $feeRs  = $feeObj->field('profit_rmb')->where('order_id='.$orderId.' and type=1')->select();


        if(!$feeRs)
        {
            $orderRs['commission']  = 0;
        }
        else
        {
            $orderRs['commission']  = array_sum($feeRs);
        }


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

}