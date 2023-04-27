<?php
namespace jpp\util;

/**
 * RSA加解密工具类
 *
 * @package jpp\util
 */
class RsaEncryptor
{
    /**
     * @var int 验签成功
     */
    const VERIFY_SUCCESS = 1;

    /**
     * 生成RSA算法的MAC值
     *
     * @param string $source 生成MAC值原文
     * @param string $pkcs12path 商户证书
     * @param string $password 证书私钥
     * @return string 消息摘要
     */
    public static function RSAsign($source, $pkcs12path, $password)
    {
        $certs = array ();
        $fd = fopen($pkcs12path, 'r');
        $p12buf = fread($fd, filesize($pkcs12path));
        fclose ( $fd );
        if (openssl_pkcs12_read($p12buf, $certs, $password)) {
            $pkeyid = openssl_pkey_get_private($certs['pkey']);
            $signature = "";
            openssl_sign($source, $signature, $pkeyid, OPENSSL_ALGO_SHA256);
            openssl_free_key($pkeyid);
            return BaseSigner::asc2hex($signature);
        }
    }

    /**
     * 验签RSA
     *
     * @param string $source 生成MAC值原文
     * @param string $hmac mac值
     * @param string $pubcert 服务器证书
     * @return int 1-成功; 2-失败; -1-其他错误
     */
    public static function RSAVerify($source, $hmac, $pubcert)
    {
        $pubder = BaseSigner::hex2asc($pubcert);
        $signhmac = BaseSigner::hex2asc($hmac);
        $pubpem = BaseSigner::der2pem($pubder);
        $pubkeyid = openssl_get_publickey($pubpem);
        $ok = openssl_verify($source, $signhmac, $pubkeyid, OPENSSL_ALGO_SHA256);
        openssl_free_key($pubkeyid);
        if ($ok == 0) {
            $ok = 2;
        }
        return $ok; // 1:成功; 2:失败; -1:其他错误
    }

    /**
     * 获取证书公钥
     *
     * @param string $pkcs12path 证书
     * @param string $password 私钥
     * @return string 证书公钥
     */
    public static function getPubCert($pkcs12path, $password)
    {
        $fd = fopen($pkcs12path, 'r');
        $p12buf = fread($fd, filesize($pkcs12path));
        fclose($fd);
        if (openssl_pkcs12_read($p12buf, $certs, $password)) {
            $pubder = BaseSigner::pem2der($certs['cert']);
            return BaseSigner::asc2hex($pubder);
        }
    }
}