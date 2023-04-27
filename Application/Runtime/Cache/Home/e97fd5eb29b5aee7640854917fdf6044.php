<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title>注册账户</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0">
<meta name="keywords" content="股指期货,期指,黄金,白银,沪深300,中证500,上证50">
<meta name="description" content="<?php echo tel('notice');?>">
	<link rel="stylesheet" href="/Public/Home/css/merge1.css">

    <script typet="text/javascript" src="/Public/Home/js/1.9.1jq/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/Home/css/layer/layer.js"></script>

	<style type="text/css">
		.formtips{
			text-align:center;
			width: 100%;
		}

        .mod-list>li {
            border-bottom: 1px solid #ededed;
        }

        .mod-list>li:after {
            content: "";
            display: block;
            position: absolute;
            left: -50%;
            width: 200%;
            height: 0px;
            background: #ededed;
            -webkit-transform: scale(0.5);
        }
	</style>
</head>
<body>
	<header class="page-header">
		<div class="content">
			<h3>免费注册</h3>
			<div class="left">
				<a href="javascript:window.history.back()" class="iconfont go-back icon-youjiantou" id="back"></a>
			</div>
			<div class="right">
				<a href="<?php echo U('User/login');?>">登录</a>
			</div>
		</div>
	</header>

	<!-- 内容 -->
	<section class="page-main main-user main-smscode main-user-register">
		<form id="reviseForm" class="content" method="post">

			<div class="step step1">
				<ul class="mod-list">
					<li class="clearfix">
						<label class="left">手机号</label>
						<input id="c-pho" name="utel" class="left input mobile" maxlength="11" placeholder="请输入手机号" type="text">
					</li>
					<li class="clearfix">
						<label class="left">短信验证</label>
						<input name="code" class="left input smscode" style="width:42%;" maxlength="6" placeholder="请输入短信验证码" id="c-pwd" type="text">
						<input class="right get-smscode disabled" type="button" value="获取验证码" id="mes" onclick="javascript:mbtime(this);">
					</li>
					<li class="clearfix">
						<label class="left">密码</label>
						<input name="upwd" id="n-pwd" class="left input password" maxlength="20" placeholder="请输入登录密码" type="password">
					</li>
					<li class="clearfix">
						<label class="left">推广码</label>
					    <input id="tuig" name="tg" class="left input" placeholder="推广码(必填)" type="text" value="<?php echo ($code); ?>">
					</li>
				 </ul>
			</div>
		</form>
		<a class="login-btn do-login" id="send" style="width: 90%">免费注册</a>
	</section>
</body>
</html>

	<script type="text/javascript">

		
           $("#send").click(function(){
                
                var index = layer.load(0, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                });

                 var numbers = /^1\d{10}$/;
                 var mobile   = $(".mobile").val().replace(/\s+/g,""); //手机号
                 if(!numbers.test(mobile) || mobile.length ==0){
                        
                      layer.close(index);              	     
                      layer.msg('手机号码格式错误', {icon: 5});
                       return false;
                  }
                 
                 var smscode  = $(".smscode").val(); //短信验证码
                 var password = $(".password").val(); //密码
                 var tuig     = $('#tuig').val();   //推广码

         
                 $.ajax({
				            url:"<?php echo U('Register/register');?>",
				            dataType: 'json',
				            type: 'post',
				            data: {'mobile':mobile,'smscode':smscode,'password':password,'tuig':tuig},
				            success:function(data){
                                    
                                if(data.status === 0){

					                     layer.close(index);              	     
					                     layer.msg(data.msg, {icon: 5});
				                         return false;
				                    }

				                    if(data.status === 1){

					                     layer.close(index);              	     
					                     layer.msg(data.msg, {icon: 6});
				                         window.setTimeout("window.location='<?php echo U('Register/concern');?>'",1000);
				                         return false;
				                    }
				            }
				    });

 
           });
</script>

<script type="text/javascript">
 
        //发送验证码
         $("#c-pho")
          .keyup(function(event){

           var tel = $(".mobile").val();
  
            if(tel.length == '11'){
              
			   $("#mes").removeClass('disabled');
            } else{

            	$("#mes").addClass('disabled');
            }

		});


         var wait=60;

		function mbtime(o) {
		    if (wait == 60) {
		        get_phones_code();
		    }
		    if (wait == 0) {
		        o.removeAttribute("disabled");
		        o.value="重新获取";
		        wait = 60;
		    } else {
		        o.setAttribute("disabled", true);
		        o.value="重新发送(" + wait + ")";
		        wait--;
		        setTimeout(function() {mbtime(o)},1000)
		    }
		}

            function get_phones_code(){
                        
                        var index = layer.load(0, {
                            shade: [0.1,'#fff'] //0.1透明度的白色背景
                         });
                        var numbers = /^1\d{10}$/;
                        var mobile   = $(".mobile").val().replace(/\s+/g,""); //手机号
                         if(!numbers.test(mobile) || mobile.length ==0){
                                 	      	     
                                    layer.msg('手机号码格式错误', {icon: 5});
                                    layer.close(index); 
                                    return false;
                          }

                        $.ajax({
				            url:"<?php echo U('Tools/smsverify');?>",
				            dataType: 'json',
				            type: 'get',
				            data: "mobile="+mobile+" ",
				            success:function(data){

				                    if(data.ret_code == 1){
                                        
                                        layer.close(index);      
                                        layer.msg(data.ret_msg, {icon: 6});

				                    } else{
				                    	layer.close(index);
                                        layer.msg(data.ret_msg, {icon: 5});

				                    }

				            }
				    });
}

</script>