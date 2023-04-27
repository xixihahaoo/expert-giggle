<?php
namespace Home\Controller;

use Think\Controller;
use Org\Util\Zhongxin;
use Org\Util\Log;


class PayController extends CommonController
{
       
     public function _initialize(){
        $this->reapalNotice_url = "http://" . $_SERVER['HTTP_HOST'] . "/index.php/Pay/payReapalNotice"; //通知
        $this->reapalReturn_url = "http://" . $_SERVER['HTTP_HOST'] . "/index.php/Pay/payReapalReturn"; //回调
           $this->yitong_url= "http://" . $_SERVER['HTTP_HOST'] . "/Home/Pay/payReapalReturn";
        $this->yitong_payReapalReturn= "http://" . $_SERVER['HTTP_HOST'] . "/Home/Pay/yitong_payReapalReturn";//易通支付通知
     }


    /**
     * 智付
     * @author wang <admin>
     */
    public function zhifu(){

        $money = I('get.money');
        $serial_no =  I('get.ordernum');

        header("Content-type: text/html; charset=UTF-8");
        require_once 'Dinpay.Key.php';
        $priKey = openssl_get_privatekey($priKey);

        /////////////////////////////////初始化提交参数//////////////////////////////////////

        $merchant_code = C('ZHIFUNO'); //商户号
        $service_type = "direct_pay";
        $interface_version = "V3.0";
        $pay_type = "";
        $sign_type = "RSA-S";
        $input_charset = "UTF-8";
        $notify_url = $this->reapalNotice_url;   //通知地址

        $order_no = $serial_no; //订单号id[商户网站]

        $order_time = date("Y-m-d H:i:s", time()); //订单创建时间

        $nummoney = number_format($money, 2, ".", ""); //冲值金额

        $fee = 0;
        //手续费率后台设定
        $feemoney = number_format($fee * $nummoney / 100, 2, ".", "");

        $order_amount = $nummoney; //最终冲值金额

        $name = mb_convert_encoding("帐户充值", "UTF-8", "UTF-8");
        $product_name = $name;
        //iconv( "UTF-8", "gb2312//IGNORE" ,$this->glo['web_name']."帐户充值");//产品名称
        $product_code = "";
        $product_desc = "";
        $product_num = "";
        $show_url = "";
        $client_ip = "";
        $bank_code = "";
        $redo_flag = "";
        $extend_param = "";
        $extra_return_param = "";
        $return_url = $this->reapalReturn_url;  //回调地址

        $signStr = "";
        if ($bank_code != "") {
            $signStr = $signStr . "bank_code=" . $bank_code . "&";
        }
        if ($client_ip != "") {
            $signStr = $signStr . "client_ip=" . $client_ip . "&";
        }
        if ($extend_param != "") {
            $signStr = $signStr . "extend_param=" . $extend_param . "&";
        }
        if ($extra_return_param != "") {
            $signStr = $signStr . "extra_return_param=" . $extra_return_param . "&";
        }
        $signStr = $signStr . "input_charset=" . $input_charset . "&";
        $signStr = $signStr . "interface_version=" . $interface_version . "&";
        $signStr = $signStr . "merchant_code=" . $merchant_code . "&";
        $signStr = $signStr . "notify_url=" . $notify_url . "&";
        $signStr = $signStr . "order_amount=" . $order_amount . "&";
        $signStr = $signStr . "order_no=" . $order_no . "&";
        $signStr = $signStr . "order_time=" . $order_time . "&";
        if ($pay_type != "") {
            $signStr = $signStr . "pay_type=" . $pay_type . "&";
        }
        if ($product_code != "") {
            $signStr = $signStr . "product_code=" . $product_code . "&";
        }
        if ($product_desc != "") {
            $signStr = $signStr . "product_desc=" . $product_desc . "&";
        }
        $signStr = $signStr . "product_name=" . $product_name . "&";
        if ($product_num != "") {
            $signStr = $signStr . "product_num=" . $product_num . "&";
        }
        if ($redo_flag != "") {
            $signStr = $signStr . "redo_flag=" . $redo_flag . "&";
        }
        if ($return_url != "") {
            $signStr = $signStr . "return_url=" . $return_url . "&";
        }
        if ($show_url != "") {
            $signStr = $signStr . "service_type=" . $service_type . "&";
            $signStr = $signStr . "show_url=" . $show_url;
        } else {
            $signStr = $signStr . "service_type=" . $service_type;
        }
        openssl_sign($signStr, $sign_info, $priKey, OPENSSL_ALGO_MD5);

        $sign = base64_encode($sign_info);

        $submitdata['sign'] = $sign;

        $submitdata['merchant_code'] = $merchant_code;

        $submitdata['bank_code'] = $bank_code;

        $submitdata['order_no'] = $order_no;

        $submitdata['order_amount'] = $order_amount;

        $submitdata['service_type'] = $service_type;

        $submitdata['input_charset'] = $input_charset;

        $submitdata['notify_url'] = $notify_url;

        $submitdata['interface_version'] = $interface_version;

        $submitdata['sign_type'] = $sign_type;

        $submitdata['order_time'] = $order_time;

        $submitdata['product_name'] = $product_name;

        $submitdata['client_ip'] = $client_ip;

        $submitdata['extend_param'] = $extend_param;

        $submitdata['extra_return_param'] = $extra_return_param;

        $submitdata['pay_type'] = $pay_type;

        $submitdata['product_code'] = $product_code;

        $submitdata['product_num'] = $product_num;

        $submitdata['return_url'] = $return_url;

        $submitdata['product_desc'] = $product_desc;

        $submitdata['show_url'] = $show_url;

        $submitdata['redo_flag'] = $redo_flag;

        $this->create($submitdata, "https://pay.dinpay.com/gateway?input_charset=UTF-8");
        //智付接收地址
       
    }
	

