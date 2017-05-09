<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;


Yii::$app->mailer->compose()
            ->setTo('rasheedsaidi@gmail.com')
            ->setFrom('sales@speedysms.com.ng')
            ->setSubject('Invite')
            ->setTextBody('Hello!')
            ->send();
/*
$mailer = Yii::$app->mailer;
        $subject = "Test email";
        $email = "rasheedsaidi@gmail.com";
        $result = $mailer->compose('signup_success')
            ->setTo($email)
            ->setSubject($subject)
            ->send();*/
?>
<section class="main">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="map">
                                <img src="<?php echo Yii::$app->request->baseUrl; ?>/assets2/img/general/map.png" alt="" class="img-responsive">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="widget">
                                <div class="widget-header">
                                    <h3>Office Address</h3>
                                </div>
                                <div class="widget-body">
                                    <!-- address>
                                        <strong>Helloworld Techonologies</strong><br/>
                                        77 Herbert, Macaulay Way, Ebute Metta, Yaba, Lagos<br/>
                                        admin@speedysms.com.ng<br/>
                                        Phone : 08153505442
                                    </address-->
                                    <address>
                                        <strong>SpeedySMS</strong><br/>
                                        University of Lagos,<br/>
                                        Faculty of Engineering, <br/>
                                        Akoka,<br/>
                                        Lagos<br/>
                                        admin@speedysms.com.ng<br/>
                                        Phone : 08060553348, 08153505442
                                    </address>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="widget">
                                    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

    <div class="alert alert-success">
        Thank you for contacting us. We will respond to you as soon as possible.
    </div>

    <?php else: ?>
                                        <div class="widget-header">
                                            <h3>Send Message</h3>
                                        </div>
                                        <div class="widget-body">
                                        
                                            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                                            <?= $form->errorSummary($model); ?>
                                                <p>If you have any question, feel free to send message us</p>
                                                <div class="row">
                                                    <div class="col-xs-4">
                                                        <input type="text" name="ContactForm[name]" value="<?= $model->name; ?>" placeholder="Name" class="form-control input-lg">
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <input type="text" name="ContactForm[email]" value="<?php echo $model->email; ?>" placeholder="Email" class="form-control input-lg">
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <input type="text" name="ContactForm[subject]" value="<?php echo $model->subject; ?>" placeholder="Subject" class="form-control input-lg">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <textarea name="ContactForm[body]" rows="5" placeholder="Write message here..." class="form-control input-lg"><?php echo $model->body; ?></textarea>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <button class="btn btn-lg btn-custom pull-right">Submit</button>
                                                    </div>
                                                </div>
                                            <?php ActiveForm::end(); ?>
                                        </div>                                        
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
