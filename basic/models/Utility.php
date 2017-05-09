<?php
namespace app\models;

use Yii;
use linslin\yii2\curl;

class Utility {
	
	const ONE_POINT_SEVEN = 1.7;
	const ONE_POINT_EIGHT = 1.8;
	const TEXT_MESSAGE_LENGTH = 153;
	const UNICODE_MESSAGE_LENGTH = 268;
	const DEFAULT_PRICE_ID = 4;
	public $statuses = array();
	
	public static function getMessageParts($length = 1, $type=0) {
		switch ($type) {
			case 0:
			case 1:
				return ceil($length / self::TEXT_MESSAGE_LENGTH);
				break;
			case 2:
			case 6:
				return ceil($length / self::UNICODE_MESSAGE_LENGTH);
				break;
			default:
				return ceil($length / self::TEXT_MESSAGE_LENGTH);
				break;			
		}
	}
	
	public static function sms__unicode($message){
$hex1='';
if (function_exists('iconv')) {
	$latin = @iconv('UTF-8', 'ISO-8859-1', $message);
	if (strcmp($latin, $message)) {
		$arr = unpack('H*hex', @iconv('UTF-8', 'UCS-2BE', $message));
		$hex1 = strtoupper($arr['hex']);
	}
	if($hex1 ==''){
	$hex2='';
	$hex='';
	for ($i=0; $i < strlen($message); $i++){
	$hex = dechex(ord($message[$i]));
	$len =strlen($hex);
	$add = 4 - $len;
	if($len < 4){
	for($j=0;$j<$add;$j++){
	$hex="0".$hex;
	}
	}
	$hex2.=$hex;
	}
	return $hex2;
	}
	else{
	return $hex1;
	}
}
else{
print 'iconv Function Not Exists !';
}
}

	public static function sendSingle($sms, $profile, $id=0) {
		$user_id = ($id != 0)? $id: Yii::$app->user->id;
    	$sms_log = new MessageLog();
    	$sms_log->mobile_no = $sms->recipient;
        $sms_log->message_id = $sms->id;
        $sms_log->sent_at = date('Y-m-d H:i:s');
        $sms_log->country = 'Nigeria';
        $sms_log->user_id = $user_id;
        $sms_log->status = "PENDING";
        $sending_profile = $profile;
        $sms_log->credit_used = (float) Utility::getCurrentPrice($profile, $sms->length, $user_id, 1);
               	//echo $sms->sender_id . $sms->body . $sms->recipient . $sms->type . $profile. $user_id; //exit;
    	$responses = Utility::sendSMS($sms->sender_id, $sms->body, $sms->recipient, $sms->type, $profile, $user_id);
        	//var_dump($responses);exit;
		if($responses) {
			Utility::deductCredit($profile, $sms->credit);
	        $sms_log->sender_id = $sms->sender_id;
			$sms_log->sms_return_id = isset($responses[2])? $responses[2]: null;
			$sms_log->status = isset($responses[0])? $responses[0]: "PENDING";
			$sms_log->save();
			return true;
		}
		return false;        
    }
    
	public static function sendBulk($sms, $profile, $nos, $id=0) {
		if (is_array($nos) && !empty($nos)) {
			$paddedNos = $nos;
		} else {
			return false;
		}
		$user_id = ($id != 0)? $id: Yii::$app->user->id;
		Utility::deductCredit($profile, $sms->credit);
		foreach($paddedNos as $paddedNo) {								        	
		
				        	
			        		$resp = Utility::sendSMSBulk($sms->sender_id, $sms->body, $paddedNo, $sms->type, $profile, $user_id);
			        		//var_dump($resp);exit;
			        		if($resp) {			        			
								$resps = explode(",", $resp);
								foreach ($resps as $r) {
									$responses = explode("|", $r);
									$sms_log = new MessageLog();
    	$sms_log->mobile_no = $sms->recipient;
        $sms_log->message_id = $sms->id;
        $sms_log->sent_at = date('Y-m-d H:i:s');
        $sms_log->country = 'Nigeria';
        $sms_log->user_id = $user_id;
        $sms_log->status = "PENDING";
        $sending_profile = $profile;
        $sms_log->credit_used = (float) Utility::getCurrentPrice($profile, $sms->length, $user_id, 1);
									
									$sms_log->mobile_no = isset($responses[1])? $responses[1]: "bulk_" . $sms->recipient;
									$sms_log->sms_return_id = isset($responses[2])? $responses[2]: null;
									$sms_log->status = isset($responses[0])? $responses[0]: "PENDING";
									$sms_log->save();
								}
								//return true;
			        		} else {
			        			return false;
					        }
		        		}
		        		return true;    	    
    }
	
