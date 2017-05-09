<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SentMessage */

$this->title = 'Create Sent Message';
$this->params['breadcrumbs'][] = ['label' => 'Sent Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sent-message-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
