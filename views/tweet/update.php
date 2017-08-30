<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tweet */

$this->title = 'Tweet frissítése: ' . $model->tweetid;
$this->params['breadcrumbs'][] = ['label' => 'Tweet-ek', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tweetid, 'url' => ['view', 'id' => $model->tweetid]];
$this->params['breadcrumbs'][] = 'Tweet frissítése';
?>
<div class="tweet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
