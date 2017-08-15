<?php
/**
 * Created by PhpStorm.
 * User: jiangminjie
 * Date: 2017/8/14
 * Time: 下午3:22
 */

namespace api\common\controllers;



use common\models\Activity;
use common\models\Offline;
use common\models\OfflineActivity;
use common\models\Online;
use common\models\OnlineActivity;
use common\service\OrderService;
use common\util\Constants;
use common\util\Utils;
use yii\base\ErrorException;

class ActivityController extends BaseController
{

    public $needLoginActions=['online','offline'];

    public function actionList($id)
    {
        //$id=Utils::decryptId($id,Constants::ENC_TYPE_TOPIC);
        if(empty($id)){
            throw new ErrorException("1");
        }
        return Activity::find()->where(['topic_id'=>$id])->all();
    }

    public function actionShow($id)
    {
        //$id=Utils::decryptId($id,Constants::ENC_TYPE_ACTIVITY);
        if(empty($id)){
            throw new ErrorException("1");
        }

        return Activity::find()->where(['id'=>$id])->one();
    }


    /**
     * @api {post} /activity/online 线上报名
     *
     *
     * @apiGroup activity
     *
     * @apiParam {string} walk 益行公里数
     * @apiParam {string} run 益跑公里数
     * @apiParam {string} bike 益骑公里数
     *
     * @apiParam {string} mobile 手机号
     * @apiParam {string} name 姓名
     * @apiParam {int} gender 性别 0女 1男
     * @apiParam {string} address 地址
     *
     *
     *
     *
     * @apiSuccessExample SuccessExample
        {
        "id": "nmyow",
        "api_code": 200
        }
     */

    public function actionOnline($id)
    {
        //$id=Utils::decryptId($id,Constants::ENC_TYPE_ONLINE_ACTIVITY);

        $benefit_walk=$this->getParam('walk',0);
        $benefit_run=$this->getParam('run',0);
        $benefit_bike=$this->getParam('bike',0);

        $mobile=$this->getParam('mobile');
        $name=$this->getParam('name');
        $gender=$this->getParam('gender');
        $address=$this->getParam('address');


        $user_id=\Yii::$app->user->id;

        $online_activity=OnlineActivity::find()->where(['id'=>$id])->one();
        $activity=$online_activity->activity;
        $online=Online::find()->where(['activity_id'=>$activity->id,'online_activity_id'=>$online_activity->id,'user_id'=>$user_id])->one();

        if(!empty($online)){
            throw new ErrorException("已报名");
        }
        if(empty($online_activity)){
            throw new ErrorException("无该线下活动");
        }
        if($online_activity->end_time<time()){
            throw new ErrorException("已过报名时间");
        }
        if(($online_activity->benefit_walk_max<$benefit_walk||$online_activity->benefit_walk_min>$benefit_walk)&&!empty($benefit_walk)){
            throw new ErrorException("益行公里数有误");
        }
        if(($online_activity->benefit_run_max<$benefit_run||$online_activity->benefit_run_min>$benefit_run)&&!empty($benefit_run)){
            throw new ErrorException("益跑公里数有误");
        }
        if(($online_activity->benefit_bike_max<$benefit_bike||$online_activity->benefit_bike_min>$benefit_bike)&&!empty($benefit_bike)){
            throw new ErrorException("益骑公里数有误");
        }

        $transaction = \Yii::$app->db->beginTransaction();

        $model=new Online();
        $model->online_activity_id=$online_activity->id;
        $model->activity_id=$activity->id;
        $model->user_id=$user_id;
        $model->benefit_walk=$benefit_walk;
        $model->benefit_run=$benefit_run;
        $model->benefit_bike=$benefit_bike;

        $model->name=$name;
        $model->mobile=$mobile;
        $model->gender=$gender;
        $model->address=$address;

        if (!$model->save()){
            throw new ErrorException('报名失败');
        }

        $online_activity->people_num++;
        if (!$online_activity->save()){
            throw new ErrorException('报名人数增加失败');
        }
        $activity->people_num++;
        if (!$activity->save()){
            throw new ErrorException('报名人数增加失败');
        }

        $order=OrderService::confirm(Constants::ORDER_TYPE_ONLINE,$model->id,$user_id,$online_activity->price);

        if(empty($order)){
            throw new ErrorException('订单提交失败');
        }
        $transaction->commit();


        return $order;
    }

