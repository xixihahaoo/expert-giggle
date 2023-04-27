<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0039)http://pro.jinguzhi.net/simulation.html -->
<html style="font-size: 100px;">
<head>
    <title>模拟操盘-<?php echo config('s_domain_name'); echo config('webname');?></title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0">
<meta name="keywords" content="股指期货,期指,黄金,白银,沪深300,中证500,上证50">
<meta name="description" content="<?php echo tel('notice');?>">

    <link rel="stylesheet" href="/Public/Home/css/simulation_merge.css">
    <link rel="stylesheet" href="/Public/Home/css/index_merge.css">
    <style>
        .shadeWrap{ position:fixed; width:100%; height:100%; top:0; left:0; z-index:99; background:rgba(0,0,0,.3); font-size:.16rem;}
        .shadeWrap .content{ width: 75%; background: #fff; border-radius: .05rem; position: absolute; top: 50%; margin-top: -20.5%; left: 50%; margin-left: -38%; text-align: center;box-shadow: 0 0 .05rem rgba(0,0,0,.4); }
        .shadeWrap .mainWrap{padding: .25rem; border-bottom: 1px solid #eee;}
        .shadeWrap .action{ height:.38rem; line-height: .38rem; border-radius: 0 0 .05rem .05rem;font-size:.16rem; color:#fff;background:#da3333;}
    </style>
    <script type="text/javascript">
        var __baseDir = 'http://'+window.location.host+'/content/';
    </script>
    
    <script>
        document.getElementsByTagName('html')[0].style.fontSize = '100px'; 
    </script>
</head>

<body>

<!-- 头部 -->
<header class="head" style=" background-color: #c18e57;">
    <a href="<?php echo U('Index/index');?>" class="icon-youjiantou"></a>
    <h3>模拟交易</h3>
</header>
<!-- 内容 -->
<section class="main">
    <div class="user clear">
        <i class="icon-jifne"></i>
        <p>可用金币</p>
        <span><?php echo ($user["gold"]); ?></span>
    </div>
    <div class="mainDiv">
    <ul class="mainUl">

      <?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['global_flag'] == 1): ?><li class="addli">
                <a href="<?php echo U('product',array('id'=>$vo['id']));?>">
                <?php if($vo['stop']): ?><i class="<?php echo ($vo["stop"]); ?>" usename="CL" style="color: rgb(184, 87, 178);"></i>
                <?php else: ?>
                    <i class="<?php echo ($vo["option_key"]); ?>" usename="CL" style="color: rgb(184, 87, 178);"></i><?php endif; ?>
                <h5><?php echo ($vo["capital_name"]); ?></h5>
                <p><?php echo ($vo["option_intro"]); ?></p>
                <em class="icon-chicang"></em>
                </a>
                <span class="top_border"></span>
                <span class="right_border"></span>
        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>

    </ul>
    </div>
</section>

<!-- 底部 -->


<footer class="page-footer">
    <div class="content">
        <ul>
            <li class="home">
                <a href="<?php echo U('Index/index');?>">
                    <span class="icon-home img"></span><span>首页</span>
                </a>
            </li>
            <li class="trade">
                <a href="<?php echo U('Index/product');?>">
                    <span class="icon-jiaoyi img" style="line-height: 0.18rem;"></span><span>交易</span>
                </a>
            </li>
            <li class="ziXun">
                <a href="<?php echo U('News/index');?>">
                    <span class="icon-zx img"></span><span>资讯</span>
                </a>
            </li>
            <li class="mine">
                <a href="<?php echo U('User/index');?>">
                    <span class="icon-gerne img"></span><span class="active">我的</span>
                </a>
            </li>
        </ul>
    </div>
</footer>
</body>
</html>

<style type="text/css">
.mainDiv .mainUl .addli i{    
    color: rgb(184, 87, 178);
    width: 34px;
    height: 34px;
    border-radius: 50%;
left: 51%;}
</style>