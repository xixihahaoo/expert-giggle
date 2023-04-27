<?php
namespace jpp\service;

use jpp\constants\ApiConstants;
use jpp\lib\BaseService;

/**
 * 卡相关服务类
 *
 * @package jpp\service\card
 */
class CardService extends BaseService
{
    /**
     * 快捷绑定
     *
     * @param array $params [memberId, orderId, idType, idNo, userName, phone, cardNo, cardType, expireDate, cvn2]
     * @return array
     */
    public static function bind($params)
    {
        /*
         * 返回内容:
           协议号 contractId String(32) 返回绑卡协议号
           商户订单号 orderId String(32) 商户订单号
           银行名称 bankName String(120) 返回银行名称，例如：中国银行
           银行缩写 bankAbbr String(20) 见附录3：银行缩写
           卡类型 cardType String(2) 0.储蓄卡，1.信用卡
           消息扩展 extension String 如银行卡卡级别等，扩展字段在接入时由双方协商定义消息内容
        */
        return parent::request(ApiConstants::SERVICE_CARD_BIND, $params);
    }

    /**
     * 快捷绑定
     *
     * @param array $params [contractId, memberId]
     * @return array
     */
    public static function unbind($params)
    {
        /*
         * 返回内容:
           商户ID memberId String(32) 商户生成的用户ID
        */
        return parent::request(ApiConstants::SERVICE_CARD_UNBIND, $params);
    }

    /**
     * 查询支持绑卡的银行列表
     *
     * @param array $params
     * @return array
     */
    public static function supportBindList($params = array())
    {
        /*
         * 返回内容:
            储蓄卡银行列表 bankList String (Json 数据:bankName: 银行名称, bankAbbr: 银行缩写) 不可空
            信用卡银行列表 creditBankList String (Json 数据:bankName:  银行名称,bankAbbr:   银行缩写) 不可空
        */
        return parent::request(ApiConstants::SERVICE_CARD_SUPPORT_BIND_LIST, $params);
    }

    /**
     * 查询用户绑定的银卡列表
     *
     * @param array $params [memberId]
     * @return array
     */
    public static function userCardList($params = array())
    {
        /*
         * 返回内容:
            用户ID memberId String(32) 商户生成的用户ID 不可空
            用户银行卡列表 cardList String（Json 数据:
                bankName: 银行名称,
                bankAbbr:   银行缩写,
                bankMobileNo:银行预留手机号,
                cardNo: 卡号 (DES加密),
                cardType: 卡类型,
                contractId: 绑卡协议号）
                不可空
        */
        return parent::request(ApiConstants::SERVICE_CARD_USER_BINDED_LIST, $params);
    }

    /**
     * 商户查询银行卡的签约状态
     *
     * @param array $params [cardNo, merchantId, memberId]
     * @return array
     */
    public static function bindStatus($params = array())
    {
        /*
         * 返回内容:
            签约状态 hasSign String(1) (0:未签约, 1: 已签约) 不可空
            协议号 contractId String(32) 返回绑卡协议号 可空
        */
        return parent::request(ApiConstants::SERVICE_CARD_BIND_STATUS, $params);
    }

    /**
     * 查询银行卡信息
     *
     * @param array $params [cardNo:银行卡号(DES加密)]
     * @return array
     */
    public static function cardDetail($params = array())
    {
        /*
         * 返回内容:
            银行卡号 cardNo String(60) 银行卡号(DES加密) 不可空
            卡类型 cardType String(2) 0.储蓄卡，1.信用卡 不可空
            银行名称 bankName String(120) 返回银行名称，例如：中国银行 不可空
            银行缩写 bankAbbr String(20) 见附录3：银行缩写 不可空
        */
        return parent::request(ApiConstants::SERVICE_CARD_DETAIL, $params);
    }

    /**
     * 快捷绑卡验证短信
     *
     * @param array $params
     * @return array
     */
    public static function rpmBindCardCommit($params = array())
    {
        /*
         * 返回内容:
        协议号 contractId String(32) 返回绑卡协议号 不可空
        卡状态 cardSts String 0.生效 1.无效 2.删除 3.短信待验证 可空
        */
        return parent::request(ApiConstants::SERVICE_CARD_COMMIT, $params);
    }
}