<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>后台系统</title>
	<meta name="keywords" content="后台管理中心" />
	<meta name="description" content="后台管理中心" />
	
	<!-- basic styles -->
	
	<link href="/Public/Admin/css/assets/css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="/Public/Admin/css/assets/css/font-awesome.min.css" />
	
	<link rel="stylesheet" href="/Public/Admin/css/assets/css/ace.min.css" />
	<link rel="stylesheet" href="/Public/Admin/css/assets/css/ace-rtl.min.css" />
	<!--         <script type="text/javascript" src="/Public/css/layer/layer.js"></script> -->

</head>

<style type="text/css">
	.sms{cursor: pointer; display: block;}
</style>

<body class="login-layout">
<div class="main-container">
	<div class="main-content">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="login-container">
					<div class="center">
						<h1>
							<i class="icon-leaf green"></i>
							<span class="red"></span>
							<span class="white">管理员登陆</span>
						</h1>
						<h4 class="blue">&copy;后台管理中心</h4>
					</div>
					
					<div class="space-6"></div>
					
					<div class="position-relative">
						<div id="login-box" class="login-box visible widget-box no-border">
							<div class="widget-body">
								<div class="toolbar clearfix">
									<div>
										<!--
										<a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
											<i class="icon-arrow-left"></i>
											忘记密码？
										</a>
										 -->
									</div>
									
									<div>
										<!--
										<a href="#" onclick="show_box('signup-box'); return false;" class="user-signup-link">
											注册
											<i class="icon-arrow-right"></i>
										</a>
										 -->
									</div>
								</div>
								<div class="widget-main">
									<h4 class="header blue lighter bigger">
										<i class="icon-coffee green"></i>
										请输入用户名和密码
									</h4>
									
									<div class="space-6"></div>
									
									<form method="post" action="<?php echo U('User/signin');?>">
										<fieldset>
											<label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" class="form-control" placeholder="用户名" name="username" value="<?php echo ($user["username"]); ?>" />
                                                            <i class="icon-user"></i>
                                                        </span>
											</label>
											
											<label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" class="form-control" placeholder="密码" name="password" />
                                                            <i class="icon-lock"></i>
                                                        </span>
											</label>
											
											<div class="space"></div>
											
											<div class="clearfix">
												<label class="inline">
													<input type="checkbox" style="display:block;" value="1" name="session" />
													<span class="lbl" style=" position: absolute; left: 60px; bottom:  90px; font-size: 12px;">记住帐号</span>
												</label>
												<input type="submit" class="width-35 pull-right btn btn-sm btn-primary" value="登录">
												</input>
											</div>
											
											<div class="space-4"></div>
										</fieldset>
									</form>
								
								
								</div><!-- /widget-main -->
								
								<div class="toolbar clearfix">
									<div>
										<!--
																						<a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
																							<i class="icon-arrow-left"></i>
																							忘记密码？
																						</a>
																						 -->
									</div>
									
									<div>
										
										<a href="#" onclick="show_box('signup-box'); return false;" class="user-signup-link">
											忘记密码
											<i class="icon-arrow-right"></i>
										</a>
									
									</div>
								</div>
							</div><!-- /widget-body -->
						</div><!-- /login-box -->
						
						<div id="forgot-box" class="forgot-box widget-box no-border">
							<div class="widget-body">
								<div class="widget-main">
									<h4 class="header red lighter bigger">
										<i class="icon-key"></i>
										Retrieve Password
									</h4>
									
									<div class="space-6"></div>
									<p>
										Enter your email and to receive instructions
									</p>
									
									<form>
										<fieldset>
											<label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="email" class="form-control" placeholder="Email" />
                                                            <i class="icon-envelope"></i>
                                                        </span>
											</label>
											
											<div class="clearfix">
												<button type="button" class="width-35 pull-right btn btn-sm btn-danger">
													<i class="icon-lightbulb"></i>
													Send Me!
												</button>
											</div>
										</fieldset>
									</form>
								</div><!-- /widget-main -->
								
								<div class="toolbar center">
									<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
										Back to login
										<i class="icon-arrow-right"></i>
									</a>
								</div>
							</div><!-- /widget-body -->
						</div><!-- /forgot-box -->
						
						<div id="signup-box" class="signup-box widget-box no-border">
							<div class="widget-body">
								<div class="widget-main">
									<h4 class="header green lighter bigger">
										<i class="icon-group blue"></i>
										密码找回
									</h4>
									
									<div class="space-6"></div>
									<p> 填写信息: </p>
									
									<form>
										<fieldset>
											
											<label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="tel" class="form-control mobile" placeholder="手机号" />
                                                            <i class="icon-user"></i>
                                                        </span>
											</label>
											
											<label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" class="form-control smscode" placeholder="验证码"/>
	                                                        <!--  <i class="icon-envelope sms" ><a>获取验证码</a></i> -->
                                                            <input type="button" onclick="javascript:mbtime(this);" value="获取验证码">
                                                        </span>
											</label>
											
											<label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" class="form-control password" placeholder="新密码" />
                                                            <i class="icon-lock"></i>
                                                        </span>
											</label>
											
											<label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" class="form-control notpassword" placeholder="确认新密码" />
                                                            <i class="icon-retweet"></i>
                                                        </span>
											</label>
											
											<div class="space-24"></div>
											
											<div class="clearfix">
												<button type="reset" class="width-30 pull-left btn btn-sm">
													<i class="icon-refresh"></i>
													Reset
												</button>
												
												<button type="button" class="width-65 pull-right btn btn-sm btn-success send">
													submit
													<i class="icon-arrow-right icon-on-right"></i>
												</button>
											</div>
										</fieldset>
									</form>
								</div>
								
								<div class="toolbar center">
									<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
										<i class="icon-arrow-left"></i>
										Back to login
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="/Public/Admin/css/assets\js\jquery-2.0.3.min.js"></script>


