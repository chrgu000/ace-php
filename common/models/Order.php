<?php

namespace common\models;

use common\util\Constants;
use common\util\Utils;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order".
 *
 * @property string $id
 * @property string $type
 * @property string $target_id
 * @property string $sn
 * @property string $time
 * @property string $status
 * @property string $hidden
 * @property string $amount
 * @property string $paid_amount
 * @property integer $pay_type
 * @property integer $pay_platform
 * @property string $pay_trade_no
 * @property string $pay_time
 * @property string $refund_status
 * @property string $refund_paid
 * @property string $buyer_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $buyer
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'target_id', 'sn', 'time', 'amount'], 'required'],
            [['type', 'target_id', 'time', 'status', 'hidden', 'pay_type', 'pay_platform', 'pay_time', 'refund_status', 'buyer_id', 'created_at', 'updated_at'], 'integer'],
            [['amount', 'paid_amount', 'refund_paid'], 'number'],
            [['sn'], 'string', 'max' => 50],
            [['pay_trade_no'], 'string', 'max' => 100],
            [['buyer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['buyer_id' => 'id']],
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
            'target_id' => 'Target ID',
            'sn' => '订单号',
            'time' => '下单时间',
            'status' => '状态',
            'hidden' => 'Hidden',
            'amount' => '价格',
            'paid_amount' => '支付价格',
            'pay_type' => '付款类型',
            'pay_platform' => '付款平台',
            'pay_trade_no' => 'Pay Trade No',
            'pay_time' => '支付时间',
            'refund_status' => '退款状态',
            'refund_paid' => '退款金额',
            'buyer_id' => '购买者',
            'created_at' => '创建于',
            'updated_at' => '更新于',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyer()
    {
        return $this->hasOne(User::className(), ['id' => 'buyer_id']);
    }

    public function fields()
    {
        return [
            'id'=>function(){
                return Utils::encryptId($this->id,Constants::ENC_TYPE_ORDER);
            }
        ];
    }
}
