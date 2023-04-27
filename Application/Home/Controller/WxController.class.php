<?php
/**
 * @author: FrankHong
 * @datetime: 2016/12/15 16:26
 * @filename: WxController.class.php
 * @description: 微信类
 * @note: 
 * 
 */

namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;
use Org\Util\FileCache;

class WxController extends Controller
{

    public function index()
    {

    }

    /**
     * @functionname: weixin_oauth
     * @author: FrankHong
     * @date: 2016-12-15 16:40:57
     * @description: 用于微信验证
     * 识别类型，进行微信端后台入口分流
     *
     * @note:
     * 微信公众平台OAuth2.0授权详细步骤如下：
    1. 用户关注微信公众账号。
    2. 微信公众账号提供用户请求授权页面URL。
    3. 用户点击授权页面URL，将向服务器发起请求
    4. 服务器询问用户是否同意授权给微信公众账号(scope为snsapi_base时无此步骤)
    5. 用户同意(scope为snsapi_base时无此步骤)
    6. 服务器将CODE通过回调传给微信公众账号
    7. 微信公众账号获得CODE
    8. 微信公众账号通过CODE向服务器请求Access Token
    9. 服务器返回Access Token和OpenID给微信公众账号
    10. 微信公众账号通过Access Token向服务器请求用户信息(scope为snsapi_base时无此步骤)
    11. 服务器将用户信息回送给微信公众账号(scope为snsapi_base时无此步骤)
     */
    public function weixin_oauth()
    {
//		vD(UID);
//
//		vD($_SESSION);
//		die();
//
//
//		//根据type判断
//		if(UID != 0)
//		{
//			if (session('register_type') == 2)
//			{
//				if (BID != 0)
//					$this->redirect('Bus/shangjia_home');
//				else
//					$this->redirect('Ucenter/business_apply');
//			}
//			else
//			{
//				$this->redirect('Member/index');
//
//			}
//		}

        $redirect_uri   = urlencode('http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/Home/Wx/oauth');
        $url            = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.NORMAL_WX_APPID.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect';     //正常的

        header('location:'.$url);
    }

    /**
     * @functionname: get_token
     * @author: FrankHong
     * @date: 得到token
     * @description:
     * @note:
     * @return null
     */
    public function get_token()
    {
        $wxAccessTokenCacheKey  = 'wx_access_token';
        $cacheFileName          = WX_TOKEN_PATH.'wx_access_token.tmp';

        $cache  = new FileCache($cacheFileName);
        $token  = $cache->get($wxAccessTokenCacheKey);

        if (!$token)
        {
            $token  = $this->access_token();
            $cache->set($wxAccessTokenCacheKey, $token['access_token'], time() + 7000);
            $returnRs['access_token']   = $token['access_token'];
        }
        else
        {
            $returnRs['access_token']   = $token;
        }

        return $returnRs;
    }


    /**
     * @functionname: access_token
     * @author: FrankHong
     * @date: 2016-08-30 15:42:38
     * @description: 拿到code后，开始获取token
     * @note:
     * https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code
     * @return mixed
     */
    private function access_token()
    {
        //接收上一部获取的信息
        $state  = $_GET['state'];
        $code   = $_GET['code'];

        $url    = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.NORMAL_WX_APPID.'&secret='.NORMAL_WX_APPSECRET.'&code='.$code.'&grant_type=authorization_code';
        $token  = json_decode(get_curl_contents($url), true);
        Log::debugArr($token, 'wx1');

        if (isset($token['errcode']))
        {
            echo '<h1>错误：</h1>'.$token['errcode'];
            echo '<br/><h2>错误信息：</h2>'.$token['errmsg'];
            exit;
        }
        //$token['refer_id'] = $state;

        return $token;
    }


    /**
     * @functionname: refresh_token
     * @author: FrankHong
     * @date: 2016-08-30 16:51:37
     * @description: 刷新access_token（如果需要）refresh_token拥有较长的有效期（7天、30天、60天、90天）
     * @note: https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN
     * @return mixed
     * @param $token
     */
    private function refresh_token($token)
    {
        $url    = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.C('WX_APPID').'&grant_type=refresh_token&refresh_token='.$token['refresh_token'];
        $rtoken = json_decode(get_curl_contents($url), true);
        if (isset($rtoken['errcode']))
        {
            echo '<h1>错误：</h1>'.$rtoken['errcode'];
            echo '<br/><h2>错误信息：</h2>'.$rtoken['errmsg'];
            exit;
        }

        return $rtoken;
    }


