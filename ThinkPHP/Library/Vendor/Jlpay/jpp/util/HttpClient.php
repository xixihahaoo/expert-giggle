<?php
namespace jpp\util;

/**
 * 网络抓取工具
 * 使用方法：
 * 1：单次请求：
 * HttpClient::curl($arrRequest);
 * $arrRequest = ['url' => string, 'get/post' => [key => val], 'option' => []]
 * 注：get和post只能写一个,里面是需要提交的参数和对应的值(key-value对)，option是一些附加的参数信息,详见：CURLOPT_*。
 * <pre>
 * $arrReq = [
 *   'url' => 'http://172.28.40.154/socketclient/house_searchClient.php',
 * 	 'post' => ['query' => '石景山', 'high' => '30', 'low' => '20', 'pageSize'=>'10'],
 * 	 'option' => [
 *      'retry' => 2,
 * 	    CURLOPT_TIMEOUT_MS => 100,
 * 	    CURLOPT_CONNECTTIMEOUT_MS => 200,
 * 	    CURLOPT_HTTPHEADER => [
 * 	      'Content-type: application/json;charset="utf-8"',
 * 	      'Accept: application/json',
 * 	      'Cache-Control: no-cache',
 * 	      'Pragma: no-cache',
 *      ],
 *   ],
 * ];
 * $arrCtn = HttpClient::instance()->curl($arrReq);
 * </pre>
 * @author hongcq
 * @since 2017-08-03
 */
class HttpClient {

    /**
     * 请求header默认设置项：
     * <ol>
     *   <li>agent: 浏览器代理串(Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36)</li>
     *   <li>referer: 引用页(默认是截取URL的主域名)</li>
     *   <li>encoding: UTF-8</li>
     *   <li>conn_timeout: 链接超时时间(1000)</li>
     *   <li>conn_retry: 链接重试次数(3)</li>
     *   <li>max_redirs: 连接重定向次数(3)</li>
     *   <li>follow_location: 是否跟踪重定向跳转(true)</li>
     *   <li>returntransfer: =true显示头信息</li>
     *   <li>header: =false不把头信息包含在输出流中</li>
     *   <li>nosignal: =true时支持毫秒超时设置</li>
     * </ol>
     * @var array
     */
    private $arrOptions = [
        CURLOPT_USERAGENT            => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 JDB/1.0',
        CURLOPT_REFERER              => '',
        CURLOPT_ENCODING             => 'UTF-8',
        CURLOPT_TIMEOUT_MS           => 6000,
        CURLOPT_CONNECTTIMEOUT_MS    => 3000,
        CURLOPT_MAXREDIRS            => 3,
        CURLOPT_FOLLOWLOCATION       => true,
        CURLOPT_RETURNTRANSFER       => 1,
        CURLOPT_HEADER               => false,
        CURLOPT_NOSIGNAL             => true,
        CURLOPT_SSL_VERIFYPEER       => false,
        CURLOPT_SSL_VERIFYHOST       => false,
    ];

