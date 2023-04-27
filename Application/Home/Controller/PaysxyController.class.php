<?php
namespace Home\Controller;

use Think\Controller;
use Org\Util\Shouxinyi;
use Org\Util\ShouxinyiYinlian;
use Org\Util\Log;


class PaysxyController extends CommonController
{
       
     public function _initialize(){

     }

    /**
     * 首信易微信扫码支付
     * @author wang <admin>
     */
    public function pay_sxy()
    {
        if(!session('user_id'))
        {
            $this->redirect(U('Register/login'));
        }


        $v_rcvname='test'; //收货人姓名,建议用商户编号代替或者是英文数字。因为首信平台的编号是gb2312的
        $v_rcvaddr='test'; //收货人地址，可用商户编号代替
        $v_rcvtel='82652626';   //收货人电话
        $v_rcvpost='100037';  //收货人邮编

		$v_oid	 =  I('get.ordernum', '');
        $money   =  trim(I('get.money'));
        $paycode =  271;//trim(I('get.paycode'));

        $balance = M('balance')->where(array('balanceno' => $v_oid))->find();
        if(!$balance)
        {
            $this->redirect('User/index');
        }

        if($balance['bpprice'] != $money)
        {
            $this->redirect('User/index');
        }


        $dataArr    = array(
            'v_amount'      => $money,
            'v_rcvpost'     => $v_rcvpost,
            'v_rcvtel'      => $v_rcvtel,
            'v_rcvaddr'     => $v_rcvaddr,
            'v_rcvname'     => $v_rcvname,
			'v_oid'			=> $v_oid,
            'pay_code'      => $paycode
        );


        $req        = new Shouxinyi();

        $aa = $req->get_pay_img($dataArr);


        Log::debugArr($aa, 'shouxinyi');
        // echo $aa['bankurl'];


        if($aa)
        {
            $zhifuImg	= $aa['bankurl'];
        }

		$this->assign('oid', $v_oid);
        $this->assign('zhifuImg', $zhifuImg);
        $this->display('Pay/shouxinyi_ma');
        
    }

    /**
     * 首信易支付通知
     * @author wang <admin>
     */
    
