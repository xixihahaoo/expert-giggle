<?php
/**
 * @author: FrankHong
 * @datetime: 2016-11-17 00:49:10
 * @filename: Crontab.php
 * @description: 系统计划任务，每天定时计算平台用户返现金额
 * @note:

 *
 */
namespace Admin\Controller;
use Think\Controller;
use Org\Util\Log;
use Org\Util\Shouxinyi;

class CrontabController extends Controller
{
    /**
     * 构造函数
     */
    public function _initialize()
    {


    }


    /**
     * @functionname: opt_deal_status_temp
     * @author: FrankHong
     * @date:
     * @description:
     * @note:
     *
     * $dealTimeRs1
     *
     * [59]=>
    array(2) {
    [0]=>
    array(4) {
    ["option_id"]=>
    string(2) "59"
    ["deal_time_start"]=>
    string(6) "070000"
    ["deal_time_end"]=>
    string(6) "235959"
    ["deal_time_type"]=>
    int(2)
    }
    [1]=>
    array(4) {
    ["option_id"]=>
    string(2) "59"
    ["deal_time_start"]=>
    string(6) "000000"
    ["deal_time_end"]=>
    string(6) "050000"
    ["deal_time_type"]=>
    int(2)
    }
    }

     */
    public function opt_deal_status_temp()
    {
        date_default_timezone_set('PRC');
        //date_default_timezone_set('Asia/Shanghai');

        $dealTimeObj    = M('option_deal_time');
        $dealTimeRs     = $dealTimeObj->order('option_id desc')->select();


        $timeNow        = time();

        //得到一个测试的时间
        $timeNow       = time() - 43200;

//        echo date('Y-m-d H:i:s', $timeNow);
//        die();

        $dateNow        = date('Ymd');
        $dateExt        = '00';
        $dateBase       = 86400;
//        echo strtotime('20161117110500');

        //echo "\n";

        $dealTimeRs1    = array();
        foreach($dealTimeRs as $k => $v)
        {
            if($v['deal_time_type'] == 2)
            {
                $aaa    = array(
                    'option_id'         => $v['option_id'],
                    'deal_time_start'   => $v['deal_time_start'].'00',
                    'deal_time_end'     => '235959',
                    'deal_time_type'    => 5
                );
                $dealTimeRs1[$v['option_id']][] = $aaa;

                //如果是把隔夜的时间拆分了，则设置一个type6
                $bbb    = array(
                    'option_id'         => $v['option_id'],
                    'deal_time_start'   => '000000',
                    'deal_time_end'     => $v['deal_time_end'].'00',
                    'deal_time_type'    => 6
                );
                $dealTimeRs1[$v['option_id']][] = $bbb;
            }

            else
            {
                $ccc    = array(
                    'option_id'         => $v['option_id'],
                    'deal_time_start'   => $v['deal_time_start'].'00',
                    'deal_time_end'     => $v['deal_time_end'].'00',
                    'deal_time_type'    => 6
                );
                $dealTimeRs1[$v['option_id']][] = $ccc;
            }

        }

//        vD($dealTimeRs1);
//        die();

        foreach($dealTimeRs1 as $k => $v)
        {
            //vD(k);

            if($k == 59)
            {

                $flagRs[$k]     = 0;
                $flagRs1[$k]    = 0;

                foreach($v as $k1 => $v1)
                {
                    //当状态不为1时，则是次日，需要加上一天，得到次日该时间对应的时间戳

                    if($this->opt_time($timeNow, $this->get_time_new($v1['deal_time_start']), $this->get_time_new($v1['deal_time_end'])))
                    {
                        $flagRs[$k] = 1;
                    }



                    if($v1['deal_time_type'] != 5)
                    {
                        if($this->opt_time($timeNow, $this->get_time_new($v1['deal_time_start']), $this->get_time_sell_new($v1['deal_time_end'])))
                        {
                            $flagRs1[$k] = 1;
                        }
                    }
                    else
                    {
                        if($this->opt_time($timeNow, $this->get_time_new($v1['deal_time_start']), $this->get_time_new($v1['deal_time_end'])))
                        {
                            $flagRs1[$k] = 1;
                        }
                    }


                }
            }
        }



//        vD($flagRs);
//        vD($flagRs1);
//        die();


        $optionObj  = M('option');
        $optionRs   = $optionObj->select();

        $i          = 0;
        foreach($optionRs as $k => $v)
        {
            $dealStatus = !empty($flagRs[$v['id']]) ? $flagRs[$v['id']] : 0;
            if($optionObj->where('id='.$v['id'])->setField('flag', $dealStatus))
                $i++;
        }

        $z          = 0;
        foreach($optionRs as $k => $v)
        {
            $dealStatus = !empty($flagRs1[$v['id']]) ? $flagRs1[$v['id']] : 0;
            if($optionObj->where('id='.$v['id'])->setField('sell_flag', $dealStatus))
                $z++;
        }


        $this->write_log("[note]系统本次共处理商品交易状态: [".$i.'__'.$z."]");
        Log::w("[note]\t系统本次共处理商品交易状态: [".$i.'__'.$z."]\t");

    }


