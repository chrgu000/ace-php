<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $nickname
 * @property string $avatar
 * @property string $access_token
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $open_id
 * @property string $union_id
 * @property integer $gender
 * @property string $city
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
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
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nickname', 'access_token', 'auth_key'], 'required'],
            [['gender', 'created_at', 'updated_at'], 'integer'],
            [['nickname'], 'string', 'max' => 50],
            [['avatar'], 'string', 'max' => 200],
            [['access_token', 'open_id', 'union_id'], 'string', 'max' => 500],
            [['password_reset_token', 'auth_key', 'city'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'Nickname',
            'avatar' => 'Avatar',
            'access_token' => 'Access Token',
            'password_reset_token' => 'Password Reset Token',
            'auth_key' => 'Auth Key',
            'open_id' => 'Open ID',
            'union_id' => 'Union ID',
            'gender' => 'Gender',
            'city' => 'City',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }


    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * generate access token
     */
    public function generateAccessToken() {
        $this->access_token = uniqid() . '_' . time();
    }
}
