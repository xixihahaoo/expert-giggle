<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html style="display: block;">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0">
<meta name="keywords" content="股指期货,期指,黄金,白银,沪深300,中证500,上证50">
<meta name="description" content="<?php echo tel('notice');?>">
    <title><?php echo ($product["capital_name"]); ?>-<?php echo config('s_domain_name'); echo config('webname');?></title>
    <link rel="stylesheet" href="/Public/Home/css/merge_product.css">
    <script typet="text/javascript" src="/Public/Home/js/1.9.1jq/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/Home/css/layer/layer.js"></script>

    <style type="text/css">
 @media all and (min-height:200px) and (max-height:379px){
            .xiantu{
                height: 260px!important;
            }
        }
        @media all and (min-height:380px) and (max-height:480px){
            .xiantu{
                height: 232px!important;
            }
        }
        @media all and (min-height:481px) and (max-height:568px){
            /*iphone 5 改为300高*/
            .xiantu{
                height: 320px!important;
            }
        }
        @media all and (min-height:569px) and (max-height:627px){
            /*iPhone 6 改为360高*/
            .xiantu{
                height: 378px!important;
            }

        }
        @media all and (min-height:628px) and (max-height:800px){
            /*iPhone 6Plus 改为450高*/
            .xiantu{
                height: 487px!important;
            }
        }
       @media all and (min-height:801px){
           /*iPhone 6Plus 改为450高*/
           .xiantu{
               height: 710px!important;
           }
       }

        .mod-tab-min li {
            margin-left: 0.07rem;
        }

    </style>
</head>
<body>

