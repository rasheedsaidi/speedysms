<?php
use app\models\Group;
//var_dump($groups);
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Contact */
/* @var $form yii\widgets\ActiveForm */
$group = Group::find()->asArray()->all();
        $groups = array();
        foreach ($group as $value) {
        	$groups[$value['id']] = $value['name'];
        }
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'group_id')->label('Select Group from list')->dropdownList($groups) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number')->textInput() ?>

    <?= $form->field($model, 'created_at')->hiddenInput(['value'=>date('Y-m-d H:i:s')])->label(false) ?>
    
    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>(Yii::$app->user->isGuest)? 0: Yii::$app->user->id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
