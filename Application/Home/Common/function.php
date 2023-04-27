<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/12
 * Time: 9:05
 */

//系统基本信息
function config($field) {

       $user_id = exchange(session('user_id'),2);
       $user = M('userinfo')->where(array('uid' => $user_id))->find();
       if($user['s_domain_name'] != '' && $user['utel'] != ''){

           return $user[$field];
       }  else {
           $user = M('webconfig')->where(array('id' => 1))->find();
       }
         return $user[$field];

}

function tel($tel){

    $user = M('webconfig')->where(array('id' => 1))->find();
    return strtr($user[$tel], array(' '=>''));
}

//交易所收取佣金
//1 交易所 2运营中心
function exchange_commission($option_id,$number,$pid){
   
   if($number == 1){

      $info = M('OptionInfo')->where(array('option_id' => $option_id))->find();  //外汇
   }
   
   if($number == 2){

      $info = M("OptionUserSpecial")->where(array('user_id' => $option_id,'option_id' => $pid))->find();

   }
   return $info['commission'];
}



//佣金比率
function commission_rate($class){

  $rate = M("UserinfoRate")->where(array('class' => $class))->find();
  return $rate['rate'];
}