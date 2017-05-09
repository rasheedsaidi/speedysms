<?php
namespace app\models;

use Yii;
use linslin\yii2\curl;

class Utility {
	
	const ONE_POINT_SEVEN = 1.7;
	const ONE_POINT_EIGHT = 1.8;
	const MESSAGE_LENGTH = 160;
	public $statuses = array();
	
	public static function getMessageParts($length = 1) {
		return ceil($length / self::MESSAGE_LENGTH);
	}
	
	public static function getSendingPrice($sms_length = 1, $type = "express") {
		$id = Yii::$app->user->id;
		$price = Credit::find()->where(['user_id' => $id])->where(['type' => $type])->orderBy('amount DESC')->all();
		$unit_price = Price::findOne($price->price_id);
		$credit = (float) self::getMessageParts($sms_length) * (float) $unit_price->price;
		$new_price = Credit::find()->where(['user_id' => $id]);
		$new_price->amount = $new_price->amount - $credit;
		$new_price->save();
		return $credit;
	}
	
	public static function getCurrentPrice($credit_id, $sms_length, $id=0, $bulk=1) {//echo $credit_id . $id;exit;
		//$id = Yii::$app->user->id;
		$price = 0;//echo 'Credit id: ' . $credit_id . 'Sms length: ' . $sms_length . 'Userid: ' . $id . ' Bulk: ' . $bulk;
		$credit = Credit::find()->where(['user_id' => $id])->andWhere(['id' => $credit_id])->one();
		//var_dump($credit);exit;
		if($credit) {
			$unit_price = Price::findOne($credit->price_id); //echo $unit_price->price. $bulk;
			$price = (float) self::getMessageParts($sms_length) * (float) $unit_price->price * $bulk;
			//$new_price = Credit::find()->where(['user_id' => $id]);
			//$diff = ((int)$credit->amount * (int)$bulk) - $price;
			$diff = $price;
			if($diff < 0) {
				return 0;
			}			
			//$credit->amount = $diff;
			//$new_price->amount = $new_price->amount - $price;
			//$credit->save(); 
		}
		return $price;
	}
	
	public static function deductCredit($credit_id, $amount) {//echo $credit_id . $id;exit;		
		$credit = Credit::find()->where(['id' => $credit_id])->one();
		//$credit = Credit::findOne($id);
		if($credit) {
			$diff = (float)$credit->amount - (float)$amount;	//echo $amount.$credit->amount;exit;		
			$credit->amount = $diff;
			$credit->save(false);
			return true;
		}
		return false;
	}
	
	public static function getPrice($sms_length = 1, $type = "express") {
		$price_unit = null;
		$price = Price::find()->all();
		if($price) {
			foreach($price as $p) {
				if(($sms_length >= $p->min_price && $sms_length <= $p->max_price) && $type == $p->type) {
					//$price1 = Price::find()->where(['>=', 'min_price', $sms_length])->andWhere(['<=', 'max_price', $sms_length])->andWhere(['type' => $type])->orderBy('min_price ASC')->one();
					return $p;
				}
			}
		
			//$price_unit = $price;
		}
		return $price_unit;
	}
	
	function ref() {
		$rooms = Room::find()
	    ->select([
	        '{{room}}.*', // select all columns
	        '([[length]] * [[width]].* [[height]]) AS volume', // calculate a volume
	    ])
	    ->orderBy('volume DESC') // apply sort
	    ->all();
		
		foreach ($rooms as $room) {
		    echo $room->volume; // contains value calculated by SQL
		}
	}
	
	public static function sendSMS1()
    {
    	try {        
    		//Init curl
	        $curl = new curl\Curl();
	
	        //get http://example.com/
	        $response = $curl->get('http://www.helloworldng.com/bip/get_traffic.php');
	        var_dump($response);
    	} catch (Exception $e) {
    		var_dump($e);
    	}
    }
    
	public static function sendSMSAPI($user_id, $sender, $body, $mobile, $type, $profile)
    {
    	$credit = Credit::find()->where(['id' => $profile])->andWhere(['user_id' => $user_id])->one();//var_dump( $credit );exit;
    	//echo $credit->type;exit;
    	if($credit->type != NULL){ //echo $credit->type;
    		if($credit->type == 'express') { //var_dump(self::sendExpressSMS($sender, $body, $mobile, $type, $profile));
    			return self::sendExpressSMS($sender, $body, $mobile, $type, $profile);
    		} else { //var_dump(self::sendStandardSMS($sender, $body, $mobile, $type, $profile)); echo 'error';exit;
    			return self::sendStandardSMS($sender, $body, $mobile, $type, $profile);
    		}
    	}
    	return false;
    }
    