	public static function sendPersonalized($sms, $profile, $nos, $id=0) {
		if (is_array($nos) && !empty($nos)) {
			$paddedNos = $nos;
		} else {
			return false;
		}
		
		$user_id = ($id != 0)? $id: Yii::$app->user->id;
		//Utility::deductCredit($profile, $sms->credit);
		foreach($paddedNos as $paddedNo) {
if(strlen($paddedNo['number']) > 5) {		
		$body = self::findAndReplace($sms->body, $paddedNo['name']);
		$mobile = self::padNumber($paddedNo['number']); //var_dump($mobile);exit;
		$sms_log = new MessageLog();
    	$sms_log->mobile_no = $mobile;
        $sms_log->message_id = $sms->id;
        $sms_log->sent_at = date('Y-m-d H:i:s');
        $sms_log->country = 'Nigeria';
        $sms_log->user_id = $user_id;
        $sms_log->status = "PENDING";
        $sending_profile = $profile;
        $sms_log->credit_used = (float) Utility::getCurrentPrice($profile, $sms->length, $user_id, 1);
				        	
							//$responses = Utility::sendSMS($sms->sender_id, $sms->body, $sms->recipient, $sms->type, $profile, $user_id);
			        		$responses = Utility::sendSMS($sms->sender_id, $body, $mobile, $sms->type, $profile, $user_id);
							
			        		//var_dump($resp);exit;
			        		if($responses) {
			Utility::deductCredit($profile, $sms->credit);
	        $sms_log->sender_id = $sms->sender_id;
			$sms_log->sms_return_id = isset($responses[2])? $responses[2]: null;
			$sms_log->status = isset($responses[0])? $responses[0]: "PENDING";
			$sms_log->save();
			//return true;
		} else {
			        			return false;
					        }
		}
		        		}
		        		return true;    	    
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
		$price = -1;//echo 'Credit id: ' . $credit_id . 'Sms length: ' . $sms_length . 'Userid: ' . $id . ' Bulk: ' . $bulk;
		$credit = Credit::find()->where(['user_id' => $id])->andWhere(['id' => $credit_id])->one();
		//var_dump($credit);exit;
		if($credit) {
			$unit_price = Price::findOne($credit->price_id); //echo $unit_price->price. $bulk;
			$price = (float) self::getMessageParts($sms_length) * (float) $unit_price->price * $bulk;
			//$new_price = Credit::find()->where(['user_id' => $id]);
			//$diff = ((int)$credit->amount * (int)$bulk) - $price;
			$diff = $price;
			if($diff < 0) {
				return -1;
			}			
			//$credit->amount = $diff;
			//$new_price->amount = $new_price->amount - $price;
			//$credit->save(); 
		}
		return $price;
	}
	
