<?php
use app\models\Utility;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Order Now';
$this->params['breadcrumbs'][] = $this->title;

$message_url = urldecode(Url::toRoute(['/message/create']));
$scratchcard_url = urldecode(Url::toRoute(['/site/scratchcard']));
$e_url = urldecode(Url::to('https://voguepay.com/pay/'));

//var_dump($data);exit;
 
//$_SESSION['sms_amt'] = null;

$notify_url = urldecode(Url::to(['/site/transaction'], true));
$success_url = urldecode(Url::to(['/site/success'], true));
$failed_url = urldecode(Url::to(['/site/failed'], true));
$btn_url = urldecode(Url::to('http://voguepay.com/images/buttons/buynow_blue.png'));
$amount = $data['amt'];

	?>


                <h4 class="h4cap">Payment options</h4>        
				<div class="row"> 
				<div class="col-md-6 col-sm-12">
                        <div class="pad10 white-bg-box">
								
								<?php 
								$form = ActiveForm::begin([
		'action' => $e_url,
		//'action' => ['/site/order_summary'],		
    	'id' => "example-advanced-for",
    	//'options'=>['enctype'=>'multipart/form-data', 'onsubmit' => "return false; alert('Will be available soon!';",],
    	'enableClientValidation' => true,

	]); ?>
	<!-- form name="form1" action="<?php //echo $e_url; ?>" method="post" 2479-0026505-->
	
	<input type='hidden' name='v_merchant_id' value='2479-0026505' />
	<input type='hidden' name='merchant_ref' value='<?php echo $merchant_ref; ?>' />
	<input type='hidden' name='memo' value='Bulk SMS Credit with the amount of N <?php echo $amount; ?>' />
	
	<input type='hidden' name='notify_url' value='<?php echo $notify_url; ?>' />
	<input type='hidden' name='success_url' value='<?php echo $success_url; ?>' />
	<input type='hidden' name='fail_url' value='<?php echo $failed_url; ?>' />
	
	<input type='hidden' name='developer_code' value='' />
	<input type='hidden' name='store_id' value='77' />	
	
	<input type='hidden' name='total' value='<?php echo $amount; ?>' />
	
	
	
	
			<div class="form-group">
										<div class="col-sm-12">
										<?=Html::img(Utility::getDebitcardLogo(), ['style' => "width: 200px; height: auto;"])?>
										</div>
									</div>
									<div class="form-group">
									<div class="col-sm-12">
                                        <div class="row">
                                            <div class="space-20"></div>
											<div class="col-md-7">
											<input type='image' src='<?php echo $btn_url; ?>' alt='Continue to pay' class="">
											</div>
											<div class="col-md-5">
                                            </div>
                                        </div>
                                        </div>
                                       
                                    </div>
                                    
			<?php ActiveForm::end(); ?>					
								<div class="space-20"></div>
							</div>
							</div>
                        <div class="col-md-6 col-sm-12">
                        <div class="pad10 white-bg-box">
								
								<?php 
								$form = ActiveForm::begin([
		'action' => $scratchcard_url,
		//'action' => ['/site/order_summary'],
    	'id' => "example-advanced-for",
    	'options'=>['enctype'=>'multipart/form-data'],
    	'enableClientValidation' => true,

	]); ?>
	<!-- form name="form1" action="<?php //echo $e_url; ?>" method="post"-->	

	<input type='hidden' name='transaction_id' value='<?php echo $merchant_ref; ?>' />
	<input type='hidden' name='memo' value='Bulk SMS Online Order' />
	
	<input type='hidden' name='type' value='<?php echo $data['type']; ?>' />	
	
	<input type='hidden' name='amount' value='<?php echo $amount; ?>' />
	
	
	
	
			<div class="form-group">
										<div class="col-sm-12">
										<?=Html::img(Utility::getScratcardLogo(), ['style' => "width: 200px; height: auto;"])?>
										</div>
									</div>
									<div class="form-group">
									<div class="col-sm-12">
                                        <div class="row">
                                            <div class="space-20"></div>
											<div class="col-md-7">
											<button name="add_to_cart" type="submit" class="btn btn-custom form-control"> Continue to pay</button>											
											</div>
											<div class="col-md-5">
                                            </div>
                                        </div>
                                        </div>
                                       
                                    </div>
                                    
			<?php ActiveForm::end(); ?>					
								<div class="space-20"></div>
							</div>
							</div>
							</div>
				<div class="row"> 
                        <div class="col-md-12 col-sm-12">							
                        <div class="alert alert-success">
                        <p>In addition to the above methods, you can call (08153505442) us to deliver the SpeedySMS Scratch cards to you. Or make bank deposit into our account, then call or send email or SMS with payment details for activation:</p>
                        <h4>
                        	Request bank details.
                        </h4></div>
								<?php 
								/*
								$resp = Yii::$app->session->getFlash("order-success");
								if($resp == 'success') {
									echo '<div class="alert alert-success">Your sms was added successfully. <a href="' . $message_url . '">Click here</a> to start sending messages.</div>';
								} else {
									echo '<div class="alert alert-danger">An error occured while processing your request. Please retry or contact us at sales@helloworldng.com.</div>';
								}
								*/

								?>					
							</div>
							
                        </div>
					
					