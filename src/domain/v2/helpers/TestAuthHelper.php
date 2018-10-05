<?php

namespace yii2module\account\domain\v2\helpers;

use Yii;
use yii2lab\domain\helpers\DomainHelper;
use yii2lab\helpers\ClientHelper;
use yii2module\account\domain\v2\entities\LoginEntity;

class TestAuthHelper {
	
	const ADMIN_PASSWORD = 'Wwwqqq111';
	const DOMAIN_CLASS = \yii2module\account\domain\v2\Domain::class;
	
	public static function authByLogin($login, $password = self::ADMIN_PASSWORD) {
		self::defineAccountDomain();
		$userEntity = \App::$domain->account->auth->authentication($login, $password);
		Yii::$app->user->setIdentity($userEntity);
	}
	
	public static function authById($id) {
		self::defineAccountDomain();
		/** @var LoginEntity $userEntity */
		$userEntity = \App::$domain->account->login->oneById($id);
		Yii::$app->user->setIdentity($userEntity);
	}
	
	public static function authPseudo($login, $email = '', $parentLogin = '') {
		$userEntity = \App::$domain->account->authPseudo->authentication($login, $address = ClientHelper::ip(), $email, $parentLogin);
		Yii::$app->user->setIdentity($userEntity);
	}
	public static function defineAccountDomain() {
		DomainHelper::defineDomain('account', self::DOMAIN_CLASS);
	}
	
}
