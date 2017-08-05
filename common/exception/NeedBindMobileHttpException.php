<?php
// ////////////////////////////////////////////////////////////////////////////
//
// Copyright (c) 2015-2016 Hangzhou Freewind Technology Co., Ltd.
// All rights reserved.
// http://www.seastart.cn
//
// ///////////////////////////////////////////////////////////////////////////
namespace common\exception;

use yii\web\HttpException;
/**
 * 需要绑定手机
 * @author Ather.Shu Jul 26, 2016 12:02:29 PM
 */
class NeedBindMobileHttpException extends HttpException {
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct(105, $message, $code, $previous);
    }
}