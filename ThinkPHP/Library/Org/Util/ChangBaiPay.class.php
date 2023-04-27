<?php
/**
 * 畅佰支付
 */
namespace Org\Util;
use Org\Util\Log;
use Think\Exception;

class ChangBaiPay
{
    // 测试环境
//    private $p1_MerId = "CHANG1498011763166";
//    private $merchantKey = "fd40bef8448e4e2fa52d0dfa530d53b6";#"e57mC70otA4u0N159AK50A41mLo8WB6zPtc40u0733V6BRPVLiI5kWCmyVS2";
//    private $p1_MerId = "CHANG1489494882108";
//    private $merchantKey = "wa3ojl0x5qaom19xexpzdbdcikpcvdd3b8dplza8vxn2ta78mp84l1jfthvn";#"e57mC70otA4u0N159AK50A41mLo8WB6zPtc40u0733V6BRPVLiI5kWCmyVS2";
    // 正式环境
    private $p1_MerId = "CHANG1498206815128";
    private $merchantKey = "kvy6ei6i3xu788zx35m0oc622puw65ocdsretkybn4gltvt5jqtfq9vuzfqm";#"e57mC70otA4u0N159AK50A41mLo8WB6zPtc40u0733V6BRPVLiI5kWCmyVS2";

    private $wx_p1_MerId = 'CHANG1496819669357';
    private $wx_merchantKey = 'ox5bpq89670v0ib1vdu8yk6h34504g01z5flzl178mnt5dlo8ppm17xz0qnc';#"e57mC70otA4u0N159AK50A41mLo8WB6zPtc40u0733V6BRPVLiI5kWCmyVS2";

    private $logName = "pay_cb_html.log";

    #	产品通用接口测试请求地址
    private $reqURL_onLine = "https://changcon.92up.cn/controller.action";   #生产地址
    #	订单查询接口请求地址
//    private $queryURL_onLine = "https://gateway.92up.cn/controller.action";
    #	退款接口正式请求地址
//    private $reqURL_RefOrd	= "https://gateway.92up.cn/controller.action";   #生产地址
    #	代付接口请求地址
//    private $transUrl_onLine = "https://gateway.92up.cn/transAccs.action";
    #	短信接口请求地址
//    private $smsUrl_onLine = "https://gateway.92up.cn/controller.action";

    private $notifyUrl = "https://changcon.92up.cn/controller.action";

    public function __construct()
    {
        $this->notifyUrl = U('home/PayCb/notify', '', true, true);
    }


