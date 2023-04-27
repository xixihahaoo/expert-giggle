<?php
/**
 * @author: FrankHong
 * @datetime: 2016/11/8 15:07
 * @filename: ToolsController.class.php
 * @description: 代码样例
 * @note:
 * 1.手机验证码使用样例
 * 
 */

namespace Home\Controller;
use Think\Controller;

class DatasController extends Controller
{



    




    public function getdata()
    {

//        echo C('SMS_USERNAME'),'<br>';
//        echo (time() - session('mobile_code_time'));

        //$rs = $this->get_mobile_code('18765412746', 0.1);  //13791078251


        //$rs = $this->get_mobile_code_qixin('15688889065');



        //echo 111;

      //  vD($_SESSION);

    }



    /**
     * @functionname: get_mobile_code
     * @author: FrankHong
     * @date: 2016-11-08 15:09:33
     * @description: 获取手机验证码
     * @note:
     * @return array
     * @param string $mobile  手机号
     * @param int $mobile_code_time  手机验证码有效期，默认2*60
     */
    public function get_mobile_code($mobile = '', $mobile_code_time = 2)
    {

        if(empty($mobile))
            return array('ret_code' => 0, 'ret_msg' => '手机号不能为空');

        if (!preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile))
            return array('ret_code' => 0, 'ret_msg' => '手机号格式错误');

        //一分钟内不能重复获取
        if (time() - session('mobile_code_time') < 60 * 1)
            return array('ret_code' => 0, 'ret_msg' => '您获取验证码太频繁了，请稍后再获取！');

        //判断该手机号码是否还在有效期内, 120s
        if (($mobile == session('mobiles')) && (time() - session('mobile_code_time') < 60 * $mobile_code_time))
            return array('ret_code' => 1, 'ret_msg' => '该号码在1分钟内已经获取过验证码，可继续使用！');

        $res    = sms_qidian_send_code($mobile);

        if ($res['ret_code'] == 1)
        {
            session('mobile_code', $res['ret_msg']);
            session('mobile_code_time', time());
            session('mobiles', $mobile);

            return array('ret_code' => 1, 'ret_msg' => '短信发送成功');
        }
        else
        {
            return array('ret_code' => 0, 'ret_msg' => $res['ret_msg']);
        }
    }


    /**
     * @functionname: get_mobile_code_qixin
     * @author: FrankHong
     * @date: 2016-11-19 18:01:39
     * @description: 获取手机验证码--启信接口
     * @note:
     * @return array
     * @param string $mobile  手机号
     * @param int $mobile_code_time  手机验证码有效期，默认2*60
     */
    public function get_mobile_code_qixin($mobile = '', $mobile_code_time = 2)
    {

        if(empty($mobile))
            return array('ret_code' => 0, 'ret_msg' => '手机号不能为空');

        if (!preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile))
            return array('ret_code' => 0, 'ret_msg' => '手机号格式错误');

        //一分钟内不能重复获取
        if (time() - session('mobile_code_time') < 60 * 1)
            return array('ret_code' => 0, 'ret_msg' => '您获取验证码太频繁了，请稍后再获取！');

        //判断该手机号码是否还在有效期内, 120s
        if (($mobile == session('mobiles')) && (time() - session('mobile_code_time') < 60 * $mobile_code_time))
            return array('ret_code' => 1, 'ret_msg' => '该号码在1分钟内已经获取过验证码，可继续使用！');

        $res    = sms_qixin_send_code($mobile);

        if ($res['ret_code'] == 1)
        {
            session('mobile_code', $res['ret_msg']);
            session('mobile_code_time', time());
            session('mobiles', $mobile);

            return array('ret_code' => 1, 'ret_msg' => '短信发送成功');
        }
        else
        {
            return array('ret_code' => 0, 'ret_msg' => $res['ret_msg']);
        }
    }



 /**
  * 短信验证码
  * @author wang <admin>
  */
    public function smsverify(){
         
         $mobile = I('get.mobile');  //手机号
         $code = $this->get_mobile_code($mobile);
         $this->ajaxReturn($code);
         
    }


}