<?php
/**
 * 钱通支付
 * by linjuming 2017-4-23
 * --------------------------------
 */

namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;

class PayCbController extends Controller {

	/**
	 * 支付页面
	 */
	public function pay_qt(){
		$order_no = trim(I('get.ordernum'));
		$paytype  = trim(I('get.paytype'));
		$balance  = D('Balance')->getDetailByOrderNo($order_no);
		if($balance)
		{
			$qt_rs['code_img_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/Home/PayQt/pay?ordernum='.$order_no.'&paytype='.$paytype.'';
			$qt_rs['order_no'] = $order_no;

			$this->assign('qt_rs',$qt_rs);
			$this->display('wxpay_qt');
		}
	}


	/**
	 * 正式支付
	 */
	public function pay()
	{
		if (!session('user_id')) {
			$this->redirect(U('Register/login'));
		}

		$order_no = I('get.ordernum'); // 交易id
		$method = I('get.paytype'); // 支付方式
		if (!$method) die('无效支付方式');
		$method2Type = array(
			'weiXinScan_cb' => 'WEIXIN',
			'ZFBScan_cb' => 'ALIPAY'
		);
		$type = $method2Type[$method];
		if (empty($type)) die('无效支付方式1.');

		$balance = D('Balance')->getDetailByOrderNo($order_no); // 交易详情
		if (!$balance) die('无效订单');

		$q = new \Org\Util\ChangBaiPay();
		$rs = $q->postOrder($type, $balance);
		if ($rs['status'] == 1) {
			$qt_rs['code_img_url'] = $rs['codeUrl'];
			$qt_rs['order_no'] = $order_no;

		} else {
			$qt_rs['code_img_url'] = $rs['codeUrl'];
		}
		
		$this->assign('qt_rs',$qt_rs);
		$this->display();
	}

	public function jumpRequest()
	{
		if (!session('user_id')) {
			$this->redirect(U('Register/login'));
		}

		$order_no = I('get.ordernum'); // 交易id
		$method = I('get.paytype'); // 支付方式
		if (!$method) die('无效支付方式');
		$method2Type = array(
			'weiXinScan_cb' => 'WEIXIN',
			'h5_cb' => 'Nocard',
			'ZFBScan_cb' => 'ALIPAY'
		);
		$type = $method2Type[$method];
		if (empty($type)) die('无效支付方式.');

		$balance = D('Balance')->getDetailByOrderNo($order_no); // 交易详情
		if (!$balance) die('无效订单');

		$q = new \Org\Util\ChangBaiPay();
		$def_url = $q->jumpRequest($type, $balance);
		echo $def_url;
		exit;
	}

	public function notify()
	{
		$orderId = intval($_REQUEST['r6_Order']);
		if($orderId <= 0){
			Log::debugArr('orderId error.', 'cbpay_notify');
			exit;
		}
		$balance = M('balance');
		$data1 = $balance->where(array('balanceno' => $orderId))->find();
		Log::debugArr('order:'.$_REQUEST['r6_Order'], 'cbpay_notify');

		if($data1['pay_type'] == 20){//畅佰微信
			$type = 'WEIXIN';
		}else if($data1['pay_type'] == 21){//畅佰支付宝
			$type = 'ALIPAY';
		}else if($data1['pay_type'] == 22){//畅佰快捷支付
			$type = 'Nocard';
		}

		$q = new \Org\Util\ChangBaiPay();
		$result = $q->notify($type);

		Log::debugArr($result, 'cbpay_notify');

		if ($result['status'] == 0) {//验签失败
			return 0;
		}

		if ($result['payStatus'] == 'success') {//支付成功

			$account = M('accountinfo');

			$order_no = $result['orderId'];
			$order_time = time();  //cltime


			$datas = $balance->where(array('balanceno' => $order_no))->find();

			if (!$datas) {
				outjson(array('status' => 0, 'ret_msg' => '查询失败，未找到充值流水！'));
				return false;
			}

			if ($datas['isverified'] == 1 && $datas['status'] == 1) {
				outjson(array('status' => 1, 'ret_msg' => '充值成功'));
				return false;
			}

			$order_amount = $result['amount'];
			$data['bpprice'] = $order_amount;
			$data['isverified'] = '1'; //入金成功
			$data['status'] = '1'; //完成
			$data['cltime'] = $order_time; //完成
			$data['shibpprice'] = $datas['shibpprice'] + $order_amount; //完成

			//$account->startTrans();

			$case = $balance->where(array('balanceno' => $order_no))->save($data);
			if ($case) {
				$money = $account->where(array('uid' => $datas['uid']))->setInc('balance', $order_amount);
				$money_total = $account->where(array('uid' => $datas['uid']))->setInc('recharge_total', $order_amount);
			}
			//用户资金流水表
			if ($money && $money_total) {
				$map['uid'] = $datas['uid'];
				$map['type'] = 4;
				$map['oid'] = $datas['bpid'];
				if($datas['pay_type'] == 6 ){
					$typeString = '微信';
				}else if($datas['pay_type'] == 7){
					$typeString = '支付宝';
				}else if($datas['pay_type'] == 20){//畅佰微信
					$typeString = '微信';
				}else if($datas['pay_type'] == 21){//畅佰支付宝
					$typeString = '支付宝';
				}else if($datas['pay_type'] == 22){//畅佰快捷支付
					$typeString = '快捷支付';
				}
				$map['note'] = '用户使用'.$typeString.'支付充值金额[' . $order_amount . ']元';
				$map['balance'] = $account->where(array('uid' => $datas['uid']))->sum('balance');
				$map['op_id'] = $datas['uid'];
				$map['dateline'] = time();
				M("money_flow")->add($map);
				outjson(array('status' => 1, 'ret_msg' => '充值成功'));
			} else {
				outjson(array('status' => 0, 'ret_msg' => '充值失败'));
			}
		} else {
			outjson(array('status' => 0, 'ret_msg' => '支付失败！'));
		}

	}

	//查询是否支付成功
	public function get_pay_result()
	{
		$balanceObj = M('balance');
		$data 		= array();

		$order_no 	= trim(I('post.order_no'));
		
		if(empty($order_no))
		{
			$data['ret_msg'] = '订单号是空的';
			$data['status']  = 1;
			$this->ajaxReturn($data,'JSON');
		}

		$map['isverified'] 	= 1;
		$map['status']		= 1;
		$map['balanceno']	= $order_no; 
		$balance = $balanceObj->field('balanceno')->where($map)->find();
		if(!$balance)
		{
			$data['ret_msg'] = '尚未支付';
			$data['status']  = 0;
			$this->ajaxReturn($data,'JSON');
		} else {
			$data['ret_msg'] = '支付成功';
			$data['status']  = 1;
			$this->ajaxReturn($data,'JSON');
		}

	}
}
       
