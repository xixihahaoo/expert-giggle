<?php
require '../JppSdk.php';
require '../UtilHelper.php';

class demoCollectingPayment {
    /**
     * 代收付5.1 代收
     * 请求类型:capSingleCollection(即公共请求报文字段service的值)
     */
    public static function singleCollection() {
        $idNo = UtilHelper::desEncode('350783199005069067');
        $cardNo = UtilHelper::desEncode('6225880175058792');
        $params = [
            'mcSequenceNo' => '20170820174500_777_111',   //商户交易流水,通讯会话流水号，对于同一个订单号的情况不同流水号区分
            'mcTransDateTime' => '20170820174500',    //商户交易时间，日期格式:YYYYMMDDHHMISS
            'orderNo' => '20170820174500_777',    //订单号，备注:商户号+订单号能确定唯 一性 最小支持8位
            'accType' => '0',    //账户类型，0:卡(目前只支持) 1:折2:对公账号 3:商户账户
            'cardNo' => $cardNo, //交易账号，账户类型为0/1/2填写:银行卡号/存折/对公账号 账户类型为3填写:商户账户名 (银行卡号需要DES加密，ECB模式)
            'accName' => '平代卉',    //账户类型为0/1/2填写:银行账户户名，账户类型为3填写:商户账户户名
            'amount' => '10000', //单位分
            'crdType' => '00',  //00 借记卡(只支持)
            'lBnkNo' => '', //开户行行号 (付款人),开户行行别(部分渠道需要),可空
            'lBnkNam' => '',    //开户行名称 (付款人),开户行行名,可空
            'idType' => '00',   //00 身份证(只支持)
            'idInfo' => $idNo,  //证件号码,身份证号(DES加密，ECB模式)
            'validPeriod' => '',    //如果是信用卡，该字段笔必输 格式:YYMM,可空
            'cvv2' => '',   //如果是信用卡，该字段笔必输,可空
            'cellPhone' => '',
            'remark' => '', 
            'bnkRsv' => '',
            'cvv2' => '',
            'reqReserved1' => '',
            'reqReserved2' => '',
        ];

        $ret = JppSdk::singleCollection($params);
        return $ret; 
    }

    /**
     * 代收付5.2 代付
     * 请求类型:capSingleTransfer(即公共请求报文字段service的值)
     */
    public static function singleTransfer() {
        $cardNo = UtilHelper::desEncode('6225880175058792');

        $params = [
            'mcSequenceNo' => '20170820174500_777',   //通讯会话流水号，对于同一个订 单号的情况不同流水号区分，有 效长度5-32
            'mcTransDateTime' => '20170820174500',    //长度为14位，日期格式: YYYYMMDDHHMISS
            'orderNo' => '20170820174500_777',    //订单号，备注:商户号+订单号能确定唯 一性 最小支持8位
            'amount' => '10000', //单位分
            'cardNo' => $cardNo, //交易账号，账户类型为0/1/2填写:银行卡号/存折/对公账号 账户类型为3填写:商户账户名 (银行卡号需要DES加密，ECB模式)
            'accName' => '平代卉',    //账户类型为0/1/2填写:银行账户户名，账户类型为3填写:商户账户户名
            'accType' => '0',    //账户类型，0:卡(目前只支持) 1:折2:对公账号 3:商户账户
            'lBnkNo' => '', //开户行行号 (付款人),开户行行别(部分渠道需要),可空
            'lBnkNam' => '',    //开户行名称 (付款人),开户行行名,可空
            'crdType' => '00',  //00 借记卡(只支持)
            'validPeriod' => '',    //如果是信用卡，该字段笔必输 格式:YYMM,可空
            'cvv2' => '',   //如果是信用卡，该字段笔必输,可空
            'cellPhone' => '',
            'remark' => '', 
            'bnkRsv' => '',
            'capUse' => '00', //资金用途，目前只支持非实时结算 默认00
            'callBackUrl' => 'http://127.0.0.1/callback/',  //异步回调通知地址
            'remark1' => '',
            'remark2' => '',
            'remark3' => '',
        ];

        $ret = JppSdk::singleTransfer($params);
        return $ret; 
    }