    public function getPostData($type, $params)
    {

        if($type == 'WEIXIN' || $type == 'ALIPAY'){
            $this->p1_MerId = $this->wx_p1_MerId;
            $this->merchantKey = $this->wx_merchantKey;
            //$this->reqURL_onLine = "https://gateway.92up.cn/controller.action";
        }

        $orderNum = $params['balanceno'];
        $amount = $params['bpprice'];//单位：元

        #	商家设置用户购买商品的支付信息.
        ##畅佰支付平台统一使用GBK编码方式,参数如用到中文，请注意转码
        #	业务类型,固定值"Buy"
        $p0_Cmd = "Buy";

        #	若不为""，提交的订单号必须在自身账户交易中唯一;为""时，畅佰支付会自动生成随机的商户订单号.
        $p2_Order = $orderNum;//$_REQUEST['p2_Order'];

        #	交易币种,固定值"CNY".
        $p3_Cur = "CNY";

        #	支付金额,必填.
        ##单位:元，精确到分.
        $p4_Amt	= $amount;//$_REQUEST['p4_Amt'];

        #	商品名称
        $p5_Pid = '';

        #	商品种类
        $p6_Pcat = '恒生国际';//$_REQUEST['p6_Pcat'];

        #	商品描述
        $p7_Pdesc = '恒生国际';

        #	商户接收支付成功数据的地址,支付成功后畅佰支付会向该地址发送两次成功通知.
        $p8_Url = $this->notifyUrl;//$_REQUEST['p8_Url'];

        #	商户扩展信息
        ##商户可以任意填写1K 的字符串,支付成功时将原样返回.
        $p9_MP = "";//$_REQUEST['p9_MP'];

        #	支付通道编码
        ##默认为"NOCARDGATEWAY"
        $pa_FrpId = $type;//$_REQUEST['pa_FrpId'];


        //==============================================================
        #	商户用户ID
        $pb_CusUserId = "";//$_REQUEST['pb_CusUserId'];
        #	微信公众号openid
        $pb_OpenId = "";//$_REQUEST['pb_OpenId'];
        #	授权码
        $pb_AuthCode = "";//$_REQUEST['pb_AuthCode'];
        #	子商户号
        $p4_sonCustNumber = "";//$_REQUEST['p4_sonCustNumber'];
        #	卡号
        $pc_CardNo = "";//$_REQUEST['pc_CardNo'];
        #	信用卡有效期（年）
        $pc_ExpireYear = "";//$_REQUEST['pc_ExpireYear'];
        #	信用卡有效期（月）
        $pc_ExpireMonth = "";//$_REQUEST['pc_ExpireMonth'];
        #	信用卡CVV 3或4位
        $pc_CVV = "";//$_REQUEST['pc_CVV'];
        #	姓名
        $pd_Name = "";//$_REQUEST['pd_Name'];
        #	证件类型
        $pe_CredType = $_REQUEST['pe_CredType'];
        #	证件号
        $pe_IdNum = "";//$_REQUEST['pe_IdNum'];
        #	银行预留手机号
        $pf_PhoneNum = "";//$_REQUEST['pf_PhoneNum'];
        #	短信验证码标识
        $pf_SmsTrxId = "";//$_REQUEST['pf_SmsTrxId'];
        #	短信验证码
        $pf_kaptcha = "";//$_REQUEST['pf_kaptcha'];
        #	银行编码
        $p10_BC = "";//$_REQUEST['p10_BC'];
        //==============================================================

        #调用签名函数生成签名串
        $hmac = $this->getReqHmacString($p0_Cmd,$p2_Order,$p3_Cur,$p4_Amt,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$p9_MP,$pa_FrpId,
        $pb_CusUserId,$pb_OpenId,$pb_AuthCode,$p4_sonCustNumber,$pc_CardNo,$pc_ExpireYear,$pc_ExpireMonth,
        $pc_CVV,$pd_Name,$pe_CredType,$pe_IdNum,$pf_SmsTrxId,$pf_kaptcha,$p10_BC);
        $_data = array(
            'p0_Cmd'=>$p0_Cmd,
            'p1_MerId'=>$this->p1_MerId,
            'p2_Order'=>$p2_Order,
            'p3_Cur'=>$p3_Cur,
            'p4_Amt'=>$p4_Amt,
            'p5_Pid'=>$p5_Pid,
            'p6_Pcat'=>$p6_Pcat,
            'p7_Pdesc'=>$p7_Pdesc,
            'p8_Url'=>$p8_Url,
            'p9_MP'=>$p9_MP,
            'pa_FrpId'=>$pa_FrpId,
            'pb_CusUserId'=>$pb_CusUserId,
            'pb_OpenId'=>$pb_OpenId,
            'pb_AuthCode'=>$pb_AuthCode,
            'p4_sonCustNumber'=>$p4_sonCustNumber,
            'pc_CardNo'=>$pc_CardNo,
            'pc_ExpireYear'=>$pc_ExpireYear,
            'pc_ExpireMonth'=>$pc_ExpireMonth,
            'pc_CVV'=>$pc_CVV,
            'pd_Name'=>$pd_Name,
            'pe_CredType'=>$pe_CredType,
            'pe_IdNum'=>$pe_IdNum,
            'pf_SmsTrxId'=>$pf_SmsTrxId,
            'pf_kaptcha'=>$pf_kaptcha,
            'pg_BankCode'=>$p10_BC,
            'hmac'=>$hmac
        );


        return $_data;
    }

