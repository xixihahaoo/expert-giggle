<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>运营中心后台</title>
    <meta name="keywords" content="运营中心后台管理系统" />
    <meta name="description" content="运营中心后台管理系统" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    <link href="/Public/Ucenter/proxy/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/Public/Ucenter/proxy/assets/css/font-awesome.min.css" />

    <!--[if IE 7]>
    <link rel="stylesheet" href="/Public/Ucenter/proxy/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!-- page specific plugin styles -->

    <!-- fonts

    <link rel="stylesheet" href="/Public/Ucenter/proxy/assets\css\cyrillic.css" />
-->
    <!-- ace styles -->

    <link rel="stylesheet" href="/Public/Ucenter/proxy/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/Public/Ucenter/proxy/assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="/Public/Ucenter/proxy/assets/css/ace-skins.min.css" />

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/Public/Ucenter/proxy/assets/css/ace-ie.min.css" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->

    <script src="/Public/Ucenter/proxy/assets/js/ace-extra.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="/Public/Ucenter/proxy/assets/js/html5shiv.js"></script>
    <script src="/Public/Ucenter/proxy/assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>
                    <i class="icon-leaf"></i>
                    运营中心管理后台
                </small>
            </a><!-- /.brand -->
        </div><!-- /.navbar-header -->

        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="/Public/Ucenter/proxy/assets/avatars/user.jpg" alt="Jason's Photo" />
                        <span class="user-info">
                            <small>欢迎光临,</small><?php echo ($user_nickname); ?>
                        </span>
                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="<?php echo U('Ucenter/Proxyf/sys_info');?>">
                                <i class="icon-cog"></i>
                                个人资料
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo U('Ucenter/Proxyf/change_password');?>">
                                <i class="icon-user"></i>
                                修改密码
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="<?php echo U('Admin/User/signinout');?>">
                                <i class="icon-off"></i>
                                安全退出
                            </a>
                        </li>
                    </ul>
                </li>
            </ul><!-- /.ace-nav -->
        </div><!-- /.navbar-header -->
    </div><!-- /.container -->
