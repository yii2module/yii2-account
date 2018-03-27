<?php

namespace yii2module\account\domain\v2\repositories\core;

use Yii;
use yii\helpers\ArrayHelper;
use yii2lab\core\domain\repositories\base\BaseCoreRepository;
use yii2module\account\domain\v2\entities\LoginEntity;
use yii2module\account\domain\v2\helpers\LoginEntityFactory;
use yii2module\account\domain\v2\interfaces\repositories\AuthInterface;

class AuthRepository extends BaseCoreRepository implements AuthInterface {
	
	public $point = 'auth';
	public $version = 1;
	
	public function authentication($login, $password) {
		$response = $this->post(null, compact('login', 'password'));
		return $this->forgeEntity($response->data, LoginEntity::class);
	}
	
	public function pseudoAuthenticationWithParrent($login, $ip, $email = null, $parentLogin) {
		$response = $this->post(null, compact('login','ip','email', 'parentLogin'));
		return $this->forgeEntity($response->data);
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