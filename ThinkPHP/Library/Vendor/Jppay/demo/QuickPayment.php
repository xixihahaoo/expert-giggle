<?php
// include_once '../JppSdk.php';
// include_once '../UtilHelper.php';
include_once(dirname(__FILE__).'../../JppSdk.php');
include_once(dirname(__FILE__).'../../UtilHelper.php');

class demoQuickPayment {
    /**
     * 快捷支付6.1 快捷绑卡
     * 请求类型:rpmBindCard(即公共请求报文字段service的值)
     */
    public static function bindCard($data) {
        $idNo = UtilHelper::desEncode($data['idNo']);
        $cardNo = UtilHelper::desEncode($data['cardNo']);
        // print_r('idNo = ' + $idNo + '\n');
        // print_r('cardNo = ' + $cardNo + '\n');

        $params = [
            'memberId' => $data['memberId'],
            'orderId' => $data['orderId'],
            'idType' => '00',
            'idNo' => $idNo,
            'userName' => $data['userName'],
            'phone' => $data['phone'],
            'cardNo' => $cardNo,
            'cardType' => '0',
            'expireDate' => '',
            'cvn2' => '233',
        ];

        $ret = JppSdk::bindCard($params);
        return $ret;
    }

    /**
     * 快捷支付6.2 解绑
     * 请求类型:rpmUnbindCard
     */
    public static function unbindCard($contractId, $memberId) {
        $params = [
            'contractId' => $contractId,
            'memberId' => $memberId,
        ];

        $ret = JppSdk::unbindCard($params);
        return $ret; 
    }

    /**
     * 快捷支付6.3 快捷支付短信下发/重发
     * 请求类型:rpmQuickPaySms
     *      注:后台根据协议号可以得到手机号码。短信验证码为6位随机数字，有效期是60秒，发送 间隔时间为60秒。
     */
    public static function quickPaySms($data) {
        $params = [
            'contractId' => $data['contractId'],
            'memberId' => $data['memberId'],
        ];

        $ret = JppSdk::smsSend($params);
        return $ret; 
    }

    // 快捷绑卡验证短信（rpmBindCardCommit）
    public static function rpmBindCardCommit($data)
    {
        $params = [
            'contractId' => $data['contractId'],
            'checkCode' => $data['checkCode'],
        ];

        $ret = JppSdk::rpmBindCardCommit($params);
        return $ret; 
    }



    /**
     * 快捷支付6.4 快捷支付发起(我方验证短信)
     * 请求类型:rpmQuickPayInit
     */
    public static function quickPayInit($data) 
    {
        $params = [
            'memberId'  => $data['memberId'],
            'orderId'   => $data['orderId'],
            'contractId' => $data['contractId'],
            'payType'   => 'DQP', //通道类型 String（3）只能取以下枚举值 DQP:借记卡快捷 CQP:信用卡快捷【暂不支持】
            'amount'    => $data['amount'],   //交易金额 String(11)以分为单位,有效长度1-11
            'currency'  => 'CNY',    //交易币种 String(32)默认CNY, 即人民币
            'orderTime' => $data['orderTime'],    //格式YYYYMMDDHHmmss
            'clientIP'  => $data['clientIP'],      //商户发送的客户端IP
            'validUnit' => '01',    //订单有效期单位 Number(2) 只能取以下枚举值 00-分 01-小时 02-日 03-月
            'validNum'  => '3',  //订单有效期数量
            'goodsName' => '在线支付',
            'goodsDesc' => '在线支付',
            'offlineNotifyUrl' => $data['offlineNotifyUrl'],
        ];

        $ret = JppSdk::quickPayInit($params);
        return $ret; 
    }

    /**
     * 快捷支付6.5 快捷支付提交(我方验证短信)
     * 请求类型:rpmQuickPayCommit
     */
    public static function quickPayCommit($data) {

        $params = [
            'memberId'  => $data['memberId'],
            'orderId'   => $data['orderId'],
            'contractId' => $data['contractId'],
            'checkCode' => $data['checkCode'],    //短信校验码 String(8) 短信校验码，只能是数字
            'payType'   => 'DQP', //通道类型 String（3）只能取以下枚举值 DQP:借记卡快捷 CQP:信用卡快捷【暂不支持】
            'amount'    => $data['amount'],   //交易金额 String(11)以分为单位,有效长度1-11
            'currency'  => 'CNY',    //交易币种 String(32)默认CNY, 即人民币
            'orderTime' => $data['orderTime'],    //格式YYYYMMDDHHmmss
            'clientIP'  => $data['clientIP'],      //商户发送的客户端IP
            'validUnit' => '01',    //订单有效期单位 Number(2) 只能取以下枚举值 00-分 01-小时 02-日 03-月
            'validNum'  => '3',
            'goodsName' => '在线支付',
            'goodsDesc' => '在线支付',
            'offlineNotifyUrl' => $data['offlineNotifyUrl'],
        ];

        $ret = JppSdk::quickPayCommit($params);
        return $ret;
    }


