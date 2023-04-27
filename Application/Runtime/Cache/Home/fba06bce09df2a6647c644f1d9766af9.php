<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html style="display: block;">
<head>
    <title><?php echo config('s_domain_name'); echo config('webname');?></title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0">
<meta name="keywords" content="股指期货,期指,黄金,白银,沪深300,中证500,上证50">
<meta name="description" content="<?php echo tel('notice');?>">
    <link rel="stylesheet" href="/Public/Home/css/merge_product.css">
    <script typet="text/javascript" src="/Public/Home/js/1.9.1jq/jquery.min.js"></script>
    
    <!--<script type="text/javascript" src="/Public//Home/mui/js/mui.min.js"></script>-->
    <!--<link rel="stylesheet" href="/Public//Home/mui/css/mui.min.css">-->
    
    <script type="text/javascript" src="/Public/Home/css/layer/mobile/layer.js"></script>
</head>
<body>
    
<div id="doc" class="doc">

    <div class="page page-buy-highs" style="display: block;">
        <!-- 头部 -->
         <?php if(($type) == "1"): ?><header class="page-header">
         <?php else: ?>
              <header class="page-header" style=" background-color: #c18e57;"><?php endif; ?>
            <div class="content">
                <h3>买入委托</h3>
                <div class="left">
                
                <?php if(($type) == "1"): ?><a href="<?php echo U('Index/product',array('id' => $option[id]));?>" class="iconfont go-back icon-xiangzuojiantou"></a>
                 <?php else: ?>
                        <a href="<?php echo U('Simulation/product',array('id' => $option[id]));?>" class="iconfont go-back icon-xiangzuojiantou"></a><?php endif; ?>

                </div>
                <div class="right"></div>
            </div>
        </header>

        <!-- 内容 -->
         <input type="hidden" value="<?php echo ($option["id"]); ?>" id="id">  <!--  产品id -->
         <input type="hidden" value="<?php echo ($info["Bond"]); ?>" id="Bond"> <!-- 保证金 -->
         <input type="hidden" value="<?php echo ($code); ?>" id="currency"> <!-- 货币类型 -->
         <input type="hidden" value="<?php echo ($option["rate"]); ?>" id="rate">  <!-- 汇率 -->
         <input type="hidden" value="<?php echo ($info["CounterFee"]); ?>" id="CounterFee">  <!-- 手续费 -->
         <input type="hidden" value="<?php echo ($ostyle); ?>" id="ostyle">  <!-- 买入类型 0涨 1跌， -->
         <input type="hidden" value="<?php echo ($type); ?>" id="type">      <!-- 1实盘交易 2虚拟交易 -->
         <input type="hidden" value="<?php echo ($option["Rivalprice"]); ?>" id="Rivalprice">  <!--对手价-->
         <input type="hidden" value="<?php echo ($option["capital_key"]); ?>" id="capital_key"> <!--产品代码-->
         <input type="hidden" value="<?php echo ($option["capital_length"]); ?>" id="length">  <!--产品长度-->


        <section class="page-main main-buy-highs">
            <div class="content">
                <ul class="mod-list">
                    <li class="clearfix">
                        <div class="left"><em class="text-highs" style="font-size:14px;"><?php echo ($option["capital_name"]); ?> </em>
                        <em style="font-size:12px;"><?php echo ($option["hs_code"]); ?></em></div>
                       
                        <div class="right"><em>持仓至<?php echo deal_time_end($option[id]);?>自动平仓</em></div>
                    </li>

                    <li class="clearfix">
                        <div class="left">交易数量</div>
                        <div class="right" id="num">
                        <span class="lot selected" data-value="1" data-index="0">1手</span>
                        <span class="lot " data-value="2" data-index="1">2手</span>
                        <span class="lot " data-value="3" data-index="2">3手</span>
                        <span class="lot " data-value="5" data-index="3">5手</span>
                        <span class="lot " data-value="10" data-index="10">10手</span>
                      </div>
                    </li>
                   
