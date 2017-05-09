<?php

use amnah\yii2\user\models\Profile;
use yii\helpers\ArrayHelper;
use app\models\Price;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Credit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="credit-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php //var_dump($model->errors); ?>
    <?= $form->field($model, 'user_id')->dropDownList(Profile::find()->select(['full_name', 'user_id',])->indexBy('user_id')->column(),
    ['prompt'=>'Select User']) ?>

    <?= $form->field($model, 'amount')->textInput() ?>  

    <?php //= $form->field($model, 'unit_price')->dropDownList(ArrayHelper::map(Price::find()->all(), 'price', 'price'), ['prompt'=>'Select Price']) ?>
    <?= $form->field($model, 'unit_price')->dropDownList(Price::find()->select(['price',])->indexBy('price')->column(), ['prompt'=>'Select Price']) ?>

    <?= $form->field($model, 'created_at')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
