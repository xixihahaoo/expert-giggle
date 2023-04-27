<?php
/**
 * 九龙回调支付
 * by wanghaidong 2017-10-16
 * --------------------------------
 */
namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;

class PayJlNotifyUrlController extends Controller{

    //充值回调
    public function offlineNotifyUrl()
    {
        $postData = $_REQUEST;

        if(!$postData)
        {
            die('没有收到任何信息');
        }
        Log::debugArr($postData,'JlNotifyUrl');

        Vendor('Jlpay.demo.QuickPayment');
        $QuickPayment = new \demoQuickPayment();

        //验证证书签名
        $ret = $QuickPayment::asyncNotify($postData);
        if($ret['signStatus'] == 1 && $ret['orderSts'] == 'PD')
        {
            Log::debugArr($ret,'222JlNotifyUrl');

            $balance = M('balance');
            $account = M('accountinfo');

            $order_no = $ret['orderId'];

            $datas = $balance->where(array('balanceno' => $order_no))->find();

            if (!$datas) {
                die('未查到充值流水');
                return false;
            }

            if ($datas['isverified'] == 1 && $datas['status'] == 1) {
                echo 'SUCCESS';
                return false;
            }

            $order_amount       = $ret['amount'] / 100;
            $data['bpprice']    = $order_amount;
            $data['isverified'] = 1; //入金成功
            $data['status']     = 1; //完成
            $data['cltime']     = time(); //完成
            $data['shibpprice'] = $datas['shibpprice'] + $order_amount; //完成

            $case = $balance->where(array('balanceno' => $order_no))->save($data);
            if ($case) {
                $money = $account->where(array('uid' => $datas['uid']))->setInc('balance', $order_amount);
                $money_total = $account->where(array('uid' => $datas['uid']))->setInc('recharge_total', $order_amount);
            }

            //用户资金流水表
            if ($money && $money_total) {

                if($datas['pay_type'] == 26)
                {
                    $typeString = '快捷支付';
                } else if($datas['pay_type'] == 27)
                {
                    $typeString = '网关支付';
                }

                $map['uid']         = $datas['uid'];
                $map['type']        = 4;
                $map['oid']         = $datas['bpid'];
                $map['note']        = '用户使用'.$typeString.'支付充值金额[' . $order_amount . ']元';
                $map['balance']     = $account->where(array('uid' => $datas['uid']))->sum('balance');
                $map['op_id']       = $datas['uid'];
                $map['dateline']    = time();
                M("money_flow")->add($map);

                echo 'SUCCESS';

            } else {
                die('充值失败');
                return false;
            }
        } else {
            die('验签失败');
            return false;
        }
    }


    //从数据库中取出链接进行支付
    public function bankPayment()
    {
        $code = trim(I('get.code'));

        if(empty($code))
        {
            die('没有查到订单');
        }

        $obj = M();
        $data = $obj->table('dict_jl_pay')->where(array('code' => $code))->find();

        if(!$data)
        {
            die('没有查到订单');
        }

        $params = unserialize($data['post_data']);
        $url    = $data['url'];

        Vendor('Jppay.demo.B2CB2BPayment');
        $B2CB2BPPayment = new \demoB2CB2BPayment();
        $res = $B2CB2BPPayment->bankPayment($params);

        if(!$res['orderId'])
        {
            die('支付失败');
        }

        $this->create($res,$url);
    }

    private function create($data, $submitUrl) {
        $inputstr = "";
        foreach ($data as $key => $v) {
            $inputstr .= '<input type="hidden"  id="' . $key . '" name="' . $key . '" value="' . $v . '"/>';
        }
        $form = '<form action="' . $submitUrl . '" name="pay" id="pay" method="POST">';
        $form .= $inputstr;
        $form .= '</form>';
        $html = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>请不要关闭页面,支付跳转中.....</title>
        </head><body>
        ';
        $html .= $form;
        $html .= '
        <script type="text/javascript">
           document.getElementById("pay").submit();
        </script>';
        $html .= '</body></html>';
        $this->Mheader('utf-8');
        echo $html;

        exit;

    }

    private function Mheader($type) {

        header("Content-Type:text/html;charset={$type}");
    }

    //支付结果验证
    public function payQuery()
    {
        $balanceno = trim(I('get.balanceno'));
        if(empty($balanceno))
        {
            $return['status']    = 0;
            $return['msg']       = '订单号不能为空';
            $this->ajaxReturn($return,'JSON');
        }

        //$balanceno = settype($balanceno,'string');

        Vendor('Jlpay.demo.QuickPayment');
        $QuickPayment = new \demoQuickPayment();
        $dataArr = array('orderId' => $balanceno);
        $ret = $QuickPayment::payQuery($dataArr);

        if($ret['rspCode'] == 'IPS00000' && $ret['payResult'] == 'PD')
        {
            $balance = M('balance');
            $account = M('accountinfo');

            $order_no = $ret['orderId'];

            $datas = $balance->where(array('balanceno' => $order_no))->find();

            $return = array();

            if (!$datas) {
                $return['status']    = 0;
                $return['msg']       = '未查到充值流水';
                $this->ajaxReturn($return,'JSON');
            }

            if ($datas['isverified'] == 1 && $datas['status'] == 1) {
                $return['status']    = 0;
                $return['msg']       = '已经充值成功了';
                $this->ajaxReturn($return,'JSON');
            }

            $order_amount       = $ret['amount'] / 100;
            $data['bpprice']    = $order_amount;
            $data['isverified'] = 1; //入金成功
            $data['status']     = 1; //完成
            $data['cltime']     = time(); //完成
            $data['shibpprice'] = $datas['shibpprice'] + $order_amount; //完成

            $case = $balance->where(array('balanceno' => $order_no))->save($data);
            if ($case) {
                $money = $account->where(array('uid' => $datas['uid']))->setInc('balance', $order_amount);
                $money_total = $account->where(array('uid' => $datas['uid']))->setInc('recharge_total', $order_amount);
            }

            //用户资金流水表
            if ($money && $money_total) {

                if($datas['pay_type'] == 26)
                {
                    $typeString = '快捷支付';
                } else if($datas['pay_type'] == 27)
                {
                    $typeString = '网关支付';
                }

                $map['uid']         = $datas['uid'];
                $map['type']        = 4;
                $map['oid']         = $datas['bpid'];
                $map['note']        = '用户使用'.$typeString.'支付充值金额[' . $order_amount . ']元';
                $map['balance']     = $account->where(array('uid' => $datas['uid']))->sum('balance');
                $map['op_id']       = $datas['uid'];
                $map['dateline']    = time();
                if(M("money_flow")->add($map))
                {
                   $return['status']    = 1;
                   $return['msg']       = '充值成功';
                   $this->ajaxReturn($return,'JSON');
                }
            } else {
               $return['status']    = 0;
               $return['msg']       = '充值失败';
               $this->ajaxReturn($return,'JSON');
            }
        } else {
            $return['status']    = 0;
            $return['msg']       = $ret['rspMessage'];
            $this->ajaxReturn($return,'JSON');
        }
    }
}
       
