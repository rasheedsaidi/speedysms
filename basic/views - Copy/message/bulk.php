<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Message */
//var_dump($schedule);
$this->title = 'Bulk SMS';
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="message-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?php //=Html::errorSummary($message) ?>
    <?= $form->field($numbers, 'numbersFile')->fileInput() ?>
    <?php //echo $form->field($numbers, 'avatar')->widget(FileInput::classname(), ['options' => ['accept' => '*'],]); ?>
	
    <?= $form->field($message_log, 'sender_id')->textInput(['maxlength' => true, 'label'=>'Sender ID']) ?>

    <?= $form->field($message, 'type')->dropDownList(['0'=>'Text', '2'=>'Unicode'], ['prompt' => 'Choose SMS Type']) ?>

    <?= $form->field($message, 'body')->textarea(['rows' => 6, 'id' => 'message_body']) ?>

    <?php //= $form->field($message, 'flag')->hiddenInput(['value' => 2]) ?>
    <?= $form->field($message, 'length')->hiddenInput(['id' => 'message_length']) ?>
    <div class="alert alert-info" id="message_status"></div>
    <!-- label class="control-label" for="schedule-started_at">Scheduled?</label-->
    <?php //=Html::checkbox('scheduled')?>
    <?php /*= $form->field($schedule, 'started_at')->widget(DateTimePicker::classname(), [
    'name' => 'started_at',
    'options' => ['placeholder' => 'Select operating time ...'],
    'convertFormat' => true,
    'pluginOptions' => [
        'format' => 'y-m-d H:i:s',
        'startDate' => '01-Mar-2014 12:00 AM',
        'todayHighlight' => true
    ]
])->label('Scheduled Time');*/ ?>

    <div class="form-group">
        <?= Html::submitButton($message->isNewRecord ? 'Send BULK SMS' : 'Update', ['class' => $message->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
