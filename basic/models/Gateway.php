<?php
namespace app\models;

use yii\widgets\ActiveForm;

use yii\helpers\Url;
use yii\base\Model;

use Yii;
use amnah\yii2\user\models\User;

class Gateway extends Model
{
	const PRODUCT_ID = "6205";	 
	
public static function query($trans_id) {
        //$amt = $amount;
        $admin = 0;
        $date = date('Y-m-d H:i:s');
        $url = 'https://voguepay.com/?v_transaction_id=' . $trans_id . '&type=json&demo=true';
		
        
		$curl = curl_init();		
		curl_setopt_array($curl, array(		
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_SSL_VERIFYPEER => 'TRUE',		
			CURLOPT_URL => $url		
		));
		
		$resp = curl_exec($curl); //var_dump($resp);e
		curl_close($curl);	
		
        //$resp = file_get_contents($url);
		$data = json_decode($resp, true);
		return $data;
	}
	
	public static function updateVoguepay($data) {
		$transaction = new Voguepay();
		$transaction->transaction_id = $data['transaction_id'];
		$transaction->email = $data['email'];
		$transaction->total = $data['total'];
		$transaction->memo = $data['memo'];
		$transaction->status = $data['status'];
		$transaction->referrer = $data['referrer'];
		$transaction->date = $data['date'];
		$transaction->method = $data['method'];
		$transaction->save(false);
	}
	
	public static function requery($amount, $trans_id) {
        $amt = $amount;
        $admin = 0;
        $date = date('Y-m-d H:i:s');
        $type = 'Interswitch';
        
		// Get cURL resource
		$product_id = self::PRODUCT_ID;	//"5545"; //"4790";
		$mackey = "D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B59E897FA930DA44F9230910DAC9E20641823799A107A02068F7BC0F4CC41D2952E249552255710F";

		$hashdata  = $product_id.$trans_id.$mackey;
		$newhash = hash("SHA512",$hashdata,false);

		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_HTTPHEADER => array("Hash:$newhash"),
		    //CURLOPT_URL => "https://webpay.interswitchng.com/paydirect/api/v1/gettransaction.json?productid=$product_id&transactionreference=$ref&amount=$amt",
			CURLOPT_URL => "https://stageserv.interswitchng.com/test_paydirect/api/v1/gettransaction.json?productid=$product_id&transactionreference=$trans_id&amount=$amt",
			CURLOPT_SSL_VERIFYPEER => 'TRUE',
			CURLOPT_CAINFO => 'zerious/ncacert.pem'
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		// Close request to clear up some resources
		$data = json_decode($resp); //var_dump($resp);

		curl_close($curl);

        $arr = array();
		$arr[0] = $data->ResponseCode;
		$arr[1]= $data->Amount;
		$arr[2]=$data->ResponseDescription;		
		$arr[3]= "https://webpay.interswitchng.com/paydirect/api/v1/gettransaction.json?productid=5545&transactionreference=$ref&amount=$amt";
		//$arr[3]= "https://stageserv.interswitchng.com/test_paydirect/api/v1/gettransaction.json?productid=$product_id&transactionreference=$ref&amount=$amt";	
			
		return $arr;
	}
	public static function requery1($amount, $trans_id) { 
		$subpdtid = self::PRODUCT_ID;
        $submittedamt = $amount; // same amount sent in 2.3 
        $submittedref = $trans_id; // ref from isw 
        
        $nhash = 
"D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B59E897FA930DA44F9230910DAC9E20641823799A107A02068F7BC0F4CC41D2952E249552255710F" ; // the mac key sent to you, same value used in 2.3 
  		$hashv = $subpdtid.$submittedref.$nhash;  // concatenate the strings for hash this time different parameters 
  		$thash = hash('sha512',$hashv); 
   
   		$valuesforurl = array( 
	        "productid"=>$subpdtid, 
	        "transactionreference"=>$submittedref, 
	        "amount"=>$submittedamt 
	    );  
  		$outvalue = http_build_query($valuesforurl) . "\n";
  		
		//$url = "http://stageserv.interswitchng.com/test_paydirect/api/v1/gettransaction.xml?$outvalue ";// xml 
    	$url = "http://stageserv.interswitchng.com/test_paydirect/api/v1/gettransaction.json?$outvalue "; // json 
     
    	//note the variables appended to the url as get values for these parameters 
    	$headers = array(
		    "GET /HTTP/1.1", 
		    "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 
		Firefox/3.0.1", 
		      
		    "Accept-Language: en-us,en;q=0.5", 
		    "Keep-Alive: 300",       
		    "Connection: keep-alive", 
		    "Hash: $thash " 
    	); // computed hash now added to header of my request 
    	
	    $ch = curl_init();  // initiate the request 
	    curl_setopt($ch, CURLOPT_URL,$url); 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	    curl_setopt($ch, CURLOPT_TIMEOUT, 60);  
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  
		curl_setopt( $ch, CURLOPT_POST, false ); 
		// dont use this on production enviroment 
		//curl_setopt($ch, CURLOPT_USERAGENT, $defined_vars['HTTP_USER_AGENT']);  
     
 		$data = curl_exec($ch);  
		if (curl_errno($ch)) {  
		  print "Error: " . curl_error($ch); 
		} else {   
			// Show me the result 
			//  $json = simplexml_load_string($data); 
			$json = json_decode($data, TRUE); 
			curl_close($ch); 
		 	//print_r($json); 
		  	// loop through the array nicely for your UI 
		}
		return $json;
	}
	
}