<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {

    public function _initialize()
    {
        init_common_function();


        // 需要跳过登陆验证的路由 by linjuming 2017-4-30     
        $excluded_rotuers = array(
            '/Home/PayZn/notify'
        );
        if(in_array(__ACTION__, $excluded_rotuers)){
            return;
        }

        //判断运营中心域名在本系统是否存在
//        http_host();


        $user_id = $_COOKIE['user_id'];    //判断cookie是否存在

        //判断用户是否已经登录
        if (!empty($user_id)) {
            $user = M('userinfo')->field('uid,username,utel')->where(array('uid' => $user_id,'otype' => 4,'ustatus' => 0))->find();

            if($user)
            {
                session('user_id',$user['uid']);
                session('username',$user['username']);
                session('utel',$user['utel']);
            } else {
                unset($_SESSION['user_id']);
                unset($_SESSION['username']);
                unset($_SESSION['utel']);

                setcookie('user_id', '', time() - 3600, '/');
                $this->redirect('Register/login');
            }
        } else {
            $this->redirect('Register/login');
        }

        //取出用户余额
        $this->user_id = session('user_id');

        if(isset($this->user_id)) {
            
            $where['uid']     = $this->user_id;
            $where['otype']   = 4;
            $where['_string'] = 'ustatus = 2 OR ustatus = 1';
            $info = M("userinfo")->where($where)->find();
            if($info) {
               session_unset();
               $this->redirect('Register/login');
            }
            //账号余额
            $user=M('accountinfo')->where(array('uid' => $this->user_id))->find();
            $this->assign('user',$user);
            $this->assign('ajax',C('AJAX'));
        }
        
            //取出对应运营中心id
            $this->agent_id = exchange($this->user_id,2);
    }
}
