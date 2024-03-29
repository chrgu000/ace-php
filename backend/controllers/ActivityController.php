<?php

namespace backend\controllers;

use common\util\Constants;
use Yii;
use common\models\Activity;
use backend\models\ActivitySearch;
use yii\base\UserException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
/**
 * ActivityController implements the CRUD actions for Activity model.
 */
class ActivityController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Activity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActivitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $pagination = new Pagination(['totalCount' => $dataProvider->query->count()]);
        $dataProvider->setPagination($pagination);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pagination' => $pagination
        ]);
    }

    /**
     * Creates a new Activity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Activity();

        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $model->title = $post['title'];
            $model->en_title = $post['en_title'];
            $model->start_time = strtotime($post['start_time']);
            if(array_key_exists('filePath',$post)){
                $model->cover = implode(Constants::IMG_DELIMITER,$post['filePath']);
            }else{
                $model->cover = '';
            }
            if($model->save()){
                return 1;
            }else{
                throw new UserException(implode('|',$model->getFirstErrors()));
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Activity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $model->title = $post['title'];
            $model->en_title = $post['en_title'];
            $model->start_time = strtotime($post['start_time']);
            if(array_key_exists('filePath',$post)){
                $model->cover = implode(Constants::IMG_DELIMITER,$post['filePath']);
            }else{
                $model->cover = '';
            }
            if($model->save()){
                return 1;
            }else{
                throw new UserException(implode('|',$model->getFirstErrors()));
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Activity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return 1;
    }

    /**
     * Finds the Activity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Activity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Activity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
