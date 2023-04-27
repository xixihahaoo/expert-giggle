<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>特别运营后台</title>
    <meta name="keywords" content="运营中心分部后台" />
    <meta name="description" content="运营中心分部后台" />
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
                   特别运营管理后台
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
                            <a href="<?php echo U('Branch/Proxy/sys_info');?>">
                                <i class="icon-cog"></i>
                                个人资料
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo U('Branch/Proxy/change_password');?>">
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
            <li <?php if(($nowMenu == 'index') and ($nowAct == 'index')): ?>class="active"<?php endif; ?>>
                <a href="<?php echo U('index/index');?>">
                    <i class="icon-dashboard"></i>
                    <span class="menu-text"> 控制台 </span>
                </a>
            </li>

            <!-- 运营中心 -->
            <li <?php if(($nowMenu == 'operate')): ?>class="active open"<?php endif; ?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-user"></i>
                <span class="menu-text">运营中心</span>

                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li <?php if($nowAct == 'index'): ?>class="active"<?php endif; ?>>
                <a href="/Branch/Operate/index">
                    <i class="icon-double-angle-right"></i>
                    运营中心列表
                </a>
                </li>

                <li <?php if($nowAct == 'money_flow'): ?>class="active"<?php endif; ?>>
                <a href="/Branch/Operate/money_flow">
                    <i class="icon-double-angle-right"></i>
                    资金流水
                </a>
                </li>
            </ul>
            </li>

            <!-- 机构 -->
            <li <?php if(($nowMenu == 'agent')): ?>class="active open"<?php endif; ?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-user"></i>
                <span class="menu-text">机构管理</span>

                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li <?php if($nowAct == 'index'): ?>class="active"<?php endif; ?>>
                <a href="/Branch/agent/index">
                    <i class="icon-double-angle-right"></i>
                    机构列表
                </a>
                </li>
            </ul>
            </li>

            <!-- 用户 -->
            <li <?php if(($nowMenu == 'user')): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-group"></i>
                    <span class="menu-text">用户管理</span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if(($nowAct == 'user_list') or ($nowAct == 'user_detail')): ?>class="active"<?php endif; ?>>
                        <a href="/Branch/user/user_list">
                            <i class="icon-double-angle-right"></i>
                            用户列表
                        </a>
                    </li>
                    <li <?php if(($nowAct == 'money_flow') or ($nowAct == 'money_flow')): ?>class="active"<?php endif; ?>>
                        <a href="/Branch/user/money_flow">
                            <i class="icon-double-angle-right"></i>
                            用户资金流水
                        </a>
                    </li>
                </ul>
            </li>

            <!-- 订单 -->
            <li <?php if($nowMenu == 'order' ): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-hdd"></i>
                    <span class="menu-text"> 订单管理 </span>
                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'cash_list' ): ?>class="active"<?php endif; ?>>
                        <a href="/Branch/order/cash_list">
                            <i class="icon-double-angle-right"></i>
                            现金订单
                        </a>
                    </li>
                    <li <?php if($nowAct == 'order_list_gold' ): ?>class="active"<?php endif; ?>>
                        <a href="/Branch/order/order_list_gold">
                            <i class="icon-double-angle-right"></i>
                            积分订单
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
                    <a href="/Branch/positionf/tlist">
                        <i class="icon-double-angle-right"></i>
                        持仓监控
                    </a>
                    </li>
                </ul>
            </li>


            <!-- 系统管理 -->
            <li <?php if($nowMenu == 'relship' ): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-cog"></i>
                    <span class="menu-text"> 推广管理 </span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'relship_commission_list' ): ?>class="active"<?php endif; ?>>
                    <a href="/Branch/relship/relship_commission_list">
                        <i class="icon-double-angle-right"></i>
                        佣金流水
                    </a>
                    </li>
                    <li <?php if($nowAct == 'relship_list' ): ?>class="active"<?php endif; ?>>
                    <a href="/Branch/relship/relship_list">
                        <i class="icon-double-angle-right"></i>
                        推广员列表
                    </a>
                    </li>
                </ul>
            </li>

            <!-- 用户 -->
            <li <?php if(($nowMenu == 'proxy')): ?>class="active open"<?php endif; ?>>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-group"></i>
                    <span class="menu-text">系统配置</span>

                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li <?php if($nowAct == 'sys_info' ): ?>class="active"<?php endif; ?>>
                    <a href="/Branch/proxy/sys_info">
                        <i class="icon-double-angle-right"></i>
                        系统信息
                    </a>
                    </li>
                    <li <?php if($nowAct == 'change_password' ): ?>class="active"<?php endif; ?>>
                    <a href="/Branch/proxy/change_password">
                        <i class="icon-double-angle-right"></i>
                        密码修改
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
<link rel="stylesheet" type="text/css" href="/Public/Branch/css/layerui/css/layui.css">
<style type="text/css">
.dataTables_length span{color: red;}
td{text-align: center;}
#id_search_area>div>div>div{height: 70px}
</style>

