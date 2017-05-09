<?php
use app\models\Utility;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Pay by scratchcard';
$this->params['breadcrumbs'][] = $this->title;

$message_url = urldecode(Url::toRoute(['/message/create']));
$scratchcard_url = urldecode(Url::toRoute(['/site/scratchcard']));
$e_url = urldecode(Url::to('https://voguepay.com/pay/'));

//var_dump($data);exit;

	?>


                <h4 class="h4cap">Make payment</h4>  
                <?php if (Yii::$app->session->hasFlash('payment_reply'))
                		echo Yii::$app->session->getFlash('payment_reply')
                ?>    
				<div class="row">				
                        <div class="col-md-8 col-md-offset-2 col-sm-12">
                        <div class="pad10 white-bg-box">
								
								<?php 
								$form = ActiveForm::begin([		
		//'action' => ['/site/order_summary'],
    	'enableClientValidation' => true,

	]); ?>
	<!-- form name="form1" action="<?php //echo $e_url; ?>" method="post"-->	

	<input type='hidden' name='transaction_id' value='<?php echo $data['transaction_id']; ?>' />
	
	<input type='hidden' name='type' value='<?php echo $data['type']; ?>' />	
	
	<input type='hidden' name='amount' value='<?php echo $data['amount']; ?>' />
	<input type='hidden' name='pay_now' value='1' />
	
	<div class="form-group">
	<label class="control-label" for="pin">PIN number</label>
	<input name="pin" type="text" class="form-control input-lg" placeholder="Enter PIN">
	</div>
	
	
			
									<div class="form-group">
									<div class="col-sm-12">
                                        
											<button name="add_to_cart" type="submit" class="btn btn-custom form-control">Pay now</button>											
											
                                        </div>
                                        </div>
                                       
                                    </div>
                                    
			<?php ActiveForm::end(); ?>					
								<div class="space-20"></div>
							</div>
							</div>
					
					