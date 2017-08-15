<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/13
 * Time: 9:37
 */

namespace common\service;


use common\models\OfflineCoursePayRecord;
use common\models\Order;
use common\models\TeacherApply;
use common\models\VideoPayRecord;
use common\models\VideoPraiseRecord;
use common\models\VideoRelevance;
use common\util\Constants;
use yii\base\ErrorException;

class OrderService
{

    public static function confirm($type,$target_id,$user_id,$amount){
        $order=new Order();
        $order->sn = 'td' . date("YmdHis") . $user_id . rand(100, 999);
        $order->type=$type;
        $order->target_id=$target_id;
        $order->time=time();
        $order->amount=$amount;
        $order->paid_amount=$amount;
        $order->buyer_id=$user_id;
        $order->save();
        return $order;
    }

}
