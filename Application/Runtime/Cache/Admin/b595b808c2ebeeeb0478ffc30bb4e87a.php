<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>鼎盛国际期货管理中心</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- bootstrap -->
    <link href="/Public/Admin/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="/Public/Admin/css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
    <link href="/Public/Admin/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="/Public/Admin/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/css/lib/font-awesome.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/layout.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/elements.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/icons.css" />
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>

    <!-- navbar -->
    <div class="navbar navbar-inverse">
        <div class="navbar-inner">
            <button type="button" class="btn btn-navbar visible-phone" id="menu-toggler">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            
            <!--a class="brand" href="index.html"><img src="/Public/Admin/img/logo.png" style="width:1.5em" /></a-->

            <ul class="nav pull-right">                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle hidden-phone" data-toggle="dropdown">
                        <?php echo ($_SESSION['username']); ?>
                        <b class="caret"></b>
                    </a>
                    <!--ul class="dropdown-menu">
                        <li><a href="<?php echo U('User/personalinfo');?>">个人信息</a></li>
                        <li><a href="<?php echo U('User/personalinfo');?>">账户设置</a></li>
                        <li><a href="<?php echo U('Order/olist');?>">查看订单</a></li>
                        <li><a href="<?php echo U('User/ulist');?>">查看客户</a></li>
                        <li><a href="<?php echo U('Goods/glist');?>">查看产品</a></li>
                    </ul-->
                </li>
                <!--li class="settings hidden-phone">
                    <a href="<?php echo U('User/personalinfo');?>" role="button">
                        <i class="icon-cog"></i>
                    </a>
                </li-->
                <li class="settings hidden-phone">
                    <a href="<?php echo U('Admin/User/signinout');?>" role="button">
                        <i class="icon-share-alt"></i>
                    </a>
                </li>
            </ul>            
        </div>
    </div>
    <!-- end navbar -->

    <!-- sidebar -->
    <div id="sidebar-nav">
        <ul id="dashboard-menu">
            <?php if($_SESSION['userotype']!= 1): ?><li>
                <div class="pointer">
                    <div class="arrow"></div>
                    <div class="arrow_border"></div>
                </div>
                <a href="<?php echo U('Admin/Index/index');?>">
                    <i class="icon-home"></i>
                    <span>系统首页</span>
                </a>
            </li><?php endif; ?>
            <?php if($_SESSION['userotype']!= 1): ?><li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-edit"></i>
                    <span>内容管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?php echo U('Admin/News/typelist');?>">栏目管理</a></li>
                    <li><a href="<?php echo U('Admin/News/newslist');?>">文章管理</a></li>
                    <!--<li><a href="user-profile.html">我发布的文档</a></li>-->
                    <!--<li><a href="user-profile.html">内容回收站</a></li>-->                   
                </ul>
            </li><?php endif; ?>
            <?php if($_SESSION['userotype']!= 1): ?><li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-calendar-empty"></i>
                    <span>产品管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <!--<li><a href="<?php echo U('Admin/Goods/gadd');?>">添加产品</a></li>-->
                    <li><a href="<?php echo U('Admin/Goods/goods_list');?>">产品列表</a></li>
                    <li><a href="<?php echo U('Admin/Goods/goods_classify');?>">产品分类</a></li>
                    <!--li><a href="<?php echo U('Admin/Goods/good_time_edit');?>">管理交易时间</a></li>
                    <!--<li><a href="<?php echo U('Admin/Goods/gtypeadd');?>">添加商品分类</a></li>
                    <li><a href="<?php echo U('Admin/Goods/gtype');?>">商品分类列表</a></li>-->
                    <!--<li><a href="user-profile.html">回收站</a></li>-->             
                </ul>
            </li><?php endif; ?>
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-th-large"></i>
                    <span>持仓管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?php echo U('Admin/Position/tlist');?>">持仓订单</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-th-large"></i>
                    <span>订单管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <!--li><a href="<?php echo U('Admin/Order/olist');?>">订单列表</a></li-->
                    <li><a href="<?php echo U('Admin/Order/tlist');?>">实盘交易流水</a></li>
                    <li><a href="<?php echo U('Admin/Order/moni');?>">模拟交易流水</a></li>
                    <!--<li><a href="<?php echo U('Admin/Order/blist');?>">充值提现流水</a></li>-->
                    <!--<li><a href="new-user.html">移除的订单</a></li>-->
                </ul>
            </li>

