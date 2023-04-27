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


use Org\Util\Alidayu;


class ToolsController extends Controller
{


    /**
     * @functionname: index
     * @author: FrankHong
     * @date:
     * @description:
     * @note:
     *
     * array(2) {
        ["ret_code"]=>
        int(1)
        ["ret_msg"]=>
        string(18) "短信发送成功"
        }
     */
    public function index()
    {

//        echo C('SMS_USERNAME'),'<br>';
//        echo (time() - session('mobile_code_time'));

        //$rs = $this->get_mobile_code('18765412746', 0.1);  //13791078251


        //$rs = $this->get_mobile_code_qixin('15688889065');

//        $returnRs   = Alidayu::SendRegCode('15688889065', '111111');
//        vD($returnRs);


        //$returnRs   = sms_alidayu_send_code('15688889065');


        $returnRs   = $this->get_mobile_code('15688889065');

        vD($_SESSION);
        vD($returnRs);
        //get_mobile_code_alidayu

        //vD($returnRs);
        //$this->display('tuiguang');



    }



    /**
     * @functionname: get_mobile_code
     * @author: FrankHong
     * @date: 2016-11-08 15:09:33
     * @description: 获取手机验证码 起点接口
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

        $res    = sms_qidian_send_code($mobile,'鼎盛国际');

        if ($res['ret_code'] == 1)
        {
            session('mobile_code', $res['ret_msg']);
            session('mobile_code_time', time());
            session('mobiles', $mobile);

			$mObj   = M();
            $addArr = array(
                'mobile'        => $mobile,
                'mobile_code'   => $res['ret_msg'],
                'type'          => 1
            );
            $mObj->table('log_mobile_code')->add($addArr);

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

			$mObj   = M();
            $addArr = array(
                'mobile'        => $mobile,
                'mobile_code'   => $res['ret_msg'],
                'type'          => 2
            );
            $mObj->table('log_mobile_code')->add($addArr);

            return array('ret_code' => 1, 'ret_msg' => '短信发送成功');
        }
        else
        {
            return array('ret_code' => 0, 'ret_msg' => $res['ret_msg']);
        }
    }


    /**
     * @functionname: get_mobile_code_alidayu
     * @author: FrankHong
     * @date: 2016-12-15 12:26:18
     * @description:  获取手机验证码--阿里大于
     * @note:
     * @return array
     * @param string $mobile
     * @param int $mobile_code_time
     */
    public function get_mobile_code_alidayu($mobile = '', $mobile_code_time = 1)
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
            return array('ret_code' => 1, 'ret_msg' => '该号码在'.$mobile_code_time.'分钟内已经获取过验证码，可继续使用！');

        $res    = sms_alidayu_send_code($mobile);

        if ($res['ret_code'] == 1)
        {
            session('mobile_code', $res['ret_msg']);
            session('mobile_code_time', time());
            session('mobiles', $mobile);

			$mObj   = M();
            $addArr = array(
                'mobile'        => $mobile,
                'mobile_code'   => $res['ret_msg'],
                'type'          => 3
            );
            $mObj->table('log_mobile_code')->add($addArr);

            return array('ret_code' => 1, 'ret_msg' => '短信发送成功');
        }
        else
        {
            return array('ret_code' => 0, 'ret_msg' => $res['ret_msg']);
        }
    }


 /**
  * 短信验证码 注册用户
  * @author wang <admin>
  */
    public function smsverify(){
         
         $mobile = I('get.mobile');  //手机号

         $map['utel']    = $mobile;
         $map['ustatus'] = array('in','0,1');  //没有被删除的用户
         $map['otype']   = 4;

        $user = M('userinfo')->where('utel='.$mobile.' and ustatus in(0,1) and otype=4')->find();
         if($user) {
                $code = array();
                $code['ret_code'] = 'error';
                $code['ret_msg']  = '该手机号码已经被注册了';
                $this->ajaxReturn($code);  
         }

         $info = M("userinfo")->where($map)->find();

         if($info){
                if($info['ustatus'] == 1){
                    $code = array();
                    $code['ret_code'] = 'error';
                    $code['ret_msg']  = '该账户被冻结了';
                    $this->ajaxReturn($code);  
                } else {
                    $code = array();
                    $code['ret_code'] = 'error';
                    $code['ret_msg']  = '该手机号码已经被注册了';
                    $this->ajaxReturn($code);  
                }
         } else {
                $code = $this->get_mobile_code($mobile);
                $this->ajaxReturn($code);
         }
    }

 /**
  * 短信验证码 修改密码
  * @author wang <admin>
  */
    public function save_smsverify(){
         
         $mobile = I('get.mobile');   //手机号
         $map['utel']    = $mobile;
         $map['ustatus'] = array('in','0,1');
         $map['otype']  = 4;

         $info = M("userinfo")->where($map)->find();

         if(!$info){
              
              $code = array();
              $code['ret_code'] = 'error';
              $code['ret_msg']  = '系统未查到此号码'; 
              $this->ajaxReturn($code);
         } else {
                if($info['ustatus'] == 1){
                    $code = array();
                    $code['ret_code'] = 'error';
                    $code['ret_msg']  = '该账户被冻结了';
                    $this->ajaxReturn($code);
                } else {
                    $code = $this->get_mobile_code($mobile);
                   $this->ajaxReturn($code);
                } 
         }
    }


    /**
     * 短信验证码 管理员修改密码
     * @author wang <admin>
     */
    public function save_smsverify_admin()
    {
        $mobile = trim(I('get.mobile'));   //手机号
        $map['utel']  = $mobile;
        $map['otype'] = 3;
        $info = M("userinfo")->where($map)->find();
        if(!$info){
            $code = array();
            $code['ret_msg'] = '此号码只适用于管理员';
            $this->ajaxReturn($code);
        } else {
            $code = $this->get_mobile_code($mobile);
            $this->ajaxReturn($code);
        }
    }
}