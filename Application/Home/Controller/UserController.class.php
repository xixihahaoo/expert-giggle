<?php
namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;


class UserController extends CommonController
{

    public function _initialize(){
        parent::_initialize();

        $this->user_id = session('user_id');
        $this->regcode = $_SESSION['regcode'];  //短息验证码
    }

    /**
     * 订单编号
     * @author wang <admin>
     */

    private function number(){

        return time().mt_rand();
    }


    /**
     * @functionname: number_syx
     * @author: FrankHong
     * @date: 2017-01-07 18:08:51
     * @description: 生成订单号最后的标识
     * @note:
     * @return string
     */
    private function number_syx()
    {
        return substr(time(), 7, 4).mt_rand(1, 999);
    }

    /**
     * @functionname: number_huanxun
     * @author: FrankHong
     * @date: 2017-02-06 17:36:21
     * @description: 生成环迅支付的订单号
     * @note:
     * @return string
     */
    private function number_huanxun()
    {
        return time().mt_rand(100000, 999999);
    }

    /**
     * 订单编号
     * @author zhu
     */

    private function number_zn(){
        return $this->user_id.time().mt_rand(100000, 999999);
    }

    /**
     * 个人中心
     * @author wang <admin>
     */
    public function index()
    {

        $userinfo = M('userinfo a')->join(' left join wp_accountinfo as b on a.uid = b.uid')->where(array('a.uid' => $this->user_id))->find();
        $this->assign('userinfo',$userinfo);
        $this->assign('face',M('UserinfoOpen')->field('open_face,open_name')->where(array('user_id' => $this->user_id))->find());

        /*是否显示模拟交易*/
        $trade = M('userinfo')->where(array('uid' => $this->agent_id))->getField('s_domain_trade');
        $this->assign('trade',$trade);

        $this->display('Ucenter/index');
    }

    /**
     * 充值
     * @author wang <admin>
     */
    public function account(){
        $class = M('newsclass')->where(array('fid' => 7,'isshow' => 1))->find();
        $news  = M('newsinfo')->where(array('ncategory' => $class['fid']))->find();
        $nwes = html_entity_decode($news['ncontent']);
        $this->assign('news',$nwes);
        $this->display('Ucenter/account');
    }

