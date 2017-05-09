<?php
//use kartik\date\DatePicker;
use app\models\Reports;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;

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
    'attribute' => 'from_date',
    'template' => '{addon}{input}',
	'options' => ['placeholder' => 'Select from date ...'],
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-m-dd',			
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
            'format' => 'yyyy-m-dd',
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
            'mobile_no',
            'credit_used',
            'sent_at',
        ],
    ]);
}
        ?>
    </div>
</div>
</div>