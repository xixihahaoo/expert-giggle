<?php
namespace jpp\service;

use jpp\constants\ApiConstants;
use jpp\lib\BaseService;

/**
 * 代收相关服务
 *
 * @package jpp\service
 * @author
 */
class CollectionService extends BaseService
{
    /**
     * 商户调用该交易接口扣客户账(单笔代收)
     *
     * @param array $params [mcSequenceNo, mcTransDateTime, orderNo, accType, cardNo, accName, amount, crdType, lBnkNo, lBnkNam,
     *                       idType, idInfo, validPeriod, cvv2, cellPhone, remark, bnkRsv, capUse, reqReserved1, reqReserved2]
     * @return array
     */
    public static function singleCollection($params)
    {
        /*
         * 返回内容:
            商户交易流水 mcSequenceNo String(32) 商户上送的交易流水 不可空
            商户交易时间 mcTransDateTime String(14) 商户上送的交易时间 不可空
            订单号 orderNo String(64) 商户上送的订单号 不可空
            交易账号 cardNo String(100) 账户类型为0/1/2填写:银行卡号/ 存折/对公账号 账户类型为3填写:商户账户名 (银 行卡号des加密) 不可空
            交易金额 amount String(20) 单位:分 不可空
            保留域1 reqReserved1 String(60) 备用字段1 可空
            保留域2 reqReserved2 String(60) 备用字段1 可空
            返回交易日期 transDate String(8) YYYYMMDD 可空
            返回交易时间 transTime String(6)HHMMSS 可空
            商户流水号 bfbSequenceNo String(32) 商户内部订单号 不可空
            订单状态 orderSts VARCAHR2( 2) 订单状态(U 订单初始化, P 处理中, S 处理成功, F 处理失败)N 待人工处理 状态可能后期有改动
        */
        return parent::request(ApiConstants::SERVICE_SINGLE_COLLECT_FROM_CARD, $params);
    }

    /**
     * 商户调用该交易接口扣客户账(批量多笔代收)
     *
     * @param array $params [infoList, count, batchNo]
     * @return array
     */
    public static function batchCollection($params)
    {
        /*
         * 返回内容:
            批量代收异常数据列表 infoList String(512) 返回批量代收过程中异常数据或处理失败数据列表，此字段信息json形式存储。 可空
        */
        return parent::request(ApiConstants::SERVICE_BATCH_COLLECT_FROM_CARD, $params);
    }

    /**
     * 订单查询
     *
     * @param array $params [mcSequenceNo, mcTransDateTime, orderNo, amount, remark1, remark2]
     * @return array
     */
    public static function orderQuery($params)
    {
        /*
         * 返回内容:
            商户交易流水 mcSequenceNo String(32) 商户上送的交易流水 不可空
            商户交易时间 mcTransDateTime String(14) 商户上送的交易时间 不可空
            订单号 orderNo String(64) 商户上送的订单号 不可空
            原交易金额（单位：分） amount String(20) 单位：分 不可空
            订单状态 orderSts String(2) 订单状态 (S:成功, F:失败, P:处理中, R:退汇（代付）, N:待人工处理) 可空
            商户流水 bfbSequenceNo String(32) 商户返回 可空
            原交易金额(单位:分) amount String(20) 不可空
            返回交易时间 transTime String(6) 可空
            填充元素1 remark1 String(20) 原样返回 可空
            填充元素2 remark2 String(20) 原样返回 可空
            订单失败原因 ordmsg String(60） 可空
        */
        return parent::request(ApiConstants::SERVICE_ORDER_QUERY, $params);
    }

    /**
     * 批量多笔代收查询
     *
     * @param array $params [infoList, count, batchNo]
     * @return array
     */
    public static function batchCollectionQuery($params)
    {
        /*
         * 返回内容:
            批量代收异常数据列表 infoList String(512) 返回批量代收过程中异常数据或处理失败数据列表，此字段信息json形式存储。 可空
        */
        return parent::request(ApiConstants::SERVICE_ORDER_BATCH_QUERY, $params);
    }

    /**
     * 单笔代付
     *
     * @param array $params [mcSequenceNo, mcTransDateTime, orderNo, amount, cardNo, accName, accType, lBnkNo, lBnkNam,
     *                      crdType, validPeriod, cvv2, cellPhone, remark, bnkRsv, capUse, callBackUrl, remark1, remark2, remark3]
     * @return array
     */
    public static function singleTransfer($params)
    {
        /*
         * 返回内容:
            商户交易流水 mcSequenceNo String(32) 商户上送的交易流水 不可空
            商户交易时间 mcTransDateTime String(14) 商户上送的交易时间 不可空
            订单号 orderNo String(64) 商户上送的订单号 不可空
            交易金额 amount String(20) 单位：分 不可空
            交易账号 cardNo String(32) 账户类型为0/2填写：银行卡号/对公账号(目前只支持0) (银行卡号des加密) 不可空
            订单状态 orderSts String(2) 订单状态 U订单初始化 P处理中 S处理成功 F处理失败 R退汇 N待人工处理 可空
            返回交易日期 transDate String(8) 可空
            返回交易时间 transTime String(6) 可空
            填充元素1 remark1 String(20) 原样返回 可空
            填充元素2 remark2 String(20) 原样返回 可空
            填充元素3 remark3 String(100) 原样返回 可空
            商户流水号 bfbSequenceNo String(32) 不可空
        */
        return parent::request(ApiConstants::SERVICE_SINGLE_TRANSFER, $params);
    }

    /**
     * 批量多笔代付
     *
     * @param array $params [infoList, count, batchNo]
     * @return array
     */
    public static function batchTransfer($params)
    {
        /*
         * 返回内容:
            批量代收异常数据列表 infoList String(512) 返回批量代收过程中异常数据或处理失败数据列表，此字段信息json形式存储。 可空
        */
        return parent::request(ApiConstants::SERVICE_BATCH_TRANS_TO_CARD, $params);
    }

    /**
     * 查询账户余额
     *
     * @param array $params 入参为空，账户余额查询接口为商户主动发起的请求，除公共报文体之外无其 它请求参数。
     * @return array
     */
    public static function merchantAccountQuery($params)
    {
        return parent::request(ApiConstants::SERVICE_MECHANT_ACCOUNT_QUERY, $params);
    }
    
}