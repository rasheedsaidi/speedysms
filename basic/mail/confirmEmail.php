<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var string $subject
 * @var \amnah\yii2\user\models\User $user
 * @var \amnah\yii2\user\models\Profile $profile
 * @var \amnah\yii2\user\models\UserToken $userToken
 */
?>

<h3><?= $subject ?></h3>

<h4>Dear <?= $name ?>,</h4>

<p>You have successfully signed on www.SpeedySMS.com.ng</p>

<h4>Here is a quick guide on how to get started</h4>

<p>
	<ul>
		<li>To buy SMS credit, Please <?= Html::a('click here', ['site/payment'])?></li>
		<li>To send SMS, Please <?= Html::a('click here', ['message/create'])?></li>
		<li>For more information on our services, Please <?= Html::a('click here', ['site/contact'])?> to contact us or Call: 08153505442, 08060553348.</li>
	</ul>
</p>