<?php

namespace app\controllers;

use Yii;
use app\models\Tweet;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * TweetController implements the CRUD actions for Tweet model.
 */
class TweetController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'acces' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ]
        ];
    }

    /**
     * Lists all Tweet models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Tweet::find()->orderBy(['date' => SORT_DESC]),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tweet model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $model->increaseVisits();
        $model->save();
        $isOwner = $this->isOwner($model->getUserId());
        return $this->render('view', [
                    'model' => $model,
                    'isOwner' => $isOwner,
        ]);
    }

    /**
     * Creates a new Tweet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Tweet();
        $identity = Yii::$app->user->identity;
        $model->userid = $identity->getId();
        $model->visits = 0;
        $model->date = date('Y-m-d H:i:s', time());
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tweetid]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tweet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $isOwner = $this->isOwner($model->getUserId());
        if (!$isOwner) {
            return $this->render('../site/error', ['name' => "Hozzáférés megtagadva",
                        'message' => 'Nincs jogosultságod ennek a Tweetnek a módosításához']);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tweetid]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tweet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $isOwner = $this->isOwner($model->getUserId());
        if (!$isOwner) {
            return $this->render('../site/error', ['name' => "Hozzáférés megtagadva",
                        'message' => 'Nincs jogosultságod ennek a Tweetnek a törléséhez']);
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tweet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tweet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Tweet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('A keresett tweet nem létezik.');
        }
    }

    /**
     * @param type $userId
     * A User tábla userid attribútuma
     * @return int
     * 1, ha a felhasználó a tulajdnosa az adott accountnak
     * 0, ha nem. (URL átírással próbált hozzáférni más tweetjéhez)
     */
    public function isOwner($userId) {
        $identityFromSession = Yii::$app->user->identity;
        if ($identityFromSession != null && $userId == $identityFromSession->getId()) {
            return 1;
        } else {
            return 0;
        }
    }

}
