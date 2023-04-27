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


class UserfController extends CommonController
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

        $jinjiren   = I('get.jinjiren');
        $user       = I('get.user');
        $start_time = urldecode(I('get.start_time'));
        $end_time   = urldecode(I('get.end_time'));
        $utel       = I('get.utel');
        $jostyle    = I('get.jostyle');

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
        
        // 开始筛选
        // 经纪人
        if($jinjiren) {
            $agentArr = array();
            $agentinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$jinjiren.')')->select();
            foreach ($agentinfoRelationshipRs as $key => $value) {
                 array_push($agentArr,$value['user_id']);
            }
            $agentId = implode(',',array_unique($agentArr));
            $userIdStr = $agentId;
            $this->assign('jingji',$jinjiren);
        }

        //普通会员
        if($user) {
            $userIdStr = $user;
            $this->assign('user',$this->get_username($user));

        }

        //时间筛选
         if($start_time && $end_time) {
            $agentArr1 = array();
            $starttime = strtotime($start_time);
            $endtime   = strtotime($end_time);
            $map['utime'] = array('between',''.$starttime.','.$endtime.'');
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
       
            foreach ($userinfo as $key => $value) {
                array_push($agentArr1,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr1));
            $userIdStr = $userId;
            $time['start_time'] = $start_time;
            $time['end_time']   = $end_time;
            $this->assign('time',$time);
         }

         //手机号码筛选
         if($utel) {
            $agentArr2 = array();
            $map['utel'] = array('like','%'.$utel.'%');
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1-1 : $userId; 
            $userIdStr = $userId;
            $this->assign('utel',$utel);
         }

         //用户类型筛选
         if($jostyle) {
            $this->assign('jostyle',$jostyle);
            $agentArr3 = array();
            $jostyle = $jostyle == 1 ? 1 : 0;
            $map['trade_frozen'] = $jostyle;
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr3,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr3));
            $userIdStr = $userId;
         }




        //需要从这里添加条件
        $userinfoWhereArr   = 'a.uid in ('.$userIdStr.') and ustatus=0';
        
        //排序
         $sort = 'a.utime desc';
        //余额排序
        $cat   = trim(I('get.cat'));
        $sorts = trim(I('get.sort')); 
        if($cat)
        {   
             $sort = $cat.' '.$sorts.'';
             $sea['cat'] = $cat;
             $sea['sort'] = $sorts;
        }
        $this->assign('sea', $sea);


        $count      = M('userinfo a')->join('left join wp_accountinfo as b on a.uid = b.uid')->where($userinfoWhereArr)->count();

        $pageObj    = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow   = $pageObj->show();
        
        $field = 'a.*,b.balance,b.gold,b.recharge_total,b.money_total';
        $userinfoRs = M('userinfo a')
            ->field($field)
            ->join('left join wp_accountinfo as b on a.uid = b.uid')
            ->where($userinfoWhereArr)
            ->order($sort)
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        $userinfoRs1    = array();
        foreach($userinfoRs as $k => $v)
        {
            $userinfoRs1[$v['uid']]                    = $v;
            $userinfoRs1[$v['uid']]['agent_name']      = $agentinfoRs1[$userRelArr[$v['uid']]['agent_id']]['nickname'];
            $userinfoRs1[$v['uid']]['agent_username']  = $agentinfoRs1[$userRelArr[$v['uid']]['agent_id']]['username'];
            $userinfoRs1[$v['uid']]['agent_id']        = $userRelArr[$v['uid']]['agent_id'];
        }


        //bankinfo
        $bankinfoObj    = M('bankinfo');
        $bankinfoRs     = $bankinfoObj->where('uid in (' . $userIdStr . ')')->select();
        foreach ($bankinfoRs as $k => $v)
        {
            $bankinfoRs1[$v['uid']] = $v;
        }

        //accountinfo
        $accountinfoObj = M('accountinfo');
        $accountinfoRs  = $accountinfoObj->where('uid in (' . $userIdStr . ')')->select();
        foreach ($accountinfoRs as $k => $v)
        {
            $accountinfoRs1[$v['uid']] = $v;
            $acount['recharge_total']  += $v['recharge_total'];
            $acount['money_total']     += $v['money_total'];
        }
        $this->assign('account',$acount);


        foreach($userinfoRs1 as $k => $v)
        {
            $userinfoRs2[$k]                = $v;
            $userinfoRs2[$k]['last_login']  = !empty($v['lastlog']) ? date('Y-m-d H:i:s', $v['lastlog']) : '<span class="label label-sm label-warning">未登录过</span>';
            $userinfoRs2[$k]['create_date'] = date('Y-m-d H:i:s', $v['utime']);

            $userinfoRs2[$k]['name']        = $bankinfoRs1[$v['uid']]['busername'];

            // $userinfoRs2[$k]['money_remain']    = $accountinfoRs1[$v['uid']]['balance'];
            // $userinfoRs2[$k]['gold']            = $accountinfoRs1[$v['uid']]['gold'];
            // $userinfoRs2[$k]['recharge_total']  = $accountinfoRs1[$v['uid']]['recharge_total'];
            // $userinfoRs2[$k]['money_total']     = $accountinfoRs1[$v['uid']]['money_total'];

            $userinfoRs2[$k]['status_name']     = $v['ustatus'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';

            $userinfoRs2[$k]['status_o']        = $v['ustatus'] == 0 ? '冻结' : '激活';
            $userinfoRs2[$k]['status_s']        = $v['ustatus'] == 0 ? 1 : 0;

            $userinfoRs2[$k]['trade_frozen_name']     = $v['trade_frozen'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';

            $userinfoRs2[$k]['trade_frozen_o']        = $v['trade_frozen'] == 0 ? '冻结' : '激活';
            $userinfoRs2[$k]['trade_frozen_s']        = $v['trade_frozen'] == 0 ? 1 : 0;
        }


        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('userInfo', $userinfoRs2);
        $this->assign('totalCount', $count);

        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->assign('agentinfoRs',$agentinfoRs);
        $this->display();
    }


    /**
     * @functionname: user_detail
     * @author: FrankHong
     * @date: 2016-11-30 19:35:57
     * @description: 用户列表导出excel
     * @note:
     */
    public function user_daochu()
    {
        $jinjiren   = I('get.jinjiren');
        $user       = I('get.user');
        $start_time = urldecode(I('get.start_time'));
        $end_time   = urldecode(I('get.end_time'));
        $utel       = I('get.utel');
        $jostyle    = I('get.jostyle');

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
        
        // 开始筛选
        // 经纪人
        if($jinjiren) {
            $agentArr = array();
            $agentinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$jinjiren.')')->select();
            foreach ($agentinfoRelationshipRs as $key => $value) {
                 array_push($agentArr,$value['user_id']);
            }
            $agentId = implode(',',array_unique($agentArr));
            $userIdStr = $agentId;
        }

        //普通会员
        if($user) {
            $userIdStr = $user;
        }

        //时间筛选
         if($start_time && $end_time) {
            $agentArr1 = array();
            $starttime = strtotime($start_time);
            $endtime   = strtotime($end_time);
            $map['utime'] = array('between',''.$starttime.','.$endtime.'');
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr1,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr1));
            $userIdStr = $userId;
         }

         //手机号码筛选
         if($utel) {
            $agentArr2 = array();
            $map['utel'] = array('like','%'.$utel.'%');
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1-1 : $userId; 
            $userIdStr = $userId;
         }

         //用户类型筛选
         if($jostyle) {
            $this->assign('jostyle',$jostyle);
            $agentArr3 = array();
            $jostyle = $jostyle == 1 ? 1 : 0;
            $map['trade_frozen'] = $jostyle;
            $map['otype'] = 4;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr3,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr3));
            $userIdStr = $userId;
         }




        //需要从这里添加条件
        $userinfoWhereArr   = 'a.uid in ('.$userIdStr.') and ustatus=0';
        
        //排序
         $sort = 'a.utime desc';
        //余额排序
        $cat   = trim(I('get.cat'));
        $sorts = trim(I('get.sort')); 
        if($cat)
        {   
             $sort = $cat.' '.$sorts.'';
             $sea['cat'] = $cat;
             $sea['sort'] = $sorts;
        }
        $this->assign('sea', $sea);

        $field = 'a.*,b.balance,b.gold,b.recharge_total,b.money_total';
        $userinfoRs = M('userinfo a')
            ->field($field)
            ->join('left join wp_accountinfo as b on a.uid = b.uid')
            ->where($userinfoWhereArr)
            ->order($sort)
            ->select();

        $userinfoRs1    = array();
        foreach($userinfoRs as $k => $v)
        {
            $userinfoRs1[$v['uid']]                 = $v;
            $userinfoRs1[$v['uid']]['agent_name']   = $agentinfoRs1[$userRelArr[$v['uid']]['agent_id']]['nickname'];
            $userinfoRs1[$v['uid']]['agent_id']     = $userRelArr[$v['uid']]['agent_id'];
        }


        //bankinfo
        $bankinfoObj    = M('bankinfo');
        $bankinfoRs     = $bankinfoObj->where('uid in (' . $userIdStr . ')')->select();
        foreach ($bankinfoRs as $k => $v)
        {
            $bankinfoRs1[$v['uid']] = $v;
        }

        //accountinfo
        $accountinfoObj = M('accountinfo');
        $accountinfoRs  = $accountinfoObj->where('uid in (' . $userIdStr . ')')->select();
        foreach ($accountinfoRs as $k => $v)
        {
            $accountinfoRs1[$v['uid']] = $v;
        }

        foreach($userinfoRs1 as $k => $v)
        {
            $userinfoRs2[$k]                = $v;
            $userinfoRs2[$k]['last_login']  = !empty($v['lastlog']) ? date('Y-m-d H:i:s', $v['lastlog']) : '<span class="label label-sm label-warning">未登录过</span>';
            $userinfoRs2[$k]['create_date'] = date('Y-m-d H:i:s', $v['utime']);

            $userinfoRs2[$k]['name']        = $bankinfoRs1[$v['uid']]['busername'];

            // $userinfoRs2[$k]['money_remain']    = $accountinfoRs1[$v['uid']]['balance'];
            // $userinfoRs2[$k]['gold']            = $accountinfoRs1[$v['uid']]['gold'];
            // $userinfoRs2[$k]['recharge_total']  = $accountinfoRs1[$v['uid']]['recharge_total'];
            // $userinfoRs2[$k]['money_total']     = $accountinfoRs1[$v['uid']]['money_total'];

            $userinfoRs2[$k]['status_o']        = $v['ustatus'] == 0 ? '正常' : '冻结';

            $userinfoRs2[$k]['trade_frozen_name'] = $v['trade_frozen'] == 0 ? '正常' : '冻结';
        }

        $data[0] = array('编号','用户姓名','所属经纪人','手机号','现金余额','积分余额','累计充值','累计提现','注册时间','最后登录时间','交易状态');
        foreach ($userinfoRs2 as $key => $value) {
            $name = !empty($value['name']) ? $value['name'] : $value['username'];
            $data[$key+1][] = $value['uid'];
            $data[$key+1][] = $name;
            $data[$key+1][] = $value['agent_name'];
            $data[$key+1][] = $value['utel'];
            $data[$key+1][] = $value['balance'];
            $data[$key+1][] = $value['gold'];
            $data[$key+1][] = $value['recharge_total'];
            $data[$key+1][] = $value['money_total'];  
            $data[$key+1][] = $value['create_date'];
            $data[$key+1][] = $value['last_login'];
            $data[$key+1][] = $value['trade_frozen_name'];
        }
        $name='用户列表';
        $this->push($data,$name);
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
        $userId = trim(I('get.user_id'));
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
        $moneyInRs              = $accountinfoObj->where('uid=' . $userinfoRs['uid'])->find();
        $userinfoRs['money_in'] = !empty($moneyInRs['recharge_total']) ? $moneyInRs['recharge_total'] : 0.00;
        //累计提现
        $userinfoRs['money_out']= !empty($moneyInRs['money_total']) ? $moneyInRs['money_total'] : 0.00;

        //累计盈亏
        $moneyReal  = $mObj->table('view_wp_journal')->where('uid=' . $userinfoRs['uid'])->sum('jploss');
        $moneyGold  = $mObj->table('view_wp_journal_gold')->where('uid=' . $userinfoRs['uid'])->sum('jploss');
        $userinfoRs['money_real']       = !empty($moneyReal) ? $moneyReal : 0.00;
        $userinfoRs['money_gold']       = !empty($moneyGold) ? $moneyGold : 0.00;


        if($userinfoRs['money_real'] > 0)
        {
            $userinfoRs['money_real']   = '<b class="text-danger">'.$userinfoRs['money_real'].'</b>';
        }

        if($userinfoRs['money_real'] < 0)
        {
            $userinfoRs['money_real']   = '<b class="text-success">'.$userinfoRs['money_real'].'</b>';
        }


        //累计手续费
        $commissionTotalRs              = $mObj->table('view_wp_journal')->where('uid=' . $userinfoRs['uid'])->sum('jfee');
        $userinfoRs['money_fee_real']   = !empty($commissionTotalRs) ? $commissionTotalRs : 0.00;
        $commissionTotalRs              = $mObj->table('view_wp_journal_gold')->where('uid=' . $userinfoRs['uid'])->sum('jfee');
        $userinfoRs['money_fee_gold']   = !empty($commissionTotalRs) ? $commissionTotalRs : 0.00;



        //累计佣金
        $feeTotalRs                     = $mObj->table('view_user_commission')->where('uid='.$userinfoRs['uid'])->find();
        $userinfoRs['money_commission'] = !empty($feeTotalRs['profit_rmb']) ? $feeTotalRs['profit_rmb'] : 0.00;


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

    /**
     * @functionname: opt_user_status
     * @author: FrankHong
     * @date: 2016-12-02 20:28:24
     * @description: 操作用户的状态
     * @note:
     */
    public function withdrawal($isExport=0)
    {
        $yunying   = NOW_UID;              //运营中心
        $jingjiren = trim(I('get.jingjiren'));            //经纪人
        $user      = trim(I('get.user'));			        //用户
        $user_type = trim(I('get.user_type'));            //用户类型
        $utel      = trim(I('get.utel'));                 //手机号码
        $status    = trim(I('get.status'));               //提现状态
        $starttime = strtotime(urldecode(trim(I('get.starttime')))); //开始时间
        $endtime   = strtotime(urldecode(trim(I('get.endtime'))));   //结束时间

        $userinfo                = M('userinfo');
        $userinfoRelationshipObj = M('UserinfoRelationship');

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

        //经纪人信息
        $agentinfoWhereagent  = 'uid in ('.$agentIdStr.')';
        $agentinfoRs    = $userinfo->where($agentinfoWhereagent)->select();
        $agentinfoRs1   = array();
        foreach($agentinfoRs as $k => $v)
        {
            $agentinfoRs1[$v['uid']]    = $v;
        }

        //用户
        $userinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$agentIdStr.')')->select();

        $userRelArr     = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
            $userRelArr[$v['user_id']]['agent_id']  = $v['parent_user_id'];  //经纪人id

        }

        if($yunying) {

            $relation = M('userinfo_relationship')->where(array('parent_user_id' => $yunying))->select();
            $relationArr = array();
            $relationArr1 = array();
            foreach ($relation as $key => $value) {
                array_push($relationArr,$value['user_id']);
            }
            $relationId = implode(',',array_unique($relationArr));
            $users = M('userinfo_relationship')->where('parent_user_id in('.$relationId.')')->select();
            foreach ($users as $key => $value) {
                array_push($relationArr1,$value['user_id']);
            }
            $userId = implode(',',array_unique($relationArr1));
            $map['a.uid'] = array('in',$userId);
        }

        if($jingjiren) {
            $relationArr2 = array();
            $jingjiren_user = M('userinfo_relationship')->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
                array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['a.uid'] = array('in',$userId1);
            $this->assign('jingjiren',$jingjiren);
        }

        if($user) {
            $map['a.uid'] = $user;
            $sea['user'] = $user;
            $this->assign('user',$this->get_username($user));
        }

        if($user_type){
            $map['c.otype']   = $user_type;
            $sea['user_type'] = $user_type;
            $this->assign('user_type',$user_type);
        }

        if($utel){
            $map['c.utel'] = array('like','%'.$utel.'%');
            $this->assign('utel',$utel);
        }

        if($status) {
            if($status == 1) {
                $map['a.status'] = 1;
                $map['a.isverified'] = 1;
            } else if($status == 2){
                $map['a.status'] = 0;
                $map['a.isverified'] = 0;
                $map['a.cltime']  = array('exp','is not null');
            } else {
                $map['a.cltime']  = array('exp','is null');
            }
            $this->assign('status',$status);
        }

        if($starttime && $endtime) {
            $map['a.bptime'] = array('between',''.$starttime.','.$endtime.'');
            $this->assign('starttime',date('Y-m-d H:i:s',$starttime));
            $this->assign('endtime',date('Y-m-d H:i:s',$endtime));
        }

        $map['a.b_type'] = 2;
        $count =     M("balance a")->
        join('left join wp_bankinfo as b on a.uid = b.uid')->
        join('wp_userinfo as c on a.uid = c.uid')->
        join('left join wp_accountinfo as d on a.uid = d.uid')->
        where($map)->
        count();
        //分页
        $page    = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow   = $page->show();


        $bm = M("balance a")->
        join('left join wp_bankinfo as b on a.uid = b.uid')->
        join('wp_userinfo as c on a.uid = c.uid')->
        join('left join wp_accountinfo as d on a.uid = d.uid')->
        where($map)->order('a.bpid desc');
        if($isExport){
            $rechargelist = $bm->select();
            foreach ($rechargelist as $key => $value) {
                $rechargelist[$key]['agent_id']           = $userRelArr[$value['uid']]['agent_id'];  //经纪人id
                $rechargelist[$key]['agent_name']         = $agentinfoRs1[$userRelArr[$value['uid']]['agent_id']]['nickname'];  //经纪人名称
                $rechargelist[$key]['agent_username']     = $agentinfoRs1[$userRelArr[$value['uid']]['agent_id']]['username'];  //经纪人名称
            }
            return $rechargelist;
        }else{
            $rechargelist = $bm->limit($page->firstRow.','.$page->listRows)->select();
            $sum = M("balance a")->
            join('left join wp_bankinfo as b on a.uid = b.uid')->
            join('wp_userinfo as c on a.uid = c.uid')->
            join('left join wp_accountinfo as d on a.uid = d.uid')->
            where($map)->
            select();

            $amount = 0;
            foreach ($sum as $key => $value) {
                if($value['status'] == 1 && $value['isverified'] == 1) $amount += $value['bpprice'];
            }
            foreach ($rechargelist as $key => $value) {
                $rechargelist[$key]['agent_id']           = $userRelArr[$value['uid']]['agent_id'];  //经纪人id
                $rechargelist[$key]['agent_name']         = $agentinfoRs1[$userRelArr[$value['uid']]['agent_id']]['nickname'];  //经纪人名称
                $rechargelist[$key]['agent_username']     = $agentinfoRs1[$userRelArr[$value['uid']]['agent_id']]['username'];  //经纪人名称
            }
            $nowStart   = $page->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
            $nowEnd     = ($page->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

            $this->assign('totalCount', $count);
            $this->assign('nowStart', $nowStart);
            $this->assign('nowEnd', $nowEnd);
            $this->assign('pageShow',  $pageShow);
            $this->assign('rechargelist',$rechargelist);
            $this->assign('amount',$amount);
            $this->assign('agentinfoRs',$agentinfoRs);  //经纪人
            //        $this->assign('info',M('userinfo')->where(array('otype' => 3))->select());
            $this->display();
        }


    }

    public function withdrawal_daochu(){
        $rechargelist = $this->withdrawal(1);
        $data[0] = array('编号','用户姓名','手机号','机构昵称','操作时间','处理时间','提现金额','用户余额','理由','操作');
        foreach ($rechargelist as $key => $value) {
            $data[$key+1][] = $value['bpid'];
            $data[$key+1][] = $value['busername'] != '' ? $value['busername'] : $value['username'];
            $data[$key+1][] = $value['utel'];
            $data[$key+1][] = $value['agent_name'] != '' ? $value['agent_name'] : $value['agent_username'];
            $data[$key+1][] = date('Y-m-d H:i:s',$value['bptime']);
            $data[$key+1][] =  $value['cltime'] != '' ? '暂未处理' : date('Y-m-d H:i:s',$value['cltime']);
            $data[$key+1][] = $value['bpprice'];
            $data[$key+1][] = $value['balance'];
            $data[$key+1][] = $value['remarks'];
            if($value['isverified']==1 && $value['status'] == 1){
                $data[$key+1][] = '已通过';
            }elseif($value['cltime'] == ''){
                $data[$key+1][] = '待处理';
            }else{
                $data[$key+1][] = '拒绝申请';
            }
        }
        $this->push($data,'用户提现记录');
    }

