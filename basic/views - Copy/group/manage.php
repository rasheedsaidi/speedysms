<?php

use yii\grid\GridView;
use app\models\Group;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\datetime\DateTimePicker;
use app\models\Contact;

/* @var $this yii\web\View */
/* @var $model app\models\Message */
//var_dump($contact);
$this->title = 'Manage Group Contacts';
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php 
    $grp = Group::findOne($group->id); // $data['name'] for array data, e.g. using SqlDataProvider.
	$grp_name = ($grp)? $grp->name: 'group';
    ?>
    <h3>Contacts in <?php echo $grp_name; ?></h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'number',
            'created_at',
            /*
            [
				'attribute' => 'group_name',
	            'value' => function ($data) {
	                $grp = Contact::findOne($data['group_id']); // $data['name'] for array data, e.g. using SqlDataProvider.
	                $a = Html::a('View', ['contact/view', 'id' => $data['id']], ['class' => 'btn btn-success']);
	                $a .= Html::a('Edit', ['contact/update', 'id' => $data['id']], ['class' => 'btn btn-success']);
	                $a .= Html::a('Delete', ['contact/delete', 'id' => $data['id']], ['class' => 'btn btn-success']);
	                return $a;
	            },
	        ],*/
	        ['class' => 'yii\grid\ActionColumn', 'controller' => 'contact'],

        ],
    ]); ?>

    <div class="message-form">

    <?php $form = ActiveForm::begin(['id' => 'manageContact', 'options' => ['enctype' => 'multipart/form-data']]); ?>
	<?php /* echo '<p style="padding: 3px;background-color:#efefef;width:calc(100% - 6px);">';
	$contacts = $contact;
	if (is_array($contact)  && count($contact) >0) {
	foreach ($contacts as $c) {
		echo '<em style="padding: .5em;margin:3px;margin-botton:3em;float:left;background-color:#fff;">'.$c['name'] . ': ' . $c['number'] . '</em> ';
	}
	} else {
		echo 'No existing contacts found';
	}
	'</p>'; */ ?>
	
    <?php  //echo $form->field($numbers, 'numbersFile')->fileInput() ?>
    <p><?= Html::hiddenInput('file_url', '', ['id' => 'file_url'])?></p>
    <?php //echo Html::buttonInput('Fetch Numbers', ['class' => 'btn btn-success', 'id' => 'fetch', 'data-on-done' => 'fetchDone',]) ?>
    
<span class="btn btn-success fileinput-button" style="margin-left: 1em;">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select files...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
    <input id="up" type="button" value="LOADING ..." style="margin-left: 1em;display:none;" disabled class="btn btn-info">
    <?php
     echo Html::a('Fetch Numbers', ['group/link'], [
        'id' => 'fetch',
        'data-on-done' => 'fetchDone',
    	'class' => 'btn btn-success',
    ]
); ?>
    <br>
    <br>
    <!-- The global progress bar -->
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
	

    <?= $form->field($group, 'manage_contact')->textarea(['rows' => 6, 'id' => 'contact_body']) ?>   
    

    <div class="form-group">
        <?= Html::submitButton('Update Group', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