<!--                <li class="clearfix">
                        <div class="left">触发止盈<span class="iconfont help hide icon-yiwen1"></span></div>
                        <div class="right" id="profit">
                           <span class="text-stress" id="zhiying"><?php echo ($code); echo ($info["profit"]); ?></span>
                           <span id="zhiying_rmb">(￥<?php echo ($info["zhiying"]); ?>)</span>
                        </div>
                    </li> -->

                    <li class="clearfix">
                        <div class="left">触发止盈</div>
                        <div class="right" id="stop_profit">
                          
                          <?php if(is_array($transaction)): $i = 0; $__LIST__ = $transaction;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="trigger " data-value="<?php echo ($vo["stop_profit"]); ?>" data-index="0"><?php echo ($code); echo ($vo["stop_profit"]); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </li>

                    <li class="clearfix">
                        <div class="left">触发止损</div>
                        <div class="right" id="loss">
                          
                          <?php if(is_array($transaction)): $i = 0; $__LIST__ = $transaction;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="trigger " data-value="<?php echo ($vo["Stop_loss"]); ?>" data-index="0"><?php echo ($code); echo ($vo["Stop_loss"]); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </li>

                     <li class="clearfix">
                        <div class="left">止损保证金(冻结)<span class="iconfont help hide  icon-yiwen1"></span></div>
                        <div class="right"><span style="color:#666" id="zhisun"><?php echo ($code); echo ($info["Bond"]); ?></span><em id="zhisun_rmb"> (￥<?php echo ($info["baozheng"]); ?>) </em></div>
                    </li>
                     <li class="clearfix">
                        <div class="left">交易综合费</div>
                        <div class="right text-right"><span style="color:#666" id="jiaoyi"><?php echo ($code); echo ($info["CounterFee"]); ?></span><em id="shouxu"> (￥<?php echo ($info["shouxu"]); ?>) </em></div>
                    </li>
                   
                </ul>

                   <p class="rate">汇率换算：1<?php echo ($waihui); ?> = <?php echo ($option["rate"]); ?>人民币</p>

                <ul class="mod-list">
                   
                    <li class="clearfix">
                        <div class="left">合计支付：</div>
                        <div class="right text-right"><em id="heji"><?php echo ($code); echo ($info["foreign_sum"]); ?></em><span class="text-stress text-m" id="heji_rmb">￥<?php echo ($info["rmb_sum"]); ?></span></div>
                    </li>
                </ul>

                <div class="action">
                    <div class="price">最新买入价<br><em class="text-highs text-m" id="new"><?php echo ($option["Price"]); ?></em></div>
                    <?php if(($ostyle) == "0"): ?><a href="javascript:void(0)" id="submit" class="button button-stress button-buy-highs"> 确定买涨</a>
                    <?php else: ?>
                    <a href="javascript:void(0)" id="submit" class="button button-stress button-buy-lows"> 确定买跌</a><?php endif; ?>
                    
                </div>
            </div>
        </section>
    </div>
</div>
</body>
</html>

<script type="text/javascript">

$(function(){

$("#num span:first").addClass('selected');    //默认选中第一个
$("#loss span:first").addClass('selected');   //默认选中第一个
$("#stop_profit span:first").addClass('selected'); //默认选中第一个



var type = $("#currency").val();

$("#num span").click(function(){
      
    $(this).addClass('selected').siblings().removeClass('selected');

    var hand  = $(this).attr('data-value');  //手数

    var loss  = $("#loss span.selected").attr('data-value');   //止损金额
    
    $("#jiaoyi").html(type+$("#CounterFee").val() * hand);   //手续费用

    $("#shouxu").html(' (￥'+(($("#CounterFee").val() * hand) * $("#rate").val()).toFixed(2)+')');  //手续费人民币 (有余数)
       
    var index = $("#loss span.selected").index()+1;   //止损金额位置

    $("#zhisun").html(type+($("#Bond").val() * index) * hand); //止损保证金
    
    $("#zhisun_rmb").html(' (￥'+((($("#Bond").val() * index) * hand) * $("#rate").val()).toFixed(2)+')'); //止损保证金人民币

    var shouxu = $("#CounterFee").val() * hand;      //手续费用
    var zhisun = ($("#Bond").val() * index) * hand;  //止损费用

    $("#heji").html("("+type+""+(shouxu+zhisun)+")");    //合计支付 外汇
    $("#heji_rmb").html('￥'+((shouxu+zhisun) * $("#rate").val()).toFixed(2));    //合计支付 人民币

});



$("#loss span").click(function(){
      
    $(this).addClass('selected').siblings().removeClass('selected');
    
    var hand  = $("#num span.selected").attr('data-value');   //手数 

    var value = $(this).attr('data-value');

    // $("#zhiying").html(type+value * 5);   //止盈金额

    // $("#zhiying_rmb").html('(￥'+(value * 5) * $("#rate").val()+')'); //人民币止盈金额

    var index = $(this).index()+1;

    $("#zhisun").html(type+($("#Bond").val() * index) * hand); //止损保证金

    $("#zhisun_rmb").html(' (￥'+((($("#Bond").val() * index) * hand) * $("#rate").val()).toFixed(2)+')');  //止损保证金人民币费用

    var shouxu = $("#CounterFee").val() * hand;      //手续费用
    var zhisun = ($("#Bond").val() * index) * hand;  //止损费用

    $("#heji").html("("+type+""+(shouxu+zhisun)+")");    //合计支付 外汇
    $("#heji_rmb").html('￥'+((shouxu+zhisun) * $("#rate").val()).toFixed(2));    //合计支付 外汇


});

// 点击止盈
 $("#stop_profit span").click(function(){
      
       $(this).addClass('selected').siblings().removeClass('selected');

 });


});

