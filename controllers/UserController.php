<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {

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
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['update', 'delete'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                // everything else is denied
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $isOwner = $this->isOwner($id);

        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'isOwner' => $isOwner,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->userid]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionLogin() {
        $model = new User();
        if ($model->load(Yii::$app->request->post())) {
            $identity = User::findOne(['name' => $model->name]);
            if ($identity->pass == $model->pass) {
                Yii::$app->user->login($identity);
                return $this->redirect(Yii::$app->user->getReturnUrl());
            } else {
                return $this->render('login', [
                            'model' => $model,
                            'error' => "nem egyezik a felhasználónév-jelszó páros",
                ]);
            }
        }

        return $this->render('login', [
                    'model' => $model,
                    'error' => '',
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        //url átírás elleni védelem
        if (!$this->isOwner($id)) {
            return $this->render('../site/error', ['name' => "Hozzáférés megtagadva",
                        'message' => 'Nincs jogosultságod ennek a felhasználónak az adatainak a szerkesztéséhez']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->userid]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * 
     * @param type $name 
     * a felhasználónévhez köthető adatok és tweetek kilistázása
     * @return type
     */
    public function actionUsertweets($name) {

        $query = User::find()->where(['name' => $name]);
        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $user = $provider->getModels();
        //url átírás elleni védelem
        if ($user == null) {
            return $this->render('../site/error', ['name' => "nincs ilyen tweet",
                        'message' => 'Nincs ilyen felhasználónév']);
        }
        //Tweetek lekérése
        $tweets = \app\models\Tweet::find()->where(['userid' => $user[0]->getId()])->orderBy(['date' => SORT_DESC]);
        $provider = new ActiveDataProvider([
            'query' => $tweets,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        //Ha a felhasználó saját oldala, akkor egyéb gombok is jelenjenek meg 
        $isOwner = $this->isOwner($user[0]->getId());

        return $this->render('usertweets', [
                    'tweets' => $provider,
                    'isOwner' => $isOwner,
                    'model' => $this->findModel($user[0]->getId()),
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        //url átírás elleni védelem
        if (!$this->isOwner($id)) {
            return $this->render('../site/error', ['name' => "Hozzáférés megtagadva",
                        'message' => 'Nincs jogosultságod ennek a felhasználónak a törléséhez']);
        }
        //Userhez köthető tweetek lekérése
        $user = $this->findModel($id);
        $tweetQuery = \app\models\Tweet::find()->where(['userid' => $id]);
        $provider = new ActiveDataProvider([
            'query' => $tweetQuery
        ]);
        $tweets = $provider->getModels();
        //felhasználó kijelentkeztetése, majd a tweetjeinek és végül az accountjának a törlése
        Yii::$app->user->logout();
        foreach ($tweets as $tweet) {
            $tweet->delete();
        }
        $user->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param type $userId
     * A User tábla userid attribútuma
     * @return int
     * 1, ha a felhasználó a tulajdnosa az adott accountnak
     * 0, ha nem. (URL átírással próbált hozzáférni más accountjához)
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