    /**
     * 代收付5.3 订单查询
     * 请求类型:capOrderQuery(即公共请求报文字段service的值)
     */
    public static function orderQuery() {
        $params = [
            'mcSequenceNo' => '20170820174500_777_111',
            'mcTransDateTime' => '20170820174500',
            'orderNo' => '20170820174500_777',
            'amount' => '10000',
            'remark1' => '',
            'remark2' => '',
        ];

        $ret = JppSdk::orderQuery($params);
        return $ret; 
    }

    /**
     * 代收付5.4 代收付异步通知
     * 九派支付接受商户支付请求并处理成功后，为确保交易结果能够及时通知到商户，除实时接口响应外，九派支付还会增加后台异步通知到商户指定的服务器地址（offlineNotifyUrl），异步通知24小时内最多通知8次，每次通知后间隔时间递增（0m~2m~5m~10m~1h~2h~6h~15h），期间只要有一次收到商户响应接收成功（result=SUCCESS），则该笔订单结果通知结束。
     * 通知类型是九派支付主动发起的请求，没有公共报文头定义。
     */

    /**
     * 代收付5.5 批量代收
     * 请求类型:capBatchCollection(即公共请求报文字段service的值)
     */
    public static function batchCollection() {
        $mcs_1 = [
            'mcSequenceNo' => '20170820174500_777_111',   //商户交易流水,通讯会话流水号，对于同一个订单号的情况不同流水号区分
            'mcTransDateTime' => '20170820174500',    //商户交易时间，日期格式:YYYYMMDDHHMISS
            'orderNo' => '20170820174500_777',    //订单号，备注:商户号+订单号能确定唯 一性 最小支持8位
            'accType' => '0',    //账户类型，0:卡(目前只支持) 1:折2:对公账号 3:商户账户
            'cardNo' => $cardNo, //交易账号，账户类型为0/1/2填写:银行卡号/存折/对公账号 账户类型为3填写:商户账户名 (银行卡号需要DES加密，ECB模式)
            'accName' => '平代卉',    //账户类型为0/1/2填写:银行账户户名，账户类型为3填写:商户账户户名
            'amount' => '10000', //单位分
            'crdType' => '00',  //00 借记卡(只支持)
            'lBnkNo' => '', //开户行行号 (付款人),开户行行别(部分渠道需要),可空
            'lBnkNam' => '',    //开户行名称 (付款人),开户行行名,可空
            'idType' => '00',   //00 身份证(只支持)
            'idInfo' => $idNo,  //证件号码,身份证号(DES加密，ECB模式)
            'validPeriod' => '',    //如果是信用卡，该字段笔必输 格式:YYMM,可空
            'cvv2' => '',   //如果是信用卡，该字段笔必输,可空
            'cellPhone' => '',
            'remark' => '', 
            'bnkRsv' => '',
            'cvv2' => '',
            'reqReserved1' => '',
            'reqReserved2' => '',
        ];
        $infoList = json_encode($mcs_1);
        $params = [
            'infoList' => $infoList,    //存储批量代收批量数据的列表信息，此字段信息json形式存 储。
            'count' => '1',    //infoList中需做代收处理的条 数，(不可超过200条);
            'batchNo' => '123',  //确保统一商户唯一
        ];

        $ret = JppSdk::batchCollection($params);
        return $ret; 
    }

    /**
     * 代收付5.6 批量代付
     * 请求类型:capBatchCollection(即公共请求报文字段service的值)
     根据日期等条件获取查询日期的订单信息情况。
     */
    public static function batchTransfer() {
        $mcs_1 = [
            'mcSequenceNo' => '20170820174500_777_111',   //商户交易流水,通讯会话流水号，对于同一个订单号的情况不同流水号区分
            'mcTransDateTime' => '20170820174500',    //商户交易时间，日期格式:YYYYMMDDHHMISS
            'orderNo' => '20170820174500_777',    //订单号，备注:商户号+订单号能确定唯 一性 最小支持8位
            'accType' => '0',    //账户类型，0:卡(目前只支持) 1:折2:对公账号 3:商户账户
            'cardNo' => $cardNo, //交易账号，账户类型为0/1/2填写:银行卡号/存折/对公账号 账户类型为3填写:商户账户名 (银行卡号需要DES加密，ECB模式)
            'accName' => '平代卉',    //账户类型为0/1/2填写:银行账户户名，账户类型为3填写:商户账户户名
            'amount' => '10000', //单位分
            'crdType' => '00',  //00 借记卡(只支持)
            'lBnkNo' => '', //开户行行号 (付款人),开户行行别(部分渠道需要),可空
            'lBnkNam' => '',    //开户行名称 (付款人),开户行行名,可空
            'idType' => '00',   //00 身份证(只支持)
            'idInfo' => $idNo,  //证件号码,身份证号(DES加密，ECB模式)
            'validPeriod' => '',    //如果是信用卡，该字段笔必输 格式:YYMM,可空
            'cvv2' => '',   //如果是信用卡，该字段笔必输,可空
            'cellPhone' => '',
            'remark' => '', 
            'bnkRsv' => '',
            'cvv2' => '',
            'reqReserved1' => '',
            'reqReserved2' => '',
        ];
        $infoList = json_encode($mcs_1);
        $params = [
            'infoList' => $infoList,    //存储批量代收批量数据的列表信息，此字段信息json形式存 储。
            'count' => '1',    //infoList中需做代收处理的条 数，(不可超过200条);
            'batchNo' => '456',  //确保统一商户唯一
        ];

        $ret = JppSdk::batchTransfer($params);
        return $ret; 
    }

