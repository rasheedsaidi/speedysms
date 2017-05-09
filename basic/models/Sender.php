<?php
namespace app\models;

use Yii;
use linslin\yii2\curl;

class Sender{
public $host;
var $port;
/*
* Username that is to be used for submission
*/
var $strUserName;
/*
* password that is to be used along with username
*/
var $strPassword;
/*
* Sender Id to be used for submitting the message
*/
var $strSender;
/*
* Message content that is to be transmitted
*/
var $strMessage;
/*
* Mobile No is to be transmitted.
*/
var $strMobile;
/*
* What type of the message that is to be sent
* <ul>
* <li>0:means plain text</li>
* <li>1:means flash</li>
* <li>2:means Unicode (Message content should be in Hex)</li>
* <li>6:means Unicode Flash (Message content should be in Hex)</li>
* </ul>
*/
var $strMessageType;
/*
* Require DLR or not
* <ul>
* <li>0:means DLR is not Required</li>
* <li>1:means DLR is Required</li>
* </ul>
*/
var $strDlr;
private function sms__unicode($message){
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
//Constructor..
public function __construct($host,$port,$username,$password,$sender, $message,$mobile,
$msgtype,$dlr){
$this->host=$host;
$this->port=$port;
$this->strUserName = $username;
$this->strPassword = $password;
$sender = urlencode($sender);
$this->strSender= (is_numeric($sender))? substr($sender, 0, 18): substr($sender, 0, 11);
$this->strMessage=$message; //URL Encode The Message..
$this->strMobile=$mobile;
$this->strMessageType=$msgtype;
$this->strDlr=$dlr;
}
public function Submit(){
if($this->strMessageType=="2" ||
$this->strMessageType=="6") {
//Call The Function Of String To HEX.
$this->strMessage = $this->sms__unicode(
$this->strMessage);
try{
//Smpp http Url to send sms. 
$live_url="http://".$this->host."/bulksms/bulksms?username=".$this->strUserName."&password=".$this->strPassword."&type=".$this->strMessageType."&dlr=".$this->strDlr."&destination=".$this->strMobile."&source=".$this->strSender."&message=".$this->strMessage."";
$parse_url=file($live_url);
echo $live_url; $parse_url[0];
}catch(Exception $e){
echo 'Message:' .$e->getMessage();
}
}
else {
$this->strMessage=urlencode($this->strMessage);
try{
//Smpp http Url to send sms. ":".$this->port.
$live_url="http://".$this->host."/bulksms/bulksms?username=".$this->strUserName."&password=".$this->strPassword."&type=".$this->strMessageType."&dlr=".$this->strDlr."&destination=".$this->strMobile."&source=".$this->strSender."&message=".$this->strMessage."";
//echo $live_url;exit;
try { 
/*
	$curl = new curl\Curl();

        //post http://example.com/
        $response = $curl->setOption(CURLOPT_RETURNTRANSFER, 1)
        ->setOption(CURLOPT_RETURNTRANSFER, 1)
        ->setOption(CURLOPT_SSLVERSION, 3)
        ->setOption(CURLOPT_SSL_VERIFYPEER, 0)
        ->setOption(CURLOPT_SSL_VERIFYHOST, 2)
		->post($live_url);
		*/

	
    		$curl = curl_init();
		
		
		curl_setopt_array($curl, array(
		
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_SSLVERSION => 3,
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_SSL_VERIFYHOST => 2,
		
		CURLOPT_URL => $live_url 
		
		));
		
		$resp = curl_exec($curl); //var_dump($resp); //var_dump(curl_error($curl));
		curl_close($curl);
	    return $resp;
    	} catch (Exception $e) {
    		return null;
    	}
//echo $parse_url[0];
}
catch(Exception $e){
echo 'Message:' .$e->getMessage();
}
}
}
}
//Call The Constructor.
//$obj = new Sender ("121.241.242.114", "8080", "hel1-smsuser", "123@abc","HELLOWORLD", "Sample message","2348060553348", "0", "1");
//Sender("IP","Port","","","Tester"," "???????","m3v5y7e4 h7g4a1c3 919990001245,"0","1"); smsplus2.routesms.com 121.241.242.114
//$obj->Submit();
?> 