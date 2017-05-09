<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MessageLog */

$this->title = 'Create Message Log';
$this->params['breadcrumbs'][] = ['label' => 'Message Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