    /**
     * @functionname: write_log
     * @author: FrankHong
     * @date: 2016-12-27 16:43:33
     * @description: 写脚本运行log到数据表log_cli
     * @note:
     * @param $note
     */
    public function write_log($note = '')
    {
        $logObj = M();
        $logArr = array(
            'type'          => 1,
            'script_name'   => 'opt_deal_status',
            'note'          => $note
        );

        $logObj->table('log_cli')->add($logArr);

    }


    /**
     * @functionname: opt_deal_status
     * @author: FrankHong
     * @date: 2016-12-27 16:52:47
     * @description: 升级后脚本
     * @note:
     */
    public function opt_deal_status()
    {
        date_default_timezone_set('PRC');
        //date_default_timezone_set('Asia/Shanghai');

        $dealTimeObj    = M('option_deal_time');
        $dealTimeRs     = $dealTimeObj->order('option_id desc')->select();


        $weekNow        = date('w');


        $timeNow        = time();

        //得到一个测试的时间
        //$timeNow       = time() - 43200;

//        echo date('Y-m-d H:i:s', $timeNow);
//        die();

        $dateNow        = date('Ymd');
        $dateExt        = '00';
        $dateBase       = 86400;
//        echo strtotime('20161117110500');

        //echo "\n";

        $dealTimeRs1    = array();
        foreach($dealTimeRs as $k => $v)
        {
            if($v['deal_time_type'] == 2)
            {
                $aaa    = array(
                    'option_id'         => $v['option_id'],
                    'deal_time_start'   => $v['deal_time_start'].'00',
                    'deal_time_end'     => '235959',
                    'deal_time_type'    => 5
                );
                $dealTimeRs1[$v['option_id']][] = $aaa;

                //如果是把隔夜的时间拆分了，则设置一个type6
                $bbb    = array(
                    'option_id'         => $v['option_id'],
                    'deal_time_start'   => '000000',
                    'deal_time_end'     => $v['deal_time_end'].'00',
                    'deal_time_type'    => 6
                );
                $dealTimeRs1[$v['option_id']][] = $bbb;
            }

            else
            {
                $ccc    = array(
                    'option_id'         => $v['option_id'],
                    'deal_time_start'   => $v['deal_time_start'].'00',
                    'deal_time_end'     => $v['deal_time_end'].'00',
                    'deal_time_type'    => 6
                );
                $dealTimeRs1[$v['option_id']][] = $ccc;
            }

        }

//        vD($dealTimeRs1);
//        die();

        foreach($dealTimeRs1 as $k => $v)
        {
            //vD(k);

            $flagRs[$k]     = 0;
            $flagRs1[$k]    = 0;

            foreach($v as $k1 => $v1)
            {
                //当状态不为1时，则是次日，需要加上一天，得到次日该时间对应的时间戳

                if($this->opt_time($timeNow, $this->get_time_new($v1['deal_time_start']), $this->get_time_new($v1['deal_time_end'])))
                {
                    $flagRs[$k] = 1;
                }



                if($v1['deal_time_type'] != 5)
                {
                    if($this->opt_time($timeNow, $this->get_time_new($v1['deal_time_start']), $this->get_time_sell_new($v1['deal_time_end'])))
                    {
                        $flagRs1[$k] = 1;
                    }
                }
                else
                {
                    if($this->opt_time($timeNow, $this->get_time_new($v1['deal_time_start']), $this->get_time_new($v1['deal_time_end'])))
                    {
                        $flagRs1[$k] = 1;
                    }
                }


                if($weekNow == 0)
                {
                    $flagRs[$k]     = 0;
                    $flagRs1[$k]    = 0;
                }


                //当为周六时
                if($weekNow == 6)
                {
                    if($v1['deal_time_type'] == 6)
                    {
                        if($this->opt_time($timeNow, $this->get_time_new($v1['deal_time_start']), $this->get_time_new($v1['deal_time_end'])))
                        {
                            $flagRs[$k]     = 1;
                        }
                        else
                        {
                            $flagRs[$k]     = 0;
                        }

                        if($this->opt_time($timeNow, $this->get_time_new($v1['deal_time_start']), $this->get_time_sell_new($v1['deal_time_end'])))
                        {
                            $flagRs1[$k]    = 1;
                        }
                        else
                        {
                            $flagRs1[$k]    = 0;
                        }
                    }
                }

            }

        }



//        vD($flagRs);
//        vD($flagRs1);
//        die();


        $optionObj  = M('option');
        $optionRs   = $optionObj->select();

        $i          = 0;
        foreach($optionRs as $k => $v)
        {
            $dealStatus = !empty($flagRs[$v['id']]) ? $flagRs[$v['id']] : 0;
            if($optionObj->where('id='.$v['id'])->setField('flag', $dealStatus))
                $i++;
        }

        $z          = 0;
        foreach($optionRs as $k => $v)
        {
            $dealStatus = !empty($flagRs1[$v['id']]) ? $flagRs1[$v['id']] : 0;
            if($optionObj->where('id='.$v['id'])->setField('sell_flag', $dealStatus))
                $z++;
        }


        $this->write_log("[note]系统本次共处理商品交易状态: [".$i.'__'.$z."]");
        Log::w("[note]\t系统本次共处理商品交易状态: [".$i.'__'.$z."]\t");

    }


