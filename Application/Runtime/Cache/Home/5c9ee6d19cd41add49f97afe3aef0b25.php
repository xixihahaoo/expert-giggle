<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html style="display: block;"><head>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
    <title>账户登录</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0">
<meta name="keywords" content="股指期货,期指,黄金,白银,沪深300,中证500,上证50">
<meta name="description" content="<?php echo tel('notice');?>">
    <link rel="stylesheet" href="/Public/Home/css/merge1.css">

<!--     <link rel="stylesheet" type="text/css" href="/Public/Home/css/layer_mobile/layer.css">
    <script type="text/javascript" src="/Public/Home/css/layer_mobile/layer.js"></script> -->
    <style>

    </style>
    <script typet="text/javascript" src="/Public/Home/js/1.9.1jq/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/Home/css/layer/layer.js"></script>

    <script type="text/javascript">
        var __baseDir = 'http://'+window.location.host+'/content/';
    </script>
</head>
<body>

<form id="doc" class="doc page-user white">
    <header class="page-header">
        <div class="content">
            <h3>登录</h3>
            <div class="left">
                <a href="javascript:window.history.back()" class="iconfont go-back icon-youjiantou" id="back"></a>
            </div>
            <div class="right"></div>
        </div>
    </header>
    <!-- 内容 -->
    <section class="main-user main-user-login" style="margin-top:.55rem">
        <div class="content">
    
    
            <div style="text-align: center">
                <img src="/Public/Home/images/logo.jpg" style="width:50%">
            </div>
            
            
            <div class="login-input">
                <div class="login-tel">
                    <span class="icon-shouji"></span>
                    <input name="utel" maxlength="11" placeholder="请输入手机号" type="text" id="utel" value="<?php echo ($user["username"]); ?>">
                </div>
                <div class="login-password">
                    <span class="icon-mima"></span>
                    <input name="password" placeholder="请输入密码" type="password" id="password">
                </div>
                <h3 style="margin-top: 5px">
                    <input type="checkbox" name="" value="1" id="cookie" checked="true"><label for="cookie"> 记住帐号</label>
                </h3>
                <a class="login-btn do-login" id="sub">登录</a>
                <a href="<?php echo U('Register/reg');?>" class="left graya5 f13" id="zC">免费注册</a>
                <a href="<?php echo U('Register/outpwd');?>" class="right graya5 f13">忘记密码
                </a>
            </div>
        </div>
    </section>
</form>
<script src="/Public/Home/js/jquery-2.1.1.min.js"></script>

<script>
 $('#sub').click(function(){
    
     var tel    = $("#utel").val();
     var pwd    = $("#password").val();
     var cookie = $("input[type='checkbox']").is(':checked')
     if(cookie == true) 
     {
        var cookies = 1;
     } else {
        var cookies = 0;
     }

     var index = layer.load(0, {
          shade: [0.1,'#fff'] //0.1透明度的白色背景
    });

     $.ajax({
         type: "post",
         url: "<?php echo U('Register/login');?>",
         dataType: 'json',
         data:{'tel':tel,'password':pwd,'cookies':cookies},
         success: function (data) {
                   
                                if(data.status === 0){

                                        layer.close(index);     
                                        layer.msg(data.msg, {icon: 7});
                                        return false;
                                    }

                                    if(data.status === 1){
                                         layer.close(index);     
                                         layer.msg(data.msg, {icon: 6});
                                         //window.setTimeout("window.location='<?php echo U('user/index');?>'",1000);
                                        window.setTimeout("window.location='<?php echo U('register/redirect_wx');?>'",1000);
                                         return false;
                                    }
         }
     })
 })



</script>
</body>
</html>