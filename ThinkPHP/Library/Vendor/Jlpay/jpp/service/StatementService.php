<?php
namespace jpp\service;

use jpp\constants\ApiConstants;
use jpp\lib\BaseService;

/**
 * 结算相关服务
 *
 * @package jpp\service
 * @author
 */
class StatementService extends BaseService
{
    /**
     * 快捷支付对账单下载(九派支付平台每天凌晨会定时生成对账单供商户下载)
     *
     * @param array $params [acDate, type]
     * @return array
     */
    public static function statementDailyQuery($params)
    {
        /*
         * 返回内容:
            状态 status String(8) (对账单下载状态，枚举类型：S：下载成功, F：下载失败, P：对账单尚未生成) 不可空
            对账单内容 content String 对账单内容，base64编码 可空
        */
        return parent::request(ApiConstants::SERVICE_STATEMENT_DAILY, $params);
    }

    /**
     * 对账单查询
     *
     * @param array $params [txnDate, checkTyp, txTyp, curPag, pageNum, reqReserved]
     * @return array
     */
    public static function statementQuery($params)
    {
        /*
         * 返回内容:
            成功总笔数 succQty String(4) 成功总笔数 不可空
            成功总金额 succAmt Number 成功总金额 不可空
            当前页 curPag Number 当前页 不可空
            每页条数 pageNum Number 每页条数 不可空
            保留域 reqReserved String(256) 原样返回 可空
            文件内容 fileContent 每一行的格式类型为”订单号|交易账号|交易金额(单位:分)|交易类型|订单状态” 最后全部数据base64加密 可空
        */
        return parent::request(ApiConstants::SERVICE_STATEMENT_QUERY, $params);
    }

    /**
     * 对账单查询
     *
     * @param array $params [acDate, type]
     * @return array
     */
    public static function statementDownload($params)
    {
        /*
         * 返回内容:
            状态 status String(8) 对账单下载状态，(枚举类型：S：下载成功, F：下载失败, P：对账单尚未生成) 不可空
            对账单内容 content String 对账单内容，base64编码 可空
        */
        return parent::request(ApiConstants::SERVICE_STATEMENT_FILE_DOWNLOAD, $params);
    }

        /**
     * 对账单查询
     *
     * @param array $params 
     * @return array
     */
    public static function capStatementQuery($params)
    {
        return parent::request(ApiConstants::SERVICE_STATEMENT_QUERY, $params);
    }
}