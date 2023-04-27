<?php
namespace Home\Controller;
use Think\Controller;
class RegisterController extends Controller {


 /**
  * 用户注册
  * @author wang <admin>
  */
 public function reg(){
    $this->display('User/reg');
 }


 /**
  * 用户注册接口
  * @author wang <admin>
  */
   public function register()
   {
         $mobile   = trim(I('post.mobile'));    //手机号
         $smscode  = trim(I('post.smscode'));   //短信验证码
         $password = trim(I('post.password'));  //密码
         $tuig     = trim(I('post.tuig'));      //推广码

         if(empty($mobile))
            outjson(['status' => 0,'msg' => '手机号不能为空']);

         if(empty($smscode))
            outjson(['status' => 0,'msg' => '短信验证码不能为空']);

         if(empty($password))
            outjson(['status' => 0,'msg' => '密码不能为空']);

         if(empty($tuig))
            outjson(['status' => 0,'msg' => '推广码必填']);

         if($smscode != session('mobile_code'))
            outjson(['status' => 0,'msg' => '短信验证码不正确']);


        //判断是否已经有删除的
        $delUser = M('userinfo')->field('uid')->where('utel = '.$mobile.' and ustatus = 2 and otype = 4')->find();

        if($delUser) {

            M("userinfo")->where('uid='.$delUser['uid'])->delete();
            M('accountinfo')->where('uid='.$delUser['uid'])->delete();
            M('bankinfo')->where('uid='.$delUser['uid'])->delete();
            M('UserinfoRelationship')->where('user_id='.$delUser['uid'])->delete();
        }

        if(M('userinfo')->field('uid')->where('utel='.$mobile.' and ustatus in(0,1) and otype=4')->find())
            outjson(['status' => 0,'msg' => '手机号已经被注册了']);


        if(!empty($tuig)) {

           $code = M('userinfo')->field('uid,otype')->where(array('code' => $tuig))->find();
           if(!$code) {
               outjson(['status' => 0,'msg' => '推广人不存在']);
           } else{
               
              if($code['otype'] == 4)
              {
               $parent_user_id  = M("UserinfoRelationship")->where(array('user_id' => $code['uid']))->getField('parent_user_id');

               $rela['parent_user_id']  = $parent_user_id;   //代理商id
               $map['rid']              = $code['uid'];      //推广人id
             } else if($code['otype'] == 6)
             {
               $rela['parent_user_id'] = $code['uid'];       //代理商id
             }
           }
        }

        $res = M("UserinfoRelationship")->where(array('parent_user_id' => http_host()))->select();
        $arr = array();
        foreach ($res as $key => $value) {
           array_push($arr,$value['user_id']);             
        }

        $arrid = implode(',',$arr);
        $info  = M("userinfo")->field('uid')->where('uid in('.$arrid.') and is_default = 1')->find();

        if(empty($tuig)){
          if(!$info)
              outjson(['status' => 0,'msg' => '代理商不存在']);

          $rela['parent_user_id'] = $info['uid']; //代理商id
        }


        $userinfo             = M("userinfo");
        $accountinfo          = M("accountinfo");
        $UserinfoRelationship = M("UserinfoRelationship");
        $userinfo->startTrans();

        $map['username']    = $mobile;
        $map['upwd']        = md5($password);
        $map['utel']        = $mobile;
        $map['utime']       = time();
        $map['agenttype'] = 0;
        $map['otype']     = 4;
        $map['ustatus']   = 0;
        $map['usertype']  = 0;  //不是微信用户
        $map['wxtype']    = 1;  //微信还没注册
        $map['nickname']  = '操盘手'.$mobile.'';//用户昵称
        $map['reg_ip']    = get_client_ip();    //用户注册ip
        $result = $userinfo->add($map);
        
        $account['uid']  = $result;
        $account['gold'] = gold();  //赠送金币
        $info = $accountinfo->add($account);

        //用户关系表
        $rela['user_id']        = $result;
        $rela['user_type']      = 4;
        $ship = $UserinfoRelationship->add($rela);

        if($result && $info && $ship){
            $userinfo->commit();
            outjson(['status' => 1,'msg' => '注册成功']);
        } else {
            $userinfo->rollback();
            outjson(['status' => 0,'msg' => '注册失败']);
        }
  }


