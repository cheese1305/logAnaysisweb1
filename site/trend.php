<?php
/**
 * Created by PhpStorm.
 * User: na
 * Date: 2016/9/7
 * Time: 16:52
 */
$this->title = '总体流量分析';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$js=<<<EOF

    var PV_arr=new Array();
    var UV_arr=new Array();
    var date_arr=new Array();
    var id='pv';
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));
    $.post('trend_data',{
    },function(data){
        var msg=data;
        data=JSON.parse(data);
        var data_length=data.length;
        for(var i=0;i<data_length;i++){
            date_arr[i]=data[i]['Udate'];
            PV_arr[i]=data[i]['PV'];
            UV_arr[i]=data[i]['UV'];
        }
        ac(id);
        $('.title> li > a').on('click', function () {
            id =$(this).attr("id");
            ac(id);
        });
        function ac(id){
            if(id=='pv'){
                $("#uv").parent().removeClass("active");
                $("#"+id).parent().attr({class:"active"});
                var myChart = echarts.init(document.getElementById('main'));
                var option = {
                    title: {
                        text: 'PV分析'
                    },
                    tooltip: {
                        trigger:'axis'
                    },
                    legend: {
                        //data:['PV']
                    },
                    xAxis: {
                        data: date_arr
                    },
                    yAxis: {
                        splitLine: {
                        show: false
                    }
                },
                toolbox: {
                    left: 'center',
                    feature: {
                        dataZoom: {
                            yAxisIndex: 'none'
                        },
                    restore: {},
                    saveAsImage: {}
                    }
                },
                dataZoom: [{
                    startValue: '2016-07-04'
                }, {
                    type: 'inside'
                }],
                visualMap: {
                    top: 10,
                    right: 10,
                    pieces: [{
                        gt: 0,
                        lte: 50000,
                        color: '#096'
                    }, {
                        gt: 50000,
                        lte: 100000,
                        color: '#ffde33'
                    }, {
                        gt: 100000,
                        lte: 150000,
                        color: '#ff9933'
                    }, {
                        gt: 150000,
                        lte: 200000,
                        color: '#cc0033'
                    }, {
                        gt: 200000,
                        lte: 250000,
                        color: '#660099'
                    }, {
                        gt: 250000,
                        lte:300000,
                        color: '#7e0023'
                    },{
                        gt: 300000,
                        color: '#000000'
                    }],
                    outOfRange: {
                        color: '#999'
                    }
                },
                series: [{
                    name: 'PV',
                    type: 'line',
                    data: PV_arr,
                    markLine: {
                        silent: true,
                        data: [{
                            yAxis: 50000
                        }, {
                            yAxis: 100000
                        }, {
                            yAxis: 150000
                        }, {
                            yAxis: 200000
                        }, {
                            yAxis: 250000
                        }, {
                            yAxis: 300000
                        }]
                    }
                }]
            };
            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);
        }else{
            $("#pv").parent().removeClass("active");
        $("#"+id).parent().attr({class:"active"});
        var myChart = echarts.init(document.getElementById('main'));
        // 指定图表的配置项和数据
        var option = {
            title: {
                text: 'UV分析'
            },
            tooltip: {},
            legend: {
                data:['UV']
            },
            xAxis: {
                data: date_arr
            },
            yAxis: {},
            series: [{
                name: 'UV',
                type: 'bar',
                data: UV_arr
            }]
        };
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
        }
        }
});

EOF;
$this->registerJs($js);
?>
<ul class="nav nav-tabs title">
    <li class="active"><a href="#" id="pv">PV分析</a></li>
    <li><a href="#" id="uv">UV分析</a></li>
</ul>
<br/>
<div class="row">
    <div class="col-md-2">

    </div>
    <div class="col-md-2">

    </div>
</div>
<br/>
<div id="main" style="width: 900px;height:500px;">
</div>


