<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tweetek';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tweet-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tweet írása', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'summary'=>'',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['header' => 'Név', 'attribute' => 'user.name', 'label' => 'bla',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->user->getName(), ['user/'.$data->user->getName()]);
                },],
            ['header' => 'Tweet', 'attribute' => 'text'],
            ['header' => 'dátum', 'attribute' => 'date'],
            ['header' => 'Megtekinések száma', 'attribute' => 'visits'],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]);
    ?>
</div>
