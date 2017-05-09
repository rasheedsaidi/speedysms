<?php

namespace app\controllers;

use yii\web\JsExpression;

use yii\helpers\Html;

use yii\helpers\Json;

use yii\base\Response;

use app\models\BulkFile;

use app\models\Contact;

use Yii;
use app\models\Group;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends Controller
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
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Group::find(),
        ]);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Group model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$dataProvider = new ActiveDataProvider([
            'query' => Contact::find()->where(['group_id' => $id]),
        ]);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        	'contactProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Group();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Group model.
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
     * Deletes an existing Group model.
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
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
	public function actionManage($id)
    {
        $group = $this->findModel($id);
        $contact = Contact::find()->where(['group_id' => $id])->asArray()->all();//var_dump($contact);exit;
        $numbers = new BulkFile();
		$post = Yii::$app->request->post();
		//$nums = $post['Group']['manage_contact'];
        //var_dump(explode(',', $nums));exit;
        if (Yii::$app->request->post()) {
        	$post = Yii::$app->request->post();
			$nums = preg_replace('/\s+/', '', $post['Group']['manage_contact']);
			//var_dump($nums);exit;
	        $num_array = array_unique(explode(',', $nums));
	        if (is_array($num_array)) {
		        foreach ($num_array as $v) { 
		        	$dv = trim($v);
		        	if (!empty($dv)) {
		        		//array_unique
		        		$g = Contact::find()->where(['group_id'=>$id, 'number'=>$dv ])->count();
		        		$hg[]= array(
		        		'count' => $g,
		        		'id' => $id,
		        		'num' => $dv
		        		);
		        		if ($g == 0) {
		        			$co = new Contact();
		        			$co->group_id = $id;
		        			$co->name = $dv;
		        			$co->number = $dv;
		        			$co->created_at = date('Y-m-d H:i:s');
		        			$co->save(false);
		        			unset($co);
		        		}
		        		//var_dump($nums);exit;		        		
		        	}
		        } //var_dump($hg);exit;
	        } else {
	            return $this->render('manage', [
	                'group' => $group,
	            	'contact' => $contact,
	            	'numbers' => $numbers,
	            ]);
	        }        
            //var_dump($numbers);
	        //echo $message->id;exit;
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('manage', [
                'group' => $group,
            	'contact' => $contact,
            	'numbers' => $numbers,
            ]);
        }
    }
    
	private function getNumbers(BulkFile $numbers) {
		$numbers = new BulkFile();
		$numbers->numbersFile = UploadedFile::getInstance($numbers, 'numbersFile');
            if ($numbers->upload()) {
	            $phonesFile = $numbers->numbersFile->name;
            } else {
            	$phonesFile = NULL;
            }
	}
	
	public function actionLink() { 
	    if (Yii::$app->request->isAjax) {
	        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	        $file = urldecode($_POST['url']);  
	        
	        $ext = ['csv', 'xls', 'xlsx', 'txt'];
	        $l = end(explode('.', $file)); 
	        if (in_array($l, $ext)) {
		        $list = '';
		        //if (file_exists($file)) {		        
		        	$f = end(explode('/', $file));
		        	$nums = $this->loadNumbers($f);	        	
		        	if ($nums) {
		        		foreach ($nums as $num) {
		        			$list .= $num . ', ';
		        		}
		        	}
		        //} preg_replace('/\s+/', '', $VehicleN);
			    return [
			        'numbers' => $list,
			    ];
	        } else {
	        	return [
			        'numbers' => '0',
			    ];
	        }
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
		unlink("uploads/" . $numFile);
		return $val;
    }
	
}