    /**
     * @functionname: opt_deal_status_bak
     * @author: FrankHong
     * @date: 2016-09-14 16:45:49
     * @description: 循环处理系统商品，是否在该商品设置的建议时间内，即设置当前的休市、开市
     * @note:  废弃
     */
    public function opt_deal_status_bak()
    {
        date_default_timezone_set('PRC');
        //date_default_timezone_set('Asia/Shanghai');

        $dealTimeObj    = M('option_deal_time');
        $dealTimeRs     = $dealTimeObj->select();


        $timeNow        = time();
        $dateNow        = date('Ymd');
        $dateExt        = '00';
        $dateBase       = 86400;
//        echo strtotime('20161117110500');

        //echo "\n";

        $dealTimeRs1    = array();
        foreach($dealTimeRs as $k => $v)
        {
            $dealTimeRs1[$v['option_id']][] = $v;
        }

        //vD($dealTimeRs1);

        foreach($dealTimeRs1 as $k => $v)
        {
            $flagRs[$k]     = 0;
            $flagRs1[$k]    = 0;

            foreach($v as $k1 => $v1)
            {
                //当状态不为1时，则是次日，需要加上一天，得到次日该时间对应的时间戳
                if($v1['deal_time_type'] == 1)
                {
                    //echo $this->get_time($v1['deal_time_end'])."\n";
                    if($this->opt_time($timeNow, $this->get_time($v1['deal_time_start']), $this->get_time($v1['deal_time_end'])))
                    {
                        $flagRs[$k] = 1;
                    }

                    if($this->opt_time_sell($timeNow, $this->get_time_sell($v1['deal_time_start']), $this->get_time_sell($v1['deal_time_end'])))
                    {
                        $flagRs1[$k] = 1;
                    }
                }
                else
                {
                    if($this->opt_time($timeNow, $this->get_time($v1['deal_time_start']), $this->get_time($v1['deal_time_end'], 2)))
                    {
                        $flagRs[$k] = 1;
                    }

                    if($this->opt_time_sell($timeNow, $this->get_time_sell($v1['deal_time_start']), $this->get_time_sell($v1['deal_time_end'], 2)))
                    {
                        $flagRs1[$k] = 1;
                    }
                }
            }
        }






        $optionObj  = M('option');
        $optionRs   = $optionObj->select();

        $i          = 0;
        foreach($optionRs as $k => $v)
        {
            $dealStatus = !empty($flagRs[$v['id']]) ? $flagRs[$v['id']] : 0;
            if($optionObj->where('id='.$v['id'])->setField('flag', $dealStatus))
                $i++;
        }

        $z          = 0;
        foreach($optionRs as $k => $v)
        {
            $dealStatus = !empty($flagRs1[$v['id']]) ? $flagRs1[$v['id']] : 0;
            if($optionObj->where('id='.$v['id'])->setField('sell_flag', $dealStatus))
                $z++;
        }



        Log::w("[note]\t系统本次共处理商品交易状态: [".$i.'__'.$z."]\t");

    }


