<?php
namespace app\controllers;

use yii\helpers\Url;

use app\models\Utility;

use amnah\yii2\user\models\Profile;

use app\models\Credit;

use app\models\Picture;
use yii\web\UploadedFile;
use app\models\Instagram;

use amnah\yii2\user\models\User;
use app\models\Facebook;
use app\models\BankInformation;
use app\models\Service;
use app\models\Influencer;
use app\models\Advertiser;
use app\models\ContactForm;
use Yii;
use linslin\yii2\curl;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use amnah\yii2\user\controllers\DefaultController as SuperDefault;

class DefaultController extends SuperDefault {
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'confirm', 'resend', 'logout', 'reg_resp'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['account', 'profile','contact', 'resend-change', 'cancel','advertiser_dashboard','influencer_dashboard', 'influenza_info', 'advertiser', 'reg_confirmation', 'connect_instagram', 'add_picture', 'advertiser_info'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'register','contact','influencer_dashboard', 'advertiser_dashboard','register_advert','forgot', 'reset', 'login-email', 'login-callback', 'signup_influenza', 'signup_advertiser'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    /**
     * Display registration page
     */
    public function actionRegister()
    {
        /** @var \amnah\yii2\user\models\User $user */
        /** @var \amnah\yii2\user\models\Profile $profile */
        /** @var \amnah\yii2\user\models\Role $role */

    	$this->layout = '@app/views/layouts/login';
        // set up new user/profile objects
        $user = $this->module->model("User", ["scenario" => "register"]);
        $profile = $this->module->model("Profile");
        
        // load post data
        $post = Yii::$app->request->post();
        
        if ($user->load($post)) {
			//$user->email = $post['User']['username'];
            // ensure profile data gets loaded
            $profile->load($post);

            // validate for ajax request
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($user, $profile);
            }

            // validate for normal request
            if ($user->validate() && $profile->validate()) {

                // perform registration
                $role = $this->module->model("Role");
                $user->setRegisterAttributes($role::ROLE_USER, $user::STATUS_ACTIVE)->save();
                $profile->setUser($user->id)->save();
                $this->afterRegister($user);
                $data = array('username' => $user->username, 'full_name' => $profile->full_name, 'subject' => "Registration Confirmation");
                Utility::sendEmail("Registration Confirmation", $user->email, "signup_success", $data);
                //Utility::sendStandardSMS(SpeedySMS, "Thank you for", $mobile, $type, $profile)

                // set flash
                // don't use $this->refresh() because user may automatically be logged in and get 403 forbidden
                $successText = "Dear " . $user->getDisplayName() . ", you have successfully registered on SpeedySMS - The fast and reliable SMS service. Please check your email for information on how to get started. Or click help links for more information.";
                //echo 'Got: ' . $successText;exit;
                $guestText = "";
                if (Yii::$app->user->isGuest) {
                    $guestText = Yii::t("user", " - Please check your email to confirm your account");
                }
                Yii::$app->session->setFlash("Register-success", $successText);
                return $this->redirect(['/user/reg_resp']);
            }
        }

        return $this->render("register", compact("user", "profile"));
    }
    
	/**
     * Display login page
     */
    public function actionLogin()
    {
        /** @var \amnah\yii2\user\models\forms\LoginForm $model */
        $model = $this->module->model("LoginForm");
        var_dump(Credit::find()->all());exit;
        $this->layout = '@app/views/layouts/login';
        // load post data and login
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) { //var_dump($model);exit;
        	$returnUrl = $this->performLogin($model->getUser(), $model->rememberMe);
        	//echo $returnUrl;exit;
            return $this->redirect($returnUrl);
        	//$url = urldecode(Url::toRoute(['/message/create']));
        	//return $this->redirect(['/message/create'], compact("model"));
        	//return $this->goBack($url);
            //$returnUrl = $this->performLogin($model->getUser(), $model->rememberMe);
            //return $this->redirect(['/message/create'], compact("model"));
            //return $this->redirect($returnUrl);
        }

        return $this->render('login', compact("model"));
    }
    
	public function actionReg_resp()
    {        
    	$this->layout = '@app/views/layouts/login';
        return $this->render('reg_resp');
    }
    
}