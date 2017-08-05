<?php
/**
 * Created by PhpStorm.
 * User: huangdaneng
 * Date: 2017/7/31
 * Time: 下午6:01
 */

namespace api\common\controllers;

use common\models\Lesson;
use common\models\User;
use common\models\UserCoinLog;
use common\models\Vod;
use common\util\Constants;
use common\util\Utils;
use yii\base\UserException;
use yii\filters\VerbFilter;


class UserController extends BaseController
{

    public $needLoginActions = '*';

    /**
     * @api {get} /user/index 获取用户信息
     *
     * @apiGroup user
     * @apiSuccessExample SuccessExample
     *{
     * "id": 1,
     * "nickname": "daneng",
     * "avatar": "http://wx.qlogo.cn/mmopen/ibAxyNsAKaAbicHrXpiaKMahxTf9l3631k9wY0NsxCgA86SQibLfjGiaGh1F6GDtJJiaEE6icIUg2kdCV7Sic272ZXBj2yVtA0ADfKyl/0",
     * "access_token": "596de1610918c_1500373345",
     * "password_reset_token": null,
     * "auth_key": "fFjVipWhroq0egeu-g36RFtl_PSILy4F",
     * "open_id": null,
     * "union_id": null,
     * "gender": 0,
     * "city": null,
     * "created_at": 1500373345,
     * "updated_at": 1500373345,
     * "api_code": 200
     * }
     */
    public function actionIndex()
    {
        $user = \Yii::$app->user->identity;
        return $user;
    }

}