/*    public function withdrawal_process(){
        $option_id = I('get.option_id');

        $vo = M("balance")->where('bpid='.$option_id)->find();
        if(!$vo){
            $this->error("参数错误");
        }

        $user = M("userinfo")->where(array('uid'=>$vo['uid']))->find();

        $this->assign('vo', $vo);
        $this->assign('user', $user);
        $this->display();
    }

    public function withdrawal_processing(){

        //获取参数
        $bpid       = trim(I('post.bpid'));
        $isverified = trim(I('post.isverified'));
        $remarks    = trim(I('post.remarks'));

        $vo = M("balance")->where('bpid='.$bpid)->find();
        if(!$vo){
            $this->error("参数错误");
        }
        $b_type     = $vo['b_type'];
        $rebpprce   = $vo['bpprice'];
        $userid     = $vo['uid'];
        $cltime     = time();


        //检查提现用户是否是下属用户
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $agentinfoRelationshipRs    = M('UserinfoRelationship')->where($whereArr)->select();

        $agentIdArr  = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
        }

        $agentIdStr  = implode(',', array_unique($agentIdArr));
        //用户
        $userinfoRelationshipRs =  M('UserinfoRelationship')->where('parent_user_id in ('.$agentIdStr.')')->select();

        $userIdArr     = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
        }
        if(!in_array($vo['uid'], $userIdArr)){
            $this->error('您无权操作');
        }



        if($b_type == 2){
            $balance = M("balance")->where(array('bpid' => $bpid))->find();
            if(!empty($balance['cltime'])){
                $this->ajaxReturn("null");
            }

            if($isverified == 1){   //同意

                $data['isverified'] = 1;
                $data['status']     = 1;
                $data['cltime']     = $cltime;
                $data['remarks']    = $remarks;
                $isver = M("balance")->where(array('bpid' => $bpid))->save($data);
            } else {    //拒绝
                $data['cltime']     = $cltime;
                $data['isverified'] = 0;
                $data['remarks']    = $remarks;
                $res = M("balance")->where(array('bpid' => $bpid))->save($data);

                if($res){
                    $isver = M("accountinfo")->where(array('uid' => $userid))->setInc('balance',$rebpprce);
                    $infos = M('userinfo')->where(array('uid' => $userid))->find();
                    if($infos['otype'] == 5)
                    {
                        $map['user_type'] = 2;
                    }
                    //用户资金流水表
                    $map['uid']      = $userid;
                    $map['type']     = 3;
                    $map['oid']      = $bpid;
                    $map['note']     = '管理员拒绝提现增加['.$rebpprce.']元';
                    $map['balance']  = M('accountinfo')->where(array('uid'=>$userid))->sum('balance');
                    $map['op_id']    = session('userid');
                    $map['dateline'] = time();
                    $money_flow = M("MoneyFlow")->add($map);
                }
            }
        }

        if($isver){
            $this->success();
        }else{
            $this->ajaxReturn("null");
        }

    }*/

    /**
     * @functionname: opt_user_status
     * @author: FrankHong
     * @date: 2016-12-02 20:28:24
     * @description: 操作用户的状态
     * @note:
     */
    public function money_flow() 
    {
       $MoneyFlow               = M('MoneyFlow');
       $userinfo                = M('userinfo');
       $userinfoRelationshipObj = M('UserinfoRelationship');
       $bankinfo                = M('bankinfo');

       $jinjiren   = I('get.jinjiren');
       $user       = I('get.user');
       $start_time = urldecode(I('get.start_time'));
       $end_time   = urldecode(I('get.end_time'));
       $utel       = I('get.utel');
       $type       = I('get.type');
       $operator   = trim(I('get.operator'));

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

        //经纪人信息
        $agentinfoWhereagent  = 'uid in ('.$agentIdStr.')';
        $agentinfoRs    = $userinfo->where($agentinfoWhereagent)->select();
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
            $userRelArr[$v['user_id']]['agent_id']  = $v['parent_user_id'];  //经纪人id

        }
        $userIdStr      = implode(',', array_unique($userIdArr));

        // 开始筛选
        // 经纪人
        if($jinjiren) {
            $agentArr = array();
            $agentinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$jinjiren.')')->select();
            foreach ($agentinfoRelationshipRs as $key => $value) {
                 array_push($agentArr,$value['user_id']);
            }
            $agentId = implode(',',array_unique($agentArr));
            $userIdStr = $agentId;
            $this->assign('jingji',$jinjiren);
        }

        //普通会员
        if($user) {
            $userIdStr = $user;
            $this->assign('user',$this->get_username($user));

        }

        //时间筛选
         if($start_time && $end_time) {
            $starttime = strtotime($start_time);
            $endtime   = strtotime($end_time);
            $map['dateline'] = array('between',array($starttime,$endtime));
            $time['start_time'] = $start_time;
            $time['end_time']   = $end_time;
            $this->assign('time',$time);
         }

         //手机号码筛选
         if($utel) {
            $agentArr2 = array();
            $where['utel'] = array('like','%'.$utel.'%');
            $where['otype'] = 4;
            $where['uid'] = array('in',$userIdStr);
            $tel = $userinfo->where($where)->select();
            foreach ($tel as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1-1 : $userId; 
            $userIdStr = $userId;
            $this->assign('utel',$utel);
         }

         //z资金变动筛选
         if($type) {
            $map['type'] = $type;
            $this->assign('type',$type);
         }

         //操作人筛选
         if($operator) {
            $map['op_id'] = $operator;
            $this->assign('operator',$operator);
         }
        
        //start
        $map['uid'] = array('in',$userIdStr);

        $count      = $MoneyFlow->where($map)->count();
        $pageObj    = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow   = $pageObj->show();
       
        $Flow       = $MoneyFlow->where($map)->order('id  desc')->limit($pageObj->firstRow, $pageObj->listRows)->select();
        $Flow_money = $MoneyFlow->where($map)->order('id  desc')->select();
        
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

            $Flow[$key]['agent_id']           = $userRelArr[$value['uid']]['agent_id'];  //经纪人id
            $Flow[$key]['agent_name']         = $agentinfoRs1[$userRelArr[$value['uid']]['agent_id']]['nickname'];  //经纪人名称
            $Flow[$key]['agent_username']     = $agentinfoRs1[$userRelArr[$value['uid']]['agent_id']]['username'];  //经纪人名称
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
     * @functionname: opt_user_status
     * @author: FrankHong
     * @date: 2016-12-02 20:28:24
     * @description: 用户资金流水导出excel
     * @note:
     */
    public function flow_daochu()
    {
        
       $MoneyFlow               = M('MoneyFlow');
       $userinfo                = M('userinfo');
       $userinfoRelationshipObj = M('UserinfoRelationship');
       $bankinfo                = M('bankinfo');

       $jinjiren   = I('get.jinjiren');
       $user       = I('get.user');
       $start_time = urldecode(I('get.start_time'));
       $end_time   = urldecode(I('get.end_time'));
       $utel       = I('get.utel');
       $type       = I('get.type');
       $operator   = trim(I('get.operator'));

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

        //经纪人信息
        $agentinfoWhereagent  = 'uid in ('.$agentIdStr.')';
        $agentinfoRs    = $userinfo->where($agentinfoWhereagent)->select();
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
            $userRelArr[$v['user_id']]['agent_id']  = $v['parent_user_id'];  //经纪人id

        }
        $userIdStr      = implode(',', array_unique($userIdArr));


        // 经纪人
        if($jinjiren) {
            $agentArr = array();
            $agentinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$jinjiren.')')->select();
            foreach ($agentinfoRelationshipRs as $key => $value) {
                 array_push($agentArr,$value['user_id']);
            }
            $agentId = implode(',',array_unique($agentArr));
            $userIdStr = $agentId;
        }

        //普通会员
        if($user) {
            $userIdStr = $user;
        }

        //时间筛选
         if($start_time && $end_time) {
            $starttime = strtotime($start_time);
            $endtime   = strtotime($end_time);
            $map['dateline'] = array('between',array($starttime,$endtime));
            $time['start_time'] = $start_time;
            $time['end_time']   = $end_time;
            $this->assign('time',$time);
         }

         //手机号码筛选
         if($utel) {
            $agentArr2 = array();
            $where['utel'] = array('like','%'.$utel.'%');
            $where['otype'] = 4;
            $where['uid'] = array('in',$userIdStr);
            $tel = $userinfo->where($where)->select();
            foreach ($tel as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }
            $userId = implode(',',array_unique($agentArr2));
            $userId = empty($userId) ? 1-1 : $userId; 
            $userIdStr = $userId;
         }

         //用户类型筛选
         if($type) {
            $map['type'] = $type;
         }

       //操作人筛选
         if($operator) {
            $map['op_id'] = $operator;
         }
        
        //start
        $map['uid'] = array('in',$userIdStr);
       
        $Flow       = $MoneyFlow->where($map)->order('dateline  desc')->select();
        
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

            $Flow[$key]['agent_id']           = $userRelArr[$value['uid']]['agent_id'];  //经纪人id
            $Flow[$key]['agent_name']         = $agentinfoRs1[$userRelArr[$value['uid']]['agent_id']]['nickname'];  //经纪人名称
        }


        $data[0] = array('编号','用户姓名','经纪人昵称','手机号','资金变动描述','变动金额','操作人','操作时间');
        foreach ($Flow as $key => $value) {
            $name          = !empty($value['busername']) ? $value['busername'] : $value['username'];
            $operator_name = !empty($value['operator_busername']) ? $value['operator_busername'] : $value['operator'];

            $data[$key+1][] = $value['id'];
            $data[$key+1][] = $name;
            $data[$key+1][] = $value['agent_name'];
            $data[$key+1][] = $value['utel'];
            $data[$key+1][] = $value['note'];
            $data[$key+1][] = $value['account'];
            $data[$key+1][] = $operator_name;
            $data[$key+1][] = date('Y-m-d H:i:s',$value['dateline']);  
        }
        $name='用户资金流水';
        $this->push($data,$name);
    }

    private function push($data,$name){
        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data,$name);
    }

    private function get_username($uid = 0) {
         
         $info = M("userinfo a")->field('a.uid,a.username,b.busername')->join('left join wp_bankinfo as b on a.uid = b.uid')->where(array('a.uid'=> $uid))->find();

         $info['username'] = !empty($info['busername']) ? $info['busername'] : $info['username'];

         return $info ? $info : null;
    }


