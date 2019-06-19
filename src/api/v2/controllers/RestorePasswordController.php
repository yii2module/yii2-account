<?php

namespace yii2module\account\api\v2\controllers;

use Yii;
use yii2lab\rest\domain\rest\Controller;

class RestorePasswordController extends Controller
{
	public $service = 'account.restorePassword';
	
	/**
	 * @inheritdoc
	 */
	protected function verbs()
	{
		return [
			'request' => ['POST'],
			'check-code' => ['POST'],
			'confirm' => ['POST'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'check-code' => [
				'class' => 'yii2lab\domain\rest\UniAction',
				'successStatusCode' => 204,
				'serviceMethod' => 'checkActivationCode',
				'serviceMethodParams' => ['login', 'activation_code', 'password'],
			],
			'confirm' => [
				'class' => 'yii2lab\domain\rest\UniAction',
				'successStatusCode' => 204,
				'serviceMethod' => 'confirm',
				'serviceMethodParams' => ['login', 'activation_code', 'password'],
			],
		];
	}

	public function actionRequest() {
		$body = Yii::$app->request->getBodyParams();
		$entity = \App::$domain->account->restorePassword->request($body);
		return $entity;
	}

}