<?php
//use kartik\date\DatePicker;
use app\models\Utility;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

$this->title = "SMS Reports";
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php //var_dump($stats); ?>
<div class="content-right">
<h1><?= Html::encode($this->title) ?></h1>
<h3>Enter search term</h3>
<?php $form = ActiveForm::begin(
	['method' => 'get']
); ?>
<?php 
	if (isset($model->errors['from_date']) && $model->errors['from_date'][0] !== null) {
		echo Alert::widget([
		   'options' => ['class' => 'alert-info'],
		   'body' => $model->errors['from_date'][0],
		]); 
	}
	?>
<div class="row">
<div class="col-xs-6">
<?php 
echo '<label>From Date</label>';
echo DatePicker::widget([
	'model' => $model,
    'attribute' => 'from_date',
    'template' => '{addon}{input}',
	'options' => ['placeholder' => 'Select from date ...'],
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',			
        ]
]);
?>
</div>
<div class="col-xs-6">
<?php 
echo '<label>To Date</label>';

/*echo DatePicker::widget([
    'name' => 'to_date', 
    'value' => date('Y-m-d'),
    'options' => ['placeholder' => 'Select to date ...'],
    'pluginOptions' => [
        'format' => 'yyyy-m-dd',
        'todayHighlight' => true
    ]
]);*/
echo DatePicker::widget([
	'model' => $model,
    'attribute' => 'to_date',
    'template' => '{addon}{input}',
	'options' => ['placeholder' => 'Select to date ...'],
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
			'todayHighlight' => true
        ]
]);
?>

</div>
</div>
<div class="row">
<div class="col-xs-12" style="margin-top: 1em;">
        <?= Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<div class="row">
<div class="col-xs-12" style="margin-top: 1em;">
        <?php 
if(isset($stats) && !empty($stats)) {
	echo GridView::widget([
        'dataProvider' => $stats,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
				'attribute' => 'message',
	            'value' => function ($data) {
            		$in = $data['body'];
            		$out = strlen($in) > 50 ? substr($in,0,50)."..." : $in;
	                return $out; // $data['name'] for array data, e.g. using SqlDataProvider.
	            },
	        ],
            'mobile_no',
            'length',
			[
				'attribute' => 'parts',
	            'value' => function ($data) {
	                return Utility::getMessageParts($data['length']); // $data['name'] for array data, e.g. using SqlDataProvider.
	            },
	        ],
	        'credit_used',
            'status',
            'sent_at',
        ],
    ]);
}

        ?>
    </div>
</div>
</div>