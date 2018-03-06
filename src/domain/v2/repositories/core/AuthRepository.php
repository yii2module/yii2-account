<?php

namespace yii2module\account\domain\v2\repositories\core;

use Yii;
use yii\helpers\ArrayHelper;
use yii2lab\domain\repositories\CoreRepository;
use yii2lab\extension\registry\helpers\Registry;
use yii2module\account\domain\v2\entities\LoginEntity;
use yii2module\account\domain\v2\helpers\LoginEntityFactory;
use yii2module\account\domain\v2\interfaces\repositories\AuthInterface;

class AuthRepository extends CoreRepository implements AuthInterface {
	
	public $baseUri = 'auth';
	public $version = 'v4';
	
	public function authentication($login, $password) {
		$response = $this->post(null, compact('login', 'password'));
		return $this->forgeEntity($response->data, LoginEntity::class);
	}
	
	public function pseudoAuthenticationWithParrent($login, $ip, $email = null, $parentLogin) {
		$response = $this->post(null, compact('login','ip','email', 'parentLogin'));
		return $this->forgeEntity($response->data);
	}

	public function setToken($token) {
		if (Yii::$app->user->enableSession) {
			Yii::$app->session['token'] = $token;
		}
		Registry::set('authToken', $token);
	}
	
	protected function forgeLoginEntity($user, $class = null)
	{
		if(empty($user)) {
			return null;
		}
		$user = ArrayHelper::toArray($user);
		$user = $this->alias->decode($user);
		return LoginEntityFactory::forgeLoginEntity($user);
	}
}