<?php

namespace common\models;

use common\util\Constants;
use common\util\Utils;
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
 * @property integer $start_time
 * @property integer $people_num
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Topic $topic
 * @property OfflineActivity[] $offlineActivities
 * @property Online[] $onlines
 * @property OnlineActivity[] $onlineActivities
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
            [['topic_id', 'start_time', 'people_num', 'created_at', 'updated_at'], 'integer'],
            [['cover', 'title', 'en_title'], 'string', 'max' => 100],
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
            'start_time' => 'Start Time',
            'people_num' => 'People Num',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfflineActivities()
    {
        return $this->hasOne(OfflineActivity::className(), ['activity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnlines()
    {
        return $this->hasMany(Online::className(), ['activity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnlineActivities()
    {
        return $this->hasOne(OnlineActivity::className(), ['activity_id' => 'id']);
    }

    public function fields()
    {
        return [
            'id'=>function(){
                return Utils::encryptId($this->id,Constants::ENC_TYPE_ACTIVITY);
            },
            'topic_id'=>function(){
                return Utils::encryptId($this->topic_id,Constants::ENC_TYPE_TOPIC);
            },
            'cover',
            'title',
            'en_title',
            'start_time',
            'people_num',
            //'online_activity'=>'onlineActivities',
            //'offline_activity'=>'offlineActivities',
        ];
    }
    public function extraFields()
    {
        return [
        ];
    }
}
