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
use common\util\Constants;
use common\util\Utils;
use common\util\YunPianManager;
use yii\base\UserException;
use yii\filters\VerbFilter;


class UserController extends BaseController
{

    public $needLoginActions = ['index','set-nickname'];

    /**
     * @api {post} /user/code 发送验证码
     *
     * @apiGroup user
     * @apiParam {string} username 手机号或则邮箱
     * @apiParam {int} type 0 代表注册 1 代表重设密码
     *
     * @apiSuccessExample SuccessExample
     * {
     * "data": 1,
     * "api_code": 200
     * }
     */
    public function actionCode()
    {
        $username = \Yii::$app->request->post('username', '');
        $type = \Yii::$app->request->post('type',0);
        $is_mobile = false;
        $is_email = false;
        $pattern = '/^1[34578]\d{9}$/';
        if (preg_match($pattern, $username)) {
            $is_mobile = true;
        }
        $pattern = '/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i';
        if (preg_match($pattern, $username)) {
            $is_email = true;
        }
        if (empty($is_email) && empty($is_mobile)) {
            throw new UserException('手机或者邮箱不正确');
        }
        $user = User::findOne(['username' => $username]);
        if($type == 0){
            if ($user) {
                throw new UserException('用户名已被注册');
            }
        }else{
            if(empty($username)){
                throw new UserException('此用户名没有注册过');
            }
        }

//        $code = '8888';
        $code = $this->randCode(4);
        \Yii::$app->cache->set("code_" . $username, $code, 20 * 60);
        if ($is_mobile) {
            $res = YunPianManager::sendAdminSMS($username, '【益跑益行】您的验证码是' . $code);
        }
        if ($is_email) {
            $res = \Yii::$app->mailer->compose('mail.php', ['code' => $code])
                ->setFrom('429407645@qq.com')
                ->setTo($username)
                ->setSubject('益跑益行注册验证')
                ->send();
        }
        \Yii::error($res);
        return ['data' => 1];
    }

    /**
     * @api {post} /user/oauths 用户注册
     *
     * @apiGroup user
     * @apiParam {string} username 手机号或则邮箱
     * @apiParam {string} password 密码
     * @apiParam {string} code 验证码(发手机或则邮箱)
     * @apiSuccessExample SuccessExample
     * {
     * "id": "xlzgw",
     * "username": "15167813170",
     * "nickname": "15167813170",
     * "type": 0,
     * "created_at": 1502090875,
     * "access_token": "5988167bdedad_1502090875",
     * "api_code": 200
     * }
     */
    public function actionOauths()
    {
        $username = \Yii::$app->request->post('username', '');
        $password = \Yii::$app->request->post('password', '');
        $code = \Yii::$app->request->post('code', '');
        $origin_code = \Yii::$app->cache->get('code_' . $username);
        if (empty($origin_code)) {
            throw new UserException('还没有发送验证码');
        }
        if ($code != $origin_code) {
            throw new UserException('验证码不正确');
        }
        if (strlen($password) < 6) {
            throw new UserException('密码不能小于6位');
        }
        $type = -1;
        $pattern = '/^1[34578]\d{9}$/';
        if (preg_match($pattern, $username)) {
            $type = 0;
        }
        if ($type < 0) {
            $pattern = '/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i';
            if (preg_match($pattern, $username)) {
                $type = 1;
            }
        }
        if ($type < 0) {
            throw new UserException('用户名不正确');
        }
        $model = User::find()->where([
            'username' => $username
        ])->one();
        if ($model) {
            throw new UserException('用户名已被使用');
        }
        $user = new User();
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->username = $username;
        $user->nickname = $username;
        $user->type = $type;
        if ($user->save()) {
            return $user->toArray([], ['access_token']);
        } else {
            throw new UserException(implode('|', $user->getFirstErrors()));
        }
    }

    /**
     * @api {get} /user/index 获取登录用户信息
     *
     * @apiGroup user
     * @apiPermission token
     * @apiSuccessExample SuccessExample 同用户注册接口
     * {
     * "id": "xlzgw",
     * "username": "15167813170",
     * "nickname": "15167813170",
     * "type": 0,
     * "created_at": 1502090875,
     * "access_token": "5988167bdedad_1502090875",
     * "api_code": 200
     * }
     */
    public function actionIndex()
    {
        $user = \Yii::$app->user->identity;
        return $user->toArray([], ['access_token']);
    }


