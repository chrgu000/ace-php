<?php
use common\util\Utils;
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser'
            ],
            'cookieValidationKey' => '9ueFlfTMFbaGPROT5_6H58snthzx-ewF',
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'charset' => 'UTF-8',
            'on beforeSend' => function ($event) {
                /* @var $response yii\web\Response */
                $response = $event->sender;
                Utils::formatApiResponse($response);
            }
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [

        ],
        'urlManager' => [
            'enablePrettyUrl' => true, // 启用美化URL
            'enableStrictParsing' => true, // 是否执行严格的url解析
            'showScriptName' => false, // 在URL路径中是否显示脚本入口文件
            'rules' => [
                'OPTIONS <any:.*>' => 'v1/api/response',
                // 获取用户资料
                'POST v1/users/index' => 'v1/user/index',
                // 用户注册
                'POST v1/users/oauths' => 'v1/user/oauths',
                // 发送验证码
                'POST v1/users/code' => 'v1/user/code',
                // 用户登录
                'POST v1/users/login' => 'v1/user/login',
                // 昵称是否可用
                'GET v1/users/check-nick' => 'v1/user/nickname',
                // 设置用户昵称
                'POST v1/users' => 'v1/user/set-nickname',
                // 用户重新设置密码
                'POST v1/users/reset-pwd' => 'v1/user/set-password',
                // 获取顽兔上传文件凭证
                'GET v1/upload/token' => 'v1/api/token',
                // 获取顽兔上传的文件名
                'GET v1/upload/file-name' => 'v1/api/file-name',

                // 线上报名
                'POST v1/activity/online/<id:.+>' => 'v1/activity/online',
                // 线下报名
                'POST v1/activity/offline/<id:.+>' => 'v1/activity/offline',


                // 首页
                'GET v1/homepage/index' => 'v1/homepage/index',

                // 专题列表
                'GET v1/topic/index' => 'v1/activity/topic',
                // 获取活动详情
                'GET v1/activity/list/<id:.+>' => 'v1/activity/list',
                // 获取活动详情
                'GET v1/activity/show/<id:.+>' => 'v1/activity/show',

                // 获取跑团详情
                'GET v1/group/show/<id:.+>' => 'v1/run-group/show',
                // 创建跑团
                'POST v1/group/create' => 'v1/run-group/create',
                // 加入跑团
                'POST v1/group/join/<id:.+>' => 'v1/run-group/join',
                // 加入跑团
                'POST v1/group/praise/<id:.+>/<user_id:.+>' => 'v1/run-group/praise',

                // 官方招募
                'POST v1/recruit' => 'v1/recruit/create',


                // 我的报名
                'GET v1/my/activity/index' => 'v1/my/activity',
                // 我的跑团
                'GET v1/my/group/index' => 'v1/my/run-group',


                // 外链
                'GET v1/link' => 'v1/link/link',


            ],
        ],

    ],
    'params' => $params,
];
