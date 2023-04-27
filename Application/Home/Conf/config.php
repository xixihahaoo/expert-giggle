<?php
return array(
    //'配置项'=>'配置值'
   'SHOW_PAGE_TRACE'=>false,
     /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__ADDONS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/Addons',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
        '__PUBLIC__'    => __ROOT__ . '/Public/'
    ),


   // 'SHOW_PAGE_TRACE'=>true,//开启页面Trace

     //易通支付参数
   

    'stspage' => 'Home/User/memberinfo',

        //路由配置
    'URL_ROUTER_ON'   => true,      // 开启路由
    'URL_ROUTE_RULES'=>array(
        'pay/:code'         => 'PayJlNotifyUrl/bankPayment',
        'pay'               => 'PayJlNotifyUrl/bankPayment',
    ),
);