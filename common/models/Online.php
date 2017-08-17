<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "online".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $activity_id
 * @property integer $online_activity_id
 * @property integer $status
 * @property string $name
 * @property integer $gender
 * @property string $mobile
 * @property string $address
 * @property integer $benefit_walk
 * @property integer $benefit_run
 * @property integer $benefit_bike
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property Activity $activity
 * @property OnlineActivity $onlineActivity
 */
class Online extends \yii\db\ActiveRecord
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
        return 'online';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'activity_id', 'online_activity_id', 'name', 'mobile'], 'required'],
            [['user_id', 'activity_id', 'online_activity_id', 'status', 'gender', 'benefit_walk', 'benefit_run', 'benefit_bike', 'created_at', 'updated_at'], 'integer'],
            [['address'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'id']],
            [['online_activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => OnlineActivity::className(), 'targetAttribute' => ['online_activity_id' => 'id']],
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
            'activity_id' => 'Activity ID',
            'online_activity_id' => 'Online Activity ID',
            'status' => 'Status',
            'name' => 'Name',
            'gender' => 'Gender',
            'mobile' => 'Mobile',
            'address' => 'Address',
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
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnlineActivity()
    {
        return $this->hasOne(OnlineActivity::className(), ['id' => 'online_activity_id']);
    }

    public function fields()
    {
        return [
            'activity_type'=>function(){
                return 0;
            },
            'status',
            'activity'=>'onlineActivity'
        ];
    }
}
