<?php
/**
 * Created by PhpStorm.
 * User: jiangminjie
 * Date: 2017/8/17
 * Time: 上午10:52
 */

namespace common\service;

use common\models\Walk;
use yii\base\ErrorException;

class MyService
{
    public static function document($step_number)
    {

        $user_id=\Yii::$app->user->id;

        $today = strtotime(date("Y-m-d"),time());

        $end = $today+60*60*24;

        $model=Walk::find()->where(['user_id'=>$user_id])->andWhere(['>=','created_at',$today])->andWhere(['<','created_at',$end])->one();

        if (empty($model)){
            $model= new Walk();
        }

        $model->count=$step_number;

        $model->user_id=$user_id;

        if (!$model->save()){
            throw new ErrorException('步数记录失败');
        }

        return true;
    }

}