	public static function isCreditEnough($credit_id, $price) {//echo $credit_id . $id;exit;
		
		$credit = Credit::find()->where(['id' => $credit_id])->one();
		//var_dump($credit);exit;
		if($credit) {
			
			$diff = ((int)$credit->amount - (int)$price);
			if($diff <= 0) {
				return false;
			} else {
				return true;
			}
		}
		return false;
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
	
	public static function getPrice($amount = 1, $type = "express") {
		$price_unit = null;
		$price = Price::find()->all();
		if($price) {
			foreach($price as $p) {
				//echo 'From: ' . $p->min_price . ' to: ' . $p->max_price;
				if(($amount >= $p->min_price && $amount <= $p->max_price) && $type == $p->type) {					
					//$price1 = Price::find()->where(['>=', 'min_price', $sms_length])->andWhere(['<=', 'max_price', $sms_length])->andWhere(['type' => $type])->orderBy('min_price ASC')->one();
					return $p;
				}
			}
		
			//$price_unit = $price;
		}
		return $price_unit;
	}
	
	public static function getUserPrice($price_id = 0, $type = "express") {
		$price_unit = null;
		$price = Price::find()->where(['id' => $price_id])->andWhere(['type' => $type])->one(); //var_dump($price);
		if($price) {
			return $price;
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
    	$sms_length = ($type == '2' || $type == '6') ? strlen(self::sms__unicode($body)) : strlen(trim($body));
    	$s_credit_used = (float) self::getCurrentPrice($profile, $sms_length, $user_id, 1);
    	if(!self::isCreditEnough($profile, $s_credit_used)) {
    		return false;
    	}
    	$credit = Credit::find()->where(['id' => $profile])->andWhere(['user_id' => $user_id])->one();//var_dump( $credit );exit;
    	//echo $credit->type;exit;
    	if($credit && $credit->type != NULL){ echo $credit->type;
    		if($credit->type == 'express') { //var_dump(self::sendExpressSMS($sender, $body, $mobile, $type, $profile));
    			return self::sendExpressSMS($sender, $body, $mobile, $type, $profile);
    		} else { //var_dump(self::sendStandardSMS($sender, $body, $mobile, $type, $profile)); echo 'error';exit;
    			return self::sendStandardSMS($sender, $body, $mobile, $type, $profile);
    		}
    	}
    	return false;
    }
    
	public static function sendSMS($sender, $body, $mobile, $type, $profile, $id=0)
    {  //echo $sender . ' ' . $body . ' ' . $mobile . ' ' . $type . ' ' . $profile . $id; exit;
		$user_id = ($id != 0)? $id: Yii::$app->user->id; 
    	$credit = Credit::find()->where(['user_id' => $user_id])->andWhere(['id' => $profile])->one();
		
		if($credit) { 
			if($credit->type != NULL){
				if($credit->type == 'express') {
					return self::sendExpressSMS($sender, $body, $mobile, $type, $profile);
				} else {
					return self::sendStandardSMS($sender, $body, $mobile, $type, $profile);
				}
			}
		}    	
    	return false;
    }
	
	public static function sendSMSType($sender, $body, $mobile, $type, $profile, $service)
    { 
		if($service == 'express') {
			return self::sendExpressSMS($sender, $body, $mobile, $type, $profile);
		} else {
			return self::sendStandardSMS($sender, $body, $mobile, $type, $profile);
		}    	
    	return false;
    }
	
	public static function getProfileType($id, $profile)
    {
    	$credit = Credit::find()->where(['user_id' => $id])->andWhere(['id' => $profile])->one();
    	if($credit)
			return $credit->type;
		return false;
	}
    
	public static function sendSMSBulk($sender, $body, $mobile, $type, $profile, $id=0)
    {
		$user_id = ($id != 0)? $id: Yii::$app->user->id;
    	$credit = Credit::find()->where(['user_id' => $user_id])->andWhere(['id' => $profile])->one();
		if($credit) {
			if($credit->type != NULL){
				if($credit->type == 'express') {
					return self::sendExpressSMS2($sender, $body, $mobile, $type, $profile);
				} else {
					return self::sendStandardSMS2($sender, $body, $mobile, $type, $profile);
				}
			}
		}
    	return false;
    }
    
    public static function sendStandardSMS ($sender, $body, $mobile, $type, $profile) {
    	$responses = false;
    	// send the message using BODY, SENDER_ID, and NUMBER 
        //$obj = new Sender ("121.241.242.114", "8080", "hel1-smsuser", "123@abc", $sms_detail['sender'], $sms_detail['body'], $sms_detail['mobile'], "0", "1");
        //$obj = new Sender ("121.241.242.114", "8080", "helo-460degree", "1qaz2wsx", $sender, $body, $mobile, $type, "1");
        $obj = new Sender ("smsplus4.routesms.com", "8080", "helloworldnaira", "rtydnf45", $sender, $body, $mobile, $type, "1");
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
    	//http://smsplus4.routesms.com:8080/bulksms/bulksms?username=helloworldnaira&password=rtydnf45&type=0&message=test%20message&source=test@@&destination=23400000000&dlr=1
        //$obj = new Sender ("121.241.242.114", "8080", "hel1-smsuser", "123@abc", $sms_detail['sender'], $sms_detail['body'], $sms_detail['mobile'], "0", "1");
        //$obj = new Sender ("121.241.242.114", "8080", "hel1-smsuser", "123@abc", $sender, $body, $mobile, $type, "1");
		$obj = new Sender ("smsplus4.routesms.com", "8080", "helloworldnaira", "rtydnf45", $sender, $body, $mobile, $type, "1");
		$resp = $obj->Submit(); //var_dump($resp);exit;
		if($resp) {
			$responses = explode("|", $resp);
		}
		return $responses;
    }
    
	public static function sendStandardSMS2 ($sender, $body, $mobile, $type, $profile) {
    	$responses = false;
    	// send the message using BODY, SENDER_ID, and NUMBER 
        //$obj = new Sender ("121.241.242.114", "8080", "hel1-smsuser", "123@abc", $sms_detail['sender'], $sms_detail['body'], $sms_detail['mobile'], "0", "1");
        $obj = new Sender ("121.241.242.114", "8080", "helo-460degree", "1qaz2wsx", $sender, $body, $mobile, $type, "1");
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
        $obj = new Sender ("121.241.242.114", "8080", "hel1-smsuser", "123@abc", $sender, $body, $mobile, $type, "1");
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
    		$b = trim(substr($t, 0, 1));
	    	if($b == '0') {
				$to = '234'.substr($t, 1);
			} else if($b == '2') {
				$to = $t;
			} else {				
				if($b == '8' || $b == '1' || $b == '7' || $b == '9') {
					$to = '234'. $t;
				} else {
					$to = $t;	//'234'.substr($t, 1);			//"2348024099255";
				}
			}
    	}
		return $to;
    }
    
    public static function padNumber1($t=0) {
    	$to = 0;
    	if($t != 0) {
	    	if($t[0] == '0') {
				$to = '234'.substr($t, 1);
			} else {
				$to = '234'.$t;			//"2348024099255";
			}
			
			if(substr($t, 0, 2) == '234') {
				$to = $t;
			}
    		if(substr($t, 0, 3) == '2340') {
				$to = '234'.substr($t, 3);
			}
			if(substr($t, 0, 4) == '+2340') {
				$to = '234'.substr($t, 5);
			} 
			if(substr($t, 0, 3) == '+234') {
				$to = '234'.substr($t, 4);
			}
			
			if(substr($t, 0, 5) == '234234') {
				$to = '234'.substr($t, 6);
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
	
	public static function logTransaction($merchant_ref, $amt) {
		$transaction = new Voguepay();
		$transaction->user_id = Yii::$app->user->id;
		$transaction->merchant_ref = $merchant_ref;
		$transaction->status = "Pending";
		$transaction->posted_at = date('Y-m-d H:i:s');
		$transaction->save(false);
	}
	
	public static function logTransaction1($transaction_id, $amt) {
		$transaction = new Transaction();
		$transaction->user_id = Yii::$app->user->id;
		$transaction->reference = $transaction_id;
		$transaction->status = "Pending";
		$transaction->posted_at = date('Y-m-d H:i:s');
		$transaction->save(false);
	}
	
	public static function getNoBulk($bulknos, $personalised=0) {
		$paddedNos = array();
        	$i = 0;
        	$paddedNos[$i] = "";
        	$counter = 0;
        	$max = 2;
        	$j = 100;
        	$c = count($bulknos);
		        	foreach ($bulknos as $no) {	//var_dump($no['number']);exit;

		        		$comma = ',';
		        		if($counter === $max-1 || $j === $c) {
		        			$comma = "";
		        		}
		        		if($counter === $max) {	        			
		        			$counter = 0;
		        			$i++;
		        			$paddedNos[$i] = "";
		        		}
		        		$counter++;
		        		$j++;
		        		
		        		$paddedNos[$i] .= ($personalised == 1)? trim(self::padNumber($no['number'])) . $comma: trim(self::padNumber($no)) . $comma;
		        	}
		        	return $paddedNos;
	}
	
	public static function getNoGroup($group_nos, $personalised=0) {
		$paddedNos = array();
        	$i = 0;
        	$paddedNos = array();
        	$i = 0;
        	$paddedNos[$i] = "";
        	$counter = 0;
        	$max = 100;
        	$j = 1;
        	$c = count($group_nos);
	foreach ($group_nos as $no) {	

        		$comma = ',';
        		if($counter === $max-1 || $j === $c) {
		        	$comma = "";
		        }
        		if($counter === $max) {        			
        			$counter = 0;
        			$i++;
        			$paddedNos[$i] = "";
        		}
        		$counter++;
        		$j++;
        		
        		$paddedNos[$i] .= trim(self::padNumber($no['number'])) . $comma;
        	}
		        	return $paddedNos;
	}
	
	public function getBasePath() {
		$path = Yii::$app->basePath;
		$pos = strrpos($path, "/");
		if ($pos !== false) { // note: three equal signs
		    // not found...
		    return substr($path, 0, $pos);
		}
		return false;
	}
	
	public static function sendEmail($subject, $email, $template, $data) {
		$mailer = Yii::$app->mailer;
        $result = $mailer->compose($template, ['data' => $data])
            ->setTo($email)
            ->setSubject($subject)
            ->send();
	}
	
	public static function sendSimpleEmail($subject, $email, $body) {
        Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom('sales@speedysms.com.ng')
            ->setSubject($subject)
            ->setTextBody($body)
            ->send();
	}
	
	public static function findAndReplace($string, $name) {
		$string = trim($string);

		$pos = strpos($string, '::');
		if ($pos !== false) {
			$las = strpos($string, '::', $pos+1);
			if($las !== false) {
				//echo substr($string, 0, $pos) . $name . substr($string, $las+2);exit;
				return substr($string, 0, $pos) . $name . substr($string, $las+2);
			}
		}
		return false;		
	}
	
	public static function getStatusMessage($msg) {
		$resp = intval($msg);
		$responses = array(
			1701 => 'Successful',
			1702 => 'Invalid URL Error',
			1703 => 'Invalid value in username or password field',
			1704 => 'Invalid value in "type" field',
			1705 => 'Invalid Message',
			1706 => 'Invalid Destination',
			1707 => 'Invalid Source (Sender)',
			1708 => 'Invalid value for "dlr" field',
			1709 => 'User validation failed',
			1710 => 'Internal Error',
			1025 => 'Insufficient Credit',
			1715 => 'Response timeout'
			);
		if((array_key_exists($resp, $responses))) {
			return $responses[$resp];
		}
		
		return $resp;
	}
	
	public static function getUser($id=0) {
		$query = (new \yii\db\Query())->from('user')->select("*, user.id as userid")->distinct();
        $user = $query->join('LEFT JOIN', 'profile', 'user.id = profile.user_id')->where('user.id =' . $id)->one();
        return $user;
	}
	
	public static function getUserCredit($id)
    {
    	$credit = Credit::find()->where(['user_id' => $id])->asArray()->all(); //var_dump($credit);
    	if($credit)
			return $credit;
		return false;
	}
	
	public static function getUnitPrice($price_id)
    {
    	$credit = Price::find()->where(['id' => $price_id])->one();
    	if($credit)
			return $credit->price;
		return false;
	}
	
	public static function getPriceList() {
		$price_list = array();
		$price = Price::find()->all();
		if($price) {
			foreach($price as $p) {				
				$price_list[$p->type][] = array('price_id' => $p->id, 'amount' => $p->price);
			}		
		}
		return $price_list;
	}
	
}