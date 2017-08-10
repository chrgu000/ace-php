<?php
// ////////////////////////////////////////////////////////////////////////////
//
// Copyright (c) 2015-2016 Hangzhou Freewind Technology Co., Ltd.
// All rights reserved.
// http://www.seastart.cn
//
// ///////////////////////////////////////////////////////////////////////////
namespace common\models;

use common\util\AliBcManager;
use common\util\ConfigUtil;
use common\util\Constants;
use yii\base\Model;
use yii\validators\ImageValidator;
use yii\web\UploadedFile;

/**
 * 文件上传
 *
 * @author Ather.Shu Dec 15, 2014 3:48:20 PM
 */
class FileUploadForm extends Model {

    public $type;

    /**
     * 上传的文件
     *
     * @var UploadedFile
     */
    public $file;

    private static $_useWantu = true;

    public function rules() {
        return [ 
            [ 
                [ 
                    'type',
                    'file' 
                ],
                'required' 
            ],
            [ 
                'type',
                'integer' 
            ],
            [ 
                'file',
                'validateFile' 
            ] 
        ];
    }

    public function validateFile() {
        if( array_key_exists( $this->type, Constants::$UPLOAD_TYPES ) ) {
            $validator = new ImageValidator();
            $validator->extensions = isset( Constants::$UPLOAD_TYPES [$this->type] ['extensions'] ) ? Constants::$UPLOAD_TYPES [$this->type] ['extensions'] : [ 
                'jpg',
                'jpeg',
                'png',
                'gif' 
            ];
            $validator->mimeTypes = [ 
                'image/jpeg',
                'image/png',
                'image/gif' 
            ];
            // 700k
            $validator->maxSize = Constants::$UPLOAD_TYPES [$this->type] ['max'] * 1024 * 1024;
            $validator->validateAttribute( $this, 'file' );
        } else {
            $this->addError( 'type', '上传用途不明' );
        }
    }

    public function save() {
        if( $this->validate() ) {
            $path = $this->innerSave();
            return $path;
        }
        return false;
    }

    /**
     * 删除已经上传的图片
     *
     * @param string $path 如/res/upload/2/xy/10009.png
     */
    public static function deleteUploadedFile($path) {
        if( self::$_useWantu ) {
            // "/1/xx.jpg"
            AliBcManager::deleteWantuFile( $path );
        } else {
            @unlink( \Yii::getAlias( '@frontend' ) . "/web{$path}" );
        }
    }

    private function innerSave() {
        $now = time() . mt_rand( 1, 10000 );
        // 如果使用阿里云顽兔存储，传到云端
        if( self::$_useWantu ) {
            $dir = $this->type;
            $ext = empty( $this->file->extension ) ? 'png' : $this->file->extension;
            return AliBcManager::uploadToWantu( $this->file->tempName, $dir, "{$now}.{$ext}" );
        }
        $rand = substr( md5( $now ), 2, 2 );
        $path = "/res/upload/{$this->type}/{$rand}";
        $dir = \Yii::getAlias( '@frontend' ) . "/web{$path}";
        if( !file_exists( $dir ) ) {
            @mkdir( $dir, 0777, true );
        }
        $this->file->saveAs( "{$dir}/{$now}.{$this->file->extension}" );
        return $path . "/{$now}.{$this->file->extension}";
    }
}