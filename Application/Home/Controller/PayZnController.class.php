<?php
/**
 * 钱通支付
 * by linjuming 2017-4-23
 * --------------------------------
 */

namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;

class PayZnController extends Controller {

	/**
	 * 支付页面
	 */
	public function pay_zn(){
		$order_no = trim(I('get.ordernum'));
		$paytype  = trim(I('get.paytype'));
		$balance  = D('Balance')->getDetailByOrderNo($order_no);
		if($balance)
		{
			$zn_rs['code_img_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/Home/PayZn/pay?ordernum='.$order_no.'&paytype='.$paytype.'';
			$zn_rs['order_no'] = $order_no;

			$this->assign('zn_rs',$zn_rs);
			$this->display('wxpay_zn');
		}
	}

	public function pay_kuaijie_before()
	{
		$order_no 	= I('get.ordernum'); // 交易id
		$paytype 	= I('get.paytype'); // 交易id
		$amount 	= I('get.money'); // 交易id
		$model 		= trim(I('get.model'));	//支付模块 
		// ADD by w 20170912 start 
		$uid = I('get.uid'); // 用户id
		
		$zn_rs['uid'] = $uid;
		// ADD by w 20170912 end
		
		$zn_rs['paytype'] 	= $paytype;
		$zn_rs['order_no'] 	= $order_no;
		$zn_rs['amount'] 	= $amount;
		$zn_rs['model']		= $model;

		$this->assign('zn_rs',$zn_rs);
		$this->display('card_zn');
//		$order_no = I('get.ordernum'); // 交易id
//		$balance = D('Balance')->getDetailByOrderNo($order_no); // 交易详情
//		if (!$balance) die('无效订单');



//		$q = new \Org\Util\ZNanPay();
//
//		$aa = $q->jumpRequest($balance);
//
//		Log::debugArr($aa, 'znkuaijiejumpcode');
//		//echo $aa['bankurl'];
//		echo $aa;
//		exit;
	}

	public function jump()
	{
		layout(false);
		$this->display('pay_kuaijie');
	}


	public function pay_kuaijie()
	{
		$paytype = I('get.paytype'); // 
		$amount = I('get.amount'); // 
		$ordernum = I('get.ordernum'); // 
		$cardNo = I('get.cardNo'); // 
		$cardName = I('get.cardName'); // 
		$idNo = I('get.idNo'); // 
		$mobile = trim(I('get.mobile'));	//支付模块
		$model = trim(I('get.model'));	//支付模块
		$uid = trim(I('get.uid'));	//ADD By w 20170911


//		layout(false);
//		$this->display('pay_kuaijie');
//		
		//$balance = D('Balance')->getDetailByOrderNo($ordernum); // 交易详情
		//if (!$balance) die('无效订单');

		// ADD Start By w 20170912
		//生成订单信息
		$account = M('accountinfo')->where(array('uid' => $uid ))->find();

		if(!empty($model))
		{
			$user_tel = $mobile;
		} else
		{
			//获取手机号 Add By W 20171005 start
			$userinfo = M('userinfo')->where(array('uid' => $uid ))->find();
			$user_tel = $userinfo['utel'];
			// end
		}
		
		$num = $uid.time().mt_rand();;   //订单号


		$data['bptype']     = '充值';
		$data['remarks']    = '普通会员充值';
		$data['bptime']     = time();               //操作时间
		$data['bpprice']    = $amount;               //充值金额
		$data['uid']        = $uid;       //用户id
		$data['isverified'] = 0;                    //0未通过
		$data['balanceno']  = $num;                 //订单编号
		$data['shibpprice'] = $account['balance'];  //用户余额
		$data['b_type']     = 1;                    //流水类型，1充值，2提现
		$data['status']     = 0;                    //0待处理  1完成

		$data['pay_type'] ='11';

		M('balance_s')->add($data);
		$res = M('balance')->add($data);

        if($res){
			Log::debugArr('add sucessed', 'znkuaijiejumpcode');
        }else {
			Log::debugArr('add failed', 'znkuaijiejumpcode');
		}
		
		// ADD End By w 20170912
		
		if(!empty($model))
		{
			$q = new \Org\Util\ZNanPay($model);

		} else {

			$q = new \Org\Util\ZNanPay();
		}
		

		//$aa = $q->jumpRequest($balance,$cardNo,$cardName,$idNo);
		$aa = $q->jumpRequest($data,$cardNo,$cardName,$idNo,$user_tel); // Mod By w 20170912
		Log::debugArr($aa, 'znkuaijiejumpcode2132');

echo $aa;
//		$this->show($aa);   
   // $this->html = $aa;
   // $this->display();
//		$this->redirect($aa);
//
//		//echo $aa['bankurl'];
//		$this->display($aa);
//		header("Location:".$aa);
//		echo $aa;
//		exit;
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
			'weiXinScan_zn' => 'wxpay',
			'weiXinWap_zn' => 'wxpay',
			'ZFBScan_zn' => 'alipay',
			'QQSCANPay_zn' => 'qqpay'
		);
		$type = $method2Type[$method];
		if (empty($type)) die('无效支付方式.');

		$balance = D('Balance')->getDetailByOrderNo($order_no); // 交易详情
		if (!$balance) die('无效订单');

		$q = new \Org\Util\ZNanPay();
			
		$rs = $q->postOrder($type, $balance);
		
		if ($rs['status'] == 1) {
			$zn_rs['code_img_url'] = $rs['codeUrl'];
			$zn_rs['order_no'] = $order_no;

		} else {
			$zn_rs['code_img_url'] = $rs['codeUrl'];
		}
		
   Log::debugArr($type, 'PayZnController');
		
		if ($type=='wxpay' ){
		
			//redirect($rs['codeUrl']);
			Log::debugArr($zn_rs['code_img_url'], 'PayZnController22');
			$this->assign('zn_rs',$zn_rs);
			$this->assign('type',$type);
			// $this->display('wxscan_zn');
			$this->display('wxpay_zn');
		}
		else
		{
			$this->assign('zn_rs',$zn_rs);
			$this->display('wxpay_zn');
		}
	}

