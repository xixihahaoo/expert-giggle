<?php
namespace jpp\service;

use jpp\constants\ApiConstants;
use jpp\lib\BaseService;

/**
 * 扫码相关服务类
 *
 * @package jpp\service\card
 */
class ScanService extends BaseService
{
    /**
     * 生成固码
     *
     * @param array $params
     * @return array
     */
    public static function createSolidCode($params = array())
    {
        /*
         * 返回内容:
           二维码内容 content String(512) BASE64加密的字节流 不可空
        */
        return parent::request(ApiConstants::SERVICE_SCAN_CREATE_SOLIC_CODE, $params);
    }

    /**
     * 生成订单活码
     *
     * @param array $params [orderId, amount]
     * @return array
     */
    public static function createOrderCode($params)
    {
        /*
         * 返回内容:
           支付订单号 payOrderId String(32) 支付订单号 不可空
           二维码内容 content String(512) BASE64加密的字节流 不可空
        */
        return parent::request(ApiConstants::SERVICE_SCAN_CREATE_ORDER_CODE, $params);
    }

    /**
     * 条码支付确认
     *
     * @param array $params [orderId, amount, scanCodeId, terminalId, offlineNotifyUrl, channelCd, corpOrg, goodsName, goodsDesc]
     * @return array
     */
    public static function payConfirmViaCodeBar($params)
    {
        /*
         * 返回内容:
            商户订单号 orderId String(32) 商户订单号 不可空
            支付订单号 payOrderId String(32) 支付订单号 不可空
            订单状态 orderSts String(8) 见附录1：订单状态
            会计日期 acDate String(32) 记账日期，格式YYYYMMDD 不可空
        */
        return parent::request(ApiConstants::SERVICE_SCAN_PAY_CONFIRM_VIA_CODE_BAR, $params);
    }

    /**
     * 活码/固码支付确认
     *
     * @param array $params [token, amount, payChannel, transType, orderId, goodsName, goodsDesc, terminalId, corpOrg, clientIP]
     * @return array
     */
    public static function payConfirm($params)
    {
        /*
         * 返回内容:
            订单状态 ordSts String 见附录1：订单状态 不可空
            订单号 ordNo String 九派订单号 不可空
            订单金额 amount String 单位分 不可空
        */
        return parent::request(ApiConstants::SERVICE_SCAN_PAY_CONFIRM, $params);
    }

    /**
     * 扫码订单撤销
     *
     * @param array $params [oriOrderId]
     * @return array
     */
    public static function payCancel($params)
    {
        /*
         * 返回内容:
            原支付订单号 oriOrderId String 原支付订单号 不可空
            撤销订单号 cancelOrderId String 撤销订单的订单号 可空
            原订单状态 orderSts String 原订单状态 可空
        */
        return parent::request(ApiConstants::SERVICE_SCAN_PAY_CANCEL, $params);
    }

}