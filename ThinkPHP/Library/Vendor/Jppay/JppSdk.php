<?php
// SDK所使用的PHP版本不能低于5.5
if (version_compare(PHP_VERSION, '5.5') < 0) {
    throw new \Exception("jpp sdk php version must be >= 5.5");
}

class JppAutoloader
{
    /**
     * 自动载入
     *
     * @param string $className
     * @return void
     * @throws Exception
     */
    public static function autoload($className)
    {
        if (strpos($className, 'jpp') === false) {
            return;
        }
        $file = str_replace('\\', JPP_DS, $className);

        @include(JPP_SDK_DIR . $file . '.php');

        if (!class_exists($className, false) && !interface_exists($className, false) && !trait_exists($className, false)) {
            throw new \Exception("Unable to find '$className' in file: $file. Namespace missing?");
        }
    }
}

spl_autoload_register(['JppAutoloader', 'autoload'], true, true);

// 系统文件路径分隔符
defined('JPP_DS') or define('JPP_DS', DIRECTORY_SEPARATOR);
// 环境定义(test,prod)
defined('JPP_ENV') or define('JPP_ENV', 'test');
// 当前SDK的根目录
defined('JPP_SDK_DIR') or define('JPP_SDK_DIR', dirname(__FILE__) . JPP_DS);
// p12证书存放路径
defined('JPP_CERT_FILE') or define('JPP_CERT_FILE', JPP_SDK_DIR . 'resource/' . JPP_ENV . '/800001300030002.p12');
// p12证书解包密码
defined('JPP_CERT_PWD') or define('JPP_CERT_PWD', 'rWfOWk');
// 商户ID
defined('JPP_MERCHANT_ID') or define('JPP_MERCHANT_ID', '800001300030002');
// 服务URL
defined('JPP_MERCHANT_URL') or define('JPP_MERCHANT_URL', 'https://jd.kingpass.cn/paygateway/mpsGate/mpsTransaction');


/**
 * 九派天下商户支付SDK
 *
 * @author: hongcq
 * @since 2017-08-02
 */
class JppSdk
{
    // ------------------------- 卡相关接口 -------------------------------- //

    /**
     * 快捷绑卡
     *
     * @param array $params
     * @return array
     */
    public static function bindCard($params)
    {
        return jpp\service\CardService::bind($params);
    }

    /**
     * 解绑卡
     *
     * @param array $params
     * @return array
     */
    public static function unbindCard($params)
    {
        return jpp\service\CardService::unbind($params);
    }

    /**
     * 快捷支付短信下发／重发
     *
     * @param array $params
     * @return array
     */
    public static function smsSend($params)
    {
        return jpp\service\SmsService::sendText($params);
    }

    /**
     * 快捷绑卡验证短信
     *
     * @param array $params
     * @return array
     */
    public static function rpmBindCardCommit($params)
    {
        return jpp\service\CardService::rpmBindCardCommit($params);
    }

    /**
     * 查询用户的绑卡信息
     *
     * @param array $params
     * @return array
     */
    public static function userCardList($params)
    {
        return jpp\service\CardService::userCardList($params);
    }

    /**
     * 商户查询银行卡的签约状态
     *
     * @param array $params
     * @return array
     */
    public static function bindStatus($params)
    {
        return jpp\service\CardService::bindStatus($params);
    }

    /**
     * 查询银行卡信息
     *
     * @param array $params
     * @return array
     */
    public static function cardDetail($params)
    {
        return jpp\service\CardService::cardDetail($params);
    }

    /**
     * 查询支持绑卡的银行列表
     *
     * @param array $params
     * @return array
     */
    public static function supportBindList($params)
    {
        return jpp\service\CardService::supportBindList($params);
    }

    // ------------------------- 支付相关接口 -------------------------------- //

    /**
     * 快捷支付发起(九派支付方验证短信)
     *
     * @param array $params
     * @return array
     */
    public static function quickPayInit($params)
    {
        return jpp\service\PayService::quickPayInit($params);
    }

    /**
     * 快捷支付提交(九派支付方验证短信)
     *
     * @param array $params
     * @return array
     */
    public static function quickPayCommit($params)
    {
        return jpp\service\PayService::quickPayCommit($params);
    }

    /**
     * 快捷支付提交(商户自验短信)
     *
     * @param array $params
     * @return array
     */
    public static function quickPay($params)
    {
        return jpp\service\PayService::quickPay($params);
    }

