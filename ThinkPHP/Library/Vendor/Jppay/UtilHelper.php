<?php
// SDK所使用的PHP版本不能低于5.5
if (version_compare(PHP_VERSION, '5.5') < 0) {
    throw new \Exception("jpp sdk php version must be >= 5.5");
}



/**
 * 常用工具帮助类
 *
 * @author: cc
 * @since 2017-08-20
 */
class UtilHelper
{
    /*
    * DES加密
    */
    public static function desEncode($params)
    {
        return DesHelper::desEncode($params);
    }

    /*
    * DES解密
    */
    public static function desDecode($params)
    {
        return DesHelper::desDecode($params);
    }

    /*
    * 获取客户端IP
    */
    public static function getClientIP()
    {
        $ip = false;
        $remoteAddr = $_SERVER['REMOTE_ADDR'];
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
            for ($i = 0; $i < count($ips); $i++) {
                if (!eregi ("^(10│172.16│192.168).", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $remoteAddr);
    }
}







/**
 * 3DES加密解密算法，使用pkcs#5填充
 */
class DesHelper
{

    public static $key = "y8ZA90PTRVeb65TmMAUl0G";

    /**
     * des加密
     *
     * @param $input
     *
     * @return string
     */
    public static function desEncode($input)
    {
        $key = "cputest";
        $size = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_ECB);
        $str = self::pkcs5Pad($input, $size);
        $td = @mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_ECB, '');
        $iv = 'cputest0';
        @mcrypt_generic_init($td, $key, $iv);
        $data = @mcrypt_generic($td, $str);
        $ret = strtoupper(bin2hex($data));
        return $ret;
    }

    /**
     * des解密
     *
     * @param $encrypted
     *
     * @return bool|null|string
     */
    public static function desDecode($encrypted)
    {
        if (!$encrypted || empty($encrypted)) {
            return null;
        }
        $encrypted = hex2bin($encrypted);
        if (!$encrypted || empty($encrypted)) {
            return null;
        }
        $key = "cputest";
        $td = mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_ECB, '');
        $iv = 'cputest0';
        mcrypt_generic_init($td, $key, $iv);
        $decrypted = mdecrypt_generic($td, $encrypted);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $y = self::pkcs5Unpad($decrypted);
        return $y;
    }

    /**
     * 3des加密
     * @param $input
     *
     * @return null|string
     */
    public static function encrypt($input)
    {
        if (empty($input)) {
            return null;
        }
        $size = mcrypt_get_block_size(MCRYPT_3DES, 'cbc');
        $input = self::pkcs5Pad($input, $size);
        $key = str_pad(self::$key, 24, '0');
        $td = mcrypt_module_open(MCRYPT_3DES, '', 'cbc', '');
        $iv = 't@bdRaLf';
        mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }

    /**
     * 3des解密
     * @param $encrypted
     *
     * @return bool|null|string
     */
    public static function decrypt($encrypted)
    {
        if (!$encrypted || empty($encrypted)) {
            return null;
        }
        $encrypted = base64_decode($encrypted);
        if (!$encrypted || empty($encrypted)) {
            return null;
        }
        $key = str_pad(self::$key, 24, '0');
        $td = mcrypt_module_open(MCRYPT_3DES, '', 'cbc', '');
        $iv = 't@bdRaLf';
        mcrypt_generic_init($td, $key, $iv);
        $decrypted = mdecrypt_generic($td, $encrypted);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $y = self::pkcs5Unpad($decrypted);
        return $y;
    }

    public static function pkcs5Pad($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public static function pkcs5Unpad($text)
    {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }

    public static function PaddingPKCS7($data)
    {
        $block_size = mcrypt_get_block_size(MCRYPT_3DES, MCRYPT_MODE_CBC);
        $padding_char = $block_size - (strlen($data) % $block_size);
        $data .= str_repeat(chr($padding_char), $padding_char);
        return $data;
    }

}

