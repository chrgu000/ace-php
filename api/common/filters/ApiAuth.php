<?php
// ////////////////////////////////////////////////////////////////////////////
//
// Copyright (c) 2015-2016 Hangzhou Freewind Technology Co., Ltd.
// All rights reserved.
// http://www.seastart.cn
//
// ///////////////////////////////////////////////////////////////////////////
namespace api\common\filters;

use common\exception\NeedLoginHttpException;
use common\models\User;
use common\util\Constants;
use yii\base\UserException;
use yii\filters\auth\AuthMethod;

/**
 * api auth
 *
 * @author Ather.Shu Apr 22, 2015 7:44:18 PM
 */
class ApiAuth extends AuthMethod {

    public function beforeAction($action) {
        $request = $this->request ?  : \Yii::$app->getRequest();
        $response = $this->response ?  : \Yii::$app->getResponse();
        
        $joke = $request->getHeaders()->get( 'JOKE' );
        $device = $request->getHeaders()->get( 'Device' );
        $token = $request->getHeaders()->get( 'Authorization' );
        
        if( $joke != Constants::APP_JOKE ) {
            $this->challenge( $response );
            $this->handleFailure( $response );
            return false;
        }
        
        $loginBlockFlag = false;
        $controller = $action->controller;
        if( $controller->needLoginActions == '*' ) {
            $loginBlockFlag = empty( $token );
        } else if( is_array( $controller->needLoginActions ) ) {
            foreach ( $controller->needLoginActions as $tmpAction ) {
                if( $action->id == $tmpAction && empty( $token ) ) {
                    $loginBlockFlag = true;
                    break;
                }
            }
        }
        if( $loginBlockFlag ) {
            $this->challenge( $response );
            throw new NeedLoginHttpException();
            return false;
        } else if( !empty( $token ) ) {
            $rtn = \Yii::$app->user->loginByAccessToken( $token );
            if(empty($rtn)){
                throw new UserException('token 无效');
            }
        }
        
        return true;
    }

    public function authenticate($user, $request, $response) {
        return null;
    }
}