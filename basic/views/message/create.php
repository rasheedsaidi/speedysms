<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Message */

$this->title = 'Create Message';
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-create">

    <h1><?= Html::encode($this->title) ?></h1>
	<?php 
	if (Yii::$app->session->getFlash('smsSent') !== null) {
		echo Alert::widget([
		   'options' => ['class' => 'alert-success'],
		   'body' => Yii::$app->session->getFlash('smsSent'),
		]); 
	}
	?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
