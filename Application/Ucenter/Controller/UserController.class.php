<?php
/**
 * @author: FrankHong
 * @datetime: 2016/11/30 16:08
 * @filename: UserfController.class.php
 * @description: 运营中心用户模块
 * @note: 
 * 
 */

namespace Ucenter\Controller;


class UserfController extends CommonController
{

    /**
     * @functionname: user_list
     * @author: FrankHong
     * @date: 2016-11-30 17:15:22
     * @description: 运营中心下的所有用户列表
     * @note:
     */
    public function user_list()
    {
        $userinfoRelationshipObj    = M('userinfo_relationship');

        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $userinfoRelationshipRs     = $userinfoRelationshipObj->where($whereArr)->select();

        $userIdArr  = array();
        foreach($userinfoRelationshipRs as $k => $v)
        {
            array_push($userIdArr, $v['user_id']);
        }

        $userIdStr  = implode(',', array_unique($userIdArr));
        //vD($userIdStr);

        $userinfoObj        = M('userinfo');
        $userinfoWhereArr   = 'uid in ('.$userIdStr.')';

        $count      = $userinfoObj->where($userinfoWhereArr)->count();


        $pageObj    = new \Think\Pageace($count, 15);
        $pageShow   = $pageObj->show();

        $userinfoRs = $userinfoObj
            ->where($userinfoWhereArr)
            ->order('temptime desc')
            ->limit($pageObj->firstRow, $pageObj->listRows)
            ->select();

        //vD($userinfoRs);

        foreach($userinfoRs as $k => $v)
        {
            $userinfoRs[$k]['last_login']  = !empty($v['lastlog']) ? date('Y-m-d H:i:s', $v['lastlog']) : '<span class="label label-sm label-warning">未登录过</span>';
            $userinfoRs[$k]['create_date'] = date('Y-m-d H:i:s', $v['utime']);
        }



        //echo $pageObj->firstRow,$pageObj->listRows;

        $nowStart   = $pageObj->firstRow / PAGE_SIZE * PAGE_SIZE + 1;
        $nowEnd     = ($pageObj->firstRow / PAGE_SIZE + 1) * PAGE_SIZE;

        $this->assign('userInfo', $userinfoRs);
        $this->assign('totalCount', $count);

        $this->assign('nowStart', $nowStart);
        $this->assign('nowEnd', $nowEnd);
        $this->assign('pageShow', $pageShow);
        $this->display();
    }


    /**
     * @functionname: user_detail
     * @author: FrankHong
     * @date: 2016-11-30 19:35:57
     * @description: 用户的详细信息
     * @note:
     */
    public function user_detail()
    {
        $this->display();
    }


}