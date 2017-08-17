<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "recruit".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property integer $type
 * @property string $document_type
 * @property string $idcard
 * @property integer $gender
 * @property string $company
 * @property string $position
 * @property string $remark
 * @property string $enterprise_name
 * @property string $profile
 * @property string $number
 * @property string $name
 * @property string $country_area
 * @property string $host_city
 * @property string $mobile
 * @property string $email
 * @property string $address
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Recruit extends \yii\db\ActiveRecord
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
        return 'recruit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'status', 'type', 'gender', 'created_at', 'updated_at'], 'integer'],
            [['remark', 'profile', 'address'], 'string'],
            [['document_type', 'idcard', 'company', 'position', 'enterprise_name', 'number', 'country_area', 'host_city'], 'string', 'max' => 255],
            [['name', 'email'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'status' => 'Status',
            'type' => 'Type',
            'document_type' => 'Document Type',
            'idcard' => 'Idcard',
            'gender' => 'Gender',
            'company' => 'Company',
            'position' => 'Position',
            'remark' => 'Remark',
            'enterprise_name' => 'Enterprise Name',
            'profile' => 'Profile',
            'number' => 'Number',
            'name' => 'Name',
            'country_area' => 'Country Area',
            'host_city' => 'Host City',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'address' => 'Address',
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
}
