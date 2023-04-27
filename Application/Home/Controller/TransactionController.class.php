<?php
namespace Home\Controller;
class TransactionController extends CommonController {



  public function _initialize(){
     parent::_initialize();
  }
  
    /**
     * 订单选择
     * @author wang <admin>
     */
    public function Buyup() {

          $id = trim(I('get.id'));
          //判断id是否存在或是否为休市状态
          $exis  = M('option')->where(array('id'=>$id))->find();   
          if($exis) {
              if($exis['global_flag'] == 0 || $exis['flag'] == 0 || $exis['sell_flag'] == 0) {
                $this->redirect('Index/index');
              }
          } else {
              $this->redirect('Index/index');
          }
          
          //判断是否签署协议 (真实交易)
          $contract = M("OptionContract")->where(array("user_id" => $this->user_id,"option_id" => $id,'status' => 1))->find();
          if(!$contract && I('get.type') == 1){
              
              $key = M("option")->field('id')->where(array('id' => $id))->find();
              $this->assign("option_id",$id);
              $this->display('contract');
              exit;
          }
       

          $option = M('option a')->join('wp_option_info as b on a.id = b.option_id')->where(array('a.id' => $id))->find();

          $currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($option['id']).'');

          $rate =  $currency['rate'];
           
           //外汇标志
          $code = M('currency')->field('currency_sign')->where(array('currency_code' => $currency['code']))->find();

          $option['rate']  = $rate;  // 转换人民币
          
          if(I('get.ostyle') == 0){
                $option['Price'] = sprintf("%.".$option['capital_length']."f",$option['sp']);      //小数点位
                $option['Rivalprice'] = sprintf("%.".$option['capital_length']."f",$option['bp']); //对手价点位
          } else {
                $option['Price'] = sprintf("%.".$option['capital_length']."f",$option['bp']);     //小数点位 
                $option['Rivalprice'] = sprintf("%.".$option['capital_length']."f",$option['sp']);//对手价点位
          }

         
        $special = M('OptionUserSpecial')->field('platform_commission,commission')->where(array('user_id' => $this->agent_id,'option_id' => $option['id']))->find();

        $info = M('option_info')->where(array('option_id' => $option['id']))->find();
        $info['zhiying']  = $info['profit'] * $rate;                //止盈
        $info['baozheng'] = round($info['Bond'] * $rate,2);         //保证金


        $info['foreign_sum'] = $info['Bond'] + $special['platform_commission'] + $special['commission'];
        $info['rmb_sum']     = round(($info['Bond'] + $special['platform_commission'] + $special['commission']) * $rate,2);

        $info['CounterFee']  = ($special['platform_commission'] + $special['commission']);
        $info['shouxu']      = round($info['CounterFee'] * $rate,2);   //交易综合费
          

         //触发止损
          $transaction = M('OptionTransaction')->where(array('option_id' => $option['id']))->select();

          $this->assign('option',$option);
          $this->assign('info',$info);
          $this->assign('transaction',$transaction);
          $this->assign('ostyle',I('get.ostyle'));  //买入类型
          $this->assign('type',I('get.type'));  // 1实盘交易 2虚拟交易

          $this->assign('code',$code['currency_sign']);   //外汇标志
          $this->assign('waihui',$currency['name']); //外汇名称

