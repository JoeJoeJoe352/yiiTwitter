<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tweet */

$this->title = "Tweet";
$this->params['breadcrumbs'][] = ['label' => 'Tweet-ek', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tweet-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?PHP
        if ($isOwner) {
            echo Html::a('Szerkesztés', ['update', 'id' => $model->tweetid], ['class' => 'btn btn-primary']);
            echo Html::a('Törlés', ['delete', 'id' => $model->tweetid], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'text',
            'date',
            'visits',
        ],
    ])
    ?>

</div>