    /**
     * @functionname: opt_time_sell
     * @author: FrankHong
     * @date: 2016-12-09 16:02:27
     * @description: 判断平仓时间
     * @note: sell_flag， 系统是否强制平仓，1为强制平仓，0为不平仓
     *      当时间大于计算出来的平仓的时间，则平仓
     *      返回true的时候，是正常交易，不需要平仓
     * @return bool
     * @param $time
     * @param $time1
     * @param $time2 @internal param $time2
     */
    public function opt_time_sell($time, $time1, $time2)
    {
        if($time > $time1 && $time < $time2)
            return true;
        else
            return false;
    }


    /**
     * @functionname: opt_time
     * @author: FrankHong
     * @date: 2016-11-17 11:37:11
     * @description: 判断当前时间，是否是交易时间区间，基础时间是以时区为RPC的当前时间
     * @note: 当返回true时，是交易时间
     * @return bool
     * @param $time
     * @param $time1
     * @param $time2
     */
    public function opt_time($time, $time1, $time2)
    {
        if($time > $time1 && $time < $time2)
            return true;
        else
            return false;
    }


    /**
     * @functionname: get_time_sell
     * @author: FrankHong
     * @date: 2016-12-09 15:55:29
     * @description: 得到系统平仓时间
     * @note:
     * @return int
     * @param $dateStr
     * @param int $timeType
     */
    public function get_time_sell($dateStr, $timeType = 1)
    {
        $sysDate    = get_setting_config('find', 'SYSTEM_OPTION_TIME');
        $sysMinute  = $sysDate['datas']['sys_date'];



        if($timeType == 1)
            return strtotime(date('Ymd').$dateStr.'00') - $sysMinute * 60;
        else
            return strtotime(date('Ymd').$dateStr.'00') + 86400 - $sysMinute * 60;

    }



    public function get_time_sell_new($dateStr)
    {
        $sysDate    = get_setting_config('find', 'SYSTEM_OPTION_TIME');
        $sysMinute  = $sysDate['datas']['sys_date'];

        return strtotime(date('Ymd').$dateStr) - $sysMinute * 60;
    }

    public function get_time_new($dateStr)
    {
        return strtotime(date('Ymd').$dateStr);
    }

