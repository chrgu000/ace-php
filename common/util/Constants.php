<?php
namespace common\util;

class Constants{
    // id加密
    const ID_CRYPT_KEY = "ol_crypt_key";

    const MAIL = '429407645@qq.com';

    const APP_JOKE = 'bensdfjasldfjxv!';

    const UPLOAD_TYPE_LIVE = 1;

    const UPLOAD_TYPE_APP = 2;

    const IMG_DELIMITER = '||';

    const ENC_TYPE_USER = 'USER';

    public static $UPLOAD_TYPES = [

        self::UPLOAD_TYPE_LIVE => [
            'name' => '海星直播图片',
            'max' => 2
        ],

        self::UPLOAD_TYPE_APP => [
            'name' => '海星直播图片',
            'max' => 2
        ],
    ];

}