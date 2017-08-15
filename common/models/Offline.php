<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "offline".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $activity_id
 * @property integer $offline_activity_id
 * @property integer $status
 * @property integer $type
 * @property string $document_type
 * @property string $idcard
 * @property integer $gender
 * @property string $company
 * @property string $position
 * @property string $enterprise_name
 * @property string $profile
 * @property string $number
 * @property string $name
 * @property string $country_area
 * @property string $host_city
 * @property string $mobile
 * @property string $email
 * @property string $address
 * @property string $remark
 * @property integer $benefit_walk
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property Activity $activity
 * @property OfflineActivity $offlineActivity
 */
class Offline extends \yii\db\ActiveRecord
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
        return 'offline';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'activity_id', 'offline_activity_id'], 'required'],
            [['user_id', 'activity_id', 'offline_activity_id', 'status', 'type', 'gender', 'benefit_walk', 'created_at', 'updated_at'], 'integer'],
            [['profile', 'address', 'remark'], 'string'],
            [['document_type', 'idcard', 'company', 'position', 'enterprise_name', 'number', 'country_area', 'host_city'], 'string', 'max' => 255],
            [['name', 'email'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'id']],
            [['offline_activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => OfflineActivity::className(), 'targetAttribute' => ['offline_activity_id' => 'id']],
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
            'offline_activity_id' => 'Offline Activity ID',
            'status' => 'Status',
            'type' => 'Type',
            'document_type' => 'Document Type',
            'idcard' => 'Idcard',
            'gender' => 'Gender',
            'company' => 'Company',
            'position' => 'Position',
            'enterprise_name' => 'Enterprise Name',
            'profile' => 'Profile',
            'number' => 'Number',
            'name' => 'Name',
            'country_area' => 'Country Area',
            'host_city' => 'Host City',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'address' => 'Address',
            'remark' => 'Remark',
            'benefit_walk' => 'Benefit Walk',
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
    public function getOfflineActivity()
    {
        return $this->hasOne(OfflineActivity::className(), ['id' => 'offline_activity_id']);
    }
}
