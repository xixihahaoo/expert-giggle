<?php
// +----------------------------------------------------------------------
// | 经纪人控制器
// +----------------------------------------------------------------------
// | Author wang <admin>
// +----------------------------------------------------------------------
namespace Admin\Controller;

class AgentController extends CommonController {

    /**
     * 经纪人列表
     * @author wang <admin>
     */
    public function index()
    {
        $row = array();
        if(I('get.phone')){

            $map['a.utel'] = array('like','%'.I('get.phone').'%');
            $this->assign('phone',I('get.phone'));
        }

        if(I('get.username')){

            $map['a.username'] = array('like','%'.I('get.username').'%');
            $this->assign('username',I('get.username'));
        }

        if(I('get.uid')){

            $map['b.parent_user_id'] = I('get.uid');
            $row['uid'] = I('get.uid');
            $this->assign('uid',I('get.uid'));
        }

        $map['a.otype'] = 6;
        $arr = array();
        //分页
        $count = M("userinfo a")->join('left join wp_userinfo_relationship as b on a.uid = b.user_id')->where($map)->count();

        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $row;
        $page->setConfig('first','首页');
        $page->setConfig('prev','&#8249;');
        $page->setConfig('next','&#8250;');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();
        $agent = M("userinfo a")->join('left join wp_userinfo_relationship as b on a.uid = b.user_id')->where($map)->limit($page->firstRow,$page->listRows)->select();


        foreach ($agent as $k => $v) {

            array_push($arr, $v['parent_user_id']);
        }
        $userid = implode(',' ,array_unique($arr));

        $where['uid'] = array('in',$userid);
        $info = M("userinfo")->where($where)->select();
        foreach ($info as $key => $value) {

            $dd[$value['uid']]['name'] = $value['username'];
        }

        $this->assign('user',$dd);
        $this->assign('agent',$agent);
        $this->assign('count',$count);
        $this->assign('page',$show);
        $this->assign("extends",M("userinfo")->where(array('otype' => 5))->select());
        $this->display();
    }

    public function edit(){

        $uid      = I('post.uid');
        $s_domain = I('post.s_domain');
        if(!$uid || !$s_domain){

            $data['status'] = 0;
            $data['msg']    = '操作失败';
            $this->ajaxReturn($data,'JSON');
        }

        $result = M("userinfo")->where(array('uid' => $uid))->setField('s_domain',$s_domain);
        if($result){

            $data['status'] = 0;
            $data['msg']    = '修改成功';
            $this->ajaxReturn($data,'JSON');

        } else {

            $data['status'] = 0;
            $data['msg']    = '修改失败';
            $this->ajaxReturn($data,'JSON');
        }

    }