    public function sxy_notify_url()
    {

        $v_oid       = I('get.v_oid');                  //订单编号组
        $v_pmode     = urldecode(I('get.v_pmode'));     //支付方式组
        $v_pstatus   = I('get.v_pstatus');              //支付状态组
        $v_pstring   = urldecode(I('get.v_pstring'));   //支付结果说明
        $v_amount    = I('get.v_amount');               //订单支付金额
        $v_count     = I('get.v_count');                //订单个数
        $v_moneytype = I('get.v_moneytype');            //订单支付币种
        $v_mac       = I('get.v_mac');                  //数字指纹（v_mac）
        $v_md5money  = I('get.v_md5money');             //数字指纹（v_md5money）
        $v_sign      = I('get.v_sign');                 //验证商城数据签名（v_sign）

        Log::debugArr(I('get.'), 'shouxinyi_notify');
        //拆分参数
        $sp = '|_|';
        $a_oid       = explode($sp, $v_oid);
        $a_pmode     = explode($sp, $v_pmode);
        $a_pstatus   = explode($sp, $v_pstatus);
        $a_pstring   = explode($sp, $v_pstring);
        $a_amount    = explode($sp, $v_amount);
        $a_moneytype = explode($sp, $v_moneytype);
        //MD5校验v c 
        $key   = 'z10263028';//商户的密钥
        $data1 = $v_oid.$v_pmode.$v_pstatus.$v_pstring.$v_count;

        $req        = new Shouxinyi();
        $mac        = $req->hmac($key, $data1);

        $data2      = $v_amount.$v_moneytype;
        $md5money   = $req->hmac($key, $data2);

        if($mac == $v_mac or $md5money == $v_md5money)
        {
            $balanceObj = M('balance');
            $accountObj = M('accountinfo');
            $flowObj    = M('MoneyFlow');

            
            //更改数据库状态
            //通过for循环查看该笔通知有几笔订单,并对于更改数据库状态
             for($i=0;$i<$v_count;$i++)
             {
                if($a_pstatus[$i] == '1')
                {
                	echo("sent");
                    if(!$a_oid[$i])
                    {
                        $msg = array('v_oid' => $a_oid[$i],'msg' => '查询失败，缺少充值流水号！');
                        Log::debugArr($msg, 'shouxinyi_notify');
                        return false;
                    }

                    if($balanceObj->where(array('b_type' => 1, 'balanceno' => $a_oid[$i],'isverified' => 1,'status' => 1))->find())
                    {
                        $msg = array('v_oid' => $a_oid[$i],'msg' => '已经充值了');
                        Log::debugArr($msg, 'shouxinyi_notify');
                        return false;
                    }

                    $info = $balanceObj->field('uid,bpid')->where(array('b_type' => 1,'balanceno' => $a_oid[$i],'isverified' => 0,'status' => 0))->find();
                    
                    $data = array(
                        'status'     => 1,
                        'isverified' => 1,
                        'bpprice'    => $a_amount[$i],
                        'cltime'     => time()
                    );


                    if($info)
                    {
                    	if($balanceObj->where(array('b_type' => 1, 'bpid' => $info['bpid'],'isverified' => 1,'status' => 1))->find())
                    	{
                    		return false;
                    	}
                    	
                    	$balance  = $balanceObj->where(array('b_type' => 1,'balanceno' => $a_oid[$i],'isverified' => 0,'status' => 0))->save($data);
                    	
                    	if($balance)
                    	{
                    		$account  = $accountObj->where(array('uid' => $info['uid']))->setInc('balance',$a_amount[$i]);
                    	
                    		$recharge = $accountObj->where(array('uid' => $info['uid']))->setInc('recharge_total',$a_amount[$i]);
                    		 
                        if($account && $recharge)
                        {
                            $infos = M('userinfo')->field('uid,otype')->where(array('uid' => $info['uid']))->find();
                            if($infos['otype'] == 5)
                            {
                               $flow['user_type'] = 2;
                            }

                            $flow['uid']      = $infos['uid'];
                            $flow['type']     = 4;
                            $flow['oid']      = $info['bpid'];
                            $flow['note']     = '用户使用首信易支付充值金额['.$a_amount[$i].']元';
                            $flow['op_id']    = $infos['uid'];
                            $flow['balance']  = $accountObj->where(array('uid' => $infos['uid']))->sum('balance');
                            $flow['dateline'] = time();

                            if($flowObj->add($flow))
                            {
                                $msg = array('v_oid' => $a_oid[$i],'uid' => $flow['uid'],'oid' => $flow['oid'],'msg' => '数据库插入成功');
                            } else {
                                $msg = array('v_oid' => $a_oid[$i],'uid' => $flow['uid'],'oid' => $flow['oid'],'msg' => '数据库插入失败');
                            }
                        }
                      }
                    }
                }
                else if($a_pstatus[$i] == '3')
                {
                    $msg = array('v_oid' => $a_oid[$i],'msg' => '支付失败');
                    $data = array(
                        'status'     => 1,
                        'isverified' => 0,
                        'bpprice'    => $a_amount[$i],
                        'cltime'     => time()
                    );
                    $balanceObj->where(array('b_type' => 1,'balanceno' => $a_oid[$i],'isverified' => 0,'status' => 0))->save($data);
                }
                else
                {
                    $msg = array('v_oid' => $a_oid[$i],'msg' => '待处理');
                }
                Log::debugArr($msg, 'shouxinyi_notify');
             }
        } else
        {
            echo("error");
            echo("<br>");
        }


    }



    /**
     * @functionname: pay_sxy_yinlian
     * @author: FrankHong
     * @date: 2017-01-13 15:05:21
     * @description: 首信易银联接口
     * @note:
     */
    public function pay_sxy_yinlian()
    {
        // if(!session('user_id'))
        // {
        //     $this->redirect(U('Register/login'));
        // }
        
        if(trim(I('get.model')))
        {
            $return_url = 'http://'.$_SERVER['HTTP_HOST'].'/Ucenter/Balancef/recharge';
        } else {
            $return_url = 'http://'.$_SERVER['HTTP_HOST'].'/Home/Paysxy/get_pay_result_yinlian';
        }


        $v_rcvname  = 'test'; //收货人姓名,建议用商户编号代替或者是英文数字。因为首信平台的编号是gb2312的
        $v_rcvaddr  = 'test'; //收货人地址，可用商户编号代替
        $v_rcvtel   = '82652626';   //收货人电话
        $v_rcvpost  = '100037';  //收货人邮编

        $v_oid  = I('get.ordernum', '');
        $money  =  trim(I('get.money'));
        $v_amount = $money;

        $balance = M('balance')->where(array('balanceno' => $v_oid))->find();
        if(!$balance)
        {
            $this->redirect('User/index');
        }

        if($balance['bpprice'] != $v_amount)
        {
            $this->redirect('User/index');
        }

        

        $dataArr    = array(
            'v_amount'      => $v_amount,
            'v_rcvpost'     => $v_rcvpost,
            'v_rcvtel'      => $v_rcvtel,
            'v_rcvaddr'     => $v_rcvaddr,
            'v_rcvname'     => $v_rcvname,
            'v_oid'         => $v_oid,
            'v_url'         => $return_url
        );


        $req        = new ShouxinyiYinlian();


        $aa = $req->opt_pay($dataArr);


        Log::debugArr($aa, 'shouxinyi');
        //echo $aa['bankurl'];


        $this->assign('payrs', $aa);
        $this->display('Pay/shouxinyi_yinlian');

    }

