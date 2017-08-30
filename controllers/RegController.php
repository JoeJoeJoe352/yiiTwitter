<?php

namespace app\controllers;
use app\models\User;
use Yii;
class RegController extends \yii\web\Controller{

    public function actionIndex(){
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
}

}
    




