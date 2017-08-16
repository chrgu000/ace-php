<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "top_run_group".
 *
 * @property integer $id
 * @property integer $run_group_id
 * @property integer $rank
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property RunGroup $runGroup
 */
class TopRunGroup extends \yii\db\ActiveRecord
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
        return 'top_run_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['run_group_id'], 'required'],
            [['run_group_id', 'rank', 'created_at', 'updated_at'], 'integer'],
            [['run_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => RunGroup::className(), 'targetAttribute' => ['run_group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'run_group_id' => 'Run Group ID',
            'rank' => 'Rank',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRunGroup()
    {
        return $this->hasOne(RunGroup::className(), ['id' => 'run_group_id']);
    }

    public function fields()
    {
        return [
            'runGroup'
        ];
    }
}
