<?php

namespace app\controllers;

use app\models\Voguepay;

use app\models\Transaction;

use app\models\Gateway;

use app\models\MessageLog;

use yii\helpers\Url;

use app\models\Pin;

use app\models\CreditLog;

use app\models\Utility;

use app\models\Credit;

use yii\widgets\ActiveForm;

use app\models\User;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['pricing', 'payment', 'contact', 'about', 'services', 'index', 'order_now', 'api'],
                        'allow'   => true,
                        'roles'   => ['?', '@'],
                    ],
                    [
                        'actions' => ['create', 'bulk', 'group', 'logout', 'scratchcard', 'success', 'failed', 'transaction'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                    [
                        'actions' => ['login', 'register', 'forgot', 'reset', 'success', 'confirm'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
            		'rating' => ['post', 'get'],
            		'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
	public function beforeAction($action)
	{            
	    if ($action->id == 'transaction' || $action->id == 'success' || $action->id == 'failed') {
	        $this->enableCsrfValidation = false;
	    }
	
	    return parent::beforeAction($action);
	}

    public function actionIndex()
    {
    	$this->layout = '@app/views/layouts/home';        
        return $this->render('index');
    }

    public function actionLogin()
    {
    	$this->layout = '@app/views/layouts/login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
	/**
     * Display registration page
     */
    public function actionRegister() {

    	$this->layout = '@app/views/layouts/login';
        // set up new user/profile objects
        $user = new User();

        // load post data
        $post = Yii::$app->request->post();
        if ($user->load($post)) {

            // validate for ajax request
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($user);
            }

            // validate for normal request
            if ($user->validate()) {

                // perform registration
                //$role = $this->module->model("Role");
                $user->role_id = $user::ROLE_USER;
                $user->status = $user::STATUS_ACTIVE;
                $user->created_at = date('Y-m-d H:i:s');   
				$user->updated_at = date('Y-m-d H:i:s');   

				$user->save(false);
				
				//send email

                // set flash
                // don't use $this->refresh() because user may automatically be logged in and get 403 forbidden
                $successText = Yii::t("You registration is successful. You can now start sending messages");
                $guestText = "";
                //if (Yii::$app->user->isGuest) {
                    //$guestText = Yii::t("user", " - Please check your email to confirm your account");
                //}
                Yii::$app->session->setFlash("reg-success", $successText);
            }
        }

        return $this->render("register", compact("user"));
    }

    public function actionLogout()
    {
    	$this->layout = '@app/views/layouts/home';
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
    	$this->layout = '@app/views/layouts/login';
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
			
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
    	$this->layout = '@app/views/layouts/site';
        return $this->render('about');
    }
    
	public function actionServices()
    {
    	$this->layout = '@app/views/layouts/site';
        return $this->render('services');
    }
    
	public function actionPricing()
    {
    	$this->layout = '@app/views/layouts/site';
        return $this->render('pricing');
    }
    
    public function actionScratchcard()
    {    	
    	$this->layout = '@app/views/layouts/site';
    	
    	$data = Yii::$app->request->post();
    	
    	if(isset($_POST['pay_now'])) {
    		// search for PIN
    		$type = $data['type'];
		    $amount = $data['amount'];
		    $id = Yii::$app->user->id;
		    $trans_id = $data['transaction_id'];
    		$pin = Utility::isValidPIN($data['pin'], $amount);
    		if($pin == 1) {		    	
		    	
		    	$price = Utility::getPrice($amount, $type);
		    	$credit = Credit::find()->where(['user_id' => $id])->andWhere(['type' => $type])->andWhere(['price_id' => $price['id']])->one();
		    		    	
		    	//$new_credit = (float) $amount * (float) $price->price;
		    	
		    	if(!$credit) {    		
			    	$credit = new Credit();
			    	$credit->user_id = $id;
			    	$credit->amount = $amount;
			    	$credit->price_id = $price['id'];
			    	$credit->type = $type;
			    	$credit->created_at = date('Y-m-d H:i:s');
			    	$credit->save(false);
			    	
			    	$credit_log = new CreditLog();
		    		$credit_log->credit = $amount;
		    		$credit_log->user_id = $id;
		    		$credit_log->type = $type;
		    		$credit_log->credit_id = $credit->id;
		    		$credit_log->added_at = date('Y-m-d H:i:s');
		    		$credit_log->save(false);
		    		$resp = 'success';
		    		Yii::$app->session->setFlash("order-success", $resp);
		    		//return $this->redirect(['/site/order_now']);
		    		
		    	} else {	    		
		    		$credit->amount = $credit->amount + $amount;
		    		$credit->save(false);
		    		
		    		$credit_log = new CreditLog();
		    		$credit_log->credit = $amount;
		    		$credit_log->user_id = $id;
		    		$credit_log->type = $type;
		    		$credit_log->credit_id = $credit->id;
		    		$credit_log->added_at = date('Y-m-d H:i:s');
		    		$credit_log->save(false);
		    		//echo 'got_here1';exit;
		    		$resp = 'success';
		    		Yii::$app->session->setFlash("order-success", $resp);
		    		//return $this->redirect(['/site/order_now']);
		    	} 
    			$reply = 'success';
    			Utility::usePIN($data['pin'], $trans_id);
    			$message_url = urldecode(Url::toRoute(['/message/create']));
    			Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-success">Your sms was added successfully. <a href="' . $message_url . '">Click here</a> to start sending messages.</div>');
    		} else {
    			$payment_url = urldecode(Url::toRoute(['/site/payment']));
    			if($pin == '0') {
    			Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-info">
        Invalid PIN. Please check the PIN and retry. <a href="' . $payment_url . '">Click here</a> to go back.
    </div>');
    			} else if($pin == '2') {
    			Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-info">
        The PIN has been used. Please purchase a valid PIN and retry. <a href="' . $payment_url . '">Click here</a> to go back.
    </div>');
    			} else if($pin == '3') {
    			Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-info">
        The price on the PIN doesn\'t match the price selected. Please select the correct price value and retry. <a href="' . $payment_url . '">Click here</a> to go back.
    </div>');
    			}
    		}
    	}
    	return $this->render('scratchcard', compact("data"));
    }
    
	public function actionOrder_now()
    {
    	$this->layout = '@app/views/layouts/site';
    	$id = Yii::$app->user->id;    	    
        	
    	$data = Yii::$app->request->post();
		if(isset($data['amt']) && !empty($data['amt'])) {
			$_SESSION['sms_amt'] =  $data['amt'];
			$_SESSION['sms_type'] = $data['type'];
		} else {
			$data['amt'] = $_SESSION['sms_amt'];
			$data['type'] = $_SESSION['sms_type'];
		}
		
    	if (Yii::$app->user->isGuest) {
    		$session = Yii::$app->session;
	        $session->setFlash('loginRequired', 'You need to login to continue.');
	        return $this->redirect(['/user/login']);
        }
    	$resp = 'error';
    	$merchant_ref = substr(md5(time()), 2, 14);
    	Utility::startSession();
    	$_SESSION['merchant_ref'] = $merchant_ref;
    	//$_SESSION['sms_type'] = $merchant_ref;
    	
    	Utility::logTransaction($merchant_ref, $data['amt']);
    	
    	if(false) {	//$data) {
	    	$type = $data['type'];
	    	$amount = $data['amt'];	    	
	    	
	    	$price = Utility::getPrice($amount, $type);
	    	$credit = Credit::find()->where(['user_id' => $id])->andWhere(['type' => $type])->andWhere(['price_id' => $price['id']])->one();
	    		    	
	    	$new_credit = (float) $amount * (float) $price->price;
	    	
	    	if(!$credit) {    		
		    	$credit = new Credit();
		    	$credit->user_id = $id;
		    	$credit->amount = $amount;
		    	$credit->price_id = $price['id'];
		    	$credit->type = $type;
		    	$credit->created_at = date('Y-m-d H:i:s');
		    	$credit->save(false);
		    	
		    	$credit_log = new CreditLog();
	    		$credit_log->credit = $amount;
	    		$credit_log->user_id = $id;
	    		$credit_log->type = $type;
	    		$credit_log->credit_id = $credit->id;
	    		$credit_log->added_at = date('Y-m-d H:i:s');
	    		$credit_log->save(false);
	    		$resp = 'success';
	    		Yii::$app->session->setFlash("order-success", $resp);
	    		//return $this->redirect(['/site/order_now']);
	    		
	    	} else {	    		
	    		$credit->amount = $credit->amount + $amount;
	    		$credit->save(false);
	    		
	    		$credit_log = new CreditLog();
	    		$credit_log->credit = $amount;
	    		$credit_log->user_id = $id;
	    		$credit_log->type = $type;
	    		$credit_log->credit_id = $credit->id;
	    		$credit_log->added_at = date('Y-m-d H:i:s');
	    		$credit_log->save(false);
	    		//echo 'got_here1';exit;
	    		$resp = 'success';
	    		Yii::$app->session->setFlash("order-success", $resp);
	    		//return $this->redirect(['/site/order_now']);
	    	}    	
    	
    	} else {
    		//echo 'got_here';exit;
    		//return $this->redirect(['/site/payment']);
    	}    	    
    	
        return $this->render('order_now', compact("data", "merchant_ref"));
    }
    
	public function actionOrder_now1()
    {
    	$this->layout = '@app/views/layouts/site';
    	
    	$data = Yii::$app->request->post();
    	$resp = 'error';
    	$transaction_id = 'demo-'.substr(md5(time()), 2, 14);
    	Utility::startSession();
    	$_SESSION['transid'] = $transaction_id;
    	
    	Utility::logTransaction($transaction_id, $data['amt']);
    	
    	if(false) {	//$data) {
	    	$type = $data['type'];
	    	$amount = $data['amt'];
	    	$id = Yii::$app->user->id;
	    	
	    	$price = Utility::getPrice($amount, $type);
	    	$credit = Credit::find()->where(['user_id' => $id])->andWhere(['type' => $type])->andWhere(['price_id' => $price['id']])->one();
	    		    	
	    	$new_credit = (float) $amount * (float) $price->price;
	    	
	    	if(!$credit) {    		
		    	$credit = new Credit();
		    	$credit->user_id = $id;
		    	$credit->amount = $amount;
		    	$credit->price_id = $price['id'];
		    	$credit->type = $type;
		    	$credit->created_at = date('Y-m-d H:i:s');
		    	$credit->save(false);
		    	
		    	$credit_log = new CreditLog();
	    		$credit_log->credit = $amount;
	    		$credit_log->user_id = $id;
	    		$credit_log->type = $type;
	    		$credit_log->credit_id = $credit->id;
	    		$credit_log->added_at = date('Y-m-d H:i:s');
	    		$credit_log->save(false);
	    		$resp = 'success';
	    		Yii::$app->session->setFlash("order-success", $resp);
	    		//return $this->redirect(['/site/order_now']);
	    		
	    	} else {	    		
	    		$credit->amount = $credit->amount + $amount;
	    		$credit->save(false);
	    		
	    		$credit_log = new CreditLog();
	    		$credit_log->credit = $amount;
	    		$credit_log->user_id = $id;
	    		$credit_log->type = $type;
	    		$credit_log->credit_id = $credit->id;
	    		$credit_log->added_at = date('Y-m-d H:i:s');
	    		$credit_log->save(false);
	    		//echo 'got_here1';exit;
	    		$resp = 'success';
	    		Yii::$app->session->setFlash("order-success", $resp);
	    		//return $this->redirect(['/site/order_now']);
	    	}    	
    	
    	} else {
    		//echo 'got_here';exit;
    		//return $this->redirect(['/site/payment']);
    	}    	    
    	
        return $this->render('order_now', compact("data", "transaction_id"));
    }
    
	public function actionPayment()
    {
    	$this->layout = '@app/views/layouts/site';
        return $this->render('payment');
    }
    
	public function actionApi()
    {
    	$this->layout = '@app/views/layouts/site';
    	$id = Yii::$app->user->id;
    	$credit = Utility::getUserCredit($id); //var_dump($credit);exit;
        return $this->render('api', ['credit' => $credit]);
    }
    
    public function actionRequest() {
    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    	$data = \Yii::$app->request->post();
    	//echo $data['name_contact'];
    	$name = $data['name_contact'];
    	$subject = $data['subject_contact'];
    	$comment = $data['comment_contact'];
    	
    	$path = Yii::$app->basePath . '/web/assets/contact.txt';
    	$file = json_decode(file_get_contents($path), true);
    	$co = array(
    		'name' => $name,
    		'subject' => $subject,
    		'comment' => $comment,
    		'datetime' => date('Y-m-d H:i:s')
    	);
    	
    	$file[] = $co;
    	
    	$open = fopen($path,'w');
    	fwrite($open, json_encode($file));
    	fclose($open);
    	
    	echo json_encode("Your request was sent successfully. We'll get back to you as soon as possible.");	        	
	    exit;    	
    }
    
    public function actionTransaction() {
		//return true;
		Utility::sendSimpleEmail("Trans Page", "rasheedsaidi@gmail.com", json_endcode($_REQUEST));
		return;
    	Utility::startSession();
    	$id = Yii::$app->user->id;
		$transacs = $_SESSION['merchant_ref'];
		$transac = (isset($_REQUEST['transaction_id']) && !empty($_REQUEST['transaction_id']))? $_REQUEST['transaction_id']: null;
		$reply = "";
		
		$amount = $_SESSION['sms_amt'];
			$resp = Gateway::query($transac);
			
		$mailer = Yii::$app->mailer;
        $subject = json_encode($resp);
        $email = "rasheedsaidi@gmail.com";
        $result = $mailer->compose('signup_success')
            ->setTo($email)
            ->setSubject($subject)
            ->send();
		if($transac != null) {
			$trans = Voguepay::find()->where(['transaction_id' => $transac])->andWhere(['status' => 'Approved'])->one();
			if($trans)
			{
				$reply = 'error';
				$payment_url = urldecode(Url::toRoute(['/site/payment']));
    		Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-info">
        This transaction regarding the transaction number: ' . $transac . ' is complete. Please contact the administrator for details of Transaction Log for the Status of this transaction ' . $transac . '. <a href="' . $payment_url . '">Click here</a> to go back.
    </div>');
    		exit;
			}
			
			$amount = $_SESSION['sms_amt'];
			$resp = Gateway::query($transac);
			
			Gateway::updateVoguepay($resp);
			
			if($resp['total'] == 0)die('Invalid total');
			if($resp['status'] != 'Approved')die('Failed transaction');
			if($resp['merchant_id'] != $merchant_id)die('Invalid merchant');
			
			$type = $_SERVER['sms_type'];
			$price = Utility::getPrice($amount, $type);
		    	$credit = Credit::find()->where(['user_id' => $id])->andWhere(['type' => $type])->andWhere(['price_id' => $price['id']])->one();
		    		    	
		    	//$new_credit = (float) $amount * (float) $price->price;
		    	
		    	if(!$credit) {    		
			    	$credit = new Credit();
			    	$credit->user_id = $id;
			    	$credit->amount = $amount;
			    	$credit->price_id = $price['id'];
			    	$credit->type = $type;
			    	$credit->created_at = date('Y-m-d H:i:s');
			    	$credit->save(false);
			    	
			    	$credit_log = new CreditLog();
		    		$credit_log->credit = $amount;
		    		$credit_log->user_id = $id;
		    		$credit_log->type = $type;
		    		$credit_log->credit_id = $credit->id;
		    		$credit_log->added_at = date('Y-m-d H:i:s');
		    		$credit_log->save(false);
		    		$resp = 'success';
		    		Yii::$app->session->setFlash("order-success", $resp);
		    		//return $this->redirect(['/site/order_now']);
		    		
		    	} else {	    		
		    		$credit->amount = $credit->amount + $amount;
		    		$credit->save(false);
		    		
		    		$credit_log = new CreditLog();
		    		$credit_log->credit = $amount;
		    		$credit_log->user_id = $id;
		    		$credit_log->type = $type;
		    		$credit_log->credit_id = $credit->id;
		    		$credit_log->added_at = date('Y-m-d H:i:s');
		    		$credit_log->save(false);
		    		//echo 'got_here1';exit;
		    		$resp = 'success';
		    		Yii::$app->session->setFlash("order-success", $resp);
		    		//return $this->redirect(['/site/order_now']);
		    	} 
    			$reply = 'success';
    			Utility::usePIN($data['pin'], $trans_id);
		}	
		
		
		//var_dump($_REQUEST);
		//var_dump($resp);exit;
    }
    
	public function actionTransaction1() { //var_dump($_POST);exit;
		//return true;
    	Utility::startSession();
		$transacs = $_SESSION['transid'];
		$transac = (isset($_REQUEST['transaction_id']) && !empty($_REQUEST['transaction_id']))? $_REQUEST['transaction_id']: null;
		$reply = "";
		if($transac != null) {
			$trans = Transaction::find()->where(['reference' => $transac])->andWhere(['status' => 'Approved'])->one();
			if($trans)
			{
				$reply = 'error';
				$payment_url = urldecode(Url::toRoute(['/site/payment']));
    		Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-info">
        This transaction regarding the transaction number: ' . $transac . ' is complete. Please contact the administrator for details of Transaction Log for the Status of this transaction ' . $transac . '. <a href="' . $payment_url . '">Click here</a> to go back.
    </div>');
			}
		}	
		
		$amount = $_SESSION['sms_amt'];
		$resp = Gateway::query($transac);
		//var_dump($_REQUEST);
		//var_dump($resp);exit;
		
		
		if($resp) {
			
			$reference = $resp['merchant_ref'];
			$email = $resp['email'];
			$amount = $resp['total'];		 
			$status = $resp['status'];
			$description = $resp['memo'];
			$date = $resp['date'];
			
			$type = $_SESSION['sms_type'];
	
			//echo $transac;
			$transaction = Transaction::find()->where(['reference' => $transac])->one();//var_dump($transaction);exit;
			if($transaction) {
				$transaction->date = $date;
				$transaction->email = $email;
				$transaction->description = $description;
				$transaction->amount = $amount;
				$transaction->status = $status;
				$transaction->save(false);
			}
			
			//$pin = Utility::isValidPIN($data['pin'], $amount);
    		if($status == 'Approved') {		    	
		    	
		    	$price = Utility::getPrice($amount, $type);
		    	$credit = Credit::find()->where(['user_id' => $id])->andWhere(['type' => $type])->andWhere(['price_id' => $price['id']])->one();
		    		    	
		    	//$new_credit = (float) $amount * (float) $price->price;
		    	
		    	if(!$credit) {  		
			    	$credit = new Credit();
			    	$credit->user_id = $id;
			    	$credit->amount = $amount;
			    	$credit->price_id = $price['id'];
			    	$credit->type = $type;
			    	$credit->created_at = date('Y-m-d H:i:s');
			    	$credit->save(false);
			    	
			    	$credit_log = new CreditLog();
		    		$credit_log->credit = $amount;
		    		$credit_log->user_id = $id;
		    		$credit_log->type = $type;
		    		$credit_log->credit_id = $credit->id;
		    		$credit_log->added_at = date('Y-m-d H:i:s');
		    		$credit_log->save(false);
		    		$resp = 'success';
		    		Yii::$app->session->setFlash("order-success", $resp);
		    		//return $this->redirect(['/site/order_now']);
		    		
		    	} else {	    		
		    		$credit->amount = $credit->amount + $amount;
		    		$credit->save(false);
		    		
		    		$credit_log = new CreditLog();
		    		$credit_log->credit = $amount;
		    		$credit_log->user_id = $id;
		    		$credit_log->type = $type;
		    		$credit_log->credit_id = $credit->id;
		    		$credit_log->added_at = date('Y-m-d H:i:s');
		    		$credit_log->save(false);
		    		//echo 'got_here1';exit;
		    		$resp = 'success';
		    		Yii::$app->session->setFlash("order-success", $resp);
		    		//return $this->redirect(['/site/order_now']);
		    	} 
    			$reply = 'success';
    			//Utility::updateTransaction($data['pin'], $trans_id);
    			$message_url = urldecode(Url::toRoute(['/message/create']));
    			Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-success">Your sms was added successfully. <a href="' . $message_url . '">Click here</a> to start sending messages.</div>');
    		} else {
    			$payment_url = urldecode(Url::toRoute(['/site/payment']));
    			Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-info">
        We could not verify your payment. Please check your selection and retry. <a href="' . $payment_url . '">Click here</a> to go back.
    </div>');
    		}		
		} else {
			$payment_url = urldecode(Url::toRoute(['/site/payment']));
    		Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-info">
        We could not verify your payment. Please check your selection and retry. <a href="' . $payment_url . '">Click here</a> to go back.
    </div>');
		}
		
		return $this->render('transaction');
    }
    
    public function actionSuccess() { 
    	Utility::startSession();
    	$transacs = $_SESSION['merchant_ref'];
		$transac = (isset($_REQUEST['transaction_id']) && !empty($_REQUEST['transaction_id']))? $_REQUEST['transaction_id']: null;
		$reply = "";
		if($transac != null) {
			$trans = Transaction::find()->where(['reference' => $transac])->andWhere(['status' => 'Approved'])->one();
			if($trans)
			{
				$reply = 'error';
				$payment_url = urldecode(Url::toRoute(['/site/payment']));
    		Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-info">
        This transaction regarding the transaction number: ' . $transac . ' is complete. Please contact the administrator for details of Transaction Log for the Status of this transaction ' . $transac . '. <a href="' . $payment_url . '">Click here</a> to go back.
    </div>');
			}
		}	
		
		$amount = $_SESSION['sms_amt'];
		$resp = Gateway::query($transac);
		$id = Yii::$app->user->id;
		//var_dump($_REQUEST);
		//var_dump($resp);exit;
		
		
		if($resp) {
			
			$reference = $resp['merchant_ref'];
			$email = $resp['email'];
			$amount = $resp['total'];		 
			$status = $resp['status'];
			$description = $resp['memo'];
			$date = $resp['date'];
			
			$type = $_SESSION['sms_type'];
	/*
			//echo $transac;
			$transaction = Transaction::find()->where(['reference' => $transac])->one();//var_dump($transaction);exit;
			if($transaction) {
				$transaction->date = $date;
				$transaction->email = $email;
				$transaction->description = $description;
				$transaction->amount = $amount;
				$transaction->status = $status;
				$transaction->save(false);
			}
			
			$pin = Utility::isValidPIN($data['pin'], $amount);
    		if($status == 'Approved') {		    	
		    	
		    	$price = Utility::getPrice($amount, $type);
		    	$credit = Credit::find()->where(['user_id' => $id])->andWhere(['type' => $type])->andWhere(['price_id' => $price['id']])->one();
		    		    	
		    	//$new_credit = (float) $amount * (float) $price->price;
		    	
		    	if(!$credit) {  		
			    	$credit = new Credit();
			    	$credit->user_id = $id;
			    	$credit->amount = $amount;
			    	$credit->price_id = $price['id'];
			    	$credit->type = $type;
			    	$credit->created_at = date('Y-m-d H:i:s');
			    	$credit->save(false);
			    	
			    	$credit_log = new CreditLog();
		    		$credit_log->credit = $amount;
		    		$credit_log->user_id = $id;
		    		$credit_log->type = $type;
		    		$credit_log->credit_id = $credit->id;
		    		$credit_log->added_at = date('Y-m-d H:i:s');
		    		$credit_log->save(false);
		    		$resp = 'success';
		    		Yii::$app->session->setFlash("order-success", $resp);
		    		//return $this->redirect(['/site/order_now']);
		    		
		    	} else {	    		
		    		$credit->amount = $credit->amount + $amount;
		    		$credit->save(false);
		    		
		    		$credit_log = new CreditLog();
		    		$credit_log->credit = $amount;
		    		$credit_log->user_id = $id;
		    		$credit_log->type = $type;
		    		$credit_log->credit_id = $credit->id;
		    		$credit_log->added_at = date('Y-m-d H:i:s');
		    		$credit_log->save(false);
		    		//echo 'got_here1';exit;
		    		$resp = 'success';
		    		Yii::$app->session->setFlash("order-success", $resp);
		    		//return $this->redirect(['/site/order_now']);
		    	} 
    			$reply = 'success';
    			*/
    			//Utility::updateTransaction($data['pin'], $trans_id);
				
		$transaction = Transaction::find()->where(['reference' => $transac])->one();//var_dump($transaction);exit;
			if($transaction) {
				$transaction->date = $date;
				$transaction->email = $email;
				$transaction->description = $description;
				$transaction->amount = $amount;
				$transaction->status = $status;
				$transaction->save(false);
			}
			
			//$pin = Utility::isValidPIN($data['pin'], $amount);
    		if($status == 'Approved') {		    	
		    	
		    	$price = Utility::getPrice($amount, $type);
		    	
		    	
		    	$credit = Credit::find()->where(['user_id' => $id])->andWhere(['type' => $type])->andWhere(['price_id' => $price['id']])->one();
		    		    	
		    	//$new_credit = (float) $amount * (float) $price->price;
		    	//var_dump(!$credit);exit;
		    	if(!$credit) {
		    		$price_id = (!$price)? Utility::DEFAULT_PRICE_ID: $price['id'];		
			    	$credit = new Credit();
			    	$credit->user_id = $id;
			    	$credit->amount = $amount;
			    	$credit->price_id = $price_id;
			    	$credit->type = $type;
			    	$credit->created_at = date('Y-m-d H:i:s');
			    	$credit->save(false);
			    	
			    	$credit_log = new CreditLog();
		    		$credit_log->credit = $amount;
		    		$credit_log->user_id = $id;
		    		$credit_log->type = $type;
		    		$credit_log->credit_id = $credit->id;
		    		$credit_log->added_at = date('Y-m-d H:i:s');
		    		$credit_log->save(false);
		    		$resp = 'success';
		    		Yii::$app->session->setFlash("order-success", $resp);
		    		//return $this->redirect(['/site/order_now']);
		    		
		    	} else {	    		
		    		$credit->amount = $credit->amount + $amount;
		    		$credit->save(false);
		    		
		    		$credit_log = new CreditLog();
		    		$credit_log->credit = $amount;
		    		$credit_log->user_id = $id;
		    		$credit_log->type = $type;
		    		$credit_log->credit_id = $credit->id;
		    		$credit_log->added_at = date('Y-m-d H:i:s');
		    		$credit_log->save(false);
		    		//echo 'got_here1';exit;
		    		$resp = 'success';
		    		Yii::$app->session->setFlash("order-success", $resp);
		    		//return $this->redirect(['/site/order_now']);
		    	} 
    			$reply = 'success';
    			//Utility::updateTransaction($data['pin'], $trans_id);
    			$message_url = urldecode(Url::toRoute(['/message/create'], true));
    			$msg = 'Your sms was added successfully. <a href="' . $message_url . '">Click here</a> to start sending messages.';
    			Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-success">' . $msg . '</div>');
    		} else {
    			$payment_url = urldecode(Url::toRoute(['/site/payment'], true));
    			$msg = 'We could not verify your payment. Please check your selection and retry. <a href="' . $payment_url . '">Click here</a> to go back.';
    			Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-info">' . $msg . '</div>');
    		}
    		
		} else {
    			$payment_url = urldecode(Url::toRoute(['/site/payment'], true));
    			$msg = 'We could not verify your payment. Please check your selection and retry. <a href="' . $payment_url . '">Click here</a> to go back.';
    			Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-info">' . $msg . '</div>');
    		}
    	$user = Utility::getUser($id); //var_dump($user);
		Utility::sendSimpleEmail("Payment Response", $user['email'], $msg);
    	return $this->render('success');
    }
    
	public function actionFailed() { 
		Utility::startSession();
		$id = Yii::$app->user->id;
    	$transacs = $_SESSION['merchant_ref'];
		$transac = (isset($_REQUEST['transaction_id']) && !empty($_REQUEST['transaction_id']))? $_REQUEST['transaction_id']: null;
		$reply = "";
		if($transac != null) {
			$trans = Transaction::find()->where(['reference' => $transac]);
			if($trans)
			{
				$reply = 'error';
				$payment_url = urldecode(Url::toRoute(['/site/payment'], true));
    		Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-info">
        This transaction regarding the transaction number: ' . $transac . ' is complete. Please contact the administrator for details of Transaction Log for the Status of this transaction ' . $transac . '. <a href="' . $payment_url . '">Click here</a> to go back.
    </div>');
			}
		}	
		
		$amount = $_SESSION['sms_amt'];
		$resp = Gateway::query($transac);
		//var_dump($_REQUEST);
		//var_dump($resp);exit;
		
		
		if($resp) {
			
			$reference = $resp['merchant_ref'];
			$email = $resp['email'];
			$amount = $resp['total'];		 
			$status = $resp['status'];
			$description = $resp['memo'];
			$date = $resp['date'];
			
			$type = $_SESSION['sms_type'];	
			
		$transaction = Transaction::find()->where(['reference' => $transac])->one();//var_dump($transaction);exit;
			if($transaction) {
				$transaction->date = $date;
				$transaction->email = $email;
				$transaction->description = $description;
				$transaction->amount = $amount;
				$transaction->status = $status;
				$transaction->save(false);
			}
			
    			//Utility::updateTransaction($data['pin'], $trans_id); 
    			//echo $status;exit; 
			if($status) {	// == 'Failed') {
    			$message_url = urldecode(Url::toRoute(['/message/create'], true));
    			$payment_url = urldecode(Url::toRoute(['/site/payment'], true));
    			$msg = 'Your sms transaction failed with the status: ' . $status . '. Please <a href="' . $payment_url . '">Click here</a> to go back.';
    			Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-danger">' . $msg . '</div>');
    		} else {
    			$payment_url = urldecode(Url::toRoute(['/site/payment'], true));
    			$msg = 'We could not verify your payment. Please check your selection and retry. <a href="' . $payment_url . '">Click here</a> to go back.';
    			Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-info">' . $msg . '</div>');
    		}		
		} else {
			if($reply != 'error') {
				$payment_url = urldecode(Url::toRoute(['/site/payment'], true));
				$msg = 'We could not verify your payment. Please check your selection and retry. <a href="' . $payment_url . '">Click here</a> to go back.';
    			Yii::$app->session->setFlash('payment_reply', '<div class="alert alert-info">' . $msg . '</div>');
			}
		}
		$user = Utility::getUser($id); //var_dump($user);
		Utility::sendSimpleEmail("Payment Response", $user['email'], $msg);
    	return $this->render('failed');
    }
    	
}