    private function create($data, $submitUrl) {
        $inputstr = "";
        foreach ($data as $key => $v) {
            $inputstr .= '<input type="hidden"  id="' . $key . '" name="' . $key . '" value="' . $v . '"/>';
        }
        $form = '<form action="' . $submitUrl . '" name="pay" id="pay" method="POST">';
        $form .= $inputstr;
        $form .= '</form>';
        $html = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>请不要关闭页面,支付跳转中.....</title>
        </head><body>
        ';
        $html .= $form;
        $html .= '
        <script type="text/javascript">
           document.getElementById("pay").submit();
        </script>';
        $html .= '</body></html>';
        $this->Mheader('utf-8');
        echo $html;

        exit;

    }

    private function Mheader($type) {

        header("Content-Type:text/html;charset={$type}");
    }



   public function checkorderstatus($orderno) {
        $balance = M('balance');
        $order = $balance->WHERE(array("balanceno" => $orderno))->find();
        if ($order['isverified'] == 1) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * 智付通知地址
     * @author wang <admin>
     */
    public function payReapalNotice() {
        if (empty($_POST)) {
            //判断提交来的数组是否为空
            echo "POST";
            return false;
        } else {
            $merchant_code      = $_POST["merchant_code"];
            $merchant_code2     = C('ZHIFUNO');
            $interface_version  = $_POST["interface_version"];
            $sign_type          = $_POST["sign_type"];
            $dinpaySign         = base64_decode($_POST["sign"]);
            $notify_type        = $_POST["notify_type"];
            $notify_id          = $_POST["notify_id"];
            $order_no           = $_POST["order_no"];
            $order_time         = $_POST["order_time"];
            $order_amount       = $_POST["order_amount"];
            $trade_status       = $_POST["trade_status"];
            $trade_time         = $_POST["trade_time"];
            $trade_no           = $_POST["trade_no"];
            $bank_seq_no        = $_POST["bank_seq_no"];
            $extra_return_param = $_POST["extra_return_param"];
            if ($trade_status == "SUCCESS" && $merchant_code == $merchant_code2) {
                //验签成功（Signature correct）
                $parameter = array(
                    "order_no" => $order_no, //商户订单编号；
                    "order_amount" => $order_amount, //交易金额；
                    "trade_status" => $trade_status, //交易状态
                );
                if (!$this->checkorderstatus($order_no)) {

                    //数据库逻辑处理
                    $balance = M('balance');
                    $user = M('accountinfo');

                    $data = $balance->where(array('balanceno' => $order_no))->find();
                    $data['isverified'] = '1'; //入金成功
                    $data['status']     = '1'; //完成
                    $user->startTrans();

                    $case = $balance->where(array('balance' => $order_no))->save($data);
                    $money = $user->where(array('uid' => $data['uid']))->setInc('balance', $order_amount);
                    $money_total = $user->where(array('uid' => $bala['uid']))->setInc('recharge_total', $order_amount);
                    if ($case && $money && $money_total) {
                        //用户资金流水表
                        $map['uid']      = $this->user_id;
                        $map['type']     = 4;
                        $map['oid']      = $bala['bpid'];
                        $map['note']     = '用户使用智付充值金额增加['.$order_amount.']元';
                        $map['op_id']    = $this->user_id;
                        $map['dateline'] = time();
                        M("MoneyFlow")->add($map);

                        $balance->commit(); //对数据库的操作
                        echo "OK";
                        //$this->success('支付成功', 'User/memberinfo');
                    } else {
                        echo "ERROR";
                        $balance->callbak();
                        //$this->error('支付失败,系统没有查到此订单号!');
                    }

                }
            } else {
                echo "Signature Error";
            }

        }
    }

    /**
     * 智付回调地址
     * @author wang <admin>
     */
    
    public function payReapalReturn(){

          $this->redirect('User/index');

    }


    /**
     * 微信支付
     * @author wang <admin>
     */
    public function wxpay()
    {

        if(!session('user_id'))
        {
            $this->redirect(U('Register/login'));
        }


        $info  = M("userinfo_open")->where(array('user_id' => session('user_id')))->find();

        $req        = new Zhongxin();
        $money      =  trim(I('get.money'));
        $serial_no  =  trim(I('get.ordernum'));
        $dataArr    = array(
            'out_trade_no'  => $serial_no,
            'total_fee'     => $money * 100,
            'attach'        => '普通会员充值',
            'body'          => '普通会员充值',
            'mch_create_ip' => '127.0.0.1',
            'sub_openid'    => $info['open_id']
        );


//        vD($dataArr);
//        die();

        $aa = $req->weixin_js_pay($dataArr);

     
        header('Location: https://pay.swiftpass.cn/pay/jspay?token_id='.$aa.'&showwxtitle=1');
        
    }


    /**
     * 提供给威富通的回调方法
     */
    public function WxpayReturn(){

//        $xml = file_get_contents('php://input');
//
//          $req        = new Zhongxin();

          $this->display('payok');
    }


    /**
     * @functionname: notify_url
     * @author: FrankHong
     * @date: 2016-12-16 17:05:45
     * @description:
     * @note:
     *
     * array (
        'attach' => '普通会员充值',
        'bank_type' => 'CFT',
        'charset' => 'UTF-8',
        'fee_type' => 'CNY',
        'is_subscribe' => 'N',
        'mch_id' => '102560066669',
        'nonce_str' => '1481879070878',
        'openid' => 'oMJGHsyVmhRJX-yBPPgik9PEV-pY',
        'out_trade_no' => '14818790501446994881',
        'out_transaction_id' => '4004282001201612162975410281',
        'pay_result' => '0',
        'result_code' => '0',
        'sign' => '22DB9CC35CEC4C461398CEAE856AE08A',
        'sign_type' => 'MD5',
        'status' => '0',
        'sub_appid' => 'wxc63594d45a3df5bb',
        'sub_is_subscribe' => 'Y',
        'sub_openid' => 'o-4egwbpWHh_QkAmnOsHGz-TYM1I',
        'time_end' => '20161216170430',
        'total_fee' => '1',
        'trade_type' => 'pay.weixin.jspay',
        'transaction_id' => '102560066669201612161255902883',
        'version' => '2.0',
        )
     */
    public function notify_url()
    {
        $postStr = file_get_contents('php://input');
        if(!empty($postStr))
        {
            $returnRs = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        }

        Log::debugArr($returnRs, 'notify_url');


        if($returnRs['status'] == 0 && $returnRs['result_code'] == 0)
        {
            $order_no           = $returnRs["out_trade_no"];
            $order_time         = time();  //cltime
            $order_amount       = $returnRs["total_fee"] / 100;

            $balance    = M('balance');
            $account    = M('accountinfo');

            $data1 = $balance->where(array('balanceno' => $order_no))->find();


            if(!$data1)
            {
                echo 'failure';
                exit();
            }
            else
            {
                if($data1['isverified'] == 1 && $data1['status'] == 1)
                {
                    echo 'success';
                    exit();
                }


                $data['isverified'] = '1'; //入金成功
                $data['status']     = '1'; //完成
                $data['cltime']     = $order_time; //完成
                $data['shibpprice']     = $data1['shibpprice'] + $order_amount; //完成

                //$account->startTrans();

                $case = $balance->where(array('balanceno' => $order_no))->save($data);
                $money = $account->where(array('uid' => $data1['uid']))->setInc('balance', $order_amount);
                $money_total = $account->where(array('uid' => $data1['uid']))->setInc('recharge_total', $order_amount);
                if ($case && $money && $money_total)
                {    
                    //用户资金流水表
                    $map['uid']      = $this->user_id;
                    $map['type']     = 4;
                    $map['oid']      = $data1['bpid'];
                    $map['note']     = '用户使用微信支付充值金额增加['.$order_amount.']元';
                    $map['op_id']    = $this->user_id;
                    $map['dateline'] = time();
                    M("MoneyFlow")->add($map);
                    
                    //$balance->commit(); //对数据库的操作
                    echo 'success';
                    exit();
                }
                else
                {
                    //$balance->callbak();
                    echo 'failure';
                    exit();
                }
            }

        }


    }


    /**
     * 微信支付回调
     * @author wang <admin>
     */

    public function WxpayReturn123(){
        

       $fileContent = file_get_contents("php://input");
       $xmlResult = simplexml_load_string($fileContent);

       var_dump($xmlResult);
    
        var_dump($_REQUEST);die;

        if (empty($_POST)) {
            //判断提交来的数组是否为空
            echo "POST";
            return false;
        } else {
            $merchant_code      = $_POST["merchant_code"];
            $merchant_code2     = C('ZHIFUNO');
            $interface_version  = $_POST["interface_version"];
            $sign_type          = $_POST["sign_type"];
            $dinpaySign         = base64_decode($_POST["sign"]);
            $notify_type        = $_POST["notify_type"];
            $notify_id          = $_POST["notify_id"];
            $order_no           = $_POST["order_no"];
            $order_time         = $_POST["order_time"];
            $order_amount       = $_POST["order_amount"];
            $trade_status       = $_POST["trade_status"];
            $trade_time         = $_POST["trade_time"];
            $trade_no           = $_POST["trade_no"];
            $bank_seq_no        = $_POST["bank_seq_no"];
            $extra_return_param = $_POST["extra_return_param"];
            if ($trade_status == "SUCCESS" && $merchant_code == $merchant_code2) {
                //验签成功（Signature correct）
                $parameter = array(
                    "order_no" => $order_no, //商户订单编号；
                    "order_amount" => $order_amount, //交易金额；
                    "trade_status" => $trade_status, //交易状态
                );
                if (!$this->checkorderstatus($order_no)) {

                    //数据库逻辑处理
                    $balance = M('balance');
                    $user = M('accountinfo');

                    $data = $balance->where(array('balanceno' => $order_no))->find();
                    $data['isverified'] = '1'; //入金成功
                    $data['status']     = '1'; //完成
                    $user->startTrans();

                    $case = $balance->where(array('balance' => $order_no))->save($data);
                    $money = $user->where(array('uid' => $data['uid']))->setInc('balance', $order_amount);
                    if ($case && $money) {

                        $balance->commit(); //对数据库的操作
                        echo "OK";
                        //$this->success('支付成功', 'User/memberinfo');
                    } else {
                        echo "ERROR";
                        $balance->callbak();
                        //$this->error('支付失败,系统没有查到此订单号!');
                    }

                }
            } else {
                echo "Signature Error";
            }

        }

    }
    //易通支付
    public function yitong_pay(){
       $money = I('get.money');
       $ordernum =  I('get.ordernum');
       $type=I('get.paytype');
       $money=I('get.money');
       $balance = D('Balance')->getDetailByOrderNo($ordernum); // 交易详情
       if (!$balance) die('无效订单');
      
       $payUrl = "http://cashier.etonepay.com/NetPay/BankSelect.action";
        $data['merchantId'] =  C("MERCHANTID"); //商户编号
        $data['bussId'] = "888297";
        if($type=="yitong_weipay"){

            $orderInfo = '微信充值';
            $data['activeTime'] = 10;
        }elseif($type=="yitong_zhifubaopay"){
            $data['activeTime'] = 10;
            $orderInfo = '支付宝扫码充值';
        }else if($type=="yitong_webyinlian"){
             $data['bussId'] = "888298";
             $orderInfo = '银联web快捷充值';
        }else{
            $data['bussId'] = "888296";
            $orderInfo = '银联手机快捷充值';
        }
        $data['bankId'] = C("BANKID");
        $data['EntryType'] = 1;
        $data['datakey'] = C('DATAKEY');
        $data['tranAmt'] = $money*100;
        $data['merOrderNum'] = $ordernum;
        $data['orderInfo'] = $orderInfo;
        $data['tranDateTime'] = date('YmdHis');
        $data['transCode'] = "8888";
        $data['currencyType'] = "156";
        $data['version'] = "1.0.0";
        $data['sysTraceNum'] = $data['tranDateTime'] . floor(microtime() * 1000);  //请求流水号，需要保持唯一
        $data['userId'] = ''; //易通支付会员ID代码，可为空
        $data['merURL'] = $this->yitong_url;//页面返回地址
        $data['backURL'] = $this->yitong_payReapalReturn;
       // dump($data);exit;
    //  dump($data);exit;
        if (!empty($data['orderInfo'])) {
            $data['orderInfo'] = $this->strToHex($orderInfo);
        }
        $txnString = $data['version'] . "|" . $data['transCode'] . "|" . $data['merchantId'] . "|" . $data['merOrderNum'] . "|" . $data['bussId'] . "|" . $data['tranAmt'] . "|" . $data['sysTraceNum']
                . "|" . $data['tranDateTime'] . "|" . $data['currencyType'] . "|" . $data['merURL'] . "|" . $data['backURL'] . "|" . $data['orderInfo'] . "|" . $data['userId'];
      
        $data['signValue'] = md5($txnString . $data['datakey']); 
       //dump($result);exit;
      if($type=="yitong_weipay"){
            $result = post_codeimglist($payUrl,$data);
            //dump($result);exit;
            $url=$result['codeUrl'];
            Header("Location:$url");
        }elseif($type=="yitong_zhifubaopay"){
            $result = post_codeimglist($payUrl,$data);
            $this->assign('oid',$ordernum);
            $this->assign('zhifuImg',$result['codeImg']);
            $this->display('Pay/yitong_code');
        }elseif($type=="yitong_yinlian"){
             $this->create($data,$payUrl);
        }elseif($type=="yitong_webyinlian"){
            // dump($data);exit;
            $this->create($data,$payUrl);
        }
      
    }
    //字符串转16进制ascii码
    private function strToHex($string){
        $hex='';
        for ($i=0; $i < strlen($string); $i++)
        {
            $hex .= dechex(ord($string[$i]));
        }
        return strtoupper($hex);
    }
    public function yitong_payReapalReturn(){

         if (empty($_REQUEST)) {
            //判断提交来的数组是否为空
            echo "ERROR";
        }else{
            $transCode = $_REQUEST["transCode"];
            $merchantId = $_REQUEST["merchantId"];
            $merchantId2=C("MERCHANTID");
            $respCode = $_REQUEST["respCode"];
            $sysTraceNum = $_REQUEST["sysTraceNum"];
            $merOrderNum = $_REQUEST["merOrderNum"];
            $orderId = $_REQUEST["orderId"];
            $bussId = $_REQUEST["bussId"];
            $tranAmt = $_REQUEST["tranAmt"]/100;
            $orderAmt = $_REQUEST["orderAmt"];
            $bankFeeAmt = $_REQUEST["bankFeeAmt"];
            $integralAmt = $_REQUEST["integralAmt"];
            $vaAmt = $_REQUEST["vaAmt"];
            $bankAmt = $_REQUEST["bankAmt"];
            $bankId = $_REQUEST["bankId"];
            $sysTraceNum = $_REQUEST["sysTraceNum"];
            $integralSeq = $_REQUEST["integralSeq"];
            $vaSeq = $_REQUEST["vaSeq"];
            $bankSeq = $_REQUEST["bankSeq"];
            $tranDateTime = $_REQUEST["tranDateTime"];
            $payMentTime = $_REQUEST["payMentTime"];
            $settleDate = $_REQUEST["settleDate"];
            $currencyType = $_REQUEST["currencyType"];
            $orderInfo = $_REQUEST["orderInfo"];
            $userId = $_REQUEST["userId"];
            $userIp = $_REQUEST["userIp"];
            $reserver1 = $_REQUEST["reserver1"];
            $reserver2 = $_REQUEST["reserver2"];
            $reserver3 = $_REQUEST["reserver3"];
            $reserver4 = $_REQUEST["reserver4"];
            $signValue = $_REQUEST["signValue"];
           // dump($_REQUEST);
            Log::debugArr($_REQUEST,'yitong_payReapalReturn');
            $res=$this->checkorderstatus($merOrderNum);
            if($res){
            	echo "success";exit;
            }
             $fp = fopen("./lock.lock", "w");  
      
            if (flock($fp, LOCK_EX)) {  // 进行排它型锁定 
                if($respCode=="0000" && $merchantId==$merchantId2){
               
                    if (!$this->checkorderstatus($merOrderNum)) {    
                        $balance = M('balance');
                        $user = M('accountinfo');
                        $data = $balance->where(array('balanceno' => $merOrderNum))->find();

                        $res['isverified'] = '1'; //入金成功
                        $res['status']     = '1'; //完成
                        $res['cltime']=time();
                        //$user->startTrans();
                        $case = $balance->where("balanceno='".$merOrderNum."'")->save($res);
                        if ($case) {
                            $money = $user->where(array('uid' => $data['uid']))->setInc('balance', $tranAmt);
                            $money_total = $user->where(array('uid' => $data['uid']))->setInc('recharge_total', $tranAmt);
                         //用户资金流水表
                            $zongjinge=$user->getFieldByUid($data['uid'],'balance');
                            $map['uid']      = $data['uid'];
                            $map['type']     = 4;
                            $map['oid']      = $data['bpid'];
                            $map['note']     = '用户使用易通充值金额增加['.$tranAmt.']元';
                            $map['op_id']    = $data['uid'];
                            $map['dateline'] = time();
                            $map['balance']=$zongjinge;
                            M("MoneyFlow")->add($map);
                           //$sql=M()->getlastsql();

                           //file_put_contents('text.txt',$case."#".$money."#".$money_total."#".$sql);
                           //M("MoneyFlow")->commit();
                           //$balance->commit(); //对数据库的操作
                           echo "success";
                        }else{
                          echo "error";
    
                        }
            
                    }
                }
            }else{
                    
            }
            flock($fp, LOCK_UN);   
            fclose($fp);
        }
    }
  //  public function findmonery_fllow(){
  //   $balance = M('balance');
  //   $user = M('accountinfo');
  //   //$where['pay_type']=array("eq",23);
  //   $where['balanceno']="15032868661551464280";
  //   $where['status']=array("eq",1);
  //   $case = $balance->where($where)->find();
  //   dump($case);//exit;
  //   if($case){
  //       $money = $user->where(array('uid' => $case['uid']))->setInc('balance', $case["bpprice"]);
  //       echo M()->getlastsql();
  //       $money_total = $user->where(array('uid' => $case['uid']))->setInc('recharge_total', $case["bpprice"]);
  //       echo M()->getlastsql();
  //       $map['uid']  =$case['uid'];
  //       $map['type']     = 4;
  //       $map['oid']      = $case['bpid'];
  //       $map['note']     = '用户使用易通充值金额增加['.$case['bpprice'].']元';
  //       $map['op_id']    = $case['uid'];
  //       $map['dateline'] = $case['bptime'];
  //       $map['balance']=$case['bpprice']+$case['shibpprice'];
  //       $res=M("MoneyFlow")->add($map);
  //       dump($res);

  //   }
  // }
 
}