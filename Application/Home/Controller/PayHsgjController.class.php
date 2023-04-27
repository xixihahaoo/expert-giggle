<?php
/**
 * 恒生国际支付
 * by wang 2017-8-30
 * --------------------------------
 */

namespace Home\Controller;
use Think\Controller;
use Org\Util\HsgjPay;
use Org\Util\Log;

class PayHsgjController extends Controller {

	public function pay()
	{
		$order_no 	= trim(I('get.ordernum'));
		$money		= trim(I('get.money'));

		$balanceObj = M('balance');

		$balance = $balanceObj->where(array('balanceno' => $order_no,'bpprice' => $money))->find();
		if (!$balance) die('无效订单');

		if($balance['isverified'] == 1 && $balance['status'] == 1)
		{
			die('已经支付');
		}

        $signArr    = array(
            'cp_trade_no'   => $balance['balanceno'],
            'fee'           => ($balance['bpprice'] * 100),
            'w_type'        => 1,
        );

        $res    = new HsgjPay();

        $sign = $res->sign($signArr);

        $signArr['sign'] = $sign;

        $url = $res->postArr($signArr);

        $url = html_entity_decode($url);

        header("Location: $url");
	}

    public function jump_url()
    {
       $fileContent = file_get_contents("php://input");
      // $xmlResult = simplexml_load_string($fileContent);
        $this->redirect('User/index');
    }

    public function notify_url()
    {
        $postStr    = file_get_contents('php://input');    //获取输入流

        $postArr    = json_decode($postStr,true);

        $res        = new HsgjPay();

        $sign       = $res->notifySign($postArr);

        $order_no 		= $postArr['cp_trade_no'];
        $fee 			= ($postArr['fee'] /100);
        $result_code 	= $postArr['result_code']; 

        Log::debugArr($sign, 'newPaysign');
        Log::debugArr($postStr, 'newPay');


        if($sign == $postArr['sign'])
        {
            echo 'success';

            if($result_code == 0)
            {
				$balanceObj = M('balance');
				$accountObj = M('accountinfo');

				$order_time = time();

				$data = $balanceObj->where(array('balanceno' => $order_no,'bpprice' => $fee))->find();

				if (!$data) {
					echo '查询失败，未找到充值流水';
					return false;
				}

				if ($data['isverified'] == 1 && $data['status'] == 1) {
					echo '充值成功';
					return false;
				}

				$datas['bpprice'] 	= $fee;
				$datas['isverified'] = 1; 		//入金成功
				$datas['status'] 	= 1; 		//完成
				$datas['cltime'] 	= time(); 	//完成
				$datas['shibpprice'] = $data['shibpprice'] + $fee; //完成

				//操作数据

				$balanceObj->startTrans();

				$caseRes 		 	= $balanceObj->where(array('balanceno' => $order_no,'bpprice' => $fee))->save($datas);

				if($caseRes)
				{
					$moneyRes 		 	= $accountObj->where(array('uid' => $data['uid']))->setInc('balance', $fee);
					$moneyTotalRes 		= $accountObj->where(array('uid' => $data['uid']))->setInc('recharge_total', $fee);
				}
				if($moneyRes && $moneyTotalRes)
				{
					$typeString 		= '微信支付'; 
					$flow['uid'] 		= $data['uid'];
					$flow['type'] 		= 4;
					$flow['oid'] 		= $data['bpid'];
					$flow['note'] 		= '用户使用'.$typeString.'充值金额[' . $fee . ']元';
					$flow['balance'] 	= $accountObj->where(array('uid' => $data['uid']))->sum('balance');
					$flow['op_id'] 		= $data['uid'];
					$flow['dateline'] 	= time();
					$flowRes = M("money_flow")->add($flow);
				}

				if($caseRes && $moneyRes && $moneyTotalRes && $flowRes)
				{
					$balanceObj->commit();
					echo '充值成功';
					return false;
				} else {
					$balanceObj->rollback();
					echo '充值失败';
					return false;
				}

            } else {
            	echo '充值失败';
				return false;
            }

        } else {
            echo 'error';
            return false;
        }
    }
}
       