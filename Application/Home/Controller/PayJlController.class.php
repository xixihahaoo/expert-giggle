<?php
/**
 * 九龙支付
 * by wanghaidong 2017-10-16
 * --------------------------------
 */

namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;

class PayJlController extends CommonController{

	//绑定快捷支付
	public function bindCard()
	{	
		if(IS_AJAX)
		{	
			$data 	= array();

			$mobile 	= trim(I('post.mobile'));
			$idCard 	= trim(I('post.idCard'));
			$name 		= trim(I('post.name'));
			$bankCard 	= trim(I('post.bankCard'));

			if(!$this->user_id)
			{
				$data['staus'] 	= 0;
				$data['msg']	= '用户编号不存在';
				outjson($data);
			}

			$uid = M('userinfo')->where(array('uid' => $this->user_id))->getField('uid');
			if($this->user_id != $uid)
			{
				$data['staus'] 	= 0;
				$data['msg']	= '没有查到该用户';
				outjson($data);
			}

            if (!preg_match('/^1\d{10}$/', $mobile)) {
                $data['status'] = 0;
                $data['msg'] = '手机号填写错误';
                outjson($data);
            }

           	if(!preg_match("/(^\d{15}$)|(^\d{17}([0-9]|X)$)/",$idCard)) {

                $data['status'] = 0;
                $data['msg'] = '身份证号码填写不正确';
                outjson($data);
        	}

            if (is_numeric($name) || mb_strlen($name) > 15 || empty($name)) {
                $data['status'] = 0;
                $data['msg'] = '姓名填写不正确';
                outjson($data);
            }

            if (!is_numeric($bankCard) || empty($bankCard)) {
                $data['status'] = 0;
                $data['msg'] = '银行卡号填写不正确';
               	outjson($data);
            }
            
            $banksObj = M('JlBanks');

            if($banksObj->field('contract_id')->where(array('user_id' => $this->user_id,'card_sts' => 0))->find())
        	{
                $data['status'] = 0;
                $data['msg'] = '你已经绑定过银行卡';
               	outjson($data);
        	}

	        Vendor('Jlpay.demo.QuickPayment');
	        $QuickPayment = new \demoQuickPayment();

	        $params = [
	            'memberId' => $this->user_id,
	            'orderId' => $this->number_no(),
	            'idNo' => $idCard,
	            'userName' => $name,
	            'phone' => $mobile,
	            'cardNo' => $bankCard
	        ];

	        $res = $QuickPayment::bindCard($params);
	        if($res['rspCode'] == 'IPS00000')
	        {
	        	$banksObj->add(array(
	        		'user_id' 		=> $this->user_id,
	        		'order_id' 		=> $res['orderId'],
	        		'contract_id' 	=> $res['contractId'],
                    'phone'         => $mobile,
                    'id_no'         => $idCard,
                    'card_no'       => $bankCard,
                    'user_name'     => $name,
	        		'bank_name' 	=> $res['bankName'],
	        		'bank_abbr' 	=> $res['bankAbbr'],
	        		'card_type' 	=> $res['cardType'],
	        		'card_sts' 		=> 0
	        	));
	        }

	        $data['status'] 	= $res['rspCode'] == 'IPS00000' ? 1 : 0;
            $data['msg'] 		= $res['rspMessage'];
            $data['contractId']	= $res['contractId'];
           	outjson($data);

		} else 
		{
			$this->display();
		}
	}

	//获取短信验证码
	public function quickPaySms()
	{
		if(IS_AJAX)
		{
			$contractId = trim(I('get.contractId'));
			if(empty($contractId))
			{
		        $data['status'] 	= 0;
	            $data['msg'] 		= '协议号不能为空';
	           	outjson($data);
			}

	        Vendor('Jlpay.demo.QuickPayment');
	        $QuickPayment = new \demoQuickPayment();

	        $params = [
	            'contractId' => $contractId,
	            'memberId' => $this->user_id,
	        ];

	        $res = $QuickPayment::quickPaySms($params);

	        $data['status'] 	= $res['rspCode'] == 'IPS00000' ? 1 : 0;
            $data['msg'] 		= $res['rspMessage'];
           	outjson($data);

		} else {

			$contractId = trim(I('get.contractId'));
			$this->assign('contractId',$contractId);
        	$this->display();
		}
	}

    // 快捷绑卡验证短信（rpmBindCardCommit）
    public  function rpmBindCardCommit()
    {
    	$checkCode 	= trim(I('post.checkcode'));
    	$contractId = trim(I('post.contractId'));
    	if(empty($checkCode))
    	{
	        $data['status'] 	= 0;
            $data['msg'] 		= '验证码不能为空';
           	outjson($data);
    	}
		if(empty($contractId))
		{
	        $data['status'] 	= 0;
            $data['msg'] 		= '协议号不能为空';
           	outjson($data);
		}

        $params = [
            'contractId' => $contractId,
            'checkCode' => $checkCode
        ];

        Vendor('Jlpay.demo.QuickPayment');
        $QuickPayment = new \demoQuickPayment();
        $res = $QuickPayment::rpmBindCardCommit($params);

        if(isset($res['cardSts']))
        {
        	$banksObj 	= M('JlBanks');
        	$status 	= $banksObj->where(array('user_id' => $this->user_id,'contract_id' => $res['contractId']))->setField('card_sts',$res['cardSts']);
        	if($status)
        	{
		        $data['status'] 	= 1;
		        $data['msg'] 		= $res['rspMessage'];
		       	outjson($data);
        	}
        }

        $data['status'] 	= 0;
        $data['msg'] 		= $res['rspMessage'];
       	outjson($data);
    }


