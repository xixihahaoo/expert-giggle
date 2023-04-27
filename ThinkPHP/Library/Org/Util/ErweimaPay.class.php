<?php
/**
 * 中南支付
 */
namespace Org\Util;
use Org\Util\Log;
use Think\Exception;

class ErweimaPay
{


    

    public function __construct($model)
    {
        $config = $this->_getConfig();

        $this->merchantId = $config['merchantId'];
        $this->merchantPassword = $config['merchantPassword'];
        $this->gatewayUrl = $config['gatewayUrl'];
        $this->gatewayUrlFuwuhao = $config['gatewayUrlFuwuhao'];
        $this->gatewayUrlDaifu = $config['gatewayUrlDaifu'];
        $this->notifyUrl = U('home/PayErweima/notify', '', true, true);
        $this->notifyDaofuUrl = U('home/PayErweima/notifyDaifu', '', true, true);

    }

    /**
     * 微信扫码支付方法
     * by linjuming 2017-5-8
     * @param array $balance 交易详细，wp_balance表中的一条记录
     * @return array
     */
    public function wxpay($balance)
    {
        Log::debugArr('begin wxpay', 'Erweima');
        $rs = $this->postOrder('wxpay', $balance);
        return $rs;
    }

    /**
     * 支付宝扫码支付方法
     * by linjuming 2017-5-8
     * @param array $balance 交易详细，wp_balance表中的一条记录
     * @return array
     */
    public function alipay($balance)
    {
        $rs = $this->Postorder('alipay', $balance);
        return $rs;
    }


    /**
     * 获取配置
     * @return array
     */
    private function _getConfig()
    {
        static $config;
        if ($config) return $config;

        $config = require(VENDOR_PATH . 'Erweima/config.inc.php');
		Log::debugArr($config, 'erweima');

        return $config;
    }

   public function jumpRequest($params,$cardNo,$cardName,$idNo,$tel = ""){
        $str = $this->getPostString('qkpay',$params,$cardNo,$cardName,$idNo,$tel);
        Log::debugArr('jumpRequest params string :'.$str, 'znpay');
        return $str;
    }

    public function getPostString($type, $params)
    {
        $orderNum = $params['balanceno'];
        $amount = $params['bpprice'];

        $merchantId = $this->merchantId;
        $merchantPassword = $this->merchantPassword;
 
		if ($type == 'zfbscan_ewm'){
			$payType='1';
		}else if ($type == 'wxscan_ewm'){
			$payType='2';
		}else if ($type == 'qqscan_ewm'){
			$payType='8';
		}else if ($type == 'fuwuhao_zfb_ewm'){
			$payType='1';
		}else if ($type == 'fuwuhao_wx_ewm'){
			$payType='2';
		}

		$post_data = array(
			'merchno'=>$this->merchantId,
			"amount"=>$amount,
			'traceno'=>$orderNum,//自定义流水号
			'payType'=>$payType,
			'notifyUrl'=>$this->notifyUrl
		);
		$temp='';
		ksort($post_data);//对数组进行排序
		//遍历数组进行字符串的拼接
		foreach ($post_data as $x=>$x_value){
			if ($x_value != null){
				$temp = $temp.$x."=".iconv('UTF-8','GBK//IGNORE',$x_value)."&";
			}
		}
		$md5=md5($temp.$merchantPassword);
		$reveiveData = $temp.'signature'.'='.$md5;

        Log::debugArr($reveiveData, 'erweima');
        return $reveiveData;
    }

