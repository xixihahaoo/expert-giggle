<?php ?><?php


use Org\Util\QidianSmsApi;
use Org\Util\QixinSmsApi;
use Org\Util\Alidayu;

#import('ORG.Util.QidianSmsApi');
#import('ORG.Util.QixinSmsApi');
#import('ORG.Util.Alidayu');

function get_url() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
 }
 


/**
 * 使用curl获取远程数据
 * @param  string $url url连接
 * @return string      获取到的数据
 */
function curl_get_contents($url){
    
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);                //设置访问的url地址
    curl_setopt($ch,CURLOPT_HEADER,1);                //是否显示头部信息
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);               //设置超时
    curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);   //用户访问代理 User-Agent
    curl_setopt($ch, CURLOPT_REFERER,_REFERER_);        //设置 referer
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);          //跟踪301
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //返回结果
    $r=curl_exec($ch);
    curl_close($ch);
    var_dump($r);exit;
    return $r;
}

function getJson($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, true);
}

/****************************
 * /*  手机短信接口（www.ussns.com）
 * /* 参数：$mob        手机号码
 * /*        $content    短信内容
 *****************************/
function sendsms($mob, $content)
{
    $msgconfig = C("SMS");
    $username=$msgconfig['user2'];
    $pwd=$msgconfig['pwd'];
    $type = 0;// type=0 短信接口
    if ($type == 0) {
        /////////////////////////////////////////短信接口 开始/////////////////////////////////////////////////////////////
        $post_data = array(
            'username' => $username,
            'pwd' => $pwd,
            'msg' => urlencode($content),//短信内容 编码处理
            'phone' => $mob,//发送手机号，多号码用半角逗号","分割
        );
        $smsapi = 'www.ussns.com/Api/send';//API地址
        header("Content-type:text/html;charset=utf-8");
        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents('http://'.$smsapi, false, $context);
        if($result == '888'){
            return true;//echo('恭喜：发送成功！');
        }else{
            return false;//echo('错误：发送失败！');
        }
        /////////////////////////////////////////短信接口 结束/////////////////////////////////////////////////////////////
    }else{
        return false;
    }
}   

function isBuyAble($code) {
    $codeid = false;
    if (is_int($code)) {
        $codeid = intval($code);
    } else {
        $code = strtoupper($code);
    }
    $Moption = M('option');
    if ($codeid) {
        $where = array("id" => $codeid);
    } else {
        $where = array("capital_key" => $code);
    }
    $product = $Moption->WHERE($where)->find();
    //品种不存在
    if (!$product) {
        return false;
    }

    /**
     * tradeLimitType 限制交易时间类型 0不限制 1以天为单位限制 2以一周时间为限制
     */
    if ($product['tradeLimitType'] == 0) {
        //不限制
        return true;
    } elseif ($product['tradeLimitType'] == 1) {
        //按照一天为单位进行限制 单位是分钟
        $nowMinute = date("H") * 60 + date("i");
        //如果在限制时间之内
        if ($nowMinute > $product['start_time'] && $nowMinute < $product['end_time']) {
            return true;
        }
    } elseif ($product['tradeLimitType'] == 2) {
        //判断按一周
        $week = date('w');
        if ($week == 0) {
            $week = 6;
        } else {
            $week -= 1;
        }
        //$week是获取今天周几 周天改为7 其他的都是星期几减去1获取
        $nowMinute = $week * 24 * 60 + date("H") * 60 + date("i");
        //如果在限制时间之内
        if ($nowMinute > $product['start_time'] && $nowMinute < $product['end_time']) {
            return true;
        }
    }
    return false;
}


//add by frank----------------------------------------------------------------------------


/**
 * @functionname: sms_alidayu_send_code
 * @author: FrankHong
 * @date:
 * @description:
 * @note:
 * object(stdClass)#10 (2) {
 * ["result"]=>
 * object(stdClass)#11 (3) {
 * ["err_code"]=>
 * string(1) "0"
 * ["model"]=>
 * string(26) "105034655820^1106969866067"
 * ["success"]=>
 * bool(true)
 * }
 * ["request_id"]=>
 * string(12) "3bt4kfioxbdv"
 * }
 * @return array
 * @param $mobile
 */
