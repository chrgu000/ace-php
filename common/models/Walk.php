<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "walk".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $count
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Walk extends \yii\db\ActiveRecord
{

    public $group_id;

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
        return 'walk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'count', 'created_at', 'updated_at'], 'integer'],
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
            'count' => 'Count',
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

    public function fields()
    {
        return [
            'user',
            'step_number'=>'count',
            'praise'=>function(){
                $today = strtotime(date("Y-m-d"),time());

                $end = $today+60*60*24;

                return RunGroupPraise::find()->where(['user_id'=>Yii::$app->user->id])->andWhere(['>=','created_at',$today])->andWhere(['<','created_at',$end])->count();
            },
            'praise_count'=>function(){

                $today = strtotime(date("Y-m-d"),time());

                $end = $today+60*60*24;


                return RunGroupPraise::find()->where(['run_group_joiner'=>Yii::$app->user->id,'run_group'=>$this->group_id])->andWhere(['>=','created_at',$today])->andWhere(['<','created_at',$end])->count();

            },
        ];
    }
}