    /**
     * 快捷支付6.6 快捷支付(商户自验短信)
     * 请求类型:rpmQuickPay
     */
    public static function quickPay() {
        // $clientIP = UtilHelper::getClientIP();
        $clientIP = '192.168.7.7';
        $params = [
            'memberId' => '123456789',
            'orderId' => '20170820132400_779',
            'contractId' => '201708200000020512',
            'payType' => 'DQP', //通道类型 String（3）只能取以下枚举值 DQP:借记卡快捷 CQP:信用卡快捷【暂不支持】
            'amount' => '100000',   //交易金额 String(11)以分为单位,有效长度1-11
            'currency' => 'CNY',    //交易币种 String(32)默认CNY, 即人民币
            'orderTime' => '20170820141000',    //格式YYYYMMDDHHmmss
            'clientIP' => $clientIP,      //商户发送的客户端IP
            'validUnit' => '00',    //订单有效期单位 Number(2) 只能取以下枚举值 00-分 01-小时 02-日 03-月
            'validNum' => '3',
            'goodsName' => '巧克力圣代冰激凌蛋糕',
            'goodsDesc' => '商品描述：暂无',
            'offlineNotifyUrl' => 'http://127.0.0.1',   //异步通知url String(256) 交易结果通过后台通知到这个 url，建议DES加密
        ];

        $ret = JppSdk::quickPay($params);
        return $ret; 
    }

    /**
     * 快捷支付6.7 快捷支付查询
     * 请求类型:rpmPayQuery
     */
    public static function payQuery() {
        $params = [
            'orderId' => '20170820132400_778'
        ];

        $ret = JppSdk::payQuery($params);
        return $ret; 
    }

    /**
     * 快捷支付6.8 异步通知
     * 通知类型:rpmAsyncNotify
     * 通知类型是九派支付主动发起的请求，没有公共报文头定义。
     * 描述:九派支付通过https协议post方式请求商户系统。如果商户返回处理失败，九派支 付会间隔一段时间后`再次通知商户。但如果7天内商户对同一个订单的异步通知都返回失败， 九派支付就不再异步通知商户，商户可以主动查询订单状态。
     */
    public static function asyncNotify($parms) {
        $ret = JppSdk::asyncNotify($parms);
        return $ret; 
    }

    /**
     * 快捷支付6.9 退款
     * 请求类型:rpmRefund
     */
    public static function refund() {
        $params = [
            'refundAmount' => '100000',  //退款金额 String(11) 退款的金额，以分为单位,有效长 度为1-11位
            'oriOrderId' => '20170820132400_778',
            'orderId' => 'r_20170820132400_778',
        ];

        $ret = JppSdk::refund($params);
        return $ret; 
    }

    /**
     * 快捷支付6.10 退款查询
     * 请求类型:rpmRefundQuery
     */
    public static function refundQuery() {
        $params = [
            'oriOrderId' => '20170820132400_778',
            'orderId' => 'r_20170820132400_778',
        ];

        $ret = JppSdk::refundQuery($params);
        return $ret; 
    }

    /**
     * 快捷支付6.11 查询支持绑卡的银行列表
     * 请求类型:rpmBankList
     */
    public static function bankListQuery() {
        $params = NULL;
        $ret = JppSdk::supportBindList($params);
        return $ret; 
    }

    /**
     * 快捷支付6.12 查询用户的绑卡信息
     * 请求类型:rpmMemberCardList
     * 查询用户的绑卡信息时，只返回未过绑卡有效期、且未被解绑的绑卡信息。
     */
    public static function userCardList() {
        $params = [
            'memberId' => '123456789',
        ];

        $ret = JppSdk::userCardList($params);
        var_dump($ret);die;
        return $ret; 
    }

    /**
     * 快捷支付6.13 商户查询银行卡的签约状态
     * 请求类型:rpmQueryCardBindStatus
     * 查询用户的绑卡信息时，只返回未过绑卡有效期、且未被解绑的绑卡信息。
     */
    public static function bindStatus() {
        $cardNo = UtilHelper::desEncode('6226090000000048');
        $params = [
            'cardNo' => $cardNo,
            'merchantId' => '800001707100001',
            'memberId' => '123456789',
        ];

        $ret = JppSdk::bindStatus($params);
        var_dump($ret);die;
        return $ret; 
    }