          $this->display();
   }


    /**
     * 交易 下单
     * @author wang <admin>
     */
   
   public function transaction(){

      $hand      = trim(I('post.hand'));      //手数 

      $profit    = trim(I('post.profit'));    //止盈

      $loss      = trim(I('post.loss'));      //止损金额

      $Bond      = trim(I('post.Bond'));      //止损保证金

      $fee       = trim(I('post.fee'));       //交易综合费

      $foreign   = trim(I('post.foreign'));   //合计费用外汇

      $heji_rmb  = trim(I('post.heji_rmb'));  //合计费用人民币

      $type      = trim(I('post.type'));      //货币类型

      $ostyle    = trim(I('post.ostyle'));    //买涨买跌类型

      $pid       = trim(I('post.id'));        //产品id 

      $type_two  = trim(I('post.type_two'));  //1 实盘交易 2模拟交易

      //查询当前余额
      $accountinfo = M('accountinfo');
      $userinfo    = M('userinfo');

      $data = array();

      $accoun = $accountinfo->field('balance,frozen,gold')->where(array('uid' => $this->user_id))->find();
      $user   = $userinfo->where(array('uid' => $this->user_id))->find();
      
      //判断id是否存在或是否为休市状态
      $option = M('option')->where(array('id'=>$pid))->find();
      if ($option) {

            if(shijian($pid) == '已休市'){
                $data['status'] = 1;
                $data['msg'] = '该产品已休市';
                $this->ajaxReturn($data,'JSON');
            }
            
            if ($option['global_flag'] == 0 || $option['flag'] == 0) {
                $data['status'] = 1;
                $data['msg'] = '该产品已休市';
                $this->ajaxReturn($data,'JSON');
            }
            if ($option['sell_flag'] == 0) {
                $data['status'] = 1;
                $data['msg'] = '产品即将休市';
                $this->ajaxReturn($data,'JSON');
            }


            //判断用户提交的数据
             $transaction = M('OptionTransaction')->where(array('option_id' => $pid))->select();
             $profitArr = array();
             $lossArr   = array();
             foreach ($transaction as $key => $value) {
                 array_push($profitArr,$value['stop_profit']);
                 array_push($lossArr,$value['Stop_loss']);
             }
             if(!in_array($profit,$profitArr) || !in_array($loss,$lossArr))
             { 
                $data['status'] = 1;
                $data['msg'] = '止盈或止损参数错误！';
                $this->ajaxReturn($data,'JSON');
             }
             
             $optionInfo = M('OptionInfo')->where(array('option_id' => $pid))->find();
             $offset = array_search($loss,$lossArr);
             $offset = ($offset)+1;
             $Bonds  = round(($optionInfo['Bond'] * $offset) * $hand,2);
             if($Bond != $Bonds) {
                $data['status'] = 1;
                $data['msg'] = '保证金有误！';
                $this->ajaxReturn($data,'JSON');
             }

             $special = M('OptionUserSpecial')->field('platform_commission,commission')->where(array('user_id' => $this->agent_id,'option_id' => $pid))->find();
             $fees = round(($special['platform_commission'] + $special['commission'])  * $hand,2);
             if($fees != $fee) {
                $data['status'] = 1;
                $data['msg'] = '手续费有误！';
                $this->ajaxReturn($data,'JSON');
             }

             $foreigns = round(($Bonds + $fees),2);
             if($foreigns != $foreign) {
                $data['status'] = 1;
                $data['msg'] = '金额有误！';
                $this->ajaxReturn($data,'JSON');
             }
             
            $currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($pid).'');  //汇率
            $rate =  $currency['rate'];
            $heji_rmbs = round($foreigns * $rate,2);
            if($heji_rmbs != $heji_rmb) {
                $data['status'] = 1;
                $data['msg'] = '人民币金额有误！';
                $this->ajaxReturn($data,'JSON');
            }
            
            if($ostyle == 0){
                $new_price  = $option['sp'];   //小数点位
                $rivalprice = $option['bp'];   //对手价点位
            } else {
                $new_price  = $option['bp'];   //小数点位 
                $rivalprice = $option['sp'];   //对手价点位
            }
            
      } else {
            $data['status'] = 1;
            $data['msg'] = '参数错误！你不能购买';
            $this->ajaxReturn($data,'JSON');
      }


      //交易手数限制
      $sysDate    = get_setting_config('find', 'SYSTEM_OPTION_NUMBER');
      $sys_date   = explode('|',$sysDate['datas']['sys_date']);

   //如果为实盘交易
    if($type_two == '1'){

        if($accoun['balance'] < $heji_rmb){

            $data['status'] = 0;
            $data['msg'] = '余额不足请充值!';
            $this->ajaxReturn($data,'JSON');
        }
        
        $acc = M("accountinfo")->where(array('uid' => $this->agent_id))->find();

        /*冻结资金阈值*/
        if($acc['frozen_threshold'] == 0)
        {
            $data['status'] = 1;
            $data['msg'] = '购买失败，请联系相关客服';
            $this->ajaxReturn($data,'JSON');
        }
        if($acc['balance'] <= $acc['frozen_threshold'])
        {
            $data['status'] = 1;
            $data['msg'] = '购买失败，请联系相关客服';
            $this->ajaxReturn($data,'JSON');
        }
        /*冻结资金阈值*/

        if($acc['balance'] < $profit){

            $data['status'] = 0;
            $data['msg'] = '购买失败，请联系相关客服';
            $this->ajaxReturn($data,'JSON');
        }

        //交易手数限制
      if($sys_date[0] != 0) {
          
        $count = M("order")->where('uid = '.$this->user_id.' and pid = '.$pid.' and type = 1 and ostaus = 0')->count();
        $count = ($hand + $count);
        if($count > $sys_date[0]) {
          $data['status'] = 1;
          $data['msg'] = '持仓中的商品请不要超过'.$sys_date[0].'手';
          $this->ajaxReturn($data,'JSON');
        }
      } else { 
            $data['status'] = 1;
            $data['msg'] = '商品暂时无法交易，请联系客服咨询';
            $this->ajaxReturn($data,'JSON');
      }

        $order['type'] = '1';
    } else {

      //交易手数限制
      if($sys_date[1] != 0) {
          
        $count = M("order")->where('uid = '.$this->user_id.' and pid = '.$pid.' and type = 2 and ostaus = 0')->count();
        $count = ($hand + $count);
        if($count > $sys_date[1]) {
          $data['status'] = 1;
          $data['msg'] = '持仓中的商品请不要超过'.$sys_date[1].'手';
          $this->ajaxReturn($data,'JSON');
        }
      } else { 
          $data['status'] = 1;
          $data['msg'] = '商品暂时无法交易，请联系客服咨询';
          $this->ajaxReturn($data,'JSON');
      }

      if($accoun['gold'] < $heji_rmb){

          $data['status'] = 1;
          $data['msg'] = '金币不足请联系客服人员';
          $this->ajaxReturn($data,'JSON');
      }
        
        $order['type'] = '2';
    }

     
      if($user['trade_frozen'] == 1) {
          $data['status'] = 1;
          $data['msg'] = '交易账户未激活，请联系客服！';
          $this->ajaxReturn($data,'JSON');
      }

      $order['uid']       = $this->user_id;
      $order['pid']       = $pid;
      $order['ostyle']    = $ostyle;          //0涨 1跌，
      $order['buytime']   = time();
      $order['ostaus']    = 0;                //0交易，1平仓
      $order['buyprice']  = $new_price;       //入仓价
      $order['sellprice'] = $rivalprice;       //平仓价
      $order['endprofit'] = $profit;          //止盈
      $order['endloss']   = $loss;            //止损
      $order['fee']       = $fee / $hand;     //交易综合费
      $order['orderno']   = time().mt_rand(); //订单号
      $order['Bond']      = $Bond / $hand;    //止损保证金
      $order['extension'] = 1;                //推广金额 1未领取  2已领取
      $a = array();
      for($i = 1; $i <= $hand; $i++){
         
         //添加订单
         $result = M('order')->add($order);
          array_push($a, $result);
          //添加订单日志
           
           $data['jno']     = time().mt_rand(); //日志编号
           $data['uid']     = $this->user_id;
           $data['jtype']   = '建仓';
           $data['jtime']   = time();  //操作时间
           $data['number']  = '1';
           
           $data['remarks'] = $option['capital_name'];

            if($type_two == '1'){
                $data['type']    = '1';                                            //真实交易
                $data['balance'] = $accoun['balance'] - ($heji_rmb / $hand) * $i;  //用户余额
             } else{
                $data['balance'] = $accoun['gold'] - ($heji_rmb / $hand) * $i;      //用户金币
                $data['type']    = '2';
             }

           $data['jusername']  = $user['username'];
           $data['jostyle']    = $ostyle;   //涨跌
           $data['juprice']    = $order['Bond'] * $rate;  //产品单价
           $data['jfee']       = $order['fee'] * $rate;  //手续费
           $data['jbuyprice']  = $new_price;    //进仓价
           $data['jaccess']    = '-'.$heji_rmb / $hand;  //出入金额
           $data['oid']        = $result;
           $journal = M('journal')->add($data);
      }

      if($result && $journal){
             
             if($type_two == '1'){
                  //生成手续流水单
                   foreach ($a as $key => $value) {
                      $money_flow = $accountinfo->where(array('uid' => $this->user_id))->setDec('balance',$heji_rmb/$hand);  //减去用户余额

                      if($money_flow) {
                          //用户资金流水表
                          $map['uid']      = $this->user_id;
                          $map['type']     = 1;
                          $map['oid']      = $value;
                          $map['note']     = '用户购买'.$option['capital_name'].'扣除['.$heji_rmb / $hand.']元';
                          $map['balance']  = $accountinfo->where(array('uid' => $this->user_id))->sum('balance');
                          $map['op_id']    = $this->user_id;
                          $map['dateline'] = time();
                          M("MoneyFlow")->add($map);
                      }

                      $order     = M('order')->where(array('oid' => $value))->find();     //查询订单

                      $money_rmb     = $order['fee']  * $rate; //转换人民币
                      
                      $user = M('userinfo')->where(array('uid' => $order['uid']))->find();   //查询购买的用户   

                      $one = M()->query("SELECT * FROM wp_userinfo WHERE uid = ".$user['rid']." AND unix_timestamp(NOW()) < utime+365*24*60*60;");

                      if($one){

                        $one_money   = $order['fee'] * (commission_rate('class_a') / 100);   //收益

                        $one_money_rmb = $money_rmb * (commission_rate('class_a') / 100);    //收益人民币

                        $one_class['order_id']     = $value;         //订单id
                        $one_class['user_id']      = $one[0]['uid']; //领取人id 0表示交易所
                        $one_class['profit']       = $one_money;     //佣金收益
                        $one_class['profit_rmb']   = $one_money_rmb; //佣金收益人民币
                        $one_class['fee_rmb']      = $money_rmb;     //手续费人民币
                        $one_class['create_time']  = time();         //创建时间
                        $one_class['status']       = 2;              //1已经发放  2未发放
                        $one_class['type']         = 1;              //1用户 2交易所 3运营中心  4 经纪人
                        $one_class['purchaser_id'] = $this->user_id; //购买人
                        M('FeeReceive')->add($one_class);
                           
                           //二级
                        $two = M()->query("SELECT * FROM wp_userinfo WHERE uid = ".$one[0]['rid']." AND unix_timestamp(NOW()) < utime+365*24*60*60;");
                      if($two){

                            $two_money     = $order['fee'] * (commission_rate('class_b') / 100);

                            $two_money_rmb = $money_rmb * (commission_rate('class_b') / 100);    //收益人民币

                            $two_class['order_id']     = $value;           //订单id
                            $two_class['user_id']      = $two[0]['uid'];   //领取人id 0表示交易所
                            $two_class['profit']       = $two_money;      //佣金收益
                            $two_class['profit_rmb']   = $two_money_rmb; //手续费人民币
                            $two_class['fee_rmb']      = $money_rmb;     //手续费人民币
                            $two_class['create_time']  = time();        //创建时间
                            $two_class['status']       = 2;             //1已经发放  2未发放
                            $two_class['type']         = 1;             //1用户 2交易所 3运营中心  4 经纪人
                            $two_class['purchaser_id'] = $this->user_id;  //购买人
                            M('FeeReceive')->add($two_class);
                        }

                      }

                    //交易所
                        $exchange['order_id']     = $value;       //订单id
                        $exchange['user_id']      = 0;             //领取人id 0表示交易所
                        $exchange['profit']       = $special['platform_commission']; //佣金收益
                        $exchange['profit_rmb']   = $special['platform_commission'] * $rate;
                        $exchange['fee_rmb']      = $money_rmb;     //手续费人民币
                        $exchange['create_time']  = time();        //创建时间
                        $exchange['status']       = 1;             //1已经发放  2未发放
                        $exchange['type']         = 2;             //1用户 2交易所 3运营中心  4 经纪人
                        $exchange['purchaser_id'] = $this->user_id;  //购买人
                        M('FeeReceive')->add($exchange);
                                           

                    //查找运营中心
                    $operats = $this->agent_id;

                    if($operats){
                        //人民币
                        $operats_money = $special['commission'] * $rate;
                        $one_money_rmb = round($one_money_rmb,2);
                        $two_money_rmb = round($two_money_rmb,2);
                        $balance_money = round($operats_money - ($one_money_rmb + $two_money_rmb),2);

                        //外汇
                        $currency_money = round($special['commission'] - ($one_money + $two_money),2);

                        $operat['order_id']     = $value;       //订单id
                        $operat['user_id']      = $operats;      //领取人id 0表示交易所
                        $operat['profit']       = $currency_money;
                        $operat['profit_rmb']   = $balance_money;
                        $operat['fee_rmb']      = $money_rmb;     //手续费人民币
                        $operat['create_time']  = time();         //创建时间
                        $operat['status']       = 1;              //1已经发放  2未发放
                        $operat['type']         = 3;              //1用户 2交易所 3运营中心  4 经纪人
                        $operat['purchaser_id'] = $this->user_id; //购买人
                        M('FeeReceive')->add($operat);
                        $operat_status = M('accountinfo')->where(array('uid' => $operats))->setInc('balance',$balance_money);
                        if($operat_status) {
                            //运营中心资金流水表
                            $operat_flow['uid']      = $operats;
                            $operat_flow['type']     = 5;
                            $operat_flow['oid']      = $value;
                            $operat_flow['note']     = '用户购买'.$option['capital_name'].'运营中心增加佣金['.$balance_money.']元';
                            $operat_flow['balance']  = $accountinfo->where(array('uid' => $operats))->sum('balance');
                            $operat_flow['op_id']    = $this->user_id;
                            $operat_flow['user_type']= 2;
                            $operat_flow['dateline'] = time();
                            M("MoneyFlow")->add($operat_flow);
                        }
                    }
             }

             } else {
                  $accountinfo->where(array('uid' => $this->user_id))->setDec('gold',$heji_rmb);  //减去用户金币
             }

             if($accountinfo){
                  
                  $data['status'] = 2;
                  $data['msg'] = '购买成功';
                  $this->ajaxReturn($data,'JSON');
             } else {

                  $data['status'] = 0;
                  $data['msg'] = '购买失败';
                  $this->ajaxReturn($data,'JSON');
             }

      }
   }


    /**
     * 持仓记录
     * @author wang <admin>
     */

   public function position(){
        
       $pid  = I('get.pid'); 
       $type = I('get.type'); //1实盘交易 2模拟交易 

       $order  = M('order')->where(array('uid' => $this->user_id , 'pid' => $pid,'ostaus' => 0,'type' => $type))->select();

       $currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($order[0]['pid']).''); //外汇定义

       $rate = $currency['rate'];

       $option = M('option a')->field('a.currency,a.Price,a.id,a.capital_key,a.bp,a.sp,a.capital_name,b.*')->join('wp_option_info as b on a.id = b.option_id')->where(array('id' => $pid))->find();
       $option['Price'] = sprintf("%.".$option['capital_length']."f",$option['Price']);
       $option['new_pricetop'] = sprintf("%.".$option['capital_length']."f",$option['bp']);   //小数点位
       $option['new_priceup'] = sprintf("%.".$option['capital_length']."f",$option['sp']);   //小数点位
       
       foreach($order as &$val){
            
            $val['buyprice']  = sprintf("%.".$option['capital_length']."f",$val['buyprice']);
            $val['endprofit'] = $val['endprofit'].'&nbsp'.$currency['name'];
            $val['endloss']   = $val['endloss'].'&nbsp'.$currency['name'];
            $val['RMB']       = round($val['ploss'] * $rate,2);   //人民币
       }

        $sum['type']      = $currency['name'];   //外汇类型
        //持仓总收益
        $sum['sum'] = M('order')->where(array('uid' => $this->user_id, 'pid' => $pid,'ostaus' => 0))->sum('ploss');
        $sum['sum_rmb'] = $sum['sum'] * $rate;
       $this->assign('order',$order);
       $this->assign('option',$option);
       $this->assign('sum',$sum);
       $this->assign('type',$type);
       $this->assign('user_id',$this->user_id);
       $this->display();
   }




    /**
     * 持仓请求数据
     * @author wang <admin>
     */
   public function PositionData(){

        
        $pid    = I('get.pid');   //订单id
        $type   = I('get.type');  //1实盘 2虚拟
        $id =   I('get.id');

       $order  = M('order')->where("pid={$pid} and ostaus=0 and uid={$this->user_id} and type=type and oid in({$id})")->select();

      //  $order  = M('order')->where(array('pid' => $pid,'ostaus' => 0 ,'uid' => $this->user_id,'type' => $type))->select();
        $option = M('option a')->field('a.*,b.*')->join('wp_option_info as b on a.id = b.option_id')->where(array('id' => $pid))->find();

        $currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($option['id']).''); //外汇定义

        $rate = $currency['rate'];

        foreach($order as &$val){

            $val['RMB']       = round($val['ploss'] * $rate,2);

            $val['new_pricetop'] = sprintf("%.".$option['capital_length']."f",$option['bp']);   //小数点位

            $val['new_priceup'] = sprintf("%.".$option['capital_length']."f",$option['sp']);   //小数点位
            
            //持仓总收益
            $val['sum'] = M('order')->where(array('pid' => $pid,'ostaus' => 0,'uid' => $this->user_id, 'type' => $type))->sum('ploss');
            $val['sum_rmb'] = $val['sum'] * $rate;        //人民币
        }
        if($order) {
          $this->ajaxReturn($order);
        } else {
          $status['status'] = 0;
          $this->ajaxReturn($status,'JSON');
        } 
   }


    /**
     * 单个平仓
     * @author wang <admin>
     */
   public function Manual(){

            $Order       = M('order');
            $Accountinfo = M('accountinfo');
            $userinfo    = M('userinfo');
            $option      = M('option');
 
            $oid       = trim(I('post.oid'));
            $selltime  = time();
            $type      = trim(I('post.type'));  //1实盘 2虚拟
            
            $orderInfo = $Order->field('pid,ostyle,sellprice,buyprice')->where(array('oid' => $oid,'uid' => $this->user_id,'type' => $type, 'ostaus' => 0))->find();
            $optionInfo = $option->field('wave,capital_dot_length')->where(array('id' => $orderInfo['pid']))->find();
            $Order->startTrans(); //开启事务

            $data['selltime']  = $selltime;
            $data['ostaus']    = 1;
            $data['display'] = 1;
            $data['auto']    = 1;

            $true = $Order->field('oid')->where(array('oid' => $oid,'ostaus' => 1))->find();
            $return = array();
            if($true){
                 $return['status'] = 0;
                 $return['msg'] = '系统已经自动平仓了';
                 $this->ajaxReturn($return,'JSON');
            }


            if ($orderInfo['ostyle'] == 0) {
                 $ploss = (round($orderInfo['sellprice']  -  $orderInfo['buyprice'],5) * $optionInfo['wave']) * $optionInfo['capital_dot_length'];
                 $data['sellprice'] = $orderInfo['sellprice'];
                 $data['ploss'] = $ploss;
            } else {
                 $ploss = (round($orderInfo['buyprice']  -  $orderInfo['sellprice'],5) * $optionInfo['wave']) * $optionInfo['capital_dot_length'];
                 $data['sellprice'] = $orderInfo['sellprice'];
                 $data['ploss'] = $ploss;
            }

           $ostaus = $Order->where(array('oid' => $oid, 'ostaus' => 0 ,'uid' => $this->user_id ,'type' => $type))->save($data);

              if($ostaus)
              {
                 $order   = $Order->field('pid,ploss,Bond,sellprice,oid')->where(array('oid' => $oid,'uid' => $this->user_id,'type' => $type))->find();

                 $currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($order['pid']).'');//外汇定义

                 $rate = $currency['rate'];
                  
                 $yingkui = $order['ploss'] * $rate;

                 $money   = ($order['Bond'] + $order['ploss']) * $rate;  //转换人民币
                
                 if($type == 1){

                        //设置运营中心余额 (盈亏)
                        $ex_yingkui = $yingkui < 0 ? (abs($yingkui)) : -$yingkui;

                        $Accountinfo->where(array('uid' => $this->agent_id))->setInc('balance',$ex_yingkui);  //修改运营中心金额
                        if($yingkui >= 0) {
                           $Accountinfo->where(array('uid' => $this->user_id))->setInc('income_total',abs($yingkui));  //修改用户总盈利 
                        } else {
                           $Accountinfo->where(array('uid' => $this->user_id))->setInc('loss_total',abs($yingkui));  //修改用户总亏损
                        }
                        
                        $account = $Accountinfo->where(array('uid' => $this->user_id))->setInc('balance',$money);  //修改用户金额
                        $gold = $Accountinfo->where(array('uid' => $this->user_id))->getField('balance');
                       
                 } else{
                        
                        $account = $Accountinfo->where(array('uid' => $this->user_id))->setInc('gold',$money);  //修改用户金币
                        $gold = $Accountinfo->where(array('uid' => $this->user_id))->getField('gold');
                 }

                  $bond    = ($order['Bond'] + $order['ploss']) * $rate;  //出入金额
                  $ploss   = $order['ploss'] * $rate;  //盈亏金额 
                  $jstate  = $order['ploss'] > 0 ? 1:0;

                  $select = "INSERT INTO wp_journal 
                                                (
                                                `jno`,`jtype`,
                                                 `uid`,`jtime`,
                                                 `number`,`remarks`,
                                                 `type`,`balance`,
                                                 `jstate`,`jusername`,
                                                 `jostyle`,`juprice`,
                                                 `jfee`,`jbuyprice`,
                                                 `jsellprice`,`jaccess`,
                                                 `jploss`,`oid`,`auto`
                                                )
                                               SELECT 
                                                      ".time().mt_rand().",
                                                      '平仓', 
                                                       uid,
                                                       ".time().",
                                                       number,
                                                       remarks,
                                                       type,
                                                       ".$gold.",
                                                       ".$jstate.",
                                                       jusername,
                                                       jostyle,
                                                       juprice,
                                                       jfee,
                                                       jbuyprice,
                                                       ".$order['sellprice'].",
                                                       ".$bond.",
                                                       ".$ploss.",
                                                       oid,
                                                       1
                                                       FROM wp_journal 
                                                where oid = ".$order['oid']." ";

              M()->query($select);
              if($type == 1){

                      $id = M()->query('select last_insert_id() as last_insert_id');
                      $name = M('journal')->field('remarks')->where(array('id' => $id[0]['last_insert_id']))->find();
                      //用户资金流水表
                      $map['uid']      = $this->user_id;
                      $map['type']     = 2;
                      $map['oid']      = $id[0]['last_insert_id'];
                      $map['note']     = '用户对'.$name['remarks'].'进行平仓增加['.$bond.']元';
                      $map['balance']  = $gold;
                      $map['op_id']    = $this->user_id;
                      $map['dateline'] = time();
                      M("MoneyFlow")->add($map);

                      //运营中心资金流水表
                      $operate_loss = $ex_yingkui >= 0 ? '增加['.$ex_yingkui.']' : '扣除['.$ex_yingkui.']';
                      $operat_flow['uid']      = $this->agent_id;
                      $operat_flow['type']     = 2;
                      $operat_flow['oid']      = $id[0]['last_insert_id'];
                      $operat_flow['note']     = '用户对'.$name['remarks'].'进行平仓'.$operate_loss.'元';
                      $operat_flow['balance']  = M('accountinfo')->where('uid='.$this->agent_id)->sum('balance');
                      $operat_flow['op_id']    = $this->user_id;
                      $operat_flow['user_type']= 2;
                      $operat_flow['dateline'] = time();
                      M("MoneyFlow")->add($operat_flow);
              }
        }
 
            if($ostaus && $account){

                 $Order->commit();
                 $return['status'] = 1;
                 $return['msg'] = '平仓成功';
                 $this->ajaxReturn($return,'JSON');
            } else {
                              
                 $return['status'] = 0;
                 $return['msg'] = '平仓失败';
                 $this->ajaxReturn($return,'JSON');
                 $Order->rollback();
            }
   }

    /**
     * 一键平仓
     * @author wang <admin>
     */
    
    public function All(){
            
            $Order       = M('order');
            $Accountinfo = M('accountinfo');
            $userinfo    = M('userinfo');
            $option      = M('option');
            $journal     = M('journal');
    
            $id           = substr(trim(I('post.oid')),0,-1);
            $pid          = trim(I('post.pid'));
            $type         = trim(I('post.type'));    //1实盘 2虚拟
            $selltime     = time();

            $orderInfo = $Order->field('ostyle,buyprice,sellprice,oid,pid')->where('oid in('.$id.') and uid = '.$this->user_id.' and type = '.$type.' and ostaus = 0 and pid = '.$pid.'')->select();

            $optionInfo = $option->field('wave,capital_dot_length')->where(array('id' => $pid))->find();
            
            $data['selltime']  = $selltime;
            $data['ostaus']    = '1';
            $data['display'] = 1;
            $data['auto']    = 1;
            
            $Order->startTrans();   //开启事务

            $return = array();
            $true = $Order->field('oid')->where('oid in('.$id.') and pid = '.$pid.' and ostaus = 1')->select();
            if($true){
                 $return['status'] = 0;
                 $return['msg'] = '系统已经自动平仓了';
                 $this->ajaxReturn($return,'JSON');
            }


            foreach ($orderInfo as $key => $value) {
                if ($value['ostyle'] == 0) {
                   $ploss = (round($value['sellprice'] - $value['buyprice'],5) * $optionInfo['wave']) * $optionInfo['capital_dot_length'];
                   $data['sellprice'] = $value['sellprice'];
                   $data['ploss'] = $ploss;
                } else {
                   $ploss = (round($value['buyprice'] - $value['sellprice'],5) * $optionInfo['wave']) * $optionInfo['capital_dot_length'];
                   $data['sellprice'] = $value['sellprice'];
                   $data['ploss'] = $ploss;
                }
                $ostaus_top  = $Order->where( 'pid = '.$pid.' and ostaus = 0 and uid = '.$this->user_id.' and type = '.$type.' and oid = '.$value['oid'].'')->save($data);
            }

            
            $order   = $Order->where('pid = '.$pid.' and uid = '.$this->user_id.' and type = '.$type.' and oid in('.$id.')')->select();

            $currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($order[0]['pid']).'');//外汇定义
            $rate = $currency['rate'];
            
            $money = 0;

            foreach ($order as $val) {

                if(!$Order->where(array('oid' => $val['oid'],'ostaus' => 1,'display' => 1,'auto' => 1))->find())
                {
                  return;
                }

                $yingkui = $val['ploss'] * $rate;   //盈亏
                $money   = ($val['Bond'] + $val['ploss']) * $rate;  //转换人民币

             if($type == '1'){
                                    
                  //设置运营中心余额 (盈亏)
                  $ex_yingkui = $yingkui < 0 ? (abs($yingkui)) : -$yingkui;
                 
                  $Accountinfo->where(array('uid' => $this->agent_id))->setInc('balance',$ex_yingkui);  //修改运营中心金额
                  if($yingkui >= 0) {
                      $Accountinfo->where(array('uid' => $this->user_id))->setInc('income_total',abs($yingkui));  //修改用户总盈利
                  } else {
                      $Accountinfo->where(array('uid' => $this->user_id))->setInc('loss_total',abs($yingkui));  //修改用户总亏损
                  }
                  $account = $Accountinfo->where(array('uid' => $this->user_id))->setInc('balance',$money);  //修改用户金额
                  $gold = $Accountinfo->where(array('uid' => $this->user_id))->getField('balance');
                  
             } else{

                  $account = $Accountinfo->where(array('uid' => $this->user_id))->setInc('gold',$money);  //修改用户金币
                  $gold = $Accountinfo->where(array('uid' => $this->user_id))->getField('gold');
             }
                   
                    //生成订单信息
                  $bond    = ($val['Bond'] + $val['ploss']) * $rate;  //出入金额
                  $ploss   = $val['ploss'] * $rate;  //盈亏金额
                  $jstate  = $val['ploss'] > 0 ? 1:0;

                  $select = "INSERT INTO wp_journal 
                                                (
                                                `jno`,`jtype`,
                                                 `uid`,`jtime`,
                                                 `number`,`remarks`,
                                                 `type`,`balance`,
                                                 `jstate`,`jusername`,
                                                 `jostyle`,`juprice`,
                                                 `jfee`,`jbuyprice`,
                                                 `jsellprice`,`jaccess`,
                                                 `jploss`,`oid`,`auto`
                                                )
                                               SELECT
                                                      ".time().mt_rand().",
                                                      '平仓',
                                                       uid,
                                                       ".time().",
                                                       number,
                                                       remarks,
                                                       type,
                                                       ".$gold.",
                                                       ".$jstate.",
                                                       jusername,
                                                       jostyle,
                                                       juprice,
                                                       jfee,
                                                       jbuyprice,
                                                       ".$val['sellprice'].",
                                                       ".$bond.",
                                                       ".$ploss.",
                                                       oid,
                                                       1
                                                       FROM wp_journal
                                                where oid = ".$val['oid']." ";

                  M()->query($select);
                  //用户流水
                  if($type == 1) {
                      $id   = M()->query('select last_insert_id() as last_insert_id');
                      $name = M('journal')->field('remarks')->where(array('id' => $id[0]['last_insert_id']))->find();
                      //用户资金流水表
                      $map['uid']      = $this->user_id;
                      $map['type']     = 2;
                      $map['oid']      = $id[0]['last_insert_id'];
                      $map['note']     = '用户对'.$name['remarks'].'进行平仓增加['.$bond.']元';
                      $map['balance']  = $gold;
                      $map['op_id']    = $this->user_id;
                      $map['dateline'] = time();
                      M("MoneyFlow")->add($map);

                      //运营中心资金流水表
                      $operate_loss = $ex_yingkui >= 0 ? '增加['.$ex_yingkui.']' : '扣除['.$ex_yingkui.']';
                      $operat_flow['uid']      = $this->agent_id;
                      $operat_flow['type']     = 2;
                      $operat_flow['oid']      = $id[0]['last_insert_id'];
                      $operat_flow['note']     = '用户对'.$name['remarks'].'进行平仓'.$operate_loss.'元';
                      $operat_flow['balance']  = M('accountinfo')->where('uid='.$this->agent_id)->sum('balance');
                      $operat_flow['op_id']    = $this->user_id;
                      $operat_flow['user_type']= 2;
                      $operat_flow['dateline'] = time();
                      M("MoneyFlow")->add($operat_flow);
                  }

              }

            if($ostaus_top && $account){

                 $Order->commit();
                 $return['status'] = 1;
                 $return['msg'] = '平仓成功';
                 $this->ajaxReturn($return,'JSON');
            } else {
                              
                 $return['status'] = 0;
                 $return['msg'] = '平仓失败';
                 $this->ajaxReturn($return,'JSON');
                 $Order->rollback();
            }
           
    }

 /**
  * 结算
  * @author wang <admin>
  */
  public function settlement(){

       $pid  = I('get.pid'); 
       $type = I('get.type');  //1 实盘交易 2模拟交易

       $map['a.uid'] = $this->user_id;
       $map['a.pid'] = $pid;
       $map['a.ostaus'] = 1;
       $map['a.type'] = $type;
       $map['b.jtype'] = '平仓';
       $map['b.uid'] = $this->user_id;
       $order  = M('order a')->field('a.*,b.jploss,c.capital_length')->join('wp_journal as b on a.oid = b.oid')->join('wp_option_info as c on a.pid = c.option_id')->where($map)->order('a.selltime desc')->limit(0,10)->select();
       $count  = M('order a')->field('a.*,b.jploss')->join('wp_journal as b on a.oid = b.oid')->where($map)->order('a.selltime desc')->count();
       $count  = $count / 10; //总页数

       $currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($order[0]['pid']).'');//外汇定义
       $option = M('option')->field('currency,Price,capital_key,id,capital_name')->where(array('id' => $pid))->find();
       
       foreach($order as &$val){

            $val['endprofit'] = $val['endprofit'].'&nbsp'.$currency['name']; //止盈 外汇
            $val['endloss']   = $val['endloss'].'&nbsp'.$currency['name'];   //止损 外汇
            $val['buyprice']  = sprintf("%.".$val['capital_length']."f",$val['buyprice']);  //买入价格
            $val['sellprice'] = sprintf("%.".$val['capital_length']."f",$val['sellprice']); //卖出价格
            $val['RMB']       = round($val['jploss'],2);
            $val['color']     = $val['ploss'] >= 0 ? '#DA2F34' : '#539B53';

       }
       $data = array();
       $data['type']  = $type;
       $data['pid']   = $pid;
       $data['count'] = ceil($count);
       
       $this->assign('data',$data);
       $this->assign('order',$order);
       $this->assign('option',$option);
       $this->display();
   }

    /**
     * 结算
     * @author wang <admin>
     */
  public function settlement_new(){

       $pid  = I('get.pid'); 
       $type = I('get.type'); 
       $page = I('get.page');
       
       $map['a.uid'] = $this->user_id;
       $map['a.pid'] = $pid;
       $map['a.ostaus'] = 1;
       $map['a.type'] = $type;
       $map['b.jtype'] = '平仓';
       $map['b.uid'] = $this->user_id;
       $order  = M('order a')->field('a.*,b.jploss,c.capital_length')->join('wp_journal as b on a.oid = b.oid')->join('wp_option_info as c on a.pid = c.option_id')->where($map)->order('a.selltime desc')->limit($page,10)->select();
       $currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($order[0]['pid']).'');//外汇定义
       
       foreach($order as &$val){

            $val['endprofit'] = $val['endprofit'].'&nbsp'.$currency['name']; //止盈 外汇
            $val['endloss']   = $val['endloss'].'&nbsp'.$currency['name'];   //止损 外汇
            $val['buyprice']  = sprintf("%.".$val['capital_length']."f",$val['buyprice']);  //买入价格
            $val['sellprice'] = sprintf("%.".$val['capital_length']."f",$val['sellprice']); //卖出价格
            $val['RMB']       = round($val['jploss'],2);
            $val['buytime']   = date('Y-m-d H:i:s',$val['buytime']);
            $val['selltime']  = date('Y-m-d H:i:s',$val['selltime']);
            $val['color']     = $val['ploss'] >= 0 ? '#DA2F34' : '#539B53';

       }
        $this->ajaxReturn($order,'JSON');
   }

    /**
     * 产品签署协议
     * @author wang <admin>
     */
    
     public function contract(){

         $option_id = I('get.option_id');

         $data      = array();
         $contract  = M("OptionContract")->where(array("option_id" => $option_id,"user_id" => $this->user_id,'status'=> 1))->find();

         if($contract){
            
              $data['status'] = 1;
              $data['msg']    = '你已经签署过协议了!';
              $this->ajaxReturn($data,'JSON');

         } else {

              $map['option_id'] = $option_id;
              $map['user_id']   = $this->user_id;
              $map['status']    = 1;
              $result = M("OptionContract")->add($map);
              if($result){
                                
                  $data['status'] = 1;
                  $data['msg']    = '协议签署成功！';
                  $this->ajaxReturn($data,'JSON');
              } else {

                  $data['status'] = 0;
                  $data['msg']    = '协议签署失败!';
                  $this->ajaxReturn($data,'JSON');
              }
         }

     }

    /**
     * 产品协议详情
     * @author wang <admin>
     */
    
    public function contractinfo(){
       
       $id = I('get.nid');
       // $info = M("newsinfo")->where(array('nid' => $id))->find();
       // $in = htmlspecialchars_decode($info['ncontent']);
       // //echo $in;die;
       // $this->assign('info',$in);
       if($id  == 1){
          
             $this->display('fengxian');
       } else {
            
             $this->display();
       }
       
    }

}