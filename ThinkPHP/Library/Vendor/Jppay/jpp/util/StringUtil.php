<?php
namespace jpp\util;

/**
 * 字符串工具类
 *
 * @package jpp\util
 */
class StringUtil
{
    /**
     * 获取全局唯一串，规则
     * 1. 随机salt
     * 2. 本地IP + 客户端IP
     * 3. 时间戳（毫秒）
     *
     * @param string $salt
     * @return string 32位定长md5字符串
     */
    public static function getUniqueId($salt = '')
    {
        $env = json_encode($_SERVER);
        $clientIp = self::getClientIp();
        $time = microtime(true);
        $str = self::getRnum(32);
        return md5($env . '|' . $clientIp .'|'. $time .'|'. $str . '|' . $salt);
    }

    /**
     * 获取请求来源IP
     *
     * @return string
     */
    public static function getClientIp() {
        $ip = '';
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], 'unknown')) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            strpos($ip, ',') && list($ip) = explode(',', $ip);
        } else if (!empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], 'unknown')) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * 获取固定长度的随机数字
     *
     * @param int $length default:6
     * @return string
     */
    public static function getRnum($length = 6)
    {
        $chars = str_repeat('0123456789', 10);
        return substr(str_shuffle($chars), 0, $length);
    }
}