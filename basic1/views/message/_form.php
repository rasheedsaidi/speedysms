<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sender')->textInput(['maxlength' => true, 'label'=>'Sender ID']) ?>

    <?= $form->field($model, 'type')->dropDownList(['text'=>'Text', 'unicode'=>'Unicode']) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6, 'id' => 'message_body']) ?>

    <?= $form->field($model, 'flag')->hiddenInput(['value' => 1])->label(false) ?>
    <?= $form->field($model, 'length')->hiddenInput(['id' => 'message_length']) ?>
    <div class="alert alert-info" id="message_status"></div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Send SMS' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::submitButton('Reset', ['class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
