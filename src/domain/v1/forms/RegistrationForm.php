<?php

namespace yii2module\account\domain\v1\forms;

use Yii;
use yii2module\account\domain\v1\validators\LoginValidator;

class RegistrationForm extends RestorePasswordForm {
	
	public $login;
	public $activation_code;
	public $password;
	public $email;
	
	const SCENARIO_REQUEST = 'request';
	const SCENARIO_CHECK = 'check';
	const SCENARIO_CONFIRM = 'confirm';
	
	public function rules() {
		return [
			[['login', 'password', 'activation_code', 'email'], 'trim'],
			[['login', 'password', 'activation_code'], 'required'],
			//['login', LoginValidator::class],
			['email', 'email'],
			[['activation_code'], 'integer'],
			[['activation_code'], 'string', 'length' => 6],
			[['password'], 'string', 'min' => 4],
		];
	}
	
	public function scenarios() {
		return [
			self::SCENARIO_REQUEST => ['login', 'email'],
			self::SCENARIO_CHECK => ['login', 'activation_code'],
			self::SCENARIO_CONFIRM => ['login', 'activation_code', 'password'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'login' 		=> Yii::t('account/main', 'login'),
			'email' 		=> Yii::t('account/main', 'email'),
			'activation_code' 		=> Yii::t('account/main', 'activation_code'),
		];
	}
	
}