	public static function sendSMS($sender, $body, $mobile, $type, $profile)
    {
    	$credit = Credit::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['id' => $profile])->one();
    	if($credit->type != NULL){
    		if($credit->type == 'express') {
    			return self::sendExpressSMS($sender, $body, $mobile, $type, $profile);
    		} else {
    			return self::sendStandardSMS($sender, $body, $mobile, $type, $profile);
    		}
    	}
    	return false;
    }
    
	public static function sendSMSBulk($sender, $body, $mobile, $type, $profile)
    {
    	$credit = Credit::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['id' => $profile])->one();
    	if($credit->type != NULL){
    		if($credit->type == 'express') {
    			return self::sendExpressSMS2($sender, $body, $mobile, $type, $profile);
    		} else {
    			return self::sendStandardSMS2($sender, $body, $mobile, $type, $profile);
    		}
    	}
    	return false;
    }
    
    public static function sendStandardSMS ($sender, $body, $mobile, $type, $profile) {
    	$responses = false;
    	// send the message using BODY, SENDER_ID, and NUMBER 
        //$obj = new Sender ("121.241.242.114", "8080", "hel1-smsuser", "123@abc", $sms_detail['sender'], $sms_detail['body'], $sms_detail['mobile'], "0", "1");
        $obj = new Sender ("121.241.242.114", "8080", "helo-460degree", "1qaz2wsx", $sender, $body, $mobile, "0", "1");
		//$obj = new Sender ("smsplus1.routesms.com", "8080", "helloworld", "m3v5y7e4", $sms_detail['sender'], $sms_detail['body'], $sms_detail['mobile'], "0", "1");
		$resp = $obj->Submit();
		if($resp) {
			$responses = explode("|", $resp);
		}
		return $responses;
    }
    
	public static function sendExpressSMS ($sender, $body, $mobile, $type, $profile) {
		$responses = false;
    	// send the message using BODY, SENDER_ID, and NUMBER
        //$obj = new Sender ("121.241.242.114", "8080", "hel1-smsuser", "123@abc", $sms_detail['sender'], $sms_detail['body'], $sms_detail['mobile'], "0", "1");
        $obj = new Sender ("121.241.242.114", "8080", "hel1-smsuser", "123@abc", $sender, $body, $mobile, "0", "1");
		//$obj = new Sender ("smsplus1.routesms.com", "8080", "helloworld", "m3v5y7e4", $sms_detail['sender'], $sms_detail['body'], $sms_detail['mobile'], "0", "1");
		$resp = $obj->Submit();
		if($resp) {
			$responses = explode("|", $resp);
		}
		return $responses;
    }
    
	public static function sendStandardSMS2 ($sender, $body, $mobile, $type, $profile) {
    	$responses = false;
    	// send the message using BODY, SENDER_ID, and NUMBER 
        //$obj = new Sender ("121.241.242.114", "8080", "hel1-smsuser", "123@abc", $sms_detail['sender'], $sms_detail['body'], $sms_detail['mobile'], "0", "1");
        $obj = new Sender ("121.241.242.114", "8080", "helo-460degree", "1qaz2wsx", $sender, $body, $mobile, "0", "1");
		//$obj = new Sender ("smsplus1.routesms.com", "8080", "helloworld", "m3v5y7e4", $sms_detail['sender'], $sms_detail['body'], $sms_detail['mobile'], "0", "1");
		$resp = $obj->Submit();
		if($resp) {
			return $resp;
		}
		return $responses;
    }
    
	public static function sendExpressSMS2 ($sender, $body, $mobile, $type, $profile) {
		$responses = false;
    	// send the message using BODY, SENDER_ID, and NUMBER
        //$obj = new Sender ("121.241.242.114", "8080", "hel1-smsuser", "123@abc", $sms_detail['sender'], $sms_detail['body'], $sms_detail['mobile'], "0", "1");
        $obj = new Sender ("121.241.242.114", "8080", "hel1-smsuser", "123@abc", $sender, $body, $mobile, "0", "1");
		//$obj = new Sender ("smsplus1.routesms.com", "8080", "helloworld", "m3v5y7e4", $sms_detail['sender'], $sms_detail['body'], $sms_detail['mobile'], "0", "1");
		$resp = $obj->Submit();
		if($resp) {
			return $resp;
		}
		return $responses;
    }
    
    public static function padNumber($t=0) {
    	$to = 0;
    	if($t != 0) {
	    	if($t[0] == '0') {
				$to = '234'.substr($t, 1);
			} if($t[0] == '2') {
				$to = $t;
			} else {
				$to = '234'.$t;			//"2348024099255";
			}
    	}
		return $to;
    }
    
	public static function startSession() {
		$session = Yii::$app->session;
		if (!$session->isActive)
			$session->open();
	}
	
	public static function getScratcardLogo() {
		//Yii::$app->basePath
		return Yii::$app->getUrlManager()->getBaseUrl() . '/images/scratchcard.jpg';
	}
	
	public static function getDebitcardLogo() {
		//Yii::$app->basePath
		return Yii::$app->getUrlManager()->getBaseUrl() . '/images/debitcard.jpg';
	}
	public static function isValidPIN($pin_no, $amt) {
		$pin_no = sha1($pin_no);
		$pin = Pin::find()->where(['pin' =>  $pin_no])->one();
		if ($pin) {
			if($pin->status == '0') {
				if($pin->amount != $amt) {
					return 3;
				}
				return 1;
			}			
			
			if($pin->status == '1') {
				return 2;
			}
		}
		return 0;
	}
	
	public static function usePIN($pin_no, $transid) {
		$pin_no = sha1(trim($pin_no));
		$pin = Pin::find()->where(['pin' =>  $pin_no])->one();
		if ($pin) {
			$pin->status = '1';
			$pin->dateused = date('Y-m-d H:i:s');
			$pin->transid = $transid;
			$pin->save(false);
		}
	}
	
	public static function logTransaction($transaction_id, $amt) {
		$transaction = new Transaction();
		$transaction->user_id = Yii::$app->user->id;
		$transaction->reference = $transaction_id;
		$transaction->status = "Pending";
		$transaction->posted_at = date('Y-m-d H:i:s');
		$transaction->save(false);
	}
	
}