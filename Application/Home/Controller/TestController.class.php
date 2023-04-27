<?php
/**
 * @author: FrankHong
 * @datetime: 2016/11/8 15:07
 * @filename: TestController.class.php
 * @description: 代码样例
 * @note:
 * 1.手机验证码使用样例
 * 
 */

namespace Home\Controller;
use Think\Controller;
use Org\Util\Zhongxin;
use Org\Util\Log;
use Org\Util\FileCache;
use Org\Util\Work;

class TestController extends Controller
{

    public function test()
    {
        $req    = new Zhongxin();

        $dataArr    = array(

            'out_trade_no'  => 'ronmei'.time(),
            'total_fee'     => 1,
            'attach'        => '测试商品',
            'body'          => '商品测试啊',
            'mch_create_ip' => '127.0.0.1',
			'sub_openid'    => 'o-4egwbpWHh_QkAmnOsHGz-TYM1I'
        );

        $aaaa = $req->weixin_js_pay($dataArr);



    }

	public function aaaa() 
	{
		return 'asdfasdfa';
	}

    public function order()
    {
        $this->display();
    }


    public function pay()
    {
        $this->display();
    }
    
    public function file_cache()
    {
        $cacheFileName  = WX_TOKEN_PATH.'wx_access_token.tmp';
        $cache          = new FileCache($cacheFileName);
        $cache->set('username', 'afasdfasdfafafa23423423', time() + 3600);
        $username       = $cache->get('username');
        echo $username;
    }


    /**
     * @functionname: index
     * @author: FrankHong
     * @date:
     * @description:
     * @note:
     *
     *
     */
    public function index()
    {

        //Log::debugArr('111111');
        //$this->display('tuiguang');

        $wxObj  = new WxController();
        $wxObj->weixin_oauth();
    }

    public function websocket()
    {
        $work    = new Work();
        $work->work('0.0.0.0:3808');
    }

    public function NumToStr($num) {
        if (stripos($num, 'e') === false)
            return $num;
        $num = trim(preg_replace('/[=\'"]/', '', $num, 1), '"'); //出现科学计数法，还原成字符串
        $result = "";
        while ($num > 0) {
            $v = $num - floor($num / 10) * 10;
            $num = floor($num / 10);
            $result = $v . $result;
        }
        return $result;
    }


    //九龙支付
    public function Jlpay()
    {
        //快捷支付
        // Vendor('Jlpay.demo.QuickPayment');
        // $QuickPayment = new \demoQuickPayment();

        //$QuickPayment::bindCard(123456789);   //绑定
         //$QuickPayment::unbindCard(201710170000024169,123456789); //解绑
        //$QuickPayment::quickPaySms();  //快捷支付短信下发/重发

        //$QuickPayment::rpmBindCardCommit(12331); // 快捷绑卡验证短信

        //网关支付
        // Vendor('Jppay.demo.B2CB2BPayment');
        // $B2CB2BPPayment = new \demoB2CB2BPayment();
        // $res = $B2CB2BPPayment->bankPayment();
        // $this->create($res,'https://jd.kingpass.cn/paygateway/paygateway/bankPayment');

        //支付结果查询
        Vendor('Jlpay.demo.QuickPayment');
        $QuickPayment = new \demoQuickPayment();
        $balanceno = 158801511920227593326843;

        $dataArr = array('orderId' => '55391511930505702934');
        $data = $QuickPayment::payQuery($dataArr);
        //$res = $QuickPayment::asyncNotify($data);

        var_dump($data);
    }

    public function offlineNotifyUrl()
    {
        $data = $_REQUEST;
        Log::debugArr($data,'1111111');

        Vendor('Jlpay.demo.QuickPayment');
        $QuickPayment = new \demoQuickPayment();

        //验证证书签名
        $ret = $QuickPayment::asyncNotify($data);
        if($ret['signStatus'] == 1 && $ret['orderSts'] == 'PD')
        {
            Log::debugArr($ret,'222222');
            echo 'SUCCESS';

            $amount = $amount / 100;    //以分为单位
        }
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

    public function cookie()
    {
        $user_id = $_COOKIE['user_id'];    //判断cookie是否存在
        echo $user_id;
    }
    
}