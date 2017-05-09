<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<?php //var_dump($model->errors);
if (!empty($model->errors)) {
	echo '<div class="alert alert-error"><ul>';
	foreach($model->errors as $errors) {
		foreach($errors as $error) {
			echo '<li>' . $error . '</li>';
		}	
	}
	echo '</ul></div>';
}
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(['options'=>['label'=>'Add Group']]); ?>
	
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->hiddenInput(['value'=>date('Y-m-d H:i:s')])->label(false) ?>
    
    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>(Yii::$app->user->isGuest)? 0: Yii::$app->user->id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