    /**
     * 充值
     * @author wang <admin>
     */
    public function account_check(){

        $data = array();
        $paytype = I('post.paytype');  //支付方式
        $money   = I('post.money');    //充值金额
        if(trim($money) == ''){
            $data['status'] = 0;
            $data['msg']    = '支付金额不能为空';
            outjson($data);
        }
       if(trim($money) < 100){
          $data['status'] = 0;
          $data['msg']    = '支付金额不能小于100';
          $this->ajaxReturn($data,'JSON');
       }
        if(trim($paytype) == ''){
            $data['status'] = 0;
            $data['msg']    = '请选择支付方式';
            outjson($data);
        }


        //生成订单信息
        $account = M('accountinfo')->where(array('uid' => $this->user_id))->find();


        switch($paytype)
        {
            case 'wxpay':
                $num = $this->number();   //订单号
                $redirectUrl    = U('Pay/wxpay');
                $data['pay_type']   = 1;
                break;
            case 'wxpay_syx':
                $randN  = $this->number_syx();   //订单号
                $v_ymd  = date('Ymd'); //订单产生日期，要求订单日期格式yyyymmdd.
                $v_mid  = "10704";    //商户编号，和首信签约后获得,测试的商户编号444

                $num    = $v_ymd .'-' . $v_mid . '-' .$randN;
                $redirectUrl        = U('Paysxy/pay_sxy');
                $data['pay_type']   = 2;
                break;

            case 'wxpay_syx_yl':
                $randN  = $this->number_syx();   //订单号
                $v_ymd  = date('Ymd'); //订单产生日期，要求订单日期格式yyyymmdd.
                $v_mid  = "10704";    //商户编号，和首信签约后获得,测试的商户编号444

                $num    = $v_ymd .'-' . $v_mid . '-' .$randN;
                $redirectUrl        = U('Paysxy/pay_sxy_yinlian');
                $data['pay_type']   = 3;
                break;
            case 'pay_ips_wx':
                $randN  = $this->number_huanxun();   //订单号
                $num    = 'ips192545'.$randN;

                $redirectUrl        = U('Payips/pay_ips');
                $data['pay_type']   = 4;
                break;
            case 'pay_ips_zfb':
                $randN  = $this->number_huanxun();   //订单号
                $num    = 'ips192545'.$randN;

                $redirectUrl        = U('Payips/pay_ips');
                $data['pay_type']   = 5;
                break;

            case 'weiXinScan_qt' : // 钱通微信扫码支付
                $num = $this->number();  // 订单号
                $redirectUrl = U('PayQt/pay');
                $data['pay_type'] = 6;
                break;
            case 'ZFBScan_qt' : // 钱通支付宝扫码支付
                $num = $this->number_zn();  // 订单号
                $redirectUrl = U('PayQt/pay');
                $data['pay_type'] = 7;
                break;
            case 'weiXinScan_zn' : // 中南微信扫码支付
                $num = $this->number_zn();  // 订单号
                $redirectUrl = U('PayZn/pay');
                $data['pay_type'] = 9;
                break;
            case 'ZFBScan_zn' : // 中南支付宝扫码支付
                $num = $this->number_zn();  // 订单号
                $redirectUrl = U('PayZn/pay');
                $data['pay_type'] = 10;
                break;
            case 'CertPay_zn' : // 中南快捷支付
                if(intval($money)  < 500){
                    $data['status'] = 0;
                    $data['msg']    = '快捷支付必须大于500元';
                    outjson($data);
                }
                $num = $this->number();  // 订单号
                $redirectUrl = U('PayZn/pay_kuaijie_before');
                $data['pay_type'] = 11;
                break;
            case 'QQSCANPay_zn' : // 中南QQ扫码支付
                $num = $this->number_zn();  // 订单号
                $redirectUrl = U('PayZn/pay');
                $data['pay_type'] = 12;
                break;
            case 'zfbscan_ewm' : // 二维码支付宝支付
				if(intval($money)  > 2999){
                    $data['status'] = 0;
                    $data['msg']    = '该支付必须小于3000元';
                    outjson($data);
                }
                $num = $this->number_zn();  // 订单号
                $redirectUrl = U('PayErweima/pay');
                $data['pay_type'] = 14;
                break;
            case 'wxscan_ewm' : // 二维码支付宝支付
				if(intval($money)  > 2999){
                    $data['status'] = 0;
                    $data['msg']    = '该支付必须小于3000元';
                    outjson($data);
                }
                $num = $this->number_zn();  // 订单号
                $redirectUrl = U('PayErweima/pay');
                $data['pay_type'] = 15;
                break;
            case 'qqscan_ewm' : // 二维码支付宝支付
				if(intval($money)  > 2999){
                    $data['status'] = 0;
                    $data['msg']    = '该支付必须小于3000元';
                    outjson($data);
                }
                $num = $this->number_zn();  // 订单号
                $redirectUrl = U('PayErweima/pay');
                $data['pay_type'] = 16;
                break;
            case 'fuwuhao_wx_ewm' : // 二维码支付宝支付
				if(intval($money)  > 2999){
                    $data['status'] = 0;
                    $data['msg']    = '该支付必须小于3000元';
                    outjson($data);
                }
                $num = $this->number_zn();  // 订单号
                $redirectUrl = U('PayErweima/pay');
                $data['pay_type'] = 17;
                break;
            case 'fuwuhao_zfb_ewm' : // 二维码支付宝支付
				if(intval($money)  > 2999){
                    $data['status'] = 0;
                    $data['msg']    = '该支付必须小于3000元';
                    outjson($data);
                }
                $num = $this->number_zn();  // 订单号
                $redirectUrl = U('PayErweima/pay');
                $data['pay_type'] = 18;
                break;
            case 'weiXinScan_cb' : // 畅佰微信扫码支付
                $num = $this->number();  // 订单号
                $redirectUrl = U('PayCb/pay');
                $data['pay_type'] = 20;
                break;
            case 'ZFBScan_cb' : // 畅佰微信扫码支付
                $num = $this->number();  // 订单号
                $redirectUrl = U('PayCb/pay');
                $data['pay_type'] = 21;
                break;
            case 'h5_cb' : // 畅佰微信扫码支付
                $num = $this->number();  // 订单号
                $redirectUrl = U('PayCb/jumpRequest');
                $data['pay_type'] = 22;
                break;
            case 'yitong_yinlian'://易通支付
                $num = $this->number();  // 订单号
                $redirectUrl = U('Pay/yitong_pay');
                $data['pay_type'] = 23;
                break;
            case 'yitong_weipay'://易通支付
                $num = $this->number();  // 订单号
                $redirectUrl = U('Pay/yitong_pay');
                $data['pay_type'] = 24;
                break;
            case 'hsgj_weipay'://恒生国际微信公众号支付
                $num = $this->number_zn();  // 订单号
                $redirectUrl = U('PayHsgj/pay');
                $data['pay_type'] = 25;
                break;
            case 'JlPay_zn'://九龙快捷支付

                //查询是否绑定快捷支付
                $banks = M('JlBanks')->where(array('user_id' => $this->user_id,'card_sts' => 0))->getField('contract_id');
                if(!$banks)
                {
                    $return['status']       = 1;
                    $return['redirectUrl']  = U('PayJl/bindCard');
                    $return['msg']          = '请先绑定快捷支付';
                    outjson($return);
                }

                $num = $this->number_zn();  // 订单号
                $redirectUrl = U('PayJl/quickPayInit');
                $data['pay_type'] = 26;
                break;

            case 'JlPay_B2C'://九龙网关支付

                $num = $this->number_zn();  // 订单号
                $redirectUrl = U('PayJl/bankPayment');
                $data['pay_type'] = 27;
                break;
            case 'manual_zfb'://人工支付宝充值
                $num = $this->number_zn();  // 订单号
                $redirectUrl = U('PayManual/zfbQrcode');
                $data['pay_type'] = 28;
                break;

            case 'manual_wx'://人工微信充值
                $num = $this->number_zn();  // 订单号
                $redirectUrl = U('PayManual/wxQrcode');
                $data['pay_type'] = 29;
                break;

            case 'manual_yl'://人工银联充值
                $num = $this->number_zn();  // 订单号
                $redirectUrl = U('PayManual/yl');
                $data['pay_type'] = 31;
                break;
            default:
            $data['status'] = 0;
            $data['msg']    = '系统没有此支付方式';
            outjson($data);

        }


        $data['bptype']     = '充值';
        $data['remarks']    = '普通会员充值';
        $data['bptime']     = time();               //操作时间
        $data['bpprice']    = $money;               //充值金额
        $data['uid']        = $this->user_id;       //用户id
        $data['isverified'] = 0;                    //0未通过
        $data['balanceno']  = $num;                 //订单编号
        $data['shibpprice'] = $account['balance'];  //用户余额
        $data['b_type']     = 1;                    //流水类型，1充值，2提现
        $data['status']     = 0;                    //0待处理  1完成

				// Mod Start By w 20170912 
        if (trim($paytype) == 'CertPay_zn' ){
            
            $return['status']   = 1;
            $return['paytype']  = trim($paytype);           //支付类型
            $return['amount']   = trim($money);            //支付金额
            $return['ordernum'] = trim($data['balanceno']);//订单号
            $return['redirectUrl']  = $redirectUrl;
            $return['uid']  = $this->user_id;
            $return['msg']      = '正在跳转支付页面';
            outjson($return);
        }else{
            M('balance_s')->add($data);
            $res = M('balance')->add($data);

            if($res){

                $return['status']   = 1;
                $return['paytype']  = trim($paytype);           //支付类型
                $return['amount']   = trim($money);            //支付金额
                $return['ordernum'] = trim($data['balanceno']);//订单号
                $return['redirectUrl']  = $redirectUrl;
                $return['uid']  = $this->user_id;
                $return['msg']      = '正在跳转支付页面';
                outjson($return);
            }
        }
				// Mod End By w 20170912 
    }


