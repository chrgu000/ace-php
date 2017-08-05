<?php
namespace common\util;

class Constants{
    // id加密
    const ID_CRYPT_KEY = "ol_crypt_key";

    const APP_JOKE = 'bensdfjasldfjxv!';

    const UPLOAD_TYPE_LIVE = 1;

    const IMG_DELIMITER = '||';

    const SLIDE_TYPE_LIVE = 0;

    const SLIDE_TYPE_VOD = 1;

    const USER_TOKEN = '595f02837a99e_578_1499398787';

    public static $UPLOAD_TYPES = [

        self::UPLOAD_TYPE_LIVE => [
            'name' => '海星直播图片',
            'max' => 2
        ],

    ];

    const USER_LIMIT_TYPE_1 = 1;

    const USER_LIMIT_TYPE_2 = 2;

    const USER_LIMIT_TYPE_3 = 3;

    const USER_LIMIT_TYPE_4 = 4;

    const USER_LIMIT_TYPE_5 = 5;

    // 白领，金领，粉领，督导，高级督导
    public static $USER_LIMIT_TYPE = [
        self::USER_LIMIT_TYPE_1 => '白领',

        self::USER_LIMIT_TYPE_2 => '金领',

        self::USER_LIMIT_TYPE_3 => '粉领',

        self::USER_LIMIT_TYPE_4 => '督导',

        self::USER_LIMIT_TYPE_5 => '高级督导',
    ];
}