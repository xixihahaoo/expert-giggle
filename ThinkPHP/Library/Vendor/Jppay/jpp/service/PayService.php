<?php
namespace jpp\service;

use jpp\constants\ApiConstants;
use jpp\lib\BaseService;

/**
 * 支付相关服务
 *
 * @package jpp\service
 * @author
 */
class PayService extends BaseService
{
    /**
     * 快捷支付初始化(九派支付方验证短信)
     *
     * @param array $params [memberId, orderId, contractId, payType, amount, currency, orderTime, clientIP, validUnit, validNum, goodsName, goodsDesc, offlineNotifyUrl]
     * @return array
     */
    public static function quickPayInit($params)
    {
        /*
         * 返回内容:
           商户订单号 orderId String(32) 商户上送订单号 不可空
           支付订单号 payOrderId String(32) 支付订单号 不可空
           会计日期 acDate String(8) 记账日期，格式YYYYMMDD 不可空
        */
        return parent::request(ApiConstants::SERVICE_PAY_INIT, $params);
    }

    /**
     * 快捷支付提交(九派支付方验证短信)
     *
     * @param array $params [memberId, orderId, contractId, payType, amount, currency, orderTime, clientIP, validUnit, validNum, goodsName, goodsDesc, offlineNotifyUrl]
     * @return array
     */
    public static function quickPayCommit($params)
    {
        /*
         * 返回内容:
           商户订单号 orderId String(32) 商户上送订单号 不可空
           订单状态 orderSts String(8) （WP: 等待付款，PP: 支付中，PD: 支付完成） 不可空
           支付订单号 payOrderId String(32) 支付订单号 不可空
           会计日期 acDate String(8) 记账日期，格式YYYYMMDD 不可空
        */
        return parent::request(ApiConstants::SERVICE_PAY_COMMIT, $params);
    }

    /**
     * 快捷支付提交(商户自验短信)
     *
     * @param array $params [memberId, orderId, contractId, payType, amount, currency, orderTime, clientIP, validUnit, validNum, goodsName, goodsDesc, offlineNotifyUrl]
     * @return array
     */
    public static function quickPay($params)
    {
        /*
         * 返回内容:
           商户订单号 orderId String(32) 商户上送订单号 不可空
           订单状态 orderSts String(8) （WP: 等待付款，PP: 支付中，PD: 支付完成） 不可空
           支付订单号 payOrderId String(32) 支付订单号 不可空
           会计日期 acDate String(8) 记账日期，格式YYYYMMDD 不可空
        */
        return parent::request(ApiConstants::SERVICE_SMS_SEND_SELF_CHECK, $params);
    }

    /**
     * 快捷支付查询
     *
     * @param array $params [orderId]
     * @return array
     */
    public static function payQuery($params)
    {
        /*
         * 返回内容:
            用户ID memberId String(32) 商户生成的用户ID 不可空
            商户订单号 orderId String(32) 商户上送订单号 不可空
            支付金额 amount String(11) 以分为单位 不可空
            交易时间 orderTime String(14) 格式YYYYMMDDHHmmss 不可空
            支付结果 payResult String(10) 见附录1：订单状态 不可空
            支付银行 bankAbbr String(8) 见附录3：银行缩写 可空
            支付时间 payTime String(14) 格式YYYYMMDDHHmmss 不可空 支付订单号 payOrderId String(32) 支付订单号 不可空
            会计日期 acDate String(8) 记账日期，格式YYYYMMDD 不可空
            费用 fee Number(10) 以分为单位（支付成功才有值） 可空
        */
        return parent::request(ApiConstants::SERVICE_PAY_QUERY, $params);
    }

    /**
     * 退款
     *
     * @param array $params [refundAmount, oriOrderId, orderId]
     * @return array
     */
    public static function refund($params)
    {
        /*
         * 返回内容:
            退款金额 refundAmount String(11) 退款的金额，以分为单位 不可空
            商户订单号 orderId String(32) 商户上送的退款订单号 不可空
            退款状态 orderSts String(8) 见附录2：退款状态 不可空
        */
        return parent::request(ApiConstants::SERVICE_PAY_REFUND_COMMIT, $params);
    }

    /**
     * 退款查询
     *
     * @param array $params [oriOrderId, orderId]
     * @return array
     */
    public static function refundQuery($params)
    {
        /*
         * 返回内容:
            退款金额 refundAmount String(11) 退款的金额，以分为单位 不可空
            商户订单号 orderId String(32) 商户上送的退款订单号 不可空
            退款状态 orderSts String(8) 见附录2：退款状态 不可空
        */
        return parent::request(ApiConstants::SERVICE_PAY_REFUND_QUERY, $params);
    }

    /**
     * 网银支付
     * 用户在商户页面进行支付时，从商户网站选择要支付的银行，选择银行后通过九派支付服务跳到银行页面进行实际付款。
     *
     * @param array $params []
     * @return 会跳转到银行网银页面，需通过页面来访问，支付成功后会通过页面重定
 向方式返回商户指定页面，同时后台异步点对点通知到商户服务器。
     */
    public static function bankPayment($params = array())
    {
        /*
         * 返回内容:
           二维码内容 content String(512) BASE64加密的字节流 不可空
        */
        return parent::request(ApiConstants::SERVICE_PAY_B2C_OR_B2B, $params);
    }
}