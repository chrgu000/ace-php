<?php

namespace common\models;

use common\util\Constants;
use common\util\Utils;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $nickname
 * @property string $username
 * @property integer $type
 * @property string $avatar
 * @property string $access_token
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $open_id
 * @property string $union_id
 * @property integer $gender
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
            [['nickname', 'access_token', 'auth_key','password_hash'], 'required'],
            [['type', 'gender', 'created_at', 'updated_at'], 'integer'],
            [['nickname', 'username'], 'string', 'max' => 50],
            [['avatar'], 'string', 'max' => 200],
            [['access_token', 'open_id', 'union_id'], 'string', 'max' => 500],
            [['password_reset_token', 'auth_key','password_hash'], 'string', 'max' => 100],
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
            'username' => 'Username',
            'type' => 'Type',
            'avatar' => 'Avatar',
            'access_token' => 'Access Token',
            'password_reset_token' => 'Password Reset Token',
            'auth_key' => 'Auth Key',
            'open_id' => 'Open ID',
            'union_id' => 'Union ID',
            'gender' => 'Gender',
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

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function fields()
    {
        return [
            'id' => function(){
                return Utils::encryptId($this->id,Constants::ENC_TYPE_USER);
            },'username','nickname','type','created_at',
            'step_number'=>function(){
                $today = strtotime(date("Y-m-d"),time());

                $end = $today+60*60*24;

                $model=Walk::find()->where(['user_id'=>$this->id])->andWhere(['>=','created_at',$today])->andWhere(['<','created_at',$end])->one();

                if (empty($model)){
                    return 0;
                }
                else{
                    return $model->count;
                }
            },
            'cal'=>function(){
                $today = strtotime(date("Y-m-d"),time());

                $end = $today+60*60*24;

                $model=Walk::find()->where(['user_id'=>$this->id])->andWhere(['>=','created_at',$today])->andWhere(['<','created_at',$end])->one();

                if (empty($model)){
                    return 0;
                }
                else{
                    return $model->count*0.04;
                }
            }
        ];
    }

    public function extraFields()
    {
        return [
            'access_token',
        ];
    }
}