<script type="text/javascript">
    function show_box(id) {
        jQuery('.widget-box.visible').removeClass('visible');
        jQuery('#'+id).addClass('visible');
    }
</script>
</body>
</html>

<script type="text/javascript">
    var wait=60;

    function mbtime(o) {
        if (wait == 60) {
            var numbers = /^1\d{10}$/;
            var mobile   = $(".mobile").val().replace(/\s+/g,""); //手机号
            if(!numbers.test(mobile) || mobile.length ==0){
                alert('手机号码格式错误');
                return false;
            } else {
                get_phones_code();
            }
        }
        if (wait == 0) {
            o.removeAttribute("disabled");
            o.value="重新获取验证码";
            wait = 60;
        } else {
            o.setAttribute("disabled", true);
            o.value="重新发送(" + wait + ")";
            wait--;
            setTimeout(function() {mbtime(o)},1000)
        }
    }


    function get_phones_code(){
        var mobile = $(".mobile").val().replace(/\s+/g,""); //手机号
        $.ajax({
            url:"<?php echo U('/Home/Tools/save_smsverify_admin');?>",
            dataType: 'json',
            type: 'get',
            data: "mobile="+mobile+" ",
            success:function(data){
                alert(data.ret_msg);
            }
        });
    }


    $(".send").click(function(){

        var numbers = /^1\d{10}$/;
        var mobile   = $(".mobile").val().replace(/\s+/g,""); //手机号
        if(!numbers.test(mobile) || mobile.length ==0){
            alert('手机号码格式错误');
            return false;
        }

        var smscode     = $(".smscode").val(); //短信验证码
        var password    = $(".password").val(); //密码
        var notpassword = $(".notpassword").val();

        $.ajax({
            url:"<?php echo U('Outpwd/outpwd');?>",
            dataType: 'json',
            type: 'post',
            data: {'mobile':mobile,'smscode':smscode,'password':password,'notpassword':notpassword},
            success:function(data){
                if(data.status === 0){
                    alert(data.msg)
                    return false;
                }
                if(data.status === 1){
                    alert(data.msg);
                    location.reload();
                }
            }
        });
    });
</script>