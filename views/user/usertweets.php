<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tweet-ek';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tweet-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php
    if ($isOwner) {
        echo '<p>';
        echo Html::a('Tweet írása', ['create'], ['class' => 'btn btn-success']);
        echo '</p>';
        echo Html::a('Adatlap frissítése', ['update', 'id' => $model->userid], ['class' => 'btn btn-primary']);
        echo Html::a('Regisztráció törlése', ['delete', 'id' => $model->userid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Biztos vagy benne, hogy törölni akarod ezt a profilt?',
                'method' => 'post',
            ],
        ]);
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'email',
            ],
        ]);

        echo GridView::widget([
            'dataProvider' => $tweets,
            'summary'=>'',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'text',
                'date',
                'visits',
                ['class' => 'yii\grid\ActionColumn', 'template' => '{view}', 'controller' => 'tweet']
            ],
        ]);
    } else {
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'email',
            ],
        ]);

        echo GridView::widget([
            'dataProvider' => $tweets,
            'summary'=>'',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'text',
                'date',
                'visits',
                ['class' => 'yii\grid\ActionColumn', 'template' => '{view}', 'controller' => 'tweet']
            ],
        ]);
    }
    ?>
</div>
