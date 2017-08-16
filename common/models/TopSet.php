<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "top_set".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $count
 * @property integer $created_at
 * @property integer $updated_at
 */
class TopSet extends \yii\db\ActiveRecord
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
        return 'top_set';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'count', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'count' => 'Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function fields()
    {
        return [
            'type',
            'count',
        ];
    }
}
