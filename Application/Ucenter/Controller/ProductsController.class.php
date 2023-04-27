<?php
/**
 * @author: FrankHong
 * @datetime: 2016/11/29 13:36
 * @filename: ProductsController.class.php
 * @description:  经纪人-商品模块
 * @note:
 */

namespace Ucenter\Controller;


class ProductsController extends CommonController
{

    /**
     * @functionname: product_list
     * @author: FrankHong
     * @date: 2016-11-29 13:38:00
     * @description: 代理商商品列表
     * @note:
     */
    public function product_list()
    {
        $optionObj  = M('option');
        $whereArr   = array(
            'global_flag'   => 1
        );
        $optionRs   = $optionObj->where($whereArr)->select();

        //vD($optionRs);


        $optionIdArr    = array();
        $optionRs1  = array();
        foreach($optionRs as $k => $v)
        {
            $optionRs1[$v['id']]  = $v;
            array_push($optionIdArr, $v['id']);
        }
        $optionIdStr    = implode(',', array_unique($optionIdArr));


        $optionSpecialObj   = M('option_user_special');
        $optionSpecialRs    = $optionSpecialObj->where('user_id='.NOW_UID.' and option_id in ('.$optionIdStr.')')->select();


        $dictOptionTypeObj  = M('dict_option_type');
        $dictOptionTypeRs   = $dictOptionTypeObj->select();
        foreach($dictOptionTypeRs as $k => $v)
        {
            $dictOptionTypeRs1[$v['id']]    = $v;
        }

        $optionSpecialRs1   = array();
        foreach($optionSpecialRs as $k => $v)
        {
            $optionSpecialRs1[$v['option_id']]              = $v;
            $optionSpecialRs1[$v['option_id']]['type_name'] = $dictOptionTypeRs1[$v['type']]['type_name'];

            $optionSpecialRs1[$v['option_id']]['status_n']  = $v['status'] == 1 ? '可售' : '不可售';
        }

        $optionRs2  = array();
        foreach($optionRs1 as $k => $v)
        {
            $optionRs2[$v['id']]  = $v;
            if(!empty($optionSpecialRs1[$v['id']]['status']))
            {
                $optionRs2[$v['id']]['status_n']    = $optionSpecialRs1[$v['id']]['status'] == 1 ? '可售' : '不可售';
                $optionRs2[$v['id']]['status_o']    = $optionSpecialRs1[$v['id']]['status'] == 1 ? '禁售' : '可售';
                $optionRs2[$v['id']]['status_s']    = $optionSpecialRs1[$v['id']]['status'] == 1 ? 0 : 1;
            }
            else
            {
                $optionRs2[$v['id']]['status_n']    = '不可售';
                $optionRs2[$v['id']]['status_o']    = '可售';
                $optionRs2[$v['id']]['status_s']    = 1;
            }

        }


        //vD($optionRs2);

        $this->assign('optionSpecialRs', $optionSpecialRs1);
        $this->assign('optionRs', $optionRs2);

        $this->display();

    }

    /**
     * @functionname: edit_special_info
     * @author: FrankHong
     * @date: 2016-11-29 18:23:25
     * @description: 代理商设置个人级别所属的商品信息
     * @note:
     */
    public function edit_special_info()
    {
        $optionId   = I('get.option_id');
        $optionObj  = M('option');
        $whereArr   = array(
            'id'    => $optionId
        );

        $optionRs   = $optionObj->where($whereArr)->find();


        $optionSpecialObj   = M('option_user_special');
        $optionSpecialRs    = $optionSpecialObj->where('user_id='.NOW_UID.' and option_id='.$optionId)->find();


        $this->assign('type_id', $optionSpecialRs['type']);
        $this->assign('option_id', $optionId);
        $this->assign('optionRs', $optionRs);
        $this->display();
    }

    /**
     * @functionname: opt_edit_special_info
     * @author: FrankHong
     * @date: 2016-11-29 21:11:25
     * @description: 处理商品的特殊属性
     * @note:
     */
    public function opt_edit_special_info()
    {
        $optionId           = I('post.option_id', 0);
        $optionSpecialType  = I('post.option_special_type', 1);

        if(!$optionId)
            outjson(array('status' => 0, 'ret_msg' => '参数错误'));

        $dataArr            = array();
        $dataArr['type']    = $optionSpecialType;


        $optionSpecialObj   = M('option_user_special');
        $optionSpecialWhere = 'user_id='.NOW_UID.' and option_id='.$optionId;
        $optionSpecialRs    = $optionSpecialObj->where($optionSpecialWhere)->find();

        if($optionSpecialRs)
        {
            $flag   = $optionSpecialObj->where($optionSpecialWhere)->save($dataArr);
        }
        else
        {
            $dataArr['user_id']     = NOW_UID;
            $dataArr['option_id']   = $optionId;
            $dataArr['create_date'] = time();

            $flag   = $optionSpecialObj->where($optionSpecialWhere)->add($dataArr);
        }




        if($flag)
            outjson(array('status' => 1, 'ret_msg' => '保存成功'));
        else
            outjson(array('status' => 0, 'ret_msg' => '保存失败'));
    }


    /**
     * @functionname: opt_edit_special_status
     * @author: FrankHong
     * @date: 2016-11-30 11:06:55
     * @description: 代理设置个人级别所属的商品销售状态
     * @note:
     */
    public function opt_edit_special_status()
    {
        $optionId               = I('post.option_id', 0);
        $optionSpecialStatus    = I('post.option_special_status', '');

        if(!$optionId || !$optionSpecialStatus)
            outjson(array('status' => 0, 'ret_msg' => '参数错误'));

        $dataArr            = array();
        $dataArr['status']  = $optionSpecialStatus;


        $optionSpecialObj   = M('option_user_special');
        $optionSpecialWhere = 'user_id='.NOW_UID.' and option_id='.$optionId;
        $optionSpecialRs    = $optionSpecialObj->where($optionSpecialWhere)->find();

        if($optionSpecialRs)
        {
            $flag   = $optionSpecialObj->where($optionSpecialWhere)->save($dataArr);
        }
        else
        {
            $dataArr['user_id']     = NOW_UID;
            $dataArr['option_id']   = $optionId;
            $dataArr['create_date'] = time();

            $flag   = $optionSpecialObj->where($optionSpecialWhere)->add($dataArr);
        }


        if($flag)
            outjson(array('status' => 1, 'ret_msg' => '保存成功'));
        else
            outjson(array('status' => 0, 'ret_msg' => '保存失败'));
    }

}

