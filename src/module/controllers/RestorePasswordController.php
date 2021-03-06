<?php
namespace yii2module\account\module\controllers;

use yii2lab\extension\web\helpers\Behavior;
use yii2module\account\module\forms\RestorePasswordForm;
use yii2lab\domain\exceptions\UnprocessableEntityHttpException;
use Yii;
use yii\web\Controller;
use yii2lab\navigation\domain\widgets\Alert;

/**
 * PasswordController controller
 */
class RestorePasswordController extends Controller
{
	
	const SESSION_KEY = 'restore-password';

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => Behavior::access('?'),
		];
	}

	public function actionCheck() {
		$model = new RestorePasswordForm();
		$model->setScenario(RestorePasswordForm::SCENARIO_CHECK);
		$session = Yii::$app->session->get(self::SESSION_KEY);
		$model->login = $session['login'];
		if(Yii::$app->request->isPost) {
			$body = Yii::$app->request->post('RestorePasswordForm');
			$model->setAttributes($body, false);
			try {
				\App::$domain->account->restorePassword->checkActivationCode($model->login, $model->activation_code, $model->password);
				$session['activation_code'] = $model->activation_code;
				Yii::$app->session->set(self::SESSION_KEY, $session);
				return $this->redirect(['/user/restore-password/confirm']);
			} catch (UnprocessableEntityHttpException $e){
				$model->addErrorsFromException($e);
			}
		}
		return $this->render('check', ['model' => $model]);
	}
	
	public function actionConfirm()
	{
		$model = new RestorePasswordForm();
		$model->setScenario(RestorePasswordForm::SCENARIO_CONFIRM);
		$session = Yii::$app->session->get(self::SESSION_KEY);
		$model->login = $session['login'];
		$model->activation_code = $session['activation_code'];
		if(Yii::$app->request->isPost) {
			$body = Yii::$app->request->post('RestorePasswordForm');
			$model->setAttributes($body, false);
			try {
				\App::$domain->account->restorePassword->confirm($model->login, $model->activation_code, $model->password);
				\App::$domain->navigation->alert->create(['account/restore-password', 'new_password_saved_success'], Alert::TYPE_SUCCESS);
				return $this->redirect('/' . Yii::$app->user->loginUrl[0]);
			} catch (UnprocessableEntityHttpException $e){
				$model->addErrorsFromException($e);
			}
		}
		return $this->render('reset', [
			'model' => $model,
		]);
	}
	
}