<!--             <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-th-large"></i>
                    <span>持仓订单</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?php echo U('Admin/Position/tlist');?>">实盘交易流水</a></li>
                    <li><a href="<?php echo U('Admin/Position/moni');?>">模拟交易流水</a></li>
                </ul>
            </li> -->
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-group"></i>
                    <span>客户管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?php echo U('User/adduser');?>">添加客户</a></li>
                    <li><a href="<?php echo U('User/ulist');?>">客户列表</a></li>
                    <li><a href="<?php echo U('User/chongzhi');?>">充值记录</a></li>
                    <li><a href="<?php echo U('User/withdrawal');?>">提现申请</a></li>
                    <li><a href="<?php echo U('User/money_flow');?>">资金流水</a></li>
                    <li><a href="<?php echo U('User/online_user');?>">在线用户</a></li>
                </ul>
            </li>

            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-picture"></i>
                    <span>佣金管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?php echo U('User/ExtensionList');?>">推广员列表</a></li>
                    <li><a href="<?php echo U('User/extension');?>">佣金转入记录</a></li>
                    <li><a href="<?php echo U('User/extension_water');?>">佣金流水</a></li>
<!--                     <li><a style="color: red;" href="<?php echo U('User/extension_water_old');?>">流水(旧数据)</a></li> -->
                </ul>
            </li>

            <?php if($_SESSION['userotype']!= 1): ?><!--li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-group"></i>
                    <span>会员管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?php echo U('Menber/madd');?>">添加会员</a></li>
                    <li><a href="<?php echo U('Menber/mlist');?>">会员列表</a></li>
                </ul>
            </li><?php endif; ?>
            <!--if condition="$Think.session.userotype != 1" >
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-picture"></i>
                    <span>优惠卷管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?php echo U('Coupons/cpadd');?>">添加优惠卷</a></li>
                    <li><a href="<?php echo U('Coupons/cplist',array('style'=>'list'));?>">优惠券列表</a></li>
                    <li><a href="<?php echo U('Coupons/cplist',array('style'=>'oldlist'));?>">历史优惠卷</a></li>
                </ul>
            </li>
            </if-->
            <?php if($_SESSION['userotype']!= 1): ?><li>
                <a class="dropdown-toggle" href="personal-info.html">
                    <i class="icon-code-fork"></i>
                    <span>系统管理员</span>
                    <i class="icon-chevron-down"></i>
                    <ul class="submenu">                        
                        <li><a href="<?php echo U('Super/sadd');?>">添加管理员</a></li>
                        <li><a href="<?php echo U('Super/slist');?>">管理员列表</a></li>
                        <?php if($_SESSION['username'] == 'admin_hu'): ?><li><a href="<?php echo U('Super/loginlog');?>">登录日志</a></li>
                        <li><a href="<?php echo U('Super/actionlog');?>">操作日志</a></li><?php endif; ?>
                        <!--<li><a href="grids.html">管理员组</a></li>-->
                    </ul>
                </a>
            </li><?php endif; ?>
            <?php if($_SESSION['userotype']!= 1): ?><li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-cog"></i>
                    <span>系统设置</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <!--li><a href="<?php echo U('Super/esystem');?>">基本设置</a></li>
                    <!--<li><a href="grids.html">清理缓存</a></li>>
                    <li><a href="<?php echo U('Super/backupdb');?>">数据备份</a></li-->
                    <li><a href="<?php echo U('Tools/basic');?>">基本设置</a></li>
                    <li><a href="<?php echo U('Tools/setting_list');?>">系统货币设置</a></li>
                    <li><a href="<?php echo U('Tools/product_sell_time');?>">系统平仓时间</a></li>
                    <li><a href="<?php echo U('Tools/commission_rate');?>">佣金比率设置</a></li>
                    <li><a href="<?php echo U('Tools/product_number');?>">用户交易手数</a></li>
                    <!--li><a href="signin.html">数据还原</a></li-->
                    <!--li><a href="<?php echo U('User/signinout');?>">退出系统</a></li-->
                </ul>
            </li>

            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-cog"></i>
                    <span>特别运营</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                     <li><a href="<?php echo U('Branch/index');?>">特别运营列表</a></li>
                    <li><a href="<?php echo U('Branch/add');?>">添加分部</a></li>
                </ul>
            </li>

            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-cog"></i>
                    <span>运营中心</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                     <li><a href="<?php echo U('Operate/index');?>">运营中心列表</a></li>
                    <li><a href="<?php echo U('Operate/add');?>">添加运营</a></li>
