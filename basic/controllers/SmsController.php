<?php

namespace app\controllers;

use app\models\Schedule;

use app\models\MessageLog;

use app\models\Utility;

use amnah\yii2\user\models\forms\LoginForm;

use yii\filters\AccessControl;

use Yii;
use app\models\Message;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use amnah\yii2\user\models\User;

/**
 * SmsController implements the CRUD actions for Message model.
 */
class SmsController extends Controller
{
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
        		'rules' => [
                    [
                        'actions' => ['send', 'tos', 'privacy', 'get_credit'],
                        'allow'   => true,
                        'roles'   => ['?', '@'],
                    ],
                    [
                        'actions' => ['', 'add_to_cart', 'payment_option'],
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
                ],
            ],
        ];
    }
    
	public function beforeAction($action)
	{            
	    if ($action->id == 'send' || $action->id == 'get_credit') {
	        $this->enableCsrfValidation = false;
	    }
	
	    return parent::beforeAction($action);
	}

    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Message::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSend($sender="", $user="", $password="", $to="", $msg="", $profile="", $type=0) 
    {
    	//echo $sender.$user.$password.$to.$msg.$profile;exit;
    	$model = new LoginForm();
    	$login = ["LoginForm" => ["username" => $user, "password" => $password]]; 
    	//$post = Yii::$app->request->();
    	//echo json_encode($login);exit;
    	if($to == "") {
    		echo json_encode(['error' => 'Destination mobile no is required.']);
    		exit;
    	} 
    	if($msg == "") {
    		echo json_encode(['error' => 'Message is empty.']);
    		exit;
    	}
    	if($profile == "") {
    		echo json_encode(['error' => 'Profile value is required.']);
    		exit;
    	} 
    	$model->load($login);
        if ($model->validate()) {
        	$sms = new Message();
	        $sms_log = new MessageLog();
	        $schedule = new Schedule();
        	//echo json_encode(['success' => "User details correct"]);
        	//$duser = (new \yii\db\Query())->from('user')->where('user.username =\'' . $user . '\'')->all();
        	$duser = User::find()->where(['username' => $user])->one();
        	//echo 'got'.json_encode($duser);exit;
        	$user_id = $duser->id;
        	//echo json_encode($user_id);exit;
        	$sms->body = $msg;
			//$sms_length = isset($sms['length']) ? intval($sms['length']) : 1;
        	$sms_length = strlen($msg);
			$sms->user_id = $user_id;
			$sms->length = $sms_length;
			$sms->type = $type;
			$sms->created_at = date('Y-m-d H:i:s');
        	$sms->save();
        	$sms_id = $sms->id;
        	
        	$sms_log->mobile_no = Utility::padNumber(trim($to));
        	$sms_log->message_id = $sms_id;
        	$sms_log->sent_at = date('Y-m-d H:i:s');
        	$sms_log->country = 'Nigeria';
        	$sms_log->user_id = $user_id;
        	//$sms_log->status = "PENDING";
        	//$sending_profile = $_POST['sending_profile'];
        	
        	$current_price = (float) Utility::getCurrentPrice($profile, $sms_length, $user_id, 1);
	        if($current_price == 0) {
	    		echo json_encode(['error' => 'Insufficient credit to send messages.']);
	    		exit;
	    	}	    	        	     
        	
        	// Grab the credit
        	// $credit = new
        	//$type = 0;
        	$responses = Utility::sendSMSAPI($user_id, $sender, $msg, $to, $type, $profile);
        	//var_dump($responses);
			if($responses) {
				$sms_log->credit_used = $current_price;
	        	$sms_detail = array(
	        		'sender' => isset($sender) ? trim($sender) : 'SMS',
	        		'mobile' => isset($to) ? trim($to) : null,
	        		'body' => isset($msg) ? trim($msg) : "",
	        		'profile' => $profile,
	        	);  
				//echo $sender. $sms_detail['sender'];
	        	Utility::deductCredit($profile, $current_price);
	        	$sms_log->sender_id = $sms_detail['sender'];
				$sms_log->sms_return_id = isset($responses[2])? $responses[2]: null;
				$sms_log->status = isset($responses[0])? $responses[0]: "PENDING";
				$sms_log->save(false);
				
				echo json_encode(['success' => "Message successfully sent."]);
	        	exit;
			} else {
				echo json_encode(['error' => "Error occured while sending your message."]);
        		exit;
			}
        	
        } else {
        	echo json_encode(['error' => "Invalid username or password"]);
        	exit;
        }
    }

    public function actionGet_credit($user="", $password="", $profile="") 
    {    	
    	$model = new LoginForm();
    	$login = ["LoginForm" => ["username" => $user, "password" => $password]]; 
    	//$post = Yii::$app->request->();
    	//echo json_encode($login);exit;
    	$model->load($login);
        if ($model->validate()) {
        	//$duser = (new \yii\db\Query())->from('user')->where('user.username =\'' . $user . '\'')->all();
        	$user = User::find()->where(['username' => $user])->one();
        	//echo 'got'.json_encode($duser);exit;
        	$user_id = $user->id;
        	$credits = Utility::getUserCredit($user_id);
        	if($credits) {
        		$ar = array();
        		foreach($credits as $credit) {
        			$ar[] = array(
        				'amount' => $credit['amount'],
        				'unit_price' => Utility::getUnitPrice($credit['price_id']),
        				'profile' => $credit['id']
        			);
        		}
        		return json_encode(array('status' => 'SUCCESS', 'credit' => $ar));
        	}
        }
        return json_encode(array('status' => 'ERR'));
    }
    
    /**
     * Displays a single Message model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Message();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
