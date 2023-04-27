<?php
return array(
    //'配置项'=>'配置值'
   'SHOW_PAGE_TRACE'=>false,
     /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__ADDONS__' => __ROOT__ . '/Public/Home/Addons',
        '__IMG__'    => __ROOT__ . '/Public/Home/images',
        '__CSS__'    => __ROOT__ . '/Public/Home/css',
        '__JS__'     => __ROOT__ . '/Public/Home/js',
        '__PUBLIC__'    => __ROOT__ . '/Public/'
    ),


   // 'SHOW_PAGE_TRACE'=>true,//开启页面Trace


    'stspage' => 'Home/User/memberinfo',
);