    /**
     * 提现申请
     * @author wang <admin>
     */
    public function withdraw(){

        $user = M('accountinfo a')->join(' left join wp_bankinfo as b on a.uid = b.uid')->where(array('a.uid' => $this->user_id))->find();

        $class = M('newsclass')->where(array('fid' => 8,'isshow' => 1))->find();
        $news  = M('newsinfo')->where(array('ncategory' => $class['fid']))->find();
        $nwes = html_entity_decode($news['ncontent']);
        $this->assign('news',$nwes);


        $this->assign('user',$user);
        $this->display('Ucenter/withdraw');

    }

    /**
     * 提现记录
     * @author wang <admin>
     */

    public function record(){

        $record = M('balance')->where(array('uid' => $this->user_id,'b_type' => 2))->select();
        $this->assign('record',$record);
        $this->display('Ucenter/record');
    }

    /**
     * 提现审核
     * @author wang <admin>
     */

    public function withdraw_check(){

        $data   = array();
        $amount = I('post.amount'); //提现金额
        $banks  = I('post.banks');  //提现银行
        $trade_pwd  = I('post.trade_pwd');  //交易密码

        $open   = false; 
        if($open){

            $data['status'] = 0;
            $data['msg']    = '因国庆节银行结算影响，暂停出金';
            $this->ajaxReturn($data,'JSON');
        }

        if(trim($amount) == ''){

            $data['status'] = 0;
            $data['msg']    = '提现金额不能为空';
            $this->ajaxReturn($data,'JSON');
        }

        if(trim($amount) <= 11){

            $data['status'] = 0;
            $data['msg']    = '提现金额小于最小出金阈值';
            $this->ajaxReturn($data,'JSON');
        }

        if(!is_numeric($amount)){

            $data['status'] = 0;
            $data['msg']    = '请输入金额';
            $this->ajaxReturn($data,'JSON');
        }

        if(trim($banks) == ''){

            $data['status'] = 0;
            $data['msg']    = '银行名称不能为空';
            $this->ajaxReturn($data,'JSON');
        }

        if(empty($trade_pwd)) {
            $data['status'] = 0;
            $data['msg']    = '提款密码不能为空';
            $this->ajaxReturn($data,'JSON');
        }

        $account = M('accountinfo')->where(array('uid' => $this->user_id))->find();
        $user    = M('userinfo')->where(array('uid' => $this->user_id))->find();
        if($account['balance'] < $amount){

            $data['status'] = 0;
            $data['msg']    = '余额不足';
            $this->ajaxReturn($data,'JSON');
        }

        if(empty($user['trade_pwd'])) {
            $data['status'] = 2;
            $data['msg']    = '您还没有设置提款密码';
            $this->ajaxReturn($data,'JSON');
        }

        if(md5($trade_pwd)   != $user['trade_pwd']) {
            $data['status'] = 0;
            $data['msg']    = '提款密码不正确';
            $this->ajaxReturn($data,'JSON');
        }

        $data['bptype']     = '普通会员申请提现';
        $data['bptime']     = time();               //操作时间
        $data['bpprice']    = $amount;              //提现金额
        $data['uid']        = $this->user_id;       //用户id
        $data['isverified'] = 0;                    //0未通过
        $data['balanceno']  = $this->number_zn();   //订单编号
        $data['shibpprice'] = $account['balance'];  //用户余额
        $data['b_type']     = 2;                    //流水类型，1充值，2提现
        $data['status']     = 0;                    //0待处理  1完成

        $res = M('balance')->add($data);
        if($res){

            M("accountinfo")->where(array('uid' => $this->user_id))->setDec('balance',$amount);
            M("accountinfo")->where(array('uid' => $this->user_id))->setInc('money_total',$amount);

            //添加出入金流动表
            $map['uid']      = $this->user_id;
            $map['type']     = 3;
            $map['oid']      = $res;
            $map['note']     = '用户申请提现扣除['.$amount.']元';
            $map['balance']  = M('accountinfo')->where(array('uid' => $this->user_id))->sum('balance');
            $map['op_id']    = $this->user_id;
            $map['dateline'] = time();
            M("MoneyFlow")->add($map);

            $data['status'] = 1;
            $data['msg']    = '申请提现成功';
            $this->ajaxReturn($data,'JSON');
        } else{
            $data['status'] = 0;
            $data['msg']    = '申请提现失败';
            $this->ajaxReturn($data,'JSON');
        }
    }

