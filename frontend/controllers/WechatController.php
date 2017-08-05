<?php
// ////////////////////////////////////////////////////////////////////////////
//
// ATHER.SHU WWW.ASAREA.CN
// All Rights Reserved.
// email: shushenghong@gmail.com
//
// ///////////////////////////////////////////////////////////////////////////
namespace frontend\controllers;

use common\models\CharacterUser;
use yii\web\UnauthorizedHttpException;
use yii\web\Response;
use yii\base\UserException;

/**
 * 微信公众号
 *
 * @author Ather.Shu May 29, 2016 4:11:06 PM
 */
class WechatController extends BaseController {

    public $enableCsrfValidation = false;

    public $layout = false;

    private function getWechat() {
        $options = \WechatConfig::getConfig();
        $wechat = new \Wechat( $options );
        return $wechat;
    }

    /**
     * 微信收到用户消息
     */
    public function actionResponse() {
        $this->getWechat()->valid();
    }

    /**
     * 获取微信js分享参数
     *
     * @throws UnauthorizedHttpException
     */
    public function actionJsSign() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        \Yii::error(\Yii::$app->request->post());
        $url = \Yii::$app->request->post( "url");
        if( empty( $url ) ) {
            throw new UnauthorizedHttpException('url不能为空');
        }
        $params = $this->getWechat()->getJsSign( $url );
        return $params;
    }

    /**
     * 获取当前浏览网页的用户的openid
     *
     * @throws UnauthorizedHttpException
     */
    public function actionGetOpenId() {
        $url = \Yii::$app->request->get( "url" );
        if( empty( $url ) ) {
            throw new UnauthorizedHttpException( '请输入最终要回调的url' );
        }
        $wechat = $this->getWechat();
        $tokenData = $wechat->getOauthAccessToken();
        \Yii::error($tokenData);
        if( empty( $tokenData ) ) {
            $redirect = $wechat->getOauthRedirect( \Yii::$app->request->getAbsoluteUrl(), 'foropenid', 'snsapi_base' );
            $this->redirect( $redirect );
        } else {
            $url = $url . (strpos( $url, '?' ) === false ? '?' : '&') . 'open_id=' . $tokenData ['openid'];
            $this->redirect( $url );
        }
    }

    /**
     * 微信自动登录注册平台账号
     */
    public function actionAutoLogin() {
        $url = \Yii::$app->request->get( "url" );
        if( empty( $url ) ) {
            throw new UnauthorizedHttpException( '请输入最终要回调的url' );
        }
        $wechat = $this->getWechat();
        $tokenData = $wechat->getOauthAccessToken();
        if( empty( $tokenData ) ) {
            $redirect = $wechat->getOauthRedirect( \Yii::$app->request->getAbsoluteUrl(), 'forautologin', 'snsapi_userinfo' );
            $this->redirect( $redirect );
        } else {
            $userInfo = $wechat->getOauthUserinfo( $tokenData ['access_token'], $tokenData ['openid'] );
            // var_export($userInfo);exit;
            // 自动获取邀请人
            parse_str( parse_url( rawurldecode( $url ), PHP_URL_QUERY ), $params );
            // 根据详细信息注册
            $loginData = $this->callApi( "users/oauth", 
                    [
                        'open_id' => $userInfo ['openid'],
                        'nickname' => $userInfo ['nickname'],
                        'avatar' => $userInfo ['headimgurl'],
                        'gender' => $userInfo ['sex'] == 2 ? 0 : 1,
                    ], "v1", "post" );
            if( isset( $loginData ['error'] ) ) {
                throw new UserException( $loginData ['error'] ['message'] );
            }
            $this->redirect( $url );
        }
    }
}
