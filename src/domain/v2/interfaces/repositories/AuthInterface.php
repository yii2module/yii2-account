<?php

namespace yii2module\account\domain\v2\interfaces\repositories;

use yii2module\account\domain\v2\entities\LoginEntity;

interface AuthInterface {
	
	/**
	 * @param $login
	 * @param $password
	 *
	 * @return LoginEntity
	 */
	public function authentication($login, $password);
	public function setToken($token);

}