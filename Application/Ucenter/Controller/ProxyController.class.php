<?php
/**
 * @author: FrankHong
 * @datetime: 2016/11/30 16:08
 * @filename: UserfController.class.php
 * @description: 运营中心用户模块
 * @note:
 *
 */

namespace Ucenter\Controller;


class ProxyfController extends CommonController
{

    /**
     * @functionname: user_list
     * @author: FrankHong
     * @date: 2016-11-30 17:15:22
     * @description: 运营中心下的所有用户列表
     * @note:
     */
    public function user_list()
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
        //vD($userIdStr);

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


        //需要从这里添加条件
        $userinfoWhereArr   = 'uid in ('.$userIdStr.')';


        $count      = $userinfoObj->where($userinfoWhereArr)->count();


        $pageObj    = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow   = $pageObj->show();

        $userinfoRs = $userinfoObj
            ->where($userinfoWhereArr)
            ->order('temptime desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();


        $userIdArr1     = array();
        $userinfoRs1    = array();
        foreach($userinfoRs as $k => $v)
        {
            $userinfoRs1[$v['uid']]                 = $v;
            $userinfoRs1[$v['uid']]['agent_name']   = $agentinfoRs1[$userRelArr[$v['uid']]['agent_id']]['nickname'];
            $userinfoRs1[$v['uid']]['agent_id']     = $userRelArr[$v['uid']]['agent_id'];
            array_push($userIdArr1, $v['uid']);
        }
        $userIdStr1 = implode(',', array_unique($userIdArr1));


        //bankinfo
        $bankinfoObj    = M('bankinfo');
        $bankinfoRs     = $bankinfoObj->where('uid in (' . $userIdStr1 . ')')->select();
        foreach ($bankinfoRs as $k => $v)
        {
            $bankinfoRs1[$v['uid']] = $v;
        }

        //vD($bankinfoRs1);

        //accountinfo
        $accountinfoObj = M('accountinfo');
        $accountinfoRs  = $accountinfoObj->where('uid in (' . $userIdStr1 . ')')->select();
        foreach ($accountinfoRs as $k => $v)
        {
            $accountinfoRs1[$v['uid']] = $v;
        }


        //total_balance
        $mObj   = M();
        $moneyTotalRs   = $mObj->table('view_account_info_in')->where('uid in (' . $userIdStr1 . ')')->select();
        foreach($moneyTotalRs as $k => $v)
        {
            $moneyTotalRs1[$v['uid']]   = $v;
        }


        //费率
        $currencyRs     = get_setting_config('find', 'SYSTEM_CURRENCY_TYPE');
        $currencyRs1    = $currencyRs['datas'];

        //订单
        $orderObj       = M('order');
        $orderWhereStr  = 'uid in ('.$userIdStr.')';

        $orderRs        = $orderObj->table('view_wp_orders')->where($orderWhereStr)->select();

        $orderRs1       = array();
        foreach($orderRs as $k => $v)
        {
            $orderRs1[$v['oid']]            = $v;
            $orderRs1[$v['oid']]['rate']    = $currencyRs1[$v['currency']]['rate'];
        }

        foreach($orderRs1 as $k => $v)
        {
            $commissionTotalRs1[$v['uid']][]= $v['rate'] * $v['fee'];
        }

        foreach($commissionTotalRs1 as $k => $v)
        {
            $totalCommission[$k]    = array_sum($v);
        }


        foreach($userinfoRs1 as $k => $v)
        {
            $userinfoRs2[$k]                = $v;
            $userinfoRs2[$k]['last_login']  = !empty($v['lastlog']) ? date('Y-m-d H:i:s', $v['lastlog']) : '<span class="label label-sm label-warning">未登录过</span>';
            $userinfoRs2[$k]['create_date'] = date('Y-m-d H:i:s', $v['utime']);

            $userinfoRs2[$k]['name']        = $bankinfoRs1[$v['uid']]['busername'];

            $userinfoRs2[$k]['money_remain']    = $accountinfoRs1[$v['uid']]['balance'];
            $userinfoRs2[$k]['money_total']     = $accountinfoRs1[$v['uid']]['money_total'];
            $userinfoRs2[$k]['gold']            = $accountinfoRs1[$v['uid']]['gold'];

            $userinfoRs2[$k]['amount_total']    = !empty($moneyTotalRs1[$v['uid']]['money_total']) ? $moneyTotalRs1[$v['uid']]['money_total'] : 0;
            $userinfoRs2[$k]['total_commission']= !empty($totalCommission[$v['uid']]) ? $totalCommission[$v['uid']] : 0;

            $userinfoRs2[$k]['status_name']     = $v['ustatus'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';

            $userinfoRs2[$k]['status_o']        = $v['ustatus'] == 0 ? '冻结' : '激活';
            $userinfoRs2[$k]['status_s']        = $v['ustatus'] == 0 ? 1 : 0;
        }



        //echo $pageObj->firstRow,$pageObj->listRows;

        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('userInfo', $userinfoRs2);
        $this->assign('totalCount', $count);

        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }


    /**
     * @functionname: user_detail
     * @author: FrankHong
     * @date: 2016-11-30 19:35:57
     * @description: 用户的详细信息
     * @note:
     */
    public function user_detail()
    {
        $userId = I('get.user_id');
        if(!$userId)
        {
            $this->display('Common/error_not_found');
            die();
        }

        $mObj   = M();

        //用户信息
        $userinfoObj        = M('userinfo');
        $userinfoWhereArr   = 'uid='.$userId;
        $userinfoRs         = $userinfoObj->where($userinfoWhereArr)->find();


        //银行卡信息
        $bankinfoObj    = M('bankinfo');
        $bankinfoRs     = $bankinfoObj->where('uid='.$userinfoRs['uid'])->find();

        $userinfoRs['u_bankname']   = !empty($bankinfoRs['bankname']) ? $bankinfoRs['bankname'] : '未填写';
        $userinfoRs['u_banknumber'] = !empty($bankinfoRs['banknumber']) ? $bankinfoRs['banknumber'] : '未填写';
        $userinfoRs['u_busername']  = !empty($bankinfoRs['busername']) ? $bankinfoRs['busername'] : '未填写';
        $userinfoRs['u_card']       = !empty($bankinfoRs['card']) ? $bankinfoRs['card'] : '未填写';

        $userinfoRs['status_n'] = $userinfoRs['ustatus'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';
        $userinfoRs['u_reg_time']       = date('Y-m-d H;i:s', $userinfoRs['utime']);

        $userinfoRs['u_lastlog_time']   = !empty($userinfoRs['lastlog']) ? date('Y-m-d H:i:s', $userinfoRs['lastlog']) : '<span class="label label-sm label-warning">未登录过</span>';
        $userinfoRs['u_reg_ip']         = !empty($userinfoRs['reg_ip']) ? $userinfoRs['reg_ip'] : '无';
        $userinfoRs['u_last_login_ip']  = !empty($userinfoRs['last_login_ip']) ? $userinfoRs['last_login_ip'] : '无';


        //资金帐户
        $accountinfoObj = M('accountinfo');
        $accountinfoRs  = $accountinfoObj->where('uid=' . $userinfoRs['uid'])->find();

        $userinfoRs['real_account']     = !empty($accountinfoRs['balance']) ? $accountinfoRs['balance'] : 0.00;
        $userinfoRs['gold_account']     = !empty($accountinfoRs['gold']) ? $accountinfoRs['gold'] : 0.00;

        //可提佣金
        $extensionObj   = M('extension');
        $extensionRs    = $extensionObj->where('user_id='.$userId)->find();
        $userinfoRs['commission_available'] = !empty($extensionRs['money']) ? $extensionRs['money'] : 0.00;


        //累计充值
        $moneyInRs              = $mObj->table('view_account_info_in')->where('uid=' . $userinfoRs['uid'])->find();
        $userinfoRs['money_in'] = !empty($moneyInRs['money_total']) ? $moneyInRs['money_total'] : 0.00;
        //累计取出
        $moneyOutRs             = $mObj->table('view_account_info_out')->where('uid=' . $userinfoRs['uid'])->find();
        $userinfoRs['money_out']= !empty($moneyOutRs['money_total']) ? $moneyOutRs['money_total'] : 0.00;

        //累计盈亏
        $moneyReal  = $mObj->table('view_order_real')->where('uid=' . $userinfoRs['uid'])->find();
        $moneyGold  = $mObj->table('view_order_gold')->where('uid=' . $userinfoRs['uid'])->find();
        $userinfoRs['money_real']       = !empty($moneyReal['money_total']) ? $moneyReal['money_total'] : 0.00;
        $userinfoRs['money_gold']       = !empty($moneyGold['money_total']) ? $moneyGold['money_total'] : 0.00;


        if($userinfoRs['money_real'] > 0)
        {
            $userinfoRs['money_real']   = '<b class="text-danger">'.$userinfoRs['money_real'].'</b>';
        }

        if($userinfoRs['money_real'] < 0)
        {
            $userinfoRs['money_real']   = '<b class="text-success">'.$userinfoRs['money_real'].'</b>';
        }


        //累计手续费
        $commissionTotalRs              = $mObj->table('view_order_user_fee_real')->where('uid=' . $userinfoRs['uid'])->find();
        $userinfoRs['money_fee_real']   = !empty($commissionTotalRs['total_commission']) ? $commissionTotalRs['total_commission'] : 0.00;
        $commissionTotalRs              = $mObj->table('view_order_user_fee_gold')->where('uid=' . $userinfoRs['uid'])->find();
        $userinfoRs['money_fee_gold']   = !empty($commissionTotalRs['total_commission']) ? $commissionTotalRs['total_commission'] : 0.00;



        //累计佣金
        $feeTotalRs                     = $mObj->table('view_user_commission')->where('uid='.$userinfoRs['uid'])->find();
        $userinfoRs['money_commission'] = !empty($feeTotalRs['total_commission']) ? $feeTotalRs['total_commission'] : 0.00;




//        //获取所有佣金
//        $feeObj = M('fee_receive');
//
//        $feeWhereArr    = 'type = 1 and user_id='.$userId;
//        $feeRs          = $feeObj->where($feeWhereArr)->select();
//
//        //汇率
//        $systemCurrency = M('currency')->select();
//        $currencyRs     = get_setting_config('find', 'SYSTEM_CURRENCY_TYPE');
//        $currencyRs1    = $currencyRs['datas'];

        $this->assign('moneyInRs', $moneyInRs);
        $this->assign('moneyOutRs', $moneyOutRs);
        $this->assign('userinfoRs', $userinfoRs);
        $this->assign('bankinfoRs', $bankinfoRs);
        $this->display();
    }


    /**
     * @functionname: opt_user_status
     * @author: FrankHong
     * @date: 2016-12-02 20:28:24
     * @description: 操作用户的状态
     * @note:
     */
    public function opt_user_status()
    {
        $userId             = I('post.user_id', 0);
        $userStatus         = I('post.user_status', '');

        if(!$userId)
            outjson(array('status' => 0, 'ret_msg' => '参数错误'));

        $dataArr            = array();
        $dataArr['ustatus'] = $userStatus;


        $userinfoObj        = M('userinfo');
        $userInfoWhere      = 'uid='.$userId;
        $flag               = $userinfoObj->where($userInfoWhere)->save($dataArr);


        if($flag)
            outjson(array('status' => 1, 'ret_msg' => '操作成功'));
        else
            outjson(array('status' => 0, 'ret_msg' => '操作失败'));
    }


}