    public function postOrder($type, $params)
    {
        $_data = $this->getPostData($type, $params);
        Log::debugArr('postOrder params string :'.$_data, 'cbpay');
        $curl = new CurlHTTPClient();
        $res = $curl->send_post_data($this->reqURL_onLine, $_data);
        $resObj = json_decode($res);
        if(json_last_error()){
            Log::debugArr('postOrder Error code:'.$resObj, 'cbpay');
            $return = array('status' => 0, 'msg' => 'Error');
        }else{
            $responseData = (array)$resObj;
            if ($responseData['r1_Code'] == 1) {//下单成功
                Log::debugArr('postOrder success', 'cbpay');
                Log::debugArr($responseData, 'qtpay');
                $return = array('status' => 1, 'msg' => 'Success', 'codeUrl' => $responseData['r3_PayInfo']);
            } else {
                Log::debugArr('postOrder Error code:'.$responseData['r1_Code'], 'cbpay');
                $return = array('status' => 0, 'msg' => 'Error');
            }
        }
        return $return;
    }

#function getReqHmacString($p0_Cmd,$p2_Order,$p3_Cur,$p4_Amt,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$p9_MP,$pa_FrpId,$p10_BC)
    private function getReqHmacString($p0_Cmd,$p2_Order,$p3_Cur,$p4_Amt,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$p9_MP,$pa_FrpId,$pb_CusUserId,$pb_OpenId,$pb_AuthCode,$p4_sonCustNumber,$pc_CardNo,$pc_ExpireYear,$pc_ExpireMonth,
                              $pc_CVV,$pd_Name,$pe_CredType,$pe_IdNum,$pf_SmsTrxId,$pf_kaptcha,$p10_BC)
    {
        #进行签名处理，一定按照文档中标明的签名顺序进行
        $sbOld = "";
        #加入业务类型
        $sbOld = $sbOld.$p0_Cmd;
        #加入商户编号
        $sbOld = $sbOld.$this->p1_MerId;
        #加入商户订单号
        $sbOld = $sbOld.$p2_Order;
        #加入交易币种
        $sbOld = $sbOld.$p3_Cur;
        #加入支付金额
        $sbOld = $sbOld.$p4_Amt;
        #加入商品名称
        $sbOld = $sbOld.$p5_Pid;
        #加入商品分类
        $sbOld = $sbOld.$p6_Pcat;
        #加入商品描述
        $sbOld = $sbOld.$p7_Pdesc;
        #加入商户接收支付成功数据的地址
        $sbOld = $sbOld.$p8_Url;
        #加入商户扩展信息
        $sbOld = $sbOld.$p9_MP;
        #加入支付通道编码
        $sbOld = $sbOld.$pa_FrpId;
        #
        $sbOld = $sbOld.$pb_CusUserId;
        #
        $sbOld = $sbOld.$pb_OpenId;
        #
        $sbOld = $sbOld.$pb_AuthCode;
        #
        $sbOld = $sbOld.$p4_sonCustNumber;
        #
        $sbOld = $sbOld.$pc_CardNo;
        #
        $sbOld = $sbOld.$pc_ExpireYear;
        #
        $sbOld = $sbOld.$pc_ExpireMonth;
        #
        $sbOld = $sbOld.$pc_CVV;
        #
        $sbOld = $sbOld.$pd_Name;
        #
        $sbOld = $sbOld.$pe_CredType;
        #
        $sbOld = $sbOld.$pe_IdNum;
        #
        $sbOld = $sbOld.$pf_SmsTrxId;
        #
        $sbOld = $sbOld.$pf_kaptcha;

        $sbOld = $sbOld.$p10_BC;
//        echo "<br/>";
//        echo $sbOld;
//        echo "<br/>===============================<br/>";
//        echo $this->HmacMd5($sbOld,$this->merchantKey);
        $this->logstr($p2_Order,$sbOld,$this->HmacMd5($sbOld,$this->merchantKey));

        return $this->HmacMd5($sbOld,$this->merchantKey);
    }
    function getTransHmacString($orCode,$cdNo,$atName,$bdName,$tramt)
    {
        $sbOld = "";
        $sbOld = $sbOld.$orCode;
        $sbOld = $sbOld.$cdNo;
        $sbOld = $sbOld.$atName;
        $sbOld = $sbOld.$bdName;
        $sbOld = $sbOld.$tramt;

        $this->logstr($orCode,$sbOld,$this->HmacMd5($sbOld,$this->merchantKey));
        return $this->HmacMd5($sbOld,$this->merchantKey);
    }
    function getCallbackHmacString($p1_MerId,$r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r8_MP,$r9_BType,$ro_BankOrderId,$rp_PayDate)
    {
        #取得加密前的字符串
        $sbOld = "";
        #加入商家ID
        $sbOld = $sbOld.$this->p1_MerId;
        #加入消息类型
        $sbOld = $sbOld.$r0_Cmd;
        #加入业务返回码
        $sbOld = $sbOld.$r1_Code;
        #加入交易ID
        $sbOld = $sbOld.$r2_TrxId;
        #加入交易金额
        $sbOld = $sbOld.$r3_Amt;
        #加入货币单位
        $sbOld = $sbOld.$r4_Cur;
        #加入产品Id
        $sbOld = $sbOld.$r5_Pid;
        #加入订单ID
        $sbOld = $sbOld.$r6_Order;
        #加入商家扩展信息
        $sbOld = $sbOld.$r8_MP;
        #加入交易结果返回类型
        $sbOld = $sbOld.$r9_BType;
        #银行订单号
        $sbOld = $sbOld.$ro_BankOrderId;
        #支付成功时间
        $sbOld = $sbOld.$rp_PayDate;

        $this->logstr($r6_Order,$sbOld,$this->HmacMd5($sbOld,$this->merchantKey));

        return $this->HmacMd5($sbOld,$this->merchantKey);
    }

#	取得返回串中的所有参数
    function getCallBackValue(&$p1_MerId,&$r0_Cmd,&$r1_Code,&$r2_TrxId,&$r3_Amt,&$r4_Cur,&$r5_Pid,&$r6_Order,&$r8_MP,&$r9_BType,&$ro_BankOrderId,&$rp_PayDate,&$hmac)
    {
        $p1_MerId           = $_REQUEST['p1_MerId'];
        $r0_Cmd				= $_REQUEST['r0_Cmd'];
        $r1_Code			= $_REQUEST['r1_Code'];
        $r2_TrxId			= $_REQUEST['r2_TrxId'];
        $r3_Amt				= $_REQUEST['r3_Amt'];
        $r4_Cur				= $_REQUEST['r4_Cur'];
        $r5_Pid				= $_REQUEST['r5_Pid'];
        $r6_Order			= $_REQUEST['r6_Order'];
        $r8_MP				= $_REQUEST['r8_MP'];
        $r9_BType			= $_REQUEST['r9_BType'];
        $ro_BankOrderId		= $_REQUEST['ro_BankOrderId'];
        $rp_PayDate			= $_REQUEST['rp_PayDate'];
        $hmac				= $_REQUEST['hmac'];

        return null;
    }

