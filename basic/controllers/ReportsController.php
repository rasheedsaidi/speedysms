<?php
namespace app\controllers;

use yii\filters\VerbFilter;

use yii\filters\AccessControl;

use app\models\MessageLog;

use Yii;
use app\models\Reports;
use yii\web\Controller;

class ReportsController extends Controller {
	
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['*'],
                        'allow'   => true,
                        'roles'   => ['?', '@'],
                    ],
                    [
                        'actions' => ['create', 'view', 'update', 'index', 'logout', 'delete', 'today_statistics', 'credit_statistics', 'sms_statistics'],
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
	public function actionIndex() {
		return $this->render("index");
	}
	
	public function actionCredit_statistics() {
		$model = new Reports();
		$stats = array();
		$detail = $model::CreditDetail();
		
		$data = Yii::$app->request->get();
		$loaded = $model->load($data);
		//var_dump($data);
		if($loaded && $model->validate()) {			
			if(Yii::$app->request->get()) {
				$data = Yii::$app->request->get();
				$stats = $model::CreditStatistics($model['from_date'], $model['to_date']);
				
				//$stats = 
				//var_dump($data);exit;
			}
		}
		return $this->render("credit_statistics", compact("model", "stats", "detail"));
	}
	
	public function actionToday_statistics() {
		$model = new Reports();
		$stats = $model::TodayStatistics();

		return $this->render("today_statistics", compact("model", "stats"));
	}
	
	public function actionSms_statistics() {
		$model = new Reports();
		$stats = "";
		
		$data = Yii::$app->request->get();
		$loaded = $model->load($data);
		//echo '<pre>';
		//var_dump($data);
		//echo '/<pre>';
		if($loaded && $model->validate()) {
			$data = Yii::$app->request->get();
			$stats = $model::SmsStatistics($model['from_date'], $model['to_date']);
			//echo $data['from_date'] . ' : ' . $data['to_date'];
			//var_dump($data);exit;
		}
		return $this->render("sms_statistics", compact("model", "stats"));
	}
}