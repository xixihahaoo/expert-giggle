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
        
    <link href="/Public/Admin/css/bootstrap/bootstrap-switch.css" type="text/css" rel="stylesheet" />
    <link href="/Public/Admin/css/bootstrap/highlight.css" type="text/css" rel="stylesheet" />

	<!-- this page specific styles -->
	<link rel="stylesheet" href="/Public/css/public.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/Public/Admin/css/compiled/article.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/layerui/css/layui.css">

    <style>
        .layui-layer-dialog .layui-layer-content {
            position: relative;
            padding: 20px;
            line-height: 24px;
            word-break: break-all;
            overflow: hidden;
            font-size: 14px;
            overflow-x: hidden;
            overflow-y: auto;
        }
    </style>
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header head2">
                <h3><?php if($posiname): echo ($posiname["name"]); else: ?>产品管理<?php endif; ?>&nbsp;>&nbsp;产品列表</h3>

            </div>
            <div class="row-fluid header">
                <form  action="<?php echo U('Goods/gdel');?>" method="post" name="del">
                <div class="row-fluid table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="span1 sortable">
                                    <!--<input type="checkbox">-->
                                    编号
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>商品名称(商品代码)
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>是否允许交易
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>当前交易状态
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>当前持仓状态
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>品种价格
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>单位波动金额（单位）
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>货币单位
                                </th>
<!--                                 <th class="span2 sortable">
                                    <span class="line"></span>1手手续费
                                </th> -->
                                <th class="span3 sortable">
                                    <span class="line"></span>止盈列表
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>止损列表
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>止损保证金
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>今开/昨收
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>交易时间
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>所属分类
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>商品玩法
                                </th>

                                <th class="span3 sortable">
                                    <span class="line"></span>保留小数
                                </th>

                                <th class="span3 sortable">
                                    <span class="line"></span>排序
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>产品编号
                                </th>
                            </tr>
                        </thead>
                        <tbody id="ajaxback">
                        <?php if(is_array($optionRs)): $i = 0; $__LIST__ = $optionRs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><!-- row -->
                        <tr class="first">
                            <td>
                                <?php echo ($v['id']); ?>
                            </td>
                            <td>
                                <a href="#" class="name"><?php echo ($v['capital_name']); ?><br>(<?php echo ($v['capital_key']); ?>)</a>
                            </td>
                            <td>
                                <p id="deal_status_opt_<?php echo ($v['id']); ?>">
                                    <input class="class_deal_status"  name="deal_status" data-option-id="<?php echo ($v['id']); ?>" type="checkbox" <?php echo ($v['deal_status_check']); ?> data-size="mini">
                                </p>
                            </td>
                            <td>
                                <b class="<?php echo ($v['deal_status_style']); ?>"><?php echo ($v['deal_status']); ?></b>
                            </td>
                            <td>
                                <b class="<?php echo ($v['sell_status_style']); ?>"><?php echo ($v['sell_status']); ?></b>                       
                            </td>
                            <td>
                                 <a class="layui-btn layui-btn-normal layui-btn-radius capital_dot_length" onclick="edit(<?php echo ($v['id']); ?>,'capital_dot_length','品种价格')"><?php echo ($v['capital_dot_length']); ?></a>
                            </td>
                            <td>
                                <a class="layui-btn layui-btn-normal layui-btn-radius wave" onclick="edit(<?php echo ($v['id']); ?>,'wave','波动金额')"><?php echo ($v['wave']); ?></a>
                            </td>
                            <td>
                                <?php echo ($v['currency_v1']); ?>(<?php echo ($v['currency_v']); ?>)
                            </td>
<!--                             <td>
                                <a class="layui-btn layui-btn-normal layui-btn-radius fee" onclick="edit(<?php echo ($v['id']); ?>,'CounterFee','手续费')"><?php echo ($v['fee']); ?></a>
                            </td> -->
                            <td>
                                <div style="display:inline-block;float:left;color: green;font-weight: bold;">
                                    <?php echo ($deal[$v['id']]['stop_profit']); ?>
                                </div>
                                <div style="display:inline-block;float:left;margin-left:2rem;margin-top: 1rem;">
                                    <ul class="actions">
                                        <li style="border: 0;">
                                            <a class="stop_profit" href="#" data-id="<?php echo ($v['id']); ?>"><i class="table-edit"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div style="display:inline-block;float:left;color: green;font-weight: bold;">
                                    <?php echo ($deal[$v['id']]['Stop_loss']); ?>
                                </div>

                                <div style="display:inline-block;float:left;margin-left:2rem;margin-top: 1rem;">
                                    <ul class="actions">
                                        <li style="border: 0;">
                                            <a class="stop_edit" href="#" data-id="<?php echo ($v['id']); ?>"><i class="table-edit"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <a class="layui-btn layui-btn-normal layui-btn-radius profit" onclick="edit(<?php echo ($v['id']); ?>,'Bond','止损保证金')"><?php echo ($v['Bond']); ?></a>
                            </td>
                            <td>
                                <b class="<?php echo ($v['style_color']); ?>"><?php echo ($v['Open']); ?></b>/<?php echo ($v['Close']); ?>
                            </td>
                            <td>
                                <div style="display:inline-block;float:left;">
                                    <?php echo ($dealTimeRs1[$v['id']]['deal_time']); ?>
                                </div>
                                <div style="display:inline-block;float:left;margin-left:20px;">
                                    <ul class="actions">
                                        <li style="border: 0;">
                                            <a class="option_time_edit" href="#" data-id="<?php echo ($v['id']); ?>"><i class="table-edit"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                 <?php echo ($class[$v['pid']]['name']); ?>
                            </td>
                            <td>
                                 <a class="layui-btn layui-btn-normal layui-btn-radius take" data-id="<?php echo ($v['id']); ?>">商品玩法</a>
                            </td>

                            <td>
                                <a class="layui-btn layui-btn-normal layui-btn-radius capital_length" onclick="edit(<?php echo ($v['id']); ?>,'capital_length','保留小数点')"><?php echo ($v['capital_length']); ?></a>
                            </td>


                            <td>
                                <a class="layui-btn layui-btn-normal layui-btn-radius sort" onclick="edit(<?php echo ($v['id']); ?>,'sort','产品排序')"><?php echo ($v['sort']); ?></a>
                            </td>

                            <td>
                                <a class="layui-btn layui-btn-normal layui-btn-radius hs_code" onclick="edit(<?php echo ($v['id']); ?>,'hs_code','产品编号')"><?php echo ($v['hs_code']); ?></a>
                            </td>

                            <!--td>
                                <ul class="actions">
                                    <li style="border: 0;"><a href="<?php echo U('Goods/gedit',array('pid'=>$v['id']));?>"><i class="table-edit"></i></a></li>
                                    <!--<li class="last"><a href="<?php echo U('Goods/gdel',array('pid'=>$gl['pid']));?>" onclick="if(confirm('确定要删除吗?')){return true;}else{return false;}"><i class="table-delete"></i></a></li>
                                </ul>
                            </td-->
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>

                </div>

                </form>
            </div>

            <!-- end users table -->
        </div>
    </div>
