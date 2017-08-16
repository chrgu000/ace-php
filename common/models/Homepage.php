<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "homepage".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $target_id
 * @property integer $rank
 * @property integer $created_at
 * @property integer $updated_at
 */
class Homepage extends \yii\db\ActiveRecord
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
        return 'homepage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'target_id', 'rank', 'created_at', 'updated_at'], 'integer'],
            [['target_id'], 'required'],
        ];
    }

    public function getTarget(){
        if(empty($this->type)){
            return $this->hasOne(Topic::className(), ['id' => 'target_id']);
        }
        else{
            return $this->hasOne(Activity::className(), ['id' => 'target_id']);
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'target_id' => 'Target ID',
            'rank' => 'Rank',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public  function fields()
    {
        return [
            'target'
        ];
    }
}
