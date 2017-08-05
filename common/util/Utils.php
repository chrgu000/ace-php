<?php
// ////////////////////////////////////////////////////////////////////////////
//
// Copyright (c) 2015-2016 Hangzhou Freewind Technology Co., Ltd.
// All rights reserved.
// http://www.seastart.cn
//
// ///////////////////////////////////////////////////////////////////////////
namespace common\util;

use Hashids\Hashids;
use yii\base\Model;
use yii\base\UserException;
use yii\web\Response;

/**
 * utils
 *
 * @author Ather.Shu Apr 27, 2015 11:29:09 AM
 */
class Utils {

    private static $_idHashers = [ ];

    /**
     * 获取id hasher
     *
     * @param string $type
     * @return Hashids
     */
    private static function getIdHasher($type) {
        if( !isset( self::$_idHashers [$type] ) ) {
            self::$_idHashers [$type] = new Hashids( Constants::ID_CRYPT_KEY . $type, 5, 'abcdefghijklmnopqrstuvwxyz1234567890' );
        }
        return self::$_idHashers [$type];
    }

    /**
     * id加密
     *
     * @param int $id
     * @param string $type 如order address goods
     * @return string
     */
    public static function encryptId($id, $type) {
        return self::getIdHasher( $type )->encode( $id );
    }

    /**
     * id解密
     *
     * @param string $encID
     * @param string $type 如order address goods
     * @return int
     */
    public static function decryptId($encID, $type) {
        $data = self::getIdHasher( $type )->decode( $encID );
        return empty( $data ) ? '' : $data [0];
    }

    /**
     * 模板字符串
     *
     * @param string $tpl {user}于{time}关注了您
     * @param [] $data
     */
    public static function tpl($tpl, $data) {
        $rtn = preg_replace_callback( "/{(.+?)}/i", function ($match) use($data) {
            return $data [$match [1]];
        }, $tpl );
        return $rtn;
    }

    /**
     * xml转数组
     *
     * @param string $xml
     * @return []
     */
    public static function xml2Array($xml) {
        $result = simplexml_load_string( $xml, 'SimpleXMLElement', LIBXML_NOCDATA );
        return json_decode( json_encode( $result ), true );
    }

    /**
     * 格式化
     *
     * @param string|number $money
     * @param int $precision 精度，默认小数点后两位
     * @return number
     */
    public static function roundMoney($money, $precision = 2) {
        $flag = pow( 10, $precision );
        return round( $flag * $money ) / $flag;
    }

    /**
     * 抛出模型错误异常
     *
     * @param Model $model
     * @param string $message
     * @param boolean $prepend
     */
    public static function throwModelErrorException($model, $message, $prepend = true) {
        $error = '';
        if( $model->hasErrors() ) {
            $error = implode( ", ", $model->getFirstErrors() );
        }
        throw new UserException( $error ? ($prepend ? "{$message}：{$error}" : $error) : $message );
    }

    /**
     * 格式化api json response
     * @param Response $response
     */
    public static function formatApiResponse($response) {
        if($response->format != Response::FORMAT_JSON) {
            return;
        }
        if( $response->isSuccessful ) {
            // 如果非数组或者纯数组，套一层data
            //array_keys($response->data) === array_keys(array_keys($response->data))
            if(!array_key_exists('api_code',$response->data)){
                if(!is_array( $response->data ) || empty($response->data) || array_keys($response->data) === range(0, count($response->data) - 1)) {
                    $response->data = [
                        'data' => $response->data ,
                        'api_code' => 200
                    ];
                }
                else {
                    $response->data['api_code'] = 200;
                }
            }
        }
        else {
            //data在有运行error或者exception是一维数组
            //有model错误时是多维数组
            //统一转化为一维数组
            $error = $response->data;
            if(isset($error['message'])) {
                if(empty($error['message'])) {
                    $error['message'] = $error['name'];
                }
                $error = [$error];
            }
            $response->data = [
                'api_code' => $response->statusCode,
                'api_msg' => $error[0]['message']
            ];
        }
        $response->statusCode = 200;
    }

    /**
     * 获取后端图片渲染前缀
     */
    public static function getImgUrlPrefix() {
        $imgPrefix = \Yii::$app->params['stv']['imgPrefix'];
        return $imgPrefix;
    }

    /**
     * 获取图片全路径
     */
    public static function getFullImageUrl($path){
        if(substr($path, 0, strlen('http://')) == 'http://'){
            return $path;
        }
        if(substr($path, 0, strlen('https://')) == 'https://') {
            return $path;
        }
        $imgPrefix = Utils::getImgUrlPrefix();
        return $imgPrefix.$path;
    }

    /**
     * 渲染一张预览图
     *
     * @param string $img
     * @return string
     */
    public static function renderPreviewImg($img, $small = false) {
        if( empty( $img ) ) {
            return '';
        }
        $img = self::getImgFullUrl($img);
        return "<div class='img-preview " . ($small ? 'img-preview-sm' : '') . "'><img src='{$img}'></div>";
    }

    public static function renderPreviewImgs($imgs, $small = false, $max = null) {
        if( empty( $imgs ) ) {
            return '';
        }
        if( is_string( $imgs ) ) {
            $imgs = explode( Constants::IMG_DELIMITER, $imgs );
        }
        $rtn = '';
        $index = 0;
        foreach ( $imgs as $img ) {
            $rtn .= self::renderPreviewImg( $img, $small );
            $index++;
            if( $max && $index == $max ) {
                break;
            }
        }
        return $rtn;
    }
}