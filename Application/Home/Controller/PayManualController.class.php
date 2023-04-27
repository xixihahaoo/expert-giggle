<?php
/**
 * 微信支付宝手动充值
 */

namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;

class PayManualController extends CommonController{

    /**
     * zfbQroce
     * @deprecated  支付宝人工扫码充值
     * @date
     * @return void
     */
    public function zfbQroce()
    {
        $this->display();
    }

    /**
     * wxQroce
     * @deprecated  微信人工扫码充值
     * @date
     * @return void
     */
    public function wxQrcode()
    {
        $this->display();
    }

    //银联充值
    public function yl()
    {
        $this->display();
    }


    //账户回调
    public function notify()
    {
        $balanceno = trim(I('get.balanceno'));
        if(empty($balanceno))
        {
            $return['status']    = 0;
            $return['msg']       = '订单号不能为空';
            $this->ajaxReturn($return,'JSON');
        }

        //$balanceno = settype($balanceno,'string');

        $balance = M('balance');
        $account = M('accountinfo');

        $datas = $balance->where(array('balanceno' => $balanceno))->find();

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

        $order_amount       = $datas['bpprice'];
        $data['bpprice']    = $order_amount;
        $data['isverified'] = 1; //入金成功
        $data['status']     = 1; //完成
        $data['cltime']     = time(); //完成
        $data['shibpprice'] = $datas['shibpprice'] + $order_amount; //完成

        $case = $balance->where(array('balanceno' => $balanceno))->save($data);
        if ($case) {
            $money = $account->where(array('uid' => $datas['uid']))->setInc('balance', $order_amount);
            $money_total = $account->where(array('uid' => $datas['uid']))->setInc('recharge_total', $order_amount);
        }

        //用户资金流水表
        if ($money && $money_total) {

            if($datas['pay_type'] == 28)
            {
                $typeString = '支付宝手动';
            } else if($datas['pay_type'] == 29)
            {
                $typeString = '微信手动';
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
    }
}

