<?php
/**
 * Created by PhpStorm.
 * User: huangdaneng
 * Date: 2017/7/31
 * Time: 下午6:01
 */
namespace api\common\controllers;

use common\models\Lesson;
use common\models\User;
use common\models\UserCoinLog;
use common\models\Vod;
use common\util\Constants;
use common\util\Utils;
use yii\base\UserException;
use yii\filters\VerbFilter;


class ApiController extends BaseController {

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);
        unset($behaviors['encrypter']);
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'response' => [
                    'post',
                    'options',
                    'get',
                ]
            ]
        ] ;
        return $behaviors;
    }

    public function actionResponse()
    {
        return [ 'data' => 1];
    }

}