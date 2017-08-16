<?php
/**
 * Created by PhpStorm.
 * User: jiangminjie
 * Date: 2017/8/16
 * Time: 下午4:44
 */

namespace api\common\controllers;


use common\models\RunGroup;
use common\util\Constants;
use common\util\Utils;
use yii\base\ErrorException;

class RunGroupController extends BaseController
{
    /**
     * @api {get} /group/show/<id:.+> 跑团详情
     *
     *
     * @apiGroup group
     *
     * @apiParam {string} :id 跑团id
     *
     *
     *
     * @apiSuccessExample SuccessExample
        {
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
        "api_code": 200
        }
     */

    public function actionShow($id)
    {
        $id=Utils::decryptId($id,Constants::ENC_TYPE_RUN_GROUP);
        if(empty($id)){
            throw new ErrorException('跑团不能为空');
        }
        return RunGroup::find()->where(['id'=>$id])->one();
    }


    /**
     * @api {post} /group/create 创建跑团
     *
     *
     * @apiGroup group
     *
     * @apiParam {string} name 团名称
     * @apiParam {string} introduction 团简介
     * @apiParam {string} head 团头像
     * @apiParam {string} province 省
     * @apiParam {string} city 市
     * @apiParam {string} region 区
     * @apiParam {string} benefit_walk 益跑 0 未选择 1 选择
     * @apiParam {string} benefit_run 益行 0 未选择 1 选择
     * @apiParam {string} benefit_bike 益骑 0 未选择 1 选择
     *
     *
     *
     *
     *
     * @apiSuccessExample SuccessExample
    {
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
    "api_code": 200
    }
     */
    public function actionCreate()
    {
        $name=$this->getParam('name');
        $introduction=$this->getParam('introduction');
        $head=$this->getParam('head');
        $province=$this->getParam('province');
        $city=$this->getParam('city');
        $region=$this->getParam('region');
        $benefit_walk=$this->getParam('benefit_walk');
        $benefit_run=$this->getParam('benefit_run');
        $benefit_bike=$this->getParam('benefit_bike');
        $user=\Yii::$app->user->id;

        $model=new RunGroup();

        $model->name=$name;
        $model->introduction=$introduction;
        $model->head=$head;
        $model->province=$province;
        $model->city=$city;
        $model->region=$region;
        $model->benefit_walk=$benefit_walk;
        $model->benefit_run=$benefit_run;
        $model->benefit_bike=$benefit_bike;
        $model->user_id=$user;

        if (!$model->save()){
            throw  new ErrorException('跑团创建失败');
        }

        return $model;

    }
}