    //银行卡解绑
    public function unbindBank()
    {
        if(IS_AJAX)
        {
            $id = trim(I('post.id'));

            $data = array();

            if(empty($id))
            {
                $data['status'] = 0;
                $data['msg']    = '请选择要解绑的银行卡';
                $this->ajaxReturn($data,'JSON');
            }

            $JlBanksObj = M('JlBanks');

            $bank = $JlBanksObj->where(array('user_id' => $this->user_id,'id' => $id))->find();
            if(!$bank)
            {
                $data['status'] = 0;
                $data['msg']    = '系统没有查到此银行卡';
                $this->ajaxReturn($data,'JSON');
            }

            Vendor('Jlpay.demo.QuickPayment');
            $QuickPayment = new \demoQuickPayment();

            $res = $QuickPayment::unbindCard($bank['contract_id'],$bank['user_id']);

            if($res['rspCode'] == 'IPS00000')
            {
                $JlBanksObj->where(array('user_id' => $this->user_id,'id' => $id))->delete();

                $data['status'] = 1;
                $data['msg']    = $res['rspMessage'];
                $this->ajaxReturn($data,'JSON');

            } else {
                $data['status'] = 0;
                $data['msg']    = $res['rspMessage'];
                $this->ajaxReturn($data,'JSON');
            }
        } else {
            $banks = M('JlBanks')->where(array('user_id' => $this->user_id))->find();
            $this->assign('bank',$banks);
            $this->display();
        }
    }


    //快捷支付预下单
    public function quickPayInit()
    {
        $ordernum   = trim(I('get.ordernum'));

        if(empty($ordernum))
        {
            $this->error('必传参数不能为空');
            exit;
        }
        
        $balance = M('balance')->where(array('balanceno' => $ordernum))->find();
        if(!$balance)
        {
            $this->error('订单不存在');
            exit;
        }

        if ($balance['isverified'] == 1 && $balance['status'] == 1) {
            $this->error('订单已经充值');
            exit;
        }

        $bank = M('JlBanks')->where(array('user_id' => $balance['uid'],'card_sts' => 0))->find();
        if(!$bank)
        {
            $this->error('尚未绑定快捷支付');
            exit;
        }

        $params = [
            'memberId'          => $bank['user_id'],
            'orderId'           => $balance['balanceno'],
            'contractId'        => $bank['contract_id'],
            'amount'            => $balance['bpprice'] * 100,   //交易金额 String(11)以分为单位,有效长度1-11
            'orderTime'         => date('YmdHis',$balance['bptime']),    //格式YYYYMMDDHHmmss
            'clientIP'          => get_client_ip(),      //商户发送的客户端IP
            'offlineNotifyUrl'  => U('Home/PayJlNotifyUrl/offlineNotifyUrl', '', true, true)
        ];

        Vendor('Jlpay.demo.QuickPayment');
        $QuickPayment = new \demoQuickPayment();
        $res = $QuickPayment::quickPayInit($params);

        if($res['rspCode'] != 'IPS00000')
        {
            $this->error($res['rspMessage']);
            exit;
        } else {
            $this->assign('balance',$balance);
            $this->assign('bank',$bank);
            $this->display();
        }
    }

