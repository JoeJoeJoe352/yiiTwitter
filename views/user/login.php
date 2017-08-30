<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Bejelentkezés';
$this->params['breadcrumbs'][] = ['label' => 'Felhasználók', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-login">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_loginform', [
        'model' => $model,
        'error' => $error,
    ])
    ?>

</div>