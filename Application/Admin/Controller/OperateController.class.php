<?php
// +----------------------------------------------------------------------
// | 运营中心控制器
// +----------------------------------------------------------------------
// | Author wang <admin>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Think\Controller;
class OperateController extends CommonController {

    /**
     * 运营中心列表
     * @author wang <admin>
     */
    public function index()
    {
        $phone    = trim(I('get.phone'));
        $username = trim(I('get.username')); 

        if($phone){

            $map['a.utel'] = $phone;
            $row['phone']  = $phone;
            $this->assign('phone',$phone);
        }

        if($username){

            $map['a.username'] = array('like',''.I('get.username').'%');
            $row['username']   = $username;
            $this->assign('username',$username);
        }

        $map['a.otype'] = 5;
        //分页
        $count = M('userinfo a')->where($map)->count();
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $row;
        $page->setConfig('first','首页');
        $page->setConfig('prev','&#8249;');
        $page->setConfig('next','&#8250;');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $user = M('userinfo a')->field('a.*,b.balance,b.gold_threshold,b.frozen_threshold')->join('left join wp_accountinfo as b on a.uid = b.uid')->where($map)->order('a.uid desc')->limit($page->firstRow.','.$page->listRows)->select();

        /*查询上级 运营中心分部Start*/

        $userArr = array();
        foreach ($user as $key => $value) {
            array_push($userArr, $value['uid']);
        }

        $user_id = implode(',', $userArr);
        $branch  = M('userinfo_relationship')->field('user_id,parent_user_id')->where('user_id in('.$user_id.')')->select();

        $branchData1    = array();
        $branchArr      = array();
        foreach ($branch as $key => $value) {
            array_push($branchArr, $value['parent_user_id']);
            $branchData1[$value['user_id']] = $value;
        }

        $parent_user_id   = implode(',', $branchArr);
        $branchData  = M('userinfo')->field('uid,username')->where('uid in ('.$parent_user_id.')')->select();
        
        $branchData2 = array();
        foreach ($branchData as $key => $value) {
            $branchData2[$value['uid']] = $value;
        }

        foreach ($user as $key => $value) {
            $user[$key]['branch_name'] = empty($branchData2[$branchData1[$value['uid']]['parent_user_id']]['username']) ? '暂无' : $branchData2[$branchData1[$value['uid']]['parent_user_id']]['username'];
        }

        /*查询上级 运营中心分部End*/

        $this->assign('user',$user);
        $this->assign('count',$count);
        $this->assign('page',$show);
        $this->display();
    }