    /**
     * @api {get} /user/nickname 用户昵称是否可用
     *
     * @apiGroup user
     * @apiParam {string} nickname 昵称
     * @apiSuccessExample SuccessExample 0 昵称不可用 1 昵称可用
     *{
     * "data": 0,
     * "api_code": 200
     * }
     */
    public function actionNickname()
    {
        $nickname = \Yii::$app->request->get('nickname', '');
        if (empty($nickname)) {
            throw new UserException('昵称不能为空');
        }
        $user = User::findOne([
            'nickname' => $nickname
        ]);
        if ($user) {
            return ['data' => 0];
        } else {
            return ['data' => 1];
        }
    }


    /**
     * @api {post} /user/set-nickname 设置用户昵称
     *
     * @apiGroup user
     * @apiParam {string} nickname 昵称
     * @apiPermission token
     * @apiSuccessExample SuccessExample
     *{
     * "data": 1,
     * "api_code": 200
     * }
     */
    public function actionSetNickname()
    {
        $nickname = \Yii::$app->request->post('nickname', '');
        if (empty($nickname)) {
            throw new UserException('昵称不能为空');
        }
        $user = User::findOne([
            'nickname' => $nickname
        ]);
        if ($user) {
            throw new UserException('昵称已经被占用了');
        }
        $user = \Yii::$app->user->identity;
        $user->nickname = $nickname;
        if($user->save()){
            return ['data' => 1];
        }else{
            throw new UserException(implode('|',$user->getFirstErrors()));
        }
    }

    /**
     * @api {post} /user/login 用户登录
     *
     * @apiGroup user
     * @apiParam {string} username 用户名称
     * @apiParam {string} password 密码
     *
     * @apiSuccessExample SuccessExample
     * 同用户注册
     */
    public function actionLogin()
    {
        $username = \Yii::$app->request->post('username','');
        $password = \Yii::$app->request->post('password','');
        $user = User::findOne(['username' => $username]);
        if(empty($user)){
            throw new UserException('用户名不存在');
        }
        if($user->validatePassword($password)){
            return $user->toArray([],['access_token']);
        }else{
            throw new UserException('用户密码不正确');
        }
    }

    /**
     * @api {post} /user/set-password 用户重新设置密码
     *
     * @apiGroup user
     * @apiParam {string} username 手机号或则邮箱
     * @apiParam {string} password 密码
     * @apiParam {string} code 验证码(发手机或则邮箱)
     * @apiSuccessExample SuccessExample
     * 同用户注册
     */
    public function actionSetPassword(){
        $username = \Yii::$app->request->post('username','');
        $password = \Yii::$app->request->post('password','');
        $code = \Yii::$app->request->post('code','');
        $origin_code = \Yii::$app->cache->get('code_' . $username);
        if (empty($origin_code)) {
            throw new UserException('还没有发送验证码');
        }
        if ($code != $origin_code) {
            throw new UserException('验证码不正确');
        }
        if (strlen($password) < 6) {
            throw new UserException('密码不能小于6位');
        }
        $type = -1;
        $pattern = '/^1[34578]\d{9}$/';
        if (preg_match($pattern, $username)) {
            $type = 0;
        }
        if ($type < 0) {
            $pattern = '/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i';
            if (preg_match($pattern, $username)) {
                $type = 1;
            }
        }
        if ($type < 0) {
            throw new UserException('用户名不正确');
        }
        $user = User::findOne(['username' => $username]);
        $user->setPassword($password);
        if($user->save()){
            return $user->toArray([],['access_token']);
        }else{
            throw new UserException(implode('|',$user->getFirstErrors()));
        }
    }

    /**
     * 生成num位随机数
     */
    private function randCode($num)
    {
        $string = '';
        for ($i = 0; $i < $num; $i++) {
            $string .= rand(0, 9);
        }
        return $string;
    }

}