<?php
namespace Home\Controller;
use Think\Controller;

class WeixinController extends Controller {
    public function  index(){
        // 导入微信支付sdk
        Vendor('Weixinpay.Weixinpay');
        $wxpay=new \Weixinpay();
        // 获取jssdk需要用到的数据
		
        $data=$wxpay->getParameters($wxpay);
		//var_dump($data);exit;
        // 将数据分配到前台页面
       $assign=array(
            'data'=>json_encode($data)
            );
		$this->assign('assign',$assign);
		$this->assign('data',json_encode($data));
        $this->assign('appId',$data['appId']);
		$this->assign('timeStamp',$data['timeStamp']);
		$this->assign('nonceStr',$data['nonceStr']);
		$this->assign('package',$data['package']);
		$this->assign('signType',$data['signType']);
		$this->assign('paySign',$data['paySign']);
        $this->display();
    }
	/**
	 * notify_url接收页面
	 */
	public function notify(){
    // 导入微信支付sdk
    Vendor('Weixinpay.Weixinpay');
    $wxpay=new \Weixinpay();
    $result=$wxpay->notify();
	$orderno = $result['out_trade_no'];
    if ($orderno) {
         $balance=M('balance')->where('balanceno='.$orderno)->find();
		 if($balance['isverified'] == 1)
		 {
			$this->success('支付成功', 'User/memberinfo');
			return false;
			exit;
		 }
         //判断订单是否存在，并且判断是否是同一个人操作
         if ($balance) {
            $date['balanceno']=$balance['balanceno'];
            $date['remarks']='充值成功';
            $date['isverified']='1';
            $date['cltime']=time();
            $style=M('balance')->where('balanceno='.$orderno)->save($date);
            //修改客户的帐号余额
            if ($style) {
                //查询订单金额
                $prict=M('balance')->where('balanceno='.$orderno)->find();
                //先取出用户帐号的余额。
                $userprice=M('accountinfo')->where('uid='.$balance['uid'])->find();
                $mydate['balance']=$prict['bpprice']+$userprice['balance'];
                M('accountinfo')->where('uid='.$balance['uid'])->save($mydate);
            }
         }
         $this->redirect('User/memberinfo');   
		}
	}
	
}