    /**
     * 查看运营中心资金统计详情
     * @uid 要查看的运营中心uid
     */
    public function show(){
        if(IS_AJAX){
            $uid = I('post.uid',0);
            if($uid <1) $this->ajaxReturn(array('msg'=>'不存在该运营中心','status'=>0));
            $mObj       = M();
            $returnRs   = array();

            $userinfoRelationshipObj    = M('userinfo_relationship');

            //运营中心用户信息
            $userinfoObj    = M('userinfo');
            $proxyInfoArr   = 'uid='.$uid;
            $proxyInfoRs    = $userinfoObj->where($proxyInfoArr)->find();
            $returnRs['username'] = $proxyInfoRs['username'];

            //经纪人
            $whereArr   = array(
                'parent_user_id'    => $uid
            );
            $agentinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

            $agentIdArr = array();
            foreach($agentinfoRelationshipRs as $k => $v)
            {
                array_push($agentIdArr, $v['user_id']);
            }
            $agentIdStr  = implode(',', array_unique($agentIdArr));

            $agentinfoWhereArr  = 'uid in ('.$agentIdStr.')';

            $agentinfoRs    = $userinfoObj->where($agentinfoWhereArr)->select();
            $agentinfoRs1   = array();
            foreach($agentinfoRs as $k => $v)
            {
                $agentinfoRs1[$v['uid']]    = $v;
            }
            $returnRs['agent_total']= count($agentinfoRs);

            //用户
            $userinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$agentIdStr.')')->select();
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
            $orderRs            = $mObj->table('view_wp_journal')->where($userinfoWhereArr)->select();

            $totalMoney = array();

            foreach($orderRs as $k =>$v)
            {
                $orderRs1[$v['oid']]    = $v;
                array_push($totalMoney, $v['jploss'] );

            }

            $returnRs['total_money']    = number_format(array_sum($totalMoney),2);
            

            //总金额  手续费  订单个数
            $orderFee            = $mObj->table('view_wp_journal_jian')->where($userinfoWhereArr)->select();

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
            $accountinfoRs  = $accountinfoObj->where('uid='.$uid)->find();

            $returnRs['account']        = number_format($accountinfoRs['balance'],2);

            //手续费
            $feeObj = M('fee_receive');

            $feeWhereArr    = 'type = 3 and status = 1 and user_id in ('.$uid.')';
            $feeRs          = $feeObj->where($feeWhereArr)->select();
            $totalCommission= array();
            $orderIdArr = array();
            foreach($feeRs as $k => $v)
            {   
                array_push($totalCommission, $v['profit_rmb']);
                array_push($orderIdArr,$v['order_id']);

            }
            $returnRs['total_commission']  = number_format(array_sum($totalCommission),2);

            //自己获取的佣金
            $order_id = implode(',',array_unique($orderIdArr));
            $feeWhereArr    = 'type = 1 and order_id in('.$order_id.')';
            $feeRs          = $feeObj->where($feeWhereArr)->select();
            $totalCommissionSell= array();
            foreach($feeRs as $k => $v)
            {
                array_push($totalCommissionSell, $v['profit_rmb']);
            }
            $returnRs['total_sell_commission']  = $returnRs['total_commission'] - (number_format(array_sum($totalCommissionSell),2));


           //下面的用户获得佣金

            $feeWhereArr    = 'type = 1  and user_id in ('.$userIdStr.')';
            $feeRs          = $feeObj->where($feeWhereArr)->select();
            $totalCommissionUser= array();
            foreach($feeRs as $k => $v)
            {
                array_push($totalCommissionUser, $v['profit_rmb']);
            }
            $returnRs['total_user_commission']  = number_format(array_sum($totalCommissionUser),2);

        
            $data=array('msg'=>'资金详情','status'=>1,'data'=>$returnRs);
            $this->ajaxReturn($data,'JSON');
        }
        $this->error('您访问的地址不存在','/admin/');
    }

    /**
     * 运营中心删除
     * @author wang <admin>
     */
    public function del(){

        $uid    = I('post.uid'); //userid
        $data   = array();
        $ship = M("UserinfoRelationship")->where(array('parent_user_id' => $uid))->select();
        if($ship){

            $data['status'] = 0;
            $data['msg']    = '该运营中心下还有经纪人,你不能删除';
            $this->ajaxReturn($data,'JSON');
        }

        $result = M('userinfo')->where(array('uid' => $uid,'otype' => 5))->delete();
        $account= M('accountinfo')->where(array('uid' => $uid))->delete();
        $del    = M("UserinfoRelationship")->where(array('user_id' => $uid))->delete();
        $special  = M('OptionUserSpecial')->where(array('user_id' => $uid))->delete();

        if($result && $account && $del && $special){

            $data['status'] = 1;
            $data['msg']    = '删除成功';
            $this->ajaxReturn($data,'JSON');
        } else{

            $data['status'] = 0;
            $data['msg']    = '删除失败';
            $this->ajaxReturn($data,'JSON');
        }

    }


    /**
     * 添加运营中心
     * @author wang <admin>
     */
    public function add(){
        if(IS_AJAX){

            $data        = array();
            $username    = I('post.username');
            $notusername = I("post.notusername");
            $s_domain    = I('post.s_domain');
            $pwd         = I('post.pwd');
            $notpwd      = I('post.notpwd');
            $tel         = I('post.tel');
            $branch      = I('post.branch');

            if(trim($branch) == '')
            {
                $data['status'] = 0;
                $data['msg']    = '运营中心分部不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(!M('userinfo')->where(array('uid' => $branch,'otype' => 7))->find())
            {
                $data['status'] = 0;
                $data['msg']    = '系统没有查到此运营中心分部';
                $this->ajaxReturn($data,'JSON');
            }

            if(trim($username) == ''){

                $data['status'] = 0;
                $data['msg']    = '运营中心用户名不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(!preg_match('/^[A-Za-z0-9]+$/', trim($username))){

                $data['status'] = 0;
                $data['msg']    = '运营中心用户名不能包含中文或特殊字符';
                $this->ajaxReturn($data,'JSON');
            }


            if(trim($notusername) == ''){

                $data['status'] = 0;
                $data['msg']    = '经纪人用户名不能为空';
                $this->ajaxReturn($data,'JSON');
            }


            if(!preg_match('/^[A-Za-z0-9]+$/', trim($notusername))){

                $data['status'] = 0;
                $data['msg']    = '经纪人不能包含中文或特殊字符';
                $this->ajaxReturn($data,'JSON');
            }


            if($username == $notusername){

                $data['status'] = 0;
                $data['msg']    = '经纪人用户名不能和运营中心相同';
                $this->ajaxReturn($data,'JSON');
            }

            if(M('userinfo')->where(array('username' => $notusername))->find()){

                $data['status'] = 0;
                $data['msg']    = '经纪人用户名已经存在';
                $this->ajaxReturn($data,'JSON');
            }

            if(trim($s_domain) == ''){

                $data['status'] = 0;
                $data['msg']    = '域名不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(trim($pwd) == ''){

                $data['status'] = 0;
                $data['msg']    = '密码不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(!preg_match('/^[A-Za-z0-9]+$/', trim($pwd))){

                $data['status'] = 0;
                $data['msg']    = '密码不能包含中文或特殊字符';
                $this->ajaxReturn($data,'JSON');
            }

            if(trim($notpwd) != $pwd){

                $data['status'] = 0;
                $data['msg']    = '密码必须一致';
                $this->ajaxReturn($data,'JSON');
            }

            if(trim($tel) == ''){

                $data['status'] = 0;
                $data['msg']    = '手机号码不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(!preg_match('/^1\d{10}$/',$tel)){

                $data['status'] = 0;
                $data['msg']    = '手机号填写错误';
                $this->ajaxReturn($data,'JSON');
            }


            if(M("userinfo")->where('utel='.$tel.' and ustatus in("0,1") and otype=5')->find()){

                $data['status'] = 0;
                $data['msg']    = '该手机号已经存在';
                $this->ajaxReturn($data,'JSON');
            }

            if(M('userinfo')->where(array('username' => $username))->find()){

                $data['status'] = 0;
                $data['msg']    = '运营中心用户名已经存在';
                $this->ajaxReturn($data,'JSON');
            }

            if(M('userinfo')->where(array('s_domain' => $s_domain))->find()){

                $data['status'] = 0;
                $data['msg']    = '该域名已经存在';
                $this->ajaxReturn($data,'JSON');
            }

            //产品列表
            $option = M("option")->select();
            $arr    = array();
            foreach ($option as $key => $value) {

                array_push($arr,$value['id']);
            }

            $map['username'] = trim($username);  //登录帐号
            $map['upwd']     = md5(trim($pwd));
            $map['s_domain'] = trim($s_domain);  //域名
            $map['utel']     = trim($tel);
            $map['utime']    = time();
            $map['otype']    = trim(5);
            $map['ustatus']  = trim(0);
            $result = M('userinfo')->add($map);

            if($result){
                
                $account['uid'] = $result;
                M('accountinfo')->add($account);  //添加运营账户


                $where['user_id']        = $result;
                $where['parent_user_id'] = $branch;
                $where['user_type']      = 5;
                $res = M('UserinfoRelationship')->add($where);

                //添加运营中心产品表
                foreach ($arr as $k => $v) {

                    $specil['user_id']     = $result;
                    $specil['option_id']   = $v;
                    $specil['type']        = 1;
                    $specil['status']      = 1;
                    $specil['create_date'] = time();
                    M("OptionUserSpecial")->add($specil);
                }

                if($res){

                    $two['username'] = $notusername;  //用户登录帐号
                    $two['upwd']     = md5($pwd);
                    $two['utel']     = $tel;
                    $two['utime']    = time();
                    $two['otype']    = 6;
                    $two['ustatus']  = 0;
                    $two['is_default'] = 1; //默认经纪人
                    $two_result      = M('userinfo')->add($two);
                    if($two_result){

                        $two_where['user_id']        = $two_result;
                        $two_where['parent_user_id'] = $result;  //运营中心id
                        $two_where['user_type']      = 6;
                        $two_res = M('UserinfoRelationship')->add($two_where);
                    }
                    if($two_result && $two_res){
                        $data['status'] = 1;
                        $data['msg']    = '注册成功';
                        $this->ajaxReturn($data,'JSON');
                    } else {

                        $data['status'] = 0;
                        $data['msg']    = '注册失败';
                        $this->ajaxReturn($data,'JSON');
                    }

                }

            } else {
                $data['status'] = 0;
                $data['msg']    = '注册失败';
                $this->ajaxReturn($data,'JSON');
            }

        }

        $branch = M('userinfo')->field('uid,username')->where(array('otype' => 7))->select();
        $this->assign('branch',$branch);
        $this->assign('SYSTEM_DOMAIN',SYSTEM_DOMAIN);
        $this->display();
    }

    /**
     * 运营中心金额修改
     * @author wang <admin>
     */

    public function balance(){

        $data    = array();
        $uid     = trim(I('post.uid'));
        $value   = trim(I('post.value'));
        $field   = trim(I('post.field'));

        if(!isset($uid) || !isset($field))
        {
            $data['status'] = 0;
            $data['msg']    = 'id不存在';
            $this->ajaxReturn($data,'JSON');
        }

        if($field == 's_domain' || $field == 'utel')
        {
            if(M('userinfo')->where(array('uid' => $uid))->setField($field,$value))
            {
                $data['status'] = 1;
                $data['msg']    = '修改成功';
                $this->ajaxReturn($data,'JSON');
            } else {
                $data['status'] = 0;
                $data['msg']    = '修改失败';
                $this->ajaxReturn($data,'JSON');
            }
        }

        $account = M("accountinfo")->where(array('uid' => $uid))->find();
        if($account){

            $result = M('accountinfo')->where(array('uid' => $uid))->setInc($field,$value);

        } else {

            $map['uid']     = $uid;
            $map[$field]    = $value;
            $result = M('accountinfo')->add($map);
        }

        if($result && $field == 'balance'){

            $where['user_id'] = $uid;
            $where['account'] = $value;
            $where['type']    = 2;
            $where['create_time'] = time();
            $journal = M("UserJournal")->add($where);

            //运营中心资金流水表
            if($journal)
            {
                if($value > 0) {
                    $msg = '资金变动增加['.$value.']元';
                } else {
                    $msg = '资金变动扣除['.$value.']元';
                }
                $operat_flow['uid']      = $uid;
                $operat_flow['type']     = 4;
                $operat_flow['oid']      = $journal;
                $operat_flow['note']     = $msg;
                $operat_flow['balance']  = M('accountinfo')->where('uid='.$uid)->sum('balance');
                $operat_flow['op_id']    = session('userid');
                $operat_flow['user_type']= 2;
                $operat_flow['dateline'] = time();
                M("MoneyFlow")->add($operat_flow);
            }

        }
        if($result)
        {
            $data['status'] = 1;
            $data['msg']    = '修改成功';
            $this->ajaxReturn($data,'JSON');
        }
        else {
            $data['status'] = 0;
            $data['msg']    = '修改失败';
            $this->ajaxReturn($data,'JSON');
        }
    }

    /**
     * @author [wang] <[admin]>
     */
    
    public function flow()
    {
       $MoneyFlow            = M('MoneyFlow');
       $userinfo             = M('userinfo');
       $UserinfoRelationship = M('UserinfoRelationship');
       $bankinfo             = M('bankinfo');

       $utel      = trim(I('get.utel'));
       $type      = trim(I('get.type'));
       $yunying   = trim(I('get.yunying'));
       $starttime = urldecode(trim(I('get.starttime')));
       $endtime   = urldecode(trim(I('get.endtime')));
       $operator  = trim(I('get.operator'));  //操作人


       if($utel) {
          $searchArr = array();
          $where['utel'] = array('like','%'.$utel.'%');
          $info = $userinfo->where($where)->select();
          foreach ($info as $key => $value) {
              array_push($searchArr,$value['uid']);
          }
          $searchId = implode(',',array_unique($searchArr));
          $map['uid'] = array('in',$searchId);
          $sea['utel'] = $utel;
       } 

       if($type) {
            $map['type'] = $type;
            $sea['type'] = $type;
       }

       if($operator) {
            $map['op_id'] = $operator;
            $this->assign('op_id',$operator);
            $sea['operator'] = $operator;
       }

        if($yunying) {

            // $relation = $UserinfoRelationship->where(array('parent_user_id' => $yunying))->select();
            // $relationArr = array();
            // $relationArr1 = array();
            // foreach ($relation as $key => $value) {
            //      array_push($relationArr,$value['user_id']);
            // }
            // $relationId = implode(',',array_unique($relationArr));
            // $users = $UserinfoRelationship->where('parent_user_id in('.$relationId.')')->select();
            // foreach ($users as $key => $value) {
            //      array_push($relationArr1,$value['user_id']);
            // }
            // $userId = implode(',',array_unique($relationArr1));
            $map['uid'] = array('in',$yunying);
            $sea['yunying'] = $yunying;
        }


        if($starttime && $endtime) {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $map['dateline'] = array('between',''.$start_time.','.$end_time.'');
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        } else {
            $start_time = strtotime(date('Y-m-d')." 06:00:00");
            $end_time = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
            $map['dateline'] = array('between',''.$start_time.','.$end_time.'');
            $sea['starttime'] = date('Y-m-d H:i:s',$start_time);
            $sea['endtime']   = date('Y-m-d H:i:s',$end_time);
        }

       $map['user_type'] = array('eq',2);

       $count = $MoneyFlow->where($map)->count();   //总数量
       $pagecount = 15;   //每页显示的数量
       $page = new \Think\Page($count, $pagecount);
       $page->parameter = $sea; //此处的row是数组，为了传递查询条件
       $page->setConfig('first', '首页');
       $page->setConfig('prev', '&#8249;');
       $page->setConfig('next', '&#8250;');
       $page->setConfig('last', '尾页');
       $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
       $show = $page->show();
       $Flow = $MoneyFlow->where($map)->order('dateline  desc')->limit($page->firstRow, $page->listRows)->select();
       //echo M()->getLastSql();
       $Flow_money = $MoneyFlow->where($map)->order('dateline  desc')->select();
       $flowArr = array();
       $flowArr2 = array();
       foreach ($Flow as $key => $value) {
          array_push($flowArr,$value['uid']);
          array_push($flowArr2,$value['op_id']);
       }
       $flowId  = implode(',',array_unique($flowArr));
       $flowId1 = implode(',',array_unique($flowArr2));
       
       $info = $userinfo->where('uid in('.$flowId.')')->select();
       $infoArr = array();
       foreach ($info as $key => $value) {
          $infoArr[$value['uid']] = $value;
       }

       $info1 = $userinfo->where('uid in('.$flowId1.')')->select();
       $infoArr1 = array();
       foreach ($info1 as $key => $value) {
          $infoArr1[$value['uid']] = $value;
       }

       $bank = $bankinfo->where('uid in('.$flowId.')')->select();
       $infoArr2 = array();
       foreach ($bank as $key => $value) {
            $infoArr2[$value['uid']] = $value;
       }

       $bank1 = $bankinfo->where('uid in('.$flowId1.')')->select();
       $infoArr3 = array();
       foreach ($bank1 as $key => $value) {
            $infoArr3[$value['uid']] = $value;
       }

       foreach ($Flow as $key => $value) {

           $Flow[$key]['busername']     = $infoArr2[$value['uid']]['busername'];
           $Flow[$key]['username']      = $infoArr[$value['uid']]['username'];
           $Flow[$key]['utel']          = $infoArr[$value['uid']]['utel'];

           $Flow[$key]['account']       = substr($value['note'],strrpos($value['note'],'[')+1);
           $Flow[$key]['account']       = preg_replace("/]元/", "",$Flow[$key]['account']);

           $Flow[$key]['operator']      = $infoArr1[$value['op_id']]['username'];
           $Flow[$key]['operator_name'] = $infoArr3[$value['op_id']]['busername'];
       }

       //无分页
       foreach ($Flow_money as $key => $value) {
           $Flow_money[$key]['account']  = substr($value['note'],strrpos($value['note'],'[')+1);
           $Flow_money[$key]['account']  = preg_replace("/]元/", "",$Flow_money[$key]['account']);
           $money += $Flow_money[$key]['account'];
       }

       $this->assign('flow',$Flow);
       $this->assign('page',$show);
       $this->assign('sea',$sea);
       $this->assign('yunying',$userinfo->where('otype=5')->select());
       $this->assign('money',$money);
       $this->assign('info',M('userinfo')->where(array('otype' =>3))->select());
       $this->display();
    }

      public function daochu_moneyFlow() 
   {

       $MoneyFlow            = M('MoneyFlow');
       $userinfo             = M('userinfo');
       $UserinfoRelationship = M('UserinfoRelationship');
       $bankinfo             = M('bankinfo');

       $utel      = trim(I('get.utel'));
       $type      = trim(I('get.type'));
       $yunying   = trim(I('get.yunying'));
       $jingjiren = trim(I('get.jingjiren'));
       $user      = trim(I('get.user'));
       $starttime = urldecode(trim(I('get.starttime')));
       $endtime   = urldecode(trim(I('get.endtime')));
       $operator  = trim(I('get.operator'));  //操作人


       if($utel) {
          $searchArr = array();
          $where['utel'] = array('like','%'.$utel.'%');
          $info = $userinfo->where($where)->select();
          foreach ($info as $key => $value) {
              array_push($searchArr,$value['uid']);
          }
          $searchId = implode(',',array_unique($searchArr));
          $map['uid'] = array('in',$searchId);
       } 

       if($type) {
            $map['type'] = $type;
       }

       if($operator) {
            $map['op_id'] = $operator;
       }

        if($yunying) {

            $relation = $UserinfoRelationship->where(array('parent_user_id' => $yunying))->select();
            $relationArr = array();
            $relationArr1 = array();
            foreach ($relation as $key => $value) {
                 array_push($relationArr,$value['user_id']);
            }
            $relationId = implode(',',array_unique($relationArr));
            $users = $UserinfoRelationship->where('parent_user_id in('.$relationId.')')->select();
            foreach ($users as $key => $value) {
                 array_push($relationArr1,$value['user_id']);
            }
            $userId = implode(',',array_unique($relationArr1));
            $map['uid'] = array('in',$userId);
        }

        if($jingjiren) {
            $relationArr2 = array();
            $jingjiren_user = $UserinfoRelationship->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
                 array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['uid'] = array('in',$userId1);
        }
        
        if($user) {
            $map['uid'] = $user;
        }

        if($starttime && $endtime) {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $map['dateline'] = array('between',''.$start_time.','.$end_time.'');
        } else {
            $start_time = strtotime(date('Y-m-d')." 06:00:00");
            $end_time = strtotime(date('Y-m-d')." 05:00:00")+ 3600*24;
            $map['dateline'] = array('between',''.$start_time.','.$end_time.'');
        }

       $map['user_type'] = array('eq',2);

       $Flow = $MoneyFlow->where($map)->order('dateline  desc')->select();
       $flowArr = array();
       $flowArr2 = array();
       foreach ($Flow as $key => $value) {
          array_push($flowArr,$value['uid']);
          array_push($flowArr2,$value['op_id']);
       }
       $flowId  = implode(',',array_unique($flowArr));
       $flowId1 = implode(',',array_unique($flowArr2));
       
       $info = $userinfo->where('uid in('.$flowId.')')->select();
       $infoArr = array();
       foreach ($info as $key => $value) {
          $infoArr[$value['uid']] = $value;
       }

       $info1 = $userinfo->where('uid in('.$flowId1.')')->select();
       $infoArr1 = array();
       foreach ($info1 as $key => $value) {
          $infoArr1[$value['uid']] = $value;
       }

       $bank = $bankinfo->where('uid in('.$flowId.')')->select();
       $infoArr2 = array();
       foreach ($bank as $key => $value) {
            $infoArr2[$value['uid']] = $value;
       }

       $bank1 = $bankinfo->where('uid in('.$flowId1.')')->select();
       $infoArr3 = array();
       foreach ($bank1 as $key => $value) {
            $infoArr3[$value['uid']] = $value;
       }

       foreach ($Flow as $key => $value) {
           
           $Flow[$key]['username']      = $infoArr[$value['uid']]['username'];
           $Flow[$key]['busername']     = $infoArr2[$value['uid']]['busername'];
           $Flow[$key]['utel']          = $infoArr[$value['uid']]['utel'];

           $Flow[$key]['account']       = substr($value['note'],strrpos($value['note'],'[')+1);
           $Flow[$key]['account']       = preg_replace("/]元/", "",$Flow[$key]['account']);

           $Flow[$key]['operator']      = $infoArr1[$value['op_id']]['username'];
           $Flow[$key]['operator_name'] = $infoArr3[$value['op_id']]['busername'];

       }

        $data[0] = array('编号','用户名','手机号码','资金变动描述','变动金额','操作人','操作时间');
        foreach($Flow as $k => $v){
            $username = !empty($v['busername']) ? $v['busername'] : $v['username'];
            $operator_name = !empty($v['operator_name']) ? $v['operator_name'] : $v['operator'];
            $data[$k+1][] = $v['id'];
            $data[$k+1][] = $username;
            $data[$k+1][] = $v['utel'];
            $data[$k+1][] = $v['note'];
            $data[$k+1][] = number_format($v['account'],2);
            $data[$k+1][] = $operator_name;
            $data[$k+1][] = date('Y-m-d H:i:s',$v['dateline']);
        }
        $name='资金流水记录';      //生成的Excel文件文件名
        $res=$this->push($data,$name);
   } 


    /**
     * 导出表格
     * @author wang <admin>
     */

    public function daochu(){

        $phone    = trim(I('get.phone'));
        $username = trim(I('get.username')); 

        if($phone){

            $map['a.utel'] = $phone;
            $this->assign('phone',$phone);
        }

        if($username){

            $map['a.username'] = array('like',''.I('get.username').'%');
            $this->assign('username',$username);
        }

        $map['a.otype'] = 5;

        $user = M('userinfo a')->field('a.*,b.balance')->join('left join wp_accountinfo as b on a.uid = b.uid')->where($map)->select();

        /*查询上级 运营中心分部Start*/

        $userArr = array();
        foreach ($user as $key => $value) {
            array_push($userArr, $value['uid']);
        }

        $user_id = implode(',', $userArr);
        $branch  = M('userinfo_relationship')->field('user_id,branch_id')->where('user_id in('.$user_id.')')->select();

        $branchData1    = array();
        $branchArr      = array();
        foreach ($branch as $key => $value) {
            array_push($branchArr, $value['branch_id']);
            $branchData1[$value['user_id']] = $value;
        }

        $branch_id   = implode(',', $branchArr);
        $branchData  = M('userinfo')->field('uid,username')->where('uid in ('.$branch_id.')')->select();
        
        $branchData2 = array();
        foreach ($branchData as $key => $value) {
            $branchData2[$value['uid']] = $value;
        }

        foreach ($user as $key => $value) {
            $user[$key]['branch_name'] = empty($branchData2[$branchData1[$value['uid']]['branch_id']]['username']) ? '暂无' : $branchData2[$branchData1[$value['uid']]['branch_id']]['username'];
        }

        /*查询上级 运营中心分部End*/

        $data[0] = array('编号','用户','手机号','注册时间','余额','域名','上级');
        foreach ($user as $key => $value) {

            $data[$key+1][] = $value['uid'];
            $data[$key+1][] = $value['username'];
            $data[$key+1][] = $value['utel'];
            $data[$key+1][] = date('Y-m-d H:i:s',$value['utime']);
            $data[$key+1][] = $value['balance'];
            $data[$key+1][] = $value['s_domain'];
            $data[$key+1][] = $value['branch_name'];
        }
        $name='运营中心';
        $this->push($data,$name);
    }


    private function push($data,$name){

        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data,$name);
    }


    /**
     * @functionname: show_product
     * @author: wang
     * @date: 2016-12-12 11:42:05
     * @description: 展示运营中心商品
     * @note:
     */
    public function show_product()
    {
        $uid=  trim(I('get.uid'));

        $returnRs   = array();

        $special = M('OptionUserSpecial a');
        $field = 'a.*,b.capital_type,b.capital_name,b.capital_key,b.currency';
        $map['a.user_id'] = $uid;
        $special_data = $special->
                        field($field)->
                        join('inner join wp_option as b on a.option_id = b.id')->
                        where($map)->
                        select();
        foreach ($special_data as $key => $value) {

            $currencys = currency($value['currency']);
            $special_data[$key]['CounterFeeRmb'] = '(￥'.round($value['platform_commission'] * $currencys['rate'],2).')';

            $special_data[$key]['commission_rmb'] = '(￥'.round($value['commission'] * $currencys['rate'],2).')';
                  
            if(empty($value['option_intro']))
            {
                $special_data[$key]['option_intro'] = '无';
            }
            if($value['status'] == 1)
            {
                $special_data[$key]['status_msg'] = '可售';
            } else {
                $special_data[$key]['status_msg'] = '禁售';
            }
            if($value['type'] == 1)
            {
                $special_data[$key]['type_msg'] = '无';
            } else if($value['type'] == 2){
                $special_data[$key]['type_msg'] = '新商品';
            } else {
                    $special_data[$key]['type_msg'] = '热门商品';
            }

            }
        
        $this->assign('special_data',$special_data);
        $this->display();
    }

    /**
     * @functionname: commission_save
     * @author: wang
     * @date: 2016-12-12 11:42:05
     * @description: 修改运营中心商品
     * @note:
     */
    public function commission_save_back()
    {
        $id  = trim(I('get.id'));
        $val = trim(I('get.val'));
        $uid = trim(I('get.uid'));
        
        $userSpecial = M('OptionUserSpecial');

        $data = array();

        if(empty($val))
        {
           $data['msg'] = '输入的内容不能为空';
           $this->ajaxReturn($data,'JSON');
        }

        if(isset($id) || isset($uid))
        {
           $is_save = $userSpecial->where(array('user_id' => $uid,'id' => $id))->setField('commission',$val);
           if($is_save)
           {
               $data['msg'] = '修改成功';
               $this->ajaxReturn($data,'JSON');
           } else {
                $data['msg'] = '修改失败';
                $this->ajaxReturn($data,'JSON');
           }

        } else {
           $data['msg'] = '用户编号或者商品编号不存在';
           $this->ajaxReturn($data,'JSON');
        }
    }


    public function commission_save()
    {
        $uid                 = I('post.uid');
        $id                  = I('post.id');
        $commission          = I('post.commission');
        $platform_commission = I('post.platform_commission');

        
        $userSpecial = M('OptionUserSpecial');

        $data = array();

        if(empty($uid) || empty($id))
        {
           $data['msg'] = '产品编号或用户编号不存在';
           $this->ajaxReturn($data,'JSON');
        }

        if(empty($commission) || empty($platform_commission))
        {
           $data['msg'] = '输入的内容不能为空';
           $this->ajaxReturn($data,'JSON');
        }

        $Combination = array();

        foreach ($id as $key => $value) {
            $Combination[$key]['id']                  = $id[$key];
            $Combination[$key]['commission']          = $commission[$key];
            $Combination[$key]['platform_commission'] = $platform_commission[$key];
        }

        foreach ($Combination as $key => $value) {
            
            $save['commission']          = $value['commission'];
            $save['platform_commission'] = $value['platform_commission'];

            $result[] = $userSpecial->where(array('id' => $value['id'],'uid' => $uid))->save($save);
        }

        $str = in_array(1, $result);
        if($str)
        {
           $data['msg'] = '修改成功';
           $this->ajaxReturn($data,'JSON');
        } else {
           $data['msg'] = '修改失败';
           $this->ajaxReturn($data,'JSON');
        }
    }


    /**
     * @functionname: proxy_open_start
     * @date: 2016-12-12 11:42:05
     * @description: 开启模拟交易系统
     * @note:
     */
    public function proxy_open_start()
    {
        $trade = trim(I('post.trade'));
        $uid   = trim(I('post.uid'));
        $userObj = M('userinfo');

        $data = array();

        $result = $userObj->where(array('uid' => $uid))->setField('s_domain_trade',$trade);
        if($result)
        {
            $data['status'] = 1;
            $data['msg']    = '修改成功';
            $this->ajaxReturn($data,'JSON');
        } else{
            $data['status'] = 0;
            $data['msg']    = '修改失败';
            $this->ajaxReturn($data,'JSON');
        }
    }


    /**
     * @functionname: save_superior
     * @date: 2017-12-12 11:42:05
     * @description: 修改运营中心上级
     * @note:
     */

    public function save_superior()
    {
        $userinfoObj        = M('userinfo');
        $relationshipObj    = M('userinfo_relationship');

        if(IS_AJAX)
        {
            $data   = array();
            $branch = I('post.branch');
            $uid    = I('post.uid');

            if(!isset($branch))
            {
                $data['status'] = 0;
                $data['msg']    = '请选择要修改的数据';
                $this->ajaxReturn($data,'JSON');
            }

            if(!isset($uid))
            {
                $data['status'] = 0;
                $data['msg']    = '修改人不存在';
                $this->ajaxReturn($data,'JSON');
            }

            $ship = $relationshipObj->where(array('user_id' => $uid))->setField('parent_user_id',$branch);

            if($ship)
            {
                $data['status'] = 1;
                $data['msg']    = '修改成功';
                $this->ajaxReturn($data,'JSON');

            } else {

                $data['status'] = 0;
                $data['msg']    = '修改失败';
                $this->ajaxReturn($data,'JSON');
            }



        } else {

            $uid  = trim(I('get.uid'));

            if($uid)
            {
                $branch_id = $relationshipObj->where(array('user_id' => $uid))->getField('parent_user_id');
                $this->assign('branch_id',$branch_id);
                $this->assign('uid',$uid);
            }

            $branch = $userinfoObj->field('uid,username')->where(array('otype' => 7))->select();
            $this->assign('branch',$branch);
            $this->display();
        }
    }
}