<!--                     <li><a href="<?php echo U('Operate/recharge');?>">充值记录</a></li>
                    <li><a href="<?php echo U('Operate/withdraw');?>">提现记录</a></li> -->
                    <li><a href="<?php echo U('Operate/flow');?>">资金流水</a></li>
                </ul>
            </li>
            
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-cog"></i>
                    <span>机构</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                     <li><a href="<?php echo U('Agent/index');?>">机构列表</a></li>
                 <!--    <li><a href="<?php echo U('Agent/add');?>">添加机构</a></li> -->
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-cog"></i>
                    <span>活动公告</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                     <li><a href="<?php echo U('stretch/index');?>">公告列表</a></li>
                 <!--    <li><a href="<?php echo U('Agent/add');?>">添加机构</a></li> -->
                </ul>
            </li><?php endif; ?>
            <!--if condition="$Think.session.userotype != 1" >
             <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-group"></i>
                    <span>微信管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?php echo U('Menber/wxinfo');?>">微信基本信息</a></li>
                    <li><a href="<?php echo U('Menber/wxlist');?>">微信用户列表</a></li>
                    <li><a href="<?php echo U('Menber/instruser');?>">更新微信用户</a></li>
                </ul>
            </li>
            </if-->
        </ul>
    </div>
    <!-- end sidebar -->


    <!-- main container -->
    <div class="content">

        <!-- settings changer -->
        <!--div class="skins-nav">
            <a href="#" class="skin first_nav selected">
                <span class="icon"></span><span class="text">默认颜色</span>
            </a>
            <a href="#" class="skin second_nav" data-file="/Public/Admin/css/skins/dark.css">
                <span class="icon"></span><span class="text">黑色背景</span>
            </a>
        </div-->
        
<!-- this page specific styles -->
<link rel="stylesheet" href="/Public/Admin/css/compiled/index.css" type="text/css" media="screen" />  
<div class="container-fluid">

    <!-- upper main stats -->
    <div id="main-stats">
        <div class="row-fluid stats-row">
            <div class="span3 stat last">
                <div class="data">
                    <span class="number"><?php echo ($extend_count); ?></span>
                    运营中心
                </div>
                <span class="date">截止<?php echo ($date); ?></span>
            </div>
          <div class="span3 stat last">
                <div class="data">
                    <span class="number"><?php echo ($agent_count); ?></span>
                    机构
                </div>
                <span class="date">截止<?php echo ($date); ?></span>
            </div>
            <div class="span3 stat last">
                <div class="data">
                    <span class="number"><?php echo ($user_count); ?></span>
                    用户
                </div>
                <span class="date">截止<?php echo ($date); ?></span>
            </div>
            <div class="span3 stat last">
                <div class="data">
                    <span class="number"><?php echo ($order_count); ?></span>
                    订单
                </div>
                <span class="date">最近7天</span>
            </div>
            <div class="span3 stat last">
                <div class="data">
                    <span class="number">￥<?php echo ($sum); ?></span>
                    交易总额
                </div>
                <span class="date">最近30天</span>
            </div>
            <div class="span3 stat last">
                <div class="data">
                    <span class="number">￥<?php echo ($balance); ?></span>
                    提现
                </div>
                <span class="date">最近30天</span>
            </div>
            <div class="span3 stat last">
                <div class="data">
                    <span class="number">￥<?php echo ($point); ?></span>
                    充值
                </div>
                <span class="date">最近30天</span>
            </div>
            
<!--             <div class="span3 stat last">
                <div class="data">
                    <span class="number">￥<?php echo ($exchange_rmb); ?></span>
                    交易所佣金
                </div>
                <span class="date">截止<?php echo ($date); ?></span>
            </div>

            <div class="span3 stat last">
                <div class="data">
                    <span class="number">￥<?php echo ($operate_rmb); ?></span>
                    运营中心佣金
                </div>
                <span class="date">截止<?php echo ($date); ?></span>
            </div>
            <div class="span3 stat last">
                <div class="data">
                    <span class="number">￥<?php echo ($sum_rmb); ?></span>
                    用户推广佣金
                </div>
                <span class="date">截止<?php echo ($date); ?></span>
            </div> -->

        </div>
    </div>
    <!-- end upper main stats -->

    <div id="pad-wrapper">

        <!-- statistics chart built with jQuery Flot -->
        <!--<div class="row-fluid chart">
            <h4>
                统计<small>Statistics</small>
                 <div class="btn-group pull-right">
                    <button class="glow left">今天</button>
                    <button class="glow middle active">本月</button>
                    <button class="glow right">今年</button>
                </div>
            </h4>
            <div class="span12">
                <div id="statsChart"></div>
            </div>
        </div>-->
        <!-- end statistics chart -->
        <!-- table sample -->
        <!-- the script for the toggle all checkboxes from header is located in js/theme.js -->
        <div class="table-products" style="padding-top: 0;">
            <div class="row-fluid head">
                <div class="span12">
                    <h4>今日交易记录 <small>Orders</small></h4>
                </div>
            </div>
            <div class="row-fluid">
                <table class="table table-hover">
                    <thead>
                        <tr>
                                <th class="span3 sortable">
                                    订单编号
                                </th>
								<th class="span3 sortable">
                                    <span class="line"></span>用户
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>订单时间
                                </th>
                                <th class="span4 sortable">
                                    <span class="line"></span>产品信息
                                </th>
								<th class="span2 sortable">
                                    <span class="line"></span>数量
                                </th>
								<th class="span2 sortable">
                                    <span class="line"></span>类型
                                </th>
								<th class="span2 sortable">
                                    <span class="line"></span>订单状态
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>买入点位
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>平仓点位
                                </th>
