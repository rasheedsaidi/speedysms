<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Payment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">

                            <div class="post">                            
		
		<!-- Banner -->
			<div id="banner-wrapper">
				<div id="banner" class="box container">
					<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Monthly Access fee: N300</h2>
                <h3>Enjoy huge discounts by ordering in bulk.</h3>
            <h4>PAYMENT INFORMATION</h4>
         <h4>How to obtain activation code</h4>
            <div>
                <div>(1) Pay by Vogue Pay using your atm Master Card or Visacard <em><form method='POST' action='https://voguepay.com/pay/'>

<input type='hidden' name='v_merchant_id' value='13161-9737' />
<input type='hidden' name='merchant_ref' value='<?php echo substr(md5(time()), 0, 10); ?>' />
<input type='hidden' name='memo' value='Naijastudent POST UTME monthly access fee.' />

<input type='hidden' name='recurrent' value='false' />
<!--<input type='hidden' name='interval' value='30' /-->

<input type='hidden' name='developer_code' value='<?php  ?>' />
<!--input type='hidden' name='store_id' value='25' /-->

<input type='hidden' name='total' value='300' />

<input type='hidden' name='notify_url' value='http://www.naijastudent.com.ng/public/notify' />
<input type='hidden' name='success_url' value='http://www.naijastudent.com.ng/public/thank_you' />
<input type='hidden' name='fail_url' value='http://www.naijastudent.com.ng/public/failed' />

<input type='image' style='cursor: pointer' src='http://voguepay.com/images/buttons/make_payment_green.png' alt='Make payment' />

</form></em></div>
                <div>(2) By Bank Deposit with account detail:
                    <h4>Bank Name: Fidelity Bank</h4>
                    <h4>Account Name: TopSoftWeb Solutions</h4>
                    <h4>Account No: 5060025382</h4>
                    <div>Then send the teller no and amount paid to 08153545442 or sales@naijastudent.com.ng. You will receive a message containing the activation code.</div>
                </div>
                <div>(3) By Our Manual Scratch Card from distributors</div>
                <div>(4) <h4>Get huge discounts by ordering in bulk</h4></div>
            </div>
            <div>For more information call 07036958491, 08153505442 (also on WhatApp), 08060553348, sales@naijastudent.com.ng.</div>
            
        </div>
						
               

					</div>
				</div>
			</div>
                            </div>
                        </div>