    /**
     * 查看指定经纪人资金统计信息
     * @uid 指定会员id
     * return array json
     */
    public function show(){
        if(IS_AJAX){
            $uid = I('post.uid',0);
            if($uid < 1){
                $this->ajaxReturn(array('msg'=>'不存在该经纪人','status'=>0));
            }

            $mObj       = M();
            $returnRs   = array();

            $userinfoRelationshipObj    = M('userinfo_relationship');

            //经纪人用户信息
            $userinfoObj    = M('userinfo');
            $proxyInfoArr   = 'uid='.$uid;
            $proxyInfoRs    = $userinfoObj->where($proxyInfoArr)->find();
            $returnRs['username'] = $proxyInfoRs['username'];

            //用户
            $whereArr   = array(
                'parent_user_id'    => $uid
            );
            $userinfoRelationshipRs = $userinfoRelationshipObj->where($whereArr)->select();

            $userIdArr  = array();
            foreach($userinfoRelationshipRs as $k => $v)
            {
                array_push($userIdArr, $v['user_id']);
            }
            $userIdStr  = implode(',', array_unique($userIdArr));

            $userinfoWhereArr   = 'uid in ('.$userIdStr.')';

            $userinfoRs     = $userinfoObj->where($userinfoWhereArr)->select();
            $userinfoRs1    = array();
            foreach($userinfoRs as $k => $v)
            {
                $userinfoRs1[$v['uid']]    = $v;
            }
            $returnRs['user_total']= count($userinfoRs);

            //需要从这里添加条件
            $userinfoWhereArr   = 'uid in ('.$userIdStr.')';
            $orderRs            = $mObj->table('view_wp_journal')->where($userinfoWhereArr)->select();


            $totalFee   = array();
            $totalMoney = array();
            $totalCount = array();
            foreach($orderRs as $k =>$v)
            {
                $orderRs1[$v['oid']]    = $v;
                array_push($totalFee, $v['jfee']);
                array_push($totalMoney, $v['jploss'] );
                array_push($totalCount, $v['juprice']+$v['jfee']);
            }

            $returnRs['total_fee']      = number_format(array_sum($totalFee),2);
            $returnRs['total_money']    = number_format(array_sum($totalMoney),2) ;
            $returnRs['total_count']    = number_format(array_sum($totalCount),2);
            $returnRs['order_total']    = count($orderRs);


            //保证金
            $accountinfoObj = M('accountinfo');
            $accountinfoRs  = $accountinfoObj->where('uid=' . $uid)->find();

            $returnRs['account']        = number_format($accountinfoRs['balance'],2);

            //佣金
            $feeObj = M('fee_receive');
            $feeWhereArr    = 'type = 1  and user_id in ('.$userIdStr.')';
            $feeRs          = $feeObj->where($feeWhereArr)->select();
            $totalCommissionUser= array();
            foreach($feeRs as $k => $v)
            {
                array_push($totalCommissionUser, $v['profit_rmb']);
            }
            $returnRs['total_commission']  = number_format(array_sum($totalCommissionUser),2);




            $data=array('msg'=>'查询成功','status'=>1,'data'=>$returnRs);

            $this->ajaxReturn($data,'JSON');

        }
        $this->error('访问页面不存在','/admin/index/index');
    }

    /**
     * 添加经纪人
     * @author wang <admin>
     */
    public function add(){
        if(IS_AJAX){

            $data     = array();
            $username = I('post.username');
            $pwd      = I('post.pwd');
            $notpwd   = I('post.notpwd');
            $tel      = I('post.tel');
            $gongsi   = I('post.gongsi');
            $zizhi    = I('post.zizhi');
            $dizhi    = I('post.dizhi');
            $s_domain = I('post.s_domain');
            $yunying  = I('post.yunying');

            if(trim($username) == ''){

                $data['status'] = 0;
                $data['msg']    = '用户名不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(trim($pwd) == ''){

                $data['status'] = 0;
                $data['msg']    = '密码不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(trim($notpwd) != $pwd){

                $data['status'] = 0;
                $data['msg']    = '密码必须一致';
                $this->ajaxReturn($data,'JSON');
            }

            if(trim($tel) == ''){

                $data['status'] = 0;
                $data['msg']    = '电话号码不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(trim($gongsi) == ''){

                $data['status'] = 0;
                $data['msg']    = '公司名称不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(trim($zizhi) == ''){

                $data['status'] = 0;
                $data['msg']    = '公司资质不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(trim($dizhi) == ''){

                $data['status'] = 0;
                $data['msg']    = '地址不能为空';
                $this->ajaxReturn($data,'JSON');
            }
            if(trim($s_domain) == ''){

                $data['status'] = 0;
                $data['msg']    = '域名不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(M('userinfo')->where(array('utel' => $tel))->find()){

                $data['status'] = 0;
                $data['msg']    = '该手机号已经存在';
                $this->ajaxReturn($data,'JSON');
            }
            if(M('userinfo')->where(array('username' => $username))->find()){

                $data['status'] = 0;
                $data['msg']    = '该用户名已经存在';
                $this->ajaxReturn($data,'JSON');
            }


            $map['username'] = $username;  //用户登录帐号
            $map['upwd']     = md5($pwd);
            $map['utel']     = $tel;
            $map['utime']    = time();
            $map['otype']    = 5;
            $map['ustatus']  = 0;
            $map['address']  = $dizhi;
            $map['comname']  = $gongsi;
            $map['comqua']   = $zizhi;
            $map['s_domain'] = $s_domain;

            $result = M('userinfo')->add($map);
            if($result){

                $where['user_id']        = $result;
                $where['parent_user_id'] = $yunying;  //上级id
                $res = M('UserinfoRelationship')->add($where);
                if($res){

                    $data['status'] = 1;
                    $data['msg']    = '注册成功';
                    $this->ajaxReturn($data,'JSON');

                }  else {

                    $data['status'] = 0;
                    $data['msg']    = '注册失败';
                    $this->ajaxReturn($data,'JSON');
                }

            } else {
                $data['status'] = 0;
                $data['msg']    = '注册失败';
                $this->ajaxReturn($data,'JSON');
            }



        }
        $this->assign("extends",M("userinfo")->where(array('otype' => 5))->select());
        $this->display();
    }