function sms_alidayu_send_code($mobile)
{
    $returnRs   = array('ret_code' => 0, 'ret_msg' => '');

    if (empty($mobile) || !preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile))
    {
        $returnRs['ret_msg']    = '手机号码错误！';
        return $returnRs;
    }

    $mobile_verify  = get_six_num();

    $returnObj  = Alidayu::SendRegCode($mobile, $mobile_verify);
    //vD($returnObj);

    $returnObj1 = $returnObj->result;
    if($returnObj1->success)
    {
        $returnRs['ret_code']   = 1;
        $returnRs['ret_msg']    = $mobile_verify;
    }
    else
    {
        $returnRs['ret_code']   = 0;
        $returnRs['ret_msg']    = '系统繁忙，发送失败！';
    }

    return $returnRs;

}


/**
 * @functionname: sms_qidian_send_code
 * @author: FrankHong
 * @date: 2016-11-08 15:19:41
 * @description: 发送手机号
 * @note:
 * 例子
 * sms_qidian_send_code('15688889065', '微操盘' , '您的验证码是：', 1)
 *
 *
 * @return array
 * @param $mobile
 * @param string $sign_msg 签名信息，默认验证码
 * @param string $content  签名主体内容，默认  您的验证码是：
 * @param int $sign_where 签名位置，默认1 在左侧， 2右侧
 */
function sms_qidian_send_code($mobile, $sign_msg = '验证码', $content = '您的验证码是：', $sign_where = 1)
{
    $returnRs   = array('ret_code' => 0, 'ret_msg' => '');
    if (empty($mobile) || !preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile))
    {
        $returnRs['ret_msg']    = '手机号码错误！';
        return $returnRs;
    }

    $mobile_verify  = get_six_num();
    $r_sign         = '【'.$sign_msg.'】';
    $r_content      = $content.$mobile_verify;

    if($sign_where == 1)
        $r_content  = $r_sign.$r_content;
    else
        $r_content  = $r_content.$r_sign;


    $smsObj = new QidianSmsApi(C('SMS_USERNAME'), C('SMS_PASSWORD'));
    $res    = $smsObj->sendSMS($mobile, $r_content);
    $res    = $smsObj->execResult($res);

    //vD($res);

    if ($res['Status'] != 1)
    {
        $returnRs['ret_code']   = 0;
        $returnRs['ret_msg']    = '系统繁忙，发送失败！';
        return $returnRs;
    }
    else
    {
        $returnRs['ret_code']   = 1;
        $returnRs['ret_msg']    = $mobile_verify;
        return $returnRs;
    }

}


/**
 * @functionname: sms_qixin_send_code
 * @author: FrankHong
 * @date: 2016-11-19 18:02:33
 * @description: 发送手机号--启信
 * @note:  http://www.ussns.com/Api/index.html
 * 例子
 * sms_qixin_send_code('15688889065', '微操盘' , '您的验证码是：', 1)
 *
 *
 * @return array
 * @param $mobile
 * @param string $sign_msg 签名信息，默认验证码
 * @param string $content  签名主体内容，默认  您的验证码是：
 * @param int $sign_where 签名位置，默认1 在左侧， 2右侧
 */
function sms_qixin_send_code($mobile, $sign_msg = '验证码', $content = '您的验证码是：', $sign_where = 1)
{
    $returnRs   = array('ret_code' => 0, 'ret_msg' => '');
    if (empty($mobile) || !preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile))
    {
        $returnRs['ret_msg']    = '手机号码错误！';
        return $returnRs;
    }

    $mobile_verify  = get_six_num();
    $r_sign         = '【'.$sign_msg.'】';
    $r_content      = $content.$mobile_verify;

    if($sign_where == 1)
        $r_content  = $r_sign.$r_content;
    else
        $r_content  = $r_content.$r_sign;


    $smsObj = new QixinSmsApi(C('SMS_USERNAME'),C('SMS_PASSWORD'));
    $res    = $smsObj->sendSMS($mobile, $r_content);

    //$res    = $smsObj->execResult($res);

    $res    = $smsObj->getResult($res,$mobile_verify);


    //return $res;

    //vD($res);

    if ($res['ret_code'] != 1)
    {
        $returnRs['ret_code']   = 0;
        $returnRs['ret_msg']    = '系统繁忙，发送失败！';
        return $returnRs;
    }
    else
    {
        $returnRs['ret_code']   = 1;
        $returnRs['ret_msg']    = $mobile_verify;
        return $returnRs;
    }

}


