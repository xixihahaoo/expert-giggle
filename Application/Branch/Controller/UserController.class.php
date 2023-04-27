<?php
/**
 * @author: wang
 * @datetime: 2017/5/28 16:08
 * @filename: UserController.class.php
 * @description:  用户模块
 * @note: 
 * 
 */
namespace Branch\Controller;
use Think\Controller;
use Org\Util\Excel;
class UserController extends CommonController
{

    /**
     * @functionname: user_list
     * @author: wang
     * @date: 2017-5-28 17:15:22
     * @description: 运营中心分部下的所有用户列表
     * @note:
     */
    public function user_list()
    {

        $operate    = trim(I('get.operate'));
        $jinjiren   = trim(I('get.jinjiren'));
        $user       = trim(I('get.user'));
        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $utel       = trim(I('get.utel'));
        $jostyle    = trim(I('get.jostyle'));

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
        $userinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$agentIdStr.')')->select();

        $userIdArr      = array();
        $userRelArr     = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
            $userRelArr[$v['user_id']]['agent_id']  = $v['parent_user_id'];

        }
        $userIdStr      = implode(',', array_unique($userIdArr));

        

        //运营中心 
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
            $this->assign('operate',$operate);
        }




        // 经纪人
        if($jinjiren) {
            $agentArr = array();
            $agentinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$jinjiren.')')->select();
            foreach ($agentinfoRelationshipRs as $key => $value) {
                 array_push($agentArr,$value['user_id']);
            }
            $agentId = implode(',',array_unique($agentArr));
            $userIdStr = $agentId;
            $this->assign('jinjiren',$this->get_username($jinjiren));
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
            $map['utel'] = $utel;
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

            $userinfoRs1[$v['uid']]['operate_name']      = $operateinfoRs1[$agentIdArr2[$userRelArr[$v['uid']]['agent_id']]['parent_user_id']]['nickname'];

            $userinfoRs1[$v['uid']]['operate_username']  = $operateinfoRs1[$agentIdArr2[$userRelArr[$v['uid']]['agent_id']]['parent_user_id']]['username'];

            $userinfoRs1[$v['uid']]['operate_id']  = $agentIdArr2[$userRelArr[$v['uid']]['agent_id']]['parent_user_id'];


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


            $userinfoRs2[$k]['status_name']     = $v['ustatus'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';

            $userinfoRs2[$k]['status_o']        = $v['ustatus'] == 0 ? '冻结' : '激活';
            $userinfoRs2[$k]['status_s']        = $v['ustatus'] == 0 ? 1 : 0;

            $userinfoRs2[$k]['trade_frozen_name']     = $v['trade_frozen'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';
        }


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
     * @description: 用户列表导出excel
     * @note:
     */
    public function user_daochu()
    {
        $operate    = trim(I('get.operate'));
        $jinjiren   = trim(I('get.jinjiren'));
        $user       = trim(I('get.user'));
        $start_time = urldecode(trim(I('get.start_time')));
        $end_time   = urldecode(trim(I('get.end_time')));
        $utel       = trim(I('get.utel'));
        $jostyle    = trim(I('get.jostyle'));

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
        $userinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$agentIdStr.')')->select();

        $userIdArr      = array();
        $userRelArr     = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
            $userRelArr[$v['user_id']]['agent_id']  = $v['parent_user_id'];

        }
        $userIdStr      = implode(',', array_unique($userIdArr));

        

        //运营中心 
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
            $this->assign('operate',$operate);
        }




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
            $map['utel'] = $utel;
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
            $userinfoRs1[$v['uid']]                    = $v;

            $userinfoRs1[$v['uid']]['operate_name']      = $operateinfoRs1[$agentIdArr2[$userRelArr[$v['uid']]['agent_id']]['parent_user_id']]['nickname'];

            $userinfoRs1[$v['uid']]['operate_username']  = $operateinfoRs1[$agentIdArr2[$userRelArr[$v['uid']]['agent_id']]['parent_user_id']]['username'];

            $userinfoRs1[$v['uid']]['operate_id']  = $agentIdArr2[$userRelArr[$v['uid']]['agent_id']]['parent_user_id'];


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

        foreach($userinfoRs1 as $k => $v)
        {
            $userinfoRs2[$k]                = $v;
            $userinfoRs2[$k]['last_login']  = !empty($v['lastlog']) ? date('Y-m-d H:i:s', $v['lastlog']) : '<span class="label label-sm label-warning">未登录过</span>';
            $userinfoRs2[$k]['create_date'] = date('Y-m-d H:i:s', $v['utime']);

            $userinfoRs2[$k]['name']        = $bankinfoRs1[$v['uid']]['busername'];


            $userinfoRs2[$k]['status_name']     = $v['ustatus'] == 0 ? '<span class="label label-sm label-success">正常</span>' : '<span class="label label-sm label-warning">冻结</span>';

            $userinfoRs2[$k]['status_o']        = $v['ustatus'] == 0 ? '冻结' : '激活';
            $userinfoRs2[$k]['status_s']        = $v['ustatus'] == 0 ? 1 : 0;

            $userinfoRs2[$k]['trade_frozen_name'] = $v['trade_frozen'] == 0 ? '正常' : '冻结';
        }

        $data[0] = array('编号','用户姓名','所属运营','所属经纪人','手机号','现金余额','积分余额','累计充值','累计提现','注册时间','最后登录时间','交易状态');
        foreach ($userinfoRs2 as $key => $value) {
            $name = !empty($value['name']) ? $value['name'] : $value['username'];
            $data[$key+1][] = $value['uid'];
            $data[$key+1][] = $name;
            $data[$key+1][] = $value['operate_name'];
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
     * @author: wang
     * @date: 2017-5-29 12:35:57
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
     * @functionname: money_flow
     * @author: wang
     * @date: 2017-5-28 20:28:24
     * @description: 用户流水
     * @note:
     */
    public function money_flow() 
    {
       $MoneyFlow               = M('MoneyFlow');
       $userinfo                = M('userinfo');
       $userinfoRelationshipObj = M('UserinfoRelationship');
       $bankinfo                = M('bankinfo');

       $operate    = trim(I('get.operate'));
       $jinjiren   = trim(I('get.jinjiren'));
       $user       = trim(I('get.user'));
       $start_time = urldecode(trim(I('get.start_time')));
       $end_time   = urldecode(trim(I('get.end_time')));
       $utel       = trim(I('get.utel'));
       $type       = trim(I('get.type'));
       $operator   = trim(I('get.operator'));

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

        //运营中心 
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
            $this->assign('operate',$operate);
        }



        // 经纪人
        if($jinjiren) {
            $agentArr = array();
            $agentinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$jinjiren.')')->select();
            foreach ($agentinfoRelationshipRs as $key => $value) {
                 array_push($agentArr,$value['user_id']);
            }
            $agentId = implode(',',array_unique($agentArr));
            $userIdStr = $agentId;
            $this->assign('jinjiren',$this->get_username($jinjiren));
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
            $where['utel'] = $utel;
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


            $Flow[$key]['operate_name']      = $operateinfoRs1[$agentIdArr2[$userRelArr[$value['uid']]['agent_id']]['parent_user_id']]['nickname'];

            $Flow[$key]['operate_username']  = $operateinfoRs1[$agentIdArr2[$userRelArr[$value['uid']]['agent_id']]['parent_user_id']]['username'];

            $Flow[$key]['operate_id']  = $agentIdArr2[$userRelArr[$value['uid']]['agent_id']]['parent_user_id'];


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

       $operate    = trim(I('get.operate'));
       $jinjiren   = trim(I('get.jinjiren'));
       $user       = trim(I('get.user'));
       $start_time = urldecode(trim(I('get.start_time')));
       $end_time   = urldecode(trim(I('get.end_time')));
       $utel       = trim(I('get.utel'));
       $type       = trim(I('get.type'));
       $operator   = trim(I('get.operator'));

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

        //运营中心 
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
         }

         //手机号码筛选
         if($utel) {
            $agentArr2 = array();
            $where['utel'] = $utel;
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

         //z资金变动筛选
         if($type) {
            $map['type'] = $type;
         }

         //操作人筛选
         if($operator) {
            $map['op_id'] = $operator;
         }
        
        //start
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


            $Flow[$key]['operate_name']      = $operateinfoRs1[$agentIdArr2[$userRelArr[$value['uid']]['agent_id']]['parent_user_id']]['nickname'];

            $Flow[$key]['operate_username']  = $operateinfoRs1[$agentIdArr2[$userRelArr[$value['uid']]['agent_id']]['parent_user_id']]['username'];

            $Flow[$key]['operate_id']  = $agentIdArr2[$userRelArr[$v['uid']]['agent_id']]['parent_user_id'];


            $Flow[$key]['agent_id']           = $userRelArr[$value['uid']]['agent_id'];  //经纪人id
            $Flow[$key]['agent_name']         = $agentinfoRs1[$userRelArr[$value['uid']]['agent_id']]['nickname'];  //经纪人名称
            $Flow[$key]['agent_username']     = $agentinfoRs1[$userRelArr[$value['uid']]['agent_id']]['username'];  //经纪人名称
        }

        $data[0] = array('编号','用户姓名','运营中心','经纪人昵称','手机号','资金变动描述','变动金额','操作人','操作时间');
        foreach ($Flow as $key => $value) {
            $name          = !empty($value['busername']) ? $value['busername'] : $value['username'];
            $operator_name = !empty($value['operator_busername']) ? $value['operator_busername'] : $value['operator'];

            $data[$key+1][] = $value['id'];
            $data[$key+1][] = $name;
            $data[$key+1][] = $value['operate_username'];
            $data[$key+1][] = $value['agent_username'];
            $data[$key+1][] = $value['utel'];
            $data[$key+1][] = $value['note'];
            $data[$key+1][] = $value['account'];
            $data[$key+1][] = $operator_name;
            $data[$key+1][] = date('Y-m-d H:i:s',$value['dateline']);  
        }
        $name='用户资金流水';
        $this->push($data,$name);
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