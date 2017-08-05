<?php
// ////////////////////////////////////////////////////////////////////////////
//
// Copyright (c) 2015-2016 Hangzhou Freewind Technology Co., Ltd.
// All rights reserved.
// http://www.seastart.cn
//
// ///////////////////////////////////////////////////////////////////////////
namespace api\common\filters;

use yii\base\ActionFilter;
use common\util\DataEncryptUtil;
use yii\web\UnauthorizedHttpException;

/**
 * 数据加密
 *
 * @author Ather.Shu May 22, 2015 4:56:10 PM
 */
class DataEncrypter extends ActionFilter {

    private $_encryptKey;

    private function checkNeedEncrypt($action) {
        $controller = $action->controller;
        $needEncrypt = false;
        if( $controller->needEncryptActions == '*' ) {
            $needEncrypt = true;
        }
        else if( is_array( $controller->needEncryptActions ) ) {
            foreach ( $controller->needEncryptActions as $tmpAction ) {
                if( $action->id == $tmpAction ) {
                    $needEncrypt = true;
                    break;
                }
            }
        }
        return $needEncrypt;
    }

    public function beforeAction($action) {
        $request = \Yii::$app->getRequest();
        
        $needEncrypt = $this->checkNeedEncrypt( $action );
        if( $needEncrypt ) {
            $user = \Yii::$app->getUser();
            if( $user->isGuest ) {
                throw new UnauthorizedHttpException( 'Please login first.', 999 );
                return false;
            }
            else {
                $this->_encryptKey = $user->identity->access_token;
                // 解密传递过来的数据
                $rawBody = file_get_contents( 'php://input' );
                if( $rawBody ) {
                    $rawBody = DataEncryptUtil::decrypt( $rawBody, $this->_encryptKey );
                    $request->setRawBody( $rawBody );
                }
            }
        }
        return true;
    }

    public function afterAction($action, $result) {
        $response = \Yii::$app->getResponse();
        
        $needEncrypt = $this->checkNeedEncrypt( $action );
        if( $needEncrypt ) {
            $controller = $action->controller;
            
            $result = \Yii::createObject( $controller->serializer )->serialize( $result );
            if( $response->isSuccessful ) {
                // 只加密正常数据
                $result = DataEncryptUtil::encrypt( json_encode( $result, 320 ), $this->_encryptKey );
            }
        }
        
        return $result;
    }
}