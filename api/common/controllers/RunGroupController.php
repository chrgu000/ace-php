<?php
/**
 * Created by PhpStorm.
 * User: jiangminjie
 * Date: 2017/8/16
 * Time: 下午4:44
 */

namespace api\common\controllers;


use common\models\RunGroup;
use common\models\RunGroupJoin;
use common\models\RunGroupPraise;
use common\util\Constants;
use common\util\Utils;
use yii\base\ErrorException;

class RunGroupController extends BaseController
{
    public $needLoginActions=['create'];
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
        "join": "1",
        "joiner_number": "1",
        "joiner_step_number": 2000,
        "top": [
        {
        "user": {
        "id": "xlzgw",
        "username": "18868343306",
        "nickname": "18868343306",
        "type": 0,
        "created_at": 1502703532,
        "step_number": 2000,
        "cal": 80
        },
        "step_number": 2000,
        "praise": "1",
        "praise_count": "1"
        }
        ],
        "api_code": 200
        }
     */

    public function actionShow($id)
    {
        $id=Utils::decryptId($id,Constants::ENC_TYPE_RUN_GROUP);
        if(empty($id)){
            throw new ErrorException('跑团不能为空');
        }
        return RunGroup::find()->where(['id'=>$id])->one()->toArray([],['top']);
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
        "join": "1",
        "joiner_number": "1",
        "joiner_step_number": 2000,
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

        $transaction = \Yii::$app->db->beginTransaction();

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

        if(!$this->actionJoin(Utils::encryptId($model->id,Constants::ENC_TYPE_RUN_GROUP))){
            throw  new ErrorException('创建者加入跑团失败');
        }

        $transaction->commit();
        return $model;

    }


    /**
     * @api {post} /group/join/<id:.+> 加入跑团
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
        "data": true,
        "api_code": 200
        }
     */

    public function actionJoin($id)
    {
        $id=Utils::decryptId($id,Constants::ENC_TYPE_RUN_GROUP);
        if (empty($id)){
            throw new ErrorException('跑团不能为空');
        }

        if (RunGroupJoin::find()->where(['user_id'=>\Yii::$app->user->id,'run_group_id'=>$id])->count()){
            throw new ErrorException('您已加入');
        }

        $model=new RunGroupJoin();
        $model->user_id=\Yii::$app->user->id;
        $model->run_group_id=$id;

        if (!$model->save()){
            throw new ErrorException('加入跑团失败');
        }

        return true;
    }

    /**
     * @api {post} /group/praise/<id:.+>/<user_id.+> 点赞
     *
     *
     * @apiGroup group
     *
     * @apiParam {string} :id 跑团id
     * @apiParam {string} user_id 被点赞者
     *
     *
     * @apiSuccessExample SuccessExample
        {
        "data": true,
        "api_code": 200
        }
     */


    public function actionPraise($id,$user_id)
    {
        $id=Utils::decryptId($id,Constants::ENC_TYPE_RUN_GROUP);

        if (empty($id)){
            throw new ErrorException('跑团不能为空');
        }
        $user_id=Utils::decryptId($user_id,Constants::ENC_TYPE_USER);

        if (empty($user_id)){
            throw new ErrorException('用户不能为空');
        }

        $today = strtotime(date("Y-m-d"),time());

        $end = $today+60*60*24;

        $model=RunGroupPraise::find()->where(['run_group_joiner'=>$user_id,'run_group'=>$id])->andWhere(['>=','created_at',$today])->andWhere(['<','created_at',$end])->one();

        if ($model){
            throw new  ErrorException('您已点赞');
        }

        $model= new RunGroupPraise();
        $model->run_group_joiner=$user_id;
        $model->run_group=$id;
        $model->user_id=\Yii::$app->user->id;

        if (!$model->save()){
            throw new ErrorException('点赞失败');
        }

        return true;
    }
}