    /**
     * 经纪人删除
     * @author wang <admin>
     */
    public function agent_del(){

        $data   = array();

        $uid    = I('post.uid'); //userid

        if(empty($uid))
        {
            $data['status'] = 0;
            $data['msg']    = '用户编号不能为空';
            $this->ajaxReturn($data,'JSON');
        }

        $prefix = C('DB_PREFIX');

        $sql       = 'SELECT `uid` from '.$prefix.'userinfo where uid in(select user_id from '.$prefix.'userinfo_relationship where parent_user_id = '.$uid.') and ustatus=0';
        $res = M()->query($sql);

        if($res)
        {
            $data['status'] = 0;
            $data['msg']    = '该机构下方还有用户，禁止删除';
            $this->ajaxReturn($data,'JSON');
        }
        
        $result = M('userinfo')->where(array('uid' => $uid,'otype' => 6))->delete();  //普通会员
        $del    = M("UserinfoRelationship")->where(array('user_id' => $uid))->delete();

        if($result && $del){

            $data['status'] = 1;
            $data['msg']    = '删除成功';
            $this->ajaxReturn($data,'JSON');
        } else{

            $data['status'] = 0;
            $data['msg']    = '删除失败';
            $this->ajaxReturn($data,'JSON');
        }
    }

    public function daochu(){

        if(I('get.phone')){

            $map['a.utel'] = array('like','%'.I('get.phone').'%');
            $this->assign('phone',I('get.phone'));
        }

        if(I('get.username')){

            $map['a.username'] = array('like','%'.I('get.username').'%');
            $this->assign('username',I('get.username'));
        }

        if(I('get.uid')){

            $map['c.parent_user_id'] = I('get.uid');
            $this->assign('uid',I('get.uid'));
        }

        $map['a.otype'] = 6;

        $agent = M("userinfo a")->field('a.*,b.balance,c.*')->join('left join wp_accountinfo as b on a.uid = b.uid')->join('left join wp_userinfo_relationship as c on a.uid = c.user_id')->where($map)->order('s_domain desc')->select();

        $data[0] = array('编号','用户','手机号','注册时间','所属运营中心');
        foreach($agent as $key=>$val)
        {
            $data[$key+1][] = $val['uid'];
            $data[$key+1][] = $val['username'];
            $data[$key+1][] = $val['utel'];
            $data[$key+1][] = date("Y-m-d H:i:s",$val['utime']);
            $data[$key+1][] = change(exchange($val['uid'],2));
        }
        $name='Excelfile';  //生成的Excel文件文件名
        $this->push($data,$name);
    }

    private function push($data,$name){

        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data,$name);
    }

}