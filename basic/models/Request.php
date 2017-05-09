<?php
 
namespace app\models;
 
use Yii;
 
class Request extends \yii\web\Request
{
    public $noCsrfRoutes = [];
     
    public function validateCsrfToken()
    {
    	//var_dump($this->noCsrfRoutes);
    	/*
        if(
            $this->enableCsrfValidation && 
            in_array(Yii::$app->getUrlManager()->parseRequest($this)[0], $this->noCsrfRoutes)
        ){
            return true;
        } */
    	if(in_array('http://helloworldng.com/speedysms/basic/web/blueimp-file-upload/server/php/', $this->noCsrfRoutes) || in_array('group/link', $this->noCsrfRoutes) || in_array('sms/send', $this->noCsrfRoutes)) {
    		return true;
    	}
        return parent::validateCsrfToken();
    }
}