    /**
     * 快捷支付6.14 查询银行卡信息
     * 请求类型:rpmCardInfo
     */
    public static function cardDetail() {
        $cardNo = UtilHelper::desEncode('6225880175058792');
        $params = [
            'cardNo' => $cardNo,
        ];

        $ret = JppSdk::cardDetail($params);
        return $ret; 
    }

    /**
     * 快捷支付6.15 对账单下载
     * 请求类型:rpmStatement
     * 描述:九派支付平台每天凌晨会定时生成对账单供商户下载。
     对账单内容: 
     描述:对账单内容由头信息与交易明细信息组成。文件只包含成功的交易，金额以“分”为单位，每行字段用“|”分隔，每行的最后有换行符是“\n”，没有回车符“\r”， 文件明细后面没有 空行或者文件终结符。
        1. 支付交易的对账单内容格式:
        头信息:“HEAD:成功订单笔数|成功订单金额|” 交易明细:“订单日期|订单支付类型|订单时间|商户订单编号|支付方式|订单状态|订单金额| 服务费|”
            订单支付类型:PAY_TYP 
            支付方式:PAY_CAP_MOD 
            订单状态:BD-交易成功
        文件内容示例: 
            2|50100|
            20170320|1|210638|ZL20170320203637340387|1|BD|100|0|
            20170321|1|115337|ZL20170321112335746734|1|BD|50000|0|
        2. 退款交易的对账单内容格式: 头信息:“HEAD:成功退款订单笔数|成功退款订单金额” 明细格式:“退款日期|退款时间|原商户订单号|退款状态|退款金额|退款订单号|”
            退款状态:RFD_STS
     */
    public static function statementDailyQuery() {
        $params = [
            'acDate' => '20170816',
            'type' => 'pay',    //类型，枚举类型: pay: 支付订单 | refund: 退款订单
        ];

        $ret = JppSdk::statementDailyQuery($params);
        return $ret; 
    }


}

// test 
$merchantId = '800000101000090';
$memberId = '123456789';
$phone = '18609098987';
$contractId = '201708200000020512';
$checkCode = '384923';  //九派支付验证短信，用户收到九派支付的短信验证码


// #1.绑卡
// $msgBindCard = demoQuickPayment::bindCard($memberId);
// var_dump($msgBindCard);

// #2.解绑
// $msgUnbindCard = demoQuickPayment::unbindCard('201708180000020420',$memberId);
// var_dump($msgUnbindCard);

// #3.快捷支付短信下发/重发
// $msgQuickPaySms = demoQuickPayment::quickPaySms();
// var_dump($msgQuickPaySms);


// #4 快捷支付发起(我方验证短信)
// $msgQuickPayInit = demoQuickPayment::quickPayInit();
// var_dump($msgQuickPayInit);

// #5 快捷支付提交(我方验证短信)
// $msgQuickPayCommit = demoQuickPayment::quickPayCommit($checkCode);
// var_dump($msgQuickPayCommit);

// #6 快捷支付(商户自验短信)
// $msg = demoQuickPayment::quickPay();
// var_dump($msg);
// # RPM00300 不符合短信验证码配置规则

// #7 快捷支付查询
// $msg = demoQuickPayment::payQuery();
// var_dump($msg);
// # IPS00008 请求返回内容验签失败

// #9 退款
// $msg = demoQuickPayment::refund();
// var_dump($msg);

// #10 退款查询
// $msg = demoQuickPayment::refundQuery();
// var_dump($msg);

// #11 查询支持绑卡的银行列表
// $msg = demoQuickPayment::bankListQuery();
// var_dump($msg);
// # IPS00008 请求返回内容验签失败

// #12 查询用户的绑卡信息
// $msg = demoQuickPayment::userCardList();
// var_dump($msg);
// # IPS00008 请求返回内容验签失败

// #13 商户查询银行卡的签约状态
// $msg = demoQuickPayment::bindStatus();
// var_dump($msg);

// #14 查询银行卡信息
// $msg = demoQuickPayment::cardDetail();
// var_dump($msg);

// #15 对账单下载
// $msg = demoQuickPayment::statementDailyQuery();
// var_dump($msg);
// # ["content"]=> "MHwwCg=="  ["status"]=> "S" 



