<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Message */

$this->title = 'Registration Confirmation';

$this->params['breadcrumbs'][] = $this->title;
?>
<section class="main">
                    <div class="row">
                        <div class="col-sm-5 login-form">
                            <div class="panel panel-default">
                                <div class="panel-intro text-center">
                                    <h1 class="logo"><i class="fa fa-user"></i> <?= Html::encode($this->title) ?></h1>
                                </div>
                                <div class="panel-body">

   
	<?php 
	if (Yii::$app->session->getFlash('Register-success') !== null) {
		echo Alert::widget([
		   'options' => ['class' => 'alert-success'],
		   'body' => Yii::$app->session->getFlash('Register-success'),
		]); 
	}
	?>
 </div>
 </div> 
 </div>  

</div>
</section>
