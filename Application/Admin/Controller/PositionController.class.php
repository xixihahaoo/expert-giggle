<?php
// +----------------------------------------------------------------------
// | 运营中心控制器
// +----------------------------------------------------------------------
// | Author wang <admin>
// +----------------------------------------------------------------------
namespace Admin\Controller;

class PositionController extends CommonController {

    /**
     * 持仓中的订单
     * @author wang <admin>
     */
    public function tlist()
    {
    	$order = M('order a');
       
        /*条件筛选*/
        $utel      = trim(I('get.utel'));
        $starttime = trim(I('get.starttime'));
        $endtime   = trim(I('get.endtime'));
        $otype     = trim(I('get.otype'));
        $jingjiren = trim(I('get.jingjiren'));
        $user      = trim(I('get.user'));
        $option    = trim(I('get.option'));


        if ($utel) {
            $map['c.utel'] = array('like', '%' . $utel . '%');
            $sea['utel'] = $utel;
        }

        if($starttime && $endtime)
        {
            $start_time = strtotime($starttime." 00:00:00");
            $end_time   = strtotime($endtime." 23:59:59");
            $map['a.buytime'] = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        }

        if($option)
        {
            $map['b.capital_name'] = $option;
            $sea['option'] = $option;
        }

        //运营中心筛选
        if($otype){
            
            $userarr  = array();
            $userarr1 = array(); 
            $ship = M("UserinfoRelationship")->where(array('parent_user_id' => $otype))->select();
            foreach ($ship as $key => $value) {
                array_push($userarr, $value['user_id']);
            }
            $user_id = implode(',',array_unique($userarr));
  
            $users = M("UserinfoRelationship")->where('parent_user_id  in('.$user_id.')')->select();

            foreach ($users as $key => $val) {
                 
                array_push($userarr1,$val['user_id']);
            }
            $id = implode(',',array_unique($userarr1));
     
            $map['a.uid'] = array('in',$id);
            $username = M('userinfo')->where(array('uid'=> $otype))->find();
            $sea['otype'] = $otype;
            $this->assign('user_id',$username['uid']);
        }

        //经纪人筛选
        if($jingjiren){
            
            $userarr  = array();
            $userarr1 = array(); 
            $ship = M("UserinfoRelationship")->where(array('parent_user_id' => $jingjiren))->select();
            foreach ($ship as $key => $value) {
                
                array_push($userarr, $value['user_id']);
            }
            $userid = implode(',',array_unique($userarr));

            $map['a.uid'] = array('in',$userid);
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren',$this->get_username($jingjiren));
        }


        if($user){
            $uid = $user;
            $map['a.uid'] = array('in',$uid);
            $sea['user'] = $user;
            $this->assign('user',$this->get_username($user));
        }


    	$field = 'a.*,b.capital_name,b.currency,c.utel,d.capital_length';

        $map['a.ostaus'] = 0;
        $map['display'] = 0;
        $map['type'] = 1;

    	$counts =  $orders = $order->field($field)->
    	                  join('inner join wp_option as b on a.pid = b.id')->
    	                  join('inner join wp_userinfo as c on a.uid = c.uid')->
                          join('left join wp_option_info as d on b.id = d.option_id')->
    	                  where($map)->
    	                  count();

	    $pagecount = 10;
	    $page = new \Think\Page($counts , $pagecount);
	    $page->parameter = $sea; //此处的row是数组，为了传递查询条件
	    $page->setConfig('first','首页');
	    $page->setConfig('prev','&#8249;');
	    $page->setConfig('next','&#8250;');
	    $page->setConfig('last','尾页');
	    $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
	    $show = $page->show();
    	$orders = $order->field($field)->
    	                  join('inner join wp_option as b on a.pid = b.id')->
    	                  join('inner join wp_userinfo as c on a.uid = c.uid')->
                          join('left join wp_option_info as d on b.id = d.option_id')->
                          where($map)->
    	                  limit($page->firstRow.','.$page->listRows)->
    	                  select();
        foreach ($orders as $key => $value) {
            $currency = currency($value['currency']);
            $orders[$key]['fee_rmb'] = $value['fee'] * $currency['rate'];
            $orders[$key]['buyprice'] = sprintf("%.".$value['capital_length']."f",$value['buyprice']);
        }

        if($orders)
        {
            $this->assign('statuss',1);
        }


        $tlistAll = $order->field($field)->
                          join('inner join wp_option as b on a.pid = b.id')->
                          join('inner join wp_userinfo as c on a.uid = c.uid')->
                          join('left join wp_option_info as d on b.id = d.option_id')->
                          where($map)->
                          select();
        $this->assign('tlistAll',$tlistAll);


    	$this->assign('tlist',$orders);
        $this->assign('info', M('userinfo')->where('otype=5')->select());
        $this->assign('options',M('option')->select());
        $this->assign('sea',$sea);
        $this->assign('page',$show);
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
            $profit_count = M('journal')->where('type = 1 and jtype = "平仓" and uid='.$value['uid'].' and jploss > 0')->count();
            $ploss_count  = M('journal')->where('type = 1 and jtype = "平仓" and uid='.$value['uid'].'')->count();
            $orders[$key]['percentage'] = round(($profit_count / $ploss_count) * 100,2);
            /*盈亏百分比*/

            $currency = currency($value['currency']);
            $orders[$key]['rmb_ploss'] = $value['ploss'] * $currency['rate'];
            $jploss = M('journal')->where('TO_DAYS(FROM_UNIXTIME(jtime,"%Y-%m-%d")) = TO_DAYS(CURDATE()) and type = 1 and jtype = "平仓" and uid='.$value['uid'].' ')->sum('jploss');
            $orders[$key]['day_ploss'] = $jploss;

            /*总统计*/
            $orders['ploss_sum'] += $value['ploss'] * $currency['rate'];
            $orders['fee_sum']   += $value['fee']   * $currency['rate'];
            $orders['count']     += count($value['oid']);
    	}

