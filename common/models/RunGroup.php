<?php

namespace common\models;

use common\util\Constants;
use common\util\Utils;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table 'run_group'.
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $introduction
 * @property string $head
 * @property string $title
 * @property string $en_title
 * @property integer $province
 * @property integer $city
 * @property integer $region
 * @property integer $benefit_walk
 * @property integer $benefit_run
 * @property integer $benefit_bike
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property Region $province0
 * @property Region $city0
 * @property Region $region0
 * @property RunGroupImg[] $runGroupImgs
 * @property TopRunGroup[] $topRunGroups
 */
class RunGroup extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'run_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'introduction', 'head', 'province', 'city', 'region'], 'required'],
            [['user_id', 'province', 'city', 'region', 'benefit_walk', 'benefit_run', 'benefit_bike', 'created_at', 'updated_at'], 'integer'],
            [['introduction'], 'string'],
            [['name', 'head', 'title', 'en_title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['province'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['province' => 'id']],
            [['city'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['city' => 'id']],
            [['region'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'introduction' => 'Introduction',
            'head' => 'Head',
            'title' => 'Title',
            'en_title' => 'En Title',
            'province' => 'Province',
            'city' => 'City',
            'region' => 'Region',
            'benefit_walk' => 'Benefit Walk',
            'benefit_run' => 'Benefit Run',
            'benefit_bike' => 'Benefit Bike',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince0()
    {
        return $this->hasOne(Region::className(), ['id' => 'province']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity0()
    {
        return $this->hasOne(Region::className(), ['id' => 'city']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion0()
    {
        return $this->hasOne(Region::className(), ['id' => 'region']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRunGroupImgs()
    {
        return $this->hasMany(RunGroupImg::className(), ['run_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopRunGroups()
    {
        return $this->hasMany(TopRunGroup::className(), ['run_group_id' => 'id']);
    }

    public function fields()
    {
        return [
            'id'=>function(){
                return Utils::encryptId($this->id,Constants::ENC_TYPE_RUN_GROUP);
            },
            'name',
            'introduction',
            'head',
            'title',
            'en_title',
            'province',
            'city',
            'region',
            'benefit_walk',
            'benefit_run',
            'benefit_bike',
            'join'=>function(){
                return RunGroupJoin::find()->where(['user_id'=>\Yii::$app->user->id,'run_group_id'=>$this->id])->count();
            },
            'joiner_number'=>function(){
                return RunGroupJoin::find()->where(['run_group_id'=>$this->id])->count();
            },
            'joiner_step_number'=>function(){
                $runners=RunGroupJoin::find()->where(['run_group_id'=>$this->id])->all();
                $sum=0;
                foreach ($runners as $runner){

                    $today = strtotime(date("Y-m-d"),time());

                    $end = $today+60*60*24;

                    $model=Walk::find()->where(['user_id'=>$runner->user_id])->andWhere(['>=','created_at',$today])->andWhere(['<','created_at',$end])->one();

                    if ($model){
                        $sum+=$model->count;
                    }
                }
                return $sum;
            },

        ];
    }

    public function extraFields()
    {
        return [
            'top'=>function(){
                $runners=RunGroupJoin::find()->where(['run_group_id'=>$this->id])->all();
                $runnerIds=ArrayHelper::getColumn($runners,'user_id');

                $today = strtotime(date("Y-m-d"),time());

                $end = $today+60*60*24;

                $data=Walk::find()->where(['user_id'=>$runnerIds])->andWhere(['>=','created_at',$today])->andWhere(['<','created_at',$end])->orderBy('count Desc')->limit('6')->all();

                foreach ($data as $val){
                    $val->group_id=$this->id;
                }
                return $data;
            }
        ];
    }
}
