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
use common\util\AliBcManager;
use common\util\Constants;
use common\util\Utils;
use yii\base\UserException;
use yii\filters\VerbFilter;


class ApiController extends BaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);
        unset($behaviors['encrypter']);
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'response' => [
                    'post',
                    'options',
                    'get',
                ]
            ]
        ];
        return $behaviors;
    }

    public function actionResponse()
    {
        return ['data' => 1];
    }

    /**
     * @api {get} /upload/token 获取上传凭证
     *
     * @apiGroup api
     *
     * @apiSuccessExample SuccessExample
     * {
     * "token": "UPLOAD_AK_TOP MjQ1NjkyNDE6ZXlKdVlXMWxjM0JoWTJVaU9pSmlaVzVsWm1sMElpd2lZblZqYTJWMElqcHVkV3hzTENKcGJuTmxjblJQYm14NUlqb3dMQ0psZUhCcGNtRjBhVzl1SWpveE5UQXlNVGM1TmpnMU16WXhMQ0prWlhSbFkzUk5hVzFsSWpveExDSmthWElpT201MWJHd3NJbTVoYldVaU9tNTFiR3dzSW5OcGVtVk1hVzFwZENJNmJuVnNiQ3dpYldsdFpVeHBiV2wwSWpwdWRXeHNMQ0pqWVd4c1ltRmphMVZ5YkNJNmJuVnNiQ3dpWTJGc2JHSmhZMnRJYjNOMElqcHVkV3hzTENKallXeHNZbUZqYTBKdlpIa2lPbTUxYkd3c0ltTmhiR3hpWVdOclFtOWtlVlI1Y0dVaU9tNTFiR3dzSW5KbGRIVnlibFZ5YkNJNmJuVnNiQ3dpY21WMGRYSnVRbTlrZVNJNmJuVnNiQ3dpYldWa2FXRkZibU52WkdVaU9tNTFiR3g5OjQyZDYzN2NiZTc3MmQ4NTI1MzQ1ZTIzYWMyYjE0NDQ1ZjI3YjA0ZjY",
     * "expiration": 1502179685361,
     * "api_code": 200
     * }
     */
    public function actionToken()
    {
        $rtn = AliBcManager::getWantuUploadToken();
        return $rtn;
    }

    /**
     * @api {get} /upload/file-name 获取上传的文件名称
     *
     * @apiGroup api
     *
     * @apiSuccessExample SuccessExample
     *{
     * "dir": 2,
     * "file-name": "15021790461",
     * "api_code": 200
     * }
     */
    public function actionFileName()
    {
        return [
            'dir' => Constants::UPLOAD_TYPE_APP,
            'file-name' => time() . rand(0, 9) ,
        ];
    }
}