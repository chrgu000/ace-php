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

    const ENC_TYPE_TOPIC = 'TOPIC';

    const ENC_TYPE_ACTIVITY = 'ACTIVITY';

    const ENC_TYPE_ONLINE_ACTIVITY = 'ONLINE_ACTIVITY';

    const ENC_TYPE_OFFLINE_ACTIVITY = 'OFFLINE_ACTIVITY';

    const ENC_TYPE_ONLINE = 'ONLINE';

    const ENC_TYPE_ORDER = 'ORDER';

    const ORDER_TYPE_ONLINE = 0;

    const ORDER_TYPE_OFFLINE = 1;

    const OFFLINE_TYPE_INDIVIDUSL=0;

    const OFFLINE_TYPE_ENTERPRISE=1;

    const OFFLINE_TYPE_MEDIA=2;

    const OFFLINE_TYPE_STRATEGIC=3;



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