    function CheckHmac($p1_MerId,$r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r8_MP,$r9_BType,$ro_BankOrderId,$rp_PayDate,$hmac)
    {
        if($hmac==$this->getCallbackHmacString($p1_MerId,$r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r8_MP,$r9_BType,$ro_BankOrderId,$rp_PayDate))
            return true;
        else
            return false;
    }

    function getSmsHmacString($p0_Cmd,$p1_MerId,$p2_ReqNo,$p3_TelNum,$p4_Amt)
    {
        #进行签名处理，一定按照文档中标明的签名顺序进行
        $sbOld = "";
        #加入业务类型
        $sbOld = $sbOld.$p0_Cmd;
        #加入商户编号
        $sbOld = $sbOld.$this->p1_MerId;
        #加入商户订单号
        $sbOld = $sbOld.$p2_ReqNo;
        #加入交易币种
        $sbOld = $sbOld.$p3_TelNum;
        #加入支付金额
        $sbOld = $sbOld.$p4_Amt;
        #加入商品名称
//        $sbOld = $sbOld.$p5_Pid;
        #加入商品分类
        $this->logstr($p2_ReqNo,$sbOld,$this->HmacMd5($sbOld,$this->merchantKey));

        return $this->HmacMd5($sbOld,$this->merchantKey);
    }

    private function HmacMd5($data,$key)
    {
        // RFC 2104 HMAC implementation for php.
        // Creates an md5 HMAC.
        // Eliminates the need to install mhash to compute a HMAC
        // Hacked by Lance Rushing(NOTE: Hacked means written)

        //需要配置环境支持iconv，否则中文参数不能正常处理
//        $key = iconv("GB2312","UTF-8",$key);
//        $data = iconv("GB2312","UTF-8",$data);
//echo "<br/>";echo 'data:'.$data;echo "<br/>";
        $b = 64; // byte length for md5
        if (strlen($key) > $b) {
            $key = pack("H*",md5($key));
        }
        $key = str_pad($key, $b, chr(0x00));
        $ipad = str_pad('', $b, chr(0x36));
        $opad = str_pad('', $b, chr(0x5c));
        $k_ipad = $key ^ $ipad ;
        $k_opad = $key ^ $opad;

        return md5($k_opad . pack("H*",md5($k_ipad . $data)));
    }