</script>

<script type="text/javascript">
                 
var capital_key = $('#capital_key').val();
var arrString = capital_key;
var length = $('#length').val();

ws = new WebSocket("ws://39.107.99.235:8889");
ws.onopen = function() {
  ws.send('tom');
};

ws.onmessage = function(e) {
    var data = eval("("+e.data+")");
    var type = data.type || '';
    switch(type){
        case 'init':
            $.post('<?php echo U("Index/binding");?>', {client_id: data.client_id,group:arrString}, function(data){}, 'json');
            break;
        default :
            var data = JSON.parse(e.data);
            var Price = $('#ostyle').val() == 0 ? data.sp : data.bp;
            $("#new").html(parseFloat(Price).toFixed(length));
    }
}
</script>


<script type="text/javascript">


// 1美元  2港币 3欧元 4新加波元
var type = $("#currency").val();  //类型

  $("#submit").click(function(){

      layer.open({
          content: '您确定要买入？'
          ,btn: ['确定', '不要']
          ,yes: function(index){
            trade();
          }
      });
  });
  
</script>
<!--<script type="text/javascript" src="/Public/Home/css/layer/layer.js"></script>-->
<script>
    function trade() {
        // var index = layer.load(0, {
        //     shade: [0.1,'#fff'] //0.1透明度的白色背景
        // });
        var index = layer.open({type: 2});
        var hand      = $("#num span.selected").attr('data-value');    //手数
        // var profit    = $("#zhiying").html().replace(/[^\d.]/g,'');         //止盈
        var profit    = $("#stop_profit span.selected").attr('data-value'); //止盈
        var loss      = $("#loss span.selected").attr('data-value');    //止损金额
        var Bond      = $("#zhisun").html().replace(/[^\d.]/g,'');      //止损保证金
        var fee       = $("#jiaoyi").html().replace(/[^\d.]/g,'');      //交易综合费
        var foreign   = $("#heji").html().replace(/[^\d.]/g,'');        //合计费用外汇
        var heji_rmb  = $("#heji_rmb").html().replace(/[^\d.]/g,'');    //合计费用人民币
        var huobi     = $("#currency").val();                          //货币类型
        var ostyle    = $("#ostyle").val();                            //买入类型
        var id        = $("#id").val();                                //产品id
        var type_two  = $("#type").val();                              //1实盘交易  2虚拟交易

        $.ajax({
            url: "<?php echo U('transaction');?>",
            dataType: "json",
            type:"post",
            data: {'hand':hand,'profit':profit,'loss':loss,'Bond':Bond,'fee':fee,'foreign':foreign,'heji_rmb':heji_rmb,'type':huobi,'ostyle':ostyle,'id':id,'type_two':type_two},
            success: function(data){

                if(data.status === 0){

                    // layer.close(index);
                    // layer.msg(data.msg, {icon: 7});
                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    window.setTimeout("window.location='<?php echo U('User/account');?>'",2000);
                    return false;
                }

                if(data.status === 1){

                    layer.close(index);
                    // layer.msg(data.msg, {icon: 5});
                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    return false;
                }

                if(data.status === 2){

                    //    layer.close(index);
                    // layer.msg(data.msg, {icon: 6});
                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    window.setTimeout("window.location='<?php echo U("Position",array("pid" => $option[id],type => $type));?>'",500);
                    return false;
                }
            },
        });
    }
</script>