<div class="page-content">
    <div class="page-header">
        <h1>
            运营中心管理
            <small>
                <i class="icon-double-angle-right"></i>
                运营中心资金流水
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-header">
                        用户列表&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="table-responsive">

                    <div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
                                                <form action="/Branch/Operate/money_flow" method="get" id="form1">
                            <input type="hidden" name="type" value="1">
                            <div class="row" id="id_search_area">
                                <div class="col-sm-9">
                                <div style=" width: 1350px; height: 100px;">

                                <div class="col-sm-2">
                                    <!-- <label>开始时间:</label> -->
                                    <?php if($time): ?><input class="layui-input input" style="width: 200px;" placeholder="开始时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo ($time['start_time']); ?>" name="start_time">
                                   <?php else: ?>
                                    <input class="layui-input input" style="width: 200px;" placeholder="开始时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="" name="start_time"><?php endif; ?>
                                </div>

                                <div class="col-sm-2">
                                 <!--    <label>结束时间:</label> -->
                                 <?php if($time): ?><input class="layui-input input" style="width: 200px;" placeholder="结束时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo ($time['end_time']); ?>" name="end_time">
                                <?php else: ?>
                                    <input class="layui-input input" style="width: 200px;" placeholder="结束时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="" name="end_time"><?php endif; ?>
                                </div>

                                    <div class="col-sm-2">
                                        <div class="dataTables_length" id="">
                                            <label>
                                                资金变动类型：<select name="type"  style="width: 100px;">
                                                <option value="" class="selected">默认不选</option>
                                                    <?php if($type == 2): ?><option value="2" selected>平仓</option>
                                                    <?php else: ?>
                                                    <option value="2">平仓</option><?php endif; ?>
                                                    <?php if($type == 3): ?><option value="3" selected>提现</option>
                                                    <?php else: ?>
                                                    <option value="3">提现</option><?php endif; ?>
                                                    <?php if($type == 4): ?><option value="4" selected>充值</option>
                                                    <?php else: ?>
                                                    <option value="4">充值</option><?php endif; ?>
                                                    <?php if($type == 5): ?><option value="5" selected>佣金转入</option>
                                                    <?php else: ?>
                                                    <option value="5">佣金转入</option><?php endif; ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="dataTables_length" id="">
                                            <label>
                                    操作人：<select name="operator" class="span7" id="option" style="width: 120px;">
                                                <option value="">默认不选</option>
                                                <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["uid"]); ?>"><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                            </label>
                                        </div>
                                        <input type="hidden" value="<?php echo ($operator); ?>" id="operator">
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="dataTables_length" id="">
                                            <label>
                                    运营中心：<select name="operate" class="span7 operate" style="width: 120px;">
                                                <option value="">默认不选</option>
                                                <?php if(is_array($operateData)): $i = 0; $__LIST__ = $operateData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["uid"]); ?>"><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                            </label>
                                        </div>
                                        <input type="hidden" value="<?php echo ($operate); ?>" id="operate">
                                    </div>

                                    </div>
                                </div>


                                <div class="hr hr-24"></div>
                                <div class="col-sm-12">
                                    <div class="dataTables_length" id="sample-table-2_length1">
                                        <label>
                                            <input type="button"  onclick="sub()" value="点击查询" class="btn btn-xs btn-info">
                                        </label>&nbsp;&nbsp;
                                        <label>
                                            <input type="button" onclick="daochu()" value="查找导出" class="btn btn-xs btn-info">
                                        </label>&nbsp;&nbsp;
                                        <label>
                                            <input type="button" id="id_reset" value="清空数据" class="btn btn-xs btn-info">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            </form>

                        <div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
                            <table id="sample-table-2" class="table table-striped table-bordered table-hover dataTable">
                                <thead>
                                <tr>
                                    <th class="center">编号id</th>
                                    <th class="center">用户姓名</th>
                                    <th class="center">手机号</th>
                                    <th class="center">资金变动描述</th>
                                    <th class="center">变动金额</th>
                                    <th class="center">用户余额</th>
                                    <th class="center">操作人</th>
                                    <th class="center">操作时间</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php if(is_array($flow)): $i = 0; $__LIST__ = $flow;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                                    <td class="center"><a target="_blank" style="color: #307ECC;" href="<?php echo U('user_detail');?>?user_id=<?php echo ($v["uid"]); ?>"><?php echo ($v["id"]); ?></a></td>
                                    <?php if($v['busername'] != ''): ?><td><?php echo ($v["busername"]); ?></td>
                                    <?php else: ?>
                                     <td><?php echo ($v["username"]); ?></td><?php endif; ?>
                                    <td><?php echo ($v["utel"]); ?></td>
                                    <td><?php echo ($v["note"]); ?></td>
                                    <td><?php echo ($v["account"]); ?></td>
                                    <td><?php echo ($v["balance"]); ?>元</td>
                                    <?php if($v['operator_busername'] != ''): ?><td><?php echo ($v["operator_busername"]); ?></td>
                                    <?php else: ?>
                                     <td><?php echo ($v["operator"]); ?></td><?php endif; ?>
                                    <td><?php echo (date('Y-m-d H:i:s',$v["dateline"])); ?></td>
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

                            <div class="col-sm-3">
                                <div class="dataTables_length" id="" style="width: 265px;">
                                    <label>
                                        <span>总变动金额: <?php echo ($sum); ?>元</span></br>
                                    </label>
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
<script type="text/javascript" src="/Public/Branch/css/layerui/layui.js"></script>


