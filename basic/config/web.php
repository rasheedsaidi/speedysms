<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'yeruyfhd74345yhrfew7r9oerfdd',
			//'class' => 'app\models\Request',
		    //'noCsrfRoutes' => [
		    //    'http://helloworldng.com/speedysms/basic/web/blueimp-file-upload/server/php/',
			//	'group/link','sms/send',
		    //]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'amnah\yii2\user\components\User',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
        	'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'seven.qservers.net',
                //'host' => 'one.qservers.net',
                'username' => 'sales@speedysms.com.ng',
                'password' => '1qaz2wsx',
                'port' => '465',
        		'encryption' => 'ssl',
            ],
            'messageConfig' => [
                'from' => ['sales@helloworldng.com' => 'SpeedySMS Admin Team'], // this is needed for sending emails
                'charset' => 'UTF-8',
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'view' => [
	        'theme' => [
	            'pathMap' => [
					'@vendor/amnah/yii2-user/views' => '@app/views',
	            ],
	        ],
	    ],
    ],
    'params' => $params,
    'modules' => [
        'user' => [
            'class' => 'amnah\yii2\user\Module',
            // set custom module properties here ...
        
        'controllerMap' => [
	            'default' => 'app\controllers\DefaultController',
    			//'admin' => 'app\controllers\AdminController',
	        ],
	        'modelClasses'  => [
	            //'User' => 'app\models\MyUser', // note: don't forget user::identityClass above amnah\yii2\user\models\User
	            //'Profile' => 'app\models\MyProfile',
	            //'Role' => 'app\models\InRole',
	        ],
	        
	    ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
