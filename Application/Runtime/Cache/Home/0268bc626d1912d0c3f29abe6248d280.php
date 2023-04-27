<?php if (!defined('THINK_PATH')) exit();?><script src="/Public/Home/js/3.1.1jq/jquery-3.1.1.min.js"></script>
<script src="/Public/Home/js/highstock.js"></script>
<script type="text/javascript" src="/Public/Home/css/layer/layer.js"></script>

<body style='margin-left: 0;margin-right: 0'>
<div id="container" style="height: 100%; min-width: 310px"></div>
<script type="text/javascript">
    var chart1; // 全局变量
    var length = "<?php echo ($length); ?>";
    var globalData=[];

    Highcharts.setOptions({
        global: {
            useUTC: false
        },
        legend: {
            enabled: false,
        },
        exporting: {
            enabled: false
        },
        credits: {
            enabled: false // 禁用版权信息
        },
        chart: {
            marginLeft: 3,
            marginRight: 3,
            events: {
                load: updateData1M
            },
        },
        title: {
            text: '',
        },
        plotOptions: {
            area: {
                enableMouseTracking: true
            },
            series: {
                states: {
                    hover: {
                        enabled: true,
                    }
                }
            },
        },
        tooltip: {
            enabled: true,
        },
        yAxis:{
            showLastLabel: false,

        },
    });
    
    function renderIt1M(data) {
        var ohlc    = [];

        dataLength = data.length,

            i = 0;
        for (i; i < dataLength; i += 1) {
            ohlc.push([
                data[i][0], // the date
                data[i][1] // open
            ]);
        }
        
        chart1 = new Highcharts.Chart('container', {
            xAxis: {

                type: 'datetime',
                showFirstLabel: true,
                showEmpty:false,
                labels: { //设置X轴各分类名称的样式style
                    formatter: function() {
                        var vDate = new Date(this.value);
                        minutes = vDate.getMinutes();
                        if(minutes < 10)minutes='0'+minutes;
                        return vDate.getHours() + ":" + (minutes);
                    }
                },
                gridLineWidth: 0.5,

            },

            tooltip: {
                enabled:true,
                formatter: function() {
                    var tip = "";
                    tip += Highcharts.dateFormat("%Y-%m-%d %H:%M", this.x, false) + "<br/>";
                    tip += "最新价：" + this.y + "<br/>";
                    return tip;
                },
                followTouchMove:false,
            },

            yAxis: {

                type: 'value',
                title: {
                    text: ''
                },
                labels: {
                    x: -47,
                    formatter: function(){
                        return this.value.toFixed(length);  //保留小数
                    }
                },

                tickPosition: 'inside',
                gridLineWidth: 0.5,
                opposite: true,

                plotLines:[{
                    color:'red',
                    dashStyle:'longdashdot',
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
            },

            plotOptions: {
                area: {
                    // fillColor: {
                    //     linearGradient: {
                    //         x1: 0,
                    //         y1: 0,
                    //         x2: 0,
                    //         y2: 1
                    //     },
                    //     stops: [
                    //         [0, Highcharts.getOptions().colors[0]],
                    //         [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                    //     ]
                    // },
                    marker: {
                        radius: 0
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
	        
            series: [{
                type: 'area',
                data: ohlc,
                lineWidth: 1,
                lineColor: '#3186cd',
                fillOpacity: 0.3,
                animation: false
            }]
        });
    }
    

    function Init1M() {

        var index = layer.load(2);
        var url     = "<?php echo U('getData',array('codes' => $code,'interval' => '1m','rows' => 300));?>";
        
        $.getJSON(url, function(data) {
			
            renderIt1M(data);
            globalData=data;
            layer.close(index);
        });
    };

    

    function updateData1M(price) {

        var chart   = $('#container').highcharts();
        series      = chart.series[0];

        price = parseFloat(price);

        if(globalData != '')
        {
            globalLength = globalData.length;

            lastData = globalData[globalLength-1];

            lastData[0] = getTimestamp();
            lastData[1] = price;

            globalData[globalLength-1] = lastData;
            series.setData(globalData);
        }


        yAxis = chart.yAxis[0];
        yAxis.removePlotLine('plot-line');
        yAxis.addPlotLine({
            color: 'red',
            dashStyle:'solid',
            value: price,
            width: 1,
            id: 'plot-line',
            label: {
                text: '<span style="color: #FFF;font-family:\'微软雅黑\'; background-color: #e4393c; margin-right: 10px;">' + price + '</span>',
                align: 'right',
                useHTML: true,
                y: 3,   //上下位置
                x: 55,  //左右位置
                style: {
                    color: 'red'
                },
            },
            zIndex:200
        });
    }

    //获取当前时间戳
    function getTimestamp(){
        var timestamp = (new Date()).getTime();
        var timestamp;
    }

    $(function() {
        Init1M();
        setInterval(Init1M, 30000);
    })
</script>
</body>