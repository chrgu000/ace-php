<?php
/**
 * Created by PhpStorm.
 * User: jiangminjie
 * Date: 2017/8/17
 * Time: 下午4:22
 */

namespace api\common\controllers;


use common\models\Link;
use yii\base\ErrorException;

class LinkController extends BaseController
{

    /**
     * @api {get} /link 外链
     *
     *
     * @apiGroup link
     *
     * @apiParam {string} type 0 新浪微博 1 爱心捐赠 2 外链商城
     *
     *
     *
     * @apiSuccessExample SuccessExample
        {
        "link": "https://www.baidu.com/",
        "api_code": 200
        }
     */

    public function actionLink()
    {
        $type=$this->getParam('type',0,true);
        if (empty(Link::find()->where(['type'=>$type])->one())){
            throw new ErrorException('外链不能为空');
        }
        return Link::find()->where(['type'=>$type])->one();
    }
}