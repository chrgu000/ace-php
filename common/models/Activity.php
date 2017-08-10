<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "activity".
 *
 * @property integer $id
 * @property integer $topic_id
 * @property string $cover
 * @property string $title
 * @property string $en_title
 * @property string $location
 * @property string $en_location
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $join_type
 * @property integer $people_num
 * @property string $desc
 * @property string $en_desc
 * @property string $price
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $benefit_walk
 * @property integer $benefit_run
 * @property integer $benefit_bike
 *
 * @property Topic $topic
 */
class Activity extends \yii\db\ActiveRecord
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
        return 'activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topic_id', 'start_time', 'end_time', 'join_type', 'people_num', 'created_at', 'updated_at', 'benefit_walk', 'benefit_run', 'benefit_bike'], 'integer'],
            [['desc', 'en_desc'], 'string'],
            [['price'], 'number'],
            [['cover', 'title', 'en_title', 'location', 'en_location'], 'string', 'max' => 100],
            [['topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topic::className(), 'targetAttribute' => ['topic_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topic_id' => 'Topic ID',
            'cover' => 'Cover',
            'title' => 'Title',
            'en_title' => 'En Title',
            'location' => 'Location',
            'en_location' => 'En Location',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'join_type' => 'Join Type',
            'people_num' => 'People Num',
            'desc' => 'Desc',
            'en_desc' => 'En Desc',
            'price' => 'Price',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'benefit_walk' => 'Benefit Walk',
            'benefit_run' => 'Benefit Run',
            'benefit_bike' => 'Benefit Bike',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }
}