    //首信易银联回调地址

    public function get_pay_result_yinlian() 
    {
        sleep(1);
        $v_oid = I('get.v_oid');
        $getArr = array('v_oid' => $v_oid);
        $req    = new ShouxinyiYinlian();
        $status = $req->get_result($getArr);

        $balance    = M('balance');
        if(!$v_oid)
        {
            $this->redirect('payok',array('msg' => '缺少充值流水号'));  //失败
        }

        if($status == 1)
        {
            $order_no           = $v_oid;
            $order_time         = time();  //cltime

            $data1 = $balance->where(array('balanceno' => $order_no))->find();


            if(!$data1)
            {
                $this->redirect('payok',array('msg' => '未找到充值流水号'));  //失败
            }
            else
            {
                if($data1['isverified'] == 1 && $data1['status'] == 1)
                {
                    $this->redirect('payok',array('msg' => '充值成功'));  //成功
                }
                else
                {

                  $this->redirect('payok',array('msg' => '充值失败'));  //失败
                }
            }

        }
        else if($status == 2)
        {
            $this->redirect('payok',array('msg' => '尚未支付'));  //失败
        }
        else
        {
            $this->redirect('payok',array('msg' => '支付失败'));  //失败
        }
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
        $v_oid  = I('get.oid', '');
        if(!$v_oid)
            outjson(array('status' => 0, 'ret_msg' => '查询失败，缺少充值流水号！'));

        $getArr = array('v_oid' => $v_oid);
        $req    = new Shouxinyi();
        $desc   = $req->get_result($getArr);

        $aa     = $desc['pstatus'];  //状态
        $amount = $desc['amount'];

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
                return false;
            }
            else
            {
                $data2 = $balance->where(array('status' => 1,'isverified' => 1,'bpid' => $data1['bpid']))->find();
                if($data2)
                {
                    outjson(array('status' => 1, 'ret_msg' => '已经充值了'));
                    return false;
                }

                $order_amount       = $amount;
                $data['bpprice']    = $order_amount;
                $data['isverified'] = '1'; //入金成功
                $data['status']     = '1'; //完成
                $data['cltime']     = $order_time; //完成
                $data['shibpprice'] = $data1['shibpprice'] + $order_amount; //完成

                //$account->startTrans();

                $case = $balance->where(array('balanceno' => $order_no))->save($data);
                if ($case)
                {
                    $money = $account->where(array('uid' => $data1['uid']))->setInc('balance', $order_amount);
                    $money_total = $account->where(array('uid' => $data1['uid']))->setInc('recharge_total', $order_amount);
                }
                    //用户资金流水表
                if($money && $money_total)
                {
                        $info = M('userinfo')->where(array('uid' => $data1['uid']))->find();
                        if($info['otype'] == 5)
                        {
                           $map['user_type'] = 2;
                        }
                        $map['uid']      = $data1['uid'];
                        $map['type']     = 4;
                        $map['oid']      = $data1['bpid'];
                        $map['note']     = '用户使用首信易支付充值金额['.$order_amount.']元';
                        $map['balance']  = $account->where(array('uid' => $data1['uid']))->sum('balance');
                        $map['op_id']    = $data1['uid'];
                        $map['dateline'] = time();
                        M("money_flow")->add($map);
                        outjson(array('status' => 1, 'ret_msg' => '充值成功'));
                } else {
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
    
  
    /*支付之后跳转的页面*/
    public function payok()
    {
        $msg = I('get.msg');   
        $this->assign('msg',$msg);
        $this->display('Pay/payok');
    }
}