/**
 * @functionname: get_six_num
 * @author: FrankHong
 * @date: 2016-11-08 15:24:22
 * @description: 生成随机的6位数字
 * @note: 常用于6位数字手机验证码
 * @return int
 */
function get_six_num()
{
    return mt_rand(100000, 999999);
}

/**
 * @functionname: vD
 * @author: FrankHong
 * @date: 2016-11-08 16:03:12
 * @description: 友好的调试输出
 * @note:
 */
function vD($arr)
{
    header('content-type:text/html;charset=utf-8');
    echo '<pre>';
    var_dump($arr);
    echo '</pre>';
}


/**
 * @functionname: get_setting_config
 * @author: FrankHong
 * @date: 2016-11-14 14:51:49
 * @description: 得到配置信息
 * @note:
 * @return array|string
 * @param $type
 * @param string $name
 */
function get_setting_config($type, $name = '')
{
    $res        = '';
    $setting    = M('setting');
    switch($type)
    {
        //获取单条信息
        case 'find':
            if (empty($name)) break;

            $res    = $setting->field('name, title, datas')->where(array('name' => $name))->find();
            if ($res)
            {
                $res['datas']   = !empty($res['datas']) ? unserialize($res['datas']) : array();
            }
            break;
        case 'all':
            $list   = $setting->field('name,title,datas')->select();
            $res    = array();
            if ($list)
            {
                foreach($list as $key => $val)
                {
                    $res[$val['name']]  = !empty($val['datas']) ? unserialize($val['datas']) : array();
                }
            }
            break;
    }
    return $res;
}


/**
 * @functionname: set_setting_config
 * @author: FrankHong
 * @date: 2016-11-14 15:03:48
 * @description: 设置配置信息
 * @note:
 * @return bool
 * @param $name
 * @param $datas
 */
function set_setting_config($name, $datas)
{    
    $setting    = M('setting');
    if ($setting->where(array('name' => $name))->setField('datas', $datas) !== false)
    {
        $setting->where(array('name' => $name))->setField('modify_date', date('Y-m-d H:i:s'));
        return true;
    }
    else
    {
        return false;
    }
}


/**
 * @functionname: init_common_function
 * @author: FrankHong
 * @date: 2016-11-14 17:24:31
 * @description: 系统加载的配置，来自于表setting
 * @note:
 */
function init_common_function()
{
    $con    = S('DB_CONFIG_DATA');

    if (!$con)
    {
        $con        = array();
        $setting    = get_setting_config('all');

        if (!empty($setting))
            $con    = array_merge($con, $setting);

        S('DB_CONFIG_DATA', $con);
    }

    C($con);
}

/**
 * @functionname: outjson
 * @author: FrankHong
 * @date: 2016-11-16 11:44:23
 * @description: 输出json
 * @note: 输出json，常用于前后台json交互时，后台输出json数据
 * @param $data
 * @param bool $flag
 */
function outjson($data, $flag = true)
{
    header('Content-type: application/json');
    echo json_encode($data, $flag);
    die();
}


/**
 * @author: wang
 * @date: 2016-11-10 12:04:12
 * @description: 外汇转换
 * @note:
 */
   function Transformation($pid){

      $option = M('option')->field('currency')->where(array('id' => $pid))->find();
      return $option['currency'];
}

/**
 * @author: wang
 * @date: 2016-11-10 12:04:12
 * @description: 生成二维码
 * @note:
 */
  
  function qrcode($url,$size=4,$code){

       Vendor('Phpqrcode.phpqrcode');
       $errorCorrectionLevel = 'L';//容错级别   

       // 如果没有http 则添加
        if (strpos($url, 'http')===false) 
           {
               $url='http://'.$url;
           }

       QRcode::png($url,'qrcode.png',$errorCorrectionLevel,$size,2);
       $logo = 'logo.png';//准备好的logo图片   
       $QR = 'qrcode.png';//已经生成的原始二维码图

       if ($logo !== FALSE) {   
        $QR = imagecreatefromstring(file_get_contents($QR));   
        $logo = imagecreatefromstring(file_get_contents($logo));   
        $QR_width = imagesx($QR);//二维码图片宽度   
        $QR_height = imagesy($QR);//二维码图片高度   
        $logo_width = imagesx($logo);//logo图片宽度   
        $logo_height = imagesy($logo);//logo图片高度   
        $logo_qr_width = $QR_width / 5;   
        $scale = $logo_width/$logo_qr_width;   
        $logo_qr_height = $logo_height/$scale;   
        $from_width = ($QR_width - $logo_qr_width) / 2;   
        //重新组合图片并调整大小   
        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,   
        $logo_qr_height, $logo_width, $logo_height);   
      }

        //保存图片到文件夹
         $datapath = 'Uploads/qrcode/';
         if(!is_dir($datapath)) {
             mkdir($datapath,0777);
         } 

        //输出图片   
        $time = $datapath.'extension_'.$code;
        imagepng($QR, "$time.png");
        //$img  = '<img src="'.$time.'.png">';
        $ext = $time.'.png';
        return $ext;
  }


