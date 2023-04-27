<?php

namespace Admin\Controller;
use Think\Controller;
class OutpwdController extends Controller {
	
  /**
  * 忘记密码
  * @author wang <admin>
  */
 
 public function outpwd() {
   
      //查询当前运营中心下的所有经纪人

        $mobile      = trim(I('post.mobile'));
        $smscode     = trim(I('post.smscode'));
        $password    = trim(I('post.password'));
        $notpassword = trim(I('post.notpassword'));

        $map['utel']  = $mobile;
        $map['otype'] = 3;
      
        if(empty($mobile)){
            $data['status'] = 0;
            $data['msg']    = '手机号不能为空';
            $this->ajaxReturn($data,'JSON');
         }

        if(empty($smscode)){
            $data['status'] = 0;
            $data['msg']    = '短信验证码不能为空';
            $this->ajaxReturn($data,'JSON');
         }

        if($smscode != $_SESSION['mobile_code']){
            $data['status'] = 0;
            $data['msg']    = '短信验证码不正确 ';
            $this->ajaxReturn($data,'JSON');
        }

        if(!is_numeric($password) || !is_numeric($notpassword)){
            $data['status'] = 0;
            $data['msg']    = '密码只能输入数字';
            $this->ajaxReturn($data,'JSON');
         }

        if(empty($password) || empty($notpassword)){
            $data['status'] = 0;
            $data['msg']    = '密码或确认密码不能为空';
            $this->ajaxReturn($data,'JSON');
         }

        if($password != $notpassword){
            $data['status'] = 0;
            $data['msg']    = '两次密码不一致';
            $this->ajaxReturn($data,'JSON');
         }

        $user = M("userinfo")->where($map)->find();
        if(!$user){
            $data['status'] = 0;
            $data['msg']    = '此号码只适用于管理员';
            $this->ajaxReturn($data,'JSON');
        }
        
        $where['utel']  = $mobile;
        $where['otype'] = 3;
        $res = M('userinfo')->where($where)->setField('upwd',md5($password));
        if($res){
              $data['status'] = 1;
              $data['msg']    = '修改成功';
              $this->ajaxReturn($data,'JSON');

        } else{
              $data['status'] = 0;
              $data['msg']    = '修改失败';
              $this->ajaxReturn($data,'JSON');
        }
    }
}