<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Groups';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Add Contacts', 'url' => ['contact/create']];
?>
<div class="group-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Group', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            ['class' => 'yii\grid\ActionColumn'],
            [
			    'attribute' => 'Actions',
			    'format' => 'raw',
			    'value' => function ($model) {                      
			            return Html::a('Manage Group', ['group/manage', 'id' => $model->id], ['class' => 'btn btn-success']);
			    },
			],
        ],
    ]); ?>
    

</div>
