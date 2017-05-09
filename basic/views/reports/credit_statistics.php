<?php
//use kartik\date\DatePicker;
use kartik\date\DatePicker;
use app\models\Reports;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
//use dosamigos\datepicker\DatePicker;

$this->title = "Credit Reports";
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content-right">
<?php //var_dump($detail); ?>
<h1><?= Html::encode($this->title) ?></h1>
<?php 
	if (isset($model->errors['from_date']) && $model->errors['from_date'][0] !== null) {
		echo Alert::widget([
		   'options' => ['class' => 'alert-info'],
		   'body' => $model->errors['from_date'][0],
		]); 
	}
	?>
	<table class="table table-bordered">
		<tr>
			<th colspan="2">Your Credit Summary</th>
		</tr>
		<tr>
			<th>Total Credit Purchased</th><td><?php echo Reports::NAIRA_SIGN . ' ' .number_format($detail['total'],2,'.',','); ?></td>
		</tr>
		<tr>
			<th>Total Credit Used</th><td><?php echo Reports::NAIRA_SIGN . ' ' .number_format($detail['used'],2,'.',','); ?></td>
		</tr>
		<tr>
			<th>Total Credit Balance</th><td><?php echo Reports::NAIRA_SIGN . ' ' .number_format($detail['balance'],2,'.',','); ?></td>
		</tr>
	</table>
<h3>Enter search term</h3>
<?php $form = ActiveForm::begin([
	'method' => 'get',
]); ?>
<div class="row">
<div class="col-xs-6">
<?php 
echo '<label>From Date</label>';

echo DatePicker::widget([
	'model' => $model,
    'name' => 'Reports[from_date]',	
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'value' => date('Y-m-d'),
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-m-dd',
        'placeholder' => 'Select from date ...',
    ]
]);
/*
echo DatePicker::widget([
    'model' => $model,
    'attribute' => 'from_date',
    'template' => '{addon}{input}',
	'options' => ['placeholder' => 'Select from date ...'],
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-m-dd',			
        ]
]);
*/
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

/*
echo DatePicker::widget([
    'model' => $model,
    'attribute' => 'to_date',
    'template' => '{addon}{input}',
	'value' => date('d-M-Y', strtotime('+2 days')),
	'options' => ['placeholder' => 'Select to date ...'],
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-m-dd',
			'todayHighlight' => true
        ]
]);
*/

echo DatePicker::widget([
	'model' => $model,
    'name' => 'Reports[to_date]',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'value' => date('Y-m-d'),
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-m-dd'
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
            'credit',
            'type',
            'added_at',
        ],
    ]);
}
        ?>
    </div>
</div>
</div>