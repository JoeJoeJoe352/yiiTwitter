<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Felhasználók';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?PHP
        if (Yii::$app->user->isGuest) {
            echo Html::a('Regisztráció', ['create'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'summary'=>'',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'email',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        $url = "user/" . $model->getName();
                        return Html::a(
                                        '<span class="glyphicon glyphicon-user"></span>', $url);
                    },
                    'link' => function ($url, $model, $key) {
                        return Html::a('Action', $url);
                    },
                ],
            ],
        ],
    ]);
    ?>
</div>
