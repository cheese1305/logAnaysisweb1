<?php
/**
 * Created by PhpStorm.
 * User: na
 * Date: 2016/9/11
 * Time: 8:16
 */
namespace app\controllers;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';
}