    // * 快捷支付6.5 快捷支付提交
    public function quickPayCommit()
    {
        $balanceno  = trim(I('post.balanceno'));
        $checkCode  = trim(I('post.checkCode'));

        $data = array();

        if(empty($balanceno))
        {
            $data['status'] = 0;
            $data['msg']    = '订单号不能为空';
            $this->ajaxReturn($data,'JSON');
        }

        if(empty($checkCode))
        {
            $data['status'] = 0;
            $data['msg']    = '验证码不能为空';
            $this->ajaxReturn($data,'JSON');
        }
        
        $balance = M('balance')->where(array('balanceno' => $balanceno))->find();
        if(!$balance)
        {
            $data['status'] = 0;
            $data['msg']    = '订单不存在';
            $this->ajaxReturn($data,'JSON');
        }

        if ($balance['isverified'] == 1 && $balance['status'] == 1) 
        {
            $data['status'] = 0;
            $data['msg']    = '订单已经充值';
            $this->ajaxReturn($data,'JSON');
        }

        $bank = M('JlBanks')->where(array('user_id' => $balance['uid'],'card_sts' => 0))->find();
        if(!$bank)
        {
            $data['status'] = 0;
            $data['msg']    = '尚未绑定快捷支付';
            $this->ajaxReturn($data,'JSON');
        }

        $params = [
            'memberId'          => $bank['user_id'],
            'orderId'           => $balance['balanceno'],
            'contractId'        => $bank['contract_id'],
            'checkCode'         => $checkCode,
            'amount'            => $balance['bpprice'] * 100,   //交易金额 String(11)以分为单位,有效长度1-11
            'orderTime'         => date('YmdHis',$balance['bptime']),    //格式YYYYMMDDHHmmss
            'clientIP'          => get_client_ip(),      //商户发送的客户端IP
            'offlineNotifyUrl'  => U('Home/PayJlNotifyUrl/offlineNotifyUrl', '', true, true)
        ];

        Vendor('Jlpay.demo.QuickPayment');
        $QuickPayment = new \demoQuickPayment();
        $res = $QuickPayment::quickPayCommit($params);

        if($res['rspCode'] != 'IPS00000')
        {
            $data['status'] = 0;
            $data['msg']    = $res['rspMessage'];
            $this->ajaxReturn($data,'JSON');
        } else {
            $data['status'] = 1;
            $data['msg']    = $res['rspMessage'];
            $this->ajaxReturn($data,'JSON');
        }
    }


    //九龙网关支付
    public function bankPayment()
    {
        if(IS_POST)
        {
            $data = array();

            $bank       = trim(I('post.bank'));
            $ordernum   = trim(I('post.ordernum'));

            if(empty($bank))
            {
                $data['status'] = 0;
                $data['msg']    = '请选择银行';
                $this->ajaxReturn($data,'JSON');
            }

            if(empty($ordernum))
            {
                $data['status'] = 0;
                $data['msg']    = '订单不存在';
                $this->ajaxReturn($data,'JSON');
            }

            $balance = M('balance')->where(array('balanceno' => $ordernum))->find();
            if(!$balance)
            {
                $data['status'] = 0;
                $data['msg']    = '订单不存在';
                $this->ajaxReturn($data,'JSON');
            }

            if ($balance['isverified'] == 1 && $balance['status'] == 1) 
            {
                $data['status'] = 0;
                $data['msg']    = '订单已经充值';
                $this->ajaxReturn($data,'JSON');
            }

            $params = [
                'pageReturnUrl'     => U('Home/User/index', '', true, true),
                'notifyUrl'         => U('Home/PayJlNotifyUrl/offlineNotifyUrl', '', true, true),
                'memberId'          => $balance['uid'],
                'orderTime'         => date('YmdHis',$balance['bptime']),    //格式YYYYMMDDHHmmss
                'orderId'           => $balance['balanceno'],
                'totalAmount'       => $balance['bpprice'] * 100,   //交易金额 String(11)
                'bankAbbr'          => $bank
            ];

            Vendor('Jppay.demo.B2CB2BPayment');
            $B2CB2BPPayment = new \demoB2CB2BPayment();
            $res = $B2CB2BPPayment->bankPayment($params);

            if(!$res['orderId'])
            {
                die('支付失败');
            }

            $this->create($res,'https://jd.kingpass.cn/paygateway/paygateway/bankPayment');


            // $dataArr = array();

            // $dataArr['order_no']    = $balance['balanceno'];
            // $dataArr['code']        = generate_code(6);
            // $dataArr['post_data']   = serialize($params);
            // $dataArr['url']         = 'https://jd.kingpass.cn/paygateway/paygateway/bankPayment';

            // $obj = M();

            // $res = $obj->table('dict_jl_pay')->add($dataArr);
            // // echo M()->getLastSql();die;

            // if($res)
            // {
            //     $data['status'] = 1;
            //     $data['msg']    = '请复制链接';
            //     $data['code']   = $dataArr['code'];
            //     $this->ajaxReturn($data,'JSON');
            // } else {
            //     $data['status'] = 0;
            //     $data['msg']    = '订单生成失败';
            //     $this->ajaxReturn($data,'JSON');
            // }

        } else {

            $ordernum = trim(I('get.ordernum'));
            if(empty($ordernum))
            {
                $this->error('订单不存在');
            }
            $this->assign('ordernum',$ordernum);
            $this->display();
        }
    }

    //复制链接进行支付
    public function copyLink()
    {
        $code = trim(I('get.code'));

        if(empty($code))
        {
            $this->error('订单编号不能为空');
            exit;
        }

        $obj = M();
        $data = $obj->table('dict_jl_pay')->where(array('code' => $code))->find();

        if(!$data)
        {
            $this->error('没有该订单');
            exit;  
        }

        $zn_rs['order_no']      = $data['order_no'];
        $zn_rs['code_img_url']  = 'http://'.$_SERVER['HTTP_HOST'].'/Home/pay/'.$code;

        $this->assign('zn_rs',$zn_rs);
        $this->display();
    }


	//获取订单号
    private function number_no()
    {
        return $this->user_id.time().mt_rand();
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
}
       
