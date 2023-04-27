<?php
namespace Branch\Controller;
use Think\Controller;
use Org\Util\Excel;
class OperateController extends CommonController {

	/**
	* 运营中心列表 
	* @author wang admin
	**/
	public function index()
	{

        /**
         * get area
         */
        $agentId    = I('get.agent_id', '');
        $username   = I('get.username', '');


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
        //vD($userIdStr);

        $userinfoObj = M('userinfo');


        //search


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

        //vD($userinfoRs);

        $userIdArr1 = array();
        foreach ($userinfoRs as $k => $v) {
            $userinfoRs[$k]['last_login'] = !empty($v['lastlog']) ? date('Y-m-d H:i:s', $v['lastlog']) : '<span class="label label-sm label-warning">未登录过</span>';
            $userinfoRs[$k]['create_date'] = date('Y-m-d H:i:s', $v['utime']);
            array_push($userIdArr1, $v['uid']);
        }
        $userIdStr1 = implode(',', array_unique($userIdArr1));


        //weixinlogo
        $agentExtraObj  = M('agent_extra');
        $agentExtraRs   = $agentExtraObj->where('agent_user_id in (' . $userIdStr1 . ')')->select();
        foreach ($agentExtraRs as $k => $v) {
            $agentExtraRs1[$v['agent_user_id']] = $v;
        }

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

            $userinfoRs1[$v['uid']]['money_remain']		= $accountinfoRs1[$v['uid']]['balance'];
            $userinfoRs1[$v['uid']]['money_total'] 		= $accountinfoRs1[$v['uid']]['money_total'];
            $userinfoRs1[$v['uid']]['recharge_total'] 	= $accountinfoRs1[$v['uid']]['recharge_total'];

            $userinfoRs1[$v['uid']]['status_name']  = $v['ustatus'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';

            $userinfoRs1[$v['uid']]['status_o']     = $v['ustatus'] == 0 ? '冻结' : '激活';
            $userinfoRs1[$v['uid']]['status_s']     = $v['ustatus'] == 0 ? 1 : 0;

            $userinfoRs1[$v['uid']]['weixin_img']   = !empty($agentExtraRs1[$v['uid']]) ? '<img title="已上传公众号二维码" src="http://www.'.SYSTEM_DOMAIN.'/Public/Ucenter/img_logo.jpg" >' : '';

            $userinfoRs1[$v['uid']]['domain_n']     = !empty($v['s_domain']) ? $v['s_domain'].'.'.$s_domain : '';
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
    *  运营中心资金流水
    *  @author wang admin
    **/
    public function money_flow()
    {
       $MoneyFlow               = M('MoneyFlow');
       $userinfo                = M('userinfo');
       $userinfoRelationshipObj = M('UserinfoRelationship');
       $bankinfo                = M('bankinfo');

       $start_time = urldecode(trim(I('get.start_time')));
       $end_time   = urldecode(trim(I('get.end_time')));
       $type       = trim(I('get.type'));
       $operator   = trim(I('get.operator'));
       $operate    = trim(I('get.operate'));


        $whereArr = array(
                'parent_user_id' => NOW_UID
        );
        $userinfoRelationshipRs = $userinfoRelationshipObj->where($whereArr)->select();

        $userIdArr = array();
        foreach ($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
        }

        $userIdStr   = implode(',', array_unique($userIdArr));

        $operateData = $userinfo->field('uid,username')->where('uid in('.$userIdStr.')')->select();
        $this->assign('operateData',$operateData);



        //时间筛选
         if($start_time && $end_time) {
            $starttime = strtotime($start_time);
            $endtime   = strtotime($end_time);
            $map['dateline'] = array('between',array($starttime,$endtime));
            $time['start_time'] = $start_time;
            $time['end_time']   = $end_time;
            $this->assign('time',$time);
         }

         //资金变动筛选
         if($type) {
            $map['type'] = $type;
            $this->assign('type',$type);
         }

         //操作人筛选
         if($operator) {
            $map['op_id'] = $operator;
            $this->assign('operator',$operator);
         }

         //运营中心筛选
         if($operate)
         {
            $userIdStr = $operate;
            $this->assign('operate',$operate);
         }


        
        $map['uid'] = array('in',$userIdStr);

        $count      = $MoneyFlow->where($map)->count();
        $pageObj    = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow   = $pageObj->show();
       
        $Flow       = $MoneyFlow->where($map)->order('id  desc')->limit($pageObj->firstRow, $pageObj->listRows)->select();
        $Flow_money = $MoneyFlow->field('note')->where($map)->select();
        
        $FlowArr  = array();
        $FlowArr1 = array();
        foreach ($Flow as $key => $value) {
            array_push($FlowArr, $value['uid']);
            array_push($FlowArr1, $value['op_id']);
        }
        $FlowId  = implode(',',array_unique($FlowArr));
        $FlowId1 = implode(',',array_unique($FlowArr1));

        //查询购买人信息
        $info = $userinfo->where('uid in('.$FlowId.')')->select();
        foreach ($info as $key => $value) {
            $info[$value['uid']] = $value;
        }

        //查询用户银行卡信息
        $bank = $bankinfo->where('uid in('.$FlowId.')')->select();
        foreach ($bank as $key => $value) {
            $bank[$value['uid']] = $value;
        }

        //查询操作人信息
        $info1 = $userinfo->where('uid in('.$FlowId1.')')->select();
        foreach ($info1 as $key => $value) {
            $info1[$value['uid']] = $value;
        }

        //查询操作人用户银行卡信息
        $bank1 = $bankinfo->where('uid in('.$FlowId1.')')->select();
        foreach ($bank1 as $key => $value) {
            $bank1[$value['uid']] = $value;
        }


        foreach ($Flow as $key => $value) {
            $Flow[$key]['busername']          = $bank[$value['uid']]['busername'];
            $Flow[$key]['username']           = $info[$value['uid']]['username'];
            $Flow[$key]['utel']               = $info[$value['uid']]['utel'];

            $Flow[$key]['account']            = substr($value['note'],strrpos($value['note'],'[')+1);
            $Flow[$key]['account']            = preg_replace("/]/", "",$Flow[$key]['account']);

            $Flow[$key]['operator']           = $info1[$value['op_id']]['username'];  //操作人
            $Flow[$key]['operator_busername'] = $bank1[$value['op_id']]['busername'];  //操作人
        }

        foreach ($Flow_money as $key => $value) {
            $Flow_money[$key]['account']  = substr($value['note'],strrpos($value['note'],'[')+1);
            $sum += preg_replace("/]元/", "",$Flow_money[$key]['account']);
        }
        
        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('totalCount', $count);
        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->assign('flow',$Flow);
        $this->assign('agentinfoRs',$agentinfoRs);  //经纪人
        $this->assign('sum',$sum);
        $this->assign('info',M('userinfo')->where(array('otype' =>3))->select());
        $this->display();
    }

    /**
    *  money_flow  流水导出
    *  @author wang 99052936@qq.com
    **/
    public function flow_daochu()
    {
       $MoneyFlow               = M('MoneyFlow');
       $userinfo                = M('userinfo');
       $userinfoRelationshipObj = M('UserinfoRelationship');
       $bankinfo                = M('bankinfo');

       $start_time = urldecode(trim(I('get.start_time')));
       $end_time   = urldecode(trim(I('get.end_time')));
       $type       = trim(I('get.type'));
       $operator   = trim(I('get.operator'));
       $operate    = trim(I('get.operate'));


        $whereArr = array(
                'parent_user_id' => NOW_UID
        );
        $userinfoRelationshipRs = $userinfoRelationshipObj->where($whereArr)->select();

        $userIdArr = array();
        foreach ($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
        }

        $userIdStr   = implode(',', array_unique($userIdArr));


        //时间筛选
         if($start_time && $end_time) {
            $starttime = strtotime($start_time);
            $endtime   = strtotime($end_time);
            $map['dateline'] = array('between',array($starttime,$endtime));
            $time['start_time'] = $start_time;
            $time['end_time']   = $end_time;
         }

         //资金变动筛选
         if($type) {
            $map['type'] = $type;
         }

         //操作人筛选
         if($operator) {
            $map['op_id'] = $operator;
         }

         //运营中心筛选
         if($operate)
         {
            $userIdStr = $operate;
         }


        
        $map['uid'] = array('in',$userIdStr);
       
        $Flow       = $MoneyFlow->where($map)->order('id  desc')->select();
        
        $FlowArr  = array();
        $FlowArr1 = array();
        foreach ($Flow as $key => $value) {
            array_push($FlowArr, $value['uid']);
            array_push($FlowArr1, $value['op_id']);
        }
        $FlowId  = implode(',',array_unique($FlowArr));
        $FlowId1 = implode(',',array_unique($FlowArr1));

        //查询购买人信息
        $info = $userinfo->where('uid in('.$FlowId.')')->select();
        foreach ($info as $key => $value) {
            $info[$value['uid']] = $value;
        }

        //查询用户银行卡信息
        $bank = $bankinfo->where('uid in('.$FlowId.')')->select();
        foreach ($bank as $key => $value) {
            $bank[$value['uid']] = $value;
        }

        //查询操作人信息
        $info1 = $userinfo->where('uid in('.$FlowId1.')')->select();
        foreach ($info1 as $key => $value) {
            $info1[$value['uid']] = $value;
        }

        //查询操作人用户银行卡信息
        $bank1 = $bankinfo->where('uid in('.$FlowId1.')')->select();
        foreach ($bank1 as $key => $value) {
            $bank1[$value['uid']] = $value;
        }


        foreach ($Flow as $key => $value) {
            $Flow[$key]['busername']          = $bank[$value['uid']]['busername'];
            $Flow[$key]['username']           = $info[$value['uid']]['username'];
            $Flow[$key]['utel']               = $info[$value['uid']]['utel'];

            $Flow[$key]['account']            = substr($value['note'],strrpos($value['note'],'[')+1);
            $Flow[$key]['account']            = preg_replace("/]/", "",$Flow[$key]['account']);

            $Flow[$key]['operator']           = $info1[$value['op_id']]['username'];  //操作人
            $Flow[$key]['operator_busername'] = $bank1[$value['op_id']]['busername'];  //操作人
        }


        $data[0] = array('编号','用户姓名','手机号','资金变动描述','变动金额','操作人','操作时间');
        foreach ($Flow as $key => $value) {
            $name          = !empty($value['busername']) ? $value['busername'] : $value['username'];
            $operator_name = !empty($value['operator_busername']) ? $value['operator_busername'] : $value['operator'];

            $data[$key+1][] = $value['id'];
            $data[$key+1][] = $name;
            $data[$key+1][] = $value['utel'];
            $data[$key+1][] = $value['note'];
            $data[$key+1][] = $value['account'];
            $data[$key+1][] = $operator_name;
            $data[$key+1][] = date('Y-m-d H:i:s',$value['dateline']);  
        }
        $this->push($data,'用户资金流水');

    }


    /**
    * 运营中心详细页面
    * @author wang admin
    **/
    public function agent_detail()
    {
         $agentId    = I('get.agent_id', '');
        if(!$agentId)
        {
            $this->display('Common/error_not_found');
            die();
        }

        $accountObj         = M('accountinfo');
        $userinfoObj        = M('userinfo');
        $userinfoWhereArr   = 'uid='.$agentId;

        $userinfoRs         = $userinfoObj->where($userinfoWhereArr)->find();

        $userinfoRs['status_n']         = $userinfoRs['ustatus'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';
        $userinfoRs['u_reg_time']       = date('Y-m-d H;i:s', $userinfoRs['utime']);


        $userinfoRs['u_lastlog_time']   = !empty($userinfoRs['lastlog']) ? date('Y-m-d H:i:s', $userinfoRs['lastlog']) : '<span class="label label-sm label-warning">未登录过</span>';
        $userinfoRs['u_reg_ip']         = !empty($userinfoRs['reg_ip']) ? $userinfoRs['reg_ip'] : '无';
        $userinfoRs['u_last_login_ip']  = !empty($userinfoRs['last_login_ip']) ? $userinfoRs['last_login_ip'] : '无';

        $accountRs          = $accountObj->field('balance')->where($userinfoWhereArr)->find();
        $userinfoRs['balance']       = empty($accountRs) ? '0.00' : $accountRs['balance'];

        //vD($bankinfoRs);


        //经纪人
        $userinfoRelationshipObj    = M('userinfo_relationship');
        $agentinfoRelationshipRs     = $userinfoRelationshipObj->where('parent_user_id in ('.$agentId.')')->select();

        $agentIdArr      = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
        }

        $agentIdStr      = implode(',', array_unique($agentIdArr));

        //用户
        $userinfoRelationshipRs     = $userinfoRelationshipObj->where('parent_user_id in ('.$agentIdStr.')')->select();
        $userIdArr      = array();
        $userRelArr      = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
            $userRelArr[$v['user_id']]['agent_id']  = $v['parent_user_id'];
        }

        $userIdStr      = implode(',', array_unique($userIdArr));

        $orderObj       = M();
        $orderWhereStr  = 'uid in ('.$userIdStr.')';

        $orderRs = $orderObj->table('view_wp_journal')->where($orderWhereStr)->select();

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



        $feeObj = M('fee_receive');

        //获取用户推广佣金
        $feeWhereArr    = 'type = 1 and status = 1 and user_id in ('.$userIdStr.')';
        $feeRs          = $feeObj->where($feeWhereArr)->sum('profit_rmb');

        //获取自己推广佣金
        $feeselfArr   = 'type = 3 and status = 1 and user_id in ('.$agentId.')';
        $feeself      = $feeObj->where($feeselfArr)->sum('profit_rmb');

        $returnRs['total_commission']   = empty($feeRs) ? '0.00' : $feeRs;

        $returnRs['self_commission']    = empty($feeself) ? '0.00' : $feeself;;


        
        //运营中心本周资金信息
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

            $returnWeek['total_count']   = count($orderWeek);
            $returnWeek['total_fee']      = number_format(array_sum($totalFeeWeek),2);
            $returnWeek['total_money']    = number_format(array_sum($totalMoneyWeek),2);
        }
        else
        {
            $returnWeek['total_fee']      = 0;
            $returnWeek['total_money']    = 0;
        }
        
        //获取本周用户推广佣金
        $feeWeek        = $feeObj->where("type = 1 and status = 1 and user_id in(".$userIdStr.") and YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s')) = YEARWEEK(now())")->sum('profit_rmb');

        //获取本周自己收益
        $selffeeWeek        = $feeObj->where("type = 3 and status = 1 and user_id in(".$agentId.") and YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s')) = YEARWEEK(now())")->sum('profit_rmb');

        $returnWeek['total_commission'] = empty($feeWeek) ? '0.00' : $feeWeek;
        $returnWeek['self_commission']  = empty($selffeeWeek) ? '0.00' : $selffeeWeek;


        //统计下级单位个数
        $userinfoRs['total_user']  = count($userinfoRelationshipRs);
        $userinfoRs['total_agent'] = count($agentinfoRelationshipRs);

        $this->assign('userinfoRs', $userinfoRs);
        $this->assign('returnRs', $returnRs);
        $this->assign('returnWeek',$returnWeek);
        $this->display();
    }


    private function push($data,$name){
        $excel = new Excel();
        $excel->download($data,$name);
    }
}