    /**
     * 快捷支付查询
     *
     * @param array $params
     * @return array
     */
    public static function payQuery($params)
    {
        return jpp\service\PayService::payQuery($params);
    }

    /**
     * 退款
     *
     * @param array $params
     * @return array
     */
    public static function refund($params)
    {
        return jpp\service\PayService::refund($params);
    }

    /**
     * 退款结果查询
     *
     * @param array $params
     * @return array
     */
    public static function refundQuery($params)
    {
        return jpp\service\PayService::refundQuery($params);
    }

    /**
     * 网银支付
     *
     * @param array $params
     * @return array
     */
    public static function bankPayment($params)
    {
        return jpp\service\PayService::bankPayment($params);
    }



    // ------------------------- 账单相关接口 -------------------------------- //

    /**
     * 对账单查询下载
     *
     * @param array $params
     * @return array
     */
    public static function statementDailyQuery($params)
    {
        return jpp\service\StatementService::statementDailyQuery($params);
    }

    // ------------------------- 代收相关接口 -------------------------------- //

    /**
     * 商户调用该交易接口扣客户账(单笔)
     *
     * @param array $params
     * @return array
     */
    public static function singleCollection($params)
    {
        return jpp\service\CollectionService::singleCollection($params);
    }

    /**
     * 商户调用该交易接口扣客户账(批量多笔)
     *
     * @param array $params
     * @return array
     */
    public static function batchCollection($params)
    {
        return jpp\service\CollectionService::batchCollection($params);
    }

    /**
     * 批量多笔代收查询
     *
     * @param array $params
     * @return array
     */
    public static function batchCollectionQuery($params)
    {
        return jpp\service\CollectionService::batchCollectionQuery($params);
    }

    /**
     * 单笔代付
     *
     * @param array $params
     * @return array
     */
    public static function singleTransfer($params)
    {
        return jpp\service\CollectionService::singleTransfer($params);
    }

    /**
     * 批量多笔代付
     *
     * @param array $params
     * @return array
     */
    public static function batchTransfer($params)
    {
        return jpp\service\CollectionService::batchTransfer($params);
    }

    /**
     * 查询账户余额
     *
     * @param array $params 
     * @return array
     */
    public static function merchantAccountQuery($params)
    {
        return jpp\service\CollectionService::merchantAccountQuery($params);
    }

    // ------------------------- 对账单相关接口 -------------------------------- //

    /**
     * 定单查询下载
     *
     * @param array $params
     * @return array
     */
    public static function orderQuery($params)
    {
        return jpp\service\CollectionService::orderQuery($params);
    }

    /**
     * 对账单查询下载
     *
     * @param array $params
     * @return array
     */
    public static function statementQuery($params)
    {
        return jpp\service\StatementService::statementQuery($params);
    }

    /**
     * 对账单下载
     *
     * @param array $params
     * @return array
     */
    public static function statementDownload($params)
    {
        return jpp\service\StatementService::statementDownload($params);
    }

    /**
     * 对账单查询
     *
     * @param array $params
     * @return array
     */
    public static function capStatementQuery($params)
    {
        return jpp\service\StatementService::capStatementQuery($params);
    }

    // ------------------------- 扫码支付相关接口 -------------------------------- //

    /**
     * 生成固码
     *
     * @param array $params
     * @return array
     */
    public static function scanCreateSolidCode($params = array())
    {
        return jpp\service\ScanService::createSolidCode($params);
    }

    /**
     * 生成订单活码
     *
     * @param array $params
     * @return array
     */
    public static function scanCreateOrderCode($params)
    {
        return jpp\service\ScanService::createOrderCode($params);
    }

    /**
     * 条码支付确认
     *
     * @param array $params
     * @return array
     */
    public static function scanPayConfirmViaCodeBar($params)
    {
        return jpp\service\ScanService::payConfirmViaCodeBar($params);
    }

    /**
     * 活码/固码支付确认
     *
     * @param array $params
     * @return array
     */
    public static function scanPayConfirm($params)
    {
        return jpp\service\ScanService::payConfirm($params);
    }

    /**
     * 扫码订单撤销
     *
     * @param array $params
     * @return array
     */
    public static function scanPayCancel($params)
    {
        return jpp\service\ScanService::payCancel($params);
    }


    /**
     * 异步通知
     *
     * @param array $params
     * @return array
     */
    public static function asyncNotify($params)
    {
        return jpp\lib\NotifyService::request($params);
    }


    // ------------------------- B2B B2C 支付相关接口 -------------------------------- //

}
