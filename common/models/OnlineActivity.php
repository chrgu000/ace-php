<?php

namespace common\models;

use common\util\Constants;
use common\util\Utils;
use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table 'online_activity'.
 *
 * @property integer $id
 * @property integer $activity_id
 * @property string $location
 * @property string $en_location
 * @property integer $end_time
 * @property integer $people_num
 * @property string $desc
 * @property string $en_desc
 * @property string $price
 * @property integer $benefit_walk_min
 * @property integer $benefit_run_min
 * @property integer $benefit_bike_min
 * @property integer $benefit_walk_max
 * @property integer $benefit_run_max
 * @property integer $benefit_bike_max
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Activity $activity
 */
class OnlineActivity extends \yii\db\ActiveRecord
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
        return 'online_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id'], 'required'],
            [['activity_id', 'end_time', 'people_num', 'benefit_walk_min', 'benefit_run_min', 'benefit_bike_min', 'benefit_walk_max', 'benefit_run_max', 'benefit_bike_max', 'created_at', 'updated_at'], 'integer'],
            [['desc', 'en_desc'], 'string'],
            [['price'], 'number'],
            [['location', 'en_location'], 'string', 'max' => 100],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_id' => 'Activity ID',
            'location' => 'Location',
            'en_location' => 'En Location',
            'end_time' => 'End Time',
            'people_num' => 'People Num',
            'desc' => 'Desc',
            'en_desc' => 'En Desc',
            'price' => 'Price',
            'benefit_walk_min' => 'Benefit Walk Min',
            'benefit_run_min' => 'Benefit Run Min',
            'benefit_bike_min' => 'Benefit Bike Min',
            'benefit_walk_max' => 'Benefit Walk Max',
            'benefit_run_max' => 'Benefit Run Max',
            'benefit_bike_max' => 'Benefit Bike Max',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
    }

    public function fields()
    {
        return [
            'id'=>function(){
                return Utils::encryptId($this->id,Constants::ENC_TYPE_ONLINE_ACTIVITY);
            },
            'location',
            'en_location',
            'end_time',
            'people_num',
            'desc',
            'en_desc',
            'price',
            'benefit_walk_min',
            'benefit_run_min',
            'benefit_bike_min',
            'benefit_walk_max',
            'benefit_run_max',
            'benefit_bike_max',
        ];
    }
}
