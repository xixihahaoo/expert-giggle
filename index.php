<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件


// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// header("Access-Control-Allow-Origin: *");

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);
define('DB_FIELD_CACHE',true);

defined('APP_REAL_PATH') 	or define('APP_REAL_PATH',     __DIR__.'/');
// 定义应用目录
define('APP_PATH','./Application/');

define('SYSTEM_DOMAIN', 'kltas.com');

define('SYSTEM_DOMAIN_NAME', '鼎盛国际');

define('SYSTEM_WEIXIN_UPLOAD_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/Uploads/');

define('LOG_PATH_SPE', dirname($_SERVER['SCRIPT_FILENAME']).'/Logs/');

define('APP_NAME', 'index');

define('NORMAL_WX_APPID', 'wxc63594d45a3df5bb');
define('NORMAL_WX_APPSECRET', 'df258fc30c973721e7fce2e2f38694da');

define('WX_TOKEN_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/wxcache/');

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单
