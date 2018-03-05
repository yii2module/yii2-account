<?php

namespace yii2module\account\api\v1\controllers;

use yii2lab\domain\rest\ActiveController as Controller;

class UserController extends Controller
{

	public $serviceName = 'account.login';

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'create' => [
				'class' => 'yii2lab\domain\rest\CreateAction',
			],
			'view' => [
				'class' => 'yii2lab\domain\rest\ViewActionWithQuery',
			],
		];
	}

}