<div id="doc" class="doc">
    <!--
      PAGE: 行情数据
    -->
    <div class="page page-trade nofooter">
        <!-- 头部 -->
        <header class="page-header">
            <div class="content">
                <h3>
                    <span class="click"><i>实盘交易</i> - <em class="text-s14"><?php echo ($product["capital_name"]); ?></em><span class="iconfont dropdown icon-xiangxiajiantou"></span></span>
                </h3>
                <div class="left">
                        <a href="<?php echo U('Index/index');?>" class="iconfont go-back icon-xiangzuojiantou"></a>
                </div>
                <div class="right">
                    <a class="text-link" href="<?php echo U('play',array('option_id' => $product[id]));?>">玩法</a>
                </div>
            </div>
        </header>

        <!-- 内容 -->
        <section class="page-main main-trade">
            <div class="content tab-make">

                <!-- panel: 下单 -->
                <article class="make">
                <?php if($user_id): ?><div class="summary clearfix" id="summary" style="">
                            <div class="left">
                                <div class="text-minor">可用资金(元)</div>
                                <em class="text-l"><?php echo ($user["balance"]); ?></em>
                            </div>
                            <div class="right">
                                <a href="<?php echo U('User/account');?>" class="text-recharge">￥</a>
                                <span class="text-l rechage">充值</span>
                            </div>
                        </div><?php endif; ?>
                    <div class="panel stock-chart tab-min-tick">
                        <ul class="mod-tab-min clearfix">
                            <li class="tick tu" data-interval="1m" data-type="area">分时图</li>
                            <!--<li class="tu" data-interval="allday" data-type="area">全天</li>-->
                            <li class="tu" data-interval="1m" data-type="candlestick">1分</li>
                            <li class="tu" data-interval="5m" data-type="candlestick">5分</li>
                            <li class="tu" data-interval="15m" data-type="candlestick">15分</li>
                            <li class="tu" data-interval="30m" data-type="candlestick">30分</li>
                            <li class="tu" data-interval="1h" data-type="candlestick">1时</li>
                            <li class="tu" data-interval="1d" data-type="candlestick">1天</li>
                            <li class="tu">盘口</li>
                        </ul>

                        
                        <!-- 分时曲线图 -->
                        <article class="tick" style="display: block;" id="quxian">
                                 <div class="xiantu" style="height: 300px;width:100%" >
                                 <iframe  id="nowtu" name='nowtu' style='width:100%;height:95%;border: 0;' src="<?php echo U("Index/echarts",array("capital_key"=>"$product[capital_key]","interval"=>1,"length" => $product[capital_length],'type' => 'area'));?>">
                                 </iframe>
                                 </div>
                        </article>
                        <input type="hidden" value="<?php echo ($product["capital_length"]); ?>" id="length">
                        <input type="hidden" value="<?php echo ($product["id"]); ?>" id="op_id">
                        <!-- 分时曲线图 -->

                        <article class="market" id="pankou">
                            <table class="mod-table text-minor" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td class="clearfix">
                                            <span class="left">涨跌</span>
                                            <span class="right text-lows" id="zhang"><?php echo ($product["Diff"]); ?></span>
                                        </td>
                                        <td class="clearfix">
                                            <span class="left">涨幅</span>
                                            <span class="right text-lows" id="fu"><?php echo ($product["DiffRate"]); ?>%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="clearfix">
                                            <span class="left">最高</span>
                                            <span class="right text-highs" id="gao"><?php echo ($product["High"]); ?></span>
                                        </td>
                                        <td class="clearfix">
                                            <span class="left">最低</span>
                                            <span class="right text-lows" id="di"><?php echo ($product["Low"]); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="clearfix">
                                            <span class="left">开盘</span>
                                            <span class="right text-highs" id="kai"><?php echo ($product["Open"]); ?></span>
                                        </td>
                                        <td class="clearfix">
                                            <span class="left">昨结</span>
                                            <span class="right" id="shou"><?php echo ($product["Close"]); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="clearfix">
                                            <span class="left">持仓</span>
                                            <span class="right" id="today">--</span>
                                        </td>
                                        <td class="clearfix">
                                            <span class="left">昨持仓</span>
                                            <span class="right" id="Yesterday">--</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="clearfix">
                                            <span class="left">成交量</span>
                                            <span class="right" id="Volume">--</span>
                                        </td>
                                        <td class="clearfix">
                                            <span class="left">金额</span>
                                            <span class="right" id="money">--</span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </article>
                    </div>

                     <div class="panel stock-detail">
                         <div class="symbol clearfix">
                            <div class="left">
                                <span class="text-m"><?php echo ($product["capital_name"]); ?></span>
                                <em class="text-minor" style="display: none;" id="key"><?php echo ($product["capital_key"]); ?></em>
                                <em class="text-minor"><?php echo ($product["hs_code"]); ?></em>
                            </div>

                          <?php if(($product['global_flag'] == 1) AND ($product['flag'] == 1) ): ?><div class="right"><span class="text-minor">本时段持仓时间至 <em class="text-highs">
                            <?php echo deal_time_end($product[id]);?></em></span></div><?php endif; ?>

                        </div>
    
                         <!--闪电下单Start-->
                         <div class="lighting-order clearfix ">
                             <span>闪电下单设置</span>
                             <input type="hidden" value="<?php echo ($info["CounterFee"]); ?>" id="CounterFee">   <!-- 外汇手续费用-->
                             <input type="hidden" value="<?php echo ($info["Bond"]); ?>" id="Bond">               <!-- 保证金-->
                             <input type="hidden" value="<?php echo ($info["foreign"]); ?>" id="foreign">         <!-- 外汇保证金总和-->
                             <input type="hidden" value="<?php echo ($info["foreign_rmb"]); ?>" id="foreign_rmb"> <!-- 人民币保证金总和-->
        
        
                             <input type="hidden" value="<?php echo ($currency["rate"]); ?>" id="rate_base">    <!-- 外汇汇率人民币基数-->
                             <input type="hidden" value="<?php echo ($info["CounterFee"]); ?>" id="fee_base">   <!-- 手续费基数-->
                             <input type="hidden" value="<?php echo ($info["Bond"]); ?>" id="Bond_base">        <!-- 保证金基数-->
        
        
                             <div class="lighting-count">
                                 <span>交易数量 <em id="l-count">1手</em></span>
                                 <ul class="lighting-stopLoss-list" style="display: none">
                                     <li data-num="1">1手</li>
                                     <li data-num="2">2手</li>
                                     <li data-num="3">3手</li>
                                     <li data-num="5">5手</li>
                                 </ul>
                             </div>
                             <div class="lighting-stopLoss">
                                 <span>触发止损 <em id="l-stopLoss"><?php echo ($code); echo ($transaction[0]['Stop_loss']); ?></em></span>
                                 <ul class="lighting-stopLoss-list" style="display: none">
                                     <?php if(is_array($transaction)): $i = 0; $__LIST__ = $transaction;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><?php echo ($code); echo ($vo["Stop_loss"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
                                 </ul>
                             </div>
                             <div class="lighting-stopProfit">
                                 <em id="l-stopProfit" style="display: none;"><?php echo ($code); echo ($transaction[0]['stop_profit']); ?></em>
                                 <ul class="lighting-stopLoss-list" style="display: none">
                                     <?php if(is_array($transaction)): $i = 0; $__LIST__ = $transaction;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><?php echo ($code); echo ($vo["stop_profit"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
                                 </ul>
                             </div>
                         </div>
                         <!--闪电下单End-->
                         
                         
                         
                         
                         
                         
                        <ul class="clearfix left" style="width:50%;padding-top: .1rem;">

                            <li class="price" style="width:100%">
                                <div class="text-lows left"><em class="text-xxl" id="price" style="color:#539B53;"><?php echo ($product["Price"]); ?></em></div>
                                <div class="change left">
                                    <span class="text-lows" id="diff" style="color:#539B53;"><?php echo ($product["Diff"]); ?></span>
                                    <span class="text-lows" id="diffrate" style="color:#539B53;"><?php echo ($product["DiffRate"]); ?>%</span>
                                </div>
                            </li>

                        </ul>

                        <ul class="clearfix right" style="width:50%;padding:.04rem 0;">
                            <li class="sale" style="width:100%;">
                                <div class="clearfix" id="down">
                                    <span class="right text-highs"><?php echo ($product["sv"]); ?></span>
                                    <div class="right">
                                        <em class="volume" style="width: 0.03rem;"></em>
                                        <em class="text-minor" style="width: 0.00rem;">卖量</em>
                                    </div>
                                </div>
                            </li>
                            <li class="buy" style="width:100%;">
                                <div class="clearfix" id="up">
                                    <span class="right text-highs"><?php echo ($product["bv"]); ?></span>
                                    <div class="right">
                                        <em class="volume" style="width: 0.02rem;"></em>
                                        <em class="text-minor" style="width: 0.00rem;">买量</em>
                                    </div>
                                </div>
                            </li>
                        </ul>

                    <?php if(($product['global_flag'] == 0) OR ($product['flag'] == 0) ): ?><div class="closed-tips text-minor Hugh">
                        已休市
                       </div><?php endif; ?>

                    <div class="closed-tips text-minor Hugh" id="xiu" style="display: none;">
                        已休市
                       </div>
                    </div>

                    <div class="action clearfix">
                        <div class="left" style="width:40%;height:100%">
                           <a href="<?php echo U('Transaction/position',array('pid' => $product[id], 'type' => 1));?>" class="button button-open-interest">持仓<span class="icon-unread"><?php echo ($count); ?></span></a>
                            <!--<a href="<?php echo U('Transaction/settlement',array('pid' => $product[id], 'type' => 1));?>" class="button button-settle">结算</a>-->
                            <a href="javascript:void(0)" class="button button-settle " id="lightn">
                                <i class="jt-icon_lightning"></i>
                                <span>(已关闭)</span>
                            </a>
                        </div>
    
                        <div class="right" style="width:60%;height:100%;">
                            <?php if(($product['global_flag'] == 0) OR ($product['flag'] == 0) ): ?><a href="javascript:void(0)" class="button button-buy-highs disbal">
                                    <em id="SP" ><?php echo ($product["sp"]); ?></em>
                                    买涨</a>
                                <a href="javascript:void(0)" class="button button-buy-lows disbal">
                                    <em id="BP" ><?php echo ($product["bp"]); ?></em>
                                    买跌</a>
                                <?php else: ?>
            
                                <?php if($product['sell_flag'] == 0): ?><a href="javascript:void(0)" class="button button-buy-highs now">
                                        <em id="SP" ><?php echo ($product["sp"]); ?></em>
                                        买涨</a>
                                    <a href="javascript:void(0)" class="button button-buy-lows now">
                                        <em id="BP" ><?php echo ($product["bp"]); ?></em>
                                        买跌</a>
                                    <?php else: ?>
                                    <a href="javascript:void(0)" lightning="" pid="<?php echo ($product["id"]); ?>" ostyle='0' type="1" class="button button-buy-highs lightning">
                                        <em id="SP" ><?php echo ($product["sp"]); ?></em>买涨
                                    </a>
                                    <a href="javascript:void(0)" lightning="" pid="<?php echo ($product["id"]); ?>" ostyle='1' type="1" class="button button-buy-lows lightning">
                                        <em id="BP" ><?php echo ($product["bp"]); ?></em>买跌
                                    </a><?php endif; endif; ?>
    
                        </div>

                    </div>
                </article>

            </div>
        </section>
    </div>


     <div class="float" style="display: none;">
       <div class="content">
         <div class="overlay-top msgbox msgbox-info hide">
           <div class="content">
             <div class="main"></div>
             <div class="action">
                <a href="javascript:void(0)" class="button ok">确定</a>
             </div>
           </div>
         </div>
         <div class="overlay-top msgbox msgbox-confirm hide">
           <div class="content">
             <div class="main"></div>
             <div class="action clearfix">
               <div class="left"><a href="javascript:void(0)" class="button button-lesser no">取消</a></div>
               <div class="right"><a href="javascript:void(0)" class="button ok">确定</a></div>
             </div>
           </div>
         </div>
         <div class="msgbox-toast hide">
              <div class="content"></div>
         </div>

         <div class="overlay-top msgbox menu-slidedown menu-fade-in">
           <div class="content slide-in">
             <div class="main">
               <ul style="max-height: 6.1488rem;">

                    <?php if(is_array($option)): $i = 0; $__LIST__ = $option;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['global_flag'] == 1): if(($type) == "1"): ?><a href="<?php echo U('Index/product',array('id' => $vo['id']));?>" style="border-top: .01rem solid #e5e5e5;padding: .09rem 0 .07rem;font-size: .12rem;display: block; height: .5rem;">
                         <li data-value="<?php echo ($vo["capital_key"]); ?>" data-code="CL" data-url="<?php echo U('Index/product',array('id' => $vo['id']));?>"><?php echo ($vo["capital_name"]); ?></li>
                        </a>
                    <?php else: ?>
                         <a href="<?php echo U('Simulation/product',array('id' => $vo['id']));?>" style="border-top: .01rem solid #e5e5e5;padding: .09rem 0 .07rem;font-size: .12rem;display: block; height: .5rem;">
                         <li data-value="<?php echo ($vo["capital_key"]); ?>" data-code="CL" data-url="<?php echo U('Index/product',array('id' => $vo['id']));?>"><?php echo ($vo["capital_name"]); ?></li>
                        </a><?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
               </ul>
             </div>
           </div>
         </div>
       </div>
     </div>

</div>

</body>
</html>


<script type="text/javascript">

 $(function(){

 
var op_id = $("#op_id").val();
setInterval(function(){
            $.ajax({
                url: "<?php echo U('Index/Hugh');?>",
                dataType: 'html',
                type: 'get',
                data: 'op_id='+op_id+'',
                success: function (data) {
                if(data == 1) {  //1表示可交易
                     $("#xiu").css('display','none');
                } else{
                     $("#xiu").css('display','block');
                     $(".button-buy-highs").removeAttr('href');
                     $(".button-buy-lows").removeAttr('href');
                  }
                }
            });
},5000);


var arrString = $("#key").html();
var length    = $('#length').val();

ws = new WebSocket("ws://39.107.99.235:8889");
ws.onopen = function() {
    ws.send('tom');
};
ws.onmessage = function(e) {

    var data = eval("("+e.data+")");
    var type = data.type || '';
    switch(type){
        case 'init':
            $.post('<?php echo U("binding");?>', {client_id: data.client_id,group:arrString}, function(data){}, 'json');
            break;
        // 当mvc框架调用GatewayClient发消息时直接alert出来
        default :
            var data = JSON.parse(e.data);
            data.Price = data.Price.toFixed(length);
            try{
                frames['nowtu'].updateData1M(parseFloat(data.Price));
            }catch(e){
            }
           if(data.Diff > 0){
                $('#price').css('color','#DA2F34');
                $("#diff").css("color","#DA2F34");
                $("#diffrate").css("color","#DA2F34");
                var fu = '+';
            }else {
                $('#price').css('color','#539B53');
                $("#diff").css("color","#539B53");
                $("#diffrate").css("color","#539B53");
                var fu = '';
            }

               $("#price").html(data.Price);
               $("#diff").html(fu+data.Diff);
               $("#diffrate").html(fu+data.DiffRate+'%');
               $("#High").html(data.High);
               $("#Low").html(data.Low);

               $("#zhang").html(data.Diff);
               $("#fu").html(data.DiffRate);
               $("#gao").html(data.High);
               $("#di").html(data.Low);
               $("#kai").html(data.Open);
               $("#shou").html(data.Close);

               $("#Volume").html(data.TotalVol);        //持仓量
               try{
                    $("#SP").html(data.sp);
                    $("#BP").html(data.bp);
               }catch(e){

               }
               $("#down span").html(data.sv);          //卖量
               sv = data.sv/230;
               bv = data.bv/230;
               $("#down .volume").css('width',sv+'rem');//卖量

               $("#up span").html(data.bv);             //买量
               $("#up .volume").css('width', bv+'rem');  //买量

    }
};

 });

  //5分钟后刷新页面
window.setTimeout("location.reload()",300000);
</script>

<script type="text/javascript">

$(function(){

     $(".tu").click(function(){
       
       $(this).addClass('tick').siblings().removeClass('tick');
       
       var interval = $(this).attr('data-interval');
       var type     = $(this).attr('data-type');
       
       if(interval == undefined) {
           $("#quxian").css('display','none');
           $("#pankou").css('display','block');
       } else {
           $("#quxian").css('display','block');
           $("#pankou").css('display','none');

           var length   = $("#length").val();
           var code     = $("#key").html();
           var src      = '<?php echo U("Index/echarts");?>'+"?capital_key="+code+"&interval="+interval+"&length="+length+"&type="+type;
           $("#nowtu").attr('src',src);
       }
     });

    /*对沪深300休市框加高*/
    let capital_key = "<?php echo ($product["capital_key"]); ?>";
    if(capital_key == 'SH000300')
        $('.Hugh').css('height','.8rem');
    
});


$(".click").click(function(){

    $(".float").toggle();

});

$(".disbal").click(function(){

 layer.msg('产品已休市', {icon: 5});
});

$(".now").click(function(){

 layer.msg('你不能购买，产品即将休市', {icon: 5});
});

($(function(){
    document.getElementById('nowtu').style.height = ($('.symbol').offset().top - $('.tick').offset().top - 10).toString()+'px';
}))


/*闪电买涨 Start*/
$(".lighting-count li:first").addClass('selected');        //手数
$(".lighting-stopProfit li:first").addClass('selected');   //止盈
$(".lighting-stopLoss li:first").addClass('selected');     //止损

var lightn = $("#lightn");
lightn.click(function(){
    var _class = 'button-settle-open';
    var o = $('.lighting-order');
    var me = $(this);
    var thighs = $(".button-buy-highs");
    var tLows = $(".button-buy-lows");
    var open = me.find('span');
    var isLighting = 0;

    me.hasClass(_class)?
        (
            isLighting=!1,
                me.removeClass(_class),
                o.removeClass('lighting-order-open'),
                thighs.html('<em id="SP"><?php echo ($product["sp"]); ?></em>买涨'),
                tLows.html('<em id="BP"><?php echo ($product["bp"]); ?></em>买跌'),
                open.text('(已关闭)'),
                thighs.attr('lightning',''),
                tLows.attr('lightning','')
        )
        :(
            isLighting=!0,
                me.addClass(_class),
                o.addClass('lighting-order-open'),
                thighs.html('<em id="SP"><?php echo ($product["sp"]); ?></em>闪电买涨'),
                tLows.html('<em id="BP"><?php echo ($product["bp"]); ?></em>闪电买跌'),
                open.text('(已开启)'),
                thighs.attr('lightning',1),
                tLows.attr('lightning',1)
        )

});
$(".lighting-stopLoss").click(function(){
    $(this).find("ul").toggle();
});
$(".lighting-count").click(function(){
    $(this).find("ul").toggle();
});
$(".lighting-stopLoss li").click(function(){
    $("#l-stopLoss").html($(this).html())
    $(this).addClass('selected').siblings().removeClass('selected');

    var hand  = $(".lighting-count li.selected").attr('data-num');   //手数
    var rate  = $('#rate_base').val();    //汇率
    var index = $(this).index()+1;

    /*取出对应的止盈*/
    var indexs = (index - 1);
    var stopProfit = $(".lighting-stopProfit li:eq("+indexs+")").html();
    $(".lighting-stopProfit li:eq("+indexs+")").addClass('selected').siblings().removeClass('selected');;
    $("#l-stopProfit").html(stopProfit);
    console.log(stopProfit);
    /*取出对应的止盈*/


    $("#Bond").attr('value',(($("#Bond_base").val() * index) * hand).toFixed(2)); //保证金

    var CounterFee = $("#CounterFee").val();
    var Bond = $("#Bond").val();
    var foreign_sum = (parseFloat(CounterFee) + parseFloat(Bond)).toFixed(2);
    $("#foreign").attr("value",foreign_sum);                            //合计支付 外汇
    $("#foreign_rmb").attr('value',(foreign_sum * rate).toFixed(2));    //合计支付 人民币

})
$(".lighting-count li").click(function(){

    $("#l-count").html($(this).html());
    $(this).addClass('selected').siblings().removeClass('selected');

    var hand = $(this).attr('data-num'); //手数
    var rate = $('#rate_base').val();    //汇率
    var index = $(".lighting-stopLoss li.selected").index()+1;   //止损金额位置


    $("#CounterFee").attr('value',($('#fee_base').val() * hand).toFixed(2)); //外汇手续费
    $("#Bond").attr('value',(($("#Bond_base").val() * index) * hand).toFixed(2)); //保证金

    var CounterFee = $("#CounterFee").val();
    var Bond = $("#Bond").val();
    var foreign_sum = (parseFloat(CounterFee) + parseFloat(Bond)).toFixed(2);
    $("#foreign").attr("value",foreign_sum);                            //合计支付 外汇
    $("#foreign_rmb").attr('value',(foreign_sum * rate).toFixed(2));    //合计支付 人民币

});
/*闪电买涨 End*/


/*开始下单 Start*/
$('.lightning').click(function(){
    var lightning = $(this).attr('lightning');

    var hand      = $('#l-count').html().replace(/[^\d.]/g,'');
    var profit    = $('#l-stopProfit').html().replace(/[^\d.]/g,'');
    var loss      = $('#l-stopLoss').html().replace(/[^\d.]/g,'');
    var Bond      = $('#Bond').val();
    var fee       = $('#CounterFee').val();
    var foreign   = $('#foreign').val();     //合计费用外汇
    var heji_rmb  = $("#foreign_rmb").val(); //合计费用人民币
    var ostyle    = $(this).attr('ostyle');  //买入类型
    var id        = $(this).attr('pid');     //产品id
    var type_two  = $(this).attr('type');    //1实盘交易  2虚拟交易
    //alert(fee);return false;


    if(lightning == 1)
    {
        var index = layer.load(0, {
            shade: [0.1,'#fff']
        });

        $.ajax({
            url: "<?php echo U('Transaction/transaction');?>",
            dataType: 'json',
            type: 'post',
            data: {'hand':hand,'profit':profit,'loss':loss,'Bond':Bond,'fee':fee,'foreign':foreign,'heji_rmb':heji_rmb,'ostyle':ostyle,'id':id,'type_two':type_two},
            success: function (data) {
                if(data.status === 0){

                    layer.msg(data.msg, {icon: 7});
                    window.setTimeout("window.location='<?php echo U('User/account');?>'",2000);
                    return false;
                }

                if(data.status === 1){

                    layer.close(index);
                    layer.msg(data.msg, {icon: 5});
                    return false;
                }

                if(data.status === 2){

                    layer.msg(data.msg, {icon: 6});
                    window.location.href="<?php echo U('Transaction/Position');?>"+'?pid=<?php echo ($product['id']); ?>&type='+type_two+'';
                    return false;
                }
            },
        });

    } else
    {
        window.location.href="<?php echo U('Transaction/Buyup');?>"+'?id=<?php echo ($product['id']); ?>&ostyle='+ostyle+'&type='+type_two+'';
    }
});
</script>