<?php
namespace app\models;

use yii\db\Query;

use yii\data\ActiveDataProvider;

use yii\base\Model;

use Yii;

class Reports extends Model
{
	public $from_date;
	public $to_date;
	const NAIRA_SIGN = "₦";
	
	public function rules(){
		return [
			['from_date', 'default', 'value' => date('Y-m-d H:i:s')],			
			['to_date', 'default', 'value' => date('Y-m-d H:i:s')],
			['to_date', 'isTogtFrom'],
		];
	}
	public function attributeLabels()
    {
        return [
            'from_date' => 'From Date',
        	'to_date' => 'To Date',
        ];
    }
    
	public static function CreditStatistics($from=null, $to=null) {
		//MessageLog::find()->where(['>=', 'sent_at', $from])->andWhere(['<=', 'sent_at', $to])
		$to .= ' 23:59:59';
		$from .= ' 00:00:00';
		$dataProvider = new ActiveDataProvider([
            'query' => CreditLog::find()->where(['between', 'added_at', $from, $to]), //->where(['like', 'sent_at', $to]),
			//'query' => $query,
		    'pagination' => [
		        'pageSize' => 10,
		    ],
		    'sort' => [
		        'defaultOrder' => [
		            'added_at' => SORT_DESC,
		        ]
		    ],
        ]);
		return $dataProvider;		
	}
	
	public static function CreditDetail() {
		$balance = Credit::find()->where(['user_id' => Yii::$app->user->id])->sum('amount');
		$used = MessageLog::find()->where(['user_id' => Yii::$app->user->id])->sum('credit_used');
		return array('balance' =>  $balance, 'used' => $used, 'total' => $balance + $used);
	}
	
	public static function SmsStatistics($from=null, $to=null) {
		$to .= ' 23:59:59';
		$query = (new Query())->from('message_log');
		//$query->select('DISTINCT *');
        $query->join('JOIN', 'message', 'message.id = message_log.message_id');
        $query->where(['between', 'message_log.sent_at', $from, $to]);
        $query->andWhere(['=', 'message.user_id', Yii::$app->user->id]);
        //$query->where(['>=', 'message_log.sent_at', $from]);
        //$query->andWhere(['<=', 'message_log.sent_at', $to]);
        //$query->where(['like', 'message_log.sent_at', $to]);
        $query->orderBy('message_log.sent_at DESC');
        //$query->distinct();
        
        
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
			//'query' => $query,
		    'pagination' => [
		        'pageSize' => 10,
		    ],
        ]);
                
		return $dataProvider;
	}
	
	public function isTogtFrom($attribute, $params)
    {
        if ($this->$attribute > $this->to_date) {
            $this->addError($attribute, 'The to date cannot be less than the from date.');
        }
    }
    
	public static function TodayStatistics() {
		$messages = MessageLog::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['like', 'sent_at', date('Y-m-d')])->count();
		$used = MessageLog::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['like', 'sent_at', date('Y-m-d')])->sum('credit_used');
		$balance = Credit::find()->where(['user_id' => Yii::$app->user->id])->sum('amount');
		return array('messages' =>  $messages, 'used' => $used, 'balanceb4' => $balance + $used, 'new_balance' => $balance);		
	}
}