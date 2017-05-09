<?php
//use kartik\date\DatePicker;
use app\models\Utility;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

$this->title = "Reports";
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php //var_dump($stats); ?>
<div class="content-right">
<h1><?= Html::encode($this->title) ?></h1>
<h3>Select a link below</h3>

<div class="row">
<div class="col-xs-12" style="margin-top: 1em;"></div>
<div class="col-xs-4">

<p>
  	<?= Html::a('Credit Details', ['/reports/credit_statistics'], ['class' => 'btn btn-success']) ?>
</p>

</div>

<div class="col-xs-4">

<p>
  	<?= Html::a('Today\'s Statistics', ['/reports/today_statistics'], ['class' => 'btn btn-success']) ?>
</p>

</div>

<div class="col-xs-4">

<p>
  	<?= Html::a('SMS Statistics', ['/reports/sms_statistics'], ['class' => 'btn btn-success']) ?>
</p>
</div>
</div>
</div>