<?php use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="row">
                            <?php 
							if(!Yii::$app->user->isGuest) { ?>
				<div class="col-xs-12">
				<div id='cssmenu'>
					<ul>
					   <li class='active has-sub'><a href='#'><span>SEND SMS</span></a>
					      <ul>
							<li role="presentation"><?=  Html::a('SEND SINGLE SMS', ['/message/create']); ?></li>
							<li class="active" role="presentation"><?=  Html::a('SEND BULK SMS', ['/message/bulk']); ?></li>
							<li class="last" role="presentation"><?=  Html::a('SEND GROUP SMS', ['/message/group']); ?></li>
					    </ul>
					   </li>
					   <!-- li role="presentation"><?php //=  Html::a('SCHEDULED JOB', ['/schedule/index']); ?></li-->
					  <li role="presentation"><?=  Html::a('ADDRESS BOOK', ['/addressbook/index']); ?></li>
					  <li class='active has-sub'><a href='#'><span>REPORTS</span></a>
					      <ul>
							<li role="presentation"><?=  Html::a('CREDIT REPORTS', ['/reports/credit_statistics']); ?></li>
							<li class="" role="presentation"><?=  Html::a('TODAY\'s STATISTICS', ['/reports/today_statistics']); ?></li>
							<li class="last" role="presentation"><?=  Html::a('SMS REPORTS', ['/reports/sms_statistics']); ?></li>
							<!-- li class="last" role="presentation"><?php //=  Html::a('SMS SUMMARY', ['/reports/sms_summary']); ?></li-->
					    </ul>
					   </li>
					   <!-- li role="presentation"><?php //=  Html::a('MONTHLY SUMMARY', ['/site/summary']); ?></li-->
					   <li class='last' role="presentation"><?=  (Yii::$app->user->isGuest) ? Html::a('LOG IN', ['/site/login']): Html::a('LOGOUT', ['/site/logout']); ?></li>
					</ul>
					</div>
				</div>
			
			
			<?php 
								
							} else {
							?>
							<div style="padding:20px;">
                                <div class="widget-header" style="padding-bottom:15px;">
                                    <h3>Quick Signup</h3>
                                </div>
                                <div class="widget-body">
                                    <?php $form = ActiveForm::begin([]); ?>
                                        <div class="form-group">
                                            <input type="text" name="Profile[full_name]" class="form-control input-lg" placeholder="Enter full name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="User[username]" class="form-control input-lg" placeholder="Email or phone number">
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
                                    </form>
                                </div></div>
                                <?php } ?>
                            </div>