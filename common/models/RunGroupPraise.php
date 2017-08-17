<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "run_group_praise".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $run_group_joiner
 * @property integer $run_group
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property User $runGroupJoiner
 * @property RunGroup $runGroup
 */
class RunGroupPraise extends \yii\db\ActiveRecord
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
        return 'run_group_praise';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'run_group_joiner', 'run_group'], 'required'],
            [['user_id', 'run_group_joiner', 'run_group', 'created_at', 'updated_at'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['run_group_joiner'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['run_group_joiner' => 'id']],
            [['run_group'], 'exist', 'skipOnError' => true, 'targetClass' => RunGroup::className(), 'targetAttribute' => ['run_group' => 'id']],
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
            'run_group_joiner' => 'Run Group Joiner',
            'run_group' => 'Run Group',
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
    public function getRunGroupJoiner()
    {
        return $this->hasOne(User::className(), ['id' => 'run_group_joiner']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRunGroup()
    {
        return $this->hasOne(RunGroup::className(), ['id' => 'run_group']);
    }
}