<!-- inline scripts related to this page -->
<script type="text/javascript">
    jQuery(function($) {

    });

    $('.class_opt_status').click(function(){
        var user_id   = $(this).attr('data-id');
        var user_status   = $(this).attr('data-status');

        layer.confirm('确认修改用户的状态吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                type: "post",
                url: "<?php echo U('userf/opt_user_status');?>",
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


var user_id = $("#jingji").val();
$("#jinjiren option").each(function(){
        if(user_id == $(this).val()){

             $(this).attr('selected',true);
        }
});

$("#id_reset").click(function(){
    
     $('.input').val("");
     $('.selected').attr('selected',true);
});


//日期选择时间
layui.use('laydate', function(){
  var laydate = layui.laydate;
});

function sub() {
    $('#form1').attr("action","/Branch/Operate/money_flow");
    $('#form1').submit();
}

function daochu() {
    $('#form1').attr("action","/Branch/Operate/flow_daochu");
    $('#form1').submit();
}

var uid = $("#operator").val();
$.each($('#option option'),function(){
    var id = $(this).val();
    if(uid == id)
    {
        $(this).attr('selected',true);
    }
});

var uid = $("#operate").val();
$.each($('.operate option'),function(){
    var id = $(this).val();
    if(uid == id)
    {
        $(this).attr('selected',true);
    }
});
</script>
<!-- ace scripts -->

<script src="/Public/Ucenter/proxy/assets/js/ace-elements.min.js"></script>
<script src="/Public/Ucenter/proxy/assets/js/ace.min.js"></script>
</body>
</html>