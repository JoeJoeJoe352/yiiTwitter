<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tweet */

$this->title = 'Tweet írása';
$this->params['breadcrumbs'][] = ['label' => 'Tweet-ek', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tweet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
