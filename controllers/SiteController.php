<?php

namespace app\controllers;

use app\models\Profile;
use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Country;


class SiteController extends Controller
{

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
     * Lists all User models.
     */
    public function actionIndex()
    {
        $create_model = new User();
        $profile_model = new Profile();
        $status = 0;

        if ($create_model->load(Yii::$app->request->post()) && $create_model->save()) {
            $create_model = new User();
            $status = 1;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);



        return $this->render('index', compact('dataProvider','create_model','status','profile_model'));
    }

    /**
     * Displays a single User model.
     */
    public function actionView($id)
    {
        $this->render('index', [
         //   'view_model' => '',//$this->findModel($id),
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $create_model = new User();
        $this->findModel($id)->delete();
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);
        return $this->render('index', compact('dataProvider','create_model'));
    }

    protected function deleteModel($id)
    {
        return User::findOne($id);

    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
