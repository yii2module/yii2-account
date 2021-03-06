<?php

namespace yii2module\account\domain\v2\forms;

use Yii;
use yii2lab\domain\base\Model;
use yii2module\lang\domain\helpers\LangHelper;

class LoginForm extends Model
{
	
	const SCENARIO_SIMPLE = 'SCENARIO_SIMPLE';
	const SCENARIO_OTP = 'SCENARIO_OTP';
	
	public $login;
	public $password;
	public $email;
	public $role;
	public $status;
	public $token_type;
	public $rememberMe = true;
	public $otp;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['login', 'password', 'token_type'], 'trim'],
			[['login', 'password'], 'required'],
			[['otp'], 'required', 'on' => self::SCENARIO_OTP ],
			['email', 'email'],
			//['login', 'match', 'pattern' => '/^[0-9_]{11,13}$/i', 'message' => Yii::t('account/registration', 'login_not_valid')],
			//['login', LoginValidator::class],
			'normalizeLogin' => ['login', 'normalizeLogin'],
			[['password'], 'string', 'min' => 8],
			['rememberMe', 'boolean'],
		    [['status'], 'safe'],
		];
	}
	
	public function scenarios() {
		return [
			self::SCENARIO_DEFAULT => [
				'login',
				'password',
				'email',
				'role',
				'status',
				'rememberMe',
				'token_type',
				'otp',
			],
			self::SCENARIO_SIMPLE => [
				'login',
				'password',
				'token_type',
			],
			self::SCENARIO_OTP => [
				'login',
				'password',
				'token_type',
				'otp',
			],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'login' 		=> Yii::t('account/main', 'login'),
			'password' 		=> Yii::t('account/main', 'password'),
			'otp' 		    => Yii::t('account/main', 'otp'),
			'rememberMe' 		=> Yii::t('account/auth', 'remember_me'),
		];
	}

	public function normalizeLogin($attribute)
	{
		//$this->$attribute = LoginHelper::pregMatchLogin($this->$attribute);
		$isValid = \App::$domain->account->login->isValidLogin($this->$attribute);
		if($isValid) {
			$this->$attribute = \App::$domain->account->login->normalizeLogin($this->$attribute);
		} else {
			return;
		}
	}
	
}