    /**
     * @functionname: snsapi_userinfo
     * @author: FrankHong
     * @date: 2016-08-30 16:54:42
     * @description: 拉取用户信息(需scope为 snsapi_userinfo)
     * @note: http：GET（请使用https协议）
     *          https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
     *
     * 获取的报文信息
     * array (
    'openid' => 'oIChsxDPDgQ4ND-mBPrs-hcdmxCY',
    'nickname' => 'Frank',
    'sex' => 1,
    'language' => 'zh_CN',
    'city' => '',
    'province' => '山东',
    'country' => '中国',
    'headimgurl' => 'http://wx.qlogo.cn/mmopen/FQRZHryzYyT1N2DZWrbxKtoC6qWqlJSVRemMPIQC0PiaibibpAu272NRylgQGbRjiaKZdGTZ5EDMBiaYgIQ0VCtWNceOiadhgZ5uXJ/0',
    'privilege' =>
    array (
    ),
    )

     *
     * @return mixed
     * @param $token
     */
    private function snsapi_userinfo($token)
    {
        $url        = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$token['access_token'].'&openid='.$token['openid'].'&lang=zh_CN';
        $user_info  = json_decode(get_curl_contents($url), true);
        Log::debugArr($user_info, 'wx_userinfo');
        if (isset($user_info['errcode']))
        {
            echo '<h1>错误：</h1>'.$user_info['errcode'];
            echo '<br/><h2>错误信息：</h2>'.$user_info['errmsg'];
            exit;
        }
        return $user_info;
    }

    /**
     * @functionname: oauth
     * @author: FrankHong
     * @date: 2016-08-30 15:10:58
     * @description: 微信公众号回调获得code，然后获取token，再获取用户信息
     *              如果用户同意授权，页面将跳转至 redirect_uri/?code=CODE&state=STATE。
     * @note:
     * code说明 ： code作为换取access_token的票据，每次用户授权带上的code将不一样，code只能使用一次，5分钟未被使用自动过期。
     *
     *
     * array (
    'openid' => 'oIChsxDPDgQ4ND-mBPrs-hcdmxCY',
    'nickname' => 'Frank',
    'sex' => 1,
    'language' => 'zh_CN',
    'city' => '',
    'province' => '山东',
    'country' => '中国',
    'headimgurl' => 'http://wx.qlogo.cn/mmopen/FQRZHryzYyT1N2DZWrbxKtoC6qWqlJSVRemMPIQC0PiaibibpAu272NRylgQGbRjiaKZdGTZ5EDMBiaYgIQ0VCtWNceOiadhgZ5uXJ/0',
    'privilege' =>
    array (
    ),
    )
     *
     *
     * 目前设计流程：
     * 1.用户已经登陆过，即当前公众号用户信息与注册信息绑定，下次自动登录，
     * 2.用户未登陆过，即注册信息与公众号用户信息是独立的，并无关联，则进入到登录页面
     */
    public function oauth()
    {
        Log::debugArr($_GET, 'wx2');
        $token      = $this->access_token();

        //获取粉丝微信信息
        $user_info  = $this->snsapi_userinfo($token);

        $userOpenObj    = M('userinfo_open');
        $whereArr       = array('open_id' => $user_info['openid']);
        $userOpenRs     = $userOpenObj->where($whereArr)->find();

        //vD($userOpenRs);

        if($userOpenRs)    //公众号粉丝信息存在的话，进行一次信息更新
        {
            $dataArr    = array(
                'open_name'     => $user_info['nickname'],
                'open_face'     => $user_info['headimgurl'],
                'sex'           => $user_info['sex'],
                'country'       => $user_info['country'],
                'province'      => $user_info['province'],
                'city'          => $user_info['city'],
                'user_id'       => session('user_id')
            );
            $userOpenObj->where(array('open_id' => $user_info['openid']))->save($dataArr);

        }
        else    //如果微信公众号用户信息不存在，则插入信息
        {
            $member_open_mid    = 0;

//            //获取公众号的access_token，此access_token不是用户授权后的access_token
//            $appid          = NORMAL_WX_APPID;
//            $appsecret      = NORMAL_WX_APPSECRET;
//            $auth           = new \Org\Util\WechatAuth($token, $appid, $appsecret);
//            $access_token   = $auth->getAccessToken();
//
//            $subscribe_msg  = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid={$user_info['openid']}";
//            $subscribe_info = file_get_contents($subscribe_msg);
//            $subscribe_info = json_decode($subscribe_info);
//
//            //follow=1时,关注了公众号
//            if(isset($subscribe_info->subscribe) && $subscribe_info->subscribe == 1)
//                $follow = 1;
//            else
//                $follow = 0;

            //当前不存在公众号粉丝信息，保存用户信息=>member_open
            $dataArr    = array(
                'open_id'       => $user_info['openid'],
                'user_id'       => session('user_id'),
                'open_name'     => $user_info['nickname'],
                'open_face'     => $user_info['headimgurl'],
                'sex'           => $user_info['sex'],
                'create_time'   => time(),
                'status'        => 1,
                'follow'        => 1,
                'country'       => $user_info['country'],
                'province'      => $user_info['province'],
                'city'          => $user_info['city']
            );


            $userOpenObj->add($dataArr);
        }



        //Log::debugArr($user_info, 'a');


        //保存公众号信息到session
        $open_info = array(
            'open_cn'       => '微信',
            'open_id'       => $user_info['openid'],
            'open_name'     => $user_info['nickname'],
            'open_sex'      => $user_info['sex'],
            'open_face'     => $user_info['headimgurl'],
            'open_country'  => $user_info['country'],
            'open_province' => $user_info['province'],
            'open_city'     => $user_info['city']
        );

        session('open_info', $open_info);


        $this->redirect('Index/index');

    }



