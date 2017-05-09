<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MessageLog */

$this->title = 'Update Message Log: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Message Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="message-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
