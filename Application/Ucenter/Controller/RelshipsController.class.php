<?php
/**
 * @author: FrankHong
 * @datetime: 2016-12-06 11:18:03
 * @filename: RelshipsController.class.php
 * @description: 经纪人推广模块
 * @note:
 *
 */

namespace Ucenter\Controller;

class RelshipsController extends CommonController
{
    /**
     * @functionname: relship_list
     * @author: FrankHong
     * @date: 2016-12-06 11:38:24
     * @description: 经纪人推广用户的佣金流水
     * @note:
     */
    public function relship_commission_list()
    {

        $userid     = trim(I('get.user'));
        $utel       = trim(I('get.utel'));
        $status     = trim(I('get.status'));
        $type       = trim(I('get.type'));
        $starttime = urldecode(trim(I('get.start_time')));
        $endtime   = urldecode(trim(I('get.end_time')));
        $where      = '';

        $userinfoRelationshipObj    = M('userinfo_relationship');

        $userinfoObj        = M('userinfo');

        //查询运营zhongxin
        $business = $userinfoRelationshipObj->where(array('user_id' => NOW_UID))->find();

        //用户
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $userinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

        $userIdArr  = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
        }
        $uid        = implode(',',array_unique($userIdArr));
        $userIdStr  = implode(',', array_unique($userIdArr));


        $Search['user_id']   = array('in',$userIdStr);
        $Search['type']      =  array(array('eq',3),array('eq',1), 'or');

        //普通会员
        if($userid) {
            $receive = M('fee_receive')->where(array('user_id' => $userid,'type' => 1))->select();
            $purchaserArr = array();
            foreach ($receive as $key => $value) {
                array_push($purchaserArr,$value['purchaser_id']);
            }
            $userIdStr = $userid;
            $userinfoWhereArr   = 'uid in ('.implode(',',$purchaserArr).')';
            $Search['type']     =  1;
            $this->assign('userid',$userid);
        }

        //手机号码筛选
        if($utel) {
            $agentArr2 = array();
            $map['utel']  = $utel;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }

