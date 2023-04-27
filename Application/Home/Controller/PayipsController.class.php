<?php
namespace Home\Controller;

use Think\Controller;
use Org\Util\Ipspay;
use Org\Util\Log;


class PayipsController extends CommonController
{
    public function _initialize()
    {

    }


    /**
     * @functionname: pay_ips
     * @author: FrankHong
     * @date: 2017-02-06 17:47:47
     * @description: 环迅支付处理
     * @note:
     *
     * array(16) {
            ["MsgId"]=>
            string(5) "00001"
            ["ReqDate"]=>
            string(14) "20170206173741"
            ["MerCode"]=>
            string(6) "192545"
            ["MerName"]=>
            string(0) ""
            ["Account"]=>
            string(10) "1925450015"
            ["MerBillNo"]=>
            string(17) "Mer20170206173731"
            ["GatewayType"]=>
            string(2) "10"
            ["Date"]=>
            string(8) "20170206"
            ["RetEncodeType"]=>
            string(2) "17"
            ["CurrencyType"]=>
            string(3) "156"
            ["Amount"]=>
            string(4) "0.01"
            ["BillEXP"]=>
            string(1) "2"
            ["GoodsName"]=>
            string(6) "环迅"
            ["ServerUrl"]=>
            string(41) "http://huanxun.edc6.com/s2snotify_url.php"
            ["Lang"]=>
            string(2) "GB"
            ["Attach"]=>
            string(15) "商户数据包"
        }
     */
    public function pay_ips()
    {
        if(!session('user_id'))
        {
            $this->redirect(U('Register/login'));
        }


		$v_oid	= I('get.ordernum', '');
        $money  =  trim(I('get.money'));
        $payType    = I('get.paytype');
        if($payType == 'pay_ips_zfb')
        {
            $gatewayType    = 11;
        }
        else
        {
            $gatewayType    = 10;
        }

        $dataArr    = array(
            'amount'        => $money,
            'orderDate'     => date('Ymd'),
            'gatewayType'   => $gatewayType,
			'merBillNo'     => $v_oid
        );


        $req        = new Ipspay();
//        vD($dataArr);
//        die();

        $aa = $req->get_pay_img($dataArr);

        if($aa['ret_code'] == 1)
        {
            $imgUrl = $aa['img_url'];
        }

        //Log::debugArr($aa, 'shouxinyi');
        //echo $aa['bankurl'];


		$this->assign('oid', $v_oid);
        $this->assign('zhifuImg', $imgUrl);
        $this->display('Pay/huanxun_ma');
        
    }

    /**
     * @functionname: echo_img
     * @author: FrankHong
     * @date: 2017-02-07 14:36:01
     * @description: 输出二维码
     * @note:
     */
    public function echo_img()
    {
        $url    = urldecode($_GET["data"]);
        $req    = new Ipspay();
		ob_clean();
        $req->create_img_url($url);
    }




	/**
	 * @functionname: get_pay_result
	 * @author: FrankHong
	 * @date: 2017-01-08 17:32:14
	 * @description: 获得支付结果
	 * @note:
	 */
	public function get_pay_result()
	{
		$v_oid	= I('get.oid', '');
		if(!$v_oid)
			outjson(array('status' => 0, 'ret_msg' => '查询失败，缺少充值流水号！'));

		$getArr	= array('v_oid' => $v_oid);
		$req	= new Shouxinyi();
		$aa 	= $req->get_result($getArr);

		Log::debugArr($aa, 'shouxinyi_notify_url');

		$balance    = M('balance');
		$account    = M('accountinfo');

		if($aa == 1)
		{
			$order_no           = $v_oid;
			$order_time         = time();  //cltime

			$data1 = $balance->where(array('balanceno' => $order_no))->find();


			if(!$data1)
			{
				outjson(array('status' => 0, 'ret_msg' => '查询失败，未找到充值流水！'));
			}
			else
			{
				if($data1['isverified'] == 1 && $data1['status'] == 1)
				{
					outjson(array('status' => 1, 'ret_msg' => '充值成功'));
				}

				$order_amount       = $data1['bpprice'];
				$data['isverified'] = '1'; //入金成功
				$data['status']     = '1'; //完成
				$data['cltime']     = $order_time; //完成
				$data['shibpprice'] = $data1['shibpprice'] + $order_amount; //完成

				//$account->startTrans();

				$case = $balance->where(array('balanceno' => $order_no))->save($data);
				$money = $account->where(array('uid' => $data1['uid']))->setInc('balance', $order_amount);
				$money_total = $account->where(array('uid' => $data1['uid']))->setInc('recharge_total', $order_amount);
				if ($case && $money && $money_total)
				{
					//用户资金流水表
					$map['uid']      = $data1['uid'];
					$map['type']     = 4;
					$map['oid']      = $data1['bpid'];
					$map['note']     = '用户使用首信易支付充值金额['.$order_amount.']元';
					$map['op_id']    = $data1['uid'];
					$map['dateline'] = time();
					M("money_flow")->add($map);

					//$balance->commit(); //对数据库的操作
					outjson(array('status' => 1, 'ret_msg' => '充值成功'));
				}
				else
				{
					//$balance->callbak();
					outjson(array('status' => 0, 'ret_msg' => '充值失败'));
				}
			}

		}
        else if($aa == 2)
        {
            outjson(array('status' => 0, 'ret_msg' => '尚未支付！'));
        }
        else
        {
            outjson(array('status' => 0, 'ret_msg' => '支付失败！'));
        }

	}


