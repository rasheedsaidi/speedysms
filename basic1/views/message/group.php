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
	
    <?= $form->field($message, 'number')->label('Select Group from list')->dropdownList($groups) ?>
    <?= Html::a('Add Group', Yii::$app->homeUrl.'?r=group/create', ['class'=>'btn btn-primary'])?>

    <?= $form->field($message, 'sender')->textInput(['maxlength' => true, 'label'=>'Sender ID']) ?>

    <?= $form->field($message, 'type')->listBox([1=>'Text', 2=>'Unicode'], ['size' =>  '1']) ?>

    <?= $form->field($message, 'body')->textarea(['rows' => 6, 'id' => 'message_body']) ?>

	<?= $form->field($message, 'flag')->hiddenInput(['value' => 3]) ?>
	
    <?= $form->field($message, 'length')->hiddenInput(['id' => 'message_length']) ?>
    <div class="alert alert-info" id="message_status"></div>
	
	<label class="control-label" for="schedule-started_at">Scheduled?</label>
    <?=Html::checkbox('scheduled')?>
    <?= $form->field($schedule, 'started_at')->widget(DateTimePicker::classname(), [
    'name' => 'datetime_10',
    'options' => ['placeholder' => 'Select operating time ...'],
    'convertFormat' => true,
    'pluginOptions' => [
        'format' => 'y-m-d H:i:s',
        'startDate' => '01-Mar-2014 12:00 AM',
        'todayHighlight' => true
    ]
])->label('Scheduled Time'); ?>

    <div class="form-group">
        <?= Html::submitButton($message->isNewRecord ? 'Send GROUP SMS' : 'Update', ['class' => $message->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