    private function logstr($orderid,$str,$hmac)
    {
        $james=fopen($this->logName,"a+");
        fwrite($james,"\r\n".date("Y-m-d H:i:s")."|orderid[".$orderid."]|str[".$str."]|hmac[".$hmac."]");
        fclose($james);
    }

    //POST请求
    function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }

        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        return $data;
    }

    public function jumpRequest($type, $params){
        //exit;
        $_data = $this->getPostData($type, $params);
//        $str = 'BuyCHANG14980117631661498353983931397826CNY100.00testtesthttp://zqzx.hjb.cn/home/PayCb/notify.htmlNocard_H5';
//        echo $str;echo "<br/>";
//        echo $this->HmacMd5($str,$this->merchantKey);echo "<br/>";
//        exit;
        $def_url =  '<div style="text-align:center">';
        $def_url .= '<body onLoad="document.cbpay.submit();">正在跳转充值页面...';
        $def_url .= '<form name="cbpay" action="'.$this->reqURL_onLine.'" method="post">';
        $def_url .=	'
        <input name="p0_Cmd" type="hidden" value="'.$_data['p0_Cmd'].'" />
        <input name="p1_MerId" type="hidden" value="'.$_data['p1_MerId'].'" />
        <input name="p2_Order" type="hidden" value="'.$_data['p2_Order'].'" />
        <input name="p3_Cur" type="hidden" value="'.$_data['p3_Cur'].'" />
        <input name="p4_Amt" type="hidden" value="'.$_data['p4_Amt'].'" />
        <input name="p8_Url" type="hidden" value="'.$_data['p8_Url'].'" />
        <input name="pa_FrpId" type="hidden" value="'.$_data['pa_FrpId'].'" />
        <input name="p6_Pcat" type="hidden" value="'.$_data['p6_Pcat'].'" />
        <input name="p7_Pdesc" type="hidden" value="'.$_data['p7_Pdesc'].'" />
        <input name="hmac" type="hidden" value="'.$_data['hmac'].'" />
        <input type="submit" value="快速跳转"/>';
        $def_url .=	'</form></div>';
        return $def_url;
    }
    /**
     * 支付结果异步通知
     */
    public function notify($type)
    {
        if($type == 'WEIXIN' || $type == 'ALIPAY'){
            $this->p1_MerId = $this->wx_p1_MerId;
            $this->merchantKey = $this->wx_merchantKey;
        }
        Log::debugArr('pay type : '.$type, 'cbpay_notify');
#	解析返回参数.
        $return = $this->getCallBackValue($p1_MerId,$r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r8_MP,$r9_BType,$ro_BankOrderId,$rp_PayDate,$hmac);

#	判断返回签名是否正确（True/False）
        $bRet = $this->CheckHmac($p1_MerId,$r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r8_MP,$r9_BType,$ro_BankOrderId,$rp_PayDate,$hmac);
        Log::debugArr('pay hmac : '.$bRet, 'cbpay_notify');
#	以上代码和变量不需要修改.
#	校验码正确.
        $return = array('status' => 0, 'msg' => '');
        ob_start();
        print_r($_REQUEST);
        $resstr = ob_get_clean();
        Log::debugArr('pay result : '.$resstr, 'cbpay_notify');
        if($bRet){
            if($r1_Code=="1"){
                #	需要比较返回的金额与商家数据库中订单的金额是否相等，只有相等的情况下才认为是交易成功.
                #	并且需要对返回的处理进行事务控制，进行记录的排它性处理，防止对同一条交易重复发货的情况发生.
                if($r9_BType=="1"){
//                    echo "交易成功";
//                    echo  "<br />在线支付页面返回";
                }elseif($r9_BType=="2"){
                    #如果需要应答机制则必须回写流,以success开头,大小写不敏感.
                    echo "success";
                }
                $payStatus = 'success';
            }else{
                $payStatus = 'failed';

            }
            Log::debugArr('pay status2 : '.$payStatus, 'cbpay_notify');
            $return = array('status' => 1, 'payStatus' => $payStatus, 'orderId' => $r6_Order, 'amount' => $r3_Amt, 'payTime' => $rp_PayDate, 'msg' => $r8_MP);
        }else{
            $return['msg'] = '验签失败';
            Log::debugArr($return['msg'], 'cbpay_notify');
        }
        return $return;
    }
}