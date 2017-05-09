<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SentMessage */

$this->title = 'Update Sent Message: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Sent Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sent-message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