            $userid = implode(',',$agentArr2);
            $Search['user_id'] = array('in',$userid);
            $this->assign('utel',$utel);
        }


        //结算状态筛选
        if($status) {
            $Search['status'] = $status;
            $this->assign('status',$status);
        }

        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);

            $Search['create_time'] = array('between',array($start_time,$end_time));
            $sea['start_time'] = $starttime;
            $sea['end_time'] = $endtime;
            $this->assign('time',$sea);
        }

        //佣金
        $feeObj         = M('fee_receive');
        $count          = $feeObj->where($Search)->count();
        $pageObj        = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow       = $pageObj->show();

        $feeRs  = $feeObj
            ->where($Search)
            ->order('create_time desc, order_id desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        foreach ($fee_rmb as $key => $value) {
            $account['currency_rmb'] += $value['currency_rmb'];
        }

        //用户名称
        $userIdStr      = empty($userIdStr) ? '' : $userIdStr.','.$business['parent_user_id'];
        $feeUserRs      = $userinfoObj->where('uid in ('.$userIdStr.')')->select();
        $feeUserRs1     = array();
        foreach($feeUserRs as $k => $v)
        {
            $feeUserRs1[$v['uid']]  = $v;
        }


        $feeRsUserIdArr = array();
        $feeRs1         = array();

        foreach($feeRs as $k => $v)
        {
            $feeRs1[$v['id']]           = $v;
            $feeRs1[$v['id']]['u_name'] = !empty($feeUserRs1[$v['user_id']]['nickname']) ? $feeUserRs1[$v['user_id']]['nickname'] : $feeUserRs1[$v['user_id']]['username'];
            $feeRs1[$v['id']]['date_c'] = date('Y-m-d H:i:s', $v['create_time']);
            $feeRs1[$v['id']]['otype']  = $feeUserRs1[$v['user_id']]['otype'];
            $feeRs1[$v['id']]['utel']   = $feeUserRs1[$v['user_id']]['utel'];

            $feeRs1[$v['id']]['status_n']   = $v['status'] == 2 ? '<span class="label label-sm label-warning">未结算</span>' : '<span class="label label-sm label-success">已结算</span>';

            array_push($feeRsUserIdArr, $v['purchaser_id']);
        }
        $feeRsUserIdStr = implode(',', array_unique($feeRsUserIdArr));

        $feeRsUserIdRs  = $userinfoObj->where('uid in ('.$feeRsUserIdStr.')')->select();
        foreach($feeRsUserIdRs as $k => $v)
        {
            $feeRsUserIdRs1[$v['uid']]  = $v;
        }

        $feeRs2         = array();
        foreach($feeRs1 as $k => $v)
        {
            $feeRs2[$k]                     = $v;
            $feeRs2[$k]['purchaser_name']   = $feeRsUserIdRs1[$v['purchaser_id']]['nickname'];
            $account['profit_rmb']          += $v['profit_rmb'];

            if($v['status'] == 1) {
                $account['count'] += count($v['status']);
            }
            if($v['status'] == 2) {
                $account['count_stop'] += count($v['status']);
            }
        }
        $this->assign('account',$account);

        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('feeRs', $feeRs2);
        $this->assign('totalCount', $count);

        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $name = M('userinfo a')->field('a.uid,a.username,b.busername')->join(' left join wp_bankinfo as b on a.uid = b.uid')->where('a.uid in('.$uid.')')->select();
        foreach ($name as $key => $value) {
            $name[$key]['username'] = !empty($value['busername']) ? $value['busername'] : $value['username'];
        }
        $this->assign('user',$name);
        $this->display();
    }

    /**
     * @functionname: relship_list
     * @author: FrankHong
     * @date: 2016-12-04 12:48:52
     * @description: 佣金流水导出excel
     * @note:
     */

    public function commission_daochu()
    {
        $userid     = trim(I('get.user'));
        $utel       = trim(I('get.utel'));
        $status     = trim(I('get.status'));
        $type       = trim(I('get.type'));
        $starttime = urldecode(trim(I('get.start_time')));
        $endtime   = urldecode(trim(I('get.end_time')));
        $where      = '';

        $userinfoRelationshipObj    = M('userinfo_relationship');

        $userinfoObj        = M('userinfo');

        //查询运营zhongxin
        $business = $userinfoRelationshipObj->where(array('user_id' => NOW_UID))->find();

        //用户
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $userinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

        $userIdArr  = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
        }
        $uid        = implode(',',array_unique($userIdArr));
        $userIdStr  = implode(',', array_unique($userIdArr));


        $Search['user_id']   = array('in',$userIdStr);
        $Search['type']      =  array(array('eq',3),array('eq',1), 'or');

        //普通会员
        if($userid) {
            $receive = M('fee_receive')->where(array('user_id' => $userid,'type' => 1))->select();
            $purchaserArr = array();
            foreach ($receive as $key => $value) {
                array_push($purchaserArr,$value['purchaser_id']);
            }
            $userIdStr = $userid;
            $userinfoWhereArr   = 'uid in ('.implode(',',$purchaserArr).')';
            $Search['type']     =  1;
            $this->assign('userid',$userid);
        }

        //手机号码筛选
        if($utel) {
            $agentArr2 = array();
            $map['utel']  = $utel;
            $map['uid'] = array('in',$userIdStr);
            $userinfo = $userinfoObj->where($map)->select();
            foreach ($userinfo as $key => $value) {
                array_push($agentArr2,$value['uid']);
            }

            $userid = implode(',',$agentArr2);
            $Search['user_id'] = array('in',$userid);
            $this->assign('utel',$utel);
        }


        //结算状态筛选
        if($status) {
            $Search['status'] = $status;
            $this->assign('status',$status);
        }

        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            if($start_time || $end_time)
            {
                $Search['create_time'] = array('between',array($start_time,$end_time));
                $sea['start_time'] = $starttime;
                $sea['end_time'] = $endtime;
                $this->assign('time',$sea);
            }
        }

        //佣金
        $feeObj         = M('fee_receive');
        $count          = $feeObj->where($Search)->count();
        $pageObj        = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow       = $pageObj->show();

        $feeRs  = $feeObj
            ->where($Search)
            ->order('create_time desc, order_id desc')
            ->select();

        foreach ($fee_rmb as $key => $value) {
            $account['currency_rmb'] += $value['currency_rmb'];
        }

        //用户名称
        $userIdStr      = empty($userIdStr) ? '' : $userIdStr.','.$business['parent_user_id'];
        $feeUserRs      = $userinfoObj->where('uid in ('.$userIdStr.')')->select();
        $feeUserRs1     = array();
        foreach($feeUserRs as $k => $v)
        {
            $feeUserRs1[$v['uid']]  = $v;
        }



        $feeRsUserIdArr = array();
        $feeRs1         = array();

        foreach($feeRs as $k => $v)
        {
            $feeRs1[$v['id']]           = $v;
            $feeRs1[$v['id']]['u_name'] = !empty($feeUserRs1[$v['user_id']]['nickname']) ? $feeUserRs1[$v['user_id']]['nickname'] : $feeUserRs1[$v['user_id']]['username'];
            $feeRs1[$v['id']]['date_c'] = date('Y-m-d H:i:s', $v['create_time']);
            $feeRs1[$v['id']]['otype']  = $feeUserRs1[$v['user_id']]['otype'];
            $feeRs1[$v['id']]['utel']   = $feeUserRs1[$v['user_id']]['utel'];

            $feeRs1[$v['id']]['status_n']   = $v['status'] == 2 ? '<span class="label label-sm label-warning">未结算</span>' : '<span class="label label-sm label-success">已结算</span>';

            array_push($feeRsUserIdArr, $v['purchaser_id']);
        }
        $feeRsUserIdStr = implode(',', array_unique($feeRsUserIdArr));

        $feeRsUserIdRs  = $userinfoObj->where('uid in ('.$feeRsUserIdStr.')')->select();
        foreach($feeRsUserIdRs as $k => $v)
        {
            $feeRsUserIdRs1[$v['uid']]  = $v;
        }

        $feeRs2         = array();
        foreach($feeRs1 as $k => $v)
        {
            $feeRs2[$k]                     = $v;
            $feeRs2[$k]['purchaser_name']   = $feeRsUserIdRs1[$v['purchaser_id']]['nickname'];
        }

        $data[0] = array('编号','推广员用户昵称','手机号码','用户类型','推广员获得佣金','交易用户','结算状态','流水时间');
        foreach ($feeRs2 as $key => $value) {
            $otype = $value['otype'] == 4 ? '普通会员' : '运营中心';

            $data[$key+1][] = $value['order_id'];
            $data[$key+1][] = getUsername($value['user_id']);
            $data[$key+1][] = $value['utel'];
            $data[$key+1][] = $otype;
            $data[$key+1][] = $value['profit_rmb'];
            $data[$key+1][] = getUsername($value['purchaser_id']);
            $data[$key+1][] = $value['status_n'];
            $data[$key+1][] = $value['date_c'];

        }
        $name = '佣金流水表';
        $this->push($data,$name);
    }


    /**
     * @functionname: relship_list
     * @author: FrankHong
     * @date: 2016-12-04 12:48:52
     * @description: 经纪人推广员列表
     * @note:
     */
    public function relship_list()
    {
        $userid       = trim(I('get.user'));
        $utel       = trim(I('get.utel'));
        $starttime = urldecode(trim(I('get.starttime')));
        $endtime = urldecode(trim(I('get.endtime')));


        $userinfoRelationshipObj    = M('userinfo_relationship');
        $userinfoObj        = M('userinfo');

        //经纪人
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );


        $userinfoRelationshipRs     = $userinfoRelationshipObj->where($whereArr)->select();

        $userIdArr  = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
        }
        $uid = implode(',',array_unique($userIdArr));
        $userIdStr  = implode(',', array_unique($userIdArr));


        //普通会员
        if($userid) {
            $userIdStr = $userid;
            $this->assign('userid',$userid);
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
            $userId = empty($userId) ? 1 : $userId;
            $userIdStr = $userId;
            $this->assign('utel',$utel);
        }

        if($starttime  && $endtime)
        {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where = 'and utime between '.$start_time.' and '.$end_time.'';
            $sea['starttime'] = $starttime;
            $sea['endtime'] = $endtime;
            $this->assign('sea',$sea);
        }




        $userinfoWhereArr   = 'uid in ('.$userIdStr.')';

        $userinfoRs         = $userinfoObj->where($userinfoWhereArr)->select();
        $userinfoRs1        = array();
        foreach($userinfoRs as $k => $v)
        {
            $userinfoRs1[$v['uid']] = $v;
        }


        $relUserWhereArr= 'uid in ('.$userIdStr.') and `code` is not null and code != "" and otype = 4'.$where.'';
        $count          = $userinfoObj->where($relUserWhereArr)->count();
        $pageObj        = new \Think\Pageace($count, PAGE_SIZE);
        $pageShow       = $pageObj->show();

        $relUserRs      = $userinfoObj
            ->where($relUserWhereArr)
            ->order('utime desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        $relUserRs1 = array();
        foreach($relUserRs as $k => $v)
        {
            $relUserRs1[$v['uid']]  = $v;
            $relUserRs1[$v['uid']]['date_c']  = date('Y-m-d H:i:s', $v['utime']);
        }

        $relUserRss      = $userinfoObj
            ->where($relUserWhereArr)
            ->select();
        foreach($relUserRss as $k => $v)
        {
            $profit_rmb += M('extension')->where(array('user_id' => $v['uid']))->sum('money');
        }


        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('relUserRs', $relUserRs1);
        $this->assign('totalCount', $count);

        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $name = M('userinfo a')->field('a.uid,a.username,b.busername')->join(' left join wp_bankinfo as b on a.uid = b.uid')->where('a.uid in('.$uid.')')->select();
        foreach ($name as $key => $value) {
            $name[$key]['username'] = !empty($value['busername']) ? $value['busername'] : $value['username'];
        }
        $this->assign('user',$name);
        $this->assign('profit_rmb',$profit_rmb);
        $this->display();
    }


    /**
     * @functionname: relship_list
     * @author: FrankHong
     * @date: 2016-12-04 12:48:52
     * @description: 推广员列表导出excel
     * @note:
     */

    public function relship_list_daochu()
    {
        $userid     = trim(I('get.user'));
        $utel       = trim(I('get.utel'));
        $starttime = urldecode(trim(I('get.starttime')));
        $endtime = urldecode(trim(I('get.endtime')));


        $userinfoRelationshipObj    = M('userinfo_relationship');
        $userinfoObj                = M('userinfo');

        //经纪人
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );


        $userinfoRelationshipRs     = $userinfoRelationshipObj->where($whereArr)->select();

        $userIdArr  = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
        }
        $uid = implode(',',array_unique($userIdArr));
        $userIdStr  = implode(',', array_unique($userIdArr));


        //普通会员
        if($userid) {
            $userIdStr = $userid;
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
            $userId = empty($userId) ? 1 : $userId;
            $userIdStr = $userId;
        }


        if($starttime  && $endtime)
        {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where = 'and utime between '.$start_time.' and '.$end_time.'';
            $sea['starttime'] = $starttime;
            $sea['endtime'] = $endtime;
            $this->assign('sea',$sea);
        }

        $userinfoWhereArr   = 'uid in ('.$userIdStr.')';

        $userinfoRs         = $userinfoObj->where($userinfoWhereArr)->select();
        $userinfoRs1        = array();
        foreach($userinfoRs as $k => $v)
        {
            $userinfoRs1[$v['uid']] = $v;
        }


        $relUserWhereArr= 'uid in ('.$userIdStr.') and `code` is not null and code != "" and otype = 4'.$where.'';

        $relUserRs      = $userinfoObj
            ->where($relUserWhereArr)
            ->order('utime desc')
            ->select();

        $relUserRs1 = array();
        foreach($relUserRs as $k => $v)
        {
            $relUserRs1[$v['uid']]  = $v;
            $relUserRs1[$v['uid']]['date_c']  = date('Y-m-d H:i:s', $v['utime']);
        }

        $data[0] = array('推广员编号','推广员用户昵称','推广员手机号码','推广码','创建时间');
        foreach ($relUserRs1 as $key => $value) {
            $data[$key+1][] = $value['uid'];
            $data[$key+1][] = $value['nickname'];
            $data[$key+1][] = $value['utel'];
            $data[$key+1][] = $value['code'];
            $data[$key+1][] = $value['date_c'];

        }
        $name = '推广员列表';
        $this->push($data,$name);
    }


    /**
     * 推广员下级
     * @author wang <admin>
     */
    public function subordinate(){

        $user_id = trim(I('get.user_id'));
        $level   = trim(I('get.level'));
        $status  = trim(I('get.status'));
        $starttime = urldecode(trim(I('get.starttime')));
        $endtime = urldecode(trim(I('get.endtime')));


        if($starttime  && $endtime)
        {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where = ' and a.create_time between '.$start_time.' and '.$end_time.'';
            $sea['starttime'] = $starttime;
            $sea['endtime'] = $endtime;
            $this->assign('sea',$sea);
        }

        $optionIdArr     = array();
        $optionIdArr_two = array();
        $userobj=M('userinfo');
        //一年有效期
        $userinfo = M()->query("select uid from wp_userinfo where UNIX_TIMESTAMP(NOW()) < utime+365*24*60*60 and rid = ".$user_id." ");
        foreach ($userinfo as $key => $value) {
            array_push($optionIdArr,$value['uid']);
        }

        $uid   = implode(',',array_unique($optionIdArr));

        $water  = M()->query("select a.*,b.*,c.*,d.id,d.capital_name from wp_fee_receive as a left join wp_userinfo as b on a.purchaser_id = b.uid left join wp_order as c on a.order_id = c.oid left join wp_option as d on c.pid = d.id where unix_timestamp(now()) < b.utime+365*24*60*60  and a.type = 1 and a.purchaser_id in(".$uid.") and a.user_id = ".$user_id." ".$where."");

        foreach ($water as $key => $val) {

            $aa[$key]['lavel']        = '一级';
            $aa[$key]['id']           = $val['id'];
            $aa[$key]['purchaser_id'] = $value['purchaser_id'];
            $aa[$key]['username']     = $val['username'];
            $aa[$key]['profit_rmb']   = $val['profit_rmb'];  //一级
            $aa[$key]['create_time']  = date("Y-m-d H:i:s",$val['create_time']);
            $aa[$key]['status']       = $val['status'];
            $aa[$key]['fee_rmb']       = $val['fee_rmb'];
            $aa[$key]['onumber']      = $val['onumber'].'手';
            $aa[$key]['capital_name'] = $val['capital_name'];
        }

        //二级
        $user_two = M()->query("select * from wp_userinfo where UNIX_TIMESTAMP(NOW()) < utime+365*24*60*60 and rid in(".$uid.")");
        foreach ($user_two as $value) {

            array_push($optionIdArr_two,$value['uid']);
        }

        $water_two = implode(',',array_unique($optionIdArr_two));
        $two = M()->query("select a.*,b.*,c.*,d.id,d.capital_name from wp_fee_receive as a left join wp_userinfo as b on a.purchaser_id = b.uid left join wp_order as c on a.order_id = c.oid left join wp_option as d on c.pid = d.id where unix_timestamp(now()) < b.utime+365*24*60*60  and a.type = 1 and a.purchaser_id in(".$water_two.") and a.user_id = ".$user_id." ".$where."");

        foreach ($two as $key => $value) {

            $bb[$key]['lavel']        = '二级';
            $bb[$key]['id']           = $value['id'];
            $bb[$key]['purchaser_id'] = $value['purchaser_id'];
            $bb[$key]['username']     = $value['username'];
            $bb[$key]['profit_rmb']   = $value['profit_rmb'];
            $bb[$key]['create_time']  = date("Y-m-d H:i:s",$value['create_time']);
            $bb[$key]['status']       = $value['status'];
            $bb[$key]['fee_rmb']       = $value['fee_rmb'];
            $bb[$key]['onumber']      = $value['onumber'].'手';
            $bb[$key]['capital_name'] = $value['capital_name'];
        }

        $a = count($aa) >= count($bb) ? $aa : $bb;
        //$a = empty($bb) ? $aa : $bb;
        foreach ($a as $kkk => $vvv) {
            switch ($level) {
                case 1:
                    $user[] = $aa[$kkk];
                    break;
                case 2:
                    $user[] = $bb[$kkk];
                    break;
                default:
                    $user[] = $aa[$kkk];
                    $user[] = $bb[$kkk];
                    break;
            }


        }

        $user = array_filter($user);
        foreach ($user as $key => $value) {
            if(empty($status)) {
                $users[] = $value;
            } else {
                if($value['status'] == $status)
                {
                    $users[] = $value;
                }
            }
        }

        $datetime = array();
        foreach ($users as $v) {
            $datetime[] = $v['create_time'];
            $currency   += $v['fee_rmb'];      //总手续费
            $profit_rmb += $v['profit_rmb'];  //总佣金
        }
        array_multisort($datetime,SORT_DESC,$users);
        $users = $this->array_page($users,10);


        $this->assign('user',$users);
        $this->assign('currency',$currency);
        $this->assign('profit_rmb',$profit_rmb);
        $this->assign('level',$level);
        $this->assign('status',$status);
        $this->assign('username',M('userinfo')->field('username,uid')->where(array('uid' => $user_id))->find());
        $this->display();
    }


    public function lowerlevel() {
        $userinfo = M('userinfo a');

        $user_id  = trim(I('get.user_id'));
        $level    = trim(I('get.level'));
        $username = trim(I('get.username'));
        $starttime = urldecode(trim(I('get.starttime')));
        $endtime = urldecode(trim(I('get.endtime')));

        $optionIdArr = array();

        if(!empty($username))
        {   if($level == 1)
        {
            $one_map['_complex']['a.username']  = array('like', '%' .$username. '%');
            $one_map['_complex']['b.busername'] = array('like','%'.$username.'%');
            $one_map['_complex']['_logic']='OR';
        } else if($level == 2)
        {
            $two_map['_complex']['a.username']  = array('like', '%' .$username. '%');
            $two_map['_complex']['b.busername'] = array('like','%'.$username.'%');
            $two_map['_complex']['_logic']='OR';
        } else {
            $one_map['_complex']['a.username']  = array('like', '%' .$username. '%');
            $one_map['_complex']['b.busername'] = array('like','%'.$username.'%');
            $one_map['_complex']['_logic']='OR';
            $two_map['_complex']['a.username']  = array('like', '%' .$username. '%');
            $two_map['_complex']['b.busername'] = array('like','%'.$username.'%');
            $two_map['_complex']['_logic']='OR';
        }
            $this->assign('username',$username);
        }

        if($starttime  && $endtime)
        {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $one_map['a.utime'] = array('between',array($start_time,$end_time));
            $two_map['a.utime'] = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime'] = $endtime;
            $this->assign('sea',$sea);
        }

        $field = 'a.*,b.busername';

        $one_map['a.rid'] = $user_id;
        $one_level = $userinfo->field($field)->join('left join wp_bankinfo as b on a.uid = b.uid')->where($one_map)->select();
        foreach ($one_level as $key => $val) {
            $one[$key]['lavel']         = '一级';
            $one[$key]['uid']           = $val['uid'];
            $one[$key]['utel']          = $val['utel'];
            $one[$key]['utime']         = date("Y-m-d H:i:s",$val['utime']);
            $one[$key]['lastlog']       = date("Y-m-d H:i:s",$val['lastlog']);
            $one[$key]['last_login_ip'] = $val['last_login_ip'];
            $one[$key]['rid']           = $val['rid'];
        }


        $one_null = $userinfo->where(array('rid' => $user_id))->select();
        foreach ($one_null as $key => $val) {
            array_push($optionIdArr,$val['uid']);
        }

        $uid   = implode(',',array_unique($optionIdArr));
        if(!empty($uid)) {
            $two_map['a.rid'] = array('in',$uid);
            $two_level = $userinfo->field($field)->join('left join wp_bankinfo as b on a.uid = b.uid')->where($two_map)->select();
        }

        // echo M()->getLastSql();

        foreach ($two_level as $key => $value) {

            $two[$key]['lavel']         = '二级';
            $two[$key]['uid']           = $value['uid'];
            $two[$key]['utel']          = $value['utel'];
            $two[$key]['utime']         = date("Y-m-d H:i:s",$value['utime']);
            $two[$key]['lastlog']       = date("Y-m-d H:i:s",$value['lastlog']);
            $two[$key]['last_login_ip'] = $value['last_login_ip'];
            $two[$key]['rid'] = $value['rid'];
        }

        $type = isset($one) ? $one : $two;
        foreach ($type as $k => $v) {
            switch ($level) {
                case 1:
                    $user[] = $one[$k];
                    break;
                case 2:
                    $user[] = $two[$k];
                    break;
                default:
                    $user[] = $one[$k];
                    $user[] = $two[$k];
                    break;
            }
        }


        $user = array_filter($user);
        $datetime = array();
        foreach ($user as $v) {
            $datetime[] = $v['utime'];
            if($v['lavel'] == '一级') {
                $counts['one'] += count($v['lavel']);
            }
            if($v['lavel'] == '二级') {
                $counts['two'] += count($v['lavel']);
            }
            $counts['count'] += count($v['lavel']);
        }
        array_multisort($datetime,SORT_DESC,$user);
        $user = $this->array_page($user,10);
        $this->assign('user',$user);
        $this->assign('user_id',$user_id);
        $this->assign('level',$level);

        $this->assign('counts',$counts);
        $this->display();
    }

    public function array_page($array,$rows){

        $count = count($array);
        $Page = new \Think\Page($count, $rows);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $Page->setConfig('first', '首页');
        $Page->setConfig('prev','<<');
        $Page->setConfig('next','>>');
        $Page->setConfig('last', '尾页');
        $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $Page->show();
        $p    = I('get.p');

        $list=array_slice($array,$Page->firstRow,$Page->listRows);
        $this->assign('page',$show);
        $this->assign('count',$count);
        $this->assign('nowEnd',ceil($count/$rows));
        if(empty($p)) {
            $nowStart = 1;
        } else {
            $nowStart = $p;
        }
        $this->assign('nowStart',$nowStart);
        return $list;
    }


    private function push($data,$name){
        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data,$name);
    }
}
