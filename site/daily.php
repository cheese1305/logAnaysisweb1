<?php
/**
 * Created by PhpStorm.
 * User: na
 * Date: 2016/9/13
 * Time: 9:48
 */
$this->title = '今日流量分析';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$js=<<<EOF
var time=new Array();
var degree=new Array();
var yes_degree=new Array();
var date="2016-09-05";
var yes_date="2016-09-04";
$.post('today',{
    'today':date,
    'yesterday':yes_date
},function(data){
    data=JSON.parse(data);
    var data_length=data.length;
    for(var i=0;i<data_length;i++){
        var j=data[i]['logtime'];
        time[i]=j.substring(11);
        if(j.substring(0,10)==date){
            degree[i]=data[i]['times'];
        }else{
            var k=i-24;
            yes_degree[k]=data[i]['times'];
        }
    }
    chart(time,degree,yes_degree);


});
function chart(time,degree,yes_degree){
    var myChart = echarts.init(document.getElementById('main'));
    // 指定图表的配置项和数据
    var option = {
    title: {
        text: '今日PV'
    },
    tooltip: {
        trigger: 'axis'
    },
    legend: {
        data:['今日','昨日']
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    toolbox: {
        feature: {
            saveAsImage: {}
        }
    },
    xAxis: {
        type: 'category',
        boundaryGap: false,
        data: time
    },
    yAxis: {
        type: 'value'
    },
    series: [
        {
            name:'今日',
            type:'line',
            stack: '总量',
            data:degree,
            markPoint: {
                data: [
                    {type: 'max', name: '最大值'},
                    {type: 'min', name: '最小值'}
                ]
            },
            markLine: {
                data: [
                    {type: 'average', name: '平均值'}
                ]
            }
        },
        {
            name:'昨日',
            type:'line',
            stack: '总量',
            data:yes_degree,
            markPoint: {
                data: [
                    {type: 'max', name: '最大值'},
                    {type: 'min', name: '最小值'}
                ]
            },
            markLine: {
                data: [
                    {type: 'average', name: '平均值'}
                ]
            }
        }
    ]
};

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
}
EOF;
$this->registerJs($js);
?>
<div class="btn-group">
    <button type="button" class="btn btn-default">今日</button>
    <button type="button" class="btn btn-default">昨日</button>
    <button type="button" class="btn btn-default">按钮 3</button>
</div>
<br/><br/><br/>
<div id="main" style="width: 900px;height:500px;">
</div>