    public function postOrder($type, $params)
    {

        Log::debugArr(iconv( 'GBK//IGNORE','UTF-8',urldecode('%BA%E3%BD%F0%B1%A6')), 'testStr');

        $str = $this->getPostString($type, $params);

        Log::debugArr('postOrder params string :'.$str, 'erweima');

		if ($type == 'fuwuhao_wx_ewm'){
			$gatewayUrl=$this->gatewayUrlFuwuhao;
		}else{
			$gatewayUrl=$this->gatewayUrl;
		}
		
		Log::debugArr($gatewayUrl, 'erweima');
		//echo  $reveiveData;
		$curl = curl_init();
		//设置抓取的url
		curl_setopt($curl, CURLOPT_URL, $gatewayUrl);
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
		curl_close($curl);
		//return iconv('GB2312', 'UTF-8', $data);

		Log::debugArr($result, 'erweima');
		Log::debugArr(iconv('GBK//IGNORE', 'UTF-8', $result), 'erweima');
        $obj=json_decode(iconv('GBK//IGNORE', 'UTF-8', $result)); 
        
		Log::debugArr($obj, 'erweima');

		Log::debugArr($obj->respCode, 'erweima');
		Log::debugArr($obj->message, 'erweima');
		Log::debugArr($obj->merchno, 'erweima');
		$post_data = array(
			'respCode'=>$obj->respCode,
			"message"=>$obj->message,
			"merchno"=>$obj->merchno,
			"traceno"=>$obj->traceno,
			"refno"=>$obj->refno,
			"barCode"=>$obj->barCode
		);
		$temp='';
		ksort($post_data);//对数组进行排序
		//遍历数组进行字符串的拼接
		foreach ($post_data as $x=>$x_value){
			if ($x_value != null){
				$temp = $temp.$x."=".iconv('UTF-8','GBK//IGNORE',$x_value)."&";
			}
		}
		$md5=md5($temp.$this->merchantPassword);
		
		Log::debugArr($temp, 'erweima');
		Log::debugArr(strtoupper($md5), 'erweima');
		
        if ($obj->signature == strtoupper($md5)) {//验签成功
			if ($obj->respCode == '00') {//下单成功
				Log::debugArr('postOrder success', 'erweima');
				Log::debugArr($return, 'erweima');
				$return = array('status' => 1, 'codeUrl' => $obj->barCode);
			} else {
				Log::debugArr('postOrder Error code:['.$obj->respCode.']'.$obj->message, 'erweima');
				$return = array('status' => 0, 'msg' => 'Error'.$obj->message);
			}
		} else {
			Log::debugArr('postOrder Error code:['.$obj->respCode.']'.$obj->message, 'erweima');
			$return = array('status' => 0, 'msg' => '验签失败'.$obj->message);
		}

        return $return;
    }
    

    /**
     * 支付结果异步通知
     */
    public function notify()
    {
        Log::debugArr('notify开始', 'erweima_notify');
        $result = file_get_contents('php://input');
        Log::debugArr($result, 'erweima_notify');
		
        $obj= $this->str2arr1(iconv('GBK//IGNORE','UTF-8',urldecode($result)));

		Log::debugArr($obj, 'erweima_notify');

		ksort($obj);//对数组进行排序
		//遍历数组进行字符串的拼接
		foreach ($obj as $x=>$x_value){
			if ($x != 'signature' ){
				if ($x_value != null){
					$temp = $temp.$x."=".iconv('UTF-8','GBK//IGNORE',$x_value)."&";
				}
			}
		}
		Log::debugArr($temp, 'erweima_notify');
		$md5=md5($temp.$this->merchantPassword);
        
		Log::debugArr($md5, 'erweima_notify');
         if (strtoupper($md5) == strtoupper($obj['signature'])) {

			Log::debugArr($obj['status'], 'erweima_notify');

             if ($obj['status'] == '1'  ) {//下单成功
                 Log::debugArr('postOrder success', 'erweima_notify');
                 Log::debugArr($obj, 'erweima_notify');
				$return = array('status' => 1, 'payStatus' => 'success','orderId' =>$obj['traceno'],'amount'=>$obj['amount'] );
             } else {
                 Log::debugArr('postOrder Error code:'.$obj['status'], 'erweima_notify');
                 $return = array('status' => 0, 'msg' => 'Error');
             }
         } else {
             Log::debugArr('postOrder 验签失败', 'erweima_notify');
             $return = array('status' => 0, 'msg' => '验签失败');
         }

         return $return;
    }
    
 
    
	
    /* 将一个字符串转变成键值对数组
     * @param    : string str 要处理的字符串 $str ='TranAbbr=IPER|AcqSsn=000000073601|MercDtTm=20090615144037';
     * @return    : array*/
    function str2arr1($str){
        $arr = explode("&",$str);
        $r = array();
        foreach ($arr as $val ){
            $t = explode("=",$val);
            $r[$t[0]]= $t[1];
        }
        return $r;
    }
}
    
