<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
//var_dump($groups);

/* @var $this yii\web\View */
/* @var $model app\models\Message */

$this->title = 'Create Message';
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="message-form">

    <?php $form = ActiveForm::begin(); ?>
	
    <?= $form->field($message_log, 'mobile_no')->label('Select Group from list')->dropdownList($groups) ?>
    <?= Html::a('Add Group', Yii::$app->homeUrl.'?r=group/create', ['class'=>'btn btn-primary'])?>

    <?= $form->field($message_log, 'sender_id')->textInput(['maxlength' => true, 'label'=>'Sender ID']) ?>

    <?= $form->field($message, 'type')->dropDownList(['0'=>'Text', '2'=>'Unicode'], ['prompt' => 'Choose SMS Type']) ?>

    <?= $form->field($message, 'body')->textarea(['rows' => 6, 'id' => 'message_body']) ?>

	<?php //= $form->field($message, 'flag')->hiddenInput(['value' => 3]) ?>
	
    <?= $form->field($message, 'length')->hiddenInput(['id' => 'message_length']) ?>
    <div class="alert alert-info" id="message_status"></div>
	
	

    <div class="form-group">
        <?= Html::submitButton($message->isNewRecord ? 'Send GROUP SMS' : 'Update', ['class' => $message->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