/**
 * @author: wang
 * @date: 2016-11-10 12:04:12
 * @description: 生成6位随机验证码
 * @note:
 */
   function generate_code($length = 6) {
        $randStr = str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz');
        $rand = substr($randStr, 0, $length);
        return $rand;
    }

/**
 * @author: wang
 * @date: 2016-11-10 12:04:12
 * @description: 获取产品名称
 * @note:
 */
 function product_name($pid){

      $name = M('option')->field('capital_name')->where(array('id' => $pid))->find();
      return $name['capital_name'];
 }

 /**
 * @author: wang
 * @date: 2016-11-10 12:04:12
 * @description: 获取上级
 * @note:
 */
 function superior($rid){

    $name = M('userinfo')->field('username,uid')->where(array('uid' => $rid))->find();
    $bank = M('bankinfo')->where(array('uid' => $name['uid']))->find();
    if($name){
          
    if($bank['busername']) {
        return $bank['busername'];
    } else {
        return $name['username'];
    } 
    } else {
        return '无';
    }
}

/**
 * @author: wang
 * @date: 2016-11-10 12:04:12
 * @description: 运营中心
 * @note:
 */
 function exchange($user_id,$numer)
 {     
    $user = M('UserinfoRelationship')->where(array('user_id'=>$user_id))->find();  //用户
     
    if(isset($user))
    {
        //运营中心
         if(trim($numer) == 2){
          
             if($user["user_type"] != 5){
                  return exchange($user["parent_user_id"],$numer);
              }
         }
         
         //经纪人
        if(trim($numer) == 1){

                $user = M("UserinfoRelationship")->where(array('user_id' => $user['parent_user_id']))->find();
        }

        if(isset($user['user_id']))
        {
            
            return $user['user_id'];
        }
    }  else {

        return null;
    }
 }

//运营中心
 function change($user_id){
  
       $user = M('userinfo')->where(array('uid' => $user_id))->find();
       return $user['username'];
 }


  //经纪人昵称
 function agent_name($user_id)
 {
       $user = M('userinfo')->where(array('uid' => $user_id))->find();
       return !empty($user['nickname']) ? $user['nickname'] : $user['username'];
 }

 //上级推广员
 function promotion($user_id,$numer)
 {
    $user = M('userinfo')->where(array('uid' => $user_id))->find();
    if($user['rid'])
    {
        $row = M('userinfo')->where(array('uid' => $user['rid']))->find();
        if($numer == 2)
        {
            $row = M('userinfo')->where(array('uid' => $row['rid']))->find();
        }
    }

    $bank = M('bankinfo')->where(array('uid' => $row['uid']))->find();
    return !empty($bank['busername']) ? $bank['busername'] : $row['username'];
 }
 

 //运营中心统计金额
 function change_money($user_ids,$status){
      
      $arr1 = array();
      $arr2 = array();

      $jinji = M("UserinfoRelationship")->field('user_id')->where(array('parent_user_id' => $user_ids,'user_type' => 6))->select();  //经纪人

      foreach ($jinji as $k => $v) {
         
         array_push($arr1,$v['user_id']);
      }
      $jinji_id = implode(',',array_unique($arr1));

      $user = M("UserinfoRelationship")->field('user_id')->where('parent_user_id in('.$jinji_id.') and user_type=4')->select();

      foreach ($user as $key => $value) {
           
           array_push($arr2,$value['user_id']);
      }
      $user_id = implode(',',array_unique($arr2));
      $order = M("journal")->field('jploss')->where('uid in('.$user_id.') and type = 1 and jtype = "平仓"')->select();
      foreach ($order as $key => $val) {
            
            $sum_ploss += $val['jploss'];
      }

    $order = M("journal")->field('jfee')->where('uid in('.$user_id.') and type = 1 and jtype = "建仓"')->select();
      foreach ($order as $key => $val) {
            
            $sum_fee += $val['jfee'];
      }
     if($status == 1){
              return number_format($sum_fee,2).'元';

     } else {
              return  number_format($sum_ploss,2).'元';
     }
     
 }