    /**
     * @functionname: oauth_bak
     * @author: FrankHong
     * @date: 2016-08-30 15:10:58
     * @description: 微信公众号回调获得code，然后获取token，再获取用户信息
     *              如果用户同意授权，页面将跳转至 redirect_uri/?code=CODE&state=STATE。
     * @note:
     * code说明 ： code作为换取access_token的票据，每次用户授权带上的code将不一样，code只能使用一次，5分钟未被使用自动过期。
     *
     *
     * 目前设计流程：
     * 1.用户已经登陆过，即当前公众号用户信息与注册信息绑定，下次自动登录，
     * 2.用户未登陆过，即注册信息与公众号用户信息是独立的，并无关联，则进入到登录页面
     *
     *
     * 该方法备份
     */
    public function oauth_bak()
    {
        //Log::debugArr($_GET, 'wx');
        $token      = $this->access_token();
        $user_info  = $this->snsapi_userinfo($token);



//		vD($user_info);
//		die();

        //检查是否已经存在
        $member_open    = M('member_open');
        $res            = $member_open->where(array('open_id' => $user_info['openid']))->find();

        //用于判断当前用户,1为不自动登录
        $tempFlag       = 1;

        //Log::debugArr($res, 'test');
        //-------------------------------------------------------------

        $members        = M('members');




        //如果微信公众号用户信息已经存在
        if ($res)
        {
            $data   = array(
                'open_name'     => $user_info['nickname'],
                'open_face'     => $user_info['headimgurl'],
                'sex'           => $user_info['sex'],
                'country'       => $user_info['country'],
                'province'      => $user_info['province'],
                'city'          => $user_info['city']
            );
            //更新用户微信信息
            $member_open->where(array('open_id' => $user_info['openid']))->save($data);

            //member_id存在，则说明已经绑定过
            $state  = $res['member_id'] > 0 ? 1 : false;
            $uinfo  = array();


            if ($state) //如果当前微信已经与注册信息绑定
            {
                //判断是否存在
                $uinfo      = $members->field('member_id,member_lv_id,uname,password,small_face,mobile,email,is_state,point,experience,consume,type')->where(array('member_id' => $res['member_id']))->find();

                if (!$uinfo)//如果不存在,解绑并进行重新绑定,设置open中的member_id为0
                {
                    $member_open->where(array('open_id' => $user_info['openid']))->setField('member_id', 0);
                    $state = false;
                }
                else //如果存在，则判断是会员还是商家
                {

                    session('member_id', $uinfo['member_id']);
                    session('uname', $uinfo['uname']);
                    //session('register_type', $uinfo['type']);

//					if($uinfo['type'] == 1) //如果是商城会员
                    if(session('register_type') == 1)
                    {

                    }
                    else //如果是商家
                    {
                        $business   = M('business');
                        $binfo      = $business->field('bus_id,cat_id,bus_name,mobile,bus_logo')->where(array('member_id' => $res['member_id']))->find();

                        //如果没有商家信息记录，则跳转到完善信息页面
                        $bstate     = !$binfo ? false : true;
                    }

                }
            }


            if ($state)//如果当前用户微信已经绑定，并且member中存在绑定的信息
            {
                //判断用户是否被禁用
                if ($uinfo['is_state'] == 2)
                    $this->error(L('_passport_login_state_'));

                cookie('member_id', $uinfo['member_id']);

                //直接登录，并进入到微信端用户后台首页 changed @2016-09-12 11:30:59
//				if($uinfo['type'] == 1)
                if(session('register_type') == 1)
                {
                    $this->redirect('Member/index');
                }
                else
                {
                    if($bstate)
                        $this->redirect('Bus/shangjia_home');
                    else
                        $this->redirect('Ucenter/business_apply');
                }

                //$this->error(L('_busy_'));
            }
            else    //1.用户未绑定  2.用户已经绑定，但member中不存在对应的绑定的信息
            {
                $open_info  = array(
                    'open_cn'       => '微信',
                    'open_type'     => 'wechat',
                    'open_id'       => $user_info['openid'],
                    'open_name'     => $user_info['nickname'],
                    'open_sex'      => $user_info['sex'],
                    'open_face'     => $user_info['headimgurl'],
                    'open_country'  => $user_info['country'],
                    'open_province' => $user_info['province'],
                    'open_city'     => $user_info['city']
                );
                session('open_info', $open_info);

                //默认跳转到登录页面，由用户选择是登陆还是注册
                $this->redirect('Ucenter/login');
                return $tempFlag;
            }
        }
        else    //如果微信公众号用户信息不存在 By Frank
        {
            //获取公众号的access_token，此access_token不是用户授权后的access_token
            $appid          = C('WXAPP.app_id');
            $appsecret      = C('WXAPP.app_secret');
            $auth           = new \Org\Util\WechatAuth($token, $appid, $appsecret);
            $access_token   = $auth->getAccessToken();

            $subscribe_msg  = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid={$user_info['openid']}";
            $subscribe_info = file_get_contents($subscribe_msg);
            $subscribe_info = json_decode($subscribe_info);

            //Log::debugArr($subscribe_info, 'subscribe');

            //follow=1时,关注了公众号
            if(isset($subscribe_info->subscribe) && $subscribe_info->subscribe == 1)
                $follow = 1;
            else
                $follow = 0;

            //当前不存在公众号用户信息，保存用户信息=>member_open
            $data   = array(
                'open_id'       => $user_info['openid'],
                'mtype'         => 'wechat',
                'open_name'     => $user_info['nickname'],
                'open_face'     => $user_info['headimgurl'],
                'sex'           => $user_info['sex'],
                'create_time'   => time(),
                'status'        => session('extend.refer_id'),
                'follow'        => $follow,
                'country'       => $user_info['country'],
                'province'      => $user_info['province'],
                'city'          => $user_info['city']
                //'refer_id' => $user_info['refer_id'],      //后加的，还不知道怎么使用到这个参数。
            );
            $member_open->add($data);

            $open_info = array(
                'open_cn'       => '微信',
                'open_type'     => 'wechat',
                'open_id'       => $user_info['openid'],
                'open_name'     => $user_info['nickname'],
                'open_sex'      => $user_info['sex'],
                'open_face'     => $user_info['headimgurl'],
                'open_country'  => $user_info['country'],
                'open_province' => $user_info['province'],
                'open_city'     => $user_info['city'],
                'follow'        => $follow
            );
            //保存open_info的源头
            session('open_info', $open_info);

            //默认跳转到登录页面，登录或是注册，由用户选择
            $this->redirect('Ucenter/login');
            return $tempFlag;
        }
    }




    //微信配置：测试
    public function weixin_test()
    {

        define("TOKEN", "weixin");
        $wechatObj = new wechatCallbackapiTest();
        $wechatObj->valid();

    }




    //测试生成带会员id的二维码
    public function test_qrcode(){

        //二维码处理部分
        $a = vendor("phpqrcode.qrlib");
        //mkdirs(getcwd().'/Data/test_qrcode/');

        //$filename = getcwd().'/Data/coupons/'.$res['bus_id'].'/'.$res['bus_id'].'_'.$uuid.'.png';
        $errorCorrectionLevel = 'L';
        $matrixPointSize = 4;

        $member_id = I('get.member_id', 0, 'intval');
        $domain = C('DOMAIN_QRCODE');      //生成二维码的域名地址
        $domain = 'http://z.hhweb.com.cn/';

        $url = $domain.'/Weixin/index?member_id='.$member_id;

        \QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);

    }








}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)){
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
            if(!empty( $keyword ))
            {
                $msgType = "text";
                $contentStr = "Welcome to wechat world!";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }else{
                echo "Input something...";
            }

        }else {
            echo "";
            exit;
        }
    }

    private function checkSignature()
    {
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }



}