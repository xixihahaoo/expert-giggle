<?php

namespace Branch\Controller;

class AgentController extends CommonController
{
	/**
	* 机构列表
	* @author wang admin
	**/
	public function index()
	{
        /**
         * get area
         */
        $agentId    = I('get.agent_id', '');
        $username   = I('get.username', '');
        $operate   	= I('get.operate', '');


        //运营中心
        $userinfoRelationshipObj = M('userinfo_relationship');

        $whereArr = array(
                'parent_user_id' => NOW_UID
        );
        $userinfoRelationshipRs = $userinfoRelationshipObj->where($whereArr)->select();

        $userIdArr = array();
        foreach ($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
        }

        $userIdStr = implode(',', array_unique($userIdArr));


        //经纪人
        $agentRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$userIdStr.')')->select();

        $agentIdArr = array();
        $operateArr = array();
        $parentArr 	= array();
        foreach ($agentRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
            array_push($operateArr, $v['parent_user_id']);
            $parentArr[$v['user_id']] = $v;
        }

        $userIdStr 	  = implode(',', array_unique($agentIdArr));
        $operateIdStr = implode(',', array_unique($operateArr));


        $operateData 	= M('userinfo')->field('uid,username')->where('uid in('.$operateIdStr.')')->select();
        $operateDataArr = array();
        foreach ($operateData as $key => $value) {
        	$operateDataArr[$value['uid']] = $value;
        }



        $userinfoObj = M('userinfo');

        $userinfoWhereArr = 'uid in (' . $userIdStr . ')';


        if($agentId)
            $userinfoWhereArr   = 'uid in (' . $userIdStr . ')'.' and uid='.$agentId;

        if($username)
            $userinfoWhereArr   = 'uid in (' . $userIdStr . ')'." and username like '".$username."%'";

        $count = $userinfoObj->where($userinfoWhereArr)->count();


        $pageObj = new \Think\Pageace($count, 15);
        $pageShow = $pageObj->show();

