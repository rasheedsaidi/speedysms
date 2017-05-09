<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property string $sender_id
 * @property integer $type
 * @property string $body
 * @property integer $length
 *
 * @property MessageLog[] $messageLogs
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'length', 'user_id'], 'integer'],
            [['body'], 'string'],
            [['type', 'length', 'body'], 'required'],
            [['created_at', 'mode', 'recipient', 'credit', 'sender_id', 'personalised', 'scheduled'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'SMS Type',
            'body' => 'The Message',
            'length' => 'SMS Length',
        	'user_id' => 'User ID',
        	'recipient' => 'Recipient',
        	'created_at' => 'Time of Composition',
        	'personalised' => 'Personalize this SMS',
        	'scheduled' => 'Schedule SMS'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageLogs()
    {
        return $this->hasMany(MessageLog::className(), ['message_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return MessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MessageQuery(get_called_class());
    }

    public static function sendSingle($profile) { var_dump(getCredit());exit;
    	$sms_log = new MessageLog();
    	$sms_log->mobile_no = $this->recipient;
        $sms_log->message_id = $this->id;
        $sms_log->sent_at = date('Y-m-d H:i:s');
        $sms_log->country = 'Nigeria';
        $sms_log->user_id = Yii::$app->user->id;
        $sms_log->status = "PENDING";
        $sending_profile = $_POST['sending_profile'];
        $sms_log->credit_used = (float) Utility::getCurrentPrice($profile, $this->length, Yii::$app->user->id, 1);
               	
    	$responses = Utility::sendSMS($sms_detail['sender'], $sms_detail['body'], $sms_detail['mobile'], $type, $sms_detail['profile']);
        	
		if($responses) {
			Utility::deductCredit($profile, $this->credit);
	        $sms_log->sender_id = $sms_detail['sender'];
			$sms_log->sms_return_id = isset($responses[2])? $responses[2]: null;
			$sms_log->status = isset($responses[0])? $responses[0]: "PENDING";
			$sms_log->save();
			return true;
		}
		return false;        
    }
    
    function getCredit() {
    	return $this->credit;
    }
    
function sms__unicode($message){
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
	
}
