<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var string $subject
 * @var \amnah\yii2\user\models\User $user
 * @var \amnah\yii2\user\models\Profile $profile
 * @var \amnah\yii2\user\models\UserToken $userToken
 */

$services_url = Url::toRoute(['/site/services'], true);
$pricing_url = Url::toRoute(['/site/pricing'], true);
$payment_url = Url::toRoute(['/site/payment'], true);
?>

<h3><?= $data['subject'] ?></h3>

<h4>Dear <?= $data['full_name'] ?>,</h4>

<p>You have successfully signed up on www.SpeedySMS.com.ng. SpeedySMS provides fast and reliable SMS services.</p>

<h4>Here is a quick guide on how to get started</h4>

<p>
<ul>
	<li>To learn more about our services, <a href="<?php echo $services_url; ?>">Click here</a></li>
	<li>To view our price list, <a href="<?php echo $pricing_url; ?>">Click here</a></li>
	<li>To buy credit online, <a href="<?php echo $payment_url; ?>">Click here</a></li>
</ul>
</p>

<h4>Thanks for choosing SpeedySMS<br>
SpeedySMS Team.</h4>
