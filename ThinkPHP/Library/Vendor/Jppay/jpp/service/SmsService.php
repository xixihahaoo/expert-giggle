<?php
namespace jpp\service;

use jpp\constants\ApiConstants;
use jpp\lib\BaseService;

/**
 * 短信发送服务类
 *
 * @package jpp\service\card
 */
class SmsService extends BaseService
{
    /**
     * 快捷支付短信下发／重发
     *
     * @param array $params [contractId, memberId]
     * @return array
     */
    public static function sendText($params)
    {
        /*
         * 返回内容:
           手机号 phone String(11) 下发短信使用的手机号
        */
        return parent::request(ApiConstants::SERVICE_SMS_SEND, $params);
    }
}