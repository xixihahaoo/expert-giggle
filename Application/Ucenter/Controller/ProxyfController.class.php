<?php
/**
 * @author: FrankHong
 * @datetime: 2016-12-12 09:58:30
 * @filename: ProxyfController.class.php
 * @description: 运营中心信息模块
 * @note:
 *
 */

namespace Ucenter\Controller;


class ProxyfController extends CommonController
{

    /**
     * @functionname: sys_info
     * @author: FrankHong
     * @date: 2016-12-12 09:58:40
     * @description: 个人信息
     * @note:
     */
    public function sys_info()
    {
        $userinfoObj        = M('userinfo');
        $userInfoWhere      = 'uid='.NOW_UID;
        $userInfoRs         = $userinfoObj->where($userInfoWhere)->find();


        $systemName         = !empty($userInfoRs['s_domain_name']) ? $userInfoRs['s_domain_name'] : SYSTEM_DOMAIN_NAME;

        $userInfoRs['s_domain_trades'] = $userInfoRs['s_domain_trade'] == 1 ? 2 : 1;

        $this->assign('userInfo', $userInfoRs);
        $this->assign('systemName', $systemName);
        $this->assign('s_domain', SYSTEM_DOMAIN);
        $this->assign('now_user_id', NOW_UID);
        $this->display();
    }


    /**
     * @functionname: opt_sys_info
     * @author: FrankHong
     * @date: 2016-12-12 11:58:47
     * @description: 处理运营中心信息保存
     * @note:
     */
    public function opt_sys_info()
    {
        $userId     = I('post.now_user_id');

        $nickname   = I('post.nickname', '');
        //$mobile     = I('post.mobile', '');
        $domainName = I('post.domain_name', '');

        if(!$userId || $userId != NOW_UID)
            outjson(array('status' => 0, 'ret_msg' => '系统错误'));

        if(!$nickname || !$domainName)
            outjson(array('status' => 0, 'ret_msg' => '不能为空'));

        $dataArr    = array();


        $dataArr['nickname']    = $nickname;
        //$dataArr['utel']        = $mobile;
        $dataArr['s_domain_name']   = $domainName;
        $dataArr['update_time'] = time();

        $userinfoObj    = M('userinfo');
        $whereStr       = 'uid=' . NOW_UID;
        $userinfoRs     = $userinfoObj->where($whereStr)->find();


        if (!$userinfoRs)
        {
            outjson(array('status' => 0, 'ret_msg' => '系统错误：未查询到信息！'));
        }
        else
        {
            $flag   = $userinfoObj->where($whereStr)->save($dataArr);
            if($flag)
                outjson(array('status' => 1, 'ret_msg' => '保存成功'));
            else
                outjson(array('status' => 0, 'ret_msg' => '保存失败！'));
        }

    }

    /**
     * @functionname: change_password
     * @author: FrankHong
     * @date: 2016-12-12 10:43:02
     * @description: 运营中心修改后台密码
     * @note:
     */
    public function change_password()
    {
        if(!NOW_UID)
        {
            $this->display('Common/error_no_info');
            die();
        }

        $userinfoObj        = M('userinfo');
        $userInfoWhere      = 'uid='.NOW_UID;
        $userInfoRs         = $userinfoObj->where($userInfoWhere)->find();

        $this->assign('userInfo', $userInfoRs);
        $this->assign('now_user_id', NOW_UID);
        $this->display();
    }

    /**
     * @functionname: opt_change_password
     * @author: FrankHong
     * @date: 2016-12-12 10:48:02
     * @description: 处理修改密码
     * @note:
     */
    public function opt_change_password()
    {
        $password   = I('post.password'. '');
        $rpassword  = I('post.rpassword'. '');
        $nowUserId  = I('post.now_user_id'. '');

        if(NOW_UID != $nowUserId)
            outjson(array('status' => 0, 'ret_msg' => '系统错误'));

        if(!$password || !$rpassword)
            outjson(array('status' => 0, 'ret_msg' => '两次输入的密码不一样'));

        if($password != $rpassword)
            outjson(array('status' => 0, 'ret_msg' => '两次输入的密码不一样'));

        $userinfoObj        = M('userinfo');
        $dataArr            = array(
            'upwd'  => md5($password)
        );
        $userInfoWhere      = 'uid='.NOW_UID;
        $flag               = $userinfoObj->where($userInfoWhere)->save($dataArr);

        if($flag)
            outjson(array('status' => 1, 'ret_msg' => '密码修改成功！'));

    }

