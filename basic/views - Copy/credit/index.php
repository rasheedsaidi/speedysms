<?php

use app\models\Utility;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Sender;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Credits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="credit-index">

    <h1><?= Html::encode($this->title) ?></h1>
<?php 
//$obj = new Sender ("121.241.242.114", "8080", "hel1-smsuser", "123@abc","HELLOWORLD", "Sample message","2348153505442", "0", "1");
//$obj = new Sender ("smsplus2.routesms.com", "2349", "helloworld", "m3v5y7e4","HELLOWORLD", "Sample message","2348153505442", "0", "1");
//$obj->Submit();
//var_dump($obj->Submit());
?>
    <p>
        <?= Html::a('Create Credit', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

    		'user_id',
            'amount',
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
