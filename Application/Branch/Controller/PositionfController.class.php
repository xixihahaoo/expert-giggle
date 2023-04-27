<?php
/**
 * @author: wang
 * @datetime: 2017/5/28 16:08
 * @filename: PositionfController.class.php
 * @description:  持仓监控模块
 * @note: 
 * 
 */

namespace Branch\Controller;
use Think\Controller;
use Org\Util\Excel;

class PositionfController extends CommonController
{
    public function tlist()
    {

         $order = M('order a');
          
         $operate       = trim(I('get.operate'));
         $jinjiren      = trim(I('get.jinjiren'));
         $user          = trim(I('get.user'));
         $starttime     = urldecode(trim(I('get.start_time')));
         $endtime       = urldecode(trim(I('get.end_time')));
         $utel          = trim(I('get.utel'));
         $option_name   = trim(I('get.option_name'));
        
         $userinfoRelationshipObj    = M('userinfo_relationship');

        //运营中心
        $whereArr   = array(
            'parent_user_id'    => NOW_UID
        );
        $operateinfoRelationshipRs    = $userinfoRelationshipObj->where($whereArr)->select();

        $operateIdArr  = array();
        foreach($operateinfoRelationshipRs as $k => $v)
        {
            array_push($operateIdArr, $v['user_id']);
        }

        $operateIdStr  = implode(',', array_unique($operateIdArr));
        

        $userinfoObj            = M('userinfo');
        $operateinfoWhereArr    = 'uid in ('.$operateIdStr.')';

        $operateinfoRs    = $userinfoObj->field('uid,username,nickname')->where($operateinfoWhereArr)->select();
        $operateinfoRs1   = array();
        foreach($operateinfoRs as $k => $v)
        {
            $operateinfoRs1[$v['uid']]    = $v;
        }
        $this->assign('operateinfoRs',$operateinfoRs);


        //经纪人
        $agentinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$operateIdStr.')')->select();
        $agentIdArr     = array();
        $agentIdArr2    = array();
        foreach($agentinfoRelationshipRs as $k => $v)
        {
            array_push($agentIdArr, $v['user_id']);
            $agentIdArr2[$v['user_id']] = $v;
        }

        $agentIdStr  = implode(',', array_unique($agentIdArr));

        $userinfoObj        = M('userinfo');
        $agentinfoWhereArr  = 'uid in ('.$agentIdStr.')';

        $agentinfoRs    = $userinfoObj->field('uid,username,nickname')->where($agentinfoWhereArr)->select();
        $agentinfoRs1   = array();
        foreach($agentinfoRs as $k => $v)
        {
            $agentinfoRs1[$v['uid']]    = $v;
        }


         
        //用户
        $ship = M("UserinfoRelationship")->where('parent_user_id in('.$agentIdStr.')')->select();
        $shipArr = array();
        foreach ($ship as $key => $value) {
            array_push($shipArr,$value['user_id']);               
        }
        $where['a.uid'] = array('in',implode(',',array_unique($shipArr)));





        // 联动运营中心筛选
        if($operate)
        {
            $agentArr = array();
            $agentinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$operate.')')->select();
            foreach ($agentinfoRelationshipRs as $key => $value) {
                 array_push($agentArr,$value['user_id']);
            }
            $agentId = implode(',',array_unique($agentArr));
            