</div>
<!-- end main container -->


<!-- scripts -->
<script src="/Public/Admin/js/jquery-latest.js"></script>
<script src="/Public/Admin/js/bootstrap.min.js"></script>
<script src="/Public/Admin/css/bootstrap/highlight.js"></script>
<script src="/Public/Admin/css/bootstrap/bootstrap-switch.js"></script>

<script src="/Public/Admin/js/theme.js"></script>
<script type="text/javascript" src="/Public/Js/layer/layer.js"></script>
<script type="text/javascript">  

</script>
<script type="text/javascript">
$(document).ready(function(){
    $('[name="deal_status"]').bootstrapSwitch({
        onText:"交易开启",
        offText:"交易关闭",
        onSwitchChange:function(event, state){
            if(state == true)
                flag = 1;
            else
                flag = 0;

            $.ajax({
                type: "post",
                url: "<?php echo U('Goods/opt_deal_status');?>",
                data:{'flag' : flag, 'option_id' : $(this).attr('data-option-id')},
                success: function(data) {
                    console.log(data.status);
                    if(data.status == 1)
                    {
                        layer.open({
                            content: data.ret_msg,
                            btn: '确定',
                            yes: function(index, layero){
                                layer.close(index);
                                top.location.reload();
                            }
                        });
                    }
                    else
                    {
                        layer.open({
                            content: '操作失败，请重新操作',
                            btn: '确定',
                            yes: function(index, layero){
                                layer.close(index);
                                top.location.reload();
                            }
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    });


    $('.option_time_edit').click(function(){
        layer.open({
            type: 2,
            area: ['700px', '530px'],
            fixed: true, //不固定
            maxmin: true,
            title: "商品交易时间设置",
            content: ["<?php echo U('Goods/good_time_edit');?>?option_id="+$(this).attr('data-id'), 'no'],
            end: function () {
                top.location.reload();
            }

        });

    });

    $(".stop_edit").click(function(){

        layer.open({
            type: 2,
            area: ['500px', '500px'],
            fixed: true, //不固定
            maxmin: true,
            title: "商品止损金额设置",
            content: ["<?php echo U('Goods/good_stop');?>?option_id="+$(this).attr('data-id'), 'no'],
            end: function () {
                top.location.reload();
            }

        });
    });
     
    $(".stop_profit").click(function(){

        layer.open({
            type: 2,
            area: ['500px', '500px'],
            fixed: true, //不固定
            maxmin: true,
            title: "商品止盈金额设置",
            content: ["<?php echo U('Goods/good_profit');?>?option_id="+$(this).attr('data-id'), 'no'],
            end: function () {
                top.location.reload();
            }

        });
    });

   //商品玩法
    $(".take").click(function(){

        layer.open({
            type: 2,
            area: ['600px', '500px'],
            fixed: true, //不固定
            maxmin: true,
            title: "商品玩法",
            content: ["<?php echo U('Goods/take');?>?option_id="+$(this).attr('data-id'), 'no'],
            end: function () {
                //top.location.reload();
            }

        });
    });



});

function edit(option_id,field,msg){

 layer.prompt({title: '请输入要修改的'+msg+'', formType: 0}, function(pass, index){
    layer.close(index);

           $.ajax({
                type: "post",
                url: "<?php echo U('Goods/good_fee');?>",
                data:{'option_id' : option_id,'pass' : pass,'field' : field},
                success: function(data) {
                    console.log(data.status);
                    if(data.status == 1)
                    {
                        layer.open({
                            content: data.msg,
                            btn: '确定',
                            yes: function(index, layero){
                                layer.close(index);
                                top.location.reload();
                            }
                        });
                    }
                    else
                    {
                        layer.open({
                            content: data.msg,
                            btn: '确定',
                            yes: function(index, layero){
                                layer.close(index);
                                top.location.reload();
                            }
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });

   });
}
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var eqli = $("#dashboard-menu").children().eq(2);
        eqli.attr('class','active');
        $("#dashboard-menu .active .submenu").css("display","block");
    });
</script>

    </div>
    <script type="text/javascript">
        var wid = $(window).height();
        document.writeln('<div id="popupLayer" style="position:absolute;z-index:2;width:100%;height:'+wid+'px;left:0;top:0;opacity:0.3;filter:Alpha(opacity=30);background:#000;display: none;"></div>');
    </script>
</body>
</html>