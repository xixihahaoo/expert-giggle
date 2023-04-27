<?php
include_once '../JppSdk.php';
include_once '../UtilHelper.php';
include_once './QuickPayment.php';

class demoQRCodePayment {
    /**
     * 扫码支付5.1 生成固码
     * 请求类型:rpmBindCard(即公共请求报文字段service的值)
     rsp:
     默认返回为BASE64加密的二维码 图片字节流 qrType值为1时为二维码地址字 节流
     */
    public static function qrCodeGenerateByMerchant() {
        $params = [
            'qrType' => '1',    //返回值类型 String（2）默认为空或其它时，返回二维码; 参数值”1”时，返回URL
        ];

        $ret = JppSdk::scanCreateSolidCode($params);
        return $ret; 
    }

    /**
     * 扫码支付5.2 生成活码
     * 请求类型:rpmBindCard(即公共请求报文字段service的值)
     rsp:
     默认返回为BASE64加密的二维码 图片字节流 qrType值为1时为二维码地址字 节流
     */
    public static function qrCodeGenerateByOrder() {
        $params = [
            'orderId' => '20170820160500_777',
            'amount' => '3656', //单位分，如36元5角6分传递 3656
            'goodsName' => '巧克力圣代冰激凌蛋糕',
            'goodsDesc' => '商品描述：暂无',
            'offlineNotifyUrl' => 'http://127.0.0.1',   //异步通知url 可空-不填的话不通知; 建议DES加密
            'qrType' => '1',    //返回值类型 String（2）默认为空或其它时，返回二维码; 参数值”1”时，返回URL
        ];

        $ret = JppSdk::scanCreateOrderCode($params);
        return $ret; 
    }

    /**
     * 扫码支付5.3 条码支付确认
     请求类型:barCodePayMent
     */
    public static function scanPayConfirmViaCodeBar() {
        $params = [
            'amount' => '3656', //单位分，如36元5角6分传递 3656
            'scanCodeId' => 'aHR0cDovL3N0YWJsZS5qaXVwYWlwYXkuY29tOjgwL2NwL3FyY29kZS9oNS9pbmRleC5odG1sP21lcmNoYW50SWQ9ODAwMDAwMTAxMDAwMDkw', //扫码号，客户端软件中展示的条码值,扫 码设备扫描获取
            'orderId' => '20170820160500_777',
            'terminalId' => 'DEVICE-CC-TMLID_SURECC',   //终端号，要求不同终端此号码不一样
            'offlineNotifyUrl' => 'http://127.0.0.1',   //异步通知url 可空-不填的话不通知; 建议DES加密
            'channelCd' => 'WXP',  //支付渠道,目前仅支持微信支付和支付宝， WXP:微信 支付，ALP: 支付宝
            'corpOrg' => 'WXP', //资金合作机构,目前仅支持微信支付和支付宝， WXP:微信 支付，ALP: 支付宝
            'goodsName' => '巧克力圣代冰激凌蛋糕',
            'goodsDesc' => '商品描述：暂无',
        ];

        $ret = JppSdk::scanPayConfirmViaCodeBar($params);
        return $ret; 
    }

    /**
     * 扫码支付5.4 活码/固码支付确认
     */
    public static function scanPayConfirm() {
        // $clientIP = UtilHelper::getClientIP();
        $clientIP = '192.168.7.7';
        $params = [
            'token' => '',  //令牌，校验交易的有效性
            'amount' => '3656', //单位分，如36元5角6分传递 3656
            'payChannel' => 'WXP',  //支付渠道,目前仅支持微信支付和支付宝， WXP:微信 支付，ALP: 支付宝
            'transType' => '0', //0:固码;1:活码
            'orderId' => '',    //活码支付必传
            'goodsName' => '巧克力圣代冰激凌蛋糕',
            'goodsDesc' => '商品描述：暂无',
            'terminalId' => 'DEVICE-CC-TMLID_SURECC',   //终端号，要求不同终端此号码不一样
            'corpOrg' => 'WXP', //资金合作机构,目前仅支持微信支付和支付宝， WXP:微信 支付，ALP: 支付宝
            'clientIP' => $clientIP,
        ];

        $ret = JppSdk::scanPayConfirm($params);
        return $ret; 
    }

    /**
     * 扫码支付5.5 订单查询
    请求类型:rpmPayQuery
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
     * 扫码支付5.6 退款
     */
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
     * 扫码支付5.7 退款查询
     */
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
     * 扫码支付5.8 订单撤销
     请求类型:qrCodePayCancel
     */
    public static function qrCodePayCancel() {
        $params = [
            'oriOrderId' => '20170820160500_777',
        ];

        $ret = JppSdk::scanPayCancel($params);
        return $ret; 
    }

    /**
     * 扫码支付5.9 对账单下载
     描述:九派支付平台每天凌晨会定时生成对账单供商户下载。
     对账单内容: 描述:对账单内容由头信息与交易明细信息组成。文件只包含成功的交易，金额以“分” 为单位，每行字段用“|”分隔，每行的最后有换行符是“\n”，没有回车符“\r”， 文件明细后面没有空行或者文件终结符。
     1. 支付交易的对账单内容格式:
     头信息:“HEAD:成功订单笔数|成功订单金额|”
     交易明细:“订单日期|订单支付类型|订单时间|商户订单编号|支付方式|订单状态|订单 金额|服务费|”
        订单支付类型:PAY_TYP
        支付方式:PAY_CAP_MOD
        订单状态:BD-交易成功
    文件内容示例:
        2|50100|
        20170320|1|210638|ZL20170320203637340387|1|BD|100|0|
        20170321|1|115337|ZL20170321112335746734|1|BD|50000|0|
    2. 退款交易的对账单内容格式:
    头信息:“HEAD:成功退款订单笔数|成功退款订单金额”
    明细格式:“退款日期|退款时间|原商户订单号|退款状态|退款金额|退款订单号|”
        退款状态:RFD_STS
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

    /**
     * 扫码支付5.10 异步通知
     * 功能描述:支付网关通知商户支付和退款的接口
     */


}



// test 
$merchantId = '800000101000090';
$memberId = '123456789';
$phone = '18609098987';
$contractId = '201708200000020512';
$checkCode = '384923';  //九派支付验证短信，用户收到九派支付的短信验证码



// #1 生成固码
// $msg = demoQRCodePayment::qrCodeGenerateByMerchant();
// var_dump($msg);
// #   ["content"]=> string(108) "aHR0cDovL3N0YWJsZS5qaXVwYWlwYXkuY29tOjgwL2NwL3FyY29kZS9oNS9pbmRleC5odG1sP21lcmNoYW50SWQ9ODAwMDAwMTAxMDAwMDkw"

// #2 生成活码
// $msg = demoQRCodePayment::qrCodeGenerateByOrder();
// var_dump($msg);
// #IPS00002  "系统处理失败"

// #3 条码支付确认
// $msg = demoQRCodePayment::scanPayConfirmViaCodeBar();

#4 活码/固码支付确认
// $msg = demoQRCodePayment::scanPayConfirm();

#5 订单查询
#6 退款
#7 退款查询
// #8 订单撤销
// $msg = demoQRCodePayment::qrCodePayCancel();

#9 对账单下载
#10 异步通知

var_dump($msg);