    /**
     * @functionname: get_time
     * @author: FrankHong
     * @date: 2016-11-17 11:43:22
     * @description: 根据日期时间字符串，得到时间戳
     * @note:
     * @return int
     * @param $dateStr | 返回时间戳
     * @param int $timeType
     */
    public function get_time($dateStr, $timeType = 1)
    {
        if($timeType == 1)
        {
            return date('Y-m-d').$dateStr.'00'."\n";
            return strtotime(date('Ymd').$dateStr.'00');
        }
        else
        {
            return date('Y-m-d H:i:s', strtotime(date('Ymd').$dateStr.'00') + 86400);
            return strtotime(date('Ymd').$dateStr.'00') + 86400;
        }
    }


    /**
     * @functionname: auto_commission
     * @author: wang
     * @date: 2016-11-17 11:43:22
     * @description: 结算上周佣金
     * @note:
     */

    public function auto_commission(){
        
        // $fee = M()->query("SELECT * FROM wp_fee_receive WHERE status = 2 and type = 1 and YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d'), 1) = YEARWEEK(NOW(), 1)-1");
        $fee = M()->query("SELECT * FROM wp_fee_receive WHERE status = 2 and type = 1 and YEARWEEK(FROM_UNIXTIME(create_time,'%Y-%m-%d'), 1) = YEARWEEK(NOW(), 1)");
        $data = array();
        $status = array();
        foreach ($fee as $key => $value) {

            $data[$key]['user_id']    = $value['user_id'];
            $data[$key]['profit_rmb'] = $value['profit_rmb'];
            array_push($status,$value['id']);
        }

        $id = implode(',',array_unique($status));
        $result = M("FeeReceive")->where('id in('.$id.')')->setField('status',1);

        if($result){
            foreach ($data as $k => $v) {
                $result = M("extension")->where(array('user_id' => $v['user_id']))->setInc('money',$v['profit_rmb']);
            }
        }
    }
    

        /**
     * @functionname: write_log_new
     * @author: FrankHong
     * @date: 2017-01-09 15:52:03
     * @description: 写脚本运行log到数据表log_cli
     * @note:
     *
     * 执行的类型
     * 1:商品状态
     * 2:前几分钟休市
     * 3:佣金周结
     * 4:首信易获取支付状态
     *
     * @param string $note
     * @param int $type
     * @param string $script_name
     */
    public function write_log_new($note = '', $type = 1, $script_name = 'opt_deal_status')
    {
        $logObj = M();
        $logArr = array(
            'type'          => $type,
            'script_name'   => $script_name,
            'note'          => $note
        );

        $logObj->table('log_cli')->add($logArr);

    }


    /**
     * @functionname: sxy_get_pay_results
     * @author: FrankHong
     * @date: 2017-01-09 14:40:56
     * @description: 首信易支付--批量获取支付状态
     * @note:
     */

