<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html style="font-size: 100px;"><head>
    <title>我的账户</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0">
<meta name="keywords" content="股指期货,期指,黄金,白银,沪深300,中证500,上证50">
<meta name="description" content="<?php echo tel('notice');?>">

    <link rel="stylesheet" href="/Public/Home/css/merge_user.css">

    <script typet="text/javascript" src="/Public/Home/js/1.9.1jq/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/layer_mobile/layer.css">
    <script type="text/javascript" src="/Public/Home/css/layer_mobile/layer.js"></script>

 <style type="text/css">
        
#accounts .user .img{
             width: 0.77rem;
            height: 0.77rem;
/*            <?php if($face[open_face]): ?>*/
            background: url('<?php echo ($face["open_face"]); ?>')no-repeat;
/*            <?php else: ?>
            background: url('http://zhongying.gwecaopan.com/content/assets/imgs/head_visitor.png')no-repeat;<?php endif; ?>*/
            background-size: cover;
            display: block;
            margin: 0.1rem auto;
            border-radius: 50%;
       }
 </style>

</head>
<body>

<div id="doc" class="doc page-mine" data-details="" data-financy="">
    <!-- 头部 -->
    <header class="page-header">
        <div class="content">
            <h3>我的</h3>
            <div class="right">
               <!--  <a href="<?php echo U('Register/logout');?>" style="display: block;">退出</a> -->
            </div>
        </div>
    </header>

    <!-- 内容 -->
    <section class="page-main main-mine">
        <div class="content">
            <!-- 账户内容 -->
            <article class="accounts" id="accounts">
                <div class="user">
                    <a class="goDetail" href="<?php echo U('User/personal');?>" data-href="">
                        <span class="img"></span>
                         <?php if($userinfo[nickname]): ?><span class="name">您好，<?php echo ($userinfo["nickname"]); ?></span>
                        <?php else: ?>
                         <span class="name">您好，<?php echo ($userinfo["username"]); ?></span><?php endif; ?>
                    </a>
                </div>
                <div class="detail">
                    <div class="summary clearfix">
                        <ul>
                            <li class="text-lesser"><span class="text-stress"><em class="text-l">
                            <?php if(empty($userinfo[balance])): ?>0
                             <?php else: ?>
                            <?php echo ($userinfo["balance"]); endif; ?>
                            </em></span></li>
                            <li class="text-lesser">账户余额(元)</li>
                        </ul>
                        <?php if($trade == 1): ?><ul>
                            <li class="text-lesser"><em class="text-minor text-m">
                             <?php if(empty($userinfo[gold])): ?>0
                             <?php else: ?>
                            <?php echo ($userinfo["gold"]); endif; ?>
                            </em> </li>
                            <li class="text-lesser">模拟金币</li>
                        </ul>
                        <?php else: ?>
                            <style>
                                .detail .summary ul {
                                    width: 100%;
                                }
                            </style><?php endif; ?>
                    </div>
                    <div class="action clearfix" style="display:none">

                        <div class="left">
                            <a href="/login.html" class="button button-stress do-rechange">登录</a>
                        </div>
                        <div class="right">
                            <a href="/register.html" class="button do-atm">免费注册</a>
                        </div>

                    </div>
                    <div class="action clearfix clear" style="display: block;">

                        <div class="left">
                            <a href="<?php echo U('account');?>" class="button button-stress do-rechange">充值</a>
                        </div>
                        <div class="right">
                            <a href="<?php echo U('withdraw');?>" class="button do-atm">提现</a>
                        </div>
                    </div>
                </div>
            </article>


            <!-- 列表 -->

            <ul class="mod-list mod-list-sample mine-mod-list" style="display: none;">

                <li class="height">
                    <a class="test" href="/news/Message.html">
                        <span class="leftBg icon-xiaoxi1"></span>
                        <span>消息中心</span>
                        <span class="rightBg icon-jiantou"></span>
                    </a>
                </li>
            </ul>

            <ul class="mod-list mod-list-sample mine-mod-list bottom1">
                
                <li class="height">
                    <a class="goCash buttn test" href="<?php echo U('User/capital');?>" data-url="account/detail.html?type=1">
                        <span class="leftBg icon-xianjin"></span>
                        <span>资金明细</span>
                        <span class="rightBg icon-jiantou"></span>
                    </a>
                </li>
            </ul>
    
    
    
            <?php if($trade == 1): ?><ul class="mod-list mod-list-sample mine-mod-list">

	                <li class="height">
	                    <a class="goCash buttn" href="<?php echo U('User/simulation');?>" data-url="account/detail.html?type=2">
	                        <span class="leftBg icon-mingxi"></span>
	                        <span>模拟明细</span>
	                        <span class="rightBg icon-jiantou"></span>
	                    </a>
	                </li>
            	</ul><?php endif; ?>
 
            
            <!-- 列表2 -->
            <ul class="mod-list mod-list-sample mine-mod-list">
                <li class="height">
                    <a class="goDetail buttn" href="<?php echo U('User/personal');?>" data-href="mine/profile.html">
                        <span class="leftBg icon-geren"></span>
                         <span>个人信息</span>
                        <span class="rightBg icon-jiantou"></span>
                    </a>
                </li>
            </ul>
            <ul class="mod-list mod-list-sample mine-mod-list">
                <li class="height">
                <?php if(($userinfo['code']) == ""): ?><a class="goDetail buttn" id="extension">
                    <?php else: ?>
                       <a class="goDetail buttn" href="<?php echo U('User/extension');?>"><?php endif; ?>
                        <span class="leftBg icon-xinshou"></span>
                         <span>推广赚钱</span>
                        <span class="rightBg icon-jiantou"></span>
                    </a>
                </li>
            </ul>

            <ul class="mod-list mod-list-sample mine-mod-list last1">
                <li class="height">
                    <a class="goDetail buttn" href="<?php echo U('Register/logout');?>" data-href="mine/profile.html">
                        <span class="leftBg icon-geren"></span>
                         <span>退出登陆</span>
                        <span class="rightBg icon-jiantou"></span>
                    </a>
                </li>
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

</div>


<script type="text/javascript">

</script>
</body>
</html>

<script type="text/javascript">
      
     $("#extension").click(function(){

         //询问框
          layer.open({
            content: '你确定要成为推广者吗'
            ,btn: ['是的', '不要']
            ,yes: function(index){
                  // location.reload();
                    $.ajax({
                            url:"<?php echo U('User/ExtensionIs');?>",
                            dataType: 'json',
                            type: 'get',
                            success:function(data){

                                    if(data.code == 1){

                                        window.location="<?php echo U('User/extension');?>";
                 
                                    } else{
                                        
                                        layer.open({
                                            content: '失败了，请稍候再试'
                                            ,skin: 'msg'
                                            ,time: 2 
                                          }); 
                                    }

                            }
                    });
            }
          });
            
});

</script>