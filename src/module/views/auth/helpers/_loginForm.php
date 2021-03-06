<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \yii2module\account\module\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii2module\account\domain\v2\forms\LoginForm;

?>

<br/>

<p class="login-box-msg"><?= Yii::t('account/auth', 'login_text') ?></p>

<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'login') ?>

	<?= $form->field($model, 'password')->passwordInput() ?>

    <?php if($model->scenario == LoginForm::SCENARIO_OTP) {
        echo $form->field($model, 'otp');
    } ?>

    <?=$form->field($model, 'rememberMe', [
		'checkboxTemplate'=>'<div class="checkbox">{beginLabel}{input}{labelTitle}{endLabel}{error}{hint}</div>',
	])->checkbox();?>
	
	<div class="form-group">
		<?=Html::submitButton(Yii::t('account/auth', 'login_action'), ['class' => 'btn btn-primary btn-flat', 'name' => 'login-button']) ?>
	</div>
	
<?php ActiveForm::end(); ?>