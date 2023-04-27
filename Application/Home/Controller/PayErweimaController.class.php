<?php
/**
 * 魔宝支付
 * by zhuxq 2017-11-1
 * --------------------------------
 */

namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;

class PayErweimaController extends Controller {

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

		$type = $method;
		if (empty($type)) die('无效支付方式.');

		$balance = D('Balance')->getDetailByOrderNo($order_no); // 交易详情
		if (!$balance) die('无效订单');

		$q = new \Org\Util\ErweimaPay();
			
		$rs = $q->postOrder($type, $balance);
		
		Log::debugArr($rs, 'erweima');
		if ($rs['status'] == 1) {
			$zn_rs['code_img_url'] = $rs['codeUrl'];
			$zn_rs['order_no'] = $order_no;

			//if ($type=='fuwuhao_wx_ewm'){
				/* $str = array(
					'code_img_url'=>$code_img_url
				);
				$curl = curl_init();
				//设置抓取的url
				curl_setopt($curl, CURLOPT_URL, 'http://hjba.eq67.com/Home/PayErweima/UrlOpen');
				//设置头文件的信息作为数据流输出
				curl_setopt($curl, CURLOPT_HEADER, false);
				//设置获取的信息以文件流的形式返回，而不是直接输出。
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				//设置post方式提交
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $str);
				//执行命令
				$result = curl_exec($curl);
				//关闭URL请求
				curl_close($curl); */
				
				// $this->redirect(U('/Home/PayErweima/UrlOpen'),array('code_img_url'=>$zn_rs['code_img_url']));
				//redirect(U('home/PayErweima/UrlOpen').'?code_img_url='.$zn_rs['code_img_url']);
				redirect($zn_rs['code_img_url']);
			//}else{
				//$this->assign('zn_rs',$zn_rs);
				//$this->display('wxscan_Erweima');
			//}

		} else {
			$this->success("支付异常:".$rs->message,U('home/User/index'),5);
		}
		
	}	


	
	
	/**
	 * 正式支付
	 */
	public function UrlOpen()
	{
		$code_img_url=$_REQUEST['code_img_url'];
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$zn_rs['code_img_url'] = $code_img_url;
		Log::debugArr($code_img_url, 'UrlOpen');
		 if (strpos($user_agent, 'MicroMessenger') === false) {
			Log::debugArr($code_img_url, 'UrlOpen');
			redirect($code_img_url);
		 } else {
			 redirect($code_img_url);
				 // $this->assign('zn_rs',$zn_rs);
				 // $this->display('wxscan_Erweima');
		 }
		// $code_img_url = I('get.code_img_url');
		// $this->assign('zn_rs',$zn_rs);
		// $this->display('wxscan_Erweima');
		
	}

	public function notify()
	{
		$q = new \Org\Util\ErweimaPay();
		$result = $q->notify();

		Log::debugArr($result, 'erweima_notify');

		if ($result['status'] == 0) {//验签失败
			return 0;
		}

		Log::debugArr($result['payStatus'], 'erweima_notify');
		if ($result['payStatus'] == 'success') {//支付成功
			$balance = M('balance');
			$account = M('accountinfo');

			$order_no = $result['orderId'];
			$order_time = time();  //cltime

			$data1 = $balance->where(array('balanceno' => $order_no))->find();

			if (!$data1) {
				outjson('PayNum Not Founded!!! ');
				return false;
			}

			if ($data1['isverified'] == 1 && $data1['status'] == 1) {
				echo success;
				return false;
			}

			$order_amount = $result['amount'];
			$data['bpprice'] = $order_amount;
			$data['isverified'] = '1'; //入金成功
			$data['status'] = '1'; //完成
			$data['cltime'] = $order_time; //完成
			$data['shibpprice'] = $data1['shibpprice'] + $order_amount; //完成

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

                if($data1['pay_type'] == 14)
                {
                	$typeString = '二维码支付宝';
                }

				$map['uid'] = $data1['uid'];
				$map['type'] = 4;
				$map['oid'] = $data1['bpid'];
				$map['note'] = '用户使用'.$typeString.'支付充值金额[' . $order_amount . ']元';
				$map['balance'] = $account->where(array('uid' => $data1['uid']))->sum('balance');
				$map['op_id'] = $data1['uid'];
				$map['dateline'] = time();
				M("money_flow")->add($map);

				echo success;
			} else {
				outjson('Failed');
			}
		} else {
			outjson('Failed');
		}

	}
    

}

