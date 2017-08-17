<?php
/**
 * Created by PhpStorm.
 * User: jiangminjie
 * Date: 2017/8/17
 * Time: 下午4:47
 */

namespace api\common\controllers;


use common\models\Recruit;
use common\util\Constants;
use yii\base\ErrorException;

class RecruitController extends BaseController
{

    /**
     * @api {post} /recruit 官方招募
     *
     *
     * @apiGroup recruit
     *
     * @apiParam {string} type 0 明星报名 1 企业支持 2 媒体支持 3 跑团合作
     *
     * @apiParam {string} mobile 手机号
     * @apiParam {string} name 姓名/联系人/记者名称
     * @apiParam {string} country_area 国家地区
     * @apiParam {string} host_city 所在城市
     * @apiParam {string} email 邮箱
     * @apiParam {string} address 地址
     *
     * @apiParam {int} gender 性别 0 女 1 男
     * @apiParam {string} document_type 证件类型
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
        "data": true,
        "api_code": 200
        }
     */


    public function actionCreate()
    {
        $user_id=\Yii::$app->user->id;

        $type=$this->getParam('type',999);

        $mobile=$this->getParam('mobile');
        $name=$this->getParam('name');
        $country_area=$this->getParam('country_area');
        $host_city=$this->getParam('host_city');
        $email=$this->getParam('email');
        $address=$this->getParam('address');


        $transaction = \Yii::$app->db->beginTransaction();

        $model=new Recruit();

        $model->user_id=$user_id;
        $model->name=$name;
        $model->mobile=$mobile;
        $model->country_area=$country_area;
        $model->host_city=$host_city;
        $model->email=$email;
        $model->address=$address;

        if ($type==Constants::RECRUIT_TYPE_STAR){
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
        else if ($type==Constants::RECRUIT_TYPE_ENTERPRISE){
            $enterprise_name=$this->getParam('enterprise_name');
            $profile=$this->getParam('profile');

            $model->type=$type;
            $model->enterprise_name=$enterprise_name;
            $model->profile=$profile;

        }
        else if ($type==Constants::RECRUIT_TYPE_MEDIA){
            $enterprise_name=$this->getParam('enterprise_name');
            $profile=$this->getParam('profile');
            $number=$this->getParam('number');

            $model->type=$type;
            $model->enterprise_name=$enterprise_name;
            $model->profile=$profile;
            $model->number=$number;

        }
        else if ($type==Constants::RECRUIT_TYPE_GROUP){
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



        $transaction->commit();

        return true;
    }
}