<?php if (!defined('THINK_PATH')) exit();?><!doctype>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0">
<meta name="keywords" content="股指期货,期指,黄金,白银,沪深300,中证500,上证50">
<meta name="description" content="<?php echo tel('notice');?>">
    <title>账户充值-<?php echo config('s_domain_name'); echo config('webname');?></title>
    <script typet="text/javascript" src="/Public/Home/js/1.9.1jq/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/account/account.css">
    <link rel="stylesheet" href="/Public/Home/css/merge/merge.css">

    <link rel="stylesheet" type="text/css" href="/Public/Home/css/layer_mobile/layer.css">
    <script type="text/javascript" src="/Public/Home/css/layer_mobile/layer.js"></script>
    <style>
        .shadeWrap{ position:fixed; width:100%; height:100%; top:0; left:0; z-index:99; background:rgba(0,0,0,.3); font-size:.16rem;}
        .shadeWrap .content{ width: 75%; background: #fff; border-radius: .05rem; position: absolute; top: 50%; margin-top: -20.5%; left: 50%; margin-left: -38%; text-align: center;box-shadow: 0 0 .05rem rgba(0,0,0,.4); }
        .shadeWrap .main{padding: .25rem; border-bottom: 1px solid #eee;}
        .shadeWrap .action{ width:100%; height:.38rem; line-height: .38rem; border-radius: 0 0 .05rem .05rem;font-size:.16rem; color:#fff;background:#da3333;}

        .money1{
            padding:10px .2rem;
            background: #fff;
        }
        .money1 ul{
            overflow: hidden;
        }
        .money1 li{
            float: left;
            width: 33.3%;
            text-align: center;
            padding: 0 10px;
            margin-top: 15px;
        }
        .money1 li div{
            background: #ECEFF4;
            padding:5px 0;
        }
        .money1 li div.active{
            background: #DA2F34;
            color: #fff;
        }
        .money1 ul li input{
            background: #ECEFF4;
            text-align: center;
            width:100%;
            color: #000;
        }
        .money1 ul li:last-child div{
            background:#ECEFF4 !important;
        }
        
    </style>
</head>
<body>
<div class="wrap gray">
    <header class="page-header">
        <a class="back" href="javascript:window.history.back();">&nbsp;</a>

        <h3>充值</h3>
    </header>
    <section class="content ">
        <div class="pay-money p1520 mtb10">
            <span class="pay-title">充值金额</span><input readonly type="text" id="j_tradeId" name="money" placeholder="充值金额>=100元" onkeyup="value=value.replace(/[^\d\.]/g,'')" value="1999">
        </div>
    
        
        <div class="money1">
            <p>选择充值金额
                <!--<span style="color:red">>=588</span>--></p>
            <ul>
                <li>
                    <div class="active btn">1999</div>
                </li>
                <li>
                    <div class="btn">4999</div>
                </li>
                <li>
                    <div class="btn">9999</div>
                </li>
                <li>
                    <div class="btn">16999</div>
                </li>
                <li>
                    <div class="btn">19999</div>
                </li>
                <li>
                    <div>
                        <input type="tel" placeholder="其他金额" onkeyup="value=value.replace(/[^\d\.]/g,'')">
                    </div>
                </li>
            </ul>
        </div>
        
        
        <div class="pay-type p20" id="pay_area">
            <p>请选择支付方式</p>
            <input type="hidden" value="manual_wx" name="pay_type_value" id="id_pay_type">
            
            <!-- 智付 -->
             <!--<div class="paycard border" pay-type="zhifu">
                    <img class="logo" src="http://pro.jinguzhi.net/content/assets/imgs/yinlian.png" alt="">
                    <img class="tuijian" src="http://pro.jinguzhi.net/content/assets/imgs/tuijian.png" alt="">
                    <p class="pay-name">智付支付</p>
                    <p class="pay-tips">无需开通网银</p>
                </div> -->
            <!-- 智付 -->
            


            <!-- 钱通微信扫码支付 -->
<!--             <div class="paycard" pay-type="weiXinScan_qt">
                <img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/weixin.jpg" alt="">
                <p class="pay-name">微信支付</p>
                <p class="pay-tips">免手续费</p>
            </div> -->


<!--             <div class="paycard" pay-type="ZFBScan_qt">
                <img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/zhifubao.jpg" alt="">
                <p class="pay-name">支付宝支付</p>
                <p class="pay-tips">免手续费</p>
            </div> -->
            <!-- 钱通微信扫码支付 -->


            <!-- 首信易支付 -->
<!--             <div class="paycard" pay-type="wxpay_syx">
                <img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem; border-radius: 16px;" src="/Public/Home/images/../img/weixin.jpg" alt="">
                <p class="pay-name">微信支付</p>
                <p class="pay-tips">免手续费</p>
            </div> 
            <div class="paycard" pay-type="weiXinScan_zn">
                <img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/weixin.jpg" alt="">
                <p class="pay-name">微信支付</p>
                <p class="pay-tips">免手续费</p>
            </div> -->
           <!--  易通微信支付 
              <div class="paycard" pay-type="yitong_weipay">
                <img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/weixinlog.png" alt="">
                <p class="pay-name">微信支付</p>
                <p class="pay-tips">免手续费</p>
            </div>-->
            <!-- 中南支付 -->
            <!--<div class="paycard" pay-type="QQSCANPay_zn">-->
                <!--<img class="logo" src="/Public/Home/images/qq.png" alt="" style="width:40px;left: 0.1rem;top: 0.1rem;">-->
                <!--<p class="pay-name">QQ支付</p>-->
                <!--<p class="pay-tips">免手续费</p>-->
            <!--</div>-->
             <!-- 中南支付 

            <div class="paycard" pay-type="ZFBScan_zn">
                <img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/zhifubao.jpg" alt="">
                <p class="pay-name">支付宝支付</p>
                <p class="pay-tips">免手续费</p>
            </div>-->
            <!--<div class="paycard" pay-type="weiXinScan_cb">-->
                <!--<img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/weixin.jpg" alt="">-->
                <!--<p class="pay-name">畅佰微信支付</p>-->
                <!--<p class="pay-tips">免手续费</p>-->
            <!--</div>-->
            <!--<div class="paycard" pay-type="ZFBScan_cb">-->
                <!--<img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/zhifubao.jpg" alt="">-->
                <!--<p class="pay-name">畅佰支付宝支付</p>-->
                <!--<p class="pay-tips">免手续费</p>-->
            <!--</div>
            <div class="paycard border" pay-type="yitong_yinlian">
                <img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/yinlian.png" alt="">
                <p class="pay-name">快捷支付</p>
                <p class="pay-tips">免手续费</p>
            </div>-->
          
           <!----> 
		   <!--<div class="paycard" pay-type="CertPay_zn">-->
                <!--<img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/yinlian.png" alt="">-->
                <!--<p class="pay-name">快捷支付</p>-->
                <!--<p class="pay-tips">免手续费</p>-->
            <!--</div> -->


            <!--<div class="paycard" pay-type="wxpay_syx">-->
                <!--<img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/zhifubao.jpg" alt="">-->
                <!--<p class="pay-name">支付宝支付</p>-->
                <!--<p class="pay-tips">免手续费</p>-->
            <!--</div>-->

            <!--<div class="paycard border" pay-type="wxpay_syx_yl">-->
                <!--<img class="logo" src="/Public/Home/images/yinlian.png" alt="" style="width:40px;left: 0.1rem;top: 0.1rem;">-->
                <!--<p class="pay-name">银联支付</p>-->
                <!--<p class="pay-tips">免手续费</p>-->
            <!--</div>-->
             <!-- 首信易支付 -->

            <!-- 环迅支付 -->
        <!-- <div class="paycard" pay-type="pay_ips_wx">
                <img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/wxjugg.png" alt="">
                <p class="pay-name">微信支付</p>
                <p class="pay-tips">免手续费</p>
            </div> -->
<!--             <div class="paycard" pay-type="pay_ips_zfb">
                <img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/zhifubao.jpg" alt="">
                <p class="pay-name">支付宝支付</p>
                <p class="pay-tips">免手续费</p>
            </div> -->
            <!-- 环迅支付 -->


            <!-- 恒生国际微信公众号支付 -->
<!--             <div class="paycard" pay-type="hsgj_weipay">
                <img class="logo" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/weixinlog.png" alt="">
                <p class="pay-name">微信支付
                <p class="pay-tips">免手续费</p>
            </div> -->
             <!-- 恒生国际微信公众号支付 -->
            <!--<div class="paycard" pay-type="weiXinScan_zn">-->
                <!--<img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/weixin.jpg" alt="">-->
                <!--<p class="pay-name">微信支付A通道</p>-->
                <!--<p class="pay-tips">免手续费</p>-->
            <!--</div>-->

               <!--&lt;!&ndash; 九龙快捷支付 &ndash;&gt;-->
             <!--<div class="paycard border" pay-type="JlPay_zn">-->
                <!--<img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/kuaijie.png" alt="">-->
                <!--<p class="pay-name">快捷支付-->
                <!--<a href="<?php echo U('PayJl/unbindBank');?>" style="color:red;font-size: 14px;margin-left:14px;">我的快捷</a>-->
                <!--</p>-->
                <!--<p class="pay-tips">免手续费</p>-->
            <!--</div>-->
            <!--&lt;!&ndash; 九龙快捷支付 &ndash;&gt;-->

           <!--&lt;!&ndash; 九龙网关支付 &ndash;&gt;-->
             <!--<div class="paycard" pay-type="JlPay_B2C">-->
                <!--<img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/yinlian.png" alt="">-->
                <!--<p class="pay-name">网银支付-->
                    <!--<span style="color: red">大额通道</span>-->
                <!--</p>-->

                <!--<p class="pay-tips">免手续费</p>-->
            <!--</div>-->
            <!-- 九龙快捷支付 -->


            <!-- <div class="paycard" pay-type="zfbscan_ewm"> -->
                <!-- <img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/zhifubao.jpg" alt=""> -->
                <!-- <p class="pay-name">支付宝支付 </p> -->
                <!-- <p class="pay-tips">免手续费</p> -->
            <!-- </div> -->
<!--             <div class="paycard" pay-type="fuwuhao_zfb_ewm">
                <img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/zhifubao.jpg" alt="">
                <p class="pay-name">支付宝支付 </p>
                <p class="pay-tips">免手续费</p>
            </div> -->
<!-- 			<div class="paycard" pay-type="fuwuhao_wx_ewm">
                <img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/weixin.jpg" alt="">
                <p class="pay-name">微信支付B通道 </p>
                <p class="pay-tips">免手续费</p>
            </div> -->
            
            
            <!--个人二维码手工充值-->
            <div class="paycard" pay-type="manual_zfb">
                <img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/zhifubao.jpg" alt="">
                <p class="pay-name">支付宝支付 </p>
                <p class="pay-tips">免手续费</p>
            </div>
    
            <div class="paycard border" pay-type="manual_wx">
                <img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/../img/weixin.jpg" alt="">
                <p class="pay-name">微信支付 </p>
                <p class="pay-tips">免手续费</p>
            </div>
    
            <div class="paycard" pay-type="manual_yl">
                <img class="logo zhifubao" style="width:40px;left: 0.1rem;top: 0.1rem;" src="/Public/Home/images/yinlian.png" alt="">
                <p class="pay-name">银联支付 </p>
                <p class="pay-tips">免手续费</p>
            </div>
    
            <!--个人二维码手工充值-->
            
            <p class="login-btn">下一步</p>
            
                <?php echo ($news); ?>
            <!--<p style="color:red">温馨提示</p>-->
            <!--<p>1：付款之后请把‘支付凭证’以及在该平台登录‘手机号’发送给客服，</p>-->
            <!--<p>2：客服微信：123456</p>-->
            
        </div>
    </section>
</div>
<!--弹出层begin-->
<div class="shadeWrap" style="display:none;">
    <div class="content">
        <div class="main">你还没有绑定银行卡</div>
        <div class="action">
            <span class="shadow-btn" href="javascript:void(0);">确定</span>
        </div>
    </div>
</div>
<!--弹出层end-->
</body>
</html>
<script type="text/javascript">


    $('.money1 ul li div').click(function() {
        $('.money1 ul li div').removeClass('active');
        $(this).addClass('active');
        if ($(this).hasClass('btn')) {
            $('#j_tradeId').val($(this).html())
        }
    })

    $('.money1 ul li div input').keyup(function() {
        $('#j_tradeId').val($(this).val())
    });
    
    
    $('.paycard').click(function(){
        $('#pay_area').find('.paycard').each(function(){
            $(this).removeClass('border');
        });

        $(this).addClass('border');
        $('#id_pay_type').val($(this).attr('pay-type'));
    });


    $(".login-btn").click(function(){

        var paytype  = $('#id_pay_type').val(); //支付类型

        if(paytype == '')
            return layer.msg('请选择支付方式!');

        var money    = $("#j_tradeId").val();  //充值金额

        $.ajax({
            url: "<?php echo U('User/account_check');?>",
            dataType: 'json',
            type: 'post',
            data: {'paytype':paytype,'money':money},
            success: function (data) {
                if(data.status === 1){
                    layer.open({
                        content: data.msg,
                        btn: '确定',
                        yes: function(index, layero){
                            layer.close(index);
                            top.location.href=data.redirectUrl + '?money=' + data.amount + '&ordernum=' + data.ordernum + '&paytype=' + data.paytype + '&uid=' + data.uid;
                        }
                    });
                }
                if(data.status === 0){
                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time: 2
                    });
                    return false;
                }
            }
        });


    });
</script>
<style type="text/css">
    .border{border: solid 1px red;}
</style>