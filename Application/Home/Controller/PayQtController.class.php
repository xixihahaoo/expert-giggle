<?php
/**
 * 钱通支付
 * by linjuming 2017-4-23
 * --------------------------------
 */

namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;

class PayQtController extends Controller {

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
;
			$this->assign('qt_rs',$qt_rs);
			$this->display('wxpay_qt');
		}
	}

	public function pay_kuaijie()
	{
		$order_no = I('get.ordernum'); // 交易id
		$balance = D('Balance')->getDetailByOrderNo($order_no); // 交易详情
		if (!$balance) die('无效订单');

		$q = new \Org\Util\QTongPay();

		$aa = $q->jumpRequest($balance);

		Log::debugArr($aa, 'qtkuaijiejumpcode');
		//echo $aa['bankurl'];
		echo $aa;
		exit;
	}

	public function jump_notify(){
		$this->success("支付完成",U('home/User/index'));
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
			'weiXinScan_qt' => 'WeiXinScanOrder',
			'weiXinWap_qt' => 'WeiXinWapOrder',
			'ZFBScan_qt' => 'ZFBScanOrder'
		);
		$type = $method2Type[$method];
		if (empty($type)) die('无效支付方式.');

		$balance = D('Balance')->getDetailByOrderNo($order_no); // 交易详情
		if (!$balance) die('无效订单');

		$q = new \Org\Util\QTongPay();
		$rs = $q->postOrder($type, $balance);
		if ($rs['status'] == 1) {
			$qt_rs['code_img_url'] = $rs['codeUrl'];
			$qt_rs['order_no'] = $order_no;

		} else {
			$qt_rs['code_img_url'] = $rs['codeUrl'];
		}
		
		$this->assign('qt_rs',$qt_rs);
		$this->display('wxpay_qt');
	}

	public function jumpRequest()
	{
		$q = new \Org\Util\QTongPay();
		$def_url = $q->jumpRequest();
		echo $def_url;
		exit;
	}

	public function notify()
	{
		Log::debugArr('start process notify', 'qtpay_notify');
		$q = new \Org\Util\QTongPay();
		$result = $q->notify();
		if ($result['status'] == 0) {//验签失败
			return 0;
		}

		if ($result['payStatus'] == 'success') {//支付成功
			$balance = M('balance');
			$account = M('accountinfo');

			$order_no = $result['orderId'];
			$order_time = time();  //cltime

			$data1 = $balance->where(array('balanceno' => $order_no))->find();


			if (!$data1) {
				outjson(array('status' => 0, 'ret_msg' => '查询失败，未找到充值流水！'));
				return false;
			}

			if ($data1['isverified'] == 1 && $data1['status'] == 1) {
				outjson(array('status' => 1, 'ret_msg' => '充值成功'));
				return false;
			}

			$order_amount = $result['amount'];
			$data['bpprice'] = $order_amount;
			$data['isverified'] = '1'; //入金成功
			$data['status'] = '1'; //完成
			$data['cltime'] = $order_time; //完成
			$data['shibpprice'] = $data1['shibpprice'] + $order_amount; //完成

			//$account->startTrans();

			$case = $balance->where(array('balanceno' => $order_no))->save($data);
			if ($case) {
				$money = $account->where(array('uid' => $data1['uid']))->setInc('balance', $order_amount);
				$money_total = $account->where(array('uid' => $data1['uid']))->setInc('recharge_total', $order_amount);
			}
			//用户资金流水表
			if ($money && $money_total) {
				$map['uid'] = $data1['uid'];
				$map['type'] = 4;
				$map['oid'] = $data1['bpid'];
				if($data1['pay_type'] == 6 ){
					$typeString = '微信';
				}else if($data1['pay_type'] == 7){
					$typeString = '支付宝';
				}else if($data1['pay_type'] == 8){
					$typeString = '快捷支付';
				}
				$map['note'] = '用户使用'.$typeString.'充值金额[' . $order_amount . ']元';
				$map['balance'] = $account->where(array('uid' => $data1['uid']))->sum('balance');
				$map['op_id'] = $data1['uid'];
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
       