        if($orders[0]['oid'])
        {
           $orders['code'] = 200;
        } else {
           $orders['code'] = 300;
        }
    	$this->ajaxReturn($orders,'JSON');
    }



    public function getdata_back()
    {
        $oid   = trim(I('post.oid'));


        $order       = M('order');
        $option      = M('option');
        $journal     = M('journal');
        $option_info = M('option_info');

        $orderData = $order->where('oid in('.$oid.') and ostaus = 0 and display=0')->select();

        $optionArr  = array();
        $journalArr = array(); 
        foreach ($orderData as $key => $value) {
            array_push($optionArr,$value['pid']);
            array_push($journalArr,$value['uid']);
        }

        $pid = implode(',',$optionArr);
        $optionData = $option->field('id,bp,sp,currency')->where('id in('.$pid.')')->select();
        $optionArr  = array();
        foreach ($optionData as $key => $value) {
            $optionArr[$value['id']] = $value;
        }


        $option_infoData = $option_info->field('option_id,capital_length')->select();
        $option_infoArr  = array();
        foreach ($option_infoData as $key => $value) {
            $option_infoArr[$value['option_id']] = $value;
        }


        $uid         = implode(',',$journalArr);

        /*盈利的单子*/
        $sql         = 'select uid,count(*) as count from wp_journal where uid in('.$uid.') and jtype="平仓" and jploss > 0 and type=1 group by uid';
        $journalData = M()->query($sql);
        $profit      = array();
        foreach ($journalData as $key => $value) {
            $profit[$value['uid']] = $value;
        }

        /*购买全部的单子*/
        $sql         = 'select uid,count(*) as count from wp_journal where uid in('.$uid.') and jtype="平仓" and type=1 group by uid';
        $journalData = M()->query($sql);
        $ploss       = array();
        foreach ($journalData as $key => $value) {
            $ploss[$value['uid']] = $value;
        }

        /*当日的单子*/
        $sql          = 'select uid,sum(jploss) as jploss from wp_journal where TO_DAYS(FROM_UNIXTIME(jtime,"%Y-%m-%d")) = TO_DAYS(CURDATE()) and uid in('.$uid.') and jtype="平仓" and type=1 group by uid';
        $journalData  = M()->query($sql);
        $jploss       = array();
        foreach ($journalData as $key => $value) {
            $jploss[$value['uid']] = $value;
        }


        foreach ($orderData as $key => $value) {
            if($value['ostyle'] == 0)
            {
                $orderData[$key]['Price'] = sprintf("%.".$option_infoArr[$value['pid']]['capital_length']."f",$optionArr[$value['pid']]['bp']);
            } else {
                $orderData[$key]['Price'] = sprintf("%.".$option_infoArr[$value['pid']]['capital_length']."f",$optionArr[$value['pid']]['sp']);
            }

            /*盈亏百分比*/
            $profit_count = $profit[$value['uid']]['count'];
            $ploss_count  = $ploss[$value['uid']]['count'];
            $orderData[$key]['percentage'] = round(($profit_count / $ploss_count) * 100,2);
            /*盈亏百分比*/

            $currency = currency($optionArr[$value['pid']]['currency']);
            $orderData[$key]['rmb_ploss'] = $value['ploss'] * $currency['rate']; //盈亏人民币

            $orderData[$key]['day_ploss'] = $jploss[$value['uid']]['jploss'];  //当日盈亏

            /*总统计*/
            $orderData['ploss_sum'] += $value['ploss'] * $currency['rate'];
            $orderData['fee_sum']   += $value['fee']   * $currency['rate'];
            $orderData['count']     += count($value['oid']);
        }

        if($orderData[0]['oid'])
        {
           $orderData['code'] = 200;
        } else {
           $orderData['code'] = 300;
        }
        $this->ajaxReturn($orderData,'JSON');
    }



    private function get_username($uid = 0) {
         
         $info = M("userinfo")->field('uid,username')->where(array('uid'=> $uid))->find();
         return $info ? $info : null;
    }
}