<?php
/**
 * Created by PhpStorm.
 * User: na
 * Date: 2016/9/13
 * Time: 9:48
 */
$this->title = '今日流量分析';
$this->params['breadcrumbs'][] = $this->title;
use yii\jui\DatePicker;
?>
<?php
$js=<<<EOF
var time=new Array();
var degree=new Array();
var yes_degree=new Array();
var yes_date="2016-09-04";

$("button").click(function(){
    var select_time=$('#select_time').val();
    var select_type;
    if($(this).attr("id")==="btn1"){
        select_type='pv';
    }else{
        select_type='uv';
    }
    $.post('today',{
            'today':select_time,
            'select_type':select_type
        },function(data){
            data=JSON.parse(data);
            var data_length=data.length;
            for(var i=0;i<data_length;i++){
                var j=data[i]['logtime'];
                if(j.substring(0,10)==select_time){
                    time[i]=j.substring(11);
                    degree[i]=data[i]['times'];
                }else{
                    var k=i-24;
                    yes_degree[k]=data[i]['times'];
                }
            }
            console.log(time);
            console.log(degree);
            console.log(yes_degree);
        chart(time,degree,yes_degree);
    });
});
function chart(time,degree,yes_degree){
    var myChart = echarts.init(document.getElementById('main'));
    // 指定图表的配置项和数据
    var option = {
    title: {
        text: ''
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
<div class="row">
    <label class="col-md-2" >请选择查询日期：</label>
    <div class="col-md-2">
        <?php
        echo DatePicker::widget([
            'id'   =>  'select_time',
            'name'  => 'select_time',
            'language' => 'zh',
            'dateFormat' => 'yyyy-MM-dd',
            'value'  => date("Y-m-d"),
        ]); ?>
    </div>

    <div class="btn-group col-md-4">
        <button type="button" class="btn btn-default" id="btn1">PV(Page View)</button>
        <button type="button" class="btn btn-default" id="btn2">UV(User View)</button>
    </div>
</div>
<br/>

<br/><br/>
<div id="main" style="width: 900px;height:500px;">
</div>

