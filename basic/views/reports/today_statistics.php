<?php
//use kartik\date\DatePicker;
use app\models\Reports;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

$this->title = "Today's Statistics";
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php //var_dump($stats); ?>
<div class="content-right">
<h1><?= Html::encode($this->title) ?></h1>

<table class="table table-bordered">
		<tr>
			<th colspan="2">Today's Summary</th>
		</tr>
		<tr>
			<td>Total No of Messages sent:</td><td><?php echo $stats['messages']; ?></td>
		</tr>
		<tr>
			<td>Total Credit Used</td><td><?php echo Reports::NAIRA_SIGN . ' ' .number_format($stats['used'],2,'.',','); ?></td>
		</tr>
		<tr>
			<td>Initial Credit Balance</td><td><?php echo Reports::NAIRA_SIGN . ' ' .number_format($stats['balanceb4'],2,'.',','); ?></td>
		</tr>
		<tr>
			<td>New Credit Balance</td><td><?php echo Reports::NAIRA_SIGN . ' ' .number_format($stats['new_balance'],2,'.',','); ?></td>
		</tr>
	</table>

</div>
