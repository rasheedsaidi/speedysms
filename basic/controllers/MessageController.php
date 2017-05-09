<?php

namespace app\controllers;

use app\models\SentMessage;

use yii\helpers\Url;

use yii\helpers\Html;

use yii\filters\AccessControl;

use app\models\Contact;

use app\models\Utility;

use app\models\MessageLog;

use app\models\Bulk;

use app\models\Group;

use app\models\BulkFile;

use app\models\Schedule;
use app\models\Sender;

use Yii;
use app\models\Message;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use alexgx\phpexcel;
use moonland\phpexcel1;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
{
    public function behaviors()
    {
    	return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['freesms', 'scheduler'],
                        'allow'   => true,
                        'roles'   => ['?', '@'],
                    ],
                    [
                        'actions' => ['create', 'bulk', 'group', 'index', 'logout', ],
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
    
    public function actionScheduler() {
		$now = date('Y-m-d H:i:s');
		//$schedules1 = Schedule::find()->select('`scheduled_datetime`')->where(['<=', '`scheduled_datetime`', $now])->asArray()->all();var_dump($schedules1);
		$schedules = Schedule::find()->where(['<=', '`scheduled_datetime`', $now])->asArray()->andWhere(['status' => 0])->all();
		//$schedules = Schedule::find()->where(['<=', '`scheduled_date`', 'DATE(NOW())'])->andWhere(['<=', '`scheduled_time`', 'TIME(NOW())'])->andWhere(['status' => 0])->all();
		//echo date('Y-m-d H:i:s');
		$subject = "Scheduled SMS Sent :: SpeedySMS";
		$view_url = urldecode(Url::toRoute(['/site/help'], true));		
		//var_dump($schedules);
		
		if($schedules && !empty($schedules)) {
			foreach($schedules as $schedule) {
				$message = Message::findOne($schedule['message_id']); //var_dump($message->profile);				
				if($message) {
					$user = Utility::getUser($message['user_id']); //var_dump($user);
					$service = Utility::getProfileType($message['user_id'], $message->profile);
					if($message->mode == 'single') {
						Utility::sendSingle($message, $message->profile, $message['user_id']);
					} else if($message->mode == 'group') {
						$group_nos = Contact::find()->where(['group_id' => $message->recipient])->asArray()->all();
						if($group_nos && !empty($group_nos)) {
							$paddedNos = Utility::getNoGroup($group_nos, intval($message->personalised));
							if(intval($message->personalised) == 1) {
								Utility::sendPersonalized($message, $message->profile, $group_nos, $message['user_id']);
							} else {
								Utility::sendBulk($message, $message->profile, $paddedNos, $message['user_id']);
							}
						}
					} else if($message->mode == 'bulk') {
						$bulk = Bulk::findOne($message->recipient);
						if($bulk) {
							$bulknos = $this->loadNumbers($bulk->name, intval($message->personalised));
							$paddedNos = Utility::getNoBulk($bulknos);
							if(intval($message->personalised) == 1) {
								Utility::sendPersonalized($message, $message->profile, $bulknos);
							} else {
								Utility::sendBulk($message, $message->profile, $paddedNos, $message['user_id']);
							}
						}	
					}
					
					$sch = Schedule::findOne($schedule['id']);
					$sch->status = 1;
					$sch->started_at = date('Y-m-d H:i:s');
					$sch->save(false);
					
					$body = '<div><h4>Dear ' . $user['full_name']. ',</h4>';
					$body .= '<p>Your message which you scheduled for ' . $schedule['scheduled_date'] . ' and ' . $schedule['scheduled_time'] . ' has been sent.</p>';
					$body .= '<p>Please <a href="' . $view_url . '">click here</a> to view the report.</p>';
					$body .= '<p>Thank you for choosing SpeedySMS</p>';
					$body .= '<h4>From: SpeedySMS Team</h4></div>';
					//echo $body;echo $user['email'];exit;
					$data = array();
					$data['name'] = $user['full_name'];
					$data['subject'] = $subject;
					$data['email'] = $user['email'];
					$data['scheduled_date'] = $schedule['scheduled_date'];
					$data['scheduled_time'] = $schedule['scheduled_time'];
					Utility::sendEmail($subject, $user['email'], 'scheduleAlert', $data);
				}				
			}
		}    	
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sms = new Message();
        $sms_log = new MessageLog();
		
    	if (Yii::$app->request->isAjax) {    		
        	//\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    		if (Yii::$app->user->isGuest) {
	        	echo json_encode('Please login with your account to send SMS');	        	
	        	exit;
        	}
        	if (!($sms->load(Yii::$app->request->post()))) {
        		$data_log = \Yii::$app->request->post('MessageLog', []);
	        	echo json_encode('Please fill in all fields');	        	
	        	exit;
        	}
		}
        
        if ($sms->load(Yii::$app->request->post())) {
        	$sms_log->load(Yii::$app->request->post());
        	$data = \Yii::$app->request->post('Message', []);
        	$data_log = \Yii::$app->request->post('MessageLog', []);
        	$post = \Yii::$app->request->post();
        	
        	// Set and save Message
			$sms->body = isset($sms['body']) ? $sms['body'] : null;
			$profile = $_POST['sending_profile'];
			$sms_length = ($sms['type'] == '2' || $sms['type'] == '6') ? strlen(Utility::sms__unicode($sms['body'])) : $sms['length'];
			$s_credit_used = (float) Utility::getCurrentPrice($profile, $sms_length, Yii::$app->user->id, 1);
			$sms->user_id = Yii::$app->user->id;
			$sms->created_at = date('Y-m-d H:i:s');
			$sms->length = $sms_length;
			$sms->mode = "single";
			$sms->recipient = Utility::padNumber($data['recipient']);
			$sms->sender_id = $data['sender_id'];			
			//$sms->scheduled = ($data['scheduled'] == 'yes')? 1: 0;
			$sms->credit = $s_credit_used;
			$sms->profile = $profile;
			$sms->type = $data['type'];
			
        	$sms->save(); 
        	//echo $s_credit_used;exit;
        	
        	if (intval($post['save_message']) == 1) {
        		$save = new SentMessage();
        		$save->user_id = Yii::$app->user->id;
        		$save->title = substr($sms['body'], 0, 100);
        		$save->body = $sms['body'];
        		$save->posted_at = date('Y-m-d H:i:s');
        		$save->save(false);
        	}
        	
        	if(!Utility::isCreditEnough($profile, $s_credit_used)) {
		        		$session = Yii::$app->session;
        				$session->setFlash('smsSent', 'Insufficient credit to send messages.');
		        		return $this->render('create', [
			                'message' => $sms,
			            	'message_log' => $sms_log
			            ]);
		    }
			
			$s = intval($data['scheduled']); //var_dump($s);exit;
	        	if (intval($s) == 1) {
					$dates = $_POST['scheduled_date'];
					$times = $_POST['scheduled_time'];
					//for($i =0; $i < count($dates); $i++) {
						$schedules = array();
					foreach($dates as $key=>$date) {
						$date_split = explode('-', $dates[$key]);
						$year = $date_split[2];
						$month = $date_split[1];
						$day = $date_split[0];
						
						$time_split = explode(':', $times[$key]);
						$hour = $time_split[0];
						$minute = $time_split[1];
						$second = $time_split[2]; //print_r($_POST);
						//print_r($time_split);exit;
						$schedules[$key] = array('date' => $dates[$key], 'time' => $times[$key]);
						$schedule = new Schedule();
						$schedule->message_id = $sms->id;
						$schedule->year = $year;
						$schedule->month = $month;
						$schedule->day = $day;
						$schedule->hour = $hour;
						$schedule->minute = $minute;
						$schedule->second = $second;
						$schedule->scheduled_date = date('Y-m-d', strtotime($dates[$key]));
						$schedule->scheduled_time = $times[$key];
						$datetime = date('Y-m-d', strtotime($dates[$key])) . ' ' . $times[$key];
						$schedule->scheduled_datetime = $datetime;
						$schedule->status = 0;
						$schedule->started_at = null;
						$schedule->created_at = date('Y-m-d H:i:s');
						$schedule->save(false);  
					}
					
					$session = Yii::$app->session;
					$msg = '<p>Your message has been scheduled as follows:</p><p><ul>';
					foreach($schedules as $sched) {
						$msg .= '<li>Date: ' . $sched['date'] . ', Time: ' . $sched['time'] . '</li>';
					}
					$msg .= '</ul></p>';
					$session->setFlash('smsSent', $msg);
					//return $this->redirect(['view', 'id' => $sms->id]);
					//return $this->refresh('#success');
					$sms = new Message();
					return $this->render('create', [
						'model' => $sms,
						'schedules' => array($schedules)
					]);
		        	
		        	//var_dump($schedule);exit; INSERT INTO  schedule (message_id,  started_at) VALUES (2, '2015-30-14 7:30:41')
	        	}
        	//
        	$sms_id = $sms->id;        	
        	$resp = Utility::sendSingle($sms, $profile);
        	
        	if(!$resp) {
        		$session = Yii::$app->session;
	        	$session->setFlash('smsSent', 'Error encountered while sending your SMS. Please retry or contact the admin.');
	            //return $this->redirect(['view', 'id' => $sms->id]);
	            //return $this->refresh('#success');
	            return $this->render('create', [
                'model' => $sms,
            ]);
        	}
        	
			if (Yii::$app->request->isAjax) {    		
	        	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	        	return json_encode('Your message has successfully been sent to ' . $data['recipient']);
	        	exit;
			}
        	$session = Yii::$app->session;
        	$session->setFlash('smsSent', 'Your message has successfully been sent to ' . $data['recipient'] . '.');
            //return $this->redirect(['view', 'id' => $sms->id]);
            //return $this->refresh('#success');
            $sms = new Message();
            return $this->render('create', [
                'model' => $sms,
            ]);
        } else {
        	if (Yii::$app->request->isAjax) {    		
	        	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	        	return json_encode('Error sending the message.Please retry.');
	        	exit;
			}
            return $this->render('create', [
                'model' => $sms,
            	'model_log' => $sms_log,
            ]);
        }
    }
    
	public function actionFreesms()
    {
    	
        $sms = new Message();
        $sms_log = new MessageLog();
		
    	if (Yii::$app->request->isAjax) { 
    		 		
        	//\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    		if (Yii::$app->user->isGuest) {
    			$login_url = urldecode(Url::toRoute(['/user/login'], true));
	        	return ('Please <a href="' . $login_url . '">click here</a> to login with your account to send SMS');
        	}
        	$count = MessageLog::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['like', 'sent_at', date('Y-m-d')])->andWhere(['free' => '1'])->count();
        	//return $count;
        	
        	$total_count = MessageLog::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['free' => '1'])->count();
        	//exit();
        	if($count >= 1) {
        		return ('Sorry, you\'ve already sent a FREE SMS today. To send more SMS, please purchase credit.');  
        		exit;      		
        	}        	
        	
    		if($total_count > 10) {
        		return json_encode('Sorry, you\'ve reach the FREE SMS limit of 10 messages. To send more SMS, please purchase credit.');
        	}
        	
        	if (!($sms->load(Yii::$app->request->post()))) {        		
	        	return ('Please fill in all fields');
        	} 
		
        	$data = \Yii::$app->request->post('Message', []);
        	//return Utility::padNumber($data['recipient']);exit;
        	// Set and save Message
			$sms->body = isset($sms['body']) ? $sms['body'] : null;
			$profile = 1;	//$_POST['sending_profile'];
			$sms_length = ($sms['type'] == '2' || $sms['type'] == '6') ? strlen(Utility::sms__unicode($sms['body'])) : $sms['length'];
			$s_credit_used = (float) Utility::getCurrentPrice($profile, $sms_length, Yii::$app->user->id, 1);
			$sms->user_id = Yii::$app->user->id;
			$sms->created_at = date('Y-m-d H:i:s');
			$sms->length = $sms_length;
			$sms->mode = "single";
			$sms->recipient = Utility::padNumber($data['recipient']);
			$sms->sender_id = trim(substr($data['sender_id'], 0, 10));
			//$sms->scheduled = ($data['scheduled'] == 'yes')? 1: 0;
			$sms->credit = $s_credit_used;
			$sms->profile = $profile;
			$sms->type = 0;
        	$sms->save();   
        	
        	$sms_log->credit_used = '0.00'; //(float) Utility::getCurrentPrice($sending_profile, $sms_length);
        	        	
        	
    	$sms_log = new MessageLog();
    	$sms_log->mobile_no = $sms->recipient;
        $sms_log->message_id = $sms->id;
        $sms_log->sent_at = date('Y-m-d H:i:s');
        $sms_log->country = 'Nigeria';
        $sms_log->user_id = Yii::$app->user->id;
        $sms_log->status = "PENDING";
        $sms_log->free = "1";
        $sending_profile = $profile;
        $sms_log->credit_used = (float) Utility::getCurrentPrice($profile, $sms->length, Yii::$app->user->id, 1);
               	
    	//$responses = Utility::sendSMS($sms->sender_id, $sms->body, $sms->recipient, $sms->type, $profile);
    	$responses = Utility::sendStandardSMS($sms->sender_id, $sms->body, $sms->recipient, $sms->type, $profile);
        	
		if($responses) {
			Utility::deductCredit($profile, $sms->credit);
	        $sms_log->sender_id = $sms->sender_id;
			$sms_log->sms_return_id = isset($responses[2])? $responses[2]: null;
			$sms_log->status = isset($responses[0])? $responses[0]: "PENDING";
			$sms_log->save();
			return ('Your message has successfully been sent to ' . $sms->recipient);
			$sms = $sms_log = null;
			
			exit;
		} else {
			return ('Error sending the message to ' . $sms_detail['mobile'] . '. Please retry.');
			exit;
		}
					
        } else { 
	        return ('Error sending the message.Please retry.');
	        exit;
        }
    }
    
	/**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionBulk()
    {
        $sms = new Message();
        $sms_log = new MessageLog();
        $schedule = new Schedule();
        $numbers = new BulkFile();
		
        //if ($message->load(Yii::$app->request->post()) && $schedule->load(Yii::$app->request->post())) {
        if (Yii::$app->request->post()) {
        	//$bulkfile = \Yii::$app->request->post('BulkFile', []);
        	$load_sms = $sms->load(Yii::$app->request->post());
            $load_sms_log = $sms_log->load(Yii::$app->request->post());
            
        	
        	$numbers->numbersFile = UploadedFile::getInstance($numbers, 'numbersFile');
            if ($numbers->upload()) {
                $bulk = new Bulk();
                $bulk->user_id = Yii::$app->user->id;
	            $bulk->name = $numbers->numbersFile->name;
	            $bulk->ext = $numbers->numbersFile->extension;
	            $bulk->created_at = date('Y-m-d H:i:s');	            
	            $bulk->save(false);
            } else {
            	$session = Yii::$app->session;
        				$session->setFlash('smsSent', 'No file containing numbers selected.');
		        		return $this->render('bulk', [
			                'message' => $sms,
			            	'schedule' => $schedule,
			            	'numbers' => $numbers,
			            ]);
            }                      
            
	        if (isset($bulk) && $bulk->id) {	
		        if ($load_sms) {
					$data = \Yii::$app->request->post('Message', []);
		        	$data_log = \Yii::$app->request->post('MessageLog', []);
		        	$post = \Yii::$app->request->post();
					
		        	$bulknos = $this->loadNumbers($numbers->numbersFile->name, intval($data['personalised']));	
					
		        	if(!$bulknos) {
		        		$session = Yii::$app->session;
        				$session->setFlash('smsSent', 'No file containing numbers selected.');
		        		return $this->render('bulk', [
			                'message' => $sms,
			            	'message_log' => $sms_log,
			            	'schedule' => $schedule,
			            	'numbers' => $numbers,
			            ]);
		        	}
		        	
		        	
		        	// Set and save Message
					$sms->body = isset($sms['body']) ? $sms['body'] : null;
					$profile = $_POST['sending_profile'];
					$sms_length = ($sms['type'] == '2' || $sms['type'] == '6') ? strlen(Utility::sms__unicode($sms['body'])) : $sms['length'];
					$s_credit_used = (float) Utility::getCurrentPrice($profile, $sms_length, Yii::$app->user->id, count($bulknos));
					$sms->user_id = Yii::$app->user->id;
					$sms->created_at = date('Y-m-d H:i:s');
					$sms->length = $sms_length;
					$sms->mode = "bulk";
					$sms->recipient = $bulk->id;
					$sms->sender_id = trim(substr($data['sender_id'], 0, 10));
					$sms->personalised = intval($data['personalised']);
					$sms->scheduled = intval($data['scheduled']);
					$sms->credit = $s_credit_used;
					$sms->profile = $profile;
					$sms->type = $data['type'];
		        	$sms->save(); 					
		        	
		        	$paddedNos = Utility::getNoBulk($bulknos, intval($data['personalised']));
		        	
		        if (intval($post['save_message']) == 1) {
        		$save = new SentMessage();
        		$save->user_id = Yii::$app->user->id;
        		$save->title = substr($sms['body'], 0, 100);
        		$save->body = $sms['body'];
        		$save->posted_at = date('Y-m-d H:i:s');
        		$save->save(false);
        	}
		        	
		        	if(!Utility::isCreditEnough($profile, $s_credit_used)) {
		        		$session = Yii::$app->session;
        				$session->setFlash('smsSent', 'Insufficient credit to send messages.');
		        		return $this->render('bulk', [
			                'message' => $sms,
			            	'message_log' => $sms_log,
			            	'schedule' => $schedule,
			            	'numbers' => $numbers,
			            ]);
		        	}
					
				
        		$s = intval($data['scheduled']); //var_dump($s);exit;
	        	if (intval($s) == 1) {
					$dates = $_POST['scheduled_date'];
					$times = $_POST['scheduled_time'];
					//for($i =0; $i < count($dates); $i++) {
						$schedules = array();
					foreach($dates as $key=>$date) {
						$date_split = explode('-', $dates[$key]);
						$year = $date_split[2];
						$month = $date_split[1];
						$day = $date_split[0];
						
						$time_split = explode(':', $times[$key]);
						$hour = $time_split[0];
						$minute = $time_split[1];
						$second = $time_split[2]; //print_r($_POST);
						//print_r($time_split);exit;
						$schedules[$key] = array('date' => $dates[$key], 'time' => $times[$key]);
						$schedule = new Schedule();
						$schedule->message_id = $sms->id;
						$schedule->year = $year;
						$schedule->month = $month;
						$schedule->day = $day;
						$schedule->hour = $hour;
						$schedule->minute = $minute;
						$schedule->second = $second;
						$schedule->scheduled_date = date('Y-m-d', strtotime($dates[$key]));
						$schedule->scheduled_time = $times[$key];
						$datetime = date('Y-m-d', strtotime($dates[$key])) . ' ' . $times[$key];
						$schedule->scheduled_datetime = $datetime;
						$schedule->status = 0;
						$schedule->started_at = null;
						$schedule->created_at = date('Y-m-d H:i:s');
						$schedule->save(false);  
					}
					
					$session = Yii::$app->session;
					$msg = '<p>Your message has been scheduled as follows:</p><p><ul>';
					foreach($schedules as $sched) {
						$msg .= '<li>Date: ' . $sched['date'] . ', Time: ' . $sched['time'] . '</li>';
					}
					$msg .= '</ul></p>';
					$session->setFlash('smsSent', $msg);
					//return $this->redirect(['view', 'id' => $sms->id]);
					//return $this->refresh('#success');
					$sms = new Message();
					return $this->render('create', [
						'model' => $sms,
						'schedules' => array($schedules)
					]);
		        	
		        	//var_dump($schedule);exit; INSERT INTO  schedule (message_id,  started_at) VALUES (2, '2015-30-14 7:30:41')
	        	}
	        	
		        	
		        	if(intval($data['personalised']) == 1) {
				if(!Utility::sendPersonalized($sms, $profile, $bulknos)) {
					Utility::startSession();
			        			$session = Yii::$app->session;
		        				$session->setFlash('smsSent', 'Your messages were not sent due to errors. Please contact the administrator or re-send');
					            return $this->render('group', [
					                'message' => $sms,
					            	'message_log' => $sms_log,
					            	'schedule' => $schedule,
					            	'groups' => $groups,
					            ]);	
				}
				
			} else if(!Utility::sendBulk($sms, $profile, $paddedNos)) {
			        			Utility::startSession();
			        			$session = Yii::$app->session;
		        				$session->setFlash('smsSent', 'Your messages were not sent due to errors. Please contact the administrator or re-send');
					            return $this->render('bulk', [
					                'message' => $sms,
					            	'message_log' => $sms_log,
					            	'schedule' => $schedule,
					            	'numbers' => $numbers,
					            ]);					     
		        	}
					Utility::startSession();
		        	$session = Yii::$app->session;
		        	$session->setFlash('smsSent', 'Your messages were successfully sent to ' . count($bulknos) . ' numbers.');
		            
					
		        	$sms = new Message();
		        	return $this->render('bulk', [
					                'message' => $sms,
					            	'message_log' => $sms_log,
					            	'schedule' => $schedule,
					            	'numbers' => $numbers,
					            ]); 
		        }
	        	//var_dump($data);
	        	
	        	//open and read the file        	
	        	
	        } else {
	            return $this->render('bulk', [
	                'message' => $sms,
	            	'message_log' => $sms_log,
	            	'schedule' => $schedule,
	            	'numbers' => $numbers,
	            ]);
	        }
        } else {
            return $this->render('bulk', [
                'message' => $sms,
            	'message_log' => $sms_log,
            	'schedule' => $schedule,
            	'numbers' => $numbers,
            ]);
        }
    }

	/**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionGroup()
    {
        $sms = new Message();
        $sms_log = new MessageLog();
        $schedule = new Schedule();
        $group = Group::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all();
        $groups = array();
        foreach ($group as $value) {
        	$groups[$value['id']] = $value['name'];
        }
        

        if ($sms->load(Yii::$app->request->post())) {
        	$sms_log->load(Yii::$app->request->post());
        	$data = \Yii::$app->request->post('Message', []);
        	$post = \Yii::$app->request->post();
        	$group_id = isset($data['recipient']) ? $data['recipient'] : null;
        	$group_nos = Contact::find()->where(['group_id' => $group_id])->asArray()->all();
        	//$sms_log->user_id = Yii::$app->user->id;
        	//var_dump($group_nos);exit;
			
        	$sms->body = isset($sms['body']) ? $sms['body'] : null;
					$profile = $_POST['sending_profile'];
					$sms_length = ($sms['type'] == '2' || $sms['type'] == '6') ? strlen(Utility::sms__unicode($sms['body'])) : $sms['length'];
					$s_credit_used = (float) Utility::getCurrentPrice($profile, $sms_length, Yii::$app->user->id, count($group_nos));
					$sms->user_id = Yii::$app->user->id;
					$sms->created_at = date('Y-m-d H:i:s');
					$sms->length = $sms_length;
					$sms->mode = "group";
					$sms->recipient = $group_id;
					$sms->sender_id = trim(substr($data['sender_id'], 0, 10));
					$sms->personalised = intval($data['personalised']);
					$sms->scheduled = intval($data['scheduled']);
					$sms->credit = $s_credit_used;
					$sms->profile = $profile;
					$sms->type = $data['type'];
		        	$sms->save(); 					
		        	
		        	$paddedNos = Utility::getNoGroup($group_nos, intval($data['personalised']));
        	
        if (intval($post['save_message']) == 1) {
        		$save = new SentMessage();
        		$save->user_id = Yii::$app->user->id;
        		$save->title = substr($sms['body'], 0, 100);
        		$save->body = $sms['body'];
        		$save->posted_at = date('Y-m-d H:i:s');
        		$save->save(false);
        	}
        	if(!Utility::isCreditEnough($profile, $s_credit_used)) {
		        		$session = Yii::$app->session;
        				$session->setFlash('smsSent', 'Insufficient credit to send messages.');
		        		return $this->render('group', [
			                'message' => $sms,
			            	'message_log' => $sms_log,
			            	'schedule' => $schedule,
			            	'groups' => $groups,
			            ]);
		        	}
			
			$s = intval($data['scheduled']); //var_dump($s);exit;
	        	if (intval($s) == 1) {
					$dates = $_POST['scheduled_date'];
					$times = $_POST['scheduled_time'];
					//for($i =0; $i < count($dates); $i++) {
						$schedules = array();
					foreach($dates as $key=>$date) {
						$date_split = explode('-', $dates[$key]);
						$year = $date_split[2];
						$month = $date_split[1];
						$day = $date_split[0];
						
						$time_split = explode(':', $times[$key]);
						$hour = $time_split[0];
						$minute = $time_split[1];
						$second = $time_split[2]; //print_r($_POST);
						//print_r($time_split);exit;
						$schedules[$key] = array('date' => $dates[$key], 'time' => $times[$key]);
						$schedule = new Schedule();
						$schedule->message_id = $sms->id;
						$schedule->year = $year;
						$schedule->month = $month;
						$schedule->day = $day;
						$schedule->hour = $hour;
						$schedule->minute = $minute;
						$schedule->second = $second;
						$schedule->scheduled_date = date('Y-m-d', strtotime($dates[$key]));
						$schedule->scheduled_time = $times[$key];
						$datetime = date('Y-m-d', strtotime($dates[$key])) . ' ' . $times[$key];
						$schedule->scheduled_datetime = $datetime;
						$schedule->status = 0;
						$schedule->started_at = null;
						$schedule->created_at = date('Y-m-d H:i:s');
						$schedule->save(false);  
					}
					
					$session = Yii::$app->session;
					$msg = '<p>Your message has been scheduled as follows:</p><p><ul>';
					foreach($schedules as $sched) {
						$msg .= '<li>Date: ' . $sched['date'] . ', Time: ' . $sched['time'] . '</li>';
					}
					$msg .= '</ul></p>';
					$session->setFlash('smsSent', $msg);
					//return $this->redirect(['view', 'id' => $sms->id]);
					//return $this->refresh('#success');
					$sms = new Message();
					return $this->render('create', [
						'model' => $sms,
						'schedules' => array($schedules)
					]);
		        	
		        	//var_dump($schedule);exit; INSERT INTO  schedule (message_id,  started_at) VALUES (2, '2015-30-14 7:30:41')
	        	}
				
			if(intval($data['personalised']) == 1) {
				if(!Utility::sendPersonalized($sms, $profile, $group_nos)) {
					Utility::startSession();
			        			$session = Yii::$app->session;
		        				$session->setFlash('smsSent', 'Your messages were not sent due to errors. Please contact the administrator or re-send');
					            return $this->render('group', [
					                'message' => $sms,
					            	'message_log' => $sms_log,
					            	'schedule' => $schedule,
					            	'groups' => $groups,
					            ]);	
				}
				
			} else if(!Utility::sendBulk($sms, $profile, $paddedNos)) {
			        			Utility::startSession();
			        			$session = Yii::$app->session;
		        				$session->setFlash('smsSent', 'Your messages were not sent due to errors. Please contact the administrator or re-send');
					            return $this->render('group', [
					                'message' => $sms,
					            	'message_log' => $sms_log,
					            	'schedule' => $schedule,
					            	'groups' => $groups,
					            ]);				     
		        	}
		        	Utility::startSession();
		        	$session = Yii::$app->session;
		        	$session->setFlash('smsSent', 'Your messages were successfully sent to ' . count($group_nos) . ' numbers.');
            		//return $this->redirect(['view', 'id' => $message->id]);
            		//return $this->refresh('#success');
            		$sms = new Message();
            		return $this->render('group', [
					                'message' => $sms,
					            	'message_log' => $sms_log,
					            	'schedule' => $schedule,
					            	'groups' => $groups,
					            ]);
        } else {
            return $this->render('group', [
                'message' => $sms,
            	'message_log' => $sms_log,
            	'schedule' => $schedule,
            	'groups' => $groups,          	
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
    
    private function loadNumbers($numFile=NULL, $personalised=0) {
    	if($numFile === NULL || !file_exists("uploads/" . $numFile)) {
    		return [];
    	}
    	//$data = \moonland\phpexcel\Excel::import("uploads/" . $numFile,
    	//[
        //'setFirstRecordAsKeys' => false, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
        //'setIndexSheetByName' => false, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
    	//]);
    	//return $data;
    	if (0 == filesize("uploads/" . $numFile))
    		return false;
    	$objPHPExcel = \PHPExcel_IOFactory::load("uploads/" . $numFile);
    	$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
		$val=array();
		if ($personalised == 1) {
			for ($row = 1; $row <= $highestRow; $row++) {
				$arr = array();
			   for ($col = 0; $col < $highestColumnIndex; ++ $col) {
			   $cell = $sheet->getCellByColumnAndRow($col, $row);
			   $arr[] = $cell->getValue();
				//End of For loop   
			}
			$val[] = array('name' => $arr[0], 'number' => $arr[1]);
			}
		} else {
			for ($row = 1; $row <= $highestRow; $row++) {		    
				//for ($col = 0; $col < $highestColumnIndex; ++ $col) {
			   $cell = $sheet->getCellByColumnAndRow(0, $row);
			   $val[] = $cell->getValue();
				//End of For loop   
				//}
			}
		}
		
		return $val;
    }
}