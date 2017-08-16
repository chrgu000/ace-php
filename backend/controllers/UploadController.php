<?php
// ////////////////////////////////////////////////////////////////////////////
//
// Copyright (c) 2015-2016 Hangzhou Freewind Technology Co., Ltd.
// All rights reserved.
// http://www.seastart.cn
//
// ///////////////////////////////////////////////////////////////////////////
namespace backend\controllers;

use common\models\FileUploadForm;
use common\util\Constants;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * 图片上传
 *
 * @author Ather.Shu May 12, 2015 2:29:34 PM
 */
class UploadController extends Controller {


    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [
                            '@'
                        ]
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => [
                        'post'
                    ],
                    'ck-upload' => [
                        'post'
                    ]
                ]
            ]
        ];
    }


    public function actionFileDelete(){
        return 1;
    }

    /**
     * 上传文件
     */
    public function actionIndex() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new FileUploadForm();
        if( \Yii::$app->request->isPost ) {
            $model->file = UploadedFile::getInstanceByName( 'file_data' );
            $model->type = \Yii::$app->request->post( 'type' );
            $savedPath = $model->save();
            if( $savedPath ) {
                return array(
                    'url' => $savedPath
                );
            } else {
                return array (
                    'error' => implode( ";", array_values( $model->getFirstErrors() ) )
                );
            }
        }
    }

    /**
     * ckeditor upload
     */
    public function actionCkUpload() {
        $model = new FileUploadForm();
        if( \Yii::$app->request->isPost ) {
            $model->file = UploadedFile::getInstanceByName( 'upload' );
            $model->type = Constants::UPLOAD_TYPE_LIVE;
            $savedPath = $model->save();
            $funcNum = \Yii::$app->request->get( 'CKEditorFuncNum' );
            if( $savedPath ) {
                echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, window.parent.frontUrl + '$savedPath');</script>";
            } else {
                $message = '';
                $firstErrors = $model->getFirstErrors();
                foreach ( $firstErrors as $field => $error ) {
                    $message = $error;
                }
                echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, false, '$message');</script>";
            }
        }
    }

    /**
     * simditor
     */
    public function actionSimUpload(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new FileUploadForm();
        if( \Yii::$app->request->isPost ) {
            $model->file = UploadedFile::getInstanceByName( 'fileData' );
            $model->type = Constants::UPLOAD_TYPE_LIVE;
            $savedPath = $model->save();
            if( $savedPath ) {
                return [
                    'success' => true,
                    'file_path' => $savedPath,
                ];
            }else{
                return array (
                    'error' => implode( ";", array_values( $model->getFirstErrors() ) )
                );
            }
        }
    }
}