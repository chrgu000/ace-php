<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "region".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $region_name
 * @property integer $region_type
 * @property integer $agency_id
 * @property string $areaid
 * @property string $zip
 * @property string $code
 *
 * @property RunGroup[] $runGroups
 * @property RunGroup[] $runGroups0
 * @property RunGroup[] $runGroups1
 */
class Region extends \yii\db\ActiveRecord
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
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'region_type', 'agency_id'], 'integer'],
            [['region_name'], 'string', 'max' => 120],
            [['areaid', 'zip', 'code'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'region_name' => 'Region Name',
            'region_type' => 'Region Type',
            'agency_id' => 'Agency ID',
            'areaid' => 'Areaid',
            'zip' => 'Zip',
            'code' => 'Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRunGroups()
    {
        return $this->hasMany(RunGroup::className(), ['province' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRunGroups0()
    {
        return $this->hasMany(RunGroup::className(), ['city' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRunGroups1()
    {
        return $this->hasMany(RunGroup::className(), ['region' => 'id']);
    }
}