    /**
     * @functionname: pay_sxy_yinlian
     * @author: FrankHong
     * @date: 2017-01-13 15:05:21
     * @description: 首信易的银联接口
     * @note:
     *
     * array (
            'v_mid' => '10630',
            'v_oid' => '20170113-10630-643774',
            'v_rcvname' => 'test',
            'v_rcvaddr' => 'test',
            'v_rcvtel' => '82652626',
            'v_rcvpost' => '100037',
            'v_amount' => 0.01,
            'v_ymd' => '20170113',
            'v_orderstatus' => '1',
            'v_ordername' => 'test',
            'v_moneytype' => '0',
            'v_url' => 'http://localhost/payease/receive1.php',
            'v_md5info' => '38b264e5bf347b2ef6b07c64e3a9c905',
            'v_pmode' => 126,
        )
     */
    public function pay_sxy_yinlian()
    {
        if(!session('user_id'))
        {
            $this->redirect(U('Register/login'));
        }


        $v_rcvname  = 'test'; //收货人姓名,建议用商户编号代替或者是英文数字。因为首信平台的编号是gb2312的
        $v_rcvaddr  = 'test'; //收货人地址，可用商户编号代替
        $v_rcvtel   = '82652626';   //收货人电话
        $v_rcvpost  = '100037';  //收货人邮编
        $v_amount   = 0.01; //订单金额

        $v_oid	= I('get.ordernum', '');
        $money  =  trim(I('get.money'));

        $dataArr    = array(
            'v_amount'      => $v_amount,
            'v_rcvpost'     => $v_rcvpost,
            'v_rcvtel'      => $v_rcvtel,
            'v_rcvaddr'     => $v_rcvaddr,
            'v_rcvname'     => $v_rcvname,
            'v_oid'			=> $v_oid
        );


        $req        = new ShouxinyiYinlian();


        $aa = $req->opt_pay($dataArr);


        Log::debugArr($aa, 'shouxinyi');
        //echo $aa['bankurl'];


        $this->assign('payrs', $aa);
        $this->display('Pay/shouxinyi_yinlian');

    }

    //中信银联回调地址

    public function get_pay_result_yinlian() 
    {
        $v_oid = I('get.v_oid');
        $getArr = array('v_oid' => $v_oid);
        $req    = new ShouxinyiYinlian();
        $status = $req->get_result($getArr);
        
        $balance    = M('balance');
        $account    = M('accountinfo');

        if(!$v_oid)outjson(array('status' => 0, 'ret_msg' => '查询失败，缺少充值流水号！'));

        if($status == 1)
        {
            $order_no           = $v_oid;
            $order_time         = time();  //cltime

            $data1 = $balance->where(array('balanceno' => $order_no))->find();


            if(!$data1)
            {
                outjson(array('status' => 0, 'ret_msg' => '查询失败，未找到充值流水！'));
            }
            else
            {
                if($data1['isverified'] == 1 && $data1['status'] == 1)
                {
                    outjson(array('status' => 1, 'ret_msg' => '充值成功'));
                }

                $order_amount       = $data1['bpprice'];
                $data['isverified'] = '1'; //入金成功
                $data['status']     = '1'; //完成
                $data['cltime']     = $order_time; //完成
                $data['shibpprice'] = $data1['shibpprice'] + $order_amount; //完成

                //$account->startTrans();

                $case = $balance->where(array('balanceno' => $order_no))->save($data);
                $money = $account->where(array('uid' => $data1['uid']))->setInc('balance', $order_amount);
                $money_total = $account->where(array('uid' => $data1['uid']))->setInc('recharge_total', $order_amount);
                if ($case && $money && $money_total)
                {
                    //用户资金流水表
                    $map['uid']      = $data1['uid'];
                    $map['type']     = 4;
                    $map['oid']      = $data1['bpid'];
                    $map['note']     = '用户使用首信易支付充值金额['.$order_amount.']元';
                    $map['op_id']    = $data1['uid'];
                    $map['dateline'] = time();
                    M("money_flow")->add($map);

                    //$balance->commit(); //对数据库的操作
                    outjson(array('status' => 1, 'ret_msg' => '充值成功'));
                }
                else
                {
                    //$balance->callbak();
                    outjson(array('status' => 0, 'ret_msg' => '充值失败'));
                }
            }

        }
        else if($status == 2)
        {
            outjson(array('status' => 0, 'ret_msg' => '尚未支付！'));
        }
        else
        {
            outjson(array('status' => 0, 'ret_msg' => '支付失败！'));
        }
    }
  
}