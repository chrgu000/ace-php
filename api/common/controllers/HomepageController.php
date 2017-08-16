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
use common\models\TopRunGroup;
use common\models\TopSet;

class HomepageController extends BaseController
{

    /**
     * @api {get} /homepage/index 首页
     *
     *
     * @apiGroup homepage
     *
     *
     *
     *
     *
     * @apiSuccessExample SuccessExample
     *
        {
        "Banner": [
        {
        "type": 0,
        "img": "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=4276212331,3046393127&fm=26&gp=0.jpg",
        "link": "https://www.baidu.com/",
        "target": null
        },
        {
        "type": 1,
        "img": "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=4276212331,3046393127&fm=26&gp=0.jpg",
        "link": null,
        "target": {
        "id": "rdy81",
        "cover": "test",
        "title": "test",
        "activities": [
        {
        "id": "d70r7",
        "topic_id": "rdy81",
        "cover": "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=4276212331,3046393127&fm=26&gp=0.jpg",
        "title": "test",
        "en_title": "test",
        "start_time": null,
        "people_num": 0
        }
        ]
        }
        },
        {
        "type": 2,
        "img": "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=4276212331,3046393127&fm=26&gp=0.jpg",
        "link": null,
        "target": {
        "id": "d70r7",
        "topic_id": "rdy81",
        "cover": "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=4276212331,3046393127&fm=26&gp=0.jpg",
        "title": "test",
        "en_title": "test",
        "start_time": null,
        "people_num": 0
        }
        },
        {
        "type": 3,
        "img": "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=4276212331,3046393127&fm=26&gp=0.jpg",
        "link": null,
        "target": {
        "id": "d70r7",
        "topic_id": "rdy81",
        "cover": "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=4276212331,3046393127&fm=26&gp=0.jpg",
        "title": "test",
        "en_title": "test",
        "start_time": null,
        "people_num": 0
        }
        }
        ],
        "topic": [
        {
        "target": {
        "id": "rdy81",
        "cover": "test",
        "title": "test",
        "activities": [
        {
        "id": "d70r7",
        "topic_id": "rdy81",
        "cover": "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=4276212331,3046393127&fm=26&gp=0.jpg",
        "title": "test",
        "en_title": "test",
        "start_time": null,
        "people_num": 0
        }
        ]
        }
        }
        ],
        "hot": [
        {
        "target": {
        "id": "d70r7",
        "topic_id": "rdy81",
        "cover": "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=4276212331,3046393127&fm=26&gp=0.jpg",
        "title": "test",
        "en_title": "test",
        "start_time": null,
        "people_num": 0
        }
        },
        {
        "target": {
        "id": "d70r7",
        "topic_id": "rdy81",
        "cover": "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=4276212331,3046393127&fm=26&gp=0.jpg",
        "title": "test",
        "en_title": "test",
        "start_time": null,
        "people_num": 0
        }
        }
        ],
        "top": [
        {
        "type": 0,
        "count": 1080
        },
        {
        "type": 1,
        "count": 109
        },
        {
        "type": 2,
        "count": 209
        }
        ],
        "run_group": [
        {
        "runGroup": {
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
        "benefit_bike": 0
        }
        }
        ],
        "api_code": 200
        }
     *
     * @apiSuccessExample SuccessResponse
     * type 0 外链 1 专题  2  线上活动  3 线下活动
     */

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
        $query=TopSet::find()->all();
        $data['top']=$query;
        $query=TopRunGroup::find()->orderBy('rank')->all();
        $data['run_group']=$query;
        return $data;
    }
}