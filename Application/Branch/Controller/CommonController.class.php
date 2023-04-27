<?php

namespace Branch\Controller;
use Think\Controller;


class CommonController extends Controller
{

    public function _initialize()
    {
        //判断用户是否已经登录
        if (!isset($_SESSION['cuid']))
        {
            $this->redirect('Admin/User/signin');
        }

        define('NOW_UID', $_SESSION['cuid']);
        define('NOW_USER_TYPE', session('userotype'));
        define('PAGE_SIZE', 15);

        $this->assign('nowMenu', strtolower(CONTROLLER_NAME));
        $this->assign('nowAct', strtolower(ACTION_NAME));

        $new_nickname = session('new_nickname');
        $new_nickname = empty($new_nickname) ? session('newusername') : session('new_nickname');
        $this->assign('user_nickname', $new_nickname);
    }

}