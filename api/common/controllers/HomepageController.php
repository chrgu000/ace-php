<?php
/**
 * Created by PhpStorm.
 * User: jiangminjie
 * Date: 2017/8/15
 * Time: 下午6:03
 */

namespace api\common\controllers;


use common\models\Homepage;
use common\models\Banner;
class HomepageController extends BaseController
{
    public function actionIndex()
    {
        $types=['0','1'];
        $data=[];
        $query=Banner::find()->orderBy('rank')->all();
        $data['Banner']=$query;
        foreach ($types as $type){
            switch ($type){
                case 0: $name="topic";break;
                case 1: $name="hot";break;
            }
            $query=Homepage::find()->where(['type'=>$type])->all();
                $data[$name]=$query;
        }
        return $data;
    }
}