/**
 * @author: wang
 * @date: 2016-11-10 12:04:12
 * @description: 后台查看外汇
 * @note:
 */

function currency($code){

  $setting = M("setting")->where(array('name' => 'SYSTEM_CURRENCY_TYPE'))->find();
  $datas = unserialize($setting['datas']);

  return($datas[$code]);
}

/**
 * @author: wang
 * @date: 2016-11-10 12:04:12
 * @description: 判断域名查找运营中心
 * @note:
 */
 function http_host(){

        if($_SERVER['HTTP_HOST']){

              $arr = explode('.',$_SERVER['HTTP_HOST']);
              $a   = explode('.',SYSTEM_DOMAIN);
          
             if($arr[0] == strtolower('www') || $arr[0] == $a[0]){
                     
                     echo '请使用二级域名';
                     exit;
                  
             } else {
                 $user = M('userinfo')->where(array('s_domain' => $arr[0],'otype' => 5))->find();
                 if($user){
                        return $user['uid'];
                  } else {

                        echo '域名不存在';
                        exit;
                  }
             }

        }
 }


function users_online(){

     header('Content-type: text/html; charset=utf-8');
    $online_log = "count.dat"; //保存人数的文件,
    $timeout = 60;//60秒内没动作者,认为掉线
    $entries = file($online_log);
    
    $temp = array();

    for ($i=0;$i<count($entries);$i++) {
    $entry = explode(",",trim($entries[$i]));
    if (($entry[0] != $_SERVER["REMOTE_ADDR"]) && ($entry[1] > time())) {
    array_push($temp,$entry[0].",".$entry[1]."\n"); //取出其他浏览者的信息,并去掉超时者,保存进$temp
    }
    }

    array_push($temp,$_SERVER["REMOTE_ADDR"].",".(time() + ($timeout))."\n"); //更新浏览者的时间
    $users_online = count($temp); //计算在线人数

    $entries = implode("",$temp);
    //写入文件
    $fp = fopen($online_log,"w");
    flock($fp,LOCK_EX); //flock() 不能在NFS以及其他的一些网络文件系统中正常工作
    fputs($fp,$entries);
    flock($fp,LOCK_UN);
    fclose($fp);
    return $users_online;
}


/**
 * @functionname: get_curl_contents
 * @author: FrankHong
 * @date: 2016-12-15 17:46:18
 * @description: curl方法
 * @note:
 * @return bool|mixed|string
 * @param $url
 * @param string $method
 * @param array $data
 */
function get_curl_contents($url, $method = 'GET', $data = array())
{
    if ($method == 'POST')
    {
        //使用crul模拟
        $ch = curl_init();
        //禁用https
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //允许请求以文件流的形式返回
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch); //执行发送
        curl_close($ch);
    }
    else
    {
        if (ini_get('allow_fopen_url') == '1')
        {
            $result = file_get_contents($url);
        }
        else
        {
            //使用crul模拟
            $ch = curl_init();
            //允许请求以文件流的形式返回
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            //禁用https
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch); //执行发送
            curl_close($ch);
        }
    }

    return $result;
}

   function Jiancangtime($oid) {

       $journal=M("journal")->field('jtime')->where(array('oid' => $oid,'jtype'=>"建仓"))->find();
       if($journal) {
         return  date('Y-m-d H:i:s',$journal['jtime']);
       } 
    }

  function getUsername($uid) {

       $bankinfo=M("bankinfo")->field('busername')->where(array('uid' => $uid))->find();
       if(!empty($bankinfo['busername'])) {
         return  $bankinfo['busername'];
       } else {
         $user = M("userinfo")->field('username')->where(array('uid' => $uid))->find();
         return $user['username'];
       }
    }

function extension($uid) 
{
    $extension = M('extension')->where(array('user_id' => $uid))->find();
    return $extension;
}


