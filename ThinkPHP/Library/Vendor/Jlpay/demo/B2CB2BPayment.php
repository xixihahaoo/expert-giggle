<?php
// require '../JppSdk.php';
// require '../UtilHelper.php';
include_once(dirname(__FILE__).'../../JppSdk.php');
include_once(dirname(__FILE__).'../../UtilHelper.php');

class demoB2CB2BPayment {
    /**
     * B2B/B2C5.1 网银支付
     * 请求类型:rpmBankPayment(即公共请求报文字段service的值)
     用户在商户页面进行支付时，从商户网站选择要支付的银行，选择银行后通过九派支付服务跳到银行页面进行实际付款。
     */
    public static function bankPayment() {
        // $notifyUrl = UtilHelper::desEncode('http://127.0.0.1/notifyUrl');
        $notifyUrl = 'http://127.0.0.1/notifyUrl';
        $params = [
            'pageReturnUrl' => 'http://127.0.0.1',   //页面返回地址,String(100),页面重定向URL支付结果同步返回到该url，该url由商户提供
            'notifyUrl' => $notifyUrl,  //后台通知地址,String(100),后台异步通知URL，交易结果 通过后台通知到此url，为确保安全该字段支持 (DES加密，ECB模式)
            'merchantName' => '煦尔工作室小卖铺',
            'memberId' => '123456789',
            'orderTime' => '20170820172200',  //订单提交时间，格式YYYYMMDDHHmmss
            'orderId' => '20170820170500_778', 
            'totalAmount' => '3565',    //订单金额，以分为单位，￥35.65，只能传整数
            'currency' => 'CNY',
            'bankAbbr' => 'ICBC',    //银行简称
            'cardType' => '0',  //卡类型，0:借记卡 1:贷记卡
            'payType' => 'B2C', //B2C/B2B
            'validNum' => '3',  //订单有效期数量
            'validUnit' => '01',    //订单有效期单位 Number(2) 只能取以下枚举值 00-分 01-小时 02-日 03-月
            'showUrl' => 'http://127.0.0.1/goods/item_11.html', //商品展示地址
            'goodsName' => '巧克力圣代冰激凌蛋糕',
            'goodsId' => 'SURECC_ITEM_11',
            'goodsDesc' => '商品描述：暂无',
        ];

        $ret = JppSdk::bankPayment($params);
        return $ret; 
    }

    /**
     * B2B/B2C5.2 支付结果查询
     * 请求类型:rpmPayQuery(即公共请求报文字段service的值)
     用户支付完成后，商户可根据需要实时查询订单支付结果
     */
    
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
     * B2B/B2C5.3 异步通知
     * 请求类型:rpmAsyncNotify(即公共请求报文字段service的值)
     */
    public static function rpmAsyncNotify() {
    }

    /**
     * B2B/B2C5.4 支付结果同步通知
     * 请求类型:rpmSynchroNotify(即公共请求报文字段service的值)
     */
    public static function rpmSynchroNotify() {
    }

    /**
     * B2B/B2C5.5 对账单下载
     * 请求类型:rpmStatement(即公共请求报文字段service的值)
     */
    
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

#1.网银支付
//$msg = demoB2CB2BPayment::bankPayment();
# IPS00008 "请求返回内容验签失败"


#2 支付结果查询
#3 异步通知
#4 支付结果同步通知
#5 对账单下载


//var_dump($msg);