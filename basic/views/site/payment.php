<?php
use app\models\Utility;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Payment';
$this->params['breadcrumbs'][] = $this->title;

$url = urldecode(Url::toRoute(['order_now']));
$priceList = Utility::getPriceList();
?>

				<div class="row">
	                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		            	<h4>PAYMENT INFORMATION</h4>
	            	</div>
	            </div>
	            <h4>Please find the information on how to buy our SMS below:</h4>
	            <div class="row">
	         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         
            
                <table class="table table-bordered">
                	<tr>
                		<th colspan="5">Standard Type SMS</th>
                	</tr>
                	<tr>
                		<th>SMS Type</th>
                		<th>Amount</th>
                		<th>Price per SMS</th>
                		<th>Number of SMS</th>
                		<th>Order</th>
                	</tr>
                	<tr>
                		<td>&nbsp;</td>
                		<td>N 100</td>
                		<td>N <?php echo $priceList['standard'][0]['amount'] ?></td>
                		<td><?php echo ceil(100 / floatval($priceList['standard'][0]['amount'])); ?></td>
                		<td>
                		<?php $form = ActiveForm::begin(['action' => ['/site/order_now'], 'options' => ['class' => 'update_post_form']]); ?>
                		<input type="hidden" name="amt" value="100">
                		<input type="hidden" name="type" value="standard">
                		<input class="btn btn-success" type="submit" value="Order Now (N 100)" name="order100">
                		<?php ActiveForm::end(); ?>
                		</td>
                	</tr>
                	<tr>
                		<td>&nbsp;</td>
                		<td>N 200</td>
                		<td>N <?php echo $priceList['standard'][0]['amount']; ?></td>
                		<td><?php echo ceil(200 / floatval($priceList['standard'][0]['amount'])); ?></td>
                		<td>
                		<?php $form = ActiveForm::begin(['action' => ['/site/order_now']]); ?>
                		<input type="hidden" name="amt" value="200">
                		<input type="hidden" name="type" value="standard">
                		<input class="btn btn-success" type="submit" value="Order Now (N 200)" name="order200">
                		<?php ActiveForm::end(); ?>
                		</td>
                	</tr>
                	<tr>
                		<td>&nbsp;</td>
                		<td>N 500</td>
                		<td>N <?php echo $priceList['standard'][0]['amount']; ?></td>
                		<td><?php echo ceil(500 / floatval($priceList['standard'][0]['amount'])); ?></td>
                		<td>
                		<?php $form = ActiveForm::begin(['action' => ['/site/order_now']]); ?>
                		<input type="hidden" name="amt" value="500">
                		<input type="hidden" name="type" value="standard">
                		<input class="btn btn-success" type="submit" value="Order Now (N 500)" name="order500">
                		<?php ActiveForm::end(); ?>
                		</td>
                	</tr>              	
                	<tr>
                		<td>&nbsp;</td>
                		<td>N 1000</td>
                		<td>N <?php echo $priceList['standard'][1]['amount']; ?></td>
                		<td><?php echo ceil(1000 / floatval($priceList['standard'][1]['amount'])); ?></td>
                		<td>
                		<?php $form = ActiveForm::begin(['action' => ['/site/order_now']]); ?>
                		<input type="hidden" name="amt" value="1000">
                		<input type="hidden" name="type" value="standard">
                		<input class="btn btn-success" type="submit" value="Order Now (N 1000)" name="order1000">
                		<?php ActiveForm::end(); ?>
                		</td>
                	</tr>
                	<tr>
                		<td>&nbsp;</td>
                		<td>N 2000</td>
                		<td>N <?php echo $priceList['standard'][1]['amount']; ?></td>
                		<td><?php echo ceil(2000 / floatval($priceList['standard'][1]['amount'])); ?></td>
                		<td>
                		<?php $form = ActiveForm::begin(['action' => ['/site/order_now']]); ?>
                		<input type="hidden" name="amt" value="2000">
                		<input type="hidden" name="type" value="standard">
                		<input class="btn btn-success" type="submit" value="Order Now (N 2000)" name="order2000">
                		<?php ActiveForm::end(); ?>
                		</td>
                	</tr>
                	<tr>
                		<td>&nbsp;</td>
                		<td>N 5000</td>
                		<td>N <?php echo floatval($priceList['standard'][1]['amount']); ?></td>
                		<td><?php echo ceil(5000 / floatval($priceList['standard'][1]['amount'])); ?></td>
                		<td>
                		<?php $form = ActiveForm::begin(['action' => ['/site/order_now']]); ?>
                		<input type="hidden" name="amt" value="5000">
                		<input type="hidden" name="type" value="standard">
                		<input class="btn btn-success" type="submit" value="Order Now (N 5000)" name="order5000">
                		<?php ActiveForm::end(); ?>
                		</td>
                	</tr>
                	<tr>
                		<td>&nbsp;</td>
                		<td>N 10000</td>
                		<td>N <?php echo $priceList['standard'][2]['amount']; ?></td>
                		<td><?php echo ceil(10000 / floatval($priceList['standard'][2]['amount'])); ?></td>
                		<td>
                		<?php $form = ActiveForm::begin(['action' => ['/site/order_now']]); ?>
                		<input type="hidden" name="amt" value="10000">
                		<input type="hidden" name="type" value="standard">
                		<input class="btn btn-success" type="submit" value="Order Now (N 10000)" name="order10000">
                		<?php ActiveForm::end(); ?>
                		</td>
                	</tr>
                	<tr>
                		<th colspan="5">Express Type SMS</th>
                	</tr>
                	<tr>
                		<th>SMS Type</th>
                		<th>Amount</th>
                		<th>Price per SMS</th>
                		<th>Number of SMS</th>
                		<th>Order</th>
                	</tr>
                	<tr>
                		<td>&nbsp;</td>
                		<td>N 100</td>
                		<td>N <?php echo $priceList['express'][0]['amount']; ?></td>
                		<td><?php echo ceil(100 / floatval($priceList['express'][0]['amount'])); ?></td>
                		<td>
                		<?php $form = ActiveForm::begin(['action' => ['/site/order_now']]); ?>
                		<input type="hidden" name="amt" value="100">
                		<input type="hidden" name="type" value="express">
                		<input class="btn btn-success" type="submit" value="Order Now (N 100)" name="direct100">
                		<?php ActiveForm::end(); ?>
                		</td>
                	</tr>
                	<tr>
                		<td>&nbsp;</td>
                		<td>N 200</td>
                		<td>N <?php echo $priceList['express'][0]['amount']; ?></td>
                		<td><?php echo ceil(200 / floatval($priceList['express'][0]['amount'])); ?></td>
                		<td>
                		<?php $form = ActiveForm::begin(['action' => ['/site/order_now']]); ?>
                		<input type="hidden" name="amt" value="200">
                		<input type="hidden" name="type" value="express">
                		<input class="btn btn-success" type="submit" value="Order Now (N 200)" name="direct200">
                		<?php ActiveForm::end(); ?>
                		</td>
                	</tr>
                	<tr>
                		<td>&nbsp;</td>
                		<td>N 500</td>
                		<td>N <?php echo $priceList['express'][0]['amount']; ?></td>
                		<td><?php echo ceil(500 / floatval($priceList['express'][0]['amount'])); ?></td>
                		<td>
                		<?php $form = ActiveForm::begin(['action' => ['/site/order_now']]); ?>
                		<input type="hidden" name="amt" value="500">
                		<input type="hidden" name="type" value="express">
                		<input class="btn btn-success" type="submit" value="Order Now (N 500)" name="direct500">
                		<?php ActiveForm::end(); ?>
                		</td>
                	</tr>               	
                	<tr>
                		<td>&nbsp;</td>
                		<td>N 1000</td>
                		<td>N <?php echo $priceList['express'][1]['amount']; ?></td>
                		<td><?php echo ceil(1000 / floatval($priceList['express'][1]['amount'])); ?></td>
                		<td>
                		<?php $form = ActiveForm::begin(['action' => ['/site/order_now']]); ?>
                		<input type="hidden" name="amt" value="1000">
                		<input type="hidden" name="type" value="express">
                		<input class="btn btn-success" type="submit" value="Order Now (N 1000)" name="direct1000">
                		<?php ActiveForm::end(); ?>
                		</td>
                	</tr>
                	<tr>
                		<td>&nbsp;</td>
                		<td>N 2000</td>
                		<td>N <?php echo $priceList['express'][1]['amount']; ?></td>
                		<td><?php echo ceil(2000 / floatval($priceList['express'][1]['amount'])); ?></td>
                		<td>
                		<?php $form = ActiveForm::begin(['action' => ['/site/order_now']]); ?>
                		<input type="hidden" name="amt" value="2000">
                		<input type="hidden" name="type" value="express">
                		<input class="btn btn-success" type="submit" value="Order Now (N 2000)" name="direct2000">
                		<?php ActiveForm::end(); ?>
                		</td>
                	</tr>
                	<tr>
                		<td>&nbsp;</td>
                		<td>N 5000</td>
                		<td>N <?php echo $priceList['express'][1]['amount']; ?></td>
                		<td><?php echo ceil(5000 / floatval($priceList['express'][1]['amount'])); ?></td>
                		<td>
                		<?php $form = ActiveForm::begin(['action' => ['/site/order_now']]); ?>
                		<input type="hidden" name="amt" value="5000">
                		<input type="hidden" name="type" value="express">
                		<input class="btn btn-success" type="submit" value="Order Now (N 5000)" name="direct5000">
                		<?php ActiveForm::end(); ?>
                		</td>
                	</tr>
                	<tr>
                		<td>&nbsp;</td>
                		<td>N 10000</td>
                		<td>N <?php echo $priceList['express'][2]['amount']; ?></td>
                		<td><?php echo ceil(10000 / floatval($priceList['express'][2]['amount'])); ?></td>
                		<td>
                		<?php $form = ActiveForm::begin(['action' => ['/site/order_now']]); ?>
                		<input type="hidden" name="amt" value="10000">
                		<input type="hidden" name="type" value="express">
                		<input class="btn btn-success" type="submit" value="Order Now (N 10000)" name="direct10000">
                		<?php ActiveForm::end(); ?>
                		</td>
                	</tr>
                </table>
                <h4>For orders above N 10,000, please pay via Bank Deposit with account detail:</h4>
                    <h4>Bank Name: Access Bank</h4>
                    <h4>Account Name: Helloworld Technologies</h4>
                    <h4>Account No: 0707020231</h4>
                    <div>Then send the teller no and amount paid to 08153545442 or sales@helloworldng.com. You will receive a message confirming your credit activation.</div>
                    <div><!-- h4>Or Buy Our Manual Scratch Card from distributors</h4--></div>
                </div>
                
            </div>
            <div>For more information call 08153505442 (also on WhatApp), 08060553348, sales@speedysms.com.ng.</div>
            
   
		