<?php

namespace yii2module\account\domain\v2\repositories\core;

use yii\web\NotFoundHttpException;
use yii2lab\core\domain\repositories\base\BaseActiveCoreRepository;
use yii2lab\misc\enums\HttpHeaderEnum;
use yii2lab\rest\domain\helpers\RestHelper;
use yii2module\account\domain\v2\interfaces\repositories\LoginInterface;

class LoginRepository extends BaseActiveCoreRepository implements LoginInterface {
	
	public $point = 'user';
	public $version = 1;
	
	public function isExistsByLogin($login) {
		try {
			$this->oneByLogin($login);
			return true;
		} catch(NotFoundHttpException $e) {
			return false;
		}
	}
	
	public function oneByLogin($login) {
		$response = $this->get($login);
		return $this->forgeEntity($response->data);
	}
	
	public function oneByToken($token, $type = null) {
		//$response = $this->get('\auth', [], [HttpHeaderEnum::AUTHORIZATION => $token]);
		$url = env('servers.core.domain') . 'v' . $this->version . SL . 'auth';
		$response = RestHelper::get($url, [], [HttpHeaderEnum::AUTHORIZATION => $token]);
		return $this->forgeEntity($response->data);
	}
	
}