<!--                                 <th class="span2 sortable">
                                    <span class="line"></span>止盈
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>止损
                                </th> -->
								<th class="span3 sortable">
                                    <span class="line"></span>手续费
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>保证金
                                </th>
								<th class="span3 sortable">
                                    <span class="line"></span>出入金额
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>盈亏
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>用户余额
                                </th>
                            </tr>
                    </thead>
                    <tbody>
                    <!-- row -->
                    <?php if(is_array($orders)): $i = 0; $__LIST__ = $orders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="first">
							<td>
                                <?php echo ($vo["jno"]); ?>
                            </td>
                            <td>
                                <a href="<?php echo U('User/updateuser',array('uid'=>$vo['uid']));?>" class="name"><?php echo ($vo["username"]); ?></a>
                            </td>
                            <td>
                                <?php echo (date('Y-m-d H:i:s',$vo["jtime"])); ?>
                            </td>
                            <td>
								<?php echo ($vo["remarks"]); ?>
                            </td>
							<td>
                                <?php echo ($vo["number"]); ?>手
                            </td>
							<td>
								<?php if($vo["jostyle"] == 1): ?><span class="label label-success">买跌</span></span>
                            	<?php else: ?>
								<span class="label label-cc">买涨</span></span><?php endif; ?>
                            </td>
                            <td>
                               <?php if($vo['jtype'] == '建仓'): ?><span class="label label-success">建仓</span></span>
                                <?php else: ?>
                                <span class="label label-cc">平仓</span></span><?php endif; ?>
                            </td>
                            <td>
                                <font color="#f00" size="3"><?php echo ($vo['jbuyprice']); ?><font>
                            </td>
                            <td>
                                <font color="#f00" size="3"><?php echo ($vo['jsellprice']); ?><font>
                            </td>
<!--                             <td>
                                <font color="#f00" size="3">￥<?php echo ($vo['endprofit']); ?><font>
                            </td>
                            <td>
                                <font color="#f00" size="3">￥<?php echo ($vo['endloss']); ?><font>
                            </td> -->
							<td>
                                <font color="#f00" size="3">￥<?php echo ($vo['jfee']); ?><font>
                            </td>

                            <td>
                                <font color="#f00" size="4">￥<?php echo ($vo['juprice']); ?><font>
                            </td>

							<td>
                                <font color="#f00" size="4">￥<?php echo ($vo['jaccess']); ?><font>
                            </td>

                            <td>
                                <font color="#f00" size="4">￥<?php echo ($vo['jploss']); ?><font>
                            </td>
                            <td>
                                <font color="#f00" size="4">￥<?php echo ($vo['balance']); ?><font>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="pagination">
              <ul>
                    <?php echo ($page); ?>
              </ul>
            </div>
            <div>今日已有<font color="#f00" size="4"><?php echo ($day_count); ?></font>个<a href="<?php echo U('Order/olist');?>">订单</a>达成交易</div>
        </div>

    </div>
</div>
<!-- scripts -->
    <script src="/Public/Admin/js/jquery-latest.js"></script>
    <script src="/Public/Admin/js/bootstrap.min.js"></script>
    <script src="/Public/Admin/js/theme.js"></script>
    <script type="text/javascript">
		$(document).ready(function(){
			var eqli = $("#dashboard-menu").children().eq(0);
			eqli.attr('class','active');
			$("#dashboard-menu .active .submenu").css("display","block");
		});
	</script>
	<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?7dd4859c5b7803f341ea77ee786f33f9";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>


    </div>
    <script type="text/javascript">
        var wid = $(window).height();
        document.writeln('<div id="popupLayer" style="position:absolute;z-index:2;width:100%;height:'+wid+'px;left:0;top:0;opacity:0.3;filter:Alpha(opacity=30);background:#000;display: none;"></div>');
    </script>
</body>
</html>