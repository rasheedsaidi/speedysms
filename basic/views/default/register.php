<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="main">
                    <div class="row">
                        <div class="col-sm-5 login-form">
                            <div class="panel panel-default">
                                <div class="panel-intro text-center">
                                    <h1 class="logo"><i class="fa fa-user"></i> <?= Html::encode($this->title) ?></h1>
                                </div>
                                <div class="panel-body">
<?php 
if (!empty($user->errors)) {
	echo '<div class="alert alert-error"><ul>';
	foreach($user->errors as $errors) {
		foreach($errors as $error) {
			echo '<li>' . $error . '</li>';
		}	
	}
	echo '</ul></div>';
}
// 'class' => 'form-horizontal', 
?>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        //'options' => [],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
        
    ]); ?>
    <div class="form-group">
                                            <input type="text" name="Profile[full_name]" value="<?php echo (isset($_REQUEST['Profile']))? $_REQUEST['Profile']['full_name']: ''; ?>" placeholder="Enter full name" class="form-control input-lg">
                                        </div>
<div class="form-group">
                                            <input type="text" name="User[email]" value="<?php echo (isset($_REQUEST['User']))? $_REQUEST['User']['email']: ''; ?>" placeholder="Email address" class="form-control input-lg">
                                        </div>                                        
<div class="form-group">
                                            <input type="text" name="User[username]" value="<?php echo (isset($_REQUEST['User']))? $_REQUEST['User']['username']: ''; ?>" placeholder="Username or phone number" class="form-control input-lg">
                                        </div>
    <?php //= $form->field($model, 'username')->label(false) ?>
<div class="form-group">
                                            <input type="password" name="User[newPassword]" placeholder="Password" class="form-control input-lg">
                                        </div>
    <?php //= $form->field($model, 'password')->passwordInput()->label(false) ?>

    <?php // = $form->field($model, 'rememberMe', [
       // 'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
   // ])->checkbox() ?>

    <div class="form-group">
        <div class="col-sm-12">
            <?= Html::submitButton('Register', ['class' => 'btn btn-block btn-custom', 'name' => 'login-button']) ?>
        </div>
    </div>
    <p class="text-center form-group" style="margin-top: 1.2em;">Don't have an account? <strong><?= Html::a("Create an account", ["/user/register"]) ?></strong></p>

    <?php ActiveForm::end(); ?>

</div></div></div></div></section>
