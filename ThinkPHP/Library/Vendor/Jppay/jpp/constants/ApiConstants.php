<?php
namespace jpp\constants;

/**
 * Api常量定义类
 *
 * @package jpp\constants
 */
class ApiConstants
{
    /** @var string 快捷绑卡 */
    const SERVICE_CARD_BIND = 'rpmBindCard';

    /** @var string 解绑卡 */
    const SERVICE_CARD_UNBIND = 'rpmUnbindCard';

    /** @var string 快捷绑卡验证短信 */
    const SERVICE_CARD_COMMIT = 'rpmBindCardCommit';

    /** @var string 查询支持绑卡的银行列表 */
    const SERVICE_CARD_SUPPORT_BIND_LIST = 'rpmBankList';

    /** @var string 查询用户绑卡信息 */
    const SERVICE_CARD_USER_BINDED_LIST = 'rpmMemberCardList';

    /** @var string 查询银行卡信息 */
    const SERVICE_CARD_DETAIL = 'rpmCardInfo';

    /** @var string 商户查询银行卡的签约状态 */
    const SERVICE_CARD_BIND_STATUS = 'rpmQueryCardBindStatus';

    /** @var string 短信下发 */
    const SERVICE_SMS_SEND = 'rpmQuickPaySms';

    /** @var string 快捷支付（商户自验短信） */
    const SERVICE_SMS_SEND_SELF_CHECK = 'rpmQuickPay';

    /** @var string 快捷支付预下单 */
    const SERVICE_PAY_INIT = 'rpmQuickPayInit';

    /** @var string 快捷支付（我方验证短信） */
    const SERVICE_PAY_COMMIT = 'rpmQuickPayCommit';

    /** @var string 支付查询 */
    const SERVICE_PAY_QUERY = 'rpmPayQuery';

    /** @var string 退款 */
    const SERVICE_PAY_REFUND_COMMIT = 'rpmRefund';

    /** @var string 退款查询 */
    const SERVICE_PAY_REFUND_QUERY = 'rpmRefundQuery';

    /** @var string 快捷支付对账单下载(九派支付平台每天凌晨会定时生成对账单供商户下载) */
    const SERVICE_STATEMENT_DAILY = 'rpmStatement';

    /** @var string 代收付对账单查询 */
    const SERVICE_STATEMENT_QUERY = 'capStatementQuery';

    /** @var string 批量多笔代付到银行卡 */
    const SERVICE_BATCH_TRANS_TO_CARD = 'capBatchTransfer';

    /** @var string 单笔代收从银行卡 */
    const SERVICE_SINGLE_COLLECT_FROM_CARD = 'capSingleCollection';

    /** @var string 批量代收从银行卡 */
    const SERVICE_BATCH_COLLECT_FROM_CARD = 'capBatchCollection';

    /** @var string 单笔代付 */
    const SERVICE_SINGLE_TRANSFER = 'capSingleTransfer';

    /** @var string 订单查询 */
    const SERVICE_ORDER_QUERY = 'capOrderQuery';

    /** @var string 委托收付对账单下载 */
    const SERVICE_STATEMENT_FILE_DOWNLOAD = 'capStatementFileDown';

    /** @var string 代收付订单批量查询 */
    const SERVICE_ORDER_BATCH_QUERY = 'capBatchQuery';

    /** @var string B2C/B2B支付 */
    const SERVICE_PAY_B2C_OR_B2B = 'rpmBankPayment';

    /** @var string 生成固码 */
    const SERVICE_SCAN_CREATE_SOLIC_CODE = 'qrCodeGenerateByMerchant';

    /** @var string 生成订单活码 */
    const SERVICE_SCAN_CREATE_ORDER_CODE = 'qrCodeGenerateByOrder';

    /** @var string 条码支付确认 */
    const SERVICE_SCAN_PAY_CONFIRM_VIA_CODE_BAR = 'barCodePayMent';

    /** @var string 活码or固码支付确认 */
    const SERVICE_SCAN_PAY_CONFIRM = '';

    /** @var string 撤销订单 */
    const SERVICE_SCAN_PAY_CANCEL = 'qrCodePayCancel';

    /** @var string 代收付查询账户余额 */
    const SERVICE_MECHANT_ACCOUNT_QUERY = 'merchantAccountQuery';

}