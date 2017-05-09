<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var string $subject
 * @var \amnah\yii2\user\models\User $user
 * @var \amnah\yii2\user\models\Profile $profile
 * @var \amnah\yii2\user\models\UserToken $userToken
 */

$view_url = urldecode(Url::toRoute(['/site/help']));
?>

<div>
<h3><?= $data['subject'] ?></h3>

<h4>Dear <?= $data['name'] ?>,</h4>

<p>Your message which you scheduled for <?php echo $data['scheduled_date']; ?> and <?php echo $data['scheduled_time']; ?> has been sent.</p>

<p>Please <a href="<?php echo $view_url; ?>">click here</a> to view the report.</p>

<p>Thank you for choosing SpeedySMS</p>

<h4>From: SpeedySMS Team</h4>
</div>