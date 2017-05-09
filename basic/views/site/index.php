<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = 'SpeedySMS - Convenient and Reliable';
$request_url = urldecode(Url::toRoute(['/site/request'])); 
?>
            <section class="main">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-sm-10">
                         <div class="widget" style="margin-bottom:0px;">
                            <div class="row">
							<div class="widget-header" style="margin-left:10px;">
                              <h3>SMS CALCULATOR: Price to No of SMS</h3>
                                                             
                                </div>
                                
                                <div class="widget-body" style="margin:0 15px;">
                                    
									<div class="row" style="padding-bottom: 5px;">
									<div class="col-md-6">
									<input type="text" id="price_cal" class="form-control input-lg" placeholder="Enter budget in Naira. e.g: 5000" style="padding-right:5px;">
									</div>
									<div class="col-md-6">
									<select id="sms_type_cal1" class="form-control input-lg">
										<option value="">SMS Service Type</option>
										<option value="standard">Standard</option>
										<option value="express">Express</option>
									</select>
									</div>
									</div>
                                        
										<div class="row">
                                        <div class="col-md-6">
                                            <button id="price_cal_btn" type="button" class="btn btn-block btn-custom">Calculated amount =></button>
                                        </div>
										<div class="col-md-6">
                                            <input type="text" id="calculated_no_cal" class="form-control input-lg" placeholder="0 SMS">
                                        </div>
										</div>
                                    
							</div>

                           </div>
                            </div>
							<div style="height: 20px;clear:both;"></div>
						 <div class="widget" style="margin-bottom:0px;">
                            <div class="row">
							<div class="widget-header" style="margin-left:10px;">
                              <h3>SMS CALCULATOR: No of SMS to price</h3>
                                                             
                                </div>
                                
                                <div class="widget-body" style="margin:0 15px;">
                                    
									<div class="row" style="padding-bottom: 5px;">
									<div class="col-md-6">
									<input type="text" id="no_of_sms_cal" class="form-control input-lg" placeholder="No of SMS" style="padding-right:5px;">
									</div>
									<div class="col-md-6">
									<select id="sms_type_cal" class="form-control input-lg">
										<option value="">SMS Service Type</option>
										<option value="standard">Standard</option>
										<option value="express">Express</option>
									</select>
									</div>
									</div>
                                        
										<div class="row">
                                        <div class="col-md-6">
                                            <button id="cal_cal" type="button" class="btn btn-block btn-custom">Calculated price =></button>
                                        </div>
										<div class="col-md-6">
                                            <input type="text" id="calculated_amt_cal" class="form-control input-lg" placeholder="N0.00">
                                        </div>
										</div>
                                    
							</div>

                           </div>
                            </div>
							<div style="height: 20px;clear:both;"></div>
							<div class="widget">
                            <div class="row">
							<div class="widget-header" style="margin-left:10px;">
							<form id="contact_form_home" method="post" action="<?php echo $request_url; ?>">
                              <h3>Request Quote</h3>
                              <div class="col-md-12 col-sm-12">
	<div class="alert alert-info text-center" style="display: none;" id="contact_output"></div></div>                          
                                </div>
                                <div class="widget-body" style="margin:0 15px;">
                                    
									<div class="row" style="padding-bottom: 5px;">
									<div class="col-md-6">
									<input type="text" id="name_contact" name="name_contact" class="form-control input-lg" placeholder="Name">
									</div>
									<div class="col-md-6">
									<input type="text" id="subject_contact" name="subject_contact" class="form-control input-lg" placeholder="Subject">
									</div>
									</div>
										<div class="row">
                                        <div class="col-md-4">
                                            <button type="submit" id="btn_contact" class="btn btn-block btn-custom">Request quote</button>
                                        </div>
										<div class="col-md-8">
                                            <input type="text" name="comment_contact" id="comment_contact" class="form-control input-lg" placeholder="Comment">
                                        </div>
										</div>
                                    </form>
							</div>

                           </div>
                            </div>
							</div>
						
							<div class="col-md-4 col-sm-2">
							
                            <div class="widget" style="padding-bottom:50px;">
                            <?php 
							if(!Yii::$app->user->isGuest) { ?>
								<div class="widget">
			<!-- Categories -->
			<?php echo \Yii::$app->view->renderFile('@app/views/layouts/_sidebar_nav.php'); ?>
	</div>
	<?php
							} else {
							?>
                                <div class="widget-header" style="padding-bottom:15px;">
                                    <h3>Quick Signup</h3>
                                </div>
                                <div class="widget-body">
                                    <?php $form = ActiveForm::begin(['action' => Url::toRoute(['/user/register'])]); ?>
                                        <div class="form-group">
                                            <input type="text" name="Profile[full_name]" class="form-control input-lg" placeholder="Enter full name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="User[email]" class="form-control input-lg" placeholder="Email address">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="User[username]" class="form-control input-lg" placeholder="Username or phone number">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="User[newPassword]" class="form-control input-lg" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label class="string optional" for="terms">
                                                    <input type="checkbox" id="terms" style="">
                                                    <a href="#">I Agree with Term and Conditions</a>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-block btn-custom">Sign Up</button>
                                        </div>
                                        <div class="form-group">
                                            <?= Html::a('Log in', ['/user/login'], ['class' => "btn btn-block btn-info"]) ?>
                                        </div>
                                    </form>
                                </div>
                                <?php } ?>
                            </div>
                            
                           </div>
                        </div>
					
					  <div class="row">
                        <div class="col-md-12 col-sm-12">
                            
                            <div class="row" style="margin-left:0px;">
                              <div class="col-md-12 col-sm-3">
								<div class="row">
                                    <div id="featured-products" class="owl-carousel owl-carousel-featured">
                                        <div class="item" >
                                            <div class="item-ads-grid" style="min-height:10px;">
                                                <div class="item-img-grid">
                                                    <img alt="" src="<?php echo Yii::$app->request->baseUrl; ?>/assets2/img/products/fast-acting.jpg" class="img-responsive img-center">
                                                </div>
                                                <div class="item-title" style="padding-left:25px;">
                                                    <h4>Fast SMS</h4>
                                                </div>                                           
                                            </div>   
                                        </div>
										

                                        <div class="item" >
                                            <div class="item-ads-grid" style="min-height:10px;">
                                                <div class="item-img-grid">
                                                    <img alt="" src="<?php echo Yii::$app->request->baseUrl; ?>/assets2/img/products/product-6.png" class="img-responsive img-center">
                                                </div>
                                                <div class="item-title" style="padding-left:5px;">
                                                    <h4>Accurate Delivery Reports</h4>
                                                </div>                                            
                                            </div>
                                        </div>
										
										<div class="item" >
                                            <div class="item-ads-grid" style="min-height:10px;">
                                                <div class="item-img-grid">
                                                    <img alt="" src="<?php echo Yii::$app->request->baseUrl; ?>/assets2/img/products/low-cost.jpg" class="img-responsive img-center">
                                                </div>
                                                <div class="item-title" style="padding-left:25px;">
                                                   <h4>Cost Effective SMS</h4>
                                                </div>                                           
                                            </div>   
                                        </div>

                                        <div class="item">
                                            <div class="item-ads-grid" style="min-height:10px;">
                                                <div class="item-img-grid">
                                                    <img alt="" src="<?php echo Yii::$app->request->baseUrl; ?>/assets2/img/products/product-7.jpg" class="img-responsive img-center">
                                                </div>
                                                <div class="item-title" style="padding-left:2em auto;">
                                                   <h4>Convenient Payment</h4>
                                                </div>                                                                                           
                                            </div>
                                        </div>
										
										

                                        <div class="item">
                                            <div class="item-ads-grid" style="min-height:10px;">
                                                <div class="item-img-grid">
                                                    <img alt="" src="<?php echo Yii::$app->request->baseUrl; ?>/assets2/img/products/product-1.jpg" class="img-responsive img-center">
                                                </div>
                                                <div class="item-title" style="padding-left:5px;" style="padding-right:5px;" margin>
                                                    <h4>Easy and accessible</h4>
                                                </div>                                         
                                            
                                        </div>
									</div>
                                    </div>
                                </div>
                            </div>
                       

                    </div>
                </div>
            </section>