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
use common\service\MyService;
use common\util\Constants;
use common\util\Utils;
use common\util\YunPianManager;
use yii\base\UserException;
use yii\filters\VerbFilter;


class UserController extends BaseController
{

    public $needLoginActions = ['index','set-nickname'];

    /**
     * @api {post} /users/code 发送验证码
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
     * @api {post} /users/oauths 用户注册
     *
     * @apiGroup user
     * @apiParam {string} username 手机号或则邮箱
     * @apiParam {string} password 密码
     * @apiParam {string} code 验证码(发手机或则邮箱)
     * @apiParam {string} step_number 步数
     *
     * @apiSuccessExample SuccessExample
        {
        "id": "xlzgw",
        "username": "18868343306",
        "nickname": "18868343306",
        "type": 0,
        "created_at": 1502703532,
        "step_number": 2000,
        "cal": 80,
        "access_token": "59916facdc278_1502703532",
        "api_code": 200
        }
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
     * @api {post} /users/index 获取登录用户信息
     *
     * @apiGroup user
     *
     * @apiParam {string} step_number 步数
     *
     * @apiPermission token
     * @apiSuccessExample SuccessExample 同用户注册接口
        {
        "id": "xlzgw",
        "username": "18868343306",
        "nickname": "18868343306",
        "type": 0,
        "created_at": 1502703532,
        "step_number": 2000,
        "cal": 80,
        "access_token": "59916facdc278_1502703532",
        "api_code": 200
        }
     */
    public function actionIndex()
    {
        $step_number=$this->getParam('step_number',0);
        $user = \Yii::$app->user->identity;
        MyService::document($step_number);
        return $user->toArray([], ['access_token']);
    }


    /**
     * @api {get} /users/check-nick 用户昵称是否可用
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
     * @api {post} /users 更新当前登录用户资料
     * @apiVersion 0.1.0
     *
     * @apiGroup user
     * @apiPermission token
     *
     * @apiParam {string} nickname 昵称
     * @apiParam {string} avatar 头像
     * @apiParam {string} sign 签名
     * @apiParam {string} school 学校
     * @apiParam {string} province 省份id
     * @apiParam {string} city 城市id
     * @apiParam {string} inauguration_status 就职状态 0 在校 1 在职 2 其他
     * @apiParam {string} age 年龄 0 60后 1 70后 2 80后 3 90后 4 00后
     * @apiParam {int} gender 性别（0为女，1为男）
     *
     * @apiSuccessExample 范例（注：更新哪些字段就传哪些字段）
     * 同获取当前登录用户信息
     */
    public function actionSetNickname()
    {
        $nickname = \Yii::$app->request->post('nickname', '');
//        $user = User::findOne([
//            'nickname' => $nickname
//        ]);
//        if ($user) {
//            throw new UserException('昵称已经被占用了');
//        }
        $user = \Yii::$app->user->identity;
        if( !empty( $nickname ) ) {
            $user->nickname = $nickname;
        }
        $avatar = $this->getParam( 'avatar' );
        if( !empty( $avatar ) ) {
            $user->avatar = $avatar;
        }
        // 更改签名
        $sign = $this->getParam( 'sign' );
        if( isset( $sign ) ) {
            $user->sign = $sign;
        }
        // 更改性别、生日
        $gender = $this->getParam( 'gender' );
        if( isset( $gender ) ) {
            $user->gender = $gender;
        }
        $school= $this->getParam( 'school' ) ;
        if( !empty( $school ) ) {
            $user->school = $school;
        }
        $province= $this->getParam( 'province' ) ;
        if( !empty( $province ) ) {
            $user->province = $province;
        }
        $city= $this->getParam( 'city' ) ;
        if( !empty( $city ) ) {
            $user->city = $city;
        }
        $inauguration_status= $this->getParam( 'inauguration_status' ) ;
        if( !empty( $inauguration_status ) ) {
            $user->inauguration_status = $inauguration_status;
        }
        $age= $this->getParam( 'age' ) ;
        if( !empty( $age ) ) {
            $user->age = $age;
        }
        if($user->save()){
            return $user;
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
     * @apiParam {string} step_number 步数
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
            $step_number=$this->getParam('step_number',0);
            MyService::document($step_number);
            return $user->toArray([],['access_token']);
        }else{
            throw new UserException('用户密码不正确');
        }
    }

    /**
     * @api {post} /users/reset-pwd 用户重新设置密码
     *
     * @apiGroup user
     * @apiParam {string} username 手机号或则邮箱
     * @apiParam {string} password 密码
     * @apiParam {string} code 验证码(发手机或则邮箱)
     * @apiParam {string} step_number 步数
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
            $step_number=$this->getParam('walk',0);
            MyService::document($step_number);
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