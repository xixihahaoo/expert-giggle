<?php
/**
 * @author: FrankHong
 * @datetime: 2017/2/7 15:36
 * @filename: PayresController.class.php
 * @description: 
 * @note: 
 * 
 */
namespace Home\Controller;
use Think\Controller;

use Org\Util\Ipspay;
use Org\Util\Log;

class PayresController extends Controller
{
    /**
     * @functionname: ips_notify
     * @author: FrankHong
     * @date: 2017-02-07 16:01:42
     * @description: 环迅的支付状态异步回调
     * @note:
     *
     * <Ips>
        <GateWayRsp>
        <head>
        <ReferenceID>00001</ReferenceID>
        <RspCode>000000</RspCode>
        <RspMsg><![CDATA[交易成功！]]></RspMsg>
        <ReqDate>20170207154323</ReqDate>
        <RspDate>20170207155514</RspDate>
        <Signature>606d316d045e8180c45fb10c931e0dfd</Signature>
        </head>
        <body>
        <MerBillNo>ips1925451486453400955000</MerBillNo>
        <CurrencyType>156</CurrencyType>
        <Amount>0.01</Amount>
        <Date>20170207</Date>
        <Status>Y</Status>
        <Attach>商户数据包</Attach>
        <IpsBillNo>BO20170207154323016473</IpsBillNo>
        <IpsTradeNo>20170207154323043494</IpsTradeNo>
        <BankBillNo>7104817466</BankBillNo>
        <RetEncodeType>17</RetEncodeType>
        <ResultType>0</ResultType>
        <IpsBillTime>20170207154341</IpsBillTime>
        </body>
        </GateWayRsp>
    </Ips>
     */
    public function ips_notify()
    {
        //Log::debugArr($_REQUEST, 'notify_return');
        $req        = new Ipspay();
        $returnArr  = $req->callback();
        if($returnArr == 'ipscheckok')
        {
            $paymentResult  = $_REQUEST['paymentResult'];
            $resultArr      = (array)simplexml_load_string($paymentResult, 'SimpleXMLElement', LIBXML_NOCDATA);
            $order_no1      = (array)$resultArr['GateWayRsp']->body->MerBillNo;
            $order_no       = $order_no1[0];
            //Log::debugArr($order_no, 'notify_return3');

            $order_time         = time();  //cltime

            $balance    = M('balance');
            $account    = M('accountinfo');

            $data1 = $balance->where(array('balanceno' => $order_no))->find();

            Log::debugArr($data1, 'notify11');
            if(!$data1)
            {
                echo 'ipscheckfail';
                die();
                outjson(array('status' => 0, 'ret_msg' => '查询失败，未找到充值流水！'));
            }
            else
            {
                if($data1['isverified'] == 1 && $data1['status'] == 1)
                {
                    echo 'ipscheckok';
                    die();
                    outjson(array('status' => 1, 'ret_msg' => '充值成功'));
                }

                $order_amount       = $data1['bpprice'];
                $data['isverified'] = '1'; //入金成功
                $data['status']     = '1'; //完成
                $data['cltime']     = $order_time; //完成
                $data['shibpprice'] = $data1['shibpprice'] + $order_amount; //完成

                //$account->startTrans();

                $case   = $balance->where(array('balanceno' => $order_no))->save($data);
                $money  = $account->where(array('uid' => $data1['uid']))->setInc('balance', $order_amount);
                $money_total = $account->where(array('uid' => $data1['uid']))->setInc('recharge_total', $order_amount);
                if ($case && $money && $money_total)
                {
                    //用户资金流水表
                    $map['uid']      = $data1['uid'];
                    $map['type']     = 4;
                    $map['oid']      = $data1['bpid'];
                    $map['note']     = '用户使用环迅微信扫码支付充值金额['.$order_amount.']元';
                    $map['balance']  = $account->where(array('uid' => $data1['uid']))->sum('balance');
                    $map['op_id']    = $data1['uid'];
                    $map['dateline'] = time();
                    M("money_flow")->add($map);

                    echo 'ipscheckok';
                    die();
                    //$balance->commit(); //对数据库的操作
                    outjson(array('status' => 1, 'ret_msg' => '充值成功'));
                }
                else
                {
                    echo 'ipscheckfail';
                    die();
                    //$balance->callbak();
                    outjson(array('status' => 0, 'ret_msg' => '充值失败'));
                }
            }
        }
        else
        {
            echo 'error';
        }


    }

}