// 首页时间段 - 时间段
function shijian($pid){

         $time = M('option_deal_time')->where(array('option_id' => $pid))->select();

         $date = time(); //当前时间

         foreach ($time as $key => $value) {
             

               if($value['deal_time_type'] == 2){

                   $end_time = tradetimetotime($value['deal_time_end']) + 24 * 60 * 60;
                   if($date <= tradetimetotime($value['deal_time_start'])){
                      
                      $date = time() + 24 * 60 * 60;
                   }
                  
               } else {
  
                   $end_time = tradetimetotime($value['deal_time_end']);
               }

                   $start_time = tradetimetotime($value['deal_time_start']);

                //判断周六时间段
                if (date('w') == 6) {

                    $end_time = $end_time - 24 * 60 * 60;

                    if($value['deal_time_type'] == 2) {

                      if(time() <= $end_time){

                         $res = '今日凌晨'.date('H:i',$end_time).'休市';
                      }
                    }

                } else if(date('w') == 0) {

                     $res = '已休市';

                } else {
                    if($date >= $start_time && $date <= $end_time){

                      //周一判断
                      if(date('w') == 1 && time() <= $start_time)
                      {
                        return '已休市';
                      }

                        
                        if(date('Y-m-d',$end_time) != date('Y-m-d',time())){

                              $res = date('H:i',$start_time).'-次日'.date('H:i',$end_time);

                        } else {

                             $res = date('H:i',$start_time).'-'.date('H:i',$end_time);
                        }
                    }
                }
}

  if($res) {
      return $res;
  } else{
      return '已休市';
  }

}


  //持仓至
function deal_time_end($pid){

         $time = M('option_deal_time')->where(array('option_id' => $pid))->select();
         
         $date  = time();  //当前时间
         
         foreach ($time as $key => $value) {

             if($value['deal_time_type'] == 2){
                   
                   $end_time = tradetimetotime($value['deal_time_end']) + 24 * 60 * 60;
                   if($date <= tradetimetotime($value['deal_time_start'])){
                      
                        $date = time() + 24 * 60 * 60;
                   } 
               } else{

                   $end_time = tradetimetotime($value['deal_time_end']);
               }

               $start_time = tradetimetotime($value['deal_time_start']);

              //判断周六时间段
              if (date('w') == 6) {
                    $end_time = $end_time - 24 * 60 * 60;
                    if($value['deal_time_type'] == 2) {
                        if(time() <= $end_time){
                           return date('H:i',($end_time-(sell_time() * 60)));
                        }
                    }


              } else {
                    if($date >= $start_time && $date <= $end_time){

                      if(date('Y-m-d',$end_time) != date('Y-m-d',time())){
                        return '次日'.date('H:i',($end_time-(sell_time() * 60)));
                      } else {
                        return date('H:i',($end_time-(sell_time() * 60)));
                      }
                    } 
              }
         }
}


//时间戳转换
function tradetimetotime($ntime) {
  return strtotime(date('Y-m-d ' . substr($ntime, 0, 2) . ':' . substr($ntime, 2, 4) . ':00'));
}


//减少 某个时间平仓
function sell_time(){

      $setting = M("setting")->where(array('name' => 'SYSTEM_OPTION_TIME'))->find();
      $setting = unserialize($setting['datas']);
      return $setting['sys_date'];
}

//交易所赠送金币
function gold(){
 
   $gold = M("webconfig")->field('gold')->where(array('id' => 1))->find();
   return $gold['gold'];

}
function post_codeimglist ($requestUrl, $curlPost) {

            $curl = curl_init();
            //设置提交的url  
            curl_setopt($curl, CURLOPT_URL, $requestUrl);
            //设置头文件的信息作为数据流输出  
            curl_setopt($curl, CURLOPT_HEADER, 0);
            //设置获取的信息以文件流的形式返回，而不是直接输出。  
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            //设置post方式提交  
            curl_setopt($curl, CURLOPT_POST, 1);
            //设置post数据  

            curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
            //执行命令  
            $data = curl_exec($curl);
            //关闭URL请求  
            curl_close($curl);
            //获得数据并返回  
            $data = explode("&", $data);
            foreach ($data as $key => $val) {

                $arr = explode("=", $val);
                $data[$arr[0]] = $arr[1];
                unset($data[$key]);
            }
            return  $data;
           // echo "<img src='data:image/png;base64," . $data['codeImg'] . "'></img>";
           
}

?>