    /**
     * 代收付5.7 批量代收付查询
     * 请求类型:capBatchQuery(即公共请求报文字段service的值)
     */
    public static function batchCollectionQuery() {
        $params = [
            'batchNo' => '456', 
            'ordSts' => '', //订单状态，U0:预下单;P0:处理中;S0:可空处理成功;F0:处理失败，不传就为全部。
            'pageSize' => '3',
            'pageNo' => '1',
        ];

        $ret = JppSdk::batchCollectionQuery($params);
        return $ret; 
    }

    /**
     * 代收付5.8 查询账户余额
     * 请求类型:merchantAccountQuery(即公共请求报文字段service的值)
     商户可根据商户号等条件调用此接口查询账户余额信息情况
     账户余额查询接口为商户主动发起的请求，除公共报文体之外无其它请求参数
     */
    public static function merchantAccountQuery() {
        $params = [];
        $ret = JppSdk::merchantAccountQuery($params);
        return $ret; 
    }

    /**
     * 代收付5.9 对账单查询
     * 请求类型:capStatementQuery(即公共请求报文字段service的值)
     */
    public static function capStatementQuery() {
        $params = [
            'txnDate' => '20170816',    //YYYYMMDD
            'checkTyp' => '00', //00:单笔(默认) 
            'txTyp' => '00',    //交易类型，00:全部 01:从银行卡代收 02:代付到银行卡
            'curPag' => '1',  //当前请求页,起始
            'pageNum' => '10', //每页数据量，默认 10 (根据具体情况调整)
            'reqReserved' => '', //保留域，商户自定义保留域，交易应答时 会原样返回
        ];

        $ret = JppSdk::capStatementQuery($params);
        return $ret; 
    }

    /**
     * 代收付5.10 对账单下载
     * 请求类型:capStatementFileDown(即公共请求报文字段service的值)
     */
    public static function capStatementFileDown() {
        $params = [
            'acDate' => '20170816', //YYYYMMDD
            'type' => 'cap', //类型，枚举类型: cap: 代收付
        ];

        $ret = JppSdk::statementDownload($params);
        return $ret; 
    }


}



// test 

// #1 
// $msg = demoCollectingPayment::singleCollection();
// #IPS00006 "数据格式错误"

// #2 
// $msg = demoCollectingPayment::singleTransfer();
// #IPS00006 "数据格式错误"

// #3
// $msg = demoCollectingPayment::orderQuery();
// #IPS00006 "数据格式错误"

// #5
// $msg = demoCollectingPayment::batchCollection();
// # CAP00528 CAP00528参数解析异常

// #6
// $msg = demoCollectingPayment::batchTransfer();
// # CAP00528 CAP00528参数解析异常

// #7
// $msg = demoCollectingPayment::batchCollectionQuery();
// #CAP00520  "数据为空"

// #8 
// $msg = demoCollectingPayment::merchantAccountQuery();
#   ["cashAccountBalance"]=> "27.55"

// #9
// $msg = demoCollectingPayment::capStatementQuery();
// #IPS00002 "系统处理失败"

#10 
$msg = demoCollectingPayment::capStatementFileDown();
#IPS00000 对账文件尚未生成





var_dump($msg);