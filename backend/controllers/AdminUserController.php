<?php

namespace backend\controllers;

use Yii;
use backend\models\AdminUser;
use backend\models\AdminUserSearch;
use yii\base\UserException;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * AdminUserController implements the CRUD actions for AdminUser model.
 */
class AdminUserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AdminUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminUserSearch();
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
     * Displays a single AdminUser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AdminUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdminUser();
        if ( \Yii::$app->request->isPost ) {
            $post = \Yii::$app->request->post();
            $data['password'] = $post['password'];
            $data['username'] = $post['username'];
            $data['nickname'] = $post['nickname'];
            if($user = AdminUser::createUser($data)){
                if($user->id){
                    return 1;
                }else{
                    throw new UserException('创建失败');
                }
            }else{
                throw new UserException(implode('|',$user->getFirstErrors()));
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AdminUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ( \Yii::$app->request->isPost ) {
            $post = \Yii::$app->request->post();
            $data['password'] = $post['password'];
            $data['username'] = $post['username'];
            $data['nickname'] = $post['nickname'];
            $model->load($data);
            $model->setPassword($data['password']);
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
     * Deletes an existing AdminUser model.
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
     * Finds the AdminUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
