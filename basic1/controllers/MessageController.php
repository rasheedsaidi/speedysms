<?php

namespace app\controllers;

use app\models\Bulk;

use app\models\Group;

use app\models\BulkFile;

use app\models\Schedule;

use Yii;
use app\models\Message;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use alexgx\phpexcel;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
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
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionBulk()
    {
        $message = new Message();
        $schedule = new Schedule();
        $numbers = new BulkFile();
		
        //if ($message->load(Yii::$app->request->post()) && $schedule->load(Yii::$app->request->post())) {
        if (Yii::$app->request->post()) {
        	$numbers->numbersFile = UploadedFile::getInstance($numbers, 'numbersFile');
            if ($numbers->upload()) {
                $bulk = new Bulk();
	            $bulk->name = $numbers->numbersFile->name;
	            $bulk->ext = $numbers->numbersFile->extension;
	            $bulk->created_at = date('Y-m-d H:i:s');
	            $bulk->save(false);
            }
	        if ($bulk->id) {	
	        	$data = Yii::$app->request->post();
	        	$m = $data['Message'];   	
        		$message->number = $bulk->id;
        		$message->sender = $m['sender'];
        		$message->type = $m['type'];
        		$message->body = $m['body'];
        		$message->length = $m['length'];
        		$message->flag = $m['flag'];
        		$message->save(false);  
	        	//var_dump($data);
        		$s = $data['Schedule'];//var_dump($s);exit;
	        	if ($data['scheduled'] == '1') {
		        	//$schedule->load(Yii::$app->request->post() $schedule->save()		        	
		        	$schedule->message_id = $message->id;
		        	$schedule->started_at = $s['started_at'];
		        	$schedule->created_at = date('Y-m-d H:i:s');
		        	$schedule->save(false);  
		        	//var_dump($schedule);exit; INSERT INTO  schedule (message_id,  started_at) VALUES (2, '2015-30-14 7:30:41')
	        	}
	        	
	        	//open and read the file
	        	$bulknos = $this->loadNumbers($numbers->numbersFile->name);
	        	
	        } else {
            return $this->render('bulk', [
                'message' => $message,
            	'schedule' => $schedule,
            	'numbers' => $numbers,
            ]);
        }        
            //var_dump($numbers);
	        //echo $message->id;exit;
            return $this->redirect(['view', 'id' => $message->id]);
        } else {
            return $this->render('bulk', [
                'message' => $message,
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
        $message = new Message();
        $schedule = new Schedule();
        $group = Group::find()->asArray()->all();
        $groups = array();
        foreach ($group as $value) {
        	$groups[$value['id']] = $value['name'];
        }
        

        if ($message->load(Yii::$app->request->post()) && $schedule->load(Yii::$app->request->post()) && $message->save() && $schedule->save()) {
            return $this->redirect(['view', 'id' => $message->id]);
        } else {
            return $this->render('group', [
                'message' => $message,
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
    
    private function loadNumbers($numFile=NULL) {
    	if($numFile === NULL || !file_exists("uploads/" . $numFile)) {
    		return [];
    	}
    	$objPHPExcel = \PHPExcel_IOFactory::load("uploads/" . $numFile);
    	$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
		$val=array();
		for ($row = 1; $row <= $highestRow; $row++) {		    
			//for ($col = 0; $col < $highestColumnIndex; ++ $col) {
		   $cell = $sheet->getCellByColumnAndRow(0, $row);
		   $val[] = $cell->getValue();
		 	//End of For loop   
			//}
		}
		return $val;
    }
}
