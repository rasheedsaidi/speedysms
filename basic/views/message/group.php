<?php

use app\models\SentMessage;
use yii\bootstrap\Alert;
use app\models\Utility;
use app\models\Credit;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
//var_dump($groups);

/* @var $this yii\web\View */
/* @var $model app\models\Message */

$this->title = 'Create Message';
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$credits = Credit::find()->where(['user_id' => Yii::$app->user->id])->all();

$saved_msg = SentMessage::find()->select('id, body')->where(['user_id' => Yii::$app->user->id])->all(); //var_dump($saved_messages);
$saved_messages = array();
if($saved_msg  && count($saved_msg) > 0) {
	foreach($saved_msg as $msg) {
		$saved_messages[$msg->id] = trim($msg->body);
	}
} else {
	$saved_messages = null;
}

$profiles = array();	//('prompt' => "Please select sending profile");
foreach ($credits as $credit) {
	$price = Utility::getUserPrice($credit['price_id'], $credit['type']);
	if($price != null) {
		$profiles[$credit['id']] = $credit['type'] . '( N' . $price['price'] . ' per SMS. Balance: N' . $credit['amount'] . ' )';
	}
}
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
    <div class="message-form">

    <?php $form = ActiveForm::begin(); ?>
	
    <?= $form->field($message, 'recipient')->label('Select Group from list')->dropdownList($groups) ?>
    <?= Html::a('Add Group', Yii::$app->homeUrl.'?r=group/create', ['class'=>'btn btn-primary'])?>

    <?= $form->field($message, 'sender_id')->textInput(['maxlength' => true, 'label'=>'Sender ID']) ?>

    <?= $form->field($message, 'type')->dropDownList(['0'=>'Text Message', '1'=>'Flash Message', '2'=>'Unicode Message', '6'=>'Unicode Flash'], ['prompt' => 'Choose SMS Type']) ?>

	<?= $form->field($message, 'personalised')->checkbox(['id' => 'personalised_box']) ?>
    <div class="form-group" id="personalised_info" style="display: none;">
    	<div class="row">
    		<div class="alert alert-info">
    			<p>To personalize this SMS, create a csv file in Ms Excel with two columns (name, number)</p>
    			<p>In the SMS body field below: use ::name:: to insert the name for each SMS.</p>
    			<p>For more information, please <?= Html::a('click here', ['/site/help']) ?>.</p>
    		</div> 
    	</div>
    </div>
    
    <div id="form-group">	
<div class="row">
	<div class="col-md-6">	
	<?= Html::radio("message_body", false, ['id' => 'new_message']) ?>
	<label>New Message</label>	
	</div>
	
	<div class="col-md-6">	
	<?= Html::radio("message_body", false, ['id' => 'existing_message']) ?>
	<label>Saved Message</label>	
	</div>
</div> 
</div>

<div class="form-group" id="saved_messages_div">
<?php
if($saved_messages && !empty($saved_messages)) {
?>

	<label class="control-label" for="sending_profile">Service type</label>
	<?=Html::dropDownList('saved_messages', [], $saved_messages, ['id' => 'saved_messages_select', 'class' => 'form-control', 'prompt' => 'Please select message']) ?>
	  
<?php
} else {
	echo '<div class="alert alert-success">No saved messages found</div>';
}
?>
</div>  
	
    <?= $form->field($message, 'body')->textarea(['rows' => 6, 'id' => 'message_body']) ?>

	<div id="form-group">	
	<div class="row">
	<div class="col-md-12">	
	<?= Html::checkbox("save_message", false, ['id' => 'save_message']) ?>
	<label>Save this message</label>	
	</div>
	</div>
	</div>
	<?php //= $form->field($message, 'flag')->hiddenInput(['value' => 3]) ?>
	
    <?= $form->field($message, 'length')->hiddenInput(['id' => 'message_length']) ?>
    <div class="alert alert-info" id="message_status"></div>
	
	<div style="">
	<?= $form->field($message, 'scheduled')->checkbox(['id' => 'scheduled_box']) ?>

<div id="schedule_form">	
<div class="row" style="display: none;">
	<div class="col-md-6">
	<label>Set Date</label>
	<input name="scheduled_date[]" class="form-control" type="text" placeholder="Select time" value="" id="scheduled_datepicker"/>
		
	</div>
	
	<div class="col-md-6">
	<label>Set Time</label>
	<input name="scheduled_date[]" class="form-control" type="text" placeholder="Select time" value="" id="scheduled_timepicker"/>
	</div>
</div>

</div>
<?= Html::button('Add schedule', ['class' => 'btn btn-info', 'id' => 'add_scheduled_item']) ?>
</div>
	<div class="form-group">
	<label class="control-label" for="sending_profile">Service type</label>
	<?=Html::dropDownList('sending_profile', [], $profiles, ['class' => 'form-control']) ?>
	</div>
	
	<?php if(empty($profiles)) {
		echo Html::submitButton('No credit found', ['class' => 'btn btn-info', 'disabled' => 'disabled']);	
	} else {
	 ?>
    <div class="form-group">
        <?= Html::submitButton($message->isNewRecord ? 'Send GROUP SMS' : 'Update', ['class' => $message->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-info']) ?>
    </div>
    <?php } ?>

    

    <?php ActiveForm::end(); ?>

</div>