   public function redirect_wx()
    {
        $this->redirect('Index/index');
        die();

        if(!session('user_id'))
        {
            $this->redirect('Register/login');
            die();
        }

        $userOpenObj    = M('userinfo_open');
        $userOpenRs     = $userOpenObj->where('user_id='.session('user_id'))->find();


        if(!empty($userOpenRs['open_id']))
        {
            $this->redirect('Index/index');
        }
        else
        {
            $wxObj  = new WxController();
            $wxObj->weixin_oauth();
        }
    }

 /**
  * 用户登录
  * @author wang <admin>
  */
  public function login(){
        if(IS_AJAX){

           $tel      = trim(I("post.tel"));
           $password = md5(trim(I('post.password')));
           $cookies  = trim(I('post.cookies'));


           $where['utel']    = $tel;
           $where['otype']   = 4;
           $where['ustatus'] = 0;
           $user = M('userinfo')->field('uid,username,upwd,ustatus')->where($where)->find();

           if(!$user)
               outjson(['status' => 0,'msg' => '用户不存在']);

           if($user['upwd'] != $password)
               outjson(['status' => 0,'msg' => '密码不正确']);

           if($user['ustatus'] == 1)
               outjson(['status' => 0,'msg' => '该帐号被冻结']);


           session('user_id',$user['uid']);
           session('username',$user['username']);
           session('tel',$user['tel']);

           if(session('user_id')) {

                setcookie("user_id", $user['uid'], (time() + 24 * 60 * 60) * 15, '/');

                if($cookies == 1)
                    setcookie("username",$user['username'],time()+ 24 * 60 * 60,'/');
                else
                    setcookie("username",'',time()-1,'/');

                $map['lastlog']         = time();
                $map['last_login_ip']   = get_client_ip(); //最后登录ip
                M("userinfo")->where(array('uid' => $user['uid']))->save($map);   //用户最后登录时间

                outjson(['status' => 1,'msg' => '登录成功']);
           } else {

                outjson(['status' => 0,'msg' => '用户名或密码输入错误']);
           }

        } else{
               $user['username'] = isset($_COOKIE['username'])?$_COOKIE['username']:'';
               $this->assign('user',$user);
               $this->display('User/login');
        }

  }


  /**
  * 忘记密码
  * @author wang <admin>
  */
 
 public function outpwd() {

     if(IS_POST) {

         $mobile     = trim(I('post.mobile'));
         $password   = trim(I('post.password'));
         $smscode    = trim(I('post.smscode'));

         if(empty($mobile))
             outjson(['status' => 0,'msg' => '手机号不能为空']);

         if(empty($smscode))
             outjson(['status' => 0,'msg' => '短信验证码不能为空']);

         if(empty($password))
             outjson(['status' => 0,'msg' => '新密码不能为空']);

         if($smscode != session('mobile_code'))
             outjson(['status' => 0,'msg' => '短信验证码不正确']);

         $map['utel']               = $mobile;
         $map['ustatus']            = array('in','0,1');
         $map['otype']              = 4;

         $user = M("userinfo")->where($map)->find();

         if(!$user)
             outjson(['status' => 0,'msg' => '用户不存在']);

         if($user['ustatus'] == 1)
             outjson(['status' => 0,'msg' => '用户被冻结']);


         $res = M('userinfo')->where($map)->setField('upwd',md5($password));
         if($res)
             outjson(['status' => 1,'msg' => '修改成功']);
         else
             outjson(['status' => 0,'msg' => '修改失败']);


     } else {
         $this->display('User/outpwd');
     }
 }

  /**
  * 退出登录
  * @author wang <admin>
  */

public function logout(){
    session_unset();
    session_destroy();
    setcookie('user_id', '', time() - 3600, '/');
    $this->redirect('login');

}

  /**
  * 订阅号关注
  * @author wang <admin>
  */
public function concern(){
    
     $extra = M("AgentExtra")->where(array('agent_user_id' => http_host()))->find();
     if($extra['weixin_logo']){
                    
            $this->assign('extra',$extra);
            $this->display('Ucenter/concern');
      } else {

            $this->display('User/login');
      }
}

}