    /**
     * @functionname: weixin_img
     * @author: FrankHong
     * @date: 2016-12-12 11:32:57
     * @description: 上传运营中心的公众号二维码图片
     * @note:
     */
    public function weixin_img()
    {

        $userinfoObj        = M('userinfo');
        $userInfoWhere      = 'uid='.NOW_UID;
        $userInfoRs         = $userinfoObj->where($userInfoWhere)->find();

        $this->assign('userInfo', $userInfoRs);

        $this->display();
    }

    /**
     * @functionname: opt_upload_img
     * @author: FrankHong
     * @date: 2016-12-12 11:35:54
     * @description: 处理上传图片
     * @note:
     */
    public function opt_weixin_img()
    {
        $userId     = I('post.user_id');
        $ncover     = I('post.ncover', '');

        if(!$userId)
            outjson(array('status' => 0, 'ret_msg' => '系统错误'));

        if(!$ncover)
            outjson(array('status' => 0, 'ret_msg' => '请选择要上传的图片'));

        $configUpload   = array('rootPath' => SYSTEM_WEIXIN_UPLOAD_PATH);
        $upload         = new \Think\Upload($configUpload);// 实例化上传类
        $upload->maxSize    = 3145728 ;// 设置附件上传大小
        $upload->exts       = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型

        $info   = $upload->upload();

        if(!$info)
        {
            $this->error($upload->getError());
        }
        else
        {
            foreach($info as $file)
                $idcover    = $file['savepath'].$file['savename'];
        }

        $agentExtraObj  = M('agent_extra');

        $agentExtraRs   = $agentExtraObj->where('agent_user_id='.$userId)->select();
        $agentExtraC    = count($agentExtraRs);

        $agentExtraObj->where('agent_user_id='.$userId)->limit($agentExtraC)->delete();

        //$agentExtra

        $dataSave['agent_user_id']  = $userId;
        $dataSave['weixin_logo']    = $idcover;

        $flag   = $agentExtraObj->add($dataSave);
        if($flag)
        {
            $this->success("公众号二维码添加成功", U('proxyf/proxy_system_detail'));

        }
        else
        {
            $this->success("添加失败，请重新处理", U('proxyf/weixin_img'));
        }

    }

    /**
     * @functionname: proxy_system_detail
     * @author: FrankHong
     * @date: 2016-12-12 11:42:05
     * @description: 查看运营中心公众号二维码图片
     * @note:
     */
    public function proxy_system_detail()
    {

        $agentExtraObj  = M('agent_extra');
        $agentExtraRs   = $agentExtraObj->where('agent_user_id='.NOW_UID)->find();

        $userinfoObj	= M('userinfo');
        $userinfoRs		= $userinfoObj->where('uid='.NOW_UID)->find();

        $imgUrl         = 'http://'.$userinfoRs['s_domain'].'.'.SYSTEM_DOMAIN.'/Uploads/'.$agentExtraRs['weixin_logo'];

        $this->assign('agentId', NOW_UID);
        $this->assign('imgUrl', $imgUrl);

        $this->display();
    }

    /**
     * @functionname: proxy_open_start
     * @date: 2016-12-12 11:42:05
     * @description: 开启模拟交易系统
     * @note:
     */
    public function proxy_open_start()
    {
        $trade = trim(I('post.trade'));
        $userObj = M('userinfo');

        $data = array();

        $result = $userObj->where(array('uid' => NOW_UID))->setField('s_domain_trade',$trade);
        if($result)
        {
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