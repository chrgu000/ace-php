<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "run_group_img".
 *
 * @property integer $id
 * @property integer $run_group_id
 * @property string $src
 * @property integer $cover
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property RunGroup $runGroup
 */
class RunGroupImg extends \yii\db\ActiveRecord
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
        return 'run_group_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['run_group_id', 'src'], 'required'],
            [['run_group_id', 'cover', 'created_at', 'updated_at'], 'integer'],
            [['src'], 'string', 'max' => 255],
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
            'src' => 'Src',
            'cover' => 'Cover',
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
}
