<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html style="display: block;">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0">
<meta name="keywords" content="股指期货,期指,黄金,白银,沪深300,中证500,上证50">
<meta name="description" content="<?php echo tel('notice');?>">
    <title class="productName"><?php echo config('s_domain_name'); echo config('webname');?></title>

    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="stylesheet" href="/Public/Home/css/index_merge.css">
    <script typet="text/javascript" src="/Public/Home/js/1.8.3jq/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/layer_mobile/layer.css">
    <script type="text/javascript" src="/Public/Home/css/layer_mobile/layer.js"></script>
    <!--da fan ge-->
    <!--<script type="text/javascript" src="/Public/Home/js/jquery.event.drag-1.5.min.js"></script>-->
    <script type="text/javascript" src="/Public/Home/js/jquery.touchSlider.js"></script>
</head>

<style type="text/css">
.red{color: red;}
.green{color: #17b03e;}
.layui-m-layercont p img{width: 100%;}
</style>

<body>
<div id="doc" class="doc page-home" data-url-query-index="/quote">
    <!-- 头部 -->
    <header class="page-header">
        <div class="content">
            <h3 class="productName"><?php echo config('s_domain_name'); echo config('webname');?></h3>
<!--             <div class="right">
                <a id="login" href="<?php echo U('newtrader');?>">新手?</a>
            </div> -->
        </div>
    </header>

    <!-- 内容 -->
    <section class="page-main main-home" style="padding-top:0.5rem;">
    <input type="hidden" value="<?php echo (session('user_id')); ?>" id="user_id">

        <div class="content">

                <!-- 图片传送带 -->
     <div class="mod-carousel">
                <!--轮播-->
                <!--<ul class="clearfix">-->
                   <!--<?php if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>-->
                     <!--<li>-->
                         <!--<a href="<?php echo U('newtrader',array('nid' => $vo['nid']));?>">-->
                             <!--<img src="../../Uploads/<?php echo ($vo["ncover"]); ?>">-->
                         <!--</a>-->
                     <!--</li>-->
                     <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                <!--</ul>-->
         <!--图论-->
         <div class="main_visual">
            <div class="flicking_con">
                <?php if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="#"></a><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
             <div class="main_image">
                 <ul>
                  <?php if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('newtrader',array('nid' => $vo['nid']));?>">
                      <li><span class="img_3"><img src="../../Uploads/<?php echo ($vo["ncover"]); ?>"></span></li>
                    </a><?php endforeach; endif; else: echo "" ;endif; ?>
                 </ul>
                 <a href="javascript:;" id="btn_prev" style="display: none"></a>
                 <a href="javascript:;" id="btn_next" style="display: none"></a>
             </div>
         </div>
                <div class="clearfix"></div>
            </div>
        <!-- 图片传送带 -->
<!--           <div id="onLine">
                <div class="onMain">
                    <div class="line_left" id="rank"><a href="" style="color:#da2f35; display:block; width:0.9rem; height:0.21rem; margin-top:0.05rem"><font style="color: #000">当前在线</font><?php echo ($users_online); ?><font style="color: #000">人</font></a></div>

                    <ul class="line_right">

                    <li style="top: -0.35rem;">***39<span> 12:15 </span><span style="color:#17b03e">做空</span><span> 美原油</span></li><li style="top: -0.35rem;">***88<span> 12:15 </span><span style="color:#17b03e">做空</span><span> 美原油</span></li><li style="top: 0px;">***23<span> 12:15 </span><span style="color:#17b03e">做空</span><span> 美原油</span></li><li>***02<span> 12:15 </span><span style="color:#d0402d">做多</span><span> 美原油</span></li><li>***93<span> 12:15 </span><span style="color:#d0402d">做多</span><span> 美原油</span></li>
                    </ul>
                </div>
            </div> -->

            <div class="marketing">
                <ul class="indexList">

                  <li id="service">
                        <a href="<?php echo U('newtrader');?>" id="tuig" class="clearfix">
                            <span class="icon-icon_ad2 index-icon"></span>
                            <p class="left">
                            </p><div class="text-s18">新手指引</div>
                            <p></p>
                        </a>
                    </li>
                <?php if($trade == 1): ?><li class="">
                        <i class="icon-chicang chicang "></i>
                            <a href="<?php echo U('Simulation/index');?>" class="czhongying.gwecaopan.comlearfix">
                            <span class="icon-moni index-icon"></span>
                            <p class="left">
                            </p><div class="text-s18">模拟交易</div>
                            <p></p>
                        </a>
                    </li><?php endif; ?>

                    <li id="service">
                        <?php if($user['code'] == ''): ?><a id="extension" class="clearfix">
                        <?php else: ?>
                            <a href="<?php echo U('User/extension');?>" id="tuig" class="clearfix"><?php endif; ?>
                            <span class="icon-icon_ad index-icon"></span>
                            <p class="left">
                            </p><div class="text-s18">推广赚钱</div>
                            <p></p>

                        </a>
                    </li>

                    <li id="service">

                        <a href="tel:<?php echo config('utel');?>" id="tuig" class="clearfix">
                            <span class="icon-kefu index-icon"></span>
                            <p class="left">
                            </p><div class="text-s18">联系我们</div>
                            <p></p>

                        </a>
                    </li>

                </ul>
            </div>
            <!-- 0428 end-->
            <!--实盘交易开始-->
            <div class="bargainTitle">
                <div>实盘交易</div>
            </div>
            <!--实盘交易结束-->
        <div class="mod-hot">
         <?php if(is_array($result)): foreach($result as $k=>$lt): ?><div class="tradeType" id="gupji"><?php echo ($k); ?></div>
                <ul class="mod-list hot-comm-list" id="hot-comm-list">
             <?php if(is_array($lt)): $i = 0; $__LIST__ = $lt;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="hidden" class="capital_key" value="<?php echo ($vo["capital_key"]); ?>">
             <input type="hidden" id="length<?php echo ($vo["capital_key"]); ?>" value="<?php echo ($vo["capital_length"]); ?>">

            <?php if($vo['global_flag'] == 1): ?><li class="tradeList" tradeid="HSI">
                    <a href="<?php echo U('product',array('id'=>$vo['id']));?>">
                       <span class="img">

                    <?php if($vo['color']): ?><i class="<?php echo ($vo["color"]); ?>" usename="CL" style="color:#BD6959"></i>
                    <?php else: ?>
                        <i class="<?php echo ($vo["option_key"]); ?>" usename="CL" style="color:#BD6959"></i><?php endif; ?>

                        </span>
                            <div class="list-info">
                                <p>
                                <!-- <?php if($vo['type'] == 2): ?><span class="list-name block"><?php echo ($vo["capital_name"]); ?>  <font style="color: red;font-size: 12px;">new</font></span>

                                        <?php elseif($vo['type'] == 3): ?>
                                         <span class="list-name block"><?php echo ($vo["capital_name"]); ?>  <font style="color: red;font-size: 12px;">hot</font></span>

                                        <?php else: ?>
                                         <span class="list-name block"><?php echo ($vo["capital_name"]); ?></span><?php endif; ?> -->
                                <span class="list-name block"><?php echo ($vo["capital_name"]); ?></span>
                                  <?php if($vo['flag'] == 0): ?><span class="list-img ">
                                        <i class="right-icon">
                                            <span class="icon-sun icon-star"></span>
                                            <span class="icon-moon icon-star"></span>
                                            <i class="list-txt">T+0</i>
                                        </i>
                                    </span>
                                        <p>
                                          <span class="gray mt02"><?php echo ($vo["option_intro"]); ?></span>
                                          <span class="gray list-time">已休市</span>
                                        </p>
                                <?php else: ?>
                                    <span class="list-img ">
                                         <i class="right-icon">
                                            <span class="text-range  red <?php echo ($vo["capital_key"]); ?>" data-key="<?php echo ($vo["capital_key"]); ?>"><?php echo ($vo["Price"]); ?>&nbsp;&nbsp;<?php echo ($vo["DiffRate"]); ?>%</span>
                                         </i>
                                    </span>
                                       <p>
                                              <span class="gray mt02"><?php echo ($vo["option_intro"]); ?></span>
                                              <span class="gray list-time"><?php echo shijian($vo[id]);?></span>
                                        </p><?php endif; ?>
                                </p>
                                <div class="right-arrow"></div>
                            </div>
                    </a>
                </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>

               </ul><?php endforeach; endif; ?>

            <div style="text-align: center;margin-top:.04rem;display:hidden;">
                <p class="text-lesser" id="tele">客服电话：<?php echo config('utel');?></p>
                <p class="text-lesser">交易由香港交易所及纽约商品交易所及欧洲期货交易所实盘对接</p>
                <p class="text-lesser1">合作伙伴: 平安保险|南华期货|芝加哥商品交易所|港交所</p>
            </div>
    </div>
</section>


    <div id="newMask">
        <div class="Maskcon">
            <div id="newNone"></div>
            <h3></h3>
            <p></p>
            <a href="javascript:;">查看详情</a>
        </div>
    </div>

    <!-- 底部 -->


<footer class="page-footer">
    <div class="content">
        <ul>
            <li class="home">
                <a href="<?php echo U('Index/index');?>">
                    <span class="icon-home img"></span><span>首页</span>
                </a>
            </li>
            <li class="trade">
                <a href="<?php echo U('Index/product');?>">
                    <span class="icon-jiaoyi img" style="line-height: 0.18rem;"></span><span>交易</span>
                </a>
            </li>
            <li class="ziXun">
                <a href="<?php echo U('News/index');?>">
                    <span class="icon-zx img"></span><span>资讯</span>
                </a>
            </li>
            <li class="mine">
                <a href="<?php echo U('User/index');?>">
                    <span class="icon-gerne img"></span><span class="active">我的</span>
                </a>
            </li>
        </ul>
    </div>
</footer>
</div>
<?php if($info['content'] != '' ): ?><div class="layer_notice" style="background: #5FB878;width: 100%; height: 100%;padding: 5px 10px;display: none;font-size: 0.16rem;color:#fff;">
    <?php echo ($info["content"]); ?>
</div>

<script type="text/javascript">
  layer.open({
    time:10,
    title:false,
    content: $('.layer_notice').html(),
    btn: '我知道了'
  });
</script><?php endif; ?>
</body>
</html>

<!--JS轮播-->
<script type="text/javascript">
    $(document).ready(function(){

        $(".main_visual").hover(function(){
            $("#btn_prev,#btn_next").fadeIn()
        },function(){
            $("#btn_prev,#btn_next").fadeOut()
        });

        $dragBln = false;

        $(".main_image").touchSlider({
            flexible : true,
            speed : 200,
            btn_prev : $("#btn_prev"),
            btn_next : $("#btn_next"),
            paging : $(".flicking_con a"),
            counter : function (e){
                $(".flicking_con a").removeClass("on").eq(e.current-1).addClass("on");
            }
        });

        $(".main_image").bind("mousedown", function() {
            $dragBln = false;
        });

        $(".main_image").bind("dragstart", function() {
            $dragBln = true;
        });

        $(".main_image a").click(function(){
            if($dragBln) {
                return false;
            }
        });

        timer = setInterval(function(){
            $("#btn_next").click();
        }, 5000);

        $(".main_visual").hover(function(){
            clearInterval(timer);
        },function(){
            timer = setInterval(function(){
                $("#btn_next").click();
            },5000);
        });

        $(".main_image").bind("touchstart",function(){
            clearInterval(timer);
        }).bind("touchend", function(){
            timer = setInterval(function(){
                $("#btn_next").click();
            }, 5000);
        });

    });
</script>
<script type="text/javascript">
var arr = [];
$.each($('.capital_key'),function(){
   var key = $(this).val();
   arr.push(key);
});
var arrString = arr.join(',');
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
           // console.log(e.data);
            var data     = JSON.parse(e.data);
            var operator = data.DiffRate <=0 ? '' : '+';
            var length   = $('#length'+data.capital_key+'').val();
            data.Price   = data.Price.toFixed(length);

            $('.'+data.capital_key+'').html(data.Price +'&nbsp;&nbsp;'+operator+data.DiffRate+'%');
            if(data.DiffRate < 0) {
                $('.'+data.capital_key+'').removeClass('red').addClass('green');
            } else {
                $('.'+data.capital_key+'').removeClass('green').addClass('red');
            }
    }
};



//推广赚钱
$("#extension").click(function(){

  var user_id = $("#user_id").val();
    //询问框
    layer.open({
    content: '你确定要成为推广者吗'
    ,btn: ['是的', '不要']
    ,yes: function(index){
      if(user_id == ''){
        window.location="<?php echo U('User/login');?>";return false;
      }

        $.ajax({
            url:"<?php echo U('User/ExtensionIs');?>",
            dataType: 'json',
            type: 'get',
            success:function(data){

                if(data.code == 1){

                    window.location="<?php echo U('User/extension');?>";

                } else{

                    layer.open({
                    content: '失败了，请稍候再试'
                    ,skin: 'msg'
                    ,time: 2
                    });
                }

            }
        });
    }
});
});
</script>