    /**
     * 获取HttpClient实例
     *
     * @param array $arrOpt curl option 已设置默认值的有[user_agent,referer,encoding,conn_timeout,conn_retry,max_redirs,timeout,max_response_size,follow_location]
     * @return HttpClient
     */
    public static function instance($arrOpt = []) {
        $proxy = new self();
        if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
            // 由于curl优先解析IPV6地址再解析V4
            // php>= 5.3 && curl >= 7.10.8
            $proxy->arrOptions[CURLOPT_IPRESOLVE] = CURL_IPRESOLVE_V4;
        }
        if (is_array($arrOpt) && !empty($arrOpt)) {
            $proxy->arrOptions = $arrOpt + $proxy->arrOptions;
        }
        return $proxy;
    }

    /**
     * 请求单个URL资源
     *
     * @param array $arrReq ['url', 'get', 'post', 'option']
     * @return array ['content', 'errno', 'msg']
     */
    public function curl($arrReq) {

        // 失败重试次数
        $intMaxRetry = 1;
        $intCounter = 0;
        if(isset($arrReq['option']['retry'])) {
            $intMaxRetry = intval($arrReq['option']['retry']) + 1;
            unset($arrReq['option']['retry']);
        }

        $errno = -1;
        $ret = ['errno' => $errno, 'msg' => 'error happen', 'content' => ''];
        $start = microtime(true);
        $url = $this->getRequestUrl($arrReq);
        $curl = $this->getHandle($url, $arrReq);
        $log['msg'] = 'HttpClient_curl_exec_detail';

        while ($intCounter < $intMaxRetry) {
            // 记录重试日志
            if ($intCounter > 0) {
                // do log
            }

            $strContent = curl_exec($curl);
            $errno = curl_errno($curl);
            $msg = curl_error($curl);
            $info = curl_getinfo($curl);

            $log = $this->getExpireInfo($info);
            $log['url'] = $url;
            $ret['errno'] = $log['curl_errno'] = $errno;
            $ret['msg'] = $log['curl_error_msg'] = $msg;

            // 做http_code和curl_error校验
            if($this->checkResponse($info, $errno, $msg)) {
                // func checkResponse 做完了再最后做$intErrno === CURLE_OK
                if ($errno === CURLE_OK) {
                    // do log request
                    $log['total_cost'] = bcsub(microtime(true), $start, 4);
                    $ret['content'] = $strContent;
                    break;
                }
            } else {
                $errno = $info['http_code'] == 200 ? 0 : $info['http_code'];
                // bugfix:部分超时的情况下$arrInfo['http_code'] = 0
                if ($info['http_code'] == 0 && strpos($ret['msg'], 'Operation timed out after') !== false) {
                    $errno = CURLE_OPERATION_TIMEOUTED;
                }
                if (empty($msg)) {
                    $ret['msg'] = $strContent;
                }
            }

            $intCounter++;
        }

        curl_close($curl);

        // log request info

        $ret['errno'] = $errno;

        return $ret;
    }

    /**
     * 校验执行结果状态码
     *
     * @param array $resp 函数curl_getinfo返回的数组
     * @param int $errno
     * @param string $message
     * @return boolean
     */
    private function checkResponse(&$resp, $errno, $message)
    {
        $bolValid = false;
        $intCode = intval($resp['http_code']);
        // 出错的情况下记录详尽的错误信息
        $log = [
            'curl_errno' => $errno,
            'curl_erorr_msg' => $message,
            'http_code' => $intCode,
            'total_time' => isset($resp['total_time']) ? $resp['total_time'] : -1,
            'namelookup_time' => isset($resp['namelookup_time']) ? $resp['namelookup_time'] : -1,
            'connect_time' => isset($resp['connect_time']) ? $resp['connect_time'] : -1,
            'starttransfer_time' => isset($resp['starttransfer_time']) ? $resp['starttransfer_time'] : -1,
            'pretransfer_time' => isset($resp['pretransfer_time']) ? $resp['pretransfer_time'] : -1,
            'primary_ip' => isset($resp['primary_ip']) ? $resp['primary_ip'] : 'unknow',
            'primary_port' => isset($resp['primary_port']) ? $resp['primary_port'] : -1,
            'local_ip' => isset($resp['local_ip']) ? $resp['local_ip'] : 'unknow',
            'local_port' => isset($resp['local_port']) ? $resp['local_port'] : -1,
            'redirect_count' => isset($resp['redirect_count']) ? $resp['redirect_count'] : -1,
            'redirect_time' => isset($resp['redirect_time']) ? $resp['redirect_time'] : -1,
            'url' => isset($resp['url']) ? $resp['url'] : 'unknow',
        ];

        // 域名或URL错误
        if($errno == CURLE_URL_MALFORMAT || $errno == CURLE_COULDNT_RESOLVE_HOST) {
            $log['msg'] = 'The URL is not valid.';

            // URL连接不上
        } elseif ($errno == CURLE_COULDNT_CONNECT) {
            $log['msg'] = 'Service for URL is invalid now, could not connect to.';

            // 超出最大耗时
        } elseif( $errno == CURLE_OPERATION_TIMEOUTED) {
            $log['msg'] = 'Request for URL timeout.';

            // 重定向次数过多
        } elseif( $errno == CURLE_TOO_MANY_REDIRECTS
            || $intCode == 301
            || $intCode == 302
            || $intCode == 307 ) {
            //$intErrno == CURLE_OK can only indicate that the response is received, but it may
            //also be an error page or empty page, so we also need more checking when $intErrno == CURLE_OK
            $log['msg'] = 'Request for URL caused too many redirections.';

            // 其他异常(可能对方服务器内部错误等)
        } elseif( $intCode >= 400 ) {
            $log['msg'] = 'Received HTTP error code >= 400 while loading';

        } else {
            $bolValid = true;
        }

        if ($bolValid !== true) {
            // do warn log
        }

        return $bolValid;
    }

    /**
     * 给multi-curl添加handle
     *
     * @param string $strUrl
     * @param array $arrReq
     * @return mixed on success, false on failure
     */
    private function getHandle($strUrl, &$arrReq) {

        $ch = curl_init();
        if (!is_resource($ch)) {
            // do warn log
            return false;
        }
        $arrOption = $this->getOption($strUrl, $arrReq);
        $bolRet = curl_setopt_array($ch, $arrOption);
        if ($bolRet !== true) {
            // do warn log
            curl_close($ch);
            return false;
        }

        return $ch;
    }

    /**
     * 获得完整URL信息
     *
     * @param array $arrOpt [{'option', 'get', 'post', 'cookie'}, ...]
     * @return string
     */
    private function getRequestUrl(&$arrOpt) {

        $strUrl = $arrOpt['url'];
        if(!isset($arrOpt['get'])) {
            return $strUrl;
        }

        // 设置GET参数
        if (is_array($arrOpt['get']) && !empty($arrOpt['get'])) {
            $strGet = http_build_query($arrOpt['get']);
            if (strpos($strUrl, '?', 7) > 0) {
                $strUrl .= '&' . $strGet;
            } else {
                $strUrl .= '?' . $strGet;
            }
        }
        unset($arrOpt['get']);

        return $strUrl;
    }

    /**
     * 获取请求的时间信息
     *
     * @param array $arrInfo
     * @return array [errno,total_time,namelookup_time,connect_time,pretransfer_time,starttransfer_time,redirect_time]
     */
    private function getExpireInfo($arrInfo) {

        $ret = [];
        // 单个请求耗时(in seconds)
        $ret['cost'] = $arrInfo['total_time'];
        // 状态码
        $ret['http_code'] = $arrInfo['http_code'];
        // DNS查询时间(in seconds)
        $ret['namelookup_time'] = $arrInfo['namelookup_time'];
        // 连接耗时(in seconds)
        $ret['connect_time'] = $arrInfo['connect_time'];
        // 从建立连接到准备传输所运用的时间(in seconds)
        $ret['pretransfer_time'] = $arrInfo['pretransfer_time'];
        // 从建立连接到传输开始所运用的时间(in seconds)
        $ret['starttransfer_time'] = $arrInfo['starttransfer_time'];
        // 在事务传输开始前重定向所运用的时间(in seconds)
        $ret['redirect_time'] = $arrInfo['redirect_time'];

        return $ret;
    }

    /**
     * 获取请求头的curl_option
     *
     * @param string $strUrl 请求URL
     * @param array $arrReq [{'option', 'get', 'post', 'cookie'}, ...]
     * @return array curl_option 相关选项数据
     */
    private function getOption($strUrl, &$arrReq) {

        // 设置POST参数
        $arrOption = array();
        if (isset($arrReq['post']) && !empty($arrReq['post'])) {
            $arrOption[CURLOPT_POST] = 1;
            $arrOption[CURLOPT_POSTFIELDS] = is_array($arrReq['post']) ? http_build_query($arrReq['post']) : $arrReq['post'];
            unset($arrReq['post']);
        }

        // 设置COOKIE
        if (isset($arrReq['cookie'])) {
            if(is_array($arrReq['cookie']) && !empty($arrReq['cookie'])) {
                $strCookie = '';
                foreach($arrReq['cookie'] as $k => $v) {
                    $strCookie .= ($k . '=' . $v.'; ');
                }
                $arrOption[CURLOPT_COOKIE] = $strCookie;
            }
            unset($arrReq['cookie']);
        }
        $arrOption[CURLOPT_URL] = $strUrl;

        // 用户自定义curl_option选项
        $arrUserOpt = array();
        if (isset($arrReq['option'])) {
            $arrUserOpt = $arrReq['option'];
        }

        // 没设置浏览器useragent时默认设置请求URL的主域名
        if (!isset($arrUserOpt[CURLOPT_REFERER])) {
            $arrUrl = parse_url($strUrl);
            $arrOption[CURLOPT_REFERER] = $arrUrl['scheme'] . '://' . $arrUrl['host'] . '/';
        }

        // 两个数组相加(保持索引不变)
        if (!empty($arrUserOpt) && is_array($arrUserOpt)) {
            // 不允许指定CURLOPT_RETURNTRANSFER参数
            if (isset($arrUserOpt[CURLOPT_RETURNTRANSFER])) {
                unset($arrUserOpt[CURLOPT_RETURNTRANSFER]);
            }
            $arrOption = $arrUserOpt + $arrOption;
        }

        $arrOption = $arrOption + $this->arrOptions;

        return $arrOption;
    }
}
