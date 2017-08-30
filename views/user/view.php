<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Felhasználók', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?PHP
        if ($isOwner) {
            echo Html::a('Update', ['update', 'id' => $model->userid], ['class' => 'btn btn-primary']);
            echo Html::a('Delete', ['delete', 'id' => $model->userid], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'userid',
                    'name',
                    'email:email',
                    'pass',
                ],
            ]);
        } else {
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'email:email',
                ],
            ]);
        }
        ?>

    </p>



</div>
