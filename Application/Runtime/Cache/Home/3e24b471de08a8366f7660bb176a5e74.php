<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, user-scalable=no,minimum-scale=1.0, maximum-scale=1.0">
<meta name="keywords" content="股指期货,期指,黄金,白银,沪深300,中证500,上证50">
<meta name="description" content="<?php echo tel('notice');?>">
    <title><?php echo config('s_domain_name'); echo config('webname');?></title>
    <link rel="stylesheet" href="/Public/Home/css/merge_product.css">
    <link rel="stylesheet" href="/Public/Home/css/index_merge.css">
    <link rel="stylesheet" href="/Public/Home/css/merge.css">
    <link rel="stylesheet" href="/Public/Home/css/wxcommon.css">
    <link rel="stylesheet" href="/Public/Home/css/index.css">
        
    <script typet="text/javascript" src="/Public/Home/js/1.9.1jq/jquery.min.js"></script>

  <link rel="stylesheet" href="/Public/Home/css/layerui/css/layui.css"  media="all">
    

    <style>
        .news-nav i {font-size:15px;}
        .page-footer .content .icon-zx {
            color: #DA3333;
        }

        .page-footer .content .icon-home {
            color: #B5B5B5;
        }
    </style>
</head>

<body class="page-news">
<div class="hbar">
    <div class="content">
        <h3>最新资讯</h3>
        <div class="arrow">
            <a href="<?php echo U('Index/index');?>" class="iconfont go-back icon-xiangzuojiantou"></a>
        </div>
    </div>
</div>



<div class="body" style="min-height:5rem;">
    <nav class="news-nav news-zhibo " >
    <?php if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="zhibo"><a href="<?php echo ($vo["methodnm"]); ?>"><i ><?php echo ($vo["fclass"]); ?></i></a></span><?php endforeach; endif; else: echo "" ;endif; ?>

</nav>
    <div class="timecon">
        <ul class="livecon" style="margin-top: 80px;">
      <?php if(is_array($a)): $i = 0; $__LIST__ = $a;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['content'] != '' ): ?><li class="flash  newsline-2016-11-10" id="">
               <a>
                  <div class="timeline"> 
                     <div class="dotbg">    
                        <div class="dot"></div>
                    </div>
                    <div class="time time<?php echo ($i); ?>"><?php echo ($vo["time"]); ?></div>
                    </div>
                    <div class="live-c onlytxt">
                    <div class="txt txt<?php echo ($i); ?>"><b><?php echo ($vo["content"]); ?></b> </div>
                    </div>
                </a>
        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
         </ul>
      <div id="LAY_demo1"></div>
    </div>

    <div id="full-loading" class="loading loadgif hide">
        <img class="loadin" src="/Public/Home/images/loading1x.png">
    </div>

</div>

<div class="img-layer hide2"><img style="-moz-user-select: none;"></div>
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

</body>
</html>

<script type="text/javascript">

  if($(".zhibo a i").html() == $(".zhibo a i").html()){
         
         $(".zhibo:first").addClass('on');
  }
</script>

          
<script src="/Public/Home/css/layerui/layui.js" charset="utf-8"></script>
<script>
layui.use('flow', function(){
  var flow = layui.flow;
 
  flow.load({
    elem: '#LAY_demo1' //流加载容器
    ,scrollElem: '' //滚动条所在元素，一般不用填，此处只是演示需要。
    ,done: function(page, next){ //执行下一页的回调

      //模拟数据插入
      setTimeout(function(){
        var lis = [];
        
          $.ajax({
                url: "<?php echo U('News/new_nwes');?>",
                dataType: 'json',
                type: 'get',
                // data:"page="+((page-1)*10)+"",
                data:"page="+((page-1))+"",
                success: function (data) {       

                        var html = '';
                        $.each(data,function(key,val){
                           
                           if(val.content != ''){
                                html += '<li class="flash  newsline-2016-11-10" id="">';
                                html += '<a>';
                                html += '<div class="timeline">';
                                html += '<div class="dotbg">';
                                html += '<div class="dot"></div>';
                                html += '</div>';
                                html += '<div class="time time<?php echo ($i); ?>">'+val.time+'</div>';
                                html += '</div>';
                                html += '<div class="live-c onlytxt">';
                                html += '<div class="txt txt<?php echo ($i); ?>"><b>'+val.content+'</b> </div>';
                                html += '</div>';
                                html += '</a>';
                                html += '</li>'; 
                        }
                    });
                    $(".livecon").append(html);
                }
            });
        next(lis.join(''), page < "<?php echo ($count); ?>"); 
      }, 1000);
    }
  });
  
  
});
</script>

</body>
</html>