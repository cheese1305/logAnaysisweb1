<?php
/**
 * Created by PhpStorm.
 * User: na
 * Date: 2016/9/5
 * Time: 11:15
 */

$this->title = '数据分析';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <table class="table table-striped table-bordered table-hover table-condensed">
        <caption><h4>网站概况</h4></caption>
        <thead>
        <tr>
            <th></th>
            <th>浏览量(PV)</th>
            <th>访客数(UV)</th>
            <th>平均访问时长</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>今日</th>
            <th><?php echo $today['PV'];?></th>
            <th><?php echo $today['UV'];?></th>
            <th>288.35</th>
        </tr>
        <tr>
            <th>昨日</th>
            <th><?php echo $yesterday['PV'];?></th>
            <th><?php echo $yesterday['UV'];?></th>
            <th>173.99</th>
        </tr>
        <!--<tr>
            <th>预计今日</th>
        </tr>-->
        <tr>
            <th>每日平均</th>
            <th><?php echo $avg['apv'];?></th>
            <th><?php echo $avg['auv'];?></th>
            <th>--</th>
        </tr>
        <tr>
            <th>历史峰值</th>
            <th><?php echo $max['PV'];?></th>
            <th><?php echo $max['UV'];?></th>
            <th>--</th>
        </tr>
        </tbody>
    </table>

</div>