    /**
     * 绑定银行卡
     * @author wang <admin>
     */

    public function banks(){
        $bank = M('bankinfo')->where(array('uid' => $this->user_id))->find();
        $city = M('city')->where(array('level' => 1))->select();
        $this->assign('bank',$bank);
        $this->assign('city',$city);
        $this->display('Ucenter/banks');
    }

    /**
     * 省市联动
     * @author wang <admin>
     */
    public function city(){
         if(IS_AJAX) {
             $id = I('post.id');
             $city = M('city')->where(array('parent_id' => $id))->select();
             if(!$city) {
                    $this->ajaxReturn('不存在','JSON');
             } else {
                    $this->ajaxReturn($city,'JSON');
             }
        } else {
             $this->ajaxReturn('程序异常','JSON');
        }
    }

    /**
     * 银行解绑，只允许ajax方式访问
     * @uid  用户uid
     */
    public function unbind(){
        if(IS_AJAX){
            $uid = I('post.uid',0);
            if($uid <1){
                $data=array('msg'=>'不存在该会员','status'=>0);
                $this->ajaxReturn($data,'JSON');
            }
            $res = M('bankinfo')->where(array('uid'=>$uid))->delete();
            if($res){
                $this->ajaxReturn(array('msg'=>'解绑成功','status'=>1),'JSON');
            }
            $this->ajaxReturn(array('msg'=>'解绑失败','status'=>0),'JSON');
        }
        $this->error('您访问的页面不存在','index');
    }

    /**
     * 编辑个人银行账户
     */
    public function editbank(){
        $field = 'a.*,b.name';
        $bank = M('bankinfo a')->field($field)->join('left join wp_city as b on a.city = b.id')->where(array('a.uid' => $this->user_id))->find();
        $city = M('city')->where(array('level' => 1))->select();
        $this->assign('bank',$bank);
        $this->assign('city',$city);
        $this->display('Ucenter/editbanks');
    }

    /**
     * 实名认证
     * @author wang <admin>
     */

    // public function realname() {

    //     $this->display('Ucenter/realname');
    // }