        $userinfoRs = $userinfoObj
            ->where($userinfoWhereArr)
            ->order('temptime desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        $userIdArr1 = array();
        foreach ($userinfoRs as $k => $v) {
            $userinfoRs[$k]['last_login'] = !empty($v['lastlog']) ? date('Y-m-d H:i:s', $v['lastlog']) : '<span class="label label-sm label-warning">未登录过</span>';
            $userinfoRs[$k]['create_date'] = date('Y-m-d H:i:s', $v['utime']);
            array_push($userIdArr1, $v['uid']);
        }
        $userIdStr1 = implode(',', array_unique($userIdArr1));

        //bankinfo
        $bankinfoObj = M('bankinfo');
        $bankinfoRs = $bankinfoObj->where('uid in (' . $userIdStr1 . ')')->select();

        foreach ($bankinfoRs as $k => $v) {
            $bankinfoRs1[$v['uid']] = $v;
        }

        //accountinfo
        $accountinfoObj = M('accountinfo');
        $accountinfoRs = $accountinfoObj->where('uid in (' . $userIdStr1 . ')')->select();

        foreach ($accountinfoRs as $k => $v) {
            $accountinfoRs1[$v['uid']] = $v;
        }



        $s_domain   = SYSTEM_DOMAIN;


        //************************
        $userinfoRs1 = array();
        foreach ($userinfoRs as $k => $v)
        {
            $userinfoRs1[$v['uid']] = $v;
            $userinfoRs1[$v['uid']]['name'] = $bankinfoRs1[$v['uid']]['busername'];

            $userinfoRs1[$v['uid']]['money_remain'] = $accountinfoRs1[$v['uid']]['balance'];
            $userinfoRs1[$v['uid']]['money_total'] = $accountinfoRs1[$v['uid']]['money_total'];

            $userinfoRs1[$v['uid']]['status_name']  = $v['ustatus'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';

            $userinfoRs1[$v['uid']]['status_o']     = $v['ustatus'] == 0 ? '冻结' : '激活';
            $userinfoRs1[$v['uid']]['status_s']     = $v['ustatus'] == 0 ? 1 : 0;

            $userinfoRs1[$v['uid']]['operat_name'] = $operateDataArr[$parentArr[$v['uid']]['parent_user_id']]['username'];  //上级
        }

        $nowStart = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;



        $this->assign('userInfo', $userinfoRs1);
        $this->assign('totalCount', $count);


        //get area
        $this->assign('agentId', $agentId);
        $this->assign('username', $username);


        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
	}



    /**
     * @functionname: opt_user_status
     * @author: wang
     * @description: 操作用的状态
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


        /**
     * @functionname: agent_detail
     * @author: wang
     * @date: 2017-5-28 19:35:57
     * @description: 经纪人的详细信息
     * @note:
     */
    public function agent_detail()
    {
        $agentId    = I('get.agent_id', '');
        if(!$agentId)
        {
            $this->display('Common/error_not_found');
            die();
        }

        $userinfoObj        = M('userinfo');
        $userinfoWhereArr   = 'uid='.$agentId;

        $userinfoRs         = $userinfoObj->where($userinfoWhereArr)->find();

        $userinfoRs['status_n'] = $userinfoRs['ustatus'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';
        $userinfoRs['u_reg_time']       = date('Y-m-d H;i:s', $userinfoRs['utime']);


        $userinfoRs['u_lastlog_time']   = !empty($userinfoRs['lastlog']) ? date('Y-m-d H:i:s', $userinfoRs['lastlog']) : '<span class="label label-sm label-warning">未登录过</span>';
        $userinfoRs['u_reg_ip']         = !empty($userinfoRs['reg_ip']) ? $userinfoRs['reg_ip'] : '无';
        $userinfoRs['u_last_login_ip']  = !empty($userinfoRs['last_login_ip']) ? $userinfoRs['last_login_ip'] : '无';



        //用户
        $userinfoRelationshipObj    = M('userinfo_relationship');
        $userinfoRelationshipRs     = $userinfoRelationshipObj->where('parent_user_id in ('.$agentId.')')->select();

        $userIdArr      = array();
        $userRelArr     = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
            $userRelArr[$v['user_id']]['agent_id']  = $v['parent_user_id'];
        }
        $userIdStr      = implode(',', array_unique($userIdArr));



        //获取所有佣金
        $feeObj = M('fee_receive');

        $feeWhereArr    = 'type = 1 and status = 1 and user_id in ('.$userIdStr.')';
        $feeRs          = $feeObj->where($feeWhereArr)->select();

        $orderObj       = M();
        $orderWhereStr  = 'uid in ('.$userIdStr.')';

        $orderRs = $orderObj->table('view_wp_journal')->where($orderWhereStr)->select();
        $optionObj  = M('option');
        $optionRs   = $optionObj->select();
        foreach($optionRs as $k => $v)
        {
            $optionRs1[$v['id']]    = $v;
        }

        $returnRs       = array();
        if(!empty($orderRs))
        {

            $totalFee   = array();
            $totalMoney = array();
            foreach($orderRs as $k => $v)
            {
                array_push($totalFee, $v['jfee']);
                array_push($totalMoney, $v['jploss']);
            }

            $returnRs['total_count']    = count($orderRs);
            $returnRs['total_fee']      = number_format(array_sum($totalFee),2);
            $returnRs['total_money']    = number_format(array_sum($totalMoney),2);
        }
        else
        {
            $returnRs['total_fee']      = 0;
            $returnRs['total_money']    = 0;
        }

        $totalCommission    = array();
        $returnRs['total_commission']   = 0;
        foreach($feeRs as $k => $v)
        {
            $returnRs['total_commission'] += $v['profit_rmb'];
        }

        
        //经纪人本周资金信息
        $orderWeek = $orderObj->table('view_wp_journal')->where("uid in(".$userIdStr.") and YEARWEEK(FROM_UNIXTIME(jtime,'%Y-%m-%d %H:%i:%s')) = YEARWEEK(now())")->select();
        if(!empty($orderWeek))
        {
            $totalFeeWeek   = array();
            $totalMoneyWeek = array();
            foreach($orderWeek as $k => $v)
            {
                array_push($totalFeeWeek, $v['jfee']);
                array_push($totalMoneyWeek, $v['jploss']);
            }

            $returnWeek['total_count']    = count($orderWeek);
            $returnWeek['total_fee']      = number_format(array_sum($totalFeeWeek),2);
            $returnWeek['total_money']    = number_format(array_sum($totalMoneyWeek),2);
        }
        else
        {
            $returnWeek['total_fee']      = 0;
            $returnWeek['total_money']    = 0;
        }
        
        //获取本周佣金
        $feeWeek        = $feeObj->where("type = 1 and status = 1 and user_id in(".$userIdStr.") and YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s')) = YEARWEEK(now())")->select();
        $totalCommission    = array();
        $returnWeek['total_commission']   = 0;
        foreach($feeWeek as $k => $v)
        {
            $returnWeek['total_commission'] += $v['profit_rmb'];
        }

        //统计下级单位个数
        $userinfoRs['total_user']  = count($userinfoRelationshipRs);

        
        $this->assign('userinfoRs', $userinfoRs);
        $this->assign('returnRs', $returnRs);
        $this->assign('returnWeek',$returnWeek);
        $this->display();
    }
}