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

                'GET v1/user/index' => 'v1/user/index',
            ],
        ],

    ],
    'params' => $params,
];
