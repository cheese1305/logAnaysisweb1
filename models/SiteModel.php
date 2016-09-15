<?php
/**
 * Created by PhpStorm.
 * User: na
 * Date: 2016/9/6
 * Time: 9:53
 */
namespace app\models;
use Yii;
use yii\base\Model;
class SiteModel extends Model
{
    public function data($date){
        //$date=date('Y-m-d',time());
        $sql=<<<EOF
        select sum(times) AS PV,count(IP) AS UV
        from dateIpNum where Udate="$date"
EOF;
        $connection=\yii::$app->db;
        $command = $connection->createCommand($sql);
        return $command->queryOne();
    }
    public function data_max(){
        $sql=<<<EOF
        SELECT SUM(times) AS PV,COUNT(IP) AS UV,Udate
        FROM dateIpNum GROUP BY Udate ORDER BY UV DESC
EOF;
        $connection=\yii::$app->db;
        $command = $connection->createCommand($sql);
        $result=$command->queryAll();
        return $result[0];
    }
    public function average(){
        $sql=<<<EOF
        SELECT AVG(PV) as apv,AVG(UV) as auv
        FROM data
EOF;
        $connection=\yii::$app->db;
        $command = $connection->createCommand($sql);
        $result=$command->queryOne();
        return $result;
    }
    public function data_min(){
        $sql=<<<EOF
        SELECT SUM(times) AS PV,COUNT(IP) AS UV,Udate
        FROM dateIpNum GROUP BY Udate ORDER BY Udate ASC
EOF;
        $connection=\yii::$app->db;
        $command = $connection->createCommand($sql);
        $result=$command->queryAll();
        return $result;
    }
    public function today($today,$yesterday){
        $connection=\yii::$app->db;
        $sql=<<<EOF
        select * from pv where logtime like '$today%' order by logtime ASC
EOF;
        $command = $connection->createCommand($sql);
        $result=$command->queryAll();
        $sql1=<<<EOF
        select * from pv where logtime like '$yesterday%' order by logtime ASC
EOF;
        $command1 = $connection->createCommand($sql1);
        $result1=$command1->queryAll();
        $result2=array_merge($result,$result1);
        return $result2;

    }
    public function ip(){
        $sql=<<<EOF
        SELECT IP,COUNT(1) AS 重复数
        FROM dateIpNum
        GROUP BY IP
EOF;
        $connection=\yii::$app->db;
        $command = $connection->createCommand($sql);
        $result=$command->queryAll();
        for($i=0;$i<count($result);$i++){
            $url = "http://ip.taobao.com/service/getIpInfo.php?ip=".$result[$i]['IP'];
            $data = file_get_contents($url); //调用淘宝接口获取信息
            $data1=json_decode($data,true);
            //$data2=(array)$data1;
            $result[$i]['地址']=$data1['data']['region'];
        }

        return $result;

    }

}