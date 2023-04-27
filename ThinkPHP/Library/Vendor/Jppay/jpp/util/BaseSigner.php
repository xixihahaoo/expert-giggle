<?php
namespace jpp\util;

/**
 * 一些pack工作
 *
 * @package jpp\util
 */
class BaseSigner
{
    // RSA相关
    public static function asc2hex($str)
    {
        return chunk_split(bin2hex($str), 2, '');
    }

    public static function hex2asc($str)
    {
        $len = strlen($str);
        $data = "";
        for($i=0;$i < $len;$i += 2)
            $data.=chr(hexdec(substr($str,$i,2)));
        return $data;
    }

    public static function pem2der($pem_data)
    {
        $begin = "CERTIFICATE-----";
        $end   = "-----END";
        $pem_data = substr($pem_data, strpos($pem_data, $begin)+strlen($begin));
        $pem_data = substr($pem_data, 0, strpos($pem_data, $end));
        $der = base64_decode($pem_data);
        return $der;
    }

    public static function der2pem($der_data)
    {
        $pem = chunk_split(base64_encode($der_data), 64, "\n");
        $pem = "-----BEGIN CERTIFICATE-----\n".$pem."-----END CERTIFICATE-----\n";
        return $pem;
    }
}