<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SiteModel;
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model=new SiteModel();
        $date="2016-08-24";//date('Y-m-d',time());
        $date_y="2016-08-23";//date("Y-m-d",strtotime("-1 day"));

        $today=$model->data($date);
        $yesterday=$model->data($date_y);
        $max=$model->data_max();
        $avg=$model->average();

        return $this->render('analysis',[
            'today'=>$today,
            'yesterday'=>$yesterday,
            'max'=>$max,
            'avg'=>$avg,

        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render ('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionTrend()
    {
        return $this->render('trend');
    }
    public function actionTrend_data(){
        $model=new SiteModel();
        //$date="2016-08-24";//date('Y-m-d',time());
        $data=$model->data_min();
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    public function actionDaily(){


        return $this->render('daily');
    }
    public function actionToday(){
        $model=new SiteModel();
        $today=$_POST['today'];
        $type=$_POST['select_type'];
        if($type=='pv'){
            $result=$model->today_pv($today);
        }else{
            $result=$model->today_uv($today);
        }

        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }
    public function actionDiqu(){
        return $this->render('diqu');
    }

    public function actionReip(){
        $model=new SiteModel();
        $ip=$model->ip();

        /*$ip = '1.181.185.251'; //获取当前用户的ip
        $url = "http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
        $data = file_get_contents($url); //调用淘宝接口获取信息
        print_r(json_decode($data));*/
        echo json_encode($ip,JSON_UNESCAPED_UNICODE);;
    }
}
