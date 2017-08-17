<?php
/**
 * Created by PhpStorm.
 * User: jiangminjie
 * Date: 2017/8/17
 * Time: 上午10:35
 */

namespace api\common\controllers;


use common\models\Online;
use common\models\Offline;
use common\models\RunGroup;
use common\models\RunGroupJoin;
use common\models\Walk;
use yii\base\ErrorException;

class MyController extends BaseController
{
    public $needLoginActions=['activity','group'];
    /**
     * @api {get} /my/activity/index 我的报名
     *
     *
     * @apiGroup my
     *
     *
     * @apiSuccessExample SuccessExample
        {
        "data": [
        {
        "activity_type": 0,
        "status": 0,
        "activity": {
        "id": "pl38y",
        "activity": {
        "id": "d70r7",
        "topic_id": "rdy81",
        "cover": "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=4276212331,3046393127&fm=26&gp=0.jpg",
        "title": "test",
        "en_title": "test",
        "start_time": null,
        "people_num": 2,
        "online_activity": "1",
        "offline_activity": "1"
        },
        "type": 0,
        "location": null,
        "en_location": null,
        "end_time": 1602864429,
        "people_num": 1,
        "desc": null,
        "en_desc": null,
        "price": "1000.00",
        "benefit_walk_min": 0,
        "benefit_run_min": 0,
        "benefit_bike_min": 0,
        "benefit_walk_max": 100,
        "benefit_run_max": 1000,
        "benefit_bike_max": 1000
        }
        },
        {
        "activity_type": 1,
        "status": 0,
        "activity": {
        "id": "4z7yz",
        "activity": {
        "id": "d70r7",
        "topic_id": "rdy81",
        "cover": "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=4276212331,3046393127&fm=26&gp=0.jpg",
        "title": "test",
        "en_title": "test",
        "start_time": null,
        "people_num": 2,
        "online_activity": "1",
        "offline_activity": "1"
        },
        "type": 1,
        "location": null,
        "en_location": null,
        "end_time": 1602864429,
        "people_num": 1,
        "desc": null,
        "en_desc": "1502864429",
        "price": "100.00",
        "benefit_walk_min": 0,
        "benefit_walk_max": 1000
        }
        }
        ],
        "api_code": 200
        }
     */

    public function actionActivity()
  {
      $user_id=\Yii::$app->user->id;

      $data=[];

      $model=Online::find()->where(['user_id'=>$user_id])->all();

      foreach ($model as $val){
          $data[]=$val;
      }

      $model=Offline::find()->where(['user_id'=>$user_id])->all();

      foreach ($model as $val){
          $data[]=$val;
      }


      return $data;
  }

    /**
     * @api {get} /my/group/index 我的跑团
     *
     *
     * @apiGroup my
     *
     * @apiParam {string} start 跑团id
     * @apiParam {string} page 页码
     * @apiParam {string} num 数量
     *
     * @apiSuccessExample SuccessExample
        {
        "data": [
        {
        "group": {
        "id": "g70x7",
        "name": "test",
        "introduction": "test",
        "head": "test",
        "title": null,
        "en_title": null,
        "province": 1,
        "city": 1,
        "region": 1,
        "benefit_walk": 0,
        "benefit_run": 0,
        "benefit_bike": 0,
        "join": "1",
        "joiner_number": "1",
        "joiner_step_number": 2000
        }
        },
        {
        "group": {
        "id": "17gl4",
        "name": "test",
        "introduction": "1",
        "head": "1",
        "title": null,
        "en_title": null,
        "province": 1,
        "city": 1,
        "region": 1,
        "benefit_walk": 1,
        "benefit_run": 1,
        "benefit_bike": 1,
        "join": "1",
        "joiner_number": "1",
        "joiner_step_number": 2000
        }
        }
        ],
        "api_code": 200
        }
     */
    public function actionRunGroup()
  {
      $start = $this->getParam( 'start', 0, true );
      $page = $this->getParam( 'page', 0, true );
      $num = $this->getParam( 'num', 10, true );
      if (empty($start)){
          return RunGroupJoin::find()->where(['user_id'=>\Yii::$app->user->id])->orderBy('created_at DESC')->offset($page * $num)->limit($num)->all();
      }
      return RunGroupJoin::find()->where(['user_id'=>\Yii::$app->user->id])->andWhere(['<','id',$start])->orderBy('created_at DESC')->offset($page * $num)->limit($num)->all();
  }
}