    public function sxy_get_pay_results_back()
    {
        set_time_limit(0);
        $balanceObj = M('balance');
        $accountObj = M('accountinfo');
        
        $map['pay_type'] = array(array('eq',2),array('eq',3), 'or');
        $map['status'] = 0;
        $map['isverified'] = 0;
        $map['b_type'] = 1;
        $rsBalance  = $balanceObj->where($map)->select();

        $rsBalance1 = array();
        $nowTime    = time();

        $rsSuccess  = 0;
        $rsFail     = 0;
        $rsFail1    = 0;
        $rsNo       = 0;
        $rsChaoshi  = 0;

        foreach($rsBalance as $k => $v)
        {
            //20分钟订单，直接作废
            if($nowTime - $v['bptime'] > 1200)
            {
                $data['isverified'] = '0'; //失败
                $data['status']     = '1'; //完成
                $data['cltime']     = time(); //完成

                $case   = $balanceObj->where(array('balanceno' => $v['balanceno']))->save($data);

                $rsChaoshi++;
            }
            else
            {
                $rsBalance1[$v['bpid']] = $v;
            }
        }

        $req    = new Shouxinyi();


        foreach($rsBalance1 as $k => $v)
        {
            $getArr = array('v_oid' => $v['balanceno']);
            Log::debugArr($getArr, 'send_data');
            $desc   = $req->get_result($getArr);
            
            

            $aa     = $desc['pstatus'];  //状态
            $amount = $desc['amount'];

            if($aa == 1)
            {

                $flow_data = M('money_flow')->where(array('oid' => $v['bpid']))->find();
                $balance   = M('balance')->where(array('status' => 1,'isverified' => 1,'bpid' => $v['bpid']))->find();

                if(isset($balance) || isset($flow_data))
                {
                    $msg = array('v_oid' => $balance['balanceno'],'msg' => '已经充值了！');
                    Log::debugArr($msg, 'shouxinyi_notify');
                    return false;
                    die();
                }




                $order_no           = $v['balanceno'];
                $order_time         = time();  //cltime

                $order_amount       = $amount;  //$v['bpprice'];
                $data['bpprice']    = $order_amount;
                $data['isverified'] = '1'; //入金成功
                $data['status']     = '1'; //完成
                $data['cltime']     = $order_time; //完成
                $data['shibpprice'] = $v['shibpprice'] + $order_amount; //完成

                $case               = $balanceObj->where(array('balanceno' => $order_no))->save($data);
                if ($case !== false) //fix bug 不全等于false表示更新成功,因为计划任务执行时有可能已经手动从接口获取了状态，所以此处会没有任何更新，导致$case 为0，
                {
                    $money          = $accountObj->where(array('uid' => $v['uid']))->setInc('balance', $order_amount);
                    $money_total    = $accountObj->where(array('uid' => $v['uid']))->setInc('recharge_total', $order_amount);
                }
                    
                    //用户资金流水表
                if($money && $money_total)
                {
                        $info = M('userinfo')->where(array('uid' => $v['uid']))->find();
                        if($info['otype'] == 5)
                        {
                           $map['user_type'] = 2;
                        }
                        $map['uid']      = $v['uid'];
                        $map['type']     = 4;
                        $map['oid']      = $v['bpid'];
                        $map['note']     = '用户使用首信易支付充值金额['.$order_amount.']元';
                        $map['balance']  = $accountObj->where(array('uid' => $v['uid']))->sum('balance');
                        $map['op_id']    = $v['uid'];
                        $map['dateline'] = time();
                        M("money_flow")->add($map);
                        $rsSuccess++;
                }
                else
                {
                    $rsFail++;
                    //$this->write_log_new('[note]订单号为['.$v['balanceno'].']的订单充值失败1', 4, 'sxy_get_pay_results');
                }

            }
            else if($aa == 2)
            {
                $rsNo++;
                //$this->write_log_new('[note]订单号为['.$v['balanceno'].']的订单尚未充值', 4, 'sxy_get_pay_results');
            }
            else
            {
                $order_no           = $v['balanceno'];
                $order_time         = time();  //cltime

                $data['isverified'] = '0'; //入金成功
                $data['status']     = '0'; //完成
                $data['cltime']     = $order_time; //完成

                $case   = $balanceObj->where(array('balanceno' => $order_no))->save($data);

                $rsFail1++;
                //$this->write_log_new('[note]订单号为['.$v['balanceno'].']的订单充值失败2', 4, 'sxy_get_pay_results');
            }

        }


        $totalCount = $rsSuccess + $rsFail + $rsNo + $rsFail1 + $rsChaoshi;
        $this->write_log_new('[note]系统共处理['.$totalCount.']--[success:'.$rsSuccess.']'.'[fail:'.$rsFail.']'.'[fail1:'.$rsFail1.']'.'[no:'.$rsNo.']'.'[chaoshi:'.$rsChaoshi.']', 4, 'sxy_get_pay_results');

    }


}