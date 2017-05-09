<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
?>
<h1>Address Book</h1>

<h3>Manage Groups</h3>

<p>
  	<?= Html::a('Add Group', ['/group/create'], ['class' => 'btn btn-success']) ?>
</p>

<h3>Manage Contacts</h3>

<p>
  	<?= Html::a('Add Contact', ['/contact/create'], ['class' => 'btn btn-success']) ?>
</p>