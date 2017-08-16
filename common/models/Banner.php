<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "banner".
 *
 * @property integer $id
 * @property integer $target_id
 * @property string $link
 * @property integer $type
 * @property string $img
 * @property integer $rank
 * @property integer $created_at
 * @property integer $updated_at
 */
class Banner extends \yii\db\ActiveRecord
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
        return 'banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['target_id', 'type', 'rank', 'created_at', 'updated_at'], 'integer'],
            [['link'], 'string', 'max' => 255],
            [['img'], 'string', 'max' => 1000],
        ];
    }

    public function getTarget(){
        if($this->type==0){
            return $this->target_id;
        }
        if($this->type==1){
            return $this->hasOne(Topic::className(), ['id' => 'target_id']);
        }
        if($this->type==2){
            return $this->hasOne(Activity::className(), ['id' => 'target_id']);
        }
        if($this->type==3){
            return $this->hasOne(Activity::className(), ['id' => 'target_id']);
        }
        return $this->target_id;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'target_id' => 'Target ID',
            'link' => 'Link',
            'type' => 'Type',
            'img' => 'Img',
            'rank' => 'Rank',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function fields()
    {
        return [
            'type',
            'img',
            'link',
            'target',
        ];
    }
}
