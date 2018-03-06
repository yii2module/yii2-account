<?php

namespace yii2module\account\domain\v2\filters\auth;

use Yii;
use yii\filters\auth\AuthMethod;
use yii\web\Response;

/**
 * Class HttpAuth
 *
 * @package yii2module\account\domain\v2\filters\auth
 *
 * @deprecated use yii2module\account\domain\v2\filters\auth\HttpTokenAuth
 */
class HttpAuth extends AuthMethod
{
	/**
	 * @var string the HTTP authentication realm
	 */
	public $realm = 'api';


	/**
	 * @inheritdoc
	 */
	public function authenticate($user, $request, $response)
	{
		$authHeader = Yii::$app->account->auth->getToken();
		if ($authHeader !== null) {
			$identity = $user->loginByAccessToken($authHeader, get_class($this));
			if ($identity === null) {
				$this->handleFailure($response);
			}
			return $identity;
		}

		return null;
	}

	/**
	 * @inheritdoc
	 */
	public function challenge($response)
	{
		/** @var Response $response */
		$response->getHeaders()->set('WWW-Authenticate', "Bearer realm=\"{$this->realm}\"");
	}
}