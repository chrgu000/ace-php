<?php

namespace backend\controllers;

use common\models\Merchant;
use common\service\StvMerchantApi;
use Yii;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * AdminUserController implements the CRUD actions for AdminUser model.
 */
class HomeController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(){
        return $this->render('index',[
        ]);
    }

}