	public function jumpRequest()
	{
	
		$this->display('card_zn');
		
		
		$q = new \Org\Util\ZNanPay();
		$def_url = $q->jumpRequest();
		echo $def_url;
		exit;
	}

	public function notify()
	{
		$q = new \Org\Util\ZNanPay();
		$result = $q->notify();

		Log::debugArr($result, 'znpay_notify');

		if ($result['status'] == 0) {//验签失败
			return 0;
		}

		Log::debugArr($result['payStatus'], 'znpay_notify');
		if ($result['payStatus'] == 'success') {//支付成功
			$balance = M('balance');
			$account = M('accountinfo');

			$order_no = $result['orderId'];
			$order_time = time();  //cltime

			$data1 = $balance->where(array('balanceno' => $order_no))->find();


			if (!$data1) {
//				outjson(array('status' => 0, 'ret_msg' => '查询失败，未找到充值流水！'));
				outjson('PayNum Not Founded!!! ');
				return false;
			}

			if ($data1['isverified'] == 1 && $data1['status'] == 1) {
//				outjson(array('status' => 1, 'ret_msg' => '充值成功'));
//				outjson(success);
				echo success;

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

                $infos = M('userinfo')->field('uid,otype')->where(array('uid' => $data1['uid']))->find();
                if($infos['otype'] == 5)
                {
                   $map['user_type'] = 2;
                }

                if($data1['pay_type'] == 9)
                {
                	$typeString = '中南微信';
                } else if($data1['pay_type'] == 10)
                {
                	$typeString = '中南支付宝';
                } else if($data1['pay_type'] == 11)
                {
                	$typeString = '中南快捷支付';
                }

				$map['uid'] = $data1['uid'];
				$map['type'] = 4;
				$map['oid'] = $data1['bpid'];
				$map['note'] = '用户使用'.$typeString.'支付充值金额[' . $order_amount . ']元';
				$map['balance'] = $account->where(array('uid' => $data1['uid']))->sum('balance');
				$map['op_id'] = $data1['uid'];
				$map['dateline'] = time();
				M("money_flow")->add($map);
//				outjson(array('status' => 1, 'ret_msg' => '充值成功'));
//				outjson(success);

				echo success;
			} else {
//				outjson(array('status' => 0, 'ret_msg' => '充值失败'));
				outjson('Failed');
			}
		} else {
//			outjson(array('status' => 0, 'ret_msg' => '支付失败！'));
			outjson('Failed');
		}

	}


	public function notifyDaifu()
	{
		$q = new \Org\Util\ZNanPay();
		$result = $q->notifyDaifu();

		Log::debugArr($result, 'notifyDaifu');

		if ($result['status'] == 0) {//验签失败
			return 0;
		}

		$balance = M('balance');
		$order_no = $result['orderId'];
		$order_time = time();  //cltime
		$data = $balance->where(array('balanceno' => $order_no))->find();

		Log::debugArr($result['payStatus'], 'notifyDaifu');
		if ($result['payStatus'] == 'success') {//代付成功

			if (!$data) {
				Log::debugArr($order_no, 'notifyDaifu');
				return false;
			}

			Log::debugArr($data['isverified'], 'notifyDaifu');
			Log::debugArr($data['status'], 'notifyDaifu');
			// 判断是否代付已经完成
			if ($data['isverified'] == 2 && $data['status'] == 1) {
				echo success;
				return false;
			}

			$data['isverified'] = '2'; //代付成功
			$data['status'] = '1'; //完成
			$data['cltime'] = $order_time; //完成

			Log::debugArr($data['isverified'], 'notifyDaifu');
			Log::debugArr($data['status'], 'notifyDaifu');
			$case = $balance->where(array('balanceno' => $order_no))->save($data);

			echo success;
		} else {
			$data['isverified'] = '2'; //代付
			$data['status'] = '3'; //代付失败
			$data['cltime'] = $order_time; 

			$case = $balance->where(array('balanceno' => $order_no))->save($data);
			outjson('Failed');
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
       
