<?php
use app\models\Utility;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Transaction';
$this->params['breadcrumbs'][] = $this->title;

$message_url = urldecode(Url::toRoute(['/message/create']));
$scratchcard_url = urldecode(Url::toRoute(['/site/scratchcard']));
$e_url = urldecode(Url::to('https://voguepay.com/pay/'));

//var_dump($data);exit;

	?>


                <h4 class="h4cap">Payment Message</h4>  
                <?php if (Yii::$app->session->hasFlash('payment_reply'))
                		echo Yii::$app->session->getFlash('payment_reply')
                ?>    
				
					
					