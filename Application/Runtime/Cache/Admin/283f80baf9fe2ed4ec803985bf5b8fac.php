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
    <link rel="stylesheet" href="/Public/Admin/css/compiled/user-list.css" type="text/css" media="screen">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/layerui/css/layui.css">
    <script src="/Public/Admin/js/theme.js"></script>
    <script type="text/javascript" src="/Public/Js/layer/layer.js"></script>

    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header" style="margin-bottom: 10px">
                <form id="form1" action="/admin/agent/index" method="get">
                    <h3 style="height: 40px; width: 100%;font-size: 24px;">机构列表</h3>
                    <div class="span10 pull-left">
                        <div class="tpsearch" style="width: 20%">
                            运营中心：<select name="uid" id="uid" class="span7">
                            <option value="">默认不选</option>
                            <?php if(is_array($extends)): foreach($extends as $key=>$vo): if($uid == $vo['uid']){ ?>
                                <option value="<?php echo ($vo["uid"]); ?>" selected><?php echo ($vo["username"]); ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo ($vo["uid"]); ?>"><?php echo ($vo["username"]); ?></option>
                                <?php } endforeach; endif; ?>
                        </select>
                        </div>
                        <div class="tpsearch" style="width: 20%">
                            手机号：<input type="text" class="span6 search" value="<?php echo ($phone); ?>" placeholder="请输入手机号" name="phone" id="phone"/>
                        </div>
                        <div class="tpsearch"  style="width: 20%">
                            用户名称：<input type="text" value="<?php echo ($username); ?>" class="span6 search" placeholder="请输入用户名称查找..." name="username" id="username"/>
                        </div>

                    </div>
                    <div class="tpsearch" style="width:12%;float:right">
                        <a href="javascript:void(0)" class="btn-flat info" id="submit">开始查找</a>
                        <a href="javascript:void(0)" class="btn-flat info" id="daochu">查找导出</a>
                    </div>
                </form>
            </div>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span1 sortable">
                            编号
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>用户名
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>手机号
                        </th>
                        <!--                                 <th class="span2 sortable">
                                                        <span class="line"></span>域名
                                                        </th> -->
                        <th class="span2 sortable">
                            <span class="line"></span>注册时间
                        </th>

                        <!--                           <th class="span2 sortable">
                                                           <span class="line"></span>余额
                                                       </th> -->
                        <th class="span2 sortable">
                            <span class="line"></span>所属运营中心
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>操作
                        </th>
                    </tr>
                    </thead>
                    <tbody id="ajaxback">
                    <?php if(is_array($agent)): $i = 0; $__LIST__ = $agent;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ult): $mod = ($i % 2 );++$i;?><!-- row -->
                        <tr class="first">
                            <td>
                                <?php echo ($ult['uid']); ?>
                            </td>
                            <td>
                                <a href="javascript:void(0)"  style="color: red;" onclick="showdetail(<?php echo ($ult['uid']); ?>)" title="查看资金详情"><?php echo ($ult['username']); ?></a>
                                <?php if($ult['is_default'] == '1' ): ?><font style="color: red;font-size: 8px;">(默认)</font><?php endif; ?>
                            </td>
                            <td>
                                <?php echo ($ult['utel']); ?>
                            </td>
                            <td>
                                <?php echo (date('Y-m-d H:i:s',$ult["utime"])); ?>
                            </td>

                            <td>
                                <?php echo ($user[$ult['parent_user_id']]['name']); ?>
                            </td>

                            <td>
                                <a href="<?php echo U('user/resetpwd/',array('uid'=>$ult['uid']));?>" class="layui-btn layui-btn-normal layui-btn-mini">重置密码</a>
                                <a  class="del layui-btn layui-btn-mini layui-btn-danger"  data-id="<?php echo ($ult['uid']); ?>">删除</a>
                            </td>

                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <div class="qjcz">
                    <span style="margin-right:30px;float:right">总机构：<i style="color:red"><?php echo ($count); ?>个</i><br></span>
                </div>
            </div>
            <div class="pagination pull-right">
                <ul>
                    <?php echo ($page); ?>
                </ul>
            </div>
            <!-- end users table -->
        </div>


    <!--运营上详情界面 the template of the showdetail-->
    <div style="display:none;" id="showdetail">
        <div class="container-fluid">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row"  style="margin-left:0;">
                <div class="col-md-6">
                    <h2>交易信息统计</h2>

                    <table class="special_table_border table table-striped table-bordered" style="text-align:center;">
                        <tbody>
                        <tr>
                            <td class="center hidden-xs specla_background_class">
                                <h5>订单总数</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>订单总金额</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>总盈亏</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>总手续费</h5>
                            </td>
                            <td class="center specla_background_class">
                                <h5>用户推广总佣金</h5>
                            </td>
                        </tr>
                        <tr>
                            <td id="show_order_total"></td>
                            <td id="show_order_count"></td>
                            <td id="show_order_money"></td>
                            <td id="show_order_fee"></td>
                            <td id="show_order_commission"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row"  style="margin-left:0;">
                <div class="col-md-6">
                    <h3 class="header smaller lighter blue">用户信息统计</h3>

                    <table class="special_table_border table table-striped table-bordered">

                        <tbody>
                        <tr>
                            <td class="center specla_background_class">
                                <h5>用户总数</h5>
                            </td>
                        </tr>
                        <tr>
                            <td id="show_user_total"></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- PAGE CONTENT ENDS -->
        </div>
    </div>
    <!-- scripts -->
    <script src="/Public/Admin/js/jquery-latest.js"></script>
    <script src="/Public/Admin/js/bootstrap.min.js"></script>
    <script src="/Public/Admin/js/bootstrap.datepicker.js"></script>
    <script src="/Public/Admin/js/theme.js"></script>
    <script type="text/javascript" src="/Public/Js/layer/layer.js"></script>
    <script type="text/javascript">

            $('#daochu').click(function(){
                $('#form1').attr("action","/admin/agent/daochu");
                $('#form1').submit();
            });

            $('#submit').click(function(){
                $('#form1').attr("action","/admin/agent/index");
                $('#form1').submit();
            });


        $(".del").click(function(){

            var uid = $(this).attr('data-id');

            //询问框
            layer.open({
                content: '您确定要删除吗？'
                ,btn: ['确定', '不要']
                ,yes: function(index){

                    $.ajax({
                        url:"<?php echo U('agent_del');?>",
                        type:"post",
                        dataType:"json",
                        data:"uid="+uid+"",
                        success:function(data){
                            if(data.status === 0){

                                layer.msg(data.msg);
                                return false;
                            } else {

                                layer.msg(data.msg);
                                top.location.reload();
                                return false;
                            }

                        }
                    });
                    layer.close(index);
                }
            });

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            var eqli = $("#dashboard-menu").children().eq(8);
            eqli.attr('class','active');
            $("#dashboard-menu .active .submenu").css("display","block");
        }


    </script>

    <script type="text/javascript">

        $(".profit").click(function(){

            var  uid = $(this).attr('data_id');

            layer.prompt({title: '请输入要修改的金额', formType: 0}, function(pass, index){
                layer.close(index);

                $.ajax({
                    type: "post",
                    url: "<?php echo U('Operate/balance');?>",
                    data:{'uid' : uid,'balance': pass},
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

        });
        $(".s_domain").click(function(){

            var  uid = $(this).attr('data_id');

            layer.prompt({title: '请输入要修改的二级域名', formType: 0}, function(pass, index){
                layer.close(index);

                $.ajax({
                    type: "post",
                    url: "<?php echo U('edit');?>",
                    data:{'uid' : uid,'s_domain': pass},
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

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            var eqli = $("#dashboard-menu").children().eq(11);
            eqli.attr('class','active');
            $("#dashboard-menu .active .submenu").css("display","block");
        });

        //展示指定机构资金详情
        function showdetail(uid){
            if(uid == ''){
                layer.msg('用户id不存在');
            }else{
                $.ajax({
                    type: "post",
                    url: "<?php echo U('show');?>",
                    data: {'uid': uid},
                    success: function(data){
                        $("#show_account").html('<strong>&yen;'+data.data.account+'</strong>');
                        $("#show_order_total").html('<strong>&yen;'+data.data.order_total+'</strong>');
                        $("#show_order_count").html('<strong>&yen;'+data.data.total_count+'</strong>');
                        $("#show_order_money").html('<strong>&yen;'+data.data.total_money+'</strong>');
                        $("#show_order_fee").html('<strong>&yen;'+data.data.total_fee+'</strong>');
                        $("#show_user_total").html('<strong>'+data.data.user_total+' 个</strong>');
                        $("#show_order_commission").html('<strong>&yen'+data.data.total_commission+'</strong>');
                        layer.open({
                            type: 1,
                            shadeClose: true,
                            title: '<strong>'+data.data.username+'</strong> 的资金统计',
                            area: ['800px', '300px'],
                            content: $('#showdetail') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                        });
                    }
                });
            }
        }
    </script>

    </div>
    <script type="text/javascript">
        var wid = $(window).height();
        document.writeln('<div id="popupLayer" style="position:absolute;z-index:2;width:100%;height:'+wid+'px;left:0;top:0;opacity:0.3;filter:Alpha(opacity=30);background:#000;display: none;"></div>');
    </script>
</body>
</html>