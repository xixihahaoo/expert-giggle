<?php
namespace Home\Controller;
class SimulationController extends CommonController {
  
    public function _initialize(){
        
        parent::_initialize();
    //判断域名
        $this->agent_id = http_host();

        $this->user_id = $_SESSION['user_id'];
    }


    public function index(){


      //产品列表
        
        $map['b.user_id'] = $this->agent_id;
        $map['b.status']  = 1;  //1为可售
        $result = M('option a')->field('a.*,b.status,b.type,b.option_id,b.user_id,b.commission,b.option_intro,c.sort')->join(' left join wp_option_user_special as b on a.id = b.option_id')->join('left join wp_option_info as c on a.id = c.option_id')->where($map)->order('c.sort asc')->select();
        foreach ($result as &$value) {
             
             if($value['flag'] == 0 || $value['global_flag'] == 0 || shijian($value['id']) == '已休市'){

                  $value['stop'] = $value['option_key'].'z';
             }
        }

        $this->assign('result',$result);
        $this->display(); 
    }


    //获取产品详情
    public function product(){
        
        $id = trim(I('get.id'));
        //判断id是否存在
        $exis  = M('option')->where(array('id'=>$id))->find();
        $first = M("option a")->join('wp_option_info as b on a.id = b.option_id')->where(array('a.global_flag' => 1))->order('b.sort asc')->find();   
        if($exis) {
            if($exis['global_flag'] == 0) {
               $id = $first['id'];
            }
        } else {
               $id = $first['id'];
        }
        
        $product = M('option a')->join('wp_option_info as b on a.id = b.option_id')->where(array('a.id' => $id))->find();
        $product['Price'] = sprintf("%.".$product['capital_length']."f",$product['Price']);
        $product['bp']    = sprintf("%.".$product['capital_length']."f",$product['bp']);
        $product['sp']    = sprintf("%.".$product['capital_length']."f",$product['sp']);
        $product['DiffRate'] = sprintf("%.".$product['capital_length']."f",$product['DiffRate']);

        if(shijian($product['id']) == '已休市')
            $product['flag'] = 0 ;


        $map['b.user_id'] = $this->agent_id;
        $map['b.status']  = 1;  //1为可售
        $option = M('option a')->field('a.*,b.status,b.type,b.option_id,b.user_id,b.commission,b.option_intro,c.sort')->join(' left join wp_option_user_special as b on a.id = b.option_id')->join('left join wp_option_info as c on a.id = c.option_id')->where($map)->order('c.sort asc')->select();
        $this->assign('option',$option);
        
        $this->assign('product',$product);
        $this->assign('type',2);

        //查询持仓中的商品个数
        $count = M('order')->where(array('uid' => $this->user_id,'ostaus' => 0, 'pid' => $product['id'],'type' => 2))->count();
        $this->assign('count',$count);


        /**闪电下单选择订单**/
        $transaction = M('OptionTransaction')->where(array('option_id' => $product['id']))->select();

        $currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($product['id']).'');

        $code = M('currency')->field('currency_sign')->where(array('currency_code' => $currency['code']))->find();
        $info = M('OptionInfo')->where(array('option_id' => $product['id']))->find();

        /*运营中心手续费*/
        $special = M('OptionUserSpecial')->field('platform_commission,commission')->where(array('user_id' => $this->agent_id,'option_id' => $product['id']))->find();

        $info['CounterFee'] = ($special['platform_commission'] + $special['commission']);
        /*运营中心手续费*/

        $info['foreign']     = round($info['Bond'] + $info['CounterFee'],2);                       //合计支付 外汇
        $info['foreign_rmb'] = round(($info['Bond'] + $info['CounterFee']) * $currency['rate'],2); //合计支付 人民币

        $this->assign('transaction',$transaction);
        $this->assign('currency',$currency);
        $this->assign('code',$code['currency_sign']);
        $this->assign('info',$info);
        /**闪电下单选择订单 End**/
        
        $this->assign('user_id',$this->user_id);
        $this->display();
    }

}