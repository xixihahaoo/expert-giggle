<?php
namespace jpp\util;

/**
 * 签名工具类
 *
 * @package jpp\util
 */
class SignMaker
{
    /**
     * 借贷宝通用加签方法
     *
     * @param array $data
     * @return array
     */
    public static function wrapperRequest($data)
    {
        if (isset($data['merchantSign'])) {
            unset($data['merchantSign']);
        }
        if (isset($data['serverSign'])) {
            unset($data['serverSign']);
        }
        if (isset($data['serverCert'])) {
            unset($data['serverCert']);
        }
        if (isset($data['merchantCert'])) {
            unset($data['merchantCert']);
        }

        ksort($data);

        $text = self::normalResponse($data);

        $data['merchantSign'] = RsaEncryptor::RSAsign($text, JPP_CERT_FILE, JPP_CERT_PWD);
        $data['merchantCert'] = RsaEncryptor::getPubCert(JPP_CERT_FILE, JPP_CERT_PWD);

        return $data;
    }

    /**
     * 验签参数归一化
     *
     * @param array $rsp
     * @return array
     */
    public static function normalResponse($rsp)
    {
        $ret = [];
        // 生成签名之前要进行编码转换
        while (list($k, $v) = each($rsp)) {
            if ($v === 'null') {
                continue;
            }
            if (!empty ($v) || $v === 0 || $v === '0') {
                $ret[] = "$k=$v";
            }
        }
        return implode('&', $ret);
    }

}