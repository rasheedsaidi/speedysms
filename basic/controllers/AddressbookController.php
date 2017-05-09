<?php

namespace app\controllers;

use yii\filters\VerbFilter;

use yii\filters\AccessControl;

class AddressbookController extends \yii\web\Controller
{
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'confirm', 'resend', 'success'],
                        'allow'   => true,
                        'roles'   => ['?', '@'],
                    ],
                    [
                        //'actions' => ['account', 'profile', 'resend-change', 'cancel', 'logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                    [
                        'actions' => ['login', 'register', 'forgot', 'reset', 'success', 'confirm'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
            		'rating' => ['post', 'get'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }

}