</div>
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>
<div class="main-container-inner">
    <a class="menu-toggler" id="menu-toggler" href="#">
        <span class="menu-text"></span>
    </a>

    <div class="sidebar" id="sidebar">
        <script type="text/javascript">
            try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
        </script>

        <!--div class="sidebar-shortcuts" id="sidebar-shortcuts">
            <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                <button class="btn btn-success">
                    <i class="icon-signal"></i>
                </button>

                <button class="btn btn-info">
                    <i class="icon-pencil"></i>
                </button>

                <button class="btn btn-warning">
                    <i class="icon-group"></i>
                </button>

                <button class="btn btn-danger">
                    <i class="icon-cogs"></i>
                </button>
            </div>
        </div><!-- #sidebar-shortcuts -->

        <ul class="nav nav-list">
            <li <?php if(($nowMenu == 'indexf') and ($nowAct == 'index')): ?>class="active"<?php endif; ?>>
                <a href="<?php echo U('indexf/index');?>">
                    <i class="icon-dashboard"></i>
                    <span class="menu-text"> 控制台 </span>
                </a>
            </li>

            <!-- 机构 -->
            <li <?php if(($nowMenu == 'agentf')): ?>class="active open"<?php endif; ?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-user"></i>
                <span class="menu-text">机构管理</span>

                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li <?php if($nowAct == 'agent_list'): ?>class="active"<?php endif; ?>>
                <a href="/Ucenter/agentf/agent_list">
                    <i class="icon-double-angle-right"></i>
                    机构列表
                </a>
                </li>

                <li <?php if($nowAct == 'add_agent'): ?>class="active"<?php endif; ?>>
                <a href="/Ucenter/agentf/add_agent">
                    <i class="icon-double-angle-right"></i>
                    增加机构
                </a>
                </li>
            </ul>
            </li>

            <!-- 用户 -->
            <li <?php if(($nowMenu == 'userf')): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-group"></i>
                    <span class="menu-text">用户管理</span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if(($nowAct == 'user_list') or ($nowAct == 'user_detail')): ?>class="active"<?php endif; ?>>
                        <a href="/Ucenter/userf/user_list">
                            <i class="icon-double-angle-right"></i>
                            用户列表
                        </a>
                    </li>
                    <li <?php if(($nowAct == 'withdrawal')): ?>class="active"<?php endif; ?>>
                        <a href="/Ucenter/userf/withdrawal">
                            <i class="icon-double-angle-right"></i>
                            提现申请
                        </a>
                    </li>
                    <li <?php if(($nowAct == 'money_flow') or ($nowAct == 'money_flow')): ?>class="active"<?php endif; ?>>
                        <a href="/Ucenter/userf/money_flow">
                            <i class="icon-double-angle-right"></i>
                            用户资金流水
                        </a>
                    </li>
                </ul>
            </li>

            <!-- 订单 -->
            <li <?php if($nowMenu == 'cashorderf' ): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-hdd"></i>
                    <span class="menu-text"> 订单管理 </span>
                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'cash_list' ): ?>class="active"<?php endif; ?>>
                        <a href="/Ucenter/cashorderf/cash_list">
                            <i class="icon-double-angle-right"></i>
                            现金订单
                        </a>
                    </li>
                    <li <?php if($nowAct == 'order_list_gold' ): ?>class="active"<?php endif; ?>>
                        <a href="/Ucenter/cashorderf/order_list_gold">
                            <i class="icon-double-angle-right"></i>
                            积分订单
                        </a>
                    </li>
                </ul>
            </li>

            <!-- 商品管理 -->
            <li <?php if($nowMenu == 'productf' ): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-leaf"></i>
                    <span class="menu-text"> 商品管理 </span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'product_list'): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/productf/product_list">
                        <i class="icon-double-angle-right"></i>
                        商品列表
                    </a>
                    </li>
                </ul>
            </li>

            <!-- 系统管理 -->
            <li <?php if($nowMenu == 'relshipf' ): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-cog"></i>
                    <span class="menu-text"> 推广管理 </span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'relship_commission_list' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/relshipf/relship_commission_list">
                        <i class="icon-double-angle-right"></i>
                        佣金流水
                    </a>
                    </li>
                    <li <?php if($nowAct == 'relship_list' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/relshipf/relship_list">
                        <i class="icon-double-angle-right"></i>
                        推广员列表
                    </a>
                    </li>
                </ul>
            </li>

            <!-- 用户 -->
            <li <?php if(($nowMenu == 'proxyf')): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-group"></i>
                    <span class="menu-text">系统配置</span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'sys_info' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/proxyf/sys_info">
                        <i class="icon-double-angle-right"></i>
                        系统信息
                    </a>
                    </li>
                    <li <?php if(($nowAct == 'proxy_system_detail') or ($nowAct == 'weixin_img') ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/proxyf/proxy_system_detail">
                        <i class="icon-double-angle-right"></i>
                        公众号二维码
                    </a>
                    </li>
                    <li <?php if($nowAct == 'change_password' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/proxyf/change_password">
                        <i class="icon-double-angle-right"></i>
                        密码修改
                    </a>
                    </li>
                </ul>
            </li>
            
            <!-- 持仓管理 -->
            <li <?php if($nowMenu == 'positionf' ): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-cog"></i>
                    <span class="menu-text"> 持仓管理 </span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'tlist' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/positionf/tlist">
                        <i class="icon-double-angle-right"></i>
                        持仓监控
                    </a>
                    </li>
                </ul>
            </li>

            <!-- 资金流水 -->
            <li <?php if($nowMenu == 'flowf' ): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-cog"></i>
                    <span class="menu-text"> 运营资金账户 </span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'money_flow' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/flowf/money_flow">
                        <i class="icon-double-angle-right"></i>
                        资金流水
                    </a>
                    </li>
                    <li <?php if($nowAct == 'recharge' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/flowf/recharge">
                        <i class="icon-double-angle-right"></i>
                        充值记录
                    </a>
                    </li>
                    <li <?php if($nowAct == 'withdrawal' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/flowf/withdrawal">
                        <i class="icon-double-angle-right"></i>
                        提现记录
                    </a>
                    </li>
                </ul>
            </li>

            <!-- 出入金管理 -->
            <li <?php if($nowMenu == 'balancef' ): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-cog"></i>
                    <span class="menu-text"> 出入金管理 </span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li style="display:block;" <?php if($nowAct == 'recharge' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/balancef/recharge">
                        <i class="icon-double-angle-right"></i>
                        资金充值
                    </a>
                    </li>
                    <li <?php if($nowAct == 'withdrawal' ): ?>class="active"<?php endif; ?>>
                    <a href="/Ucenter/balancef/withdrawal">
                        <i class="icon-double-angle-right"></i>
                        资金提现
                    </a>
                    </li>
                </ul>
            </li>
        </ul><!-- /.nav-list -->

        <div class="sidebar-collapse" id="sidebar-collapse">
            <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
        </div>

        <script type="text/javascript">
            try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
        </script>
    </div>

    <div class="main-content">
        <!--div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>

            <ul class="breadcrumb">
                <li>
                    <i class="icon-home home-icon"></i>
                    <a href="#">首页</a>
                </li>
                <li class="active">控制台</li>
            </ul><!-- .breadcrumb -->
        <!--/div>
        <!--end breadcrumbs-->


<div class="page-content">
    <div class="page-header">
        <h1>
            我的机构
            <small>
                <i class="icon-double-angle-right"></i>
                机构列表
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->


            <div class="row">
                <div class="col-xs-12">

                    <div class="table-responsive">
                        <div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">

                            <form action="" method="post" id="search_form">
                            <div class="row" id="id_search_area">
                                <div class="col-sm-12">
                                    <div class="col-sm-2">
                                        <div class="dataTables_length" id="">
                                            <label>
                                                机构ID
                                                <input class="class_search_area" value="<?php echo ($agentId); ?>" aria-controls="sample-table-2" name="agent_id" data-type="agent_id" type="text">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="dataTables_length" id="">
                                            <label>
                                                机构昵称
                                                <input class="class_search_area" value="<?php echo ($agentName); ?>" aria-controls="sample-table-2" name="agent_name" data-type="agent_name" type="text">
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="hr hr-24"></div>
                                <div class="col-sm-12">
                                    <div class="dataTables_length" id="sample-table-2_length1">
                                        <label>
                                            <input type="button" id="id_submit" value="点击查询" class="btn btn-xs btn-info">
                                        </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label>
                                            <input type="button" id="id_reset" value="清空数据" class="btn btn-xs btn-info">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            </form>

                            <table id="sample-table-2" class="table table-striped table-bordered table-hover dataTable">
                                <thead>
                                <tr>
                                    <th class="center">机构id</th>
                                    <th>机构账户</th>
                                    <th>机构昵称</th>
                                    <th>机构姓名</th>
                                    <!--th>系统信息</th-->
                                    <th>资金帐户余额</th>
                                    <th>累计提现金额</th>
                                    <th>注册时间</th>
                                    <th>最后登陆</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php if(is_array($userInfo)): $i = 0; $__LIST__ = $userInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                                    <td class="center"><a target="_blank" href="<?php echo U('agent_detail');?>?agent_id=<?php echo ($v["uid"]); ?>"><?php echo ($v["uid"]); ?></a></td>
                                    <td><?php echo ($v["username"]); ?></td>
                                    <td><?php echo ($v["nickname"]); ?></td>
                                    <td><?php echo ($v["name"]); ?></td>
                                    <!--td>[<?php echo ($v["s_domain_name"]); ?>]&nbsp;<a href="<?php echo U('agent_system_detail');?>?agent_id=<?php echo ($v["uid"]); ?>"><?php echo ($v["domain_n"]); ?></a>&nbsp;<?php echo ($v["weixin_img"]); ?></td-->
                                    <td><?php echo ($v["money_remain"]); ?></td>
                                    <td><?php echo ($v["money_total"]); ?></td>
                                    <td><?php echo ($v["create_date"]); ?></td>
                                    <td><?php echo ($v["last_login"]); ?></td>
                                    <td><?php echo ($v["status_name"]); ?></td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                            <a href="#" data-id="<?php echo ($v['uid']); ?>" data-status="<?php echo ($v['status_s']); ?>" class="class_opt_status">
                                                <?php echo ($v["status_o"]); ?>
                                            </a>

                                            <a href="#" data-id="<?php echo ($v['uid']); ?>" data-status="" class="class_opt_info">
                                                编辑
                                            </a>

                                        </div>
                                    </td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="dataTables_info" id="sample-table-2_info">共<b class="orange"><?php echo ($totalCount); ?></b>，当前显示第 <b class="orange"><?php echo ($nowStart); ?></b>到<b class="orange"><?php echo ($nowEnd); ?></b></div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="dataTables_paginate paging_bootstrap">
                                        <ul class="pagination">
                                            <?php echo ($pageShow); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end id sample-table-2_wrapper-->
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
            <div class="space-20"></div>
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->



</div><!-- /.main-content -->
</div><!-- /.main-container-inner -->
<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="icon-double-angle-up icon-only bigger-110"></i>
</a>
</div><!-- /.main-container -->
<!-- basic scripts -->
<script src="/Public/Ucenter/proxy/assets\js\jquery-2.0.3.min.js"></script>

<!-- <![endif]-->

<!--[if IE]>
<script src="/Public/Ucenter/proxy/assets\js\jquery-1.10.2.min.js"></script>
<![endif]-->

<!--[if !IE]> -->

<script type="text/javascript">
    window.jQuery || document.write("<script src='/Public/Ucenter/proxy/assets/js/jquery-2.0.3.min.js'>"+"<"+"script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/Public/Ucenter/proxy/assets/js/jquery-1.10.2.min.js'>"+"<"+"script>");
</script>
<![endif]-->

<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='/Public/Ucenter/proxy/assets/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
</script>
<script src="/Public/Ucenter/proxy/assets/js/bootstrap.min.js"></script>
<script src="/Public/Ucenter/proxy/assets/js/typeahead-bs2.min.js"></script>


<!-- basic scripts -->

<!--[if !IE]> -->


<!-- page specific plugin scripts -->



<script type="text/javascript" src="/Public/Js/layer/layer.js"></script>


<!-- inline scripts related to this page -->
<script type="text/javascript">
    jQuery(function($) {

    });

    var arrayObj = new Array();

    $('#id_reset').bind('click', function(){
        $('#id_search_area').find('input.class_search_area').each(function(){
            $(this).val('');
        });
    });

    $('#id_submit').bind('click', function(){

//        var index = layer.load(0, {
//            shade: [0.7,'#000'] //0.1透明度的白色背景
//        });

        //alert($('#id_search_area').find('input.class_search_area').length);

        //alert(get_host());

        $('#id_search_area').find('input.class_search_area').each(function(){
            //alert($(this).attr('data-type') + $(this).val());
            if($(this).val() != ''){
                arrayObj.push($(this).attr('data-type') + '=' + $(this).val());
            }
        });

        //alert(get_host() + '?' + arrayObj[0]);

        if(arrayObj[0] != undefined){
            top.location.href = get_host() + '?' + arrayObj[0];
        }else{
            top.location.href = get_host();
        }


    });

    function get_host(){
        return window.location.protocol + '//' + window.location.host + window.location.pathname;
    }


    $('.class_opt_info').click(function(){
        layer.open({
            type: 2,
            area: ['780px', '530px'],
            fixed: true, //不固定
            maxmin: true,
            title: "编辑机构信息",
            content: ["<?php echo U('agentf/edit_agent');?>?user_id="+$(this).attr('data-id'), 'no'],
            end: function () {
                top.location.reload();
            }
        });
    });

//    $('.class_opt_img').click(function(){
//        layer.open({
//            type: 2,
//            area: ['780px', '530px'],
//            fixed: true, //不固定
//            maxmin: true,
//            title: "上传机构公众号二维码",
//            content: ["<?php echo U('agentf/upload_img');?>?user_id="+$(this).attr('data-id'), 'no'],
//            end: function () {
//                top.location.reload();
//            }
//        });
//    });


    $('.class_opt_status').click(function(){
        var user_id   = $(this).attr('data-id');
        var user_status   = $(this).attr('data-status');

        layer.confirm('确认修改该机构的状态吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                type: "post",
                url: "<?php echo U('agentf/opt_user_status');?>",
                data:{'user_id' : user_id, 'user_status' : user_status},
                success: function(data) {
                    //console.log(data.status);
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
                            content: data.ret_msg,
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

        }, function(){

        });
    });

</script>

<!-- ace scripts -->

<script src="/Public/Ucenter/proxy/assets/js/ace-elements.min.js"></script>
<script src="/Public/Ucenter/proxy/assets/js/ace.min.js"></script>
</body>
</html>