/**
 * 修改用户积分余额
 * @author wang
 */
public function save_gold()
    {
        $uid    = trim(I('post.uid'));
        $value  = trim(I('post.value'));

        $accountinfo = M('accountinfo');

        $data = array();

        $map['uid'] = $uid;
        if($uid)
        {
           $info = $accountinfo->where($map)->find();
           if($info)
           {
            $is_save = $accountinfo->where($map)->setInc('gold',$value);
            if($is_save)
            {
                $data['code'] = 1;
                $data['msg']  = '积分余额修改成功';
                $this->ajaxReturn($data,'JSON');
            } else {
                $data['code'] = 0;
                $data['msg']  = '积分余额修改失败';
                $this->ajaxReturn($data,'JSON');
            }

           } else {
            $data['code'] = 0;
            $data['msg']  = '系统不存在此用户';
            $this->ajaxReturn($data,'JSON');
           }

        } else {
           $data['code'] = 0;
           $data['msg']  = '用户id不存在';
           $this->ajaxReturn($data,'JSON');
        }
    }

    /**
    *   冻结交易用户
    *   @author wang
    **/
    public function tradeFrozen()
    {
        $user_id        = trim(I('post.user_id'));
        $trade_frozen   = trim(I('post.trade_frozen'));

        if(empty($user_id) || !isset($trade_frozen))
        {
            $data['status']     = 0;
            $data['ret_msg']    = '非法操作';
            $this->ajaxReturn($data,'JSON');
        }

        $userinfoObj = M('userinfo');
        
        $res = $userinfoObj->where(array('uid' => $user_id))->setField('trade_frozen',$trade_frozen);

        if($res){

            $data['status']     = 1;
            $data['ret_msg']    = '操作成功';
            $this->ajaxReturn($data,'JSON');

        }else{

            $data['status']     = 0;
            $data['ret_msg']    = '操作失败';
            $this->ajaxReturn($data,'JSON');
        }
    }

}