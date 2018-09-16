<?php

/* @var $this yii\web\View */
/* @var $model \yii2module\account\module\forms\LoginForm */

use yii\helpers\Html;
use yii2lab\app\domain\helpers\EnvService;

$this->title = Yii::t('account/auth', 'login_title');
//\App::$domain->navigation->breadcrumbs->create($this->title);

$loginForm = $this->render('helpers/_loginForm.php', [
	'model' => $model,
])

?>

<?php if(APP == BACKEND) { ?>

	<div class="login-box">
		<div class="login-logo">
			<?= Html::encode($this->title) ?>
		</div>
		<div class="login-box-body">
			<?= $loginForm ?>
			<?= Html::a(Yii::t('main', 'go_to_frontend'), EnvService::getUrl(FRONTEND)) ?>
		</div>
	</div>

<?php } else { ?>

	<div class="user-login">
		<h1>
			<?= Html::encode($this->title) ?>
		</h1>
		<div class="row">
			<div class="col-lg-5">
				<?= $loginForm ?>
				<?= Html::a(Yii::t('account/auth', 'register_new_user'), ['/user/registration']) ?>
				<br/>
				<?= Html::a(Yii::t('account/auth', 'i_forgot_my_password'), ['/user/restore-password']) ?>
				
			</div>
		</div>
	</div>

<?php } ?>