    /**
     * @api {post} /activity/offline 线下报名
     *
     *
     * @apiGroup activity
     *
     * @apiParam {string} benefit_walk 益行公里数
     *
     * @apiParam {string} mobile 手机号
     * @apiParam {string} name 姓名/联系人/记者名称
     * @apiParam {string} country_area 国家地区
     * @apiParam {string} host_city 所在城市
     * @apiParam {string} email 邮箱
     * @apiParam {string} address 地址
     *
     * @apiParam {int} gender 性别 0女 1男
     * @apiParam {string} document_type 证件烈性
     * @apiParam {string} idcard 证件号码
     * @apiParam {string} company 单位
     * @apiParam {string} position 职称
     * @apiParam {string} remark 您从哪里获取
     *
     * @apiParam {string} enterprise_name 企业名称／媒体名称／组织机构名称
     * @apiParam {string} profile 简介
     * @apiParam {string} number 记者编号
     *
     *
     *
     * @apiSuccessExample SuccessExample
    {
    "id": "nmyow",
    "api_code": 200
    }
     */

    public function actionOffline($id)
    {
        //$id=Utils::decryptId($id,Constants::ENC_TYPE_ONLINE_ACTIVITY);

        $user_id=\Yii::$app->user->id;

        $type=$this->getParam('type',999);

        $mobile=$this->getParam('mobile');
        $name=$this->getParam('name');
        $country_area=$this->getParam('country_area');
        $host_city=$this->getParam('host_city');
        $email=$this->getParam('email');
        $address=$this->getParam('address');
        $benefit_walk=$this->getParam('benefit_walk');

        $offline_activity=OfflineActivity::find()->where(['id'=>$id])->one();
        $activity=$offline_activity->activity;

        if(empty($offline_activity)){
            throw new ErrorException("无该线下活动");
        }
        if($offline_activity->benefit_walk_max<$benefit_walk||$offline_activity->benefit_walk_min>$benefit_walk){
            throw new ErrorException("公里数有误");
        }

        $transaction = \Yii::$app->db->beginTransaction();

        $model=new Offline();

        $model->user_id=$user_id;
        $model->activity_id=$activity->id;
        $model->offline_activity_id=$offline_activity->id;
        $model->name=$name;
        $model->mobile=$mobile;
        $model->country_area=$country_area;
        $model->host_city=$host_city;
        $model->email=$email;
        $model->address=$address;
        $model->benefit_walk=$benefit_walk;

        if ($type==Constants::OFFLINE_TYPE_INDIVIDUSL){
            $gender=$this->getParam('gender');
            $document_type=$this->getParam('document_type');
            $idcard=$this->getParam('idcard');
            $company=$this->getParam('company');
            $position=$this->getParam('position');
            $remark=$this->getParam('reamrk');

            $model->type=$type;
            $model->gender=$gender;
            $model->document_type=$document_type;
            $model->idcard=$idcard;
            $model->company=$company;
            $model->position=$position;
            $model->remark=$remark;

        }
        else if ($type==Constants::OFFLINE_TYPE_ENTERPRISE){
            $enterprise_name=$this->getParam('enterprise_name');
            $profile=$this->getParam('profile');

            $model->type=$type;
            $model->enterprise_name=$enterprise_name;
            $model->profile=$profile;

        }
        else if ($type==Constants::OFFLINE_TYPE_MEDIA){
            $enterprise_name=$this->getParam('enterprise_name');
            $profile=$this->getParam('profile');
            $number=$this->getParam('number');

            $model->type=$type;
            $model->enterprise_name=$enterprise_name;
            $model->profile=$profile;
            $model->number=$number;

        }
        else if ($type==Constants::OFFLINE_TYPE_STRATEGIC){
            $enterprise_name=$this->getParam('enterprise_name');
            $profile=$this->getParam('profile');

            $model->type=$type;
            $model->enterprise_name=$enterprise_name;
            $model->profile=$profile;

        }
        else{
            throw new ErrorException('未知类型');
        }


        if (!$model->save()){
            throw new ErrorException('报名失败');
        }

        $offline_activity->people_num++;
        if (!$offline_activity->save()){
            throw new ErrorException('报名人数增加失败');
        }
        $activity->people_num++;
        if (!$activity->save()){
            throw new ErrorException('报名人数增加失败');
        }

        $order=OrderService::confirm(Constants::ORDER_TYPE_OFFLINE,$model->id,$user_id,$offline_activity->price);

        if(empty($order)){
            throw new ErrorException('订单提交失败');
        }

        $transaction->commit();

        return $order;

    }
}