            $userArr = array();
            $userinfoRelationshipRs = $userinfoRelationshipObj->where('parent_user_id in ('.$agentId.')')->select();
            foreach ($userinfoRelationshipRs as $key => $value) {
                 array_push($userArr,$value['user_id']);
            }
            $userIdStr = implode(',',array_unique($userArr));
            $this->assign('operate',$operate);
        }


        //联动经纪人筛选
        if($jinjiren != ''){
            
            $userarr  = array();
            $userarr1 = array(); 
            $ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jinjiren))->select();
            foreach ($ship as $key => $value) {
                
                array_push($userarr, $value['user_id']);
            }
            $id = implode(',',array_unique($userarr));

            $where['a.uid'] = array('in',$id);
            $sea['jinjiren'] = $jinjiren;
            $this->assign('jingji',$jinjiren);
            $this->assign('jinjiren',$this->get_username($jinjiren));
        }

        //联动用户筛选
        if($user != ''){
            
            $id = $user; 
            $where['a.uid'] = array('in',$id);
            $sea['user'] = $user;
            $this->assign('user',$this->get_username($user));
        }

        //日期筛选
        if($starttime && $endtime){
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $where['a.buytime'] = array('between',array($start_time,$end_time));
            $sea['start_time'] = $starttime;
            $sea['end_time'] = $endtime;
            $this->assign('time',$sea);
        }    

        //手机号码筛选
        if($utel) {
            $where['b.utel'] = $utel;
            $sea['utel'] = $utel;
            $this->assign('utel',$utel);
        }
        
        //交易品种筛选
        if($option_name) {
           $where['c.capital_name'] = $option_name;
           $sea['option_name'] = $option_name;
           $this->assign('op_name',$option_name);
        }


        $where['a.type'] = 1;       //区分真实和模拟交易
        $where['a.ostaus']  = 0;
        $where['a.display'] = 0;

        $counts = $order->
                        join('left join wp_userinfo as b on a.uid = b.uid')->
                        join('left join wp_option as c on a.pid = c.id')->
                        join('left join wp_option_info as d on c.id = d.option_id')->
                        where($where)->
                        count();

        $pagecount = 10;
        $page = new \Think\Page($counts , $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','<<');
        $page->setConfig('next','>>');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $start = $page->firstRow;
        $end   = $page->listRows;
        $show = $page->show();
        
        $field = 'a.*,b.utel,c.capital_name,c.currency,d.capital_length';
        $tlist = $order->field($field)->
                            join('left join wp_userinfo as b on a.uid = b.uid')->
                            join('left join wp_option as c on a.pid = c.id')->
                            join('left join wp_option_info as d on c.id = d.option_id')->
                            where($where)->
                            order('a.oid desc')->
                            limit($page->firstRow.','.$page->listRows)->
                            select();
        foreach ($tlist as $key => $value) {
            $curr = currency($value['currency']);
            $tlist[$key]['fee_rmb']  = $value['fee'] * $curr['rate'];
            $tlist[$key]['buyprice'] = sprintf("%.".$value['capital_length']."f",$value['buyprice']);
        }


        if($tlist)
        {
            $this->assign('statuss',1);
        }


        $tlistAll = $order->field($field)->
                            join('left join wp_userinfo as b on a.uid = b.uid')->
                            join('left join wp_option as c on a.pid = c.id')->
                            join('left join wp_option_info as d on c.id = d.option_id')->
                            order('a.oid desc')->
                            where($where)->
                            select();
     //  echo M()->getLastSql();


        $total['totalCount'] = $counts;
        $total['nowStart'] = trim(I('get.p')) ? trim(I('get.p')) : 1;
        $total['nowEnd'] = ceil($count / $pagecount);


        $this->assign('tlist',$tlist);
        $this->assign('tlistAll',$tlistAll);
        $this->assign("sea",$sea);
        $this->assign('total',$total);
        $this->assign('page',$show);
        $this->assign('options',M('option')->select());
        $this->display();
    }
    

    public function getdata()
    {
        $oid = trim(I('post.oid'));
        $order = M('order a');
        $field = 'a.*,b.Price,b.sp,b.bp,b.currency,c.capital_length'; 
        $orders = $order->
                      join('left join wp_option as b on a.pid = b.id')->
                      join('inner join wp_option_info as c on b.id = c.option_id')->
                      where('a.oid in('.$oid.') and ostaus = 0 and display=0')->
                      select();

        foreach ($orders as $key => $value) {

          if($value['ostyle'] == 0){
                    $orders[$key]['Price'] = sprintf("%.".$value['capital_length']."f",$value['bp']); //对手价点位
          } else {
                    $orders[$key]['Price'] = sprintf("%.".$value['capital_length']."f",$value['sp']);//对手价点位
           }

            /*盈亏百分比*/
            $profit_count = M('journal')->where(' type = 1 and jtype = "平仓" and uid='.$value['uid'].' and jploss > 0')->count();
            $ploss_count  = M('journal')->where(' type = 1 and jtype = "平仓" and uid='.$value['uid'].'')->count();
            $orders[$key]['percentage'] = round(($profit_count / $ploss_count) * 100,2);
            /*盈亏百分比*/
            $curr = currency($value['currency']);
            $orders[$key]['rmb_ploss'] = $value['ploss'] * $curr['rate'];
            $jploss = M('journal')->where('TO_DAYS(FROM_UNIXTIME(jtime,"%Y-%m-%d")) = TO_DAYS(CURDATE()) and type = 1 and jtype = "平仓" and uid='.$value['uid'].' ')->sum('jploss');
            $orders[$key]['day_ploss'] = $jploss;


            $orders['ploss_sum'] += $value['ploss'] * $curr['rate'];
            $orders['fee_sum'] += $value['fee'] * $curr['rate'];
            $orders['count'] += count($value['oid']);
        }
      
        if($orders[0]['oid'])
        {
           $orders['code'] = 200;
        } else {
           $orders['code'] = 300;
        }

        $this->ajaxReturn($orders,'JSON');
    }


    private function get_username($uid = 0) {
         
         $info = M("userinfo a")->field('a.uid,a.username,b.busername')->join('left join wp_bankinfo as b on a.uid = b.uid')->where(array('a.uid'=> $uid))->find();

         $info['username'] = !empty($info['busername']) ? $info['busername'] : $info['username'];

         return $info ? $info : null;
    }

    public function ajax_get_brokers(){
        if(IS_AJAX){
            $userobj         = M('userinfo a');
            $relationshipobj = M('userinfo_relationship');
            
            $parent_id = I('get.parent_id',0,'intval');
            
            if($parent_id < 1) $this->AjaxReturn(array('msg'=>'父级id不存在','status'=>0));
            $ids_arr = $relationshipobj->field('user_id')->where(array('parent_user_id'=>$parent_id))->select();
            $ids='';
            
            if($ids_arr){
                foreach($ids_arr as $v){
                    if(!empty($ids)){
                        $ids .=','.$v['user_id'];
                    }else{
                        $ids = $v['user_id'];
                    }
                }
            }
            $where['a.uid']=array('IN',$ids);
            $res = $userobj->field('a.uid,a.username,b.busername')->join('left join wp_bankinfo as b on a.uid = b.uid')->where($where)->order('uid DESC')->select();
            foreach ($res as $key => $value) {
                $res[$key]['username'] = !empty($value['busername']) ? $value['busername'] : $value['username'];
            }

            $data=array('msg'=>'成功','status'=>1,'data'=>$res);
            $this->AjaxReturn($data);
        }
            $this->error('您访问的页面不存在','index/index');
    }

}