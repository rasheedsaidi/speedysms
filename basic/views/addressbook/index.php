<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
?>
<h1>Address Book</h1>

<h3>Manage Groups</h3>

<p style="margin: 1em 0;">
  	<?= Html::a('My Groups', ['/group/index'], ['class' => 'btn btn-success']) ?>
</p>
<p style="margin: 1em 0;">
  	<?= Html::a('Add New Group', ['/group/create'], ['class' => 'btn btn-success']) ?>
</p>


<h3>Manage Contacts</h3>

<p style="margin: 1em 0;">
  	<?= Html::a('Add Contact', ['/contact/create'], ['class' => 'btn btn-success']) ?>
</p>