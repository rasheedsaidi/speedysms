<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CreditLog */

$this->title = 'Create Credit Log';
$this->params['breadcrumbs'][] = ['label' => 'Credit Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="credit-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
