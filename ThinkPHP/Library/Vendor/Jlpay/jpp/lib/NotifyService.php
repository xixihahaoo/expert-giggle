<?php
namespace jpp\lib;

use jpp\util\HttpClient;
use jpp\util\RsaEncryptor;
use jpp\util\SignMaker;
use jpp\util\StringUtil;
use jpp\util\DesHelper;

/**
 * 服务基础类
 *
 * @package jpp\lib
 */
class NotifyService
{

    /**
     * 回调签名
     *
     * @param array $params 业务参数
     * @return array
     */
    public static function request($ret)
    {

        ksort($ret);

        $sign = $ret['serverSign'];
        unset($ret['serverSign']);
        $cert = $ret['serverCert'];
        unset($ret['serverCert']);

        $normalText = SignMaker::normalResponse($ret);

        // 返回结果验签
        $checkResult = RsaEncryptor::RSAVerify($normalText, $sign, $cert);
        if ($checkResult == RsaEncryptor::VERIFY_SUCCESS) {
            var_dump('cc-test:BaseService:request'.'----验签成功-----');
            $ret['signStatus'] = 1;
            return $ret;
        }
        // cc-test
        var_dump('cc-test:BaseService:request'.['rspCode' => 'IPS00008', 'rspMessage' => '请求返回内容验签失败']);
        var_dump($params);

        return ['rspCode' => 'IPS00008', 'rspMessage' => '请求返回内容验签失败'];
    }
}