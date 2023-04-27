<?php if (!defined('THINK_PATH')) exit();?><script src="/Public/Home/js/3.1.1jq/jquery-3.1.1.min.js"></script>
<script src="/Public/Home/js/highstock.js"></script>
<script type="text/javascript" src="/Public/Home/css/layer/layer.js"></script>

<body style='margin-left: 0;margin-right: 0'>
    <div id="container" style="height: 100%; min-width: 310px"></div>
    <script type="text/javascript">

    var length = "<?php echo ($length); ?>";
    var globalData=[];

    Highcharts.setOptions({
        global: {
            useUTC: false
        },
        legend: {
            enabled: false,   //禁止图例
        },
        exporting: {
            enabled: false   //设置导出按钮不可用
        },
        credits: {
            enabled: false // 禁用版权信息
        },
        chart: {
            backgroundColor: 'rgba(31,34,43,1)',  //设置透明背景颜色
            events: {
                load: updateData1M
            },
        },
        plotOptions: {

            candlestick: {

                upColor: '#F85654',   //设置k线图的颜色
                upLineColor: '#F85654',

                color: '#1FC65B',
                lineColor: '#1FC65B',

                lineWidth: 1,   //线条宽度
                pointWidth:3    //柱子宽度
            },
            column: {   //柱状图宽以及间距
                pointPadding: 10,
                borderWidth:2
            },

            series: {   //点击均线时禁止放大
                states: {
                    hover: {
                        enabled: false,
                        radius:2
                    }
                }
            },
            tooltip: {
                enabled: true,
            },
            yAxis:{
                showLastLabel: false,   //是否显示坐标轴的最后一个标签。 默认是：true.

            },
        },
        lang: {
            resetZoom: '重置',
            resetZoomTitle: '重置缩放比例'
        }
    });


    function renderIt1D(data)
    {
        var ohlc    = [],
            volume      = [],
            maset       = [5,10,20,30],
            ma          = [],

            dataLength  = data.length,

            i = 0;

        for (i; i < dataLength; i += 1) {
            ohlc.push([
                data[i][0], // the date
                data[i][1], // open
                data[i][2], // high
                data[i][3], // low
                data[i][4] // close
            ]);

            // volume.push([    //成交量
            //     data[i][0], // the date
            //     data[i][4] // the volume
            // ]);

            $.each(maset,function(index,value){

                if(typeof ma['ma'+value] == "undefined"){
                    ma['ma'+value]=[];
                }
                if(typeof ma[value+'total'] == "undefined"){
                    ma[value+'total']=0;
                }
                if(i<value)
                {
                    ma[value+'total'] += data[i][4];
                    ma['ma'+value].push([data[i][0],null]);
                } else {
                    ma[value+'total'] += (data[i][4] - data[i-value][4]);
                    ma['ma'+value].push([data[i][0], ma[value+'total']/value]);
                }
            });
        }
        //判断ma是否为null
        if(ma['ma5'][dataLength-1][1] == null)
            m5 = null;
        else
            m5 = ma['ma5'][dataLength-1][1].toFixed(2);

        if(ma['ma10'][dataLength-1][1] == null)
            m10 = null;
        else
            m10 = ma['ma10'][dataLength-1][1].toFixed(2);

        if(ma['ma20'][dataLength-1][1] == null)
            m20 = null;
        else
            m20 = ma['ma20'][dataLength-1][1].toFixed(2);


        $('#container').highcharts('StockChart', {

            chart: {
                panning: true,
                pinchType: 'x',
                zoomType: 'x',
                // resetZoomButton: {
                //     position: {
                //         x: 0,
                //         y: -60
                //     }
                // },
                resetZoomButton: {
                    // 按钮定位
                    position: {
                        align: 'right', // by default
                        verticalAlign: 'top', // by default
                        x: 30,
                        y: -10
                    },
                },
                backgroundColor: 'rgba(0,0,0,0)',
                renderTo: $('#container')[0],
                animation: {
                    duration: 600,  //更长时间动画
                    // easing: 'easeOutBounce' //jQuery UI缓慢动画：
                }
            },
            //右上角日期格式
            rangeSelector: {
                enabled:false,
                selected: 1,
                inputDateFormat: '%Y-%m-%d'
            },

            //滚动条
            scrollbar: {
                enabled: false,   //是否显示 滚动条
                liveRedraw: false //设置scrollbar在移动过程中，chart不会重绘
            },
            //导航器
            navigator: {
                enabled:false,  //导航器
                adaptToUpdatedData: true,   //导航器和滚动条是否应适应基础中的更新数据
                margin:0,
                height:20,
                handles:{backgroundColor:'red',borderColor:'yellow'}
            },
            title: {
                text: ''
            },
            subtitle: {
                // text: '<p style="color:#000;"><span style="color:red;background:#000">MA5:'+m5+'</span>  <span style="color:green;">MA10:'+m10+'</span>  <span style="color:#cccc5b">MA20:'+m20+'</span></p>',
                // align:'left',
            },

            tooltip: {
                enabled: true,
                formatter: function() {
                    try{
                        open  = this.points[0].point.open.toFixed(2);        /* 开盘 */
                        close = this.points[0].point.close.toFixed(2);       /* 收盘 */
                        high  = this.points[0].point.high.toFixed(2);        /* 最高 */
                        low   = this.points[0].point.low.toFixed(2);         /* 最低 */
                        // y     = (this.points[1].point.y*0.0001).toFixed(2);  /* 成交量 */
                        MA5   = this.points[1].y.toFixed(2);
                        MA10  = this.points[2].y.toFixed(2);
                        MA20  = this.points[3].y.toFixed(2);
                    }catch(e){
                    }

                    var tip = "";
                    
                    try{
                        // tip = this.points[0].series.name+"<br/> ";
                        tip += Highcharts.dateFormat("%Y-%m-%d %H:%m", this.x, false) + "<br/>";
                        tip += "开盘价：" + open + "<br/>";
                        tip += "收盘价：" + close + "<br/>";
                        tip += "最高价：" + high + "<br/>";
                        tip += "最低价：" + low + "<br/>";
                        // if(y>10000){
                        //     tip += "成交量："+(y*0.0001).toFixed(2)+"(亿股)<br/>";
                        // }else{
                        //     tip += "成交量："+y+"(万股)<br/>";
                        // }
                        tip += "MA5：" + MA5 + "<br/>";
                        tip += "MA10：" + MA10 + "<br/>";
                        tip += "MA20：" + MA20 + "<br/>";
                    }catch(e){
                    
                    }
                    return tip;
                },
                followTouchMove:false,
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    millisecond: '%H:%M:%S.%L',
                    second: '%H:%M:%S',
                    minute: '%H:%M',
                    hour: '%H:%M',
                    day: '%m-%d',
                    week: '%m-%d',
                    month: '%y-%m',
                    year: '%Y'
                },
                labels: {
                    enabled: true, //是否显示x轴时间抽
                },
                //tickWidth: 0,       //去掉最下方白角
                //lineWidth: 0.5,      //x轴宽度
                crosshair: false,   //点击时禁止出现线条
                // crosshair: {
                //     width: 1,
                //     color: 'red'
                // },
                tickPixelInterval:80,   //时间抽刻度显示 像素间隔

            },
            yAxis: [{
                type:'value',
                crosshair: false,
                // crosshair: {
                //     width: 1,
                //     color: 'red'
                // },

                plotLines:[{
                    color:'red',
                    dashStyle:'dash',
                    value:ohlc[dataLength-1][1],       //定义在那个值上显示标示线，
                    width:0.5,       //标示线的宽度，2px
                    id:'plot-line',
                    label:{
                        text:ohlc[dataLength-1][1],
                        align:'right',
                        x:-10,
                        y: -15,
                        style: {
                            color: 'red'
                        }
                    }
                }],

                labels: {
                    zIndex: 4,
                    y: -10,
                    x: 5,   //最右侧值显示的位置
                    formatter: function() {
                        return this.value.toFixed(length);
                    }
                },
                title: {
                    enabled:false,
                    text:'数据'
                },
                height: '100%',
                lineWidth: 0,
                gridLineWidth: 0.5, //中间值的宽度
                opposite: true,
                offset:42 //y轴左右距离
            },
                {
                    labels: {
                        enabled:true,
                        align: 'right',
                        x: 10
                    },
                    title: {
                        enabled:false,
                        text: '成交量'
                    },
                    top: '75%',
                    height: '25%',
                    offset: 0,
                    lineWidth: 0,
                    gridLineWidth: 0,
                    opposite: true,
                }],
            plotOptions: {
                column: {
                    pointPadding: 10,
                    borderWidth:2
                }
            },
            series: [{
                type: 'candlestick',
                data: ohlc,
                dataGrouping: {
                    enables:false
                },
                yAxis: 0,
                fillOpacity: 0.3,
                animation: false
            }, {
                animation: false,
                type: 'column',
                name: 'Volume',
                data: volume,
                yAxis: 1,
                dataGrouping: {
                    enables:false
                }
            },
                {
                    type: 'spline',
                    name: 'MA5',
                    color:'red',
                    data: ma['ma5'],
                    lineWidth:0.8,
                    yAxis: 0,
                },
                {
                    type: 'spline',
                    name: 'MA10',
                    color:'green',
                    data: ma['ma10'],
                    lineWidth:0.8,
                    yAxis: 0
                },
                {
                    type: 'spline',
                    name: 'MA20',
                    color:'#cccc5b',
                    data: ma['ma20'],
                    lineWidth:0.8,
                    yAxis: 0
                }
            ]
        });
    }
    
    function Init1D() {
        var index = layer.load(2);
        var url     = "<?php echo U('getData',array('codes' => $code,'interval' => $interval,'rows' => 200));?>";
        
        $.getJSON(url, function(jsondata) {

            //过滤k线图异常数据
            var data = [];
            $.each(jsondata,function (key,val) {
                if(val[1] != 0 && val[2] != 0 && val[3] != 0 && val[4] != 0) {
                    data.push(val);
                }

                //开盘
                // if(val[1] == 0) {
                //     val[1] = val[4] + Math.random().toFixed(length);
                // }
                //
                // //收盘
                // if(val[4] == 0) {
                //     val[4] = val[1] - Math.random().toFixed(length);
                // }
                //
                // //最高
                // if(val[2] == 0) {
                //     val[2] = val[1] + Math.random().toFixed(length);
                // }
                //
                // //最低
                // if(val[3] == 0) {
                //     val[3] = val[1] - Math.random().toFixed(length);
                // }
                //
                // data.push(val);
            });

            renderIt1D(data);
            globalData = data;
            // renderIt1D(jsondata);
            // globalData = jsondata;
            layer.close(index);
        });
    };


    function updateData1M(price)
    {

        var chart   = $('#container').highcharts();
        series      = chart.series[0];
        
        //实时更新k线图
        // console.log(series.yData);
        //chart.series[0].addPoint([1,2,3,4,5], true,true);

        price = parseFloat(price);

        if(globalData != '')
        {
            globalLength = globalData.length;

            lastData = globalData[globalLength-1];

            lastData[4] = price;

            if(lastData[2] < price)
                lastData[2] = price;

            if(lastData[3] > price)
                lastData[3] = price;

            globalData[globalLength-1] = lastData;

            // console.log(lastData);
            // console.log(series.yData[39]);

            series.setData(globalData);
        }
        

        yAxis = chart.yAxis[0];
        yAxis.removePlotLine('plot-line');
        yAxis.addPlotLine({
            color: 'red',
            dashStyle:'dash',
            value: price,
            width: 1,
            id: 'plot-line',
            label: {
                text: '<span style="color: #FFF;font-family:\'微软雅黑\'; background-color: #e4393c; margin-right: 10px;">' + price + '</span>',
                align: 'right',
                useHTML: true,
                y: 3,    //上下位置
                x: 55,   //左右位置
                style: {
                    color: 'red'
                },
            },
            zIndex:200
        });
    }


    window.onload=function()
    {
        try{
            Init1D();
        }catch(e){
        }
    }
    </script>
</body>