    /**
     * 绑定银行卡或实名认证
     * @author wang <admin>
     */
    public function binding(){

        $data = array();

        if (IS_AJAX) {
            $user = M('bankinfo')->where(array('uid' => $this->user_id))->find();
            if (!$user['j_bankNo']) {
                $j_name       = trim(I('post.j_name'));  //姓名
                $Card         = trim(I('post.Card'));   // 身份证号码
                $j_bankPhone  = trim(I('post.j_bankPhone')); //银行预留手机号
                $bankName     = trim(I('post.bankName'));  //银行名称
                $province     = trim(I('post.province'));  //开户所在省
                $city         = trim(I('post.city'));  //开户所在市
                $branch       = trim(I('post.branch'));    //支行名称
                $j_bankNo     = trim(I('post.j_bankNo'));  //银行卡号码
                $j_bankNoNote = trim(I('post.j_bankNoNote'));  //再次确认银行卡号码

                if (empty($j_name)) {
                    $data['status'] = 0;
                    $data['msg'] = '持卡人不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (is_numeric($j_name) || mb_strlen($j_name) > 15) {
                    $data['status'] = 0;
                    $data['msg'] = '持卡人填写不正确';
                    $this->ajaxReturn($data, 'JSON');
                }
                
                if(empty($Card)) {

                    $data['status'] = 0;
                    $data['msg'] = '身份证号码不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

               if(!preg_match("/(^\d{15}$)|(^\d{17}([0-9]|X)$)/",$Card)) {

                    $data['status'] = 0;
                    $data['msg'] = '身份证号码填写不正确';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($j_bankPhone)) {
                    $data['status'] = 0;
                    $data['msg'] = '银行预留手机号不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (!preg_match('/^1\d{10}$/', $j_bankPhone)) {
                    $data['status'] = 0;
                    $data['msg'] = '手机号填写错误';
                    $data['tel'] = $j_bankPhone;
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($bankName)) {

                    $data['status'] = 0;
                    $data['msg'] = '银行名称不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($province)) {

                    $data['status'] = 0;
                    $data['msg'] = '请填写开户所在省';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($city)) {

                    $data['status'] = 0;
                    $data['msg'] = '请填写开户所在市';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($branch)) {
                    $data['status'] = 0;
                    $data['msg'] = '支行名称不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($j_bankNo) || empty($j_bankNoNote)) {
                    $data['status'] = 0;
                    $data['msg'] = '银行卡号不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (!is_numeric($j_bankNo) || !is_numeric($j_bankNoNote)) {
                    $data['status'] = 0;
                    $data['msg'] = '银行卡号填写不正确';
                    $this->ajaxReturn($data, 'JSON');
                }

                if($j_bankNo != $j_bankNoNote) {
                    $data['status'] = 0;
                    $data['msg'] = '银行卡号填写不一致';
                    $this->ajaxReturn($data, 'JSON');
                }


                $data['uid'] = $this->user_id;
                $data['busername']  = $j_name;
                $data['bankname']   = $bankName;
                $data['banknumber'] = $j_bankNo;
                $data['branch']     = $branch;
                $data['tel']        = $j_bankPhone;
                $data['card']       = $Card;
                $data['province']   = $province;
                $data['city']       = $city;

                $bankinfoObj = M('bankinfo');
                $is_exist = $bankinfoObj->field('busername,bankname,banknumber,branch,tel')->where(array('uid' => $data['uid']))->find();
                if ($is_exist) {//若存在，更新
                    if($is_exist['busername']==$data['busername'] && $is_exist['bankname']==$data['bankname'] && $is_exist['banknumber']==$data['banknumber']&&$is_exist['branch']==$data['branch']&&$is_exist['tel']==$data['tel']){
                        $bank=1;//提交的数据和原始数据一致，则不更改数据库
                    }else{
                        $bank = $bankinfoObj->where(array('uid' => $data['uid']))->save($data);
                    }
                } else {//不存在则添加
                    $bank = $bankinfoObj->add($data);
                }
            }

            if ($bank) {
                $data['status'] = 1;
                $data['msg'] = '绑定成功';
                $this->ajaxReturn($data, 'JSON');
            } else {
                $data['status'] = 0;
                $data['msg'] = '绑定失败';
                $this->ajaxReturn($data, 'JSON');
            }
        }
        $this->error('您访问的页面不存在','index');
    }

    /**
     * 个人信息
     * @author wang <admin>
     */
    public function personal(){

        $bank = M("bankinfo")->field('banknumber')->where(array('uid' => $this->user_id))->find();
        $this->assign('bank',$bank);

        $info = M('userinfo')->field('utel,nickname,trade_pwd')->where(array('uid' => $this->user_id))->find();
        $tel = substr_replace($info['utel'],'****',3,4);
        $this->assign('tel',$tel);
        $this->assign('user',$info);

        $this->display('Ucenter/personal');
    }


    /**
     * 资金明细
     * @author wang <admin>
     */
    public function capital(){

        $flow = M("MoneyFlow")->where(array('uid' => $this->user_id))->order('dateline desc')->limit(0,10)->select();
        $count = M("MoneyFlow")->where(array('uid' => $this->user_id))->count();
        foreach ($flow as $key => $value) {

            $flow[$key]['account'] = substr($value['note'],strrpos($value['note'],'[')+1);
            $flow[$key]['account'] = preg_replace("/]/", "",$flow[$key]['account']);
            $note  = explode('[',$flow[$key]['note']);
            $flow[$key]['note'] = $note[0];
        }

        $this->assign('info',$flow);
        $this->assign('count',ceil($count/10));
        $this->display('Ucenter/capital');
    }

    /**
     * 资金明细分页
     * @author wang <admin>
     */
    public function capital_new(){

        $page = I('get.page');
        $flow = M("MoneyFlow")->where(array('uid' => $this->user_id))->order('dateline desc')->limit($page,10)->select();
        foreach ($flow as $key => $value) {

            $flow[$key]['account'] = substr($value['note'],strrpos($value['note'],'[')+1);
            $flow[$key]['account'] = preg_replace("/]/", "",$flow[$key]['account']);
            $flow[$key]['jtime']   = date('Y-m-d H:i:s',$flow[$key]['dateline']);
        }
        $this->ajaxReturn($flow,'JSON');
    }



    /**
     * 模拟明细
     * @author wang <admin>
     */
    public function simulation(){

        $journal = M('journal')->where(array('uid' => $this->user_id, 'type' => 2))->order('jtime desc')->limit(0,5)->select();
        $count   = M('journal')->where(array('uid' => $this->user_id, 'type' => 2))->count();
        $this->assign('count',ceil($count / 5));
        $this->assign('journal',$journal);
        $this->display('Ucenter/simulation');
    }

    /**
     * 模拟明细分页
     * @author wang <admin>
     */
    public function simulation_new(){

        $page = I('get.page');
        $journal = M('journal')->where(array('uid' => $this->user_id, 'type' => 2))->order('jtime desc')->limit($page,5)->select();
        foreach ($journal as &$value) {

            $value['jtime'] = date('Y-m-d H:i:s',$value['jtime']);
        }
        $this->ajaxReturn($journal,'JSON');

    }

    /**
     * 推广赚钱
     * @author wang <admin>
     */

    public function extension(){

        $dataArr  = array();

        $this->assign('img',M('accountinfo')->field('img')->where(array('uid' => $this->user_id))->find());  //图片

        $user = M('userinfo')->field('code,uid')->where(array('uid' => $this->user_id))->find();//code
        $ship = M("UserinfoRelationship")->where(array('user_id' => $user['uid']))->find();

        //$user['url'] = 'http://'.$_SERVER['HTTP_HOST'].'/?code='.$user['code'];  //推广连接

        $agent_id    = exchange($user['uid'],2);
        $s_domain    = M('userinfo')->where(array('uid' => $agent_id,'otype' => 5))->getField('s_domain');
        if($s_domain){
           $user['url'] = 'http://'.$s_domain.'.'.SYSTEM_DOMAIN.'/?code='.$user['code'];
        }else{
           $user['url'] = 'http://'.$_SERVER['HTTP_HOST'].'/?code='.$user['code'];
        }
        $this->assign('code',$user);

        //一级
        $extension_on = "select * from wp_userinfo where unix_timestamp(NOW()) < utime+365*24*60*60 and rid = ".$user['uid']." ";

        $extension_one = M()->query($extension_on);

        $summm   = 0;
        $sum_two = 0;
        foreach ($extension_one as $value) {

            if(M('FeeReceive')->field('id')->where(array('purchaser_id' => $value['uid']))->find())  //交易用户
                $summm+=1;

            //二级
            $extension_tw = "select * from wp_userinfo where unix_timestamp(NOW()) < utime+365*24*60*60 and rid = ".$value['uid']." ";
            $extension_two = M()->query($extension_tw);

            if($extension_two){

                foreach ($extension_two as $value_two) {

                    if(M('FeeReceive')->field('id')->where(array('purchaser_id' => $value_two['uid']))->find())
                        $sum_two+=1;
                }
            }
        }

        //佣金结算统计
        $dataArr['RightMoney'] = M('FeeReceive')->where(array('user_id' => $this->user_id,'status' => 1))->sum('profit_rmb');
        $dataArr['WrongMoney'] = M('FeeReceive')->where(array('user_id' => $this->user_id,'status' => 2))->sum('profit_rmb');

        //佣金订单统计
        $dataArr['RightCount'] = M('FeeReceive')->where(array('user_id' => $this->user_id,'status' => 1))->count();
        $dataArr['WrongCount'] = M('FeeReceive')->where(array('user_id' => $this->user_id,'status' => 2))->count();


        $extension = M('extension')->where(array('user_id' => $this->user_id))->find(); //可提佣金
        $count = count($extension_one) + count($extension_two);  //我的用户
        $order_count = $summm+$sum_two;                          //交易的用户
        $this->assign('money',$extension['money']);
        $this->assign('count',$count);
        $this->assign('order_count',$order_count);

        $this->assign('RightMoney',$RightMoney);
        $this->assign('dataArr',$dataArr);
        $this->display('Ucenter/extension');
    }

    public function auto_commission(){

        $fee = M()->query("SELECT * FROM wp_fee_receive WHERE status = 2 and type = 1 and YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d')) = YEARWEEK(NOW())-1");
        $data = array();
        $status = array();
        foreach ($fee as $key => $value) {

            $data[$key]['user_id']    = $value['user_id'];
            $data[$key]['profit_rmb'] = $value['profit_rmb'];
            array_push($status,$value['id']);
        }

        $id = implode(',',array_unique($status));
        $result = M("FeeReceive")->where('id in('.$id.')')->setField('status',1);

        if($result){
            foreach ($data as $k => $v) {
                $result = M("extension")->where(array('user_id' => $v['user_id']))->setInc('money',$v['profit_rmb']);
            }
        }
    }


 /**
  * 确认推广
  * @author wang <admin>
  */
    public function ExtensionIs(){

        $map = array();
        $code = generate_code(4);
        $ship = M("UserinfoRelationship")->where(array('user_id' => $this->user_id))->find();
        $url  = 'http://'.$_SERVER['HTTP_HOST'].'/?code='.$code;
        $ext  = qrcode($url,4,$code);


        $is_code = M('userinfo')->where(array('uid' => $this->user_id))->find();
        $extension = M('extension')->where(array('user_id' => $this->user_id))->find();
        if(!empty($is_code['code']) && isset($extension)){
          $map['code'] = 0;
          $this->ajaxReturn($map,'JSON');
        } else {
           
            $res  = M('userinfo')->where(array('uid' => $this->user_id))->setField('code',$code);
            $result = M('accountinfo')->where(array('uid' => $this->user_id))->setField('img',$ext);

            $data['user_id'] = $this->user_id;
            $data['money']   = 0;
            $data['create_time'] = time();
            $re = M('extension')->add($data);
            if($res && $result && $re){

                $map['code'] = 1;
            } else {
                $map['code'] = 0;
            }

          $this->ajaxReturn($map,'JSON');
        }
    }


    /**
     * 我的用户
     * @author wang <admin>
     */

    public function MyUser(){

        $optionIdArr     = array();
        $optionIdArr_two = array();
        //查询一级用户
        $user_one = M("userinfo")->where(array('rid' => $this->user_id))->select();
        foreach ($user_one as $key => $value) {

            array_push($optionIdArr,$value['uid']);
        }

        $one_id = implode(',',$optionIdArr);
        $water  = M()->query("select a.create_time,a.purchaser_id,a.status,a.type,a.profit_rmb as profit_rmb,b.*,d.capital_name from wp_fee_receive as a left join wp_userinfo as b on a.purchaser_id = b.uid left join wp_order as c on a.order_id = c.oid left join wp_option as d on c.pid = d.id where unix_timestamp(now()) < b.utime+365*24*60*60 and a.type = 1 and a.purchaser_id in(".$one_id.") and a.user_id = ".$this->user_id." order by a.status desc");

        foreach ($water as $key => $val) {

            $aa[$key]['lavel']        = '一级';
            $aa[$key]['username']     = $val['username'];
            $aa[$key]['profit']       = $val['profit_rmb'];  //一级
            $aa[$key]['create_time']  = $val['create_time'];
            $aa[$key]['capital_name'] = $val['capital_name'];
            $aa[$key]['status']       = $val['status'];
        }

         $user_two = M()->query("select * from wp_userinfo where rid in(".$one_id.")");

         foreach ($user_two as $value) {

             array_push($optionIdArr_two,$value['uid']);
         }

         $water_two = implode(',',array_unique($optionIdArr_two));

         $two = M()->query("select a.create_time,a.purchaser_id,a.status,a.type,a.profit_rmb as profit_rmb,b.*,d.capital_name from wp_fee_receive as a left join wp_userinfo as b on a.purchaser_id = b.uid left join wp_order as c on a.order_id = c.oid left join wp_option as d on c.pid = d.id where unix_timestamp(now()) < b.utime+365*24*60*60 and a.type = 1 and a.purchaser_id in(".$water_two.") and a.user_id = ".$this->user_id." order by a.status desc");


         foreach ($two as $key => $value) {

             $bb[$key]['lavel']        = '二级';
             $bb[$key]['username']     = $value['username'];
             $bb[$key]['profit']       = $value['profit_rmb'];
             $bb[$key]['create_time']  = $value['create_time'];
             $bb[$key]['capital_name'] = $value['capital_name'];
             $bb[$key]['status']       = $value['status'];
         }
        
        $a = count($aa) >= count($bb) ? $aa : $bb;

//        $a = $aa;

        foreach ($a as $kkk => $vvv) {

            $user[] = $aa[$kkk];
            $user[] = $bb[$kkk];
        }

        $user = array_filter($user);
        
        $datetime = array();
        foreach ($user as $v) {
            $datetime[] = $v['create_time'];
        }

        array_multisort($datetime,SORT_DESC,$user);
   
        if(I('get.page')){
            $page = I('get.page');
            $user = array_slice($user,$page,10);
            foreach ($user as &$value) {
                $value['create_time'] = date('y-m-d',$value['create_time']);
                $value['username'] = substr_replace($value['username'],'****',3,4);
            }
            $this->ajaxReturn($user,'JSON');

        } else{
            $this->assign('count',ceil(count($user)/10));
            $user = array_slice($user,0,10);
            foreach ($user as $key => $value) {
                $user[$key]['username'] = substr_replace($value['username'],'****',3,4);
            }
            $this->assign('user',$user);
            $this->display('Ucenter/myuser');
        }
    }


    /**
     * 提取佣金
     * @author wang <admin>
     */

    public function Commission(){

        $extension = M('extension')->where(array('user_id' => $this->user_id))->find(); //可提佣金

        $money = I('post.money'); //提取金额


        if(trim($money) > $extension['money']){
            $data['status'] = 0;
            $data['msg']    = '余额不足';
            $this->ajaxReturn($data,'JSON');
        }

        if(trim($money) < 100){
            $data['status'] = 0;
            $data['msg']    = '提现金额不能小于100元';
            $this->ajaxReturn($data,'JSON');
        }

        $result = M('accountinfo')->where(array('uid' => $this->user_id))->setInc('balance',$money);

        if($result){

            //用户佣金出入金额
            $map['user_id']     = $this->user_id;
            $map['account']     = $money;
            $map['type']        = 1;
            $map['create_time'] = time();
            $journal = M("UserJournal")->add($map);
            $extens = M("extension")->where(array('user_id' => $this->user_id))->setDec('money',$money);
            if($journal && $extens) {

                $where['uid']   = $this->user_id;
                $where['type']  = 5;
                $where['oid']   = $journal;
                $where['note']  = '用户佣金转入余额['.$money.']元';
                $where['balance'] = M('accountinfo')->where(array('uid' => $this->user_id))->sum('balance');
                $where['op_id'] = $this->user_id;
                $where['dateline'] = time();
                M("MoneyFlow")->add($where);

                $data['status'] = 1;
                $data['msg']    = '提取金额成功,页面正在跳转';
                $this->ajaxReturn($data,'JSON');
            }
        } else {

            $data['status'] = 0;
            $data['msg']    = '提取金额失败';
            $this->ajaxReturn($data,'JSON');
        }

    }

    //修改昵称
    public function nickname()
    {
        if(IS_POST) {

            $nickname = trim(I('post.nickname'));

            if(empty($nickname)) {
                $data['status'] = 0;
                $data['msg']    = '请输入要修改的昵称';
                $this->ajaxReturn($data,'JSON');
            }

            $res = M('userinfo')->where(['uid' => $this->user_id])->setField('nickname',$nickname);

            if($res) {
                $data['status'] = 1;
                $data['msg']    = '昵称修改成功';
                $this->ajaxReturn($data,'JSON');
            }else {
                $data['status'] = 0;
                $data['msg']    = '昵称修改失败';
                $this->ajaxReturn($data,'JSON');
            }

        } else {

            $nickname = M('userinfo')->where(['uid' => $this->user_id])->getField('nickname');

            $this->assign('nickname',$nickname);
            $this->display();
        }
    }

    //修改提款密码
    public function tradePwd(){
        if(IS_POST) {

            $login_pwd          = trim(I('post.login_pwd'));
            $trade_pwd          = trim(I('post.trade_pwd'));
            $confim_trade_pwd   = trim(I('post.confim_trade_pwd'));


            if(empty($login_pwd)) {
                $data['status'] = 0;
                $data['msg']    = '登录密码不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(empty($trade_pwd)) {
                $data['status'] = 0;
                $data['msg']    = '提款密码不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(empty($confim_trade_pwd)) {
                $data['status'] = 0;
                $data['msg']    = '确认提款密码不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if($trade_pwd != $confim_trade_pwd) {
                $data['status'] = 0;
                $data['msg']    = '提款密码不一致';
                $this->ajaxReturn($data,'JSON');
            }

            $upwd = M('userinfo')->where(['uid' => $this->user_id])->getField('upwd');

            if($upwd != md5($login_pwd)) {
                $data['status'] = 0;
                $data['msg']    = '登录密码不正确';
                $this->ajaxReturn($data,'JSON');
            }

            $res = M('userinfo')->where(['uid' => $this->user_id])->setField('trade_pwd',md5($trade_pwd));

            if($res) {
                $data['status'] = 1;
                $data['msg']    = '提款密码修改成功';
                $this->ajaxReturn($data,'JSON');
            }else {
                $data['status'] = 0;
                $data['msg']    = '提款密码修改失败';
                $this->ajaxReturn($data,'JSON');
            }

        } else {
            $this->display();
        }
    }

    //修改登录密码
    public function loginPwd(){
        if(IS_POST) {

            $used_pwd       = trim(I('post.used_pwd'));
            $new_pwd        = trim(I('post.new_pwd'));
            $confim_new_pwd = trim(I('post.confim_new_pwd'));

            if(empty($used_pwd)) {
                $data['status'] = 0;
                $data['msg']    = '旧密码不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(empty($new_pwd)) {
                $data['status'] = 0;
                $data['msg']    = '新密码不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(empty($confim_new_pwd)) {
                $data['status'] = 0;
                $data['msg']    = '确认新密码不能为空';
                $this->ajaxReturn($data,'JSON');
            }


            if($new_pwd != $confim_new_pwd) {
                $data['status'] = 0;
                $data['msg']    = '新密码输入不一致';
                $this->ajaxReturn($data,'JSON');
            }


            $upwd = M('userinfo')->where(['uid' => $this->user_id])->getField('upwd');

            if($upwd != md5($used_pwd)) {
                $data['status'] = 0;
                $data['msg']    = '旧密码不正确';
                $this->ajaxReturn($data,'JSON');
            }

            $res = M('userinfo')->where(['uid' => $this->user_id])->setField('upwd',md5($new_pwd));

            if($res) {
                $data['status'] = 1;
                $data['msg']    = '密码修改成功';
                $this->ajaxReturn($data,'JSON');
            }else {
                $data['status'] = 0;
                $data['msg']    = '密码修改失败';
                $this->ajaxReturn($data,'JSON');
            }

        }else {
            $this->display();
        }
    }
}
