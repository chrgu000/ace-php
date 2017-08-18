<?php

namespace backend\controllers;

use Yii;
use common\models\OnlineActivity;
use backend\models\OnlineActivitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
/**
 * OnlineActivityController implements the CRUD actions for OnlineActivity model.
 */
class OnlineActivityController extends Controller
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
     * Lists all OnlineActivity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OnlineActivitySearch();
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
     * Creates a new OnlineActivity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OnlineActivity();

        if (\Yii::$app->request->isPost && $this->innserSave($model)) {

            return 1;
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OnlineActivity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (\Yii::$app->request->isPost && $this->innserSave($model) ) {
            return 1;
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing OnlineActivity model.
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
     * Finds the OnlineActivity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OnlineActivity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OnlineActivity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function innserSave($model){
        /** @var OnlineActivity $model */
        $post = \Yii::$app->request->post();
        $model->activity_id = $post['activity_id'];
        $model->location = $post['location'];
        $model->en_location = $post['en_location'];
        if(array_key_exists('end_time',$post)){
            $model->end_time = strtotime($post['end_time']);
        }
        $model->price = $post['price'];
        if(array_key_exists('min_walk',$post)){
            $model->benefit_walk_min = $post['min_walk'];
        }
        if(array_key_exists('max_walk',$post)){
            $model->benefit_walk_max = $post['max_walk'];
        }
        if(array_key_exists('min_run',$post)){
            $model->benefit_run_min = $post['min_run'];
        }
        if(array_key_exists('max_run',$post)){
            $model->benefit_run_max = $post['max_run'];
        }
        if(array_key_exists('min_bike',$post)){
            $model->benefit_bike_min = $post['min_bike'];
        }
        if(array_key_exists('max_bike',$post)){
            $model->benefit_bike_max = $post['max_bike'];
        }

        if(array_key_exists('desc',$post)){
            $model->desc = $post['desc'];
        }
        if(array_key_exists('en_desc',$post)){
            $model->en_desc = $post['en_desc'];
        }
        if($model->save()){
            return 1;
        }else {
            dd($model->getFirstErrors());
        }
    }
}
