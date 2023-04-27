<?php

namespace Org\Util;
use Org\Util\Log;
use Think\Exception;

class HsgjPay
{

    private $appid      = 6050;
    private $cpid       = 1050;
    private $user_id    = 123456;

    private $jump_url   = '';
    private $notify_url = '';
    private $send_url   = 'http://www.lefusdk.com/pay.php';
    private $key        = '105060508udj7ln';


    public function __construct()
    {
        $this->jump_url   = urlencode(U('home/PayHsgj/jump_url', '', true, true));
        $this->notify_url = urlencode(U('home/PayHsgj/notify_url', '', true, true));
    }

    //提交订单时的签名
    public function sign($signArr)
    {
        $str = '';

        $signArr['appid']       = $this->appid;
        $signArr['cpid']        = $this->cpid;
        $signArr['user_id']     = $this->user_id;
        $signArr['jump_url']    = $this->jump_url;
        $signArr['notify_url']  = $this->notify_url;

        ksort($signArr);
        foreach ($signArr as $key => $value) {
            
            if("" != $value && "sign" != $key) {
                $str.= $key.'='.$value.'&';
            }
        }
        
        $str .= "key=" . $this->key;

        $sign   = strtoupper(md5($str));

        return $sign;
    }

    //处理请求
    public function postArr($dataArr)
    {
        $str = $this->send_url.'?';

        $dataArr['appid']       = $this->appid;
        $dataArr['cpid']        = $this->cpid;
        $dataArr['user_id']     = $this->user_id;
        $dataArr['jump_url']    = $this->jump_url;
        $dataArr['notify_url']  = $this->notify_url;

        ksort($dataArr);

        foreach ($dataArr as $key => $value) {

            $str.= $key.'='.$value.'&';
        }
        
        $str = rtrim($str,'&');

        return htmlspecialchars($str);
    }

    //回调时的签名
    public function notifySign($signArr)
    {
        $str = '';

        ksort($signArr);
        foreach ($signArr as $key => $value) {
            
            if("" != $value && "sign" != $key) {
                $str.= $key.'='.$value.'&';
            }
        }
        
        $str .= "key=" . $this->key;

        $sign   = strtoupper(md5($str));

        return $sign;
    }

}